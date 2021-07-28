<?php

namespace App\Services\Analytics;

use \App\Core\Analytics as AnalyticsCore;
use App\Repository\AnalyticsRepository;

class Analytics {

    /**
     * @return string
     * return visitor ip
     */
    public static function getClientIp() {
        $analytics = new AnalyticsCore();
        return $analytics->getClientIp();
    }

    /**
     * @param null $clientIp
     * @return false|mixed|string
     * call ipinfo.io and insert return data
     */
    public static function getIpInfo($clientIp = null) {
        $analytics = new AnalyticsCore();
        if(!is_null($clientIp)) {
            $analytics->setClientIp($clientIp);
        }
        return $analytics->getIpInfo();
    }

    /**
     * insert new row in analytics table in database with visitor ip and date
     */
    public static function tracker() {
        AnalyticsRepository::insert();
    }

}