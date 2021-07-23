<?php

namespace App\Core;

use App\Services\Http\Session;
use ErrorException;
use \App\Services\Http\Router as RouterService;

class Framework {

    /**
     * @var string
     */
    protected $slug;

    /**
     * @var Router
     */
    protected $route;

    public function __construct() {
        new ConstantManager();
        $this->slug = mb_strtolower($_SERVER["REQUEST_URI"]);
        $this->route = new Router($this->slug);
    }

    /**
     * @throws ErrorException
     */
    public function run() {

        set_error_handler(function($errno, $errstr, $errfile, $errline ){
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        });

        Installer::checkInstall();

        $c = $this->route->getController();
        $a = $this->route->getAction();

        if( file_exists("../Controllers/". $c .".php") ){

            include "../Controllers/". $c .".php";

            $c = "App\\Controller\\" . str_replace('/', '\\', $c);

            if( class_exists($c)){

                $cObject = new $c(); // new App\User
                if(method_exists($cObject, $a)){
                    $cObject->$a();
                }else{
                    Helpers::error("Error la methode n'existe pas !!!");
                }
            }else{
                Helpers::error("Error la classe n'existe pas!!!");
            }
        }else{
            Helpers::error("Error le fichier controller n'existe pas !!!");
        }
    }

    /**
     * @return string
     * return website base url
     */
    public static function getBaseUrl() {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
    }

    /**
     * @param string|null $route_name
     * @param array|null $params
     * @return string|null
     * @throws Exceptions\RouterException
     * return url in routes.yml from route_name parameter
     */
    public static function getUrl(string $route_name = null, array $params = null) {
        return is_null($route_name) ? null : RouterService::generateUrlFromName($route_name, $params);
    }

    /**
     * @return string
     * return current route url
     */
    public static function getCurrentPath() {
        return self::getBaseUrl() . $_SERVER['REQUEST_URI'];
    }

    /**
     * @param null $resources
     * @return string
     * return absolut resource path and if $resources return path with res
     */
    public static function getResourcesPath($resources = null) {
        return is_null($resources) ? self::getBaseUrl() . '/Resources/' : self::getBaseUrl() . '/Resources/' . (substr( $resources, 0, 1 ) === "/" ? ltrim($resources, '/') : $resources);
    }

}