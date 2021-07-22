<?php

namespace App\Services\Http;

class Cookie {

    /**
     * @param string $name
     * @param $value
     * @param int $expires
     * @param string $path
     * @param string|null $domain
     * @param bool $secure
     * @param bool $httponly
     * create cookie
     */
    public static function create(string $name, $value, int $expires = 0, string $path = '/', string $domain = null, bool $secure = false, bool $httponly = false ) {
        setcookie($name, $value, $expires == 0 ? time()+3600*24 : $expires, $path ?? null, $domain ?? null, $secure ?? null, $httponly ?? null);
    }

    /**
     * @param $name
     * destory cookie
     */
    public static function destroy($name) {
        setcookie($name, null, -1, '/');
    }

    /**
     * @param $name
     * @return mixed
     * load cookie
     */
    public static function load($name) {
        return $_COOKIE[$name];
    }

    /* cookie flash qui se détruit apres utilisation */
    /**
     * @param $name
     * @return mixed
     * load one time cookie and destroy it
     */
    public static function flash($name) {
        $cookie = $_COOKIE[$name];
        unset($_COOKIE[$name]);
        return $cookie;
    }

    /**
     * @param $name
     * @return bool
     * check if cookie exist
     */
    public static function exist($name) {
        return isset($_COOKIE[$name]) ? true : false;
    }

}