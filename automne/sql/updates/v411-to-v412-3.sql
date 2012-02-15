ALTER TABLE  `mod_object_i18nm` CHANGE  `code_i18nm`  `code_i18nm` CHAR( 5 ) NOT NULL;
ALTER TABLE  `modulesCategories_i18nm` CHANGE  `language_mcl`  `language_mcl` CHAR( 5 ) NOT NULL DEFAULT 'en';
ALTER TABLE  `mod_cms_forms_formulars` CHANGE  `language_frm`  `language_frm` CHAR( 5 ) NOT NULL DEFAULT  'en';