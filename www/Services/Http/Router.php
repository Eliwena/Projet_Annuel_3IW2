<?php

namespace App\Services\Http;

use App\Core\Exceptions\RouterException;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\Router as CoreRouter;

class Router {

    /**
     * @return int|mixed|string
     * @throws RouterException
     * return current route
     */
    public static function getCurrentRoute() {
        $listOfRoutes = CoreRouter::getListOfRoutes();
        foreach ($listOfRoutes as $k => $i) {
            if (isset($k) and $k == (strpos($_SERVER['REQUEST_URI'], '?') ? explode('?', $_SERVER['REQUEST_URI'])[0] : $_SERVER['REQUEST_URI'])) {
                return isset($i['name']) ? $i['name'] : $k;
            }
        }
        throw new RouterException('No route matches');
    }

    /**
     * @param string $search_name
     * @return int|string|null
     * @throws RouterException
     * return route slug from route name
     */
    public static function getRoutePathFromName(string $search_name) {
        $listOfRoutes = CoreRouter::getListOfRoutes();
        foreach ($listOfRoutes as $k => $i) {
            if (isset($i['name']) and $i['name'] == $search_name) {
                return isset($k) ? $k : null;
            }
        }
        throw new RouterException('No route matches');
    }

    /**
     * @param string $search_name
     * @param array|null $params
     * @return string
     * @throws RouterException
     * create url from route name
     */
    public static function generateUrlFromName(string $search_name, array $params = null) {
        $listOfRoutes = CoreRouter::getListOfRoutes();
        foreach ($listOfRoutes as $k => $i) {
            if (isset($i['name']) and $i['name'] == $search_name) {
                //params ex : ['id' => 7, 'name' => 'anthony'] -> return ?id=7&name=anthony
                $param_str = '';
                if(isset($params)) {
                    foreach($params as $param_key => $param) {
                        //key(array_slice($params, 0, 1)) < php 7.3 sinon array_key_first > 7.3
                        $param_str .= key(array_slice($params, 0, 1)) == $param_key ? '?' : '&';
                        $param_str .= $param_key . '=' . $param;
                    }
                }
                return Framework::getBaseUrl() . $k . (isset($params) ? $param_str : '');
            }
        }
        throw new RouterException('No route matches with this name : ' . $search_name);
    }

    /**
     * @param $route_name
     * @throws RouterException
     * redirect to route name
     */
    public static function redirectToRoute($route_name) {
        header('location: ' . Framework::getUrl($route_name));
    }

    /**
     * @param $raw_slug
     * return formatted slug
     * format slug for page system
     */
    public static function formatSlug($raw_slug) {
        $slug = str_replace(' ', '-', $raw_slug);
        $slug = str_replace('\'', '', $slug);
        $slug = str_replace('?', '', $slug);
        $slug = str_replace('&', '', $slug);
        $slug = str_replace('/', '', $slug);
        $slug = str_replace('@', '', $slug);
        return $slug;
    }

}