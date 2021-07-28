<?php

namespace App\Form\Admin\Appearance;

use App\Core\Framework;
use App\Form\Form;
use App\Services\Translator\Translator;

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
            "submit" => Translator::trans('form_appearance_submit'),
            'enctype' => 'multipart/form-data'
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
                "placeholder" => Translator::trans('form_appearance_placeholder_name'),
                "label"       => Translator::trans('form_appearance_label_name'),
                "required"    => true,
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => Translator::trans('form_appearance_error_length_name'),
                "error"       => Translator::trans('form_appearance_error'),
            ],
            "description" => [
                "id"          => "description",
                'name'        => 'description',
                "type"        => "text",
                "placeholder" => Translator::trans('form_appearance_placeholder_description'),
                "label"       => Translator::trans('form_appearance_label_description'),
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => Translator::trans('form_appearance_error_length_description'),
                "error"       => Translator::trans('form_appearance_error'),
            ],

            "link_police" => [
                "id"          => "link_police",
                'name'        => 'link_police',
                "type"        => "text",
                "placeholder" => Translator::trans('form_appearance_placeholder_link_police'),
                "label"       => Translator::trans('form_appearance_label_link_police'),
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => Translator::trans('form_appearance_error_length_link_police'),
                "error"       => Translator::trans('form_appearance_error'),
            ],

            "police" => [
                "id"          => "police",
                'name'        => 'police',
                "type"        => "text",
                "placeholder" => Translator::trans('form_appearance_placeholder_police'),
                "label"       => Translator::trans('form_appearance_label_police'),
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => Translator::trans('form_appearance_error_length_police'),
                "error"       => Translator::trans('form_appearance_error'),
            ],
            "police_color" => [
                "id"          => "police_color",
                'name'        => 'police_color',
                "type"        => "color",
                "placeholder" => Translator::trans('form_appearance_placeholder_police_color'),
                "label"       => Translator::trans('form_appearance_label_police_color'),
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => Translator::trans('form_appearance_error_length_police_color'),
                "error"       => Translator::trans('form_appearance_error'),
            ],
            "background" => [
                "id"          => "background",
                'name'        => 'background',
                "type"        => "color",
                "placeholder" => Translator::trans('form_appearance_placeholder_background'),
                "label"       => Translator::trans('form_appearance_label_background'),
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => Translator::trans('form_appearance_error_length_background'),
                "error"       => Translator::trans('form_appearance_error'),
            ],
            "color_1" => [
                "id"          => "color_1",
                'name'        => 'color_1',
                "type"        => "color",
                "placeholder" => Translator::trans('form_appearance_placeholder_color_1'),
                "label"       => Translator::trans('form_appearance_label_color_1'),
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => Translator::trans('form_appearance_error_length_color_1'),
                "error"       => Translator::trans('form_appearance_error'),
            ],
            "color_2" => [
                "id"          => "color_2",
                'name'        => 'color_2',
                "type"        => "color",
                "placeholder" => Translator::trans('form_appearance_placeholder_color_2'),
                "label"       => Translator::trans('form_appearance_label_color_2'),
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => Translator::trans('form_appearance_error_length_color_2'),
                "error"       => Translator::trans('form_appearance_error'),
            ],

            "background_image" => [
                'id'          => 'background_image',
                'name'        => 'background_image',
                'type'        => 'file',
                "label"       => Translator::trans('form_appearance_label_background_image'),
                "required"    => true,
                "class"       => "form_input",
                "errorLength" => Translator::trans('form_appearance_error_length_background_image'),
                "error"       => Translator::trans('form_appearance_error'),
            ]
        ];
        $this->inputs = array_replace_recursive($this->inputs, $options);
        return $this;
    }

    public function getInputs() {
        return $this->inputs;
    }
}