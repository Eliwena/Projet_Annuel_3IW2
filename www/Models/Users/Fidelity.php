<?php

namespace App\Models\Users;

use App\Core\Database;

class Fidelity extends Database
{
    protected $tableName = 'dft__Fidelite';

    protected $id = null;
    protected $idUsers;
    protected $dateDebut;
    protected $nombrePoint;

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
    public function getIdUsers()
    {
        return $this->idUsers;
    }

    /**
     * @param mixed $idUsers
     */
    public function setIdUsers($idUsers): void
    {
        $this->idUsers = $idUsers;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getNombrePoint()
    {
        return $this->nombrePoint;
    }

    /**
     * @param mixed $nombrePoint
     */
    public function setNombrePoint($nombrePoint): void
    {
        $this->nombrePoint = $nombrePoint;
    }
}