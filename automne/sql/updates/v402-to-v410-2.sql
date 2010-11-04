ALTER TABLE `pagesBaseData_public` ADD `codename_pbd` VARCHAR( 20 ) NOT NULL ;
ALTER TABLE `pagesBaseData_edited` ADD `codename_pbd` VARCHAR( 20 ) NOT NULL ;
ALTER TABLE `pagesBaseData_deleted` ADD `codename_pbd` VARCHAR( 20 ) NOT NULL ;
ALTER TABLE `pagesBaseData_archived` ADD `codename_pbd` VARCHAR( 20 ) NOT NULL ;

ALTER TABLE  `pagesBaseData_public` DROP INDEX  `title_pbd` ,
ADD FULLTEXT  `title_pbd` (
`title_pbd` ,
`linkTitle_pbd` ,
`keywords_pbd` ,
`description_pbd` ,
`codename_pbd`
);
ALTER TABLE  `pagesBaseData_edited` DROP INDEX  `title_pbd` ,
ADD FULLTEXT  `title_pbd` (
`title_pbd` ,
`linkTitle_pbd` ,
`keywords_pbd` ,
`description_pbd` ,
`codename_pbd`
);