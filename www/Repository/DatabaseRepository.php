<?php

namespace App\Repository;

use App\Core\Database;
use App\Core\Helpers;

class DatabaseRepository extends Database {

    public static function getTables() {
        return self::databaseTables();
    }

    public static function getDatas() {
        return self::databaseDatas();
    }

    public static function checkIftablesExist() {
        $response = true;
        foreach (self::getTables() as $table_key => $table_columns) {
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

}