<?php

namespace App\Core;

use App\Repository\DatabaseRepository;
use \App\Services\Http\Router as RouterService;
use App\Services\Http\Session;

class Installer {

    protected static $php_required_version = 7.2;

    protected static $query = '';
    protected $database_datas;
    protected static $database_charset = 'utf8';
    protected static $database_collate = 'utf8_unicode_ci';

    public function __construct() {}

    public static function checkInstall() {

        if(ConstantManager::envExist()) {

            if(!self::isPHPVersionCompatible()) {
                Helpers::error('Version de PHP incompatible version minimum ' . self::$php_required_version);
                return false;
            }
            if(!self::isPDOExtInstalled()) {
                Helpers::error('PHP Pdo extension non installé');
                return false;
            }

            if(DatabaseRepository::checkIftablesExist() == false) {
                Helpers::error('DATABASE ERROR, Tables manquantes cms corrompu. supprimer le .env et effectuer une nouvelle installation');
                return false;
            }

        } else {
            if(RouterService::getCurrentRoute() != 'app_install') {
                RouterService::redirectToRoute('app_install');
                return false;
            }
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
        foreach (self::databaseTables() as $table_name => $table_columns) {
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

    public static function queryDataBuilder() {
        foreach (self::databaseDatas() as $table_name => $table_datas) {
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

    //TODO get tables name and property from model instead of this array
    public static function databaseTables() {
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
                'description' => [
                    'type' => 'text',
                ],
                'picture' => [
                    'type' => 'varchar',
                    'size' => 255,
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
            //table permission avec une clé etrangère pour les groupes
            'page' => [
                'name' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'meta_description' => [
                    'type' => 'text'
                ],
                'slug' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'content' => [
                    'type' => 'longtext',
                ],
            ],
            //table review avec une clé etrangère pour les groupes
            'review' => [
                'foreign_key' => [
                    'userId' => [
                        'table' => 'user',
                        'key' => 'id',
                    ],
                ],
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
            //table user_password_request
            'user_password_request' => [
                'foreign_key' => [
                    'userId' => [
                        'table' => 'user',
                        'key' => 'id',
                    ]
                ],
                'token' => [
                    'type' => 'varchar',
                    'size' => 255,
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
            'appearance'=>[
                'title'=>[
                    'type'=> 'varchar',
                    'size'=> 255,
                ],
                'description' =>[
                    'type'=> 'varchar',
                    'size' => 255,
                ],
                'background' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'link_police' =>[
                    'type' => 'varchar',
                    'size' => 255,
                    'null_permitted' => true,
                ],
                'police' =>[
                    'type' => 'varchar',
                    'size' => 255,
                ],
                'police_color'=>[
                    'type'=> 'varchar',
                    'size' =>255,
                ],
                'color_number_1'=>[
                    'type'=> 'varchar',
                    'size' => 255,
                ],
                'color_number_2'=>[
                    'type'=> 'varchar',
                    'size' => 255,
                ],
                'background_image'=>[
                    'type'=>'varchar',
                    'size'=>255,
                ]
            ],
            //nav
            'navigation'=>[
                'name'=>[
                    'type'=> 'varchar',
                    'size'=> 255,
                ],
                'navOrder' =>[
                    'type' => 'int',
                    'size' => 4,
                    'default_value' => 10,
                ],
                'value' => [
                    'type' => 'varchar',
                    'size' => 255,
                ],
            ],
            //table menu_plat avec deux clé étrangère pour les plats et les menus
            'reservation' => [
                'date_reservation' => [
                    'type' => 'date',
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
                'validate'=>[
                    'type' =>'int',
                    'null_permitted' => true,
                ],
                'lastname'=>[
                    'type' =>'varchar',
                    'size' => 255,
                    'null_permitted' => true,

                ],
                'foreign_key' => [
                    'userId' => [
                        'table' => 'user',
                        'key' => 'id',
                        'null_permitted' => true,
                    ],
                ],
            ],
        ];

        return $tables;
    }

    public static function databaseDatas() {
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
                ['name' => 'Original Burger', 'price' => 14.90, 'description' => 'description 1', 'picture' => 'picture1'],
            ],
            'menu_meal' => [
                ['mealId' => 1, 'menuId' => 1],
                ['mealId' => 2, 'menuId' => 1],
            ],
            'permission' => [
                ['name' => 'admin_panel_dashboard', 'description' => 'voir le panel admin'],
                ['name' => 'admin_panel_appearance_list', 'description' => 'voir les apparences'],
                ['name' => 'admin_panel_appearance_add', 'description' => 'ajouter une apparence'],
                ['name' => 'admin_panel_appearance_edit', 'description' => 'editer une apparence'],
                ['name' => 'admin_panel_appearance_delete', 'description' => 'supprimer une apparence'],
                ['name' => 'admin_panel_page_list', 'description' => 'voir les pages'],
                ['name' => 'admin_panel_page_add', 'description' => 'ajouter une page'],
                ['name' => 'admin_panel_page_edit', 'description' => 'editer une page'],
                ['name' => 'admin_panel_page_delete', 'description' => 'supprimer une page'],
                ['name' => 'admin_panel_user_list', 'description' => 'voir les utilisateurs'],
                ['name' => 'admin_panel_user_add', 'description' => 'ajouter un utilisateur'],
                ['name' => 'admin_panel_user_edit', 'description' => 'editer un utilisateur'],
                ['name' => 'admin_panel_user_delete', 'description' => 'supprime un utilisateur'],
                ['name' => 'admin_panel_group_list', 'description' => 'voir les groupes'],
                ['name' => 'admin_panel_group_add', 'description' => 'ajouter un groupe'],
                ['name' => 'admin_panel_group_edit', 'description' => 'editer un groupe'],
                ['name' => 'admin_panel_group_delete', 'description' => 'supprime une groupe'],
                ['name' => 'admin_panel_menu_list', 'description' => 'voir les menus'],
                ['name' => 'admin_panel_menu_add', 'description' => 'ajouter un menu'],
                ['name' => 'admin_panel_menu_edit', 'description' => 'editer un menu'],
                ['name' => 'admin_panel_menu_delete', 'description' => 'supprime une menu'],
                ['name' => 'admin_panel_meal_list', 'description' => 'voir les plats'],
                ['name' => 'admin_panel_meal_add', 'description' => 'ajouter un plat'],
                ['name' => 'admin_panel_meal_edit', 'description' => 'editer un plat'],
                ['name' => 'admin_panel_meal_delete', 'description' => 'supprime une plat'],
                ['name' => 'admin_panel_foodstuff_list', 'description' => 'voir les aliments'],
                ['name' => 'admin_panel_foodstuff_add', 'description' => 'ajouter un aliment'],
                ['name' => 'admin_panel_foodstuff_edit', 'description' => 'editer un aliment'],
                ['name' => 'admin_panel_foodstuff_delete', 'description' => 'supprime une aliment'],
                ['name' => 'admin_panel_reservation_list', 'description' => 'voir les reservations'],
                ['name' => 'admin_panel_reservation_add', 'description' => 'ajouter un reservation'],
                ['name' => 'admin_panel_reservation_edit', 'description' => 'editer un reservation'],
                ['name' => 'admin_panel_reservation_delete', 'description' => 'supprime une reservation'],
                ['name' => 'admin_panel_reservation_validate', 'description' => 'Valider une reservation'],
                ['name' => 'admin_panel_review_list', 'description' => 'voir les commentaires des menus'],
                ['name' => 'admin_panel_review_edit', 'description' => 'editer les commentaires des menus'],
                ['name' => 'admin_panel_review_delete', 'description' => 'supprimer les commentaires des menus'],
                ['name' => 'admin_panel_review_list', 'description' => 'voir la liste des commentaires des menus'],
                ['name' => 'admin_panel_review_show', 'description' => "voir le commentaire d'un menu"],
                ['name' => 'admin_panel_review_delete', 'description' => "supprimer le commentaire d'un menu"],
                ['name' => 'admin_panel_report_list', 'description' => "voir la liste des signalements"],
                ['name' => 'admin_panel_report_show', 'description' => "voir le signalements d'un commentaires"],
                ['name' => 'admin_panel_report_delete', 'description' => "annuler le signalements d'un commentaires"],
                ['name' => 'admin_panel_parameter_list', 'description' => "voir la liste des paramètres du site"],
                ['name' => 'admin_panel_parameter_edit', 'description' => "editer les paramètres du site"],
            ],
            'group_permission' => [
                ['groupId' => 2, 'permissionId' => 1],
                ['groupId' => 2, 'permissionId' => 2],
                ['groupId' => 2, 'permissionId' => 3],
                ['groupId' => 2, 'permissionId' => 4],
            ],
            'website_configuration' => [
                ['name' => 'site_name', 'description' => 'Nom du site', 'value' => 'RestoGuest'],
                ['name' => 'homepage_title', 'description' => "Titre de la page d'accueil", 'value' => 'Accueil - RestoGuest'],
                ['name' => 'meta_description', 'description' => "Description de la page d'accueil", 'value' => 'Bienvenue sur le site de notre restaurant'],
                ['name' => 'phone_number', 'description' => "Numéro de téléphone", 'value' => ''],
                ['name' => 'address', 'description' => "Adresse du restaurant", 'value' => '242 Rue du Faubourg Saint-Antoine, 75012, Paris'],
                ['name' => 'people_number','description'=>'Nombre de personne maximum a la reservation', 'value'=>6],
                ['name' => 'site_logo', 'description' => "Logo du site", 'value' => 'default_logo.png'],
                ['name' => 'site_favicon', 'description' => "Favicon du site", 'value' => 'favicon.ico'],
                ['name' => 'locale', 'description' => 'Langue par défaut', 'value' => 'fr'],
                ['name' => 'oauth_enable', 'description' => 'Connexion par réseau sociaux', 'value' => 'false'],
                ['name' => 'contact_email', 'description' => 'Email de contact', 'value' => 'contact@' . $_SERVER['HTTP_HOST']],
                ['name' => 'ipinfo_key', 'description' => 'Clé Api IPInfo', 'value' => ''],
                ['name' => 'google_analytics', 'description' => 'Clé google analytics', 'value' => ''],
                ['name' => 'oauth_google_client_id', 'description' => 'Google Authentification Client ID', 'value' => ''],
                ['name' => 'oauth_google_secret_id', 'description' => 'Google Authentification Secret ID', 'value' => ''],
                ['name' => 'social_link_facebook', 'description' => 'Lien facebook', 'value' => ''],
                ['name' => 'social_link_instagram', 'description' => 'Lien instragram', 'value' => ''],
                ['name' => 'social_link_tiktok', 'description' => 'Lien TikTok', 'value' => ''],
                ['name' => 'social_link_snapchat', 'description' => 'Lien Snapchat', 'value' => ''],
                ['name' => 'gmail_account', 'description' => 'Email gmail (SMTP)', 'value' => ''],
                ['name' => 'gmail_password', 'description' => 'Mot de passe gmail (SMTP)', 'value' => ''],
            ],
            'user'=> [
                ["firstname"=>'default', "lastname" => 'default', "email" => 'default@default.fr',"password" => 'default',"country" => 'fr', "token" => 'default',]
            ],
            'appearance'=>[
                ["title" => 'CH Dark & Gray', "description" => 'ColorHunt most popular pallet', "background" => '#eeeeee', "link_police" => "https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap;", "police"=>'Roboto, sans-serif;',"police_color"=>" #fff", "color_number_1"=>'#222831', "color_number_2"=>'#393e46','background_image'=>'restaurant.svg', 'isActive'=> 1],
            ],
        ];
        return $datas;
    }

}