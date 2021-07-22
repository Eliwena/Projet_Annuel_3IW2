<?php

namespace App\Services\Http;

use App\Core\Cache as CacheCore;

class Cache {

    /**
     * @param string $key
     * @param $data
     * @param int $duration
     * @return bool
     * create new cache file with $key for name, $data for data and $duration for the cache renew
     */
    public static function write(string $key, $data, $duration = 60) {
        $cache = new CacheCore($duration);
        return $cache->write($key, $data);
    }

    /**
     * @param string $key
     * @param int $duration
     * @return false|mixed|string
     * return data from cache file with $key
     */
    public static function read(string $key, $duration = 60) {
        $cache = new CacheCore($duration);
        return $cache->read($key);
    }

    /**
     * @param string|null $key
     * @return bool
     * if key is null remove all cache file or if key remove key file cache
     */
    public static function clear(string $key = null) {
        $cache = new CacheCore(0);
        return $cache->clear($key);
    }

    /**
     * @param string $file
     * @param null $key
     * @param int $duration
     * @return bool|mixed|string
     */
    public static function inc(string $file, $key = null, $duration = 60) {
        $cache = new CacheCore($duration);
        return $cache->inc($file, $key);
    }

    /**
     * @param string $key
     * @param int $duration
     * @return bool
     * check if cache file already exist
     */
    public static function exist(string $key, $duration = 60) {
        $cache = new CacheCore($duration);
        return $cache->exist($key);
    }

}