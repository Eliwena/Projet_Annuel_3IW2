<?php

namespace App\Models\Users;

use App\Core\Database;

class UserGroup extends Database
{
    protected $tableName = 'dft__Users_Groups';
    protected $joinParameters = [
        'idUsers'  => [User::class, 'id'],
        'idGroups' => [Group::class, 'id']
    ];

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
     * @return integer|null|array
     */
    public function getIdUsers()
    {
        return $this->idUsers;
    }
    /**
     * @param integer|null $idUsers
     */
    public function setIdUsers($idUsers)
    {
        $this->idUsers = $idUsers;
        return $this;
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









