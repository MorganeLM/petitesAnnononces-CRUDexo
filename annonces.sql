-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 25 août 2020 à 17:20
-- Version du serveur :  10.4.13-MariaDB
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `annonces`
--

-- --------------------------------------------------------

--
-- Structure de la table `announces`
--

CREATE TABLE `announces` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `price` float NOT NULL,
  `featured_image` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `users_id` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `departments_number` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `announces`
--

INSERT INTO `announces` (`id`, `title`, `content`, `price`, `featured_image`, `created_at`, `users_id`, `categories_id`, `departments_number`) VALUES
(9, 'Brouette', 'Brouette top moumoutte 3000', 10, 'f02cc0adb2331fceaaf61ebf13bb89a7.jfif', '2020-08-24 15:01:12', 4, 1, '12'),
(11, 'Pontiac LeMans', 'La Pontiac LeMans est une automobile produite par la filiale Pontiac du groupe General Motors de 1961 à 1981 puis de 1989 à 1993. Elle regroupe plusieurs classe de véhicule, entre la citadine (4 portes), la coupé et le muscle (dont l\'option GTO).\r\n\r\nElle sera remplacée en 1982 par la Pontiac Bonneville de taille réduite et moins puissante.\r\nEn 1964, la LeMans redevient une version de la Tempest, cette dernière changeant de plateforme pour le A-Body. On peut la commander équipée d\'un six cylindres en ligne de 215 ci (3,5 L), d\'un V8 de 326 ci (5,4 L) , d\'autre option plus sportive comme le V8 389 ci sont disponibles et donne au muscle car de la puissance et du couple en plus .Peu de temps après la sortie du modèle 1964, l\'option performance « GTO » est mise sur le marché par Pontiac. Elle coûte alors 300 dollars et inclut le V8 de 389 ci (6,4 L) développant 325 ou 360 ch, une boîte manuelle Hurst à trois ou quatre rapports, des suspensions renforcées, des pneus Tiger Paw et des emblèmes « GTO » on entend souvent dire que la gto est le premier muscle car, mais la Tempest fut renommée ainsi quelques années avant.\r\n1966 Pontiac Tempest Le Mans coupe)\r\n\r\nPour les motorisation, le 326 ci (5,4 L) est basé sur le 389 ci (6,4 L) mais à alésage réduit, tout comme le 389, le 326 fait 3,75 in (95,3 mm) de course, mais a un alésage réduit à 3,72 in (94,5 mm) lui donnant une cylindrée de (5,4 L) , d\'une puissance entre 260 et 285 hp sans préparation, lui conférant un rapport poids puissance de 4 kg par hp.\r\n\r\n\r\nEn 1967 Pontiac introduit le 400 ci (6,6 L). C\'est un 389 ré-alésé Il remplaça le 389 jusqu\'en 1979, étant aussi disponible en option sur les Lemans mais surtout sur l\'option GTO.\r\n\r\n\r\nPontiac écoulera plus de 32 000 exemplaires de la GTO dès sa première année, bien au-dessus des 5 000 estimés. L\'image sportive de la GTO contribuera en grande partie à gonfler les ventes de la Tempest/LeMans dans les années qui suivirent.\r\n\r\n\r\nLes moteurs Pontiac.  \r\n&lt;p&gt; Une bien belle bagnole quoi ! &lt;/p&gt;', 1000000, 'ad25b358508f23e327338ce95f0b5b22.jpg', '2020-08-24 15:30:50', 8, 5, '59'),
(12, 'Râteau', 'Le râteau est un outil manuel ou mécanique, utilisé en horticulture pour ramasser les feuilles ou les brindilles et égaliser la terre fraîchement bêchée ou sarclée. Il est utilisé également en agriculture pour rassembler et ramasser les foins coupés (râteau-andaineur).\r\n\r\nLe râteau à main est composé d\'une pièce de travail en métal, en plastique, ou encore en bois, comme à son origine : une sorte de traverse munie de dents et fixée en son milieu à un manche en bois ou en métal, parfois garni de poignées en matière plastique. Certains râteaux (scarificateurs) sont équipés de lames qui permettent d\'aérer les pelouses en enlevant la mousse. Il existe également des râteaux à lames flexibles disposées en éventail (racloirs) et servant à racler les feuilles mortes et les coupes de gazon. ', 24, '65a14719bc00b1a9c2ab706b600bc21a.jfif', '2020-08-24 15:55:20', 8, 1, '61'),
(13, 'Boules', 'Pour pointer ou tirer', 5, '288bd5e222dfc6b8584570f8b2d2bfcc.jfif', '2020-08-24 16:01:02', 8, 6, '13'),
(14, 'Valise', 'Jaune pas très très jolie pour ne pas se la faire voler à l\'aéroport ;)', 45, '94dd5e18834e02bdbaa09f5a54227295.jfif', '2020-08-24 16:02:32', 8, 7, '75'),
(15, 'Bic', 'Pas machouillé', 1.05, 'd170dc44c559cc10d2c7fbeb1bdc41f7.jpg', '2020-08-25 12:15:59', 3, 4, '07'),
(17, 'Petit Beurre', 'Le vrai petit LU nantais', 0.2, '6ad2c03529ef5504d3eedcf0f18f2019.JPG', '2020-08-25 15:09:31', 4, 4, '44');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Jardin'),
(4, 'Maison'),
(5, 'Véhicules'),
(6, 'Sport'),
(7, 'Voyage');

-- --------------------------------------------------------

--
-- Structure de la table `departments`
--

CREATE TABLE `departments` (
  `number` varchar(3) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `departments`
--

INSERT INTO `departments` (`number`, `name`) VALUES
('01', 'Ain'),
('02', 'Aisne'),
('03', 'Allier'),
('04', 'Alpes-de-Haute-Provence'),
('05', 'Hautes-Alpes'),
('06', 'Alpes-Maritimes'),
('07', 'Ardèche'),
('08', 'Ardennes'),
('09', 'Ariège'),
('10', 'Aube'),
('11', 'Aude'),
('12', 'Aveyron'),
('13', 'Bouches-du-Rhône'),
('14', 'Calvados'),
('15', 'Cantal'),
('16', 'Charente'),
('17', 'Charente-Maritime'),
('18', 'Cher'),
('19', 'Corrèze'),
('21', 'Côte-d\'Or'),
('22', 'Côtes-d\'Armor'),
('23', 'Creuse'),
('24', 'Dordogne'),
('25', 'Doubs'),
('26', 'Drôme'),
('27', 'Eure'),
('28', 'Eure-et-Loir'),
('29', 'Finistère'),
('2A', 'Corse-du-Sud'),
('2B', 'Haute-Corse'),
('30', 'Gard'),
('31', 'Haute-Garonne'),
('32', 'Gers'),
('33', 'Gironde'),
('34', 'Hérault'),
('35', 'Ille-et-Vilaine'),
('36', 'Indre'),
('37', 'Indre-et-Loire'),
('38', 'Isère'),
('39', 'Jura'),
('40', 'Landes'),
('41', 'Loir-et-Cher'),
('42', 'Loire'),
('43', 'Haute-Loire'),
('44', 'Loire-Atlantique'),
('45', 'Loiret'),
('46', 'Lot'),
('47', 'Lot-et-Garonne'),
('48', 'Lozère'),
('49', 'Maine-et-Loire'),
('50', 'Manche'),
('51', 'Marne'),
('52', 'Haute-Marne'),
('53', 'Mayenne'),
('54', 'Meurthe-et-Moselle'),
('55', 'Meuse'),
('56', 'Morbihan'),
('57', 'Moselle'),
('58', 'Nièvre'),
('59', 'Nord'),
('60', 'Oise'),
('61', 'Orne'),
('62', 'Pas-de-Calais'),
('63', 'Puy-de-Dôme'),
('64', 'Pyrénées-Atlantiques'),
('65', 'Hautes-Pyrénées'),
('66', 'Pyrénées-Orientales'),
('67', 'Bas-Rhin'),
('68', 'Haut-Rhin'),
('69', 'Rhône'),
('70', 'Haute-Saône'),
('71', 'Saône-et-Loire'),
('72', 'Sarthe'),
('73', 'Savoie'),
('74', 'Haute-Savoie'),
('75', 'Paris'),
('76', 'Seine-Maritime'),
('77', 'Seine-et-Marne'),
('78', 'Yvelines'),
('79', 'Deux-Sèvres'),
('80', 'Somme'),
('81', 'Tarn'),
('82', 'Tarn-et-Garonne'),
('83', 'Var'),
('84', 'Vaucluse'),
('85', 'Vendée'),
('86', 'Vienne'),
('87', 'Haute-Vienne'),
('88', 'Vosges'),
('89', 'Yonne'),
('90', 'Territoire de Belfort'),
('91', 'Essonne'),
('92', 'Hauts-de-Seine'),
('93', 'Seine-Saint-Denis'),
('94', 'Val-de-Marne'),
('95', 'Val-d\'Oise'),
('971', 'Guadeloupe'),
('972', 'Martinique'),
('973', 'Guyane'),
('974', 'La Réunion'),
('976', 'Mayotte');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '["ROLE_USER"]' CHECK (json_valid(`roles`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `roles`) VALUES
(3, 'Huguette', 'a@a.a', '0603020507', '$argon2i$v=19$m=65536,t=4,p=1$Qi5NbGJzbDVPSTFNS1BTcQ$gdY6VdBsXnqL1Qe2ZGd064aNjBztCagfPeg9A+BO/3k', '[\"ROLE_USER\"]'),
(4, 'Michelle', 'michelle@ab.c', '0733741820', '$argon2i$v=19$m=65536,t=4,p=1$aDc2b3U0N3FSVkNveElLSQ$IRqx3yR/hskJUBNVAdAhp4MBtumaDFoOK1Rhq7yRWfg', '[\"ROLE_USER\"]'),
(5, 'Jean', 'jean123@hotmail.fr', '012548956', '$argon2i$v=19$m=65536,t=4,p=1$ei5EUDdMREsybnZEV1hxLg$46COm10VmeR31sAPZQefJjZ2HCoOAeXQZrFa76dRGyI', '[\"ROLE_USER\"]'),
(6, 'Jean', 'jean123@hotmail.fr', '012548956', '$argon2i$v=19$m=65536,t=4,p=1$NjhabmFlbXVmNS5iMlhPOQ$Kek1ge4ud+/XdutES/BpBxnHOGZYTYZHJ5isBwCZlQM', '[\"ROLE_USER\"]'),
(7, 'Jean', 'jean123@hotmail.fr', '012548956', '$argon2i$v=19$m=65536,t=4,p=1$OGpPMFRRZmIvbUtpaG55Zg$fm3NkG13P55wdVuOci/oRRaOVeMySmHfTenbbj9EOPU', '[\"ROLE_USER\"]'),
(8, 'Huguette', 'huguette@a.a', '0123456789', '$argon2i$v=19$m=65536,t=4,p=1$WGoxc0tDMFB2RGVtRWxSQQ$tbZSY50b2psjigZM8sKBATOyhEP5srsilgaAlOCLDPQ', '[\"ROLE_USER\"]');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `announces`
--
ALTER TABLE `announces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_number` (`departments_number`),
  ADD KEY `categories_id` (`categories_id`),
  ADD KEY `users_id` (`users_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`number`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `announces`
--
ALTER TABLE `announces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `announces`
--
ALTER TABLE `announces`
  ADD CONSTRAINT `announces_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `announces_ibfk_2` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `announces_ibfk_3` FOREIGN KEY (`departments_number`) REFERENCES `departments` (`number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
