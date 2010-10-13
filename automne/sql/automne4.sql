#
# Create database structure with default values
#

-- --------------------------------------------------------

--
-- Structure de la table `actionsTimestamps`
--

DROP TABLE IF EXISTS `actionsTimestamps`;
CREATE TABLE `actionsTimestamps` (
  `type_at` varchar(50) NOT NULL default '',
  `date_at` datetime NOT NULL default '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `actionsTimestamps`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFiles_archived`
--

DROP TABLE IF EXISTS `blocksFiles_archived`;
CREATE TABLE `blocksFiles_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFiles_archived`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFiles_deleted`
--

DROP TABLE IF EXISTS `blocksFiles_deleted`;
CREATE TABLE `blocksFiles_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFiles_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFiles_edited`
--

DROP TABLE IF EXISTS `blocksFiles_edited`;
CREATE TABLE `blocksFiles_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`),
  FULLTEXT KEY `label` (`label`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFiles_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFiles_edition`
--

DROP TABLE IF EXISTS `blocksFiles_edition`;
CREATE TABLE `blocksFiles_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFiles_edition`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFiles_public`
--

DROP TABLE IF EXISTS `blocksFiles_public`;
CREATE TABLE `blocksFiles_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`),
  FULLTEXT KEY `label` (`label`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFiles_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFlashes_archived`
--

DROP TABLE IF EXISTS `blocksFlashes_archived`;
CREATE TABLE `blocksFlashes_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFlashes_archived`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFlashes_deleted`
--

DROP TABLE IF EXISTS `blocksFlashes_deleted`;
CREATE TABLE `blocksFlashes_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFlashes_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFlashes_edited`
--

DROP TABLE IF EXISTS `blocksFlashes_edited`;
CREATE TABLE `blocksFlashes_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFlashes_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFlashes_edition`
--

DROP TABLE IF EXISTS `blocksFlashes_edition`;
CREATE TABLE `blocksFlashes_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFlashes_edition`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksFlashes_public`
--

DROP TABLE IF EXISTS `blocksFlashes_public`;
CREATE TABLE `blocksFlashes_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `width` int(4) unsigned NOT NULL default '200',
  `height` int(4) unsigned NOT NULL default '100',
  `name` varchar(100) NOT NULL default '',
  `version` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  `flashvars` text NOT NULL,
  `attributes` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksFlashes_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksImages_archived`
--

DROP TABLE IF EXISTS `blocksImages_archived`;
CREATE TABLE `blocksImages_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksImages_archived`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksImages_deleted`
--

DROP TABLE IF EXISTS `blocksImages_deleted`;
CREATE TABLE `blocksImages_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksImages_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksImages_edited`
--

DROP TABLE IF EXISTS `blocksImages_edited`;
CREATE TABLE `blocksImages_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`),
  FULLTEXT KEY `label` (`label`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksImages_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksImages_edition`
--

DROP TABLE IF EXISTS `blocksImages_edition`;
CREATE TABLE `blocksImages_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksImages_edition`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksImages_public`
--

DROP TABLE IF EXISTS `blocksImages_public`;
CREATE TABLE `blocksImages_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `label` varchar(255) NOT NULL default '',
  `file` varchar(255) NOT NULL default '',
  `enlargedFile` varchar(255) NOT NULL default '',
  `externalLink` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`),
  FULLTEXT KEY `label` (`label`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksImages_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksRawDatas_archived`
--

DROP TABLE IF EXISTS `blocksRawDatas_archived`;
CREATE TABLE `blocksRawDatas_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksRawDatas_archived`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksRawDatas_deleted`
--

DROP TABLE IF EXISTS `blocksRawDatas_deleted`;
CREATE TABLE `blocksRawDatas_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksRawDatas_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksRawDatas_edited`
--

DROP TABLE IF EXISTS `blocksRawDatas_edited`;
CREATE TABLE `blocksRawDatas_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksRawDatas_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksRawDatas_edition`
--

DROP TABLE IF EXISTS `blocksRawDatas_edition`;
CREATE TABLE `blocksRawDatas_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksRawDatas_edition`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksRawDatas_public`
--

DROP TABLE IF EXISTS `blocksRawDatas_public`;
CREATE TABLE `blocksRawDatas_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksRawDatas_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksTexts_archived`
--

DROP TABLE IF EXISTS `blocksTexts_archived`;
CREATE TABLE `blocksTexts_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksTexts_archived`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksTexts_deleted`
--

DROP TABLE IF EXISTS `blocksTexts_deleted`;
CREATE TABLE `blocksTexts_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksTexts_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksTexts_edited`
--

DROP TABLE IF EXISTS `blocksTexts_edited`;
CREATE TABLE `blocksTexts_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksTexts_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksTexts_edition`
--

DROP TABLE IF EXISTS `blocksTexts_edition`;
CREATE TABLE `blocksTexts_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksTexts_edition`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksTexts_public`
--

DROP TABLE IF EXISTS `blocksTexts_public`;
CREATE TABLE `blocksTexts_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksTexts_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksVarchars_archived`
--

DROP TABLE IF EXISTS `blocksVarchars_archived`;
CREATE TABLE `blocksVarchars_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksVarchars_archived`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksVarchars_deleted`
--

DROP TABLE IF EXISTS `blocksVarchars_deleted`;
CREATE TABLE `blocksVarchars_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksVarchars_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksVarchars_edited`
--

DROP TABLE IF EXISTS `blocksVarchars_edited`;
CREATE TABLE `blocksVarchars_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksVarchars_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksVarchars_edition`
--

DROP TABLE IF EXISTS `blocksVarchars_edition`;
CREATE TABLE `blocksVarchars_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksVarchars_edition`
--


-- --------------------------------------------------------

--
-- Structure de la table `blocksVarchars_public`
--

DROP TABLE IF EXISTS `blocksVarchars_public`;
CREATE TABLE `blocksVarchars_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `page` (`page`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksVarchars_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `contactDatas`
--

DROP TABLE IF EXISTS `contactDatas`;
CREATE TABLE `contactDatas` (
  `id_cd` int(11) unsigned NOT NULL auto_increment,
  `service_cd` varchar(100) NOT NULL default '',
  `jobTitle_cd` varchar(100) NOT NULL default '',
  `addressField1_cd` varchar(255) NOT NULL default '',
  `addressField2_cd` varchar(255) NOT NULL default '',
  `addressField3_cd` varchar(255) NOT NULL default '',
  `zip_cd` varchar(20) NOT NULL default '',
  `city_cd` varchar(100) NOT NULL default '',
  `state_cd` varchar(50) NOT NULL default '',
  `country_cd` varchar(100) NOT NULL default '',
  `phone_cd` varchar(20) NOT NULL default '',
  `cellphone_cd` varchar(20) NOT NULL default '',
  `fax_cd` varchar(20) NOT NULL default '',
  `email_cd` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_cd`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `contactDatas`
--

INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES(1, '', '', '', '', '', '', '', '', '', '', '', '', 'root@localhost');
INSERT INTO `contactDatas` (`id_cd`, `service_cd`, `jobTitle_cd`, `addressField1_cd`, `addressField2_cd`, `addressField3_cd`, `zip_cd`, `city_cd`, `state_cd`, `country_cd`, `phone_cd`, `cellphone_cd`, `fax_cd`, `email_cd`) VALUES(3, '', '', '', '', '', '', '', '', '', '', '', '', 'nobody@localhost');

-- --------------------------------------------------------

--
-- Structure de la table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `code_lng` varchar(5) NOT NULL default '',
  `label_lng` varchar(50) NOT NULL default '',
  `dateFormat_lng` varchar(5) NOT NULL default 'm/d/Y',
  `availableForBackoffice_lng` tinyint(4) NOT NULL default '0',
  `modulesDenied_lng` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`code_lng`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `languages`
--

INSERT INTO `languages` (`code_lng`, `label_lng`, `dateFormat_lng`, `availableForBackoffice_lng`, `modulesDenied_lng`) VALUES('fr', 'Français', 'd/m/Y', 1, '');
INSERT INTO `languages` (`code_lng`, `label_lng`, `dateFormat_lng`, `availableForBackoffice_lng`, `modulesDenied_lng`) VALUES('en', 'English', 'm/d/Y', 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `linx_real_public`
--

DROP TABLE IF EXISTS `linx_real_public`;
CREATE TABLE `linx_real_public` (
  `start_lre` int(11) unsigned NOT NULL default '0',
  `stop_lre` int(11) NOT NULL default '0',
  UNIQUE KEY `start_lre` (`start_lre`,`stop_lre`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `linx_real_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `linx_tree_edited`
--

DROP TABLE IF EXISTS `linx_tree_edited`;
CREATE TABLE `linx_tree_edited` (
  `id_ltr` int(11) unsigned NOT NULL auto_increment,
  `father_ltr` int(11) unsigned NOT NULL default '0',
  `sibling_ltr` int(11) unsigned NOT NULL default '0',
  `order_ltr` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_ltr`),
  KEY `father_ltr` (`father_ltr`),
  KEY `sibling_ltr` (`sibling_ltr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `linx_tree_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `linx_tree_public`
--

DROP TABLE IF EXISTS `linx_tree_public`;
CREATE TABLE `linx_tree_public` (
  `id_ltr` int(11) unsigned NOT NULL auto_increment,
  `father_ltr` int(11) unsigned NOT NULL default '0',
  `sibling_ltr` int(11) unsigned NOT NULL default '0',
  `order_ltr` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_ltr`),
  KEY `father_ltr` (`father_ltr`),
  KEY `sibling_ltr` (`sibling_ltr`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `linx_tree_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `linx_watch_public`
--

DROP TABLE IF EXISTS `linx_watch_public`;
CREATE TABLE `linx_watch_public` (
  `page_lwa` int(11) unsigned NOT NULL default '0',
  `target_lwa` int(11) unsigned NOT NULL default '0',
  UNIQUE KEY `page_lwa` (`page_lwa`,`target_lwa`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `linx_watch_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `locks`
--

DROP TABLE IF EXISTS `locks`;
CREATE TABLE `locks` (
  `id_lok` int(11) unsigned NOT NULL auto_increment,
  `resource_lok` int(11) unsigned NOT NULL default '0',
  `locksmithData_lok` int(11) unsigned NOT NULL default '0',
  `date_lok` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_lok`),
  KEY `resource_lok` (`resource_lok`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `locks`
--


-- --------------------------------------------------------

--
-- Structure de la table `log`
--

DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id_log` int(11) unsigned NOT NULL auto_increment,
  `user_log` int(11) unsigned NOT NULL default '0',
  `action_log` int(11) unsigned NOT NULL default '0',
  `datetime_log` datetime NOT NULL default '0000-00-00 00:00:00',
  `textData_log` mediumtext NOT NULL,
  `label_log` tinytext NOT NULL,
  `module_log` varchar(100) NOT NULL default '',
  `resource_log` int(11) unsigned NOT NULL default '0',
  `rsAfterLocation_log` tinyint(4) unsigned NOT NULL default '0',
  `rsAfterProposedFor_log` tinyint(4) unsigned NOT NULL default '0',
  `rsAfterEditions_log` tinyint(4) unsigned NOT NULL default '0',
  `rsAfterValidationsRefused_log` tinyint(4) unsigned NOT NULL default '0',
  `rsAfterPublication_log` tinyint(4) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_log`),
  KEY `user_log` (`user_log`),
  KEY `action_log` (`action_log`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `log`
--


-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `id_mes` int(11) unsigned NOT NULL auto_increment,
  `module_mes` varchar(50) NOT NULL,
  `language_mes` varchar(3) NOT NULL,
  `message_mes` text NOT NULL,
  UNIQUE KEY `id` (`id_mes`,`module_mes`,`language_mes`),
  KEY `module` (`module_mes`),
  KEY `language` (`language_mes`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `messages`
--


-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id_mod` int(11) unsigned NOT NULL auto_increment,
  `label_mod` int(11) unsigned NOT NULL default '0',
  `codename_mod` varchar(20) NOT NULL default '',
  `administrationFrontend_mod` varchar(100) NOT NULL default '',
  `hasParameters_mod` tinyint(4) NOT NULL default '0',
  `isPolymod_mod` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_mod`),
  KEY `codename_mod` (`codename_mod`),
  KEY `isPolymod_mod` (`isPolymod_mod`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES(1, 243, 'standard', '', 1, 0);
INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES(2, 1, 'cms_aliases', 'index.php', 0, 0);
INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES(3, 1, 'cms_forms', 'index.php', 1, 0);
INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES(4, 1, 'pnews', 'index.php', 0, 1);
INSERT INTO `modules` (`id_mod`, `label_mod`, `codename_mod`, `administrationFrontend_mod`, `hasParameters_mod`, `isPolymod_mod`) VALUES(5, 1, 'pmedia', 'index.php', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `modulesCategories`
--

DROP TABLE IF EXISTS `modulesCategories`;
CREATE TABLE `modulesCategories` (
  `id_mca` int(11) unsigned NOT NULL auto_increment,
  `uuid_mca` varchar(36) NOT NULL,
  `module_mca` varchar(20) NOT NULL default '',
  `parent_mca` int(10) unsigned NOT NULL default '0',
  `root_mca` int(10) unsigned NOT NULL default '0',
  `lineage_mca` varchar(255) NOT NULL default '',
  `order_mca` int(10) unsigned NOT NULL default '1',
  `icon_mca` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_mca`),
  KEY `module` (`module_mca`),
  KEY `lineage` (`lineage_mca`),
  KEY `parent` (`parent_mca`),
  KEY `root` (`root_mca`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `modulesCategories`
--

INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(1, '3e60e534-0ba9-102e-80e2-001a6470da26', 'cms_forms', 0, 0, '1', 1, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(2, '3e60e656-0ba9-102e-80e2-001a6470da26', 'pnews', 0, 0, '2', 2, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(18, '3e60e714-0ba9-102e-80e2-001a6470da26', 'pmedia', 0, 0, '18', 5, '');

-- --------------------------------------------------------

--
-- Structure de la table `modulesCategories_clearances`
--

DROP TABLE IF EXISTS `modulesCategories_clearances`;
CREATE TABLE `modulesCategories_clearances` (
  `id_mcc` int(11) unsigned NOT NULL auto_increment,
  `profile_mcc` int(11) unsigned NOT NULL default '0',
  `category_mcc` int(10) unsigned NOT NULL default '0',
  `clearance_mcc` tinyint(16) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_mcc`),
  UNIQUE KEY `profilecategories` (`profile_mcc`,`category_mcc`),
  KEY `profile` (`profile_mcc`),
  KEY `category` (`category_mcc`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `modulesCategories_clearances`
--

INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(668, 1, 18, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(172, 3, 2, 1);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(171, 3, 1, 1);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(667, 1, 2, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(626, 4, 2, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(625, 4, 1, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(666, 1, 1, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(645, 10, 18, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(644, 10, 2, 3);
INSERT INTO `modulesCategories_clearances` (`id_mcc`, `profile_mcc`, `category_mcc`, `clearance_mcc`) VALUES(629, 4, 18, 3);

-- --------------------------------------------------------

--
-- Structure de la table `modulesCategories_i18nm`
--

DROP TABLE IF EXISTS `modulesCategories_i18nm`;
CREATE TABLE `modulesCategories_i18nm` (
  `id_mcl` int(11) unsigned NOT NULL auto_increment,
  `category_mcl` int(11) unsigned NOT NULL default '0',
  `language_mcl` char(2) NOT NULL default 'en',
  `label_mcl` varchar(255) NOT NULL default '',
  `description_mcl` text NOT NULL,
  `file_mcl` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_mcl`),
  UNIQUE KEY `categoryperlang` (`category_mcl`,`language_mcl`),
  KEY `category` (`category_mcl`),
  KEY `language` (`language_mcl`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `modulesCategories_i18nm`
--

INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(167, 1, 'en', 'Forms', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(168, 1, 'fr', 'Formulaire', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(155, 2, 'en', 'News', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(156, 2, 'fr', 'Actualités', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(113, 18, 'en', 'Media', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(114, 18, 'fr', 'Média', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `mod_ase_document`
--

DROP TABLE IF EXISTS `mod_ase_document`;
CREATE TABLE `mod_ase_document` (
  `id_mased` int(11) unsigned NOT NULL auto_increment,
  `xid_mased` varchar(255) NOT NULL default '',
  `uid_mased` varchar(255) NOT NULL default '',
  `module_mased` varchar(20) NOT NULL default '',
  `language_mased` char(2) NOT NULL default '',
  `type_mased` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id_mased`),
  UNIQUE KEY `mod-uid` (`uid_mased`,`module_mased`),
  KEY `xid_mased` (`xid_mased`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_ase_document`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_cms_aliases`
--

DROP TABLE IF EXISTS `mod_cms_aliases`;
CREATE TABLE `mod_cms_aliases` (
  `id_ma` int(11) unsigned NOT NULL auto_increment,
  `parent_ma` int(11) unsigned NOT NULL default '0',
  `page_ma` int(11) NOT NULL default '0',
  `url_ma` varchar(255) NOT NULL default '',
  `alias_ma` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_ma`),
  KEY `alias_ma` (`alias_ma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_aliases`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_cms_forms_actions`
--

DROP TABLE IF EXISTS `mod_cms_forms_actions`;
CREATE TABLE `mod_cms_forms_actions` (
  `id_act` int(10) unsigned NOT NULL auto_increment,
  `form_act` int(11) unsigned NOT NULL default '0',
  `value_act` mediumtext NOT NULL,
  `type_act` tinyint(2) unsigned NOT NULL default '0',
  `text_act` mediumtext NOT NULL,
  PRIMARY KEY  (`id_act`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_actions`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_cms_forms_categories`
--

DROP TABLE IF EXISTS `mod_cms_forms_categories`;
CREATE TABLE `mod_cms_forms_categories` (
  `id_fca` int(11) unsigned NOT NULL auto_increment,
  `form_fca` int(11) unsigned NOT NULL default '0',
  `category_fca` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_fca`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_categories`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_cms_forms_fields`
--

DROP TABLE IF EXISTS `mod_cms_forms_fields`;
CREATE TABLE `mod_cms_forms_fields` (
  `id_fld` int(11) unsigned NOT NULL auto_increment,
  `form_fld` int(11) unsigned NOT NULL default '0',
  `name_fld` varchar(32) NOT NULL default '',
  `label_fld` varchar(255) NOT NULL default '',
  `defaultValue_fld` mediumtext NOT NULL,
  `dataValidation_fld` varchar(100) NOT NULL default '',
  `type_fld` varchar(255) NOT NULL default '',
  `options_fld` mediumtext NOT NULL,
  `required_fld` int(1) NOT NULL default '0',
  `active_fld` int(1) NOT NULL default '0',
  `order_fld` int(11) unsigned NOT NULL default '0',
  `params_fld` mediumtext NOT NULL,
  PRIMARY KEY  (`id_fld`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_fields`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_cms_forms_formulars`
--

DROP TABLE IF EXISTS `mod_cms_forms_formulars`;
CREATE TABLE `mod_cms_forms_formulars` (
  `id_frm` int(11) unsigned NOT NULL auto_increment,
  `name_frm` varchar(255) NOT NULL default '',
  `source_frm` text NOT NULL,
  `language_frm` char(2) NOT NULL default 'en',
  `owner_frm` int(11) unsigned NOT NULL default '0',
  `closed_frm` tinyint(1) NOT NULL default '0',
  `destinationType_frm` int(2) NOT NULL default '0',
  `DestinationData_frm` mediumtext NOT NULL,
  `responses_frm` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_frm`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_formulars`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_cms_forms_records`
--

DROP TABLE IF EXISTS `mod_cms_forms_records`;
CREATE TABLE `mod_cms_forms_records` (
  `id_rec` int(11) unsigned NOT NULL auto_increment,
  `sending_rec` int(11) unsigned NOT NULL default '0',
  `field_rec` int(11) unsigned NOT NULL default '0',
  `value_rec` text NOT NULL,
  PRIMARY KEY  (`id_rec`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_records`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_cms_forms_senders`
--

DROP TABLE IF EXISTS `mod_cms_forms_senders`;
CREATE TABLE `mod_cms_forms_senders` (
  `id_snd` int(11) unsigned NOT NULL auto_increment,
  `clientIP_snd` varchar(255) NOT NULL default '',
  `dateInserted_snd` datetime default '0000-00-00 00:00:00',
  `sessionID_snd` varchar(100) NOT NULL default '',
  `userAgent_snd` varchar(255) NOT NULL default '',
  `languages_snd` varchar(255) NOT NULL default '',
  `userID_snd` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_snd`),
  KEY `userID_snd` (`userID_snd`),
  KEY `sessionID_snd` (`sessionID_snd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_senders`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_object_definition`
--

DROP TABLE IF EXISTS `mod_object_definition`;
CREATE TABLE `mod_object_definition` (
  `id_mod` int(11) unsigned NOT NULL auto_increment,
  `uuid_mod` varchar(36) NOT NULL,
  `label_id_mod` int(11) unsigned NOT NULL default '0',
  `description_id_mod` int(11) unsigned NOT NULL default '0',
  `resource_usage_mod` int(2) unsigned NOT NULL default '0',
  `module_mod` varchar(255) NOT NULL default '',
  `admineditable_mod` int(1) unsigned NOT NULL default '0',
  `composedLabel_mod` varchar(255) NOT NULL default '',
  `previewURL_mod` varchar(255) NOT NULL default '',
  `indexable_mod` int(1) NOT NULL default '0',
  `indexURL_mod` mediumtext NOT NULL,
  `compiledIndexURL_mod` mediumtext NOT NULL,
  `resultsDefinition_mod` mediumtext NOT NULL,
  PRIMARY KEY  (`id_mod`),
  KEY `module_mod` (`module_mod`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_object_definition`
--

INSERT INTO `mod_object_definition` (`id_mod`, `uuid_mod`, `label_id_mod`, `description_id_mod`, `resource_usage_mod`, `module_mod`, `admineditable_mod`, `composedLabel_mod`, `previewURL_mod`, `indexable_mod`, `indexURL_mod`, `compiledIndexURL_mod`, `resultsDefinition_mod`) VALUES(1, '3e517ad6-0ba9-102e-80e2-001a6470da26', 1, 2, 1, 'pnews', 0, '', '', 0, '', '', '');
INSERT INTO `mod_object_definition` (`id_mod`, `uuid_mod`, `label_id_mod`, `description_id_mod`, `resource_usage_mod`, `module_mod`, `admineditable_mod`, `composedLabel_mod`, `previewURL_mod`, `indexable_mod`, `indexURL_mod`, `compiledIndexURL_mod`, `resultsDefinition_mod`) VALUES(2, '3e517c2a-0ba9-102e-80e2-001a6470da26', 70, 71, 1, 'pmedia', 0, '', '', 0, '', '', '<div class="pmedias">\r\n	<atm-if what="{[''object2''][''fields''][9][''thumbnail'']} &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''flv'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''mp3''">\r\n		<p style="float:right;"><a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" /></a></p>\r\n	</atm-if>\r\n	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''flv''">\r\n		<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n			<script type="text/javascript">\r\n				swfobject.embedSWF(''{constant:string:PATH_REALROOT_WR}/automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''{constant:string:PATH_REALROOT_WR}/automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''{constant:string:PATH_REALROOT_WR}/automne/playerflv/config_playerflv.xml'', startimage:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}''}, {allowfullscreen:true, wmode:''transparent''}, {''style'':''float:right;''});\r\n			</script>\r\n		</atm-if>\r\n		<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n			<script type="text/javascript">\r\n				swfobject.embedSWF(''{constant:string:PATH_REALROOT_WR}/automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''{constant:string:PATH_REALROOT_WR}/automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''{constant:string:PATH_REALROOT_WR}/automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, {''style'':''float:right;''});\r\n			</script>\r\n		</atm-if>\r\n		<div id="media-{[''object2''][''id'']}" class="pmedias-video" style="width:320px;height:200px;float:right;">\r\n			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n		</div>\r\n	</atm-if>\r\n	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''mp3''">\r\n		<script type="text/javascript">\r\n			swfobject.embedSWF(''{constant:string:PATH_REALROOT_WR}/automne/playermp3/player_mp3.swf'', ''media-{[''object2''][''id'']}'', ''200'', ''20'', ''9.0.0'', ''{constant:string:PATH_REALROOT_WR}/automne/swfobject/expressInstall.swf'', {mp3:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''{constant:string:PATH_REALROOT_WR}/automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, {''style'':''float:right;''});\r\n		</script>\r\n		<div id="media-{[''object2''][''id'']}" class="pmedias-audio" style="width:200px;height:20px;float:right;">\r\n			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n		</div>\r\n	</atm-if>\r\n	<p>{[''object2''][''fields''][9][''fieldname'']} : <strong><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="{[''object2''][''fields''][9][''fileExtension'']}" title="{[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''fields''][9][''fileHTML'']} ({[''object2''][''fields''][9][''fileSize'']}Mo)</strong></p>\r\n	<p>{[''object2''][''fields''][8][''fieldname'']} : <strong>{[''object2''][''fields''][8][''label'']}</strong></p>\r\n	<div style="clear:both;"> </div>\r\n</div>');

-- --------------------------------------------------------

--
-- Structure de la table `mod_object_field`
--

DROP TABLE IF EXISTS `mod_object_field`;
CREATE TABLE `mod_object_field` (
  `id_mof` int(11) unsigned NOT NULL auto_increment,
  `uuid_mof` varchar(36) NOT NULL,
  `object_id_mof` int(11) unsigned NOT NULL default '0',
  `label_id_mof` int(11) unsigned NOT NULL default '0',
  `desc_id_mof` int(11) unsigned NOT NULL default '0',
  `type_mof` varchar(255) NOT NULL default '',
  `order_mof` int(11) unsigned NOT NULL default '0',
  `system_mof` int(1) unsigned NOT NULL default '0',
  `required_mof` int(1) unsigned NOT NULL default '0',
  `indexable_mof` int(1) unsigned NOT NULL default '0',
  `searchlist_mof` int(1) unsigned NOT NULL default '0',
  `searchable_mof` int(1) unsigned NOT NULL default '0',
  `params_mof` mediumtext NOT NULL,
  PRIMARY KEY  (`id_mof`),
  KEY `object_id_mof` (`object_id_mof`,`type_mof`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_object_field`
--

INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(1, '3e5932bc-0ba9-102e-80e2-001a6470da26', 1, 3, 0, 'CMS_object_string', 1, 0, 1, 0, 0, 1, 'a:3:{s:9:"maxLength";s:3:"255";s:7:"isEmail";b:0;s:8:"matchExp";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(2, '3e5933de-0ba9-102e-80e2-001a6470da26', 1, 4, 5, 'CMS_object_text', 3, 0, 1, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"550";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(3, '3e5934b0-0ba9-102e-80e2-001a6470da26', 1, 6, 7, 'CMS_object_text', 4, 0, 0, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"550";s:13:"toolbarHeight";s:3:"500";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(4, '3e593582-0ba9-102e-80e2-001a6470da26', 1, 8, 0, 'CMS_object_image', 5, 0, 0, 0, 0, 1, 'a:5:{s:8:"maxWidth";s:3:"100";s:9:"maxHeight";s:0:"";s:15:"useDistinctZoom";b:0;s:8:"makeZoom";b:1;s:14:"maxWidthPreviz";s:2:"16";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(5, '3e59364a-0ba9-102e-80e2-001a6470da26', 1, 9, 0, 'CMS_object_categories', 2, 0, 1, 0, 1, 1, 'a:6:{s:15:"multiCategories";b:0;s:12:"rootCategory";s:1:"2";s:12:"defaultValue";s:0:"";s:15:"associateUnused";b:0;s:11:"selectWidth";s:0:"";s:12:"selectHeight";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(6, '3e593712-0ba9-102e-80e2-001a6470da26', 2, 80, 0, 'CMS_object_string', 1, 0, 1, 0, 0, 1, 'a:3:{s:9:"maxLength";s:3:"255";s:7:"isEmail";b:0;s:8:"matchExp";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(7, '3e5937da-0ba9-102e-80e2-001a6470da26', 2, 83, 0, 'CMS_object_text', 2, 0, 0, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:4:"100%";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(8, '3e5938ac-0ba9-102e-80e2-001a6470da26', 2, 84, 0, 'CMS_object_categories', 3, 0, 1, 0, 1, 1, 'a:6:{s:15:"multiCategories";b:0;s:12:"rootCategory";s:2:"18";s:12:"defaultValue";s:0:"";s:15:"associateUnused";b:0;s:11:"selectWidth";s:0:"";s:12:"selectHeight";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(9, '3e593974-0ba9-102e-80e2-001a6470da26', 2, 85, 86, 'CMS_object_file', 4, 0, 1, 0, 1, 1, 'a:8:{s:12:"useThumbnail";b:1;s:13:"thumbMaxWidth";s:3:"200";s:14:"thumbMaxHeight";s:0:"";s:9:"fileIcons";a:18:{s:3:"doc";s:7:"doc.gif";s:3:"gif";s:7:"gif.gif";s:4:"html";s:8:"html.gif";s:3:"htm";s:8:"html.gif";s:3:"jpg";s:7:"jpg.gif";s:4:"jpeg";s:7:"jpg.gif";s:3:"jpe";s:7:"jpg.gif";s:3:"mov";s:7:"mov.gif";s:3:"mp3";s:7:"mp3.gif";s:3:"pdf";s:7:"pdf.gif";s:3:"png";s:7:"png.gif";s:3:"ppt";s:7:"ppt.gif";s:3:"pps";s:7:"ppt.gif";s:3:"swf";s:7:"swf.gif";s:3:"sxw";s:7:"sxw.gif";s:3:"url";s:7:"url.gif";s:3:"xls";s:7:"xls.gif";s:3:"xml";s:7:"xml.gif";}s:8:"allowFtp";b:0;s:6:"ftpDir";s:13:"/automne/tmp/";s:11:"allowedType";s:0:"";s:14:"disallowedType";s:31:"exe,php,pif,vbs,bat,com,scr,reg";}');

-- --------------------------------------------------------

--
-- Structure de la table `mod_object_i18nm`
--

DROP TABLE IF EXISTS `mod_object_i18nm`;
CREATE TABLE `mod_object_i18nm` (
  `id_i18nm` int(11) unsigned NOT NULL auto_increment,
  `code_i18nm` char(2) NOT NULL default '',
  `value_i18nm` mediumtext NOT NULL,
  UNIQUE KEY `id` (`id_i18nm`,`code_i18nm`),
  KEY `code` (`code_i18nm`),
  KEY `id_2` (`id_i18nm`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_object_i18nm`
--

INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(1, 'fr', 'Actualités');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(1, 'en', 'News');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(2, 'fr', 'Cet élément permet de saisir des textes catégorisés et soumis à une date de publication.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(2, 'en', 'This item allows you to enter texts categorized and subject to publication date.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(3, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(3, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(4, 'fr', 'Introduction');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(4, 'en', 'Introduction');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(5, 'fr', 'Visible sur la page d''accueil');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(5, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(6, 'fr', 'Texte');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(6, 'en', 'Text');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(7, 'fr', 'Ce texte sera visible dans le détail d''une actualité');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(7, 'en', 'This text will be visible in the news detail');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(8, 'fr', 'Image');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(8, 'en', 'Image');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(9, 'fr', 'Catégorie');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(9, 'en', 'Category');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(10, 'fr', 'Automne : Actualités');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(10, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(11, 'fr', 'Fil RSS des actualités de la démonstration d''Automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(11, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(13, 'fr', 'Un document est un fichier Word, PDF au autre complété par un titre, une description, etc.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(13, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(20, 'fr', 'Insérez un lien vers un document français dans vos textes.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(20, 'en', 'Insert a link to a french document into your texts');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(22, 'fr', 'Insérez un lien vers un document anglais dans vos textes');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(22, 'en', 'Insert a link to an english document into your texts');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(24, 'fr', 'Cette ressource permet de publier des images soumises à validation');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(24, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(26, 'fr', 'Permet de catégoriser les images');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(26, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(29, 'fr', 'Titre de l''image');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(29, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(31, 'fr', 'Image de la photothèque, alignée à droite');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(31, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(33, 'fr', 'Image de la photothèque, alignée à gauche');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(33, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(34, 'fr', 'RSS de la photothèque');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(34, 'en', 'Pictures RSS');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(35, 'fr', 'Fil RSS de la photothèque');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(35, 'en', 'Pictures RSS feed');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(36, 'fr', 'Actualités de Automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(36, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(37, 'fr', 'Flux RSS du site de démonstration d''automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(37, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(38, 'fr', 'Actualités de Automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(38, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(39, 'fr', 'Flux RSS du site de démonstration d''automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(39, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(40, 'fr', 'Actualités de la démo Automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(40, 'en', 'News of Automne demo');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(41, 'fr', 'Flux RSS du site de démonstration d''automne');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(41, 'en', 'RSS feed of the Automne demonstration website.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(42, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(42, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(43, 'fr', 'Fichier média à télécharger. Ce peut-être une vidéo (flv), un son (mp3), une image (jpg, png, gif) ou bien tout autre document (doc, pdf, txt, etc.).');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(43, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(44, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(44, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(45, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(45, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(46, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(46, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(47, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(47, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(48, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(48, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(49, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(49, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(50, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(50, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(51, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(51, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(52, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(52, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(53, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(53, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(54, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(54, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(55, 'fr', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(55, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(56, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(56, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(57, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(57, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(58, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(58, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(59, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(59, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(60, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(60, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(61, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(61, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(62, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(62, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(63, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(63, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(64, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(64, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(65, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(65, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(66, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(66, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(67, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(67, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(68, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(68, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(69, 'fr', 'test');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(69, 'en', '');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(70, 'fr', 'Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(70, 'en', 'Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(71, 'fr', 'Média à télécharger de type Vidéo (flv), Image (jpg, gif, png), Son (mp3) ou tout autre type de fichier (doc, pdf, etc.).');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(71, 'en', 'Downloadable Media of type Video (flv), image (jpg, gif, png), Audio (mp3) or any other file type (doc, pdf, etc.).');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(72, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(72, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(73, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(73, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(74, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(74, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(75, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(75, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(76, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(76, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(77, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(77, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(78, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(78, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(79, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(79, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(80, 'fr', 'Titre');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(80, 'en', 'Title');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(81, 'fr', 'Description');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(82, 'fr', 'Description');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(83, 'fr', 'Description');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(83, 'en', 'Description');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(84, 'fr', 'Catégorie');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(84, 'en', 'Category');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(85, 'fr', 'Fichier');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(85, 'en', 'File');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(86, 'fr', 'Média à télécharger de type Vidéo (flv), Image (jpg, gif, png), Son (mp3) ou tout autre type de fichier (doc, pdf, etc.).');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(86, 'en', 'Downloadable Media type Video (flv), image (jpg, gif, png), Audio (mp3) or any other file type (doc, pdf, etc.).');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(87, 'fr', 'Insérer un Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(87, 'en', 'Insert a Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(88, 'fr', 'Insérez un Média depuis la Médiathèque directement dans votre texte.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(88, 'en', 'Insert a Media from the Mediacenter directly into your text.');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(89, 'fr', 'Lien vers un Média');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(89, 'en', 'Link to Media');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(90, 'fr', 'Faites un lien depuis votre texte sélectionné vers un Média géré par le module Médiathèque');
INSERT INTO `mod_object_i18nm` (`id_i18nm`, `code_i18nm`, `value_i18nm`) VALUES(90, 'en', 'Make a link from your selected text to a Media managed by the Mediacenter module');

-- --------------------------------------------------------

--
-- Structure de la table `mod_object_plugin_definition`
--

DROP TABLE IF EXISTS `mod_object_plugin_definition`;
CREATE TABLE `mod_object_plugin_definition` (
  `id_mowd` int(11) unsigned NOT NULL auto_increment,
  `uuid_mowd` varchar(36) NOT NULL,
  `object_id_mowd` int(11) unsigned NOT NULL default '0',
  `label_id_mowd` int(11) unsigned NOT NULL default '0',
  `description_id_mowd` int(11) unsigned NOT NULL default '0',
  `query_mowd` mediumtext NOT NULL,
  `definition_mowd` mediumtext NOT NULL,
  `compiled_definition_mowd` mediumtext NOT NULL,
  PRIMARY KEY  (`id_mowd`),
  KEY `object_id_mowd` (`object_id_mowd`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_object_plugin_definition`
--

INSERT INTO `mod_object_plugin_definition` (`id_mowd`, `uuid_mowd`, `object_id_mowd`, `label_id_mowd`, `description_id_mowd`, `query_mowd`, `definition_mowd`, `compiled_definition_mowd`) VALUES(1, '3e69e1a2-0ba9-102e-80e2-001a6470da26', 2, 87, 88, 'a:1:{i:8;s:1:"0";}', '<atm-plugin language="fr">\r\n    <atm-plugin-valid>\r\n        <atm-if what="{[''object2''][''fields''][9][''fileExtension'']} != ''flv'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''mp3'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''jpg'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''gif'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''png''">\r\n			<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank" title="Télécharger le document ''{[''object2''][''fields''][9][''fileLabel'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="Fichier {[''object2''][''fields''][9][''fileExtension'']}" title="Fichier {[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''label'']}</a>\r\n		</atm-if>\r\n    	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''flv''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<script type="text/javascript" src="js/modules/pmedia/swfobject.js"></script>\r\n				<script type="text/javascript">\r\n					swfobject.addLoadEvent(function(){\r\n						swfobject.embedSWF(''automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''automne/playerflv/config_playerflv.xml'', startimage:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}''}, {allowfullscreen:true, wmode:''transparent''}, false);\r\n					});\r\n				</script>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<script type="text/javascript" src="js/modules/pmedia/swfobject.js"></script>\r\n				<script type="text/javascript">\r\n					swfobject.addLoadEvent(function(){\r\n						swfobject.embedSWF(''automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, false);\r\n					});\r\n				</script>\r\n			</atm-if>\r\n			<div id="media-{[''object2''][''id'']}" class="pmedias-video" style="width:320px;height:200px;">\r\n				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n			</div>\r\n		</atm-if>\r\n		<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''mp3''">\r\n			<script type="text/javascript" src="js/modules/pmedia/swfobject.js"></script>\r\n			<script type="text/javascript">\r\n				swfobject.addLoadEvent(function(){\r\n					swfobject.embedSWF(''automne/playermp3/player_mp3.swf'', ''media-{[''object2''][''id'']}'', ''200'', ''20'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {mp3:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, false);\r\n				});\r\n			</script>\r\n			<div id="media-{[''object2''][''id'']}" class="pmedias-audio" style="width:200px;height:20px;">\r\n				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n			</div>\r\n		</atm-if>\r\n		<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''jpg'' || {[''object2''][''fields''][9][''fileExtension'']} == ''gif'' || {[''object2''][''fields''][9][''fileExtension'']} == ''png''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" onclick="javascript:CMS_openPopUpImage(''imagezoom.php?location=public&amp;module=pmedia&amp;file={[''object2''][''fields''][9][''filename'']}&amp;label={[''object2''][''label'']|js}'');return false;" target="_blank" title="Voir l''image ''{[''object2''][''label'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" /></a>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" style="max-width:200px;" />\r\n			</atm-if>\r\n		</atm-if>\r\n    </atm-plugin-valid>\r\n	<atm-plugin-view>\r\n        <atm-if what="{[''object2''][''fields''][9][''fileExtension'']} != ''jpg'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''gif'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''png''">\r\n			<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank" title="Télécharger le document ''{[''object2''][''fields''][9][''fileLabel'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="Fichier {[''object2''][''fields''][9][''fileExtension'']}" title="Fichier {[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''label'']}</a>\r\n		</atm-if>\r\n    	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''jpg'' || {[''object2''][''fields''][9][''fileExtension'']} == ''gif'' || {[''object2''][''fields''][9][''fileExtension'']} == ''png''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" onclick="javascript:CMS_openPopUpImage(''imagezoom.php?location=public&amp;module=pmedia&amp;file={[''object2''][''fields''][9][''filename'']}&amp;label={[''object2''][''label'']|js}'');return false;" target="_blank" title="Voir l''image ''{[''object2''][''label'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" /></a>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" style="max-width:200px;" />\r\n			</atm-if>\r\n		</atm-if>\r\n    </atm-plugin-view>\r\n</atm-plugin>', '<?php\n/*Generated on Fri, 10 Sep 2010 16:48:53 +0200 by Automne (TM) 4.1.0a1 */\nif(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, ''CMS_profile_user'') && $cms_user->hasModuleClearance(''pmedia'', CLEARANCE_MODULE_VIEW))){\n	$content = "";\n	$replace = "";\n	$atmIfResults = array();\n	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();\n	$parameters[''objectID''] = 2;\n	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != ''fr'')) $cms_language = new CMS_language(''fr'');\n	$parameters[''public''] = (isset($parameters[''public''])) ? $parameters[''public''] : true;\n	if (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\n	if (!isset($object) || !is_array($object)) $object = array();\n	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters[''public'']);\n	$parameters[''module''] = ''pmedia'';\n	//PLUGIN TAG START 19_42c3db\n	if (!sensitiveIO::isPositiveInteger($parameters[''itemID'']) || !sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n		CMS_grandFather::raiseError(''Error into atm-plugin tag : can\\''t found object infos to use into : $parameters[\\''itemID\\''] and $parameters[\\''objectID\\'']'');\n	} else {\n		//search needed object (need to search it for publications and rights purpose)\n		if (!isset($objectDefinitions[$parameters[''objectID'']])) {\n			$objectDefinitions[$parameters[''objectID'']] = new CMS_poly_object_definition($parameters[''objectID'']);\n		}\n		$search_19_42c3db = new CMS_object_search($objectDefinitions[$parameters[''objectID'']], $parameters[''public'']);\n		$search_19_42c3db->addWhereCondition(''item'', $parameters[''itemID'']);\n		$results_19_42c3db = $search_19_42c3db->search();\n		if (isset($results_19_42c3db[$parameters[''itemID'']]) && is_object($results_19_42c3db[$parameters[''itemID'']])) {\n			$object[$parameters[''objectID'']] = $results_19_42c3db[$parameters[''itemID'']];\n		} else {\n			$object[$parameters[''objectID'']] = new CMS_poly_object($parameters[''objectID''], 0, array(), $parameters[''public'']);\n		}\n		unset($search_19_42c3db);\n		$parameters[''has-plugin-view''] = true;\n		//PLUGIN-VALID TAG START 20_c9ca95\n		if ($object[$parameters[''objectID'']]->isInUserSpace() && !(@$parameters[''plugin-view''] && @$parameters[''has-plugin-view'']) ) {\n			//IF TAG START 21_8fc252\n			$ifcondition_21_8fc252 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''flv'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''mp3'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''jpg'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''gif'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''png''", $replace);\n			if ($ifcondition_21_8fc252) {\n				$func_21_8fc252 = create_function("","return (".$ifcondition_21_8fc252.");");\n				if ($func_21_8fc252()) {\n					$content .="\n					<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Télécharger le document ''".$object[2]->objectValues(9)->getValue(''fileLabel'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\">";\n					//IF TAG START 22_e81162\n					$ifcondition_22_e81162 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileIcon'','''')), $replace);\n					if ($ifcondition_22_e81162) {\n						$func_22_e81162 = create_function("","return (".$ifcondition_22_e81162.");");\n						if ($func_22_e81162()) {\n							$content .="<img src=\\"".$object[2]->objectValues(9)->getValue(''fileIcon'','''')."\\" alt=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" title=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" />";\n						}\n						unset($func_22_e81162);\n					}\n					unset($ifcondition_22_e81162);\n					//IF TAG END 22_e81162\n					$content .=" ".$object[2]->getValue(''label'','''')."</a>\n					";\n				}\n				unset($func_21_8fc252);\n			}\n			unset($ifcondition_21_8fc252);\n			//IF TAG END 21_8fc252\n			//IF TAG START 23_c79f4d\n			$ifcondition_23_c79f4d = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''flv''", $replace);\n			if ($ifcondition_23_c79f4d) {\n				$func_23_c79f4d = create_function("","return (".$ifcondition_23_c79f4d.");");\n				if ($func_23_c79f4d()) {\n					//IF TAG START 24_a6db21\n					$ifcondition_24_a6db21 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_24_a6db21) {\n						$func_24_a6db21 = create_function("","return (".$ifcondition_24_a6db21.");");\n						if ($func_24_a6db21()) {\n							$content .="\n							<script type=\\"text/javascript\\" src=\\"js/modules/pmedia/swfobject.js\\"></script>\n							<script type=\\"text/javascript\\">\n							swfobject.addLoadEvent(function(){\n								swfobject.embedSWF(''automne/playerflv/player_flv.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''320'', ''200'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {flv:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''automne/playerflv/config_playerflv.xml'', startimage:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."''}, {allowfullscreen:true, wmode:''transparent''}, false);\n							});\n							</script>\n							";\n						}\n						unset($func_24_a6db21);\n					}\n					unset($ifcondition_24_a6db21);\n					//IF TAG END 24_a6db21\n					//IF TAG START 25_21cb8e\n					$ifcondition_25_21cb8e = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_25_21cb8e) {\n						$func_25_21cb8e = create_function("","return (".$ifcondition_25_21cb8e.");");\n						if ($func_25_21cb8e()) {\n							$content .="\n							<script type=\\"text/javascript\\" src=\\"js/modules/pmedia/swfobject.js\\"></script>\n							<script type=\\"text/javascript\\">\n							swfobject.addLoadEvent(function(){\n								swfobject.embedSWF(''automne/playerflv/player_flv.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''320'', ''200'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {flv:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, false);\n							});\n							</script>\n							";\n						}\n						unset($func_25_21cb8e);\n					}\n					unset($ifcondition_25_21cb8e);\n					//IF TAG END 25_21cb8e\n					$content .="\n					<div id=\\"media-".$object[2]->getValue(''id'','''')."\\" class=\\"pmedias-video\\" style=\\"width:320px;height:200px;\\">\n					<p><a href=\\"http://www.adobe.com/go/getflashplayer\\"><img src=\\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\\" alt=\\"Get Adobe Flash player\\" /></a></p>\n					</div>\n					";\n				}\n				unset($func_23_c79f4d);\n			}\n			unset($ifcondition_23_c79f4d);\n			//IF TAG END 23_c79f4d\n			//IF TAG START 26_9eb7ee\n			$ifcondition_26_9eb7ee = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''mp3''", $replace);\n			if ($ifcondition_26_9eb7ee) {\n				$func_26_9eb7ee = create_function("","return (".$ifcondition_26_9eb7ee.");");\n				if ($func_26_9eb7ee()) {\n					$content .="\n					<script type=\\"text/javascript\\" src=\\"js/modules/pmedia/swfobject.js\\"></script>\n					<script type=\\"text/javascript\\">\n					swfobject.addLoadEvent(function(){\n						swfobject.embedSWF(''automne/playermp3/player_mp3.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''200'', ''20'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {mp3:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, false);\n					});\n					</script>\n					<div id=\\"media-".$object[2]->getValue(''id'','''')."\\" class=\\"pmedias-audio\\" style=\\"width:200px;height:20px;\\">\n					<p><a href=\\"http://www.adobe.com/go/getflashplayer\\"><img src=\\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\\" alt=\\"Get Adobe Flash player\\" /></a></p>\n					</div>\n					";\n				}\n				unset($func_26_9eb7ee);\n			}\n			unset($ifcondition_26_9eb7ee);\n			//IF TAG END 26_9eb7ee\n			//IF TAG START 27_427d6a\n			$ifcondition_27_427d6a = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''jpg'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''gif'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''png''", $replace);\n			if ($ifcondition_27_427d6a) {\n				$func_27_427d6a = create_function("","return (".$ifcondition_27_427d6a.");");\n				if ($func_27_427d6a()) {\n					//IF TAG START 28_9a69cc\n					$ifcondition_28_9a69cc = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_28_9a69cc) {\n						$func_28_9a69cc = create_function("","return (".$ifcondition_28_9a69cc.");");\n						if ($func_28_9a69cc()) {\n							$content .="\n							<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" onclick=\\"javascript:CMS_openPopUpImage(''imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue(''filename'','''')."&amp;label=".$object[2]->getValue(''label'',''js'')."'');return false;\\" target=\\"_blank\\" title=\\"Voir l''image ''".$object[2]->getValue(''label'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\"><img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" /></a>\n							";\n						}\n						unset($func_28_9a69cc);\n					}\n					unset($ifcondition_28_9a69cc);\n					//IF TAG END 28_9a69cc\n					//IF TAG START 29_a16612\n					$ifcondition_29_a16612 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_29_a16612) {\n						$func_29_a16612 = create_function("","return (".$ifcondition_29_a16612.");");\n						if ($func_29_a16612()) {\n							$content .="\n							<img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" style=\\"max-width:200px;\\" />\n							";\n						}\n						unset($func_29_a16612);\n					}\n					unset($ifcondition_29_a16612);\n					//IF TAG END 29_a16612\n				}\n				unset($func_27_427d6a);\n			}\n			unset($ifcondition_27_427d6a);\n			//IF TAG END 27_427d6a\n		}\n		//PLUGIN-VALID END 20_c9ca95\n		//PLUGIN-VIEW TAG START 30_b94642\n		if ($object[$parameters[''objectID'']]->isInUserSpace() && isset($parameters[''plugin-view''])) {\n			//IF TAG START 31_8c02eb\n			$ifcondition_31_8c02eb = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''jpg'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''gif'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''png''", $replace);\n			if ($ifcondition_31_8c02eb) {\n				$func_31_8c02eb = create_function("","return (".$ifcondition_31_8c02eb.");");\n				if ($func_31_8c02eb()) {\n					$content .="\n					<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Télécharger le document ''".$object[2]->objectValues(9)->getValue(''fileLabel'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\">";\n					//IF TAG START 32_625efd\n					$ifcondition_32_625efd = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileIcon'','''')), $replace);\n					if ($ifcondition_32_625efd) {\n						$func_32_625efd = create_function("","return (".$ifcondition_32_625efd.");");\n						if ($func_32_625efd()) {\n							$content .="<img src=\\"".$object[2]->objectValues(9)->getValue(''fileIcon'','''')."\\" alt=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" title=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" />";\n						}\n						unset($func_32_625efd);\n					}\n					unset($ifcondition_32_625efd);\n					//IF TAG END 32_625efd\n					$content .=" ".$object[2]->getValue(''label'','''')."</a>\n					";\n				}\n				unset($func_31_8c02eb);\n			}\n			unset($ifcondition_31_8c02eb);\n			//IF TAG END 31_8c02eb\n			//IF TAG START 33_e1042e\n			$ifcondition_33_e1042e = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''jpg'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''gif'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''png''", $replace);\n			if ($ifcondition_33_e1042e) {\n				$func_33_e1042e = create_function("","return (".$ifcondition_33_e1042e.");");\n				if ($func_33_e1042e()) {\n					//IF TAG START 34_d85f75\n					$ifcondition_34_d85f75 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_34_d85f75) {\n						$func_34_d85f75 = create_function("","return (".$ifcondition_34_d85f75.");");\n						if ($func_34_d85f75()) {\n							$content .="\n							<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" onclick=\\"javascript:CMS_openPopUpImage(''imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue(''filename'','''')."&amp;label=".$object[2]->getValue(''label'',''js'')."'');return false;\\" target=\\"_blank\\" title=\\"Voir l''image ''".$object[2]->getValue(''label'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\"><img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" /></a>\n							";\n						}\n						unset($func_34_d85f75);\n					}\n					unset($ifcondition_34_d85f75);\n					//IF TAG END 34_d85f75\n					//IF TAG START 35_2523b4\n					$ifcondition_35_2523b4 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_35_2523b4) {\n						$func_35_2523b4 = create_function("","return (".$ifcondition_35_2523b4.");");\n						if ($func_35_2523b4()) {\n							$content .="\n							<img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" style=\\"max-width:200px;\\" />\n							";\n						}\n						unset($func_35_2523b4);\n					}\n					unset($ifcondition_35_2523b4);\n					//IF TAG END 35_2523b4\n				}\n				unset($func_33_e1042e);\n			}\n			unset($ifcondition_33_e1042e);\n			//IF TAG END 33_e1042e\n		}\n		//PLUGIN-VIEW END 30_b94642\n		$content .="\n		";\n	}\n	//PLUGIN TAG END 19_42c3db\n	$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);\n	$content .= ''<!--{elements:''.base64_encode(serialize(array (\n		''module'' =>\n		array (\n			0 => ''pmedia'',\n		),\n	))).''}-->'';\n	echo $content;\n	unset($content);}\n	?>');
INSERT INTO `mod_object_plugin_definition` (`id_mowd`, `uuid_mowd`, `object_id_mowd`, `label_id_mowd`, `description_id_mowd`, `query_mowd`, `definition_mowd`, `compiled_definition_mowd`) VALUES(2, '3e69e3be-0ba9-102e-80e2-001a6470da26', 2, 89, 90, 'a:1:{i:8;s:1:"0";}', '<atm-plugin language="fr">\r\n    <atm-plugin-valid>\r\n        <a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank" title="Télécharger le document ''{[''object2''][''fields''][9][''fileLabel'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="Fichier {[''object2''][''fields''][9][''fileExtension'']}" title="Fichier {[''object2''][''fields''][9][''fileExtension'']}" /> </atm-if>{plugin:selection}</a>\r\n    </atm-plugin-valid>\r\n	<atm-plugin-invalid>\r\n        {plugin:selection}\r\n    </atm-plugin-invalid>\r\n</atm-plugin>', '<?php\n/*Generated on Fri, 10 Sep 2010 16:47:45 +0200 by Automne (TM) 4.1.0a1 */\nif(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, ''CMS_profile_user'') && $cms_user->hasModuleClearance(''pmedia'', CLEARANCE_MODULE_VIEW))){\n	$content = "";\n	$replace = "";\n	$atmIfResults = array();\n	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();\n	$parameters[''objectID''] = 2;\n	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != ''fr'')) $cms_language = new CMS_language(''fr'');\n	$parameters[''public''] = (isset($parameters[''public''])) ? $parameters[''public''] : true;\n	if (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\n	if (!isset($object) || !is_array($object)) $object = array();\n	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters[''public'']);\n	$parameters[''module''] = ''pmedia'';\n	//PLUGIN TAG START 19_e45d46\n	if (!sensitiveIO::isPositiveInteger($parameters[''itemID'']) || !sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n		CMS_grandFather::raiseError(''Error into atm-plugin tag : can\\''t found object infos to use into : $parameters[\\''itemID\\''] and $parameters[\\''objectID\\'']'');\n	} else {\n		//search needed object (need to search it for publications and rights purpose)\n		if (!isset($objectDefinitions[$parameters[''objectID'']])) {\n			$objectDefinitions[$parameters[''objectID'']] = new CMS_poly_object_definition($parameters[''objectID'']);\n		}\n		$search_19_e45d46 = new CMS_object_search($objectDefinitions[$parameters[''objectID'']], $parameters[''public'']);\n		$search_19_e45d46->addWhereCondition(''item'', $parameters[''itemID'']);\n		$results_19_e45d46 = $search_19_e45d46->search();\n		if (isset($results_19_e45d46[$parameters[''itemID'']]) && is_object($results_19_e45d46[$parameters[''itemID'']])) {\n			$object[$parameters[''objectID'']] = $results_19_e45d46[$parameters[''itemID'']];\n		} else {\n			$object[$parameters[''objectID'']] = new CMS_poly_object($parameters[''objectID''], 0, array(), $parameters[''public'']);\n		}\n		unset($search_19_e45d46);\n		$parameters[''has-plugin-view''] = false;\n		//PLUGIN-VALID TAG START 20_530222\n		if ($object[$parameters[''objectID'']]->isInUserSpace() && !(@$parameters[''plugin-view''] && @$parameters[''has-plugin-view'']) ) {\n			$content .="\n			<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Télécharger le document ''".$object[2]->objectValues(9)->getValue(''fileLabel'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\">";\n			//IF TAG START 21_52063c\n			$ifcondition_21_52063c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileIcon'','''')), $replace);\n			if ($ifcondition_21_52063c) {\n				$func_21_52063c = create_function("","return (".$ifcondition_21_52063c.");");\n				if ($func_21_52063c()) {\n					$content .="<img src=\\"".$object[2]->objectValues(9)->getValue(''fileIcon'','''')."\\" alt=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" title=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" /> ";\n				}\n				unset($func_21_52063c);\n			}\n			unset($ifcondition_21_52063c);\n			//IF TAG END 21_52063c\n			$content .=$parameters[''selection'']."</a>\n			";\n		}\n		//PLUGIN-VALID END 20_530222\n		//PLUGIN-INVALID TAG START 22_3a2761\n		if (!$object[$parameters[''objectID'']]->isInUserSpace()) {\n			$content .="\n			".$parameters[''selection'']."\n			";\n		}\n		//PLUGIN-INVALID END 22_3a2761\n		$content .="\n		";\n	}\n	//PLUGIN TAG END 19_e45d46\n	$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);\n	$content .= ''<!--{elements:''.base64_encode(serialize(array (\n		''module'' =>\n		array (\n			0 => ''pmedia'',\n		),\n	))).''}-->'';\n	echo $content;\n	unset($content);}\n	?>');

-- --------------------------------------------------------

--
-- Structure de la table `mod_object_polyobjects`
--

DROP TABLE IF EXISTS `mod_object_polyobjects`;
CREATE TABLE `mod_object_polyobjects` (
  `id_moo` int(11) unsigned NOT NULL auto_increment,
  `object_type_id_moo` int(11) unsigned NOT NULL default '0',
  `deleted_moo` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_moo`),
  KEY `object_id_moo` (`object_type_id_moo`),
  KEY `deleted_moo` (`deleted_moo`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_object_polyobjects`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_object_rss_definition`
--

DROP TABLE IF EXISTS `mod_object_rss_definition`;
CREATE TABLE `mod_object_rss_definition` (
  `id_mord` int(11) unsigned NOT NULL auto_increment,
  `uuid_mord` varchar(36) NOT NULL,
  `object_id_mord` int(11) unsigned NOT NULL default '0',
  `label_id_mord` int(11) unsigned NOT NULL default '0',
  `description_id_mord` int(11) unsigned NOT NULL default '0',
  `link_mord` varchar(255) NOT NULL default '',
  `author_mord` varchar(255) NOT NULL default '',
  `copyright_mord` varchar(255) NOT NULL default '',
  `categories_mord` mediumtext NOT NULL,
  `ttl_mord` int(11) NOT NULL default '0',
  `email_mord` varchar(255) NOT NULL default '',
  `definition_mord` mediumtext NOT NULL,
  `compiled_definition_mord` mediumtext NOT NULL,
  `last_compilation_mord` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_mord`),
  KEY `object_id_mord` (`object_id_mord`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_object_rss_definition`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_standard_clientSpaces_archived`
--

DROP TABLE IF EXISTS `mod_standard_clientSpaces_archived`;
CREATE TABLE `mod_standard_clientSpaces_archived` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_standard_clientSpaces_archived`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_standard_clientSpaces_deleted`
--

DROP TABLE IF EXISTS `mod_standard_clientSpaces_deleted`;
CREATE TABLE `mod_standard_clientSpaces_deleted` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_standard_clientSpaces_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_standard_clientSpaces_edited`
--

DROP TABLE IF EXISTS `mod_standard_clientSpaces_edited`;
CREATE TABLE `mod_standard_clientSpaces_edited` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_standard_clientSpaces_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_standard_clientSpaces_edition`
--

DROP TABLE IF EXISTS `mod_standard_clientSpaces_edition`;
CREATE TABLE `mod_standard_clientSpaces_edition` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_standard_clientSpaces_edition`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_standard_clientSpaces_public`
--

DROP TABLE IF EXISTS `mod_standard_clientSpaces_public`;
CREATE TABLE `mod_standard_clientSpaces_public` (
  `template_cs` int(11) unsigned NOT NULL default '0',
  `tagID_cs` varchar(100) NOT NULL default '',
  `rowsDefinition_cs` varchar(255) NOT NULL default '',
  `type_cs` int(11) NOT NULL default '0',
  `order_cs` int(11) NOT NULL default '0',
  PRIMARY KEY  (`template_cs`,`tagID_cs`,`order_cs`),
  KEY `template_cs` (`template_cs`),
  KEY `type_cs` (`type_cs`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_standard_clientSpaces_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_standard_rows`
--

DROP TABLE IF EXISTS `mod_standard_rows`;
CREATE TABLE `mod_standard_rows` (
  `id_row` int(11) unsigned NOT NULL auto_increment,
  `uuid_row` varchar(36) NOT NULL,
  `label_row` varchar(100) NOT NULL default '',
  `definitionFile_row` varchar(100) NOT NULL default '',
  `modulesStack_row` varchar(255) NOT NULL default '',
  `groupsStack_row` varchar(255) NOT NULL default '',
  `image_row` varchar(255) NOT NULL default '',
  `description_row` text NOT NULL,
  `tplfilter_row` varchar(255) NOT NULL default '',
  `useable_row` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_row`),
  FULLTEXT KEY `label_row` (`label_row`,`description_row`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_standard_rows`
--

INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(25, '3e79ad9e-0ba9-102e-80e2-001a6470da26', '000 Exemple', 'r25_Complet.xml', 'standard', '', 'nopicto.gif', 'Cette rangée regroupe des exemples des différents types de blocs à votre disposition : chaîne de caractères, texte, image, fichier, animation Flash', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(46, '3e79b0be-0ba9-102e-80e2-001a6470da26', '220 Texte et Image Gauche', 'r46_220_Texte_et_Image_Gauche.xml', 'standard', '', 'text-img-left.gif', 'Cette rangée permet d''insérer du texte qu''on pourra mettre en forme via l''éditeur Wysiwyg et elle permet d''insérer en plus une image alignée sur le côté gauche', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(45, '3e79b3c0-0ba9-102e-80e2-001a6470da26', '210 Texte et Image Droite', 'r45_210_Texte__image_droite.xml', 'standard', '', 'text-img-right.gif', 'Cette rangée permet d''insérer du texte qu''on pourra mettre en forme via l''éditeur Wysiwyg et elle permet d''insérer en plus une image alignée sur le côté droit', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(44, '3e79b6b8-0ba9-102e-80e2-001a6470da26', '200 Texte', 'r44_200_Texte.xml', 'standard', '', 'text.gif', 'Cette rangée peut contenir du texte mis en forme (liens, listes à puces, tableaux, etc.) à l''aide de l''éditeur Wysiwyg. Elle permet aussi d''insérer des liens vers des contenus stockés dans les modules', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(43, '3e79ba14-0ba9-102e-80e2-001a6470da26', '110 Sous Titre (niveau 2)', 'r43_100_Sous_Titre.xml', 'standard', '', 'title.gif', 'Cette rangée permet d''insérer un titre de niveau 2 correspondant à l''élément H2 en HTML', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(42, '3e79bc26-0ba9-102e-80e2-001a6470da26', '100 Titre (niveau 1)', 'r42_000_Titre.xml', 'standard', '', 'title.gif', 'Cette rangée vous permet d''insérer un titre de niveau 1 correspondant à l''élément H1 en HTML', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(47, '3e79be2e-0ba9-102e-80e2-001a6470da26', '400 Télécharger un fichier', 'r47_400_Telecharger_un_fichier.xml', 'standard', '', 'file.gif', 'Cette rangée permet d''insérer un fichier à télécharger', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(48, '3e79bfdc-0ba9-102e-80e2-001a6470da26', '300 Image Centrée', 'r48_300_Image_Centree.xml', 'standard', '', 'img.gif', 'Cette rangée insère une image centrée dont la largeur est limitée à 500px', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(49, '3e79c1c6-0ba9-102e-80e2-001a6470da26', '410 Animation Flash', 'r49_500_Animation_Flash.xml', 'standard', '', 'flash.gif', 'Cette rangée permet d''insérer une animation Flash (.swf)', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(54, '3e79c36a-0ba9-102e-80e2-001a6470da26', '700 Plan du site', 'r54_700_Plan_du_site.xml', 'standard', 'admin', 'tree.gif', 'Cette rangée génère un plan du site à partir de la racine du site sur 3 niveaux de profondeur', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(55, '3e79c572-0ba9-102e-80e2-001a6470da26', '800 [Formulaire]', 'r55_800_Formulaire.xml', 'cms_forms', 'admin', 'form.gif', 'Cette rangée permet d''insérer un formulaire créé à partir du module formulaire', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(61, '3e79c75c-0ba9-102e-80e2-001a6470da26', '900 Carte Google', 'r61_900_Google_Maps.xml', 'standard', 'admin', 'nopicto.gif', 'Cette rangée vous permet d''insérer une carte Google Maps à partir d''une adresse postale.\nVous devez posséder une clef valide pour utiliser ce service. Voir le code source de la rangée pour plus d''informations', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(67, '3e79cb1c-0ba9-102e-80e2-001a6470da26', '120 Mini Titre (niveau 3)', 'r67_120_Sous_Sous_Titre.xml', 'standard', '', 'title.gif', 'Cette rangée vous permet d''insérer un titre de niveau 3 correspondant à l''élément H3 en HTML', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(69, '3e79cd42-0ba9-102e-80e2-001a6470da26', '230 Texte et Média à Droite', 'r69_Texte_-_Media_a_droite.xml', 'pmedia;standard', '', 'text-mod-right.gif', 'Cette rangée permet d''insérer du texte qu''on pourra mettre en forme via l''éditeur Wysiwyg avec,  aligné à droite, un élément issu du module médiathèque', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(70, '3e79d04e-0ba9-102e-80e2-001a6470da26', '240 Texte et Média à Gauche', 'r70_240_Texte_et_Media_a_Gauche.xml', 'pmedia;standard', '', 'text-mod-left.gif', 'Cette rangée permet d''insérer du texte qu''on pourra mettre en forme via l''éditeur Wysiwyg avec,  aligné à gauche, un élément issu du module médiathèque', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_date_deleted`
--

DROP TABLE IF EXISTS `mod_subobject_date_deleted`;
CREATE TABLE `mod_subobject_date_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_date_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_date_edited`
--

DROP TABLE IF EXISTS `mod_subobject_date_edited`;
CREATE TABLE `mod_subobject_date_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_date_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_date_public`
--

DROP TABLE IF EXISTS `mod_subobject_date_public`;
CREATE TABLE `mod_subobject_date_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_date_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_integer_deleted`
--

DROP TABLE IF EXISTS `mod_subobject_integer_deleted`;
CREATE TABLE `mod_subobject_integer_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_integer_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_integer_edited`
--

DROP TABLE IF EXISTS `mod_subobject_integer_edited`;
CREATE TABLE `mod_subobject_integer_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_integer_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_integer_public`
--

DROP TABLE IF EXISTS `mod_subobject_integer_public`;
CREATE TABLE `mod_subobject_integer_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_integer_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_string_deleted`
--

DROP TABLE IF EXISTS `mod_subobject_string_deleted`;
CREATE TABLE `mod_subobject_string_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_string_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_string_edited`
--

DROP TABLE IF EXISTS `mod_subobject_string_edited`;
CREATE TABLE `mod_subobject_string_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_string_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_string_public`
--

DROP TABLE IF EXISTS `mod_subobject_string_public`;
CREATE TABLE `mod_subobject_string_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_string_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_text_deleted`
--

DROP TABLE IF EXISTS `mod_subobject_text_deleted`;
CREATE TABLE `mod_subobject_text_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_text_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_text_edited`
--

DROP TABLE IF EXISTS `mod_subobject_text_edited`;
CREATE TABLE `mod_subobject_text_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_text_edited`
--


-- --------------------------------------------------------

--
-- Structure de la table `mod_subobject_text_public`
--

DROP TABLE IF EXISTS `mod_subobject_text_public`;
CREATE TABLE `mod_subobject_text_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `objectID` int(11) unsigned NOT NULL default '0',
  `objectFieldID` int(11) unsigned NOT NULL default '0',
  `objectSubFieldID` int(11) unsigned NOT NULL default '0',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `objectID` (`objectID`),
  KEY `objectFieldID` (`objectFieldID`),
  KEY `objectSubFieldID` (`objectSubFieldID`),
  FULLTEXT KEY `value` (`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_text_public`
--


-- --------------------------------------------------------

--
-- Structure de la table `pages`
--

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id_pag` int(11) unsigned NOT NULL auto_increment,
  `resource_pag` int(11) unsigned NOT NULL default '0',
  `remindedEditorsStack_pag` varchar(255) NOT NULL default '',
  `lastReminder_pag` date NOT NULL default '0000-00-00',
  `template_pag` int(11) unsigned NOT NULL default '0',
  `lastFileCreation_pag` datetime NOT NULL default '0000-00-00 00:00:00',
  `url_pag` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_pag`),
  KEY `id_pag` (`id_pag`),
  KEY `template_pag` (`template_pag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pages`
--

INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(1, 1, '1', '2010-06-02', 1, '2010-06-02 16:51:00', '1-accueil.php');

-- --------------------------------------------------------

--
-- Structure de la table `pagesBaseData_archived`
--

DROP TABLE IF EXISTS `pagesBaseData_archived`;
CREATE TABLE `pagesBaseData_archived` (
  `id_pbd` int(11) unsigned NOT NULL auto_increment,
  `page_pbd` int(11) unsigned NOT NULL default '0',
  `title_pbd` varchar(150) NOT NULL default '',
  `linkTitle_pbd` varchar(150) NOT NULL default '',
  `keywords_pbd` mediumtext NOT NULL,
  `description_pbd` mediumtext NOT NULL,
  `reminderPeriodicity_pbd` smallint(6) unsigned NOT NULL default '0',
  `reminderOn_pbd` date NOT NULL default '0000-00-00',
  `reminderOnMessage_pbd` mediumtext NOT NULL,
  `category_pbd` varchar(255) NOT NULL default '',
  `author_pbd` varchar(255) NOT NULL default '',
  `replyto_pbd` varchar(255) NOT NULL default '',
  `copyright_pbd` varchar(255) NOT NULL default '',
  `language_pbd` varchar(255) NOT NULL default '',
  `robots_pbd` varchar(255) NOT NULL default '',
  `pragma_pbd` varchar(255) NOT NULL default '',
  `refresh_pbd` varchar(255) NOT NULL default '',
  `redirect_pbd` varchar(255) NOT NULL default '',
  `refreshUrl_pbd` int(1) NOT NULL default '0',
  `url_pbd` varchar(255) NOT NULL default '',
  `metas_pbd` text NOT NULL,
  `codename_pbd` varchar(20) NOT NULL,
  PRIMARY KEY  (`id_pbd`),
  KEY `page_pbd` (`page_pbd`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pagesBaseData_archived`
--


-- --------------------------------------------------------

--
-- Structure de la table `pagesBaseData_deleted`
--

DROP TABLE IF EXISTS `pagesBaseData_deleted`;
CREATE TABLE `pagesBaseData_deleted` (
  `id_pbd` int(11) unsigned NOT NULL auto_increment,
  `page_pbd` int(11) unsigned NOT NULL default '0',
  `title_pbd` varchar(150) NOT NULL default '',
  `linkTitle_pbd` varchar(150) NOT NULL default '',
  `keywords_pbd` mediumtext NOT NULL,
  `description_pbd` mediumtext NOT NULL,
  `reminderPeriodicity_pbd` smallint(6) unsigned NOT NULL default '0',
  `reminderOn_pbd` date NOT NULL default '0000-00-00',
  `reminderOnMessage_pbd` mediumtext NOT NULL,
  `category_pbd` varchar(255) NOT NULL default '',
  `author_pbd` varchar(255) NOT NULL default '',
  `replyto_pbd` varchar(255) NOT NULL default '',
  `copyright_pbd` varchar(255) NOT NULL default '',
  `language_pbd` varchar(255) NOT NULL default '',
  `robots_pbd` varchar(255) NOT NULL default '',
  `pragma_pbd` varchar(255) NOT NULL default '',
  `refresh_pbd` varchar(255) NOT NULL default '',
  `redirect_pbd` varchar(255) NOT NULL default '',
  `refreshUrl_pbd` int(1) NOT NULL default '0',
  `url_pbd` varchar(255) NOT NULL default '',
  `metas_pbd` text NOT NULL,
  `codename_pbd` varchar(20) NOT NULL,
  PRIMARY KEY  (`id_pbd`),
  KEY `page_pbd` (`page_pbd`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pagesBaseData_deleted`
--


-- --------------------------------------------------------

--
-- Structure de la table `pagesBaseData_edited`
--

DROP TABLE IF EXISTS `pagesBaseData_edited`;
CREATE TABLE `pagesBaseData_edited` (
  `id_pbd` int(11) unsigned NOT NULL auto_increment,
  `page_pbd` int(11) unsigned NOT NULL default '0',
  `title_pbd` varchar(150) NOT NULL default '',
  `linkTitle_pbd` varchar(150) NOT NULL default '',
  `keywords_pbd` mediumtext NOT NULL,
  `description_pbd` mediumtext NOT NULL,
  `reminderPeriodicity_pbd` smallint(6) unsigned NOT NULL default '0',
  `reminderOn_pbd` date NOT NULL default '0000-00-00',
  `reminderOnMessage_pbd` mediumtext NOT NULL,
  `category_pbd` varchar(255) NOT NULL default '',
  `author_pbd` varchar(255) NOT NULL default '',
  `replyto_pbd` varchar(255) NOT NULL default '',
  `copyright_pbd` varchar(255) NOT NULL default '',
  `language_pbd` varchar(255) NOT NULL default '',
  `robots_pbd` varchar(255) NOT NULL default '',
  `pragma_pbd` varchar(255) NOT NULL default '',
  `refresh_pbd` varchar(255) NOT NULL default '',
  `redirect_pbd` varchar(255) NOT NULL default '',
  `refreshUrl_pbd` int(1) NOT NULL default '0',
  `url_pbd` varchar(255) NOT NULL default '',
  `metas_pbd` text NOT NULL,
  `codename_pbd` varchar(20) NOT NULL,
  PRIMARY KEY  (`id_pbd`),
  KEY `page_pbd` (`page_pbd`),
  FULLTEXT KEY `title_pbd` (`title_pbd`,`linkTitle_pbd`,`keywords_pbd`,`description_pbd`,`codename_pbd`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pagesBaseData_edited`
--

INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(1, 1, 'Automne', 'Automne', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '', '', 'root');

-- --------------------------------------------------------

--
-- Structure de la table `pagesBaseData_public`
--

DROP TABLE IF EXISTS `pagesBaseData_public`;
CREATE TABLE `pagesBaseData_public` (
  `id_pbd` int(11) unsigned NOT NULL auto_increment,
  `page_pbd` int(11) unsigned NOT NULL default '0',
  `title_pbd` varchar(150) NOT NULL default '',
  `linkTitle_pbd` varchar(150) NOT NULL default '',
  `keywords_pbd` mediumtext NOT NULL,
  `description_pbd` mediumtext NOT NULL,
  `reminderPeriodicity_pbd` smallint(6) unsigned NOT NULL default '0',
  `reminderOn_pbd` date NOT NULL default '0000-00-00',
  `reminderOnMessage_pbd` mediumtext NOT NULL,
  `category_pbd` varchar(255) NOT NULL default '',
  `author_pbd` varchar(255) NOT NULL default '',
  `replyto_pbd` varchar(255) NOT NULL default '',
  `copyright_pbd` varchar(255) NOT NULL default '',
  `language_pbd` varchar(255) NOT NULL default '',
  `robots_pbd` varchar(255) NOT NULL default '',
  `pragma_pbd` varchar(255) NOT NULL default '',
  `refresh_pbd` varchar(255) NOT NULL default '',
  `redirect_pbd` varchar(255) NOT NULL default '',
  `refreshUrl_pbd` int(1) NOT NULL default '0',
  `url_pbd` varchar(255) NOT NULL default '',
  `metas_pbd` text NOT NULL,
  `codename_pbd` varchar(20) NOT NULL,
  PRIMARY KEY  (`id_pbd`),
  KEY `page_pbd` (`page_pbd`),
  FULLTEXT KEY `title_pbd` (`title_pbd`,`linkTitle_pbd`,`keywords_pbd`,`description_pbd`,`codename_pbd`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pagesBaseData_public`
--

INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(1, 1, 'Automne', 'Automne', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', 0, '', '', 'root');

-- --------------------------------------------------------

--
-- Structure de la table `pageTemplates`
--

DROP TABLE IF EXISTS `pageTemplates`;
CREATE TABLE `pageTemplates` (
  `id_pt` int(11) unsigned NOT NULL auto_increment,
  `label_pt` varchar(100) NOT NULL default '',
  `groupsStack_pt` varchar(255) NOT NULL default '',
  `modulesStack_pt` varchar(255) NOT NULL default '1',
  `definitionFile_pt` varchar(100) NOT NULL default '',
  `creator_pt` int(11) unsigned NOT NULL default '0',
  `private_pt` tinyint(4) NOT NULL default '0',
  `image_pt` varchar(255) NOT NULL default '',
  `inUse_pt` tinyint(4) unsigned NOT NULL default '0',
  `printingCSOrder_pt` varchar(255) NOT NULL default '',
  `description_pt` text NOT NULL,
  `websitesdenied_pt` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_pt`),
  KEY `definitionFile_pt` (`definitionFile_pt`),
  FULLTEXT KEY `label_pt` (`label_pt`,`description_pt`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pageTemplates`
--

INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(1, 'Splash', 'fr', '', 'splash.xml', 0, 0, 'nopicto.gif', 0, '', 'Modèle vide. Employé pour les pages de redirections.', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(2, 'Exemple', 'fr', 'standard', 'example.xml', 0, 0, 'nopicto.gif', 0, '', 'Modèle d''exemple.', '');

-- --------------------------------------------------------

--
-- Structure de la table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
CREATE TABLE `profiles` (
  `id_pr` int(11) unsigned NOT NULL auto_increment,
  `templateGroupsDeniedStack_pr` varchar(255) NOT NULL default '',
  `rowGroupsDeniedStack_pr` varchar(255) NOT NULL default '',
  `pageClearancesStack_pr` text NOT NULL,
  `moduleClearancesStack_pr` text NOT NULL,
  `validationClearancesStack_pr` text NOT NULL,
  `administrationClearance_pr` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_pr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profiles`
--

INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES(1, '', '', '1,2', 'standard,2;cms_aliases,2;pnews,2;cms_forms,2;ppictures,2', 'standard', 319);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES(3, 'fr;en', '', '1,1', '', '', 0);

-- --------------------------------------------------------

--
-- Structure de la table `profilesUsers`
--

DROP TABLE IF EXISTS `profilesUsers`;
CREATE TABLE `profilesUsers` (
  `id_pru` int(11) unsigned NOT NULL auto_increment,
  `login_pru` varchar(50) NOT NULL default '',
  `password_pru` varchar(32) NOT NULL default '',
  `firstName_pru` varchar(50) NOT NULL default '',
  `lastName_pru` varchar(50) NOT NULL default '',
  `contactData_pru` int(11) unsigned NOT NULL default '0',
  `profile_pru` int(11) unsigned NOT NULL default '0',
  `language_pru` varchar(16) NOT NULL default 'fr',
  `dn_pru` varchar(255) NOT NULL default '',
  `active_pru` tinyint(4) NOT NULL default '0',
  `deleted_pru` tinyint(4) unsigned NOT NULL default '0',
  `alerts_pru` text NOT NULL,
  `favorites_pru` text NOT NULL,
  PRIMARY KEY  (`id_pru`),
  KEY `ldapDN_pru` (`dn_pru`),
  FULLTEXT KEY `login_pru` (`login_pru`,`firstName_pru`,`lastName_pru`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profilesUsers`
--

INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES(1, 'root', '3b0d99b9bb927794036aa828050f364d', '', 'Super Administrator', 1, 1, 'en', '', 1, 0, 'standard,7;pnews,1;pmedia,1', '');
INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES(3, 'anonymous', '294de3557d9d00b3d2d8a1e6aab028cf', '', 'Anonymous User', 3, 3, 'en', '', 1, 0, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `profilesUsersGroups`
--

DROP TABLE IF EXISTS `profilesUsersGroups`;
CREATE TABLE `profilesUsersGroups` (
  `id_prg` int(11) unsigned NOT NULL auto_increment,
  `description_prg` mediumtext NOT NULL,
  `label_prg` varchar(50) NOT NULL default '',
  `profile_prg` int(11) unsigned NOT NULL default '0',
  `dn_prg` varchar(255) NOT NULL default '',
  `invertdn_prg` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id_prg`),
  KEY `ldapDN_prg` (`dn_prg`),
  FULLTEXT KEY `description_prg` (`description_prg`,`label_prg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profilesUsersGroups`
--


-- --------------------------------------------------------

--
-- Structure de la table `profilesUsers_validators`
--

DROP TABLE IF EXISTS `profilesUsers_validators`;
CREATE TABLE `profilesUsers_validators` (
  `id_puv` int(11) NOT NULL auto_increment,
  `userId_puv` int(11) unsigned NOT NULL default '0',
  `module_puv` varchar(100) default NULL,
  PRIMARY KEY  (`id_puv`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profilesUsers_validators`
--


-- --------------------------------------------------------

--
-- Structure de la table `profileUsersByGroup`
--

DROP TABLE IF EXISTS `profileUsersByGroup`;
CREATE TABLE `profileUsersByGroup` (
  `id_gu` int(11) NOT NULL auto_increment,
  `groupId_gu` int(11) NOT NULL default '0',
  `userId_gu` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_gu`),
  KEY `groupId_gu` (`groupId_gu`),
  KEY `userId_gu` (`userId_gu`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profileUsersByGroup`
--


-- --------------------------------------------------------

--
-- Structure de la table `regenerator`
--

DROP TABLE IF EXISTS `regenerator`;
CREATE TABLE `regenerator` (
  `id_reg` int(11) unsigned NOT NULL auto_increment,
  `module_reg` varchar(255) NOT NULL default '0',
  `parameters_reg` text NOT NULL,
  PRIMARY KEY  (`id_reg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `regenerator`
--


-- --------------------------------------------------------

--
-- Structure de la table `resources`
--

DROP TABLE IF EXISTS `resources`;
CREATE TABLE `resources` (
  `id_res` int(11) unsigned NOT NULL auto_increment,
  `status_res` int(11) unsigned NOT NULL default '0',
  `editorsStack_res` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_res`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `resources`
--

INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(1, 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `resourceStatuses`
--

DROP TABLE IF EXISTS `resourceStatuses`;
CREATE TABLE `resourceStatuses` (
  `id_rs` int(11) unsigned NOT NULL auto_increment,
  `location_rs` tinyint(4) unsigned NOT NULL default '1',
  `proposedFor_rs` tinyint(4) unsigned NOT NULL default '0',
  `editions_rs` tinyint(4) unsigned NOT NULL default '0',
  `validationsRefused_rs` tinyint(4) unsigned NOT NULL default '0',
  `publication_rs` tinyint(4) unsigned NOT NULL default '0',
  `publicationDateStart_rs` date NOT NULL default '0000-00-00',
  `publicationDateEnd_rs` date NOT NULL default '0000-00-00',
  `publicationDateStartEdited_rs` date NOT NULL default '0000-00-00',
  `publicationDateEndEdited_rs` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id_rs`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `resourceStatuses`
--

INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(1, 1, 0, 0, 0, 2, '2009-01-01', '0000-00-00', '2009-01-01', '0000-00-00');

-- --------------------------------------------------------

--
-- Structure de la table `resourceValidations`
--

DROP TABLE IF EXISTS `resourceValidations`;
CREATE TABLE `resourceValidations` (
  `id_rv` int(11) unsigned NOT NULL auto_increment,
  `module_rv` varchar(100) NOT NULL default '',
  `editions_rv` int(11) unsigned NOT NULL default '0',
  `resourceID_rv` int(11) unsigned NOT NULL default '0',
  `serializedObject_rv` mediumtext NOT NULL,
  `creationDate_rv` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id_rv`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `resourceValidations`
--


-- --------------------------------------------------------

--
-- Structure de la table `scriptsStatuses`
--

DROP TABLE IF EXISTS `scriptsStatuses`;
CREATE TABLE `scriptsStatuses` (
  `scriptName_ss` varchar(255) NOT NULL default '',
  `launchDate_ss` datetime default NULL,
  `pidFileName_ss` varchar(255) NOT NULL default '',
  `module_ss` varchar(255) NOT NULL default '',
  `parameters_ss` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `scriptsStatuses`
--


-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id_ses` int(11) unsigned NOT NULL auto_increment,
  `phpid_ses` varchar(75) NOT NULL default '',
  `lastTouch_ses` datetime NOT NULL default '0000-00-00 00:00:00',
  `user_ses` int(11) unsigned NOT NULL default '0',
  `remote_addr_ses` varchar(64) NOT NULL,
  `http_user_agent_ses` varchar(255) NOT NULL default '',
  `cookie_expire_ses` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id_ses`),
  KEY `lastTouch_ses` (`lastTouch_ses`),
  KEY `phpid_ses` (`phpid_ses`),
  KEY `user_ses` (`user_ses`),
  KEY `cookie_expire_ses` (`cookie_expire_ses`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sessions`
--


-- --------------------------------------------------------

--
-- Structure de la table `toolbars`
--

DROP TABLE IF EXISTS `toolbars`;
CREATE TABLE `toolbars` (
  `id_tool` int(11) unsigned NOT NULL auto_increment,
  `code_tool` varchar(20) NOT NULL default '',
  `label_tool` varchar(255) NOT NULL default '',
  `elements_tool` text NOT NULL,
  PRIMARY KEY  (`id_tool`),
  KEY `code_tool` (`code_tool`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `toolbars`
--

INSERT INTO `toolbars` (`id_tool`, `code_tool`, `label_tool`, `elements_tool`) VALUES(1, 'Default', 'Default', 'Source|Separator1|ShowBlocks|Separator2|Preview|Templates|Separator3|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Print|Separator5|Undo|Redo|Separator6|Find|Replace|Separator7|SelectAll|RemoveFormat|Separator8|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Table|Rule|SpecialChar|Separator15|Style|FontFormat|FontSize|Separator16|TextColor|BGColor|Separator17|automneLinks|polymod|Image');
INSERT INTO `toolbars` (`id_tool`, `code_tool`, `label_tool`, `elements_tool`) VALUES(2, 'Basic', 'Basic', 'Source|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Table|Rule|SpecialChar|Separator1');
INSERT INTO `toolbars` (`id_tool`, `code_tool`, `label_tool`, `elements_tool`) VALUES(3, 'BasicLink', 'BasicLink', 'Source|Separator1|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Table|Rule|SpecialChar|Separator16|automneLinks|polymod');

-- --------------------------------------------------------

--
-- Structure de la table `websites`
--

DROP TABLE IF EXISTS `websites`;
CREATE TABLE `websites` (
  `id_web` int(11) unsigned NOT NULL auto_increment,
  `codename_web` varchar(255) NOT NULL,
  `label_web` varchar(255) NOT NULL default '',
  `url_web` varchar(255) NOT NULL default '',
  `altdomains_web` text NOT NULL,
  `root_web` int(11) unsigned NOT NULL default '0',
  `keywords_web` mediumtext NOT NULL,
  `description_web` mediumtext NOT NULL,
  `category_web` varchar(255) NOT NULL default '',
  `author_web` varchar(255) NOT NULL default '',
  `replyto_web` varchar(255) NOT NULL default '',
  `copyright_web` varchar(255) NOT NULL default '',
  `language_web` varchar(255) NOT NULL default '',
  `robots_web` varchar(255) NOT NULL default '',
  `favicon_web` varchar(255) NOT NULL default '',
  `metas_web` text NOT NULL,
  `order_web` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_web`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `websites`
--

INSERT INTO `websites` (`id_web`, `codename_web`, `label_web`, `url_web`, `altdomains_web`, `root_web`, `keywords_web`, `description_web`, `category_web`, `author_web`, `replyto_web`, `copyright_web`, `language_web`, `robots_web`, `favicon_web`, `metas_web`, `order_web`) VALUES(1, 'root', 'Site principal', '127.0.0.1', '', 1, '', '', '', '', '', '', 'en', '', '/favicon.ico', '', 1);
