#09/03/2004 
#
#Added in Automne .sql since
#Automne2.sql version 1.20
#Automne2-data.sql version 1.23
#automne2-I18NM_messages.sql version 1.4

#[FEATURE] Updated page meta admin, newers feature

# --------------------------------------------------------
DELETE FROM I18NM_messages WHERE module='standard' and id='902';

# --------------------------------------------------------

INSERT INTO I18NM_messages (id, module, timestamp, fr, en) VALUES 
(902, 'standard', 20030331165734, 'Une page (Arbo)', 'One page (Tree)'),
(1060, 'standard', 20040127180510, 'Effacer la Table', 'Clear Table'),
(1061, 'standard', 20040127180510, 'Une page (ID)', 'One page (ID)'),
(1062, 'standard', 20040127180510, 'Lancé le', 'Launch Date'),
(1063, 'standard', 20040127180510, 'Fichier PID', 'PID File'),
(1064, 'standard', 20040127180510, 'Présent', 'Present'),
(1065, 'standard', 20040127180510, 'Absent', 'Absent'),
(1066, 'standard', 20040127180510, 'Pages en cours de Regénération', 'regeneration page in progress'),
(1067, 'standard', 20040127180510, 'Scripts en cours', 'Scripts in progress');

# --------------------------------------------------------

DROP TABLE IF EXISTS `scriptsStatuses`;
CREATE TABLE `scriptsStatuses` (
  `scriptName_ss` varchar(255) NOT NULL default '',
  `launchDate_ss` datetime default NULL,
  `pidFileName_ss` varchar(255) NOT NULL default ''
) TYPE=MyISAM;

# --------------------------------------------------------

