<?php
namespace App\Core;

class Autoload
{

	public static function register() {
		
		spl_autoload_register(function ($class){

			//App\Core\Router -> App/Core/Router
			$class = str_replace("\\", "/", $class);
			//App/Core/Router -> /Core/Router

            //$class = str_ireplace(__NAMESPACE__, "", $class);
			/* old method */
            $class = str_ireplace('App/', '', $class);

            // /Core/Router -> /Core/Router.php
			$class .= ".php";
			//   /Core/Router.php -> Core/Router.php
			//$class = ltrim($class, "/");
			$class = '../' . $class;

			if(file($class)){
				include $class;
			}

		});

	}


}




