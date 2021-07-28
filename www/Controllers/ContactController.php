<?php


namespace App\Controller;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Helpers;
use App\Form\ContactForm;
use App\Repository\WebsiteConfigurationRepository;
use App\Services\Http\Message;
use App\Services\Mailer\Mailer;
use App\Services\Translator\Translator;

class ContactController extends AbstractController
{

    public function contactAction() {
        $form = new ContactForm();
        if(!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if($validator) {
                $mailer = new Mailer();
                $mailer->setFrom($_POST['email']);
                $mailer->prepare(WebsiteConfigurationRepository::getContactEmail(), $_POST['title'], 'FROM: ' . $_POST['email'] . '<br>' . 'Content: ' . $_POST['content']);

                if($mailer->send()) {
                    Message::create(Translator::trans('success'), Translator::trans('app_contact_form_success'), 'success');
                    $this->redirectToRoute('app_home');
                } else {
                    Message::create(Translator::trans('error'), Translator::trans('app_contact_form_error'), 'success');
                    $this->redirectToRoute('app_home');
                }

            } else {
                $this->redirectToRoute('app_contact');
            }
        } else {
            $this->render("contact", ['form' => $form]);
        }
    }

}