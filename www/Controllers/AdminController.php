<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\View;

class AdminController extends AbstractController
{
	public function indexAction() {
        $this->render("admin/index",[],'back');
    }

    public function menusAction(){
        $this->render("admin/menus",[],'back');
    }
    public function memberAction(){
        $this->render("admin/member",[],'back');
    }

    public function dishesAction(){
        $this->render("admin/dishes",[],'back');
    }

    public function ingredientsAction(){
        $this->render("admin/ingredients",[],'back');
    }

}
