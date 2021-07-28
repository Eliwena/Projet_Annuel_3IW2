<?php

namespace App\Services\Http;

use App\Core\Helpers;

class Session {

    /**
     * init session start
     */
    public static function init() {
        if(session_status() == PHP_SESSION_DISABLED) { session_start(); }
    }

    /**
     * @param $name
     * @param $value
     * create session
     */
    public static function create($name, $value) {
        self::init();
        $_SESSION[$name] = $value;
    }

    /**
     * @param null|string|int $name
     * if name destroy session with this name or destroy all session
     */
    public static function destroy($name = null) {
        is_null($name) ? session_destroy() : $_SESSION[$name] = null; unset($_SESSION[$name]);
    }

    /**
     * @param $name
     * @return mixed|null
     * load a session with this name
     */
    public static function load($name) {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
    }

    /**
     * @param $name
     * @param array $value
     */
    public static function push($name, array $value) {
        if(Session::exist($name) && is_array(Session::load($name))) {
            $_SESSION[$name] = array_merge(Session::load($name), $value);
        } else {
            Session::create($name, $value);
        }
    }

    /**
     * @param $name
     * @return mixed
     * session flash qui se détruit apres utilisation
    */
    public static function flash($name) {
        $session = $_SESSION[$name];
        unset($_SESSION[$name]);
        return $session;
    }

    /**
     * @param $name
     * @return bool
     * check if session exist
     */
    public static function exist($name) {
        return isset($_SESSION[$name]) ? true : false;
    }

}