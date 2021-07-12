<?php

namespace App\Core;

use App\Core\Exceptions\DatabaseException;

Abstract class Database {

	private $pdo;
	private $query;
	protected $className = null;
	protected $tableName = null;
	protected $parameterExcluded = ['className', 'tableName', 'joinParameters', 'parameterExcluded'];

	public function __construct($init = true){
        if($init) {
            $this->init();
        }
	 	$classExploded = explode("\\", get_called_class());
	    $this->setTableName(is_null($this->tableName) ? DBPREFIXE . end($classExploded) : DBPREFIXE . $this->tableName); // Par défaut le nom de table est issue du nom de la classe sauf si dans la classe fille on définit une variable "protected $tableName = 'nom_de_la_table';"
	    $this->setClassName($this->getReflection());
	}

	private function init() {
        try {
            $this->pdo = new \PDO( DBDRIVER.":host=".DBHOST.";dbname=".DBNAME.";port=".DBPORT , DBUSER , DBPWD );
        } catch(DatabaseException $databaseException) {
            Helpers::error("Erreur de connexion SQL : ".$databaseException->getMessage());
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

    public function execute($query) {
        try {
            $query = $this->getPDO()->query($query);
            $query->execute();
            return $query->fetch(\PDO::FETCH_ASSOC);
        } catch(DatabaseException $databaseException) {
            Helpers::error("Erreur lors de la req SQL : ".$databaseException->getMessage());
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
        } catch(DatabaseException $databaseException) {
            Helpers::error("Erreur lors de la req SQL : ".$databaseException->getMessage());
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
        } catch(DatabaseException $databaseException) {
            Helpers::error("Erreur lors de la req SQL : ".$databaseException->getMessage());
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
        } catch(DatabaseException $databaseException) {
            Helpers::error("Erreur lors de la req SQL : ".$databaseException->getMessage());
        }

        return $response;

    }

	public function save() {

        $propsToImplode = [];

        foreach ($this->getClassName()->getProperties() as $property) {
            if(in_array($property->getName(), $this->parameterExcluded) == false and $property->getName() != 'id') {
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
        } else {
            $query = $this->getPDO()->prepare('INSERT INTO `' . $this->getTableName() . '` SET ' . $setClause );
        }

        $query->execute();
        if($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
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

    //TODO get tables name and property from model instead of this array
    protected static function databaseTables() {
        $tables = [
            //table user
            'user' => [
                'firstname' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'lastname' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'email' => [
                    'type' => 'longtext', //max 320 char
                    'comment' => 'champs email.'
                ],
                'password' => [
                    'type' => 'varchar',
                    'size' => 255,
                    'null_permitted' => true,
                    'default_value' => 'null',
                ],
                'country' => [
                    'type' => 'varchar',
                    'size' => 10,
                    'default_value' => 'fr_FR',
                ],
                'token' => [
                    'type' => 'varchar',
                    'size' => 255,
                    'null_permitted' => true,
                    'default_value' => 'null',
                ],
                'status' => [
                    'type' => 'int',
                    'size' => 3,
                    'default_value' => 1,
                ],
                'client' => [
                    'type' => 'varchar',
                    'size' => 255,
                    'null_permitted' => true,
                    'default_value' => 'null',
                ],
            ],
            //table aliment
            'foodstuff' => [
                'name' => [
                    'type' => 'varchar',
                    'size' => 45,
                ],
                'price' => [
                    'type' => 'double',
                ],
                'stock' => [
                    'type' => 'int',
                    'size' => 11,
                    'default_value' => 0,
                ],
            ],
            //table plat
            'meal' => [
                'name' => [
                    'type' => 'varchar',
                    'size' => 45,
                ],
                'price' => [
                    'type' => 'double',
                ],
            ],
            //table menu
            'menu' => [
                'name' => [
                    'type' => 'varchar',
                    'size' => 45,
                ],
                'price' => [
                    'type' => 'double',
                ],
            ],
            //table groupe
            'group' => [
                'name' => [
                    'type' => 'varchar',
                    'size' => 45,
                ],
                'description' => [
                    'type' => 'varchar',
                    'size' => 45,
                ],
                'groupOrder' => [
                    'type' => 'int',
                    'size' => 4,
                    'default_value' => 100,
                ],
            ],
            //table website_configuration
            'website_configuration' => [
                'name' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'description' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'value' => [
                    'type' => 'longtext',
                ]
            ],
            //table analytics
            'analytics' => [
                'clientIp' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'route' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
            ],
            //table permission avec une clé etrangère pour les groupes
            'permission' => [
                'name' => [
                    'type' => 'varchar',
                    'size' => 45,
                ],
                'description' => [
                    'type' => 'varchar',
                    'size' => 45,
                ],
            ],
            //table review avec une clé etrangère pour les groupes
            'review' => [
                'title' => [
                    'type' => 'varchar',
                    'size' => 80,
                ],
                'text' => [
                    'type' => 'longtext',
                ],
                'note' => [
                    'type' => 'double',
                ],
            ],
            'report' => [
                'reason' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'foreign_key' => [
                    'reviewId' => [
                        'table' => 'review',
                        'key' => 'id',
                    ],
                ],
            ],
            'review_menu' => [
                'foreign_key' => [
                    'reviewId' => [
                        'table' => 'review',
                        'key' => 'id',
                    ],
                    'menuId' => [
                        'table' => 'menu',
                        'key' => 'id',
                    ],
                ],
            ],
            //table group_permission avec une clé etrangère pour les groupes et les permission
            'group_permission' => [
                'foreign_key' => [
                    'groupId' => [
                        'table' => 'group',
                        'key' => 'id',
                    ],
                    'permissionId' => [
                        'table' => 'permission',
                        'key' => 'id',
                    ],
                ],
            ],
            //table permission avec une clé etrangère pour les groupes et les utilisateurs
            'user_group' => [
                'foreign_key' => [
                    'userId' => [
                        'table' => 'user',
                        'key' => 'id',
                    ],
                    'groupId' => [
                        'table' => 'group',
                        'key' => 'id',
                    ],
                ],
            ],
            //table meal_foodstuff avec deux clé étrangère pour les aliments et les plats
            'meal_foodstuff' => [
                'foreign_key' => [
                    'mealId' => [
                        'table' => 'meal',
                        'key' => 'id',
                    ],
                    'foodstuffId' => [
                        'table' => 'foodstuff',
                        'key' => 'id',
                    ],
                ],
            ],
            //table menu_plat avec deux clé étrangère pour les plats et les menus
            'menu_meal' => [
                'foreign_key' => [
                    'mealId' => [
                        'table' => 'meal',
                        'key' => 'id',
                    ],
                    'menuId' => [
                        'table' => 'menu',
                        'key' => 'id',
                    ],
                ],
            ],
            //table menu_plat avec deux clé étrangère pour les plats et les menus
            'reservation' => [
                'date_reservation' => [
                    'type' => 'datetime',
                    'null_permitted' => true,
                ],
                'hour'=>[
                    'type' =>'time',
                    'null_permitted' => true,
                ],
                'nbPeople'=>[
                    'type' =>'int',
                    'null_permitted' => true,
                ],
                'foreign_key' => [
                    'userId' => [
                        'table' => 'user',
                        'key' => 'id',
                    ],
                ],
            ],
        ];

        return $tables;
    }

    protected static function databaseDatas() {
	    $datas = [
	        'foodstuff' => [
	            ['name' => 'Jus de fruits', 'price' => '1.5', 'stock' => 80],
	            ['name' => 'Oasis', 'price' => '1.2', 'stock' => 50],
	            ['name' => 'Perrier', 'price' => '1', 'stock' => 20],
	            ['name' => 'Evian', 'price' => '0.8', 'stock' => 150],
	            ['name' => 'Bière', 'price' => '2', 'stock' => 50],
	            ['name' => 'Frite', 'price' => '3', 'stock' => 500],
	            ['name' => 'Steak haché de boeuf', 'price' => '8', 'stock' => 500],
	            ['name' => 'Cheddar', 'price' => '2', 'stock' => 500],
	            ['name' => 'Oignon rouges', 'price' => '0.7', 'stock' => 500],
	            ['name' => 'Salade', 'price' => '0.5', 'stock' => 500],
	            ['name' => 'Pain Bun\'s', 'price' => '0.5', 'stock' => 500],
            ],
            'group' => [
                ['name' => 'SUPER_ADMIN', 'description' => 'Administrateur', 'groupOrder' => 1],
                ['name' => 'MOD', 'description' => 'Modérateur', 'groupOrder' => 5],
                ['name' => 'CLIENT', 'description' => 'Client', 'groupOrder' => 10],
            ],
            'meal' => [
                ['name' => 'Frite', 'price' => 4.70],
                ['name' => 'Burger', 'price' => 9.90]
            ],
            'meal_foodstuff' => [
                ['mealId' => 1, 'foodstuffId' => 6],
                ['mealId' => 2, 'foodstuffId' => 7],
                ['mealId' => 2, 'foodstuffId' => 8],
                ['mealId' => 2, 'foodstuffId' => 9],
                ['mealId' => 2, 'foodstuffId' => 10],
                ['mealId' => 2, 'foodstuffId' => 11]
            ],
            'menu' => [
                ['name' => 'Original Burger', 'price' => 14.90],
            ],
            'menu_meal' => [
                ['mealId' => 1, 'menuId' => 1],
                ['mealId' => 2, 'menuId' => 1],
            ],
            'permission' => [
                ['name' => 'admin_panel_dashboard', 'description' => 'voir le panel admin'],
                ['name' => 'admin_panel_review_list', 'description' => 'voir les commentaires des menus'],
                ['name' => 'admin_panel_review_edit', 'description' => 'editer les commentaires des menus'],
                ['name' => 'admin_panel_review_delete', 'description' => 'supprimer les commentaires des menus'],
            ],
            'group_permission' => [
                ['groupId' => 2, 'permissionId' => 1],
                ['groupId' => 2, 'permissionId' => 2],
                ['groupId' => 2, 'permissionId' => 3],
                ['groupId' => 2, 'permissionId' => 4],
            ],
            'website_configuration' => [
                ['name' => 'site_name', 'description' => 'Nom du site', 'value' => 'RestoGuest'],
                ['name' => 'homepage_title', 'description' => 'Titre de la page d\'accueil', 'value' => 'Accueil - RestoGuest'],
                ['name' => 'meta_description', 'description' => 'Description de la page d\'accueil', 'value' => 'Bienvenue sur le site de notre restaurant'],
                ['name' => 'locale', 'description' => 'Langue par défaut', 'value' => 'fr'],
                ['name' => 'oauth_enable', 'description' => 'Connexion par réseau sociaux', 'value' => '0'],
                ['name' => 'contact_email', 'description' => 'Email de contact', 'value' => 'contact@' . $_SERVER['HTTP_HOST']],
            ]
        ];
	    return $datas;
    }
}