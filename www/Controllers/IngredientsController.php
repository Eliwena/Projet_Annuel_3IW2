<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Form\Ingredients\IngredientsForm;
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
        $form = new IngredientsForm();

        $this->render("admin/addIngredients",
            ["form" => $form,]
        ,'back');
    }

    public function ingredientsDeleteAction(){
        $id = $_GET['id'];

        $ingredients = new IngredientsModel();
        $ingredients->setId($id);
        $ingredients->setIsDeleted(1);
        $ingredients->save();

        header('Location: /admin/ingredients');
    }
}