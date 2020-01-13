-- phpMyAdmin SQL Dump
-- version OVH
-- https://www.phpmyadmin.net/
--
-- Hôte : sqlprive-pc2372-001.privatesql.ha.ovh.net
-- Généré le :  lun. 13 jan. 2020 à 16:08
-- Version du serveur :  5.5.59-0+deb8u1-log
-- Version de PHP :  7.0.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `cefiidev957`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `prix_u` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `nom`, `qty`, `prix_u`) VALUES
(1, 'Clous', 15, 2),
(2, 'Boulons', 50, 4),
(3, 'Marteau', 1, 15);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `adresse_postale` varchar(255) NOT NULL,
  `adresse_electronique` varchar(255) NOT NULL,
  `n_tva` varchar(255) NOT NULL,
  `siret` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `nom_societe` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `adresse_postale`, `adresse_electronique`, `n_tva`, `siret`, `notes`, `nom_societe`) VALUES
(1, '1 Place de la résistance', 'gxwen@hotmail.fr', '12365487954625', '12365487954625', 'Entreprise de construction', 'CEFii construction'),
(2, '1 Rue Max Richard', 'gxwen@hotmail.fr', '46879854324', '5798478523548', 'Entreprise de BTP', 'CEFiiBTP');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `id` int(11) NOT NULL,
  `articles` int(11) NOT NULL,
  `remise_com` float NOT NULL,
  `taux_retard` float NOT NULL,
  `date_echeance` date NOT NULL,
  `num_facture` int(11) NOT NULL,
  `date_creation` date NOT NULL,
  `statut_valider` tinyint(1) NOT NULL,
  `date_validation` date NOT NULL,
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `devis`
--

INSERT INTO `devis` (`id`, `articles`, `remise_com`, `taux_retard`, `date_echeance`, `num_facture`, `date_creation`, `statut_valider`, `date_validation`, `id_client`) VALUES
(1, 1, 0, 0.05, '2020-01-31', 1, '2020-01-01', 1, '2020-01-02', 1),
(2, 2, 0.1, 0.05, '2020-01-23', 2, '2020-01-02', 1, '2020-01-03', 1),
(3, 3, 0, 0.05, '0000-00-00', 0, '2020-01-05', 0, '0000-00-00', 2),
(4, 4, 0, 0.02, '2020-01-29', 0, '2020-01-06', 1, '2020-01-06', 2);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE `facture` (
  `id` int(11) NOT NULL,
  `id_devis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `liste_article`
--

CREATE TABLE `liste_article` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liste_article`
--

INSERT INTO `liste_article` (`id`, `id_article`) VALUES
(1, 1),
(4, 1),
(3, 2),
(4, 2),
(1, 3),
(2, 3),
(4, 3);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `devis_client_FK` (`id_client`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `facture_devis_AK` (`id_devis`);

--
-- Index pour la table `liste_article`
--
ALTER TABLE `liste_article`
  ADD PRIMARY KEY (`id`,`id_article`),
  ADD KEY `liste_article_article0_FK` (`id_article`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `liste_article_devis_FK` FOREIGN KEY (`id`) REFERENCES `devis` (`id`),
  ADD CONSTRAINT `liste_article_article0_FK` FOREIGN KEY (`id_article`) REFERENCES `article` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
