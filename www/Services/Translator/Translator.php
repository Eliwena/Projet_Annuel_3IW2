<?php


namespace App\Services\Translator;

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
    
}