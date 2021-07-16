<?php

namespace App\Repository\Page;

use App\Models\Page\Page;
use App\Services\Http\Cache;
use App\Services\Http\Router;

class PageRepository extends Page {

    const CACHE_PREFIXE = '__page_';

    private static function map($page) {
        if(is_array($page)) {
            $_page = new Page();
            $page = $_page->populate($page,false);
        }elseif(is_int($page) || is_string($page)) {
            $_page = new Page();
            $_page->setId($page);
            $page = $_page->populate(['id' => $page], false);
        }
        return $page;
    }

    public static function getPages($page = null) {
        $pages = new Page();
        $page = self::map($page);

        //si page null alors findAll avec cache
        is_null($page) ? (Cache::exist(self::CACHE_PREFIXE) ?
            $response = Cache::read(self::CACHE_PREFIXE)
            : Cache::write(self::CACHE_PREFIXE, $response = $pages->findAll(['isDeleted' => false], ['createAt' => 'DESC']))
        ) : $response = $pages->find(['id' => $page->getId(), 'isDeleted' => false], ['createAt' => 'DESC']);

        return $response;
    }

    public static function getPageBySlug($page_slug) {
        $pages = new Page();
        $page = self::map($page_slug);

        //si page null alors findAll avec cache
        Cache::exist(self::CACHE_PREFIXE.$page->getSlug()) ?
            $response =
                Cache::read(self::CACHE_PREFIXE.$page->getSlug()) :
            Cache::write(self::CACHE_PREFIXE.$page->getSlug(), $response = $pages->find(['slug' => $page->getSlug(), 'isDeleted' => false], ['createAt' => 'DESC']));

        return $response;
    }

}