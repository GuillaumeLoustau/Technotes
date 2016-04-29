-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 29 Avril 2016 à 16:30
-- Version du serveur :  5.7.9
-- Version de PHP :  5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `technotes`
--

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

DROP TABLE IF EXISTS `action`;
CREATE TABLE IF NOT EXISTS `action` (
  `id_action` int(11) NOT NULL,
  `libellle_action` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `action`
--

INSERT INTO `action` (`id_action`, `libellle_action`) VALUES
(1, 'membre'),
(2, 'technote'),
(3, 'question'),
(4, 'mot-clef'),
(5, 'commentaire');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `contenu` varchar(400) NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_techquestion` int(11) NOT NULL DEFAULT '0',
  `id_membre` int(11) NOT NULL,
  `id_pere` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_commentaire`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `mc_tq`
--

DROP TABLE IF EXISTS `mc_tq`;
CREATE TABLE IF NOT EXISTS `mc_tq` (
  `id_motcle` int(11) NOT NULL,
  `id_techquestion` int(11) NOT NULL,
  `origine` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_motcle`,`id_techquestion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

DROP TABLE IF EXISTS `membre`;
CREATE TABLE IF NOT EXISTS `membre` (
  `id_membre` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `pseudo` varchar(30) NOT NULL,
  `mot_de_passe` varchar(35) NOT NULL,
  `id_role` int(11) NOT NULL,
  `date_creation` datetime NOT NULL,
  PRIMARY KEY (`id_membre`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `email`, `pseudo`, `mot_de_passe`, `id_role`, `date_creation`) VALUES
(1, 'admin@tch.fr', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '2016-03-27 00:00:00'),
(7, 'guillaume@tch.fr', 'guillaume', 'c1ff0c723e1001c42d9ec8ef434c269d', 2, '2016-04-29 09:33:22');

-- --------------------------------------------------------

--
-- Structure de la table `motcle`
--

DROP TABLE IF EXISTS `motcle`;
CREATE TABLE IF NOT EXISTS `motcle` (
  `id_motcle` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(200) NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_pere` int(11) NOT NULL DEFAULT '0',
  `id_synonime` int(11) NOT NULL DEFAULT '0',
  `valide` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_motcle`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id_role` int(11) NOT NULL,
  `libelle_role` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`id_role`, `libelle_role`) VALUES
(1, 'administrateur'),
(2, 'membre'),
(3, 'visiteur');

-- --------------------------------------------------------

--
-- Structure de la table `role_action`
--

DROP TABLE IF EXISTS `role_action`;
CREATE TABLE IF NOT EXISTS `role_action` (
  `id_role` int(11) NOT NULL,
  `id_action` int(11) NOT NULL,
  `ajouter` int(11) NOT NULL,
  `modifier` int(11) NOT NULL,
  `supprimer` int(11) NOT NULL,
  `consulter` int(11) NOT NULL,
  PRIMARY KEY (`id_role`,`id_action`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `role_action`
--

INSERT INTO `role_action` (`id_role`, `id_action`, `ajouter`, `modifier`, `supprimer`, `consulter`) VALUES
(1, 1, 1, 1, 1, 1),
(1, 2, 1, 1, 1, 1),
(1, 3, 1, 1, 1, 1),
(1, 4, 1, 1, 1, 1),
(1, 5, 1, 0, 1, 1),
(2, 1, 0, 0, 0, 0),
(2, 2, 1, 0, 0, 1),
(2, 3, 1, 1, 1, 1),
(2, 4, 0, 0, 0, 0),
(2, 5, 1, 0, 0, 1),
(3, 1, 0, 0, 0, 0),
(3, 2, 0, 0, 0, 1),
(3, 3, 0, 0, 0, 0),
(3, 4, 0, 0, 0, 0),
(3, 5, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `techquestion`
--

DROP TABLE IF EXISTS `techquestion`;
CREATE TABLE IF NOT EXISTS `techquestion` (
  `id_techquestion` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `statut` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime DEFAULT NULL,
  `id_type` int(11) NOT NULL DEFAULT '1',
  `id_membre` int(11) NOT NULL,
  PRIMARY KEY (`id_techquestion`),
  KEY `id_auteur` (`id_membre`),
  KEY `type` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
