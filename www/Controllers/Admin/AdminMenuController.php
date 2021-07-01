<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Helpers;
use App\Models\Menu;
use App\Models\MenuPlat;


class AdminMenuController extends AbstractController
{
    public function menuAction()
    {
        $menu = new Menu();
        $menus = $menu->findAll([], [], true);
        $menuPlat = new MenuPlat();
        $menuPlats = $menuPlat->findAll([], [], true);
        $this->render("admin/menu/menu", ['_title' => 'Liste des menus','menus' => $menus , 'menuPlats' => $menuPlats],'back');

    }

}