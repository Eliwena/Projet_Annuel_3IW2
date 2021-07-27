<?php

namespace App\Core;

Abstract class Database {

	private $pdo;
	private $query;
	protected $className = null;
	protected $tableName = null;
	protected $parameterExcluded = ['className', 'tableName', 'joinParameters', 'parameterExcluded'];

	public function __construct($init = true){
        if(ConstantManager::envExist()) {
            if($init) {
                $this->init();
            }
            $classExploded = explode("\\", get_called_class());
            $this->setTableName(is_null($this->tableName) ? DBPREFIXE . end($classExploded) : DBPREFIXE . $this->tableName); // Par défaut le nom de table est issue du nom de la classe sauf si dans la classe fille on définit une variable "protected $tableName = 'nom_de_la_table';"
            $this->setClassName($this->getReflection());
        }
	}

	private function init() {
        try {
            $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";dbname=".DBNAME.";port=".DBPORT, DBUSER, DBPASS);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch(\PDOException $databaseException) {
            Helpers::error("Erreur de connexion SQL " . (ENV == 'dev' ? $databaseException->getMessage() : ''));
        }
	}

    public function populate(array $object, $keyModel = true, $return_type_array = false) {

	    if($keyModel) {
            if($return_type_array) {
                if(array_key_exists(0, $object)) {
                    $entity = $this->castMultiple($object);
                } else {
                    $entity = $this->cast($object, $return_type_array);
                }
            } else {
                //si tableau multidimentionnel alors array
                if (array_key_exists(0, $object)) {
                    $this->populate($object, true, true);
                } else {
                    $entity = $this->cast($object);
                }
            }
            return $entity;
        } else {
            foreach ($object as $key => $value) { $this->$key = $value; }
            return $this;
        }

    }

    public function execute($query, \PDO $pdo = null) {
        try {
            $query = is_null($pdo) ? $this->getPDO()->query($query) : $pdo->query($query);
            $query->execute();
            return $query->fetch(\PDO::FETCH_ASSOC);
        } catch(\PDOException $databaseException) {
            Helpers::error("Erreur lors de la req SQL " . (ENV == 'dev' ? $databaseException->getMessage() : ''));
        }
        return null;
    }

    public function executeFetchAll($query, \PDO $pdo = null) {
        try {
            $query = is_null($pdo) ? $this->getPDO()->query($query) : $pdo->query($query);
            $query->execute();
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\PDOException $databaseException) {
            Helpers::error("Erreur lors de la req SQL " . (ENV == 'dev' ? $databaseException->getMessage() : ''));
        }
        return null;
    }
    public function find($options = [], $order = [], $return_type_array = false) {

        $result = [];

        $whereClause = '';
        $whereConditions = [];

        $orderClause = '';
        $orderConditions = [];

        $this->buildQuery();

        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $whereConditions[] = '`' . $key . '` = "' . $value . '"';
            }
            $whereClause = " WHERE t0." . implode(' AND t0.',$whereConditions);
        }

        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $orderConditions[] = '`' . $key . '` ' . strtoupper($value);
            }
            $orderClause = " ORDER BY t0." . implode(', t0.',$orderConditions);
        }

        //Helpers::debug($this->query . $whereClause . $orderClause);

        try {
            $this->query = $this->getPDO()->query($this->query . $whereClause . $orderClause);
            $this->query->execute();
            $data = $this->query->fetch(\PDO::FETCH_ASSOC);
        } catch(\PDOException $databaseException) {
            Helpers::error("Erreur lors de la req SQL " . (ENV == 'dev' ? $databaseException->getMessage() : ''));
        }

        if($data) {
            return $this->populate($data, true, $return_type_array);
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

        $this->buildQuery();

        if (!empty($options)) {
            foreach ($options as $key => $value) {
                $whereConditions[] = '`' . $key . '` = "' . $value . '"';
            }
            $whereClause = " WHERE t0." . implode(' AND t0.',$whereConditions);
        }

        if (!empty($order)) {
            foreach ($order as $key => $value) {
                $orderConditions[] = '`' . $key . '` ' . strtoupper($value);
            }
            $orderClause = " ORDER BY t0." . implode(', t0.',$orderConditions);
        }

       //Helpers::debug($this->query . $whereClause . $orderClause);

        try {
            $this->query = $this->getPDO()->query($this->query . $whereClause . $orderClause);
            $this->query->execute();
            $data = $this->query->fetchAll(\PDO::FETCH_ASSOC);
        } catch(\PDOException $databaseException) {
            Helpers::error("Erreur lors de la req SQL " . (ENV == 'dev' ? $databaseException->getMessage() : ''));
        }


        if($data) {
            return $this->populate($data, true, true);
        } else {
            return false;
        }

    }

    public function delete(): bool {

        $query = 'DELETE FROM `' . $this->getTableName() . '`';

        $propsToImplode = [];

        foreach ($this->getClassName()->getProperties() as $property) {
            if(in_array($property->getName(), $this->parameterExcluded) == false) {
                $propertyName = $property->getName();
                $propertyValue = $this->{$propertyName};
                if(!empty($propertyValue)) {
                    $propsToImplode[] = '`' . $propertyName . '` = "' . $propertyValue . '"';
                }
            }
        }

        $whereClause = " WHERE " . implode(' AND ', $propsToImplode);

        try {
            $query = $this->getPDO()->query($query . $whereClause);
            $query->execute();
            if($query->rowCount() > 0) {
                $response = true;
            } else {
                $response = false;
            }
        } catch(\PDOException $databaseException) {
            Helpers::error("Erreur lors de la req SQL " . (ENV == 'dev' ? $databaseException->getMessage() : ''));
        }

        return $response;

    }

	public function save() {

        $propsToImplode = [];


        foreach ($this->getClassName()->getProperties() as $property) {
            if(in_array($property->getName(), $this->parameterExcluded) == false and $property->getName() != 'id') {
                $propertyName = $property->getName();
                $propertyValue = $this->{$propertyName};

                if(!empty($propertyValue) || is_bool($propertyValue)) {
                    $propertyValue = is_bool($propertyValue) ? ($propertyValue == true ? '1' : '0') : $propertyValue;
                    $propsToImplode[] = '`' . $propertyName . '` = "' .  $propertyValue . '"';
                }
            }
        }

        $setClause = implode(', ', array_filter($propsToImplode));

        if($propsToImplode) {
            if ($this->id > 0) {
                $query = $this->getPDO()->prepare('UPDATE `' . $this->getTableName() . '` SET ' . $setClause . ' WHERE id = ' . $this->id);
            } else {
                $query = $this->getPDO()->prepare('INSERT INTO `' . $this->getTableName() . '` SET ' . $setClause);
            }
            $query->execute();
            if($query->rowCount() > 0) {
                return true;
            }
        }
        return false;
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

    protected function getPDO() {
        return $this->pdo;
    }
    protected function getReflection() {
        $reflection = new \ReflectionClass($this);
        return $reflection;
    }

    protected function buildQuery() {

	    $i = 0;
        $tableAlias = [];

        foreach ($this->getReflection()->getProperties() as $property) {

            if(in_array($property->name, $this->parameterExcluded) == true) {
                continue;
            } else {
                $tableAlias = array_merge($tableAlias, ['t0.' . $property->name . ' AS `' . $this->getReflection()->getName() . '@' . $property->name . '`']);

                if(isset($this->joinParameters[$property->name])) {

                    $call_function = $this->joinParameters[$property->name];
                    $i++;

                    $class = new $call_function[0];
                    $class_reflection = new \ReflectionClass($class);

                    foreach ($class_reflection->getProperties() as $_property) {
                        if(in_array($_property->name, $this->parameterExcluded)) { continue; } else {
                            $tableAlias = array_merge($tableAlias, ['t' . $i . '.' . $_property->name . ' AS `' . $class_reflection->getName() . '@' . $_property->name . '`']);
                        }
                    }

                    $classExploded = explode("\\", get_called_class());
                    $tableName = is_null($class->tableName) ? DBPREFIXE . end($classExploded) : $class->tableName;
                    $this->query .= ' INNER JOIN ' . $tableName . ' t' . $i . ' ON t0.' . $property->name . ' = t'. $i . '.' . $call_function[1] . '';
                }
            }
        }
        $this->query = 'SELECT ' . implode(',', $tableAlias) . ' FROM `' . $this->getTableName() . '` t0' . $this->query;
    }

    protected function cast($object, $return_type_array = false) {
        $array = [];
	    $entity = $this->getClassName()->newInstance();

        foreach ($object as $key => $value) {

            $explode = explode('@', $key);
            $className = $explode[0];
            $classProperty = $explode[1];

            if (isset($this->joinParameters[$classProperty])) {
                foreach ($object as $_key => $_value) {
                    $_explode = explode('@', $_key);
                    $_className = $_explode[0];
                    $_classProperty = $_explode[1];
                    if ($this->joinParameters[$classProperty][0] == $_className) {
                        if($return_type_array) {
                            $array = array_merge_recursive($array, [$classProperty => [$_classProperty => $_value]]);
                        } else {
                            if (empty($entity->$classProperty)) {
                                $entity->$classProperty = new $_className;
                            }
                            $entity->$classProperty->$_classProperty = $_value;
                        }
                    }
                }
            } elseif ($className == $this->getReflection()->getName()) {
                if($return_type_array) {
                    $array = array_merge_recursive($array, [$classProperty => $value]);
                } else {
                    $entity->$classProperty = $value;
                }
            }
        }

        if($return_type_array) {
            return $array;
        } else {
            return $entity;
        }
    }

    protected function castMultiple($object) {
        $i = 0;
        $array = array();
        foreach ($object as $_key => $_object) {
            $array = array_merge($array, [$i => []]);

            foreach ($_object as $key => $value) {

                $explode = explode('@', $key);
                $className = $explode[0];
                $classProperty = $explode[1];

                if (isset($this->joinParameters[$classProperty])) {
                    foreach ($_object as $_key => $_value) {
                        $_explode = explode('@', $_key);
                        $_className = $_explode[0];
                        $_classProperty = $_explode[1];
                        if ($this->joinParameters[$classProperty][0] == $_className) {
                            $array[$i] = array_merge_recursive($array[$i], [$classProperty => [$_classProperty => $_value]]);
                        }
                    }
                } elseif ($className == $this->getReflection()->getName()) {
                    $array[$i] = array_merge_recursive($array[$i], [$classProperty => $value]);
                }
            }
            $i++;
        }
        return $array;
    }
}