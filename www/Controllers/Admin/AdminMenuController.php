<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Helpers;
use App\Models\Dishes;
use App\Models\Menu;
use App\Models\MenuPlat;
use App\Models\PlatIngredient;


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

}