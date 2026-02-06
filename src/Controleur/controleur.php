<?php

include 'Modèle/modele.php';
include 'Vue/vue.php';


class ControleurAccueil {

	public function afficherAccueil(){

		$modeleAccueil = new ModeleAccueil();
		$pageAccueil = $modeleAccueil -> getAccueil();

		$vueAccueil = new VueAccueil();
		$renduAccueil = $vueAccueil -> rendu($pageAccueil);

		echo $renduAccueil;
		
	}

	public function __construct() {
	}
	public function __destruct(){}
};
?>