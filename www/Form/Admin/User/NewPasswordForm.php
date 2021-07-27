<?php

namespace App\Form\Admin\User;

use App\Core\Framework;
use App\Form\Form;

class NewPasswordForm extends Form {

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
            "id"     => "form_new_password",
            "submit" => "Modifier mon mot de passe"
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [
            "token" => [
                "id"         => 'token',
                "name"       => 'token',
                "type"       => "hidden",
                "value"      => isset($_GET['token']) ? $_GET['token'] : '',
                "required"   => true,
            ],

            "new_password" => [
                "id"         => 'password',
                "name"       => 'password',
                "type"       => "password",
                "label"      => "Nouveau mot de passe : ",
                "required"   => true,
                "class"      => "form_input",
                "minLength"  => 8,
                "error"      => "Votre mot de passe doit faire au minimum 8 caractères"
            ],

            "new_password_confirm" => [
                "id"         => 'password_confirm',
                "name"       => 'password_confirm',
                "active"     => true,
                "type"       => "password",
                "label"      => "Confirmation : ",
                "required"   => true,
                "class"      => "form_input",
                "error"      => "Votre mot de passe de confirmation ne correspond pas"
            ],
        ];
        $this->inputs = array_replace_recursive($this->inputs, $options);
        return $this;
    }

    public function getInputs() {
        return $this->inputs;
    }

}

?>