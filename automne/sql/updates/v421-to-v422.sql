ALTER TABLE  `mod_object_rss_definition` ADD  `namespaces_mord` TEXT NOT NULL;
ALTER TABLE  `profilesUsers` CHANGE  `login_pru`  `login_pru` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '';
