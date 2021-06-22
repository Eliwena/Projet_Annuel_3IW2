<?php

namespace App\Models;

use App\Core\Database;

class Ingredients extends Database
{
    protected $tableName = 'dft__Aliment';

    protected $id = null;
    protected $nom;
    protected $prix;
    protected $stock;
    protected $activeCommande;
    protected $isDeleted;

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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param mixed $prix
     */
    public function setPrix($prix): void
    {
        $this->prix = $prix;
    }

    /**
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $stock
     */
    public function setStock($stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return mixed
     */
    public function getActiveCommande()
    {
        return $this->activeCommande;
    }

    /**
     * @param mixed $activeCommande
     */
    public function setActiveCommande($activeCommande): void
    {
        $this->activeCommande = $activeCommande;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     */
    public function setIsDeleted($isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }


}