# $Id: pageRedirect-feature.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of redirect option for pages
# automne3.sql files since version : 1.17

#Add redirect page feature 

ALTER TABLE `pagesBaseData_archived` ADD `redirect_pbd` VARCHAR( 255 ) NOT NULL AFTER `refresh_pbd` ;
ALTER TABLE `pagesBaseData_deleted` ADD `redirect_pbd` VARCHAR( 255 ) NOT NULL AFTER `refresh_pbd` ;
ALTER TABLE `pagesBaseData_edited` ADD `redirect_pbd` VARCHAR( 255 ) NOT NULL AFTER `refresh_pbd` ;
ALTER TABLE `pagesBaseData_public` ADD `redirect_pbd` VARCHAR( 255 ) NOT NULL AFTER `refresh_pbd` ;