<?php

namespace App\Controller\Admin\User;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\User\RegisterForm;
use App\Models\Users\Group;
use App\Models\Users\User;
use App\Models\Users\UserGroup;
use App\Repository\Users\GroupRepository;
use App\Repository\Users\UserGroupRepository;
use App\Repository\Users\UserRepository;
use App\Services\Http\Message;
use App\Services\Translator\Translator;
use App\Services\User\Security;

class AdminUserController extends AbstractController
{

    public function indexAction(){
        $this->render("admin/user/list", ['users' => UserRepository::getUsers()], 'back');
    }

    public function editAction() {

        $id = $_GET['id'];

        $form = new RegisterForm();
        $user = UserRepository::getUser($id);

        //check si l'id de l'utilisateur existe en db
        if(!$user) {
            Message::create(Translator::trans('error'), Translator::trans('admin_user_edit_user_exist_error_message', ['id' => $id]));
            $this->redirect(Framework::getUrl('app_admin_user'));
        }

        //si formulaire envoyé
        if(!empty($_POST)) {

            if(isset($_POST['email']) && !empty($_POST['email'])) {
                $user->setEmail($_POST["email"]);
            }
            if(isset($_POST['firstname']) && !empty($_POST['firstname'])) {
                $user->setFirstname($_POST["firstname"]);
            }
            if(isset($_POST['lastname']) && !empty($_POST['lastname'])) {
                $user->setLastname($_POST["lastname"]);
            }
            if(isset($_POST['password']) && !empty($_POST['password'])) {
                $user->setPassword(Security::passwordHash($_POST["password"]));
            }

            $user->setId($id);
            $update = $user->save();

            /**- --- -**/
            $userGroups = UserGroupRepository::getUserGroups($user);

            if(isset($_POST['groups']) && !empty($_POST['groups']) && isset($userGroups)) {
                foreach ($_POST['groups'] as $group_name) {

                    $group = GroupRepository::getGroupByName($group_name);

                    //si nouveau groupe l'ajouter
                    if(!GroupRepository::userHasGroup($group, $user)) {
                        $userGroup = new UserGroup();
                        $userGroup->setUserId($user->getId());
                        $userGroup->setGroupId($group->getId());
                        $update = $userGroup->save();
                    }
                }
                //check dans la db si l'utilisateur a un group pas coché le supprime
                foreach(UserGroupRepository::getUserGroups($user) as $user_group) {
                    if(!in_array($user_group['groupId']['name'], $_POST['groups'])) {
                        $group = GroupRepository::getGroupByName($user_group['groupId']['name']);
                        $userGroup = new UserGroup();
                        $userGroup->setGroupId($group->getId());
                        $userGroup->setUserId($user->getId());
                        $update = $userGroup->delete();
                    }
                }
            } else {
                //si aucun group tous delete
                    $groups = UserGroupRepository::getUserGroups($user);
                    foreach ($groups as $group) {
                        $userGroup = new UserGroup();
                        $userGroup->setGroupId($group['groupId']['id']);
                        $userGroup->setUserId($user->getId());
                        $update = $userGroup->delete();
                    }
                    $update = true;
            }

            /**- --- -**/

            if($update or isset($_POST['groups'])) {
                Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                $this->redirect(Framework::getUrl('app_admin_user'));
            } else {
                Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                $this->redirect(Framework::getUrl('app_admin_user'));
            }

        } else {

            $inputs = [
                'password' => ['required' => 0],
                'email' => ['required' => false, 'value' => $user->getEmail()],
                'firstname' => ['required' => false, 'value' => $user->getFirstname()],
                'lastname' => ['required' => false, 'value' => $user->getLastname()],
                'password_confirm' => ['active' => false],
            ];

            $groups = GroupRepository::getGroups();
            $group_input = [];

            if($groups) {
                foreach ($groups as $group) {
                    if (GroupRepository::userHasGroup($group, $user)) {
                        $group_input = array_merge($group_input, [['selected' => true, 'value' => $group['name'], 'text' => $group['description']]]);
                    } else {
                        $group_input = array_merge($group_input, [['value' => $group['name'], 'text' => $group['description']]]);
                    }
                }

                $inputs = array_merge($inputs, ['groups' => [
                    "id"          => "groups",
                    'name'        => 'groups[]',
                    "type"        => "select",
                    'multiple'    => true,
                    "options"      => $group_input,
                    "label"       => "Groupes : ",
                    "required"    => false,
                    "class"       => "form_input",
                    "error"       => "une erreur est survenue"
                ]]);
            }

            $form->setForm([
                "submit" => Translator::trans('admin_user_edit_form_submit'),
                "id"     => "form_edit_user",
            ]);

            $form->setInputs($inputs);

            $this->render('admin/user/edit', [
                'user' => $user,
                'form' => $form
            ], 'back');
        }

    }

    public function deleteAction(){

	    if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $user = new User();
            $user->setId($id);
            $user->setIsDeleted(1);

            $userGroups = UserGroupRepository::getUserGroups($user);
            if($userGroups) {
                foreach ($userGroups as $userGroup) {
                    $ug = new UserGroup();
                    $ug->setId($userGroup['id']);
                    $ug->setIsDeleted(1);
                    $ug->save();
                }
            }
            $user->save();
            Message::create(Translator::trans('admin_user_delete_success_title'), Translator::trans('admin_user_delete_success_message'), 'success');
            $this->redirect(Framework::getUrl('app_admin_user'));
        } else {
            Message::create(Translator::trans('error'), Translator::trans('admin_user_delete_error_message'), 'error');
            $this->redirect(Framework::getUrl('app_admin_user'));
        }

    }

    public function addAction(){

        $form = new RegisterForm();

        if(!empty($_POST)) {

            $user = new User();

            $user->setEmail($_POST["email"]);
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword(Security::passwordHash($_POST["password"]));
            $user->setCountry('fr');
            $user->setStatus(2);

            //email already exist ?
            $register = $user->find(['email' => $user->getEmail()]);

            if(!$register) {
                $save = $user->save();

                if($save) {
                    //if save get id and create group
                    if(isset($_POST['groups'])) {
                        $user = UserRepository::getUserByEmail($user);
                        foreach ($_POST['groups'] as $item) {
                            $group = GroupRepository::getGroupByName(['name' => $item]);
                            $userGroup = new UserGroup();
                            $userGroup->setUserId($user->getId());
                            $userGroup->setGroupId($group->getId());
                            $userGroup->save();
                        }
                    }
                    $this->redirect(Framework::getUrl('app_admin_user'));
                } else {
                    Message::create(Translator::trans('error'), Translator::trans('admin_user_add_undefined_error_message'), 'error');
                }
            } else {
                Message::create(Translator::trans('error'), Translator::trans('admin_user_add_email_exist_error_mesage'), 'error');
                $this->redirect(Framework::getCurrentPath());
            }

        } else {

            $form->setForm([
                "submit" => Translator::trans('admin_user_add_form_submit'),
                "id"     => "form_add_user",
                "method" => "POST",
                "action" => Framework::getCurrentPath(),
                "class"  => "form_control",
            ]);

            $group = new Group();
            $groups = $group->findAll();

            $group_input = [];
            foreach ($groups ? $groups : [] as $group) {
                $group_input = array_merge($group_input, [['value' => $group['name'], 'text' => $group['description']]]);
            }

            $form->setInputs([
                'password_confirm' => [ 'active' => false ],
                'groups' => [
                    "id"          => "groups",
                    'name'        => 'groups[]',
                    "type"        => "select",
                    'multiple'    => true,
                    "options"      => $group_input,
                    "label"       => Translator::trans('admin_user_add_form_input_group_label'),
                    "required"    => false,
                    "class"       => "form_input",
                    "error"       => Translator::trans('an_error_has_occured')
                ]
            ]);

            $this->render("admin/user/add",["form" => $form,],'back');
        }
    }

}
