<?php

namespace App\Form\Admin\Review;

use App\Core\Framework;
use App\Form\Form;
use App\Services\Http\Session;
use App\Services\Translator\Translator;

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
            "submit"    =>  Translator::trans('form_review_submit'),
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
                "placeholder" =>  Translator::trans('form_review_title_placeholder'),
                "error"      =>  Translator::trans('form_review_title_error')
            ],

            "text" => [
                "id"         => 'text',
                "name"       => 'text',
                "type"       => "textarea",
                "required"   => true,
                "class"      => "form_input",
                "minLength"   => 10,
                "maxLength"   => 520,
                "placeholder" => Translator::trans('form_review_text_placeholder'),
                "error"      => Translator::trans('form_review_text_error'),
            ],

            "note" => [
                "id"          => "note",
                'name'        => 'note',
                "type"        => "number",
                "label"       => Translator::trans('form_review_note_label'),
                "required"    => true,
                "class"       => "form_input",
                "min"         => 0,
                "max"         => 5,
                "error"       => Translator::trans('form_review_note_error'),
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