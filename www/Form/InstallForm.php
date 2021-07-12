<?php

namespace App\Form;

use App\Core\Framework;

class InstallForm extends Form {

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
            "id"     => "form_setup",
            "submit" => "Envoi des données"
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [
            "db_driver" => [
                "id"          => "db_driver",
                'name'        => 'db_driver',
                "type"        => "tex",
                "placeholder" => "Exemple : nom@gmail.com",
                "label"       => "E-mail : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 8,
                "maxLength"   => 320,
                "errorLength" => "Votre email doit faire entre 8 et 320 caractères",
                "error"       => "une erreur est survenue"
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