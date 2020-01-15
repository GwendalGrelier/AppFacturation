-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 15 jan. 2020 à 12:10
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `appfactures`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

DROP TABLE IF EXISTS `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `prix_u` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `nom`, `qty`, `prix_u`) VALUES
(1, 'Clous', 15, 0.2),
(2, 'Boulons', 50, 0.4),
(3, 'Marteau', 1, 15),
(5, 'Patate', 15, 42);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adresse_postale` varchar(255) NOT NULL,
  `adresse_electronique` varchar(255) NOT NULL,
  `n_tva` varchar(255) NOT NULL,
  `siret` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `nom_societe` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT 2,
  `password` varchar(50) NOT NULL DEFAULT '1234',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `adresse_postale`, `adresse_electronique`, `n_tva`, `siret`, `notes`, `nom_societe`, `rank`, `password`) VALUES
(1, '1 Place de la résistance', 'gxwen@hotmail.fr', '12365487954625', '12365487954625', 'Entreprise de construction', 'CEFii construction', 2, '1234'),
(2, '1 Rue Max Richard', 'gxwen@hotmail.fr', '46879854324', '5798478523548999', 'Entreprise de BTP', 'CEFiiBTP', 2, '1234');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

DROP TABLE IF EXISTS `devis`;
CREATE TABLE IF NOT EXISTS `devis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `remise_com` float NOT NULL,
  `taux_retard` float NOT NULL,
  `date_echeance` date NOT NULL,
  `num_facture` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `statut_valider` tinyint(1) NOT NULL,
  `date_validation` date NOT NULL,
  `id_client` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `devis_client_FK` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `devis`
--

INSERT INTO `devis` (`id`, `remise_com`, `taux_retard`, `date_echeance`, `num_facture`, `date_creation`, `statut_valider`, `date_validation`, `id_client`) VALUES
(1, 0, 0.05, '2020-01-31', 1, '2020-01-01', 1, '2020-01-02', 1),
(2, 10, 0.05, '2020-01-23', 2, '2020-01-02', 1, '2020-01-03', 1),
(4, 0, 0.02, '2020-01-29', 0, '2020-01-06', 1, '2020-01-06', 2),
(5, 5, 5, '2020-01-31', 0, '2020-01-30', 0, '0000-00-00', 1),
(7, 0, 0, '2020-01-22', 0, '2020-01-14', 0, '0000-00-00', 1),
(37, 50, 0, '2020-01-30', 0, '2020-01-15', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

DROP TABLE IF EXISTS `facture`;
CREATE TABLE IF NOT EXISTS `facture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_devis` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facture_devis_AK` (`id_devis`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `liste_article`
--

DROP TABLE IF EXISTS `liste_article`;
CREATE TABLE IF NOT EXISTS `liste_article` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_article`),
  KEY `liste_article_article0_FK` (`id_article`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liste_article`
--

INSERT INTO `liste_article` (`id`, `id_article`) VALUES
(1, 1),
(1, 3),
(2, 3),
(4, 1),
(4, 2),
(4, 3),
(7, 1),
(7, 3),
(7, 5),
(37, 2),
(37, 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `devis_client_FK` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_devis_FK` FOREIGN KEY (`id_devis`) REFERENCES `devis` (`id`);

--
-- Contraintes pour la table `liste_article`
--
ALTER TABLE `liste_article`
  ADD CONSTRAINT `liste_article_article0_FK` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `liste_article_devis_FK` FOREIGN KEY (`id`) REFERENCES `devis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
