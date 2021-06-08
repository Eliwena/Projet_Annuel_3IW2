<?php

namespace App\Form\Ingredients;

use App\Core\Framework;
use App\Form\Form;

class IngredientsForm extends Form
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
            "id"     => "form_ingredient",
            "submit" => "Ajouter un Ingredient"
        ];
        return $this;
    }

    public function getForm() {
        return $this->form;
    }
    public function setInputs($options = []) {

        $this->inputs = [
            "nom" => [
                "id"          => "nom",
                'name'        => 'Nom',
                "type"        => "text",
                "placeholder" => "Nom de l'ingredient",
                "label"       => "Nom : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 8,
                "maxLength"   => 320,
                "errorLength" => "Un nom est requis",
                "error"       => "une erreur est survenue"
            ],

            "prix"=>[
                "id"          => "prix",
                'name'        => 'Prix',
                "type"        => "number",
                "label"       => "Prix : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 8,
                "errorLength" => "Un prix doit être renseigné",
                "error"       => "une erreur est survenue"
            ],
            "active"=>[
                "id"          => "active",
                'name'        => 'Active',
                "type"        => "select",
                "option"      => [
                    [
                        "value" => "Oui",
                        "text" => "Oui",
                    ],
                    [
                    "value" => "Non",
                    "text" => "Non",
                    ],
                ],
                "label"       => "Est ce que l'ingredient se vent tous seul : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 8,
                "error"       => "une erreur est survenue"
            ]
        ];
        return $this;
    }

}