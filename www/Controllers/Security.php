<?php

namespace App\Controller;

use App\Core\FormValidator;
use App\Core\View;
use App\Models\User as UserModel;

class Security {

    public function loginAction() {

        $user = new UserModel();
        $view = new View("login");

        $form = $user->formBuilderRegister();

        if(!empty($_POST)){

            $errors = FormValidator::check($form, $_POST);

            if(empty($errors)){
                $user->setEmail($_POST["email"]);
                $user->setPwd($_POST["pwd"]);
                $user->save();
            } else {
                $view->assign("errors", $errors);
            }
        }

        $view->assign("form", $form);
        $view->assign("formLogin", $user->formBuilderLogin());
    }


}
