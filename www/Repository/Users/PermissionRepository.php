<?php

namespace App\Repository\Users;

use App\Models\Users\Permissions;
use App\Services\User\Security;

class PermissionRepository extends Permissions {

    public static function getPermissions(Permissions $permission = null) {
        if(Security::isConnected()) {
            $permissions = new Permissions();
            if(is_array($permission)) {
                $_permission = new Permissions();
                $permission = $_permission->populate($permission, false);
            }
            return is_null($permission) ? $permissions->findAll() : $permissions->find(['id' => $permission->getId()]);
        } else {
            return false;
        }
    }


}