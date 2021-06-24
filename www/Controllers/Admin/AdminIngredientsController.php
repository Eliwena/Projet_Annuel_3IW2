<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Form\Ingredients\IngredientsForm;
use App\Models\Ingredients;
use App\Services\Http\Message;
use App\Services\Http\Session;


class AdminIngredientsController extends AbstractController
{
    public function ingredientsAction(){

        $ingredients = new Ingredients();
        $ingredients = $ingredients->findAll([],[],true);
        $this->render("admin/ingredients/ingredients", ['_title' => 'Liste des ingredients', 'ingredients' => $ingredients],'back');
    }

    public function ingredientsAddAction() {
        $form = new IngredientsForm();

        if(!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if($validator) {

                $ingredient = new Ingredients();

                $ingredient->setNom($_POST["nom"]);
                $ingredient->setPrix($_POST["prix"]);
                $ingredient->setStock($_POST['stock']);
                $ingredient->setActiveCommande($_POST["activeCommande"]);
                $save = $ingredient->save();

                if($save) {
                    $this->redirect(Framework::getUrl('app_admin_ingredients'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_ingredients_add'));
                }

            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_ingredients_add'));
            }

        } else {
            $this->render("admin/ingredients/addIngredients", ['_title' => 'Ajout d\'ingredient', "form" => $form,], 'back');
        }
    }

    public function ingredientsEditAction() {

        if(!isset($_GET['id'])) {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_ingredients'));
        }

        $id = $_GET['id'];

        $ingredient = new Ingredients();
        $ingredient->setId($id);
        $ingredient = $ingredient->find(['id' => $id]);

        $form = new IngredientsForm();
        $form->setForm([
            "submit" => "Editer un ingrédient",
            "action" => Framework::getUrl('app_admin_ingredients_edit', ['id' => $ingredient->getId()]),
        ]);
        $form->setInputs([
            'nom' => ['value' => $ingredient->getNom()],
            'prix' => ['value' => $ingredient->getPrix()],
            'stock' => ['value' => $ingredient->getStock()],
            'activeCommande' => ['options' => [
                //recherche dans le tableau inputs->activecommands->option l'index de l'element en table sur la column value ensuite on envoi dans cette index une valeur selected a true pour le selectionner
                array_search($ingredient->getActiveCommande(), array_column($form->getInputs()['activeCommande']['options'], 'value')) => [
                    'selected' => true
                ]
            ]],
        ]);

        if(!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if($validator) {

                $ingredient = new Ingredients();

                $ingredient->setNom($_POST["nom"]);
                $ingredient->setPrix($_POST["prix"]);
                $ingredient->setStock($_POST['stock']);
                $ingredient->setActiveCommande($_POST["activeCommande"]);

                $ingredient->setId($id);
                $update = $ingredient->save();

                if($update) {
                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_ingredients'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_ingredients_edit'));
                }
            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_ingredients_edit'));
            }

        } else {
            $this->render("admin/ingredients/EditIngredients", ['_title' => 'Edition d\'un ingredient', "form" => $form,], 'back');
        }
    }

    public function ingredientsDeleteAction(){
        if(isset($_GET['id'])) { //TODO ajouter isDelete en database
            $id = $_GET['id'];

            $ingredient = new Ingredients();
            $ingredient->setId($id);
            $ingredient->setIsDeleted(1);
            $ingredient->save();

            Message::create('Succès', 'Suppression bien effectué.', 'success');
            $this->redirect(Framework::getUrl('app_admin_ingredients'));
        } else {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_ingredients'));
        }
    }
}