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
// $Id: jsmanager.php,v 1.14 2010/03/08 16:45:15 sebastien Exp $

/**
  * Javascript manager
  *
  * Interface generation of all javascript codes, 
  * Provide coherent user caching infos and allow gzip when possible
  *
  * @package Automne
  * @subpackage frontend
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//here automatic HTML colmpression is not welcome. It is handled directly by CMS_file::sendFiles method
define('ENABLE_HTML_COMPRESSION', false);
define('APPLICATION_EXEC_TYPE', 'js');
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');

$files = '';
if (isset($_GET['files'])) {
	$files = $_GET['files'];
} elseif (isset($_SERVER['QUERY_STRING'])) {//On some configuration, files are too long and are not available in $_REQUEST so use $_SERVER['QUERY_STRING'] instead
	$var = array();
	parse_str($_SERVER['QUERY_STRING'], $var);
	if (isset($var['files'])) {
		$files = $var['files'];
	}
}

$jsfiles = array();
if ($files) {
	foreach (explode(',',$files) as $file) {
		switch ($file) {
			case 'main':
				$jsMainFiles = array();
				//Automne license (protected)
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/license.js';
				//Automne JS files
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/main.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/server.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/message.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/utils.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/view.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/scripts.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/console.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/categories.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/panel.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/sidepanel.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/framepanel.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/tabpanel.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/winpanel.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/window.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/tree.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/combobox.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/json.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/menu.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/string.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/layout.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/framewindow.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/form.js';
				//swfobject file
				$jsMainFiles [] = PATH_MAIN_FS.'/swfobject/swfobject.js';
				
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/fileupload.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/imageupload.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/emptyfield.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/linkfield.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/pagefield.js';
				//CKEditor
				$jsMainFiles [] = PATH_MAIN_FS.'/ckeditor/ckeditor.js';
				$jsMainFiles [] = PATH_ADMIN_JS_FS.'/ckeditor.js';
				
				//Append others files in folder PATH_ADMIN_JS_FS.'/' which is not already listed here
				$excludedFiles = array(
					'launch.js',
					'launch-popup.js',
					'initconfig.js',
					'.htaccess',
				);
				try{
					foreach ( new DirectoryIterator(PATH_ADMIN_JS_FS.'/') as $file) {
						$filename = realpath($file->getPathname());
						if ($file->isFile() && !in_array($file->getFilename(), $excludedFiles)) {
							$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
							if ($fileExtension == 'js' && substr(pathinfo($filename, PATHINFO_BASENAME),0,2) !== '._') {
								$exists = false;
								foreach ($jsMainFiles as $aFile) {
									if ($filename == realpath($aFile)) {
										$exists = true;
										break;
									}
								}
								if (!$exists) {
									$jsMainFiles[] = $filename;
								}
							}
						}
					}
				} catch(Exception $e) {}
				$jsfiles = array_merge($jsfiles, $jsMainFiles);
			break;
			case 'edit':
				//Automne license (protected)
				$jsfiles [] = PATH_ADMIN_JS_FS.'/license.js';
				//Automne JS files
				//$jsfiles [] = PATH_ADMIN_JS_FS.'/main.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/content.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/blocks.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/rows.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/clientspaces.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/launch-edit.js';
				//swfobject file
				$jsfiles [] = PATH_MAIN_FS.'/swfobject/swfobject.js';
				//standard block files
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/block-file.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/block-flash.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/block-image.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/block-text.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/block-varchar.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/edit/block-link.js';
				//CKEditor
				$jsfiles [] = PATH_MAIN_FS.'/ckeditor/ckeditor.js';
			break;
			case 'launch':
				//this file launch application and must be the last to include
				$jsfiles [] = PATH_ADMIN_JS_FS.'/launch.js';
			break;
			case 'popup':
				//this file launch application and must be the last to include
				$jsfiles [] = PATH_ADMIN_JS_FS.'/launch-popup.js';
			break;
			case 'initconfig':
				//this file launch application and must be the last to include
				$jsfiles [] = PATH_ADMIN_JS_FS.'/initconfig.js';
			break;
			case 'swfobject':
				$jsfiles [] = PATH_MAIN_FS.'/swfobject/swfobject.js';
			break;
			case 'debug':
				//Blackbird JS file
				$jsfiles [] = PATH_MAIN_FS.'/blackbirdjs/blackbird.js';
				//prettyPrint JS file
				$jsfiles [] = PATH_MAIN_FS.'/prettyprint/prettyprint.js';
			break;
			case 'codemirror':
				//CodeMirror JS file
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/codemirror.js';
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/indent.js';
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/foldcode.js';
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/xml.js';
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/javascript.js';
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/css.js';
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/clike.js';
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/php.js';
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/htmlmixed.js';
			break;
			case 'ext':
				//Ext license (protected)
				$jsfiles [] = PATH_MAIN_FS.'/ext/license.js';
				//Ext and base adapter
				$jsfiles [] = (SYSTEM_DEBUG) ? PATH_MAIN_FS.'/ext/adapter/ext/ext-base-debug.js' : PATH_MAIN_FS.'/ext/adapter/ext/ext-base.js';
				$jsfiles [] = (SYSTEM_DEBUG) ? PATH_MAIN_FS.'/ext/ext-all-debug.js' : PATH_MAIN_FS.'/ext/ext-all.js';
				//Need to override some Ext methods
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/garbage.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/element.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/store.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/Button.js';
				//Correct some Ext bugs
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/bug.js';
				
				//Ext.ux.LiveDataPanel
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/LiveDataPanel.js';
				//Ext.ux.ItemSelector
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/MultiSelect.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/Multiselect2.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/SuperBoxSelect.js';
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/DDView.js';
				//Ext.ux.TabScrollerMenu
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/TabScrollerMenu.js';
				//Ext.ux.GMapPanel
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/GMapPanel.js';
				
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/Connection.js';
				
				//set specific source debug files here
				//$jsfiles [] = PATH_MAIN_FS.'/ext/source/data/Connection.js';
				
				$jsfiles [] = PATH_ADMIN_JS_FS.'/ext/conf.js';
			break;
			case 'fr':
				//Ext french locales
				$jsfiles [] = PATH_MAIN_FS.'/ext/src/locale/ext-lang-fr.js';
			break;
			case 'en':
				//Ext english locales (nothing for now)
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
					$jsfiles[] = $dirnamePath;
				} elseif(pathinfo($file, PATHINFO_EXTENSION) == 'js' && substr($file, 0, 1) == '/'
						&& file_exists($docrootPath) 
						&& is_file($docrootPath)
						&& (strpos(pathinfo($docrootPath, PATHINFO_DIRNAME), realpath(PATH_JS_FS)) === 0 
							|| strpos(pathinfo($docrootPath, PATHINFO_DIRNAME), realpath(PATH_ADMIN_JS_FS)) === 0)) {
					$jsfiles[] = $docrootPath;
				} elseif(pathinfo($file, PATHINFO_EXTENSION) == 'js' && substr($file, 0, 1) != '/'
						&& file_exists($realrootPath) 
						&& is_file($realrootPath)
						&& (strpos(pathinfo($realrootPath, PATHINFO_DIRNAME), realpath(PATH_JS_FS)) === 0 
							|| strpos(pathinfo($realrootPath, PATHINFO_DIRNAME), realpath(PATH_ADMIN_JS_FS)) === 0)) {
					$jsfiles[] = $realrootPath;
				}
			break;
		}
	}
}

CMS_file::sendFiles($jsfiles, 'text/javascript');
?>