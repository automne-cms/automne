# $Id: cs_rows_separation_end.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Change format of rows stored in CS
# automne3.sql file since version : 1.19

ALTER TABLE `mod_standard_clientSpaces_archived` CHANGE `rowsDefinition_cs` `rowsDefinition_cs` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE `mod_standard_clientSpaces_deleted` CHANGE `rowsDefinition_cs` `rowsDefinition_cs` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE `mod_standard_clientSpaces_edited` CHANGE `rowsDefinition_cs` `rowsDefinition_cs` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE `mod_standard_clientSpaces_edition` CHANGE `rowsDefinition_cs` `rowsDefinition_cs` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE `mod_standard_clientSpaces_public` CHANGE `rowsDefinition_cs` `rowsDefinition_cs` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE `mod_standard_clientSpaces_archived` ADD INDEX ( `type_cs` ) ;
ALTER TABLE `mod_standard_clientSpaces_deleted` ADD INDEX ( `type_cs` ) ;
ALTER TABLE `mod_standard_clientSpaces_edited` ADD INDEX ( `type_cs` ) ;
ALTER TABLE `mod_standard_clientSpaces_edition` ADD INDEX ( `type_cs` ) ;
ALTER TABLE `mod_standard_clientSpaces_public` ADD INDEX ( `type_cs` ) ;
