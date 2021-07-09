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

    public static function date($date, $format = 'd/m/Y') {
        $dateTime = new \DateTime($date);
        return $dateTime->format($format);
    }

    public static function generateStars($stars_number = 0) {
        $response = '';
        for ($i=1; $i<=$stars_number;$i++) {
            $response .= '<i class="fas fa-star"></i>';
         }
         for ($i=5-$stars_number; $i>0;$i--) {
             $response .= '<i class="far fa-star"></i>';
         }
         return $response;
    }

}