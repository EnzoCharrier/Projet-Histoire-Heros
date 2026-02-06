<?php

include 'Modèle/modele.php';
include 'Vue/vue.php';


class Page1Controleur {

	public function afficherAccueil(){
		$modele = new Page1Modele();
		$message = $modele -> getMessage();

		$lavue = new Page1Vue();
		$rendu = $lavue -> renduAccueil($message);

		echo $rendu;
		
	}

	public function __construct() {
	}
	public function __destruct(){}
};

?>