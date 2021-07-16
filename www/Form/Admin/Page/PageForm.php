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
                "label"       => Translator::trans('admin_page_form_name'),
                "required"    => true,
                "class"       => "form_input",
                "value"       => (Session::exist('form_install_name') ? Session::load('form_install_name') : ''),
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => Translator::trans('admin_page_form_error_lenght', ['name' => Translator::trans('admin_page_form_name')]),
                "error"       => Translator::trans('admin_page_form_error')
            ],

            "slug" => [
                "id"          => "slug",
                'name'        => 'slug',
                "type"        => "text",
                "label"       => Translator::trans('admin_page_form_slug'),
                "required"    => true,
                "placeholder" => '/page/nom-de-ma-page',
                "value"       => (Session::exist('form_install_slug') ? Session::load('form_install_slug') : ''),
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => Translator::trans('admin_page_form_error_lenght', ['name' => Translator::trans('admin_page_form_slug')]),
                "error"       => Translator::trans('admin_page_form_error')
            ],

            "content" => [
                "id"          => "content",
                'name'        => 'content',
                "type"        => "textarea",
                "label"       => Translator::trans('admin_page_form_content'),
                "required"    => false,
                "value"       => (Session::exist('form_install_content') ? Session::load('form_install_content') : ''),
                "style"       => "height: 500px",
                "class"       => "form_input",
                "errorLength" => Translator::trans('admin_page_form_error_lenght', ['name' => Translator::trans('admin_page_form_content')]),
                "error"       => Translator::trans('admin_page_form_error')
            ],
        ];


        $this->inputs = array_replace_recursive($this->inputs, $options);
        return $this;
    }

    public function getInputs() {
        return $this->inputs;
    }

}