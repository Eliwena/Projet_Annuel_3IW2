<?php


namespace App\Services\Translator;

use App\Core\Translator as TranslatorCore;

class Translator {

    public static function trans($key, array $options = null) {
        $translator = new TranslatorCore();
        return $translator->trans($key, $options);
    }

    public static function getLocale() {
        $translator = new TranslatorCore();
        return $translator->getLocale();
    }
    
}