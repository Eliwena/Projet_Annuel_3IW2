<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Services\Http\Message;
use App\Services\User\Security;

class AdminController extends AbstractController
{
    public function __construct() {
        parent::__construct();
        if(!Security::isConnected() && Security::hasPermissions('admin_panel_dashboard')) {
            Message::create('Attention', 'Merci de vous connecter pour accéder au panel.');
            $this->redirect(Framework::getUrl('app_login'));
        }
    }

	public function indexAction() {
        $this->render("admin/index", null,'back');
    }

}
