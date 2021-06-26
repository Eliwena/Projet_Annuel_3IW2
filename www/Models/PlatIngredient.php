<?php

namespace App\Models;

use App\Core\Database;

class PlatIngredient extends Database
{
    protected $tableName = 'dft__Plat_Aliment';

    protected $id = null;

    protected $idPlat;

    protected $idAliment;

    public function __construct()
    {
        $this->_tableName = $this->tableName;
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
    public function getIdPlat()
    {
        return $this->idPlat;
    }

    /**
     * @param mixed $idPlat
     */
    public function setIdPlat($idPlat): void
    {
        $this->idPlat = $idPlat;
    }

    /**
     * @return mixed
     */
    public function getIdAliment()
    {
        return $this->idAliment;
    }

    /**
     * @param mixed $idAliment
     */
    public function setIdAliment($idAliment): void
    {
        $this->idAliment = $idAliment;
    }


}