<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;


class AdminMenuController extends AbstractController
{
    public function menuAction()
    {
        $this->render("admin/menu/menu", ['_title' => 'Liste des menus'],'back');

    }

}