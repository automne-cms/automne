#----------------------------------------------------------------
#
# Messages content for module cms_aliases
# English Messages
#
#----------------------------------------------------------------
# $Id: cms_aliases.sql,v 1.2 2010/02/03 16:53:49 sebastien Exp $

DELETE FROM messages WHERE module_mes = 'cms_aliases' and language_mes = 'en';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'cms_aliases', 'en', 'Aliases ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(2, 'cms_aliases', 'en', 'Alias path');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(3, 'cms_aliases', 'en', 'Target');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(4, 'cms_aliases', 'en', 'Sub-aliases');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(5, 'cms_aliases', 'en', 'Do you confirm deletion of the alias ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(6, 'cms_aliases', 'en', 'Parent');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(7, 'cms_aliases', 'en', 'Alias creation / modification');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(8, 'cms_aliases', 'en', '[Error: Impossible to create this alias, a folder with this name already exists!]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(9, 'cms_aliases', 'en', '[Error while deleting the alias...]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(10, 'cms_aliases', 'en', 'Nom de votre alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(11, 'cms_aliases', 'en', 'Label');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(12, 'cms_aliases', 'en', 'Redirection');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(13, 'cms_aliases', 'en', 'Choose destination for the alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(14, 'cms_aliases', 'en', 'Sites');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(15, 'cms_aliases', 'en', 'Select Websites for which the alias applies. Attention to this distinction applies, sites should have separate domain names. If no site is selected, all sites will use this alias.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(16, 'cms_aliases', 'en', 'Replace address');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(17, 'cms_aliases', 'en', 'Replace the address of the page selected by the address of the alias?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(18, 'cms_aliases', 'en', 'If you check this box, the address of the selected page will be replaced by the address of the alias. A page can have only one alias with this property checked.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(19, 'cms_aliases', 'en', 'Permanent redirection');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(20, 'cms_aliases', 'en', 'Does this alias should return a permanent HTTP redirect code (301)?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(21, 'cms_aliases', 'en', 'If you check this box, the redirection will be made using 301 HTTP code. That is, the alias address will not be indexed by search engines. Only the address of the destination page will be indexed. <br /> If you do not check this box, the redirection will use 302 HTTP code: it will be considered temporary by search engines that will also indexes address of the alias in their base. <br /> If you do not know what to choose, check to avoid problems related to your SEO.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(22, 'cms_aliases', 'en', 'Protected Alias');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(23, 'cms_aliases', 'en', 'A protected alias can not be edited, moved, removed except by an administrator.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(24, 'cms_aliases', 'en', 'If an alias is protected, it is not possible to change the properties or position in the tree. Only an administrator can remove the protection of an alias. It is then possible to modify the properties or position. Use protection to prevent an important alias of your site to be changed inadvertently.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(25, 'cms_aliases', 'en', 'Redirect to:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(26, 'cms_aliases', 'en', 'Managing your websites aliases. An alias is a forwarding address to a page or an external URL.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(27, 'cms_aliases', 'en', 'Website root:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(28, 'cms_aliases', 'en', 'Do you confirm the suppression of the alias:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(29, 'cms_aliases', 'en', 'On this page you can manage an alias and its properties. Move your mouse over each field to get help on their use.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(30, 'cms_aliases', 'en', 'You must select a redirect to a page (internal links) in the Redirect field above to check this option.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(31, 'cms_aliases', 'en', 'This alias is for all sites.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(32, 'cms_aliases', 'en', 'Restricted alias:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(33, 'cms_aliases', 'en', 'This alias is only valid for the following sites:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(34, 'cms_aliases', 'en', 'Alias:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(35, 'cms_aliases', 'en', 'You may not use this label for your alias, the directory already exists...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(36, 'cms_aliases', 'en', 'The specified redirection is incorrect ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(37, 'cms_aliases', 'en', 'Error on the landing page of the redirection ...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(38, 'cms_aliases', 'en', 'Error during update: the alias is protected and can not be changed.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(39, 'cms_aliases', 'en', 'Managing alias of the page. The red alias replaces the address of the page.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(40, 'cms_aliases', 'en', 'Replaces the address:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(41, 'cms_aliases', 'en', 'Error: Page %s already has an alias that replaces address...');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(42, 'cms_aliases', 'en', 'ALIAS HAS AN ERROR.');
