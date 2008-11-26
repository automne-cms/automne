# $Id: cs_rows_separation.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Change format of rows stored in CS
# automne3.sql file since version : 1.19

ALTER TABLE `mod_standard_clientSpaces_archived` ADD `type_cs` INT( 11 ) NOT NULL AFTER `rowsDefinition_cs` ,
ADD `order_cs` INT( 11 ) NOT NULL AFTER `type_cs` ;
ALTER TABLE `mod_standard_clientSpaces_deleted` ADD `type_cs` INT( 11 ) NOT NULL AFTER `rowsDefinition_cs` ,
ADD `order_cs` INT( 11 ) NOT NULL AFTER `type_cs` ;
ALTER TABLE `mod_standard_clientSpaces_edited` ADD `type_cs` INT( 11 ) NOT NULL AFTER `rowsDefinition_cs` ,
ADD `order_cs` INT( 11 ) NOT NULL AFTER `type_cs` ;
ALTER TABLE `mod_standard_clientSpaces_edition` ADD `type_cs` INT( 11 ) NOT NULL AFTER `rowsDefinition_cs` ,
ADD `order_cs` INT( 11 ) NOT NULL AFTER `type_cs` ;
ALTER TABLE `mod_standard_clientSpaces_public` ADD `type_cs` INT( 11 ) NOT NULL AFTER `rowsDefinition_cs` ,
ADD `order_cs` INT( 11 ) NOT NULL AFTER `type_cs` ;

ALTER TABLE `mod_standard_clientSpaces_archived` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( `template_cs` , `tagID_cs` , `order_cs` ) ;
ALTER TABLE `mod_standard_clientSpaces_deleted` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( `template_cs` , `tagID_cs` , `order_cs` ) ;
ALTER TABLE `mod_standard_clientSpaces_edited` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( `template_cs` , `tagID_cs` , `order_cs` ) ;
ALTER TABLE `mod_standard_clientSpaces_edition` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( `template_cs` , `tagID_cs` , `order_cs` ) ;
ALTER TABLE `mod_standard_clientSpaces_public` DROP PRIMARY KEY ,
ADD PRIMARY KEY ( `template_cs` , `tagID_cs` , `order_cs` ) ;
