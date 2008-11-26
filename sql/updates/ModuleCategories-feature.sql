# $Id: ModuleCategories-feature.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of structure tables and sample datas were added in 
# automne3.sql files since version : 1.10
# automne3-data.sql files since version : 1.16


# Relative to :
# [FEATURE] : Added centralized modules categories support 

#
# Table structure for table `modulesCategories`
#

CREATE TABLE IF NOT EXISTS `modulesCategories` (
  `id_mca` int(11) unsigned NOT NULL auto_increment,
  `module_mca` varchar(20) NOT NULL default '',
  `parent_mca` int(10) unsigned NOT NULL default '0',
  `root_mca` int(10) unsigned NOT NULL default '0',
  `lineage_mca` varchar(255) NOT NULL default '',
  `order_mca` int(10) unsigned NOT NULL default '1',
  `icon_mca` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_mca`),
  KEY `module` (`module_mca`),
  KEY `lineage` (`lineage_mca`),
  KEY `parents` (`root_mca`,`parent_mca`)
) TYPE=MyISAM;

#
# Table structure for table `modulesCategories_clearances`
#

CREATE TABLE IF NOT EXISTS `modulesCategories_clearances` (
  `id_mcc` int(11) unsigned NOT NULL auto_increment,
  `profile_mcc` int(11) unsigned NOT NULL default '0',
  `category_mcc` int(10) unsigned NOT NULL default '0',
  `clearance_mcc` tinyint(16) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id_mcc`),
  UNIQUE KEY `profilecategories` (`profile_mcc`,`category_mcc`)
) TYPE=MyISAM;

#
# Table structure for table `modulesCategories_i18nm`
#

CREATE TABLE IF NOT EXISTS `modulesCategories_i18nm` (
  `id_mcl` int(11) unsigned NOT NULL auto_increment,
  `category_mcl` int(11) unsigned NOT NULL default '0',
  `language_mcl` char(2) NOT NULL default 'en',
  `label_mcl` varchar(255) NOT NULL default '',
  `description_mcl` text NOT NULL,
  `file_mcl` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_mcl`),
  UNIQUE KEY `categoryperlang` (`category_mcl`,`language_mcl`)
) TYPE=MyISAM;

