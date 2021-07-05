<?php

namespace App\Repository\Users;

use App\Models\Users\User;
use App\Services\User\Security;

class UserRepository extends User {

    public static function getUserById($id) {
        $user = new User();
        $user->setId($id);
        return $user->find(['id' => $user->getId()]);
    }

    public static function getStatusFromName($name) {
        foreach (Security::$status as $k => $i) {
            if($i == $name) {
                return $k;
            }
        }
        return false;
    }

    public static function getStatusFromId($id) {
        foreach (Security::$status as $k => $i) {
            if($k == $id) {
                return $i;
            }
        }
        return false;
    }

}