<?php
class VueHistoire {

    public function menu($classe = 'jeu') {
        echo '<!DOCTYPE html>';
        echo '<html lang="fr">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<link rel="stylesheet" href="style/style.css">';
        echo '</head>';
        echo '<body class="'.$classe.'">';
        echo '<h1>Ashen Oath</h1>';
    }

    // PAGE ACCUEIL
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

    //PAGE REGLES
    public function regles() {
        echo '<div>';
            echo '<h2>Règles du jeu</h2>';
            echo '<p class="texte-histoire">Durant votre partie il y a plusieurs choses a savoir : </p>';
            echo '<p class="texte-histoire"> - Ce jeu est doté de plusieurs fin qui peuvent être plus ou moins difficiles a obtenir selon vos choix</p>';
            echo '<p class="texte-histoire"> - Vos statistique varieront selon votre personnage</p>';
            echo '<p class="texte-histoire"> - Les objets sont uniques et peuvent être utilisé une seule fois par exemplaire</p>';
            echo '<p class="texte-histoire"> - Votre personnage se soignera après chaque combat</p>';
            echo '<p><a href="index.php">Retour à l\'accueil</a></p>';
        echo '</div>';
        echo '</body></html>';
    }

    // PAGE JEU
    public function jouer($histoire, $choix, $personnage, $inventaire) {
        echo '<div class="page-jeu">';

            // emplacement histoire
            echo '<div class="panneau-histoire">';
                echo '<p class="texte-histoire">' . $histoire["texte"] . '</p>';
                echo '<h2>Que voulez-vous faire ?</h2>';
                if (empty($choix)) {
                    echo '<p><a href="index.php" class="btnReset">Recommencer</a></p>';
                } else {
                    foreach ($choix as $unChoix) {
                        echo '<p>';
                            echo '<a href="index.php?id=' . $unChoix["id_histoire_1"] . '">';
                                echo $unChoix["choix_possible"];
                            echo '</a>';
                        echo '</p>';
                    }
                }
            echo '</div>';

            // emplacement stats
            $this->panneauStats($personnage, $inventaire);

        echo '</div>';
        echo '</body></html>';
    }

    public function magasin($histoire, $choix, $personnage, $inventaire, $objets, $message = '') {
        echo '<div class="page-jeu">';

            echo '<div class="panneau-histoire">';
                echo '<p class="texte-histoire">' . $histoire["texte"] . '</p>';
                if (!empty($message)) {
                    echo '<p class="message-magasin">' . $message . '</p>';
                }
                echo '<h2>Boutique</h2>';

                if (empty($objets)) {
                    echo '<p>Aucun objet en vente.</p>';
                } else {
                    foreach ($objets as $objet) {
                        echo '<div class="objet-magasin">';
                            echo '<strong>' . $objet['nom'] . '</strong>';
                            echo '<p>Type : ' . $objet['type'] . '</p>';
                            echo '<p>Effet : ' . $objet['effet'] . '</p>';
                            echo '<p>Prix : ' . $objet['prix'] . ' or</p>';
                            echo '<form method="POST">';
                                echo '<input type="hidden" name="action_acheter_objet" value="1">';
                                echo '<input type="hidden" name="objet_id" value="' . $objet['id_objet'] . '">';
                                echo '<button type="submit" class="btn-achat">Acheter</button>';
                            echo '</form>';
                        echo '</div>';
                    }
                }

                echo '<h2>Que voulez-vous faire ?</h2>';
                if (empty($choix)) {
                    echo '<p><a href="index.php" class="btnReset">Recommencer</a></p>';
                } else {
                    foreach ($choix as $unChoix) {
                        echo '<p>';
                            echo '<a href="index.php?id=' . $unChoix["id_histoire_1"] . '">';
                                echo $unChoix["choix_possible"];
                            echo '</a>';
                        echo '</p>';
                    }
                }
            echo '</div>';

            $this->panneauStats($personnage, $inventaire);

        echo '</div>';
        echo '</body></html>';
    }

    // PAGE COMBAT
    public function combat($combat, $personnage = null, $inventaire = []) {
        // Initialise les PV max une seule fois
        if (empty($_SESSION['maxJ']) || $_SESSION['maxJ'] == 0) {
            $_SESSION['maxJ'] = $combat['pv_joueur'];
            $_SESSION['maxE'] = $combat['pv_ennemi'];
        }

        if ($_SESSION['maxJ'] > 0) {
            $pct_joueur = ($combat['pv_joueur'] / $_SESSION['maxJ']) * 100;
        } else {
            $pct_joueur = 0;
        }

        if ($pct_joueur < 0) {
            $pct_joueur = 0;
        } else if ($pct_joueur > 100) {
            $pct_joueur = 100;
        }

        if ($_SESSION['maxE'] > 0) {
            $pct_ennemi = ($combat['pv_ennemi'] / $_SESSION['maxE']) * 100;
        } else {
            $pct_ennemi = 0;
        }

        if ($pct_ennemi < 0) {
            $pct_ennemi = 0;
        } else if ($pct_ennemi > 100) {
            $pct_ennemi = 100;
        }

        echo '<div class="page-jeu">';
            echo '<div class="panneau-histoire">';

                echo '<h2>Combat contre '.$combat['nom_ennemi'].' !</h2>';

                // Message du dernier tour
                if (!empty($combat['dernier_message'])) {
                    echo '<p class="message-combat">'.$combat['dernier_message'].'</p>';
                }

                // Barres de vie
                echo '<div class="combat-stats">';
                    echo '<div class="combattant">';
                        echo '<p>Vous</p>';
                        echo '<div class="barre-vie">';
                            echo '<div class="vie-joueur" style="width:'.$pct_joueur.'%"></div>';
                        echo '</div>';
                        echo '<p>'.$combat['pv_joueur'].' PV</p>';
                    echo '</div>';

                    echo '<div class="vs">VS</div>';

                    echo '<div class="combattant">';
                        echo '<p>'.$combat['nom_ennemi'].'</p>';
                        echo '<div class="barre-vie">';
                            echo '<div class="vie-ennemi" style="width:'.$pct_ennemi.'%"></div>';
                        echo '</div>';
                        echo '<p>'.$combat['pv_ennemi'].' PV</p>';
                    echo '</div>';
                echo '</div>';

                // Boutons d'action
                echo '<div class="boutons-combat">';

                    // Attaquer
                    echo '<form method="POST">';
                        echo '<input type="hidden" name="action_combat_attaque" value="attaquer">';
                        echo '<button type="submit" class="btn-attaque"> Attaquer</button>';
                    echo '</form>';

                    // Esquiver
                    echo '<form method="POST">';
                        echo '<input type="hidden" name="action_combat_esquive" value="esquiver">';
                        echo '<button type="submit" class="btn-esquive"> Esquiver</button>';
                    echo '</form>';

                echo '</div>';

                // Utiliser un objet (liste déroulante)
                if (!empty($inventaire)) {
                    echo '<form method="POST" class="form-objet">';
                        echo '<input type="hidden" name="action_combat_utiliser_objet" value="utiliser_objet">';
                        echo '<select name="objet_id" class="select-objet">';
                        foreach ($inventaire as $objet) {
                            $effetLabel = '';
                            switch ($objet['type']) {
                                case 'attaque':
                                    $effetLabel = '-' . abs($objet['effet']) . ' PV ennemi';
                                    break;
                                case 'soin':
                                    $effetLabel = '+' . abs($objet['effet']) . ' PV';
                                    break;
                                case 'force':
                                    $effetLabel = '+' . abs($objet['effet']) . ' force';
                                    break;
                                case 'esquive':
                                    $effetLabel = 'bonus esquive';
                                    break;
                                default:
                                    if ($objet['effet'] >= 0) {
                                        $effetLabel = '+' . $objet['effet'];
                                    } else {
                                        $effetLabel = (string) $objet['effet'];
                                    }
                                    break;
                            }
                            echo '<option value="' . $objet['id_objet'] . '">';
                                echo $objet['nom'] . ' (x' . $objet['quantite'] . ') ' . $effetLabel;
                            echo '</option>';
                        }
                        echo '</select>';
                        echo '<button type="submit" class="btn-utiliser"> Utiliser</button>';
                    echo '</form>';
                }

            echo '</div>';
            // Panneau stats 
            if ($personnage) {
                // Force l'affichage des PV du combat dans le panneau stats
                $personnage['pv'] = $combat['pv_joueur'];
                if (isset($_SESSION['maxJ'])) {
                    $this->panneauStats($personnage, $inventaire, $_SESSION['maxJ']);
                } else {
                    $this->panneauStats($personnage, $inventaire, $combat['pv_joueur']);
                }
            }

        echo '</div>';
        echo '</body></html>';
    }

    // RESULTAT COMBAT
    public function resultatCombat($resultat, $choix, $orGagne = 0) {
        echo '<div>';
        if ($resultat === 'victoire') {
            echo '<h2> Victoire !</h2>';
            echo '<p class="texte-histoire">Vous avez triomphé de votre ennemi.</p>';
            if ($orGagne > 0) {
                echo '<p class="texte-histoire">Vous gagnez ' . $orGagne . ' or.</p>';
            }
            echo '<h2>Que voulez-vous faire ?</h2>';
            foreach ($choix as $unChoix) {
                echo '<p><a href="index.php?id='.$unChoix["id_histoire_1"].'">'.$unChoix["choix_possible"].'</a></p>';
            }

        } else {
            echo '<h2> Défaite...</h2>';
            echo '<p class="texte-histoire">Vous avez succombé à vos blessures.</p>';
        }
        echo '</div>';
        echo '</body></html>';
    }


    // STATS
    private function panneauStats($personnage, $inventaire, $pvMax = 100) {
        if (!$personnage) return;

        // Calcule le % PV pour la barre
        if ($pvMax > 0) {
            $pctPv = ($personnage['pv'] / $pvMax) * 100;
        } else {
            $pctPv = 0;
        }

        if ($pctPv < 0) {
            $pctPv = 0;
        } else if ($pctPv > 100) {
            $pctPv = 100;
        }

        echo '<div class="panneau-stats">';

            // Stats personnage
            echo '<div class="stats-perso">';
                echo '<h2>Votre personnage</h2>';

                echo '<div class="stat-ligne">';
                    echo '<span class="stat-label"> PV</span>';
                    echo '<div class="barre-vie-stat">';
                        echo '<div class="vie-stat" style="width:'.$pctPv.'%"></div>';
                    echo '</div>';
                    echo '<span class="stat-valeur">'.$personnage['pv'].'</span>';
                echo '</div>';

                echo '<div class="stat-ligne">';
                    echo '<span class="stat-label">PM</span>';
                    echo '<div class="barre-mana-stat">';
                        echo '<div class="mana-stat" style="width:'.$personnage['pm'].'%"></div>';
                    echo '</div>';
                    echo '<span class="stat-valeur">'.$personnage['pm'].'</span>';
                echo '</div>';

                echo '<div class="stat-ligne">';
                    echo '<span class="stat-label"> Force</span>';
                    echo '<span class="stat-valeur">'.$personnage['force'].'</span>';
                echo '</div>';

                echo '<div class="stat-ligne">';
                    echo '<span class="stat-label"> Or</span>';
                    echo '<span class="stat-valeur">'.$personnage['or_'].'</span>';
                echo '</div>';
            echo '</div>';

            // Inventaire
            echo '<div class="inventaire">';
                echo '<h2>Inventaire</h2>';
                if (empty($inventaire)) {
                    echo '<p class="inventaire-vide">Aucun objet</p>';
                } else {
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
}
?>