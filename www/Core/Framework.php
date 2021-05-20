<?php

namespace App\Core;


class Framework {

    protected $slug;
    protected $route;

    public function __construct() {
        $this->slug = mb_strtolower($_SERVER["REQUEST_URI"]);
        $this->route = new Router($this->slug);
    }

    public function run() {

        new ConstantManager();

        $route = new Router($this->slug);

        $c = $route->getController();
        $a = $route->getAction();

        if( file_exists("./Controllers/".$c.".php") ){

            include "./Controllers/".$c.".php";

            $c = "App\\Controller\\".$c;

            if( class_exists($c)){

                $cObject = new $c(); // new App\User
                if(method_exists($cObject, $a)){
                    $cObject->$a();
                }else{
                    die("Error la methode n'existe pas !!!");
                }
            }else{
                die("Error la classe n'existe pas!!!");
            }
        }else{
            die("Error le fichier controller n'existe pas !!!");
        }
    }

    // renvoi http://localhost
    public static function getUrl() {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
    }

    // renvoi l'url actuel
    public static function getCurrentPath() {
        return self::getUrl() . $_SERVER['REQUEST_URI'];
    }

    // si on envoi un fichier en parametre alors le renvoi en path et si / devant l'url le supprime
    public static function getResourcesPath($resources = null) {
        return is_null($resources) ? self::getUrl() . '/Resources/' : self::getUrl() . '/Resources/' . (substr( $resources, 0, 1 ) === "/" ? ltrim($resources, '/') : $resources);
    }

}