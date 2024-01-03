-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 03 jan. 2024 à 08:38
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `nom`, `date_creation`) VALUES
(1, 'Projet Web', '2023-12-30 13:59:18'),
(2, 'Projet Mobile', '2023-12-30 13:59:42');

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

DROP TABLE IF EXISTS `projets`;
CREATE TABLE IF NOT EXISTS `projets` (
  `id_projet` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `contenu` text COLLATE utf8mb4_general_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_projet`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id_projet`, `titre`, `contenu`, `photo`, `date_creation`, `id_categorie`) VALUES
(1, 'Moviz', 'Retrouvez tous vos films préférés sur notre site. Notez, likez et découvrez les nouveautés.', '1703941318_Moviz.png', '2023-12-30 14:01:58', 1),
(2, 'Rest-Countries', 'Connaissez-vous bien votre géographie ? Cliquez et découvrez les pays que vous ne connaissez pas encore, ainsi que leur pays voisin.', '1703941408_Rest-Countries.png', '2023-12-30 14:03:28', 1),
(3, 'Pokedex', 'Vous aimez Pokemon ? Regardez le Pokedex pour savoir si vous les avez bien tous attrappés.', '1703941429_Pokedex.png', '2023-12-30 14:03:49', 1),
(4, 'Banker App', 'Application bancaire. Regardez votre compte, vérifiez et transférer vos actions.', '1703941450_Banker-App.png', '2023-12-30 14:04:10', 1),
(5, 'Locate Me', 'Application mobile. Scannez le QR-Code avec l\'application Expo Go et réperez votre localisation.', '1703941492_Locate.png', '2023-12-30 14:04:52', 2),
(6, 'SnaPic', 'Application mobile. Scannez le QR-Code avec l\'application Expo Go et Prenez vos meilleures photos avec SnaPic.', '1703941519_SnaPic.png', '2023-12-30 14:05:19', 2);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `username`, `password`, `date_creation`) VALUES
(1, 'admin', '$2y$10$1zZuAB0C7GB4sNNP5DjKu.ZuaLm5x3CA2fyr74Z/7N7Sa.fRpnZ7G', '2023-12-30 13:27:57');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `projets`
--
ALTER TABLE `projets`
  ADD CONSTRAINT `projets_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE RESTRICT ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
