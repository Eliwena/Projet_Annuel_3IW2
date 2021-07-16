<?php

namespace App\Controller\Admin\Appearance;

use App\Core\AbstractController;
use App\Models\Restaurant\Appearance;


class AppearanceController extends AbstractController
{

    public function indexAction(){

        $appearance = new Appearance();
        $appearances = $appearance->findAll();

        $this->render("admin/appearance/list", ['_title' => 'Liste des apparence', 'appearances' => $appearances], 'back');

    }

}