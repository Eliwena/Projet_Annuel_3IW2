<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Helpers;
use App\Services\Front\Front;

class AdminController extends AbstractController
{
	public function indexAction() {
        $this->render("admin/index", null,'back');
    }

}
