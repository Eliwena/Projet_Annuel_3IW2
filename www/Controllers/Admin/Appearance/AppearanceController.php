<?php

namespace App\Controller\Admin\Appearance;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Appearance\AppearanceForm;
use App\Models\Restaurant\Appearance;
use App\Services\Http\Message;
use App\Services\Http\Session;


class AppearanceController extends AbstractController
{

    public function indexAction()
    {
        $appearance = new Appearance();
        $appearances = $appearance->findAll();

        $this->render("admin/appearance/list", ['_title' => 'Liste des apparence', 'appearances' => $appearances], 'back');

    }

    public function addAction()
    {

        $form = new AppearanceForm();

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $appearance = new Appearance();

                $appearance->setTitle($_POST['name']);
                $appearance->setDescription($_POST['description']);
                $appearance->setLinkPolice('https://'.$_POST['link_police']);
                $appearance->setPolice($_POST['police']);
                $appearance->setBackground($_POST['background']);
                $appearance->setColorNumber1($_POST['color_1']);
                $appearance->setColorNumber2($_POST['color_2']);
                $appearance->setIsActive('0');
                Helpers::debug($appearance);
                $save = $appearance->save();

                if ($save) {
                    $this->redirect(Framework::getUrl('app_admin_appearance'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'une template.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_appearance_add'));
                }

            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_appearance_add'));
            }

        } else {
            $this->render("admin/appearance/add", ['_title' => 'Ajout d\'une template', "form" => $form,], 'back');
        }
    }

    public function deleteAction()
    {
        if (isset($_GET['appearanceId'])) {
            $id = $_GET['appearanceId'];

            $appearance = new Appearance();
            $appearance->setId($id);
            
            $appearance->delete();

            $this->redirect(Framework::getUrl('app_admin_appearance'));
        }
    }



}