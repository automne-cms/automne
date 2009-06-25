# $Id: automne4-scratch.sql,v 1.4 2009/06/25 10:31:40 sebastien Exp $
# Database : `automne4`
# --------------------------------------------------------

#
# This script can help you to make a fresh and clean install of Automne 3
# It remove all pages, rows, users and data of Automne and all datas of the pre-installed Automne demo
# /!\ Use it carefully /!\
#

DELETE FROM actionsTimestamps;

DELETE FROM blocksFiles_archived;
DELETE FROM blocksFiles_deleted;
DELETE FROM blocksFiles_edited;
DELETE FROM blocksFiles_edition;
DELETE FROM blocksFiles_public;

DELETE FROM blocksFlashes_archived;
DELETE FROM blocksFlashes_deleted;
DELETE FROM blocksFlashes_edited;
DELETE FROM blocksFlashes_edition;
DELETE FROM blocksFlashes_public;

DELETE FROM blocksImages_archived;
DELETE FROM blocksImages_deleted;
DELETE FROM blocksImages_edited;
DELETE FROM blocksImages_edition;
DELETE FROM blocksImages_public;

DELETE FROM blocksTexts_archived;
DELETE FROM blocksTexts_deleted;
DELETE FROM blocksTexts_edited;
DELETE FROM blocksTexts_edition;
DELETE FROM blocksTexts_public;

DELETE FROM blocksVarchars_archived;
DELETE FROM blocksVarchars_deleted;
DELETE FROM blocksVarchars_edited;
DELETE FROM blocksVarchars_edition;
DELETE FROM blocksVarchars_public;

DELETE FROM contactDatas where id_cd not in (1, 3);

DELETE FROM linx_real_public;
DELETE FROM linx_tree_edited;
DELETE FROM linx_tree_public;
DELETE FROM linx_watch_public;
DELETE FROM locks;
DELETE FROM log;

DELETE FROM mod_cms_forms_actions;
DELETE FROM mod_cms_forms_categories;
DELETE FROM mod_cms_forms_fields;
DELETE FROM mod_cms_forms_formulars;
DELETE FROM mod_cms_forms_records;
DELETE FROM mod_cms_forms_senders;
DELETE FROM mod_cms_aliases;
DELETE FROM mod_object_polyobjects;
DELETE FROM mod_object_rss_definition;
#remove preview url
UPDATE mod_object_definition SET previewURL_mod = '';

DELETE FROM mod_standard_clientSpaces_edited;
DELETE FROM mod_standard_clientSpaces_edition;
DELETE FROM mod_standard_clientSpaces_public;
DELETE FROM mod_standard_clientSpaces_deleted;
DELETE FROM mod_standard_clientSpaces_archived;

DELETE FROM mod_subobject_date_deleted;
DELETE FROM mod_subobject_date_edited;
DELETE FROM mod_subobject_date_public;
DELETE FROM mod_subobject_integer_deleted;
DELETE FROM mod_subobject_integer_edited;
DELETE FROM mod_subobject_integer_public;
DELETE FROM mod_subobject_string_deleted;
DELETE FROM mod_subobject_string_edited;
DELETE FROM mod_subobject_string_public;
DELETE FROM mod_subobject_text_deleted;
DELETE FROM mod_subobject_text_edited;
DELETE FROM mod_subobject_text_public;

#last news use a link to page 5
DELETE FROM mod_standard_rows WHERE id_row = '66'; 

DELETE FROM modulesCategories where id_mca not in (1,2,18);
DELETE FROM modulesCategories_clearances where category_mcc not in (1,2,18);
DELETE FROM modulesCategories_i18nm where category_mcl not in (1,2,18);

DELETE FROM pageTemplates;
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (1, 'Splash', 'fr', '', 'splash.xml', 0, 0, 'nopicto.gif', 0, '', 'Modèle vide. Employé pour les pages de redirections.', '');
INSERT INTO `pageTemplates` (`id_pt`, `label_pt`, `groupsStack_pt`, `modulesStack_pt`, `definitionFile_pt`, `creator_pt`, `private_pt`, `image_pt`, `inUse_pt`, `printingCSOrder_pt`, `description_pt`, `websitesdenied_pt`) VALUES (2, 'Exemple', 'fr', 'standard', 'example.xml', 0, 0, 'nopicto.gif', 0, '', 'Modèle d''exemple.', '');

# To reset Pages ID
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id_pag` int(11) unsigned NOT NULL auto_increment,
  `resource_pag` int(11) unsigned NOT NULL default '0',
  `remindedEditorsStack_pag` varchar(255) NOT NULL default '',
  `lastReminder_pag` date NOT NULL default '0000-00-00',
  `template_pag` int(11) unsigned NOT NULL default '0',
  `lastFileCreation_pag` datetime NOT NULL default '0000-00-00 00:00:00',
  `url_pag` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id_pag`),
  KEY `id_pag` (`id_pag`),
  KEY `template_pag` (`template_pag`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (1, 1, '1', NOW(), 1, '2009-01-01 16:55:02', '');

DELETE FROM pagesBaseData_archived;
DELETE FROM pagesBaseData_deleted;
DELETE FROM pagesBaseData_edited;
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (1, 1, 'Accueil', 'Accueil', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '');

DELETE FROM pagesBaseData_public;
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (1, 1, 'Accueil', 'Accueil', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '');

DELETE FROM profileUsersByGroup;

DELETE FROM profiles where id_pr not in (1,3);
DELETE FROM profilesUsersGroups;

DELETE FROM profilesUsers where id_pru not in (1,3);

DELETE FROM profilesUsers_validators;

DELETE FROM resourceStatuses;
INSERT INTO `resourceStatuses` (`id_rs`, `location_rs`, `proposedFor_rs`, `editions_rs`, `validationsRefused_rs`, `publication_rs`, `publicationDateStart_rs`, `publicationDateEnd_rs`, `publicationDateStartEdited_rs`, `publicationDateEndEdited_rs`) VALUES (1, 1, 0, 0, 0, 2, '2009-01-01', '0000-00-00', '2009-01-01', '0000-00-00');


DELETE FROM resourceValidations;

DELETE FROM resources;
INSERT INTO `resources` (`id_res`, `status_res`, `editorsStack_res`) VALUES (1, 1, '');

DELETE FROM sessions;

DELETE FROM websites where id_web != 1;