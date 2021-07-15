<?php

namespace App\Services\Http;

use App\Core\Helpers;

class Session {

    public static function init() {
        if(session_status() == PHP_SESSION_DISABLED) { session_start(); }
    }

    public static function create($name, $value) {
        self::init();
        $_SESSION[$name] = $value;
    }

    public static function destroy($name = null) {
        is_null($name) ? session_destroy() : $_SESSION[$name] = null;
    }

    public static function load($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    public static function push($name, array $value) {
        if(Session::exist($name) && is_array(Session::load($name))) {
            $_SESSION[$name] = array_merge(Session::load($name), $value);
        } else {
            Session::create($name, $value);
        }
    }

    /* session flash qui se détruit apres utilisation */
    public static function flash($name) {
        $session = $_SESSION[$name];
        unset($_SESSION[$name]);
        return $session;
    }

    public static function exist($name) {
        return isset($_SESSION[$name]) ? true : false;
    }

}