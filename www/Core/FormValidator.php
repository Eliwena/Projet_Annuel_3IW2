<?php
namespace App\Core;

use App\Form\Form;
use App\Services\Http\Message;

class FormValidator
{

    public static function validate(Form $formObj, $data)
    {

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

            //verification champs requis
            if (isset($input['required']) && $input['required'] == true) {

                //verification champs requis remplis
                if (empty($data[$input_name])) {
                    $error = true;
                    Message::create('Attention un erreur est survenue', $input['error']);
                } else { //si ok alors

                    //verification taille du champs minimum
                    if (isset($input['minLength'])) {
                        if ($input['minLength'] > strlen($data[$input_name])) {
                            $error = true;
                            Message::create('Attention un erreur est survenue', $input['errorLength']);
                        }
                    }

                    //verification taille du champs max
                    if (isset($input['maxLength'])) {
                        if ($input['maxLength'] < strlen($data[$input_name])) {
                            $error = true;
                            Message::create('Attention un erreur est survenue', $input['errorLength']);
                        }
                    }

                    if (isset($input['min'])) {
                        if ($input['min'] > $data[$input_name]) {
                            $error = true;
                            Message::create('Attention un erreur est survenue', $input['error']);
                        }
                    }

                    if (isset($input['max'])) {
                        if ($input['max'] < $data[$input_name]) {
                            $error = true;
                            Message::create('Attention un erreur est survenue', $input['error']);
                        }
                    }

                    //verification email
                    if ($input['type'] == 'email') {
                        if (filter_var($data[$input_name], FILTER_VALIDATE_EMAIL) == false) {
                            $error = true;
                            Message::create('Attention un erreur est survenue', 'votre email est incorrect');
                        }
                    }

                    //verification numeric
                    if ($input['type'] == 'number') {
                        if (!is_numeric($data[$input_name])) {
                            $error = true;
                            Message::create('Attention un erreur est survenue', 'le champs' . isset($input['name']) ? $input['name'] : $input_name);
                        }
                    }

                    //verification numeric

                }
            }
        }
        return $error == false ? true : false;
    }

}