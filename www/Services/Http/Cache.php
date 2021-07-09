<?php

namespace App\Services\Http;

use App\Core\Cache as CacheCore;
use App\Core\Helpers;
use App\Core\Router;

class Cache {

    public static function write(string $key, $data, int $lifetime = 60) {
        $cache = new CacheCore($lifetime);
        return $cache->write($key, $data);
    }

    public static function read(string $key, int $lifetime = 60) {
        $cache = new CacheCore($lifetime);
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

    public static function exist(string $key) {
        $cache = new CacheCore(0);
        return $cache->exist($key);
    }

}