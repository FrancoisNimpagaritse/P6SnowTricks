-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  sam. 30 jan. 2021 à 21:07
-- Version du serveur :  10.1.34-MariaDB
-- Version de PHP :  7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(9, 'Les grabs'),
(10, 'Les rotations'),
(11, 'Les flips'),
(12, 'Les slides');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201025220246', '2020-10-25 23:03:11', 4393),
('DoctrineMigrations\\Version20201026102739', '2020-10-26 11:27:58', 1540),
('DoctrineMigrations\\Version20201029234027', '2020-10-30 00:41:36', 1778),
('DoctrineMigrations\\Version20201031130240', '2020-10-31 14:02:58', 1541),
('DoctrineMigrations\\Version20201104172856', '2020-11-04 18:34:26', 1708),
('DoctrineMigrations\\Version20201104195035', '2020-11-04 20:51:23', 4218),
('DoctrineMigrations\\Version20201112093753', '2020-11-12 10:38:27', 1329),
('DoctrineMigrations\\Version20201112192002', '2020-11-12 20:20:19', 2263),
('DoctrineMigrations\\Version20201113195640', '2020-11-13 20:56:53', 1162),
('DoctrineMigrations\\Version20201113201013', '2020-11-13 21:49:13', 856),
('DoctrineMigrations\\Version20201113205036', '2020-11-13 21:50:41', 784),
('DoctrineMigrations\\Version20201113223347', '2020-11-13 23:34:03', 4055);

-- --------------------------------------------------------

--
-- Structure de la table `figure`
--

CREATE TABLE `figure` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `figure`
--

INSERT INTO `figure` (`id`, `category_id`, `name`, `description`, `updated_at`, `main_image`, `author_id`, `slug`) VALUES
(1, 9, 'Mafalda Kuphal V', 'Qui voluptatem est debitis voluptatem.', '2020-11-05 08:51:31', 'mainImage.png', 23, 'mafalda-kuphal-v'),
(2, 10, 'Ima Leffler', 'Quia quia voluptas natus voluptas ea voluptas.', '2020-11-05 08:51:31', 'mainImage.png', 24, 'ima-leffler'),
(3, 9, 'Jake Pfeffer', 'Voluptas facere quasi aut inventore ratione.', '2020-11-05 08:51:31', 'mainImage.png', 23, 'jake-pfeffer'),
(4, 10, 'Ellsworth Breitenberg', 'Pariatur error esse nihil illo.', '2020-11-05 08:51:31', 'mainImage.png', 25, 'ellsworth-breitenberg'),
(5, 10, 'Mrs Adeline Deckow', 'Quos animi repellat quidem dolore.', '2020-11-05 08:51:31', 'mainImage.png', 24, 'mrs-adeline-meckow'),
(6, 9, 'Sad', 'One of the best trick show in 2015 Winter', '2020-12-30 14:57:28', 'trick4-5fec87488db89.jpeg', 21, 'magic-interesting-tricky'),
(8, 10, 'Mute', 'ma desc', '2020-12-30 14:57:59', 'Snowboarder-web-5fec87679f002.jpeg', 21, 'figure-avec-des-images'),
(9, 10, 'ma figure n5 (modifiée)', 'une description', '2020-11-23 10:31:44', 'trick2_main-5fbb8180527ca.jpeg', 21, 'ma-figure-n5'),
(10, 9, 'Indy', 'Figure de Mickey qui fait la une du ski sort depuis ce jour là', '2020-12-30 14:56:48', 'trick1_main-5fb93ebcef075.jpeg', 21, 'mickey-boss-trick'),
(11, 9, 'tail grab amélioré', 'Une figure avec grab arrière', '2021-01-28 22:57:40', 'trick3-5fec87ac04700.jpeg', 21, 'image-test-prepersist'),
(12, 9, 'test service', 'je teste l\'externerisation du service d\'upload d\'image', '2020-11-23 11:34:13', 'Hydrangeas-5f9fe9d4a958a-5fbb9025d824f.jpeg', 21, 'test-service'),
(13, 9, 'un', 'deux', '2020-11-25 01:03:16', 'trick3_main-5fbd9f445aba5.jpeg', 21, 'un'),
(14, 9, 'Magi interesting tricky', 'test', '2020-11-28 00:30:40', 'Lighthouse-5fc18c20d76e0.jpeg', 21, 'magi-interesting-tricky'),
(15, 9, 'Magic interesting trickylll', 'blabla', '2020-12-30 14:08:02', 'trick3-5fec7bb292725.jpeg', 21, 'magic-interesting-trickylll'),
(16, 9, 'Une figure de test', 'Je certifie que cette figure est lagnifique', '2020-12-14 12:27:26', 'unamed_trick-5fd74c1e2d13f.jpeg', 21, 'une-figure-de-test'),
(17, 10, 'Magic interesting trickyhhh', 'gvsbs bhbqbkfjg pogkpos', '2020-12-30 14:58:29', 'cover_KellyClark-5fec8785aa299.jpeg', 21, 'magic-interesting-trickyhhh'),
(18, 9, 'Figure avec images et videos (aussi modifié)', 'Une figure complète (modifiée)', '2020-12-30 14:07:09', 'snowboarding_trick6-5fec7b7d1c449.jpeg', 21, 'figure-avec-images-et-videos'),
(19, 10, 'Balthez et sa figure', 'Cette figure je l\'ai décrit il y a 7 mois et est restée la meilleure', '2020-12-13 14:48:24', 'unamed_trick-5fd61ba8b0727.jpeg', 29, 'balthez-et-sa-figure');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `figure_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `figure_id`, `user_id`, `content`, `created_at`) VALUES
(1, 2, 25, 'Et explicabo perspiciatis nulla et.', '2020-11-05 08:51:31'),
(2, 3, 26, 'Accusamus explicabo cum facilis repellendus exercitationem quam impedit.', '2020-11-05 08:51:31'),
(3, 1, 26, 'Et dolores veniam quia totam.', '2020-11-05 08:51:31'),
(4, 1, 25, 'Recusandae cumque exercitationem impedit.', '2020-11-05 08:51:31'),
(5, 3, 25, 'Sunt magnam omnis omnis illum sed.', '2020-11-05 08:51:31'),
(6, 2, 25, 'Perspiciatis consequuntur eius officiis distinctio nam.', '2020-11-05 08:51:31'),
(9, 5, 24, 'Iusto voluptatem ut at fuga exercitationem quibusdam.', '2020-11-05 08:51:31'),
(10, 2, 26, 'Repudiandae consectetur accusantium delectus quo eveniet sit dicta.', '2020-11-05 08:51:31'),
(11, 2, 25, 'Sit neque fugiat temporibus voluptas itaque ut tempora.', '2020-11-05 08:51:31'),
(12, 3, 24, 'Excepturi consequuntur illum quidem consectetur porro.', '2020-11-05 08:51:31'),
(13, 5, 24, 'Beatae error rerum velit sint.', '2020-11-05 08:51:31'),
(14, 5, 23, 'Iste sed inventore commodi nam.', '2020-11-05 08:51:31'),
(15, 1, 23, 'Animi cupiditate autem et ex.', '2020-11-05 08:51:31'),
(16, 1, 21, 'Je laisse un commentaire de test', '2020-11-16 12:45:04'),
(17, 9, 21, 'Mon commentaire', '2020-11-16 13:20:34'),
(18, 18, 21, 'Ni danger!', '2020-11-30 22:10:59'),
(19, 18, 29, 'Moi  Balthez j\'apprécie votre figure et j\'aimérais l\'apprendre', '2020-12-13 14:50:04'),
(20, 18, 21, 'Cette figure représente grand chose pour moi et mes amis', '2020-12-28 15:42:37'),
(21, 18, 21, 'Très acrobatique ces figures', '2020-12-28 15:43:11'),
(22, 11, 21, 'Un commentaire pour encourager le créateur', '2021-01-28 22:58:32');

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE `picture` (
  `id` int(11) NOT NULL,
  `figure_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `picture`
--

INSERT INTO `picture` (`id`, `figure_id`, `name`, `caption`) VALUES
(1, 1, 'Garnett Hansen', 'Laudantium error illum et odit ex maxime.'),
(2, 4, 'Lauretta Abbott', 'Optio molestiae consequatur qui illum.'),
(3, 3, 'Tito Rohan III', 'Aut non a ducimus nisi eveniet quaerat.'),
(4, 8, 'mon_image.png', 'mon image 1'),
(5, 8, 'mon_image.png', 'mon image 2'),
(6, 9, 'mon_image.png', 'mon image 4'),
(7, 9, 'mon_image.png', 'mon image 5'),
(8, 10, 'mon_image.png', 'mon image 1'),
(9, 10, 'mon_image.JPEG', 'mon image 2'),
(10, 11, 'mon_image.png', 'mon image 1'),
(11, 11, 'mon_image.png', 'mon image 5'),
(12, 12, 'mon_image.png', 'mon image 12'),
(13, 12, 'mon_image.png', 'mon image 13'),
(14, 13, 'mon_image.png', 'mon image 1'),
(15, 14, 'mon_image.png', 'mon image 1'),
(16, 15, 'Lighthouse-5fc4251521ee1.jpeg', 'mon image 1'),
(17, 16, 'Penguins-5fc4263f55b3a.jpeg', 'mon image 1'),
(21, 18, 'Tulips-5fc56efe39c17.jpeg', 'mon image 1'),
(22, 18, 'snowboarding_trick6-60144ec7bc84f.jpeg', 'mon image 2'),
(23, 17, 'Chrysanthemum-5fc61215357d3.jpeg', 'Une légende à la con'),
(24, 17, 'Desert-5fc6121582a45.jpeg', 'Une deuxième caption'),
(25, 19, 'snowboard_trick2-5fd61ba8ac0d6.jpeg', 'mon image 15'),
(26, 19, 'Snowboarder-web-5fd61ba8af787.jpeg', 'mon image 16'),
(27, 18, 'craziest-tricks-60144e5428aa3.jpeg', 'cette fois mignone');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `title`) VALUES
(1, 'ROLE_ADMIN');

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

CREATE TABLE `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 21);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `firstname`, `lastname`, `email`, `image_name`, `updated_at`, `hash`, `activation_token`, `reset_token`) VALUES
(21, 'Francis', 'Biko', 'franimpa@yahoo.fr', 'foto_passeport-5fd741b54eaa9.jpeg', '2020-11-05 08:51:26', '$2y$13$H/n8KC7EWgumrvN2h7Oj5.DThvlYnjPDq4PjiH4aY764BK9pv7owy', NULL, NULL),
(22, 'Sydnee', 'Mohr', 'wisozk.jacques@yahoo.com', 'shmidt-kfd57d4s-ko.jpg', '2020-11-05 08:51:27', '$2y$13$JQ1fovfqfQVAf1eBUGaKMuUImHSimZbcP6ljoU8p539Sqlqq8SCIS', NULL, NULL),
(23, 'Leila', 'Lynch', 'kemmer.rupert@yahoo.com', 'user-male-hhgddgt5844.png', '2020-11-05 08:51:28', '$2y$13$DupWhVgGLSVeBdhOiroOUuoSz4wjDF5tkgKSOKBMkLOuSOxULStNW', NULL, NULL),
(24, 'Jettie', 'Lueilwitz', 'veffertz@luettgen.com', '470-4703547_icon-user-icon-hd.png', '2020-11-05 08:51:29', '$2y$13$k2fnr8PmIbFGaHT57uiaiuujZVzwC2WsiTWWdw0NkUh0zb7AZKu16', NULL, NULL),
(25, 'Lavina', 'Schmidt', 'sydnie.marks@yahoo.com', '171-1717870-user-icon.png', '2020-11-05 08:51:30', '$2y$13$argfyC7IhQiF9hb63BSlEuuFl2ForYqEJR8/H3NItMYGJNnF9oUFC', NULL, NULL),
(26, 'Anita', 'Nitzsche', 'bauch.kory@yahoo.com', '649-6490120_user-picture-in-circle.png', '2020-11-05 08:51:31', '$2y$13$Yee7p8U2D90CPx8V3CLuvOuxkAGFKtDs3Wqv5I.u8wQHNoCh9BAYW', NULL, NULL),
(28, 'Pet', 'Tobogan', 'pettobogan@gmail.com', 'alain_kobir.jpg', '2020-11-12 22:57:13', '$2y$13$2NQjn/QEJEiiOenyZMGtuuY94.B95nt7jT4.diBmdVziBt4Wte05e', NULL, NULL),
(29, 'Balthez', 'Krakoskerski', 'kbalthez@gmail.com', 'foto_passeport-5fd741b54eaa9.jpeg', '2020-12-13 14:34:14', '$2y$13$k2fnr8PmIbFGaHT57uiaiuujZVzwC2WsiTWWdw0NkUh0zb7AZKu16', 'c56864012b2057d71ad7e133b4996f61', NULL),
(30, 'abdc', 'zeney', 'zeny@gmail.com', 'François 2-60140e1c5dc04.jpeg', '2021-01-29 14:31:09', '$2y$13$jL46kZILHIjjg/CzpPKmyeremNCA8PB4Si5E8/h8lT25H87uyE82q', '5877e4dc9fb7394c99f34f1e012710c4', NULL),
(31, 'tutuu', 'zeney', 'zeny2@gmail.com', 'François 2-60140f5f1de60.jpeg', '2021-01-29 14:36:32', '$2y$13$98gt3rwIxhXz3GOBgG8/0.kpsiPCmIy9FP0e/OKdizuCcW15RaNzy', '2b74c6d8b427d3a6d5310bd59a316cf2', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `figure_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `figure_id`, `url`) VALUES
(1, 5, 'http://www.langworth.com/pariatur-consequatur-ex-reprehenderit-quos-autem-vitae.html'),
(2, 1, 'http://lemke.com/officiis-cupiditate-expedita-voluptas-saepe-eius-quis'),
(3, 4, 'http://bode.com/'),
(4, 18, 'https://www.youtube.com/watch?v=11f1U_H8h90'),
(5, 18, 'https://www.youtube.com/watch?v=5Y3DXeHPUpQ&list=RDCMUCzlH-Ah1a9NNYH6f9xUau9w&index=3'),
(6, 15, 'https://www.youtube.com/watch?v=QNa3ytaIOLw'),
(7, 19, 'https://www.youtube.com/watch?v=PePNEXh_1N4');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `figure`
--
ALTER TABLE `figure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2F57B37A12469DE2` (`category_id`),
  ADD KEY `IDX_2F57B37AF675F31B` (`author_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307F5C011B5` (`figure_id`),
  ADD KEY `IDX_B6BD307FA76ED395` (`user_id`);

--
-- Index pour la table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_16DB4F895C011B5` (`figure_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `IDX_332CA4DDD60322AC` (`role_id`),
  ADD KEY `IDX_332CA4DDA76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CC7DA2C5C011B5` (`figure_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `figure`
--
ALTER TABLE `figure`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `picture`
--
ALTER TABLE `picture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `figure`
--
ALTER TABLE `figure`
  ADD CONSTRAINT `FK_2F57B37A12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_2F57B37AF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307F5C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`),
  ADD CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `FK_16DB4F895C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`);

--
-- Contraintes pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `FK_332CA4DDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_332CA4DDD60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2C5C011B5` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
