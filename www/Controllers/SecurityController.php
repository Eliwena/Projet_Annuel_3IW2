<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\View;
use App\Form\User\LoginForm;
use App\Models\User as UserModel;

class SecurityController extends AbstractController {

    public function loginAction() {

        $user = new UserModel();
        $form = new LoginForm();

        if(!empty($_POST)){

            $errors = FormValidator::check($form->getInputs(), $_POST);

            if(empty($errors)){
                $user->setEmail($_POST["email"]);
                $user->setPwd($_POST["pwd"]);

                $login = $user->find([
                            'email' => $user->getEmail(),
                            'pwd'   => $user->getPwd(),
                ]);

                if($login != false) {
                    Helpers::debug($_POST);
                } else {
                    //erreur identifiant
                }
            } else {
                //erreur dans le formulaire
            }
        } else {
            $this->render("login", [
                'form' => $form,
            ]);
        }



    }


}
