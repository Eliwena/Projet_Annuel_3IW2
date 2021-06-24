<?php

namespace App\Services\User;

use App\Core\Helpers;
use App\Models\Users\Group;
use App\Models\Users\User;
use App\Models\Users\UserGroup;
use App\Services\Http\Cookie;

class Security {

    protected static $algo = PASSWORD_DEFAULT;

    protected static $status = [
        0 => 'disable',
        1 => 'not-active',
        2 => 'active',
    ];

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
            $user = new User();
            $user->setToken(Cookie::load('token'));
            return $user->find(['token' => $user->getToken()]);
        } else {
            return false;
        }
    }

    public static function getGroups() {
        $user = self::getUser();
        if($user) {
            $userGroups = new UserGroup();
            $userGroupsData = $userGroups->findAll(['idUsers' => $user->getId()]);

            foreach ($userGroupsData as $group) {
                $groups = new Group();
                Helpers::debug($group);
                //$groups->
            }
            return true;
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

    public static function getStatusFromName($name) {
        foreach (self::$status as $k => $i) {
            if($i == $name) {
                return $k;
            }
        }
        return false;
    }

    public static function getStatusFromId($id) {
        foreach (self::$status as $k => $i) {
            if($k == $id) {
                return $i;
            }
        }
        return false;
    }


}
