<?php

namespace App\Models\Restaurant;

use App\Core\Database;

class Foodstuff extends Database
{
    protected $tableName = 'foodstuff';

    protected $id = null;
    protected $name;
    protected $price;
    protected $stock;

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
     * @return Foodstuff
     */
    public function setId(?int $id): Foodstuff
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
     * @return Foodstuff
     */
    public function setName(string $name): Foodstuff
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
     * @return Foodstuff
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     * @return Foodstuff
     */
    public function setStock(int $stock): Foodstuff
    {
        $this->stock = $stock;
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
     * @return Foodstuff
     */
    public function setIsActive(?bool $isActive): Foodstuff
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
     * @return Foodstuff
     */
    public function setCreateAt(?\DateTime $createAt): Foodstuff
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
     * @return Foodstuff
     */
    public function setUpdateAt(?\DateTime $updateAt): Foodstuff
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
     * @return Foodstuff
     */
    public function setIsDeleted(?bool $isDeleted): Foodstuff
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

}