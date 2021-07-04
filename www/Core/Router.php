<?php

namespace App\Core;

use App\Core\Exceptions\RouterException;

class Router{

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
        }else{
            $this->slug = $slug;
        }
		$this->loadYaml();

		if(empty($this->listOfRoutes[$this->slug])) $this->exception404();

		/*
			$this->listOfRoutes
								["/liste-des-utilisateurs"]
								["controller"]

		*/
		$this->setController($this->listOfRoutes[$this->slug]["controller"]);
		$this->setAction($this->listOfRoutes[$this->slug]["action"]);
		//Helpers::debug($this->getController());
		//Helpers::debug($this->getAction());

    }


	/*
		$this->routePath = "routes.yml";	
		- On transforme le YAML en array que l'on stock dans listOfRoutes
		- On parcours toutes les routes
			- Si il n'y a pas de controller ou pas d'action -> die()
			- Sinon on alimente un nouveau tableau qui aura pour clé le controller et l'action
	*/
	public function loadYaml(){
		$this->listOfRoutes = yaml_parse_file(self::$routePath);
		foreach ($this->listOfRoutes as $slug=>$route) {
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
		$this->action = $action."Action";
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

	public static function getListOfRoutes() {
	    return yaml_parse_file(self::$routePath);
    }

	public static function generateUrlFromName(string $search_name, array $params = null) {
        $listOfRoutes = self::getListOfRoutes();
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

}