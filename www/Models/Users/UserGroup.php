<?php

namespace App\Models\Users;

use App\Core\Database;

class UserGroup extends Database
{
    protected $tableName = 'dft__Users_Groups';

	protected $id = null;
	protected $idUsers;
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
     * @return integer|null
     */
    public function getUsersId()
    {
        return $this->id;
    }
    /**
     * @param integer|null $idUsers
     */
    public function setUsersId($idUsers)
    {
        $this->idUsers = $idUsers;
        return $this;
    }

    /**
     * @return integer|null
     */
    public function getGroupsId()
    {
        return $this->id;
    }
    /**
     * @param integer|null $idGroups
     */
    public function setGroupsId($idGroups)
    {
        $this->idGroups = $idGroups;
        return $this;
    }

}









