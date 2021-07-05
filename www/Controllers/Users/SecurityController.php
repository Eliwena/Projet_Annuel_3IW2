<?php

namespace App\Controller\Users;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\User\LoginForm;
use App\Form\Admin\User\RegisterForm;
use App\Models\Users\User;
use App\Services\Http\Cookie;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\User\OAuth;
use App\Services\User\Security;

class SecurityController extends AbstractController {

    public function loginOAuthAction() {

        $accepted_client = [
            'google',
            'facebook'
        ];

        if(isset($_GET['client']) and in_array($_GET['client'], $accepted_client)) {
            $_client = $_GET['client'];
            switch ($_client) {
                case $accepted_client[0]:
                    $oauth = new OAuth([
                        'clientId'                => '1023879957584-mmm7rhg67e9d6d7kkfrk6k1fatgv47gf.apps.googleusercontent.com',
                        'clientSecret'            => 'kpTY1smO4uRdJNPN0TqBfnLK',
                        'redirectUri'             => 'http://localhost/login/oauth?client=google',
                        'authorizationEndpoint'   => 'https://accounts.google.com/o/oauth2/v2/auth',
                        'accessTokenEndpoint'     => "https://oauth2.googleapis.com/token",
                        'userInfoEndpoint'        => 'https://openidconnect.googleapis.com/v1/userinfo',
                        'scope'                   => ['openid', 'email', 'profile'],
                    ]);
                    break;
                case $accepted_client[1]:
                    $oauth = new OAuth([
                        'clientId'                => '2986752281580944',
                        'clientSecret'            => 'bce922a7d869845c136b3010b914df46',
                        'redirectUri'             => 'http://localhost/login/oauth?client=facebook',
                        'authorizationEndpoint'   => 'https://www.facebook.com/v11.0/dialog/oauth',
                        'accessTokenEndpoint'     => "https://graph.facebook.com/v11.0/oauth/access_token",
                        'userInfoEndpoint'        => 'https://graph.facebook.com/me',
                        'scope'                   => ['email'],
                    ]);
                    break;
            }

            if(empty($_GET['code'])) {
                $this->redirect($oauth->getOAuth()->getAuthUrl());
            } else {
                $accessToken = $oauth->getOAuth()->getToken($_GET['code']);
                $resource = $oauth->getOAuth()->getResource(true);

                if(isset($resource['email'])) {
                    $user = new User();
                    $response = $user->find(['email' => $resource['email']]);
                } else {
                    $response = false;
                }

                //si utilisateur trouvé
                if ($response) {
                    if ($response->getClient() != $_client) {
                        Message::create('Erreur', 'L\'addresse email associé a votre compte est déjà utilisé par un autre systeme de connexion');
                        $this->redirect(Framework::getUrl('app_home'));
                    } else {
                        $user->setId($response->getId());
                        Security::createLoginToken($user);
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
            $user->setPassword(Security::passwordHash($_POST["password"]));
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
                    //todo send mail here
                    //$mail = new Mailer();
                    //$mail->prepare($user->getEmail(), 'MESSAGE DE TEST', '<a style="color: cyan">TEST MESSAGE</a>');
                    //$mail->send();
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
                $form->setInputs([ 'email' => [ 'value' => Session::load('oauth_data')['email'], 'disabled' => true]]);
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
