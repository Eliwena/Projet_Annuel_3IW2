<?php

namespace App\Form\User;

use App\Core\Framework;
use App\Form\Form;

class LoginForm extends Form {

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
            "method" => "POST",
            "action" => Framework::getCurrentPath(),
            "class"  => "form_control",
            "id"     => "form_register",
            "submit" => "Se connecter"
        ];
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [
            "email" => [
                "id"          => "email",
                "type"        => "email",
                "placeholder" => "Exemple : nom@gmail.com",
                "label"       => "Votre Email",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 8,
                "maxLength"   => 320,
                "error"       => "Votre email doit faire entre 8 et 320 caractères"
            ],

            "pwd"=>[
                "id"        => "password",
                "type"      => "password",
                "label"     => "Votre mot de passe",
                "required"  => true,
                "class"     => "form_input",
                "minLength" => 8,
                "error"     => "Votre mot de passe doit faire au minimum 8 caractères"
            ]
        ];
        return $this;
    }

    public function getInputs() {
        return $this->inputs;
    }

}

?>