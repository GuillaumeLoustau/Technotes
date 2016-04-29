-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Sam 23 Avril 2016 à 17:17
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `technotes`
--

-- --------------------------------------------------------

--
-- Structure de la table `action`
--

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

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id_commentaire` int(11) NOT NULL AUTO_INCREMENT,
  `contenu` varchar(400) NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_techquestion` int(11) NOT NULL DEFAULT '0',
  `id_membre` int(11) NOT NULL,
  `id_pere` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_commentaire`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id_commentaire`, `contenu`, `date_creation`, `id_techquestion`, `id_membre`, `id_pere`) VALUES
(1, 'Bravo pour ce début', '2016-03-28 12:29:45', 1, 2, 0),
(2, 'Merci ! Je vais continuer sur ma lancée', '2016-03-28 15:40:29', 1, 1, 1),
(3, 'Et en Php, utilises-t-on la même classe regex ? ', '2016-04-10 17:31:56', 1, 2, 0),
(4, 'Et en Php, utilises-t-on la même classe regex ? ', '2016-04-10 17:33:04', 1, 2, 0),
(5, 'En voilà une bonne question ! En php, on utilises les classes php; en C++, on utilise les classes C++... Ce technote concerne le langage C++. \r\nA bon entendeur ! ', '2016-04-10 17:34:57', 1, 1, 3),
(6, 'Si on ne peut plus poser de question, je vais arrêter de venir sur ce site; j''irai poser mes questions à des personnes plus aimables. \r\n\r\n\r\nEt ça se dit admin... Les admins sont modérateurs ? Sinon, est-ce qu''on modérateur pourrait ban cet admin ? ', '2016-04-10 17:37:03', 1, 2, 3),
(7, 'Si on ne peut plus poser de question, je vais arrêter de venir sur ce site; j''irai poser mes questions à des personnes plus aimables. \r\n\r\n\r\nEt ça se dit admin... Les admins sont modérateurs ? Sinon, est-ce qu''on modérateur pourrait ban cet admin ? ', '2016-04-10 17:39:40', 1, 2, 3),
(8, 'Y''a quelqu''un .?  Ou je suis toute "seule"? \r\n\r\nY''zn ', '2016-04-10 20:02:42', 1, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `mc_tq`
--

CREATE TABLE IF NOT EXISTS `mc_tq` (
  `id_motcle` int(11) NOT NULL,
  `id_techquestion` int(11) NOT NULL,
  `origine` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id_motcle`,`id_techquestion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `mc_tq`
--

INSERT INTO `mc_tq` (`id_motcle`, `id_techquestion`, `origine`) VALUES
(1, 2, 0),
(1, 3, 0),
(2, 4, 0),
(2, 5, 0),
(3, 1, 0),
(3, 14, 0),
(6, 14, 0);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `membre`
--

INSERT INTO `membre` (`id_membre`, `email`, `pseudo`, `mot_de_passe`, `id_role`, `date_creation`) VALUES
(1, 'admin@tch.fr', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, '2016-03-27 00:00:00'),
(2, 'guillaume@tch.fr', 'guillaume', '0937d6b529933d0ef59ce458668013b9', 2, '2016-03-27 08:22:22'),
(3, 'test', 'test', '098f6bcd4621d373cade4e832627b4f6', 2, '2016-04-23 14:01:33'),
(4, 'test2', 'test2', 'ad0234829205b9033196ba818f7a872b', 2, '2016-04-23 14:57:13');

-- --------------------------------------------------------

--
-- Structure de la table `motcle`
--

CREATE TABLE IF NOT EXISTS `motcle` (
  `id_motcle` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(200) NOT NULL,
  `valide` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_pere` int(11) NOT NULL DEFAULT '0',
  `id_synonime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_motcle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `motcle`
--

INSERT INTO `motcle` (`id_motcle`, `libelle`, `valide`, `date_creation`, `id_pere`, `id_synonime`) VALUES
(1, 'langage C', 1, '2016-03-29 05:00:00', 0, 0),
(2, 'expressions régulières', 1, '2016-03-29 05:00:07', 1, 0),
(3, 'regexp', 0, '2016-03-29 05:00:07', 2, 0),
(4, 'localStorage', 1, '2016-03-29 05:00:20', 0, 0),
(5, 'mémoire', 1, '2016-03-29 05:08:07', 4, 0),
(6, 'navigateur', 0, '2016-03-29 05:08:25', 4, 0),
(7, 'Les mathématiques', 0, '2016-04-17 17:00:59', 0, 0),
(8, 'L''analyse', 1, '2016-04-17 17:01:52', 7, 0),
(10, 'L''algèbre', 1, '2016-04-17 17:02:30', 7, 0),
(11, 'Premiers pas', 0, '2016-04-17 17:12:58', 8, 0);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

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
(1, 5, 1, 1, 1, 1),
(2, 1, 0, 0, 0, 0),
(2, 2, 1, 1, 1, 1),
(2, 3, 1, 1, 1, 1),
(2, 4, 1, 1, 1, 1),
(2, 5, 1, 1, 1, 1),
(3, 1, 0, 0, 0, 0),
(3, 2, 0, 0, 0, 1),
(3, 3, 0, 0, 0, 0),
(3, 4, 0, 0, 0, 0),
(3, 5, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `techquestion`
--

CREATE TABLE IF NOT EXISTS `techquestion` (
  `id_techquestion` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `statut` int(11) NOT NULL DEFAULT '0',
  `date_creation` datetime DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '1',
  `mot_cles` text NOT NULL,
  `id_membre` int(11) NOT NULL,
  PRIMARY KEY (`id_techquestion`),
  KEY `id_auteur` (`id_membre`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Contenu de la table `techquestion`
--

INSERT INTO `techquestion` (`id_techquestion`, `titre`, `contenu`, `statut`, `date_creation`, `type`, `mot_cles`, `id_membre`) VALUES
(1, 'Les expressions r&eacute;guli&egrave;res en C', 'Les expressions régulières sont une fonctionnalité que l''on trouve dans beaucoup de langages de programmation modernes. En C++, une expression régulière correspond à la classe regex de la bibliothèque standard (dans le fichier d''en-tête regex). Il est possible de créer une expression régulière directement à partir d''une littérale chaîne de caractères ou d''une variable chaîne de type string.\r\n<code>#include <regex>\r\n#include <string>\r\n \r\nint main()\r\n{\r\n    std::regex pattern1 { "bla bla bla" }; // création à partir d''une littérale\r\n \r\n    std::string s { "bla bla bla" };\r\n    std::regex pattern2 { s };             // création à partir d''une string\r\n}</code>\r\n', 0, '2016-03-28 09:24:19', 1, 'regexp', 1),
(2, 'Le localStorage dans un navigateur', 'Nous nous sommes interressé à cette mignone petite fonctionnalité du HTML 5: le localStorage (voir les spécifications HTML 5) .\r\nSon utilisation est plus que simple et ça peut rendre de grands services.\r\n\r\nVoici les principes de bases pour vérifier si le navigateur supporte cette fonctionnalité, stocker une valeur, lire une valeur, effacer une valeur et bien sur tout casser.\r\n\r\nListe des navigateurs qui supporte le localStorage:\r\nIE(8+)	Firefox(3.5+)	Safari(4.0+)	Chrome(4.0+)	Opera(10.5+)	IPhone(2.0+)	Android(2.0+)\r\n\r\nTester si le navigateur supporte localStorage:\r\n<code>\r\nfunction support_localstorage()  \r\n{  \r\n    if (localStorage)  \r\n        return "Local Storage: Supported";  \r\n    else  \r\n        return "Local Storage: Unsupported";  \r\n}\r\n</code>\r\nSauver des données:\r\n\r\n<code>localStorage.setItem("key1", "Sam et Max ça déchire");</code>\r\nou  \r\n<code>localStorage["key1"] = "Sam et Max ça déchire";</code>\r\nLire des données:\r\n<code>\r\nvar mydata = localStorage.getItem("key1");  \r\nvar mydata = localStorage["key1"];</code>\r\nLister toutes les données:\r\n<code>\r\nfor (i=0; i<=localStorage.length-1; i++){\r\n    key = localStorage.key(i) \r\n    mydatas = localStorage.getItem(key);\r\n}</code>\r\nEffacer des données:\r\n<code>\r\nvoid localStorage.removeItem("key1");</code>\r\nTout effacer:\r\n<code>\r\nlocalStorage.clear();</code>\r\nComme vous avez pu le constater c’est très simple d’utilisation (ça me fait penser un peu à REDIS) et ça peut rendre pas mal de services.\r\nAttention quand même à ne pas saturer l’espace qui vous est réservé (environ 5MB) pour celà pensez à effacer les données qui ne vous servent plus.', 0, '2016-03-28 11:16:35', 1, 'C', 1),
(3, 'test insert1', 'test contenu1', 0, '2016-03-28 19:53:45', 1, 'C', 2),
(4, 'question1', 'Voici ma question', 0, '2016-03-29 07:10:23', 2, 'expressions régulières', 2),
(5, 'test insert2', 'test contenu2', 0, '2016-03-29 20:22:33', 1, 'expressions régulières', 1),
(14, 'testTitre3', 'blabla', 0, '2016-04-03 14:00:36', 1, 'regexp, navigateur ', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
