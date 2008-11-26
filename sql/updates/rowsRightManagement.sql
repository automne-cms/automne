# $Id: rowsRightManagement.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of structure tables and sample datas were added in 
# automne3.sql files since version : 1.14
# automne3-data.sql files since version : 1.20

# [FEATURE] : Add module rights management to rows

ALTER TABLE `mod_standard_rows` ADD `modulesStack_row` VARCHAR( 255 ) NOT NULL AFTER `definitionFile_row` ;
UPDATE `mod_standard_rows` set `modulesStack_row` = 'standard';