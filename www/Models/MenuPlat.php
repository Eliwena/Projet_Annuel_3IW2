<?php

namespace App\Models;

use App\Core\Database;

class MenuPlat extends Database
{
    protected $tableName = 'dft__Menu_Plat';
    protected $joinParameters = [
        'idPlat' => [Dishes::class, 'id'],
        'idMenu' => [Menu::class, 'id'],
        'idIngredient' => [Ingredients::class, 'id']
    ];

    protected $id = null;

    protected $idPlat;

    protected $idMenu;

    protected $idIngredient;

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
    public function getIdMenu()
    {
        return $this->idMenu;
    }

    /**
     * @param mixed $idMenu
     */
    public function setIdMenu($idMenu): void
    {
        $this->idMenu = $idMenu;
    }

    /**
     * @return mixed
     */
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * @param mixed $idIngredient
     */
    public function setIdIngredient($idIngredient): void
    {
        $this->idIngredient = $idIngredient;
    }




}