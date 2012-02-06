-- --------------------------------------------------------

--
-- Structure de la table `mod_object_search_tmp`
--

DROP TABLE IF EXISTS `mod_object_search_tmp`;
CREATE TABLE `mod_object_search_tmp` (
  `search_mos` varchar(32) NOT NULL,
  `id_mos` int(11) unsigned NOT NULL,
  UNIQUE KEY `index_mos` (`search_mos`,`id_mos`),
  KEY `search_mos` (`search_mos`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;