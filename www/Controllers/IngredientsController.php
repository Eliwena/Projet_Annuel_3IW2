<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Form\Ingredients\IngredientsForm;
use App\Models\Ingredients;
use App\Models\Ingredients as IngredientsModel;
use App\Services\Http\Message;
use App\Services\User\Security;


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

        if(!empty($_POST)) {
            $ingredients = new Ingredients();

            $ingredients->setNom($_POST["nom"]);
            $ingredients->setPrix($_POST["prix"]);
            $ingredients->setActiveCommande($_POST["active"]);

                $save = $ingredients->save();
                if($save) {
                    $this->redirect(Framework::getBaseUrl() . '/admin/ingredients');
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                }

        } else {

            $this->render("admin/addIngredients",
                ["form" => $form,]
                , 'back');
        }
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