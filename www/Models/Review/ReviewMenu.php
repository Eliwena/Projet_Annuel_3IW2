<?php

namespace App\Models\Review;

use App\Core\Database;
use App\Models\Restaurant\Menu;

class ReviewMenu extends Database
{
    protected $tableName = 'review_menu';
    protected $joinParameters = [
        'menuId' => [Menu::class, 'id'],
        'reviewId' => [Review::class, 'id']
    ];

    protected $id = null;
    protected $menuId;
    protected $reviewId;

    protected $isActive;
    protected $createAt;
    protected $updateAt;
    protected $isDeleted;

    public function __construct($object = null)
    {
        $this->_tableName = $this->tableName;
        if ($object) {
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
     * @return ReviewMenu
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Menu
     */
    public function getMenuId(): Menu
    {
        return $this->menuId;
    }

    /**
     * @param Menu $menuId
     * @return ReviewMenu
     */
    public function setMenuId($menuId): ReviewMenu
    {
        $this->menuId = $menuId;
        return $this;
    }

    /**
     * @return Review
     */
    public function getReviewId(): Review
    {
        return $this->reviewId;
    }

    /**
     * @param Review $reviewId
     * @return ReviewMenu
     */
    public function setReviewId($reviewId): ReviewMenu
    {
        $this->reviewId = $reviewId;
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
     * @return ReviewMenu
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
     * @return ReviewMenu
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
     * @return ReviewMenu
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
     * @return ReviewMenu
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

}