# $Id: mod_polymod_update_0.95.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of polymod requirements for ASE module compatibility
# mod_polymod.sql file since version : 1.7
# Polymod since version 0.95

#Add polymod ASE features

# 
#  Table `mod_object_field`
# 
ALTER TABLE `mod_object_field` CHANGE `frontend_mof` `indexable_mof` INT( 1 ) UNSIGNED NOT NULL DEFAULT '0';

# 
#  Table `mod_object_definition`
# 
ALTER TABLE `mod_object_definition` ADD `indexable_mod` INT( 1 ) NOT NULL AFTER `previewURL_mod` ;
ALTER TABLE `mod_object_definition` ADD `indexURL_mod` MEDIUMTEXT NOT NULL AFTER `indexable_mod` ;
ALTER TABLE `mod_object_definition` ADD `compiledIndexURL_mod` MEDIUMTEXT NOT NULL AFTER `indexURL_mod` ;