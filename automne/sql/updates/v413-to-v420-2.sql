ALTER TABLE  `pagesBaseData_deleted` CHANGE  `codename_pbd`  `codename_pbd` VARCHAR( 100 ) NOT NULL;
ALTER TABLE  `pagesBaseData_archived` CHANGE  `codename_pbd`  `codename_pbd` VARCHAR( 100 ) NOT NULL;
ALTER TABLE  `pagesBaseData_edited` CHANGE  `codename_pbd`  `codename_pbd` VARCHAR( 100 ) NOT NULL;
ALTER TABLE  `pagesBaseData_public` CHANGE  `codename_pbd`  `codename_pbd` VARCHAR( 100 ) NOT NULL;
ALTER TABLE  `pages` ADD  `protected_pag` INT( 1 ) NOT NULL AFTER  `url_pag` ;
ALTER TABLE  `pages` ADD  `https_pag` INT( 1 ) NOT NULL AFTER  `protected_pag` ;
ALTER TABLE  `modulesCategories` ADD  `protected_mca` INT( 1 ) NOT NULL AFTER  `icon_mca` ;