# $Id: mod_polymod_update_0.97.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of polymod requirements for field description
# mod_polymod.sql file since version : 1.8
# Polymod since version 0.97

#Add polymod ASE features

# 
#  Table `mod_object_field`
# 
ALTER TABLE `mod_object_field` ADD `desc_id_mof` INT( 11 ) UNSIGNED NOT NULL AFTER `label_id_mof` ;

# 
#  Table `mod_object_plugin_definition`
# 
ALTER TABLE `mod_object_plugin_definition` ADD `compiled_definition_mowd` MEDIUMTEXT NOT NULL AFTER `definition_mowd` ;