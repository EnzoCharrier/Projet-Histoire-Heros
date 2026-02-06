<?php

class ModeleAccueil{
	private $message;
	public function getAccueil(){
		return $this -> message;
	}

	public function __construct() {
		$this -> message =  "Titre";
	}

	public function __destruct(){}

};
?>