# $Id: mod_polymod_update_1.02.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Alter definition table to store results definition
# mod_polymod.sql file since version : 1.10
# Polymod since version 1.02

#Add polymod ASE features

# 
#  Table `mod_object_definition`
# 
ALTER TABLE `mod_object_definition` ADD `resultsDefinition_mod` MEDIUMTEXT NOT NULL ;