<?php

namespace App\Controller\Users;

use App\Core\AbstractController;
use App\Core\Helpers;
use App\Core\View;
use App\Core\FormValidator;
use App\Form\User\LoginForm;
use App\Form\User\RegisterForm;
use App\Models\Users\User;
use App\Models\Page;
use App\Services\Http\Session;

class UserController extends AbstractController
{

	//Method : Action
	public function defaultAction(){
		echo "User default";
	}


	//Method : Action
	public function addAction(){
		
		//Récupérer le formulaire
		//Récupérer les valeurs de l'internaute si il y a validation du formulaire
		//Vérification des champs (uncitié de l'email, complexité du pwd, ...)
		//Affichage du résultat

	}

	//Method : Action
	public function showAction(){
		
		//Affiche la vue user intégrée dans le template du front
		$view = new View("user");
	}



	//Method : Action
	public function showAllAction() {

	    $user = new User();

        $data = $user->find(['id' => 1, 'isDeleted' => 0], ['id' => 'ASC'], true);

        Helpers::debug($data);

        $this->render("users", [
            'test' => 0,
            'test2' => 1,
        ]);

	}
	
}
