<?php

namespace App\Models;

use App\Core\Database;

class Booking extends Database
{
    protected $tableName = 'dft__Users';

    protected $id = null;
    protected $email;
    protected $numberOfCustomers;
    protected $date;
    protected $momentOfTheDay;
    protected $hourOfService;
    protected $status;
    protected $isDeleted = 0;

    public function __construct(){
        $this->_tableName = $this->tableName;
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;
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
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getNumberOfCustomers()
    {
        return $this->numberOfCustomers;
    }

    /**
     * @param mixed $numberOfCustomers
     */
    public function setNumberOfCustomers($numberOfCustomers)
    {
        $this->numberOfCustomers = $numberOfCustomers;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getMomentOfTheDay()
    {
        return $this->momentOfTheDay;
    }

    /**
     * @param mixed $momentOfTheDay
     */
    public function setMomentOfTheDay($momentOfTheDay)
    {
        $this->momentOfTheDay = $momentOfTheDay;
    }

    /**
     * @return mixed
     */
    public function getHourOfService()
    {
        return $this->hourOfService;
    }

    /**
     * @param mixed $hourOfService
     */
    public function setHourOfService($hourOfService)
    {
        $this->hourOfService = $hourOfService;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param int $isDeleted
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }


}