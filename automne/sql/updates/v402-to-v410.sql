ALTER TABLE `mod_object_definition` ADD  `uuid_mod` VARCHAR( 36 ) NOT NULL AFTER  `id_mod` ;
update mod_object_definition set uuid_mod = UUID();

ALTER TABLE `mod_object_field` ADD  `uuid_mof` VARCHAR( 36 ) NOT NULL AFTER  `id_mof` ;
update mod_object_field set uuid_mof = UUID();

ALTER TABLE `modulesCategories` ADD  `uuid_mca` VARCHAR( 36 ) NOT NULL AFTER  `id_mca` ;
update modulesCategories set uuid_mca = UUID();

ALTER TABLE `mod_object_plugin_definition` ADD  `uuid_mowd` VARCHAR( 36 ) NOT NULL AFTER  `id_mowd` ;
update mod_object_plugin_definition set uuid_mowd = UUID();

ALTER TABLE `mod_object_rss_definition` ADD  `uuid_mord` VARCHAR( 36 ) NOT NULL AFTER  `id_mord` ;
update mod_object_rss_definition set uuid_mord = UUID();

ALTER TABLE `mod_standard_rows` ADD  `uuid_row` VARCHAR( 36 ) NOT NULL AFTER  `id_row` ;
update mod_standard_rows set uuid_row = UUID();