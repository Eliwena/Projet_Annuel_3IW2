<?php

namespace App\Core;

class AbstractController {

    public function render($view, $options = [], $template = null) {
        $view = new View($view);
        $view->assign($options);
        is_null($template) ? $view->setTemplate("front") : $view->setTemplate($template);
    }

}