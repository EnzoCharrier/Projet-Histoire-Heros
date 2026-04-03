<?php
class VueHistoire {

    public function menu($classe='jeu'){
        echo '<!DOCTYPE html><html lang="fr"><head>';
        echo '<meta charset="UTF-8">';
        echo '<link rel="stylesheet" href="style/style.css">';
        echo '</head><body class="'.$classe.'">';
            echo "<h1>Projet Histoire Heros</h1>";
    }

    public function accueil() {
        echo '<div class="page-accueil">';
            echo '<h1>Accueil</h1>';
                echo '<div class="menu-boutons">';
                    echo '<p><a href="index.php?id=1">JOUER</a></p>';
                    echo '<p><a href="index.php?id=99">REGLES</a></p>';
                echo '</div>';
        echo '</div>';
    echo '</body></html>';
}

    public function regles() {
        echo '<div>';
            echo '<h2>Règles du jeu</h2>';
            echo '<p class="texte-histoire">les règles</p>';
            echo '<p><a href="index.php">Retour à l\'accueil</a></p>';
        echo '</div>';
    echo '</body></html>';
}

    public function jouer($histoire, $choix) {
        echo "<div>";
            echo "<p class='texte-histoire'>".$histoire["texte"]."</p>";
            echo "<h2>Que voulez-vous faire ?</h2>";
            if (empty($choix)) {
                echo '<p><a href="index.php" class="btnReset">Recommencer</a></p>';
            } else {
                foreach($choix as $unChoix){
                    echo '<p>';
                        echo '<a href="index.php?id='.$unChoix["id_histoire_1"].'">';
                        echo $unChoix["choix_possible"];
                        echo '</a>';
                    echo '</p>';
                }
            }
        echo "</div>";
        echo '</body></html>';
    }

    public function combat($combat) {
        echo '<div>';
        echo '<h2> Combat contre '.$combat['nom_ennemi'].' !</h2>';

        // Barres de vie
    if ($_SESSION['maxJ'] == 0 && $_SESSION['maxE'] == 0){
        $_SESSION['maxJ'] = $combat['pv_joueur']; 
        $_SESSION['maxE'] = $combat['pv_ennemi']; 
    }
        
        $actuelle_joueur =  $combat['pv_joueur'] / $_SESSION['maxJ'] *100;
        $actuelle_ennemi =  $combat['pv_ennemi'] / $_SESSION['maxE'] *100;
        

        echo '<div class="combat-stats">';

            echo '<div class="combattant">';
                echo '<p> Vous</p>';
                echo '<div class="barre-vie"><div class="vie-joueur" style="width:'.$actuelle_joueur.'%"></div></div>';
                echo '<p>'.$combat['pv_joueur'].' PV</p>';
            echo '</div>';

            echo '<div class="vs">VS</div>';

            echo '<div class="combattant">';
                echo '<p> '.$combat['nom_ennemi'].'</p>';
                echo '<div class="barre-vie"><div class="vie-ennemi" style="width:'.$actuelle_ennemi.'%"></div></div>';
                    echo '<p>'.$combat['pv_ennemi'].' PV</p>';
                echo '</div>';
            echo '</div>';

            // Bouton attaquer
            echo '<form method="POST">';
                echo '<input type="hidden" name="action_combat" value="attaquer">';
                echo '<button type="submit" class="btn-attaque"> Attaquer</button>';
            echo '</form>';
        echo '</div>';
    echo '</body></html>';
}

    public function resultatCombat($resultat, $choix) {
        echo '<div>';
            if ($resultat === 'victoire') {
                echo '<h2> Victoire !</h2>';
                echo '<p class="texte-histoire">Vous avez triomphé de votre ennemi.</p>';
                echo '<h2>Que voulez-vous faire ?</h2>';
                foreach ($choix as $unChoix) {
                    echo '<p><a href="index.php?id='.$unChoix["id_histoire_1"].'">'.$unChoix["choix_possible"].'</a></p>';
                }
            }
        else 
        {
            echo '<h2> Défaite...</h2>';
            echo '<p class="texte-histoire">Vous avez succombé à vos blessures.</p>';
            echo '<p><a href="index.php" class="btnReset">Recommencer</a></p>';
        }

    echo '</div>';
    echo '</body></html>';
}



}
?>