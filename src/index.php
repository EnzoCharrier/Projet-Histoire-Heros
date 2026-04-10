<?php
session_start();
// Connexion à la BD
//$db="HistoireHeros";
//$dbhost="192.168.56.10";
//$dbport=3306;
//$dbuser="admin";
//$dbpasswd="admin";

$db="charrier";
$dbhost="charrier.slam.lab";
$dbport=3306;
$dbuser="charrier";
$dbpasswd="QiDjr9mq5PEF";


$pdo = new PDO("mysql:host=$dbhost;port=$dbport;dbname=$db", $dbuser, $dbpasswd);
$pdo->exec("SET NAMES utf8");

// Appel du contrôleur
include("Controleur/ControleurHistoire.php");

$controleur = new ControleurHistoire($pdo);
$controleur->afficher();


/////////* A FAIRE *////////////

// Gerer systeme d'inventaire
// Ajouter données obj
// Gerer changement de stats et effet objet
// Gerer inventaire
// Gerer son


?>
