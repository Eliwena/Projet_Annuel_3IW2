<?php

namespace App\Core;

class ConstantManager {

	private $envFile = _ENV_PATH;
	private $data = [];

	public function __construct(){
		if(self::envExist()) {
            $this->parsingEnv($this->envFile);

            if(_ENV_MULTIPLE) {
                if (!empty($this->data["ENV"])) {
                    $newFile = $this->envFile . "." . $this->data["ENV"];
                    if (!file_exists($newFile))
                        Helpers::error("Le fichier " . $newFile . " n'existe pas");
                    $this->parsingEnv($newFile);
                }
            }

            $this->defineConstants();
        }
	}

	public static function envExist() {
        if(file_exists(_ENV_PATH)) {
            return true;
        }
        return false;
    }

	private function defineConstants(){
		foreach ($this->data as $key => $value) {
			self::defineConstant($key, $value);
		}
	}


	public static function defineConstant($key, $value){
		if(!defined($key)){
			if($key == 'DBPREFIXE' && empty($value)) {
                define($key, _DEFAULT_DB_PREFIX . '_');
            } else {
                define($key, $value);
            }
		}else{
		    Helpers::error("Attention vous avez utilisé une constante reservée à ce framework ".$key);
		}
	}


	public function parsingEnv($file){

		$handle = fopen($file, "r");
		$regex = "/([^=]*)=([^#]*)/";

		if(!empty($handle)){
			while (!feof($handle)) {
				
				$line = fgets($handle);
				preg_match($regex, $line, $results);
				if(!empty($results[1]) && !empty($results[2]))
					$this->data[mb_strtoupper($results[1])] = trim($results[2]);

			}
		}

	}

}