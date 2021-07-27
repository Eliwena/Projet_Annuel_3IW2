<?php

namespace App\Services\Front;

use App\Core\Framework;
use App\Repository\Appearance\AppearanceRepository;
use \App\Models\Restaurant\Appearance as AppearanceModel;

class Appearance {

    protected static $default_properties = [
        '--default-font-family:"Nunito","Roboto",sans-serif',
        '--primary-color:#30475e',
        '--primary-color-light-30:#7194b6',
        '--primary-color-dark-50:#000',
        '--primary-border-color:#273a4d',

        '--secondary-color:#7e8a97',
        '--secondary-color-light-30:#d3d7db',
        '--secondary-color-dark-50:#0a0b0c',
        '--secondary-border-color:#707d8b',

        '--background-color:#dcdcdc',

        '--white-color:#fff',

        'background-image:url(www/public/Resources/images/restaurantbg.svg)',

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

            '--primary-color:' . $appearance->getColorNumber1(),
            '--primary-color-light-30:' . self::adjustBrightness($appearance->getColorNumber1(), 30),
            '--primary-color-dark-50:' . self::adjustBrightness($appearance->getColorNumber1(), -50),
            '--primary-border-color:' . self::adjustBrightness($appearance->getColorNumber1(), -5),

            '--secondary-color:' . $appearance->getColorNumber2(),
            '--secondary-color-light-30:' . self::adjustBrightness($appearance->getColorNumber2(), 30),
            '--secondary-color-dark-50:' . self::adjustBrightness($appearance->getColorNumber2(), -50),
            '--secondary-border-color:' . self::adjustBrightness($appearance->getColorNumber2(), -5),

            '--background-color:' . $appearance->getBackground(),

            '--white-color:' . $appearance->getPoliceColor(),

            'background-image:url('. Framework::getResourcesPath('uploads/'.$appearance->getBackgroundImage()) .')',

        ];

        $config  = '@import url(' . $appearance->getLinkPolice() . ');';
        $config .= self::getDefaultCSS();

        return str_replace(self::$default_properties, self::$active_properties, $config);
    }

    public static function getDefaultCSS() {
        return file_get_contents(Framework::getResourcesPath('styles.css' . '?' . rand()));
    }

    /**
     * Increases or decreases the brightness of a color by a percentage of the current brightness.
     *
     * @param   string  $hexCode        Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
     * @param   float   $adjustPercent  A number between -100 and 100. E.g. 30 = 30% lighter; -40 = 40% darker.
     *
     * @return  string
     */
    public static function adjustBrightness($hexCode, $adjustPercent) {
        $hexCode = ltrim($hexCode, '#');
        $adjustPercent = $adjustPercent/100;

        if (strlen($hexCode) == 3) {
            $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
        }

        $hexCode = array_map('hexdec', str_split($hexCode, 2));

        foreach ($hexCode as & $color) {
            $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
            $adjustAmount = ceil($adjustableLimit * $adjustPercent);

            $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
        }

        return '#' . implode($hexCode);
    }

}