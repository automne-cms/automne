<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * phpMyAdmin sample configuration, you can use it as base for
 * manual configuration. For easier setup you can use scripts/setup.php
 *
 * All directives are explained in Documentation.html and on phpMyAdmin
 * wiki <http://wiki.cihar.com>.
 *
 * @version $Id: config.inc.php,v 1.1 2009/03/02 11:47:35 sebastien Exp $
 */

/*
 * This is needed for cookie based authentication to encrypt password in
 * cookie
 */
$cfg['blowfish_secret'] = ''; /* YOU MUST FILL IN THIS FOR COOKIE AUTH! */

/*
 * Servers configuration
 */
$i = 0;

/*
 * First server
 */
$i++;

/* Authentication type */
$cfg['Servers'][$i]['auth_type'] = 'signon';
$cfg['Servers'][$i]['SignonSession'] = 'AutomneSession';
$cfg['Servers'][$i]['SignonURL']     = 'atmAuth.php?'.session_name().'='.session_id();

/* Server parameters */
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['compress'] = false;
/*if (defined('APPLICATION_DB_HOST')) {
	$cfg['Servers'][$i]['host'] 	= APPLICATION_DB_HOST;
} else {
	$cfg['Servers'][$i]['host'] 	= 'localhost';
}
$cfg['Servers'][$i]['user']		= APPLICATION_DB_USER;
$cfg['Servers'][$i]['password']	= APPLICATION_DB_PASSWORD;
$cfg['Servers'][$i]['only_db']	= APPLICATION_DB_NAME;
*/
/* Select mysqli if your server has it */
$cfg['Servers'][$i]['extension'] = 'mysql';
/* User for advanced features */
// $cfg['Servers'][$i]['controluser'] = APPLICATION_DB_USER;
// $cfg['Servers'][$i]['controlpass'] = APPLICATION_DB_PASSWORD;
/* Advanced phpMyAdmin features */
// $cfg['Servers'][$i]['pmadb'] = 'pmadb';
// $cfg['Servers'][$i]['bookmarktable'] = 'pma_bookmark';
// $cfg['Servers'][$i]['relation'] = 'pma_relation';
// $cfg['Servers'][$i]['table_info'] = 'pma_table_info';
// $cfg['Servers'][$i]['table_coords'] = 'pma_table_coords';
// $cfg['Servers'][$i]['pdf_pages'] = 'pma_pdf_pages';
// $cfg['Servers'][$i]['column_info'] = 'pma_column_info';
// $cfg['Servers'][$i]['history'] = 'pma_history';
// $cfg['Servers'][$i]['designer_coords'] = 'pma_designer_coords';
/* Contrib / Swekey authentication */
// $cfg['Servers'][$i]['auth_swekey_config'] = './swekey.conf';

/*
 * End of servers configuration
 */

/*
 * Directories for saving/loading files from server
 */
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';

?>
