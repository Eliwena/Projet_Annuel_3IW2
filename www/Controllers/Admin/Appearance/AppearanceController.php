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
                $appearance->setLinkPolice($_POST['link_police']);
                $appearance->setPolice($_POST['police']);
                $appearance->setBackground($_POST['background']);
                $appearance->setColorNumber1($_POST['color_1']);
                $appearance->setColorNumber2($_POST['color_2']);
                $appearance->setIsActive(false);
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

    public function editAction()
    {
        if (!isset($_GET['appearanceId'])) {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_appearance'));
        }

        $id = $_GET['appearanceId'];

        $appearances = new Appearance();
        $appearances->setId($id);
        $appearance = $appearances->find(['id' => $id]);

        $form = new AppearanceForm();
        $form->setForm([
            "submit" => "Editer le template",
        ]);
        $form->setInputs([
            'name' => ['value' => $appearance->getTitle()],
            'description' => ['value' => $appearance->getDescription()],
            'link_police' => ['value' => $appearance->getLinkPolice()],
            'police' => ['value' => $appearance->getPolice()],
            'background' => ['value' => $appearance->getBackground()],
            'color_1' => ['value' => $appearance->getColorNumber1()],
            'color_2' => ['value' => $appearance->getColorNumber2()],

        ]);

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $appearance = new Appearance();

                $appearance->setTitle($_POST['name']);
                $appearance->setDescription($_POST['description']);
                $appearance->setLinkPolice($_POST['link_police']);
                $appearance->setPolice($_POST['police']);
                $appearance->setBackground($_POST['background']);
                $appearance->setColorNumber1($_POST['color_1']);
                $appearance->setColorNumber2($_POST['color_2']);
                $appearance->setId($id);

                $update = $appearance->save();

                if ($update) {
                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_appearance'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_appearance_edit'));
                }
            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_appearance_edit'));
            }

        } else {
            $this->render("admin/appearance/edit", ['_title' => 'Edition d\'un Template', "form" => $form,], 'back');
        }
    }


}