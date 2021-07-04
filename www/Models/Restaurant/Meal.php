<?php

namespace App\Models\Restaurant;

use App\Core\Database;

class Meal extends Database
{
    protected $tableName = 'meal';

    protected $id = null;
    protected $name;
    protected $price;

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
     * @return Meal
     */
    public function setId(?int $id): Meal
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
     * @return Meal
     */
    public function setName(string $name): Meal
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return Meal
     */
    public function setPrice($price)
    {
        $this->price = $price;
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
     * @return Meal
     */
    public function setIsActive(?bool $isActive): Meal
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
     * @return Meal
     */
    public function setCreateAt(?\DateTime $createAt): Meal
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
     * @return Meal
     */
    public function setUpdateAt(?\DateTime $updateAt): Meal
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
     * @return Meal
     */
    public function setIsDeleted(?bool $isDeleted): Meal
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }


}