<?php

namespace App\Models;

use App\Core\Database;
use App\Models\Users\User;
use App\Repository\ReservationRepository;

class Reservation extends Database
{
    protected $tableName = 'reservation';
    protected $joinParameters = [
        'userId' => [User::class, 'id']
    ];

    protected $id = null;
    protected $date_reservation;
    protected $hour;
    protected $userId;
    protected $nbPeople;
    protected $validate;

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
     * @return Reservation
     */
    public function setId(?int $id): Reservation
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDate_reservation(): ?\DateTime
    {
        return $this->date_reservation;
    }

    /**
     * @param \DateTime|null $date
     * @return Reservation
     */
    public function setDate_reservation(?\DateTime $date_reservation): Reservation
    {
        $this->date_reservation = $date_reservation;
        return $this;
    }

    /**
     * @return \Time|null
     */
    public function getHour(): ?\Time
    {
        return $this->hour;
    }

    /**
     * @param \Time|null $hour
     * @return Reservation
     */
    public function setHour(?\Time $hour): Reservation
    {
        $this->hour = $hour;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbPeople(): ?int
    {
        return $this->nbPeople;
    }

    /**
     * @param int $nbPeople
     * @return Reservation
     */
    public function setNbPeople(int $nbPeople):  Reservation
    {
        $this->nbPeople = $nbPeople;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * @param mixed $validate
     */
    public function setValidate($validate): void
    {
        $this->validate = $validate;
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
     * @return Reservation
     */
    public function setUserId(int $userId): Reservation
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
     * @return Reservation
     */
    public function setIsActive(?bool $isActive): Reservation
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
     * @return Reservation
     */
    public function setCreateAt(?\DateTime $createAt): Reservation
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
     * @return Reservation
     */
    public function setUpdateAt(?\DateTime $updateAt): Reservation
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
     * @return Reservation
     */
    public function setIsDeleted(?bool $isDeleted): Reservation
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

}