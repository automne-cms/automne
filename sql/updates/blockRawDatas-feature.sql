# $Id: blockRawDatas-feature.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of structure tables and sample datas were added in 
# automne3.sql files since version : 1.15

# [FEATURE] : add rawDatas blocks to automne (for cms_forms module and polymod)

#
# Structure de la table `blocksRawDatas_archived`
#

CREATE TABLE IF NOT EXISTS `blocksRawDatas_archived` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) TYPE=MyIsam;

# --------------------------------------------------------

#
# Structure de la table `blocksRawDatas_deleted`
#

CREATE TABLE IF NOT EXISTS `blocksRawDatas_deleted` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) TYPE=MyIsam;

# --------------------------------------------------------

#
# Structure de la table `blocksRawDatas_edited`
#

CREATE TABLE IF NOT EXISTS `blocksRawDatas_edited` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) TYPE=MyIsam;

# --------------------------------------------------------

#
# Structure de la table `blocksRawDatas_edition`
#

CREATE TABLE IF NOT EXISTS `blocksRawDatas_edition` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) TYPE=MyIsam;

# --------------------------------------------------------

#
# Structure de la table `blocksRawDatas_public`
#

CREATE TABLE IF NOT EXISTS `blocksRawDatas_public` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `page` int(11) unsigned NOT NULL default '0',
  `clientSpaceID` varchar(100) NOT NULL default '',
  `rowID` varchar(100) NOT NULL default '',
  `blockID` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `page` (`page`)
) TYPE=MyIsam;