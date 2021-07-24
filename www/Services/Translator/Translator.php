<?php


namespace App\Services\Translator;

use App\Core\Helpers;
use App\Core\Translator as TranslatorCore;

class Translator {

    /**
     * @param $key
     * @param array|null $options
     * @return mixed|null
     * return translated string from key
     */
    public static function trans($key, array $options = null) {
        $translator = new TranslatorCore();
        return $translator->trans($key, $options);
    }

    /**
     * @return mixed
     * return lang
     */
    public static function getLocale() {
        $translator = new TranslatorCore();
        return $translator->getLocale();
    }

    /**
     * @return array|false|null
     * return array of translation filename in _TRANSLATION_PATH
     */
    public static function getLocaleInstalled() {
        $scan = array_diff(scandir(_TRANSLATION_PATH), ['.', '..']);
        $scan = str_replace('.yml', '', $scan);
        if(is_array($scan)) {
            return $scan;
        }
        return null;
    }
    
}