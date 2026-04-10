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


    // fonction requete pour trouver les choix possible lié a l id actuelle///
        public function getChoix($id){
            $req = "SELECT * FROM Choix WHERE id_histoire = :id";
            $reqChoix = $this->pdo->prepare($req);
            $reqChoix->bindValue(':id', $id, PDO::PARAM_INT);
            $reqChoix->execute();
            return $reqChoix->fetchAll(PDO::FETCH_ASSOC);
        }

        public function isFin($id){
            $req = "SELECT id_histoire FROM Histoire WHERE id_histoire = :id AND texte LIKE '%FIN #%'";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch() !== false;
        }
        
        // Récupère un ennemi par son id
        public function getEnnemi($id_ennemi) {
            $req = "SELECT * FROM Ennemi WHERE id_ennemi = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_ennemi, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Récupère le personnage du joueur
        public function getPersonnage($id_perso) {
            $req = "SELECT * FROM Personnage WHERE Id_perso = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Recupère l'inventaire d'un perso
        public function getInventaire($id_perso) {
            $req = "SELECT Inventaire.quantite, Objets.nom, Objets.type, Objets.effet 
                    FROM Inventaire INNER JOIN Objets ON Inventaire.type = Objets.type 
                    WHERE Inventaire.Id_perso = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
}

?>