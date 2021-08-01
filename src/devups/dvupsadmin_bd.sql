

						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_admin`
						--

						CREATE TABLE IF NOT EXISTS `dvups_admin` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` varchar(205) not NULL,
							`login` varchar(25) not NULL,
							`password` varchar(255) not NULL
,
						PRIMARY KEY `id` (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

						INSERT INTO `admin` (`id`, `nom`, `login`, `password`) VALUES
			(1, 'admin', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997');
			



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_module`
						--

						CREATE TABLE IF NOT EXISTS `dvups_module` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` varchar(50) not NULL
,
						PRIMARY KEY `id` (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_entity`
						--

						CREATE TABLE IF NOT EXISTS `dvups_entity` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` varchar(100) not NULL,
							`dvups_module_id` int(11) not NULL
,
						PRIMARY KEY `id` (`id`)
							,KEY `dvups_module_id` (`dvups_module_id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_role`
						--

						CREATE TABLE IF NOT EXISTS `dvups_role` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` varchar(50) not NULL,
							`alias` varchar(50) not NULL
,
						PRIMARY KEY `id` (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						
			INSERT INTO `dvups_role` (`id`, `nom`, `alias`) VALUES
			(1, 'admin', 'admin');



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_right`
						--

						CREATE TABLE IF NOT EXISTS `dvups_right` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`name` varchar(50) not NULL
,
						PRIMARY KEY `id` (`id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						
			INSERT INTO `dvups_right` (`id`, `name`) VALUES
			(1, 'create'),
			(2, 'read'),
			(3, 'update'),
			(4, 'delete');



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_role_dvups_module`
						--

						CREATE TABLE IF NOT EXISTS `dvups_role_dvups_module` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`dvups_module_id` int(11) not NULL,
							`dvups_role_id` int(11) not NULL
,
						PRIMARY KEY `id` (`id`)
							,KEY `dvups_module_id` (`dvups_module_id`)
							,KEY `dvups_role_id` (`dvups_role_id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_role_dvups_entity`
						--

						CREATE TABLE IF NOT EXISTS `dvups_role_dvups_entity` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`dvups_entity_id` int(11) not NULL,
							`dvups_role_id` int(11) not NULL
,
						PRIMARY KEY `id` (`id`)
							,KEY `dvups_entity_id` (`dvups_entity_id`)
							,KEY `dvups_role_id` (`dvups_role_id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_right_dvups_entity`
						--

						CREATE TABLE IF NOT EXISTS `dvups_right_dvups_entity` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`dvups_entity_id` int(11) not NULL,
							`dvups_right_id` int(11) not NULL
,
						PRIMARY KEY `id` (`id`)
							,KEY `dvups_entity_id` (`dvups_entity_id`)
							,KEY `dvups_right_id` (`dvups_right_id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_role_dvups_admin`
						--

						CREATE TABLE IF NOT EXISTS `dvups_role_dvups_admin` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`dvups_admin_id` int(11) not NULL,
							`dvups_role_id` int(11) not NULL
,
						PRIMARY KEY `id` (`id`)
							,KEY `dvups_admin_id` (`dvups_admin_id`)
							,KEY `dvups_role_id` (`dvups_role_id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						
                                    INSERT INTO `dvups_role_dvups_admin` (`id`, `admin_id`, `role_id`) VALUES
                                    (1, 1, 1);



						-- --------------------------------------------------------

						--
						-- Structure de la table `dvups_right_dvups_role`
						--

						CREATE TABLE IF NOT EXISTS `dvups_right_dvups_role` (
					  		`id` int(11) NOT NULL AUTO_INCREMENT,
							`dvups_role_id` int(11) not NULL,
							`dvups_right_id` int(11) not NULL
,
						PRIMARY KEY `id` (`id`)
							,KEY `dvups_role_id` (`dvups_role_id`)
							,KEY `dvups_right_id` (`dvups_right_id`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;
						



					-- --------------------------------------------------------
					
					--
					-- Contraintes pour la table `dvups_entity`
					--
					
					ALTER TABLE `dvups_entity`
							ADD CONSTRAINT `dvups_entity_ibfk_1` FOREIGN KEY (`dvups_module_id`) REFERENCES `dvups_module` (`id`)
							 ON DELETE cascade ON UPDATE cascade;

					-- --------------------------------------------------------
					
					--
					-- Contraintes pour la table `dvups_role_dvups_module`
					--
					
					ALTER TABLE `dvups_role_dvups_module`
							ADD CONSTRAINT `dvups_role_dvups_module_ibfk_1` FOREIGN KEY (`dvups_module_id`) REFERENCES `dvups_module` (`id`)
							 ON DELETE cascade ON UPDATE cascade,
							ADD CONSTRAINT `dvups_role_dvups_module_ibfk_2` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`)
							 ON DELETE cascade ON UPDATE cascade;

					-- --------------------------------------------------------
					
					--
					-- Contraintes pour la table `dvups_role_dvups_entity`
					--
					
					ALTER TABLE `dvups_role_dvups_entity`
							ADD CONSTRAINT `dvups_role_dvups_entity_ibfk_1` FOREIGN KEY (`dvups_entity_id`) REFERENCES `dvups_entity` (`id`)
							 ON DELETE cascade ON UPDATE cascade,
							ADD CONSTRAINT `dvups_role_dvups_entity_ibfk_2` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`)
							 ON DELETE cascade ON UPDATE cascade;

					-- --------------------------------------------------------
					
					--
					-- Contraintes pour la table `dvups_right_dvups_entity`
					--
					
					ALTER TABLE `dvups_right_dvups_entity`
							ADD CONSTRAINT `dvups_right_dvups_entity_ibfk_1` FOREIGN KEY (`dvups_entity_id`) REFERENCES `dvups_entity` (`id`)
							 ON DELETE cascade ON UPDATE cascade,
							ADD CONSTRAINT `dvups_right_dvups_entity_ibfk_2` FOREIGN KEY (`dvups_right_id`) REFERENCES `dvups_right` (`id`)
							 ON DELETE cascade ON UPDATE cascade;

					-- --------------------------------------------------------
					
					--
					-- Contraintes pour la table `dvups_role_dvups_admin`
					--
					
					ALTER TABLE `dvups_role_dvups_admin`
							ADD CONSTRAINT `dvups_role_dvups_admin_ibfk_1` FOREIGN KEY (`dvups_admin_id`) REFERENCES `dvups_admin` (`id`)
							 ON DELETE cascade ON UPDATE cascade,
							ADD CONSTRAINT `dvups_role_dvups_admin_ibfk_2` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`)
							 ON DELETE cascade ON UPDATE cascade;

					-- --------------------------------------------------------
					
					--
					-- Contraintes pour la table `dvups_right_dvups_role`
					--
					
					ALTER TABLE `dvups_right_dvups_role`
							ADD CONSTRAINT `dvups_right_dvups_role_ibfk_1` FOREIGN KEY (`dvups_role_id`) REFERENCES `dvups_role` (`id`)
							 ON DELETE cascade ON UPDATE cascade,
							ADD CONSTRAINT `dvups_right_dvups_role_ibfk_2` FOREIGN KEY (`dvups_right_id`) REFERENCES `dvups_right` (`id`)
							 ON DELETE cascade ON UPDATE cascade;