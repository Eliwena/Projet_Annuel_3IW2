<?php

namespace App\Form\Admin\Review;

use App\Core\Framework;
use App\Form\Form;
use App\Services\Http\Session;

class ReportForm extends Form {

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
            "id"        => "form_report",
            "submit"    => "Signaler un avis"
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [

            "reason" => [
                "id"         => 'reason',
                "name"       => 'reason',
                "type"       => "text",
                "required"   => true,
                "class"      => "form_input",
                "minLength"   => 2,
                "maxLength"   => 250,
                "placeholder" => "Expliquez-nous votre problème :",
                "error"      => "Votre signalement doit faire entre 2 et 250 caractères."
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