<?php
	
	// Database settings
	$db="HistoireHeros";
	$dbhost="192.168.56.10";
	$dbport=3306;
	$dbuser="admin";
	$dbpasswd="admin";
 
	$pdo = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$db.'', $dbuser, $dbpasswd);
	$pdo->exec("SET CHARACTER SET utf8");

	$req='SELECT * FROM Choix WHERE id_histoire =:id';
    $requete = $pdo -> prepare($req);	
	$requete -> bindValue(':id', 2, PDO::PARAM_INT);
	$requete -> execute();
	$resultats = $requete->fetchAll(PDO::FETCH_ASSOC);
	echo '<pre>';
		print_r($resultats);
	echo '</pre>';

	include 'Controleur/controleur.php';

	if(isset($_GET['page'])) $page = $_GET['page'];
	else $page = 1;

	
	if($page == 1){
		$monAccueil = new ControleurAccueil();
		$monAccueil -> afficherAccueil();
	}
$pdo = null;
?>