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

    public static function debug($data) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public static function error($message) {
        echo '<style>.framework-error-message{background-color: #fce4e4;border: 1px solid #fcc2c3;padding: 20px 30px;}</style><div class="framework-error-message"><span class="error-text">Erreur : '.$message.'</span></div>';
        die();
    }

}