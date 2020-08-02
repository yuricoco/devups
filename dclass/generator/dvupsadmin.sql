
--
-- Déchargement des données de la table `dvups_role`
--

INSERT INTO `dvups_role` (`id`, `name`, `alias`) VALUES
(1, 'admin', 'admin');


INSERT INTO `dvups_admin` (`id`, `name`, `login`, `password`, `firstconnexion`, dvups_role_id) VALUES
(1, 'admin', 'dv_admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 1);

--
-- Déchargement des données de la table `dvups_module`
--

INSERT INTO `dvups_module` (`id`, `name`, `project`) VALUES
(1, 'ModuleAdmin', 'devups');

--
-- Déchargement des données de la table `dvups_entity`
--

INSERT INTO `dvups_entity` (`id`, `name`, `dvups_module_id`) VALUES
(1, 'dvups_admin', 1),
(2, 'dvups_role', 1);


--
-- Déchargement des données de la table `dvups_right`
--

INSERT INTO `dvups_right` (`id`, `name`) VALUES
(1, 'create'),
(2, 'read'),
(3, 'update'),
(4, 'delete');

--
-- Déchargement des données de la table `dvups_right_dvups_role`
--

INSERT INTO `dvups_right_dvups_role` (`id`, `dvups_role_id`, `dvups_right_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4);

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Déchargement des données de la table `dvups_role_dvups_admin`
--

INSERT INTO `dvups_role_dvups_admin` (`id`, `dvups_admin_id`, `dvups_role_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Déchargement des données de la table `dvups_role_dvups_entity`
--

INSERT INTO `dvups_role_dvups_entity` (`id`, `dvups_entity_id`, `dvups_role_id`) VALUES
(1, 1, 1),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Déchargement des données de la table `dvups_role_dvups_module`
--

INSERT INTO `dvups_role_dvups_module` (`id`, `dvups_module_id`, `dvups_role_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

