ALTER TABLE `sessions` CHANGE `remote_addr_ses` `remote_addr_ses` VARCHAR( 64 ) NOT NULL ;
ALTER TABLE `locks` ADD `date_lok` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00';

ALTER TABLE `linx_real_public` DROP INDEX `id_lre`;
ALTER TABLE `linx_real_public` DROP `id_lre`;
TRUNCATE TABLE `linx_real_public`;
ALTER TABLE `linx_real_public` ADD UNIQUE (
`start_lre` ,
`stop_lre`
);

ALTER TABLE `linx_watch_public` DROP INDEX `id_lwa` ;
ALTER TABLE `linx_watch_public` DROP `id_lwa`;
TRUNCATE TABLE `linx_watch_public`;
ALTER TABLE `linx_watch_public` ADD UNIQUE (
`page_lwa` ,
`target_lwa`
);


ALTER TABLE `pagesBaseData_edited` ADD FULLTEXT (
`title_pbd` ,
`linkTitle_pbd` ,
`keywords_pbd` ,
`description_pbd`
);
ALTER TABLE `pagesBaseData_public` ADD FULLTEXT (
`title_pbd` ,
`linkTitle_pbd` ,
`keywords_pbd` ,
`description_pbd`
);
ALTER TABLE `blocksVarchars_edited` ADD FULLTEXT (
`value`
);
ALTER TABLE `blocksVarchars_public` ADD FULLTEXT (
`value`
);
ALTER TABLE `blocksTexts_edited` ADD FULLTEXT (
`value`
);
ALTER TABLE `blocksTexts_public` ADD FULLTEXT (
`value`
);
ALTER TABLE `blocksImages_edited` ADD FULLTEXT (
`label`
);
ALTER TABLE `blocksImages_public` ADD FULLTEXT (
`label`
);
ALTER TABLE `blocksFiles_edited` ADD FULLTEXT (
`label`
);
ALTER TABLE `blocksFiles_public` ADD FULLTEXT (
`label`
);
ALTER TABLE `profilesUsers` ADD FULLTEXT (
`login_pru` ,
`firstName_pru` ,
`lastName_pru`
);
ALTER TABLE `profilesUsersGroups` ADD FULLTEXT (
`description_prg` ,
`label_prg`
);
ALTER TABLE `pageTemplates` ADD FULLTEXT (
`label_pt` ,
`description_pt`
);
ALTER TABLE `mod_standard_rows` ADD FULLTEXT (
`label_row` ,
`description_row`
);

ALTER TABLE `mod_subobject_text_edited` ADD FULLTEXT (
`value`
);
ALTER TABLE `mod_subobject_text_public` ADD FULLTEXT (
`value`
);
ALTER TABLE `mod_subobject_string_edited` ADD FULLTEXT (
`value`
);
ALTER TABLE `mod_subobject_string_public` ADD FULLTEXT (
`value`
);