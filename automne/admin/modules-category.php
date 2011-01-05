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
// $Id: modules-category.php,v 1.7 2010/03/08 16:41:19 sebastien Exp $

/**
  * PHP page : Load category item interface
  * Used accross an Ajax request. Render a category item for edition
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_FIELD_DESC", 139);
define("MESSAGE_PAGE_FIELD_FILE", 191);
define("MESSAGE_ALL_FILE",530);
define("MESSAGE_IMAGE",803);
define("MESSAGE_PAGE_FIELD_PARENT_CATEGORY", 1214);
define("MESSAGE_PAGE_FIELD_THUMBNAIL", 833);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_TITLE", 689);
define("MESSAGE_TOOLBAR_HELP_MESSAGE", 690);
define("MESSAGE_PAGE_FORM_INCORRECT", 682);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$fatherId = sensitiveIO::request('fatherId', 'sensitiveIO::isPositiveInteger');
$catId = sensitiveIO::request('category', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());

//CHECKS user has module clearance
if (!$codename) {
	CMS_grandFather::raiseError('Error, unknown module : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('Error, user has no rights on module : '.$codename);
	$view->show();
}
//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename($codename);

$all_languages = CMS_languagesCatalog::getAllLanguages($codename);
//resort by user language first
$userlanguage = $all_languages[$cms_language->getCode()];
if ($userlanguage) {
	unset($all_languages[$cms_language->getCode()]);
	array_unshift($all_languages, $userlanguage);
}
// Current category object to manipulate
if ($catId) {
	$item = new CMS_moduleCategory($catId);
	$item->setAttribute('language', $cms_language);
	$item->setAttribute('moduleCodename', $codename);
	$parentCategory = $item->getParent();
} else {
	// Parent category
	$item = new CMS_moduleCategory();
	$item->setAttribute('language', $cms_language);
	$item->setAttribute('moduleCodename', $codename);
	if ($fatherId) {
		$parentCategory = CMS_moduleCategories_catalog::getById($fatherId);
		$parentCategory->setAttribute('language', $cms_language);
	}
}

if (!function_exists("build_category_tree_options")) {
	/** 
	  * Recursive function to build the categories tree.
	  *
	  * @param CMS_moduleCategory $category
	  * @param integer $count, to determine category in-tree depth
	  * @return string HTML formated
	  */
	function build_category_tree_options($category, $count) {
		global $codename, $cms_language, $parentCategory, $cms_module, $cms_user, $catId;
		//if category is not itself (to avoid infinite loop in lineage)
		$a = array();
		if ($category->getID() != $catId) {
			$category->setAttribute('language', $cms_language);
			$label = htmlspecialchars($category->getLabel());
			if ($count >= 1) {
				$label = str_repeat(' ::', $count).' '.$label;
			}
			$a[] = array($category->getID(), $label);
			$count++;
			$attrs = array(
				"module"			=> $codename,
				"language"			=> $cms_language,
				"level"				=> $category->getID(),
				"root"				=> -1,
				"cms_user"			=> $cms_user,
				"clearanceLevel"	=> CLEARANCE_MODULE_MANAGE,
				"strict"			=> true,
			);
			$siblings = CMS_module::getModuleCategories($attrs);
			if (sizeof($siblings)) {
				foreach ($siblings as $aSibling) {
					$aSibling->setAttribute('language', $cms_language);
					$a = array_merge($a, build_category_tree_options($aSibling, $count));
				}
			}
		}
		return $a;
	}
}

$items = array();

if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	// Select parent category
	$attrs = array(
		"module"			=> $codename,
		"language"			=> $cms_language,
		"level"				=> 0,
		"root"				=> -1,
		"cms_user"			=> $cms_user,
		"clearanceLevel"	=> CLEARANCE_MODULE_MANAGE,
		"strict" 			=> true,
	);
	$root_categories = CMS_module::getModuleCategories($attrs);
} else {
	$parentID = $item->getAttribute('parentID');
	if ((sensitiveIO::isPositiveInteger($parentID) && $cms_user->hasModuleCategoryClearance($parentID, CLEARANCE_MODULE_MANAGE, $codename)) || !$catId) {
		$root_categories = $cms_user->getRootModuleCategoriesManagable($codename, true);
	}
}

$selectContent = array();
if (is_array($root_categories) && sizeof($root_categories) > 0) {
	foreach ($root_categories as $aRoot) {
		// Show all sub categories
		$selectContent = array_merge($selectContent, build_category_tree_options($aRoot, 0));
	}
}
if ($selectContent) {
	$items[] = array(
		'xtype'			=> 'atmCombo',
		'fieldLabel'	=> $cms_language->getMessage(MESSAGE_PAGE_FIELD_PARENT_CATEGORY),
		'name'			=> 'parentId',
		'hiddenName'	=> 'parentId',
		'forceSelection'=> true,
		'mode'			=> 'local',
		'valueField'	=> 'id',
		'displayField'	=> 'name',
		'triggerAction'	=> 'all',
		'allowBlank'	=> true,
		'selectOnFocus'	=> true,
		'editable'		=> false,
		'value'			=> (isset($parentCategory)) ? $parentCategory->getId() : '',
		'store'			=> array(
			'xtype'			=> 'arraystore',
			'fields' 		=> array('id', 'name'),
			'data' 			=> $selectContent
		)
	);
}

// Build label list of all languages avalaibles
$count = 0;
foreach ($all_languages as $aLanguage) {
	if ($item->getFilePath($aLanguage, false, PATH_RELATIVETO_WEBROOT, true) && file_exists($item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM))) {
		$file = new CMS_file($item->getFilePath($aLanguage, true, PATH_RELATIVETO_FILESYSTEM));
		$fileDatas = array(
			'filename'		=> $file->getName(false),
			'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
			'filesize'		=> $file->getFileSize(),
			'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
			'extension'		=> $file->getExtension(),
		);
	} else {
		$fileDatas = array(
			'filename'		=> '',
			'filepath'		=> '',
			'filesize'		=> '',
			'fileicon'		=> '',
			'extension'		=> '',
		);
	}
	$fileDatas['module'] 		= $codename;
	$fileDatas['visualisation'] = RESOURCE_DATA_LOCATION_PUBLIC;
	
	$maxFileSize = CMS_file::getMaxUploadFileSize('K');
	$mandatory = ($aLanguage->getCode() == $cms_module->getDefaultLanguageCodename()) ? '<span class="atm-red">*</span> ' : '' ;
	$items[] = array(
		'title' 		=>	$aLanguage->getLabel(),
		'xtype'			=>	'fieldset',
		'autoHeight'	=>	true,
		'defaultType'	=>	'textfield',
		'defaults'		=> 	array(
			'anchor'		=>	'100%',
			'allowBlank'	=>	true
		),
		'items'			=>	array(
			array(
				'fieldLabel'		=> $mandatory.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL),
				'xtype'				=> 'textfield',
				'allowBlank'		=> !$mandatory,
				'name'				=> 'label_'.$aLanguage->getCode(),
				'value'				=> $item->getLabel($aLanguage, false)
			),array(
				'fieldLabel'		=> $cms_language->getMessage(MESSAGE_PAGE_FIELD_DESC),
				'xtype'				=> 'fckeditor',
				'name'				=> 'description_'.$aLanguage->getCode(),
				'value'				=> (string) $item->getDescription($aLanguage, false),
				'height'			=> 200,
				'editor'			=> array(
					'ToolbarSet' 		=> 'BasicLink',
					'DefaultLanguage'	=> $cms_language
				)
			),array(
				'fieldLabel'		=> $cms_language->getMessage(MESSAGE_PAGE_FIELD_FILE),
				'xtype'				=> 'atmFileUploadField',
				'name'				=> 'file_'.$aLanguage->getCode(),
				'uploadCfg'			=> array(
					'file_size_limit'			=> $maxFileSize,
					'file_types_description'	=> $cms_language->getJSMessage(MESSAGE_ALL_FILE).' ...',
					'file_types'				=> '*.*'
				),
				'fileinfos'			=> $fileDatas,
			)
		)
	);
	
	
	//Thumbnail after first language
	if (!$count) {
		if ($item->getIconPath(false, PATH_RELATIVETO_WEBROOT, true) && file_exists($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, true))) {
			$file = new CMS_file($item->getIconPath(true, PATH_RELATIVETO_FILESYSTEM, true));
			$imageDatas = array(
				'filename'		=> $file->getName(false),
				'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
				'filesize'		=> $file->getFileSize(),
				'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
				'extension'		=> $file->getExtension(),
			);
		} else {
			$imageDatas = array(
				'filename'		=> '',
				'filepath'		=> '',
				'filesize'		=> '',
				'fileicon'		=> '',
				'extension'		=> '',
			);
		}
		$imageDatas['module']		= $codename;
		$imageDatas['visualisation'] = RESOURCE_DATA_LOCATION_PUBLIC;
		$items[] = array(
			'xtype'			=> 'atmImageUploadField',
			'fieldLabel'	=> $cms_language->getMessage(MESSAGE_PAGE_FIELD_THUMBNAIL),
			'name'			=> 'icon',
			'uploadCfg'		=> array(
				'file_size_limit'					=> $maxFileSize,
				'file_types'						=> '*.jpg;*.png;*.gif',
				'file_types_description'			=> $cms_language->getMessage(MESSAGE_IMAGE).' ...'
			),
			'fileinfos'	=> $imageDatas
		);
	}
	$count++;
}

$items = sensitiveIO::jsonEncode($items);

$jscontent = <<<END
	var window = Ext.getCmp('{$winId}');
	//set window title
	window.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_TITLE)}');
	//set help button on top of page
	window.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 window.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_MESSAGE)}',
		dismissDelay:	0
	});
	
	//create center panel
	var center = new Ext.Panel({
		region:				'center',
		border:				false,
		autoScroll:			true,
		buttonAlign:		'center',
		items: [{
			id:				'{$winId}-category',
			layout: 		'form',
			bodyStyle: 		'padding:10px',
			border:			false,
			autoWidth:		true,
			autoHeight:		true,
			xtype:			'atmForm',
			url:			'modules-categories-controler.php',
			labelAlign:		'right',
			labelWidth:		130,
			defaults: {
				xtype:			'textfield',
				anchor:			'97%',
				allowBlank:		true
			},
			items:{$items}
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			iconCls:		'atm-pic-validate',
			xtype:			'button',
			name:			'submitAdmin',
			handler:		function() {
				var form = Ext.getCmp('{$winId}-category').getForm();
				if (form.isValid()) {
					form.submit({
						params:{
							action:		'save',
							module:		'{$codename}',
							fatherId:	'{$fatherId}',
							category:	window.categoryId
						},
						success:function(form, action){
							//extract updated json datas from response
							var jsonResponse = {};
							if (action.response.responseXML && action.response.responseXML.getElementsByTagName('jsoncontent').length) {
								try{
									jsonResponse = Ext.decode(action.response.responseXML.getElementsByTagName('jsoncontent').item(0).firstChild.nodeValue);
								} catch(e) {
									jsonResponse = {};
									pr(e, 'error');
									Automne.server.failureResponse(action.response, action.options, e, 'json');
								}
							}
							if (jsonResponse.id) {
								window.categoryId = jsonResponse.id;
							}
						},
						scope:this
					});
				} else {
					Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_FORM_INCORRECT)}', '', window);
				}
			},
			scope:			this
		}]
	});
	window.add(center);
	setTimeout(function(){
		//redo windows layout
		window.doLayout();
		if (Ext.isIE7) {
			center.syncSize();
		}
	}, 100);
END;
$view->addJavascript($jscontent);
$view->show();
?>