<?php

namespace App\Services\User;

use App\Models\Users\User;
use App\Models\Users\UserGroup;
use App\Services\Http\Cookie;
use App\Services\Http\Message;

class Security {

    protected static $algo = PASSWORD_DEFAULT;

    public static $status = [
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

    public static function hasGroups(...$groups): bool {
        $_user = self::getUser();
        if(self::isConnected()) {
            $_userGroups = new UserGroup();
            $userGroups = $_userGroups->findAll(['userId' => $_user->getId()]);
            if($userGroups) {
                foreach($userGroups as $group) {
                    if(in_array($group['groupId']['name'], $groups)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public static function hasPermissions(...$permissions): bool {
        if(self::isConnected()) {
            if (self::hasGroups(_SUPER_ADMIN_GROUP)) {
                return true;
            } else {
                foreach (self::getPermissions() as $permission) {
                    if (in_array($permission['name'], $permissions)) {
                        if (self::hasGroups($permission['groupId']['name'])) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function createLoginToken(User $user) {
        if($user->getIsDeleted() || $user->getIsActive() == false) {
            Message::create('Erreur', 'Compte désactiver');
            return false;
        }
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
