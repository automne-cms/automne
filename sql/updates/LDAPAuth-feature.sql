# $Id: LDAPAuth-feature.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# [FEATURE] LDAP authentification, support "dn" attribute for profile user
#

## Structure

# Added in sql/automne3.sql since version : 
#
# Add a field in profileUsers to store LDAP distinguished name (dn)
ALTER TABLE `profilesUsers` ADD `dn_pru` VARCHAR( 255 ) NOT NULL AFTER `textEditor_pru` ;
ALTER TABLE `profilesUsers` ADD INDEX ( `dn_pru` ) ;

# Add a field in profileUsersGroup to store LDAP distinguished name (dn)
ALTER TABLE `profilesUsersGroups` ADD `dn_prg` VARCHAR( 255 ) NOT NULL ;
ALTER TABLE `profilesUsersGroups` ADD INDEX ( `dn_prg` ) ;


## I18NM messages

# Added in sql/automne3-I18NM_messages.sql since version 1.12
#
INSERT INTO `I18NM_messages` VALUES (10035, 'standard', NOW(), 'Distinguished Name', 'Distinguished Name');
INSERT INTO `I18NM_messages` VALUES (10036, 'standard', NOW(), '[Le dn (Distinguished Name) "%s" existe déjà]', '[Sorry, the LDAP dn "%s" is already used]');

#
# Added in sql/automne3-I18NM_messages.sql since version 
#
