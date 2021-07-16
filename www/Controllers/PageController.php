<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\Installer;
use App\Core\Router;
use App\Core\View;
use App\Form\InstallForm;
use App\Repository\Page\PageRepository;
use App\Repository\Users\GroupRepository;
use App\Repository\WebsiteConfigurationRepository;
use App\Services\Analytics\Analytics;
use App\Services\Http\Cache;
use App\Services\Translator\Translator;


class PageController extends AbstractController
{
	public function defaultAction(){
	    //explode page request
	    $explode_uri = explode('page', $_SERVER['REQUEST_URI'], 2);
	    //trim explode and remove first slash
	    $page_slug = ltrim(end($explode_uri), '/');
	    //search page by slug and get Page object
        $page = PageRepository::getPageBySlug(['slug' => $page_slug]);

        $this->render('page', [
            'title' => WebsiteConfigurationRepository::getSiteName() . ' - ' . $page->getName(),
            'page' => $page
        ]);
	}
}