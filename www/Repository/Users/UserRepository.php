<?php

namespace App\Repository\Users;

use App\Core\Helpers;
use App\Models\Users\User;
use App\Services\Http\Cache;

class UserRepository extends User {

    public static function getUser($user) {
        if(is_array($user)) {
            $_user = new User();
            $user = $_user->populate($user, false);
        }elseif(is_int($user) || is_string($user)) {
            $_user = new User();
            $_user->setId($user);
            $user = $_user->populate(['id' => $user], false);
        }
        return $user->find(['id' => $user->getId()]) ?? null;
    }

    public static function getUserByEmail($user) {
        if(is_array($user)) {
            $_user = new User();
            $user = $_user->populate($user, false);
        }elseif(is_int($user) || is_string($user)) {
            $_user = new User();
            $_user->setEmail($user);
            $user = $_user->populate(['email' => $user], false);
        }
        return $user->find(['email' => $user->getEmail()]) ?? null;
    }

    public static function getUsers() {
        $users = new User();
        return $users->findAll(['isDeleted' => false]) ?? null;
    }

    public static function getUserNumber() {
        if(Cache::exist('__user_number')) {
            return Cache::read('__user_number')['user_number'];
        } else {
            $user = new User();
            $query = 'SELECT COUNT(id) AS `user_number` FROM ' . $user->getTableName();
            Cache::write('__user_number', $data = $user->execute($query));
            return $data['user_number'];
        }
    }

}