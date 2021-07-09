<?php

namespace App\Services\Analytics;

use \App\Core\Analytics as AnalyticsCore;
use App\Repository\AnalyticsRepository;

class Analytics {

    public static function getClientIp() {
        $analytics = new AnalyticsCore();
        return $analytics->getClientIp();
    }

    public static function getIpInfo($clientIp = null) {
        $analytics = new AnalyticsCore();
        if(!is_null($clientIp)) {
            $analytics->setClientIp($clientIp);
        }
        return $analytics->getIpInfo();
    }

    public static function tracker() {
        AnalyticsRepository::insert();
    }

}