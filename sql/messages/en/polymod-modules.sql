#----------------------------------------------------------------
#
# Messages content for polymod modules pmedia and pnews
# English Messages
#
#----------------------------------------------------------------
# $Id: polymod-modules.sql,v 1.1 2010/01/18 17:29:43 sebastien Exp $

DELETE FROM messages WHERE (module_mes = 'pmedia' or module_mes = 'pnews') and language_mes = 'en';

INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'pmedia', 'en', 'Mediacenter');
INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES(1, 'pnews', 'en', 'News');