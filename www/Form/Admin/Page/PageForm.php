<?php

namespace App\Form\Admin\Page;

use App\Core\Framework;
use App\Form\Form;
use App\Services\Http\Session;
use App\Services\Translator\Translator;

class PageForm extends Form
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
            "submit" => Translator::trans('admin_page_add_title')
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
                "label"       => Translator::trans('name_of_the_page'),
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => Translator::trans('admin_page_form_error_lenght', ['name' => Translator::trans('name_of_the_page')]),
                "error"       => Translator::trans('an_error_has_occured')
            ],

            "meta_description" => [
                "id"          => "meta_description",
                'name'        => 'meta_description',
                "type"        => "textarea",
                "label"       => Translator::trans('admin_page_textarea'),
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => Translator::trans('admin_page_form_error_lenght', ['name' => Translator::trans('name_of_the_page')]),
                "error"       => Translator::trans('an_error_has_occured')
            ],

            "slug" => [
                "id"          => "slug",
                'name'        => 'slug',
                "type"        => "text",
                "label"       => Translator::trans('address'),
                "required"    => true,
                "placeholder" => '/page/nom-de-ma-page',
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => Translator::trans('admin_page_form_error_lenght', ['name' => Translator::trans('address')]),
                "error"       => Translator::trans('an_error_has_occured')
            ],

            "content" => [
                "id"          => "content",
                'name'        => 'content',
                "type"        => "textarea",
                "label"       => Translator::trans('admin_page_form_content'),
                "required"    => false,
                "style"       => "height: 500px",
                "class"       => "form_input",
                "errorLength" => Translator::trans('admin_page_form_error_lenght', ['name' => Translator::trans('admin_page_form_content')]),
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