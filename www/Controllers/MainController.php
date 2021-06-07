<?php
//Parse error: syntax error, unexpected 'Global' (T_GLOBAL), expecting identifier (T_STRING) in /var/www/html/Controllers/Global.php on line 3

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\View;
use App\Core\Database;


class MainController extends AbstractController
{

	//Method : Action
	public function defaultAction(){

		$pseudo = "Prof"; // Depuis la bdd


		//$sql = new Database();

		//Affiche la vue home intégrée dans le template du front

        $this->render('home', ['pseudo' => $pseudo], 'front');

	}

	//Method : Action
	public function page404Action(){
		
		//Affiche la vue 404 intégrée dans le template du front
		$view = new View("404"); 
	}
	



}