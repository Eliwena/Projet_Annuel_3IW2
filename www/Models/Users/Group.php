<?php

namespace App\Models\Users;

use App\Core\Database;

class Group extends Database
{
    protected $tableName = 'dft__Groups';

	protected $id = null;
	protected $nom;
	protected $description;
	protected $groupOrdre = 100;
	protected $isDeleted = 0;

	public function __construct($object = null){
	    $this->_tableName = $this->tableName;
        if($object) {
            $this->populate($object);
        }
        parent::__construct();
	}

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
	public function setId($id): ?Group
    {
	    $this->id = $id;
	    return $this;
	}

	/**
	 * @return string|null
	 */
	public function getNom(): ?string
	{
	    return $this->nom;
	}
	/**
	 * @param string|null $nom
	 */
	public function setNom($nom): ?Group
    {
	    $this->nom = $nom;
	    return $this;
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
     * @return integer|null
     */
    public function getGroupOrdre(): ?int
    {
        return $this->groupOrdre;
    }
    /**
     * @param integer|null $groupOrdre
     */
    public function setGroupOrdre($groupOrdre): ?Group
    {
        $this->groupOrdre = $groupOrdre;
        return $this;
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

}









