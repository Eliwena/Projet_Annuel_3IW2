<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\View;
use App\Form\User\RegisterForm;
use App\Models\User as UserModel;
use App\Services\Http\Message;
use App\Services\User\Security;

class AdminController extends AbstractController
{
	public function indexAction() {
        $this->render("admin/index",[],'back');
    }

    public function menusAction(){
        $this->render("admin/menus",[],'back');
    }

    public function memberAction(){

        $user = new UserModel();

        $users = $user->findAll([],[],true);

            $this->render("admin/member", [
                'users' => $users
            ], 'back');

    }

    public function memberDeleteAction(){
	    $id = $_GET['id'];

	    $users = new UserModel();
        $users->setId($id);
        $users->setIsDeleted(1);
        $users->save();

        header('Location: /admin/member');
    }

    public function memberAddAction(){

        $form = new RegisterForm(); // TODO Ajouter les role et enlever mdp
        $form->setForm(["submit"=>"Enregistrer le membre",
            "id"=>"form_addMember",
            "method"=>"POST",
            "action"=>"",
            "class"=>"form_control",
            ]);

        if(!empty($_POST)) {
            $user = new UserModel();

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
                    $this->redirect(Framework::getUrl() . '/admin/member');
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'inscription.', 'error');
                }
            } else {
                Message::create('Attention', 'L\'email utiliser existe déjà.', 'error');
                $this->render("admin/addMember",[
                    "form" => $form,
                ],'back');
            }

        } else {
            $this->render("admin/addMember",[
                "form" => $form,
            ],'back');
        }


	}

    public function dishesAction(){
        $this->render("admin/dishes",[],'back');
    }

    public function ingredientsAction(){
        $this->render("admin/ingredients",[],'back');
    }

}
