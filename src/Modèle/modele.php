<?php

class Page1Modele{

	private $message;


	public function getMessage(){
		return $this -> message; // return this.message
	}

	public function __construct() {
		$this -> message =  "Titre"; // this.message = "Titre"
	}

	public function __destruct(){}

};

?>