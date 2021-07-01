<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\FormValidator;
use App\Core\Framework;
use App\Core\Helpers;
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

}