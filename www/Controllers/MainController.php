<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\Installer;
use App\Form\Admin\Review\ReviewForm;
use App\Form\ContactForm;
use App\Repository\Review\ReviewMenuRepository;
use App\Repository\Appearance\AppearanceRepository;
use App\Repository\Review\ReviewRepository;
use App\Services\Front\Appearance;
use App\Core\Router;
use App\Core\View;
use \App\Repository\Restaurant\MenuRepository;
use \App\Repository\Restaurant\MenuMealRepository;



class MainController extends AbstractController
{

	public function defaultAction(){
	    $this->render('home', [
            'menus' => \App\Repository\Restaurant\MenuRepository::getMenus(),
            'menu_meals' => \App\Repository\Restaurant\MenuMealRepository::getMeals(),
            'reviews'=>\App\Repository\Review\ReviewRepository::getReviewByLastTen(),
        ], 'front');
	}

	//Method : Action
    //Affiche la vue 404 intégrée dans le template du front
	public function page404Action(){
	    http_response_header(404);
		$this->render("404");
	}

	//generation du sitemap a partir du fichier routes.yaml
	public function sitemapAction() {
        header("Content-Type: application/xml; charset=utf-8");

        $routes_exclude = [
            'app_login_oauth',
            'app_logout',
            'app_sitemap',
            'app_404',
            'app_css',
            'app_install',
            'app_profile',
            'app_reset_password',
            'app_change_password',
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
        Appearance::getContentType();
        echo Appearance::getStyle();
    }

}