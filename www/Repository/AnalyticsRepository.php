<?php

namespace App\Repository;

use App\Core\Helpers;
use App\Models\Analytics;
use App\Services\Http\Cache;
use App\Services\Http\Router;
use App\Services\Analytics\Analytics as AnalyticsService;

class AnalyticsRepository extends Analytics {

    const CACHE_PREFIXE = '__analytics_';

    public static function insert() {
        $analytics = new Analytics();
        $analytics->setClientIp(AnalyticsService::getClientIp());
        $analytics->setRoute(Router::getCurrentRoute());
        $analytics->save();
    }

    public static function getTodayVisit() {
        if(Cache::exist(self::CACHE_PREFIXE.'_visit_today')) {
            return Cache::read(self::CACHE_PREFIXE.'_visit_today')['today_visit'];
        } else {
            $analytics = new Analytics();
            $query = 'SELECT COUNT(DISTINCT `clientIp`) AS `today_visit` FROM ' . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = CURDATE()";
            Cache::write(self::CACHE_PREFIXE.'_visit_today', $data = $analytics->execute($query));
            Helpers::debug($data);
            return $data['today_visit'] ?? null;
        }
    }

    public static function getPreviousDayVisit() {

        if(Cache::exist(self::CACHE_PREFIXE.'_previousday_visit')) {
            return Cache::read(self::CACHE_PREFIXE.'_previousday_visit')['previous_day_visit'];
        } else {
            $analytics = new Analytics();
            $query = "SELECT COUNT(DISTINCT `clientIp`) AS `previous_day_visit` FROM "  . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = CURDATE() - INTERVAL 1 DAY";
            Cache::write(self::CACHE_PREFIXE.'_previousday_visit', $data = $analytics->execute($query));
            return $data['previous_day_visit'] ?? null;
        }
    }

}