<?php

namespace App\Form\Admin\Reservation;

use App\Core\Framework;
use App\Core\View;
use App\Form\Form;

class ReservationForm extends Form
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
            "id"     => "form_reservation",
            "submit" => "Ajouter une reservation"
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [
            "date" => [
                "id"          => "date",
                'name'        => 'date',
                "type"        => "date",
                "label"       => "Choisir une date : ",
                "required"    => true,
                "class"       => "form_input",
                "error"       => "une erreur est survenue",
            ],
            "checkbox" => [
                "id"          => "checkbox",
                'name'        => 'checkbox',
                "type"        => "checkbox",
                "label"       => "Compte existant ? ",
                "error"       => "une erreur est survenue"
            ],
            "nom" => [
                "id"          => "nom",
                'name'        => 'nom',
                "type"        => "text",
                "label"       => "Nom de la reservation : ",
                "required"    => true,
                "class"       => "form_input",
                "error"       => "une erreur est survenue"
            ],
            'hour' => [
                    "id" => 'hour',
                    'name' => 'hour',
                    "type" => "select",
                    "class" => "form_select",
                    'label' => 'Choisir un horraire',
            ],
            "people" => [
                "id"          => "people",
                'name'        => 'people',
                "type"        => "int",
                "label"       => "Choisir le nombre de personne : ",
                "required"    => true,
                "class"       => "form_input",
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
