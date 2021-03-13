-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2021 at 03:08 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecole_tdw`
--

-- --------------------------------------------------------

--
-- Table structure for table `activite`
--

CREATE TABLE `activite` (
  `id_activite` int(11) NOT NULL,
  `activite` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activite`
--

INSERT INTO `activite` (`id_activite`, `activite`) VALUES
(1, 'Club scientifique'),
(2, 'Club football'),
(3, 'Club de musique');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `login` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `nom` tinytext NOT NULL,
  `prenom` tinytext NOT NULL,
  `adresse` tinytext NOT NULL,
  `tel1` tinytext NOT NULL,
  `tel2` tinytext NOT NULL,
  `tel3` tinytext NOT NULL,
  `email` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `login`, `password`, `nom`, `prenom`, `adresse`, `tel1`, `tel2`, `tel3`, `email`) VALUES
(1, 'admin', '$2y$10$HMNh2SS9TYDDzSELFN96HeGACi1NIFz61FTKwYbN5wYA5lXIOTzaO', 'Admin', 'Admin', 'Bouzareah, Alger', '0555 55 55 55', '0544 44 55 66', '0555 44 66 66', 'admin@ecole.dz'),
(2, 'ay_ouarab', '$2y$10$kkOmH/oKAkgrikfuiVu6M.bAVXoX6yH1iyZbGKmEa7oHiYfY3pUw6', 'OUARAB', 'Youcef', 'Bouzareah, Alger', '0555 55 55 55', '', '', 'hy_ouarab@gmail.com'),
(3, 'am_benmaiza', '$2y$10$PQ58hET6Wgqk5KRed2a8yOZQFeowUQdrgkUiTOscJhfg/b0Tfw10K', 'BENMAIZA', 'Mohamed', 'El Harrache, Alger', '0666 66 66 66', '0777 77 77 77', '', 'hm_benmaiza@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id_article` int(11) NOT NULL,
  `titre` tinytext NOT NULL,
  `description` text NOT NULL,
  `image` tinytext NOT NULL,
  `parents` tinyint(1) NOT NULL,
  `primaires` tinyint(1) NOT NULL,
  `moyens` tinyint(1) NOT NULL,
  `secondaires` tinyint(1) NOT NULL,
  `enseignants` tinyint(1) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id_article`, `titre`, `description`, `image`, `parents`, `primaires`, `moyens`, `secondaires`, `enseignants`, `created`) VALUES
(1, 'Ouverture de notre nouvelle école à Alger', 'Une nouvelle école ouvrira ses portes le dimanche 14 mars à Bouzaréah, Alger. Elle accueillera des étudiants de tous les niveaux et cycles (primaire, moyen, et secondaire), avec plusieurs disciplines à son curriculum, les meilleures enseignants, et des activités extrascolaire pour les élèves.<br />\r\n<br />\r\nPour plus d\'informations, veuillez consulter la page de présentation de l\'école.  Pour nous contacter, veuillez consulter la page de contact.', 'default.png', 1, 1, 1, 1, 1, '2021-03-12 08:54:38'),
(2, 'Nos enseignants', 'L’enseignement sera assuré par des enseignants dévoués qui encouragent le développement personnel de l\'élève. Loin donc d’imposer des règles particulières, l’objectif premier de cette nouvelle école est de former des jeunes hommes et femmes autonomes et uniques.<br />\r\n<br />\r\nPour plus d\'infos sur nos enseignants, veuillez consulter les pages des cycles d\'éducation.', '1615540482.png', 1, 1, 1, 1, 1, '2021-03-12 08:56:50'),
(3, 'Les activités extrascolaires pour les élèves', 'De la peinture et de la musique en passant par le design, les arts plastiques et la photographie, les sports (football, handball, basketball, tennis...), et les clubs scientifiques, notre nouvelle école proposera des formations sur mesure qui répondent aux besoins de chacun.', '1615540692.jpg', 1, 1, 1, 1, 0, '2021-03-12 08:58:55'),
(4, 'Début de cours pour les primaires', 'Les cours débuteront ce dimanche, 14 mars pour le cycle primaire.  L\'école a déjà pris toutes les mesures nécessaires dans le cadre de la lutte contre le COVID-19.  Tout le staff de l\'école (enseignants, administration, agents...) respectera le protocole sanitaire pour garantir la sécurité de tout le monde dans l\'école, surtout nos chers élèves.', '1615540858.jpg', 1, 1, 0, 0, 1, '2021-03-12 08:59:59'),
(5, 'Début de cours pour les moyens', 'Les cours débuteront ce dimanche, 14 mars pour le cycle moyen. L\'école a déjà pris toutes les mesures nécessaires dans le cadre de la lutte contre le COVID-19. Tout le staff de l\'école (enseignants, administration, agents...) respectera le protocole sanitaire pour garantir la sécurité de tout le monde dans l\'école, surtout nos chers élèves.', '1615541212.jpg', 1, 0, 1, 0, 1, '2021-03-12 09:05:03'),
(6, 'Début de cours pour les secondaires', 'Les cours débuteront ce dimanche, 14 mars pour le cycle secondaire. L\'école a déjà pris toutes les mesures nécessaires dans le cadre de la lutte contre le COVID-19. Tout le staff de l\'école (enseignants, administration, agents...) respectera le protocole sanitaire pour garantir la sécurité de tout le monde dans l\'école, surtout nos chers élèves.', '1615541299.jpg', 1, 0, 0, 1, 1, '2021-03-12 09:08:08'),
(7, 'COVID-19 protocole sanitaire', 'Pour garantir la sécurité de tout le monde dans l\'école, tout le monde doit respecter les règles sanitaires suivantes :<br />\r\n - Portez votre masque de protection partout dans l\'école<br />\r\n - Utilisez le gel hydroalcholique fréquemment<br />\r\n - Respectez la distanciation sociale (au moins 1 mètre)<br />\r\n<br />\r\nEnsemble, protègeons-nous!', '1615541366.jpg', 1, 1, 1, 1, 1, '2021-03-12 09:55:13'),
(8, 'Sports Day 1 !', 'Notre école organisera ce mardi 16 mars, son premier Sports Day, où les élèves de tous les niveaux pourront participer dans des jeux et des compétitions sportifs comme la course, capturer le drapeau, et plusieurs autres activités!<br />\r\n<br />\r\nVous êtes cordialement invités!<br />\r\n<br />\r\nLes inscriptions seront ouvertes en temps opportun.', '1615541689.jpg', 1, 1, 1, 1, 1, '2021-03-12 09:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `classe`
--

CREATE TABLE `classe` (
  `id_classe` varchar(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `cycle` enum('primaire','moyen','secondaire') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `classe`
--

INSERT INTO `classe` (`id_classe`, `annee`, `cycle`) VALUES
('1L1', 1, 'secondaire'),
('1M1', 1, 'moyen'),
('1P', 1, 'primaire'),
('1S1', 1, 'secondaire'),
('2L1', 2, 'secondaire'),
('2M1', 2, 'moyen'),
('2MT', 2, 'secondaire'),
('2P', 2, 'primaire'),
('2S1', 2, 'secondaire'),
('3L1', 3, 'secondaire'),
('3M1', 3, 'moyen'),
('3MT', 3, 'secondaire'),
('3P', 3, 'primaire'),
('3S1', 3, 'secondaire'),
('4M1', 4, 'moyen'),
('4P', 4, 'primaire'),
('5P', 5, 'primaire');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `cle` enum('tel','fax','email','adr','fb','twt','ig','sc','yt') NOT NULL,
  `valeur` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id_contact`, `cle`, `valeur`) VALUES
(3, 'tel', '023 23 23 23'),
(4, 'fax', '023 24 24 24'),
(5, 'email', 'ecole@ecole.dz'),
(6, 'adr', 'Bouzareah, Alger'),
(7, 'fb', 'ecole.dz'),
(8, 'twt', 'ecole.dz'),
(9, 'ig', 'ecole.dz'),
(10, 'sc', 'ecole.dz'),
(11, 'yt', 'ecole.dz');

-- --------------------------------------------------------

--
-- Table structure for table `eleve`
--

CREATE TABLE `eleve` (
  `id_eleve` varchar(11) NOT NULL,
  `date_naissance` date NOT NULL,
  `id_classe` varchar(11) NOT NULL,
  `id_parent` varchar(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `eleve`
--

INSERT INTO `eleve` (`id_eleve`, `date_naissance`, `id_classe`, `id_parent`, `id_utilisateur`) VALUES
('e21_1', '2004-03-12', '3MT', 'p21_2', 1),
('e21_3', '2008-04-10', '3M1', 'p21_2', 3),
('e21_4', '2004-06-12', '3MT', 'p21_5', 4),
('e21_6', '2003-07-04', '3MT', 'p21_7', 6),
('e21_8', '2014-10-14', '3P', 'p21_7', 8);

-- --------------------------------------------------------

--
-- Table structure for table `emploi`
--

CREATE TABLE `emploi` (
  `id_matiere` int(11) NOT NULL,
  `jour` enum('1','2','3','4','5','6','7') NOT NULL,
  `periode` enum('1','2','3','4','5','6','7','8','9','10') NOT NULL,
  `debut` time NOT NULL,
  `fin` time NOT NULL,
  `id_enseignant` varchar(11) NOT NULL,
  `id_classe` varchar(11) NOT NULL,
  `salle` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `emploi`
--

INSERT INTO `emploi` (`id_matiere`, `jour`, `periode`, `debut`, `fin`, `id_enseignant`, `id_classe`, `salle`) VALUES
(3, '1', '1', '08:00:00', '10:00:00', 's21_10', '3M1', 'LABO1'),
(8, '1', '4', '13:30:00', '15:30:00', 's21_13', '3M1', 'S20'),
(7, '2', '1', '08:00:00', '10:00:00', 's21_13', '3M1', 'S20'),
(1, '1', '1', '08:00:00', '10:00:00', 's21_14', '3MT', 'S11'),
(2, '1', '2', '10:00:00', '12:00:00', 's21_11', '3MT', 'S11'),
(1, '2', '1', '08:00:00', '10:00:00', 's21_14', '3MT', 'S11'),
(2, '2', '4', '13:30:00', '15:30:00', 's21_11', '3MT', 'LABO2'),
(5, '1', '1', '08:00:00', '09:00:00', 's21_9', '5P', 'S5');

-- --------------------------------------------------------

--
-- Table structure for table `enseignant`
--

CREATE TABLE `enseignant` (
  `id_enseignant` varchar(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enseignant`
--

INSERT INTO `enseignant` (`id_enseignant`, `id_utilisateur`) VALUES
('s21_10', 10),
('s21_11', 11),
('s21_12', 12),
('s21_13', 13),
('s21_14', 14),
('s21_9', 9);

-- --------------------------------------------------------

--
-- Table structure for table `enseigne`
--

CREATE TABLE `enseigne` (
  `id_enseignant` varchar(11) NOT NULL,
  `id_classe` varchar(11) NOT NULL,
  `id_matiere` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enseigne`
--

INSERT INTO `enseigne` (`id_enseignant`, `id_classe`, `id_matiere`) VALUES
('s21_10', '3M1', 3),
('s21_10', '4M1', 3),
('s21_11', '2MT', 2),
('s21_11', '3MT', 2),
('s21_12', '3P', 4),
('s21_13', '1M1', 7),
('s21_13', '1M1', 8),
('s21_13', '3M1', 7),
('s21_13', '3M1', 8),
('s21_14', '2MT', 1),
('s21_14', '3MT', 1),
('s21_9', '3P', 5),
('s21_9', '4P', 5),
('s21_9', '5P', 5);

-- --------------------------------------------------------

--
-- Table structure for table `matiere`
--

CREATE TABLE `matiere` (
  `id_matiere` int(11) NOT NULL,
  `nom` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `matiere`
--

INSERT INTO `matiere` (`id_matiere`, `nom`) VALUES
(1, 'Mathématiques'),
(2, 'Physiques'),
(3, 'Sciences'),
(4, 'Arabe'),
(5, 'Français'),
(6, 'Anglais'),
(7, 'Histoire'),
(8, 'Géographie'),
(9, 'Sport'),
(10, 'Musique');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id_eleve` varchar(11) NOT NULL,
  `id_classe` varchar(11) NOT NULL,
  `id_matiere` int(11) NOT NULL,
  `trimestre` enum('1','2','3') NOT NULL,
  `continu` double NOT NULL,
  `devoir` double NOT NULL,
  `examen` double NOT NULL,
  `moyenne` double NOT NULL,
  `remarque` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id_eleve`, `id_classe`, `id_matiere`, `trimestre`, `continu`, `devoir`, `examen`, `moyenne`, `remarque`) VALUES
('e21_1', '3MT', 1, '1', 18, 18, 18, 18, 'Très bien!!'),
('e21_1', '3MT', 1, '2', 20, 20, 20, 20, 'Très très bien!!'),
('e21_1', '3MT', 2, '1', 20, 20, 20, 20, 'Très bien!!'),
('e21_1', '3MT', 2, '2', 16, 16, 16, 16, 'Bien!'),
('e21_4', '3MT', 1, '1', 12, 12, 12, 12, 'Il faut travailler plus!'),
('e21_4', '3MT', 1, '2', 14, 14, 14, 14, 'Bonnes notes!'),
('e21_4', '3MT', 2, '1', 15, 15, 15, 15, 'Bien!'),
('e21_4', '3MT', 2, '2', 12, 12, 12, 12, 'Bien'),
('e21_6', '3MT', 1, '1', 8, 8, 8, 8, 'Il faut travailler plus!'),
('e21_6', '3MT', 1, '2', 15, 15, 15, 15, 'Bonne notes!'),
('e21_6', '3MT', 2, '1', 10, 10, 10, 10, 'Il faut travailler plus!'),
('e21_6', '3MT', 2, '2', 14, 14, 14, 14, 'Une nette amélioration!');

-- --------------------------------------------------------

--
-- Table structure for table `paragraphe`
--

CREATE TABLE `paragraphe` (
  `id_paragraphe` int(11) NOT NULL,
  `texte` text NOT NULL,
  `image` tinytext NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `paragraphe`
--

INSERT INTO `paragraphe` (`id_paragraphe`, `texte`, `image`, `created`) VALUES
(1, 'Notre école a ouvert ses portes le dimanche 14 mars 2021 à Bouzaréah, Alger. Elle accueille des étudiants de tous les niveaux et cycles (primaire, moyen, et secondaire), avec plusieurs disciplines à son curriculum, les meilleures enseignants, et des activités extrascolaire pour les élèves.', '1615541992.png', '2021-03-12 11:08:11'),
(2, 'L’enseignement sera assuré par des enseignants dévoués qui encouragent le développement personnel de l\'élève. Loin donc d’imposer des règles particulières, l’objectif premier de cette nouvelle école est de former des jeunes hommes et femmes autonomes et uniques.', '1615542020.png', '2021-03-12 11:10:18'),
(3, 'Pour plus d\'infos sur nos enseignants, veuillez consulter les pages des cycles d\'éducation. Pour nous contacter, veuillez consulter la page de contact.', '', '2021-03-12 11:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `id_parent` varchar(11) NOT NULL,
  `date_naissance` date NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parent`
--

INSERT INTO `parent` (`id_parent`, `date_naissance`, `id_utilisateur`) VALUES
('p21_2', '1988-12-03', 2),
('p21_5', '1980-01-05', 5),
('p21_7', '1973-08-29', 7);

-- --------------------------------------------------------

--
-- Table structure for table `participe`
--

CREATE TABLE `participe` (
  `id_eleve` varchar(11) NOT NULL,
  `id_activite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `participe`
--

INSERT INTO `participe` (`id_eleve`, `id_activite`) VALUES
('e21_1', 2),
('e21_1', 3),
('e21_3', 1),
('e21_3', 3),
('e21_4', 2),
('e21_6', 1),
('e21_8', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reception`
--

CREATE TABLE `reception` (
  `id_enseignant` varchar(11) NOT NULL,
  `jour` enum('dim','lun','mar','mer','jeu','ven','sam') NOT NULL,
  `debut` time NOT NULL,
  `fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reception`
--

INSERT INTO `reception` (`id_enseignant`, `jour`, `debut`, `fin`) VALUES
('s21_10', 'mar', '14:30:00', '15:00:00'),
('s21_11', 'mar', '13:00:00', '13:30:00'),
('s21_12', 'lun', '12:30:00', '13:00:00'),
('s21_12', 'jeu', '12:30:00', '13:00:00'),
('s21_13', 'lun', '12:30:00', '13:00:00'),
('s21_14', 'jeu', '15:30:00', '16:00:00'),
('s21_9', 'dim', '12:30:00', '13:00:00'),
('s21_9', 'mar', '13:30:00', '14:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `restauration`
--

CREATE TABLE `restauration` (
  `jour` varchar(11) NOT NULL,
  `repas` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restauration`
--

INSERT INTO `restauration` (`jour`, `repas`) VALUES
('dim', '<br />\r\nRepas : Soupe<br />\r\n<br />\r\nSalade : Oui<br />\r\n<br />\r\nDessert : Pommes, oranges<br />\r\n'),
('jeu', ''),
('lun', ''),
('mar', ''),
('mer', ''),
('sam', ''),
('ven', '');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` tinytext NOT NULL,
  `nom` tinytext NOT NULL,
  `prenom` tinytext NOT NULL,
  `adresse` tinytext NOT NULL,
  `tel1` tinytext NOT NULL,
  `tel2` tinytext NOT NULL,
  `tel3` tinytext NOT NULL,
  `email` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `login`, `password`, `nom`, `prenom`, `adresse`, `tel1`, `tel2`, `tel3`, `email`) VALUES
(1, 'ea_ouarab', '$2y$10$xPA3W/gd4x48rgAsYJVieO4SP8MlR6gQM9/yJU9ke3ut0a2xDDrYO', 'OUARAB', 'Assil', 'Bouzareah, Alger', '', '', '', 'assil.ouarab@gmail.com'),
(2, 'pa_ouarab', '$2y$10$igRiGe5zbplPWaoOct.fu.WCyCmxsMbcgfBUQakWFH7yIXir8KzJy', 'OUARAB', 'Ahmed', 'Bouzareah, Alger', '0540 40 50 60', '0660 38 38 16', '', 'ouarab.ahmed@gmail.com'),
(3, 'en_ouarab', '$2y$10$wtv/rD4f64N7cpSNNicE9uBUxP7wqSMJ9FPUaxr0dYIjR999A4/A.', 'OUARAB', 'Nesrine', 'Bouzareah, Alger', '', '', '', 'ouarab.nesrine@gmail.com'),
(4, 'em_grine', '$2y$10$NUlYQ7PBiQO3lgiSMW7OKepPxViLQHZcEHC63StIhnMxkCGYQNvIK', 'GRINE', 'Mohamed', 'Bab El Oued, Alger', '0555 55 77 99', '', '', 'grine.moha@gmail.com'),
(5, 'pn_meziane', '$2y$10$WUplLWslw1ecAmGvcNXzdOq7K96TUYwWGzplvpUI0f7eEVgrCRq6e', 'MEZIANE', 'Noura', 'Bab El Oued', '0640 46 46 17', '', '', 'meziane_noura@gmail.com'),
(6, 'el_abbane', '$2y$10$WESfuLxjw53hzUUhYx8I6OR09/4/iGxs4lt9NFrDDsj6RQadNDayi', 'ABBANE', 'Lila', 'Beni Messous, Alger', '', '', '', 'abbane.lili@gmail.com'),
(7, 'pn_abbane', '$2y$10$D7gjliAR1DzfajDxWpm98.kBNKFxOWa0hdITQ8r0ufnKXc86DBur.', 'ABBANE', 'Nour_Eddine', 'Beni Messous, Alger', '0556 65 56 61', '', '', 'abbane_nouri@gmail.com'),
(8, 'ed_abbane', '$2y$10$aM.9M52sKlxpsVIv8wCAL.X66djXm0ZZGdaEQYkhULil2JhfF8rJW', 'ABBANE', 'Djamel', 'Beni Messous, Alger', '', '', '', 'djamel.abb@gmail.com'),
(9, 'sl_mecharbat', '$2y$10$tPryu7sBrr2npKihrsd2V.74T3WxPyM/lrkjUyFSZLcPEmQWRs/8a', 'MECHARBAT', 'Lotfi', 'Bouzareah, Alger', '0555 50 50 50', '', '', 'hl_mecharbat@gmail.com'),
(10, 'si_hamzaoui', '$2y$10$85J1PrcU0jzw8qjUcNRRIuczKXLLw41dQIDtljRhADEeptifsbkaS', 'HAMZAOUI', 'Idriss', 'Douira, Alger', '0555 55 44 22', '', '', 'idriss.hmz@gmail.com'),
(11, 'sa_benbrahim', '$2y$10$6ed1z1EQYC06.xN8sOq1cuM8tRJ63AJXwNQnHVbsFxW0CYwSuvC/2', 'BENBRAHIM', 'Abdelghani', 'Baba H\'cene', '0640 40 60 64', '', '', 'benbrah.ghanou@gmail.com'),
(12, 'si_benzerara', '$2y$10$TOlvJoMAKkwg1NepvuzQmuF02/Ss16MjbWCM5FneSE0yaaQenB6Ce', 'BENZERARA', 'Ibtissem', 'Alger Centre, Alger', '0668 68 68 68', '0545 45 45 45', '0787 87 87 87', 'ibtissem.benz@gmail.com'),
(13, 'sl_zahwi', '$2y$10$Y8ZXa5YqjmaAjJMAPwIE9.iDBMqKgb8YmwFIbGBWtVqnwkqGzCOwO', 'ZAHWI', 'Lamia', 'Bab Ezzouar, Alger', '0555 50 40 40', '', '', 'lamia.zahwi@gmail.com'),
(14, 'ss_aliane', '$2y$10$8QxsrR6lkOph.jpepS1CDuS.SSld84zgqFNx3gRkVEY/glbWEhd4m', 'ALIANE', 'Samira', 'Oued Smar, Alger', '0650 50 50 52', '0770 70 70 72', '', 'alina.samira@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activite`
--
ALTER TABLE `activite`
  ADD PRIMARY KEY (`id_activite`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id_article`);

--
-- Indexes for table `classe`
--
ALTER TABLE `classe`
  ADD PRIMARY KEY (`id_classe`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`);

--
-- Indexes for table `eleve`
--
ALTER TABLE `eleve`
  ADD PRIMARY KEY (`id_eleve`);

--
-- Indexes for table `emploi`
--
ALTER TABLE `emploi`
  ADD PRIMARY KEY (`id_classe`,`jour`,`periode`) USING BTREE;

--
-- Indexes for table `enseignant`
--
ALTER TABLE `enseignant`
  ADD PRIMARY KEY (`id_enseignant`);

--
-- Indexes for table `enseigne`
--
ALTER TABLE `enseigne`
  ADD PRIMARY KEY (`id_enseignant`,`id_classe`,`id_matiere`);

--
-- Indexes for table `matiere`
--
ALTER TABLE `matiere`
  ADD PRIMARY KEY (`id_matiere`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id_eleve`,`id_classe`,`id_matiere`,`trimestre`);

--
-- Indexes for table `paragraphe`
--
ALTER TABLE `paragraphe`
  ADD PRIMARY KEY (`id_paragraphe`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`id_parent`);

--
-- Indexes for table `participe`
--
ALTER TABLE `participe`
  ADD PRIMARY KEY (`id_eleve`,`id_activite`);

--
-- Indexes for table `reception`
--
ALTER TABLE `reception`
  ADD PRIMARY KEY (`id_enseignant`,`jour`,`debut`);

--
-- Indexes for table `restauration`
--
ALTER TABLE `restauration`
  ADD PRIMARY KEY (`jour`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activite`
--
ALTER TABLE `activite`
  MODIFY `id_activite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `matiere`
--
ALTER TABLE `matiere`
  MODIFY `id_matiere` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `paragraphe`
--
ALTER TABLE `paragraphe`
  MODIFY `id_paragraphe` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
