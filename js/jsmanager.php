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
// $Id: jsmanager.php,v 1.4 2009/04/02 14:01:19 sebastien Exp $

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

$jsfiles = array();
if (isset($_GET['files'])) {
	foreach (explode(',',$_GET['files']) as $file) {
		switch ($file) {
			case 'main':
				//Automne license (protected)
				$jsfiles [] = PATH_ADMIN_FS.'/js/license.js';
				//Automne JS files
				$jsfiles [] = PATH_ADMIN_FS.'/js/main.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/panel.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/sidepanel.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/framepanel.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/tabpanel.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/winpanel.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/window.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/tree.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/combobox.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/json.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/menu.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/string.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/layout.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/framewindow.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/form.js';
				//swfobject file
				$jsfiles [] = PATH_MAIN_FS.'/swfobject/swfobject.js';
				//SWF Upload
				//$jsfiles [] = PATH_MAIN_FS.'/swfupload/swfupload.js';
				//$jsfiles [] = PATH_MAIN_FS.'/swfupload/swfupload.cookies.js';
				
				$jsfiles [] = PATH_ADMIN_FS.'/js/fileupload.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/imageupload.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/emptyfield.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/linkfield.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/pagefield.js';
			break;
			case 'edit':
				//Automne license (protected)
				$jsfiles [] = PATH_ADMIN_FS.'/js/license.js';
				//Automne JS files
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
			case 'blackbird':
				//Blackbird JS file
				$jsfiles [] = PATH_MAIN_FS.'/blackbirdjs/blackbird.js';
			break;
			case 'codemirror':
				//CodeMirror JS file
				$jsfiles [] = PATH_MAIN_FS.'/codemirror/js/codemirror.js';
			break;
			case 'ext':
				//Ext license (protected)
				$jsfiles [] = PATH_MAIN_FS.'/ext/license.js';
				//Ext and base adapter
				if (SYSTEM_DEBUG) {
					$jsfiles [] = PATH_MAIN_FS.'/ext/source/core/Ext.js';
					$jsfiles [] = PATH_MAIN_FS.'/ext/source/adapter/ext-base.js';
				} else {
					$jsfiles [] = PATH_MAIN_FS.'/ext/adapter/ext/ext-base.js';
				}
				$jsfiles [] = (SYSTEM_DEBUG) ? PATH_MAIN_FS.'/ext/ext-all-debug.js' : PATH_MAIN_FS.'/ext/ext-all.js';
				//need to override some Ext methods
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/garbage.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/element.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/store.js';
				//Ext.ux.LiveDataPanel
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/LiveDataPanel.js';
				//Ext.ux.ItemSelector
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/DDView.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/MultiSelect.js';
				$jsfiles [] = PATH_ADMIN_FS.'/js/ext/ItemSelector.js';
				
				//set specific source debug files here
				//$jsfiles [] = PATH_MAIN_FS.'/ext/source/data/Connection.js';
				
				$jsfiles [] = PATH_ADMIN_FS.'/js/blank.js';
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