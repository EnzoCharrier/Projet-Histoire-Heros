<?php

class ModeleHistoire {

    private $pdo;

    //Constructeur modele
        public function __construct($pdo){
            $this->pdo = $pdo;
        }

    // fonction requete pour texte li� a l'id 
        public function getHistoire($id){
            $req = "SELECT * FROM Histoire WHERE id_histoire = :id";
            $reqHistoire = $this->pdo->prepare($req);
            $reqHistoire->bindValue(':id', $id, PDO::PARAM_INT);
            $reqHistoire->execute();
            return $reqHistoire->fetch(PDO::FETCH_ASSOC);
        }


    // fonction requete pour trouver les choix possible li� a l id actuelle///
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
        
        // R�cup�re un ennemi par son id
        public function getEnnemi($id_ennemi) {
            $req = "SELECT * FROM Ennemi WHERE id_ennemi = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_ennemi, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // R�cup�re le personnage du joueur
        public function getPersonnage($id_perso) {
            $req = "SELECT * FROM Personnage WHERE Id_perso = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Recup�re l'inventaire d'un perso
        public function getInventaire($id_perso) {
            $req = "SELECT Inventaire.quantite, Inventaire.id_objet, Objets.nom, Objets.type, Objets.effet 
            FROM Inventaire 
            INNER JOIN Objets ON Inventaire.id_objet = Objets.id_objet 
            WHERE Inventaire.Id_perso = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getObjet($id_objet) {
            $req = "SELECT * FROM Objets WHERE id_objet = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_objet, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function getObjetsParTypes(array $types = []) {
            if (empty($types)) {
                $req = "SELECT * FROM Objets";
                $stmt = $this->pdo->prepare($req);
                $stmt->execute();
            } else {
                $placeholders = implode(',', array_fill(0, count($types), '?'));
                $req = "SELECT * FROM Objets WHERE type IN ($placeholders)";
                $stmt = $this->pdo->prepare($req);
                foreach ($types as $index => $type) {
                    $stmt->bindValue($index + 1, $type, PDO::PARAM_STR);
                }
                $stmt->execute();
            }

            $objets = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($objets as &$objet) {
                $objet['prix'] = $this->calculerPrixObjet($objet);
            }
            return $objets;
        }

        public function getPrixObjet(array $objet) {
            return $this->calculerPrixObjet($objet);
        }

        private function calculerPrixObjet(array $objet) {
            switch ($objet['type']) {
                case 'attaque':
                    return max(10, abs((int) $objet['effet']) * 3);
                case 'soin':
                    return max(5, abs((int) $objet['effet']) * 2);
                case 'force':
                    return max(15, abs((int) $objet['effet']) * 4);
                case 'esquive':
                    return 20;
                default:
                    return 15;
            }
        }

        public function useObjet($id_perso, $id_objet) {
            $req = "SELECT quantite FROM Inventaire WHERE Id_perso = :id AND id_objet = :id_objet";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->bindValue(':id_objet', $id_objet, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return;
            }

            if ($result['quantite'] > 1) {
                $reqUpdate = "UPDATE Inventaire SET quantite = quantite - 1 WHERE Id_perso = :id AND id_objet = :id_objet";
                $stmtUpdate = $this->pdo->prepare($reqUpdate);
                $stmtUpdate->bindValue(':id', $id_perso, PDO::PARAM_INT);
                $stmtUpdate->bindValue(':id_objet', $id_objet, PDO::PARAM_INT);
                $stmtUpdate->execute();
            } else {
                $reqDelete = "DELETE FROM Inventaire WHERE Id_perso = :id AND id_objet = :id_objet";
                $stmtDelete = $this->pdo->prepare($reqDelete);
                $stmtDelete->bindValue(':id', $id_perso, PDO::PARAM_INT);
                $stmtDelete->bindValue(':id_objet', $id_objet, PDO::PARAM_INT);
                $stmtDelete->execute();
            }
        }

        // Ajoute ou retire de l'or au personnage
        public function addOr($id_perso, $quantite) {
            $req = "UPDATE Personnage SET or_ = or_ + :quantite WHERE Id_perso = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':quantite', $quantite, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->execute();
        }

        public function resetOr($id_perso, $montant) {
            $req = "UPDATE Personnage SET or_ = :montant WHERE Id_perso = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':montant', $montant, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->execute();
        }

        public function resetInventaire($id_perso) {
            $req = "DELETE FROM Inventaire WHERE Id_perso = :id";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->execute();
        }

        public function addObjet($id_perso, $id_objet, $quantite) {
            $req = "SELECT quantite FROM Inventaire WHERE Id_perso = :id AND id_objet = :id_objet";
            $stmt = $this->pdo->prepare($req);
            $stmt->bindValue(':id', $id_perso, PDO::PARAM_INT);
            $stmt->bindValue(':id_objet', $id_objet, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $reqUpdate = "UPDATE Inventaire SET quantite = quantite + :quantite 
                      WHERE Id_perso = :id AND id_objet = :id_objet";
                $stmtUpdate = $this->pdo->prepare($reqUpdate);
                $stmtUpdate->bindValue(':quantite', $quantite, PDO::PARAM_INT);
                $stmtUpdate->bindValue(':id', $id_perso, PDO::PARAM_INT);
                $stmtUpdate->bindValue(':id_objet', $id_objet, PDO::PARAM_INT);
                $stmtUpdate->execute();
            }
            else {
                $reqInsert = "INSERT INTO Inventaire (Id_perso, id_objet, quantite) 
                      VALUES (:id, :id_objet, :quantite)";
                $stmtInsert = $this->pdo->prepare($reqInsert);
                $stmtInsert->bindValue(':id', $id_perso, PDO::PARAM_INT);
                $stmtInsert->bindValue(':id_objet', $id_objet, PDO::PARAM_INT);
                $stmtInsert->bindValue(':quantite', $quantite, PDO::PARAM_INT);
                $stmtInsert->execute();
            }   
        }
}
?>