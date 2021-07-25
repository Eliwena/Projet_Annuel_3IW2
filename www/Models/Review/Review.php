<?php

namespace App\Models\Review;

use App\Core\Database;
use App\Models\Users\User;

class Review extends Database
{
    protected $tableName = 'review';
    protected $joinParameters = [
        'userId' => [User::class, 'id']
    ];

    protected $id = null;
    protected $title;
    protected $text;
    protected $note;
    protected $userId;

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
     * @return Review
     */
    public function setId($id)
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
     * @return Review
     */
    public function setTitle(string $title): Review
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     * @return Review
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return float
     */
    public function getNote(): float
    {
        return $this->note;
    }

    /**
     * @param float $note
     * @return Review
     */
    public function setNote(float $note): Review
    {
        $this->note = $note;
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
     * @return Review
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
     * @return Review
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
     * @return Review
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
     * @return Review
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

    /**
     * @return User
     */
    public function getUserId(): User
    {
        return $this->user_id;
    }

    /**
     * @param User $user_id
     * @return Review
     */
    public function setUserId(User $user_id): Review
    {
        $this->user_id = $user_id;
        return $this;
    }

}