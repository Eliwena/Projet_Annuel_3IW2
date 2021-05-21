<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    protected $tableName = 'dft__Users';

	protected $id = null;
	protected $firstname;
	protected $lastname;
	protected $email;
	protected $pwd;
	protected $country;
	protected $role = 0;
	protected $status;
	protected $token;
	protected $createAt;
	protected $updateAt;
	protected $isDeleted = 0;

	/*
		role
		status
		createdAt
		updatedAt
		isDeleted (hard delete du soft delete) attention au RGPD
	*/


	public function __construct(){
	    $this->_tableName = $this->tableName;
        parent::__construct();
	}

	//Parse error: syntax error, unexpected 'return' (T_RETURN) in /var/www/html/Models/User.php on line 41

	/**
	 * @return integer|null
	 */
	public function getId(): ?int
	{
	    return $this->id;
	}
	/**
	 * @param integer|null $id
	 */
	public function setId($id): ?User
	{
	    $this->id = $id;
	    return $this;
	    //ON doit peupler (populate) l'objet avec les valeurs de la bdd ...
	}

	/**
	 * @return string|null
	 */
	public function getFirstname(): ?string
	{
	    return $this->firstname;
	}
	/**
	 * @param string|null $firstname
	 */
	public function setFirstname($firstname): ?User
	{
	    $this->firstname = $firstname;
	    return $this;
	}
	/**
	 * @return string|null
	 */
	public function getLastname(): ?string
	{
	    return $this->lastname;
	}
	/**
	 * @param string|null $lastname
	 */
	public function setLastname($lastname): ?User
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
	 */
	public function setEmail($email): void
	{
	    $this->email = $email;
	}
	/**
	 * @return mixed
	 */
	public function getPwd()
	{
	    return $this->pwd;
	}
	/**
	 * @param mixed $pwd
	 */
	public function setPwd($pwd): void
	{
	    $this->pwd = $pwd;
	}
	/**
	 * @return mixed
	 */
	public function getCountry()
	{
	    return $this->country;
	}
	/**
	 * @param mixed $country
	 */
	public function setCountry($country): void
	{
	    $this->country = $country;
	}
	/**
	 * @return int
	 */
	public function getRole(): int
	{
	    return $this->role;
	}
	/**
	 * @param int $role
	 */
	public function setRole(int $role): void
	{
	    $this->role = $role;
	}
	/**
	 * @return int
	 */
	public function getStatus(): int
	{
	    return $this->status;
	}
	/**
	 * @param int $status
	 */
	public function setStatus(int $status): void
	{
	    $this->status = $status;
	}

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

	/**
	 * @return int
	 */
	public function getIsDeleted(): int
	{
	    return $this->isDeleted;
	}
	/**
	 * @param int $isDeleted
	 */
	public function setIsDeleted(int $isDeleted): void
	{
	    $this->isDeleted = $isDeleted;
	}

    public function getCreateAt()
    {
        return $this->createAt;
    }

    public function setCreateAt($createAt)
    {
        $this->createAt = $createAt;
        return $this;
    }

    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;
        return $this;
    }

}









