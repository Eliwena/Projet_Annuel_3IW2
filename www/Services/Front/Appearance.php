<?php

namespace App\Services\Front;

use App\Core\Framework;
use App\Repository\Appearance\AppearanceRepository;
use \App\Models\Restaurant\Appearance as AppearanceModel;

class Appearance {

    protected static $default_properties = [
        '--default-font-family:"Nunito","Roboto",sans-serif',
        '--blue-primary:#30475e',
        'background:#7e8a97',
        '--midgrey-color:#dcdcdc'
    ];

    protected static $active_properties;

    public static function getContentType(): void {
        header("Content-type: text/css");
    }

    public static function getStyle() {
        $activeAppearance = AppearanceRepository::getActive();
        if($activeAppearance) {
            return self::replaceProperty($activeAppearance);
        }
        return self::getDefaultCSS();
    }

    private static function replaceProperty(AppearanceModel $appearance ) {

        self::$active_properties = [
            '--default-font-family:' . $appearance->getPolice(),
            '--blue-primary:' . $appearance->getColorNumber1(),
            'background:' . $appearance->getColorNumber2(),
            '--midgrey-color:' . $appearance->getBackground(),
        ];

        $config  = '@import url(' . $appearance->getLinkPolice() . ');';
        $config .= self::getDefaultCSS();

        return str_replace(self::$default_properties, self::$active_properties, $config);
    }

    public static function getDefaultCSS() {
        return file_get_contents(Framework::getResourcesPath('styles.css' . '?' . rand()));
    }
}