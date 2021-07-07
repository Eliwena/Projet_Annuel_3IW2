<?php

namespace App\Controller\Admin\User;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Form\Admin\Group\GroupForm;
use App\Models\Users\Group;
use App\Models\Users\GroupPermission;
use App\Models\Users\UserGroup;
use App\Repository\Users\GroupPermissionRepository;
use App\Repository\Users\GroupRepository;
use App\Repository\Users\UserGroupRepository;
use App\Services\Http\Message;
use App\Services\Translator\Translator;

class AdminGroupController extends AbstractController
{

    public function indexAction(){
        $groups = GroupRepository::getGroups();
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

            $group = new Group();
            $groups = $group->findAll();

            $group_input = [];
            foreach ($groups ? $groups : [] as $group) {
                $group_input = array_merge($group_input, [['value' => $group['name'], 'text' => $group['description']]]);
            }

            $form->setInputs([
                'password_confirm' => [ 'active' => false ],
                'permission' => [
                    "id"          => "groups",
                    'name'        => 'groups[]',
                    "type"        => "select",
                    'multiple'    => true,
                    "options"      => $group_input,
                    "label"       => Translator::trans('admin_user_add_form_input_group_label'),
                    "required"    => false,
                    "class"       => "form_input",
                    "error"       => Translator::trans('admin_user_add_form_error')
                ]
            ]);

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

            //delete if group is not super_admin
            if($group->getName() != _SUPER_ADMIN_GROUP) {

                //init data
                $groupPermissions = GroupPermissionRepository::getGroupPermission($group);
                $userGroups = UserGroupRepository::getUserGroups(null, $group);

                //delete all group permission
                if($groupPermissions) {
                    foreach ($groupPermissions as $groupPermission) {
                        $gp = new GroupPermission();
                        $gp->setGroupId($groupPermission['groupId']['id']);
                        $gp->delete();
                    }
                }

                //delete all user group attached to group
                if($userGroups) {
                    foreach ($userGroups as $userGroup) {
                        $ug = new UserGroup();
                        $ug->setGroupId($userGroup['groupId']['id']);
                        $ug->delete();
                    }
                }

                //delete group
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