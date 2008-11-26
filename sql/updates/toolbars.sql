# $Id: toolbars.sql,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $
#
# Add wysiwyg toolbars management
# automne3.sql files since version : 1.28

CREATE TABLE `toolbars` (
`id_tool` INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`code_tool` VARCHAR( 20 ) NOT NULL ,
`label_tool` VARCHAR( 255 ) NOT NULL ,
`elements_tool` TEXT NOT NULL ,
INDEX ( `code_tool` )
) TYPE = MYISAM ;

# 
# Contenu de la table `toolbars`
# 

INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (1, 'Default', 'Default', 'Source|Separator1|FitWindow|Separator2|Preview|Templates|Separator3|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Print|Separator5|Undo|Redo|Separator6|Find|Replace|Separator7|SelectAll|RemoveFormat|Separator8|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Image|Table|Rule|SpecialChar|Separator15|Style|FontFormat|FontSize|TextColor|BGColor|Separator16|automneLinks');
INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (2, 'Basic', 'Basic', 'Source|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Table|Rule|SpecialChar|Separator1');
INSERT INTO toolbars (id_tool, code_tool, label_tool, elements_tool) VALUES (3, 'BasicLink', 'BasicLink', 'Source|Cut|Copy|Paste|PasteText|PasteWord|Separator4|Undo|Redo|Separator6|Bold|Italic|Underline|StrikeThrough|Separator9|Subscript|Superscript|Separator10|OrderedList|UnorderedList|Separator11|Outdent|Indent|Separator12|JustifyLeft|JustifyCenter|JustifyRight|JustifyFull|Separator13|Link|Unlink|Anchor|Separator14|Table|Rule|SpecialChar|Separator1');
