<?php

namespace App\Models\Restaurant;

use App\Core\Database;

class MenuMeal extends Database
{
    protected $tableName = 'menu_meal';
    protected $joinParameters = [
        'mealId' => [Meal::class, 'id'],
        'menuId' => [Menu::class, 'id'],
    ];

    protected $id = null;
    protected $mealId;
    protected $menuId;

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
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     * @return MenuMeal
     */
    public function setId($id)
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
     * @return MenuMeal
     */
    public function setMealId($mealId)
    {
        $this->mealId = $mealId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMenuId()
    {
        return $this->menuId;
    }

    /**
     * @param mixed $menuId
     * @return MenuMeal
     */
    public function setMenuId($menuId)
    {
        $this->menuId = $menuId;
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
     * @return MenuMeal
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
     * @return MenuMeal
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
     * @return MenuMeal
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
     * @return MenuMeal
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }



}