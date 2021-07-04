<?php

namespace App\Services\Database;

use \App\Core\Database as DB;
use App\Core\Helpers;

class Database extends DB {

    public static function getTables() {
        return self::databaseTables();
    }

    public static function checkIftablesExist() {
        $response = true;
        foreach (self::getTables() as $table_key => $table_columns) {
            $query = (new Database)->getPDO()->prepare('SHOW TABLES LIKE \'' . DBPREFIXE . $table_key . '\'');
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
            $query = (new Database)->getPDO()->prepare($query);
            $query->execute();
            return $query->rowCount();
        } else {
            Helpers::error('Erreur interne!');
        }
        return false;
    }

}