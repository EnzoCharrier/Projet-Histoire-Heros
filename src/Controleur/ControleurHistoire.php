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
        public function afficher(){

            if(isset($_GET['id']))
            {
                $id = (int) $_GET['id'];
            }    
            else
            {
                $id = 0;
            }

        if($id === 0) {
            // Page d'accueil
                $this->vue->accueil();
        } else {
            // Récupérer l'histoire et les choix
                $histoire = $this->modele->getHistoire($id);
                $choix = $this->modele->getChoix($id);
                $this->vue->jouer($histoire, $choix);
        }
    }
}
?>