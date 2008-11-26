# $Id: multigroups.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Add multi groups feature
# automne3.sql files since version : 1.23

#Change profileUsersByGroup table structure
ALTER TABLE `profileUsersByGroup` ADD INDEX ( `userId_gu` ) ;
#Change profilesUsersGroups table structure
ALTER TABLE `profilesUsersGroups` ADD `description_prg` MEDIUMTEXT NOT NULL AFTER `id_prg` ;
ALTER TABLE `profilesUsersGroups` ADD `invertdn_prg` INT( 1 ) NOT NULL AFTER `dn_prg` ;
#Change profiles table structure
ALTER TABLE `profiles` CHANGE `pageClearancesStack_pr` `pageClearancesStack_pr` TEXT NOT NULL;
#Change log table
ALTER TABLE `log` ADD INDEX ( `user_log` );
ALTER TABLE `log` ADD INDEX ( `action_log` );

#Set categories clearances to level 3 if it was to level 2 before
UPDATE modulesCategories_clearances SET clearance_mcc='3' WHERE clearance_mcc='2';