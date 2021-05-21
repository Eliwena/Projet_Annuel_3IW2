<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\View;
use App\Form\User\LoginForm;
use App\Models\User as UserModel;
use App\Services\Http\Cookie;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\User\Security;

class SecurityController extends AbstractController {

    public function loginAction() {

        if(Security::isConnected()) {
            Message::create('Attention', 'Vous etez déjà connectée', 'error');
            $this->redirect(Framework::getUrl());
        }

        $form = new LoginForm();

        if(!empty($_POST)){

            $errors = [];//FormValidator::check($form->getInputs(), $_POST);

            if(empty($errors)) {

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
                }
            } else {
                //liste les erreur et les mets dans la session message.error
                foreach ($errors as $error) {
                    Message::create('Erreur', $error, 'error');
                }
            }
        } else {
            $this->render("login", [
                'form' => $form,
            ]);
        }



    }


}
