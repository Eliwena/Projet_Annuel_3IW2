<?php

namespace App\Controller\Admin\User;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\User\RegisterForm;
use App\Models\Users\Group;
use App\Models\Users\User;
use App\Models\Users\UserGroup;
use App\Services\Front\Front;
use App\Services\Http\Message;
use App\Services\User\Security;

class AdminUserController extends AbstractController
{

    public function indexAction(){
        $users = new User();
        $users = $users->findAll(['isDeleted' => false]);
        $this->render("admin/user/list", ['users' => $users], 'back');
    }

    public function editAction() {
        $id = $_GET['id'];

        $user = new User();
        $user->setId($id);
        $user = $user->find(['id' => $id]);

        $form = new RegisterForm();

        $form->setForm([
            "submit" => "Editer le membre",
            "id"     => "form_edit_user",
            "action" => Framework::getUrl('app_admin_user_edit', ['id' => $user->getId()]),
        ]);

        $form->setInputs([
            'password' => ['required' => 0],
            'email' => ['required' => false, 'value' => $user->getEmail()],
            'firstname' => ['required' => false, 'value' => $user->getFirstname()],
            'lastname' => ['required' => false, 'value' => $user->getLastname()],
            'password_confirm' => ['active' => false]
        ]);

        if(!empty($_POST)) {
            $user = new User();

            if(isset($_POST['email']) && !empty($_POST['email'])) {
                $user->setEmail($_POST["email"]);
            }
            if(isset($_POST['firstname']) && !empty($_POST['firstname'])) {
                $user->setFirstname($_POST["firstname"]);
            }
            if(isset($_POST['lastname']) && !empty($_POST['lastname'])) {
                $user->setLastname($_POST["lastname"]);
            }
            if(isset($_POST['pwd']) && !empty($_POST['pwd'])) {
                $user->setPassword(Security::passwordHash($_POST["password"]));
            }

            $user->setId($id);
            $update = $user->save();
            if($update) {
                Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                $this->redirect(Framework::getUrl('app_admin_user'));
            } else {
               Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
               $this->redirect(Framework::getUrl('app_admin_user'));
            }

        } else {
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

            $userGroup = new UserGroup();
            $userGroups = $userGroup->findAll(['userId' => $id]);
            if($userGroups) {
                foreach ($userGroups as $userGroup) {
                    $i = new UserGroup();
                    $i->setId($userGroup['id']);
                    $i->setIsDeleted(1);
                }
            }
            $user->save();
            Message::create('Succès', 'Suppression bien effectué.', 'success');
            $this->redirect(Framework::getUrl('app_admin_user'));
        } else {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_user'));
        }

    }

    public function addAction(){

        $form = new RegisterForm(); // TODO Ajouter les role et enlever mdp
        $form->setForm([
            "submit" => "Enregistrer le membre",
            "id" => "form_add_user",
            "method" => "POST",
            "action" => Framework::getCurrentPath(),
            "class" => "form_control",
        ]);

        $group = new Group();
        $groups = $group->findAll();

        $group_input = [];
        foreach ($groups as $group) {
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
                "label"       => "Groupes : ",
                "required"    => false,
                "class"       => "form_input",
                "error"       => "une erreur est survenue"
            ]
        ]);

        if(!empty($_POST)) {
            $user = new User();

            $user->setEmail($_POST["email"]);
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPassword(Security::passwordHash($_POST["password"]));
            $user->setCountry('fr');
            $user->setStatus(1);

            //email exist ?
            $register = $user->find(['email' => $user->getEmail()], null, true);

            if(!$register) {
                $save = $user->save();

                if($save) {
                    //if save get id and create group
                    if(isset($_POST['groups'])) {
                        $userId = new User();
                        $userId = $userId->find(['email' => $user->getEmail()]);
                        foreach ($_POST['groups'] as $item) {
                            $group = new Group();
                            $group = $group->find(['name' => $item]);
                            $userGroup = new UserGroup();
                            $userGroup->setUserId($userId->getId());
                            $userGroup->setGroupId($group->getId());
                            $userGroup->save();
                        }
                    }

                    $this->redirect(Framework::getUrl('app_admin_user'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'inscription.', 'error');
                }
            } else {
                Message::create('Attention', 'L\'email utiliser existe déjà.', 'error');
                $this->redirect(Framework::getUrl('app_admin_user_add'));
            }

        } else {
            $this->render("admin/user/add",[
                "form" => $form,
            ],'');
        }


	}

}
