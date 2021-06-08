<?php

namespace App\Controller;

use App\Core\AbstractController;

class IngredientsController extends AbstractController
{
    public function ingredientsAction(){
        $this->render("admin/ingredients",[],'back');
    }

    public function ingredientsAddAction(){
        echo "ajout ingredien ! ";

        $this->render("admin/addIngredients",[
            [],
        ],'back');
    }
}