<?php

namespace App\Controller\Admin\Restaurant;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Admin\Meal\MealFoodstuffForm;
use App\Form\Admin\Menu\MenuForm;
use App\Models\Restaurant\Foodstuff;
use App\Models\Restaurant\Meal;
use App\Models\Restaurant\MealFoodstuff;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Services\User\Security;

class AdminMealController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        if(!Security::isConnected()) {
            Message::create($this->trans('error'), $this->trans('you_need_to_be_connected'));
            $this->redirect(Framework::getUrl('app_login'));
        }
    }

    public function indexAction()
    {
        $this->isGranted('admin_panel_meal_list');

        $meal = new Meal();
        $meals = $meal->findAll(['isDeleted' => false]);

        $mealFoodstuff = new MealFoodstuff();
        $mealFoodstuffs = $mealFoodstuff->findAll();

        $this->render("admin/meal/list", ['_title' => 'Liste des plats', 'meals' => $meals, 'mealFoodstuffs' => $mealFoodstuffs], 'back');
    }

    public function addAction()
    {
        $this->isGranted('admin_panel_meal_add');

        $form = new MenuForm();

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $meal = new Meal();
                $meal->setName($_POST["name"]);
                $meal->setPrice($_POST["price"]);
                $save = $meal->save();

                if ($save) {
                    $this->redirect(Framework::getUrl('app_admin_meal'));
                } else {
                    Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un aliment.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_meal_add'));
                }

            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_meal_add'));
            }

        } else {
            $this->render("admin/meal/add", ['_title' => 'Ajout d\'un plat', "form" => $form,], 'back');
        }
    }

    public function deleteAction()
    {
        $this->isGranted('admin_panel_meal_delete');

        if (isset($_GET['mealId'])) {
            $id = $_GET['mealId'];

            $meal = new Meal();
            $meal->setId($id);

            $mealFoodstuff = new MealFoodstuff();
            $mealFoodstuff_data = $mealFoodstuff->findAll(['mealId' => $id]);

            if($mealFoodstuff_data != null) {
                //suppression des element dans les plats
                foreach ($mealFoodstuff_data as $item) {
                    $mealFoodstuff->setId($item['id']);
                    $mealFoodstuff->delete();
                }
            }

            $meal->delete();

            $this->redirect(Framework::getUrl('app_admin_meal'));
        }
    }

    public function editAction()
    {
        $this->isGranted('admin_panel_meal_edit');

        if (!isset($_GET['mealId'])) {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_meal'));
        }

        $id = $_GET['mealId'];

        $meal = new Meal();
        $meal = $meal->find(['id' => $id, 'isDeleted' => false]);

        $form = new MenuForm();
        $form->setForm(['submit' => 'Editer un Plat']);
        $form->setInputs([
            'name'  => ['value' => $meal->getName()],
            'price' => ['value' => $meal->getPrice()],
        ]);

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $meal = new Meal();

                $meal->setId($id);
                $meal->setName($_POST['name']);
                $meal->setPrice($_POST['price']);

                $update = $meal->save();

                if ($update) {
                    Message::create('Update', 'mise à jour effectué avec succès.', 'success');
                    $this->redirect(Framework::getUrl('app_admin_meal'));
                } else {
                    Message::create('Erreur de mise à jour', 'Attention une erreur est survenue lors de la mise à jour.', 'error');
                    $this->redirect(Framework::getUrl('app_admin_meal_edit'));
                }

            } else {
                //liste les erreur et les mets dans la session message.error
                if (Session::exist('message.error')) {
                    foreach (Session::load('message.error') as $message) {
                        Message::create($message['title'], $message['message'], 'error');
                    }
                }
                $this->redirect(Framework::getUrl('app_admin_meal_edit'));
            }

        } else {
            $this->render("admin/meal/edit", ['_title' => 'Edition d\'un plat', "form" => $form,], 'back');
        }

    }

    public function foodstuffEditAction()
    {
        $this->isGranted('admin_panel_meal_edit');

        if (isset($_GET['mealId'])) {
            $id = $_GET['mealId'];

            $meal = new Meal();
            $meal->setId($id);
            $meal = $meal->find(['id' => $id, 'isDeleted' => false]);

            $mealFoodstuff = new MealFoodstuff();
            $mealFoodstuffs = $mealFoodstuff->findAll(['mealId' => $id]);

            $foodstuff = new Foodstuff();
            $foodstuffs = $foodstuff->findAll(['isDeleted' => false]);

            $this->render("admin/meal/foodstuffEdit", ['_title' => 'Editions des ingredients dans le plat', 'meal' => $meal, 'mealFoodstuffs' => $mealFoodstuffs, 'foodstuffs' => $foodstuffs], 'back');
        }
    }

    public function foodstuffDeleteAction()
    {
        $this->isGranted('admin_panel_meal_delete');

        if (isset($_GET['foodstuffId']) && isset($_GET['mealId'])) {

            $foodstuffId = $_GET['foodstuffId'];
            $mealId = $_GET['mealId'];

            $mealFoodstuff = new MealFoodstuff();
            $mealFoodstuff_data = $mealFoodstuff->find(['foodstuffId' => $foodstuffId, 'mealId' => $mealId]);

            $mealFoodstuff->setId($mealFoodstuff_data->getId());
            $mealFoodstuff->delete();

            $this->redirect(Framework::getUrl('app_admin_meal_foodstuff_edit', ['mealId' => $mealId]));
        }

    }

    public function foodstuffAddAction()
    {
        $this->isGranted('admin_panel_meal_add');

        if (isset($_GET['mealId'])) {
            $mealId = $_GET['mealId'];

            $meal = new Meal();
            $meal->setId($mealId);
            $meal = $meal->find(['id' => $mealId, 'isDeleted' => false]);

            $foodstuff = new Foodstuff();
            $foodstuffs = $foodstuff->findAll();

            //Debut formulaire
            $form = new MealFoodstuffForm();

            $form->setForm([
                "submit" => "Ajouter les Ingredients",
            ]);

            //todo réduire au ingredient pas déjà existant
            $checkbox = [];

            foreach ($foodstuffs as $item) {
                $checkbox = array_replace_recursive($checkbox, [
                    'foodstuff[]' . $item['id'] => [
                        "id"          => $item['id'],
                        'name'        => $item['name'],
                        'value'       => $item['id'],
                        "type"        => "checkbox",
                        "class"       => "form_checkbox",
                        'label'       => 'ingrédient :' . $item['name']
                    ]
                ]);
            }

            $form->setInputs($checkbox);

            if (!empty($_POST)) {

                $validator = true;

                if ($validator) {

                    // Test parcourir le tableau recu et ajouter chaque ligne
                    foreach ($_POST['foodstuff'] as $foodstuff_data) {
                        $foodstuff = new MealFoodstuff();
                        $foodstuff->setMealId($mealId);
                        $foodstuff->setFoodstuffId($foodstuff_data);

                        $save = $foodstuff->save();
                        if ($save) {
                            $this->redirect(Framework::getUrl('app_admin_meal_foodstuff_edit', ['mealId' => $mealId]));
                        } else {
                            Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                            $this->redirect(Framework::getUrl('app_admin_meal_foodstuff_edit', ['mealId' => $mealId]));
                        }
                    }
                } else {
                    //liste les erreur et les mets dans la session message.error
                    if (Session::exist('message.error')) {
                        foreach (Session::load('message.error') as $message) {
                            Message::create($message['title'], $message['message'], 'error');
                        }
                    }
                    $this->redirect(Framework::getUrl('app_admin_meal_foodstuff_edit', ['mealId' => $mealId]));
                }

            } else {
                $this->render("admin/meal/foodstuffAdd", ['_title' => 'Ajout d\'ingredient', "form" => $form, 'mealId' => $mealId, 'meal' => $meal], 'back');
            }
        }
    }

}