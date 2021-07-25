<?php

namespace App\Repository;

use App\Core\ConstantManager;
use App\Core\Helpers;
use App\Models\WebsiteConfiguration;
use App\Services\Http\Cache;

class WebsiteConfigurationRepository extends WebsiteConfiguration {

    const CACHE_KEY = '__website_configuration_';

    public static function getWebsiteConfiguration() {
       if(ConstantManager::envExist()) {
           if(Cache::exist(self::CACHE_KEY, '*')) {
               return Cache::read(self::CACHE_KEY, '*');
           } else {
               Cache::write(self::CACHE_KEY, $data = (new WebsiteConfiguration)->findAll(), '*');
               return $data;
           }
       }
       return [];
    }

    public static function getValueByKey($key) {
        $wc = self::getWebsiteConfiguration();
        if(is_array($wc)) {
            $index = array_search($key, array_column($wc, 'name'));
            if($index !== FALSE) {
                return $wc[$index]['value'];
            }
        }
        return null;
    }

    public static function getConfigurationById($id) {
        $wc = new WebsiteConfiguration();
        $wc = $wc->find(['id' => $id]);
        if($wc) {
            return $wc;
        }
        return null;
    }

    public static function getConfigurations() {
        $wc = self::getWebsiteConfiguration();
        if(is_array($wc)) {
            return $wc;
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

    public static function getHomepageTitle() {
        $value = self::getValueByKey('homepage_title');
        return $value;
    }

    public static function getMetaDescription() {
        $value = self::getValueByKey('meta_description');
        return $value;
    }

    public static function getContactEmail() {
        $value = self::getValueByKey('contact_email');
        return $value;
    }

    public static function getGoogleClientId() {
        $value = self::getValueByKey('oauth_google_client_id');
        return $value;
    }

    public static function getGoogleSecretId() {
        $value = self::getValueByKey('oauth_google_secret_id');
        return $value;
    }

    public static function getSocialLinkFacebook() {
        $value = self::getValueByKey('social_link_facebook');
        return $value;
    }

    public static function getSocialLinkInstagram() {
        $value = self::getValueByKey('social_link_instagram');
        return $value;
    }

    public static function getSocialLinkTikTok() {
        $value = self::getValueByKey('social_link_tiktok');
        return $value;
    }

    public static function getSocialLinkSnapChat() {
        $value = self::getValueByKey('social_link_snapchat');
        return $value;
    }

    public static function getSMTPGmailAccount() {
        $value = self::getValueByKey('gmail_account');
        return $value;
    }

    public static function getSMTPGmailPassword() {
        $value = self::getValueByKey('gmail_password');
        return $value;
    }

    public static function getPhoneNumber() {
        $value = self::getValueByKey('phone_number');
        return $value;
    }

    public static function getAddress() {
        $value = self::getValueByKey('address');
        return $value;
    }

    public static function getSiteLogo() {
        $value = self::getValueByKey('site_logo');
        return $value;
    }
}