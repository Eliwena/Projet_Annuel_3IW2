<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Helpers;
use App\Models\Ingredients;
use App\Models\Users\Group;
use App\Services\User\Security;

class AdminController extends AbstractController
{
	public function indexAction() {
        $this->render("admin/index", null,'back');
    }

    public function groupAction() {
        Security::getGroups();
    }

    public function menusAction(){
        $this->render("admin/menus", null,'back');
    }

    public function dishesAction(){
        $this->render("admin/dishes",[],'back');
    }

    public function ingredientsAction(){
        $ingredients = new Ingredients();
        $ingredients = $ingredients->findAll(['isDeleted' => false], null, true);
        $this->render("admin/ingredients", ['ingredients' => $ingredients],'back');
    }

}
