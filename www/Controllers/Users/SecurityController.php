<?php

namespace App\Controller\Users;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\View;
use App\Form\Admin\User\LoginForm;
use App\Form\Admin\User\RegisterForm;
use App\Models\Users\User;
use App\Repository\Users\UserRepository;
use App\Repository\WebsiteConfigurationRepository;
use App\Services\Http\Cookie;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\Mailer\Mailer;
use App\Services\User\OAuth;
use App\Services\User\Security;

class SecurityController extends AbstractController {

    public function loginOAuthAction() {

        if(!WebsiteConfigurationRepository::getOAuthEnabled()) {
            Message::create('Erreur', 'Connexion par réseau sociaux désactiver');
            $this->redirect(Framework::getUrl('app_login'));
        }

        $oauth = new OAuth();

        if(isset($_GET['client']) and in_array($_GET['client'], $oauth->getAcceptedClient())) {

            $_client = $_GET['client'];
            $accepted_client = $oauth->getAcceptedClient();

            switch ($_client) {
                case $accepted_client[0]:
                    $oauth->setOAuth($oauth->getGoogleParams());
                    break;
                case $accepted_client[1]:
                    $oauth->setOAuth($oauth->getFacebookParams());
                    break;
            }
            $oauth->prepare();

            if(empty($_GET['code'])) {
                $this->redirect($oauth->getOAuth()->getAuthUrl());
            } else {
                $accessToken = $oauth->getOAuth()->getToken($_GET['code']);
                $resource = $oauth->getOAuth()->getResource(true);

                if(isset($resource['email'])) {
                    $response = UserRepository::getUserByEmail($resource['email']);
                } else {
                    $response = false;
                }

                //si utilisateur trouvé
                if ($response) {
                    if ($response->getClient() != $_client) {
                        Message::create('Erreur', 'L\'addresse email associé a votre compte est déjà utilisé par un autre systeme de connexion');
                        $this->redirect(Framework::getUrl('app_home'));
                    } else {
                        Security::createLoginToken($response->getId());
                        $this->redirect(Framework::getUrl('app_home'));
                    }
                } else {
                    //compte non repertorié redirect to register page avec lemail pré entrée et bloqué
                    Session::create('oauth_data', array_merge($resource, ['_client' => $_client]));
                    $this->redirect(Framework::getUrl('app_register'));
                }
            }
        } else {
            Message::create('Erreur', 'Merci d\'utiliser le formulaire pour accéder à cette page');
            $this->redirect(Framework::getUrl('app_login'));
        }

    }

    public function loginAction() {

        if(Security::isConnected()) {
            Message::create('Attention', 'Vous etez déjà connectée', 'error');
            $this->redirect(Framework::getBaseUrl());
        }

        $form = new LoginForm();

        if(!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if($validator) {

                $user = new User();
                $user->setEmail($_POST["email"]);
                $user->setPassword($_POST["password"]);

                $login    = $user->find(['email' => $user->getEmail()], null, true);
                $password = Security::passwordVerify($login['password'], $user->getPassword());

                if($login && $password) {
                    $user->setId($login['id']);
                    $user->setIsDeleted($login['isDeleted']);
                    $user->setIsActive($login['isActive']);
                    Security::createLoginToken($user);
                    $this->redirect(Framework::getUrl('app_home'));
                } else {
                    //Email existe pas ou mdp incorrect
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de la connexion.', 'error');
                    $this->redirect(Framework::getUrl('app_login'));
                }
            } else {
                //liste les erreur et les mets dans la session message.error
                if(Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_login'));
            }
        } else {
            $this->render("login", [
                'form' => $form,
                'title' => 'Page de connexion'
            ]);
        }

    }

    public function registerAction() {

        if(Security::isConnected()) {
            Message::create('Attention', 'Vous etez déjà connectée', 'error');
            $this->redirect(Framework::getUrl('app_home'));
        }

        $form = new RegisterForm();
        $form->setForm(['submit' => 'Inscription']);

        if(!empty($_POST)) {
            $user = new User();

            //si oauth alors prendre l'email direct sinon email du formulaire
            $user->setEmail(Session::exist('oauth_data') ? Session::load('oauth_data')['email'] : $_POST["email"]);
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            if(isset($_POST['password'])) {
                $user->setPassword(Security::passwordHash($_POST["password"]));
            }
            $user->setCountry('fr');
            $user->setStatus( Session::exist('oauth_data') ? (Session::load('oauth_data')['email_verified'] ? 2 : 1) : 1);

            //si l'oauth dit que l'email est verifier alors passe le status en verifier directement
            if(Session::exist('oauth_data')) {
                $user->setClient(Session::load('oauth_data')['_client']);
                Session::destroy('oauth_data');
            }

            //email exist ?
            $register = $user->find(['email' => $user->getEmail()]);

            if($register == false) {
                $save = $user->save();
                if($save) {
                    $mail = new Mailer();
                    $mail->prepare($user->getEmail(), 'Welcome on ' . WebsiteConfigurationRepository::getSiteName(), $mail->view('email/register', ['content' => 'Bienvenue sur notre site internet']));
                    $mail->send();
                    $this->redirect(Framework::getUrl('app_login'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'inscription.', 'error');
                }
            } else {
                Message::create('Attention', 'L\'email utiliser existe déjà.', 'error');
                $this->redirect(Framework::getUrl('app_register'));
            }

        } else {
            if(Session::exist('oauth_data') && !empty(Session::load('oauth_data')['email'])) {
                $form->setInputs(
                    [
                        'email' => [ 'value' => Session::load('oauth_data')['email'], 'disabled' => true],
                        'password' => ['hidden' => true, 'required' => false],
                        'password_confirm' => ['hidden' => true, 'required' => false],
                    ]
                );
            }
            $this->render("register", [
                "form" => $form,
            ]);
        }
    }

    public function logoutAction() {
        if(Security::isConnected()) {
            Cookie::destroy('token');
            $this->redirect(Framework::getUrl('app_home'));
        } else {
            Message::create('Attention', 'vous n\etez pas connécté', 'warning');
            $this->redirect(Framework::getUrl('app_home'));
        }
    }

}
