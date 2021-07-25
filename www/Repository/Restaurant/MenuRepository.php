<?php

namespace App\Repository\Restaurant;

use App\Models\Restaurant\Menu;
use App\Models\Restaurant\MenuMeal;
use App\Services\Http\Cache;

class MenuRepository extends Menu {

    const CACHE_PREFIXE = '__menu_';

    private static function map($menu) {
        if(is_array($menu)) {
            $_menu = new Menu();
            $menu = $_menu->populate($menu,false);
        }elseif(is_int($menu) || is_string($menu)) {
            $_menu = new Menu();
            $_menu->setId($menu);
            $menu = $_menu->populate(['id' => $menu], false);
        }
        return $menu;
    }

    public static function getMenus($menu = null) {
        $menus = new Menu();
        $menu = self::map($menu);

        //si page null alors findAll avec cache
        is_null($menu) ? (Cache::exist(self::CACHE_PREFIXE) ?
            $response = Cache::read(self::CACHE_PREFIXE)
            : Cache::write(self::CACHE_PREFIXE, $response = $menus->findAll(['isDeleted' => false], ['createAt' => 'DESC']))
        ) : $response = $menus->find(['id' => $menu->getId(), 'isDeleted' => false], ['createAt' => 'DESC']);

        return $response;
    }

}