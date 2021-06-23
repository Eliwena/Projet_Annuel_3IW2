<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Models\Dishes;
use App\Models\Ingredients;
use App\Models\PlatIngredient;

class DishesController extends AbstractController
{
    public function dishesAction(){

        $dishe = new Dishes();
        $dishes = $dishe->findAll([],[],true);
        $ingredient = new PlatIngredient();
        $ingredients = $ingredient->findAll([],[],true);
        $aliment = new Ingredients();
        $aliments = $aliment->findAll([],[],true);
        $this->render("admin/dishes/dishes", ['_title' => 'Liste des plats', 'dishes' => $dishes, 'ingredients' => $ingredients , 'aliments' => $aliments],'back');    }

}