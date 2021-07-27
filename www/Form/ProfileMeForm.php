<?php

namespace App\Form;

use App\Core\Framework;
use App\Form\Form;
use App\Services\Http\Session;

class ProfileMeForm extends Form {

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
            "method"    => "POST",
            "action"    => Framework::getCurrentPath(),
            "class"     => "form_control",
            "id"        => "form_profile_me",
            "submit"    => "Modifier"
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
                "id"          => 'firstname',
                "name"        => 'firstname',
                "type"        => "text",
                "label"       => "Prénom : ",
                "value"       => (Session::exist('form_email') ? Session::load('form_email') : ''),
                "class"       => "form_input",
                "minLength"   => 2,
                "maxLength"   => 50,
                "error"       => "Votre prénom doit faire entre 2 et 50 caractères"
            ],

            "lastname" => [
                "id"          => 'lastname',
                "name"        => 'lastname',
                "type"        => "text",
                "label"       => "Nom : ",
                "value"       => (Session::exist('form_lastname') ? Session::load('form_lastname') : ''),
                "class"       => "form_input",
                "minLength"   => 2,
                "maxLength"   => 100,
                "error"       => "Votre nom doit faire entre 2 et 100 caractères"
            ],

            'country' => [
                "id" => 'country',
                'name' => 'country',
                "type" => "select",
                "class" => "form_select",
                'label' => 'Choisir une langue',
            ],

            "password" => [
                "id"         => 'password',
                "name"       => 'password',
                "type"       => "password",
                "label"      => "Mot de passe : ",
                "class"      => "form_input",
                "minLength"  => 8,
                "error"      => "Votre mot de passe doit faire au minimum 8 caractères"
            ],

            "password_confirm" => [
                "id"         => 'password_confirm',
                "name"       => 'password_confirm',
                "active"     => true,
                "type"       => "password",
                "label"      => "Confirmation : ",
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