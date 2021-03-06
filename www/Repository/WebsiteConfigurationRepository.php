<?php

namespace App\Repository;

use App\Models\WebsiteConfiguration;

class WebsiteConfigurationRepository extends WebsiteConfiguration {

    public static function getDefaultLocale() {
        $wc = (new WebsiteConfiguration)->find(['name' => 'locale']);
        if($wc) {
            return $wc->getName();
        }
        return _TRANSLATION_DEFAULT_LOCALE;
    }

}