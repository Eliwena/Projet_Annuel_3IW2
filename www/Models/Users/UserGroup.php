<?php

namespace App\Models\Users;

use App\Core\Database;

class UserGroup extends Database
{
    protected $tableName = 'user_group';
    protected $joinParameters = [
        'userId'  => [User::class, 'id'],
        'groupId' => [Group::class, 'id']
    ];

	protected $id = null;
	protected $userId;
	protected $groupId;

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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return UserGroup
     */
    public function setId(?int $id): UserGroup
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @return UserGroup
     */
    public function setUserId(int $userId): UserGroup
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->groupId;
    }

    /**
     * @param int $groupId
     * @return UserGroup
     */
    public function setGroupId(int $groupId): UserGroup
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool|null $isActive
     * @return UserGroup
     */
    public function setIsActive(?bool $isActive): UserGroup
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreateAt(): ?\DateTime
    {
        return $this->createAt;
    }

    /**
     * @param \DateTime|null $createAt
     * @return UserGroup
     */
    public function setCreateAt(?\DateTime $createAt): UserGroup
    {
        $this->createAt = $createAt;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdateAt(): ?\DateTime
    {
        return $this->updateAt;
    }

    /**
     * @param \DateTime|null $updateAt
     * @return UserGroup
     */
    public function setUpdateAt(?\DateTime $updateAt): UserGroup
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool|null $isDeleted
     * @return UserGroup
     */
    public function setIsDeleted(?bool $isDeleted): UserGroup
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }



}









