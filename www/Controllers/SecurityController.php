<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\User\LoginForm;
use App\Form\User\RegisterForm;
use App\Models\User as UserModel;
use App\Services\Http\Cookie;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\Mailer\Mailer;
use App\Services\User\Security;

class SecurityController extends AbstractController {

    public function loginAction() {

        if(Security::isConnected()) {
            Message::create('Attention', 'Vous etez déjà connectée', 'error');
            $this->redirect(Framework::getUrl());
        }

        $form = new LoginForm();

        if(!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if($validator) {

                $user = new UserModel();
                $user->setEmail($_POST["email"]);
                $user->setPwd($_POST["pwd"]);

                $login    = $user->find(['email' => $user->getEmail()], null, true);
                $password = Security::passwordVerify($login['pwd'], $user->getPwd());

                if($login && $password) {
                    $user->setId($login['id']);
                    Security::createLoginToken($user);
                    $this->redirect(Framework::getUrl() . '/');
                } else {
                    //Email existe pas ou mdp incorrect
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de la connexion.', 'error');
                    $this->redirect(Framework::getUrl() . '/login');
                }
            } else {
                //liste les erreur et les mets dans la session message.error
                if(Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl() . '/login');
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
            $this->redirect(Framework::getUrl());
        }

        $form = new RegisterForm();
        $form->setForm(['submit' => 'test']);

        if(!empty($_POST)) {
            $user = new UserModel();

            $user->setEmail($_POST["email"]);
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPwd(Security::passwordHash($_POST["pwd"]));
            //$user->setCreateAt(date('Y-m-d H:i:s', 'now'));
            $user->setCountry('fr');
            $user->setRole(1);
            $user->setStatus(1);
            $user->setIsDeleted(1);

            //email exist ?
            $register = $user->find(['email' => $user->getEmail()], null, true);

            if($register == false) {
                $save = $user->save();
                if($save) {
                    //$mail = new Mailer();
                    //$mail->prepare($user->getEmail(), 'MESSAGE DE TEST', '<a style="color: cyan">TEST MESSAGE</a>');
                    //$mail->send();
                    $this->redirect(Framework::getUrl() . '/login');
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'inscription.', 'error');
                }
            } else {
                Message::create('Attention', 'L\'email utiliser existe déjà.', 'error');
                $this->redirect(Framework::getUrl() . '/register');
            }

        } else {
            $this->render("register", [
                "form" => $form,
            ]);
        }
    }

    public function logoutAction() {
        if(Security::isConnected()) {
            Cookie::destroy('token');
            $this->redirect(Framework::getUrl());
        } else {
            Message::create('Attention', 'vous n\etez pas co', 'warning');
            $this->redirect(Framework::getUrl());
        }
    }


    /*
        $user->setFirstname("Yves");
        $user->setLastname("SKRZYPCZYK");
        $user->setEmail("y.skrzypczyk@gmail.com");
        $user->setPwd("Test1234");
        $user->setCountry("fr");

        $user->save();



        $page = new Page();
        $page->setTitle("Nous contacter");
        $page->setSlug("/contact");
        $page->save();



        $user = new User();
        $user->setId(2); //Attention on doit populate
        $user->setFirstname("Toto");
        $user->save();

    */


    /****$user = new UserModel();
    $form = new RegisterForm();

    if(!empty($_POST)){

    $errors = FormValidator::check($form, $_POST);

    if(empty($errors)){

    $user = new UserModel();

    /*$user->setEmail('testa');
    $user->setFirstname('test');
    $user->setLastname('test');
    $user->setPwd('test');
    $user->setCountry('fr');

    $user->save();*/

    /****

    $user->setFirstname($_POST["firstname"]);
    $user->setLastname($_POST["lastname"]);
    $user->setEmail($_POST["email"]);
    $user->setPwd($_POST["pwd"]);
    $user->setCountry($_POST["country"]);

    $user->save();
    }else{
    die($errors);
    //$view->assign(["errors" => $errors]);
    }
    }

    $this->render("register", [
    "form" => $form,
    "formLogin" => $user->formBuilderLogin()
    ]);
    }
     */


}
