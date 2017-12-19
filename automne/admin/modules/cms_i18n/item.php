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
  * @subpackage cms_i18n
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

if (!defined('MOD_POLYMOD_CODENAME')) {
	define('MOD_POLYMOD_CODENAME', 'polymod');
}
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_TITLE", 2);
define("MESSAGE_PAGE_PUBLISH", 1605);
define("MESSAGE_PAGE_SAVE_DESC", 544);
define("MESSAGE_TOOLBAR_HELP_DESC", 527);
define("MESSAGE_PAGE_SAVE_ERROR", 528);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 522);
define("MESSAGE_PAGE_INFO_FIELD_CODENAME_VTYPE", 1677);

//cms_i18n messages
define("MESSAGE_PAGE_ERROR_MESSAGE", 23);
define("MESSAGE_PAGE_MESSAGE_CREATE_UPDATE", 24);
define("MESSAGE_PAGE_KEY_FORMAT_DESC", 25);
define("MESSAGE_PAGE_ACTION_SAVE", 26);
define("MESSAGE_PAGE_KEY", 30);


//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$codename = sensitiveIO::request('module');
$itemId = sensitiveIO::request('item', 'sensitiveIO::isPositiveInteger');
$format = sensitiveIO::request('format', array('text', 'html'), 'text');

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
if (!$winId) {
	CMS_grandFather::raiseError('Unknown window Id ...');
	$view->show();
}
//load module
if ($codename != 'cms_i18n_vars' && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($codename)));
	$view->show();
}

//load item messages
$languages = CMS_languagesCatalog::getAllLanguages(($codename == 'cms_i18n_vars' ? MOD_CMS_I18N_CODENAME : $codename));
$messages = array();
if ($itemId) {
	$resultCount = 0;
	$messages = CMS_languagesCatalog::searchMessages($codename, '', array(), array('ids' => array($itemId)), 'asc', 0, 1, $resultCount);
	if ($resultCount != 1 || !isset($messages[$itemId])) {
		CMS_grandFather::raiseError('Unknown message '.$itemId.' for codename '.$codename);
		$view->setActionMessage($cms_language->getMessage(MESSAGE_PAGE_ERROR_MESSAGE, array($itemId, $codename), MOD_CMS_I18N_CODENAME));
		$view->show();
	}
	$messages = $messages[$itemId];
}

$winLabel = sensitiveIO::sanitizeJSString($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($codename))." :: ".$cms_language->getMessage(MESSAGE_PAGE_MESSAGE_CREATE_UPDATE, false, MOD_CMS_I18N_CODENAME));

$itemFields = '';
if ($codename == 'cms_i18n_vars') {
	$itemFields .= '{
			fieldLabel:		\'<span ext:qtip="{'.$cms_language->getJSMessage(MESSAGE_PAGE_KEY_FORMAT_DESC, false, MOD_CMS_I18N_CODENAME).'" class="atm-help"><span class="atm-red">*</span> '.$cms_language->getJSMessage(MESSAGE_PAGE_KEY, false, MOD_CMS_I18N_CODENAME).'</span>\',
			xtype:			\'textfield\',
			allowBlank:		false,
			name:			\'messages[key]\',
			value:			\''.io::sanitizeJSString((isset($messages['key']) ? $messages['key'] : '')).'\',
			vtype:			\'i18n_key\',
			vtypeText:		\''.$cms_language->getJSMessage(MESSAGE_PAGE_KEY_FORMAT_DESC, false, MOD_CMS_I18N_CODENAME).'\'
		},';
}
if ($format == 'html') {
	foreach ($languages as $language) {
		$itemFields .= '{
			fieldLabel:		\''.io::sanitizeJSString($language->getLabel()).'\',
			xtype:			\'fckeditor\',
			name:			\'messages['.$language->getCode().']\',
			value:			\''.io::sanitizeJSString((isset($messages[$language->getCode()]) ? $messages[$language->getCode()] : '')).'\',
			height:			300,
			editor:			{
								ToolbarSet: 		\''.MOD_CMS_I18N_CODENAME.'\',
								DefaultLanguage:	\''.$cms_language->getCode().'\',
								Config:{
									EditorAreaStyles:	\''.PATH_ADMIN_WR.'/css/main.css\', 
									BodyClass: 			\'atm-help-panel\',
									StylesXmlPath: 		\''.PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/editorstyles.xml\'
								}
							}
			},';
	}
} else {
	foreach ($languages as $language) {
		$itemFields .= '{
			fieldLabel:		\''.io::sanitizeJSString($language->getLabel()).'\',
			xtype:			\'textarea\',
			name:			\'messages['.$language->getCode().']\',
			value:			\''.io::sanitizeJSString((isset($messages[$language->getCode()]) ? $messages[$language->getCode()] : '')).'\',
			height:			200
		},';
	}
}

//remove last comma
$itemFields = io::substr($itemFields, 0, -1);

$itemControler = PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/items-controler.php';

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
		html:			 '{$cms_language->getJSMessage(MESSAGE_TOOLBAR_HELP_DESC, array(""), MOD_POLYMOD_CODENAME)}',
		dismissDelay:	0
	});
	window.itemId = '{$itemId}';
	window.saved = false;
	//vtype codename
	Ext.apply(Ext.form.VTypes, {
	    i18n_key:  function(v) {
	        return /^[#a-zA-Z0-9_-]*$/.test(v);
	    },
	    i18n_keyText: '{$cms_language->getJSMessage(MESSAGE_PAGE_KEY_FORMAT_DESC, false, MOD_CMS_I18N_CODENAME)}',
	    i18n_keyMask: /[#a-zA-Z0-9_-]/i
	});
	
	var submitItem = function (action) {
		var form = Ext.getCmp('{$winId}-form').getForm();
		if (form.isValid()) {
			form.submit({
				params:{
					action:		action,
					module:		'{$codename}',
					item:		window.itemId
				},
				success:function(form, action){
					if (!action.result || action.result.success == false) {
						Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE_ERROR, false, MOD_POLYMOD_CODENAME)}', '', window);
					} else {
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
							window.itemId = jsonResponse.id;
						}
						window.saved = true;
					}
				},
				scope:this
			});
		} else {
			Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_FORM_VALUES, false, MOD_POLYMOD_CODENAME)}', '', window);
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
			url:			'{$itemControler}',
			labelAlign:		'right',
			defaults: {
				xtype:			'textfield',
				anchor:			'97%',
				allowBlank:		true
			},
			items:[{$itemFields}]
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ACTION_SAVE, false, MOD_CMS_I18N_CODENAME)}',
			iconCls:		'atm-pic-validate',
			xtype:			'button',
			name:			'submitAdmin',
			handler:		submitItem.createDelegate(this, ['update']),
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