# $Id: significantURL.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of page url on pagesBaseData_* table
# automne3.sql file since version : 1.19

#Add url significant features

#pagesbasedata tables
ALTER TABLE `pagesBaseData_archived` ADD `refreshUrl_pbd` INT( 1 ) DEFAULT '0' NOT NULL AFTER `redirect_pbd` ;
ALTER TABLE `pagesBaseData_deleted` ADD `refreshUrl_pbd` INT( 1 ) DEFAULT '0' NOT NULL AFTER `redirect_pbd` ;
ALTER TABLE `pagesBaseData_edited` ADD `refreshUrl_pbd` INT( 1 ) DEFAULT '0' NOT NULL AFTER `redirect_pbd` ;
ALTER TABLE `pagesBaseData_public` ADD `refreshUrl_pbd` INT( 1 ) DEFAULT '0' NOT NULL AFTER `redirect_pbd` ;
#pages table
ALTER TABLE `pages` ADD `url_pag` VARCHAR( 255 ) NOT NULL AFTER `lastFileCreation_pag` ;