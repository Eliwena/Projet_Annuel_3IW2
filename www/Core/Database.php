<?php

namespace App\Core;

Abstract class Database {

	private $pdo;
	protected $tableName = null;

	public function __construct(){
	    try {
			$this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";dbname=".DBNAME.";port=".DBPORT , DBUSER , DBPWD );
		} catch(\Exception $e) {
	        Helpers::error("Erreur SQL : ".$e->getMessage());
		}

	 	$classExploded = explode("\\", get_called_class());
	    // Par défaut le nom de table est issue du nom de la classe sauf si dans la classe fille on définit une variable "protected $tableName = 'nom_de_la_table';"
	    $this->tableName = is_null($this->tableName) ? strtolower(DBPREFIXE . end($classExploded)) : strtolower(DBPREFIXE . $this->tableName);
	}

    public function populate(array $object) {
        $class = new \ReflectionClass(get_called_class());
        $entity = $class->newInstance();


        Helpers::debug($class->getProperties());

        foreach ($class->getProperties() as $prop) {
            if (isset($object[$prop->getName()])) {
                Helpers::debug($prop);
                $prop->setValue($entity, $object[$prop->getName()]);
            }
        }

        $entity->initialize(); // soft magic

        return $entity;
    }

    public function find($options = []) {

        $result = [];
        $query = 'SELECT * FROM jclm_users ';

        $whereClause = '';
        $whereConditions = [];

        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $whereConditions[] = '`'.$key.'` = "'.$value.'"';
            }
            $whereClause = " WHERE ".implode(' AND ',$whereConditions);
        }

        $query = $this->pdo->query($query . $whereClause);
        $query->execute();
        $data = $query->fetch(2);

        if($data) {
            return $this->populate($data);
        } else {
            return false;
        }

    }

	public function findAll() {

    }

	public function save(){

        $class = new \ReflectionClass($this);

        $propsToImplode = [];

        foreach ($class->getProperties() as $property) { // consider only public properties of the providen
            if($property->getName() != 'tableName' and $property->getName() != 'id') {
                $propertyName = $property->getName();
                $propsToImplode[] = '`'.$propertyName.'` = "'.$this->{$propertyName}.'"';
            }
        }

        $setClause = (implode(',', $propsToImplode));

        if ($this->id > 0) {
            $query = $this->pdo->prepare('UPDATE `' . $this->tableName . '` SET '.$setClause.' WHERE id = ' . $this->id);
        } else {
            $query = $this->pdo->prepare('INSERT INTO `' . $this->tableName . '` SET ' . $setClause );
        }

        $query->execute();

        Helpers::debug($query);
	}

}