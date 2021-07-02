<?php
//Parse error: syntax error, unexpected 'Global' (T_GLOBAL), expecting identifier (T_STRING) in /var/www/html/Controllers/Global.php on line 3

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\Router;
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

        $this->render('home', [], 'front');

	}

	//Method : Action
	public function page404Action(){
		
		//Affiche la vue 404 intégrée dans le template du front
		$view = new View("404"); 
	}

	public function sitemapAction() {
        header("Content-Type: application/xml; charset=utf-8");

        $routes_exclude = [
           'app_login_oauth',
           'app_logout',
           'app_sitemap',
       ];

	   $routes = Router::getListOfRoutes();


	   $sitemap_content = '';
	   foreach ($routes as $route_params) {
            if(!in_array($route_params['name'], $routes_exclude) && !strpos($route_params['name'], 'admin')) {
                $sitemap_content .= '<url>' . PHP_EOL;
                $sitemap_content .= '<loc>' . Framework::getUrl($route_params['name']) . '</loc>' . PHP_EOL;
                $sitemap_content .= '<changefreq>daily</changefreq>' . PHP_EOL;
                $sitemap_content .= '</url>' . PHP_EOL;
            }
       }

        echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
        echo $sitemap_content;
        echo '</urlset>' . PHP_EOL;



    }
	



}