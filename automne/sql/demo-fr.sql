-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny3
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 07 Septembre 2010 à 10:34
-- Version du serveur: 5.0.51
-- Version de PHP: 4.4.4-8+etch6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `automne4_test`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksImages_edited`
--

INSERT INTO `blocksImages_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `label`, `file`, `enlargedFile`, `externalLink`) VALUES(4, 3, 'first', 'a132ad8e6542489be399526940001ee82', 'image', '', 'p3_7333fffc806233ad382709b1af305da0Nenuphars.png', '', '0||||_top||0,0|');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksImages_public`
--

INSERT INTO `blocksImages_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `label`, `file`, `enlargedFile`, `externalLink`) VALUES(4, 3, 'first', 'a132ad8e6542489be399526940001ee82', 'image', '', 'p3_7333fffc806233ad382709b1af305da0Nenuphars.png', '', '0||||_top||0,0|');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksRawDatas_edited`
--

INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(1, 9, 'first', 'aa09fe3cdbc32c9b9b7808a6ae073f604', 'form', 'a:1:{s:6:"formID";s:1:"2";}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(6, 3, 'first', '401937687b65ea5c249faa74f4e23c9a', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"40";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(4, 3, 'first', 'f2c8532eb6f56afe1d435350eebd9a52', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"35";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(5, 3, 'first', '39a32afb98d21c8252ea3714cff0f62e', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"36";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(7, 25, 'first', '267e03d5f6a4d0392b79a2d31dcd40f2', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"25";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(16, 27, 'first', '56025a9b887be03112111d215ca6f31d', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"26";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(9, 28, 'first', '9ba530cba11a3763a081a2e34072711f', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"27";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(10, 35, 'first', '9f851c9d1868ad933f280c33e5a419f3', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"28";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(11, 37, 'first', '3c1cf8ef8f25de1ae96706a2585bffb7', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"29";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(14, 38, 'first', '65990b9ff00394714dd60ffd708b2d77', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"39";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(12, 38, 'first', '4f342492c25a2b686c2b531760008d98', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"38";}}}');
INSERT INTO `blocksRawDatas_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(15, 38, 'first', '48e8e4c2bea88305e6a9353511f51ea7', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"37";}}}');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksRawDatas_public`
--

INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(1, 9, 'first', 'aa09fe3cdbc32c9b9b7808a6ae073f604', 'form', 'a:1:{s:6:"formID";s:1:"2";}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(5, 3, 'first', '39a32afb98d21c8252ea3714cff0f62e', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"36";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(4, 3, 'first', 'f2c8532eb6f56afe1d435350eebd9a52', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"35";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(6, 3, 'first', '401937687b65ea5c249faa74f4e23c9a', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"40";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(7, 25, 'first', '267e03d5f6a4d0392b79a2d31dcd40f2', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"25";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(16, 27, 'first', '56025a9b887be03112111d215ca6f31d', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"26";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(9, 28, 'first', '9ba530cba11a3763a081a2e34072711f', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"27";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(10, 35, 'first', '9f851c9d1868ad933f280c33e5a419f3', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"28";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(11, 37, 'first', '3c1cf8ef8f25de1ae96706a2585bffb7', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"29";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(15, 38, 'first', '48e8e4c2bea88305e6a9353511f51ea7', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"37";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(12, 38, 'first', '4f342492c25a2b686c2b531760008d98', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"38";}}}');
INSERT INTO `blocksRawDatas_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(14, 38, 'first', '65990b9ff00394714dd60ffd708b2d77', 'medias', 'a:1:{s:6:"search";a:1:{s:11:"mediaresult";a:1:{s:4:"item";s:2:"39";}}}');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksTexts_edited`
--

INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(547, 35, 'first', '9f851c9d1868ad933f280c33e5a419f3', 'texte', '<p>Il existe<strong> trois types de droits fondamentaux</strong> :</p> <ul>     <li>Droit d''&eacute;criture &rArr; &eacute;quivaut au <strong>droit d''administration.</strong></li>     <li>Droit de lecture &rArr; &eacute;quivaut au <strong>droit de visibilit&eacute;.</strong></li>     <li>Aucun droit &rArr; l''utilisateur ne peut voir le contenu.</li> </ul>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(465, 33, 'first', '12ea6baf8092e5e6c7abb476cf71ce08', 'texte', '<p style="text-align: left;"><span id="polymod-1-35" class="polymod">\n require_once($_SERVER["DOCUMENT_ROOT"].''/automne/classes/polymodFrontEnd.php'');\necho CMS_poly_definition_functions::pluginCode(''1'', ''35'', '''', true); \n</span></p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(520, 33, 'first', 'adbbb020aeadb2df9957a83e19e55211', 'texte', '<h2>Voici une liste de quelques unes des nouveaut&eacute;s d''Automne 4 :</h2> <ul>     <li style="text-align: left;">Refonte de l''interface administrateur, <strong>plus ergonomique, plus intuitive, plus r&eacute;active.</strong></li>     <li style="text-align: left;">Votre site n''est plus dissoci&eacute; de l''interface d''administration.</li>     <li style="text-align: left;">Vous saisissez et organisez votre contenu simplement, rapidement, sans aucune connaissance technique.</li>     <li style="text-align: left;"><strong>Aide contextuelle</strong> permettant une prise en main encore plus simple.</li>     <li style="text-align: left;">De <strong>meilleures performances</strong> de l''outil.</li>     <li style="text-align: left;">Bas&eacute; sur les technologies du <strong>web 2.0, PHP5, Ajax.</strong></li>     <li style="text-align: left;">Gestion des <strong>langues internationales</strong> - Gestion des alphabets particuliers.</li>     <li style="text-align: left;">Fonction de recherche<strong> Full Text</strong> dans les contenus.</li>     <li style="text-align: left;">...</li> </ul>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(501, 9, 'first', '17a6be4c940c12530cfaecfb2eb6b828', 'texte', '<p>Ce formulaire vous permet d''envoyer une demande de contact. Pour le transformer (Champs, actions, email de destination), modifiez le dans les propri&eacute;t&eacute;s du module &quot;Formulaire&quot;.</p><p>&nbsp;</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(493, 2, 'first', 'a0922acb28a233e527aa46607bfec987c', 'texte', '<p><strong>Automne est votre solution</strong> si vous recherchez un outil de gestion de contenu performant et &eacute;volutif. </p><p>Un outil permettant autonomie et contr&ocirc;le &eacute;ditorial.</p><p>Que votre contenu soit statique ou dynamique avec une gestion en bases de donn&eacute;es, Automne facilite la communication et les &eacute;changes <strong>sans contraintes techniques.<br /></strong></p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(517, 3, 'first', '6ff77816cb91134d254f1b0723fa0022', 'texte', '<h3>Que pouvez-vous faire ?</h3> <p>Vous disposez d&rsquo;un compte utilisateur <strong>&laquo; R&eacute;dacteur &raquo;</strong> qui vous permet d&rsquo;avoir acc&egrave;s &agrave; l&rsquo;interface d''administration d&rsquo;Automne 4 et donc d&rsquo;op&eacute;rer certaines modifications. <strong><br /> </strong></p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(516, 3, 'first', 'f2c8532eb6f56afe1d435350eebd9a52', 'texte', '<h3>Bienvenue sur le site de d&eacute;monstration de la <strong>nouvelle version d&rsquo;Automne 4.</strong></h3><p>Vous trouverez ici <strong>toutes les informations</strong> n&eacute;cessaires &agrave; la d&eacute;couverte de cette version ainsi que les <strong>notions essentielles</strong> pour bien appr&eacute;hender l&rsquo;outil.</p><p>&nbsp;</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(458, 3, 'first', '39a32afb98d21c8252ea3714cff0f62e', 'texte', '<ul><li>modifier, cr&eacute;er et copier des pages.</li><li>g&eacute;rer votre compte utilisateur.</li><li>g&eacute;rer des &eacute;l&eacute;ments des modules.</li><li>&hellip;</li></ul>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(258, 3, 'first', '8be44600466b3bd947f5b2c5cb45bf01', 'texte', '');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(518, 3, 'first', '23ba8857d961fd78dc2ff56bb56e39e7', 'texte', '<h3>Si vous souhaitez disposer d&rsquo;un contr&ocirc;le total, il vous suffit de <a target="_blank" href="http://www.automne.ws/download/">t&eacute;l&eacute;charger</a> la version compl&egrave;te d&rsquo;Automne 4.</h3>  <p>Pour plus d''information, consultez les pages suivantes :</p> <ul>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="29"/></start></selection><noselection>Automne 4</noselection><display><htmltemplate><a href="{{href}}" >Automne 4</a></htmltemplate></display></atm-linx>.</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="33"/></start></selection><noselection>Nouveaut&eacute;s</noselection><display><htmltemplate><a href="{{href}}" >Nouveaut&eacute;s</a></htmltemplate></display></atm-linx>.</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="30"/></start></selection><noselection>Pr&eacute;-requis</noselection><display><htmltemplate><a href="{{href}}" >Pr&eacute;-requis</a></htmltemplate></display></atm-linx>.</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="24"/></start></selection><noselection>Fonctionnalit&eacute;s</noselection><display><htmltemplate><a href="{{href}}" >Fonctionnalit&eacute;s</a></htmltemplate></display></atm-linx>.</li> </ul>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(526, 27, 'first', '56025a9b887be03112111d215ca6f31d', 'texte', '<p>Une des particularit&eacute;s d&rsquo;Automne est le<strong> g&eacute;n&eacute;rateur de module appel&eacute; POLYMOD. </strong></p><p>Il permet de g&eacute;rer des &eacute;l&eacute;ments contenant des donn&eacute;es de types textes, fichiers, images &hellip; Ces donn&eacute;es sont organis&eacute;es entre elles tel que vous le souhaitez et cela sans qu&rsquo;aucune comp&eacute;tence technique ne soit requise.</p><p>Exemple :&nbsp; les modules Actualit&eacute;s et M&eacute;diath&egrave;que fourni dans cette d&eacute;monstration sont enti&egrave;rement <strong>cr&eacute;&eacute;s &agrave; partir de l''interface d''administration</strong> d''Automne 4. Ils peuvent &ecirc;tre modifi&eacute;s pour &ecirc;tre ajust&eacute;s &agrave; ce que vous souhaitez sans aucune difficult&eacute;.</p><p>Le polymod permet aussi de <strong>cr&eacute;er simplement</strong> des flux RSS, des moteurs de recherche c&ocirc;t&eacute; client&hellip;</p><p>Exemple : module de gestion de produits, actualit&eacute;s, m&eacute;diath&egrave;que, annuaire, &hellip;</p> <h3>Il est possible de cr&eacute;er ses propres modules pour r&eacute;aliser des op&eacute;rations bien sp&eacute;cifiques.</h3>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(543, 27, 'first', '4564d92b193505d71f29b5ae69dddde0', 'texte', '<h2>Modules sp&eacute;cifiques</h2> <h3>Automne 4 permet aussi de g&eacute;rer des modules sp&eacute;cifiques que le Polymod ne saurai traiter.</h3><p>Ces modules, cr&eacute;&eacute;s en PHP peuvent alors <strong>r&eacute;aliser tout type d''op&eacute;ration m&eacute;tier complexe </strong>en s''int&eacute;grant parfaitement &agrave; l''interface d''Automne 4. </p><p>Vous pouvez ainsi lier Automne &agrave; vos bases de donn&eacute;es m&eacute;tier ou encore cr&eacute;er des modules de mailing, d''e-commerce, interroger des web services distant et ajouter bien d''autres fonctionnalit&eacute;s encore ...</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(541, 27, 'first', 'f863b4e5ea5a0c8019440ff99e59e29f', 'texte', '<p>Il est possible d''ajouter au noyau logiciel un ensemble de modules pour ajouter des fonctionnalit&eacute;s propres aux besoins de chaque site.</p><p>Par d&eacute;faut Automne 4 contient les modules les plus courants : <strong>M&eacute;diath&egrave;que, Gestion des Actualit&eacute;s, Cr&eacute;ation de formulaires, Cr&eacute;ation d''Alias de pages. </strong></p><h3>Il vous est cependant possible d''ajouter autant de modules suppl&eacute;mentaires que vous le souhaitez !</h3> <h2>G&eacute;n&eacute;rateur de modules&nbsp; POLYMOD</h2>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(192, 5, 'first', '68a1b1d8a072af0eb92f6392eb309ad1', 'texte', '');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(500, 31, 'first', '7448f10ee9579c5f0de5616d06e7b7f2', 'texte', '<p>Voici quelques exemples de modules int&eacute;gr&eacute;s &agrave; cette d&eacute;monstration. Il est possible d''en ajouter d''autres tr&egrave;s simplement ...</p> <p>&nbsp;</p> <h2>Module Actualit&eacute;s</h2> <h3>Permet de publier des actualit&eacute;s soumises &agrave; une date de publication.</h3> <h3>Permet un tri entre, les diff&eacute;rentes cat&eacute;gories d''actualit&eacute;s, possibilit&eacute; d''ajouter des cat&eacute;gories.</h3> <h3>Permet d''effectuer une recherche par mots cl&eacute;s, dates de publication, cat&eacute;gories.</h3> <p><atm-linx type="direct"><selection><start><nodespec type="node" value="5"/></start></selection><noselection>Exemple d''affichage du module Actualit&eacute;s</noselection><display><htmltemplate><a href="{{href}}" >Exemple d''affichage du module Actualit&eacute;s</a></htmltemplate></display></atm-linx></p><p>&nbsp;</p> <h2>Module M&eacute;diath&egrave;que</h2> <h3>Permet de t&eacute;l&eacute;charger diff&eacute;rentes cat&eacute;gories de&nbsp; m&eacute;dia : vid&eacute;o, image, son... dans une base commune.</h3> <h3>Plus fonctionnel que dans ces versions ant&eacute;rieures</h3> <ul>     <li>Permet un tri entre, les diff&eacute;rentes cat&eacute;gories de m&eacute;dias ... possibilit&eacute; de rajouter des cat&eacute;gories.</li>     <li>Permet d''effectuer une recherche par mots cl&eacute;s.</li>     <li>Accessible depuis l''&eacute;diteur Wysiwyg lors de l''&eacute;dition des pages.</li> </ul> <h3>Une fois l''objet dans la base du module, il est r&eacute;utilisable&nbsp; dans les pages et les autres modules autant de fois qu''on le souhaite.</h3> <p><atm-linx type="direct"><selection><start><nodespec type="node" value="6"/></start></selection><noselection>Exemple d''affichage du module M&eacute;diath&egrave;que</noselection><display><htmltemplate><a href="{{href}}" >Exemple d''affichage du module M&eacute;diath&egrave;que</a></htmltemplate></display></atm-linx></p><p>&nbsp;</p> <h2>Module Formulaire</h2> <h3>Permet l''envoi de mail, l''&eacute;criture dans une base de donn&eacute;es, l''identification des utilisateurs, de r&eacute;colter des avis, de faire des sondages ...</h3> <h3>Un assistant de cr&eacute;ation de formulaire vous aidera &agrave; mettre en place des formulaires tout aussi simple que complexes.</h3> <p><atm-linx type="direct"><selection><start><nodespec type="node" value="9"/></start></selection><noselection>Exemple d''affichage du module Formulaire</noselection><display><htmltemplate><a href="{{href}}" >Exemple d''affichage du module Formulaire</a></htmltemplate></display></atm-linx></p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(301, 3, 'first', '409d0a2f5060ddb2747151da5e264f99', 'texte', '<h2>Un acc&eacute;s<strong> </strong>TOTAL</h2>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(300, 3, 'first', 'c44b397b36f4839fd7bba0c769b5e56e', 'texte', '<p>&nbsp;</p> <h2>Vos droits sur ce site</h2>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(463, 3, 'first', '401937687b65ea5c249faa74f4e23c9a', 'texte', '<h3>Vous ne pouvez pas:</h3> <ul>     <li>administrer les modules.</li>     <li>valider la modification des pages.</li>     <li>ou encore cr&eacute;er de nouveaux comptes utilisateurs.</li>     <li>...</li> </ul> <p>Ces fonctionnalit&eacute;s sont r&eacute;serv&eacute;es &agrave; un compte utilisateur de type&nbsp;  <strong>&laquo; Administrateur &raquo;.</strong></p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(522, 30, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h3>L''installation / utilisation d''Automne 4 n&eacute;cessite certains  pr&eacute;-requis :</h3> <h2>Pr&eacute;-requis techniques obligatoires</h2> <h3>Serveur Linux, Windows, Max OSX, Solaris, BSD, ou tout autre syst&egrave;me syst&egrave;me Unix permettant de faire tourner les trois outils suivant sur lesquels repose Automne :</h3>    <ul><li>Serveur <a href="http://httpd.apache.org/">Apache</a>.</li><li><a href="http://www.php.net/">PHP 5.2.x</a>. Pour des raisons de s&eacute;curit&eacute; nous recommandons la derni&egrave;re version de la branche 5.x.<ul><li>Extension GD disponible pour PHP (permet le <a href="http://www.php.net/manual/fr/ref.image.php">traitement des images</a>) avec les librairies JPEG, GIF et PNG.</li><li>Option &quot;<a href="http://fr2.php.net/manual/fr/features.safe-mode.php">safe_mode</a>&quot; de PHP d&eacute;sactiv&eacute;e.</li><li>32 &agrave; 64Mo de m&eacute;moire allou&eacute; aux scripts PHP (en fonction du nombre d''extensions install&eacute;es sur PHP : plus d''extensions n&eacute;cessite plus de m&eacute;moire).</li></ul></li><li><a href="http://www.mysql.com/">MySQL 5.x .</a></li></ul>  <h3>Pour l''admnistration d''Automne : Internet Explorer 7, Firefox 3, Safari 3, Google Chrome, Opera 9</h3><p>Les pr&eacute;-requis en terme de navigateur du site public d&eacute;pendent des mod&egrave;les utilis&eacute;s pour cr&eacute;er les pages.</p> <p>&nbsp;</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(512, 38, 'first', '4f342492c25a2b686c2b531760008d98', 'texte', '<p>L''aide contextuelle vous permet d<strong>''obtenir des informations</strong> sur les &eacute;l&eacute;ments que vous pointez avec votre curseur.</p> <h3>PLUS aucun bouton n''aura de secret pour vous !</h3>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(532, 38, 'first', '65990b9ff00394714dd60ffd708b2d77', 'texte', '<p>Enfin, si vous cherchez comment modifier tel contenu ou &eacute;l&eacute;ment g&eacute;r&eacute; par Automne 4et que vous ne savez pas comment l''atteindre dans l''interface d''administration, <strong>un puissant moteur de recherche</strong> <strong>vous permet de rechercher sur l''ensemble des contenus et des &eacute;l&eacute;ments, </strong>quel que soit leurs type : Contenu des pages, contenu des modules, utilisateurs, mod&egrave;les de pages et de rang&eacute;es, etc.</p> <h3>Les r&eacute;sultats fournis par ce moteur s''adapteront m&ecirc;me au niveau de droit de l''utilisateur pour ne lui proposer que les &eacute;l&eacute;ments sur lesquels il peut agir.</h3>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(531, 38, 'first', '48e8e4c2bea88305e6a9353511f51ea7', 'texte', '<p>Cette aide vous apporte <strong>l''ensemble des points essentiels pour la d&eacute;finition de vos propres rang&eacute;es de contenu.</strong></p> <p>Elle d&eacute;taille les tags XML et les variables pouvant &ecirc;tre utilis&eacute;es ainsi que leurs fonctions.</p> <p>L''insertion des modules dans vos rang&eacute;es est document&eacute;e de la m&ecirc;me mani&egrave;re.</p> <h3>Cr&eacute;er ses propres rang&eacute;es de contenu devient extr&ecirc;mement simple !</h3>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(529, 38, 'first', '8d1b3ec256dada4f0c811896050fdc9f', 'texte', '<p>Les utilisateurs d''Automne 4 peuvent parfois &ecirc;tre confront&eacute;s &agrave; des questions sur l''utilisation de l''outil. &quot;<em>Que ce passe t''il si je clique sur ce bouton ?</em>&quot; &quot;<em>comment dois je r&eacute;aliser telle modification ?</em>&quot;.</p> <h3>Pour r&eacute;pondre &agrave; ces questions courantes, nous avons mis en place un&nbsp; NOUVEAU syst&egrave;me d''aide complet int&eacute;gr&eacute; &agrave; toutes les interfaces d''administration :</h3>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(548, 35, 'first', '718dfb04e3bd006a81604b9ccdf448cf', 'texte', '<p>Automne 4 dispose d''un <strong>syst&egrave;me intelligent de gestion des droits des utilisateurs.</strong> Il permet une gestion fine des droits, tant dans les diff&eacute;rentes pages que dans les contenus des diff&eacute;rents modules. Ce syst&egrave;me permet d''appliquer l''ensemble de ces droits sur tout types d''&eacute;l&eacute;ments g&eacute;r&eacute;s par Automne 4.</p> <p>Ces droits peuvent &ecirc;tre attribu&eacute;s sur les pages mais aussi sur les modules, les mod&egrave;les de pages, les rang&eacute;es de contenu,&nbsp; et sur toutes les grandes actions d''administration... L''ensemble de ces droits sont <strong>applicables aux utilisateurs et aux groupes d''utilisateurs</strong> ayant acc&egrave;s au site.</p> <h3>Il existe un <strong>droit particulier</strong> intitul&eacute; <atm-linx type="direct"><selection><start><nodespec type="node" value="37"/></start></selection><noselection>droit de validation.</noselection><display><htmltemplate><a href="{{href}}" >droit de validation.</a></htmltemplate></display></atm-linx></h3> <p>Ce droit permet de donner &agrave; l''utilisateur la possibilit&eacute; de valider le travail des autres utilisateurs pour publier le contenu sur le site en ligne.</p> <h3>Quelques exemples de droits utilisateurs :</h3> <ul>     <li><em>L''utilisateur A peut avoir des droits d''administrations sur certaines pages et un droit limit&eacute; sur les mod&egrave;les de pages. Ce qui lui permettra de ne cr&eacute;er que des pages utilisant les mod&egrave;les qu''il peut utiliser.</em></li>     <li><em>L''utilisateur B peut avoir les droits d''administration sur la cat&eacute;gorie Fran&ccedil;aise des actualit&eacute;s et uniquement le droit de visibilit&eacute; sur la cat&eacute;gorie Anglaise des actualit&eacute;s. Il ne pourra ainsi modifier que les actualit&eacute;s Fran&ccedil;aise du site.</em></li>     <li><em>L''utilisateur C peut avoir les droits d''administrations sur le module m&eacute;diath&egrave;que mais aucun droit sur les actualit&eacute;s et les pages du site. Il ne pourra donc que g&eacute;rer les &eacute;l&eacute;ments de la m&eacute;diath&egrave;que que d''autres utilisateurs pourront ensuite utiliser dans les actualit&eacute;s ou les pages du site.</em></li> </ul> <p>Bien entendu vous pouvez sp&eacute;cifier finement tous les droits que vous souhaitez et vous pouvez m&ecirc;me <strong>cr&eacute;er des groupes d''utilisateur comportant des droits sp&eacute;cifiques</strong> qui seront additionn&eacute; aux utilisateurs appartenant &agrave; diff&eacute;rents groupes.</p> <h3>Gestion de droits par groupes d''utilisateurs :</h3> <p>Vous avez six groupes utilisateurs distinct :</p> <ul>     <li>Administration des Actualit&eacute;s <em>Fran&ccedil;aises</em></li>     <li>Administration des Actualit&eacute;s <em>Anglaises</em></li>     <li>Administration des Pages du site <em>Fran&ccedil;ais</em> et droit sur les mod&egrave;les <em>Fran&ccedil;ais</em></li>     <li>Administration des Pages du site <em>Anglais</em> et droit sur les mod&egrave;les <span style="font-style: italic;">Anglais</span></li>     <li>Validation des modifications sur les <em>Actualit&eacute;s</em></li>     <li>Validation des modifications sur les <em>Pages</em></li> </ul> <p><strong>En associant un ou plusieurs de ces groupes &agrave; des utilisateurs</strong>, vous leur donnerez simplement les droits correspondants vous permettant ainsi de <strong>cr&eacute;er et de g&eacute;rer simplement </strong>des combinaisons plus ou moins complexe de droits d''administration.</p> <p>De plus, dans le cas de <strong>sites Extranet ou Intranet</strong>, vous pouvez aussi r&eacute;aliser ce type de combinaison sur le <strong>droit de visibilit&eacute;</strong> des diff&eacute;rents contenus du site, permettant ainsi de cr&eacute;er des <strong>zones de contenu s&eacute;curis&eacute;es sur votre site</strong>.</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(545, 28, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h2>Principe de gestion d''utilisateur</h2><p>Lors de la cr&eacute;ation d&rsquo;un site avec Automne 4, un utilisateur privil&eacute;gi&eacute; dit <atm-linx type="direct"><selection><start><nodespec type="node" value="35"/></start></selection><noselection>&laquo; Super Administrateur &raquo;</noselection><display><htmltemplate><a href="{{href}}" >&laquo; Super Administrateur &raquo;</a></htmltemplate></display></atm-linx> poss&egrave;de <strong>tous les droits sur l&rsquo;application.</strong></p> <p>Ce super administrateur a alors la possibilit&eacute; de cr&eacute;er des utilisateurs ainsi que des groupes d&rsquo;utilisateurs. Chacun dispose de droits sur certaines fonctionnalit&eacute;s de l&rsquo;application. Les groupes par d&eacute;faut sont : administrateur, validateur et r&eacute;dacteur.&nbsp;</p><p>Les r&eacute;dacteurs n''auront alors &agrave; leurs disposition que les outils qui leurs sont n&eacute;cessaires. Leurs interventions seront ainsi limit&eacute;s &agrave; leurs besoins.</p><p>Il est aussi possible, gr&acirc;ce au <atm-linx type="direct"><selection><start><nodespec type="node" value="37"/></start></selection><noselection>processus de workflow</noselection><display><htmltemplate><a href="{{href}}" >processus de workflow</a></htmltemplate></display></atm-linx> de soumettre les donn&eacute;es saisies &agrave; la validation d''une autorit&eacute; sup&eacute;rieure. Ainsi le contenu pourra &ecirc;tre v&eacute;rifi&eacute; avant sa mise en ligne.</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(551, 37, 'first', '3c1cf8ef8f25de1ae96706a2585bffb7', 'texte', '<h3>Un syst&egrave;me d''alerte email automatique informe les validateurs des modifications qui ont &eacute;t&eacute; op&eacute;r&eacute; sur le site.&nbsp;</h3> <p>Le validateur peut alors v&eacute;rifier les modifications faites sur le contenu et les accepter, les refuser ou les modifier.</p> <p>Un syst&egrave;me d''ic&ocirc;nes simple et clair permet &agrave; tout moment de connaitre le statut des &eacute;l&eacute;ments : si ils sont publi&eacute;s, d&eacute;publi&eacute;s, ou attente d''une validation.</p> <p>La publication en ligne des modifications n''est effective que lorsqu''elles sont approuv&eacute;es par le validateur. Ce droit particulier est param&eacute;trable dans la <atm-linx type="direct"><selection><start><nodespec type="node" value="28"/></start></selection><noselection>gestion des utilisateurs.</noselection><display><htmltemplate><a  href="{{href}}">gestion des utilisateurs.</a></htmltemplate></display></atm-linx></p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(523, 30, 'first', 'dda8207197eda19c8be4b1f63d76b382', 'texte', '<h2>Pr&eacute;-requis conseill&eacute;s</h2><ul><li>PHP install&eacute; sous forme de module Apache (la version CGI offre des performances moindres).</li><li><a href="http://fr.php.net/manual/fr/features.commandline.php">Module CLI de PHP install&eacute; </a>et disponible sur le serveur ainsi que les fonctions &quot;<a href="http://fr.php.net/system">system</a>&quot; et &quot;<a href="http://fr2.php.net/manual/fr/function.exec.php">exec</a>&quot; de PHP pour profiter des scripts en tache de fond.</li><li>Option<a href="http://fr2.php.net/manual/fr/ref.info.php#ini.magic-quotes-gpc"> &quot;magic_quotes_gpc&quot;</a> de PHP d&eacute;sactiv&eacute;e.</li><li>Apache doit avoir le droit de cr&eacute;er et de modifier l&rsquo;ensemble des fichiers d''Automne sur le serveur pour profiter du syst&egrave;me d&rsquo;installation et de mise &agrave; jour automatique. Sans cela, certaines parties de l&rsquo;installation et des mises &agrave; jour devront &ecirc;tre effectu&eacute;es manuellement.</li><li>Un cache de code PHP (opcode cache) tel que <a href="http://pecl.php.net/package/APC">APC</a> ou <a href="http://www.zend.com/products/zend_optimizer">Zend optimizer </a>est un plus pour les performances.</li><li>Certaines fonctionnalit&eacute;s d&rsquo;Automne (telle que la g&eacute;n&eacute;ration des pages du site) peuvent n&eacute;cessiter plus de m&eacute;moire vive (en particulier si vous avez compil&eacute; PHP avec un tr&egrave;s grand nombre d''extensions). En r&egrave;gle g&eacute;n&eacute;rale il est pr&eacute;f&eacute;rable de laisser PHP g&eacute;rer lui m&ecirc;me la m&eacute;moire vive allou&eacute; aux scripts en permettant l''usage de la fonction<a href="http://fr2.php.net/manual/fr/ini.core.php#ini.memory-limit"> &quot;memory_limit&quot;</a>.</li></ul><h3>Pour des raisons de performance, nous recommandons l&rsquo;usage d&rsquo;un serveur Linux ou Unix en production.</h3><h3>Du fait de l&rsquo;emploi de fichiers .htaccess, le serveur Apache est fortement conseill&eacute;.</h3>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(530, 25, 'first', 'f87771b9821f911d00f29d8d494a055b', 'texte', '<h2>Principe de mod&egrave;les de pages</h2> <p>Un principe fondamental des CMS est la <strong>s&eacute;paration entre le contenu et la pr&eacute;sentation.</strong> Autrement dit, le graphisme et l&rsquo;information contenu dans un site sont totalement ind&eacute;pendant l&rsquo;un de l&rsquo;autre.</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(554, 28, 'first', '9ba530cba11a3763a081a2e34072711f', 'texte', '<h3>Les utilisateurs peuvent cr&eacute;er d''autres utilisateurs ou groupes d''utilisateurs si et seulement si ils en ont les droits.</h3> <h3>Les utilisateurs appartenant &agrave; un groupe disposent des droits attribu&eacute;s au groupe.</h3>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(553, 25, 'first', '508f7be6da1c7022ae3df00f30190e49', 'texte', '<p>Lors de la cr&eacute;ation du mod&egrave;le de page, on d&eacute;termine, par l<strong>&rsquo;insertion de tags XML,</strong> l&rsquo;emplacement des zones modifiables et la logique des liens permettant la navigation entre les pages du site.</p> <p>Les mod&egrave;les servent alors &agrave; cr&eacute;er les diff&eacute;rentes pages employ&eacute;es par le site.</p> <p>Les zones modifiables des mod&egrave;les permettent de d&eacute;limiter les positions du contenu dans les pages ce qui permet de limiter volontairement les zones d''intervention des r&eacute;dacteurs des pages.</p> <p>Ce principe permet de s''assurer d''une <strong>pr&eacute;sentation homog&egrave;ne de toutes les pages du site.</strong></p> <p>Seules les personnes disposant des <atm-linx type="direct"><selection><start><nodespec type="node" value="35"/></start></selection><noselection>droits </noselection><display><htmltemplate><a  href="{{href}}">droits </a></htmltemplate></display></atm-linx>suffisants pourront ensuite ajouter / modifier de l&rsquo;information dans les pages par l&rsquo;interm&eacute;diaire des <atm-linx type="direct"><selection><start><nodespec type="node" value="26"/></start></selection><noselection>rang&eacute;es de contenu</noselection><display><htmltemplate><a  href="{{href}}">rang&eacute;es de contenu</a></htmltemplate></display></atm-linx> qui s''ins&egrave;rent dans les zones modifiables d&eacute;finies.</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(552, 26, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h2>Principe de rang&eacute;es de contenu</h2> <p>Les rang&eacute;es de contenu sont les gabarits qui contiennent l&rsquo;information. <strong>Elles peuvent contenir tous types d&rsquo;informations :</strong> texte, image, flash, vid&eacute;o&hellip; Par exemple, des rang&eacute;es titres, sous-titres, textes, textes et image &agrave; droite sont certaines des rang&eacute;es par d&eacute;faut d''Automne.</p> <p>Une rang&eacute;e est pr&eacute;-format&eacute;e. Cela permet de conserver l''homog&eacute;n&eacute;it&eacute; de la pr&eacute;sentation du site Internet.</p> <h3>Il vous est possible de cr&eacute;er vos propres rang&eacute;es avec le type d&rsquo;information que vous souhaitez.</h3> <p style="text-align: center;"><span id="polymod-1-24" class="polymod">\n require_once($_SERVER["DOCUMENT_ROOT"].''/automne/classes/polymodFrontEnd.php'');\necho CMS_poly_definition_functions::pluginCode(''1'', ''24'', '''', true); \n</span>  <span id="polymod-1-34" class="polymod">\n require_once($_SERVER["DOCUMENT_ROOT"].''/automne/classes/polymodFrontEnd.php'');\necho CMS_poly_definition_functions::pluginCode(''1'', ''34'', '''', true); \n</span></p> <h3>L''organisation des rang&eacute;es dans une page est particuli&egrave;rement simple. Vous pouvez les glisser-d&eacute;poser &agrave; l''endroit ou vous le souhaitez.</h3> <p>Les zones de saisies sont clairement indiqu&eacute;es et vous pouvez modifier l''ensemble du contenu tr&egrave;s simplement &agrave; l''aide <strong>d''outils de mise en forme tr&egrave;s intuitifs :</strong> mise en forme des textes &agrave; l''aide de <strong>l''&eacute;diteur WYSIWYG,</strong> redimensionner et recadrer des images, cr&eacute;er des liens vers d''autres sites ou vers une page donn&eacute;e de votre site.</p> <p>Vous pouvez m&ecirc;me d&eacute;cider <strong>d''importer le contenu de vos modules &agrave; n''importe quel endroit de vos textes.</strong> Si le contenu du module vient &agrave; disparaitre (suppression, d&eacute;publication, ...), il disparaitra <strong>simplement et sans erreur</strong> de tous les textes ou vous y faite r&eacute;f&eacute;rence.</p>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(1, 29, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h2>Syst&egrave;me de gestion de contenu</h2> <p>Automne est un outil <a href="http://fr.wikipedia.org/wiki/Open_source"><strong>OPEN SOURCE</strong>,</a> performant et ergonomique. C''est un <strong>syst&egrave;me de gestion de contenu (CMS)</strong> <strong>professionnel</strong> d&eacute;di&eacute; aux entreprises, aux organismes public et aux associations de toutes tailles .</p> <h3>Automne 4 offre un <strong>environnement s&eacute;curis&eacute; </strong>et<strong> collaboratif</strong> pour g&eacute;rer les pages web et les applications dynamiques.</h3> <p>&nbsp;</p> <h2>Performant et &eacute;volutif</h2> <p>Robuste pour sa capacit&eacute; de g&eacute;rer plusieurs milliers de pages avec un <strong>langage orient&eacute; objet.</strong> Automne 4 <strong>respecte</strong> <strong>les normes et recommandations du w3c</strong> ainsi que les <strong>nouvelles r&egrave;gles d&rsquo;accessibilit&eacute;.</strong></p> <p>Dot&eacute; d''un cr&eacute;ateur de <atm-linx type="direct"><selection><start><nodespec type="node" value="27"/></start></selection><noselection>modules dynamiques</noselection><display><htmltemplate><a  href="{{href}}">modules dynamiques</a></htmltemplate></display></atm-linx>, vous pourrez <strong>enrichir</strong> les <atm-linx type="direct"><selection><start><nodespec type="node" value="24"/></start></selection><noselection>fonctionnalit&eacute;s de votre site Internet</noselection><display><htmltemplate><a  href="{{href}}">fonctionnalit&eacute;s de votre site Internet</a></htmltemplate></display></atm-linx> selon vos besoins.</p> <p>&nbsp;</p> <h2>Web et plus</h2> <p>Automne 4 vous permet de <strong>cr&eacute;er et de g&eacute;rer votre site Internet, Extranet ou Intranet.</strong> Il permet de cr&eacute;er des sites Internet institutionnels de qualit&eacute; professionnelle tr&egrave;s rapidement mais aussi de<strong> r&eacute;aliser les applications web</strong> les plus &eacute;volu&eacute;es. Tout cela en restant dans un <strong>contexte simple et intuitif</strong> qui n''offre &agrave; ses utilisateurs que les fonctionnalit&eacute;s qu''ils ont le droit d''employer.</p> <p><em><br /> </em></p> <h2>P&eacute;r&eacute;nit&eacute; et s&eacute;curit&eacute;</h2> <h3>Automne existe depuis 1999. Parmi les premier CMS du march&eacute;, il a su &eacute;voluer en m&ecirc;me temps qu''Internet. Utilis&eacute; depuis ses d&eacute;buts par des professionnels, pour des professionnels, il offre des fonctionnalit&eacute;s cibl&eacute;es aux besoins des entreprises.</h3> <p>Vous &ecirc;tes assur&eacute;s d''avoir des mises &agrave; jour r&eacute;guli&egrave;res et de pouvoir employer ces mises &agrave; jour sur votre site sans difficult&eacute;s.</p> <h3>Le noyaux d''Automne 4 est d&eacute;velopp&eacute; par des professionnels certifi&eacute;s poss&eacute;dant plusieurs ann&eacute;es d''exp&eacute;rience en PHP. Tous les d&eacute;veloppement sont v&eacute;rifi&eacute;s et respectent un haut niveau de qualit&eacute; et de s&eacute;curit&eacute;.</h3> <p>Automne 4 est <strong>gratuit et librement t&eacute;l&eacute;chargeable</strong> sur <a target="_blank" href="http://sourceforge.net/projects/automne/">Sourceforge</a>. Il emploie des technologies Open Source ind&eacute;pendantes ce qui vous assure de pouvoir l''utiliser longtemps sans d&eacute;pendre d''une entreprise &eacute;ditrice.</p> <p>Par ailleurs, vous disposez d''un <a target="_blank" href="http://www.automne.ws/forum/">forum communautaire</a> pour signaler tout probl&egrave;me que vous rencontreriez.</p> <h3><strong>Il vous est aussi possible d''obtenir un support et des formations dispens&eacute;s par des professionnels. Pour plus d''information, rendez vous sur </strong><a target="_blank" href="http://www.automne.ws"><strong>le site d''Automne</strong></a><strong>.</strong></h3>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(2, 24, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h2>Vous trouverez dans cette partie les grands principes d&rsquo;utilisations d''Automne 4.</h2> <p>Syst&egrave;me de gestion de contenu puissant, Automne 4 permet de g&eacute;rer des sites de plusieurs milliers de pages, d''en <strong>modifier simplement l''apparence</strong> gr&acirc;ce aux <atm-linx type="direct"><selection><start><nodespec type="node" value="25"/></start></selection><noselection>mod&egrave;les de pages</noselection><display><htmltemplate><a  href="{{href}}">mod&egrave;les de pages</a></htmltemplate></display></atm-linx> et de modifier intuitivement le contenu gr&acirc;ce au principe des <atm-linx type="direct"><selection><start><nodespec type="node" value="26"/></start></selection><noselection>rang&eacute;es de contenu.</noselection><display><htmltemplate><a  href="{{href}}">rang&eacute;es de contenu.</a></htmltemplate></display></atm-linx></p> <p>Les nombreuses fonctionnalit&eacute;s pour le site Internet, simples ou complexes, peuvent &ecirc;tre <span style="font-weight: bold;">g&eacute;n&eacute;r&eacute;es</span><strong> automatiquement par le g&eacute;n&eacute;rateur de module appel&eacute; </strong><atm-linx type="direct"><selection><start><nodespec type="node" value="27"/></start></selection><noselection><strong>POLYMOD</strong></noselection><display><htmltemplate><a  href="{{href}}"><strong>POLYMOD</strong></a></htmltemplate></display></atm-linx> ou bien d&eacute;velopp&eacute;es directement en code PHP.</p> <p>Automne 4 dispose d''un syst&egrave;me de <atm-linx type="direct"><selection><start><nodespec type="node" value="28"/></start></selection><noselection>gestion des utilisateurs</noselection><display><htmltemplate><a  href="{{href}}">gestion des utilisateurs</a></htmltemplate></display></atm-linx> et <atm-linx type="direct"><selection><start><nodespec type="node" value="28"/></start></selection><noselection>groupes d''utilisateurs</noselection><display><htmltemplate><a  href="{{href}}">groupes d''utilisateurs</a></htmltemplate></display></atm-linx> particuli&egrave;rement &eacute;volu&eacute; permettant une <atm-linx type="direct"><selection><start><nodespec type="node" value="35"/></start></selection><noselection>gestion tr&egrave;s fine des droits.</noselection><display><htmltemplate><a  href="{{href}}">gestion tr&egrave;s fine des droits.</a></htmltemplate></display></atm-linx> Votre environnement de travail est homog&egrave;ne et ne pr&eacute;sente que les fonctionnalit&eacute;s sur lesquelles vous avez le droit d''agir.</p> <h3>Vous trouverez un descriptif des principales fonctions d''Automne 4 dans les pages ci-dessous :</h3> <ul>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="25"/></start></selection><noselection>Mod&egrave;les de pages</noselection><display><htmltemplate><a  href="{{href}}">Mod&egrave;les de pages</a></htmltemplate></display></atm-linx> (l''habillage graphique du site Internet),</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="26"/></start></selection><noselection>Rang&eacute;es de contenu</noselection><display><htmltemplate><a  href="{{href}}">Rang&eacute;es de contenu</a></htmltemplate></display></atm-linx> (l''habillage de vos contenus et m&eacute;dias),</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="27"/></start></selection><noselection>Modules dynamiques</noselection><display><htmltemplate><a  href="{{href}}">Modules dynamiques</a></htmltemplate></display></atm-linx> (vos outils personnalis&eacute;s et applications d&eacute;di&eacute;es),</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="28"/></start></selection><noselection>Gestion des utilisateurs et des groupes d''utilisateurs</noselection><display><htmltemplate><a  href="{{href}}">Gestion des utilisateurs et des groupes d''utilisateurs</a></htmltemplate></display></atm-linx>,</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="35"/></start></selection><noselection>Gestion des droits d''acc&egrave;s</noselection><display><htmltemplate><a  href="{{href}}">Gestion des droits d''acc&egrave;s</a></htmltemplate></display></atm-linx>,</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="37"/></start></selection><noselection>Workflow de publication des contenus</noselection><display><htmltemplate><a  href="{{href}}">Workflow de publication des contenus</a></htmltemplate></display></atm-linx>,</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="38"/></start></selection><noselection>Aide aux utilisateurs</noselection><display><htmltemplate><a  href="{{href}}">Aide aux utilisateurs</a></htmltemplate></display></atm-linx>,</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="34"/></start></selection><noselection>Fonctions avanc&eacute;es</noselection><display><htmltemplate><a  href="{{href}}">Fonctions avanc&eacute;es</a></htmltemplate></display></atm-linx>.</li> </ul>');
INSERT INTO `blocksTexts_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(3, 34, 'first', '592c2e33c7971c02ec553000d0eaea43', 'texte', '<h2>Gestion Multi-sites</h2> <p>Une seule et m&ecirc;me interface d''Automne 4 peut g&eacute;rer autant de sites diff&eacute;rents que vous le souhaitez. Chacun peut poss&eacute;der son propre nom de domaine, sa propre langue et ses propres &eacute;l&eacute;ments (mod&egrave;les de pages, rang&eacute;es) permettant de g&eacute;rer les diff&eacute;rentes pages qui les composent.</p> <p>&nbsp;</p> <h2>S&eacute;curiser l''acc&egrave;s au contenu cot&eacute; public des sites (Intranet / Extranet)</h2> <p>Ce syst&egrave;me &eacute;volu&eacute; de gestion des droits permet de r&eacute;aliser des <strong>espaces s&eacute;curis&eacute;s</strong> sur vos sites. Par l&rsquo;interm&eacute;diaire d&rsquo;un Nom d''utilisateur et d''un mot de de passe, votre site Internet se transforme en <strong>site Extranet </strong>appliquant ainsi des <strong>droits et restrictions</strong> sur certaines pages et certains contenus que vous sp&eacute;cifiez. Les restrictions mises en place sont <strong>invisibles </strong>&agrave; ceux qui ne poss&egrave;dent pas les droits de les voir &eacute;vitant ainsi toute frustration de vos utilisateurs.<strong><br /> </strong></p> <h3>Exemple : celui qui n&rsquo;a pas acc&egrave;s &agrave; la page &laquo; ressource &raquo; ne verra pas cet &eacute;l&eacute;ment dans la navigation.</h3> <p>&nbsp;</p> <h2>Connexion LDAP</h2> <p>L''int&eacute;r&ecirc;t principal d''un annuaire LDAP est la <strong>normalisation de l''authentification.</strong> Cet annuaire regroupe toutes les informations de type de l&rsquo;utilisateur (nom, pr&eacute;nom, services, postes &hellip;etc).  Automne 4 permet de r&eacute;cup&eacute;rer automatiquement les informations de l&rsquo;annuaire afin de d&eacute;finir les utilisateurs et leurs droits. &laquo; Le salari&eacute; travaillant au service des ressources humaines, aura automatiquement acc&egrave;s &agrave; la page ressource humaine, l&agrave; o&ugrave; d&rsquo;autres n&rsquo;y auront pas acc&egrave;s &raquo;.</p> <h3>Lors de l&rsquo;ouverture de session, les identifiants et mot de passe sont envoy&eacute;es &agrave; cet annuaire qui transmet alors les informations de l&rsquo;utilisateur.</h3> <p>&nbsp;</p> <h2>SSO (single Sign On)</h2> <p><strong>L''authentification unique</strong> est une m&eacute;thode permettant &agrave; un utilisateur de ne proc&eacute;der qu''&agrave; une seule authentification pour acc&eacute;der &agrave; plusieurs applications informatiques (ou sites web s&eacute;curis&eacute;s). Automne 4 dispose aujourd&rsquo;hui de cette technologie et les utilisateurs pourront directement &ecirc;tre connect&eacute;s &agrave; l&rsquo;interface d''Automne 4 d&eacute;s l&rsquo;ouverture de session sur leur machine.</p> <h3>Plus besoin de s''authentifier &agrave; Automne 4.</h3>');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksTexts_public`
--

INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(500, 31, 'first', '7448f10ee9579c5f0de5616d06e7b7f2', 'texte', '<p>Voici quelques exemples de modules int&eacute;gr&eacute;s &agrave; cette d&eacute;monstration. Il est possible d''en ajouter d''autres tr&egrave;s simplement ...</p> <p>&nbsp;</p> <h2>Module Actualit&eacute;s</h2> <h3>Permet de publier des actualit&eacute;s soumises &agrave; une date de publication.</h3> <h3>Permet un tri entre, les diff&eacute;rentes cat&eacute;gories d''actualit&eacute;s, possibilit&eacute; d''ajouter des cat&eacute;gories.</h3> <h3>Permet d''effectuer une recherche par mots cl&eacute;s, dates de publication, cat&eacute;gories.</h3> <p><atm-linx type="direct"><selection><start><nodespec type="node" value="5"/></start></selection><noselection>Exemple d''affichage du module Actualit&eacute;s</noselection><display><htmltemplate><a href="{{href}}" >Exemple d''affichage du module Actualit&eacute;s</a></htmltemplate></display></atm-linx></p><p>&nbsp;</p> <h2>Module M&eacute;diath&egrave;que</h2> <h3>Permet de t&eacute;l&eacute;charger diff&eacute;rentes cat&eacute;gories de&nbsp; m&eacute;dia : vid&eacute;o, image, son... dans une base commune.</h3> <h3>Plus fonctionnel que dans ces versions ant&eacute;rieures</h3> <ul>     <li>Permet un tri entre, les diff&eacute;rentes cat&eacute;gories de m&eacute;dias ... possibilit&eacute; de rajouter des cat&eacute;gories.</li>     <li>Permet d''effectuer une recherche par mots cl&eacute;s.</li>     <li>Accessible depuis l''&eacute;diteur Wysiwyg lors de l''&eacute;dition des pages.</li> </ul> <h3>Une fois l''objet dans la base du module, il est r&eacute;utilisable&nbsp; dans les pages et les autres modules autant de fois qu''on le souhaite.</h3> <p><atm-linx type="direct"><selection><start><nodespec type="node" value="6"/></start></selection><noselection>Exemple d''affichage du module M&eacute;diath&egrave;que</noselection><display><htmltemplate><a href="{{href}}" >Exemple d''affichage du module M&eacute;diath&egrave;que</a></htmltemplate></display></atm-linx></p><p>&nbsp;</p> <h2>Module Formulaire</h2> <h3>Permet l''envoi de mail, l''&eacute;criture dans une base de donn&eacute;es, l''identification des utilisateurs, de r&eacute;colter des avis, de faire des sondages ...</h3> <h3>Un assistant de cr&eacute;ation de formulaire vous aidera &agrave; mettre en place des formulaires tout aussi simple que complexes.</h3> <p><atm-linx type="direct"><selection><start><nodespec type="node" value="9"/></start></selection><noselection>Exemple d''affichage du module Formulaire</noselection><display><htmltemplate><a href="{{href}}" >Exemple d''affichage du module Formulaire</a></htmltemplate></display></atm-linx></p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(301, 3, 'first', '409d0a2f5060ddb2747151da5e264f99', 'texte', '<h2>Un acc&eacute;s<strong> </strong>TOTAL</h2>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(300, 3, 'first', 'c44b397b36f4839fd7bba0c769b5e56e', 'texte', '<p>&nbsp;</p> <h2>Vos droits sur ce site</h2>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(517, 3, 'first', '6ff77816cb91134d254f1b0723fa0022', 'texte', '<h3>Que pouvez-vous faire ?</h3> <p>Vous disposez d&rsquo;un compte utilisateur <strong>&laquo; R&eacute;dacteur &raquo;</strong> qui vous permet d&rsquo;avoir acc&egrave;s &agrave; l&rsquo;interface d''administration d&rsquo;Automne 4 et donc d&rsquo;op&eacute;rer certaines modifications. <strong><br /> </strong></p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(463, 3, 'first', '401937687b65ea5c249faa74f4e23c9a', 'texte', '<h3>Vous ne pouvez pas:</h3> <ul>     <li>administrer les modules.</li>     <li>valider la modification des pages.</li>     <li>ou encore cr&eacute;er de nouveaux comptes utilisateurs.</li>     <li>...</li> </ul> <p>Ces fonctionnalit&eacute;s sont r&eacute;serv&eacute;es &agrave; un compte utilisateur de type&nbsp;  <strong>&laquo; Administrateur &raquo;.</strong></p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(458, 3, 'first', '39a32afb98d21c8252ea3714cff0f62e', 'texte', '<ul><li>modifier, cr&eacute;er et copier des pages.</li><li>g&eacute;rer votre compte utilisateur.</li><li>g&eacute;rer des &eacute;l&eacute;ments des modules.</li><li>&hellip;</li></ul>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(258, 3, 'first', '8be44600466b3bd947f5b2c5cb45bf01', 'texte', '');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(518, 3, 'first', '23ba8857d961fd78dc2ff56bb56e39e7', 'texte', '<h3>Si vous souhaitez disposer d&rsquo;un contr&ocirc;le total, il vous suffit de <a target="_blank" href="http://www.automne.ws/download/">t&eacute;l&eacute;charger</a> la version compl&egrave;te d&rsquo;Automne 4.</h3>  <p>Pour plus d''information, consultez les pages suivantes :</p> <ul>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="29"/></start></selection><noselection>Automne 4</noselection><display><htmltemplate><a href="{{href}}" >Automne 4</a></htmltemplate></display></atm-linx>.</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="33"/></start></selection><noselection>Nouveaut&eacute;s</noselection><display><htmltemplate><a href="{{href}}" >Nouveaut&eacute;s</a></htmltemplate></display></atm-linx>.</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="30"/></start></selection><noselection>Pr&eacute;-requis</noselection><display><htmltemplate><a href="{{href}}" >Pr&eacute;-requis</a></htmltemplate></display></atm-linx>.</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="24"/></start></selection><noselection>Fonctionnalit&eacute;s</noselection><display><htmltemplate><a href="{{href}}" >Fonctionnalit&eacute;s</a></htmltemplate></display></atm-linx>.</li> </ul>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(523, 30, 'first', 'dda8207197eda19c8be4b1f63d76b382', 'texte', '<h2>Pr&eacute;-requis conseill&eacute;s</h2><ul><li>PHP install&eacute; sous forme de module Apache (la version CGI offre des performances moindres).</li><li><a href="http://fr.php.net/manual/fr/features.commandline.php">Module CLI de PHP install&eacute; </a>et disponible sur le serveur ainsi que les fonctions &quot;<a href="http://fr.php.net/system">system</a>&quot; et &quot;<a href="http://fr2.php.net/manual/fr/function.exec.php">exec</a>&quot; de PHP pour profiter des scripts en tache de fond.</li><li>Option<a href="http://fr2.php.net/manual/fr/ref.info.php#ini.magic-quotes-gpc"> &quot;magic_quotes_gpc&quot;</a> de PHP d&eacute;sactiv&eacute;e.</li><li>Apache doit avoir le droit de cr&eacute;er et de modifier l&rsquo;ensemble des fichiers d''Automne sur le serveur pour profiter du syst&egrave;me d&rsquo;installation et de mise &agrave; jour automatique. Sans cela, certaines parties de l&rsquo;installation et des mises &agrave; jour devront &ecirc;tre effectu&eacute;es manuellement.</li><li>Un cache de code PHP (opcode cache) tel que <a href="http://pecl.php.net/package/APC">APC</a> ou <a href="http://www.zend.com/products/zend_optimizer">Zend optimizer </a>est un plus pour les performances.</li><li>Certaines fonctionnalit&eacute;s d&rsquo;Automne (telle que la g&eacute;n&eacute;ration des pages du site) peuvent n&eacute;cessiter plus de m&eacute;moire vive (en particulier si vous avez compil&eacute; PHP avec un tr&egrave;s grand nombre d''extensions). En r&egrave;gle g&eacute;n&eacute;rale il est pr&eacute;f&eacute;rable de laisser PHP g&eacute;rer lui m&ecirc;me la m&eacute;moire vive allou&eacute; aux scripts en permettant l''usage de la fonction<a href="http://fr2.php.net/manual/fr/ini.core.php#ini.memory-limit"> &quot;memory_limit&quot;</a>.</li></ul><h3>Pour des raisons de performance, nous recommandons l&rsquo;usage d&rsquo;un serveur Linux ou Unix en production.</h3><h3>Du fait de l&rsquo;emploi de fichiers .htaccess, le serveur Apache est fortement conseill&eacute;.</h3>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(530, 25, 'first', 'f87771b9821f911d00f29d8d494a055b', 'texte', '<h2>Principe de mod&egrave;les de pages</h2> <p>Un principe fondamental des CMS est la <strong>s&eacute;paration entre le contenu et la pr&eacute;sentation.</strong> Autrement dit, le graphisme et l&rsquo;information contenu dans un site sont totalement ind&eacute;pendant l&rsquo;un de l&rsquo;autre.</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(548, 35, 'first', '718dfb04e3bd006a81604b9ccdf448cf', 'texte', '<p>Automne 4 dispose d''un <strong>syst&egrave;me intelligent de gestion des droits des utilisateurs.</strong> Il permet une gestion fine des droits, tant dans les diff&eacute;rentes pages que dans les contenus des diff&eacute;rents modules. Ce syst&egrave;me permet d''appliquer l''ensemble de ces droits sur tout types d''&eacute;l&eacute;ments g&eacute;r&eacute;s par Automne 4.</p> <p>Ces droits peuvent &ecirc;tre attribu&eacute;s sur les pages mais aussi sur les modules, les mod&egrave;les de pages, les rang&eacute;es de contenu,&nbsp; et sur toutes les grandes actions d''administration... L''ensemble de ces droits sont <strong>applicables aux utilisateurs et aux groupes d''utilisateurs</strong> ayant acc&egrave;s au site.</p> <h3>Il existe un <strong>droit particulier</strong> intitul&eacute; <atm-linx type="direct"><selection><start><nodespec type="node" value="37"/></start></selection><noselection>droit de validation.</noselection><display><htmltemplate><a href="{{href}}" >droit de validation.</a></htmltemplate></display></atm-linx></h3> <p>Ce droit permet de donner &agrave; l''utilisateur la possibilit&eacute; de valider le travail des autres utilisateurs pour publier le contenu sur le site en ligne.</p> <h3>Quelques exemples de droits utilisateurs :</h3> <ul>     <li><em>L''utilisateur A peut avoir des droits d''administrations sur certaines pages et un droit limit&eacute; sur les mod&egrave;les de pages. Ce qui lui permettra de ne cr&eacute;er que des pages utilisant les mod&egrave;les qu''il peut utiliser.</em></li>     <li><em>L''utilisateur B peut avoir les droits d''administration sur la cat&eacute;gorie Fran&ccedil;aise des actualit&eacute;s et uniquement le droit de visibilit&eacute; sur la cat&eacute;gorie Anglaise des actualit&eacute;s. Il ne pourra ainsi modifier que les actualit&eacute;s Fran&ccedil;aise du site.</em></li>     <li><em>L''utilisateur C peut avoir les droits d''administrations sur le module m&eacute;diath&egrave;que mais aucun droit sur les actualit&eacute;s et les pages du site. Il ne pourra donc que g&eacute;rer les &eacute;l&eacute;ments de la m&eacute;diath&egrave;que que d''autres utilisateurs pourront ensuite utiliser dans les actualit&eacute;s ou les pages du site.</em></li> </ul> <p>Bien entendu vous pouvez sp&eacute;cifier finement tous les droits que vous souhaitez et vous pouvez m&ecirc;me <strong>cr&eacute;er des groupes d''utilisateur comportant des droits sp&eacute;cifiques</strong> qui seront additionn&eacute; aux utilisateurs appartenant &agrave; diff&eacute;rents groupes.</p> <h3>Gestion de droits par groupes d''utilisateurs :</h3> <p>Vous avez six groupes utilisateurs distinct :</p> <ul>     <li>Administration des Actualit&eacute;s <em>Fran&ccedil;aises</em></li>     <li>Administration des Actualit&eacute;s <em>Anglaises</em></li>     <li>Administration des Pages du site <em>Fran&ccedil;ais</em> et droit sur les mod&egrave;les <em>Fran&ccedil;ais</em></li>     <li>Administration des Pages du site <em>Anglais</em> et droit sur les mod&egrave;les <span style="font-style: italic;">Anglais</span></li>     <li>Validation des modifications sur les <em>Actualit&eacute;s</em></li>     <li>Validation des modifications sur les <em>Pages</em></li> </ul> <p><strong>En associant un ou plusieurs de ces groupes &agrave; des utilisateurs</strong>, vous leur donnerez simplement les droits correspondants vous permettant ainsi de <strong>cr&eacute;er et de g&eacute;rer simplement </strong>des combinaisons plus ou moins complexe de droits d''administration.</p> <p>De plus, dans le cas de <strong>sites Extranet ou Intranet</strong>, vous pouvez aussi r&eacute;aliser ce type de combinaison sur le <strong>droit de visibilit&eacute;</strong> des diff&eacute;rents contenus du site, permettant ainsi de cr&eacute;er des <strong>zones de contenu s&eacute;curis&eacute;es sur votre site</strong>.</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(192, 5, 'first', '68a1b1d8a072af0eb92f6392eb309ad1', 'texte', '');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(547, 35, 'first', '9f851c9d1868ad933f280c33e5a419f3', 'texte', '<p>Il existe<strong> trois types de droits fondamentaux</strong> :</p> <ul>     <li>Droit d''&eacute;criture &rArr; &eacute;quivaut au <strong>droit d''administration.</strong></li>     <li>Droit de lecture &rArr; &eacute;quivaut au <strong>droit de visibilit&eacute;.</strong></li>     <li>Aucun droit &rArr; l''utilisateur ne peut voir le contenu.</li> </ul>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(493, 2, 'first', 'a0922acb28a233e527aa46607bfec987c', 'texte', '<p><strong>Automne est votre solution</strong> si vous recherchez un outil de gestion de contenu performant et &eacute;volutif. </p><p>Un outil permettant autonomie et contr&ocirc;le &eacute;ditorial.</p><p>Que votre contenu soit statique ou dynamique avec une gestion en bases de donn&eacute;es, Automne facilite la communication et les &eacute;changes <strong>sans contraintes techniques.<br /></strong></p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(526, 27, 'first', '56025a9b887be03112111d215ca6f31d', 'texte', '<p>Une des particularit&eacute;s d&rsquo;Automne est le<strong> g&eacute;n&eacute;rateur de module appel&eacute; POLYMOD. </strong></p><p>Il permet de g&eacute;rer des &eacute;l&eacute;ments contenant des donn&eacute;es de types textes, fichiers, images &hellip; Ces donn&eacute;es sont organis&eacute;es entre elles tel que vous le souhaitez et cela sans qu&rsquo;aucune comp&eacute;tence technique ne soit requise.</p><p>Exemple :&nbsp; les modules Actualit&eacute;s et M&eacute;diath&egrave;que fourni dans cette d&eacute;monstration sont enti&egrave;rement <strong>cr&eacute;&eacute;s &agrave; partir de l''interface d''administration</strong> d''Automne 4. Ils peuvent &ecirc;tre modifi&eacute;s pour &ecirc;tre ajust&eacute;s &agrave; ce que vous souhaitez sans aucune difficult&eacute;.</p><p>Le polymod permet aussi de <strong>cr&eacute;er simplement</strong> des flux RSS, des moteurs de recherche c&ocirc;t&eacute; client&hellip;</p><p>Exemple : module de gestion de produits, actualit&eacute;s, m&eacute;diath&egrave;que, annuaire, &hellip;</p> <h3>Il est possible de cr&eacute;er ses propres modules pour r&eacute;aliser des op&eacute;rations bien sp&eacute;cifiques.</h3>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(543, 27, 'first', '4564d92b193505d71f29b5ae69dddde0', 'texte', '<h2>Modules sp&eacute;cifiques</h2> <h3>Automne 4 permet aussi de g&eacute;rer des modules sp&eacute;cifiques que le Polymod ne saurai traiter.</h3><p>Ces modules, cr&eacute;&eacute;s en PHP peuvent alors <strong>r&eacute;aliser tout type d''op&eacute;ration m&eacute;tier complexe </strong>en s''int&eacute;grant parfaitement &agrave; l''interface d''Automne 4. </p><p>Vous pouvez ainsi lier Automne &agrave; vos bases de donn&eacute;es m&eacute;tier ou encore cr&eacute;er des modules de mailing, d''e-commerce, interroger des web services distant et ajouter bien d''autres fonctionnalit&eacute;s encore ...</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(541, 27, 'first', 'f863b4e5ea5a0c8019440ff99e59e29f', 'texte', '<p>Il est possible d''ajouter au noyau logiciel un ensemble de modules pour ajouter des fonctionnalit&eacute;s propres aux besoins de chaque site.</p><p>Par d&eacute;faut Automne 4 contient les modules les plus courants : <strong>M&eacute;diath&egrave;que, Gestion des Actualit&eacute;s, Cr&eacute;ation de formulaires, Cr&eacute;ation d''Alias de pages. </strong></p><h3>Il vous est cependant possible d''ajouter autant de modules suppl&eacute;mentaires que vous le souhaitez !</h3> <h2>G&eacute;n&eacute;rateur de modules&nbsp; POLYMOD</h2>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(501, 9, 'first', '17a6be4c940c12530cfaecfb2eb6b828', 'texte', '<p>Ce formulaire vous permet d''envoyer une demande de contact. Pour le transformer (Champs, actions, email de destination), modifiez le dans les propri&eacute;t&eacute;s du module &quot;Formulaire&quot;.</p><p>&nbsp;</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(516, 3, 'first', 'f2c8532eb6f56afe1d435350eebd9a52', 'texte', '<h3>Bienvenue sur le site de d&eacute;monstration de la <strong>nouvelle version d&rsquo;Automne 4.</strong></h3><p>Vous trouverez ici <strong>toutes les informations</strong> n&eacute;cessaires &agrave; la d&eacute;couverte de cette version ainsi que les <strong>notions essentielles</strong> pour bien appr&eacute;hender l&rsquo;outil.</p><p>&nbsp;</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(522, 30, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h3>L''installation / utilisation d''Automne 4 n&eacute;cessite certains  pr&eacute;-requis :</h3> <h2>Pr&eacute;-requis techniques obligatoires</h2> <h3>Serveur Linux, Windows, Max OSX, Solaris, BSD, ou tout autre syst&egrave;me syst&egrave;me Unix permettant de faire tourner les trois outils suivant sur lesquels repose Automne :</h3>    <ul><li>Serveur <a href="http://httpd.apache.org/">Apache</a>.</li><li><a href="http://www.php.net/">PHP 5.2.x</a>. Pour des raisons de s&eacute;curit&eacute; nous recommandons la derni&egrave;re version de la branche 5.x.<ul><li>Extension GD disponible pour PHP (permet le <a href="http://www.php.net/manual/fr/ref.image.php">traitement des images</a>) avec les librairies JPEG, GIF et PNG.</li><li>Option &quot;<a href="http://fr2.php.net/manual/fr/features.safe-mode.php">safe_mode</a>&quot; de PHP d&eacute;sactiv&eacute;e.</li><li>32 &agrave; 64Mo de m&eacute;moire allou&eacute; aux scripts PHP (en fonction du nombre d''extensions install&eacute;es sur PHP : plus d''extensions n&eacute;cessite plus de m&eacute;moire).</li></ul></li><li><a href="http://www.mysql.com/">MySQL 5.x .</a></li></ul>  <h3>Pour l''admnistration d''Automne : Internet Explorer 7, Firefox 3, Safari 3, Google Chrome, Opera 9</h3><p>Les pr&eacute;-requis en terme de navigateur du site public d&eacute;pendent des mod&egrave;les utilis&eacute;s pour cr&eacute;er les pages.</p> <p>&nbsp;</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(465, 33, 'first', '12ea6baf8092e5e6c7abb476cf71ce08', 'texte', '<p style="text-align: left;"><span id="polymod-1-35" class="polymod">\n require_once($_SERVER["DOCUMENT_ROOT"].''/automne/classes/polymodFrontEnd.php'');\necho CMS_poly_definition_functions::pluginCode(''1'', ''35'', '''', true); \n</span></p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(520, 33, 'first', 'adbbb020aeadb2df9957a83e19e55211', 'texte', '<h2>Voici une liste de quelques unes des nouveaut&eacute;s d''Automne 4 :</h2> <ul>     <li style="text-align: left;">Refonte de l''interface administrateur, <strong>plus ergonomique, plus intuitive, plus r&eacute;active.</strong></li>     <li style="text-align: left;">Votre site n''est plus dissoci&eacute; de l''interface d''administration.</li>     <li style="text-align: left;">Vous saisissez et organisez votre contenu simplement, rapidement, sans aucune connaissance technique.</li>     <li style="text-align: left;"><strong>Aide contextuelle</strong> permettant une prise en main encore plus simple.</li>     <li style="text-align: left;">De <strong>meilleures performances</strong> de l''outil.</li>     <li style="text-align: left;">Bas&eacute; sur les technologies du <strong>web 2.0, PHP5, Ajax.</strong></li>     <li style="text-align: left;">Gestion des <strong>langues internationales</strong> - Gestion des alphabets particuliers.</li>     <li style="text-align: left;">Fonction de recherche<strong> Full Text</strong> dans les contenus.</li>     <li style="text-align: left;">...</li> </ul>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(532, 38, 'first', '65990b9ff00394714dd60ffd708b2d77', 'texte', '<p>Enfin, si vous cherchez comment modifier tel contenu ou &eacute;l&eacute;ment g&eacute;r&eacute; par Automne 4et que vous ne savez pas comment l''atteindre dans l''interface d''administration, <strong>un puissant moteur de recherche</strong> <strong>vous permet de rechercher sur l''ensemble des contenus et des &eacute;l&eacute;ments, </strong>quel que soit leurs type : Contenu des pages, contenu des modules, utilisateurs, mod&egrave;les de pages et de rang&eacute;es, etc.</p> <h3>Les r&eacute;sultats fournis par ce moteur s''adapteront m&ecirc;me au niveau de droit de l''utilisateur pour ne lui proposer que les &eacute;l&eacute;ments sur lesquels il peut agir.</h3>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(531, 38, 'first', '48e8e4c2bea88305e6a9353511f51ea7', 'texte', '<p>Cette aide vous apporte <strong>l''ensemble des points essentiels pour la d&eacute;finition de vos propres rang&eacute;es de contenu.</strong></p> <p>Elle d&eacute;taille les tags XML et les variables pouvant &ecirc;tre utilis&eacute;es ainsi que leurs fonctions.</p> <p>L''insertion des modules dans vos rang&eacute;es est document&eacute;e de la m&ecirc;me mani&egrave;re.</p> <h3>Cr&eacute;er ses propres rang&eacute;es de contenu devient extr&ecirc;mement simple !</h3>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(529, 38, 'first', '8d1b3ec256dada4f0c811896050fdc9f', 'texte', '<p>Les utilisateurs d''Automne 4 peuvent parfois &ecirc;tre confront&eacute;s &agrave; des questions sur l''utilisation de l''outil. &quot;<em>Que ce passe t''il si je clique sur ce bouton ?</em>&quot; &quot;<em>comment dois je r&eacute;aliser telle modification ?</em>&quot;.</p> <h3>Pour r&eacute;pondre &agrave; ces questions courantes, nous avons mis en place un&nbsp; NOUVEAU syst&egrave;me d''aide complet int&eacute;gr&eacute; &agrave; toutes les interfaces d''administration :</h3>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(551, 37, 'first', '3c1cf8ef8f25de1ae96706a2585bffb7', 'texte', '<h3>Un syst&egrave;me d''alerte email automatique informe les validateurs des modifications qui ont &eacute;t&eacute; op&eacute;r&eacute; sur le site.&nbsp;</h3> <p>Le validateur peut alors v&eacute;rifier les modifications faites sur le contenu et les accepter, les refuser ou les modifier.</p> <p>Un syst&egrave;me d''ic&ocirc;nes simple et clair permet &agrave; tout moment de connaitre le statut des &eacute;l&eacute;ments : si ils sont publi&eacute;s, d&eacute;publi&eacute;s, ou attente d''une validation.</p> <p>La publication en ligne des modifications n''est effective que lorsqu''elles sont approuv&eacute;es par le validateur. Ce droit particulier est param&eacute;trable dans la <atm-linx type="direct"><selection><start><nodespec type="node" value="28"/></start></selection><noselection>gestion des utilisateurs.</noselection><display><htmltemplate><a  href="{{href}}">gestion des utilisateurs.</a></htmltemplate></display></atm-linx></p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(512, 38, 'first', '4f342492c25a2b686c2b531760008d98', 'texte', '<p>L''aide contextuelle vous permet d<strong>''obtenir des informations</strong> sur les &eacute;l&eacute;ments que vous pointez avec votre curseur.</p> <h3>PLUS aucun bouton n''aura de secret pour vous !</h3>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(553, 25, 'first', '508f7be6da1c7022ae3df00f30190e49', 'texte', '<p>Lors de la cr&eacute;ation du mod&egrave;le de page, on d&eacute;termine, par l<strong>&rsquo;insertion de tags XML,</strong> l&rsquo;emplacement des zones modifiables et la logique des liens permettant la navigation entre les pages du site.</p> <p>Les mod&egrave;les servent alors &agrave; cr&eacute;er les diff&eacute;rentes pages employ&eacute;es par le site.</p> <p>Les zones modifiables des mod&egrave;les permettent de d&eacute;limiter les positions du contenu dans les pages ce qui permet de limiter volontairement les zones d''intervention des r&eacute;dacteurs des pages.</p> <p>Ce principe permet de s''assurer d''une <strong>pr&eacute;sentation homog&egrave;ne de toutes les pages du site.</strong></p> <p>Seules les personnes disposant des <atm-linx type="direct"><selection><start><nodespec type="node" value="35"/></start></selection><noselection>droits </noselection><display><htmltemplate><a  href="{{href}}">droits </a></htmltemplate></display></atm-linx>suffisants pourront ensuite ajouter / modifier de l&rsquo;information dans les pages par l&rsquo;interm&eacute;diaire des <atm-linx type="direct"><selection><start><nodespec type="node" value="26"/></start></selection><noselection>rang&eacute;es de contenu</noselection><display><htmltemplate><a  href="{{href}}">rang&eacute;es de contenu</a></htmltemplate></display></atm-linx> qui s''ins&egrave;rent dans les zones modifiables d&eacute;finies.</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(552, 26, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h2>Principe de rang&eacute;es de contenu</h2> <p>Les rang&eacute;es de contenu sont les gabarits qui contiennent l&rsquo;information. <strong>Elles peuvent contenir tous types d&rsquo;informations :</strong> texte, image, flash, vid&eacute;o&hellip; Par exemple, des rang&eacute;es titres, sous-titres, textes, textes et image &agrave; droite sont certaines des rang&eacute;es par d&eacute;faut d''Automne.</p> <p>Une rang&eacute;e est pr&eacute;-format&eacute;e. Cela permet de conserver l''homog&eacute;n&eacute;it&eacute; de la pr&eacute;sentation du site Internet.</p> <h3>Il vous est possible de cr&eacute;er vos propres rang&eacute;es avec le type d&rsquo;information que vous souhaitez.</h3> <p style="text-align: center;"><span id="polymod-1-24" class="polymod">\n require_once($_SERVER["DOCUMENT_ROOT"].''/automne/classes/polymodFrontEnd.php'');\necho CMS_poly_definition_functions::pluginCode(''1'', ''24'', '''', true); \n</span>  <span id="polymod-1-34" class="polymod">\n require_once($_SERVER["DOCUMENT_ROOT"].''/automne/classes/polymodFrontEnd.php'');\necho CMS_poly_definition_functions::pluginCode(''1'', ''34'', '''', true); \n</span></p> <h3>L''organisation des rang&eacute;es dans une page est particuli&egrave;rement simple. Vous pouvez les glisser-d&eacute;poser &agrave; l''endroit ou vous le souhaitez.</h3> <p>Les zones de saisies sont clairement indiqu&eacute;es et vous pouvez modifier l''ensemble du contenu tr&egrave;s simplement &agrave; l''aide <strong>d''outils de mise en forme tr&egrave;s intuitifs :</strong> mise en forme des textes &agrave; l''aide de <strong>l''&eacute;diteur WYSIWYG,</strong> redimensionner et recadrer des images, cr&eacute;er des liens vers d''autres sites ou vers une page donn&eacute;e de votre site.</p> <p>Vous pouvez m&ecirc;me d&eacute;cider <strong>d''importer le contenu de vos modules &agrave; n''importe quel endroit de vos textes.</strong> Si le contenu du module vient &agrave; disparaitre (suppression, d&eacute;publication, ...), il disparaitra <strong>simplement et sans erreur</strong> de tous les textes ou vous y faite r&eacute;f&eacute;rence.</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(554, 28, 'first', '9ba530cba11a3763a081a2e34072711f', 'texte', '<h3>Les utilisateurs peuvent cr&eacute;er d''autres utilisateurs ou groupes d''utilisateurs si et seulement si ils en ont les droits.</h3> <h3>Les utilisateurs appartenant &agrave; un groupe disposent des droits attribu&eacute;s au groupe.</h3>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(545, 28, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h2>Principe de gestion d''utilisateur</h2><p>Lors de la cr&eacute;ation d&rsquo;un site avec Automne 4, un utilisateur privil&eacute;gi&eacute; dit <atm-linx type="direct"><selection><start><nodespec type="node" value="35"/></start></selection><noselection>&laquo; Super Administrateur &raquo;</noselection><display><htmltemplate><a href="{{href}}" >&laquo; Super Administrateur &raquo;</a></htmltemplate></display></atm-linx> poss&egrave;de <strong>tous les droits sur l&rsquo;application.</strong></p> <p>Ce super administrateur a alors la possibilit&eacute; de cr&eacute;er des utilisateurs ainsi que des groupes d&rsquo;utilisateurs. Chacun dispose de droits sur certaines fonctionnalit&eacute;s de l&rsquo;application. Les groupes par d&eacute;faut sont : administrateur, validateur et r&eacute;dacteur.&nbsp;</p><p>Les r&eacute;dacteurs n''auront alors &agrave; leurs disposition que les outils qui leurs sont n&eacute;cessaires. Leurs interventions seront ainsi limit&eacute;s &agrave; leurs besoins.</p><p>Il est aussi possible, gr&acirc;ce au <atm-linx type="direct"><selection><start><nodespec type="node" value="37"/></start></selection><noselection>processus de workflow</noselection><display><htmltemplate><a href="{{href}}" >processus de workflow</a></htmltemplate></display></atm-linx> de soumettre les donn&eacute;es saisies &agrave; la validation d''une autorit&eacute; sup&eacute;rieure. Ainsi le contenu pourra &ecirc;tre v&eacute;rifi&eacute; avant sa mise en ligne.</p>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(1, 29, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h2>Syst&egrave;me de gestion de contenu</h2> <p>Automne est un outil <a href="http://fr.wikipedia.org/wiki/Open_source"><strong>OPEN SOURCE</strong>,</a> performant et ergonomique. C''est un <strong>syst&egrave;me de gestion de contenu (CMS)</strong> <strong>professionnel</strong> d&eacute;di&eacute; aux entreprises, aux organismes public et aux associations de toutes tailles .</p> <h3>Automne 4 offre un <strong>environnement s&eacute;curis&eacute; </strong>et<strong> collaboratif</strong> pour g&eacute;rer les pages web et les applications dynamiques.</h3> <p>&nbsp;</p> <h2>Performant et &eacute;volutif</h2> <p>Robuste pour sa capacit&eacute; de g&eacute;rer plusieurs milliers de pages avec un <strong>langage orient&eacute; objet.</strong> Automne 4 <strong>respecte</strong> <strong>les normes et recommandations du w3c</strong> ainsi que les <strong>nouvelles r&egrave;gles d&rsquo;accessibilit&eacute;.</strong></p> <p>Dot&eacute; d''un cr&eacute;ateur de <atm-linx type="direct"><selection><start><nodespec type="node" value="27"/></start></selection><noselection>modules dynamiques</noselection><display><htmltemplate><a  href="{{href}}">modules dynamiques</a></htmltemplate></display></atm-linx>, vous pourrez <strong>enrichir</strong> les <atm-linx type="direct"><selection><start><nodespec type="node" value="24"/></start></selection><noselection>fonctionnalit&eacute;s de votre site Internet</noselection><display><htmltemplate><a  href="{{href}}">fonctionnalit&eacute;s de votre site Internet</a></htmltemplate></display></atm-linx> selon vos besoins.</p> <p>&nbsp;</p> <h2>Web et plus</h2> <p>Automne 4 vous permet de <strong>cr&eacute;er et de g&eacute;rer votre site Internet, Extranet ou Intranet.</strong> Il permet de cr&eacute;er des sites Internet institutionnels de qualit&eacute; professionnelle tr&egrave;s rapidement mais aussi de<strong> r&eacute;aliser les applications web</strong> les plus &eacute;volu&eacute;es. Tout cela en restant dans un <strong>contexte simple et intuitif</strong> qui n''offre &agrave; ses utilisateurs que les fonctionnalit&eacute;s qu''ils ont le droit d''employer.</p> <p><em><br /> </em></p> <h2>P&eacute;r&eacute;nit&eacute; et s&eacute;curit&eacute;</h2> <h3>Automne existe depuis 1999. Parmi les premier CMS du march&eacute;, il a su &eacute;voluer en m&ecirc;me temps qu''Internet. Utilis&eacute; depuis ses d&eacute;buts par des professionnels, pour des professionnels, il offre des fonctionnalit&eacute;s cibl&eacute;es aux besoins des entreprises.</h3> <p>Vous &ecirc;tes assur&eacute;s d''avoir des mises &agrave; jour r&eacute;guli&egrave;res et de pouvoir employer ces mises &agrave; jour sur votre site sans difficult&eacute;s.</p> <h3>Le noyaux d''Automne 4 est d&eacute;velopp&eacute; par des professionnels certifi&eacute;s poss&eacute;dant plusieurs ann&eacute;es d''exp&eacute;rience en PHP. Tous les d&eacute;veloppement sont v&eacute;rifi&eacute;s et respectent un haut niveau de qualit&eacute; et de s&eacute;curit&eacute;.</h3> <p>Automne 4 est <strong>gratuit et librement t&eacute;l&eacute;chargeable</strong> sur <a target="_blank" href="http://sourceforge.net/projects/automne/">Sourceforge</a>. Il emploie des technologies Open Source ind&eacute;pendantes ce qui vous assure de pouvoir l''utiliser longtemps sans d&eacute;pendre d''une entreprise &eacute;ditrice.</p> <p>Par ailleurs, vous disposez d''un <a target="_blank" href="http://www.automne.ws/forum/">forum communautaire</a> pour signaler tout probl&egrave;me que vous rencontreriez.</p> <h3><strong>Il vous est aussi possible d''obtenir un support et des formations dispens&eacute;s par des professionnels. Pour plus d''information, rendez vous sur </strong><a target="_blank" href="http://www.automne.ws"><strong>le site d''Automne</strong></a><strong>.</strong></h3>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(2, 24, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 'texte', '<h2>Vous trouverez dans cette partie les grands principes d&rsquo;utilisations d''Automne 4.</h2> <p>Syst&egrave;me de gestion de contenu puissant, Automne 4 permet de g&eacute;rer des sites de plusieurs milliers de pages, d''en <strong>modifier simplement l''apparence</strong> gr&acirc;ce aux <atm-linx type="direct"><selection><start><nodespec type="node" value="25"/></start></selection><noselection>mod&egrave;les de pages</noselection><display><htmltemplate><a  href="{{href}}">mod&egrave;les de pages</a></htmltemplate></display></atm-linx> et de modifier intuitivement le contenu gr&acirc;ce au principe des <atm-linx type="direct"><selection><start><nodespec type="node" value="26"/></start></selection><noselection>rang&eacute;es de contenu.</noselection><display><htmltemplate><a  href="{{href}}">rang&eacute;es de contenu.</a></htmltemplate></display></atm-linx></p> <p>Les nombreuses fonctionnalit&eacute;s pour le site Internet, simples ou complexes, peuvent &ecirc;tre <span style="font-weight: bold;">g&eacute;n&eacute;r&eacute;es</span><strong> automatiquement par le g&eacute;n&eacute;rateur de module appel&eacute; </strong><atm-linx type="direct"><selection><start><nodespec type="node" value="27"/></start></selection><noselection><strong>POLYMOD</strong></noselection><display><htmltemplate><a  href="{{href}}"><strong>POLYMOD</strong></a></htmltemplate></display></atm-linx> ou bien d&eacute;velopp&eacute;es directement en code PHP.</p> <p>Automne 4 dispose d''un syst&egrave;me de <atm-linx type="direct"><selection><start><nodespec type="node" value="28"/></start></selection><noselection>gestion des utilisateurs</noselection><display><htmltemplate><a  href="{{href}}">gestion des utilisateurs</a></htmltemplate></display></atm-linx> et <atm-linx type="direct"><selection><start><nodespec type="node" value="28"/></start></selection><noselection>groupes d''utilisateurs</noselection><display><htmltemplate><a  href="{{href}}">groupes d''utilisateurs</a></htmltemplate></display></atm-linx> particuli&egrave;rement &eacute;volu&eacute; permettant une <atm-linx type="direct"><selection><start><nodespec type="node" value="35"/></start></selection><noselection>gestion tr&egrave;s fine des droits.</noselection><display><htmltemplate><a  href="{{href}}">gestion tr&egrave;s fine des droits.</a></htmltemplate></display></atm-linx> Votre environnement de travail est homog&egrave;ne et ne pr&eacute;sente que les fonctionnalit&eacute;s sur lesquelles vous avez le droit d''agir.</p> <h3>Vous trouverez un descriptif des principales fonctions d''Automne 4 dans les pages ci-dessous :</h3> <ul>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="25"/></start></selection><noselection>Mod&egrave;les de pages</noselection><display><htmltemplate><a  href="{{href}}">Mod&egrave;les de pages</a></htmltemplate></display></atm-linx> (l''habillage graphique du site Internet),</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="26"/></start></selection><noselection>Rang&eacute;es de contenu</noselection><display><htmltemplate><a  href="{{href}}">Rang&eacute;es de contenu</a></htmltemplate></display></atm-linx> (l''habillage de vos contenus et m&eacute;dias),</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="27"/></start></selection><noselection>Modules dynamiques</noselection><display><htmltemplate><a  href="{{href}}">Modules dynamiques</a></htmltemplate></display></atm-linx> (vos outils personnalis&eacute;s et applications d&eacute;di&eacute;es),</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="28"/></start></selection><noselection>Gestion des utilisateurs et des groupes d''utilisateurs</noselection><display><htmltemplate><a  href="{{href}}">Gestion des utilisateurs et des groupes d''utilisateurs</a></htmltemplate></display></atm-linx>,</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="35"/></start></selection><noselection>Gestion des droits d''acc&egrave;s</noselection><display><htmltemplate><a  href="{{href}}">Gestion des droits d''acc&egrave;s</a></htmltemplate></display></atm-linx>,</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="37"/></start></selection><noselection>Workflow de publication des contenus</noselection><display><htmltemplate><a  href="{{href}}">Workflow de publication des contenus</a></htmltemplate></display></atm-linx>,</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="38"/></start></selection><noselection>Aide aux utilisateurs</noselection><display><htmltemplate><a  href="{{href}}">Aide aux utilisateurs</a></htmltemplate></display></atm-linx>,</li>     <li><atm-linx type="direct"><selection><start><nodespec type="node" value="34"/></start></selection><noselection>Fonctions avanc&eacute;es</noselection><display><htmltemplate><a  href="{{href}}">Fonctions avanc&eacute;es</a></htmltemplate></display></atm-linx>.</li> </ul>');
INSERT INTO `blocksTexts_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(3, 34, 'first', '592c2e33c7971c02ec553000d0eaea43', 'texte', '<h2>Gestion Multi-sites</h2> <p>Une seule et m&ecirc;me interface d''Automne 4 peut g&eacute;rer autant de sites diff&eacute;rents que vous le souhaitez. Chacun peut poss&eacute;der son propre nom de domaine, sa propre langue et ses propres &eacute;l&eacute;ments (mod&egrave;les de pages, rang&eacute;es) permettant de g&eacute;rer les diff&eacute;rentes pages qui les composent.</p> <p>&nbsp;</p> <h2>S&eacute;curiser l''acc&egrave;s au contenu cot&eacute; public des sites (Intranet / Extranet)</h2> <p>Ce syst&egrave;me &eacute;volu&eacute; de gestion des droits permet de r&eacute;aliser des <strong>espaces s&eacute;curis&eacute;s</strong> sur vos sites. Par l&rsquo;interm&eacute;diaire d&rsquo;un Nom d''utilisateur et d''un mot de de passe, votre site Internet se transforme en <strong>site Extranet </strong>appliquant ainsi des <strong>droits et restrictions</strong> sur certaines pages et certains contenus que vous sp&eacute;cifiez. Les restrictions mises en place sont <strong>invisibles </strong>&agrave; ceux qui ne poss&egrave;dent pas les droits de les voir &eacute;vitant ainsi toute frustration de vos utilisateurs.<strong><br /> </strong></p> <h3>Exemple : celui qui n&rsquo;a pas acc&egrave;s &agrave; la page &laquo; ressource &raquo; ne verra pas cet &eacute;l&eacute;ment dans la navigation.</h3> <p>&nbsp;</p> <h2>Connexion LDAP</h2> <p>L''int&eacute;r&ecirc;t principal d''un annuaire LDAP est la <strong>normalisation de l''authentification.</strong> Cet annuaire regroupe toutes les informations de type de l&rsquo;utilisateur (nom, pr&eacute;nom, services, postes &hellip;etc).  Automne 4 permet de r&eacute;cup&eacute;rer automatiquement les informations de l&rsquo;annuaire afin de d&eacute;finir les utilisateurs et leurs droits. &laquo; Le salari&eacute; travaillant au service des ressources humaines, aura automatiquement acc&egrave;s &agrave; la page ressource humaine, l&agrave; o&ugrave; d&rsquo;autres n&rsquo;y auront pas acc&egrave;s &raquo;.</p> <h3>Lors de l&rsquo;ouverture de session, les identifiants et mot de passe sont envoy&eacute;es &agrave; cet annuaire qui transmet alors les informations de l&rsquo;utilisateur.</h3> <p>&nbsp;</p> <h2>SSO (single Sign On)</h2> <p><strong>L''authentification unique</strong> est une m&eacute;thode permettant &agrave; un utilisateur de ne proc&eacute;der qu''&agrave; une seule authentification pour acc&eacute;der &agrave; plusieurs applications informatiques (ou sites web s&eacute;curis&eacute;s). Automne 4 dispose aujourd&rsquo;hui de cette technologie et les utilisateurs pourront directement &ecirc;tre connect&eacute;s &agrave; l&rsquo;interface d''Automne 4 d&eacute;s l&rsquo;ouverture de session sur leur machine.</p> <h3>Plus besoin de s''authentifier &agrave; Automne 4.</h3>');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksVarchars_edited`
--

INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(6, 2, 'first', 'a5dc59c9028fd290e4f240131991fa8a2', 'stitre', 'Faciliter la communication et les échanges !');
INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(16, 29, 'first', 'ef68332801171f3678986a9192ea85db', 'stitre', '');
INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(23, 35, 'first', '18f076b2de7e3b4310097f83ac547533', 'stitre', 'Principe de gestion des droits');
INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(26, 38, 'first', '67834d6b4d508349b9b2892e4932e718', 'stitre', 'Moteur de recherche interne');
INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(24, 38, 'first', 'e76f4966a4808ea827d71853fd371ee3', 'stitre', 'Aide contextuelle');
INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(30, 38, 'first', '229fdaa261c7fed31f048dc9f7d1c95d', 'stitre', 'L''aide à la syntaxe XML (pour les utilisateurs avancés)');
INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(4, 3, 'first', 'a909549cfffa588cae12e01ad4152f1f8', 'titre', 'Présentation Titre h1');
INSERT INTO `blocksVarchars_edited` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(27, 3, 'first', '71b5c89dda723156165f086098957ded', 'stitre', 'Bienvenue sur AUTOMNE 4 ');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `blocksVarchars_public`
--

INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(6, 2, 'first', 'a5dc59c9028fd290e4f240131991fa8a2', 'stitre', 'Faciliter la communication et les échanges !');
INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(16, 29, 'first', 'ef68332801171f3678986a9192ea85db', 'stitre', '');
INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(4, 3, 'first', 'a909549cfffa588cae12e01ad4152f1f8', 'titre', 'Présentation Titre h1');
INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(27, 3, 'first', '71b5c89dda723156165f086098957ded', 'stitre', 'Bienvenue sur AUTOMNE 4 ');
INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(23, 35, 'first', '18f076b2de7e3b4310097f83ac547533', 'stitre', 'Principe de gestion des droits');
INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(26, 38, 'first', '67834d6b4d508349b9b2892e4932e718', 'stitre', 'Moteur de recherche interne');
INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(30, 38, 'first', '229fdaa261c7fed31f048dc9f7d1c95d', 'stitre', 'L''aide à la syntaxe XML (pour les utilisateurs avancés)');
INSERT INTO `blocksVarchars_public` (`id`, `page`, `clientSpaceID`, `rowID`, `blockID`, `value`) VALUES(24, 38, 'first', 'e76f4966a4808ea827d71853fd371ee3', 'stitre', 'Aide contextuelle');

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

INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(2, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(2, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(2, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(2, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(2, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(2, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 29);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 30);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(3, 33);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 5);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 6);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(5, 36);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 5);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 6);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(6, 36);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 5);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 6);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 29);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 30);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 33);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 36);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(8, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(9, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(9, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(9, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(9, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(9, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(9, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(24, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(25, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(26, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(27, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(28, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 29);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 30);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(29, 33);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 29);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 30);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(30, 33);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 5);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 6);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(31, 36);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 29);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 30);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(33, 33);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(34, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(35, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 5);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 6);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(36, 36);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(37, 38);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 2);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 3);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 8);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 9);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 24);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 25);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 26);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 27);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 28);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 31);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 34);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 35);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 37);
INSERT INTO `linx_real_public` (`start_lre`, `stop_lre`) VALUES(38, 38);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `linx_tree_edited`
--

INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(19, 1, 2, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(20, 2, 3, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(58, 24, 38, 7);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(49, 31, 5, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(51, 31, 6, 2);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(24, 2, 7, 4);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(25, 7, 8, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(26, 7, 9, 2);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(40, 2, 24, 2);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(41, 24, 25, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(42, 24, 26, 2);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(43, 24, 27, 3);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(44, 24, 28, 4);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(45, 3, 29, 1);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(46, 3, 30, 3);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(48, 2, 31, 3);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(53, 3, 33, 2);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(54, 24, 34, 8);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(55, 24, 35, 5);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(56, 31, 36, 3);
INSERT INTO `linx_tree_edited` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(57, 24, 37, 6);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `linx_tree_public`
--

INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(61, 1, 2, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(138, 3, 30, 3);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(188, 24, 34, 8);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(101, 2, 3, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(77, 7, 8, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(78, 7, 9, 2);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(106, 2, 24, 2);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(187, 24, 38, 7);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(186, 24, 37, 6);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(185, 24, 35, 5);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(184, 24, 28, 4);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(137, 3, 33, 2);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(136, 3, 29, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(129, 2, 31, 3);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(157, 31, 6, 2);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(156, 31, 5, 1);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(183, 24, 27, 3);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(182, 24, 26, 2);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(158, 31, 36, 3);
INSERT INTO `linx_tree_public` (`id_ltr`, `father_ltr`, `sibling_ltr`, `order_ltr`) VALUES(181, 24, 25, 1);

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

INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(2, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(2, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(3, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(3, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(3, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(3, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(3, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(5, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(5, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(5, 5);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(5, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(5, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(5, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(6, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(6, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(6, 6);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(6, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(6, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(6, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(8, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(8, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(8, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(8, 8);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(8, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(8, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(9, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(9, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(9, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(9, 9);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(9, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(9, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(24, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(24, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(24, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(24, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(24, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(25, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(25, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(25, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(25, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(25, 25);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(25, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(26, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(26, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(26, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(26, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(26, 26);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(26, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(27, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(27, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(27, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(27, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(27, 27);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(27, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(28, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(28, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(28, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(28, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(28, 28);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(28, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(29, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(29, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(29, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(29, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(29, 29);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(29, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(30, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(30, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(30, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(30, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(30, 30);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(30, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(31, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(31, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(31, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(31, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(31, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(33, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(33, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(33, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(33, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(33, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(33, 33);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(34, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(34, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(34, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(34, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(34, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(34, 34);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(35, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(35, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(35, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(35, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(35, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(35, 35);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(36, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(36, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(36, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(36, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(36, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(36, 36);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(37, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(37, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(37, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(37, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(37, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(37, 37);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(38, 2);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(38, 3);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(38, 7);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(38, 24);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(38, 31);
INSERT INTO `linx_watch_public` (`page_lwa`, `target_lwa`) VALUES(38, 38);

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

INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(1, 'e595b48c-0baa-102e-80e2-001a6470da26', 'cms_forms', 0, 0, '1', 1, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(2, 'e595b5b8-0baa-102e-80e2-001a6470da26', 'pnews', 0, 0, '2', 2, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(17, 'e595b676-0baa-102e-80e2-001a6470da26', 'pnews', 2, 2, '2;17', 1, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(18, 'e595b734-0baa-102e-80e2-001a6470da26', 'pmedia', 0, 0, '18', 5, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(19, 'e595b7e8-0baa-102e-80e2-001a6470da26', 'pmedia', 18, 18, '18;19', 3, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(20, 'e595b8a6-0baa-102e-80e2-001a6470da26', 'pmedia', 18, 18, '18;20', 1, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(21, 'e595b964-0baa-102e-80e2-001a6470da26', 'pmedia', 18, 18, '18;21', 2, '');
INSERT INTO `modulesCategories` (`id_mca`, `uuid_mca`, `module_mca`, `parent_mca`, `root_mca`, `lineage_mca`, `order_mca`, `icon_mca`) VALUES(22, 'e595ba18-0baa-102e-80e2-001a6470da26', 'pmedia', 18, 18, '18;22', 4, '');

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
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(27, 6, 'en', 'Documents', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(28, 6, 'fr', 'Documents', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(71, 14, 'en', 'Pictures', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(72, 14, 'fr', 'Photos', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(161, 17, 'en', 'News item', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(162, 17, 'fr', 'Actualité', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(113, 18, 'en', 'Media', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(114, 18, 'fr', 'Média', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(131, 19, 'en', 'Movie', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(132, 19, 'fr', 'Vidéo', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(119, 20, 'en', 'Image', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(120, 20, 'fr', 'Image', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(125, 21, 'en', 'Document', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(126, 21, 'fr', 'Document', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(144, 22, 'fr', 'Audio', '', '');
INSERT INTO `modulesCategories_i18nm` (`id_mcl`, `category_mcl`, `language_mcl`, `label_mcl`, `description_mcl`, `file_mcl`) VALUES(143, 22, 'en', 'Audio', '', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_actions`
--

INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES(7, 2, 'text', 0, '');
INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES(8, 2, '', 2, '');
INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES(9, 2, 'text', 99, 'Votre demande a été envoyée par email. Vous recevrez une réponse rapidement.');
INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES(10, 2, 'text', 1, 'La saisie des champs suivants est incorrecte.');
INSERT INTO `mod_cms_forms_actions` (`id_act`, `form_act`, `value_act`, `type_act`, `text_act`) VALUES(11, 2, 'root@localhost', 3, 'Demande de contact§§Le message ci-dessous a été posté depuis le formulaire de contact de la démonstration d''Automne :§§');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_categories`
--

INSERT INTO `mod_cms_forms_categories` (`id_fca`, `form_fca`, `category_fca`) VALUES(2, 2, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_fields`
--

INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`, `params_fld`) VALUES(11, 2, '54b8a11ea29b491d40561eb321aed37f', 'Nom *', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 1, 1, 0, '');
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`, `params_fld`) VALUES(12, 2, '5d62b28a2c474455ae3a937127cf7204', 'Prénom *', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 1, 1, 1, '');
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`, `params_fld`) VALUES(13, 2, '4f77750ba5f191904e9aaab3acab488d', 'Email *', '', '', 'email', 'a:1:{s:0:"";s:0:"";}', 1, 1, 2, '');
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`, `params_fld`) VALUES(14, 2, '4005693f0d616bab1865d71fea32d1f6', 'Sujet du message *', '', '', 'text', 'a:1:{s:0:"";s:0:"";}', 1, 1, 3, '');
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`, `params_fld`) VALUES(15, 2, '778a8c9cce20558836139d64c7d403c0', 'Message *', '', '', 'textarea', 'a:1:{s:0:"";s:0:"";}', 1, 1, 5, '');
INSERT INTO `mod_cms_forms_fields` (`id_fld`, `form_fld`, `name_fld`, `label_fld`, `defaultValue_fld`, `dataValidation_fld`, `type_fld`, `options_fld`, `required_fld`, `active_fld`, `order_fld`, `params_fld`) VALUES(16, 2, '8e17e732a07c18b447c226014789627c', 'Envoyer', 'Envoyer', '', 'submit', 'a:1:{s:0:"";s:0:"";}', 0, 1, 4, '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_cms_forms_formulars`
--

INSERT INTO `mod_cms_forms_formulars` (`id_frm`, `name_frm`, `source_frm`, `language_frm`, `owner_frm`, `closed_frm`, `destinationType_frm`, `DestinationData_frm`, `responses_frm`) VALUES(2, 'Contact', '<form id="cms_forms_2">\n	<table width="100%" cellspacing="1" cellpadding="1" border="0" align="center">\n		<tbody>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzExX3JlcQ==">Nom * </label></td>\n				<td><input type="text" name="54b8a11ea29b491d40561eb321aed37f" id="zY21zX2ZpZWxkXzExX3JlcQ==" value="" /></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzEyX3JlcQ==">Prénom * </label></td>\n				<td><input type="text" name="5d62b28a2c474455ae3a937127cf7204" id="zY21zX2ZpZWxkXzEyX3JlcQ==" value="" /></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzEzX2VtYWlsX3JlcQ==">Email * </label></td>\n				<td><input type="text" name="4f77750ba5f191904e9aaab3acab488d" id="zY21zX2ZpZWxkXzEzX2VtYWlsX3JlcQ==" value="" /></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzE0X3JlcQ==">Sujet du message * </label></td>\n				<td><input type="text" name="4005693f0d616bab1865d71fea32d1f6" id="zY21zX2ZpZWxkXzE0X3JlcQ==" value="" /></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"><label for="zY21zX2ZpZWxkXzE1X3JlcQ==">Message * </label></td>\n				<td><textarea name="778a8c9cce20558836139d64c7d403c0" id="zY21zX2ZpZWxkXzE1X3JlcQ=="></textarea></td>\n			</tr>\n			<tr>\n				<td style="text-align: right;"> </td>\n				<td><input type="submit" value="Envoyer" name="8e17e732a07c18b447c226014789627c" class="button" id="zY21zX2ZpZWxkXzE2" /></td>\n			</tr>\n		</tbody>\n	</table>\n</form>', 'fr', 4, 0, 0, '', 0);

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

INSERT INTO `mod_object_definition` (`id_mod`, `uuid_mod`, `label_id_mod`, `description_id_mod`, `resource_usage_mod`, `module_mod`, `admineditable_mod`, `composedLabel_mod`, `previewURL_mod`, `indexable_mod`, `indexURL_mod`, `compiledIndexURL_mod`, `resultsDefinition_mod`) VALUES(1, 'e583bc28-0baa-102e-80e2-001a6470da26', 1, 2, 1, 'pnews', 0, '', '5||item={[''object1''][''id'']}', 0, '', '', '');
INSERT INTO `mod_object_definition` (`id_mod`, `uuid_mod`, `label_id_mod`, `description_id_mod`, `resource_usage_mod`, `module_mod`, `admineditable_mod`, `composedLabel_mod`, `previewURL_mod`, `indexable_mod`, `indexURL_mod`, `compiledIndexURL_mod`, `resultsDefinition_mod`) VALUES(2, 'e583bd90-0baa-102e-80e2-001a6470da26', 70, 71, 1, 'pmedia', 0, '', '6||item={[''object2''][''id'']}', 0, '', '', '<div class="pmedias">\r\n	<atm-if what="{[''object2''][''fields''][9][''thumbnail'']} &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''flv'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''mp3''">\r\n		<p style="float:right;"><a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" /></a></p>\r\n	</atm-if>\r\n	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''flv''">\r\n		<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n			<script type="text/javascript">\r\n				swfobject.embedSWF(''{constant:string:PATH_REALROOT_WR}/automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''{constant:string:PATH_REALROOT_WR}/automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''{constant:string:PATH_REALROOT_WR}/automne/playerflv/config_playerflv.xml'', startimage:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}''}, {allowfullscreen:true, wmode:''transparent''}, {''style'':''float:right;''});\r\n			</script>\r\n		</atm-if>\r\n		<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n			<script type="text/javascript">\r\n				swfobject.embedSWF(''{constant:string:PATH_REALROOT_WR}/automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''{constant:string:PATH_REALROOT_WR}/automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''{constant:string:PATH_REALROOT_WR}/automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, {''style'':''float:right;''});\r\n			</script>\r\n		</atm-if>\r\n		<div id="media-{[''object2''][''id'']}" class="pmedias-video" style="width:320px;height:200px;float:right;">\r\n			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n		</div>\r\n	</atm-if>\r\n	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''mp3''">\r\n		<script type="text/javascript">\r\n			swfobject.embedSWF(''{constant:string:PATH_REALROOT_WR}/automne/playermp3/player_mp3.swf'', ''media-{[''object2''][''id'']}'', ''200'', ''20'', ''9.0.0'', ''{constant:string:PATH_REALROOT_WR}/automne/swfobject/expressInstall.swf'', {mp3:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''{constant:string:PATH_REALROOT_WR}/automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, {''style'':''float:right;''});\r\n		</script>\r\n		<div id="media-{[''object2''][''id'']}" class="pmedias-audio" style="width:200px;height:20px;float:right;">\r\n			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n		</div>\r\n	</atm-if>\r\n	<p>{[''object2''][''fields''][9][''fieldname'']} : <strong><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="{[''object2''][''fields''][9][''fileExtension'']}" title="{[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''fields''][9][''fileHTML'']} ({[''object2''][''fields''][9][''fileSize'']}Mo)</strong></p>\r\n	<p>{[''object2''][''fields''][8][''fieldname'']} : <strong>{[''object2''][''fields''][8][''label'']}</strong></p>\r\n	<div style="clear:both;"> </div>\r\n</div>');

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

INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(1, 'e58dfdbe-0baa-102e-80e2-001a6470da26', 1, 3, 0, 'CMS_object_string', 1, 0, 1, 0, 0, 1, 'a:3:{s:9:"maxLength";s:3:"255";s:7:"isEmail";b:0;s:8:"matchExp";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(2, 'e58dfef4-0baa-102e-80e2-001a6470da26', 1, 4, 5, 'CMS_object_text', 3, 0, 1, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"550";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(3, 'e58dffc6-0baa-102e-80e2-001a6470da26', 1, 6, 7, 'CMS_object_text', 4, 0, 0, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:3:"550";s:13:"toolbarHeight";s:3:"500";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(4, 'e58e0098-0baa-102e-80e2-001a6470da26', 1, 8, 0, 'CMS_object_image', 5, 0, 0, 0, 0, 1, 'a:5:{s:8:"maxWidth";s:3:"100";s:9:"maxHeight";s:0:"";s:15:"useDistinctZoom";b:0;s:8:"makeZoom";b:1;s:14:"maxWidthPreviz";s:2:"16";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(5, 'e58e016a-0baa-102e-80e2-001a6470da26', 1, 9, 0, 'CMS_object_categories', 2, 0, 1, 0, 1, 1, 'a:6:{s:15:"multiCategories";b:0;s:12:"rootCategory";s:1:"2";s:12:"defaultValue";s:0:"";s:15:"associateUnused";b:0;s:11:"selectWidth";s:0:"";s:12:"selectHeight";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(6, 'e58e023c-0baa-102e-80e2-001a6470da26', 2, 80, 0, 'CMS_object_string', 1, 0, 1, 0, 0, 1, 'a:3:{s:9:"maxLength";s:3:"255";s:7:"isEmail";b:0;s:8:"matchExp";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(7, 'e58e0304-0baa-102e-80e2-001a6470da26', 2, 83, 0, 'CMS_object_text', 2, 0, 0, 0, 0, 1, 'a:4:{s:4:"html";b:1;s:7:"toolbar";s:9:"BasicLink";s:12:"toolbarWidth";s:4:"100%";s:13:"toolbarHeight";s:3:"200";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(8, 'e58e03d6-0baa-102e-80e2-001a6470da26', 2, 84, 0, 'CMS_object_categories', 3, 0, 1, 0, 1, 1, 'a:6:{s:15:"multiCategories";b:0;s:12:"rootCategory";s:2:"18";s:12:"defaultValue";s:0:"";s:15:"associateUnused";b:0;s:11:"selectWidth";s:0:"";s:12:"selectHeight";s:0:"";}');
INSERT INTO `mod_object_field` (`id_mof`, `uuid_mof`, `object_id_mof`, `label_id_mof`, `desc_id_mof`, `type_mof`, `order_mof`, `system_mof`, `required_mof`, `indexable_mof`, `searchlist_mof`, `searchable_mof`, `params_mof`) VALUES(9, 'e58e049e-0baa-102e-80e2-001a6470da26', 2, 85, 86, 'CMS_object_file', 4, 0, 1, 0, 1, 1, 'a:8:{s:12:"useThumbnail";b:1;s:13:"thumbMaxWidth";s:3:"200";s:14:"thumbMaxHeight";s:0:"";s:9:"fileIcons";a:18:{s:3:"doc";s:7:"doc.gif";s:3:"gif";s:7:"gif.gif";s:4:"html";s:8:"html.gif";s:3:"htm";s:8:"html.gif";s:3:"jpg";s:7:"jpg.gif";s:4:"jpeg";s:7:"jpg.gif";s:3:"jpe";s:7:"jpg.gif";s:3:"mov";s:7:"mov.gif";s:3:"mp3";s:7:"mp3.gif";s:3:"pdf";s:7:"pdf.gif";s:3:"png";s:7:"png.gif";s:3:"ppt";s:7:"ppt.gif";s:3:"pps";s:7:"ppt.gif";s:3:"swf";s:7:"swf.gif";s:3:"sxw";s:7:"sxw.gif";s:3:"url";s:7:"url.gif";s:3:"xls";s:7:"xls.gif";s:3:"xml";s:7:"xml.gif";}s:8:"allowFtp";b:0;s:6:"ftpDir";s:13:"/automne/tmp/";s:11:"allowedType";s:0:"";s:14:"disallowedType";s:31:"exe,php,pif,vbs,bat,com,scr,reg";}');

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

INSERT INTO `mod_object_plugin_definition` (`id_mowd`, `uuid_mowd`, `object_id_mowd`, `label_id_mowd`, `description_id_mowd`, `query_mowd`, `definition_mowd`, `compiled_definition_mowd`) VALUES(1, 'e59d665a-0baa-102e-80e2-001a6470da26', 2, 87, 88, 'a:1:{i:8;s:1:"0";}', '<atm-plugin language="fr">\r\n    <atm-plugin-valid>\r\n        <atm-if what="{[''object2''][''fields''][9][''fileExtension'']} != ''flv'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''mp3'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''jpg'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''gif'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''png''">\r\n			<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank" title="Télécharger le document ''{[''object2''][''fields''][9][''fileLabel'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="Fichier {[''object2''][''fields''][9][''fileExtension'']}" title="Fichier {[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''label'']}</a>\r\n		</atm-if>\r\n    	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''flv''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<script type="text/javascript" src="js/modules/pmedia/swfobject.js"></script>\r\n				<script type="text/javascript">\r\n					swfobject.addLoadEvent(function(){\r\n						swfobject.embedSWF(''automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''automne/playerflv/config_playerflv.xml'', startimage:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}''}, {allowfullscreen:true, wmode:''transparent''}, false);\r\n					});\r\n				</script>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<script type="text/javascript" src="js/modules/pmedia/swfobject.js"></script>\r\n				<script type="text/javascript">\r\n					swfobject.addLoadEvent(function(){\r\n						swfobject.embedSWF(''automne/playerflv/player_flv.swf'', ''media-{[''object2''][''id'']}'', ''320'', ''200'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {flv:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, false);\r\n					});\r\n				</script>\r\n			</atm-if>\r\n			<div id="media-{[''object2''][''id'']}" class="pmedias-video" style="width:320px;height:200px;">\r\n				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n			</div>\r\n		</atm-if>\r\n		<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''mp3''">\r\n			<script type="text/javascript" src="js/modules/pmedia/swfobject.js"></script>\r\n			<script type="text/javascript">\r\n				swfobject.addLoadEvent(function(){\r\n					swfobject.embedSWF(''automne/playermp3/player_mp3.swf'', ''media-{[''object2''][''id'']}'', ''200'', ''20'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {mp3:''{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}'', configxml:''automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, false);\r\n				});\r\n			</script>\r\n			<div id="media-{[''object2''][''id'']}" class="pmedias-audio" style="width:200px;height:20px;">\r\n				<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>\r\n			</div>\r\n		</atm-if>\r\n		<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''jpg'' || {[''object2''][''fields''][9][''fileExtension'']} == ''gif'' || {[''object2''][''fields''][9][''fileExtension'']} == ''png''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" onclick="javascript:CMS_openPopUpImage(''imagezoom.php?location=public&amp;module=pmedia&amp;file={[''object2''][''fields''][9][''filename'']}&amp;label={[''object2''][''label'']|js}'');return false;" target="_blank" title="Voir l''image ''{[''object2''][''label'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" /></a>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" style="max-width:200px;" />\r\n			</atm-if>\r\n		</atm-if>\r\n    </atm-plugin-valid>\r\n	<atm-plugin-view>\r\n        <atm-if what="{[''object2''][''fields''][9][''fileExtension'']} != ''jpg'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''gif'' &amp;&amp; {[''object2''][''fields''][9][''fileExtension'']} != ''png''">\r\n			<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank" title="Télécharger le document ''{[''object2''][''fields''][9][''fileLabel'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="Fichier {[''object2''][''fields''][9][''fileExtension'']}" title="Fichier {[''object2''][''fields''][9][''fileExtension'']}" /></atm-if> {[''object2''][''label'']}</a>\r\n		</atm-if>\r\n    	<atm-if what="{[''object2''][''fields''][9][''fileExtension'']} == ''jpg'' || {[''object2''][''fields''][9][''fileExtension'']} == ''gif'' || {[''object2''][''fields''][9][''fileExtension'']} == ''png''">\r\n			<atm-if what="{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" onclick="javascript:CMS_openPopUpImage(''imagezoom.php?location=public&amp;module=pmedia&amp;file={[''object2''][''fields''][9][''filename'']}&amp;label={[''object2''][''label'']|js}'');return false;" target="_blank" title="Voir l''image ''{[''object2''][''label'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''thumbnail'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" /></a>\r\n			</atm-if>\r\n			<atm-if what="!{[''object2''][''fields''][9][''thumbnail'']}">\r\n				<img src="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" alt="{[''object2''][''label'']}" title="{[''object2''][''label'']}" style="max-width:200px;" />\r\n			</atm-if>\r\n		</atm-if>\r\n    </atm-plugin-view>\r\n</atm-plugin>', '<?php\n/*Generated on Fri, 10 Sep 2010 16:24:38 +0200 by Automne (TM) 4.1.0a1 */\nif(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, ''CMS_profile_user'') && $cms_user->hasModuleClearance(''pmedia'', CLEARANCE_MODULE_VIEW))){\n	$content = "";\n	$replace = "";\n	$atmIfResults = array();\n	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();\n	$parameters[''objectID''] = 2;\n	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != ''fr'')) $cms_language = new CMS_language(''fr'');\n	$parameters[''public''] = (isset($parameters[''public''])) ? $parameters[''public''] : true;\n	if (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\n	if (!isset($object) || !is_array($object)) $object = array();\n	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters[''public'']);\n	$parameters[''module''] = ''pmedia'';\n	//PLUGIN TAG START 19_c26d5b\n	if (!sensitiveIO::isPositiveInteger($parameters[''itemID'']) || !sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n		CMS_grandFather::raiseError(''Error into atm-plugin tag : can\\''t found object infos to use into : $parameters[\\''itemID\\''] and $parameters[\\''objectID\\'']'');\n	} else {\n		//search needed object (need to search it for publications and rights purpose)\n		if (!isset($objectDefinitions[$parameters[''objectID'']])) {\n			$objectDefinitions[$parameters[''objectID'']] = new CMS_poly_object_definition($parameters[''objectID'']);\n		}\n		$search_19_c26d5b = new CMS_object_search($objectDefinitions[$parameters[''objectID'']], $parameters[''public'']);\n		$search_19_c26d5b->addWhereCondition(''item'', $parameters[''itemID'']);\n		$results_19_c26d5b = $search_19_c26d5b->search();\n		if (isset($results_19_c26d5b[$parameters[''itemID'']]) && is_object($results_19_c26d5b[$parameters[''itemID'']])) {\n			$object[$parameters[''objectID'']] = $results_19_c26d5b[$parameters[''itemID'']];\n		} else {\n			$object[$parameters[''objectID'']] = new CMS_poly_object($parameters[''objectID''], 0, array(), $parameters[''public'']);\n		}\n		unset($search_19_c26d5b);\n		$parameters[''has-plugin-view''] = true;\n		//PLUGIN-VALID TAG START 20_f8e4cf\n		if ($object[$parameters[''objectID'']]->isInUserSpace() && !(@$parameters[''plugin-view''] && @$parameters[''has-plugin-view'']) ) {\n			//IF TAG START 21_2ba10b\n			$ifcondition_21_2ba10b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''flv'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''mp3'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''jpg'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''gif'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''png''", $replace);\n			if ($ifcondition_21_2ba10b) {\n				$func_21_2ba10b = create_function("","return (".$ifcondition_21_2ba10b.");");\n				if ($func_21_2ba10b()) {\n					$content .="\n					<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Télécharger le document ''".$object[2]->objectValues(9)->getValue(''fileLabel'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\">";\n					//IF TAG START 22_dc2c5f\n					$ifcondition_22_dc2c5f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileIcon'','''')), $replace);\n					if ($ifcondition_22_dc2c5f) {\n						$func_22_dc2c5f = create_function("","return (".$ifcondition_22_dc2c5f.");");\n						if ($func_22_dc2c5f()) {\n							$content .="<img src=\\"".$object[2]->objectValues(9)->getValue(''fileIcon'','''')."\\" alt=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" title=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" />";\n						}\n						unset($func_22_dc2c5f);\n					}\n					unset($ifcondition_22_dc2c5f);\n					//IF TAG END 22_dc2c5f\n					$content .=" ".$object[2]->getValue(''label'','''')."</a>\n					";\n				}\n				unset($func_21_2ba10b);\n			}\n			unset($ifcondition_21_2ba10b);\n			//IF TAG END 21_2ba10b\n			//IF TAG START 23_2733df\n			$ifcondition_23_2733df = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''flv''", $replace);\n			if ($ifcondition_23_2733df) {\n				$func_23_2733df = create_function("","return (".$ifcondition_23_2733df.");");\n				if ($func_23_2733df()) {\n					//IF TAG START 24_9dabcb\n					$ifcondition_24_9dabcb = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_24_9dabcb) {\n						$func_24_9dabcb = create_function("","return (".$ifcondition_24_9dabcb.");");\n						if ($func_24_9dabcb()) {\n							$content .="\n							<script type=\\"text/javascript\\" src=\\"js/modules/pmedia/swfobject.js\\"></script>\n							<script type=\\"text/javascript\\">\n							swfobject.addLoadEvent(function(){\n								swfobject.embedSWF(''automne/playerflv/player_flv.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''320'', ''200'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {flv:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''automne/playerflv/config_playerflv.xml'', startimage:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."''}, {allowfullscreen:true, wmode:''transparent''}, false);\n							});\n							</script>\n							";\n						}\n						unset($func_24_9dabcb);\n					}\n					unset($ifcondition_24_9dabcb);\n					//IF TAG END 24_9dabcb\n					//IF TAG START 25_641ef5\n					$ifcondition_25_641ef5 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_25_641ef5) {\n						$func_25_641ef5 = create_function("","return (".$ifcondition_25_641ef5.");");\n						if ($func_25_641ef5()) {\n							$content .="\n							<script type=\\"text/javascript\\" src=\\"js/modules/pmedia/swfobject.js\\"></script>\n							<script type=\\"text/javascript\\">\n							swfobject.addLoadEvent(function(){\n								swfobject.embedSWF(''automne/playerflv/player_flv.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''320'', ''200'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {flv:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''automne/playerflv/config_playerflv.xml''}, {allowfullscreen:true, wmode:''transparent''}, false);\n							});\n							</script>\n							";\n						}\n						unset($func_25_641ef5);\n					}\n					unset($ifcondition_25_641ef5);\n					//IF TAG END 25_641ef5\n					$content .="\n					<div id=\\"media-".$object[2]->getValue(''id'','''')."\\" class=\\"pmedias-video\\" style=\\"width:320px;height:200px;\\">\n					<p><a href=\\"http://www.adobe.com/go/getflashplayer\\"><img src=\\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\\" alt=\\"Get Adobe Flash player\\" /></a></p>\n					</div>\n					";\n				}\n				unset($func_23_2733df);\n			}\n			unset($ifcondition_23_2733df);\n			//IF TAG END 23_2733df\n			//IF TAG START 26_b69974\n			$ifcondition_26_b69974 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''mp3''", $replace);\n			if ($ifcondition_26_b69974) {\n				$func_26_b69974 = create_function("","return (".$ifcondition_26_b69974.");");\n				if ($func_26_b69974()) {\n					$content .="\n					<script type=\\"text/javascript\\" src=\\"js/modules/pmedia/swfobject.js\\"></script>\n					<script type=\\"text/javascript\\">\n					swfobject.addLoadEvent(function(){\n						swfobject.embedSWF(''automne/playermp3/player_mp3.swf'', ''media-".$object[2]->getValue(''id'','''')."'', ''200'', ''20'', ''9.0.0'', ''automne/swfobject/expressInstall.swf'', {mp3:''".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."'', configxml:''automne/playermp3/config_playermp3.xml''}, {wmode:''transparent''}, false);\n					});\n					</script>\n					<div id=\\"media-".$object[2]->getValue(''id'','''')."\\" class=\\"pmedias-audio\\" style=\\"width:200px;height:20px;\\">\n					<p><a href=\\"http://www.adobe.com/go/getflashplayer\\"><img src=\\"http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif\\" alt=\\"Get Adobe Flash player\\" /></a></p>\n					</div>\n					";\n				}\n				unset($func_26_b69974);\n			}\n			unset($ifcondition_26_b69974);\n			//IF TAG END 26_b69974\n			//IF TAG START 27_a99ad3\n			$ifcondition_27_a99ad3 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''jpg'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''gif'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''png''", $replace);\n			if ($ifcondition_27_a99ad3) {\n				$func_27_a99ad3 = create_function("","return (".$ifcondition_27_a99ad3.");");\n				if ($func_27_a99ad3()) {\n					//IF TAG START 28_3d0b5c\n					$ifcondition_28_3d0b5c = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_28_3d0b5c) {\n						$func_28_3d0b5c = create_function("","return (".$ifcondition_28_3d0b5c.");");\n						if ($func_28_3d0b5c()) {\n							$content .="\n							<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" onclick=\\"javascript:CMS_openPopUpImage(''imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue(''filename'','''')."&amp;label=".$object[2]->getValue(''label'',''js'')."'');return false;\\" target=\\"_blank\\" title=\\"Voir l''image ''".$object[2]->getValue(''label'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\"><img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" /></a>\n							";\n						}\n						unset($func_28_3d0b5c);\n					}\n					unset($ifcondition_28_3d0b5c);\n					//IF TAG END 28_3d0b5c\n					//IF TAG START 29_d110ce\n					$ifcondition_29_d110ce = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_29_d110ce) {\n						$func_29_d110ce = create_function("","return (".$ifcondition_29_d110ce.");");\n						if ($func_29_d110ce()) {\n							$content .="\n							<img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" style=\\"max-width:200px;\\" />\n							";\n						}\n						unset($func_29_d110ce);\n					}\n					unset($ifcondition_29_d110ce);\n					//IF TAG END 29_d110ce\n				}\n				unset($func_27_a99ad3);\n			}\n			unset($ifcondition_27_a99ad3);\n			//IF TAG END 27_a99ad3\n		}\n		//PLUGIN-VALID END 20_f8e4cf\n		//PLUGIN-VIEW TAG START 30_99ef4a\n		if ($object[$parameters[''objectID'']]->isInUserSpace() && isset($parameters[''plugin-view''])) {\n			//IF TAG START 31_c4056b\n			$ifcondition_31_c4056b = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''jpg'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''gif'' && ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." != ''png''", $replace);\n			if ($ifcondition_31_c4056b) {\n				$func_31_c4056b = create_function("","return (".$ifcondition_31_c4056b.");");\n				if ($func_31_c4056b()) {\n					$content .="\n					<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Télécharger le document ''".$object[2]->objectValues(9)->getValue(''fileLabel'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\">";\n					//IF TAG START 32_349872\n					$ifcondition_32_349872 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileIcon'','''')), $replace);\n					if ($ifcondition_32_349872) {\n						$func_32_349872 = create_function("","return (".$ifcondition_32_349872.");");\n						if ($func_32_349872()) {\n							$content .="<img src=\\"".$object[2]->objectValues(9)->getValue(''fileIcon'','''')."\\" alt=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" title=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" />";\n						}\n						unset($func_32_349872);\n					}\n					unset($ifcondition_32_349872);\n					//IF TAG END 32_349872\n					$content .=" ".$object[2]->getValue(''label'','''')."</a>\n					";\n				}\n				unset($func_31_c4056b);\n			}\n			unset($ifcondition_31_c4056b);\n			//IF TAG END 31_c4056b\n			//IF TAG START 33_af8798\n			$ifcondition_33_af8798 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''jpg'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''gif'' || ".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileExtension'',''''))." == ''png''", $replace);\n			if ($ifcondition_33_af8798) {\n				$func_33_af8798 = create_function("","return (".$ifcondition_33_af8798.");");\n				if ($func_33_af8798()) {\n					//IF TAG START 34_416dd8\n					$ifcondition_34_416dd8 = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_34_416dd8) {\n						$func_34_416dd8 = create_function("","return (".$ifcondition_34_416dd8.");");\n						if ($func_34_416dd8()) {\n							$content .="\n							<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" onclick=\\"javascript:CMS_openPopUpImage(''imagezoom.php?location=public&amp;module=pmedia&amp;file=".$object[2]->objectValues(9)->getValue(''filename'','''')."&amp;label=".$object[2]->getValue(''label'',''js'')."'');return false;\\" target=\\"_blank\\" title=\\"Voir l''image ''".$object[2]->getValue(''label'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\"><img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''thumbnail'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" /></a>\n							";\n						}\n						unset($func_34_416dd8);\n					}\n					unset($ifcondition_34_416dd8);\n					//IF TAG END 34_416dd8\n					//IF TAG START 35_d48ca4\n					$ifcondition_35_d48ca4 = CMS_polymod_definition_parsing::replaceVars("!".CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''thumbnail'','''')), $replace);\n					if ($ifcondition_35_d48ca4) {\n						$func_35_d48ca4 = create_function("","return (".$ifcondition_35_d48ca4.");");\n						if ($func_35_d48ca4()) {\n							$content .="\n							<img src=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" alt=\\"".$object[2]->getValue(''label'','''')."\\" title=\\"".$object[2]->getValue(''label'','''')."\\" style=\\"max-width:200px;\\" />\n							";\n						}\n						unset($func_35_d48ca4);\n					}\n					unset($ifcondition_35_d48ca4);\n					//IF TAG END 35_d48ca4\n				}\n				unset($func_33_af8798);\n			}\n			unset($ifcondition_33_af8798);\n			//IF TAG END 33_af8798\n		}\n		//PLUGIN-VIEW END 30_99ef4a\n		$content .="\n		";\n	}\n	//PLUGIN TAG END 19_c26d5b\n	$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);\n	$content .= ''<!--{elements:''.base64_encode(serialize(array (\n		''module'' =>\n		array (\n			0 => ''pmedia'',\n		),\n	))).''}-->'';\n	echo $content;\n	unset($content);}\n	?>');
INSERT INTO `mod_object_plugin_definition` (`id_mowd`, `uuid_mowd`, `object_id_mowd`, `label_id_mowd`, `description_id_mowd`, `query_mowd`, `definition_mowd`, `compiled_definition_mowd`) VALUES(2, 'e59d688a-0baa-102e-80e2-001a6470da26', 2, 89, 90, 'a:1:{i:8;s:1:"0";}', '<atm-plugin language="fr">\r\n    <atm-plugin-valid>\r\n        <a href="{[''object2''][''fields''][9][''filePath'']}/{[''object2''][''fields''][9][''filename'']}" target="_blank" title="Télécharger le document ''{[''object2''][''fields''][9][''fileLabel'']}'' ({[''object2''][''fields''][9][''fileExtension'']} - {[''object2''][''fields''][9][''fileSize'']}Mo)"><atm-if what="{[''object2''][''fields''][9][''fileIcon'']}"><img src="{[''object2''][''fields''][9][''fileIcon'']}" alt="Fichier {[''object2''][''fields''][9][''fileExtension'']}" title="Fichier {[''object2''][''fields''][9][''fileExtension'']}" /> </atm-if>{plugin:selection}</a>\r\n    </atm-plugin-valid>\r\n	<atm-plugin-invalid>\r\n        {plugin:selection}\r\n    </atm-plugin-invalid>\r\n</atm-plugin>', '<?php\n/*Generated on Fri, 10 Sep 2010 16:15:25 +0200 by Automne (TM) 4.1.0a1 */\nif(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, ''CMS_profile_user'') && $cms_user->hasModuleClearance(''pmedia'', CLEARANCE_MODULE_VIEW))){\n	$content = "";\n	$replace = "";\n	$atmIfResults = array();\n	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();\n	$parameters[''objectID''] = 2;\n	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != ''fr'')) $cms_language = new CMS_language(''fr'');\n	$parameters[''public''] = (isset($parameters[''public''])) ? $parameters[''public''] : true;\n	if (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\n	if (!isset($object) || !is_array($object)) $object = array();\n	if (!isset($object[2])) $object[2] = new CMS_poly_object(2, 0, array(), $parameters[''public'']);\n	$parameters[''module''] = ''pmedia'';\n	//PLUGIN TAG START 19_487018\n	if (!sensitiveIO::isPositiveInteger($parameters[''itemID'']) || !sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n		CMS_grandFather::raiseError(''Error into atm-plugin tag : can\\''t found object infos to use into : $parameters[\\''itemID\\''] and $parameters[\\''objectID\\'']'');\n	} else {\n		//search needed object (need to search it for publications and rights purpose)\n		if (!isset($objectDefinitions[$parameters[''objectID'']])) {\n			$objectDefinitions[$parameters[''objectID'']] = new CMS_poly_object_definition($parameters[''objectID'']);\n		}\n		$search_19_487018 = new CMS_object_search($objectDefinitions[$parameters[''objectID'']], $parameters[''public'']);\n		$search_19_487018->addWhereCondition(''item'', $parameters[''itemID'']);\n		$results_19_487018 = $search_19_487018->search();\n		if (isset($results_19_487018[$parameters[''itemID'']]) && is_object($results_19_487018[$parameters[''itemID'']])) {\n			$object[$parameters[''objectID'']] = $results_19_487018[$parameters[''itemID'']];\n		} else {\n			$object[$parameters[''objectID'']] = new CMS_poly_object($parameters[''objectID''], 0, array(), $parameters[''public'']);\n		}\n		unset($search_19_487018);\n		$parameters[''has-plugin-view''] = false;\n		//PLUGIN-VALID TAG START 20_b2b83c\n		if ($object[$parameters[''objectID'']]->isInUserSpace() && !(@$parameters[''plugin-view''] && @$parameters[''has-plugin-view'']) ) {\n			$content .="\n			<a href=\\"".$object[2]->objectValues(9)->getValue(''filePath'','''')."/".$object[2]->objectValues(9)->getValue(''filename'','''')."\\" target=\\"_blank\\" title=\\"Télécharger le document ''".$object[2]->objectValues(9)->getValue(''fileLabel'','''')."'' (".$object[2]->objectValues(9)->getValue(''fileExtension'','''')." - ".$object[2]->objectValues(9)->getValue(''fileSize'','''')."Mo)\\">";\n			//IF TAG START 21_e8319f\n			$ifcondition_21_e8319f = CMS_polymod_definition_parsing::replaceVars(CMS_polymod_definition_parsing::prepareVar($object[2]->objectValues(9)->getValue(''fileIcon'','''')), $replace);\n			if ($ifcondition_21_e8319f) {\n				$func_21_e8319f = create_function("","return (".$ifcondition_21_e8319f.");");\n				if ($func_21_e8319f()) {\n					$content .="<img src=\\"".$object[2]->objectValues(9)->getValue(''fileIcon'','''')."\\" alt=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" title=\\"Fichier ".$object[2]->objectValues(9)->getValue(''fileExtension'','''')."\\" /> ";\n				}\n				unset($func_21_e8319f);\n			}\n			unset($ifcondition_21_e8319f);\n			//IF TAG END 21_e8319f\n			$content .=$parameters[''selection'']."</a>\n			";\n		}\n		//PLUGIN-VALID END 20_b2b83c\n		//PLUGIN-INVALID TAG START 22_0ed0d3\n		if (!$object[$parameters[''objectID'']]->isInUserSpace()) {\n			$content .="\n			".$parameters[''selection'']."\n			";\n		}\n		//PLUGIN-INVALID END 22_0ed0d3\n		$content .="\n		";\n	}\n	//PLUGIN TAG END 19_487018\n	$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);\n	$content .= ''<!--{elements:''.base64_encode(serialize(array (\n		''module'' =>\n		array (\n			0 => ''pmedia'',\n		),\n	))).''}-->'';\n	echo $content;\n	unset($content);}\n	?>');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_object_polyobjects`
--

INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(4, 1, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(17, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(24, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(25, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(26, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(27, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(28, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(29, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(34, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(35, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(36, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(37, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(38, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(39, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(40, 2, 0);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(41, 1, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(42, 1, 1);
INSERT INTO `mod_object_polyobjects` (`id_moo`, `object_type_id_moo`, `deleted_moo`) VALUES(43, 2, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_object_rss_definition`
--

INSERT INTO `mod_object_rss_definition` (`id_mord`, `uuid_mord`, `object_id_mord`, `label_id_mord`, `description_id_mord`, `link_mord`, `author_mord`, `copyright_mord`, `categories_mord`, `ttl_mord`, `email_mord`, `definition_mord`, `compiled_definition_mord`, `last_compilation_mord`) VALUES(3, 'e5a7a52a-0baa-102e-80e2-001a6470da26', 1, 40, 41, '', '', '', '', 1440, '', '<atm-rss language="fr">\r\n    <atm-rss-title>Actualités du site démo d''Automne</atm-rss-title>\r\n    <atm-search what="{[''object1'']}" name="rss">\r\n        <atm-search-order search="rss" type="publication date after" direction="desc" />\r\n        <atm-result search="rss">\r\n            <atm-rss-item>\r\n                <atm-rss-item-url>{page:5:url}?item={[''object1''][''id'']}</atm-rss-item-url>\r\n                <atm-rss-item-title>{[''object1''][''fields''][1][''value'']}</atm-rss-item-title>\r\n                <atm-rss-item-content>{[''object1''][''fields''][2][''htmlvalue'']}</atm-rss-item-content>\r\n                <atm-rss-item-date>{[''object1''][''formatedDateStart'']|rss}</atm-rss-item-date>\r\n            </atm-rss-item>\r\n        </atm-result>\r\n    </atm-search>\r\n</atm-rss>', '<?php\n//Generated by : $Id: automne4.sql,v 1.24 2010/02/01 16:16:39 sebastien Exp $\nif(!APPLICATION_ENFORCES_ACCESS_CONTROL || (isset($cms_user) && is_a($cms_user, ''CMS_profile_user'') && $cms_user->hasModuleClearance(''pnews'', CLEARANCE_MODULE_VIEW))){\n	$content = "";\n	$replace = "";\n	if (!isset($objectDefinitions) || !is_array($objectDefinitions)) $objectDefinitions = array();\n	$parameters[''objectID''] = 1;\n	if (!isset($cms_language) || (isset($cms_language) && $cms_language->getCode() != ''fr'')) $cms_language = new CMS_language(''fr'');\n	$parameters[''public''] = true;\n	if (isset($parameters[''item''])) {$parameters[''objectID''] = $parameters[''item'']->getObjectID();} elseif (isset($parameters[''itemID'']) && sensitiveIO::isPositiveInteger($parameters[''itemID'']) && !isset($parameters[''objectID''])) $parameters[''objectID''] = CMS_poly_object_catalog::getObjectDefinitionByID($parameters[''itemID'']);\n	if (!isset($object) || !is_array($object)) $object = array();\n	if (!isset($object[1])) $object[1] = new CMS_poly_object(1, 0, array(), $parameters[''public'']);\n	$parameters[''module''] = ''pnews'';\n	//RSS TAG START 23_82024b\n	if (!sensitiveIO::isPositiveInteger($parameters[''objectID''])) {\n		CMS_grandFather::raiseError(''Error into atm-rss tag : can\\''t found object infos to use into : $parameters[\\''objectID\\'']'');\n	} else {\n		//RSS-ITEM-TITLE TAG START 24_d5de16\n		$content .= ''<title>'';\n		//save content\n		$content_24_d5de16 = $content;\n		$content = '''';\n		$content .="Actualités du site démo d''Automne";\n		//then remove tags from content and add it to old content\n		$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n		$content = $content_24_d5de16.str_replace(array_keys($entities),$entities,strip_tags(io::decodeEntities($content)));\n		$content .= ''</title>'';\n		//RSS-ITEM-TITLE TAG END 24_d5de16\n		//SEARCH rss TAG START 25_066efa\n		$objectDefinition_rss = ''1'';\n		if (!isset($objectDefinitions[$objectDefinition_rss])) {\n			$objectDefinitions[$objectDefinition_rss] = new CMS_poly_object_definition($objectDefinition_rss);\n		}\n		//public search ?\n		$public_25_066efa = isset($public_search) ? $public_search : false;\n		//get search params\n		$search_rss = new CMS_object_search($objectDefinitions[$objectDefinition_rss], $public_25_066efa);\n		$launchSearch_rss = true;\n		//add search conditions if any\n		$search_rss->addOrderCondition("publication date after", "desc");\n		//RESULT rss TAG START 26_ad7b7d\n		//launch search rss if not already done\n		if($launchSearch_rss && !isset($results_rss)) {\n			if (isset($search_rss)) {\n				$results_rss = $search_rss->search();\n			} else {\n				CMS_grandFather::raiseError("Malformed atm-result tag : can''t use this tag outside of atm-search \\"rss\\" tag ...");\n				$results_rss = array();\n			}\n		} elseif (!$launchSearch_rss) {\n			$results_rss = array();\n		}\n		if ($results_rss) {\n			$object_26_ad7b7d = (isset($object[$objectDefinition_rss])) ? $object[$objectDefinition_rss] : ""; //save previous object search if any\n			$replace_26_ad7b7d = $replace; //save previous replace vars if any\n			$count_26_ad7b7d = 0;\n			$content_26_ad7b7d = $content; //save previous content var if any\n			$maxPages_26_ad7b7d = $search_rss->getMaxPages();\n			$maxResults_26_ad7b7d = $search_rss->getNumRows();\n			foreach ($results_rss as $object[$objectDefinition_rss]) {\n				$content = "";\n				$replace["atm-search"] = array (\n					"{resultid}" 	=> (isset($resultID_rss)) ? $resultID_rss : $object[$objectDefinition_rss]->getID(),\n					"{firstresult}" => (!$count_26_ad7b7d) ? 1 : 0,\n					"{lastresult}" 	=> ($count_26_ad7b7d == sizeof($results_rss)-1) ? 1 : 0,\n					"{resultcount}" => ($count_26_ad7b7d+1),\n					"{maxpages}"    => $maxPages_26_ad7b7d,\n					"{currentpage}" => ($search_rss->getAttribute(''page'')+1),\n					"{maxresults}"  => $maxResults_26_ad7b7d,\n				);\n				//RSS-ITEM TAG START 27_2e0a20\n				$content .= ''<item>\n				<guid isPermaLink="false">object''.$parameters[''objectID''].''-''.$object[$parameters[''objectID'']]->getID().''</guid>'';\n				//RSS-ITEM-LINK TAG START 28_f1e3bf\n				$content .= ''<link>'';\n				//save content\n				$content_28_f1e3bf = $content;\n				$content = '''';\n				$content .=CMS_tree::getPageValue("5","url")."?item=".$object[1]->getValue(''id'','''');\n				//then remove tags from content and add it to old content\n				$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n				$content = $content_28_f1e3bf.str_replace(array_keys($entities),$entities,strip_tags(io::decodeEntities($content)));\n				$content .= ''</link>'';\n				//RSS-ITEM-LINK TAG END 28_f1e3bf\n				//RSS-ITEM-TITLE TAG START 29_30c1f8\n				$content .= ''<title>'';\n				//save content\n				$content_29_30c1f8 = $content;\n				$content = '''';\n				$content .=$object[1]->objectValues(1)->getValue(''value'','''');\n				//then remove tags from content and add it to old content\n				$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n				$content = $content_29_30c1f8.str_replace(array_keys($entities),$entities,strip_tags(io::decodeEntities($content)));\n				$content .= ''</title>'';\n				//RSS-ITEM-TITLE TAG END 29_30c1f8\n				//RSS-ITEM-DESCRIPTION TAG START 30_97b8fc\n				$content .= ''<description>'';\n				$content .= ''<![CDATA['';\n				$content .=$object[1]->objectValues(2)->getValue(''htmlvalue'','''');\n				$content .= '']]>'';\n				$content .= ''</description>'';\n				//RSS-ITEM-DESCRIPTION TAG END 30_97b8fc\n				//RSS-ITEM-PUBDATE TAG START 31_57d809\n				$content .= ''<pubDate>'';\n				//save content\n				$content_31_57d809 = $content;\n				$content = '''';\n				$content .=$object[1]->getValue(''formatedDateStart'',''rss'');\n				//then remove tags from content and add it to old content\n				$entities = array(''&'' => ''&amp;'',''>'' => ''&gt;'',''<'' => ''&lt;'',);\n				$content = $content_31_57d809.str_replace(array_keys($entities),$entities,strip_tags(io::decodeEntities($content)));\n				$content .= ''</pubDate>'';\n				//RSS-ITEM-PUBDATE TAG END 31_57d809\n				$content .= ''</item>'';\n				//RSS-ITEM TAG END 27_2e0a20\n				$count_26_ad7b7d++;\n				//do all result vars replacement\n				$content_26_ad7b7d.= CMS_polymod_definition_parsing::replaceVars($content, $replace);\n			}\n			$content = $content_26_ad7b7d; //retrieve previous content var if any\n			$replace = $replace_26_ad7b7d; //retrieve previous replace vars if any\n			$object[$objectDefinition_rss] = $object_26_ad7b7d; //retrieve previous object search if any\n		}\n		//RESULT rss TAG END 26_ad7b7d\n		//destroy search and results rss objects\n		unset($search_rss);\n		unset($results_rss);\n		//SEARCH rss TAG END 25_066efa\n		$content .="\n		";\n	}\n	//RSS TAG END 23_82024b\n	echo CMS_polymod_definition_parsing::replaceVars($content, $replace);\n}\n?>', '2010-02-01 16:33:43');

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

INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '65990b9ff00394714dd60ffd708b2d77', 70, 6);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(58, 'first', '8910cceb3902f8e5b364ac872a452570', 70, 3);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(88, 'first', '7448f10ee9579c5f0de5616d06e7b7f2', 44, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(64, 'first', '85e7287f61fa20d9cd0d0adabbef07d1', 54, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(65, 'first', 'aa09fe3cdbc32c9b9b7808a6ae073f604', 55, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '67834d6b4d508349b9b2892e4932e718', 43, 5);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(94, 'first', '3c1cf8ef8f25de1ae96706a2585bffb7', 69, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(82, 'first', '267e03d5f6a4d0392b79a2d31dcd40f2', 69, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(92, 'first', '718dfb04e3bd006a81604b9ccdf448cf', 44, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '48e8e4c2bea88305e6a9353511f51ea7', 69, 4);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(58, 'first', 'ef68332801171f3678986a9192ea85db', 67, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(58, 'first', '947a9a22e4eefe4a486202ab6005f8b5', 69, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(58, 'first', 'e41e88d5ba9dc4da5ec2772895543861', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(81, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(84, 'first', 'f863b4e5ea5a0c8019440ff99e59e29f', 44, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(84, 'first', '4564d92b193505d71f29b5ae69dddde0', 44, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(83, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(85, 'first', '9ba530cba11a3763a081a2e34072711f', 69, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(86, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(87, 'first', 'dda8207197eda19c8be4b1f63d76b382', 44, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(93, 'first', '198690666d878af31b7d27d2f4c1cfd3', 67, 3);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(93, 'first', '472f95744f761c8f816f68cd59cf28a8', 46, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(93, 'first', '8d1b3ec256dada4f0c811896050fdc9f', 45, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(61, 'first', 'a23554f135ed742872910b38a70131cf3', 58, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(62, 'first', 'a1ba42094f9b45486a0338b5eea859dfb', 68, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(91, 'first', '592c2e33c7971c02ec553000d0eaea43', 44, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(57, 'first', 'a0922acb28a233e527aa46607bfec987c', 44, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(93, 'first', '53a2f135735e315515920da75a688354', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(94, 'first', '06557a802a64033c07bee90915ce3a93', 44, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(87, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(57, 'first', 'a5dc59c9028fd290e4f240131991fa8a2', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '23ba8857d961fd78dc2ff56bb56e39e7', 45, 7);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '409d0a2f5060ddb2747151da5e264f99', 44, 6);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '39a32afb98d21c8252ea3714cff0f62e', 69, 4);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(57, 'second', 'a149c4ef608130b6963fff950126d8690', 66, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(90, 'first', '12ea6baf8092e5e6c7abb476cf71ce08', 44, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(90, 'first', 'adbbb020aeadb2df9957a83e19e55211', 44, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(65, 'first', '17a6be4c940c12530cfaecfb2eb6b828', 44, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(92, 'first', '18f076b2de7e3b4310097f83ac547533', 43, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(85, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(92, 'first', '9f851c9d1868ad933f280c33e5a419f3', 69, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(82, 'first', '508f7be6da1c7022ae3df00f30190e49', 44, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(82, 'first', 'f87771b9821f911d00f29d8d494a055b', 45, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '229fdaa261c7fed31f048dc9f7d1c95d', 43, 3);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '4f342492c25a2b686c2b531760008d98', 70, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', 'e76f4966a4808ea827d71853fd371ee3', 43, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '8d1b3ec256dada4f0c811896050fdc9f', 45, 0);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(84, 'first', '56025a9b887be03112111d215ca6f31d', 69, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '401937687b65ea5c249faa74f4e23c9a', 69, 5);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '6ff77816cb91134d254f1b0723fa0022', 44, 3);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', 'f2c8532eb6f56afe1d435350eebd9a52', 69, 1);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', 'c44b397b36f4839fd7bba0c769b5e56e', 44, 2);
INSERT INTO `mod_standard_clientSpaces_edited` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '71b5c89dda723156165f086098957ded', 43, 0);

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

INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(61, 'first', 'a23554f135ed742872910b38a70131cf3', 58, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(64, 'first', '85e7287f61fa20d9cd0d0adabbef07d1', 54, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(65, 'first', 'aa09fe3cdbc32c9b9b7808a6ae073f604', 55, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(82, 'first', 'f87771b9821f911d00f29d8d494a055b', 45, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(94, 'first', '3c1cf8ef8f25de1ae96706a2585bffb7', 69, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(92, 'first', '18f076b2de7e3b4310097f83ac547533', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(84, 'first', '4564d92b193505d71f29b5ae69dddde0', 44, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(81, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(83, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(86, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(84, 'first', '56025a9b887be03112111d215ca6f31d', 69, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(87, 'first', 'dda8207197eda19c8be4b1f63d76b382', 44, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(93, 'first', '472f95744f761c8f816f68cd59cf28a8', 46, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(93, 'first', '8d1b3ec256dada4f0c811896050fdc9f', 45, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(93, 'first', '53a2f135735e315515920da75a688354', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(62, 'first', 'a1ba42094f9b45486a0338b5eea859dfb', 68, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(91, 'first', '592c2e33c7971c02ec553000d0eaea43', 44, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(57, 'first', 'a5dc59c9028fd290e4f240131991fa8a2', 43, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(88, 'first', '7448f10ee9579c5f0de5616d06e7b7f2', 44, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(93, 'first', '198690666d878af31b7d27d2f4c1cfd3', 67, 3);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(84, 'first', 'f863b4e5ea5a0c8019440ff99e59e29f', 44, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(94, 'first', '06557a802a64033c07bee90915ce3a93', 44, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(87, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(57, 'second', 'a149c4ef608130b6963fff950126d8690', 66, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(90, 'first', '12ea6baf8092e5e6c7abb476cf71ce08', 44, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '23ba8857d961fd78dc2ff56bb56e39e7', 45, 7);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '409d0a2f5060ddb2747151da5e264f99', 44, 6);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '401937687b65ea5c249faa74f4e23c9a', 69, 5);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(90, 'first', 'adbbb020aeadb2df9957a83e19e55211', 44, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '39a32afb98d21c8252ea3714cff0f62e', 69, 4);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(65, 'first', '17a6be4c940c12530cfaecfb2eb6b828', 44, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '6ff77816cb91134d254f1b0723fa0022', 44, 3);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(92, 'first', '718dfb04e3bd006a81604b9ccdf448cf', 44, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(82, 'first', '267e03d5f6a4d0392b79a2d31dcd40f2', 69, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(82, 'first', '508f7be6da1c7022ae3df00f30190e49', 44, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(85, 'first', '9ba530cba11a3763a081a2e34072711f', 69, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '8d1b3ec256dada4f0c811896050fdc9f', 45, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', 'e76f4966a4808ea827d71853fd371ee3', 43, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '4f342492c25a2b686c2b531760008d98', 70, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '229fdaa261c7fed31f048dc9f7d1c95d', 43, 3);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '48e8e4c2bea88305e6a9353511f51ea7', 69, 4);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '67834d6b4d508349b9b2892e4932e718', 43, 5);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(95, 'first', '65990b9ff00394714dd60ffd708b2d77', 70, 6);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(57, 'first', 'a0922acb28a233e527aa46607bfec987c', 44, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(85, 'first', 'ac2acfd1b03fd3839ffd4502484cbbfa6', 45, 0);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(92, 'first', '9f851c9d1868ad933f280c33e5a419f3', 69, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', 'c44b397b36f4839fd7bba0c769b5e56e', 44, 2);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', 'f2c8532eb6f56afe1d435350eebd9a52', 69, 1);
INSERT INTO `mod_standard_clientSpaces_public` (`template_cs`, `tagID_cs`, `rowsDefinition_cs`, `type_cs`, `order_cs`) VALUES(59, 'first', '71b5c89dda723156165f086098957ded', 43, 0);

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

INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(25, 'e5ae86ce-0baa-102e-80e2-001a6470da26', '000 Exemple', 'r25_Complet.xml', 'standard', '', 'nopicto.gif', 'Cette rangée regroupe des exemples des différents types de blocs à votre disposition : chaîne de caractères, texte, image, fichier, animation Flash', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(46, 'e5ae8a0c-0baa-102e-80e2-001a6470da26', '220 Texte et Image Gauche', 'r46_220_Texte_et_Image_Gauche.xml', 'standard', '', 'text-img-left.gif', 'Cette rangée permet d''insérer du texte qu''on pourra mettre en forme via l''éditeur Wysiwyg et elle permet d''insérer en plus une image alignée sur le côté gauche', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(45, 'e5ae8d0e-0baa-102e-80e2-001a6470da26', '210 Texte et Image Droite', 'r45_210_Texte__image_droite.xml', 'standard', '', 'text-img-right.gif', 'Cette rangée permet d''insérer du texte qu''on pourra mettre en forme via l''éditeur Wysiwyg et elle permet d''insérer en plus une image alignée sur le côté droit', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(44, 'e5ae9042-0baa-102e-80e2-001a6470da26', '200 Texte', 'r44_200_Texte.xml', 'standard', '', 'text.gif', 'Cette rangée peut contenir du texte mis en forme (liens, listes à puces, tableaux, etc.) à l''aide de l''éditeur Wysiwyg. Elle permet aussi d''insérer des liens vers des contenus stockés dans les modules', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(43, 'e5ae93a8-0baa-102e-80e2-001a6470da26', '110 Sous Titre (niveau 2)', 'r43_100_Sous_Titre.xml', 'standard', '', 'title.gif', 'Cette rangée permet d''insérer un titre de niveau 2 correspondant à l''élément H2 en HTML', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(42, 'e5ae95ba-0baa-102e-80e2-001a6470da26', '100 Titre (niveau 1)', 'r42_000_Titre.xml', 'standard', '', 'title.gif', 'Cette rangée vous permet d''insérer un titre de niveau 1 correspondant à l''élément H1 en HTML', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(47, 'e5ae983a-0baa-102e-80e2-001a6470da26', '400 Télécharger un fichier', 'r47_400_Telecharger_un_fichier.xml', 'standard', '', 'file.gif', 'Cette rangée permet d''insérer un fichier à télécharger', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(48, 'e5ae99f2-0baa-102e-80e2-001a6470da26', '300 Image Centrée', 'r48_300_Image_Centree.xml', 'standard', '', 'img.gif', 'Cette rangée insère une image centrée dont la largeur est limitée à 500px', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(49, 'e5ae9be6-0baa-102e-80e2-001a6470da26', '410 Animation Flash', 'r49_500_Animation_Flash.xml', 'standard', '', 'flash.gif', 'Cette rangée permet d''insérer une animation Flash (.swf)', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(54, 'e5ae9d8a-0baa-102e-80e2-001a6470da26', '700 Plan du site', 'r54_700_Plan_du_site.xml', 'standard', 'admin', 'tree.gif', 'Cette rangée génère un plan du site à partir de la racine du site sur 3 niveaux de profondeur', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(55, 'e5ae9f92-0baa-102e-80e2-001a6470da26', '800 [Formulaire]', 'r55_800_Formulaire.xml', 'cms_forms', 'admin', 'form.gif', 'Cette rangée permet d''insérer un formulaire créé à partir du module formulaire', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(58, 'e5aea17c-0baa-102e-80e2-001a6470da26', '605 [Actualités] Recherche', 'r58_610_Actualites__Recherche_FR.xml', 'pnews', 'admin', 'module.gif', 'Cette rangée affiche les dix dernières actualités et permet une recherche par mots-clés ou par catégorie d''actualités', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(61, 'e5aea3ac-0baa-102e-80e2-001a6470da26', '900 Carte Google', 'r61_900_Google_Maps.xml', 'standard', 'admin', 'nopicto.gif', 'Cette rangée vous permet d''insérer une carte Google Maps à partir d''une adresse postale.\nVous devez posséder une clef valide pour utiliser ce service. Voir le code source de la rangée pour plus d''informations', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(66, 'e5aea776-0baa-102e-80e2-001a6470da26', '615 [Actualités] Dernière actualité', 'r66_615_Derniere_actualite.xml', 'pnews', 'admin', 'module.gif', 'Cette rangée affiche la dernière actualité', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(67, 'e5aea92e-0baa-102e-80e2-001a6470da26', '120 Mini Titre (niveau 3)', 'r67_120_Sous_Sous_Titre.xml', 'standard', '', 'title.gif', 'Cette rangée vous permet d''insérer un titre de niveau 3 correspondant à l''élément H3 en HTML', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(68, 'e5aeab54-0baa-102e-80e2-001a6470da26', '650 [Médiathèque] Recherche', 'r68_650_Mediatheque.xml', 'pmedia', 'admin', 'module.gif', 'Cette rangée affiche les dix derniers éléments de la médiathèque et permet une recherche par mots-clés ou par catégorie de médias', '', 0);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(69, 'e5aeadb6-0baa-102e-80e2-001a6470da26', '230 Texte et Média à Droite', 'r69_Texte_-_Media_a_droite.xml', 'pmedia;standard', '', 'text-mod-right.gif', 'Cette rangée permet d''insérer du texte qu''on pourra mettre en forme via l''éditeur Wysiwyg avec,  aligné à droite, un élément issu du module médiathèque', '', 1);
INSERT INTO `mod_standard_rows` (`id_row`, `uuid_row`, `label_row`, `definitionFile_row`, `modulesStack_row`, `groupsStack_row`, `image_row`, `description_row`, `tplfilter_row`, `useable_row`) VALUES(70, 'e5aeb0b8-0baa-102e-80e2-001a6470da26', '240 Texte et Média à Gauche', 'r70_240_Texte_et_Media_a_Gauche.xml', 'pmedia;standard', '', 'text-mod-left.gif', 'Cette rangée permet d''insérer du texte qu''on pourra mettre en forme via l''éditeur Wysiwyg avec,  aligné à gauche, un élément issu du module médiathèque', '', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_integer_edited`
--

INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(9, 4, 0, 0, 49);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(11, 4, 5, 0, 17);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(26, 17, 0, 0, 75);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(27, 17, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(28, 17, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(82, 35, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(81, 35, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(80, 35, 0, 0, 107);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(47, 24, 0, 0, 96);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(48, 24, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(49, 24, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(50, 25, 0, 0, 97);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(51, 25, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(52, 25, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(53, 26, 0, 0, 98);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(54, 26, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(55, 26, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(56, 27, 0, 0, 99);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(57, 27, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(58, 27, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(59, 28, 0, 0, 100);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(60, 28, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(61, 28, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(62, 29, 0, 0, 101);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(63, 29, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(64, 29, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(79, 34, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(78, 34, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(77, 34, 0, 0, 106);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(83, 36, 0, 0, 109);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(84, 36, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(85, 36, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(86, 37, 0, 0, 110);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(87, 37, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(88, 37, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(89, 38, 0, 0, 111);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(90, 38, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(91, 38, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(92, 39, 0, 0, 112);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(93, 39, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(94, 39, 9, 3, 1);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(95, 40, 0, 0, 113);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(96, 40, 8, 0, 20);
INSERT INTO `mod_subobject_integer_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(97, 40, 9, 3, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_integer_public`
--

INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(11, 4, 5, 0, 17);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(9, 4, 0, 0, 49);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(28, 17, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(27, 17, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(26, 17, 0, 0, 75);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(80, 35, 0, 0, 107);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(81, 35, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(82, 35, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(49, 24, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(48, 24, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(47, 24, 0, 0, 96);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(52, 25, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(51, 25, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(50, 25, 0, 0, 97);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(55, 26, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(54, 26, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(53, 26, 0, 0, 98);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(58, 27, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(57, 27, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(56, 27, 0, 0, 99);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(61, 28, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(60, 28, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(59, 28, 0, 0, 100);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(64, 29, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(63, 29, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(62, 29, 0, 0, 101);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(77, 34, 0, 0, 106);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(78, 34, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(79, 34, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(83, 36, 0, 0, 109);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(84, 36, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(85, 36, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(88, 37, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(87, 37, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(86, 37, 0, 0, 110);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(91, 38, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(90, 38, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(89, 38, 0, 0, 111);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(92, 39, 0, 0, 112);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(93, 39, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(94, 39, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(97, 40, 9, 3, 1);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(96, 40, 8, 0, 20);
INSERT INTO `mod_subobject_integer_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(95, 40, 0, 0, 113);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_string_edited`
--

INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(15, 4, 1, 0, 'Automne V.4 disponible !');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(16, 4, 4, 0, 'r4_4_automne_thumbnail.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(17, 4, 4, 1, 'r4_4_automne_thumbnail.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(18, 4, 4, 2, 'r4_4_automne.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(43, 17, 6, 0, 'Gestion des dates de publication');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(44, 17, 9, 0, 'Gestion des dates de publication');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(45, 17, 9, 1, 'r17_9_publications_thumbnail.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(46, 17, 9, 2, '0.03');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(47, 17, 9, 4, 'r17_9_publications-2.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(137, 35, 9, 4, 'r35_9_adminv4-2.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(136, 35, 9, 2, '0.23');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(134, 35, 9, 0, 'Interface V4');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(135, 35, 9, 1, 'r35_9_adminv4_thumbnail.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(78, 24, 6, 0, 'Gestion / création de rangées de contenu');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(79, 24, 9, 0, 'Gestion / création de rangées de contenu');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(80, 24, 9, 1, 'r24_9_rangee.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(81, 24, 9, 2, '0.09');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(82, 24, 9, 4, 'r24_9_rangee.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(83, 25, 6, 0, 'Gestion / création de modèles de pages');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(84, 25, 9, 0, 'Gestion / création de modèles de pages');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(85, 25, 9, 1, 'r25_9_modele2.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(86, 25, 9, 2, '0.08');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(87, 25, 9, 4, 'r25_9_modele2.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(88, 26, 6, 0, 'Les modules');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(89, 26, 9, 0, 'Les modules');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(90, 26, 9, 1, 'r26_9_module.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(91, 26, 9, 2, '0.02');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(92, 26, 9, 4, 'r26_9_module.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(93, 27, 6, 0, 'Gestion des utilisateurs / groupes');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(94, 27, 9, 0, 'Gestion des utilisateurs / groupes');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(95, 27, 9, 1, 'r27_9_utilisateur.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(96, 27, 9, 2, '0.06');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(97, 27, 9, 4, 'r27_9_utilisateur.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(98, 28, 6, 0, 'Gestion des droits d''utilisateurs.');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(99, 28, 9, 0, 'Gestion des droits d''utilisateurs.');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(100, 28, 9, 1, 'r28_9_droits.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(101, 28, 9, 2, '0.08');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(102, 28, 9, 4, 'r28_9_droits.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(103, 29, 6, 0, 'Demande de validation après modification');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(104, 29, 9, 0, 'Demande de validation après modification');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(105, 29, 9, 1, 'r29_9_validation.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(106, 29, 9, 2, '0.02');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(107, 29, 9, 4, 'r29_9_validation.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(132, 34, 9, 4, 'r34_9_dragdrop3.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(130, 34, 9, 1, 'r34_9_dragdrop3.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(131, 34, 9, 2, '0.18');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(129, 34, 9, 0, 'Drag &amp; Drop d''une rangée de contenu');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(128, 34, 6, 0, 'Drag &amp; Drop d''une rangée de contenu');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(133, 35, 6, 0, 'Interface V4');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(138, 36, 6, 0, 'Création d''une page');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(139, 36, 9, 0, 'Création d''une page');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(140, 36, 9, 1, 'r36_9_creationpage.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(141, 36, 9, 2, '0.04');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(142, 36, 9, 4, 'r36_9_creationpage.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(143, 37, 6, 0, 'Aide du module actualités');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(144, 37, 9, 0, 'Aide du module actualités');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(145, 37, 9, 1, 'r37_9_aide.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(146, 37, 9, 2, '0.14');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(147, 37, 9, 4, 'r37_9_aide.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(148, 38, 6, 0, 'Aide contextuelle');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(149, 38, 9, 0, 'Aide contextuelle');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(150, 38, 9, 1, 'r38_9_aiderobots.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(151, 38, 9, 2, '0.13');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(152, 38, 9, 4, 'r38_9_aiderobots.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(153, 39, 6, 0, 'Résultats de recherche');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(154, 39, 9, 0, 'Résultats de recherche');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(155, 39, 9, 1, 'r39_9_recherche.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(156, 39, 9, 2, '0.08');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(157, 39, 9, 4, 'r39_9_recherche.jpg');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(158, 40, 6, 0, 'Administration du module formulaire');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(159, 40, 9, 0, 'Administration du module formulaire');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(160, 40, 9, 1, 'r40_9_adminformulaire.png');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(161, 40, 9, 2, '0.02');
INSERT INTO `mod_subobject_string_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(162, 40, 9, 4, 'r40_9_adminformulaire.jpg');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_string_public`
--

INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(17, 4, 4, 1, 'r4_4_automne_thumbnail.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(45, 17, 9, 1, 'r17_9_publications_thumbnail.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(105, 29, 9, 1, 'r29_9_validation.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(102, 28, 9, 4, 'r28_9_droits.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(101, 28, 9, 2, '0.08');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(135, 35, 9, 1, 'r35_9_adminv4_thumbnail.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(134, 35, 9, 0, 'Interface V4');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(100, 28, 9, 1, 'r28_9_droits.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(92, 26, 9, 4, 'r26_9_module.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(97, 27, 9, 4, 'r27_9_utilisateur.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(85, 25, 9, 1, 'r25_9_modele2.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(79, 24, 9, 0, 'Gestion / création de rangées de contenu');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(84, 25, 9, 0, 'Gestion / création de modèles de pages');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(91, 26, 9, 2, '0.02');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(90, 26, 9, 1, 'r26_9_module.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(89, 26, 9, 0, 'Les modules');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(96, 27, 9, 2, '0.06');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(95, 27, 9, 1, 'r27_9_utilisateur.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(94, 27, 9, 0, 'Gestion des utilisateurs / groupes');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(104, 29, 9, 0, 'Demande de validation après modification');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(129, 34, 9, 0, 'Drag &amp; Drop d''une rangée de contenu');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(131, 34, 9, 2, '0.18');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(99, 28, 9, 0, 'Gestion des droits d''utilisateurs.');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(88, 26, 6, 0, 'Les modules');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(130, 34, 9, 1, 'r34_9_dragdrop3.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(103, 29, 6, 0, 'Demande de validation après modification');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(98, 28, 6, 0, 'Gestion des droits d''utilisateurs.');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(93, 27, 6, 0, 'Gestion des utilisateurs / groupes');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(83, 25, 6, 0, 'Gestion / création de modèles de pages');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(78, 24, 6, 0, 'Gestion / création de rangées de contenu');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(132, 34, 9, 4, 'r34_9_dragdrop3.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(136, 35, 9, 2, '0.23');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(138, 36, 6, 0, 'Création d''une page');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(139, 36, 9, 0, 'Création d''une page');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(140, 36, 9, 1, 'r36_9_creationpage.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(141, 36, 9, 2, '0.04');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(142, 36, 9, 4, 'r36_9_creationpage.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(145, 37, 9, 1, 'r37_9_aide.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(144, 37, 9, 0, 'Aide du module actualités');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(143, 37, 6, 0, 'Aide du module actualités');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(150, 38, 9, 1, 'r38_9_aiderobots.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(149, 38, 9, 0, 'Aide contextuelle');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(148, 38, 6, 0, 'Aide contextuelle');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(153, 39, 6, 0, 'Résultats de recherche');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(154, 39, 9, 0, 'Résultats de recherche');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(155, 39, 9, 1, 'r39_9_recherche.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(156, 39, 9, 2, '0.08');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(157, 39, 9, 4, 'r39_9_recherche.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(161, 40, 9, 2, '0.02');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(160, 40, 9, 1, 'r40_9_adminformulaire.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(159, 40, 9, 0, 'Administration du module formulaire');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(137, 35, 9, 4, 'r35_9_adminv4-2.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(15, 4, 1, 0, 'Automne V.4 disponible !');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(44, 17, 9, 0, 'Gestion des dates de publication');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(43, 17, 6, 0, 'Gestion des dates de publication');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(80, 24, 9, 1, 'r24_9_rangee.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(81, 24, 9, 2, '0.09');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(82, 24, 9, 4, 'r24_9_rangee.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(86, 25, 9, 2, '0.08');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(87, 25, 9, 4, 'r25_9_modele2.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(106, 29, 9, 2, '0.02');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(107, 29, 9, 4, 'r29_9_validation.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(128, 34, 6, 0, 'Drag &amp; Drop d''une rangée de contenu');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(146, 37, 9, 2, '0.14');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(147, 37, 9, 4, 'r37_9_aide.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(151, 38, 9, 2, '0.13');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(152, 38, 9, 4, 'r38_9_aiderobots.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(158, 40, 6, 0, 'Administration du module formulaire');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(18, 4, 4, 2, 'r4_4_automne.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(16, 4, 4, 0, 'r4_4_automne_thumbnail.png');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(133, 35, 6, 0, 'Interface V4');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(46, 17, 9, 2, '0.03');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(47, 17, 9, 4, 'r17_9_publications-2.jpg');
INSERT INTO `mod_subobject_string_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(162, 40, 9, 4, 'r40_9_adminformulaire.jpg');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_text_edited`
--

INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(4, 4, 2, 0, '<p>Apr&egrave;s plusieurs mois de d&eacute;veloppement, la nouvelle version 4 d''Automne est enfin disponible.</p> <p>Cette d&eacute;monstration vous permettra d''en savoir plus et de tester ses grandes fonctionnalit&eacute;s.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(5, 4, 3, 0, '<p>Automne 4 est l''aboutissement de plusieurs ann&eacute;es d''exp&eacute;rience utilisateur avec les pr&eacute;c&eacute;dentes versions d''Automne et de plus d''un an et demi de d&eacute;veloppement. Le code est enti&egrave;rement r&eacute;&eacute;crit pour tirer le meilleur parti de PHP5 et des nouvelles technologies disponibles sur le Web. L''interface d''administration a &eacute;t&eacute; enti&egrave;rement revue pour &ecirc;tre plus intuitive, plus ergonomique et plus extensible. Elle fait <strong>un grand usage de la librairie Javascript </strong><a href="http://extjs.com/" target="_blank"><strong>ExtJS</strong></a><strong>.</strong></p> <h3>Automne 4 emploie aussi les composants open-source suivant :</h3> <ul>     <li><a href="http://www.gscottolson.com/blackbirdjs/" target="_blank">Blackbird</a></li>     <li><a href="http://code.google.com/p/cssmin/" target="_blank">CSSMin</a> et <a href="http://www.crockford.com/javascript/jsmin.html" target="_blank">JSMin</a></li>     <li><a target="_blank" href="http://marijn.haverbeke.nl/codemirror/">Codemirror</a></li>     <li><a href="http://www.fckeditor.net/" target="_blank">FCKEditor</a><a href="http://www.crockford.com/javascript/jsmin.html" target="_blank"><br />     </a></li>     <li><a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a></li>     <li><a target="_blank" href="http://github.com/jamespadolsey/prettyPrint.js">Pretty Print</a></li>     <li><a href="http://code.google.com/p/swfobject/" target="_blank">SWFObject</a><a href="http://swfupload.org/" target="_blank"><br />     </a></li>     <li><a href="http://framework.zend.com/" target="_blank">Zend Framework</a></li> </ul> <p>Gr&acirc;ce &agrave; ces outils provenant de la communaut&eacute; open-source, nous avons pu ajouter tr&egrave;s simplement des fonctionnalit&eacute;s vraiment pratiques &agrave; Automne. Un grand merci &agrave; leurs auteurs pour leur travail !</p> <p>Si vous souhaitez utiliser Automne pour vos projets, <a href="http://www.automne.ws" target="_blank">visitez le site de la communaut&eacute; Automne</a>. Vous y trouverez les d&eacute;tails n&eacute;cessaires.</p> <h3>A propos de cette d&eacute;monstration :</h3> <p>Cette d&eacute;monstration vous permettra de vous faire une id&eacute;e sur les fonctionnalit&eacute;s d''&eacute;dition offertes par Automne. Vous pourrez tester l''&eacute;dition du contenu de ces pages et de ces modules ainsi que les outils de validation sur les modifications que vous effectuerez.</p> <p>Cette d&eacute;monstration vous permettra de pouvoir tester l''utilisation de l''outil sur un exemple concret de site internet.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(12, 17, 7, 0, '<p>Ecran de date de publication.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(19, 24, 7, 0, '<p>Ecran de gestion et de cr&eacute;ation des mod&egrave;les de rang&eacute;es de contenu.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(20, 25, 7, 0, '<p>Ecran de gestion et de cr&eacute;ation des mod&egrave;les de pages.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(21, 26, 7, 0, '<p>Ecran des modules disponibles par d&eacute;faut dans Automne.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(22, 27, 7, 0, '<p>Ecran de la gestion des utilisateurs et groupes d''utilisateurs.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(23, 28, 7, 0, '<p>Ecran de la gestion des droits d''utilisateurs.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(24, 29, 7, 0, '<p>Ecran de validation d''une page apr&egrave;s modification.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(29, 34, 7, 0, '<p>Ecran de la fonction Drag &amp; Drop d''une rang&eacute;e de contenu.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(30, 35, 7, 0, '<p>Ecran de l''interface d''administration de Automne V.4.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(31, 36, 7, 0, '<p>Ecran de cr&eacute;ation d''une page.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(32, 37, 7, 0, '<p>Aide &agrave; la syntaxe des rang&eacute;es de contenu actualit&eacute;s.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(33, 38, 7, 0, '<p>Ecran de l''aide contextuelle pour les robots.</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(34, 39, 7, 0, '<p>Ecran des r&eacute;sulats de la recherche pour &quot;interface&quot;</p>');
INSERT INTO `mod_subobject_text_edited` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(35, 40, 7, 0, '<p>Ecran d''administration du module formulaire.</p>');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mod_subobject_text_public`
--

INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(12, 17, 7, 0, '<p>Ecran de date de publication.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(30, 35, 7, 0, '<p>Ecran de l''interface d''administration de Automne V.4.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(19, 24, 7, 0, '<p>Ecran de gestion et de cr&eacute;ation des mod&egrave;les de rang&eacute;es de contenu.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(20, 25, 7, 0, '<p>Ecran de gestion et de cr&eacute;ation des mod&egrave;les de pages.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(21, 26, 7, 0, '<p>Ecran des modules disponibles par d&eacute;faut dans Automne.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(22, 27, 7, 0, '<p>Ecran de la gestion des utilisateurs et groupes d''utilisateurs.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(24, 29, 7, 0, '<p>Ecran de validation d''une page apr&egrave;s modification.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(29, 34, 7, 0, '<p>Ecran de la fonction Drag &amp; Drop d''une rang&eacute;e de contenu.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(23, 28, 7, 0, '<p>Ecran de la gestion des droits d''utilisateurs.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(31, 36, 7, 0, '<p>Ecran de cr&eacute;ation d''une page.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(32, 37, 7, 0, '<p>Aide &agrave; la syntaxe des rang&eacute;es de contenu actualit&eacute;s.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(33, 38, 7, 0, '<p>Ecran de l''aide contextuelle pour les robots.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(34, 39, 7, 0, '<p>Ecran des r&eacute;sulats de la recherche pour &quot;interface&quot;</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(35, 40, 7, 0, '<p>Ecran d''administration du module formulaire.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(4, 4, 2, 0, '<p>Apr&egrave;s plusieurs mois de d&eacute;veloppement, la nouvelle version 4 d''Automne est enfin disponible.</p> <p>Cette d&eacute;monstration vous permettra d''en savoir plus et de tester ses grandes fonctionnalit&eacute;s.</p>');
INSERT INTO `mod_subobject_text_public` (`id`, `objectID`, `objectFieldID`, `objectSubFieldID`, `value`) VALUES(5, 4, 3, 0, '<p>Automne 4 est l''aboutissement de plusieurs ann&eacute;es d''exp&eacute;rience utilisateur avec les pr&eacute;c&eacute;dentes versions d''Automne et de plus d''un an et demi de d&eacute;veloppement. Le code est enti&egrave;rement r&eacute;&eacute;crit pour tirer le meilleur parti de PHP5 et des nouvelles technologies disponibles sur le Web. L''interface d''administration a &eacute;t&eacute; enti&egrave;rement revue pour &ecirc;tre plus intuitive, plus ergonomique et plus extensible. Elle fait <strong>un grand usage de la librairie Javascript </strong><a href="http://extjs.com/" target="_blank"><strong>ExtJS</strong></a><strong>.</strong></p> <h3>Automne 4 emploie aussi les composants open-source suivant :</h3> <ul>     <li><a href="http://www.gscottolson.com/blackbirdjs/" target="_blank">Blackbird</a></li>     <li><a href="http://code.google.com/p/cssmin/" target="_blank">CSSMin</a> et <a href="http://www.crockford.com/javascript/jsmin.html" target="_blank">JSMin</a></li>     <li><a target="_blank" href="http://marijn.haverbeke.nl/codemirror/">Codemirror</a></li>     <li><a href="http://www.fckeditor.net/" target="_blank">FCKEditor</a><a href="http://www.crockford.com/javascript/jsmin.html" target="_blank"><br />     </a></li>     <li><a href="http://www.phpmyadmin.net/" target="_blank">phpMyAdmin</a></li>     <li><a target="_blank" href="http://github.com/jamespadolsey/prettyPrint.js">Pretty Print</a></li>     <li><a href="http://code.google.com/p/swfobject/" target="_blank">SWFObject</a><a href="http://swfupload.org/" target="_blank"><br />     </a></li>     <li><a href="http://framework.zend.com/" target="_blank">Zend Framework</a></li> </ul> <p>Gr&acirc;ce &agrave; ces outils provenant de la communaut&eacute; open-source, nous avons pu ajouter tr&egrave;s simplement des fonctionnalit&eacute;s vraiment pratiques &agrave; Automne. Un grand merci &agrave; leurs auteurs pour leur travail !</p> <p>Si vous souhaitez utiliser Automne pour vos projets, <a href="http://www.automne.ws" target="_blank">visitez le site de la communaut&eacute; Automne</a>. Vous y trouverez les d&eacute;tails n&eacute;cessaires.</p> <h3>A propos de cette d&eacute;monstration :</h3> <p>Cette d&eacute;monstration vous permettra de vous faire une id&eacute;e sur les fonctionnalit&eacute;s d''&eacute;dition offertes par Automne. Vous pourrez tester l''&eacute;dition du contenu de ces pages et de ces modules ainsi que les outils de validation sur les modifications que vous effectuerez.</p> <p>Cette d&eacute;monstration vous permettra de pouvoir tester l''utilisation de l''outil sur un exemple concret de site internet.</p>');

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
  KEY `template_pag` (`template_pag`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `pages`
--

INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(1, 1, '', '2008-10-31', 1, '2009-10-28 17:10:50', '1-demo-automne.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(2, 40, '', '2008-10-31', 57, '2009-10-28 17:10:48', '2-accueil.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(3, 41, '1', '2008-11-03', 59, '2009-10-28 17:10:48', '3-presentation.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(5, 43, '', '2008-11-03', 61, '2009-10-28 17:10:45', '5-actualite.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(6, 44, '', '2008-11-03', 62, '2009-10-28 17:10:45', '6-mediatheque.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(7, 45, '', '2008-11-03', 63, '0000-00-00 00:00:00', '7-bas-de-page.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(8, 46, '', '2008-11-03', 64, '2009-10-28 17:10:42', '8-plan-du-site.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(9, 47, '', '2008-11-03', 65, '2009-10-28 17:10:41', '9-contact.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(17, 58, '', '2008-11-14', 73, '0000-00-00 00:00:00', '');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(18, 59, '', '2008-11-14', 74, '2008-11-14 16:54:55', '18-test.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(38, 108, '', '2009-03-04', 95, '2009-10-28 17:10:20', '38-aide-aux-utilisateurs.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(24, 80, '1', '2009-02-03', 81, '2009-10-28 17:10:39', '24-documentation.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(25, 81, '', '2009-02-03', 82, '2009-10-28 17:10:38', '25-modeles.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(26, 82, '', '2009-02-03', 83, '2009-10-28 17:10:36', '26-rangees.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(27, 83, '', '2009-02-03', 84, '2009-10-28 17:10:35', '27-modules.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(28, 84, '', '2009-02-03', 85, '2009-10-28 17:10:33', '28-administration.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(29, 85, '1', '2009-02-04', 86, '2009-10-28 17:10:32', '29-automne-v4.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(30, 86, '1', '2009-02-04', 87, '2009-10-28 17:10:30', '30-notions-essentielles.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(31, 87, '', '2009-02-04', 88, '2009-10-28 17:10:29', '31-exemples-de-modules.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(33, 89, '', '2009-02-04', 90, '2009-10-28 17:10:27', '33-nouveautes.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(34, 90, '1', '2009-02-04', 91, '2009-10-28 17:10:26', '34-fonctions-avancees.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(35, 91, '', '2009-02-04', 92, '2009-10-28 17:10:24', '35-gestion-des-droits.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(36, 92, '', '2009-03-02', 93, '2009-10-28 17:10:23', '36-formulaire.php');
INSERT INTO `pages` (`id_pag`, `resource_pag`, `remindedEditorsStack_pag`, `lastReminder_pag`, `template_pag`, `lastFileCreation_pag`, `url_pag`) VALUES(37, 93, '', '2009-03-02', 94, '2009-10-28 17:10:21', '37-droit-de-validation.php');

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

INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(1, 1, 'Démo Automne', 'Démo Automne', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '1|2|||_top|||', 0, '', '', 'root');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(20, 2, 'Automne version 4, goûter à la simplicité', 'Accueil', 'automne, cms, ecm, gestionnaire de contenu, toulouse, ws-interactive', 'Automne est un gestionnaire de contenu pour les entreprises open-source. Entièrement modulable il s''adapte à vos besoins.', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '', '', 'home');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(21, 3, 'Présentation', 'Présentation', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(23, 5, 'Actualités', 'Actualités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '', '', 'news');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(24, 6, 'Médiathèque', 'Médiathèque', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '', '', 'media');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(25, 7, 'Bas de page', 'Bas de page', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '', '', 'footer');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(26, 8, 'Plan du site', 'Plan du site', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(27, 9, 'Contact', 'Contact', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(54, 38, 'Aide aux utilisateurs', 'Aide utilisateurs', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(40, 24, 'Fonctionnalités', 'Fonctionnalités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(41, 25, 'Modèles de Pages', 'Modèles', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(42, 26, 'Rangées de contenu', 'Rangées', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(43, 27, 'Modules', 'Modules', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(44, 28, 'Gestion des utilisateurs', 'Gestion des utilisateurs', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(45, 29, 'Automne', 'Automne', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(46, 30, 'Pré-requis', 'Pré-requis', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(47, 31, 'Exemples de modules', 'Exemples de modules', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(49, 33, 'Nouveautés', 'Nouveautés', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(50, 34, 'Fonctions avancées', 'Fonctions avancées', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(51, 35, 'Gestion des droits', 'Gestion des droits', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(52, 36, 'Formulaire', 'Formulaire', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '1|9|||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_edited` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(53, 37, 'Workflow de publication', 'Workflow de publication', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');

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

INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(1, 1, 'Démo Automne', 'Démo Automne', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '1|2|||_top|||', 0, '', '', 'root');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(20, 2, 'Automne version 4, goûter à la simplicité', 'Accueil', 'automne, cms, ecm, gestionnaire de contenu, toulouse, ws-interactive', 'Automne est un gestionnaire de contenu pour les entreprises open-source. Entièrement modulable il s''adapte à vos besoins.', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '', '', 'home');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(21, 3, 'Présentation', 'Présentation', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(23, 5, 'Actualités', 'Actualités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '', '', 'news');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(24, 6, 'Médiathèque', 'Médiathèque', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '', '', 'media');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`, `codename_pbd`) VALUES(25, 7, 'Bas de page', 'Bas de page', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '', '', 'footer');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(26, 8, 'Plan du site', 'Plan du site', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(27, 9, 'Contact', 'Contact', '', '', 0, '0000-00-00', '', '', '', '', '', 'fr', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(54, 38, 'Aide aux utilisateurs', 'Aide utilisateurs', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(42, 26, 'Rangées de contenu', 'Rangées', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(40, 24, 'Fonctionnalités', 'Fonctionnalités', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(43, 27, 'Modules', 'Modules', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(44, 28, 'Gestion des utilisateurs', 'Gestion des utilisateurs', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(45, 29, 'Automne', 'Automne', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(46, 30, 'Pré-requis', 'Pré-requis', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(47, 31, 'Exemples de modules', 'Exemples de modules', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(49, 33, 'Nouveautés', 'Nouveautés', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(41, 25, 'Modèles de Pages', 'Modèles', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(51, 35, 'Gestion des droits', 'Gestion des droits', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(52, 36, 'Formulaire', 'Formulaire', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '1|9|||_top|||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(53, 37, 'Workflow de publication', 'Workflow de publication', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0|||||||', 0, '', '');
INSERT INTO `pagesBaseData_public` (`id_pbd`, `page_pbd`, `title_pbd`, `linkTitle_pbd`, `keywords_pbd`, `description_pbd`, `reminderPeriodicity_pbd`, `reminderOn_pbd`, `reminderOnMessage_pbd`, `category_pbd`, `author_pbd`, `replyto_pbd`, `copyright_pbd`, `language_pbd`, `robots_pbd`, `pragma_pbd`, `refresh_pbd`, `redirect_pbd`, `refreshUrl_pbd`, `url_pbd`, `metas_pbd`) VALUES(50, 34, 'Fonctions avancées', 'Fonctions avancées', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '0||||_top|||', 0, '', '');

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

INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(1, 'Splash', 'fr', '', 'splash.xml', 0, 0, 'nopicto.gif', 0, '', 'Modèle vide. Usuellement employé pour les pages de redirections.', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(2, 'Exemple', 'fr', 'standard', 'example.xml', 0, 0, 'nopicto.gif', 0, '', 'Modèle d''exemple. Comporte les différents tags Automne disponibles pour la création d''un modèle de page.', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(56, 'Accueil Démo', 'fr', 'standard', 'pt56_Accueil.xml', 0, 0, 'accueil.jpg', 0, 'first;second', 'Modèle de la page d''accueil de la démonstration Automne.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(57, 'Accueil Démo', 'fr', 'standard', 'pt56_Accueil.xml', 0, 1, 'accueil.jpg', 0, 'first;second', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(58, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 0, 'interieur-vert.jpg', 1, 'first', 'Modèle des pages intérieures de la démonstration Automne.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(59, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(60, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(61, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(62, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(63, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(64, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(65, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(66, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', '', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(67, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(68, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(69, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(70, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(71, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(72, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(73, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(74, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(75, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(76, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(77, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(78, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(79, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(95, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(81, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(82, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(83, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(84, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(85, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(86, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(87, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(88, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(89, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(90, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(91, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(92, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(93, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES(94, 'Intérieur Démo', 'fr', 'standard', 'pt58_Interieur.xml', 0, 1, 'interieur-vert.jpg', 0, 'first', 'Modèles des pages intérieures du site français.', '1');

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
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES(4, '', '', '1,2', 'pnews,2;cms_aliases,2;cms_forms,2;standard,2;pdocs,2;ppictures,2', '', 319);
INSERT INTO `profiles` (`id_pr`, `templateGroupsDeniedStack_pr`, `rowGroupsDeniedStack_pr`, `pageClearancesStack_pr`, `moduleClearancesStack_pr`, `validationClearancesStack_pr`, `administrationClearance_pr`) VALUES(10, '', 'admin', '1,2', 'standard,2;pnews,2;pmedia,2', '', 0);

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

INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES(1, 'root', '3b0d99b9bb927794036aa828050f364d', '', 'Super administrateur', 1, 1, 'fr', '', 1, 0, 'standard,7;pnews,1;pmedia,1', '');
INSERT INTO `profilesUsers` (`id_pru`, `login_pru`, `password_pru`, `firstName_pru`, `lastName_pru`, `contactData_pru`, `profile_pru`, `language_pru`, `dn_pru`, `active_pru`, `deleted_pru`, `alerts_pru`, `favorites_pru`) VALUES(3, 'anonymous', '294de3557d9d00b3d2d8a1e6aab028cf', '', 'Utilisateur anonyme', 3, 3, 'fr', '', 1, 0, 'standard,7', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `profilesUsersGroups`
--

INSERT INTO `profilesUsersGroups` (`id_prg`, `description_prg`, `label_prg`, `profile_prg`, `dn_prg`, `invertdn_prg`) VALUES(1, 'Groupe des administrateurs du site', 'Administrateurs', 4, '', 0);
INSERT INTO `profilesUsersGroups` (`id_prg`, `description_prg`, `label_prg`, `profile_prg`, `dn_prg`, `invertdn_prg`) VALUES(2, 'Groupes des rédacteurs pour le contenu du site.', 'Rédacteurs', 10, '', 0);

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
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(40, 40, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(41, 41, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(42, 42, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(43, 43, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(44, 44, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(45, 45, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(46, 46, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(47, 47, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(48, 48, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(49, 49, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(50, 50, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(51, 51, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(52, 52, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(53, 53, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(54, 54, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(55, 55, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(56, 56, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(57, 57, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(58, 58, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(59, 59, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(60, 60, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(61, 61, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(62, 62, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(63, 63, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(64, 64, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(65, 65, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(66, 66, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(67, 67, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(68, 68, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(69, 69, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(70, 70, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(71, 71, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(72, 72, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(73, 73, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(74, 74, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(75, 75, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(76, 76, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(77, 77, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(78, 78, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(79, 79, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(80, 80, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(81, 81, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(82, 82, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(83, 83, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(84, 84, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(85, 85, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(86, 86, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(87, 87, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(88, 88, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(89, 89, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(90, 90, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(91, 91, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(92, 92, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(93, 93, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(94, 94, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(95, 95, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(96, 96, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(97, 97, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(98, 98, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(99, 99, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(100, 100, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(101, 101, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(102, 102, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(103, 103, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(104, 104, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(105, 105, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(106, 106, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(107, 107, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(108, 108, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(109, 109, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(110, 110, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(111, 111, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(112, 112, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(113, 113, '');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(114, 114, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(115, 115, '1,2');
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES(116, 116, '1,2');

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

INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(1, 1, 0, 0, 0, 2, '2008-10-31', '0000-00-00', '2008-10-31', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(40, 1, 0, 0, 0, 2, '2008-10-31', '0000-00-00', '2008-10-31', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(41, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00', '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(42, 3, 0, 0, 0, 1, '2008-11-03', '2009-03-01', '2008-11-03', '2009-03-01');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(43, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00', '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(44, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00', '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(45, 1, 0, 0, 0, 1, '2008-11-03', '2008-11-02', '2008-11-03', '2008-11-02');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(46, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00', '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(47, 1, 0, 0, 0, 2, '2008-11-03', '0000-00-00', '2008-11-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(48, 3, 0, 0, 0, 2, '2008-11-04', '0000-00-00', '2008-11-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(49, 1, 0, 0, 0, 2, '2008-11-05', '0000-00-00', '2008-11-05', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(50, 3, 0, 2, 0, 2, '2008-11-07', '0000-00-00', '2008-11-07', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(51, 3, 0, 2, 0, 2, '2008-11-07', '0000-00-00', '2008-11-07', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(52, 3, 0, 0, 0, 2, '2008-11-12', '0000-00-00', '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(53, 3, 0, 0, 0, 2, '2008-11-12', '0000-00-00', '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(54, 3, 0, 0, 0, 2, '2008-11-12', '0000-00-00', '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(55, 3, 0, 0, 0, 2, '2008-11-12', '0000-00-00', '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(56, 3, 0, 0, 0, 2, '2008-11-12', '0000-00-00', '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(57, 3, 0, 0, 0, 2, '2008-11-12', '0000-00-00', '2008-11-12', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(58, 3, 0, 1, 0, 0, '2008-11-14', '0000-00-00', '2008-11-14', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(59, 3, 0, 0, 0, 2, '2008-11-14', '0000-00-00', '2008-11-14', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(60, 3, 0, 2, 0, 2, '2008-11-19', '0000-00-00', '2008-11-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(61, 3, 0, 2, 0, 2, '2008-11-19', '0000-00-00', '2008-11-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(62, 3, 0, 2, 0, 2, '2008-11-19', '0000-00-00', '2008-11-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(63, 3, 0, 2, 0, 2, '2008-11-19', '0000-00-00', '2008-11-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(64, 3, 0, 2, 0, 2, '2008-11-21', '0000-00-00', '2008-11-21', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(65, 3, 0, 3, 0, 0, '2008-11-29', '0000-00-00', '2008-11-29', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(66, 3, 0, 3, 0, 0, '2008-11-29', '2008-11-30', '2008-11-29', '2008-11-30');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(67, 3, 0, 1, 0, 0, '2008-11-29', '0000-00-00', '2008-11-29', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(68, 3, 0, 2, 0, 0, '2008-11-29', '2008-12-01', '2008-11-29', '2008-12-01');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(69, 3, 0, 2, 0, 2, '2008-12-19', '0000-00-00', '2008-12-19', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(70, 3, 0, 1, 0, 0, '2008-12-23', '0000-00-00', '2008-12-23', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(71, 3, 0, 2, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(72, 3, 0, 2, 0, 0, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(73, 3, 0, 2, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(74, 3, 0, 3, 3, 0, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(75, 1, 0, 0, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(76, 3, 0, 2, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(77, 3, 0, 2, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(78, 3, 0, 2, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(79, 3, 0, 2, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(80, 1, 0, 0, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(81, 1, 0, 0, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(82, 1, 0, 0, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(83, 1, 0, 0, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(84, 1, 0, 0, 0, 2, '2009-02-03', '0000-00-00', '2009-02-03', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(85, 1, 0, 0, 0, 2, '2009-02-04', '0000-00-00', '2009-02-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(86, 1, 0, 0, 0, 2, '2009-02-04', '0000-00-00', '2009-02-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(87, 1, 0, 0, 0, 2, '2009-02-04', '0000-00-00', '2009-02-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(88, 3, 0, 0, 0, 2, '2009-02-04', '0000-00-00', '2009-02-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(89, 1, 0, 0, 0, 2, '2009-02-04', '0000-00-00', '2009-02-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(90, 1, 0, 0, 0, 2, '2009-02-04', '0000-00-00', '2009-02-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(91, 1, 0, 0, 0, 2, '2009-02-04', '0000-00-00', '2009-02-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(92, 1, 0, 0, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(93, 1, 0, 0, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(94, 3, 0, 2, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(95, 3, 0, 2, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(96, 1, 0, 0, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(97, 1, 0, 0, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(98, 1, 0, 0, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(99, 1, 0, 0, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(100, 1, 0, 0, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(101, 1, 0, 0, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(102, 3, 0, 2, 0, 2, '2009-03-02', '0000-00-00', '2009-03-02', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(103, 3, 0, 2, 0, 2, '2009-03-04', '0000-00-00', '2009-03-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(104, 3, 0, 2, 0, 2, '2009-03-04', '0000-00-00', '2009-03-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(105, 3, 0, 2, 0, 2, '2009-03-04', '0000-00-00', '2009-03-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(106, 1, 0, 0, 0, 2, '2009-03-04', '0000-00-00', '2009-03-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(107, 1, 0, 0, 0, 2, '2009-03-04', '0000-00-00', '2009-03-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(108, 1, 0, 0, 0, 2, '2009-03-04', '0000-00-00', '2009-03-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(109, 1, 0, 0, 0, 2, '2009-03-04', '0000-00-00', '2009-03-04', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(110, 1, 0, 0, 0, 2, '2009-03-05', '0000-00-00', '2009-03-05', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(111, 1, 0, 0, 0, 2, '2009-03-05', '0000-00-00', '2009-03-05', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(112, 1, 0, 0, 0, 2, '2009-03-05', '0000-00-00', '2009-03-05', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(113, 1, 0, 0, 0, 2, '2009-03-05', '0000-00-00', '2009-03-05', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(114, 3, 0, 2, 0, 0, '2008-11-05', '0000-00-00', '2008-11-05', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(115, 3, 0, 2, 0, 0, '2008-11-05', '0000-00-00', '2008-11-05', '0000-00-00');
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES(116, 3, 0, 2, 0, 0, '2009-06-23', '0000-00-00', '2009-06-23', '0000-00-00');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Contenu de la table `sessions`
--

INSERT INTO `sessions` (`id_ses`, `phpid_ses`, `lastTouch_ses`, `user_ses`, `remote_addr_ses`, `http_user_agent_ses`, `cookie_expire_ses`) VALUES(2, 'a7d9bd7e7a9a02dda1a65eb78f984145921e58e2', '2009-10-28 17:11:10', 1, '192.168.2.101', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; fr; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3 Creative ZENcast v2.00.13', '2009-11-12 16:48:07');

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

INSERT INTO `websites` (`id_web`, `codename_web`, `label_web`, `url_web`, `altdomains_web`, `root_web`, `keywords_web`, `description_web`, `category_web`, `author_web`, `replyto_web`, `copyright_web`, `language_web`, `robots_web`, `favicon_web`, `metas_web`, `order_web`) VALUES(1, 'root', 'Site principal', '127.0.0.1', '', 1, '', '', '', '', '', '', 'fr', '', '/favicon.ico', '', 1);
INSERT INTO `websites` (`id_web`, `codename_web`, `label_web`, `url_web`, `altdomains_web`, `root_web`, `keywords_web`, `description_web`, `category_web`, `author_web`, `replyto_web`, `copyright_web`, `language_web`, `robots_web`, `favicon_web`, `metas_web`, `order_web`) VALUES(2, 'demo', 'Site de démonstration', '127.0.0.1', '', 2, '', '', '', '', '', '', 'fr', '', '', '', 2);
