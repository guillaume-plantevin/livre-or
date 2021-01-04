-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 04, 2021 at 03:03 PM
-- Server version: 5.7.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `livreor`
--
CREATE DATABASE IF NOT EXISTS `livreor` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `livreor`;

-- --------------------------------------------------------

--
-- Table structure for table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `commentaire` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `commentaires`
--

INSERT INTO `commentaires` (`id`, `commentaire`, `id_utilisateur`, `date`) VALUES
(1, 'Un très beau mariage, même si moins bien que le mien!', 18, '2020-12-31 19:15:42'),
(3, 'Un mariage magnifique!', 24, '2020-12-31 18:18:14'),
(4, 'Ne spammons pas le chat, m&ecirc;me si c\'est &lt;b&gt;agr&eacute;abe&lt;/b&gt;!', 24, '2020-12-31 18:19:51'),
(5, 'J\'ai peut-&ecirc;tre un peu abus&eacute; sur le champagne... Toutes mes excuses &agrave; la famille.', 23, '2021-01-04 14:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `login`, `password`) VALUES
(18, 'sardou', '$2y$10$sOYtzOarCtax28Xl.Imwe./bBqQSDgET65yPycpJM04MlnUUWDoui'),
(19, 'janedoe', '$2y$10$bTnWZpUTZu8ROTmYDJ1IwerqTpF6KIivTT..GHY3t.NTS5Ew1zeou'),
(20, 'johndoe', '$2y$10$0wQjCs5UMT/cOih915I3M.Ng9TbLKdoCJYkTn8gRAOuAx.18pnwZ.'),
(21, 'johncage', '$2y$10$sbS1Vm1qnGOuT4qMIkPbN.bg2mLXe2MavrVfmQxtuONfP6KKaMbru'),
(22, 'johnrambo', '$2y$10$2yMQO/3RUKhAlL8sBLNF1exsvwc4yqJ6lRLiaMqVDr.05T/WIHc3a'),
(23, 'stockhausen', '$2y$10$8JZShcR.V9LYZrze8rLp/upGRQdW88Aobge8CL123JonKNDFRZM/K'),
(24, 'boulez', '$2y$10$dJJGH7uIvOVVT/iQvmeT.uZLkXMiPkD8UmzFVKZv4mzZnfKD1DwlS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;