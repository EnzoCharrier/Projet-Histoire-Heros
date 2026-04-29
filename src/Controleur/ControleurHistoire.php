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

    // afficher la vue
    public function afficher() {
        $id = 0; // id page d'accueil
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
        }

        if (!isset($_SESSION['recompenses'])) {
            $_SESSION['recompenses'] = [];
        }

        if ($id !== 0 && $id !== 99) {
            // Reset inventaire et or
            if ($id === 1) {
                if (!isset($_SESSION['idPerso'])) {
                    $_SESSION['idPerso'] = 1;
                }
                $this->modele->resetOr($_SESSION['idPerso'], 150);
                $this->modele->resetInventaire($_SESSION['idPerso']);
                unset($_SESSION['combat']);
                unset($_SESSION['maxJ']);
                unset($_SESSION['maxE']);
                unset($_SESSION['recompenses']);
            } else {
                if (!isset($_SESSION['idPerso'])) {
                    $_SESSION['idPerso'] = 1;
                }

                if ($id === 13) {
                    $_SESSION['idPerso'] = 2;
                } else if ($id === 12) {
                    $_SESSION['idPerso'] = 1;
                }
            }
        }

        $messageMagasin = '';
        if ($this->estUnMagasin($id) && isset($_POST['action_acheter_objet'])) {
            $messageMagasin = $this->gererAchatObjet();
        }

        // permet de lancer le combat
        if (isset($_POST['action_combat_attaque']) || isset($_POST['action_combat_esquive']) || isset($_POST['action_combat_utiliser_objet'])) {
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
   

            $histoire = $this->modele->getHistoire($id);
            $choix    = $this->modele->getChoix($id);
            $this->appliquerRecompenseOr($id);
            $personnage = $this->modele->getPersonnage($_SESSION['idPerso']);
            $inventaire = $this->modele->getInventaire($_SESSION['idPerso']);

            // Si magasin
            if ($this->estUnMagasin($id)) {
                $types = $this->getTypesMagasin($id);
                $objets = $this->modele->getObjetsParTypes($types);
                $this->vue->menu('jeu');
                $this->vue->magasin($histoire, $choix, $personnage, $inventaire, $objets, $messageMagasin);
                return;
            }

            // Si combat est en cours
            if (isset($_SESSION['combat']) && $_SESSION['combat']['id_histoire'] == $id) {
                $this->vue->menu('jeu');
                $this->vue->combat($_SESSION['combat'], $personnage, $inventaire);
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
                    'id_perso'     => $_SESSION['idPerso'],
                    'pv_joueur'    => $personnage['pv'],
                    'pv_ennemi'    => $ennemi['pv'],
                    'force_joueur' => $personnage['force'],
                    'force_ennemi' => $ennemi['force'],
                    'nom_ennemi'   => $ennemi['nom'],
                    'choix_victoire' => $choix
                ];

                $this->vue->menu('jeu');
                $this->vue->combat($_SESSION['combat'], $personnage, $inventaire);
            }

            else
            {
                $this->vue->menu('jeu');
                $this->vue->jouer($histoire, $choix,$personnage, $inventaire);
            }
        }
    }


    // fait passer un tour de combat
    private function tourCombat() {
        $combat = $_SESSION['combat'];

        if (isset($_POST['action_combat_attaque'])) {
            $combat['pv_ennemi'] -= $combat['force_joueur'];
            $combat['dernier_message'] = 'Vous avez attaqué l\'ennemi.';

            if ($combat['pv_ennemi'] > 0) {
                $this->ennemiFrappe($combat);
            }
        }
        else if (isset($_POST['action_combat_esquive'])) {
            $combat['dernier_message'] = 'Vous tentez d\'esquiver.';
            $chance = rand(1, 2);
            if ($chance === 1 || (!empty($combat['bonus_esquive']) && $combat['bonus_esquive'] > 0)) {
                $combat['dernier_message'] = 'Vous esquivez l\'attaque ennemie !';
                if (!empty($combat['bonus_esquive'])) {
                    $combat['bonus_esquive']--;
                }
            } else {
                $this->ennemiFrappe($combat);
            }
        }
        else if (isset($_POST['action_combat_utiliser_objet'])) {
            $objetId = (int) $_POST['objet_id'];
            $this->utiliserObjetCombat($objetId, $combat);
            if ($combat['pv_ennemi'] > 0) {
                $this->ennemiFrappe($combat);
            }
        }

        $this->vue->menu('jeu');

        // victoire
        if ($combat['pv_ennemi'] <= 0) {
            $orGagne = rand(5, 25);
            if (isset($_SESSION['idPerso'])) {
                $this->modele->addOr($_SESSION['idPerso'], $orGagne);
            }
            unset($_SESSION['combat']);
            unset($_SESSION['maxJ']);
            unset($_SESSION['maxE']);
            $this->vue->resultatCombat('victoire', $combat['choix_victoire'], $orGagne);
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
            if (isset($_SESSION['idPerso'])) {
                $idPerso = $_SESSION['idPerso'];
            } else if (isset($combat['id_perso'])) {
                $idPerso = $combat['id_perso'];
            } else {
                $idPerso = 1;
            }
            $personnage = $this->modele->getPersonnage($idPerso);
            $inventaire = $this->modele->getInventaire($idPerso);
            $this->vue->combat($combat, $personnage, $inventaire);
        }
    }

    private function ennemiFrappe(&$combat) {
        if (!empty($combat['bonus_esquive']) && $combat['bonus_esquive'] > 0) {
            $combat['dernier_message'] = 'Votre bonus d\'esquive bloque l\'attaque ennemie.';
            $combat['bonus_esquive']--;
            return;
        }

        $combat['pv_joueur'] -= $combat['force_ennemi'];
        $combat['dernier_message'] = 'L\'ennemi vous inflige ' . $combat['force_ennemi'] . ' dégâts.';
    }

    private function utiliserObjetCombat($id_objet, &$combat) {
        if (isset($_SESSION['idPerso'])) {
            $id_perso = $_SESSION['idPerso'];
        } else if (isset($combat['id_perso'])) {
            $id_perso = $combat['id_perso'];
        } else {
            $id_perso = 1;
        }
        $objet = $this->modele->getObjet($id_objet);

        if (!$objet) {
            $combat['dernier_message'] = 'Objet introuvable.';
            return;
        }

        $inventaire = $this->modele->getInventaire($id_perso);
        $possede = false;
        foreach ($inventaire as $item) {
            if ($item['id_objet'] == $id_objet && $item['quantite'] > 0) {
                $possede = true;
                break;
            }
        }

        if (!$possede) {
            $combat['dernier_message'] = 'Vous ne possédez pas cet objet.';
            return;
        }

        $this->modele->useObjet($id_perso, $id_objet);

        switch ($objet['type']) {
            case 'soin':
                if (!empty($_SESSION['maxJ'])) {
                    $combat['pv_joueur'] = min($_SESSION['maxJ'], $combat['pv_joueur'] + $objet['effet']);
                } else {
                    $combat['pv_joueur'] += $objet['effet'];
                }
                $combat['dernier_message'] = 'Votre objet vous soigne de ' . $objet['effet'] . ' PV.';
                break;

            case 'attaque':
                $combat['pv_ennemi'] -= $objet['effet'];
                $combat['dernier_message'] = 'Votre objet inflige ' . $objet['effet'] . ' dégâts à l\'ennemi.';
                break;

            case 'force':
                $combat['force_joueur'] += $objet['effet'];
                $combat['dernier_message'] = 'Votre force est augmentée de ' . $objet['effet'] . ' pour ce combat.';
                break;

            case 'esquive':
                if (!empty($combat['bonus_esquive'])) {
                    $combat['bonus_esquive'] = $combat['bonus_esquive'] + 1;
                } else {
                    $combat['bonus_esquive'] = 1;
                }
                $combat['dernier_message'] = 'Votre prochain tour sera plus facile à esquiver.';
                break;

            default:
                $combat['dernier_message'] = 'Votre objet n\'a aucun effet connu en combat.';
                break;
        }
    }

    private function appliquerRecompenseOr($id) {
        if (!isset($_SESSION['idPerso'])) {
            return '';
        }

        $recompenses = [
            13101 => 20,
            131011 => 10,
            131012 => 10,
        ];

        if (!isset($recompenses[$id])) {
            return '';
        }

        if (isset($_SESSION['recompenses'][$id])) {
            return '';
        }

        $this->modele->addOr($_SESSION['idPerso'], $recompenses[$id]);
        $_SESSION['recompenses'][$id] = true;
        return 'Vous recevez ' . $recompenses[$id] . ' or.';
    }

    private function estUnMagasin($id) {
        return in_array($id, [131011, 131012]);
    }

    private function getTypesMagasin($id) {
        if ($id === 131011) {
            return ['attaque', 'force'];
        }
        if ($id === 131012) {
            return ['soin', 'esquive'];
        }
        return [];
    }

    private function gererAchatObjet() {
        if (!isset($_SESSION['idPerso'])) {
            return 'Vous devez d\'abord choisir un personnage.';
        }

        $idObjet = 0;
        if (isset($_POST['objet_id'])) {
            $idObjet = (int) $_POST['objet_id'];
        }
        if ($idObjet <= 0) {
            return 'Objet invalide.';
        }

        $objet = $this->modele->getObjet($idObjet);
        if (!$objet) {
            return 'Objet introuvable.';
        }

        $personnage = $this->modele->getPersonnage($_SESSION['idPerso']);
        if (!$personnage) {
            return 'Personnage introuvable.';
        }

        $prix = $this->modele->getPrixObjet($objet);
        if ($personnage['or_'] < $prix) {
            return 'Pas assez d\'or pour acheter ' . $objet['nom'] . '.';
        }

        $this->modele->addOr($_SESSION['idPerso'], -$prix);
        $this->modele->addObjet($_SESSION['idPerso'], $idObjet, 1);
        return 'Vous avez acheté ' . $objet['nom'] . ' pour ' . $prix . ' or.';
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