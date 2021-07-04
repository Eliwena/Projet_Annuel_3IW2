<?php

namespace App\Models;

use App\Core\Database;

class WebsiteConfiguration extends Database
{
    protected $tableName = 'website_configuration';

    protected $id = null;
    protected $name;
    protected $description;
    protected $value;

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
     * @return WebsiteConfiguration
     */
    public function setId(?int $id): WebsiteConfiguration
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return WebsiteConfiguration
     */
    public function setName(string $name): WebsiteConfiguration
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return WebsiteConfiguration
     */
    public function setDescription(string $description): WebsiteConfiguration
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return WebsiteConfiguration
     */
    public function setValue(string $value): WebsiteConfiguration
    {
        $this->value = $value;
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
     * @return WebsiteConfiguration
     */
    public function setIsActive(?bool $isActive): WebsiteConfiguration
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
     * @return WebsiteConfiguration
     */
    public function setCreateAt(?\DateTime $createAt): WebsiteConfiguration
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
     * @return WebsiteConfiguration
     */
    public function setUpdateAt(?\DateTime $updateAt): WebsiteConfiguration
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
     * @return WebsiteConfiguration
     */
    public function setIsDeleted(?bool $isDeleted): WebsiteConfiguration
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

}