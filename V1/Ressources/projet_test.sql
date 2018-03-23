-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 18 déc. 2017 à 06:47
-- Version du serveur :  5.7.20-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projet_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `Formation`
--

CREATE TABLE `Formation` (
  `ID` varchar(45) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `nb_niveaux` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Formation`
--

INSERT INTO `Formation` (`ID`, `nom`, `nb_niveaux`, `date`) VALUES
('2a151b4b-1d57-11e7-96d7-deadbeefb101', 'Département Informatique', 2, '2017-04-09 19:03:06'),
('4cc3f0a5-1907-11e7-96d7-deadbeefb101', 'IUT de Nantes', 5, '2017-04-04 07:21:20'),
('527c2513-a768-11e7-96d7-deadbeefb101', 'Informatique', 2, '2017-10-02 11:53:36');

-- --------------------------------------------------------

--
-- Structure de la table `Module`
--

CREATE TABLE `Module` (
  `ID` varchar(45) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `UE_ID` varchar(45) NOT NULL,
  `nbHeuresTD` decimal(11,0) NOT NULL,
  `nbHeuresTP` decimal(11,0) NOT NULL,
  `nbHeuresCM` decimal(11,0) NOT NULL,
  `nbHeuresDS` decimal(11,0) NOT NULL,
  `duree` decimal(11,0) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Module`
--

INSERT INTO `Module` (`ID`, `nom`, `UE_ID`, `nbHeuresTD`, `nbHeuresTP`, `nbHeuresCM`, `nbHeuresDS`, `duree`, `date`) VALUES
('M1101', 'Introduction aux systèmes informatiques', 'dbbb8780-1907-11e7-96d7-deadbeefb101', '7', '10', '8', '8', '85', '2017-04-04 07:38:50'),
('M1102', 'Introduction à l\'algorithmique et à la programmation', 'dbbb8780-1907-11e7-96d7-deadbeefb101', '14', '9', '9', '9', '172', '2017-04-04 07:40:39'),
('M1103', 'Structures de données et algorithmique fondamentaux', 'dbbb8780-1907-11e7-96d7-deadbeefb101', '7', '4', '5', '7', '172', '2017-04-04 07:41:49'),
('M1104-1', 'Modélisation de données', 'dbbb8780-1907-11e7-96d7-deadbeefb101', '7', '7', '7', '4', '172', '2017-04-04 08:06:15'),
('M1104-2', 'Bases de données', 'dbbb8780-1907-11e7-96d7-deadbeefb101', '5', '7', '6', '5', '172', '2017-04-04 07:42:20'),
('M1105', 'Conception de documents et d\'interfaces numériques', '576e059c-190f-11e7-96d7-deadbeefb101', '7', '6', '7', '6', '46', '2017-04-04 08:22:32'),
('M1202', 'Algèbre linéaire', '576e059c-190f-11e7-96d7-deadbeefb101', '5', '6', '6', '6', '85', '2017-04-04 08:47:39'),
('M1203', 'Environnement économique', '576e059c-190f-11e7-96d7-deadbeefb101', '5', '7', '6', '6', '172', '2017-04-04 08:49:14'),
('M1204', 'Fonctionnement des organisations', '576e059c-190f-11e7-96d7-deadbeefb101', '11', '9', '8', '10', '172', '2017-04-04 08:51:26'),
('M1207', 'PPP - Connaître le monde professionnel', '576e059c-190f-11e7-96d7-deadbeefb101', '5', '6', '8', '5', '85', '2017-04-04 08:50:38');

-- --------------------------------------------------------

--
-- Structure de la table `Niveau`
--

CREATE TABLE `Niveau` (
  `ID` varchar(45) NOT NULL,
  `numNiveau` int(11) DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `Formation_ID` varchar(45) NOT NULL,
  `nbTD` int(11) DEFAULT NULL,
  `nbCM` int(11) DEFAULT NULL,
  `nbTP` int(11) DEFAULT NULL,
  `nbDS` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Niveau`
--

INSERT INTO `Niveau` (`ID`, `numNiveau`, `nom`, `Formation_ID`, `nbTD`, `nbCM`, `nbTP`, `nbDS`, `date`) VALUES
('2a154133-1d57-11e7-96d7-deadbeefb101', 1, 'INFO 1', '2a151b4b-1d57-11e7-96d7-deadbeefb101', 3, 1, 5, 6, '2017-04-09 19:03:06'),
('2a155db7-1d57-11e7-96d7-deadbeefb101', 2, 'INFO 2', '2a151b4b-1d57-11e7-96d7-deadbeefb101', 3, 1, 3, 2, '2017-04-09 19:03:06'),
('4cc4171e-1907-11e7-96d7-deadbeefb101', 1, 'INFO 1', '4cc3f0a5-1907-11e7-96d7-deadbeefb101', 5, 4, 5, 4, '2017-04-04 07:21:20'),
('4cc8d101-1907-11e7-96d7-deadbeefb101', 2, 'INFO 2', '4cc3f0a5-1907-11e7-96d7-deadbeefb101', 3, 7, 3, 7, '2017-04-04 07:21:20'),
('4cc8ed08-1907-11e7-96d7-deadbeefb101', 3, 'Licence Pro', '4cc3f0a5-1907-11e7-96d7-deadbeefb101', 1, 1, 3, 1, '2017-04-04 07:21:20'),
('4cc8fe95-1907-11e7-96d7-deadbeefb101', 4, 'Alternant 1', '4cc3f0a5-1907-11e7-96d7-deadbeefb101', 3, 3, 2, 3, '2017-04-04 07:21:20'),
('4cc9108a-1907-11e7-96d7-deadbeefb101', 5, 'Alternant 2', '4cc3f0a5-1907-11e7-96d7-deadbeefb101', 3, 3, 2, 3, '2017-04-04 07:21:20'),
('527c45f5-a768-11e7-96d7-deadbeefb101', 1, 'INFO 1', '527c2513-a768-11e7-96d7-deadbeefb101', 4, 1, 8, 1, '2017-10-02 11:53:36'),
('527c7385-a768-11e7-96d7-deadbeefb101', 2, 'INFO 2', '527c2513-a768-11e7-96d7-deadbeefb101', 4, 1, 4, 1, '2017-10-02 11:53:36');

-- --------------------------------------------------------

--
-- Structure de la table `UE`
--

CREATE TABLE `UE` (
  `ID` varchar(45) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `Niveau_ID` varchar(45) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `UE`
--

INSERT INTO `UE` (`ID`, `nom`, `Niveau_ID`, `date`) VALUES
('46c6db14-1d58-11e7-96d7-deadbeefb101', 'UE 11 : Bases de l\'informatique', '2a154133-1d57-11e7-96d7-deadbeefb101', '2017-04-09 19:11:03'),
('5582bf72-e392-11e7-b54c-34de1a0e7e8c', 'UE13', '4cc4171e-1907-11e7-96d7-deadbeefb101', '2017-12-18 01:25:29'),
('576e059c-190f-11e7-96d7-deadbeefb101', 'UE12', '4cc4171e-1907-11e7-96d7-deadbeefb101', '2017-04-04 08:18:54'),
('cbfd2d3f-a768-11e7-96d7-deadbeefb101', 'UE 11', '527c45f5-a768-11e7-96d7-deadbeefb101', '2017-10-02 11:56:59'),
('dbbb8780-1907-11e7-96d7-deadbeefb101', 'UE11', '4cc4171e-1907-11e7-96d7-deadbeefb101', '2017-04-04 07:25:20'),
('f78369c7-a768-11e7-96d7-deadbeefb101', 'UE 12', '527c45f5-a768-11e7-96d7-deadbeefb101', '2017-10-02 11:58:12');

-- --------------------------------------------------------

--
-- Structure de la table `Utilisateur`
--

CREATE TABLE `Utilisateur` (
  `ID` varchar(45) NOT NULL,
  `formation_ID` varchar(45) NOT NULL,
  `login` varchar(80) DEFAULT NULL,
  `mdp` varchar(150) DEFAULT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `titre` varchar(150) DEFAULT NULL,
  `nbHeures` int(11) NOT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Utilisateur`
--

INSERT INTO `Utilisateur` (`ID`, `formation_ID`, `login`, `mdp`, `nom`, `prenom`, `type`, `titre`, `nbHeures`, `date_inscription`) VALUES
('1ae63075-1906-11e7-96d7-deadbeefb101', '2a151b4b-1d57-11e7-96d7-deadbeefb101', 'henri.dupont@etu.univ-nantes.fr', '$2y$10$9fQsPYM8W4mc6xbUrcwCFe8j.zOU/RPVnf9mOT0Gn1NNFlr1m1Mdq', 'Dupont', 'Henri', 1, 'Enseignant', 0, '2017-04-04 07:12:46'),
('286243cd-e3aa-11e7-b54c-34de1a0e7e8c', '4cc3f0a5-1907-11e7-96d7-deadbeefb101', 'test@test.test', '$2y$10$kkmbsh40pao29YVCcVIzBufD.chM7oSvlZLq/jEJ.iMtEBAF7RLh.', 'test', 'test', 3, 'Enseignant', 384, '2017-12-18 04:16:01'),
('557a23e3-e3a7-11e7-b54c-34de1a0e7e8c', '4cc3f0a5-1907-11e7-96d7-deadbeefb101', 'machin@truc.fr', '$2y$10$R0RPxLmJsM.J1.4tjszZIOYL6aTAV1WbE/voEkhYUGvytuhvwN632', 'truc', 'machin', 0, 'Enseignant', 384, '2017-12-18 03:55:49'),
('e7e6793b-cf70-11e7-96d7-deadbeefb101', '2a151b4b-1d57-11e7-96d7-deadbeefb101', 'ljjhkj@gmail.com', '$2y$10$HPAaUvi5wnjXaExG5NA.gOwH7KQhWzesLRXtWQTyXYZzA9Zd7MALy', 'Marquez', 'Lola ', 0, 'enseignant', 0, '2017-11-22 10:35:49'),
('f1426647-1148-11e7-96d7-deadbeefb101', '2a151b4b-1d57-11e7-96d7-deadbeefb101', 'yanis.ouakrim@etu.univ-nantes.fr', '$2y$10$S8A/Y/qmdx9yWQLE/E3.UODaNkfbxt/8ZAJcuthCynbd66C7rNThu', 'Ouakrim', 'Yanis', 0, 'enseignant', 0, '2017-03-25 10:51:04'),
('fb431ab3-c92a-11e7-96d7-deadbeefb101', '2a151b4b-1d57-11e7-96d7-deadbeefb101', 'admin@orce.com', '$2y$10$8L066rTOWvTDgMyF/KMVhenjbRz6UwJE0grKL0rrmuqOZUMizDl9e', 'Admin', 'Orce', 0, 'enseignant', 0, '2017-11-14 11:00:09');

-- --------------------------------------------------------

--
-- Structure de la table `Voeu`
--

CREATE TABLE `Voeu` (
  `ID` varchar(45) NOT NULL,
  `commentaire` text,
  `Module_ID` varchar(255) NOT NULL,
  `Utilisateur_ID` varchar(45) NOT NULL,
  `nbGroupesTD` int(11) NOT NULL,
  `nbGroupesTP` int(11) NOT NULL,
  `nbGroupesCM` int(11) NOT NULL,
  `nbGroupesDS` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Voeu`
--

INSERT INTO `Voeu` (`ID`, `commentaire`, `Module_ID`, `Utilisateur_ID`, `nbGroupesTD`, `nbGroupesTP`, `nbGroupesCM`, `nbGroupesDS`, `date`) VALUES
('07e1b5cc-da8f-11e7-96d7-deadbeefb101', '', 'M1101', 'f1426647-1148-11e7-96d7-deadbeefb101', 0, 3, 3, 0, '2017-12-06 14:09:10'),
('28d6a719-ca16-11e7-96d7-deadbeefb101', '', 'M1202', 'f1426647-1148-11e7-96d7-deadbeefb101', 1, 2, 3, 0, '2017-11-15 15:03:38'),
('3ac17dfe-1add-11e7-96d7-deadbeefb101', '', 'M1105', 'f1426647-1148-11e7-96d7-deadbeefb101', 1, 1, 1, 1, '2017-04-06 15:25:13');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Formation`
--
ALTER TABLE `Formation`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `Module`
--
ALTER TABLE `Module`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_Module_UE1_idx` (`UE_ID`);

--
-- Index pour la table `Niveau`
--
ALTER TABLE `Niveau`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_Niveau_Formation1_idx` (`Formation_ID`);

--
-- Index pour la table `UE`
--
ALTER TABLE `UE`
  ADD PRIMARY KEY (`ID`,`Niveau_ID`),
  ADD KEY `fk_UE_Niveau1_idx` (`Niveau_ID`);

--
-- Index pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_Utilisateur_Formation_idx` (`formation_ID`);

--
-- Index pour la table `Voeu`
--
ALTER TABLE `Voeu`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_Voeu_Utilisateur1_idx` (`Utilisateur_ID`),
  ADD KEY `FK_Voeu_Module` (`Module_ID`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Module`
--
ALTER TABLE `Module`
  ADD CONSTRAINT `fk_Module_UE1` FOREIGN KEY (`UE_ID`) REFERENCES `UE` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Niveau`
--
ALTER TABLE `Niveau`
  ADD CONSTRAINT `fk_Niveau_Formation1` FOREIGN KEY (`Formation_ID`) REFERENCES `Formation` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `UE`
--
ALTER TABLE `UE`
  ADD CONSTRAINT `fk_UE_Niveau1` FOREIGN KEY (`Niveau_ID`) REFERENCES `Niveau` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Utilisateur`
--
ALTER TABLE `Utilisateur`
  ADD CONSTRAINT `fk_Utilisateur_Formation` FOREIGN KEY (`formation_ID`) REFERENCES `Formation` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Voeu`
--
ALTER TABLE `Voeu`
  ADD CONSTRAINT `FK_Voeu_Module` FOREIGN KEY (`Module_ID`) REFERENCES `Module` (`ID`),
  ADD CONSTRAINT `fk_Voeu_Utilisateur1` FOREIGN KEY (`Utilisateur_ID`) REFERENCES `Utilisateur` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
