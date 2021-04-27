<?php

namespace App\Controller;

use App\Core\View;

class Admin
{
	public function indexAction() {
        $view = new View("admin/index");
    }
	
}
