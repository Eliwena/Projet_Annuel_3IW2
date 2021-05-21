<?php

namespace App\Models;

use App\Core\Database;

class Event extends Database
{
    private $id;
    protected $categorie;
    protected $title;
    protected $thumbnail;
    protected $description;
    protected $dateOfStartEvent;
    protected $dateOfEndEvent;
    protected $hourOfStartEvent;
    protected $hourOfEndEvent;
    protected $createdAt;
    protected $updatedAt;
    protected $isDeleted;

    public function __construct(){
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param mixed $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDateOfStartEvent()
    {
        return $this->dateOfStartEvent;
    }

    /**
     * @param mixed $dateOfStartEvent
     */
    public function setDateOfStartEvent($dateOfStartEvent)
    {
        $this->dateOfStartEvent = $dateOfStartEvent;
    }

    /**
     * @return mixed
     */
    public function getDateOfEndEvent()
    {
        return $this->dateOfEndEvent;
    }

    /**
     * @param mixed $dateOfEndEvent
     */
    public function setDateOfEndEvent($dateOfEndEvent)
    {
        $this->dateOfEndEvent = $dateOfEndEvent;
    }

    /**
     * @return mixed
     */
    public function getHourOfStartEvent()
    {
        return $this->hourOfStartEvent;
    }

    /**
     * @param mixed $hourOfStartEvent
     */
    public function setHourOfStartEvent($hourOfStartEvent)
    {
        $this->hourOfStartEvent = $hourOfStartEvent;
    }

    /**
     * @return mixed
     */
    public function getHourOfEndEvent()
    {
        return $this->hourOfEndEvent;
    }

    /**
     * @param mixed $hourOfEndEvent
     */
    public function setHourOfEndEvent($hourOfEndEvent)
    {
        $this->hourOfEndEvent = $hourOfEndEvent;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    }


}