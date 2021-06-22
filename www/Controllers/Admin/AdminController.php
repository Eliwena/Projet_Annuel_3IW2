<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\User\RegisterForm;
use App\Models\User as UserModel;
use App\Services\Http\Message;
use App\Services\User\Security;

class AdminController extends AbstractController
{
	public function indexAction() {
        $this->render("admin/index", null,'back');
    }

    public function menusAction(){
        $this->render("admin/menus", null,'back');
    }

    public function dishesAction(){
        $this->render("admin/dishes",[],'back');
    }

    public function ingredientsAction(){
        $this->render("admin/ingredients",[],'back');
    }

}
