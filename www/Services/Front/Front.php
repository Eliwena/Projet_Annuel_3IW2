<?php

namespace App\Services\Front;

use App\Core\Framework;
use App\Core\Helpers;
use App\Repository\WebsiteConfigurationRepository;

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

    public static function getGoogleAnalyticsJS() {
        $google_analytics_id = WebsiteConfigurationRepository::getGoogleAnalyticsKey();
        if($google_analytics_id) {
            return "<!-- Google Analytics --><script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', ".$google_analytics_id.", 'auto');ga('send', 'pageview');</script><!-- End Google Analytics -->";
        }
        return '';
    }

}