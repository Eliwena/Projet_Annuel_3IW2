<?php

namespace App\Form\Admin\Appearance;

use App\Core\Framework;
use App\Form\Form;

class AppearanceForm extends Form
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
            "id"     => "form_appearance",
            "submit" => "Ajouter une apparence"
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
                "placeholder" => "Nom du template",
                "label"       => "Nom : ",
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Un nom est requis",
                "error"       => "une erreur est survenue"
            ],
            "description" => [
                "id"          => "description",
                'name'        => 'description',
                "type"        => "text",
                "placeholder" => "Description",
                "label"       => "Description : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Une description doit être renseigné",
                "error"       => "une erreur est survenue"
            ],
            "link_police" => [
                "id"          => "link_police",
                'name'        => 'link_police',
                "type"        => "text",
                "placeholder" => "Lien de la police",
                "label"       => "Lien de la police  : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Un lien doit être renseigné",
                "error"       => "une erreur est survenue"
            ],
            "police" => [
                "id"          => "police",
                'name'        => 'police',
                "type"        => "text",
                "placeholder" => "Non de la police",
                "label"       => "Nom de la police : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Un nom de police doit être renseigné",
                "error"       => "une erreur est survenue"
            ],
            "police_color" => [
                "id"          => "police_color",
                'name'        => 'police_color',
                "type"        => "color",
                "placeholder" => "Exemple : #ebebeb ",
                "label"       => "Couleur de la police (HEXA) : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Une couleur principale doit être renseigné",
                "error"       => "une erreur est survenue"
            ],
            "background" => [
                "id"          => "background",
                'name'        => 'background',
                "type"        => "color",
                "placeholder" => "Exemple : #ebebeb",
                "label"       => "Couleur du background (HEXA): ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Un background doit être renseigné",
                "error"       => "une erreur est survenue"
            ],
            "color_1" => [
                "id"          => "color_1",
                'name'        => 'color_1',
                "type"        => "color",
                "placeholder" => "Exemple : #ebebeb ",
                "label"       => "Couleur principale (HEXA) : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Une couleur principale doit être renseigné",
                "error"       => "une erreur est survenue"
            ],
            "color_2" => [
                "id"          => "color_2",
                'name'        => 'color_2',
                "type"        => "color",
                "placeholder" => "Exemple : #ebebeb ",
                "label"       => "Couleur secondaire (HEXA) : ",
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => "Une couleur secondaire doit être renseigné",
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