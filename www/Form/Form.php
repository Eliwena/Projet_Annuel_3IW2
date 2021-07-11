<?php

namespace App\Form;

use App\Core\Framework;
use App\Core\Helpers;

abstract class Form
{

    protected $form = [];
    protected $inputs = [];

    public function __construct() {}

    public function render($hidden = false, $label = true)
    {

        //generate <form>
        $html = '<form';
        $html .= ' method="' . ($this->form['method'] ?? 'GET') . '"';
        $html .= ' action="' . ($this->form['action'] ?? Framework::getCurrentPath()) . '"';
        $html .= (isset($this->form['class']) != null) ? ' class="' . $this->form['class'] . '"' : '';
        $html .= (isset($this->form['id']) != null) ? ' id="' . $this->form['id'] . '"' : '';
        $html .= '>';

        foreach ($this->inputs as $input_key => $input) {

            $html .= '<div class="form_group">';
            if( (isset($input['active']) and $input['active'] == true) or !isset($input['active'])) {

                if(isset($input['type']) and $input['type'] != 'select') {

                    if($label && $input['type'] != 'checkbox') {
                        $html .= '<label class="form_label" for="' . ($input['id'] ?? $input_key) . '" class="' . ($input['id'] ?? $input_key) . '">' . ($input["label"] ?? '') . '</label>';
                    }
                    if($input['type'] == 'checkbox') {
                        $html .= '<div style="padding-top: 0.5rem">';
                    }
                    $html .= '<input';
                    $html .= ' type="' . ($input['type'] ?? 'text') .'"';
                    $html .= ' name="' . $input_key .'"';
                    $html .= (isset($input['style']) != null) ? ' style="' . $input['style'] . '"' : '';
                    $html .= (isset($input['placeholder']) != null) ? ' placeholder="' . $input['placeholder'] . '"' : '';
                    $html .= (isset($input['class']) != null) ? ' class="' . $input['class'] . '"' : '';
                    $html .= (isset($input['id']) != null) ? ' id="' . $input['id'] . '"' : '';
                    $html .= (isset($input['required']) != null and $input['required'] != false) ? ' required="' . $input['required'] . '"' : '';
                    $html .= (isset($input['minLength']) != null) ? ' minlength="' . $input['minLength'] . '"' : '';
                    $html .= (isset($input['maxLength']) != null) ? ' maxlength="' . $input['maxLength'] . '"' : '';
                    $html .= (isset($input['value']) != null) ? ' value="' . $input['value'] . '"' : '';
                    $html .= (isset($input['step']) != null) ? ' step="' . $input['step'] . '"' : '';
                    $html .= (isset($input['checked']) != null) ? ' checked' : '';
                    $html .= (isset($input['hidden']) != null) ? ' hidden' : '';
                    $html .= (isset($input['disabled']) != null) ? ' disabled' : '';
                    $html .= '>';

                    if(isset($input['help'])) {
                        foreach($input['help'] as $small) {
                            $html .= (isset($small['href']) != null) ? '<a class="form_text" href="' . $small['href'] . '">' : '';
                            $html .= '<small';
                            $html .= (isset($small['id']) != null) ? ' id="' . $small['id'] . '"' : '';
                            $html .= (isset($small['class']) != null) ? ' class="form_text ' . $small['class'] . '"' : 'form_text';
                            $html .= '>';
                            $html .= (isset($small['value']) != null) ? $small['value'] : '';
                            $html .= '</small>';
                            $html .= (isset($small['href']) != null) ? '</a>' : '';
                        }
                    }
                    if($input['type'] == 'checkbox') {
                        if($label) {
                            $html .= '<label style="margin-left: 0.2rem" for="' . ($input['id'] ?? $input_key) . '" class="' . ($input['id'] ?? $input_key) . '">' . ($input["label"] ?? '') . '</label>';
                        }
                        $html .= '</div>';
                    }

                } else {
                    if($label) {
                        $html .= '<label for="' . ($input['id'] ?? $input_key) . '" class="' . ($input['id'] ?? $input_key) . '">' . ($input["label"] ?? '') . '</label>';
                    }
                    $html .= '<select name="' . $input['name'] . '" id=' . $input['id'];
                    $html .= (isset($input['multiple']) != null) ? ' multiple' : '';
                    $html .= '>';
                    $html .= (isset($input['default_option']) != null) ?  '<option value="">'. $input['default_option'] .'</option>' : '';
                    foreach($input['options'] as $option) {
                        $html .= '<option value="' . $option['value'] . '"';
                        $html .= (isset($option['selected']) != null) ? ' selected' : '';
                        $html .= (isset($option['disabled']) != null) ? ' disabled' : '';
                        $html .= '>';
                        $html .= $option['text'] . '</option>';
                    }
                    $html .= '</select>';
                }
            }
            $html .= '</div>';
        }

        $html .= '<input class="btn btn-primary" style="margin-top: 15px" id="submit" type="submit" value="' . ($this->form["submit"] ?? "Envoyer") . '">';
        $html .= '</form>';

        if ($hidden) {
            return $html;
        } else {
            echo $html;
        }

    }
}
