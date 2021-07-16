<?php

namespace App\Controller\Admin\Restaurant;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Menu\MenuForm;
use App\Form\Admin\Menu\MenuMealForm;
use App\Models\Restaurant\Meal;
use App\Models\Restaurant\MealFoodstuff;
use App\Models\Restaurant\Menu;
use App\Models\Restaurant\MenuMeal;
use App\Services\Http\Message;
use App\Services\Http\Session;

class AdminMenuController extends AbstractController
{
    public function indexAction()
    {
        $menu  = new Menu();
        $menus = $menu->findAll();

        $menuMeal  = new MenuMeal();
        $menuMeals = $menuMeal->findAll();

        $mealFoodstuff  = new MealFoodstuff();
        $mealFoodstuffs = $mealFoodstuff->findAll();

        $this->render("admin/menu/list", ['_title' => 'Liste des menus','menus' => $menus , 'menuMeals' => $menuMeals , 'mealFoodstuffs' => $mealFoodstuffs],'back');

    }

    public function addAction(){

        $form = new MenuForm();

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $menu = new Menu();

                $menu->setName($_POST['name']);
                $menu->setPrice($_POST['price']);
                $save = $menu->save();

                if ($save) {
                    $this->redirect(Framework::getUrl('app_admin_menu'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_menu_add'));
                }

            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_menu_add'));
            }

        } else {
            $this->render("admin/menu/add", ['_title' => 'Ajout d\'un menu', "form" => $form,], 'back');
        }
    }

    public function deleteAction(){
        if (isset($_GET['menuId'])) {
            $id = $_GET['menuId'];

            $menu = new Menu();
            $menu->setId($id);

            $menuMeal  = new MenuMeal();
            $menuMeals = $menuMeal->findAll(['menuId' => $menu->getId()]);
            if($menuMeals != null) {
                foreach ($menuMeals as $item) {
                    $menuMeal->setId($item['id']);
                    $menuMeal->delete();
                }
            }
            $menu->delete();

            $this->redirect(Framework::getUrl('app_admin_menu'));
        }
    }

    public function editAction(){
        if (!isset($_GET['menuId'])) {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_menu'));
        }

        $id = $_GET['menuId'];

        $menu = new Menu();
        $menu->setId($id);
        $menu = $menu->find(['id' => $id]);

        $form = new MenuForm();
        $form->setForm([
            "submit" => "Editer un Menu",
        ]);
        $form->setInputs([
            'name' => ['value' => $menu->getName()],
            'price' => ['value' => $menu->getPrice()],
        ]);

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $menu = new Menu();

                $menu->setName($_POST["name"]);
                $menu->setPrice($_POST["price"]);
                $menu->setId($id);

                $update = $menu->save();

                if ($update) {
                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_menu'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_menu_edit'));
                }
            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_menu_edit'));
            }

        } else {
            $this->render("admin/menu/edit", ['_title' => 'Edition d\'un Menu', "form" => $form,], 'back');
        }
    }

    public function mealEditAction(){
        if (isset($_GET['menuId'])) {
            $id = $_GET['menuId'];

            $menu = new Menu();
            $menu->setId($id);
            $menu = $menu->find(['id' => $id]);

            $menuMeal = new MenuMeal();
            $menuMeals = $menuMeal->findAll(['menuId' => $id]);
            $this->render("admin/menu/mealEdit", ['_title' => 'Editions des ingredients dans le plat', 'menu' => $menu, 'menuMeals' => $menuMeals], 'back');
        }
    }

    public function mealDeleteAction(){
        if (isset($_GET['mealId']) && isset($_GET['mealId'])) {
            $mealId = $_GET['mealId'];
            $menuId = $_GET['menuId'];
            $menuMeal = new MenuMeal();
            $menuMeals = $menuMeal->find(['mealId' => $mealId, 'menuId' => $menuId]);

            $menuMeal->setId($menuMeals->getId());
            $menuMeal->delete();

            $this->redirect(Framework::getUrl('app_admin_menu_meal_edit', ['menuId' => $menuId]));
        }
    }

    public function mealAddAction(){

        if (isset($_GET['menuId'])) {
            $menuId = $_GET['menuId'];

            $menu = new Menu();
            $menu->setId($menuId);
            $menu = $menu->find(['id' => $menuId]);

            $meal = new Meal();
            $meals = $meal->findAll();

            //Debut formulaire
            $form = new MenuMealForm();

            $form->setForm([
                "submit" => "Ajouter les plats",
            ]);

            //todo réduire au ingredient pas déjà existant
            $checkbox = [];

            foreach ($meals as $item) {
                $checkbox = array_replace_recursive($checkbox, [
                    'meal[]' . $item['id'] => [
                        "id"          => $item['id'],
                        'name'        => $item['name'],
                        'value'       => $item['id'],
                        "type"        => "checkbox",
                        "class"       => "form_checkbox",
                        'label'       => 'plat : ' . $item['name']
                    ]
                ]);
            }

            $form->setInputs($checkbox);

            if (!empty($_POST)) {

                $validator = true;

                if ($validator) {

                    // Test parcourir le tableau recu et ajouter chaque ligne
                    foreach ($_POST['meal'] as $platform) {

                        $menuMeal = new MenuMeal();
                        $menuMeal->setMenuId($menuId);
                        $menuMeal->setMealId($platform);

                        $save = $menuMeal->save();
                        if ($save) {
                            $this->redirect(Framework::getUrl('app_admin_menu_meal_edit', ['menuId' => $menuId]));
                        } else {
                            Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                            $this->redirect(Framework::getUrl('app_admin_menu_meal_edit'));
                        }
                    }
                } else {
                    //liste les erreur et les mets dans la session message.error
                    if (Session::exist('message.error')) {
                        foreach (Session::load('message.error') as $message) {
                            Message::create($message['title'], $message['message'], 'error');
                        }
                    }
                    $this->redirect(Framework::getUrl('app_admin_menu_meal_edit', ['menuId' => $menuId]));
                }

            } else {
                $this->render("admin/menu/mealAdd", ['_title' => 'Ajout d\'un plat', "form" => $form, 'menu' => $menu], 'back');
            }
        } else {
            Message::create('Erreur', 'aucun identifiant menu indiqué', 'error');
            $this->redirect(Framework::getUrl('app_admin_menu'));
        }
    }


}