<?php

class ModeleHistoire {

    private $pdo;

    //Constructeur modele
        public function __construct($pdo){
            $this->pdo = $pdo;
        }

    // fonction requete pour texte lié a l'id 
        public function getHistoire($id){
            $req = "SELECT * FROM Histoire WHERE id_histoire = :id";
            $reqHistoire = $this->pdo->prepare($req);
            $reqHistoire->bindValue(':id', $id, PDO::PARAM_INT);
            $reqHistoire->execute();
            return $reqHistoire->fetch(PDO::FETCH_ASSOC);
        }


    // fonction requete pour trouver les choix possible lié a l id actuelle
        public function getChoix($id){
            $req = "SELECT * FROM Choix WHERE id_histoire = :id";
            $reqChoix = $this->pdo->prepare($req);
            $reqChoix->bindValue(':id', $id, PDO::PARAM_INT);
            $reqChoix->execute();
            return $reqChoix->fetchAll(PDO::FETCH_ASSOC);
        }
}

?>