<?php

namespace App\Models\Users;

use App\Core\Database;

class User extends Database
{
    protected $tableName = 'user';

	protected $id = null;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $password;
	protected $country;
	protected $status;
	protected $token;
	protected $client;

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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return User
     */
    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
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
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     * @return User
     */
    public function setPassword(?string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return User
     */
    public function setCountry(string $country): User
    {
        $this->country = $country;
        return $this;
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
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     * @return User
     */
    public function setToken(?string $token): User
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getClient(): ?string
    {
        return $this->client;
    }

    /**
     * @param string|null $client
     * @return User
     */
    public function setClient(?string $client): User
    {
        $this->client = $client;
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
     * @return User
     */
    public function setIsActive(?bool $isActive): User
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
     * @return User
     */
    public function setCreateAt(?\DateTime $createAt): User
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
     * @return User
     */
    public function setUpdateAt(?\DateTime $updateAt): User
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
     * @return User
     */
    public function setIsDeleted(?bool $isDeleted): User
    {
        $this->isDeleted = $isDeleted;
        return $this;
    }

}









