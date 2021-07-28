<?php

namespace App\Models\Restaurant;

use App\Core\Database;

class Appearance extends Database
{
    protected $tableName = 'appearance';

    protected $id = null;
    protected $title;
    protected $description;
    protected $background;
    protected $link_police;
    protected $police_color;
    protected $police;
    protected $color_number_1;
    protected $color_number_2;
    protected $background_image;

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
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id): void
    {
        $this->id = $id;
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
    public function setTitle($title): void
    {
        $this->title = $title;
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
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * @param mixed $background
     */
    public function setBackground($background): void
    {
        $this->background = $background;
    }

    /**
     * @return mixed
     */
    public function getLinkPolice()
    {
        return $this->link_police;
    }

    /**
     * @param mixed $link_police
     */
    public function setLinkPolice($link_police): void
    {
        $this->link_police = $link_police;
    }

    /**
     * @return mixed
     */
    public function getPolice()
    {
        return $this->police;
    }

    /**
     * @param mixed $police
     */
    public function setPolice($police): void
    {
        $this->police = $police;
    }

    /**
     * @return mixed
     */
    public function getPoliceColor()
    {
        return $this->police_color;
    }

    /**
     * @param mixed $police_color
     */
    public function setPoliceColor($police_color): void
    {
        $this->police_color = $police_color;
    }


    /**
     * @return mixed
     */
    public function getColorNumber1()
    {
        return $this->color_number_1;
    }

    /**
     * @param mixed $color_number_1
     */
    public function setColorNumber1($color_number_1): void
    {
        $this->color_number_1 = $color_number_1;
    }

    /**
     * @return mixed
     */
    public function getColorNumber2()
    {
        return $this->color_number_2;
    }

    /**
     * @param mixed $color_number_2
     */
    public function setColorNumber2($color_number_2): void
    {
        $this->color_number_2 = $color_number_2;
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
     */
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
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
     */
    public function setCreateAt($createAt): void
    {
        $this->createAt = $createAt;
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
     */
    public function setUpdateAt($updateAt): void
    {
        $this->updateAt = $updateAt;
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
    public function setIsDeleted($isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return mixed
     */
    public function getBackgroundImage()
    {
        return $this->background_image;
    }

    /**
     * @param mixed $background_image
     */
    public function setBackgroundImage($background_image): void
    {
        $this->background_image = $background_image;
    }





}