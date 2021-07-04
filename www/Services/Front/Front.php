<?php

namespace App\Services\Front;

use App\Core\Framework;
use App\Core\Helpers;

class Front {

    /**
     * Check route path and return true if current route contain base route url
     * @param string $route_path
     * @return bool
     */
    public static function isSidebarActive($route_path) {
        $route_path_exploded = explode('/', $route_path);
        $current_path_exploded = explode('/', Framework::getCurrentPath());
        if(isset($route_path_exploded[4]) && isset($current_path_exploded[4]) && $route_path_exploded[4] == $current_path_exploded[4]) {
           return true;
        } elseif($route_path == Framework::getCurrentPath()) {
            return true;
        }
        return false;
    }

}