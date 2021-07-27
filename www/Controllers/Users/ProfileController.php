<?php

namespace App\Controller\Users;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Form\ProfileMeForm;
use App\Models\Users\User;
use App\Services\Http\Message;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class ProfileController extends AbstractController
{

    public function ProfileMeAction() {
        if(Security::isConnected()) {

            $form = new ProfileMeForm();

            if(!empty($_POST)) {
                $validator = FormValidator::validate($form, $_POST);
                if($validator) {
                    $user = new User();
                    if(isset($_POST['firstname']) && $_POST['firstname'] != $this->getUser()->getFirstname()) {
                        $user->setFirstname($_POST['firstname']);
                    }
                    if(isset($_POST['lastname']) && $_POST['lastname'] != $this->getUser()->getLastname()) {
                        $user->setLastname($_POST['lastname']);
                    }
                    if(isset($_POST['password']) && isset($_POST['password_confirm']) && $_POST['password'] == $_POST['password_confirm']) {
                        $user->setPassword(Security::passwordHash($_POST['password']));
                    }

                    $user->setId($this->getUser()->getId());
                    if($user->save()) {
                        Message::create(Translator::trans('success'), Translator::trans('profile_update'), 'success');
                        $this->redirectToRoute('app_profile');
                    } else {
                        Message::create(Translator::trans('error'), Translator::trans('an_error_has_occured'));
                        $this->redirectToRoute('app_profile');
                    }
                }
            } else {
                $form->setInputs([
                    'firstname' => [ 'value' => $this->getUser()->getFirstname() ],
                    'lastname' => [ 'value' => $this->getUser()->getLastname() ],
                ]);
                $this->render('profile_me', compact('form'));
            }
        } else {
            Message::create(Translator::trans('error'), Translator::trans('you_need_to_be_disconnected'));
            $this->redirectToRoute('app_login');
        }
    }

}