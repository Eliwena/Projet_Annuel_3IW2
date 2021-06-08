<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Models\Ingredients as IngredientsModel;


class IngredientsController extends AbstractController
{
    public function ingredientsAction(){

        $ingredients = new IngredientsModel();
        $ingredient = $ingredients->findAll([],[],true);
        $this->render("admin/ingredients",
            ['ingredient' => $ingredient]
        ,'back');
    }

    public function ingredientsAddAction(){
        echo "ajout ingredien ! ";

        $this->render("admin/addIngredients",[
            [],
        ],'back');
    }
}