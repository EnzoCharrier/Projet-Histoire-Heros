<?php
class VueHistoire {

    // Fonction page d accueil
        public function accueil() {
            echo '<h1>Accueil </h1>';
            echo '<p><a href="index.php?id=1">JOUER</a></p>';
        }


    // Fonction page du jeu
        public function jouer($histoire, $choix) {
            echo "<h1>".$histoire["texte"]."</h1>";
            echo "<h2>Que voulez-vous faire ?</h2>";

            foreach($choix as $unChoix){
                echo '<p>';
                echo '<a href="index.php?id='.$unChoix["id_histoire_1"].'">';
                echo $unChoix["choix_possible"];
                echo '</a>';
                echo '</p>';   
            }
        }
}
?>