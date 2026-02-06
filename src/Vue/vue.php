<?php

	class VueAccueil{

		public function rendu($message){
					
		 $accueil =  "<!doctype html>
						<html lang='fr'>
		 					<head>
		 						<meta charset='utf-8''>
		 						<title> Mon app MVC </title>
		 					</head>
		 					<body>
								<h1>$message</h1>
		 					</body>
						</html>";
			return $accueil;
		}

		public function __construct() {}
		public function __destruct(){}
	}
?>