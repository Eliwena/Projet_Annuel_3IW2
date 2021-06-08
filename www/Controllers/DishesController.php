<?php

namespace App\Controller;

use App\Core\AbstractController;

class DishesController extends AbstractController
{
    public function dishesAction(){
        $this->render("admin/dishes",[],'back');
    }

}