#----------------------------------------------------------------
#
# Messages content for module cms_forms
# English Messages
#
#----------------------------------------------------------------
# $Id: cms_forms.sql,v 1.1 2010/01/18 17:29:43 sebastien Exp $

DELETE FROM messages WHERE module_mes = 'cms_forms' and language_mes = 'en';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'cms_forms', 'en', 'Forms');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(2, 'cms_forms', 'en', 'Here are the forms that were received by the application. You can export their data or delete it.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(3, 'cms_forms', 'en', 'Form');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(4, 'cms_forms', 'en', 'Records');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(5, 'cms_forms', 'en', 'Last post');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(6, 'cms_forms', 'en', 'No results found');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(7, 'cms_forms', 'en', 'Export');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(8, 'cms_forms', 'en', 'Delete');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(9, 'cms_forms', 'en', 'Do you confirm deletion of the ''%s'' action?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(10, 'cms_forms', 'en', 'Data received');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(11, 'cms_forms', 'en', 'PDF forms available for users');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(12, 'cms_forms', 'en', 'Here are the forms available.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(13, 'cms_forms', 'en', 'File');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(14, 'cms_forms', 'en', 'URL');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(15, 'cms_forms', 'en', 'Insertion date');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(16, 'cms_forms', 'en', 'Do you confirm deletion of form ''%s'' ?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(17, 'cms_forms', 'en', 'Insert PDF file');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(18, 'cms_forms', 'en', 'Error while uploading file !');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(19, 'cms_forms', 'en', 'Form name');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(20, 'cms_forms', 'en', 'Add a new form');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(21, 'cms_forms', 'en', 'Categories management :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(22, 'cms_forms', 'en', 'User access by groups :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(23, 'cms_forms', 'en', 'Forms management :');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(24, 'cms_forms', 'en', 'List');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(25, 'cms_forms', 'en', 'Entry');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(26, 'cms_forms', 'en', 'Label');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(27, 'cms_forms', 'en', 'Form name');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(28, 'cms_forms', 'en', 'XHTML source');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(29, 'cms_forms', 'en', 'Activated');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(30, 'cms_forms', 'en', 'Categories');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(31, 'cms_forms', 'en', 'An error occured while attempting to delete form');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(32, 'cms_forms', 'en', 'Please verify formular XHTML syntax');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(33, 'cms_forms', 'en', 'Add of categories failed');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(34, 'cms_forms', 'en', 'Add of category %s failed');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(35, 'cms_forms', 'en', 'Choose at least one category');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(36, 'cms_forms', 'en', 'Form actions');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(37, 'cms_forms', 'en', 'Nothing is selected');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(38, 'cms_forms', 'en', 'Action type');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(39, 'cms_forms', 'en', 'Values inserted in data base ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(40, 'cms_forms', 'en', 'If form datas are not correct ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(41, 'cms_forms', 'en', 'If form datas are correct');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(42, 'cms_forms', 'en', 'Sending of form values to one or more provided emails ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(43, 'cms_forms', 'en', 'Sending of form values to one email provided in a field of the form');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(44, 'cms_forms', 'en', 'Yes');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(45, 'cms_forms', 'en', 'No');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(46, 'cms_forms', 'en', 'Thank you, your message has been saved.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(47, 'cms_forms', 'en', 'Store form values in a CSV file ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(48, 'cms_forms', 'en', 'Max number of answers :<br /><small>(per users)</small>');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(49, 'cms_forms', 'en', 'Enter the maximum number of wished answers per users, or to leave vacuum not to limit this number ');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(50, 'cms_forms', 'en', 'Display a text');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(51, 'cms_forms', 'en', 'Redirect to a page');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(52, 'cms_forms', 'en', 'If the number of answers is exceeded');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(53, 'cms_forms', 'en', 'Current actions:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(54, 'cms_forms', 'en', 'Add an action:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(55, 'cms_forms', 'en', 'Enter your emails list (separator comma or semicolon)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(56, 'cms_forms', 'en', 'Enter the header message for emails');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(57, 'cms_forms', 'en', 'Text to display');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(58, 'cms_forms', 'en', 'Form field(s)');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(59, 'cms_forms', 'en', 'CSV File');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(60, 'cms_forms', 'en', 'You will be able to download CSV file here when data are available.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(61, 'cms_forms', 'en', 'No field which can contain an email was found in the form.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(62, 'cms_forms', 'en', 'Category');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(63, 'cms_forms', 'en', 'Find a form');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(64, 'cms_forms', 'en', 'Form selection');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(65, 'cms_forms', 'en', 'Select');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(66, 'cms_forms', 'en', 'Deselect');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(67, 'cms_forms', 'en', 'Please complete the following required fields:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(68, 'cms_forms', 'en', 'The following fields have incorrect content:');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(69, 'cms_forms', 'en', 'Message from form ''%s'' from website ''%s''');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(70, 'cms_forms', 'en', 'Enter the footer message for emails');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(71, 'cms_forms', 'en', 'Enter the subject message for emails');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(72, 'cms_forms', 'en', 'Download form datas in CSV format');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(73, 'cms_forms', 'en', 'Do you confirm deletion of recorded datas for the form ''%s''?');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(74, 'cms_forms', 'en', 'Reset');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(75, 'cms_forms', 'en', 'Authenticate user');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(76, 'cms_forms', 'en', 'No field which can contain a user ID was found in the form.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(77, 'cms_forms', 'en', 'No field which can contain a user password was found in the form.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(78, 'cms_forms', 'en', 'User ID');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(79, 'cms_forms', 'en', 'Password');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(80, 'cms_forms', 'en', 'Message displayed on wrong authentification');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(81, 'cms_forms', 'en', 'Remember account');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(82, 'cms_forms', 'en', 'No field which can be used to remember user account was found in the form.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(83, 'cms_forms', 'en', 'This action is not allowed during edition / previsualisation of the page.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(84, 'cms_forms', 'en', 'You must have ''%s'' active in your profile to Create / Edit a form.');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(87, 'cms_forms', 'en', 'Forms creation wizard');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(88, 'cms_forms', 'en', 'Sender address');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(89, 'cms_forms', 'en', 'With submission date');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(90, 'cms_forms', 'en', '[Error : you must not copy-paste code from one form to another one!]');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(91, 'cms_forms', 'en', 'The form has expired after a long inactivity. Please submit it again.');