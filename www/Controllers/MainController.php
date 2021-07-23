<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\Installer;
use App\Core\Router;
use App\Core\View;
use App\Form\InstallForm;
use App\Models\Restaurant\Appearance;
use App\Repository\Users\GroupRepository;
use App\Services\Analytics\Analytics;
use App\Services\Http\Cache;
use App\Services\Translator\Translator;


class MainController extends AbstractController
{

	public function defaultAction(){
	    $this->render('home', [], 'front');
	}

	//Method : Action
    //Affiche la vue 404 intégrée dans le template du front
	public function page404Action(){
		$view = new View("404");
	}

    public function contact(){
        $view = new View("contact");

    }

	//generation du sitemap a partir du fichier routes.yaml
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

    public function cssAction()
    {
        header("Content-type: text/css");
        $new = new Appearance();
        $new = $new->find(['isActive'=>1]);



        $oldVariable= [
            '--default-font-family:"Nunito","Roboto",sans-serif',
            '--blue-primary:#30475e',
            'background:#7e8a97',
            '--midgrey-color:#dcdcdc'
        ];

        $newVariable= [
            '--default-font-family:'.$new->getPolice(),
            '--blue-primary:'.$new->getColorNumber1(),
            'background:'.$new->getColorNumber2(),
            '--midgrey-color:'.$new->getBackground(),
        ];

        $config = '@import url('.$new->getLinkPolice().');';
        $config .= file_get_contents(\App\Core\Framework::getResourcesPath('styles.css' . '?' . rand()));
        $style = str_replace($oldVariable,$newVariable,$config);

        echo $style;
    }

}