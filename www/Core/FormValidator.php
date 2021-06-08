<?php
namespace App\Core;

use App\Form\Form;
use App\Services\Http\Message;

class FormValidator
{

    public static function validate(Form $formObj, $data) {

        $error = false;

        $form = $formObj->getForm();
        $inputs = $formObj->getInputs();

        if (!$form['method'] == 'POST') {
            $error = true;
            Message::create('Attention', 'un erreur est survenue lors de l\'envoi du formulaire');
        }

        if (!$form['action'] == Framework::getCurrentPath()) {
            $error = true;
            Message::create('Attention', 'L\'url ne correspond pas.');
        }

        foreach ($inputs as $input) {

            $input_name = $input['id'];

            if ($input['required']) {

                if (empty($data[$input_name])) {
                    $error = true;
                    Message::create('Attention un erreur est survenue', $input['error']);
                } else {
                    if(isset($input['minLength'])) {
                        if ($input['minLength'] > strlen($data[$input_name])) {
                            $error = true;
                            Message::create('Attention un erreur est survenue', $input['errorLength']);
                        }
                    }
                    if(isset($input['maxLength'])) {
                        if($input['maxLength'] < strlen($data[$input_name])) {
                            $error = true;
                            Message::create('Attention un erreur est survenue', $input['errorLength']);
                        }
                    }
                }
            }
        }

        return $error == false ? true : false;
    }

    /*public static function validate(Form $formObj, $data) {
        $validator = FormValidator::check($formObj, $data);
        return $validator;
    }*/

}