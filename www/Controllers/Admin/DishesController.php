<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Models\Dishes;
use App\Models\Ingredients;
use App\Models\PlatIngredient;
use App\Form\Dishes\PlatIngredientForm;
use App\Services\Http\Message;
use App\Services\Http\Session;

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

        if (isset($_GET['idPlat'])) {
            $id = $_GET['idPlat'];

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

            $this->redirect(Framework::getUrl('app_admin_dishes_ingredient_edit',['idPlat' => $idPlat]));
        }

    }

    public function dishesIngredientAddAction()
    {

        if ( isset($_GET['idPlat'])) {
            $idPlat = $_GET['idPlat'];


            $dishes = new Dishes();
            $dishes->setId($idPlat);
            $dishes = $dishes->find(['id' => $idPlat]);

            $ingredient = new Ingredients();
            $ingredients = $ingredient->findAll([], [], true);

            //Debut formulaire
            $form = new PlatIngredientForm();

            $form->setForm([
                "submit" => "Ajouter les Ingredients",
                //"action" => Framework::getUrl('app_admin_dishes_ingredient_edit',['idPlat' => $idPlat]),
            ]);

            //Test ajout checkbox
            foreach ($ingredients as $ingredient) {
                $form->setInputs([
                    'nom[]' => ['value' => $ingredient['id'],'id' => $ingredient['id'],'label'=>$ingredient['nom'],'name'=>$ingredient['nom']],
                ]);
            }

            if (!empty($_POST)) {

                $validator = FormValidator::validate($form, $_POST);

                if ($validator) {

                    // Test parcourir le tableau recu et ajouter chaque ligne
                    foreach($_POST['nom'] as $ingredientform) {
                        $ingredient = new PlatIngredient();
                        $ingredient->setIdPlat($idPlat);
                        $ingredient->setIdAliment($ingredientform);

                        $save = $ingredient->save();
                        if ($save) {
                            $this->redirect(Framework::getUrl('app_admin_dishes_ingredient_edit', ['idPlat' => $idPlat]));
                        } else {
                            Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                            $this->redirect(Framework::getUrl('app_admin_dishes_ingredient_edit'));
                        }
                    }
                } else {
                    //liste les erreur et les mets dans la session message.error
                    if (Session::exist('message.error')) {
                        foreach (Session::load('message.error') as $message) {
                            Message::create($message['title'], $message['message'], 'error');
                        }
                    }
                   $this->redirect(Framework::getUrl('app_admin_dishes_ingredient_edit',['idPlat' => $idPlat]));
                }

            } else {
                $this->render("admin/dishes/dishesIngredientAdd", ['_title' => 'Ajout d\'ingredient', "form" => $form,'idPlat' => $idPlat , 'dishes'=> $dishes], 'back');
            }
        }
    }
        //todo Faire l'ajout d'ingredient

    }