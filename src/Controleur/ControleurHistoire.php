<?php
include("Modele/ModeleHistoire.php");
include("Vue/vueHistoire.php");

class ControleurHistoire {

    private $modele;
    private $vue;

    public function __construct($pdo){
        $this->modele = new ModeleHistoire($pdo);
        $this->vue = new VueHistoire();
    }


    


    //Fonction pour afficher les fonction de vue
    public function afficher() {
        $id = (int) $_GET['id'];

       
        

        // action combat
        if (isset($_POST['action_combat'])) {
            $this->tourCombat();
            return;
        }

        //  pages Histoire
        if ($id === 0)
        {
            $this->vue->menu('accueil');
            $this->vue->accueil();
            unset($_SESSION['idPerso']);
        }
    
        else if ($id === 99)
        {
            $this->vue->menu('jeu');
            $this->vue->regles();
        }

        else
        {

            if ($id == 13)
            {
                $_SESSION['idPerso'] = 2;
                
            }
            else if ($id == 12)
            {
                $_SESSION['idPerso'] = 1;
            }

            $histoire = $this->modele->getHistoire($id);
            $choix    = $this->modele->getChoix($id);

            // Si combat est en cours
            if (isset($_SESSION['combat']) && $_SESSION['combat']['id_histoire'] == $id) {
                $this->vue->menu('jeu');
                $this->vue->combat($_SESSION['combat']);
            }

            // Si histoire déclenche un combat 
            else if ($this->estUnCombat($id))
            {
                $id_ennemi = $this->getIdEnnemiPourHistoire($id);
                
                $ennemi = $this->modele->getEnnemi($id_ennemi);

                $personnage = $this->modele->getPersonnage($_SESSION['idPerso']);
                

                // Initialise le var session pour combat
                $_SESSION['combat'] = [
                    'id_histoire'  => $id,
                    'pv_joueur'    => $personnage['pv'],
                    'pv_ennemi'    => $ennemi['pv'],
                    'force_joueur' => $personnage['force'],
                    'force_ennemi' => $ennemi['force'],
                    'nom_ennemi'   => $ennemi['nom'],
                    'choix_victoire' => $choix  // choix victoire
                ];

                $this->vue->menu('jeu');
                $this->vue->combat($_SESSION['combat']);
            }

            else
            {
                $this->vue->menu('jeu');
                $this->vue->jouer($histoire, $choix);
            }
        }
    }


    // fait passer un tour de combat
    private function tourCombat() {
        $combat = $_SESSION['combat'];

        // joueur attaque ennemi
        $combat['pv_ennemi'] -= $combat['force_joueur'];
        

        // ennemi attaque si vie > 0
        if ($combat['pv_ennemi'] > 0) {
            $combat['pv_joueur'] -= $combat['force_ennemi'];
        }

        $this->vue->menu('jeu');


        // victoire
        if ($combat['pv_ennemi'] <= 0) {
            unset($_SESSION['combat']);
            unset($_SESSION['maxJ']);
            unset($_SESSION['maxE']);
            $this->vue->resultatCombat('victoire', $combat['choix_victoire']);
        }
        
        // défaite
        else if ($combat['pv_joueur'] <= 0) {
            unset($_SESSION['combat']);
            unset($_SESSION['maxJ']);
            unset($_SESSION['maxE']);
            $this->vue->resultatCombat('defaite', []);
        } 
        
        else {
            $_SESSION['combat'] = $combat;
            $this->vue->combat($combat);
        }
}

    // Retourne true si id_histoire déclenche combat
    public function estUnCombat($id) {
        $id_combat = [1310210,121022001,1210220001]; // les id ou combat se lance
        return in_array($id, $id_combat);
    }

    public function getIdEnnemiPourHistoire($id) {
        // id histoire qui declenche combat contre tel id ennemi
        $dico = [1310210 => 1, 121022001 => 2,1210220001 => 3];
        return $dico[$id];
    }

    public function getIdPersonnagePourHistoire($id) {
        // id histoire qui declenche combat contre tel id ennemi
        $dico = [12 => 1];
        return $dico[$id];
    }

}

?>