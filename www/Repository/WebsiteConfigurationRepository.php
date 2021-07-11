<?php

namespace App\Repository;

use App\Core\Helpers;
use App\Models\WebsiteConfiguration;
use App\Services\Http\Cache;

class WebsiteConfigurationRepository extends WebsiteConfiguration {

    const CACHE_KEY = '__website_configuration_';

    public static function getWebsiteConfiguration() {
        if(Cache::exist(self::CACHE_KEY, '*')) {
            return Cache::read(self::CACHE_KEY, '*');
        } else {
            Cache::write(self::CACHE_KEY, $data = (new WebsiteConfiguration)->findAll(), '*');
            return $data;
        }
    }

    public static function getValueByKey($key) {
        $wc = self::getWebsiteConfiguration();
        $index = array_search($key, array_column($wc, 'name'));
        if($index !== FALSE) {
            return $wc[$index]['value'];
        }
        return null;
    }


    public static function getDefaultLocale() {
        $value = self::getValueByKey('locale');
        if(is_null($value)) {
            return _TRANSLATION_DEFAULT_LOCALE;
        }
        return $value;
    }

    public static function getOAuthEnabled() {
        $value = self::getValueByKey('oauth_enable');
        if(is_null($value)) {
            return _OAUTH_ENABLED;
        }
        return $value;
    }

    public static function getIpInfoKey() {
        $value = self::getValueByKey('ipinfo_key');
        return $value;
    }

    public static function getGoogleAnalyticsKey() {
        $value = self::getValueByKey('google_analytics');
        return $value;
    }

    public static function getSiteName() {
        $value = self::getValueByKey('site_name');
        return $value;
    }

}