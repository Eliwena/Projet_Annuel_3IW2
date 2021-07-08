<?php

namespace App\Controller\Admin\User;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Group\GroupForm;
use App\Models\Users\Group;
use App\Models\Users\GroupPermission;
use App\Models\Users\UserGroup;
use App\Repository\Users\GroupPermissionRepository;
use App\Repository\Users\GroupRepository;
use App\Repository\Users\PermissionRepository;
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
            if(!$validator) {
                $this->redirect(Framework::getCurrentPath());
            }

            $group = new Group();

            $group_name = rand();
            $group->setName($group_name);
            $group->setDescription($_POST["description"]);
            $save = $group->save();

            if($save) {

                //add permission to group here
                if(isset($_POST['permissions']) && is_array($_POST['permissions'])) {
                    //find new group id
                    $group = GroupRepository::getGroupByName($group_name);
                    //foreach posted permission
                    foreach($_POST['permissions'] as $permission) {
                        //get permission data from db
                        $permission = PermissionRepository::getPermissionsByName($permission);
                        //insert new permission in groupPermission table
                        $groupPermissions = new GroupPermission();
                        $groupPermissions->setGroupId($group->getId());
                        $groupPermissions->setPermissionId($permission->getId());
                        $groupPermissions->save();
                    }
                }

                $this->redirect(Framework::getUrl('app_admin_group'));
            } else {
                Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un groupe.', 'error');
                $this->redirect(Framework::getUrl('app_admin_group_add'));
            }
        } else {

            $permissions = PermissionRepository::getPermissions();

            $permission_input = [];
            $index = 0;
            foreach ($permissions ? $permissions : [] as $permission) {
                $permission_input = array_merge_recursive($permission_input, [
                    "permissions[{$index}]" => [
                            "id"          => $permission['name'],
                            'name'        => $permission['name'],
                            "type"        => "checkbox",
                            "label"       => $permission['description'],
                            "value"       => $permission['name'],
                            "required"    => false,
                            "class"       => "form_input",
                            "error"       => 'Erreur!'
                    ]
                ]);
                $index++;
            }
            $form->setInputs($permission_input);

            $this->render("admin/group/add",[
                "form" => $form,
            ],'back');
        }
    }

    public function editAction() {


        if(isset($_GET['id'])) {

            $id = $_GET['id'];
            $form = new GroupForm();

            $group = GroupRepository::getGroupById($id);

            if($group->getName() == _SUPER_ADMIN_GROUP) {
                Message::create('Warning', 'Edition interdite');
                $this->redirect(Framework::getUrl('app_admin_group'));
            }

            if(!empty($_POST)) {

                $g = new Group();
                $g->setId($id);

                if(isset($_POST['description']) && !empty($_POST['description'])) {
                    $g->setDescription($_POST['description']);
                }

                $update = $g->save();
                if($update || ($_POST['description'] == $group->getDescription())) {

                    $groupPermissions = GroupPermissionRepository::getGroupPermission($group);

                    if(isset($_POST['permissions']) && !empty($_POST['permissions']) && isset($groupPermissions)) {

                        foreach ($_POST['permissions'] as $permission_name) {

                            $permission = PermissionRepository::getPermissionsByName($permission_name);

                            //si nouvelle permission l'ajouter
                            if(!GroupPermissionRepository::groupHasPermission($group, $permission)) {
                                $groupPermission = new GroupPermission();
                                $groupPermission->setPermissionId($permission->getId());
                                $groupPermission->setGroupId($group->getId());
                                $groupPermission->save();
                            }
                        }
                        //check dans la db si le groupe a la permission pas coché le supprime
                        foreach(GroupPermissionRepository::getGroupPermission($group) as $permission_group) {
                            if(!in_array($permission_group['permissionId']['name'], $_POST['permissions'])) {
                                $permissions = PermissionRepository::getPermissionsByName($permission_group['permissionId']['name']);
                                $groupPermission = new GroupPermission();
                                $groupPermission->setGroupId($group->getId());
                                $groupPermission->setPermissionId($permissions->getId());
                                $groupPermission->delete();
                            }
                        }

                    } else {
                        //si aucune permission coché tous delete
                        foreach ($_POST['permissions'] as $permission_name) {
                            $permission = PermissionRepository::getPermissionsByName($permission_name);
                            $groupPermissions = new GroupPermission();
                            $groupPermissions->setGroupId($group->getId());
                            $groupPermissions->setPermissionId($permission->getId());
                            $groupPermissions->delete();
                        }
                    }
                    /**- --- -**/


                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_group'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_group_edit', ['id' => $group->getId()]));
                }


            } else {

                $permissions = PermissionRepository::getPermissions();
                $permissions_input = [];
                $index = 0;

                if($permissions) {
                    foreach ($permissions as $permission) {
                        if (GroupPermissionRepository::groupHasPermission($group, $permission)) {
                            $permissions_input = array_merge($permissions_input, [
                                "permissions[{$index}]" => [
                                    "id" => $permission['name'],
                                    'name' => $permission['name'],
                                    "type" => "checkbox",
                                    "label" => $permission['description'],
                                    "value" => $permission['name'],
                                    "required" => false,
                                    'checked' => true,
                                    "class" => "form_input",
                                    "error" => 'Erreur!'
                                ]
                            ]);
                        } else {
                            $permissions_input = array_merge($permissions_input, [
                                "permissions[{$index}]" => [
                                    "id" => $permission['name'],
                                    'name' => $permission['name'],
                                    "type" => "checkbox",
                                    "label" => $permission['description'],
                                    "value" => $permission['name'],
                                    "required" => false,
                                    "class" => "form_input",
                                    "error" => 'Erreur!'
                                ]
                            ]);
                        }
                        $index++;
                    }
                }

                $form->setForm([
                    "submit" => "Editer le groupe",
                    "id"     => "form_edit_groupe",
                    "action" => Framework::getUrl('app_admin_group_edit', ['id' => $group->getId()]),
                ]);

                $form->setInputs(array_merge([
                    'description' => ['value' => $group->getDescription()],

                ], $permissions_input));

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