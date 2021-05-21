<?php

namespace App\Services\User;

use App\Models\User;
use App\Models\User as UserModel;
use App\Services\Http\Cookie;

class Security {

    protected static $algo = PASSWORD_DEFAULT;

    public static function passwordHash($raw_password) {
        return password_hash($raw_password, self::$algo);
    }

    public static function passwordVerify($raw_password, $hash_password) {
        return password_verify($hash_password, $raw_password);
    }

    public static function isConnected() {
        return Cookie::exist('token');
    }

    public static function getUser() {
        if(self::isConnected()) {
            $user = new UserModel();
            $user->setToken(Cookie::load('token'));
            return $user->find(['token' => $user->getToken()], null, true);
        } else {
            return false;
        }
    }

    public static function createLoginToken(User $user) {
        $token = new User();
        $token->setId($user->getId());
        $token->setToken(uniqid() . '-' . md5($user->getEmail()));
        $result = $token->save();

        if($result) {
            Cookie::create('token', $token->getToken());
            return true;
        } else {
            return false;
        }
    }


}
