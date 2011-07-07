ALTER TABLE  `pagesBaseData_deleted` CHANGE  `codename_pbd`  `codename_pbd` VARCHAR( 100 ) NOT NULL;
ALTER TABLE  `pagesBaseData_archived` CHANGE  `codename_pbd`  `codename_pbd` VARCHAR( 100 ) NOT NULL;
ALTER TABLE  `pagesBaseData_edited` CHANGE  `codename_pbd`  `codename_pbd` VARCHAR( 100 ) NOT NULL;
ALTER TABLE  `pagesBaseData_public` CHANGE  `codename_pbd`  `codename_pbd` VARCHAR( 100 ) NOT NULL;
ALTER TABLE  `pages` ADD  `protected_pag` INT( 1 ) NOT NULL AFTER  `url_pag` ;
ALTER TABLE  `pages` ADD  `https_pag` INT( 1 ) NOT NULL AFTER  `protected_pag` ;
ALTER TABLE  `modulesCategories` ADD  `protected_mca` INT( 1 ) NOT NULL AFTER  `icon_mca` ;
ALTER TABLE  `contactDatas` ADD  `company_cd` VARCHAR( 255 ) NOT NULL AFTER  `email_cd` , ADD  `gender_cd` VARCHAR( 255 ) NOT NULL AFTER  `company_cd` ;
ALTER TABLE  `websites` ADD  `altredir_web` INT( 1 ) NOT NULL AFTER  `altdomains_web` ;
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

ALTER TABLE  `mod_cms_aliases` ADD  `websites_ma` VARCHAR( 255 ) NOT NULL ,
ADD  `replace_ma` INT( 1 ) UNSIGNED NOT NULL ,
ADD  `permanent_ma` INT( 1 ) UNSIGNED NOT NULL ,
ADD  `protected_ma` INT( 1 ) UNSIGNED NOT NULL ;