<?php

namespace App\Repository;

use App\Models\Analytics;
use App\Services\Http\Router;
use App\Services\Analytics\Analytics as AnalyticsService;

class AnalyticsRepository extends Analytics {

    public static function insert() {
        $analytics = (new Analytics);
        $analytics->setClientIp(AnalyticsService::getClientIp());
        $analytics->setRoute(Router::getCurrentRoute());
        $analytics->save();
    }

}