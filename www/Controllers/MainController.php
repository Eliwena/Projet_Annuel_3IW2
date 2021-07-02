<?php
//Parse error: syntax error, unexpected 'Global' (T_GLOBAL), expecting identifier (T_STRING) in /var/www/html/Controllers/Global.php on line 3

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\View;
use App\Core\Database;
use App\Services\User\Security;


class MainController extends AbstractController
{

	//Method : Action
	public function defaultAction(){

        if(Security::hasGroups('SUPER_ADMIN')) {
            echo 'Bonjour vous etes admin<br/>';
        }

        if(!isset($num)){
            $this->render('home', [], "front0");
        } else {
            $this->render('home', [], "front" . $num );
        }

	}

	//Method : Action
	public function page404Action(){
		
		//Affiche la vue 404 intégrée dans le template du front
		$view = new View("404"); 
	}
	



}