<?php

namespace App\Controller\Admin\Appearance;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Appearance\AppearanceForm;
use App\Models\Restaurant\Appearance;
use App\Services\File\FileManager;
use App\Services\File\uploadManager;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class AppearanceController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        if(!Security::isConnected()) {
            Message::create($this->trans('error'), $this->trans('you_need_to_be_connected'));
            $this->redirect(Framework::getUrl('app_login'));
        }
    }

    public function indexAction()
    {
        $this->isGranted('admin_panel_appearance_list');

        $appearance = new Appearance();
        $appearances = $appearance->findAll();

        $this->render("admin/appearance/list", ['_title' => 'Liste des apparence', 'appearances' => $appearances], 'back');

    }

    public function addAction()
    {
        $this->isGranted('admin_panel_appearance_add');
        $form = new AppearanceForm();

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if (true) {

                $appearance = new Appearance();

                if(!empty($_FILES['background_image']['name']) ) {

                    $uploadManager = new uploadManager();
                    $uploadManager->setFile($_FILES['background_image']);

                    if(!$uploadManager->isTypeAuthorized()) {
                        Message::create(Translator::trans('admin_file_upload_mime_type_unauthorized_title'), Translator::trans('admin_file_upload_mime_type_unauthorized_message'), 'error');
                        $this->redirect(Framework::getUrl('app_admin_appearance_edit', ['appearanceId' => $_GET['appearanceId']]));
                    }

                    if(!$uploadManager->validateFileSize()) {
                        Message::create(Translator::trans('admin_file_upload_max_size_increase_title'), Translator::trans('admin_file_upload_max_size_increase_message', ['size' => FileManager::formatBytes($uploadManager->getFileSize()), 'max_size' => FileManager::formatBytes($uploadManager->getMaxFileSize())]), 'error');
                        $this->redirect(Framework::getUrl('app_admin_appearance_edit', ['appearanceId' => $_GET['appearanceId']]));
                    }

                    $appearance->setBackgroundImage($uploadManager->getNewFileName() . '.' . $uploadManager->getFileExtension());
                    $uploadManager->save();

                }
                $appearance->setTitle($_POST['name']);
                $appearance->setDescription($_POST['description']);
                $appearance->setLinkPolice($_POST['link_police']);
                $appearance->setPolice($_POST['police']);
                $appearance->setPoliceColor($_POST['police_color']);
                $appearance->setBackground($_POST['background']);
                $appearance->setColorNumber1($_POST['color_1']);
                $appearance->setColorNumber2($_POST['color_2']);
                $appearance->setIsActive(false);

                $save = $appearance->save();

                if ($save) {
                    $this->redirect(Framework::getUrl('app_admin_appearance'));
                } else {
                    Message::create(Translator::trans('Erreur de connexion'), Translator::trans('admin_apearance_add_error_message'), 'error');
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
            $this->render("admin/appearance/add", ['_title' => Translator::trans('admin_appearance_add_title_render'), "form" => $form,], 'back');
        }
    }

    public function deleteAction()
    {
        $this->isGranted('admin_panel_appearance_delete');
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
        $this->isGranted('admin_panel_appearance_edit');
        if (!isset($_GET['appearanceId'])) {
            Message::create(Translator::trans('Erreur de connexion'), Translator::trans('admin_appearance_edit_identifiant_required'), 'error');
            $this->redirect(Framework::getUrl('app_admin_appearance'));
        }

        $id = $_GET['appearanceId'];

        $appearances = new Appearance();
        $appearances->setId($id);
        $appearance = $appearances->find(['id' => $id]);

        $form = new AppearanceForm();
        $form->setForm([
            "submit" => Translator::trans('admin_appearance_edit_submit'),
        ]);
        $form->setInputs([
            'name' => ['value' => $appearance->getTitle()],
            'description' => ['value' => $appearance->getDescription()],
            'link_police' => ['value' => $appearance->getLinkPolice()],
            'police' => ['value' => $appearance->getPolice()],
            'police_color'=>['value'=> $appearance->getPoliceColor()],
            'background' => ['value' => $appearance->getBackground()],
            'color_1' => ['value' => $appearance->getColorNumber1()],
            'color_2' => ['value' => $appearance->getColorNumber2()],
            'background_image'=>['required' => false, 'value' => $appearance->getBackgroundImage()],
        ]);

        if (!empty($_POST)) {

//            $validator = FormValidator::validate($form, $_POST);
//
//            if ($validator) {


                $_appearance = new Appearance();
               // Helpers::debug($_FILES['background_image']['name']);

                if(!empty($_FILES['background_image']['name']) ) {
                $uploadManager = new uploadManager();
                $uploadManager->setFile($_FILES['background_image']);

                if($uploadManager->getFileName() != $appearance->getBackgroundImage()) {
                    //remove old file
                    FileManager::remove(uploadManager::getDefaultSavePath() . $appearance->getBackgroundImage());

                    if(!$uploadManager->isTypeAuthorized()) {
                        Message::create(Translator::trans('admin_file_upload_mime_type_unauthorized_title'), Translator::trans('admin_file_upload_mime_type_unauthorized_message'), 'error');
                        $this->redirect(Framework::getUrl('app_admin_appearance_edit', ['appearanceId' => $_GET['appearanceId']]));
                    }

                    if(!$uploadManager->validateFileSize()) {
                        Message::create(Translator::trans('admin_file_upload_max_size_increase_title'), Translator::trans('admin_file_upload_max_size_increase_message', ['size' => FileManager::formatBytes($uploadManager->getFileSize()), 'max_size' => FileManager::formatBytes($uploadManager->getMaxFileSize())]), 'error');
                        $this->redirect(Framework::getUrl('app_admin_appearance_edit', ['appearanceId' => $_GET['appearanceId']]));
                    }

                    $_appearance->setBackgroundImage($uploadManager->getNewFileName() . '.' . $uploadManager->getFileExtension());
                    $uploadManager->save();

                }
            }

                $_appearance->setTitle($_POST['name']);
                $_appearance->setDescription($_POST['description']);
                $_appearance->setLinkPolice($_POST['link_police']);
                $_appearance->setPolice($_POST['police']);
                $_appearance->setPoliceColor($_POST['police_color']);
                $_appearance->setBackground($_POST['background']);
                $_appearance->setColorNumber1($_POST['color_1']);
                $_appearance->setColorNumber2($_POST['color_2']);
                $_appearance->setId($id);
                $update = $_appearance->save();

                if ($update) {

                    Message::create(Translator::trans('Update'), Translator::trans('admin_appearance_update_success_message'), 'success');
                    $this->redirect(Framework::getUrl('app_admin_appearance'));
                } else {
                    Message::create(Translator::trans('Erreur de mise à jour'), Translator::trans('admin_appearance_update_error_message'), 'error');
                    $this->redirect(Framework::getUrl('app_admin_appearance_edit'));
                }

        } else {
            $this->render("admin/appearance/edit", ['_title' => Translator::trans('admin_appearance_edit_title_render'), "form" => $form,], 'back');
        }
    }

    public function activeAction()
    {
        if (!isset($_GET['appearanceId'])) {
            Message::create(Translator::trans('Erreur de connexion'), Translator::trans('admin_appearance_edit_identifiant_required'), 'error');
            $this->redirect(Framework::getUrl('app_admin_appearance'));
        }

        $id = $_GET['appearanceId'];

        $appearancesActive = new Appearance();

        $appearancesActive = $appearancesActive->find(['isActive'=>1]);
        if($appearancesActive) {
            $appearancesActive->setIsActive(false);
            $appearancesActive->save();
        }

        $appearances = new Appearance();
        $appearances->setId($id);
        $appearances->setIsActive(1);

        $save = $appearances->save();

        if ($save) {
            $this->redirect(Framework::getUrl('app_admin_appearance'));
        } else {
            Message::create(Translator::trans('Erreur de connexion'), Translator::trans('admin_appearance_active_error_message'), 'error');
            $this->redirect(Framework::getUrl('app_admin_appearance'));
        }

    }

}