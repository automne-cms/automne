<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: jsmanager.php,v 1.9 2009/06/26 13:58:08 sebastien Exp $

/**
  * Javascript manager
  *
  * Interface generation of all javascript codes, 
  * Provide coherent user caching infos and allow gzip when possible
  *
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//here automatic HTML colmpression is not welcome. It is handled directly by CMS_file::sendFiles method
define('ENABLE_HTML_COMPRESSION', false);
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");

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
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/license.js';
				//Automne JS files
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/main.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/server.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/message.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/utils.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/view.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/console.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/categories.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/panel.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/sidepanel.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/framepanel.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/tabpanel.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/winpanel.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/window.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/tree.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/combobox.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/json.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/menu.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/string.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/layout.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/framewindow.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/form.js';
				//swfobject file
				$jsMainFiles [] = PATH_MAIN_FS.'/swfobject/swfobject.js';
				//SWF Upload
				//$jsMainFiles [] = PATH_MAIN_FS.'/swfupload/swfupload.js';
				//$jsMainFiles [] = PATH_MAIN_FS.'/swfupload/swfupload.cookies.js';
				
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/fileupload.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/imageupload.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/emptyfield.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/linkfield.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/pagefield.js';
				//FCKEditor
				$jsMainFiles [] = PATH_MAIN_FS.'/fckeditor/fckeditor.js';
				$jsMainFiles [] = PATH_ADMIN_FS.'/js/fckeditor.js';
				
				//Append others files in folder PATH_ADMIN_FS.'/js/' which is not already listed here
				try{
					foreach ( new DirectoryIterator(PATH_ADMIN_FS.'/js/') as $file) {
						$filename = realpath($file->getPathname());
						if ($file->isFile() && $file->getFilename() != ".htaccess" && $file->getFilename() != "launch.js") {
							$fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
							if ($fileExtension == 'js') {
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
				$jsfiles [] = PATH_ADMIN_FS.'/js/license.js';
				//Automne JS files
				//$jsfiles [] = PATH_ADMIN_FS.'/js/main.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/content.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/blocks.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/rows.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/clientspaces.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/launch-edit.js';
				//swfobject file
				$jsfiles [] = PATH_MAIN_FS.'/swfobject/swfobject.js';
				//standard block files
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/block-file.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/block-flash.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/block-image.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/block-text.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/edit/block-varchar.js';
			break;
			case 'launch':
				//this file launch application and must be the last to include
				$jsfiles [] = PATH_ADMIN_FS.'/js/launch.js';
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
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/js/codemirror.js';
			break;
			case 'ext':
				//Ext license (protected)
				$jsfiles [] = PATH_MAIN_FS.'/ext/license.js';
				//Ext and base adapter
				$jsfiles [] = PATH_MAIN_FS.'/ext/adapter/ext/ext-base.js';
				$jsfiles [] = (SYSTEM_DEBUG) ? PATH_MAIN_FS.'/ext/ext-all-debug.js' : PATH_MAIN_FS.'/ext/ext-all.js';
				//Need to override some Ext methods
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/garbage.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/element.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/store.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/Button.js';
				//Correct some Ext bugs
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/bug.js';
				
				//Ext.ux.LiveDataPanel
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/LiveDataPanel.js';
				//Ext.ux.ItemSelector
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/MultiSelect.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/Multiselect2.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/DDView.js';
				
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/Connection.js';
				
				//set specific source debug files here
				//$jsfiles [] = PATH_MAIN_FS.'/ext/source/data/Connection.js';
				
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/conf.js';
			break;
			case 'fr':
				//Ext french locales
				$jsfiles [] = PATH_MAIN_FS.'/ext/source/locale/ext-lang-fr.js';
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
				//check if file exists in current directory
				if ($file == str_replace(array_keys($replace), $replace, $file) && file_exists(dirname(__FILE__).'/'.$file)) {
					$jsfiles[] = dirname(__FILE__).'/'.$file;
				} elseif(substr($file, -3) == '.js' && file_exists(realpath($_SERVER['DOCUMENT_ROOT'].$file)) && strpos(realpath($_SERVER['DOCUMENT_ROOT'].$file), $_SERVER['DOCUMENT_ROOT']) !== false) {
					$jsfiles[] = $_SERVER['DOCUMENT_ROOT'].$file;
				}
			break;
		}
	}
}
CMS_file::sendFiles($jsfiles, 'text/javascript');
?>