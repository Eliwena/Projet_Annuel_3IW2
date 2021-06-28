<?php

namespace App\Models;

use App\Core\Database;

class Restaurant extends Database
{
    protected $tableName = 'Restaurant';

    protected $id = null;
    protected $nom;
    protected $adresse;
    protected $codePostal;
    protected $ville;
    protected $telephone;
    protected $siret;
    protected $nomDomaine;
    protected $prefixe;
    protected $activeLivraison;
    //protected $idUserCMS;

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
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     */
    public function setAdresse($adresse): void
    {
        $this->adresse = $adresse;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     */
    public function setCodePostal($codePostal): void
    {
        $this->codePostal = $codePostal;
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return mixed
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @param mixed $siret
     */
    public function setSiret($siret): void
    {
        $this->siret = $siret;
    }

    /**
     * @return mixed
     */
    public function getNomDomaine()
    {
        return $this->nomDomaine;
    }

    /**
     * @param mixed $nomDomaine
     */
    public function setNomDomaine($nomDomaine): void
    {
        $this->nomDomaine = $nomDomaine;
    }

    /**
     * @return mixed
     */
    public function getPrefixe()
    {
        return $this->prefixe;
    }

    /**
     * @param mixed $prefixe
     */
    public function setPrefixe($prefixe): void
    {
        $this->prefixe = $prefixe;
    }

    /**
     * @return mixed
     */
    public function getActiveLivraison()
    {
        return $this->activeLivraison;
    }

    /**
     * @param mixed $activeLivraison
     */
    public function setActiveLivraison($activeLivraison): void
    {
        $this->activeLivraison = $activeLivraison;
    }

}