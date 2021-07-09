<?php

namespace App\Core;

use App\Models\Users\User;
use App\Services\Analytics\Analytics;
use App\Services\User\Security;

abstract class AbstractController {

    protected $translate;

    public function __construct()  {
        Analytics::tracker();
    }

    public function render($view, $options = [], $template = null) {
        $view = new View($view);
        $view->assign($options);
        Security::isConnected() ? $view->assign(['_user' => Security::getUser()]) : $view->assign(['_user' => null]);
        //$view->assign(['user' => $this->getUser()]);
        is_null($template) ? $view->setTemplate("front") : $view->setTemplate($template);
    }

    public function redirect($path) {
        header('location: ' . $path);
    }

    public function getUser() {
        $security = Security::getUser();
        $user = new User();
        $user->populate($security);
        return $user;
    }

    public function trans($key) {
        $translator = new Translator();
        return $translator->trans($key);
    }

}