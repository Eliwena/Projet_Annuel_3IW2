<?php

namespace App\Form\Admin\Menu;

use App\Core\Framework;
use App\Form\Form;

class MenuForm extends Form
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
            "id"     => "form_menu",
            "submit" => "Ajouter un menu",
            'enctype' => 'multipart/form-data'
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
                "placeholder" => "Nom du menu",
                "label"       => "Nom : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Un nom est requis",
                "error"       => "une erreur est survenue"
            ],

            "description" => [
                'id'          => 'description',
                'name'        => 'description',
                'type'        => 'textarea',
                "label"       => "Description du menu : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "la description doit être renseigné",
                "error"       => "une erreur est survenue"
            ],

            "price" => [
                "id"          => "price",
                'name'        => 'price',
                "type"        => "number",
                "step"        => "0.01",
                "label"       => "Prix : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Un prix doit être renseigné",
                "error"       => "une erreur est survenue"
            ],

            "picture" => [
                'id'          => 'picture',
                'name'        => 'picture',
                'type'        => 'file',
                "label"       => "Image du menu : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "l'image doit être renseigné",
                "error"       => "une erreur est survenue"
            ]
        ];
        $this->inputs = array_replace_recursive($this->inputs, $options);
    }

    public function getInputs() {
        return $this->inputs;
    }

}