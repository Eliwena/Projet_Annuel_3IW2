<?php

namespace App\Repository\Appearance;

use App\Models\Restaurant\Appearance;
use App\Services\Http\Cache;

class AppearanceRepository extends Appearance {

    const CACHE_PREFIXE = '__appearance_';

    private static function map($appearance) {
        if(is_array($appearance)) {
            $_appearance = new Appearance();
            $appearance = $_appearance->populate($appearance,false);
        }elseif(is_int($appearance) || is_string($appearance)) {
            $_appearance = new Appearance();
            $_appearance->setId($appearance);
            $appearance = $_appearance->populate(['id' => $appearance], false);
        }
        return $appearance;
    }

    public static function getAppearances($appearance = null) {
        $appearances = new Appearance();
        $appearance = self::map($appearance);

        //si page null alors findAll avec cache
        is_null($appearance) ? (Cache::exist(self::CACHE_PREFIXE) ?
            $response = Cache::read(self::CACHE_PREFIXE)
            : Cache::write(self::CACHE_PREFIXE, $response = $appearances->findAll(['isDeleted' => false], ['createAt' => 'DESC']))
        ) : $response = $appearances->find(['id' => $appearance->getId(), 'isDeleted' => false], ['createAt' => 'DESC']);

        return $response;
    }

    public static function getActive() {
        $appearances = new Appearance();

        //si page null alors findAll avec cache
        Cache::exist(self::CACHE_PREFIXE.'_active') ?
            $response =
                Cache::read(self::CACHE_PREFIXE.'_active') :
            Cache::write(self::CACHE_PREFIXE.'_active', $response = $appearances->find(['isActive' => true, 'isDeleted' => false]));

        return $response;
    }

}