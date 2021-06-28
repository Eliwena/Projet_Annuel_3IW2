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
use App\Form\Dishes\DishesForm;
use App\Services\Http\Message;
use App\Services\Http\Session;

class AdminDishesController extends AbstractController
{
    public function dishesAction()
    {

        $dishe = new Dishes();
        $dishes = $dishe->findAll([], [], true);
        $ingredient = new PlatIngredient();
        $ingredients = $ingredient->findAll([], [], true);
        $aliment = new Ingredients();
        $aliments = $aliment->findAll([], [], true);
        $this->render("admin/dishes/dishes", ['_title' => 'Liste des plats', 'dishes' => $dishes, 'ingredients' => $ingredients, 'aliments' => $aliments], 'back');
    }

    public function dishesAddAction()
    {
        $form = new DishesForm();


        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $dishes = new Dishes();

                $dishes->setNom($_POST["nom"]);
                $dishes->setPrix($_POST["prix"]);
                $save = $dishes->save();

                if ($save) {
                    $this->redirect(Framework::getUrl('app_admin_dishes'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_dishes_add'));
                }

            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_dishes_add'));
            }

        } else {
            $this->render("admin/dishes/dishesAdd", ['_title' => 'Ajout d\'un plat', "form" => $form,], 'back');
        }
    }

    public function dishesDeleteAction()
    {
        if (isset($_GET['idPlat'])) {
            $id = $_GET['idPlat'];

            $dishes = new Dishes();
            $dishes->setId($id);

            $platingredients = new PlatIngredient();
            $platingredient = $platingredients->findAll(['idPlat' => $id], [], true);

            foreach ($platingredient as $platingredientdelete) {
                $platingredients->setId($platingredientdelete['id']);
                $platingredients->delete();
            }
            $dishes->delete();

            $this->redirect(Framework::getUrl('app_admin_dishes'));
        }
    }

    public function dishesEditAction()
    {
        if (!isset($_GET['idPlat'])) {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_dishes'));
        }

        $id = $_GET['idPlat'];

        $dishe = new Dishes();
        $dishe->setId($id);
        $dishe = $dishe->find(['id' => $id]);

        $form = new DishesForm();
        $form->setForm([
            "submit" => "Editer un Plat",
        ]);
        $form->setInputs([
            'nom' => ['value' => $dishe->getNom()],
            'prix' => ['value' => $dishe->getPrix()],
        ]);

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $dishe = new Dishes();

                $dishe->setNom($_POST["nom"]);
                $dishe->setPrix($_POST["prix"]);
                $dishe->setId($id);

                $update = $dishe->save();
                Helpers::debug($dishe);

                if ($update) {
                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_dishes'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_dishes_edit'));
                }
            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_dishes_edit'));
            }

        } else {
            $this->render("admin/dishes/dishesEdit", ['_title' => 'Edition d\'un plat', "form" => $form,], 'back');
        }

    }

    public function dishesIngredientEditAction()
    {

        if (isset($_GET['idPlat'])) {
            $id = $_GET['idPlat'];

            $dishes = new Dishes();
            $dishes->setId($id);
            $dishes = $dishes->find(['id' => $id]);

            $platIngredients = new PlatIngredient();
            $platIngredients = $platIngredients->findAll(['idPlat' => $id], null, true);

            $ingredients = new Ingredients();
            $ingredients = $ingredients->findAll([], [], true);


            $this->render("admin/dishes/dishesIngredientEdit", ['_title' => 'Editions des ingredients dans le plat', 'dishes' => $dishes, 'platIngredients' => $platIngredients, 'ingredients' => $ingredients], 'back');
        }
    }

    public function dishesIngredientDeleteAction()
    {
        if (isset($_GET['idAliment']) && isset($_GET['idPlat'])) {
            $idIngredient = $_GET['idAliment'];
            $idPlat = $_GET['idPlat'];

            $platIngredients = new PlatIngredient();
            $platIngredient = $platIngredients->find(['idAliment' => $idIngredient, 'idPlat' => $idPlat], null, true);
            $platIngredients->setId($platIngredient['id']);
            //Helpers::debug($platIngredient);
            $platIngredients->delete();
            //todo Delete la ligne avec les deux infos

            $this->redirect(Framework::getUrl('app_admin_dishes_ingredient_edit', ['idPlat' => $idPlat]));
        }

    }

    public function dishesIngredientAddAction()
    {

        if (isset($_GET['idPlat'])) {
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

            $checkbox = [];

            foreach ($ingredients as $ingredient) {
                $checkbox = array_replace_recursive($checkbox, [
                    'ingredient_' . $ingredient['id'] => [
                        "id"          => $ingredient['id'],
                        'name'        => $ingredient['nom'],
                        'value'       => $ingredient['id'],
                        "type"        => "checkbox",
                        "class"       => "form_input",
                        'label'       => 'ingrédient ' . $ingredient['nom']
                    ]
                ]);
            }

            $form->setInputs($checkbox);

            if (!empty($_POST)) {

                $validator = FormValidator::validate($form, $_POST);

                if ($validator) {

                    // Test parcourir le tableau recu et ajouter chaque ligne
                    foreach ($_POST['nom'] as $ingredientform) {
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
                    $this->redirect(Framework::getUrl('app_admin_dishes_ingredient_edit', ['idPlat' => $idPlat]));
                }

            } else {
                $this->render("admin/dishes/dishesIngredientAdd", ['_title' => 'Ajout d\'ingredient', "form" => $form, 'idPlat' => $idPlat, 'dishes' => $dishes], 'back');
            }
        }
    }
    //todo Faire l'ajout d'ingredient

}