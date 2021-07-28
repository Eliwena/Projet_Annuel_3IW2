<?php

namespace App\Models\Users;

use App\Core\Database;

class GroupPermission extends Database
{
    protected $tableName = 'group_permission';
    protected $joinParameters = [
        'groupId' => [Group::class, 'id'],
        'permissionId' => [Permissions::class, 'id']
    ];

    protected $id = null;
    protected $groupId;
    protected $permissionId;

    protected $isActive;
    protected $createAt;
    protected $updateAt;
    protected $isDeleted;

	public function __construct($object = null){
	    $this->_tableName = $this->tableName;
        if($object) {
            $this->populate($object);
        }
        parent::__construct();
	}

    /**
     * @return \string[][]
     */
    public function getJoinParameters(): array
    {
        return $this->joinParameters;
    }

    /**
     * @param \string[][] $joinParameters
     * @return GroupPermission
     */
    public function setJoinParameters(array $joinParameters): GroupPermission
    {
        $this->joinParameters = $joinParameters;
        return $this;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     * @return GroupPermission
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     * @return GroupPermission
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPermissionId()
    {
        return $this->permissionId;
    }

    /**
     * @param mixed $permissionId
     * @return GroupPermission
     */
    public function setPermissionId($permissionId)
    {
        $this->permissionId = $permissionId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     * @return GroupPermission
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->createAt;
    }

    /**
     * @param mixed $createAt
     * @return GroupPermission
     */
    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param mixed $updateAt
     * @return GroupPermission
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     * @return GroupPermission
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

}









