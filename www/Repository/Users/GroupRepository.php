<?php

namespace App\Repository\Users;

use App\Core\Helpers;
use App\Models\Users\Group;
use App\Models\Users\User;
use App\Models\Users\UserGroup;
use App\Services\User\Security;

class GroupRepository extends Group {

    public static function getGroups($group = null) {
        if(Security::isConnected()) {
            $groups = new Group();
            if(is_array($group)) {
                $_group = new Group();
                $group = $_group->populate($group, false);
            }
            return is_null($group) ? $groups->findAll() : $groups->find(['id' => $group->getId()]);
        } else {
            return false;
        }
    }

    public static function getGroupById($group) {
        if(is_array($group)) {
            $_group = new Group();
            $group = $_group->populate($group,false);
        }elseif(is_int($group) || is_string($group)) {
            $_group = new Group();
            $_group->setId($group);
            $group = $_group->populate(['id' => $group], false);
        }
        return $group->find(['id' => $group->getId()]) ?? null;
    }

    public static function getGroupByName($group) {
        if(is_array($group)) {
            $_group = new Group();
            $group = $_group->populate($group, false);
        }elseif(is_int($group) || is_string($group)) {
            $_group = new Group();
            $_group->setName($group);
            $group = $_group->populate(['name' => $group], false);
        }
        return $group->find(['name' => $group->getName()]) ?? null;
    }

    public static function userHasGroup(Group $group, User $user): bool {
        $userGroups = new UserGroup();
        $exist = $userGroups->find(['userId' => $user->getId(), 'groupId' => $group->getId()]);
        if($exist) {
            return true;
        }
        return false;
    }

}