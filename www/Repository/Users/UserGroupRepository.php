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
                return $userGroups->find(['userId' => $user->getId(),], null, true);
            } elseif(is_null($user) && !is_null($group)) {
                return $userGroups->find(['userId' => $group->getId()]);
            } elseif(!is_null($user) && !is_null($group)) {
                return $userGroups->find(['userId' => $user->getId(), 'groupId' => $group->getId()]);
            }
        }
        return false;
    }

}