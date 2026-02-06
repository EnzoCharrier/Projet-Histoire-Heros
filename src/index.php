<?php
 
	include 'Controleur/controleur.php';

	if(isset($_GET['page'])) $page = $_GET['page'];
	else $page = 1;

	
	if($page == 1){
		$monAccueil = new ControleurAccueil();
		$monAccueil -> afficherAccueil();
	}

?>