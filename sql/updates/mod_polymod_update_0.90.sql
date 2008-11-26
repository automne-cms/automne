# $Id: mod_polymod_update_0.90.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of polymod table mod_object_plugin_definition
# mod_polymod.sql file since version : 1.5
# Polymod since version 0.90

#Add polymod wysiwyg plugin features

# 
#  Table `mod_object_plugin_definition` structure definition
# 

DROP TABLE IF EXISTS `mod_object_plugin_definition`;
CREATE TABLE `mod_object_plugin_definition` (
  `id_mowd` int(11) unsigned NOT NULL auto_increment,
  `object_id_mowd` int(11) unsigned NOT NULL default '0',
  `label_id_mowd` int(11) unsigned NOT NULL default '0',
  `description_id_mowd` int(11) unsigned NOT NULL default '0',
  `query_mowd` mediumtext NOT NULL,
  `definition_mowd` mediumtext NOT NULL,
  PRIMARY KEY  (`id_mowd`),
  KEY `object_id_mowd` (`object_id_mowd`)
) TYPE=MyISAM;