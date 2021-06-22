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
                'name'        => 'Email',
                "type"        => "email",
                "placeholder" => "Exemple : nom@gmail.com",
                "label"       => "E-mail : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 8,
                "maxLength"   => 320,
                "errorLength" => "Votre email doit faire entre 8 et 320 caractères",
                "error"       => "une erreur est survenue"
            ],

            "pwd"=>[
                "id"          => "pwd",
                'name'        => 'Mot de passe',
                "type"        => "password",
                "label"       => "Mot de passe : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 8,
                "errorLength" => "Votre mot de passe doit faire au minimum 8 caractères",
                "error"       => "une erreur est survenue"
            ]
        ];
        return $this;
    }

    public function getInputs() {
        return $this->inputs;
    }

}

?>