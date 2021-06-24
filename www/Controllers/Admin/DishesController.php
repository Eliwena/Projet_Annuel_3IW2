<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
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
        $this->render("admin/dishes/dishes", ['_title' => 'Liste des plats', 'dishes' => $dishes, 'ingredients' => $ingredients , 'aliments' => $aliments],'back');
    }

    public function dishesIngredientEditAction()
    {

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $dishes = new Dishes();
            $dishes->setId($id);
            $dishes = $dishes->find(['id' => $id]);


            $platIngredients = new PlatIngredient();
            $platIngredients = $platIngredients->findAll(['idPlat' => $id],null, true);

            $ingredients = new Ingredients();
            $ingredients = $ingredients->findAll([],[],true);


            $this->render("admin/dishes/dishesIngredientEdit", ['_title' => 'Editions des ingredients dans le plat', 'dishes' => $dishes,  'platIngredients' => $platIngredients , 'ingredients' => $ingredients], 'back');
        }
    }

    public function dishesIngredientDeleteAction(){
        if (isset($_GET['idAliment']) && isset($_GET['idPlat'])) {
            $idIngredient = $_GET['idAliment'];
            $idPlat = $_GET['idPlat'];

            $platIngredients = new PlatIngredient();
            $platIngredient = $platIngredients->find([ 'idAliment' => $idIngredient ,'idPlat' => $idPlat], null, true);
            $platIngredients->setId($platIngredient['id']);
            //Helpers::debug($platIngredient);
            $platIngredients->delete();
             //todo Delete la ligne avec les deux infos

            $this->redirect(Framework::getUrl('app_admin_dishes_ingredient_edit',['id' => $idPlat]));
        }

    }
        //todo Faire l'ajout d'ingredient

}