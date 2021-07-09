<?php

namespace App\Models\Users;

use App\Core\Database;

class Group extends Database
{
    protected $tableName = 'group';

	protected $id = null;
	protected $name;
	protected $description;
	protected $groupOrder;

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
     * @return Group
     */
    public function setId(?int $id): Group
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
     * @return Group
     */
    public function setName(string $name): Group
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Group
     */
    public function setDescription(string $description): Group
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getGroupOrder(): int
    {
        return $this->groupOrder;
    }

    /**
     * @param int $groupOrder
     * @return Group
     */
    public function setGroupOrder(int $groupOrder): Group
    {
        $this->groupOrder = $groupOrder;
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
     * @return Group
     */
    public function setIsActive(?bool $isActive): Group
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
     * @return Group
     */
    public function setCreateAt(?\DateTime $createAt): Group
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
     * @return Group
     */
    public function setUpdateAt(?\DateTime $updateAt): Group
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
     * @return Group
     */
    public function setIsDeleted(?bool $isDeleted): Group
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }



}









