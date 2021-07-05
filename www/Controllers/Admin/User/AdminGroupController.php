<?php

namespace App\Controller\Admin\User;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Form\Admin\Group\GroupForm;
use App\Models\Users\Group;
use App\Repository\Users\GroupRepository;
use App\Services\Http\Message;

class AdminGroupController extends AbstractController
{

    public function indexAction(){
        $groups = new Group();
        $groups = $groups->findAll(['isDeleted' => false]);
        $this->render("admin/group/list", ['groups' => $groups], 'back');
    }

    public function addAction(){

        $form = new GroupForm();

        if(!empty($_POST)) {
            $validator = FormValidator::validate($form, $_POST);
            if($validator) {
                $group = new Group();

                $group->setName(rand());
                $group->setDescription($_POST["description"]);
                $save = $group->save();

                if($save) {
                    $this->redirect(Framework::getUrl('app_admin_group'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un groupe.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_group_add'));
                }
            }
        } else {
            $this->render("admin/group/add",[
                "form" => $form,
            ],'back');
        }
    }

    public function editAction() {

        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $group = new Group();
            $group->setId($id);
            $group = $group->find(['id' => $group->getId()]);

            if($group->getName() == _SUPER_ADMIN_GROUP) {
                Message::create('Warning', 'Edition interdite');
                $this->redirect(Framework::getUrl('app_admin_group'));
            }

            $form = new GroupForm();

            $form->setForm([
                "submit" => "Editer le groupe",
                "id"     => "form_edit_groupe",
                "action" => Framework::getUrl('app_admin_group_edit', ['id' => $group->getId()]),
            ]);

            $form->setInputs([
                'description' => ['value' => $group->getDescription()]
            ]);

            if(!empty($_POST)) {

                $group->setId($id);
                if($_POST['description'] != $group->getDescription()) {
                    $group->setDescription($_POST['description']);
                }

                $update = $group->save();
                if($update) {
                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_group'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_group_edit', ['id' => $group->getId()]));
                }

            } else {
                $this->render('admin/group/edit', [
                    'group' => $group,
                    'form' => $form
                ], 'back');
            }
        } else {
            Message::create('Erreur', 'Aucun identifant spécifié.', 'error');
            $this->redirect(Framework::getUrl('app_admin_group'));
        }

    }

    public function deleteAction(){
        if(isset($_GET['id'])) {
            $group = GroupRepository::getGroupById($_GET['id']);
            if($group->getName() != _SUPER_ADMIN_GROUP) {
                $group->setIsDeleted(1);
                $group->save();
                Message::create('Succès', 'Suppression bien effectué.', 'success');
                $this->redirect(Framework::getUrl('app_admin_group'));
            }
            Message::create('Warning', 'Edition interdite');
            $this->redirect(Framework::getUrl('app_admin_group'));
        } else {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_group'));
        }

    }

}