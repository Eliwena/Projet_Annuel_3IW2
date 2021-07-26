<?php

namespace App\Form\Admin;

use App\Core\Framework;
use App\Form\Form;
use App\Services\Translator\Translator;

class ConfigurationForm extends Form
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
            "id"     => "form_page",
            "submit" => Translator::trans('admin_configuration_form_edit_title')
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {
        $this->inputs = [
            "value" => [
                "id"          => "value",
                'name'        => 'value',
                "type"        => "text",
                "label"       => Translator::trans('value'),
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => Translator::trans('admin_configuration_form_error_lenght', ['name' => Translator::trans('value')]),
                "error"       => Translator::trans('an_error_has_occured')
            ]
        ];

        $this->inputs = array_replace_recursive($this->inputs, $options);
        return $this;
    }

    public function getInputs() {
        return $this->inputs;
    }

}