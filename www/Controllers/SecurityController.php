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

class SecurityController extends AbstractController {

    public function loginAction() {

        $form = new LoginForm();

        if(!empty($_POST)){

            $errors = [];//FormValidator::check($form->getInputs(), $_POST);

            if(empty($errors)) {

                $user = new UserModel();
                $user->setEmail($_POST["email"]);
                $user->setPwd($_POST["pwd"]);

                $login = $user->find(['email' => $user->getEmail()], null, true);

                if($login && password_verify($user->getPwd(), $login['pwd'])) {

                    /* update login token */
                    $user = new UserModel();
                    $user->setId($login['id']);
                    $user->setToken(uniqid() . '-' . md5($user->getEmail()));
                    $user->save();

                    /* ----- create login cookie ------ */
                    Cookie::create('token', $user->getToken());
                    /* ----- */
                    $this->redirect(Framework::getUrl() . '/');
                    
                } else {
                    //Email existe pas
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
