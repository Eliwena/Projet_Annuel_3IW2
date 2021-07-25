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

            "firstname" => [
                "id"          => 'firstname',
                "name"        => 'firstname',
                "type"        => "text",
                "label"       => "Prénom : ",
                "required"    => true,
                "value"       => (Session::exist('form_email') ? Session::load('form_email') : ''),
                "class"       => "form_input",
                "minLength"   => 2,
                "maxLength"   => 50,
                "error"       => "Votre prénom doit faire entre 2 et 50 caractères."
            ],

            "text" => [
                "id"         => 'text',
                "name"       => 'text',
                "type"       => "text",
                "label"      => "Avis : ",
                "required"   => true,
                "class"      => "form_input",
                "minLength"   => 10,
                "maxLength"   => 520,
                "error"      => "Votre avis doit faire entre 10 et 520 caractères."
            ],

            "rate" => [
                "id"          => "rate",
                'name'        => 'rate',
                "type"        => "number",
                "label"       => "Choisir une note sur 10 : ",
                "required"    => true,
                "class"       => "form_input",
                "min"         => 0,
                "max"         => 10,
                "error"       => "Votre note doit être comprise entre 0 et 10."
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