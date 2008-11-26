# $Id: rowsGroupsManagement.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Add groups feature on rows
# automne3.sql files since version : 1.23

#Change mod_standard_rows table structure
ALTER TABLE `mod_standard_rows` ADD `groupsStack_row` VARCHAR( 255 ) NOT NULL;
#Change profiles table structure
ALTER TABLE `profiles` ADD `rowGroupsDeniedStack_pr` VARCHAR( 255 ) NOT NULL AFTER `templateGroupsDeniedStack_pr` ;
#Change pageTemplates table structure
ALTER TABLE `pageTemplates` CHANGE `groupsStack_pt` `groupsStack_pt` VARCHAR( 255 ) NOT NULL 