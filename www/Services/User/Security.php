<?php

namespace App\Services\User;

use App\Core\ConstantManager;
use App\Core\Framework;
use App\Core\Helpers;
use App\Models\Users\Group;
use App\Models\Users\User;
use App\Models\Users\UserGroup;
use App\Repository\Users\GroupPermissionRepository;
use App\Repository\Users\GroupRepository;
use App\Repository\Users\UserGroupRepository;
use App\Repository\Users\UserRepository;
use App\Services\Http\Cookie;
use App\Services\Http\Message;
use App\Repository\Users\PermissionRepository;
use App\Services\Http\Router;

class Security {

    /**
     * @var string hash du mot de passe
     */
    protected static $algo = PASSWORD_DEFAULT;

    /**
     * @param $raw_password
     * @return false|string|null
     * hash le mot de passe utilisateur
     */
    public static function passwordHash($raw_password) {
        return password_hash($raw_password, self::$algo);
    }

    /**
     * @param $raw_password
     * @param $hash_password
     * @return bool
     * verifie la concordance entre le mot de passe hash et celui en clair.
     */
    public static function passwordVerify($raw_password, $hash_password) {
        return password_verify($hash_password, $raw_password);
    }

    /**
     * @return bool
     * verifie si l'utilisateur est connecté
     */
    public static function isConnected() {
        return ConstantManager::envExist() ? Cookie::exist('token') : false;
    }

    /**
     * @return []|array|false
     * récupère les données de l'utilisateur connecté en DB
     */
    public static function getUser() {
        if(self::isConnected()) {
            $user = new User();
            $user->setToken(Cookie::load('token'));
            $user = $user->find(['token' => $user->getToken()]);
            if(!$user) {
                Cookie::destroy('token');
                Router::redirectToRoute('app_home');
            }
            return $user;
        } else {
            return false;
        }
    }

    /**
     * @param ...$groups
     * @return bool
     * verifie si l'utilisateur connectée possèdes l'un des groupes dans $groups
     */
    public static function hasGroups(...$groups): bool {
        $user = self::getUser();
        if(self::isConnected()) {
            $userGroups = UserGroupRepository::getUserGroups($user);
            if($userGroups != false) {
                foreach($userGroups as $group) {
                    if(in_array($group['groupId']['name'], $groups)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param ...$permissions
     * @return bool
     * verifie si l'utilisateur connecté possède une des permissions envoyée
     */
    public static function hasPermissions(...$permissions): bool {
        $user = self::getUser();
        if(self::isConnected()) {
            if (self::hasGroups(_SUPER_ADMIN_GROUP)) {
                return true;
            } else {
                //get user groups list
                $userGroups = UserGroupRepository::getUserGroups($user);
                //user have group
                if($userGroups) {
                    //foreach all users groups
                    foreach ($userGroups as $userGroup) {
                        $group = new Group();
                        $group->populate($userGroup['groupId'], false);
                        //get all group permission
                        $groupPermissions = GroupPermissionRepository::getGroupPermission($group);
                        if ($groupPermissions) {
                            //foreach permissions
                            foreach ($groupPermissions as $permission) {
                                //compare if permission is in permissions array sended
                                if (in_array($permission['permissionId']['name'], $permissions)) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param User|null $user
     * @return bool
     * verifie si l'utilisateur est innactif ou supprimé
     */
    public static function isActive(User $user = null) {
        $user = is_null($user) ? self::getUser() : UserRepository::getUser($user);
        if($user->getIsDeleted() || $user->getIsActive() == false) {
            return false;
        }
        return true;
    }

    /**
     * @param User $user
     * @return bool
     * créer le cookie token pour authentifier un utilisateur
     */
    public static function createLoginToken($user) {

        //todo check if compte isdeleted

        if(is_array($user)) {
            $_user = new User();
            $user = $_user->populate($user, false);
        }elseif(is_int($user) || is_string($user)) {
            $_user = new User();
            $_user->setId($user);
            $user = $_user->populate(['id' => $user], false);
        }

        $token = new User();
        $token->setId($user->getId());
        $token->setToken(uniqid() . '-' . md5($user->getEmail()));
        $result = $token->save();

        if($result) {
            Cookie::create('token', $token->getToken());
            return true;
        } else {
            return false;
        }
    }

}
