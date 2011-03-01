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
// $Id: item.php,v 1.9 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : Load cms_i18n item interface
  * Used accross an Ajax request. Render a cms_i18n item for edition
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_LANGUAGE_MANAGEMENT", 446);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_ALLOWED", 719);
define("MESSAGE_PAGE_AVAILABLE", 720);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_LANGUAGE", 53);
define("MESSAGE_PAGE_DATE_FORMAT", 1692);
define("MESSAGE_PAGE_CREATE_UPDATE", 1695);
define("MESSAGE_PAGE_SELECT_MODULES", 1697);
define("MESSAGE_PAGE_EXCLUDED_MODULES", 1693);
define("MESSAGE_PAGE_EXCLUDED", 1698);
define("MESSAGE_PAGE_LANGUE_AVAILABLE_FOR_ADMIN", 1699);
define("MESSAGE_TOOLBAR_HELP_DESC", 1700);
define("MESSAGE_ERROR_SAVING", 1701);
define("MESSAGE_ERROR_INCORRECT_VALUES", 1702);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$code = sensitiveIO::request('code');

if (!$winId) {
	CMS_grandFather::raiseError('Unknown window Id ...');
	$view->show();
}
//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on language management');
	$view->show();
}

//load item messages
if ($code) {
	$language = CMS_languagesCatalog::getByCode($code);
	if (!$language || $language->hasError()) {
		CMS_grandFather::raiseError('Unknown language code : '.$code);
		$view->show();
	}
} else {
	$language = new CMS_language();
}

$winLabel = sensitiveIO::sanitizeJSString($cms_language->getMessage(MESSAGE_PAGE_LANGUAGE_MANAGEMENT)." :: ".$cms_language->getMessage(MESSAGE_PAGE_CREATE_UPDATE));

$languagesCodes = CMS_languagesCatalog::getAllLanguagesCodes();
$comboLanguages = array(
	array('format' => '','label' => '-',),
);
foreach ($languagesCodes as $languageCode => $label) {
	$comboLanguages[] = array('code' => $languageCode, 'label' => $languageCode.' : '.$label);
}
$comboLanguages = sensitiveIO::jsonEncode($comboLanguages);

$datesFormat = array(
	array('format' => '','label' => '-',),
	array('format' => 'd/m/Y','label' => date('d/m/Y').' (d/m/Y)',),
	array('format' => 'm/d/Y','label' => date('m/d/Y').' (m/d/Y)',),
	array('format' => 'Y/m/d','label' => date('Y/m/d').' (Y/m/d)',),
);
$datesFormat = sensitiveIO::jsonEncode($datesFormat);

$modules = CMS_modulesCatalog::getAll();
$modulesDenied = $language->getModulesDenied();
$availableModules = $excludedModules = array();
foreach ($modules as $codename => $module) {
	if (in_array($codename, $modulesDenied)) {
		$excludedModules[] = array($codename, $module->getLabel($cms_language));
	} else {
		$availableModules[] = array($codename, $module->getLabel($cms_language));
	}
}
$availableModules = sensitiveIO::jsonEncode($availableModules);
$excludedModules = sensitiveIO::jsonEncode($excludedModules);

$selectLanguageDisabled = $language->getCode() ? 'true' : 'false';
$isAvailableForBackoffice = $language->isAvailableForBackoffice() ? 'true' : 'false';

$itemFields = "{
	xtype:				'combo',
	name:				'selectedCode',
	hiddenName:		 	'selectedCode',
	forceSelection:		true,
	fieldLabel:			'<span class=\"atm-red\">*</span> {$cms_language->getJSMessage(MESSAGE_PAGE_LANGUAGE)}',
	mode:				'local',
	triggerAction:		'all',
	valueField:			'code',
	displayField:		'label',
	value:				'{$language->getCode()}',
	anchor:				'-20px',
	store:				new Ext.data.JsonStore({
		fields:				['code', 'label'],
		data:				{$comboLanguages}
	}),
	allowBlank:		 	false,
	selectOnFocus:		true,
	editable:			true,
	typeAhead:			true,
	validateOnBlur:		false,
	disabled:			{$selectLanguageDisabled}
},{
	xtype:				'atmCombo',
	name:				'dateformat',
	hiddenName:		 	'dateformat',
	forceSelection:		true,
	fieldLabel:			'<span class=\"atm-red\">*</span> {$cms_language->getJSMessage(MESSAGE_PAGE_DATE_FORMAT)}',
	mode:				'local',
	triggerAction:		'all',
	valueField:			'format',
	displayField:		'label',
	value:				'{$language->getDateFormat()}',
	anchor:				'-20px',
	store:				new Ext.data.JsonStore({
		fields:				['format', 'label'],
		data:				{$datesFormat}
	}),
	allowBlank:		 	false,
	selectOnFocus:		true,
	editable:			false,
	validateOnBlur:		false
},{
	xtype:			'itemselector',
	name:			'modulesDenied',
	fieldLabel:		'<span class=\"atm-help\" ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_SELECT_MODULES)}\">{$cms_language->getJSMessage(MESSAGE_PAGE_EXCLUDED_MODULES)}</span>',
	dataFields:		['code', 'label'],
	toData:			{$excludedModules},
	msWidth:		250,
	msHeight:		130,
	height:			140,
	valueField:		'code',
	displayField:	'label',
	toLegend:		'{$cms_language->getJSMessage(MESSAGE_PAGE_EXCLUDED)}',
	fromLegend:		'{$cms_language->getJsMessage(MESSAGE_PAGE_AVAILABLE)}',
	fromData:		{$availableModules}
},{
	xtype: 		'checkbox', 
	boxLabel: 	'{$cms_language->getJSMessage(MESSAGE_PAGE_LANGUE_AVAILABLE_FOR_ADMIN)}', 
	inputValue:	'1',
	checked:	{$isAvailableForBackoffice},
	name: 		'admin'
},";


//remove last comma
$itemFields = io::substr($itemFields, 0, -1);

$itemsControlerURL = PATH_ADMIN_WR.'/languages-controler.php';

$jscontent = <<<END
	var window = Ext.getCmp('{$winId}');
	//set window title
	window.setTitle('{$winLabel}');
	//set help button on top of page
	window.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 window.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJSMessage(MESSAGE_TOOLBAR_HELP_DESC)}',
		dismissDelay:	0
	});
	window.code = '{$code}';
	window.saved = false;
	
	var submitItem = function (action) {
		var form = Ext.getCmp('{$winId}-form').getForm();
		var values = form.getValues();
		if (!values.selectedCode || !values.dateformat) {
			Automne.message.show('{$cms_language->getJSMessage(MESSAGE_ERROR_INCORRECT_VALUES)}', '', window);
		} else {
			form.submit({
				params:{
					code:		window.code,
					action:		action
				},
				success:function(form, action){
					if (!action.result || action.result.success == false) {
						Automne.message.show('{$cms_language->getJSMessage(MESSAGE_ERROR_SAVING)}', '', window);
					} else {
						window.saved = true;
					}
				},
				failure:function(form, action){
					Automne.message.show('{$cms_language->getJSMessage(MESSAGE_ERROR_SAVING)}', '', window);
				},
				scope:this
			});
		}
	}
	
	//create center panel
	var center = new Ext.Panel({
		region:				'center',
		border:				false,
		autoScroll:			true,
		buttonAlign:		'center',
		items: [{
			id:				'{$winId}-form',
			layout: 		'form',
			bodyStyle: 		'padding:10px',
			border:			false,
			autoWidth:		true,
			autoHeight:		true,
			xtype:			'atmForm',
			url:			'{$itemsControlerURL}',
			labelAlign:		'right',
			defaults: {
				xtype:			'textfield',
				anchor:			'97%',
				allowBlank:		true
			},
			items:[{$itemFields}]
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			iconCls:		'atm-pic-validate',
			xtype:			'button',
			name:			'submitAdmin',
			handler:		submitItem.createDelegate(this, ['save']),
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