<?php

namespace App\Services\User;

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
                return $userGroups->find(['userId' => $user->getId(),], null, true);
            } elseif(is_null($user) && !is_null($group)) {
                return $userGroups->find(['userId' => $group->getId()]);
            } elseif(!is_null($user) && !is_null($group)) {
                return $userGroups->find(['userId' => $user->getId(), 'groupId' => $group->getId()]);
            }
        }
        return false;
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
            foreach (self::getPermissions() as $permission) {
                if(in_array($permission['name'], $permissions)) {
                    if(self::hasGroups($permission['groupId']['name'])) {
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
