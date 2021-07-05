<?php


namespace App\Services\Translator;

use App\Core\Translator as TranslatorCore;

class Translator {

    public static function trans($key) {
        $translator = new TranslatorCore();
        return $translator->trans($key);
    }

}