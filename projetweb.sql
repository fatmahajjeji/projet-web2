-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : lun. 10 mars 2025 à 14:24
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projetweb`
--

-- --------------------------------------------------------

--
-- Structure de la table `adhesions`
--

CREATE TABLE `adhesions` (
  `id` int(11) NOT NULL,
  `nom_prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `motivation` text NOT NULL,
  `club` varchar(255) NOT NULL,
  `cv` longblob DEFAULT NULL,
  `date_demande` timestamp NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `adhesions`
--

INSERT INTO `adhesions` (`id`, `nom_prenom`, `email`, `motivation`, `club`, `cv`, `date_demande`, `user_id`) VALUES
(1, 'eya hamdi', 'eyahamdi@gmail.com', 'integration', 'Infolab', '', '2025-03-08 10:52:46', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `clubs`
--

CREATE TABLE `clubs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `date_creation` date NOT NULL,
  `fondateur` varchar(255) NOT NULL,
  `id_responsable` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clubs`
--

INSERT INTO `clubs` (`id`, `nom`, `date_creation`, `fondateur`, `id_responsable`) VALUES
(1, 'infolab', '2022-05-01', 'afef slama', NULL),
(2, 'enactus', '2016-11-23', 'rayen souli', 2),
(3, 'fahmolougia', '2022-11-01', 'mehdi cherif', NULL),
(5, 'eventclub', '2025-02-19', 'cherif mohamedd', 2);

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id_utilisateur` int(11) NOT NULL,
  `id_club` int(11) NOT NULL,
  `date_confirmation` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id_utilisateur`, `id_club`, `date_confirmation`) VALUES
(32, 5, '2025-03-10'),
(30, 2, '2025-03-10');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `mail` varchar(200) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `mail`, `mot_de_passe`, `role`) VALUES
(1, 'monsieur administrateur', 'admin@gmail.com', '$2y$10$0HubM6i.4BT63LtziwYWIOcqpRdvya2RhcDhqJIXP0NVrYfkmc.SW', 'administrateur'),
(2, 'monsieur responsable', 'responsable@gmail.com', '$2y$10$4DfC49kY81o3bns8.5qiceR.WwSwwfN7uKLH3l1tXkpjnrVpDlBy2', 'responsable_club'),
(3, 'fatma hajjeji', 'fatmahajjeji@gmail.com', '$2y$10$VocMBtbJRf9lngp396k6iekwiY1fdNsuOD5xXasSeQKnNrNmL7Kia', 'etudiant'),
(4, 'emna rahmoun', 'emnarahmoun@gmail.com', '$2y$10$A5pT8TrrweEo6PDPdUae2eCTKUWg1dCK4uMTa4ZbxpsvOWkmJsE1a', 'etudiant'),
(5, 'elaa boubakri', 'elaaboubakri@gmail.com', '$2y$10$HewbzDmRrrW7OE.7IUZDaOrCn82U98aqLPLrI.L/Fct7D0aYZHeqK', 'etudiant'),
(6, 'mohamed afsa', 'mohamedafsa@gmail.com', '$2y$10$Ha1ADjbEfvVG6eaqln9yzeOjzTqnk8pS1dcCDtP1PTxg.t01MNm0e', 'etudiant'),
(7, 'iheb maiza', 'ihebmaiza@gmail.com', '$2y$10$kEXnK2vJTSUYZsw6dlrH/ud6n0BlDLXdlZe4SXC0zeufudaMHn8Vm', 'etudiant'),
(8, 'islem rebai', 'islemrebai@gmail.com', '$2y$10$jS/IMPEm8fNGXUDlzwRDoOR3hqqxxb9uniBtvQ3TyrKc4AvoVNnt.', 'etudiant'),
(9, 'serine khelifi', 'sirinekhelifi@gmail.com', '$2y$10$/QP4FLMUVS6mpnF28tDVSeo4bTLecSldh3Gmn8b1/PRVlzK2q/0Gq', 'etudiant'),
(10, 'nour cherni', 'nourcherni@gmail.com', '$2y$10$8Y2E4zbGpg7H1u5yAfrHSOEqmGOgvTjnYtvaZl.DxIkjyx8RO3SGe', 'etudiant'),
(11, 'saif bouali', 'saifbouali@gmail.com', '$2y$10$F.hPlCaI.bbvJmcSKoQn2OJ28ODu9hoHapJlU.GyTstjUETG4A3HW', 'etudiant'),
(12, 'amenallah robbena', 'amenallahrobbena@gmail.com', '$2y$10$NgHskx/Y5fVy.z3RT3xI7eU.32Bfbr8GHy6MLgnIEVACR3YJPNlKu', 'etudiant'),
(13, 'khadija ben majdoub', 'khadijabenmajdoub@gmail.com', '$2y$10$3Bmce2LqS0v28IrgWGeoPOxzPLI0oz0ytVqiRfGKpvgUD92itYmau', 'etudiant'),
(14, 'yasmine ben sta', 'yasminebensta@gmail.com', '$2y$10$kg2RpV9ofbWDXyAu9t6aNOQT49ANtqQpM/ONXp8bmgMHrIStuL7Sy', 'etudiant'),
(15, 'maha nouredin', 'mahanourdin@gmail.com', '$2y$10$7ZN//BnnQq7sjRmHvjTcMexD9yLZQvziVXqjtDVDhm.CnFVbBFz4y', 'etudiant'),
(16, 'wassim jha', 'wassimjha@gmail.com', '$2y$10$dCWjwiYJDUeU/O2HVqyyze5ecLAZCATjCwZ1tSmEn7bIgAJ/BslP.', 'etudiant'),
(17, 'iheb baccar', 'ihebbaccar@gmail.com', '$2y$10$UqXFr19ie9PMBj8ZMYk70eXeEughqXpA4041pxYHT6c7Y9I/xC8.y', 'etudiant'),
(18, 'oumaima ben nasr', 'oumaimabennasr@gmail.com', '$2y$10$KRwmVr586WXME5TJdWtP9eHBZjmFwzr4vfVdPu7f6G5lvIGRErBle', 'etudiant'),
(19, 'eya bedhiafi', 'eyabedhiafi@gmail.com', '$2y$10$cGvgR8ofjFIXGT4tmmcfDuqCigIQRtJ0cNJ8ZyYrI8MdIknomMeBK', 'etudiant'),
(20, 'ikram bouali', 'ikrambouali@gmail.com', '$2y$10$P2lQm8OSG7HwBfx6scQ8IOkBKEJchvIxnsywG4RvEAXJGuw.SPxTe', 'etudiant'),
(21, 'koussay bejaoui', 'koussaybejaoui@gmail.com', '$2y$10$4oP4cOsa5WQ3YfPVMXgHSOvwNOFT13oBeJc4emo9UK4sXLNdH1Vf2', 'etudiant'),
(22, 'montasar ghanmi', 'montasarghanmi@gmail.com', '$2y$10$Nb1S1RFTeOwWMoDL4wqt6.veh2l/Ns79HLP90n9mpKMxqSv8cbi3C', 'etudiant'),
(23, 'rayen souli', 'rayensouli@gmail.com', '$2y$10$a15H9Aw9b4WNyF.8tWGwfe.KXfU7WH726hs9FipVtUTpGwT93tswm', 'etudiant'),
(24, 'fedi hamdi', 'fedihamdi@gmail.com', '$2y$10$bKGv9NaUzO93.b/5SrHJRuRwldT7irtJVuSLtvX3CBfKvaAI7Vb/C', 'etudiant'),
(25, 'rifae ghilmemi', 'rifaeghilmemi@gmail.com', '$2y$10$FbP9vaq6dLDoCGA2NOXkV.xCmuYkUK5hjXHobBDhFpb50ppAIkpE2', 'etudiant'),
(26, 'souhail ben chaaben', 'souhailbenchaaben@gmail.com', '$2y$10$6WehGqYypapElLC.RCVNdu9Et9pBj7MIH56yumziBciGvCE.Bx7au', 'etudiant'),
(27, 'mouhib ben hassen', 'mouhibbenhaseen@gmail.com', '$2y$10$VxpivIPEuxYBVX8sqxjz4e5p1y90Leag8PRGSUrS11XZYAQEranf2', 'etudiant'),
(28, 'mariem wanes', 'mariemwanes@gmail.com', '$2y$10$4vTsnTidcZH72FiAc5lB8e9QhAXC7t.ETDMsV/xBBxons8b7Oftq2', 'etudiant'),
(29, 'mohamed', 'mohamed@gmail.com', '$2y$10$gfSZZogV5qMhjk41qE.Bnur3FNjGsHSxSN4OMqIWpvaTrZ.x4B/n6', 'etudiant'),
(30, 'tt', 'tt@gmail.com', '$2y$10$N9fcNSO9gwsDv8KYU0Aa3OE92/NS0N5mxxuYl7dHP..W6YuP9//d2', 'etudiant'),
(31, 'ha', 'ha@gmail.com', '$2y$10$B7xgdLM9vYcxdfPlnyofp.G3EAfRCqfyKl0sdazi5JGJyqkcrVnE.', 'etudiant'),
(32, 'hahahadd', 'ha@gmail.com', '$2y$10$CwYhBSUE.na0W8h/.RBAjOMjK3aBHWqCxLacCzk.l0EgebKxs62aa', 'etudiant');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adhesions`
--
ALTER TABLE `adhesions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_responsable` (`id_responsable`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_utilisateur`,`id_club`),
  ADD KEY `id_club` (`id_club`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adhesions`
--
ALTER TABLE `adhesions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
