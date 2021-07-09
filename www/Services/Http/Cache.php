<?php

namespace App\Services\Http;

use App\Core\Cache as CacheCore;

class Cache {

    public static function write(string $key, $data, $duration = 60) {
        $cache = new CacheCore($duration);
        return $cache->write($key, $data);
    }

    public static function read(string $key, $duration = 60) {
        $cache = new CacheCore($duration);
        return $cache->read($key);
    }

    public static function clear(string $key = null) {
        $cache = new CacheCore(0);
        return $cache->clear($key);
    }

    public static function inc(string $file, $key = null, $duration = 60) {
        $cache = new CacheCore($duration);
        return $cache->inc($file, $key);
    }

    public static function exist(string $key, $duration = 60) {
        $cache = new CacheCore($duration);
        return $cache->exist($key);
    }

}