<?php

namespace App\Form\Admin\Permission;

use App\Core\Framework;
use App\Form\Form;

class PermissionForm extends Form
{
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
            "id"     => "form_permission",
            "submit" => "Ajouter une permission"
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [
            "name" => [
                "id"          => "name",
                'name'        => 'name',
                "type"        => "text",
                "placeholder" => "Nom de la permission",
                "label"       => "Nom : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Un nom est requis",
                "error"       => "une erreur est survenue"
            ],
            'group' => [
                'id' => 'group',
                'name' => 'group',
                'type' => 'select',
                'default_option' => null,
                "label"       => "Groupe : ",
                "required"    => true,
                "class"       => "form_input",
                "error"       => "une erreur est survenue"
            ]
        ];


        $this->inputs = array_replace_recursive($this->inputs, $options);
        return $this;
    }

    public function getInputs() {
        return $this->inputs;
    }

}