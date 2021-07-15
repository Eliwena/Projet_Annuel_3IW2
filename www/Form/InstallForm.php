<?php

namespace App\Form;

use App\Core\Framework;
use App\Services\Http\Session;
use App\Services\Translator\Translator;

class InstallForm extends Form {

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
            "id"     => "form_setup",
            "submit" => Translator::trans('app_install_form_submit')
        ];
        $this->form = array_replace_recursive($this->form, $options);
        return $this;
    }

    public function getForm() {
        return $this->form;
    }

    public function setInputs($options = []) {

        $this->inputs = [
            "dbname" => [
                "id"          => "dbname",
                'name'        => 'dbname',
                "type"        => "text",
                "label"       => Translator::trans('app_install_form_dbname_label'),
                "required"    => true,
                "value"       => (Session::exist('form_install_dbname') ? Session::load('form_install_dbname') : 'restoguest'),
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Votre nom de table doit faire entre 1 et 320 caractères",
                "error"       => "une erreur est survenue"
            ],
            "dbuser" => [
                "id"          => "dbuser",
                'name'        => 'dbuser',
                "type"        => "text",
                "label"       => Translator::trans('app_install_form_dbuser_label'),
                "required"    => true,
                "class"       => "form_input",
                "value"       => (Session::exist('form_install_dbuser') ? Session::load('form_install_dbuser') : ''),
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Votre nom d'utilisateur doit faire entre 1 et 320 caractères",
                "error"       => "une erreur est survenue"
            ],
            "dbpass" => [
                "id"          => "dbpass",
                'name'        => 'dbpass',
                "type"        => "text",
                "label"       => Translator::trans('app_install_form_dbpass_label'),
                "required"    => false,
                "class"       => "form_input",
                "value"       => (Session::exist('form_install_dbpass') ? Session::load('form_install_dbpass') : ''),
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Votre mot de passe doit faire entre 1 et 320 caractères",
                "error"       => "une erreur est survenue"
            ],
            "dbhost" => [
                "id"          => "dbhost",
                'name'        => 'dbhost',
                "type"        => "text",
                "label"       => Translator::trans('app_install_form_dbhost_label'),
                "required"    => true,
                "value"       => (Session::exist('form_install_dbhost') ? Session::load('form_install_dbhost') : 'localhost'),
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Votre adresse de base de données faire entre 1 et 320 caractères",
                "error"       => "une erreur est survenue"
            ],
            "dbport" => [
                "id"          => "dbport",
                'name'        => 'dbport',
                "type"        => "number",
                "label"       => Translator::trans('app_install_form_dbport_label'),
                "required"    => true,
                "value"       => (Session::exist('form_install_dbport') ? Session::load('form_install_dbport') : 3306),
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Votre port de base de données faire entre 1 et 320 chiffres",
                "error"       => "une erreur est survenue"
            ],
            "dbprefixe" => [
                "id"          => "dbprefixe",
                'name'        => 'dbprefixe',
                "type"        => "text",
                "label"       => Translator::trans('app_install_form_dbprefix_label'),
                "required"    => true,
                "value"       => (Session::exist('form_install_dbprefixe') ? Session::load('form_install_dbprefixe') : hash('crc32b', rand()) . '_'),
                "class"       => "form_input",
                "minLength"   => 1,
                "maxLength"   => 320,
                "errorLength" => "Votre prefixe doit faire entre 1 et 320 caractères",
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

?>