# $Id: scriptsmanager.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Replace regenerator by script manager and add default meta in websites
# automne3.sql files since version : 1.27

#Change regenerator table structure
ALTER TABLE `regenerator` CHANGE `page_reg` `id_reg` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT ;
ALTER TABLE `regenerator` DROP PRIMARY KEY , ADD PRIMARY KEY ( `id_reg` ) ;
ALTER TABLE `regenerator` CHANGE `regenerationFromScratch_reg` `module_reg` VARCHAR( 255 ) NOT NULL DEFAULT '0' ;
ALTER TABLE `regenerator` ADD `parameters_reg` TEXT NOT NULL AFTER `module_reg` ;
ALTER TABLE `scriptsStatuses` ADD `module_ss` VARCHAR( 255 ) NOT NULL AFTER `pidFileName_ss` ,
ADD `parameters_ss` TEXT NOT NULL AFTER `module_ss` ;

#Change websites table structure
ALTER TABLE `websites` ADD `keywords_web` MEDIUMTEXT NOT NULL AFTER `root_web` ,
ADD `description_web` MEDIUMTEXT NOT NULL AFTER `keywords_web` ,
ADD `category_web` VARCHAR( 255 ) NOT NULL AFTER `description_web` ,
ADD `author_web` VARCHAR( 255 ) NOT NULL AFTER `category_web` ,
ADD `replyto_web` VARCHAR( 255 ) NOT NULL AFTER `author_web` ,
ADD `copyright_web` VARCHAR( 255 ) NOT NULL AFTER `replyto_web` ,
ADD `language_web` VARCHAR( 255 ) NOT NULL AFTER `copyright_web` ,
ADD `robots_web` VARCHAR( 255 ) NOT NULL AFTER `language_web` ,
ADD `favicon_web` VARCHAR( 255 ) NOT NULL AFTER `robots_web` ,
ADD `order_web` INT( 11 ) UNSIGNED NOT NULL AFTER `favicon_web` ;

#Set 'fr' as default language on all websites
UPDATE websites SET language_web='fr' WHERE language_web='';