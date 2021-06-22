<?php

namespace App\Form\User;

use App\Core\Framework;
use App\Form\Form;

class RegisterForm extends Form {

    protected $form = [];
    protected $inputs = [];

    public function __construct()
    {
        parent::__construct();
        $this->setForm();
        $this->setInputs();
    }

    public function setForm($options = []) {

        $this->form = [
            "method"=>"POST",
            "action"=> Framework::getCurrentPath(),
            "class"=>"form_control",
            "id"=>"form_register",
            "submit"=>"S'inscrire"
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [

            "firstname" => [
                "type"        => "text",
                "placeholder" => "Exemple : Yves",
                "label"       => "Prénom : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 2,
                "maxLength"   => 50,
                "error"       => "Votre prénom doit faire entre 2 et 50 caractères"
            ],

            "lastname" => [
                "type"        => "text",
                "placeholder" => "Exemple : Skrzypczyk",
                "label"       => "Nom : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 2,
                "maxLength"   => 100,
                "error"       => "Votre nom doit faire entre 2 et 100 caractères"
            ],

            "email" => [
                "type"        => "email",
                "placeholder" => "Exemple : nom@gmail.com",
                "label"       => "E-mail : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 8,
                "maxLength"   => 320,
                "error"       => "Votre email doit faire entre 8 et 320 caractères"
            ],

            "pwd" => [
                "type"       => "password",
                "label"      => "Mot de passe : ",
                "required"   => true,
                "class"      => "form_input",
                "minLength"  => 8,
                "error"      => "Votre mot de passe doit faire au minimum 8 caractères"
            ],

            "pwdConfirm" => [
                "active"   => true,
                "type"     => "password",
                "label"    => "Confirmation : ",
                "required" => true,
                "class"    => "form_input",
                "confirm"  => "pwd",
                "error"    => "Votre mot de passe de confirmation ne correspond pas"
            ],

            /*"country" => [
                "type"        => "text",
                "placeholder" => "Exemple : fr",
                "label"       => "Votre Pays",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 2,
                "maxLength"   => 2,
                "error"       => "Votre pays doit faire 2 caractères"
            ],*/
        ];
        $this->inputs = array_replace_recursive($this->inputs, $options);
        return $this;
    }

    public function getInputs() {
        return $this->inputs;
    }


}

?>