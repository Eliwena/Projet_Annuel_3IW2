<?php

namespace App\Controller\Admin\User;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Group\GroupForm;
use App\Form\Admin\Permission\PermissionForm;
use App\Models\Users\Group;
use App\Models\Users\Permissions;
use App\Repository\Users\GroupRepository;
use App\Services\Http\Message;
use App\Services\User\Security;

class AdminPermissionController extends AbstractController
{

    public function indexAction(){
        $permission = new Permissions();
        $permissions = $permission->findAll(['isDeleted' => false]);
        $this->render("admin/permission/list", compact('permissions'), 'back');
    }

    public function addAction(){

        $form = new PermissionForm();

        if(!empty($_POST)) {
            $validator = FormValidator::validate($form, $_POST);
            if($validator) {
                $permission = new Permissions();

                $permission->setName($_POST['name']);
                $permission->setGroupId($_POST["group"]);
                $save = $permission->save();

                if($save) {
                    $this->redirect(Framework::getUrl('app_admin_permission'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'une permission.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_permission_add'));
                }
            }
        } else {

            $groups = GroupRepository::getGroups();
            $group_input = [];

            if($groups) {
                foreach ($groups as $group) {
                    $group_input = array_merge($group_input, [['value' => $group['id'], 'text' => $group['description']]]);
                }
            }
            $form->setInputs(['group' => ['options' => $group_input]]);

            $this->render("admin/permission/add",[
                "form" => $form,
            ],'back');
        }
    }

    public function editAction() {

        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $permission = new Permissions();
            $permission->setId($id);
            $permission = $permission->find(['id' => $permission->getId()]);

            if(!empty($_POST)) {
                $p = new Permissions();
                if($_POST['name'] != $permission->getName()) {$p->setName($_POST['name']);}
                if($_POST['group'] != $permission->getGroupId()->getId()) {$p->setGroupId($_POST['group']);}
                $p->setId($id);
                $update = $p->save();
                if($update) {
                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_permission'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_permission_edit', ['id' => $permission->getId()]));
                }
            } else {
                $form = new PermissionForm();
                $form->setForm([
                    "submit" => "Editer la permission",
                    "id"     => "form_edit_permission",
                ]);
                $groups = GroupRepository::getGroups();
                $group_input = [];
                if($groups) {
                    foreach ($groups as $group) {
                        if(($group['id'] == $permission->getGroupId()->getId())) {
                            $group_input = array_merge($group_input, [['selected' => true, 'value' => $group['id'], 'text' => $group['description']]]);
                        } else {
                            $group_input = array_merge($group_input, [['value' => $group['id'], 'text' => $group['description']]]);
                        }
                    }
                }
                $form->setInputs([
                    'name' => ['value' => $permission->getName()],
                    'group' => ['options' => $group_input]
                ]);
                $this->render('admin/permission/edit', [
                    'permission' => $permission,
                    'form' => $form
                ], 'back');
            }
        } else {
            Message::create('Erreur', 'Aucun identifant spécifié.', 'error');
            $this->redirect(Framework::getUrl('app_admin_permission'));
        }

    }

    public function deleteAction(){
        if(isset($_GET['id'])) {
            $permission = new Permissions();
            $permission->setId($_GET['id']);
            $permission->setIsDeleted(1);
            $permission->save();
            Message::create('Succès', 'Suppression bien effectué.', 'success');
            $this->redirect(Framework::getUrl('app_admin_permission'));
            Message::create('Warning', 'Edition interdite');
            $this->redirect(Framework::getUrl('app_admin_permission'));
        } else {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_permission'));
        }

    }

}