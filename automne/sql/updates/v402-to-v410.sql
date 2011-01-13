ALTER TABLE `mod_object_definition` ADD  `uuid_mod` VARCHAR( 36 ) NOT NULL AFTER  `id_mod` ;
update mod_object_definition set uuid_mod = UUID() where uuid_mod = '';

ALTER TABLE `mod_object_field` ADD  `uuid_mof` VARCHAR( 36 ) NOT NULL AFTER  `id_mof` ;
update mod_object_field set uuid_mof = UUID() where uuid_mof = '';

ALTER TABLE `modulesCategories` ADD  `uuid_mca` VARCHAR( 36 ) NOT NULL AFTER  `id_mca` ;
update modulesCategories set uuid_mca = UUID() where uuid_mca = '';

ALTER TABLE `mod_object_plugin_definition` ADD  `uuid_mowd` VARCHAR( 36 ) NOT NULL AFTER  `id_mowd` ;
update mod_object_plugin_definition set uuid_mowd = UUID() where uuid_mowd = '';

ALTER TABLE `mod_object_rss_definition` ADD  `uuid_mord` VARCHAR( 36 ) NOT NULL AFTER  `id_mord` ;
update mod_object_rss_definition set uuid_mord = UUID() where uuid_mord = '';

ALTER TABLE `mod_standard_rows` ADD  `uuid_row` VARCHAR( 36 ) NOT NULL AFTER  `id_row` ;
update mod_standard_rows set uuid_row = UUID() where uuid_row = '';