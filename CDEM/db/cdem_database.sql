-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 15 déc. 2020 à 02:27
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cdem_database`
--

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `code` varchar(6) NOT NULL,
  `nbMaxPlayers` int(11) NOT NULL,
  `scoreMax` int(11) NOT NULL,
  `isInProgress` tinyint(1) NOT NULL,
  `isPublic` tinyint(1) NOT NULL,
  `currentNum` int(11) NOT NULL,
  `currentID` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `minigame`
--

DROP TABLE IF EXISTS `minigame`;
CREATE TABLE IF NOT EXISTS `minigame` (
  `idMinigame` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `timeMax` time NOT NULL,
  PRIMARY KEY (`idMinigame`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `minigame`
--

INSERT INTO `minigame` (`idMinigame`, `name`, `timeMax`) VALUES
(1, 'Clicker', '00:00:45'),
(2, 'Spammer', '00:00:45'),
(3, 'Taupe', '00:00:45'),
(4, 'Calculation', '00:01:00');

-- --------------------------------------------------------

--
-- Structure de la table `play`
--

DROP TABLE IF EXISTS `play`;
CREATE TABLE IF NOT EXISTS `play` (
  `idPlay` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(6) NOT NULL,
  `idPlayer` varchar(50) NOT NULL,
  `username` varchar(255) NOT NULL,
  `isHost` tinyint(1) NOT NULL,
  PRIMARY KEY (`idPlay`)
) ENGINE=InnoDB AUTO_INCREMENT=1132 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `idPlayer` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`idPlayer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `play_minigame`
--

DROP TABLE IF EXISTS `play_minigame`;
CREATE TABLE IF NOT EXISTS `play_minigame` (
  `idPlayMinigame` int(11) NOT NULL AUTO_INCREMENT,
  `idPlay` int(11) NOT NULL,
  `idMinigame` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `startDate` timestamp NULL DEFAULT NULL,
  `endDate` timestamp NULL DEFAULT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`idPlayMinigame`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
