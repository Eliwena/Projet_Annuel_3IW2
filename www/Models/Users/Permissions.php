<?php

namespace App\Models\Users;

use App\Core\Database;

class Permissions extends Database
{
    protected $tableName = 'dft__Permissions';
    protected $joinParameters = [
        'idGroups' => [Group::class, 'id']
    ];

	protected $id = null;
	protected $route;
	protected $idGroups;

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
	public function getId()
	{
	    return $this->id;
	}
	/**
	 * @param integer|null $id
	 */
	public function setId($id)
    {
	    $this->id = $id;
	    return $this;
	}

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route): void
    {
        $this->route = $route;
    }

    /**
     * @return integer|null|array
     */
    public function getIdGroups()
    {
        return $this->idGroups;
    }
    /**
     * @param integer|null $idGroups
     */
    public function setIdGroups($idGroups)
    {
        $this->idGroups = $idGroups;
        return $this;
    }

}








