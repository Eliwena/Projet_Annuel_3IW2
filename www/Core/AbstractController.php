<?php

namespace App\Core;

use App\Models\Users\User;
use App\Services\Analytics\Analytics;
use App\Services\Http\Message;
use App\Services\Translator\Translator;
use App\Services\User\Security;
use \App\Services\Http\Router;

abstract class AbstractController {

    protected $translate;

    public function __construct()  {
        if(ConstantManager::envExist()) {
            Analytics::tracker();
        }
    }

    public function render($view, $options = [], $template = null) {
        $view = new View($view);
        $view->assign($options);
        is_null($template) ? $view->setTemplate("front") : $view->setTemplate($template);
    }

    public function jsonResponse(array $response, $status = 'success') {
        header('Content-Type: application/json');
        $res = [
            'status' => $status,
            'code' => http_response_code(),
        ];
        echo json_encode(array_merge($res, $response));
        return null;
    }

    public function redirect($path) {
        header('location: ' . $path);
    }

    protected function redirectToRoute($route_name) {
        Router::redirectToRoute($route_name);
    }

    public function getUser() {
        return Security::getUser();
    }

    public function trans($key) {
        $translator = new Translator();
        return $translator->trans($key);
    }

    protected function isGranted($permission_name) {
        if(!Security::hasPermissions($permission_name)) {
            Message::create($this->trans('error'), $this->trans('access_denied_message'));
            if(Security::hasPermissions('admin_panel_dashboard')) {
                $this->redirectToRoute('app_admin');
            } else {
                $this->redirectToRoute('app_home');
            }
        }
        return;
    }

}