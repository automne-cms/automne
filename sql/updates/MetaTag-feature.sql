#05/01/2004 
#
#Added in Automne .sql since
#Automne2.sql version 1.18
#Automne2-data.sql version 1.19

#[FEATURE] Updated page meta tags (some newers) and created <atm-meta-tags /> 
#to use in each template instead of <atm-description /> and <atm-keywords />

#Add following META : 
#<meta name="description" content="" />
#<meta name="keywords" content="" />
#<meta name="category" content="" />
#Auto <meta name="generator" content="Automne" />
#Auto <meta name="identifier-url" content="http://" />
#<meta name="author" content="" />
#<meta name="reply-to" content="email@domain (Full Name)" />
#<meta name="copyright" content="" />
#<meta name="language" content="" />
#// Values : all, index, noindex, follow, nofollow
#<meta name="robots" content="all" />
#<meta http-equiv="last-modified" content="Wed, 26 Feb 1997 08:21:57 GMT" />
#Auto <meta name="revisit-after" content="30 days" />
#<meta http-equiv="pragma" content="no-cache" />
#Auto <meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT" />
#<meta http-equiv="refresh" content="duration_in_seconds;URL=http://" />

# -------------------------------------------------------------------------
#
#+- /automne/classes/tree/page.php
#+- /automne/admin/page_basedata.php
#+- /automne/templates/home-en.xml
#+- /automne/templates/home-fr.xml
#+- /automne/templates/automne.xml
#+- /automne/templates/n1-en.xml
#+- /automne/templates/n1-fr.xml
#+- /automne/templates/news-en.xml
#+- /automne/templates/news-fr.xml
#
# -------------------------------------------------------------------------

# New messages in standard module
INSERT INTO
	`I18NM_messages`
VALUES
	(1044, 'standard', 20040105162200, 'Catégorie', 'Category'),
	(1033, 'standard', 20040105162232, 'Auteur', 'Author'),
	(1034, 'standard', 20040105162315, 'Email de réponse', 'Reply-to email'),
	(1035, 'standard', 20040105162332, 'Copyright', 'Copyright'),
	(1036, 'standard', 20040105162408, 'Langue utilisée', 'Language used'),
	(1037, 'standard', 20040105162421, 'Robots', 'Robots'),
	(1038, 'standard', 20040105162521, 'Cache du navigateur', 'Browser memory'),
	(1039, 'standard', 20040105162714, 'Rafraichissement (ex:0;url=http://domain.com)', 'Refresh (ex:0;url=http://domain.com)'),
	(1040, 'standard', 20040105162714, 'Forcer la mise à jour (balise Pragma en `no-cache`)', 'Force page update setting Pragma value to `no-cache`'),
	(1041, 'standard', 20040106094415, 'Balise Meta courantes (visible dans le code source de la page)', 'Common meta tags (visible in page cource code)'),
	(1042, 'standard', 20040106094733, 'valeurs : all, index, follow, noindex, nofollow', 'values : all, index, follow, noindex, nofollow'),
	(1043, 'standard', 20040105165337, 'Données de référencement', 'Referencing datas');

# Changes on page base datas tables

ALTER TABLE `pagesBaseData_edited` ADD `category_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `author_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `replyto_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `copyright_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `language_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `robots_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `pragma_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `refresh_pbd` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE `pagesBaseData_deleted` ADD `category_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `author_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `replyto_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `copyright_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `language_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `robots_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `pragma_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `refresh_pbd` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE `pagesBaseData_archived` ADD `category_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `author_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `replyto_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `copyright_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `language_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `robots_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `pragma_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `refresh_pbd` VARCHAR( 255 ) NOT NULL ;

ALTER TABLE `pagesBaseData_public` ADD `category_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `author_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `replyto_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `copyright_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `language_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `robots_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `pragma_pbd` VARCHAR( 255 ) NOT NULL ,
ADD `refresh_pbd` VARCHAR( 255 ) NOT NULL ;


