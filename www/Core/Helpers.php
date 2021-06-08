<?php

namespace App\Core;

class Helpers {

	public static function cleanFirstname($firstname) {
		return ucwords(mb_strtolower(trim($firstname)));
	}

    //dump le parametre
    public static function debug(...$params) {
        echo '<pre>';
        foreach($params as $param) {
            print_r($param);
        }
        echo '</pre>';
    }

    //renvoi message erreur
    public static function error($message) {
        echo '<style>.framework-error-message{background-color: #fce4e4;border: 1px solid #fcc2c3;padding: 20px 30px;}</style><div class="framework-error-message"><span class="error-text">Erreur : '.$message.'</span></div>';
        die();
    }

}