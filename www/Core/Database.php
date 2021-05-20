<?php

namespace App\Core;

Abstract class Database {

	private $pdo;
	protected $className = null;
	protected $tableName = null;

	public function __construct($init = true){
        if($init) {
            $this->init();
        }
	 	$classExploded = explode("\\", get_called_class());
	    $this->setTableName(is_null($this->tableName) ? strtolower(DBPREFIXE . end($classExploded)) : strtolower(DBPREFIXE . $this->tableName)); // Par défaut le nom de table est issue du nom de la classe sauf si dans la classe fille on définit une variable "protected $tableName = 'nom_de_la_table';"
	    $this->setClassName(new \ReflectionClass($this));
	}

	private function init() {
        try {
            $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";dbname=".DBNAME.";port=".DBPORT , DBUSER , DBPWD );
        } catch(\Exception $e) {
            Helpers::error("Erreur SQL : ".$e->getMessage());
        }
	}

    public function populate(array $object) {

	    $entity = $this->getClassName()->newInstance();

        foreach ($object as $key => $value)
        {
            $entity->$key = $value;
        }

        return $entity;
    }

    public function find($options = [], $order = [], $return_type_array = false) {

        $result = [];

        $whereClause = '';
        $whereConditions = [];

        $orderClause = '';
        $orderConditions = [];

        $query = 'SELECT * FROM `' . $this->getTableName() . '`';

        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $whereConditions[] = '`' . $key . '` = "' . $value . '"';
            }
            $whereClause = " WHERE " . implode(' AND ',$whereConditions);
        }

        if (!empty($order) or !is_null($order)) {
            foreach ($order as $key => $value) {
                $orderConditions[] = '`' . $key . '` ' . strtoupper($value);
            }
            $orderClause = " ORDER BY " . implode(', ',$orderConditions);
        }

        $query = $this->getPDO()->query($query . $whereClause . $orderClause);
        Helpers::debug($query);
        $query->execute();
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        if($data) {
            return $return_type_array == true ? $data : $this->populate($data);
        } else {
            return false;
        }

    }

    public function findAll($options = [], $order = [], $return_type_array = false) {

        $result = [];

        $whereClause = '';
        $whereConditions = [];

        $orderClause = '';
        $orderConditions = [];

        $query = 'SELECT * FROM `' . $this->getTableName() . '`';

        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $whereConditions[] = '`' . $key . '` = "' . $value . '"';
            }
            $whereClause = " WHERE " . implode(' AND ',$whereConditions);
        }

        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $orderConditions[] = '`' . $key . '` ' . strtoupper($value);
            }
            $orderClause = " ORDER BY " . implode(', ',$orderConditions);
        }

        $query = $this->getPDO()->query($query . $whereClause . $orderClause);
        $query->execute();
        $data = $query->fetchAll(\PDO::FETCH_ASSOC);

        if($data) {
            return $return_type_array == true ? $data : $this->populate($data);
        } else {
            return false;
        }

    }

	public function save() {

        $propsToImplode = [];

        foreach ($this->getClassName()->getProperties() as $property) {
            if($property->getName() != 'tableName' and $property->getName() != 'className' and $property->getName() != 'id') {
                $propertyName = $property->getName();
                $propertyValue = $this->{$propertyName};
                if(!empty($propertyValue)) {
                    $propsToImplode[] = '`' . $propertyName . '` = "' . $propertyValue . '"';
                }
            }
        }

        $setClause = implode(', ', $propsToImplode);

        if ($this->id > 0) {
            $query = $this->getPDO()->prepare('UPDATE `' . $this->getTableName() . '` SET ' . $setClause . ' WHERE id = ' . $this->id);
            Helpers::debug($query);
        } else {
            $query = $this->getPDO()->prepare('INSERT INTO `' . $this->getTableName() . '` SET ' . $setClause );
        }

        $query->execute();
	}

    public function setTableName($tableName) {
        $this->tableName = $tableName;
        return $this;
    }
    public function getTableName() {
        return $this->tableName;
    }

    public function setClassName($className) {
        $this->className = $className;
        return $this;
    }
    public function getClassName() {
        return $this->className;
    }

    public function getPDO() {
        return $this->pdo;
    }

}