<?php

namespace App\Controller;

use App\Core\AbstractController;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\Installer;
use App\Form\Admin\Review\ReviewForm;
use App\Form\ContactForm;
use App\Models\Restaurant\Menu;
use App\Repository\Review\ReviewMenuRepository;
use App\Repository\Appearance\AppearanceRepository;
use App\Repository\Review\ReviewRepository;
use App\Services\Front\Appearance;
use App\Core\Router;
use App\Core\View;
use \App\Repository\Restaurant\MenuRepository;
use \App\Repository\Restaurant\MenuMealRepository;



class MenuController extends AbstractController
{

    public function menusAction()
    {
        $this->render('menus', [
            'menus' => MenuRepository::getMenus(),
            'menu_meals' => MenuMealRepository::getMeals(),
        ], 'front');
    }

    public function menuAction()
    {
        if (isset($_GET['menuId'])) {
            $form = new ReviewForm();
            $form->setForm(['action' => Framework::getUrl('app_review_add')]);


            $menu = MenuRepository::getMenus($_GET['menuId']);

            if ($menu) {
                $form->setInputs(['menuId' => ['type' => 'hidden', 'required' => 'true', 'value' => $menu->getId()]]);
                $menuMeals = MenuMealRepository::getMealsByMenuId($menu);
                $menuReviews = ReviewMenuRepository::getReviewMenus(null, $menu);
                $this->render('menu', compact('menu', 'menuMeals', 'menuReviews', 'form'), 'front');
            } else {
                //exist pas
            }
        }
    }
}