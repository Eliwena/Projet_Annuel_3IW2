<?php

namespace App\Core;

require '../Core/lib/oauth-client/src/Curl.php';

use App\Repository\AnalyticsRepository;
use App\Repository\WebsiteConfigurationRepository;
use App\Services\Http\Cache;
use Mnt\OAuth\Curl;

class Analytics
{
    const CACHE_PREFIXE = '__analytics_';

    protected $client_ip;

    public function __construct($client_ip = null) {
        !is_null($client_ip) ? $this->setClientIp($client_ip) : $this->setClientIp();
    }

    private function isCached() {
        $key = self::CACHE_PREFIXE . $this->getClientIp();
        if(Cache::exist($key, '*')) {
            return true;
        }
        return false;
    }

    public function getIpInfo() {
        $cacheName = self::CACHE_PREFIXE . $this->getClientIp();
        if($this->isCached()) {
            return Cache::read($cacheName);
        } else {
            $key = WebsiteConfigurationRepository::getIpInfoKey();
            if($key) {
                try {
                    //IPInfo free 50000 rate limit per month
                    $curl = new Curl(_IPINFO_URI . $this->getClientIp(), [
                        CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $key]
                    ]);
                    Cache::write($cacheName, json_decode($curl->exec(), true), '*');
                    return $this->getIpInfo();
                } catch (\Exception $exception) {
                    Helpers::error($exception->getMessage());
                }
            }
            return false;
        }
    }

    public function addEntry() {
        AnalyticsRepository::insert();
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->client_ip;
    }

    /**
     * @param string $client_ip
     * @return Analytics
     */
    public function setClientIp(string $client_ip = null)
    {
        if(is_null($client_ip)) {
            $keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
            foreach($keys as $key)
            {
                if (!empty($_SERVER[$key]) && filter_var($_SERVER[$key], FILTER_VALIDATE_IP))
                {
                    $this->client_ip = $_SERVER[$key];
                }
            }
            $this->client_ip = 'UNKNOWN';
        } else {
            $this->client_ip = $client_ip;
        }

        return $this;
    }

}