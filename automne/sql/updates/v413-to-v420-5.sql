ALTER TABLE  `modulesCategories_clearances` DROP INDEX  `profilecategories`;
ALTER TABLE  `modulesCategories_clearances` DROP  `id_mcc`;
ALTER TABLE  `modulesCategories_clearances` CHANGE  `category_mcc`  `category_mcc` INT( 11 ) UNSIGNED NOT NULL DEFAULT  '0';
ALTER TABLE  `modulesCategories_clearances` CHANGE  `clearance_mcc`  `clearance_mcc` INT( 11 ) UNSIGNED NOT NULL DEFAULT  '0';