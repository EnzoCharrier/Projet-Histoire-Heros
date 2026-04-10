/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.3-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 192.168.56.10    Database: HistoireHeros
-- ------------------------------------------------------
-- Server version	11.8.3-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `Choix`
--

DROP TABLE IF EXISTS `Choix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Choix` (
  `id_histoire` int(11) NOT NULL,
  `id_histoire_1` int(11) NOT NULL,
  `choix_possible` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_histoire`,`id_histoire_1`),
  KEY `id_histoire_1` (`id_histoire_1`),
  CONSTRAINT `Choix_ibfk_1` FOREIGN KEY (`id_histoire`) REFERENCES `Histoire` (`id_histoire`),
  CONSTRAINT `Choix_ibfk_2` FOREIGN KEY (`id_histoire_1`) REFERENCES `Histoire` (`id_histoire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Choix`
--

LOCK TABLES `Choix` WRITE;
/*!40000 ALTER TABLE `Choix` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `Choix` VALUES
(1,12,'Allez vers la lumière'),
(1,13,'Reculez vers la présence'),
(12,121,'Vous acceptez'),
(12,122,'Vous refusez'),
(13,131,'Trouver un moyen de sceller le fléau pour de bon'),
(13,132,'Mettre fin a ses jours'),
(13,133,'Accélérer la renaissance du fléau'),
(121,1210,'Continuer'),
(131,1310,'Continuer'),
(133,1310,'Continuer'),
(1210,12101,'Fouiller les alentours'),
(1210,12102,'Entrez à l\'intérieur'),
(1310,13101,'Aller visiter le village'),
(1310,13102,'Ignorez le village et continuez votre chemin.'),
(12101,1210,'Retourner a l\'entrée'),
(12102,121021,'aigle,crabe,poisson'),
(12102,121022,'crabe,poisson,aigle'),
(12102,121023,'poisson,aigle,crabe'),
(13101,13102,'Partir du village'),
(13101,131011,'Aller au magasin d\'arme'),
(13101,131012,'Aller au magasin magique'),
(13101,131013,'Aller a l\'auberge'),
(13102,131021,'Entrer dans la cave'),
(13102,131022,'Aller dans la salle du trône'),
(13102,131023,'Aller a la bibliothèque'),
(121022,1210220,'Continuer'),
(131011,1310111,'Acheter une épée simple pour 5 d\'or'),
(131011,1310112,'Voler l\'épée simple'),
(131012,13101,'Sortir du magasin'),
(131012,1310121,'Acheter la potion de soin pour 15 d\'or'),
(131012,1310122,'Voler la potion de soin'),
(131013,1310131,'Prendre la chambre de luxe pour 30 d\'or'),
(131013,1310132,'Prendre la chambre gratuite'),
(131021,13102,'Fuir la cave'),
(131021,1310210,'Attaquer avec votre arme (-20 PV)'),
(131022,13102,'Retourner en arrière'),
(131022,1310221,'Utiliser votre clé'),
(131023,13102,'Revenir en arrière'),
(131023,1310230,'Fouillez toute la bibliothèque'),
(1210220,12102200,'Continuer'),
(1310111,13101,'Sortir du magasin'),
(1310111,131011,'Acheter autre chose'),
(1310112,13102,'Continuer votre route'),
(1310121,131012,'Acheter autre chose'),
(1310122,13102,'Continuer'),
(1310132,13102,'Continuer'),
(1310210,13102,'Sortir de la cave'),
(1310221,13102211,'Partir sans vous retourner'),
(1310221,13102212,'Touchez l\'artéfact'),
(1310221,13102213,'Détruire l\'artéfact'),
(12102200,121022001,'Attaquer les monstres'),
(12102200,121022002,'Contourner les monstres'),
(13102212,131022120,'Revenir a la salle du trône'),
(13102213,131022120,'Revenir a la salle du trône'),
(121022000,1210220001,'Attaquer l\'homme'),
(121022000,1210220002,'Essayer de discuter avec lui'),
(121022001,121022000,'Continuer'),
(121022002,121022000,'Continuer'),
(131022120,1310221201,'Convaincre le héros'),
(131022120,1310221202,'Se battre'),
(131022120,1310221207,'Incanter votre nouveau sort'),
(1210220001,1210220024,'Continuer'),
(1210220002,121022000,'Revenir en arrière'),
(1210220024,1210220026,'Continuer'),
(1310221201,131022126,'Accepter'),
(1310221202,1310221299,'Utiliser votre arme'),
(1310221207,1310221209,'Le lancer');
/*!40000 ALTER TABLE `Choix` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `Ennemi`
--

DROP TABLE IF EXISTS `Ennemi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Ennemi` (
  `id_ennemi` int(11) NOT NULL AUTO_INCREMENT,
  `pv` int(11) DEFAULT NULL,
  `force` int(11) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_ennemi`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ennemi`
--

LOCK TABLES `Ennemi` WRITE;
/*!40000 ALTER TABLE `Ennemi` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `Ennemi` VALUES
(1,50,20,'Gobelin'),
(2,100,5,'Groupe de monstres'),
(3,200,5,'Hôte du fléau');
/*!40000 ALTER TABLE `Ennemi` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `Histoire`
--

DROP TABLE IF EXISTS `Histoire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Histoire` (
  `id_histoire` int(11) NOT NULL,
  `texte` text DEFAULT NULL,
  PRIMARY KEY (`id_histoire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Histoire`
--

LOCK TABLES `Histoire` WRITE;
/*!40000 ALTER TABLE `Histoire` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `Histoire` VALUES
(1,'Vous ouvrez les yeux et vous regardez autour de vous, vous ne voyez rien, il semble que vous soyez dans un espace extrêmement sombre au premier abord, puis après quelques secondes vous voyez une lumière très lointaine. Vous tentez d\'y aller, mais derrière vous, vous semblez avoir l\'impression de sentir quelque chose dans l\'obscurité qui vous interpelle. Que faites-vous ?'),
(12,'Vous vous réveillez dans une grande chambre qui a l\'air prestigieuse. Peu de temps après votre réveil, vous voyez une femme rentrer dans la pièce, l\'air paniqué. Elle vous explique la raison de votre présence. Vous êtes un héros amnésique revenu à la vie suite à l\'apparition du fléau qui est actuellement en train de se réincarner dans un réceptacle qui est un mort-vivant tout comme vous. Dans 3 jours il aura terminé sa réincarnation et ce sera la fin du monde. Votre but est d\'aller chercher l\'épée de légende ayant été utilisée lors d\'événements similaires il y a 1000 ans et qui fut scellée non loin d\'ici. Une fois cela fait, vous devrez aller trouver le réceptacle et le tuer. Vous n\'avez pas plus d\'informations qu\'en dites-vous ?'),
(13,'Vous vous réveillez dans une espèce de ruine, vous ne savez pas qui vous êtes mais vous sentez quelque chose en vous d\'étrange, vous regardez autour de vous et voyez un vieil homme qui commence à vous expliquer ce que vous êtes. Vous êtes un homme revenu à la vie dans le but de servir de réceptacle au fléau, une créature qui a déjà essayé de détruire le monde il y a plusieurs milliers d\'années. Sa résurrection arrivera dans 3 jours complets. Vous êtes celui qui peut sceller le fléau pour de bon ou bien qui peut accélérer sa résurrection et plonger le monde dans le chaos. Ce choix vous appartient pleinement.'),
(121,'Malgré le doute, vous acceptez ce que vous a dit la femme et partez vous équiper pour aller chercher l\'épée de légende.'),
(122,'FIN #1 : Vous étiez inutile donc on vous a jetés dehors, et la fin du monde a bien eu lieu 3 jours dommage !'),
(131,'Le vieil homme, votre choix, il vous indique où aller et vous explique comment faire cela. Dans un vieux château en ruine à plusieurs jours de marche, il y a quelque part dans le château un endroit auquel seul le fléau pouvait accéder et qui contient \'l\'origine\', c\'est ce qui permet au fléau de se réincarner chaque millénaire. Il suffit de le détruire mais de ne surtout pas le toucher à mains nues, sinon l\'effet contraire se produira et accélérera grandement la réincarnation.'),
(132,'FIN #2 : Vous avez décidé de mettre fin à vos jours et avez fui vos responsabilités.'),
(133,'Le vieil homme respecte votre choix et vous explique où aller et comment réaliser cela, Il faut vous rendre dans un château à quelques jours de marche d\'ici et trouver \'l\'origine\', un artefact caché quelque part dans le château, dans une pièce uniquement accessible par le fléau. Il s\'agit de ce qui lui permet de se réincarner chaque millénaire. Le toucher permettra amplement de rendre la réincarnation du fléau presque instantanée.'),
(1210,'Après vous être équipés, vous partez à la recherche de l\'épée de légende en suivant les indications de la femme. Après quelque temps, vous arrivez devant un énorme temple, c\'est bien celui que vous cherchiez. Que faites-vous ?'),
(1310,'Quoi qu\'il en soit, vous décidez de vous mettre en route directement vers le château en ruine. Cependant, avant votre départ, vous vous retournez pour remercier le vieil homme pour son aide, mais vous ne le voyez plus. Il y a cependant un petit sac par terre contenant un peu d\'argent et de la nourriture. Vous le prenez et partez Après quelque temps, vous arrivez à l\'entrée d\'un village.'),
(12101,'Vous faites rapidement le tour de la structure, vous trouvez une sorte de stèle avec trois symboles qui se suivent : crabe, poisson, aigle'),
(12102,'Vous entrez à l\'intérieur, après être rentré, la porte se referme derrière vous et le plafond se rapproche rapidement du sol. En face de vous se trouve une stèle avec 3 symboles pouvant être changés. Vous n\'aurez le temps de rentrer qu\'une seule combinaison. Que rentrez-vous ?'),
(13101,'Vous décidez d\'aller visiter le village et plusieurs endroits attirent votre attention.'),
(13102,'Vous partez maintenant en direction du château et arrivez à celui-ci après une journée entière de marche. Vous regardez aux alentours et remarquez plusieurs endroits intrigants.'),
(121021,'FIN #10 :  Mauvais code, le plafond vous écrase violemment.'),
(121022,'Le plafond s\'arrête et la porte en face de vous s\'ouvre, vous entrez dans la pièce et voyez une épée dans la pierre, vous la retirez avec succès et obtenez donc l\'épée de légende.'),
(121023,'FIN #10 :  Mauvais code, le plafond vous écrase violemment.'),
(131011,'Vous entrez dans le magasin d\'arme'),
(131012,'Vous entrez dans le magasin magique'),
(131013,'Vous entrez dans l\'auberge pour vous reposer'),
(131021,'Vous entrez dans la cave vous n\'entendez aucun bruit et ne voyez absolument rien, soudain vous vous faite sautez dessus par un monstre, vous devez agir vite !'),
(131022,'Vous arriver dans la salle du trône, vous sentez une étrange energie qui se degage de celui-ci, vous vous approchez par curiosité, puis le trone se met a bouger et revele une trappe en acier verouillé.'),
(131023,'Vous arrivez dans une immense bibliothèque, on croirait qu\'elle contient tout le savoir du monde il doit surement y avoir des informations qui pourrait vous interressez'),
(1210220,'Maintenant que vous avez l\'épée en main, il est temps de trouver le réceptacle. Selon la femme, lors de la dernière tentative de réincarnation du fléau, le réceptacle s\'était rendu dans un vieux château en ruine à l\'est du temple. Vous n\'avez pas vraiment d\'autres pistes, donc vous décidez de vous y rendre.'),
(1310111,'Vous acheter une simple épée, c\'est mieux que rien'),
(1310112,'Vous choisissez de voler l\'épée simple mais les villageois vous chassent du village, vous avez cependant reussi a prendre l\'épée avec vous disons que c\'est un mal pour un bien.'),
(1310121,'Vous achetez la potion pour 15 d\'or malgré son prix exorbitant elle sera surement utile.'),
(1310122,'Vous choisissez de voler la potion de soin, les villageois vous chassent mais vous avez obtenu la potion de soin sans donner une seule pièce a cet escroc de vendeur, bravo. '),
(1310131,'FIN #3 Vous dormez tellement bien dans et oubliez tout vos problèmes cette chambre valait son prix malheureusement vous ne vous reveillerez jamais, vous avez dormi trop longtemps et le monde a sombré dans le chaos, tout compte fait vous n\'étiez pas fait pour ca.'),
(1310132,'Vous allez dormir dans la chambre gratuite il n\'y a meme pas de lit et les murs sont moisi malgré tout vous decidez de dormir vous n\'obtener d\'ailleurs rien de cet action hormis une perte de temps colossale.'),
(1310210,'Vous l\'attaquer avec votre arme, le combat se passe dans le noir complet impossible de savoir ou se trouve exactement le monstre, après quelque minutes vous entender le monstre tomber au sol en souffrance, vous essayer de le fouiller et recuperez un objet métallique.'),
(1310221,'Vous utiliser votre clé et descendez dans un espèce de passage secret, au bout vous entrez dans une salle rempli de livre et de schéma ancien mais ce qui attire votre attention c\'est cette espèce de sphère au centre qui émane une energie terrifiante il s\'agit surement de ce que vous cherchiez il est temps de faire un choix.'),
(1310230,'FIN #8 Vous essayez d\'ouvrir et de lire chaque livre présent, vous êtes mort de vieillesse sans rien trouver d\'intéressant, vous ferez mieux la prochaine fois. '),
(12102200,'Après plus de 2 jours de marche, vous arrivez enfin à ce qui semble être le château dont parlait la femme. Il est bien en ruine, mais il a devant vous une énorme horde de monstres. '),
(13102211,'FIN #4 Vous partez sans jamais vous retourner, ignorant toutes vos responsabilités, le monde (s\'il en reste un) se rappellera de vous comme de \'l\'homme le plus lâche et égoïste au monde\'. '),
(13102212,'Vous touchez l\'artéfact qui libère presque instantanément une immense quantité d\'energie, vous vous sentez comme l\'homme le plus puissant du monde mais petit a petit votre conscience s\'efface, dans les prochaines minute vous serez remplacés par le fléau et le monde sombrera dans le chaos.'),
(13102213,'Vous prenez un bout de bois qui était par terre et frappez de toute vos force l\'orbe qui se brise sur le coup, vous ne savez pas vraiment si cela a fonctionné mais vous sentez que quelque chose a changer chez vous.'),
(121022000,'Vous entrez dans le hall principal du château. Devant vous se tient un mortvivant, mais il n\'est pas comme les autres. Sans trop savoir pourquoi, vous avez l\'intime conviction qu\'il s\'agit de la personne que vous recherchiez.'),
(121022001,'Vous vous jetez dans la mêlée et essayez d\'en tuer un maximum. Vous perdez quelques points de vie mais gagnez 10 points à toutes vos stats.'),
(121022002,'Vous vous faufilez discrètement et les contournez pour entrer dans le château.'),
(131022120,'Après être sorti de la salle vous vous retrouver dans la salle du trône. Cependant vous voyez quelqu\'un devant vous il dit être le héros venu tuer la reincarnation du fléau, il est la pour vous tuer vous devez réagir vite.'),
(131022126,'FIN #9 Quelque jours après votre capture le renaissance n\'a pas eu lieu vous avez donc pu expliquer votre situation, le fléau ne se pourra plus jamais se réincarner, vous serez connu plus tard comme un héros ayant agi dans l\'ombre et vivez une vie paisible.'),
(1210220001,'Vous engagez le combat contre lui, sa réincarnation ne va pas tarder à être complétée, vous devez vite l\'éliminer !'),
(1210220002,'Vous essayez de discuter avec lui. mais il ne vous répond pas.'),
(1210220004,'Vous attaquez avec votre épée, il prend quelques dégâts.'),
(1210220005,'Vous esquivez absolument rien, même votre ennemi est surpris.'),
(1210220006,'L\'homme prépare un sort.'),
(1210220007,'Vous attaquez avec votre épée, il prend quelques dégâts.'),
(1210220008,'Vous n\'esquivez a priori pas grand-chose.'),
(1210220009,'Le sort de l\'homme devient de plus en plus gros, vous ne savez pas quand il sera lancé mais il sera dévastateur.'),
(1210220014,'Vous décidez d\'attaquer, il prend quelques dégâts et commence à s\'affaiblir.'),
(1210220015,'Vous esquivez en pensant qu\'il allait lancer son sort, mais vous aviez faux, il continue de le canaliser.'),
(1210220016,'Le sort de l\'homme devient plus menaçant que jamais, il recouvre presque entièrement le hall du château.'),
(1210220017,'FIN #11 : Vous essayez d\'attaquer, mais avant même d\'avoir pu lancer votre épée, le sort se lance et vous pulvérise en un instant, git gud.  '),
(1210220018,'Vous esquivez le sort de l\'homme au dernier moment et survivez à l\'attaque, c\'est le moment de le tuer.'),
(1210220019,'Il a l\'air au bord de la mort, c\'est le moment ou jamais de frapper.'),
(1210220024,'Vous mettez tout ce que vous avez dans une ultime attaque et tranchez l\'homme en deux, il est définitivement mort, vous avez gagné le combat.'),
(1210220025,' FIN #12 : Vous essayez d\'esquiver dans le vent. Malheureusement, vous n\'avez pas profité de votre opportunité et la réincarnation est complète, le monde sombre dans le chaos. Inutile de préciser que vous êtes le 1ᵉʳ à mourir, bien joué.'),
(1210220026,'FIN #13 : Après votre victoire, vous rentrez au château et êtes acclamé comme un héros, vous passez le restant de vos jours couvert de gloire. Bravo à vous.'),
(1310221201,'Vous essayer d\'expliquer votre situation et de convaincre le chevalier, il semble vous croire et vous demande de vous laisser capturer pour ne prendre aucun risque.'),
(1310221202,'Vous engagez le combat contre le héros il n\'y a pas de retour en arrière possible l\'issue du duel amenera a la fin du monde ou au contraire a la paix'),
(1310221207,'Vous incantez votre nouveau sort, il s\'agit d\'une immense concentration d\'energie qui remplis presque toute la zone.'),
(1310221209,'FIN #7 Votre sort est lancé et rase l\'intégralité de la zone, hormis vous. Le héros est mort plus rien ne peut vous arreter le fléau renaît et le monde sombre dans le chaos jusqu\'a ce qu\'il n\'y ait plus rien a détruire, vous avez gagné mais était-ce vraiment ce que vous vouliez ?'),
(1310221299,'FIN #6 Vous essayez de tenir tête au héros avec votre mais malheureusement vous n\'avez jamais appris le maniement de l\'épée et en plus le héros tient une épée légendaire d\'une qualité exceptionnelle, vous vous faites massacrer, il ne reste rien de vous, techniquement le monde est sauvé mais selon le point de vue on dirait que vous avez perdu, personne ne vous pleurera par contre.');
/*!40000 ALTER TABLE `Histoire` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `Inventaire`
--

DROP TABLE IF EXISTS `Inventaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Inventaire` (
  `id_perso` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_perso`,`type`),
  KEY `type` (`type`),
  CONSTRAINT `Inventaire_ibfk_1` FOREIGN KEY (`id_perso`) REFERENCES `Personnage` (`id_perso`),
  CONSTRAINT `Inventaire_ibfk_2` FOREIGN KEY (`type`) REFERENCES `Objets` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Inventaire`
--

LOCK TABLES `Inventaire` WRITE;
/*!40000 ALTER TABLE `Inventaire` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `Inventaire` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `Objets`
--

DROP TABLE IF EXISTS `Objets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Objets` (
  `type` varchar(50) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `effet` int(11) DEFAULT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Objets`
--

LOCK TABLES `Objets` WRITE;
/*!40000 ALTER TABLE `Objets` DISABLE KEYS */;
set autocommit=0;
/*!40000 ALTER TABLE `Objets` ENABLE KEYS */;
UNLOCK TABLES;
commit;

--
-- Table structure for table `Personnage`
--

DROP TABLE IF EXISTS `Personnage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Personnage` (
  `id_perso` int(11) NOT NULL AUTO_INCREMENT,
  `pv` int(11) DEFAULT NULL,
  `pm` int(11) DEFAULT NULL,
  `force` int(11) DEFAULT NULL,
  `or_` int(11) DEFAULT NULL,
  `cle` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_perso`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Personnage`
--

LOCK TABLES `Personnage` WRITE;
/*!40000 ALTER TABLE `Personnage` DISABLE KEYS */;
set autocommit=0;
INSERT INTO `Personnage` VALUES
(1,150,100,50,0,0),
(2,100,50,20,0,0);
/*!40000 ALTER TABLE `Personnage` ENABLE KEYS */;
UNLOCK TABLES;
commit;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-04-10  9:42:32
