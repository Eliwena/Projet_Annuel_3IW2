<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Helpers;
use App\Core\View;
use App\Models\User as UserModel;

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

    public function dishesAction(){
        $this->render("admin/dishes",[],'back');
    }

    public function ingredientsAction(){
        $this->render("admin/ingredients",[],'back');
    }

}
