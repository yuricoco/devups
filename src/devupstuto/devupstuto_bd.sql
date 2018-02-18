
                    -- phpMyAdmin SQL Dump
                    -- version 4.1.14
                    -- http://www.phpmyadmin.net
                    --
                    -- Client :  127.0.0.1
                    -- Généré le :  Ven 18 Mars 2016 à 15:36
                    -- Version du serveur :  5.6.17
                    -- Version de PHP :  5.5.12

                    SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
                    SET time_zone = '+00:00';


                    /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
                    /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
                    /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
                    /*!40101 SET NAMES utf8 */;

                    
CREATE TABLE `dvups_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(205) NOT NULL,
  `login` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Déchargement des données de la table `dvups_admin`
--

INSERT INTO `dvups_admin` (`id`, `name`, `login`, `password`) VALUES
(1, 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Structure de la table `dvups_entity`
--

CREATE TABLE `dvups_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `dvups_module_id` int(11) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Déchargement des données de la table `dvups_entity`
--

INSERT INTO `dvups_entity` (`id`, `name`, `dvups_module_id`) VALUES
(1, 'dvups_admin', 1),
(2, 'dvups_role', 1);

-- --------------------------------------------------------

--
-- Structure de la table `dvups_module`
--

CREATE TABLE `dvups_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `project` varchar(50) DEFAULT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Déchargement des données de la table `dvups_module`
--

INSERT INTO `dvups_module` (`id`, `name`, `project`) VALUES
(1, 'ModuleAdmin', 'devups');

-- --------------------------------------------------------

--
-- Structure de la table `dvups_right`
--

CREATE TABLE `dvups_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

--
-- Déchargement des données de la table `dvups_right`
--

INSERT INTO `dvups_right` (`id`, `name`) VALUES
(1, 'create'),
(2, 'read'),
(3, 'update'),
(4, 'delete');

-- --------------------------------------------------------

--
-- Structure de la table `dvups_right_dvups_entity`
--

CREATE TABLE `dvups_right_dvups_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_entity_id` int(11) NOT NULL,
  `dvups_right_id` int(11) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `dvups_right_dvups_role`
--

CREATE TABLE `dvups_right_dvups_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_role_id` int(11) NOT NULL,
  `dvups_right_id` int(11) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5;

--
-- Déchargement des données de la table `dvups_right_dvups_role`
--

INSERT INTO `dvups_right_dvups_role` (`id`, `dvups_role_id`, `dvups_right_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `dvups_role`
--

CREATE TABLE `dvups_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` varchar(50) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;

--
-- Déchargement des données de la table `dvups_role`
--

INSERT INTO `dvups_role` (`id`, `name`, `alias`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Structure de la table `dvups_role_dvups_admin`
--

CREATE TABLE `dvups_role_dvups_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_admin_id` int(11) NOT NULL,
  `dvups_role_id` int(11) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;

--
-- Déchargement des données de la table `dvups_role_dvups_admin`
--

INSERT INTO `dvups_role_dvups_admin` (`id`, `dvups_admin_id`, `dvups_role_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `dvups_role_dvups_entity`
--

CREATE TABLE `dvups_role_dvups_entity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_entity_id` int(11) NOT NULL,
  `dvups_role_id` int(11) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;

--
-- Déchargement des données de la table `dvups_role_dvups_entity`
--

INSERT INTO `dvups_role_dvups_entity` (`id`, `dvups_entity_id`, `dvups_role_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `dvups_role_dvups_module`
--

CREATE TABLE `dvups_role_dvups_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dvups_module_id` int(11) NOT NULL,
  `dvups_role_id` int(11) NOT NULL,
PRIMARY KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;

--
-- Déchargement des données de la table `dvups_role_dvups_module`
--

INSERT INTO `dvups_role_dvups_module` (`id`, `dvups_module_id`, `dvups_role_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Index pour la table `dvups_entity`
--
ALTER TABLE `dvups_entity`
  ADD KEY `dvups_module_id` (`dvups_module_id`);
--
-- Index pour la table `dvups_right_dvups_entity`
--
ALTER TABLE `dvups_right_dvups_entity`
  ADD KEY `dvups_entity_id` (`dvups_entity_id`),
  ADD KEY `dvups_right_id` (`dvups_right_id`);

--
-- Index pour la table `dvups_right_dvups_role`
--
ALTER TABLE `dvups_right_dvups_role`
  ADD KEY `dvups_role_id` (`dvups_role_id`),
  ADD KEY `dvups_right_id` (`dvups_right_id`);

--
-- Index pour la table `dvups_role_dvups_admin`
--
ALTER TABLE `dvups_role_dvups_admin`
  ADD KEY `dvups_admin_id` (`dvups_admin_id`),
  ADD KEY `dvups_role_id` (`dvups_role_id`);

--
-- Index pour la table `dvups_role_dvups_entity`
--
ALTER TABLE `dvups_role_dvups_entity`
  ADD KEY `dvups_entity_id` (`dvups_entity_id`),
  ADD KEY `dvups_role_id` (`dvups_role_id`);

--
-- Index pour la table `dvups_role_dvups_module`
--
ALTER TABLE `dvups_role_dvups_module`
  ADD KEY `dvups_module_id` (`dvups_module_id`),
  ADD KEY `dvups_role_id` (`dvups_role_id`);

--
-- Contraintes pour la table `dvups_entity`
--
ALTER TABLE `dvups_entity`
  ADD CONSTRAINT `dvups_entity_ibfk_1` FOREIGN KEY (`dvups_module_id`) REFERENCES `dvups_module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dvups_right_dvups_entity`
--
ALTER TABLE `dvups_right_dvups_entity`
  ADD CONSTRAINT `dvups_right_dvups_entity_ibfk_1` FOREIGN KEY (`dvups_entity_id`) REFERENCES `dvups_entity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dvups_right_dvups_entity_ibfk_2` FOREIGN KEY (`dvups_right_id`) REFERENCES `dvups_right` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dvups_right_dvups_role`
--
ALTER TABLE `dvups_right_dvups_role`
  ADD CONSTRAINT `dvups_right_dvups_role_ibfk_1` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dvups_right_dvups_role_ibfk_2` FOREIGN KEY (`dvups_right_id`) REFERENCES `dvups_right` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dvups_role_dvups_admin`
--
ALTER TABLE `dvups_role_dvups_admin`
  ADD CONSTRAINT `dvups_role_dvups_admin_ibfk_1` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dvups_role_dvups_admin_ibfk_2` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dvups_role_dvups_entity`
--
ALTER TABLE `dvups_role_dvups_entity`
  ADD CONSTRAINT `dvups_role_dvups_entity_ibfk_1` FOREIGN KEY (`dvups_entity_id`) REFERENCES `dvups_entity` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dvups_role_dvups_entity_ibfk_2` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `dvups_role_dvups_module`
--
ALTER TABLE `dvups_role_dvups_module`
  ADD CONSTRAINT `dvups_role_dvups_module_ibfk_1` FOREIGN KEY (`dvups_module_id`) REFERENCES `dvups_module` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dvups_role_dvups_module_ibfk_2` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
 
                            
                            INSERT INTO `dvups_module` (`id`, `name`, `project`) VALUES
                            (2, 'ModuleStock', 'devupstuto'),(3, 'ModuleProduct', 'devupstuto');

                            INSERT INTO `dvups_entity` (`id`, `name`, `dvups_module_id`) VALUES
                            (3, 'storage', 2),(4, 'category', 3),(5, 'subcategory', 3),(6, 'product', 3),(7, 'image', 3) ;
                            

                            INSERT INTO `dvups_role_dvups_module` ( `dvups_module_id`, `dvups_role_id`) VALUES
                            ( 2, 1),( 3, 1);
                            
                            INSERT INTO `dvups_role_dvups_entity` ( `dvups_entity_id`, `dvups_role_id`) VALUES
                            ( 3, 1),( 4, 1),( 5, 1),( 6, 1),( 7, 1);
                            
                        

                                            -- --------------------------------------------------------

                                            --
                                            -- Structure de la table `storage`
                                            --

                                            CREATE TABLE IF NOT EXISTS `storage` (
                                      		`id` int(11) NOT NULL AUTO_INCREMENT,
							`town` varchar(25) not NULL
,
                                            PRIMARY KEY `id` (`id`)
                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
                                            


                                            -- --------------------------------------------------------

                                            --
                                            -- Structure de la table `category`
                                            --

                                            CREATE TABLE IF NOT EXISTS `category` (
                                      		`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` varchar(25) not NULL
,
                                            PRIMARY KEY `id` (`id`)
                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
                                            


                                            -- --------------------------------------------------------

                                            --
                                            -- Structure de la table `subcategory`
                                            --

                                            CREATE TABLE IF NOT EXISTS `subcategory` (
                                      		`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` varchar(22) not NULL,
							`category_id` int(11) default NULL
,
                                            PRIMARY KEY `id` (`id`)
							,KEY `category_id` (`category_id`)
                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
                                            


                                            -- --------------------------------------------------------

                                            --
                                            -- Structure de la table `product`
                                            --

                                            CREATE TABLE IF NOT EXISTS `product` (
                                      		`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` varchar(25) not NULL,
							`description` text not NULL,
							`image_id` int(11) not NULL,
							`category_id` int(11) not NULL,
							`subcategory_id` int(11) default NULL
,
                                            PRIMARY KEY `id` (`id`)
							,KEY `image_id` (`image_id`)
							,KEY `category_id` (`category_id`)
							,KEY `subcategory_id` (`subcategory_id`)
                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
                                            


                                            -- --------------------------------------------------------

                                            --
                                            -- Structure de la table `image`
                                            --

                                            CREATE TABLE IF NOT EXISTS `image` (
                                      		`id` int(11) NOT NULL AUTO_INCREMENT,
							`image` varchar(255) not NULL
,
                                            PRIMARY KEY `id` (`id`)
                                            ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
                                            



                                    -- --------------------------------------------------------

                                    --
                                    -- Contraintes pour la table `subcategory`
                                    --

                                    ALTER TABLE `subcategory`
                                                    ADD CONSTRAINT `subcategory_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
                                                     ON DELETE cascade ON UPDATE cascade;

                                    -- --------------------------------------------------------

                                    --
                                    -- Contraintes pour la table `product`
                                    --

                                    ALTER TABLE `product`
                                                    ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `image` (`id`)
                                                     ON DELETE cascade ON UPDATE cascade,
                                                    ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
                                                     ON DELETE cascade ON UPDATE cascade,
                                                    ADD CONSTRAINT `product_ibfk_3` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategory` (`id`)
                                                     ON DELETE cascade ON UPDATE cascade;