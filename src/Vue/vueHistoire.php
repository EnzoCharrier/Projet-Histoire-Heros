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

    public function jouer($histoire, $choix, $personnage, $inventaire) {
        echo '<div class="page-jeu">';

        // Interface Histoire et choix
        echo '<div class="panneau-histoire">';
            echo "<p class='texte-histoire'>" . $histoire["texte"] . "</p>";
            echo "<h2>Que voulez-vous faire ?</h2>";
            if (empty($choix)) {
                echo '<p><a href="index.php" class="btnReset"> Recommencer</a></p>';
            } 
            else {
                foreach ($choix as $unChoix) {
                    echo '<p>';
                        echo '<a href="index.php?id='.$unChoix["id_histoire_1"].'">';
                            echo $unChoix["choix_possible"];
                        echo '</a>';
                    echo '</p>';
                }
            }
        echo '</div>';

        // Interface de stats
         if ($personnage) {
            echo '<div class="panneau-stats">';

                echo '<div class="stats-perso">';
                    echo '<h2> Votre personnage </h2>';
                    echo '<div class="stat-ligne">';
                        echo '<span class="stat-label"> PV</span>';
                        echo '<div class="barre-vie-stat"><div class="vie-stat" style="width:' . $personnage['pv']. '%"></div>';
                    echo '</div>';
                    echo '<span class="stat-valeur">'.$personnage['pv'].'</span>';
                echo '</div>';

                echo '<div class="stat-ligne">';
                    echo '<span class="stat-label">PM</span>';
                    echo '<div class="barre-mana-stat"><div class="mana-stat" style="width:' .$personnage['pm'].'%"></div>';
                echo '</div>';
                echo '<span class="stat-valeur">'.$personnage['pm'].'</span>';
                echo '</div>';
                echo '<div class="stat-ligne">';
                    echo '<span class="stat-label"> Force</span>';
                    echo '<span class="stat-valeur">'.$personnage['force'].'</span>';
                echo '</div>';
                echo '<div class="stat-ligne">';
                    echo '<span class="stat-label">Or</span>';
                    echo '<span class="stat-valeur">'.$personnage['or_'].'</span>';
                echo '</div>';
            echo '</div>';

            // Inventaire
            echo '<div class="inventaire">';
                echo '<h2> Inventaire</h2>';
                if (empty($inventaire)) {
                    echo '<p class="inventaire-vide">Aucun objet</p>';
                } 
                else {
                    echo '<ul class="liste-objets">';
                    foreach ($inventaire as $objet) {
                        echo '<li class="objet">';
                            echo '<span class="objet-nom">'.$objet['nom'].'</span>';
                            echo '<span class="objet-type">'.$objet['type'].'</span>';
                            echo '<span class="objet-effet">+'.$objet['effet'].'</span>';
                            echo '<span class="objet-qte">x'.$objet['quantite'].'</span>';
                        echo '</li>';
                    }
                    echo '</ul>';
                }
            echo '</div>';
         echo '</div>';
        }
        echo '</div>';
        echo '</body></html>';
    }

    // fonction combat
    public function combat($combat) {
        echo '<div>';
        echo '<h2> Combat contre '.$combat['nom_ennemi'].' !</h2>';

        // Barres de vie
        if ((empty($_SESSION['maxJ']) || $_SESSION['maxJ'] == 0) && (empty($_SESSION['maxJ']) || $_SESSION['maxJ'] == 0)){
            $_SESSION['maxJ'] = $combat['pv_joueur']; 
            $_SESSION['maxE'] = $combat['pv_ennemi']; 
        }
        
        $actuelle_joueur =  $combat['pv_joueur'] / $_SESSION['maxJ'] *100;
        $actuelle_ennemi =  $combat['pv_ennemi'] / $_SESSION['maxE'] *100;
        //$personnage['pv'] = $actuelle_joueur;
        

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

            // Bouton pour différentes actions en combat
            echo '<div class="boutons-combat">';

                // Bouton Attaquer
                echo '<form method="POST">';
                    echo '<input type="hidden" name="action_combat_attaque" value="attaquer">';
                    echo '<button type="submit" class="btn-attaque"> Attaquer</button>';
                echo '</form>';

                // Bouton Esquive
                echo '<form method="POST">';
                    echo '<input type="hidden" name="action_combat_esquive" value="esquiver">';
                    echo '<button type="submit" class="btn-esquive"> Esquiver</button>';
                echo '</form>';


            echo '</div>';
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