<?php

namespace App\Services\Http;

class Cookie {

    public static function create(string $name, $value, int $expires = 0, string $path = '/', string $domain = null, bool $secure = false, bool $httponly = false ) {
        setcookie($name, $value, $expires == 0 ? time()+3600*24 : $expires, $path ?? null, $domain ?? null, $secure ?? null, $httponly ?? null);
    }

    public static function destroy($name) {
        setcookie($name, null, -1, '/');
    }

    public static function load($name) {
        return $_COOKIE[$name];
    }

    /* cookie flash qui se détruit apres utilisation */
    public static function flash($name) {
        $cookie = $_COOKIE[$name];
        unset($_COOKIE[$name]);
        return $cookie;
    }

    public static function exist($name) {
        return isset($_COOKIE[$name]) ? true : false;
    }

}