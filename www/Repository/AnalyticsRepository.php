<?php

namespace App\Repository;

use App\Core\Helpers;
use App\Models\Analytics;
use App\Services\Http\Cache;
use App\Services\Http\Router;
use App\Services\Analytics\Analytics as AnalyticsService;

class AnalyticsRepository extends Analytics {

    const CACHE_PREFIXE = '__analytics_';

    /**
     * @throws \App\Core\Exceptions\RouterException
     * insert new visitor in table
     */
    public static function insert() {
        $analytics = new Analytics();
        $analytics->setClientIp(AnalyticsService::getClientIp());
        $analytics->setRoute(Router::getCurrentRoute());
        $analytics->save();
    }

    /**
     * @return mixed|null
     * return visit of the day
     */
    public static function getTodayVisit() {
        if(Cache::exist(self::CACHE_PREFIXE.'_visit_today')) {
            return Cache::read(self::CACHE_PREFIXE.'_visit_today')['today_visit'];
        } else {
            $analytics = new Analytics();
            $query = 'SELECT COUNT(DISTINCT `clientIp`) AS `today_visit` FROM ' . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = CURDATE()";
            Cache::write(self::CACHE_PREFIXE.'_visit_today', $data = $analytics->execute($query));
            return $data['today_visit'] ?? null;
        }
    }

    /**
     * @return false|mixed|string|null
     * return weekly visit
     */
    public static function getWeekVisit() {
        if(Cache::exist(self::CACHE_PREFIXE.'_week_visit')) {
            return Cache::read(self::CACHE_PREFIXE.'_week_visit');
        } else {
            $analytics = new Analytics();
            $query = "SELECT 
                (SELECT COUNT(DISTINCT `clientIp`) FROM " . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = CURDATE()) AS `today_visit`,
                (SELECT COUNT(DISTINCT `clientIp`) FROM " . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL -1 DAY)) AS `previous_day_visit`,
                (SELECT COUNT(DISTINCT `clientIp`) FROM " . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL -2 DAY)) AS `previous_two_day`,
                (SELECT COUNT(DISTINCT `clientIp`) FROM " . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL -3 DAY)) AS `previous_three_day`,
                (SELECT COUNT(DISTINCT `clientIp`) FROM " . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL -4 DAY)) AS `previous_fourth_day`,
                (SELECT COUNT(DISTINCT `clientIp`) FROM " . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL -5 DAY)) AS `previous_fifth_day`,
                (SELECT COUNT(DISTINCT `clientIp`) FROM " . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL -6 DAY)) AS `previous_six_day`,
                (SELECT COUNT(DISTINCT `clientIp`) FROM " . $analytics->getTableName() . " WHERE DATE_FORMAT(createAt, '%Y-%m-%d') = DATE_ADD(CURDATE(), INTERVAL -7 DAY)) AS `previous_seven_day`
                    FROM " . $analytics->getTableName() . " LIMIT 1";
            Cache::write(self::CACHE_PREFIXE.'_week_visit', $data = $analytics->execute($query));
            return $data ?? null;
        }
    }

    /**
     * @return mixed|null
     * return visit of yesterday
     */
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