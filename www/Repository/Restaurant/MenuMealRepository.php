<?php

namespace App\Repository\Restaurant;

use App\Models\Restaurant\Menu;
use App\Models\Restaurant\MenuMeal;
use App\Services\Http\Cache;

class MenuMealRepository extends MenuMeal {

    const CACHE_PREFIXE = '__menu_';

    private static function map($menu_meal) {
        if(is_array($menu_meal)) {
            $_menu_meal = new MenuMeal();
            $menu_meal = $_menu_meal->populate($menu_meal,false);
        }elseif(is_int($menu_meal) || is_string($menu_meal)) {
            $_menu_meal = new MenuMeal();
            $_menu_meal->setId($menu_meal);
            $menu_meal = $_menu_meal->populate(['id' => $menu_meal], false);
        }
        return $menu_meal;
    }

    public static function getMeals($meal = null) {
        $menu_meals = new MenuMeal();
        $menu_meal = self::map($meal);

        //si page null alors findAll avec cache
        is_null($meal) ? (Cache::exist(self::CACHE_PREFIXE) ?
            $response = Cache::read(self::CACHE_PREFIXE)
            : Cache::write(self::CACHE_PREFIXE, $response = $menu_meals->findAll(['isDeleted' => false], ['createAt' => 'DESC']))
        ) : $response = $menu_meals->find(['id' => $menu_meal->getId(), 'isDeleted' => false], ['createAt' => 'DESC']);

        return $response;
    }

}