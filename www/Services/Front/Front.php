<?php

namespace App\Services\Front;

use App\Core\Framework;
use App\Core\Helpers;
use App\Repository\WebsiteConfigurationRepository;

class Front {

    /**
     * Check route path and return true if current route contain base route url
     * @param string $route_path
     * @return bool
     * check if current link is int list of parent if true active sidebar parent
     */
    public static function isSidebarActive($route_path) {
        $route_path_exploded = explode('/', $route_path);
        $current_path_exploded = explode('/', Framework::getCurrentPath());
        if(isset($route_path_exploded[4]) && isset($current_path_exploded[4]) && $route_path_exploded[4] == $current_path_exploded[4]) {
           return true;
        } elseif($route_path == Framework::getCurrentPath()) {
            return true;
        }
        return false;
    }

    /*
     * @return string
     * send phone number and return this phone number with space between two digits
     */
    public function formatPhone($number)
    {
        $number = preg_replace('~^.{2}|.{2}(?!$)~', '$0 ', $number);
        return $number;
    }

    /**
     * @return string|null
     * return sitename
     */
    public static function getSiteName() {
        return WebsiteConfigurationRepository::getSiteName();
    }

    public static function getSiteLogo() {
        return Framework::getResourcesPath('uploads/' . self::getSiteLogoFileName());
    }
    /**
     * @return string|null
     * return site logo filename
     */
    public static function getSiteLogoFileName() {
        return WebsiteConfigurationRepository::getSiteLogoFileName();
    }

    /*
     * @return string|null
     * return favicon.ico
     */
    public static function getSiteFavicon() {
        return WebsiteConfigurationRepository::getSiteFavicon();
    }

    /**
     * @return string|null
     * return site number
     */
    public static function getPhoneNumber() {
        return WebsiteConfigurationRepository::getPhoneNumber();
    }

    /**
     * @return string|null
     * return site address
     */
    public static function getAddress() {
        return WebsiteConfigurationRepository::getAddress();
    }

    /**
     * @return string|null
     * return homepage Title
     */
    public static function getHomepageTitle() {
        return WebsiteConfigurationRepository::getHomepageTitle();
    }

    /**
     * @return string|null
     * return homepage meta description
     */
    public static function getMetaDescription() {
        return WebsiteConfigurationRepository::getMetaDescription();
    }

    /**
     * @return string|null
     * return website contact email
     */
    public static function getContactEmail() {
        return WebsiteConfigurationRepository::getContactEmail();
    }

    /**
     * @return string|null
     * return facebook page url
     */
    public static function getSocialLinkFacebook() {
        return WebsiteConfigurationRepository::getSocialLinkFacebook();
    }

    /**
     * @return string|null
     * return instagram page url
     */
    public static function getSocialLinkInstagram() {
        return WebsiteConfigurationRepository::getSocialLinkInstagram();
    }

    /**
     * @return string|null
     * return TikTok page url
     */
    public static function getSocialLinkTikTok() {
        return WebsiteConfigurationRepository::getSocialLinkTikTok();
    }

    /**
     * @return string|null
     * return snapchat page url
     */
    public static function getSocialLinkSnapChat() {
        return WebsiteConfigurationRepository::getSocialLinkSnapChat();
    }

    /**
     * @return number|null
     * return the max number of people who can reserve for one booking
     */
    public static function getMaxNumberOfPeopleReserv() {
        return WebsiteConfigurationRepository::getNumberPeople();
    }

    /**
     * @param string $date
     * @param string $format
     * @param string|null $modify
     * @return string
     * @throws \Exception
     * send date and you can format or modify this date
     */
    public static function date($date, $format = 'd/m/Y', $modify = null) {
        $dateTime = new \DateTime($date);
        !is_null($modify) ? $dateTime->modify($modify) : $modify = null;
        return $dateTime->format($format);
    }

    /**
     * @param int $stars_number
     * @return string
     * review generator
     */
    public static function generateStars($stars_number = 0, $stars_limits = 5) {
        $response = '';
        for ($i=1; $i<=$stars_number;$i++) {
            $response .= '<i class="fas fa-star"></i>';
         }
         for ($i=$stars_limits-$stars_number; $i>0;$i--) {
             $response .= '<i class="far fa-star"></i>';
         }
         return $response;
    }

    /**
     * @return string
     * return google analytics js if api key is defined in website configuration
     */
    public static function getGoogleAnalyticsJS() {
        $google_analytics_id = WebsiteConfigurationRepository::getGoogleAnalyticsKey();
        if($google_analytics_id) {
            return "<!-- Google Analytics --><script>(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');ga('create', ".$google_analytics_id.", 'auto');ga('send', 'pageview');</script><!-- End Google Analytics -->";
        }
        return '';
    }

}