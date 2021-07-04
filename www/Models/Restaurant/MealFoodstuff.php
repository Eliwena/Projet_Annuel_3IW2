<?php

namespace App\Models\Restaurant;

use App\Core\Database;

class MealFoodstuff extends Database
{
    protected $tableName = 'meal_foodstuff';
    protected $joinParameters = [
        'mealId'  => [Meal::class, 'id'],
        'foodstuffId' => [Foodstuff::class, 'id']
    ];

    protected $id = null;
    protected $mealId;
    protected $foodstuffId;

    protected $isActive;
    protected $createAt;
    protected $updateAt;
    protected $isDeleted;

    public function __construct($object = null)
    {
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
     * @return MealFoodstuff
     */
    public function setId(?int $id): MealFoodstuff
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMealId()
    {
        return $this->mealId;
    }

    /**
     * @param mixed $mealId
     * @return MealFoodstuff
     */
    public function setMealId($mealId)
    {
        $this->mealId = $mealId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFoodstuffId()
    {
        return $this->foodstuffId;
    }

    /**
     * @param mixed $foodstuffId
     * @return MealFoodstuff
     */
    public function setFoodstuffId($foodstuffId)
    {
        $this->foodstuffId = $foodstuffId;
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
     * @return MealFoodstuff
     */
    public function setIsActive(?bool $isActive): MealFoodstuff
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
     * @return MealFoodstuff
     */
    public function setCreateAt(?\DateTime $createAt): MealFoodstuff
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
     * @return MealFoodstuff
     */
    public function setUpdateAt(?\DateTime $updateAt): MealFoodstuff
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
     * @return MealFoodstuff
     */
    public function setIsDeleted(?bool $isDeleted): MealFoodstuff
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

}