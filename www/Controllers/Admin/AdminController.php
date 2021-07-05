<?php

namespace App\Controller\Admin;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Services\Front\Front;
use App\Services\Http\Message;
use App\Services\User\Security;

class AdminController extends AbstractController
{
    public function __construct() {
        if(!Security::isConnected()) {
            Message::create('Attention', 'Merci de vous connecter pour accéder au panel.');
            $this->redirect(Framework::getUrl('app_login'));
        }
    }

	public function indexAction() {
        if(!Security::hasPermissions('admin_access')) {
            Message::create('Erreur', 'Accès restreint');
            $this->redirect(Framework::getUrl('app_home'));
        }
        $this->render("admin/index", null,'back');
    }

}
