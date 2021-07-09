<?php

namespace App\Repository\Users;

use App\Models\Users\Permissions;
use App\Services\User\Security;

class PermissionRepository extends Permissions {

    public static function getPermissions($permission = null) {
        if(Security::isConnected()) {
            $permissions = new Permissions();

            if(is_array($permission)) {
                $_permission = new Permissions();
                $permission = $_permission->populate($permission, false);
            }elseif(is_int($permission) || is_string($permission)) {
                $_permission = new Permissions();
                $_permission->setId($permission);
                $permission = $_permission->populate(['id' => $permission], false);
            }

            return is_null($permission) ? $permissions->findAll() : $permissions->find(['id' => $permission->getId()]);
        } else {
            return false;
        }
    }

    public static function getPermissionsByName($permission) {
        if(is_array($permission)) {
            $_permission = new Permissions();
            $permission = $_permission->populate($permission, false);
        }elseif(is_int($permission) || is_string($permission)) {
            $_permission = new Permissions();
            $_permission->setName($permission);
            $permission = $_permission->populate(['name' => $permission], false);
        }
        return $permission->find(['name' => $permission->getName()]) ?? null;
    }


}