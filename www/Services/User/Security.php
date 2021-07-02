<?php

namespace App\Services\User;

use App\Core\Helpers;
use App\Models\Users\Group;
use App\Models\Users\Permissions;
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

    public static function getGroups(Group $group = null) {
        if(self::isConnected()) {
            $groups = new Group();
            return is_null($group) ? $groups->findAll() : $groups->find(['id' => $group->getId()]);
        } else {
            return false;
        }
    }

    public static function getPermissions(Permissions $permission = null) {
        if(self::isConnected()) {
            $permissions = new Permissions();
            return is_null($permission) ? $permissions->findAll() : $permissions->find(['id' => $permission->getId()]);
        } else {
            return false;
        }
    }

    public static function getUserGroups(User $user = null, Group $group = null) {
        if(self::isConnected()) {
            $userGroups = new UserGroup();
            if(is_null($user) && is_null($group)) {
                return $userGroups->findAll();
            } elseif(!is_null($user) && is_null($group)) {
                return $userGroups->find(['idUsers' => $user->getId(),], null, true);
            } elseif(is_null($user) && !is_null($group)) {
                return $userGroups->find(['idGroups' => $group->getId()]);
            } elseif(!is_null($user) && !is_null($group)) {
                return $userGroups->find(['idUsers' => $user->getId(), 'idGroups' => $group->getId()]);
            }
        }
        return false;
    }

    public static function hasGroups(...$groups): bool {
        $_user = self::getUser();
        if(self::isConnected()) {
            $_userGroups = new UserGroup();
            $UserGroups = $_userGroups->findAll(['idUsers' => $_user->getId()]);
            foreach($UserGroups as $group) {
                if(in_array($group['idGroups']['nom'], $groups)) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function hasPermissions(...$permissions): bool {

        if(self::isConnected()) {
            foreach (self::getPermissions() as $permission) {
                if(in_array($permission['name'], $permissions)) {
                    if(self::hasGroups($permission['idGroups']['nom'])) {
                        return true;
                    }
                }
            }
        }
        return false;
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
