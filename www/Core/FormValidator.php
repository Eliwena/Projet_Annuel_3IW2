<?php
namespace App\Core;

class FormValidator {

	public static function check($inputs, $data) {
		$errors = [];
		if( count($data) != count($inputs) ){
			$errors[] = "Tentative de HACK - Faille XSS";
		}else{
			foreach ($inputs as $name => $configInputs) {
				if(	!empty($configInputs["minLength"]) 
					&& is_numeric($configInputs["minLength"]) 
					&& strlen($data[$name]) < $configInputs["minLength"]){

					$errors[] = $configInputs["error"];

				}
			}
	}
		return $errors; //[] vide si ok
	}


}