<?php

namespace App\Models\Users;

use App\Core\Database;

class Permissions extends Database
{
    protected $tableName = 'permission';
    protected $joinParameters = [
        'groupId' => [Group::class, 'id']
    ];

	protected $id = null;
	protected $name;
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
     * @return Permissions
     */
    public function setId(?int $id): Permissions
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Permissions
     */
    public function setName(string $name): Permissions
    {
        $this->name = $name;
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
     * @return Permissions
     */
    public function setGroupId(int $groupId): Permissions
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
     * @return Permissions
     */
    public function setIsActive(?bool $isActive): Permissions
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
     * @return Permissions
     */
    public function setCreateAt(?\DateTime $createAt): Permissions
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
     * @return Permissions
     */
    public function setUpdateAt(?\DateTime $updateAt): Permissions
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
     * @return Permissions
     */
    public function setIsDeleted(?bool $isDeleted): Permissions
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }



}









