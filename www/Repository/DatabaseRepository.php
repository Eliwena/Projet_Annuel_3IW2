<?php

namespace App\Repository;

use App\Core\Database;
use App\Core\Framework;
use App\Core\Helpers;
use App\Core\Installer;
use App\Services\Http\Message;

class DatabaseRepository extends Database {

    protected $pdo;
    protected $dbhost;
    protected $dbname;
    protected $dbport;
    protected $dbuser;
    protected $dbpass;
    protected $dbprefix;

    public function __construct($init = true, $dbhost = null, $dbname = null, $dbport = null, $dbuser = null, $dbpass = null, $dbprefix = null)
    {
        parent::__construct($init);
        $this->dbhost = $dbhost;
        $this->dbname = $dbname;
        $this->dbport = $dbport;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        $this->dbprefix = $dbprefix;
    }

    public static function checkIftablesExist() {
        $response = true;
        foreach (Installer::databaseTables() as $table_key => $table_columns) {
            $query = (new DatabaseRepository)->getPDO()->prepare('SHOW TABLES LIKE \'' . DBPREFIXE . $table_key . '\'');
            $query->execute();
            if($query->rowCount() > 0 && $response != false) {
                $response = true;
            } else {
                $response = false;
            }
        }
        return $response;
    }

    public static function makeInstall($query = null) {
        if(!is_null($query)) {
            $query = (new DatabaseRepository)->getPDO()->prepare($query);
            $query->execute();
            return $query->rowCount();
        } else {
            Helpers::error('Erreur interne!');
        }
        return false;
    }

    private function pdo() {
        try {
            $this->pdo = new \PDO("mysql:host=".$this->dbhost.";dbname=".$this->dbname.";dbport=".$this->dbport, $this->dbuser, $this->dbpass);
            return $this->pdo;
        } catch (\PDOException $exception) {
            Message::create('Erreur de connexion SQL', $exception->getMessage());
            header('location: ' . Framework::getUrl('app_install'));
        }
        return false;
    }

    public function DatabaseExist() {
        $pdo = $this->pdo();
        $query = "SHOW DATABASES LIKE '".$this->dbname."'";
        $result = $this->execute($query, $pdo);
        if($result) {
            return true;
        }
        return false;
    }

}