# $Id: ClientsSpacesLocations-refactor.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of structure tables and sample datas were added in 
# automne3.sql files since version : 1.6
# automne3-data.sql files since version : 1.6
# automne3-scratch.sql files since version : 1.4

# [BUG][REFACTOR] Updating rows in clientspaces could have bad consequences
# in public pages content when regenerated. Solved. All clientspaces
# are stored in all locations (edited, deleted, archived, public, etc)

# Try to apply these changes on any Automne website older than version 3.1.2
# files linked to these changes :
#  - automne/classes/tree/pagetemplate.php 
#  - automne/classes/tree/pagetemplatescatalog.php
#  - automne/classes/modules/standard.php
#  - automne/classes/modules/moduleclientspace.php
#  - automne/classes/modules/standard/clientspace.php
#  - automne/classes/modules/standard/clientspacescatalog.php
#  - automne/classes/modules/standard/row.php
#  - automne/admin/page_content.php
#  - automne/admin/page_summary.php
#  - automne/admin/page_template.php
#  - automne/admin/templates.php
#  - automne/sql/automne3.sql
#  - automne/sql/automne3-data.sql
#  - automne/sql/automne3-scratch.sql


ALTER TABLE `mod_standard_clientSpaces` RENAME `mod_standard_clientSpaces_edited` ;

CREATE TABLE IF NOT EXISTS `mod_standard_clientSpaces_deleted` (
`template_cs` int( 11 ) unsigned NOT NULL default '0',
`tagID_cs` varchar( 100 ) NOT NULL default '',
`rowsDefinition_cs` mediumtext NOT NULL ,
PRIMARY KEY ( `template_cs` , `tagID_cs` ) ,
KEY `template_cs` ( `template_cs` )
) TYPE = MYISAM ;

CREATE TABLE IF NOT EXISTS `mod_standard_clientSpaces_archived` (
`template_cs` int( 11 ) unsigned NOT NULL default '0',
`tagID_cs` varchar( 100 ) NOT NULL default '',
`rowsDefinition_cs` mediumtext NOT NULL ,
PRIMARY KEY ( `template_cs` , `tagID_cs` ) ,
KEY `template_cs` ( `template_cs` )
) TYPE = MYISAM ;

CREATE TABLE IF NOT EXISTS `mod_standard_clientSpaces_public` (
`template_cs` int( 11 ) unsigned NOT NULL default '0',
`tagID_cs` varchar( 100 ) NOT NULL default '',
`rowsDefinition_cs` mediumtext NOT NULL ,
PRIMARY KEY ( `template_cs` , `tagID_cs` ) ,
KEY `template_cs` ( `template_cs` )
) TYPE = MYISAM ;

INSERT INTO `mod_standard_clientSpaces_public`
SELECT *
FROM `mod_standard_clientSpaces_edited` ;
