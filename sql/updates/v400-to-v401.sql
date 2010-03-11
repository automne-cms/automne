ALTER TABLE `websites` ADD `altdomains_web` TEXT NOT NULL AFTER `url_web` ;
ALTER TABLE `mod_cms_forms_fields` ADD `params_fld` mediumtext  NOT NULL AFTER `order_fld` ;