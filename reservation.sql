-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 17 août 2024 à 17:40
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservation`
--

-- --------------------------------------------------------

--
-- Structure de la table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `appointment_for` enum('myself','someone_else') NOT NULL,
  `specialist_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `specialists`
--

CREATE TABLE `specialists` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `appointment_for` enum('myself','someone_else') NOT NULL,
  `name` varchar(100) NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `birthdate` int(11) NOT NULL,
  `birth_month` enum('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec') NOT NULL,
  `birth_year` int(11) NOT NULL,
  `birth_day` int(11) NOT NULL,
  `specialist` varchar(100) NOT NULL,
  `symptoms` text NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `appointment_for`, `name`, `gender`, `phone_number`, `birthdate`, `birth_month`, `birth_year`, `birth_day`, `specialist`, `symptoms`, `appointment_date`, `appointment_time`, `created_at`) VALUES
(1, 'myself', 'N\'doba Diarra', 'male', '71713102', 2016, 'Jan', 0, 0, 'doba', 'jjnjj', '2024-08-15', '13:55:00', '2024-08-17 10:24:48'),
(2, 'myself', 'N\'doba Diarra', 'male', '71713102', 2016, 'Jan', 0, 0, 'doba', 'rkvkkf', '2024-08-07', '14:31:00', '2024-08-17 10:25:10'),
(3, 'myself', 'N\'doba Diarra', 'male', '71713102', 2016, 'Jan', 0, 0, 'dobaaaa', 'rkvkkf', '2024-08-07', '14:31:00', '2024-08-17 10:26:00'),
(4, 'myself', 'N\'dob', 'male', '71713102', 2016, 'Jan', 0, 0, 'dobaaaa', 'rkvkkf', '2024-08-07', '14:31:00', '2024-08-17 10:26:11'),
(5, 'myself', 'N\'dob', 'female', '71713102', 2016, 'Jan', 0, 0, 'dobaaaa', 'FJFGKFKS', '2024-08-13', '12:00:00', '2024-08-17 11:22:07'),
(6, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'dermatologue', 'f,kfcv ', '2024-08-15', '11:30:00', '2024-08-17 11:31:09'),
(7, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'dermatologue', 'f,kfcv ', '2024-08-15', '11:30:00', '2024-08-17 11:34:20'),
(8, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'dermatologue', 'f,kfcv ', '2024-08-15', '11:30:00', '2024-08-17 11:34:29'),
(9, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', 'IIIDIFUHEDFUF', '2024-08-06', '12:00:00', '2024-08-17 11:35:47'),
(10, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'dermatologue', 'f,kfcv ', '2024-08-15', '11:30:00', '2024-08-17 11:39:05'),
(11, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', 'IIIDIFUHEDFUF', '2024-08-06', '12:00:00', '2024-08-17 11:39:43'),
(12, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'dermatologue', 'f,kfcv ', '2024-08-15', '11:30:00', '2024-08-17 11:45:28'),
(13, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'dermatologue', 'f,kfcv ', '2024-08-15', '11:30:00', '2024-08-17 11:59:44'),
(14, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'dermatologue', 'f,kfcv ', '2024-08-15', '11:30:00', '2024-08-17 12:13:01'),
(15, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'dermatologue', 'f,kfcv ', '2024-08-15', '11:30:00', '2024-08-17 12:19:38'),
(16, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', 'IIIDIFUHEDFUF', '2024-08-06', '12:00:00', '2024-08-17 12:27:37'),
(17, 'someone_else', 'N\'doba Diarra', 'male', '71713102', 2016, 'Jan', 0, 0, 'dermatologue', 'C\'est bien', '2024-08-15', '07:30:00', '2024-08-17 12:28:41'),
(18, 'someone_else', 'N\'doba Diarra', 'male', '71713102', 2016, 'Jan', 0, 0, 'dermatologue', 'C\'est bien', '2024-08-15', '07:30:00', '2024-08-17 12:57:25'),
(19, 'someone_else', 'N\'doba Diarra', 'male', '71713102', 2016, 'Jan', 0, 0, 'dermatologue', 'C\'est bien', '2024-08-15', '07:30:00', '2024-08-17 12:57:39'),
(20, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', ',,', '2024-08-30', '10:58:00', '2024-08-17 12:58:17'),
(21, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', ',,', '2024-08-30', '10:58:00', '2024-08-17 12:59:08'),
(22, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', ',,', '2024-08-30', '10:58:00', '2024-08-17 12:59:33'),
(23, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', ',,', '2024-08-30', '10:58:00', '2024-08-17 12:59:48'),
(24, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', ',,', '2024-08-30', '10:58:00', '2024-08-17 13:01:21'),
(25, 'myself', 'N\'doba Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', ',,', '2024-08-30', '10:58:00', '2024-08-17 13:03:02'),
(26, 'myself', 'N\'doba Diarra', 'male', '71713102', 2015, 'Jan', 0, 0, 'cardiologue', 'JJFJFJD', '2024-08-16', '10:06:00', '2024-08-17 13:06:42'),
(27, 'myself', 'N\'doba Diarra', 'male', '71713102', 2015, 'Jan', 0, 0, 'cardiologue', 'JJFJFJD', '2024-08-16', '10:06:00', '2024-08-17 13:07:47'),
(28, 'myself', 'N\'doba Diarra', 'male', '71713102', 2015, 'Jan', 0, 0, 'cardiologue', 'JJFJFJD', '2024-08-16', '10:06:00', '2024-08-17 13:08:24'),
(29, 'myself', 'Mamadou Daouda Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', 'kk', '2024-08-28', '09:17:00', '2024-08-17 15:25:07'),
(30, 'myself', 'Mamadou Daouda Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', 'kk', '2024-08-28', '09:17:00', '2024-08-17 15:26:41'),
(31, 'myself', 'Mamadou Daouda Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', 'kk', '2024-08-28', '09:17:00', '2024-08-17 15:26:46'),
(32, 'myself', 'Mamadou Daouda Diarra', 'male', '71713102', 2024, 'Jan', 0, 0, 'cardiologue', 'kk', '2024-08-28', '09:17:00', '2024-08-17 15:28:25');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `password`) VALUES
(1, 'Diarra', 'N\'doba', 'dniblon223@gmail.com', '$2y$10$X5.h3l5Hzv2ImmvC/nA/IuPcSzZfRgbaCC7f1q3UkwT/owIbc7tF2');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `specialist_id` (`specialist_id`);

--
-- Index pour la table `specialists`
--
ALTER TABLE `specialists`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `specialists`
--
ALTER TABLE `specialists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`specialist_id`) REFERENCES `specialists` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
