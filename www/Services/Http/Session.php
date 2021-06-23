<?php

namespace App\Services\Http;

class Session {

    public static function init() {
        if(session_status() == PHP_SESSION_DISABLED) { session_start(); }
    }

    public static function create($name, $value) {
        self::init();
        $_SESSION[$name] = $value;
    }

    public static function destroy($name) {
        $_SESSION[$name] = null;
    }

    public static function load($name) {
        return $_SESSION[$name];
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