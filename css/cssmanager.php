<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2010 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: cssmanager.php,v 1.10 2010/03/08 16:45:06 sebastien Exp $

/**
  * CSS manager
  *
  * Interface generation of all CSS codes, 
  * Provide coherent user caching infos and allow gzip when possible
  *
  * @package CMS
  * @subpackage CSS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//here automatic HTML colmpression is not welcome. It is handled directly by CMS_file::sendFiles method
define('ENABLE_HTML_COMPRESSION', false);
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

$cssfiles = array();
if (isset($_GET['files'])) {
	foreach (explode(',',$_GET['files']) as $file) {
		switch ($file) {
			case 'ext':
				//Ext CSS files
				$cssfiles [] = PATH_MAIN_FS.'/ext/resources/css/ext-all-notheme.css';
				$cssfiles [] = PATH_MAIN_FS.'/ext/resources/css/xtheme-blue.css';
				$cssfiles [] = PATH_ADMIN_CSS_FS.'/xtheme-automne.css'; //Automne theme
				$cssfiles [] = PATH_ADMIN_CSS_FS.'/ext.css'; //overwrite some ext definitions
			break;
			case 'main':
				//Main Automne CSS file
				$cssfiles [] = PATH_ADMIN_CSS_FS.'/main.css';
			break;
			case 'info':
				//Automne info CSS file
				$cssfiles [] = PATH_ADMIN_CSS_FS.'/info.css';
			break;
			case 'edit':
				//Automne edition CSS file
				$cssfiles [] = PATH_ADMIN_CSS_FS.'/edit.css';
			break;
			case 'debug':
				//Blackbird CSS file
				$cssfiles [] = PATH_MAIN_FS.'/blackbirdjs/blackbird.css';
			break;
			default:
				$replace = array(
					'..' => '',
					'\\' => '',
					'/' => '',
				);
				//check if file exists in current directory
				if ($file == str_replace(array_keys($replace), $replace, $file) && file_exists(dirname(__FILE__).'/'.$file) && is_file(dirname(__FILE__).'/'.$file)) {
					$cssfiles [] = dirname(__FILE__).'/'.$file;
				} elseif(pathinfo($file, PATHINFO_EXTENSION) == 'css' 
						&& file_exists(realpath($_SERVER['DOCUMENT_ROOT'].$file)) 
						&& is_file(realpath($_SERVER['DOCUMENT_ROOT'].$file))
						&& (strpos(pathinfo(realpath($_SERVER['DOCUMENT_ROOT'].$file), PATHINFO_DIRNAME), realpath(PATH_CSS_FS)) === 0 
							|| strpos(pathinfo(realpath($_SERVER['DOCUMENT_ROOT'].$file), PATHINFO_DIRNAME), realpath(PATH_ADMIN_CSS_FS)) === 0)) {
					$cssfiles[] = $_SERVER['DOCUMENT_ROOT'].$file;
				}
			break;
		}
	}
}
CMS_file::sendFiles($cssfiles, 'text/css');
?>