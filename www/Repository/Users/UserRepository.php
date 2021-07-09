<?php

namespace App\Repository\Users;

use App\Models\Users\User;
use App\Services\User\Security;

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

}