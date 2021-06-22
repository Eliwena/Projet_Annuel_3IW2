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
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [
            "nom" => [
                "id"          => "nom",
                'name'        => 'nom',
                "type"        => "text",
                "placeholder" => "Nom de l'ingredient",
                "label"       => "Nom : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Un nom est requis",
                "error"       => "une erreur est survenue"
            ],

            "prix"=>[
                "id"          => "prix",
                'name'        => 'prix',
                "type"        => "number",
                "step"        => "0.01",
                "label"       => "Prix : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Un prix doit être renseigné",
                "error"       => "une erreur est survenue"
            ],
            "activeCommande" => [
                "id"          => "activeCommande",
                'name'        => 'activeCommande',
                "type"        => "select",
                'default_option' => 'Vendre l\'ingredient a l\'unite',
                "options"      => [
                    [
                        "value" => 1,
                        "text" => "Oui",
                    ],
                    [
                        "value" => 0,
                        "text" => "Non",
                    ],
                ],
                "label"       => "Est ce que l'ingredient se vend tous seul : ",
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