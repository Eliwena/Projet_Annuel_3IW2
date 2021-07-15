<?php

namespace App\Core;

use App\Repository\DatabaseRepository;
use \App\Services\Http\Router as RouterService;
use App\Core\Helpers;

class Installer {

    protected static $php_required_version = 7.2;

    protected static $query = '';
    protected $database_datas;
    protected static $database_charset = 'utf8';
    protected static $database_collate = 'utf8_unicode_ci';

    public function __construct() {}

    public static function checkInstall() {
        if(!self::isPHPVersionCompatible()) {
            Helpers::error('Version de PHP incompatible version minimum ' . self::$php_required_version);
            return false;
        }
        if(!self::isPDOExtInstalled()) {
            Helpers::error('PHP Pdo extension non installé');
            return false;
        }
        if(ConstantManager::envExist() && DatabaseRepository::checkIftablesExist() == false) {
            Helpers::error('DATABASE ERROR, Tables manquantes cms corrompu. supprimer le .env et effectué une nouvelle installation');
            return false;
        }
        if(ConstantManager::envExist() == false && RouterService::getCurrentRoute() != 'app_install') {
            RouterService::redirectToRoute('app_install');
            return true;
        }

        return true;
    }

    public static function install() {
        $query = self::queryBuilder() . (_INSTALL_FAKE_DATA ? self::queryDataBuilder() : '');
        $install = DatabaseRepository::makeInstall($query);
        if($install > 0) {
           return true;
        }
        return false;
    }

    protected static function queryBuilder() {
        foreach (DatabaseRepository::getTables() as $table_name => $table_columns) {
            $column_exclude = ['isActive', 'isDeleted', 'createAt', 'updateAt'];
            $index_authorized = ['PRIMARY KEY', 'UNIQUE', 'INDEX', 'FULLTEXT', 'SPATIAL'];

            self::$query .= 'CREATE TABLE IF NOT EXISTS `' . DBPREFIXE . $table_name . '` (';
            self::$query .= '`id` int(11) NOT NULL AUTO_INCREMENT, PRIMARY KEY(id),';

            foreach ($table_columns as $column_name => $column_params) {
                if (!in_array($column_name, $column_exclude)) {
                    if ($column_name != 'foreign_key') {
                        self::$query .= '`' . $column_name . '` ';
                        self::$query .= $column_params['type'];
                        self::$query .= isset($column_params['size']) ? '(' . $column_params['size'] . ')' : '';
                        self::$query .= isset($column_params['null_permitted']) ? '' : ' NOT NULL';
                        self::$query .= isset($column_params['default_value']) ? ' DEFAULT ' . (is_string($column_params['default_value']) ? ($column_params['default_value'] != 'null' ? '\'' : '') . strtoupper($column_params['default_value']) . ($column_params['default_value'] != 'null' ? '\'' : '') : $column_params['default_value']) : '';
                        self::$query .= (isset($column_params['auto_increment']) && $column_params['auto_increment'] != false) ? ' AUTO_INCREMENT ' : '';
                        self::$query .= (isset($column_params['index']) && !in_array($column_params['index'], $index_authorized)) ? $column_params['index'] : '';
                        self::$query .= isset($column_params['comment']) ? ' COMMENT \'' . $column_params['comment'] . '\'' : '';
                        self::$query .= ', ';
                    } else {
                        foreach ($column_params as $foreign_key => $foreign_params) {
                            self::$query .= '`' . $foreign_key . '`' . ' int(11) NOT NULL,';
                            self::$query .= 'FOREIGN KEY (' . $foreign_key . ') REFERENCES ' . DBPREFIXE . $foreign_params['table'] . '(' . $foreign_params['key'] . ')';
                            self::$query .= ', ';
                        }
                    }
                }
            }
            self::$query .= '`isActive` boolean DEFAULT \'1\',';
            self::$query .= ' `isDeleted` boolean DEFAULT \'0\',';
            self::$query .= ' `createAt` DATETIME DEFAULT CURRENT_TIMESTAMP,';
            self::$query .= ' `updateAt` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP';
            self::$query .= ') ENGINE=InnoDB DEFAULT CHARSET=' . self::$database_charset . ' COLLATE=' . self::$database_collate . ';';
        }
        return self::$query;
    }

    protected static function queryDataBuilder() {
        foreach (DatabaseRepository::getDatas() as $table_name => $table_datas) {
            foreach($table_datas as $items) {
                self::$query .= 'INSERT INTO `' . DBPREFIXE . $table_name . '` (';
                foreach ($items as $key => $item) {
                    self::$query .= '`' . $key . '`' . (key(array_slice($items, -1, 1, true)) == $key ? ') ' : ', ');
                }
                self::$query .= 'VALUES (';
                foreach ($items as $key => $item) {
                    self::$query .= '"' . $item . '"' . (key(array_slice($items, -1, 1, true)) == $key ? '); ' : ', ');
                }
            }
        }
        return self::$query;
    }

    public static function isPHPVersionCompatible() {
        if(!version_compare(phpversion(), self::getPHPVersionRequired(), ">=")) {
            die('this framework requires at least PHP version ' . self::getPHPVersionRequired() . ', but installed is version ' . PHP_VERSION . '.');
        } else {
            return true;
        }
    }

    public static function getPHPVersionRequired() {
        return self::$php_required_version;
    }

    public static function isPDOExtInstalled() {
        if(!defined('PDO::ATTR_DRIVER_NAME')) {
            die('this framework require pdo driver.');
        } else {
            return true;
        }
    }

    public static function checkDatabase($dbhost, $dbname, $dbport, $dbuser, $dbpass) {
        $database = new DatabaseRepository(false, $dbhost, $dbname, $dbport, $dbuser, $dbpass);
        return $database->DatabaseExist();
    }

}