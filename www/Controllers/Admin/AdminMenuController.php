<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
use App\Form\Menu\MenuPlatForm;
use App\Models\Dishes;
use App\Models\Menu;
use App\Models\MenuPlat;
use App\Models\PlatIngredient;
use App\Services\Http\Message;
use App\Services\Http\Session;
use App\Form\Menu\MenuForm;



class AdminMenuController extends AbstractController
{
    public function menuAction()
    {
        $menu = new Menu();
        $menus = $menu->findAll([], [], true);

        $menuPlat = new MenuPlat();
        $menuPlats = $menuPlat->findAll();

        $plat = new PlatIngredient();
        $plats = $plat->findAll();

        $this->render("admin/menu/menu", ['_title' => 'Liste des menus','menus' => $menus , 'menuPlats' => $menuPlats , 'plats' => $plats],'back');

    }

    public function menuAddAction(){

        $form = new MenuForm();


        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $menus = new Menu();

                $menus->setNom($_POST["nom"]);
                $menus->setPrix($_POST["prix"]);
                $save = $menus->save();

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
            $this->render("admin/menu/menuAdd", ['_title' => 'Ajout d\'un menu', "form" => $form,], 'back');
        }
    }

    public function menuDeleteAction(){
        if (isset($_GET['idMenu'])) {
            $id = $_GET['idMenu'];

            $menu = new Menu();
            $menu->setId($id);

            $menuPlats = new MenuPlat();
            $menuPlat = $menuPlats->findAll(['idMenu' => $id], [], true);

            foreach ($menuPlat as $menuPlatDelete) {
                $menuPlats->setId($menuPlatDelete['id']);
                $menuPlats->delete();
            }
            $menu->delete();

            $this->redirect(Framework::getUrl('app_admin_menu'));
        }
    }

    public function menuEditAction(){
        if (!isset($_GET['idMenu'])) {
            Message::create('Erreur de connexion', 'Attention un identifiant est requis.', 'error');
            $this->redirect(Framework::getUrl('app_admin_menu'));
        }

        $id = $_GET['idMenu'];

        $menu = new Menu();
        $menu->setId($id);
        $menu = $menu->find(['id' => $id]);

        $form = new MenuForm();
        $form->setForm([
            "submit" => "Editer un Menu",
        ]);
        $form->setInputs([
            'nom' => ['value' => $menu->getNom()],
            'prix' => ['value' => $menu->getPrix()],
        ]);

        if (!empty($_POST)) {

            $validator = FormValidator::validate($form, $_POST);

            if ($validator) {

                $menu = new Menu();

                $menu->setNom($_POST["nom"]);
                $menu->setPrix($_POST["prix"]);
                $menu->setId($id);

                $update = $menu->save();
                Helpers::debug($menu);

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
            $this->render("admin/menu/menuEdit", ['_title' => 'Edition d\'un Menu', "form" => $form,], 'back');
        }
    }

    public function menuPlatEditAction(){
        if (isset($_GET['idMenu'])) {
            $id = $_GET['idMenu'];

            $menu = new Menu();
            $menu->setId($id);
            $menu = $menu->find(['id' => $id]);

            $menuPlat = new MenuPlat();
            $menuPlat = $menuPlat->findAll(['idMenu' => $id], null, true);
            $this->render("admin/menu/menuPlatEdit", ['_title' => 'Editions des ingredients dans le plat', 'menu' => $menu, 'menuPlat' => $menuPlat], 'back');
        }
    }

    public function menuPlatDeleteAction(){
        if (isset($_GET['idPlat']) && isset($_GET['idMenu'])) {
            $idPlat = $_GET['idPlat'];
            $idMenu = $_GET['idMenu'];
            $menuPlats = new MenuPlat();
            $menuPlat = $menuPlats->find(['idPlat' => $idPlat, 'idMenu' => $idMenu], null, true);

            $menuPlats->setId($menuPlat['id']);
            //Helpers::debug($platIngredient);
            $menuPlats->delete();

            Helpers::debug($idPlat);

            $this->redirect(Framework::getUrl('app_admin_menu_plat_edit', ['idMenu' => $idMenu]));
        }
    }

    public function menuPlatAddAction(){
        if (isset($_GET['idMenu'])) {
            $idMenu = $_GET['idMenu'];


            $menus = new Menu();
            $menus->setId($idMenu);
            $menus = $menus->find(['id' => $idMenu]);

            $plat = new Dishes();
            $plats = $plat->findAll([], [], true);

            //Debut formulaire
            $form = new MenuPlatForm();

            $form->setForm([
                "submit" => "Ajouter les plats",
                //"action" => Framework::getUrl('app_admin_dishes_ingredient_edit',['idPlat' => $idPlat]),
            ]);

            //todo réduire au ingredient pas déjà existant
            $checkbox = [];

            foreach ($plats as $plat) {
                $checkbox = array_replace_recursive($checkbox, [
                    'plat[]' . $plat['id'] => [
                        "id"          => $plat['id'],
                        'name'        => $plat['nom'],
                        'value'       => $plat['id'],
                        "type"        => "checkbox",
                        "class"       => "form_input",
                        'label'       => 'ingrédient ' . $plat['nom']
                    ]
                ]);
            }

            $form->setInputs($checkbox);

            if (!empty($_POST)) {

                $validator = FormValidator::validate($form, $_POST);
                Helpers::debug($_POST);
                if ($validator) {

                    // Test parcourir le tableau recu et ajouter chaque ligne
                    foreach ($_POST['plat'] as $platform) {
                        $menuPlat = new MenuPlat();
                        $menuPlat->setIdMenu($idMenu);
                        $menuPlat->setIdPlat($platform);

                        $save = $menuPlat->save();
                        if ($save) {
                            $this->redirect(Framework::getUrl('app_admin_menu_plat_edit', ['idMenu' => $idMenu]));
                        } else {
                            Message::create('Erreur de connexion', 'Attention une erreur est survenue lors de l\'ajout d\'un ingredient.', 'error');
                            $this->redirect(Framework::getUrl('app_admin_menu_plat_edit'));
                        }
                    }
                } else {
                    //liste les erreur et les mets dans la session message.error
                    if (Session::exist('message.error')) {
                        foreach (Session::load('message.error') as $message) {
                            Message::create($message['title'], $message['message'], 'error');
                        }
                    }
                    $this->redirect(Framework::getUrl('app_admin_menu_plat_edit', ['idPlat' => $idMenu]));
                }

            } else {
                $this->render("admin/menu/menuPlatAdd", ['_title' => 'Ajout d\'un plat', "form" => $form, 'menu' => $menus], 'back');
            }
        }
    }


}