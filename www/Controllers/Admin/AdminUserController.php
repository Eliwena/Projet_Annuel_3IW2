<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Form\User\RegisterForm;
use App\Models\Users\User;
use App\Services\Http\Message;
use App\Services\User\Security;

class AdminUserController extends AbstractController
{

    public function memberAction(){
        $users = new User();
        $users = $users->findAll(['isDeleted' => false], null, true);
        $this->render("admin/member/member", ['users' => $users], 'back');
    }

    public function memberEditAction() {
        $id = $_GET['id'];

        $user = new User();
        $user->setId($id);
        $user = $user->find(['id' => $id]);

        $form = new RegisterForm();

        $form->setForm([
            "submit" => "Editer le membre",
            "id"     => "form_EditMember",
            "action" => Framework::getUrl('app_admin_member_edit', ['id' => $user->getId()]),
        ]);

        $form->setInputs([
            'pwd' => ['required' => 0],
            'email' => ['required' => false, 'value' => $user->getEmail()],
            'firstname' => ['required' => false, 'value' => $user->getFirstname()],
            'lastname' => ['required' => false, 'value' => $user->getLastname()],
            'pwdConfirm' => ['active' => false]
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
                $user->setPwd(Security::passwordHash($_POST["pwd"]));
            }

            $user->setId($id);
            $update = $user->save();
            if($update) {
                Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                $this->redirect(Framework::getUrl('app_admin_member'));
            } else {
               Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
               $this->redirect(Framework::getUrl('app_admin_member'));
            }

        } else {
            $this->render("admin/member/editMember", [
                'user' => $user,
                'form' => $form
            ], 'back');
        }


    }

    public function memberDeleteAction(){

	    if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $user = new User();
            $user->setId($id);
            $user->setIsDeleted(1);
            $user->save();
            Message::create('Succès', 'Suppression bien effectué.', 'success');
            $this->redirect(Framework::getUrl('app_admin_member'));
        } else {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_member'));
        }

    }

    public function memberAddAction(){

        $form = new RegisterForm(); // TODO Ajouter les role et enlever mdp
        $form->setForm([
            "submit" => "Enregistrer le membre",
            "id" => "form_addMember",
            "method" => "POST",
            "action" => Framework::getCurrentPath(),
            "class" => "form_control",
        ]);
        $form->setInputs([
           "pwdConfirm" => [ 'active' => false ]
        ]);


        if(!empty($_POST)) {
            $user = new User();

            $user->setEmail($_POST["email"]);
            $user->setFirstname($_POST["firstname"]);
            $user->setLastname($_POST["lastname"]);
            $user->setEmail($_POST["email"]);
            $user->setPwd(Security::passwordHash($_POST["pwd"]));
            //$user->setCreateAt(date('Y-m-d H:i:s', 'now'));
            $user->setCountry('fr');
            $user->setRole(1);          //TODO Ajouter un ROLE
            $user->setStatus(1);

            //email exist ?
            $register = $user->find(['email' => $user->getEmail()], null, true);

            if($register == false) {
                $save = $user->save();
                if($save) {
                    $this->redirect(Framework::getUrl('app_admin_member'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'inscription.', 'error');
                }
            } else {
                Message::create('Attention', 'L\'email utiliser existe déjà.', 'error');
                $this->redirect(Framework::getUrl('app_admin_member_add'));
            }

        } else {
            $this->render("admin/member/addMember",[
                "form" => $form,
            ],'back');
        }


	}

}
