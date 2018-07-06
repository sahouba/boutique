-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2018 at 03:40 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boutique`
--

-- --------------------------------------------------------

--
-- Table structure for table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(3) NOT NULL,
  `id_membre` int(3) NOT NULL,
  `montant` int(3) NOT NULL,
  `date_enregistrement` date NOT NULL,
  `etat` enum('envoyé','livré') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `commande`
--

INSERT INTO `commande` (`id_commande`, `id_membre`, `montant`, `date_enregistrement`, `etat`) VALUES
(1, 9, 285, '2018-07-06', 'envoyé'),
(2, 9, 60, '2018-07-06', 'envoyé'),
(3, 9, 102, '2018-07-06', 'envoyé');

-- --------------------------------------------------------

--
-- Table structure for table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details_commande` int(3) NOT NULL,
  `id_commande` int(3) NOT NULL,
  `id_produit` int(3) NOT NULL,
  `quantite` int(3) NOT NULL,
  `prix` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `details_commande`
--

INSERT INTO `details_commande` (`id_details_commande`, `id_commande`, `id_produit`, `quantite`, `prix`) VALUES
(1, 1, 1, 1, 15),
(2, 1, 3, 2, 15),
(3, 1, 21, 4, 60),
(4, 2, 1, 4, 15),
(5, 3, 2, 6, 17);

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

CREATE TABLE `membre` (
  `id_membre` int(3) NOT NULL,
  `pseudo` varchar(20) COLLATE utf8_bin NOT NULL,
  `mdp` varchar(60) COLLATE utf8_bin NOT NULL,
  `nom` varchar(20) COLLATE utf8_bin NOT NULL,
  `prenom` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `civilite` enum('m','f') COLLATE utf8_bin NOT NULL,
  `ville` varchar(20) COLLATE utf8_bin NOT NULL,
  `code_postal` int(5) UNSIGNED ZEROFILL NOT NULL,
  `adresse` varchar(50) COLLATE utf8_bin NOT NULL,
  `statut` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id_membre`, `pseudo`, `mdp`, `nom`, `prenom`, `email`, `civilite`, `ville`, `code_postal`, `adresse`, `statut`) VALUES
(1, 'existe', '1234', 'existe', 'existe', 'existe@existe.com', 'm', 'paris', 07500, 'paris', 0),
(4, 'aaaa', '1234', 'aaaa', 'aaaa', 'aaaa@aaaa.com', 'm', 'aaaa', 01111, 'aaaa', 0),
(6, 'femme', '$2y$10$bpG4XovvnHI6i4H2p9VZNO/2U2FaIlK/NGJoEyiY1PLROMGJObzlS', 'femme', 'feme', 'femme@femme.com', '', 'paris', 75015, 'paris', 0),
(8, '', '', '', '', '', '', 'paris', 00000, '', 0),
(9, 'sahbi', '$2y$10$9HZF71cuU6szgdGxsJMBzuqHKPxIhTgqeTsWPY8slrga4E1WIwBsS', 'JLASSI', 'sahbi', 'jl.sahbi@gmail.com', '', 'Arcueil', 94110, '10 avenue  paul doumer', 1),
(10, 'membre', '$2y$10$1e6qfDaJ9ELc2Xle/q22SOklJqCj3N1aNLWaHkcC6hKXX4zC3s/r.', 'membre', 'membre', 'membre@membre.com', '', 'paris', 75015, '10 paris', 0),
(11, 'admin', '$2y$10$HfqAQyerjVP7JgEjVwZ1sudtVQ74AcmvRprXm7CwXYfpeVWLHXkqe', 'sahbi JLASSI', 'admin', 'jl.sahbi@gmail.com', 'm', 'Arcueil', 94110, '10 avenue  paul doumer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(3) NOT NULL,
  `reference` varchar(20) COLLATE utf8_bin NOT NULL,
  `categorie` varchar(20) COLLATE utf8_bin NOT NULL,
  `titre` varchar(100) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL,
  `couleur` varchar(20) COLLATE utf8_bin NOT NULL,
  `taille` varchar(5) COLLATE utf8_bin NOT NULL,
  `sexe` enum('m','f','mixte') COLLATE utf8_bin NOT NULL,
  `photo` varchar(250) COLLATE utf8_bin NOT NULL,
  `prix` int(3) NOT NULL,
  `stock` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `reference`, `categorie`, `titre`, `description`, `couleur`, `taille`, `sexe`, `photo`, `prix`, `stock`) VALUES
(1, 't-shirt-123', 't-shirt', 't-shirt nike', 'nike 2019', 'noire', 'M', 'm', 'http://localhost/PHP/boutique/photo/t-shirt_nikenoir.jpg', 15, 0),
(2, 't-shirt-011', 't-shirt', 't-shirt nike', 'nike 2018', 'blanche', 'L', 'mixte', 'http://localhost/PHP/boutique/photo/t-shirt_nikeblan.jpg', 17, 19),
(3, 'short-0123', 'short', 'short adiddas', 'short 2019', 'bleu', 'XL', 'mixte', 'http://localhost/PHP/boutique/photo/short-0123_shortadiddas.jpg', 15, 98),
(19, 't-shirt-036', 't-shirt', 't-shirt-1234', 'tshirt 2019', 'gris', 'XL', 'f', 'http://localhost/PHP/boutique/photo/t-shirt_s.jpg', 15, 100),
(21, 'vest-l-258', 'veste', 'veste noir', 'veste 2017', 'noir', 'M', 'm', 'http://localhost/PHP/boutique/photo/vest-l-258_veste.jpg', 60, 996),
(24, 'casquette', 'casquette', 'casquette adiddas', 'casquette adiddas 2018', 'rouge', 'S', 'mixte', 'http://localhost/PHP/boutique/photo/casquette_casquette.jpg', 15, 30),
(25, '1', 'Tshirt', 'tshi sabhi', 'Yooooooooo', 'noire', 'L', 'm', 'http://localhost/PHP/boutique/photo/1_t-shirt_nikeblan.jpg', 25, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_membre` (`id_membre`);

--
-- Indexes for table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details_commande`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Indexes for table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id_membre`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commande`
--
ALTER TABLE `commande`
  MODIFY `id_commande` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `details_commande`
--
ALTER TABLE `details_commande`
  MODIFY `id_details_commande` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `membre`
--
ALTER TABLE `membre`
  MODIFY `id_membre` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_membre`) REFERENCES `membre` (`id_membre`);

--
-- Constraints for table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id_commande`),
  ADD CONSTRAINT `details_commande_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
