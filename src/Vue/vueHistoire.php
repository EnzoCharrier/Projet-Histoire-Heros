<?php
class VueHistoire {

    public function menu(){
        echo '<!DOCTYPE html><html lang="fr"><head>';
        echo '<meta charset="UTF-8">';
        echo '<link rel="stylesheet" href="style/style.css">';
        echo '</head><body>';
        echo "<h1> Projet Histoire Heros </h1>";
    }
    // Fonction page d accueil
        public function accueil() {
            echo '<h1>Accueil </h1>';
            echo '<div class ="menu-boutons">';
            echo '<p><a href="index.php?id=1">JOUER</a></p>';
            echo '<p><a href="index.php?id=99">REGLES</a></p>';
            echo '</div>';

        }

        public function regles() {
            echo '<h1>Règles </h1>';
            

        }


    // Fonction page du jeu
        public function jouer($histoire, $choix) {
            echo "<div>";
                echo "<p class='texte-histoire'>".$histoire["texte"]."</p>";
                //echo "<h1>".$histoire["texte"]."</h1>";
                echo "<h2>Que voulez-vous faire ?</h2>";

                foreach($choix as $unChoix){
                echo '<p>';
                    echo '<a href="index.php?id='.$unChoix["id_histoire_1"].'">';
                        echo $unChoix["choix_possible"];
                    echo '</a>';
                echo '</p>';
            
            }
            echo "</div>";
            echo '</body></html>';
        }
}
?>