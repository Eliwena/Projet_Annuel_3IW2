<?php

namespace App\Form;

use App\Core\Framework;

abstract class Form {

    protected $form = [];
    protected $inputs = [];

    public function __construct() {

    }

    public function render($hidden = false, $label = true) {

        $html = '<form';
        $html .= ' method="' . ($this->form['method'] ?? 'GET') . '"';
        $html .= ' action="' . ($this->form['action'] ?? Framework::getCurrentPath()) . '"';
        $html .= (isset($this->form['class']) != null) ? ' class="' . $this->form['class'] . '"' : '';
        $html .= (isset($this->form['id']) != null) ? ' id="' . $this->form['id'] . '"' : '';
        $html .= '>';

        foreach ($this->inputs as $input_key => $input) {

            $__active = true;
            if(isset($input['active']) && $input['active'] == false) {
                $__active = false;
            } elseif(isset($input['active']) && $input['active'] == true) {
                $__active = true;
            } else {
                $__active = true;
            }


            if($__active) {
                if($label) {
                    $html .= '<strong><label for="' . ($input['id'] ?? $input_key) . '" class="' . ($input['id'] ?? $input_key) . '">' . ($input["label"] ?? '') . '</label></strong></br>';
                }

                $html .= '<input';
                $html .= ' type="' . ($input['type'] ?? 'text') .'"';
                $html .= ' name="' . $input_key .'"';
                $html .= (isset($input['placeholder']) != null) ? ' placeholder="' . $input['placeholder'] . '"' : '';
                $html .= (isset($input['class']) != null) ? ' class="' . $input['class'] . '"' : '';
                $html .= (isset($input['id']) != null) ? ' id="' . $input['id'] . '"' : '';
                $html .= (isset($input['required']) != null and $input['required'] != false) ? ' required="' . $input['required'] . '"' : '';
                $html .= (isset($input['minLength']) != null) ? ' minlength="' . $input['minLength'] . '"' : '';
                $html .= (isset($input['maxLength']) != null) ? ' maxlength="' . $input['maxLength'] . '"' : '';
                $html .= (isset($input['value']) != null) ? ' value="' . $input['value'] . '"' : '';
                $html .= '><br>';
            }

        }

        $html .= '<input id="submit" type="submit" value="' . ($this->form["submit"] ?? "Envoyer") . '">';
        $html .= '</form>';

        if($hidden){
            return $html;
        } else {
            echo $html;
        }
    }

}

?>