<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Helpers;
use App\Core\View;
use App\Core\FormValidator;
use App\Form\User\LoginForm;
use App\Form\User\RegisterForm;
use App\Models\User as UserModel;
use App\Models\Page;
use App\Services\Http\Session;

class UserController extends AbstractController
{

	//Method : Action
	public function defaultAction(){
		echo "User default";
	}


	//Method : Action
	public function registerAction(){}
		
		/*
			$user->setFirstname("Yves");
			$user->setLastname("SKRZYPCZYK");
			$user->setEmail("y.skrzypczyk@gmail.com");
			$user->setPwd("Test1234");
			$user->setCountry("fr");

			$user->save();



			$page = new Page();
			$page->setTitle("Nous contacter");
			$page->setSlug("/contact");
			$page->save();



			$user = new User();
			$user->setId(2); //Attention on doit populate
			$user->setFirstname("Toto");
			$user->save();

		*/


		/****$user = new UserModel();
        $form = new RegisterForm();

		if(!empty($_POST)){
			
			$errors = FormValidator::check($form, $_POST);

			if(empty($errors)){

                $user = new UserModel();

                /*$user->setEmail('testa');
                $user->setFirstname('test');
                $user->setLastname('test');
                $user->setPwd('test');
                $user->setCountry('fr');

                $user->save();*/

/****

				$user->setFirstname($_POST["firstname"]);
				$user->setLastname($_POST["lastname"]);
				$user->setEmail($_POST["email"]);
				$user->setPwd($_POST["pwd"]);
				$user->setCountry($_POST["country"]);

				$user->save();
			}else{
			    die($errors);
				//$view->assign(["errors" => $errors]);
			}
		}

        $this->render("register", [
            "form" => $form,
            "formLogin" => $user->formBuilderLogin()
        ]);
	}
*/

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
	    
	    $user = new UserModel();

        $data = $user->find(['id' => 1, 'isDeleted' => 0], ['id' => 'ASC'], true);

        Helpers::debug($data);

        $this->render("users", [
            'test' => 0,
            'test2' => 1,
        ]);

	}
	
}
