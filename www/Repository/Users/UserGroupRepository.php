<?php

namespace App\Repository\Users;

use App\Models\Users\Group;
use App\Models\Users\User;
use App\Models\Users\UserGroup;
use App\Services\User\Security;

class UserGroupRepository extends UserGroup {

    public static function getUserGroups(User $user = null, Group $group = null) {
        if(Security::isConnected()) {
            $userGroups = new UserGroup();
            if(is_null($user) && is_null($group)) {
                return $userGroups->findAll();
            } elseif(!is_null($user) && is_null($group)) {
                return $userGroups->findAll(['userId' => $user->getId()]);
            } elseif(is_null($user) && !is_null($group)) {
                return $userGroups->findAll(['groupId' => $group->getId()]);
            } elseif(!is_null($user) && !is_null($group)) {
                return $userGroups->find(['userId' => $user->getId(), 'groupId' => $group->getId()]);
            }
        }
        return false;
    }

    public static function getGroupsByUserId($id) {
        $userGroups = new UserGroup();
        $userGroups = $userGroups->findAll(['userId' => $id]);
        return $userGroups;
    }

}