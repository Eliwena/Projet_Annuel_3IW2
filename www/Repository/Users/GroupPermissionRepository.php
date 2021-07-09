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

    public static function getPermissionByGroupId($group) {
        if(is_array($group)) {
            $_group = new Group();
            $group = $_group->populate($group, false);
        }elseif(is_int($group) || is_string($group)) {
            $_group = new Group();
            $_group->setId($group);
            $group = $_group->populate(['id' => $group], false);
        }
        $groupPermission = new GroupPermission();
        $groupPermissions = $groupPermission->findAll(['groupId' => $group->getId(), 'isDeleted' => false]);
        return $groupPermissions;
    }

    public static function groupHasPermission($group, $permission): bool {
        if(is_array($group)) {
            $_group = new Group();
            $group = $_group->populate($group, false);
        }elseif(is_int($group) || is_string($group)) {
            $_group = new Group();
            $_group->setName($group);
            $group = $_group->populate(['id' => $group], false);
        }
        if(is_array($permission)) {
            $_permission = new Permissions();
            $permission = $_permission->populate($permission, false);
        }elseif(is_int($permission) || is_string($permission)) {
            $_permission = new Permissions();
            $_permission->setId($permission);
            $permission = $_permission->populate(['id' => $permission], false);
        }

        $groupPermission = new GroupPermission();
        $exist = $groupPermission->find(['permissionId' => $permission->getId(), 'groupId' => $group->getId()]);
        if($exist) {
            return true;
        }
        return false;
    }


}