-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : database
-- Généré le : jeu. 20 mai 2021 à 22:43
-- Version du serveur :  5.7.34
-- Version de PHP : 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mvcdockerPA`
--

-- --------------------------------------------------------

--
-- Structure de la table `dft__Aliment`
--

CREATE TABLE `dft__Aliment` (
                                `id` int(11) NOT NULL,
                                `nom` varchar(45) NOT NULL,
                                `prix` varchar(45) NOT NULL,
                                `activeCommande` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Article`
--

CREATE TABLE `dft__Article` (
                                `id` int(11) NOT NULL,
                                `nom` varchar(45) NOT NULL,
                                `texte` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Commande`
--

CREATE TABLE `dft__Commande` (
                                 `id` int(11) NOT NULL,
                                 `idUsers` int(11) NOT NULL,
                                 `date` datetime NOT NULL,
                                 `nom` varchar(45) NOT NULL,
                                 `prix` varchar(45) NOT NULL,
                                 `reduction` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Commande_Aliment`
--

CREATE TABLE `dft__Commande_Aliment` (
                                         `id` int(11) NOT NULL,
                                         `idCommande` int(11) NOT NULL,
                                         `idAliment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Commande_Menu`
--

CREATE TABLE `dft__Commande_Menu` (
                                      `id` int(11) NOT NULL,
                                      `idMenu` int(11) NOT NULL,
                                      `idCommande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Commande_Plat`
--

CREATE TABLE `dft__Commande_Plat` (
                                      `id` int(11) NOT NULL,
                                      `idPlat` int(11) NOT NULL,
                                      `idCommande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Event`
--

CREATE TABLE `dft__Event` (
                              `id` int(11) NOT NULL,
                              `nom` varchar(45) NOT NULL,
                              `dateDebut` datetime NOT NULL,
                              `dateFin` datetime NOT NULL,
                              `prix` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Event_User`
--

CREATE TABLE `dft__Event_User` (
                                   `id` int(11) NOT NULL,
                                   `idUsers` int(11) NOT NULL,
                                   `idEvent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Fidelite`
--

CREATE TABLE `dft__Fidelite` (
                                 `id` int(11) NOT NULL,
                                 `idUsers` int(11) NOT NULL,
                                 `dateDebut` datetime NOT NULL,
                                 `nombrePoint` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Livraison`
--

CREATE TABLE `dft__Livraison` (
                                  `id` int(11) NOT NULL,
                                  `numero` varchar(45) NOT NULL,
                                  `adresse` varchar(150) NOT NULL,
                                  `date` datetime NOT NULL,
                                  `statut` int(1) DEFAULT NULL,
                                  `idCommande` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Media`
--

CREATE TABLE `dft__Media` (
                              `id` int(11) NOT NULL,
                              `nom` varchar(45) NOT NULL,
                              `url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Menu`
--

CREATE TABLE `dft__Menu` (
                             `id` int(11) NOT NULL,
                             `nom` varchar(45) NOT NULL,
                             `prix` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Menu_Plat`
--

CREATE TABLE `dft__Menu_Plat` (
                                  `id` int(11) NOT NULL,
                                  `idPlat` int(11) NOT NULL,
                                  `idMenu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Page`
--

CREATE TABLE `dft__Page` (
                             `id` int(11) DEFAULT NULL,
                             `nom` varchar(45) NOT NULL,
                             `idArticle` int(11) DEFAULT NULL,
                             `idWidget` int(11) DEFAULT NULL,
                             `idMedia` int(11) DEFAULT NULL,
                             `idReview` int(11) DEFAULT NULL,
                             `idRestaurant` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Paiement`
--

CREATE TABLE `dft__Paiement` (
                                 `id` int(11) NOT NULL,
                                 `idCommande` int(11) NOT NULL,
                                 `date` datetime NOT NULL,
                                 `justificatif` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Plat`
--

CREATE TABLE `dft__Plat` (
                             `id` int(11) NOT NULL,
                             `nom` varchar(45) NOT NULL,
                             `prix` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Plat_Aliment`
--

CREATE TABLE `dft__Plat_Aliment` (
                                     `id` int(11) NOT NULL,
                                     `idPlat` int(11) NOT NULL,
                                     `idAliment` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Reservation`
--

CREATE TABLE `dft__Reservation` (
                                    `id` int(11) NOT NULL,
                                    `idUsers` int(11) NOT NULL,
                                    `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Review`
--

CREATE TABLE `dft__Review` (
                               `id` int(11) NOT NULL,
                               `nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `dft__Users`
--

CREATE TABLE `dft__Users` (
                              `id` int(11) NOT NULL,
                              `firstname` varchar(255) NOT NULL,
                              `lastname` varchar(255) NOT NULL,
                              `email` varchar(255) NOT NULL,
                              `pwd` varchar(255) NOT NULL,
                              `country` varchar(10) NOT NULL,
                              `token` varchar(255) DEFAULT NULL,
                              `role` int(4) NOT NULL,
                              `status` int(3) NOT NULL,
                              `isDeleted` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `dft__Users`
--

INSERT INTO `dft__Users` (`id`, `firstname`, `lastname`, `email`, `pwd`, `country`, `token`, `role`, `status`, `isDeleted`) VALUES
(1, 'test', 'test', 'testa@mytest.fr', '$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq', 'fr', '60a6db2a19394-d41d8cd98f00b204e9800998ecf8427e', 0, 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `dft__Widget`
--

CREATE TABLE `dft__Widget` (
                               `id` int(11) NOT NULL,
                               `nom` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Restaurant`
--

CREATE TABLE `Restaurant` (
                              `id` int(11) NOT NULL,
                              `nom` varchar(50) NOT NULL,
                              `adresse` varchar(100) NOT NULL,
                              `codePostal` char(5) NOT NULL,
                              `ville` varchar(45) NOT NULL,
                              `telephone` char(10) NOT NULL,
                              `siret` char(14) NOT NULL,
                              `nomDomaine` varchar(50) DEFAULT NULL,
                              `prefixe` varchar(45) NOT NULL,
                              `activeLivraison` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Restaurant`
--

INSERT INTO `Restaurant` (`id`, `nom`, `adresse`, `codePostal`, `ville`, `telephone`, `siret`, `nomDomaine`, `prefixe`, `activeLivraison`) VALUES
(1, 'default', 'default_adresse', '75000', 'Paris', '0600000000', '12345678912345', 'default', 'dft', 0);

-- --------------------------------------------------------

--
-- Structure de la table `Type_user`
--

CREATE TABLE `Type_user` (
                             `id` int(11) NOT NULL,
                             `nom` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `User_cms`
--

CREATE TABLE `User_cms` (
                            `id` int(11) NOT NULL,
                            `email` varchar(100) NOT NULL,
                            `motDePasse` varchar(45) NOT NULL,
                            `pseudo` varchar(50) NOT NULL,
                            `nom` varchar(50) DEFAULT NULL,
                            `prenom` varchar(50) DEFAULT NULL,
                            `telephone` char(10) DEFAULT NULL,
                            `idTypeUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `dft__Aliment`
--
ALTER TABLE `dft__Aliment`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dft__Article`
--
ALTER TABLE `dft__Article`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dft__Commande`
--
ALTER TABLE `dft__Commande`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idUsers` (`idUsers`);

--
-- Index pour la table `dft__Commande_Aliment`
--
ALTER TABLE `dft__Commande_Aliment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idCommande` (`idCommande`),
  ADD KEY `idAliment` (`idAliment`);

--
-- Index pour la table `dft__Commande_Menu`
--
ALTER TABLE `dft__Commande_Menu`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idCommande` (`idCommande`),
  ADD KEY `idMenu` (`idMenu`);

--
-- Index pour la table `dft__Commande_Plat`
--
ALTER TABLE `dft__Commande_Plat`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idCommande` (`idCommande`),
  ADD KEY `idPlat` (`idPlat`);

--
-- Index pour la table `dft__Event`
--
ALTER TABLE `dft__Event`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dft__Event_User`
--
ALTER TABLE `dft__Event_User`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idUsers` (`idUsers`),
  ADD KEY `idEvent` (`idEvent`);

--
-- Index pour la table `dft__Fidelite`
--
ALTER TABLE `dft__Fidelite`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idUsers` (`idUsers`);

--
-- Index pour la table `dft__Livraison`
--
ALTER TABLE `dft__Livraison`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idCommande` (`idCommande`);

--
-- Index pour la table `dft__Media`
--
ALTER TABLE `dft__Media`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dft__Menu`
--
ALTER TABLE `dft__Menu`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dft__Menu_Plat`
--
ALTER TABLE `dft__Menu_Plat`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idMenu` (`idMenu`),
  ADD KEY `idPlat` (`idPlat`);

--
-- Index pour la table `dft__Page`
--
ALTER TABLE `dft__Page`
    ADD KEY `idArticle` (`idArticle`),
  ADD KEY `idWidget` (`idWidget`),
  ADD KEY `idMedia` (`idMedia`),
  ADD KEY `idReview` (`idReview`),
  ADD KEY `idRestaurant` (`idRestaurant`);

--
-- Index pour la table `dft__Paiement`
--
ALTER TABLE `dft__Paiement`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idCommande` (`idCommande`);

--
-- Index pour la table `dft__Plat`
--
ALTER TABLE `dft__Plat`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dft__Plat_Aliment`
--
ALTER TABLE `dft__Plat_Aliment`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idAliment` (`idAliment`),
  ADD KEY `idPlat` (`idPlat`);

--
-- Index pour la table `dft__Reservation`
--
ALTER TABLE `dft__Reservation`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idUsers` (`idUsers`);

--
-- Index pour la table `dft__Review`
--
ALTER TABLE `dft__Review`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `dft__Users`
--
ALTER TABLE `dft__Users`
    ADD UNIQUE KEY `id` (`id`);

--
-- Index pour la table `dft__Widget`
--
ALTER TABLE `dft__Widget`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Restaurant`
--
ALTER TABLE `Restaurant`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Type_user`
--
ALTER TABLE `Type_user`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `User_cms`
--
ALTER TABLE `User_cms`
    ADD PRIMARY KEY (`id`),
  ADD KEY `idTypeUser` (`idTypeUser`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `dft__Aliment`
--
ALTER TABLE `dft__Aliment`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Article`
--
ALTER TABLE `dft__Article`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Commande`
--
ALTER TABLE `dft__Commande`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Commande_Aliment`
--
ALTER TABLE `dft__Commande_Aliment`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Commande_Menu`
--
ALTER TABLE `dft__Commande_Menu`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Commande_Plat`
--
ALTER TABLE `dft__Commande_Plat`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Event`
--
ALTER TABLE `dft__Event`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Event_User`
--
ALTER TABLE `dft__Event_User`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Fidelite`
--
ALTER TABLE `dft__Fidelite`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Livraison`
--
ALTER TABLE `dft__Livraison`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Media`
--
ALTER TABLE `dft__Media`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Menu`
--
ALTER TABLE `dft__Menu`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Menu_Plat`
--
ALTER TABLE `dft__Menu_Plat`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Paiement`
--
ALTER TABLE `dft__Paiement`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Plat`
--
ALTER TABLE `dft__Plat`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Plat_Aliment`
--
ALTER TABLE `dft__Plat_Aliment`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Reservation`
--
ALTER TABLE `dft__Reservation`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Review`
--
ALTER TABLE `dft__Review`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dft__Users`
--
ALTER TABLE `dft__Users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `dft__Widget`
--
ALTER TABLE `dft__Widget`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Restaurant`
--
ALTER TABLE `Restaurant`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Type_user`
--
ALTER TABLE `Type_user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `User_cms`
--
ALTER TABLE `User_cms`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `dft__Commande`
--
ALTER TABLE `dft__Commande`
    ADD CONSTRAINT `dft__Commande_ibfk_1` FOREIGN KEY (`idUsers`) REFERENCES `dft__Users` (`id`);

--
-- Contraintes pour la table `dft__Commande_Aliment`
--
ALTER TABLE `dft__Commande_Aliment`
    ADD CONSTRAINT `dft__Commande_Aliment_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `dft__Commande` (`id`),
  ADD CONSTRAINT `dft__Commande_Aliment_ibfk_2` FOREIGN KEY (`idAliment`) REFERENCES `dft__Aliment` (`id`);

--
-- Contraintes pour la table `dft__Commande_Menu`
--
ALTER TABLE `dft__Commande_Menu`
    ADD CONSTRAINT `dft__Commande_Menu_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `dft__Commande` (`id`),
  ADD CONSTRAINT `dft__Commande_Menu_ibfk_2` FOREIGN KEY (`idMenu`) REFERENCES `dft__Menu` (`id`);

--
-- Contraintes pour la table `dft__Commande_Plat`
--
ALTER TABLE `dft__Commande_Plat`
    ADD CONSTRAINT `dft__Commande_Plat_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `dft__Commande` (`id`),
  ADD CONSTRAINT `dft__Commande_Plat_ibfk_2` FOREIGN KEY (`idPlat`) REFERENCES `dft__Plat` (`id`);

--
-- Contraintes pour la table `dft__Event_User`
--
ALTER TABLE `dft__Event_User`
    ADD CONSTRAINT `dft__Event_User_ibfk_1` FOREIGN KEY (`idUsers`) REFERENCES `dft__Users` (`id`),
  ADD CONSTRAINT `dft__Event_User_ibfk_2` FOREIGN KEY (`idEvent`) REFERENCES `dft__Event` (`id`);

--
-- Contraintes pour la table `dft__Fidelite`
--
ALTER TABLE `dft__Fidelite`
    ADD CONSTRAINT `dft__Fidelite_ibfk_1` FOREIGN KEY (`idUsers`) REFERENCES `dft__Users` (`id`);

--
-- Contraintes pour la table `dft__Livraison`
--
ALTER TABLE `dft__Livraison`
    ADD CONSTRAINT `dft__Livraison_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `dft__Commande` (`id`);

--
-- Contraintes pour la table `dft__Menu_Plat`
--
ALTER TABLE `dft__Menu_Plat`
    ADD CONSTRAINT `dft__Menu_Plat_ibfk_1` FOREIGN KEY (`idMenu`) REFERENCES `dft__Menu` (`id`),
  ADD CONSTRAINT `dft__Menu_Plat_ibfk_2` FOREIGN KEY (`idPlat`) REFERENCES `dft__Plat` (`id`);

--
-- Contraintes pour la table `dft__Page`
--
ALTER TABLE `dft__Page`
    ADD CONSTRAINT `dft__Page_ibfk_1` FOREIGN KEY (`idArticle`) REFERENCES `dft__Article` (`id`),
  ADD CONSTRAINT `dft__Page_ibfk_2` FOREIGN KEY (`idWidget`) REFERENCES `dft__Widget` (`id`),
  ADD CONSTRAINT `dft__Page_ibfk_3` FOREIGN KEY (`idMedia`) REFERENCES `dft__Media` (`id`),
  ADD CONSTRAINT `dft__Page_ibfk_4` FOREIGN KEY (`idReview`) REFERENCES `dft__Review` (`id`),
  ADD CONSTRAINT `dft__Page_ibfk_5` FOREIGN KEY (`idRestaurant`) REFERENCES `Restaurant` (`id`);

--
-- Contraintes pour la table `dft__Paiement`
--
ALTER TABLE `dft__Paiement`
    ADD CONSTRAINT `dft__Paiement_ibfk_1` FOREIGN KEY (`idCommande`) REFERENCES `dft__Commande` (`id`);

--
-- Contraintes pour la table `dft__Plat_Aliment`
--
ALTER TABLE `dft__Plat_Aliment`
    ADD CONSTRAINT `dft__Plat_Aliment_ibfk_1` FOREIGN KEY (`idAliment`) REFERENCES `dft__Aliment` (`id`),
  ADD CONSTRAINT `dft__Plat_Aliment_ibfk_2` FOREIGN KEY (`idPlat`) REFERENCES `dft__Plat` (`id`);

--
-- Contraintes pour la table `dft__Reservation`
--
ALTER TABLE `dft__Reservation`
    ADD CONSTRAINT `dft__Reservation_ibfk_1` FOREIGN KEY (`idUsers`) REFERENCES `dft__Users` (`id`);

--
-- Contraintes pour la table `User_cms`
--
ALTER TABLE `User_cms`
    ADD CONSTRAINT `User_cms_ibfk_1` FOREIGN KEY (`idTypeUser`) REFERENCES `Type_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;