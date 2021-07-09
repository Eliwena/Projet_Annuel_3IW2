<?php

namespace App\Core;

use ErrorException;
use \App\Services\Http\Router as RouterService;

class Framework {

    protected $slug;
    protected $route;

    public function __construct() {
        $this->slug = mb_strtolower($_SERVER["REQUEST_URI"]);
        $this->route = new Router($this->slug);
    }

    public function run() {
       new ConstantManager();

        set_error_handler(function($errno, $errstr, $errfile, $errline ){
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        });

        if(!Installer::checkInstall()) {
           //TODO generate installation form here
        }

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

    // renvoi http://localhost
    public static function getBaseUrl() {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
    }

    public static function getUrl(string $route_name = null, array $params = null) {
        return is_null($route_name) ? null : RouterService::generateUrlFromName($route_name, $params);
    }

    // renvoi l'url actuel
    public static function getCurrentPath() {
        return self::getBaseUrl() . $_SERVER['REQUEST_URI'];
    }

    // si on envoi un fichier en parametre alors le renvoi en path et si / devant l'url le supprime
    public static function getResourcesPath($resources = null) {
        return is_null($resources) ? self::getBaseUrl() . '/Resources/' : self::getBaseUrl() . '/Resources/' . (substr( $resources, 0, 1 ) === "/" ? ltrim($resources, '/') : $resources);
    }

}