<?php

namespace App\Repository\Users;

use App\Models\Users\Group;
use App\Services\User\Security;

class GroupRepository extends Group {

    public static function getGroups(Group $group = null) {
        if(Security::isConnected()) {
            $groups = new Group();
            return is_null($group) ? $groups->findAll() : $groups->find(['id' => $group->getId()]);
        } else {
            return false;
        }
    }

    public static function getGroupById($id) {
        $group = new Group();
        $group->setId($id);
        return $group->find(['id' => $group->getId()]);
    }

    public static function getGroupByName($name) {
        $group = new Group();
        $group->setName($name);
        return $group->find(['name' => $group->getName()]);
    }

}