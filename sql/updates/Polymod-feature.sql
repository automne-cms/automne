# $Id: Polymod-feature.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Declaration of polymod modules type on modules table
# automne3.sql files since version : 1.16

#Add polymod features

ALTER TABLE `modules` ADD `isPolymod_mod` INT( 1 ) UNSIGNED NOT NULL AFTER `hasParameters_mod` ;

ALTER TABLE `modules` ADD INDEX ( `isPolymod_mod` ) ;