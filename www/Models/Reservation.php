<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Users\User;

class Reservation extends Database
{
    protected $tableName = 'reservation';
    protected $joinParameters = [
        'userId' => [User::class, 'id']
    ];

    protected $id = null;
    protected $date;
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return ReservationRepository
     */
    public function setId(?int $id): ReservationRepository
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime|null $date
     * @return ReservationRepository
     */
    public function setDate(?\DateTime $date): ReservationRepository
    {
        $this->date = $date;
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
     * @return ReservationRepository
     */
    public function setUserId(int $userId): ReservationRepository
    {
        $this->userId = $userId;
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
     * @return ReservationRepository
     */
    public function setIsActive(?bool $isActive): ReservationRepository
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
     * @return ReservationRepository
     */
    public function setCreateAt(?\DateTime $createAt): ReservationRepository
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
     * @return ReservationRepository
     */
    public function setUpdateAt(?\DateTime $updateAt): ReservationRepository
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
     * @return ReservationRepository
     */
    public function setIsDeleted(?bool $isDeleted): ReservationRepository
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

}