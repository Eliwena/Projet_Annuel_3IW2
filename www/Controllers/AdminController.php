<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\View;

class AdminController extends AbstractController
{
	public function indexAction() {
        $view = new View("admin/index");
    }
	
}
