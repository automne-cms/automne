# $Id: automne4-scratch.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
# Database : `automne3`
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

DELETE FROM contactDatas;
INSERT INTO contactDatas (id_cd, service_cd, jobTitle_cd, addressField1_cd, addressField2_cd, addressField3_cd, zip_cd, city_cd, state_cd, country_cd, phone_cd, cellphone_cd, fax_cd, email_cd) VALUES (1, '', '', '', '', '', '', '', '', '', '', '', '', 'automne@votredomain.com');
INSERT INTO contactDatas (id_cd, service_cd, jobTitle_cd, addressField1_cd, addressField2_cd, addressField3_cd, zip_cd, city_cd, state_cd, country_cd, phone_cd, cellphone_cd, fax_cd, email_cd) VALUES (3, '', '', '', '', '', '', '', '', '', '', '', '', 'automne@votredomain.com');

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
#remove preview to page 5 
UPDATE mod_object_definition SET previewURL_mod = '' WHERE id_mod = '1';

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

DELETE FROM mod_standard_rows WHERE id_row > '60';
DELETE FROM mod_standard_rows WHERE id_row = '56';

DELETE FROM modulesCategories where id_mca > 2;
DELETE FROM modulesCategories_clearances where category_mcc > 2;
DELETE FROM modulesCategories_i18nm where category_mcl > 2;

DELETE FROM pageTemplates;
INSERT INTO pageTemplates VALUES (1, 'Splash', 'fr', '', 'splash.xml', 0, 0, 'nopicto.gif', 0, '');
INSERT INTO pageTemplates VALUES (2, 'Exemple', 'fr', 'standard', 'example.xml', 0, 0, 'nopicto.gif', 1, '');

# To reset Pages ID
DROP TABLE IF EXISTS pages;
CREATE TABLE pages (
  id_pag int(11) unsigned NOT NULL auto_increment,
  resource_pag int(11) unsigned NOT NULL default '0',
  remindedEditorsStack_pag varchar(255) NOT NULL default '',
  lastReminder_pag date NOT NULL default '0000-00-00',
  template_pag int(11) unsigned NOT NULL default '0',
  lastFileCreation_pag datetime NOT NULL default '0000-00-00 00:00:00',
  url_pag varchar(255) NOT NULL default '',
  PRIMARY KEY  (id_pag),
  KEY id_pag (id_pag),
  KEY template_pag (template_pag)
) TYPE=MyISAM;
INSERT INTO pages (id_pag, resource_pag, remindedEditorsStack_pag, lastReminder_pag, template_pag, lastFileCreation_pag, url_pag) VALUES (1, 1, '1', NOW(), 1, '2005-08-30 16:55:02', '');

DELETE FROM pagesBaseData_archived;
DELETE FROM pagesBaseData_deleted;
DELETE FROM pagesBaseData_edited;
INSERT INTO pagesBaseData_edited (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (1, 1, 'Accueil', 'Accueil', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '');

DELETE FROM pagesBaseData_public;
INSERT INTO pagesBaseData_public (id_pbd, page_pbd, title_pbd, linkTitle_pbd, keywords_pbd, description_pbd, reminderPeriodicity_pbd, reminderOn_pbd, reminderOnMessage_pbd, category_pbd, author_pbd, replyto_pbd, copyright_pbd, language_pbd, robots_pbd, pragma_pbd, refresh_pbd, redirect_pbd, refreshUrl_pbd, url_pbd) VALUES (1, 1, 'Accueil', 'Accueil', '', '', 0, '0000-00-00', '', '', '', '', '', '', '', '', '', '', '', '');

DELETE FROM profileUsersByGroup;

DELETE FROM profiles;
INSERT INTO profiles (id_pr, templateGroupsDeniedStack_pr, rowGroupsDeniedStack_pr, pageClearancesStack_pr, moduleClearancesStack_pr, validationClearancesStack_pr, administrationClearance_pr, alertLevel_pr) VALUES (1, '', '', '1,2', 'standard,2;cms_aliases,2;pnews,2;cms_forms,2', 'standard', 63, 1);
INSERT INTO profiles (id_pr, templateGroupsDeniedStack_pr, rowGroupsDeniedStack_pr, pageClearancesStack_pr, moduleClearancesStack_pr, validationClearancesStack_pr, administrationClearance_pr, alertLevel_pr) VALUES (3, 'fr;en', '', '1,1', '', '', 0, 2);

DELETE FROM profilesUsersGroups;

DELETE FROM profilesUsers;
INSERT INTO profilesUsers (id_pru, login_pru, password_pru, firstName_pru, lastName_pru, contactData_pru, profile_pru, language_pru, textEditor_pru, dn_pru, active_pru, deleted_pru) VALUES (1, 'root', '3b0d99b9bb927794036aa828050f364d', '', 'Super administrateur', 1, 1, 'fr', 'fckeditor', '', 1, 0);
INSERT INTO profilesUsers (id_pru, login_pru, password_pru, firstName_pru, lastName_pru, contactData_pru, profile_pru, language_pru, textEditor_pru, dn_pru, active_pru, deleted_pru) VALUES (3, 'anonymous', '294de3557d9d00b3d2d8a1e6aab028cf', '', 'Public user', 3, 3, 'fr', 'none', '', 1, 0);

DELETE FROM profilesUsers_validators;
INSERT INTO profilesUsers_validators (id_puv, userId_puv, module_puv) VALUES (1, 1, 'standard');

DELETE FROM resourceStatuses;
INSERT INTO resourceStatuses VALUES (1, 1, 0, 0, 0, 2, '2002-02-01', '0000-00-00');

DELETE FROM resourceValidations;

DELETE FROM resources;
INSERT INTO resources VALUES (1, 1, '');

DELETE FROM sessions;

DELETE FROM toolbars;
INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (1, 'Default', 'Default', 'Source|Separator1|FitWindow|Separator2|Preview|Templates|Separator3|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Print|Separator5|Undo|Redo|Separator6|Find|Replace|Separator7|SelectAll|RemoveFormat|Separator8|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Image|Table|Rule|SpecialChar|Separator15|Style|FontFormat|FontSize|TextColor|BGColor|Separator16|automneLinks');
INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (2, 'Basic', 'Basic', 'Source|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Table|Rule|SpecialChar|Separator1');
INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (3, 'BasicLink', 'BasicLink', 'Source|Separator1|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Table|Rule|SpecialChar|Separator16|automneLinks');

DELETE FROM websites;
INSERT INTO websites (id_web, label_web, url_web, root_web, keywords_web, description_web, category_web, author_web, replyto_web, copyright_web, language_web, robots_web, favicon_web, order_web) VALUES (1, 'Site principal', '127.0.0.1', 1, '', '', '', '', '', '', 'fr', '', '/favicon.ico', 0);