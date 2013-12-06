DROP TABLE IF EXISTS `mod_object_oembed_definition`;

CREATE TABLE IF NOT EXISTS `mod_object_oembed_definition` (
  `id_mood` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid_mood` varchar(36) NOT NULL,
  `objectdefinition_mood` int(11) unsigned NOT NULL DEFAULT '0',
  `codename_mood` varchar(100) NOT NULL DEFAULT '',
  `label_mood` varchar(100) NOT NULL DEFAULT '',
  `parameter_mood` varchar(100) NOT NULL DEFAULT '',
  `html_mood` mediumtext NOT NULL DEFAULT '',
  PRIMARY KEY (`id_mood`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;