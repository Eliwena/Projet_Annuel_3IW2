<?php

namespace App\Core;

use App\Repository\DatabaseRepository;
use App\Repository\Page\PageRepository;
use App\Services\Http\Session;

class Router {

	private $slug;
	private $action;
	private $controller;
	private static $routePath = _ROUTE_PATH;
	private $listOfRoutes = [];
	private $listOfSlugs = [];

	/*	
		- On passe le slug en attribut
		- Execution de la methode loadYaml
		- Vérifie si le slug existe dans nos routes -> SINON appel la methode exception4040
		- call setController et setAction
	*/
	public function __construct($slug){

        if(strstr($slug, '?')) {
            $this->slug = substr($slug, 0, strrpos($slug, '?'));
        } else {
            $this->slug = $slug;
        }

        $this->loadYaml();

		if(empty($this->listOfRoutes[$this->slug])) {
		    $this->exception404();
		    return;
        }

		$this->setController($this->listOfRoutes[$this->slug]["controller"]);
		$this->setAction($this->listOfRoutes[$this->slug]["action"]);
    }

	/*
		$this->routePath = "routes.yml";	
		- On transforme le YAML en array que l'on stock dans listOfRoutes
		- On parcours toutes les routes
			- Si il n'y a pas de controller ou pas d'action -> die()
			- Sinon on alimente un nouveau tableau qui aura pour clé le controller et l'action
	*/
	public function loadYaml(){
	    $this->listOfRoutes = self::getListOfRoutes();
		foreach ($this->listOfRoutes as $slug => $route) {
			if(empty($route["controller"]) || empty($route["action"]))
				die("Parse YAML ERROR");
			$this->listOfSlugs[$route["controller"]][$route["action"]] = $slug;
		}
	}

	public function getSlug($controller="Main", $action="default"){
		return $this->listOfSlugs[$controller][$action];
	}

	//ucfirst = fonction upper case first : majuscule la première lettre
	public function setController($controller){
		$this->controller = ucfirst($controller);
	}

	public function setAction($action){
		$this->action = $action . "Action";
	}


	public function getController(){
		return $this->controller . 'Controller';
	}

	public function getAction(){
		return $this->action;
	}

	public function exception404(){
        http_response_code(404);
		$view = new View('404');
	}

	public static function getListOfRoutes()
    {
        $routes = yaml_parse_file(_ROUTE_PATH);
        return ConstantManager::envExist() ? DatabaseRepository::checkIftablesExist() ? self::injectPages($routes) : $routes : $routes;
    }

    private static function injectPages($list_of_routes) {
        $pages = PageRepository::getPages();
        if($pages) {
            foreach ($pages as $page) {
                $slug = \App\Services\Http\Router::formatSlug($page['slug']);
                $i = [
                    "/page/$slug" => [
                        'controller' => 'Page',
                        'action'     => 'default',
                        'name'       => "app_page_$slug"
                    ]
                ];
                $list_of_routes = array_merge_recursive($list_of_routes, $i);
            }
        }
        return $list_of_routes;
    }


}