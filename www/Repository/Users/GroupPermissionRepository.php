<?php

namespace App\Repository\Users;

use App\Models\Users\Group;
use App\Models\Users\GroupPermission;
use App\Models\Users\Permissions;
use App\Services\User\Security;

class GroupPermissionRepository extends GroupPermission {

    public static function getGroupPermission(Group $group = null, Permissions $permissions = null) {
        if(Security::isConnected()) {
            $groupPermission = new GroupPermission();
            if(is_null($group) && is_null($permissions)) {
                return $groupPermission->findAll();
            } elseif(!is_null($group) && is_null($permissions)) {
                return $groupPermission->findAll(['groupId' => $group->getId()]);
            } elseif(is_null($group) && !is_null($permissions)) {
                return $groupPermission->findAll(['permissionId' => $permissions->getId()]);
            } elseif(!is_null($group) && !is_null($permissions)) {
                return $groupPermission->find(['groupId' => $group->getId(), 'permissionId' => $permissions->getId()]);
            }
        }
        return false;
    }


}