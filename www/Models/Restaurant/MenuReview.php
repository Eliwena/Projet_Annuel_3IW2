<?php

namespace App\Models\Restaurant;

use App\Core\Database;

class MenuReview extends Database
{
    protected $tableName = 'menu_review';
    protected $joinParameters = [
        'menuId' => [Menu::class, 'id']
    ];

    protected $id = null;
    protected $title;
    protected $comment;
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return MenuReview
     */
    public function setId(?int $id): MenuReview
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return MenuReview
     */
    public function setTitle(string $title): MenuReview
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     * @return MenuReview
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return int
     */
    public function getMenuId(): int
    {
        return $this->menuId;
    }

    /**
     * @param int $menuId
     * @return MenuReview
     */
    public function setMenuId(int $menuId): MenuReview
    {
        $this->menuId = $menuId;
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
     * @return MenuReview
     */
    public function setIsActive(?bool $isActive): MenuReview
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
     * @return MenuReview
     */
    public function setCreateAt(?\DateTime $createAt): MenuReview
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
     * @return MenuReview
     */
    public function setUpdateAt(?\DateTime $updateAt): MenuReview
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
     * @return MenuReview
     */
    public function setIsDeleted(?bool $isDeleted): MenuReview
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }



}