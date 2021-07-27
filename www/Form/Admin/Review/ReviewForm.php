<?php

namespace App\Form\Admin\Review;

use App\Core\Framework;
use App\Form\Form;
use App\Services\Http\Session;

class ReviewForm extends Form {

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
            "id"        => "form_review",
            "submit"    => "Publier mon avis"
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [

            "title" => [
                "id"         => 'title',
                "name"       => 'title',
                "type"       => "text",
                "required"   => true,
                "class"      => "form_input",
                "minLength"   => 2,
                "maxLength"   => 80,
                "placeholder" => "Mon titre",
                "error"      => "Votre titre doit faire entre 2 et 80 caractères."
            ],

            "text" => [
                "id"         => 'text',
                "name"       => 'text',
                "type"       => "textarea",
                "required"   => true,
                "class"      => "form_input",
                "minLength"   => 10,
                "maxLength"   => 520,
                "placeholder" => "Mon avis...",
                "error"      => "Votre avis doit faire entre 10 et 520 caractères."
            ],

            "note" => [
                "id"          => "note",
                'name'        => 'note',
                "type"        => "number",
                "label"       => "Choisir une note sur 5 : ",
                "required"    => true,
                "class"       => "form_input",
                "min"         => 0,
                "max"         => 5,
                "error"       => "Votre note doit être comprise entre 0 et 5."
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