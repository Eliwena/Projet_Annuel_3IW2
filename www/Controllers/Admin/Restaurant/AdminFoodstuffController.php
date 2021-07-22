<?php

namespace App\Controller\Admin\Restaurant;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Foodstuff\FoodstuffForm;
use App\Models\Restaurant\Foodstuff;
use App\Services\Http\Message;
use App\Services\Http\Session;


class AdminFoodstuffController extends AbstractController
{
    public function indexAction(){
        $foodstuff = new Foodstuff();
        $foodstuff = $foodstuff->findAll(['isDeleted' => 0]);
        $this->render("admin/foodstuff/list", ['_title' => 'Liste des ingredients', 'foodstuffs' => $foodstuff],'back');
    }

    public function addAction() {
        $form = new FoodstuffForm();

        if(!empty($_POST)) {

            //$validator = FormValidator::validate($form, $_POST);

            if(true) {

                $foodstuff = new Foodstuff();

                $foodstuff->setName($_POST["name"]);
                $foodstuff->setPrice($_POST["price"]);
                $foodstuff->setStock($_POST['stock']);
                $foodstuff->setIsActive($_POST['isActive'] == '1' ? true : false);

                $save = $foodstuff->save();

                if($save) {
                    $this->redirect(Framework::getUrl('app_admin_foodstuff'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_foodstuff_add'));
                }

            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_foodstuff_add'));
            }

        } else {
            $this->render("admin/foodstuff/add", ['_title' => 'Ajout d\'ingredient', "form" => $form,], 'back');
        }
    }

    public function editAction() { //todo fix update

        if(!isset($_GET['id'])) {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_foodstuff'));
        }

        $id = $_GET['id'];

        $foodstuff = new Foodstuff();
        $foodstuff->setId($id);
        $foodstuff = $foodstuff->find(['id' => $id]);

        $form = new FoodstuffForm();
        $form->setForm([
            "submit" => "Editer un ingrédient",
            "action" => Framework::getUrl('app_admin_foodstuff_edit', ['id' => $foodstuff->getId()]),
        ]);
        $form->setInputs([
            'name' => ['value' => $foodstuff->getName()],
            'price' => ['value' => $foodstuff->getPrice()],
            'stock' => ['value' => $foodstuff->getStock()],
            'isActive' => ['options' => [
                //recherche dans le tableau inputs->activecommands->option l'index de l'element en table sur la column value ensuite on envoi dans cette index une valeur selected a true pour le selectionner
                array_search($foodstuff->getIsActive(), array_column($form->getInputs()['isActive']['options'], 'value')) => [
                    'selected' => true
                ]
            ]],
        ]);

        if(!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if($validator) {

                $foodstuff = new Foodstuff();

                $foodstuff->setName($_POST["name"]);
                $foodstuff->setPrice($_POST["price"]);
                $foodstuff->setStock($_POST['stock']);
                $foodstuff->setIsActive($_POST["isActive"]);//todo active update not work

                $foodstuff->setId($id);
                $update = $foodstuff->save();

                if($update) {
                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_foodstuff'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_foodstuff_edit', ['id' => $foodstuff->getId()]));
                }
            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_foodstuff_edit', ['id' => $foodstuff->getId()]));
            }

        } else {
            $this->render("admin/foodstuff/edit", ['_title' => 'Edition d\'un ingredient', "form" => $form,], 'back');
        }
    }

    public function deleteAction(){
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $foodstuff = new Foodstuff();
            $foodstuff->setId($id);
            $foodstuff->setIsDeleted(1);
            $foodstuff->save();

            Message::create('Succès', 'Suppression bien effectué.', 'success');
            $this->redirect(Framework::getUrl('app_admin_foodstuff'));
        } else {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_foodstuff'));
        }
    }
}