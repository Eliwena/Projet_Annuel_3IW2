<?php

namespace App\Form;

use App\Core\Framework;
use App\Services\Translator\Translator;

class ContactForm extends Form {

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
            "id"     => "form_contact",
            "submit" => Translator::trans('app_contact_form_submit')
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [
            "email" => [
                "id"          => "email",
                'name'        => 'email',
                "type"        => "email",
                "label"       => Translator::trans('app_contact_form_email_label'),
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => Translator::trans('app_contact_form_error_length_email'),
                "error"       => Translator::trans('an_error_has_occured')
            ],
            "title" => [
                "id"          => "title",
                'name'        => 'title',
                "type"        => "text",
                "label"       => Translator::trans('app_contact_form_title_label'),
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 5,
                "maxLength"   => 100,
                "errorLength" => Translator::trans('app_contact_form_error_length_title'),
                "error"       => Translator::trans('an_error_has_occured')
            ],
            "content" => [
                "id"          => "content",
                'name'        => 'content',
                "type"        => "textarea",
                "style"       => 'height: 200px;',
                "label"       => Translator::trans('app_contact_form_content_label'),
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 10,
                "maxLength"   => 500,
                "errorLength" => Translator::trans('app_contact_form_error_length_content'),
                "error"       => Translator::trans('an_error_has_occured')
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