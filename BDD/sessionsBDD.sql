-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour sfsessions
CREATE DATABASE IF NOT EXISTS `sfsessions` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sfsessions`;

-- Listage de la structure de table sfsessions. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule_categorie` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.categorie : ~6 rows (environ)
INSERT INTO `categorie` (`id`, `intitule_categorie`) VALUES
	(1, 'Algorithmie'),
	(2, 'Dev Frontend'),
	(3, 'Dev Backend'),
	(4, 'Bureautique'),
	(5, 'Gestion de projet'),
	(6, 'Base de donnée');

-- Listage de la structure de table sfsessions. formateur
CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `tel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.formateur : ~3 rows (environ)
INSERT INTO `formateur` (`id`, `nom`, `prenom`, `date_naissance`, `tel`, `email`, `code_postal`, `ville`) VALUES
	(1, 'FORMATEUR', 'Fabrice', '1972-04-23', '06 50 42 68 51', 'fabrice.formateurman@wanadoo.fr', '67000', 'STRASBOURG'),
	(2, 'PEDAGOGIQUE', 'Benoit', '1993-02-10', '06 88 47 52 68', 'benoit.pedago@hotmail.com', '67200', 'STRASBOURG'),
	(3, 'EDUCATION', 'Gérard', '1985-10-08', '06 88 47 52 68', 'gerard.education@gmail.com', '67000', 'STRASBOURG');

-- Listage de la structure de table sfsessions. formation
CREATE TABLE IF NOT EXISTS `formation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `intitule_formation` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.formation : ~4 rows (environ)
INSERT INTO `formation` (`id`, `intitule_formation`) VALUES
	(1, 'Développeur Web & Web Mobile'),
	(2, 'Concepteur Développeur d\'Application'),
	(3, 'UI/UX Designer'),
	(4, 'Remise à niveau');

-- Listage de la structure de table sfsessions. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table sfsessions. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `intitule_module` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_C242628BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.module : ~6 rows (environ)
INSERT INTO `module` (`id`, `categorie_id`, `intitule_module`) VALUES
	(1, 1, 'Introduction à l\'algorithmie'),
	(2, 3, 'Découverte PHP'),
	(3, 2, 'Découverte CSS'),
	(4, 2, 'Projet intégration'),
	(5, 6, 'Découverte SQL'),
	(7, 5, 'Développer une appli web');

-- Listage de la structure de table sfsessions. programme
CREATE TABLE IF NOT EXISTS `programme` (
  `id` int NOT NULL AUTO_INCREMENT,
  `module_id` int NOT NULL,
  `session_id` int NOT NULL,
  `duree_module` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3DDCB9FFAFC2B591` (`module_id`),
  KEY `IDX_3DDCB9FF613FECDF` (`session_id`),
  CONSTRAINT `FK_3DDCB9FF613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`),
  CONSTRAINT `FK_3DDCB9FFAFC2B591` FOREIGN KEY (`module_id`) REFERENCES `module` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.programme : ~0 rows (environ)

-- Listage de la structure de table sfsessions. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formation_id` int NOT NULL,
  `formateur_id` int NOT NULL,
  `intitule_session` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_places` int NOT NULL,
  `date_debut` datetime NOT NULL,
  `date_fin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D45200282E` (`formation_id`),
  KEY `IDX_D044D5D4155D8F51` (`formateur_id`),
  CONSTRAINT `FK_D044D5D4155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`),
  CONSTRAINT `FK_D044D5D45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.session : ~2 rows (environ)
INSERT INTO `session` (`id`, `formation_id`, `formateur_id`, `intitule_session`, `nb_places`, `date_debut`, `date_fin`) VALUES
	(1, 1, 1, 'DWWM_2_24_25', 5, '2024-04-23 00:00:00', '2025-02-21 00:00:00'),
	(3, 4, 1, 'RAN_1_24', 6, '2024-01-04 00:00:00', '2024-04-04 00:00:00'),
	(4, 2, 1, 'CDA_1_24_25', 6, '2024-04-22 00:00:00', '2024-10-25 00:00:00'),
	(5, 3, 2, 'UIUX_1_24_25', 4, '2024-04-29 00:00:00', '2024-11-01 00:00:00'),
	(6, 1, 3, 'DWWM_1_24_25', 6, '2024-03-04 00:00:00', '2024-12-06 00:00:00');

-- Listage de la structure de table sfsessions. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `tel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_inscription` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.stagiaire : ~1 rows (environ)
INSERT INTO `stagiaire` (`id`, `nom`, `prenom`, `date_naissance`, `tel`, `email`, `adresse`, `code_postal`, `ville`, `date_inscription`) VALUES
	(1, 'MAGNIFIQUE', 'Marius', '1993-02-23', '06 61 25 47 83', 'marius.magnifique@gmail.com', '6 rue des Pamplemousses', '67000', 'STRASBOURG', '2024-04-23 11:20:50'),
	(2, 'BINGBONG', 'Didier', '2004-05-06', '06 82 66 99 42', 'bing.bong@gmail.com', '32 rue bing bong', '26200', 'MONTELIMAR', '2024-04-24 12:28:31'),
	(3, 'SALSIFI', 'Henri', '2001-09-11', '06 88 69 52 74', 'henri.salsifi@free.fr', '12 rue des Pantoufles', '67200', 'STRASBOURG', '2024-04-24 13:06:41');

-- Listage de la structure de table sfsessions. stagiaire_session
CREATE TABLE IF NOT EXISTS `stagiaire_session` (
  `stagiaire_id` int NOT NULL,
  `session_id` int NOT NULL,
  PRIMARY KEY (`stagiaire_id`,`session_id`),
  KEY `IDX_D32D02D4BBA93DD6` (`stagiaire_id`),
  KEY `IDX_D32D02D4613FECDF` (`session_id`),
  CONSTRAINT `FK_D32D02D4613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_D32D02D4BBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.stagiaire_session : ~2 rows (environ)
INSERT INTO `stagiaire_session` (`stagiaire_id`, `session_id`) VALUES
	(1, 1),
	(1, 3),
	(2, 1),
	(3, 6);

-- Listage de la structure de table sfsessions. utilisateur
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table sfsessions.utilisateur : ~1 rows (environ)
INSERT INTO `utilisateur` (`id`, `email`, `roles`, `password`, `nom`, `prenom`) VALUES
	(1, 'john.php@wanadoo.fr', '[]', '$2y$13$9u1eRdPcs/wXJlKx3uRxNOkHqyJ3.fV4qlmLv2o58j1Gv3FlPxyJC', 'PHP', 'John');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
