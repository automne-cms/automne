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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: cssmanager.php,v 1.10 2010/03/08 16:45:06 sebastien Exp $

/**
  * CSS manager
  *
  * Interface generation of all CSS codes, 
  * Provide coherent user caching infos and allow gzip when possible
  *
  * @package Automne
  * @subpackage frontend
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//here automatic HTML colmpression is not welcome. It is handled directly by CMS_file::sendFiles method
define('ENABLE_HTML_COMPRESSION', false);
define('APPLICATION_EXEC_TYPE', 'css');
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');

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
				$cssfiles [] = PATH_ADMIN_CSS_FS.'/superboxselect.css';//superselect styles
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
			case 'codemirror':
				//CodeMirror CSS file
				$cssfiles [] = PATH_MAIN_FS.'/codemirror/codemirror.css';
			break;
			default:
				$replace = array(
					'..' => '',
					'\\' => '',
					'/' => '',
				);
				$docrootPath = realpath($_SERVER["DOCUMENT_ROOT"].$file);
				$realrootPath = realpath(PATH_REALROOT_FS.'/'.$file);
				$dirnamePath = realpath(dirname(__FILE__).'/'.$file);
				if ($file == str_replace(array_keys($replace), $replace, $file) && file_exists($dirnamePath) && is_file($dirnamePath)) {
					$cssfiles [] = $dirnamePath;
				} elseif(in_array(pathinfo($file, PATHINFO_EXTENSION), array('css', 'less')) && substr($file, 0, 1) == '/'
						&& file_exists($docrootPath) 
						&& is_file($docrootPath)
						&& (strpos(pathinfo($docrootPath, PATHINFO_DIRNAME), realpath(PATH_CSS_FS)) === 0 
							|| strpos(pathinfo($docrootPath, PATHINFO_DIRNAME), realpath(PATH_ADMIN_CSS_FS)) === 0)) {
					$cssfiles[] = $docrootPath;
				} elseif(in_array(pathinfo($file, PATHINFO_EXTENSION), array('css', 'less')) && substr($file, 0, 1) != '/'
						&& file_exists($realrootPath) 
						&& is_file($realrootPath)
						&& (strpos(pathinfo($realrootPath, PATHINFO_DIRNAME), realpath(PATH_CSS_FS)) === 0 
							|| strpos(pathinfo($realrootPath, PATHINFO_DIRNAME), realpath(PATH_ADMIN_CSS_FS)) === 0)) {
					$cssfiles[] = $realrootPath;
				}
			break;
		}
	}
}
CMS_file::sendFiles($cssfiles, 'text/css');
?>