<?php

namespace App\Core;

class FormBuilder
{

	public function __construct(){

	}

	public static function render($config, $show=true){

		$html = "<form 
				method='".($config["Configurations"]["method"]??"GET")."' 
				action='".($config["Configurations"]["action"]??"")."'
				class='".($config["Configurations"]["class"]??"")."'
				id='".($config["Configurations"]["id"]??"")."'
				>";


		foreach ($config["inputs"] as $name => $configInput) {
			$html .="<label for='".($configInput["id"]??$name)."'>".($configInput["label"]??"")." </label>";

			$html .="<input 
						type='".($configInput["type"]??"text")."'
						name='".$name."'
						placeholder='".($configInput["placeholder"]??"")."'
						class='".($configInput["class"]??"")."'
						id='".($configInput["id"]??$name)."'
						".(!empty($configInput["required"])?"required='required'":"")."
						 ><br>";
		}




		$html .= "<input type='submit' value=\"".($config["Configurations"]["submit"]??"Valider")."\">";
		$html .= "</form>";


		if($show){
			echo $html;
		}else{
			return $html;
		}

	}

}