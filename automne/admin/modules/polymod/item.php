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
  * PHP page : Load polymod item interface
  * Used accross an Ajax request. Render a polymod item for edition
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_FIELD_DATE_COMMENT", 148);
define("MESSAGE_PAGE_FIELD_PUBDATE_BEG", 134);
define("MESSAGE_PAGE_FIELD_PUBDATE_END", 135);
define("MESSAGE_PAGE_PUBLISH", 1605);
define("MESSAGE_PAGE_SUBMIT_TO_VALID", 1422);

//Message of polymod module
define("MESSAGE_PAGE_TITLE", 2);
define("MESSAGE_PAGE_SUBTITLE_WEBSITE_PUBS", 57);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 522);
define("MESSAGE_PAGE_ELEMENT_LOCKED", 525);
define("MESSAGE_PAGE_ELEMENT_EDIT_RIGHTS_ERROR", 526);
define("MESSAGE_TOOLBAR_HELP_DESC", 527);
define("MESSAGE_PAGE_SAVE_ERROR", 528);
define("MESSAGE_PAGE_SAVE_AND_VALID_DESC", 542);
define("MESSAGE_PAGE_SAVE_PRIMARY_DESC", 543);
define("MESSAGE_PAGE_SAVE_DESC", 544);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$objectId = sensitiveIO::request('type', 'sensitiveIO::isPositiveInteger');
$itemId = sensitiveIO::request('item', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());

//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename($codename);

//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('Error, user has no rights on module : '.$codename);
	$view->show();
}

//load object
if ($objectId) {
	$object = CMS_poly_object_catalog::getObjectDefinition($objectId);
	$objectLabel = sensitiveIO::sanitizeJSString($object->getLabel($cms_language));
}
if (!isset($object) || $object->hasError()) {
	CMS_grandFather::raiseError('Error, objectId does not exists or has an error : '.$objectId);
	$view->show();
}
//load item if any
if ($itemId) {
	$item = new CMS_poly_object($objectId, $itemId);
	if (!$item || $item->hasError()) {
		CMS_grandFather::raiseError('Error, unknown item Id : '.$itemId);
		$view->show();
	}
	$itemLabel = sensitiveIO::sanitizeJSString($item->getLabel());
	if ($object->isPrimaryResource()) {
		//put a lock on the resource or warn user if item is already locked
		if ($lock = $item->getLock()) {
			$lockUser = CMS_profile_usersCatalog::getById($lock);
			$lockDate = $item->getLockDate();
			$date = $lockDate ? $lockDate->getLocalizedDate($cms_language->getDateFormat().' @ H:i:s') : '';
			$name = sensitiveIO::sanitizeJSString($lockUser->getFullName());
			CMS_grandFather::raiseError('Error, item '.$itemId.' is locked by '.$lockUser->getFullName());
			$jscontent = "
			var window = Ext.getCmp('{$winId}');
			if (window) {
				window.close();
			}
			Automne.message.popup({
				msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ELEMENT_LOCKED, array($itemLabel, $name, $date), MOD_POLYMOD_CODENAME)}',
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});";
			$view->addJavascript($jscontent);
			$view->show();
		} else {
			$item->lock($cms_user);
		}
	}
	//check user rights on item
	if (!$item->userHasClearance($cms_user, CLEARANCE_MODULE_EDIT)) {
		CMS_grandFather::raiseError('Error, user has no rights item '.$itemId);
		$jscontent = "
		var window = Ext.getCmp('{$winId}');
		if (window) {
			window.close();
		}
		Automne.message.popup({
			msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ELEMENT_EDIT_RIGHTS_ERROR, array($itemLabel), MOD_POLYMOD_CODENAME)}',
			buttons: 			Ext.MessageBox.OK,
			closable: 			false,
			icon: 				Ext.MessageBox.ERROR
		});";
		$view->addJavascript($jscontent);
		$view->show();
	}
} else { //instanciate clean object (creation)
	$item = new CMS_poly_object($object->getID(), '');
}

$winLabel = sensitiveIO::sanitizeJSString($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, array($object->getLabel($cms_language)), MOD_POLYMOD_CODENAME));

$fieldsObjects = $item->getFieldsObjects();
$itemFields = '';
foreach ($fieldsObjects as $fieldID => $aFieldObject) {
	$fieldAdmin = $item->getHTMLAdmin($fieldID, $cms_language,'');
	
	if (is_array($fieldAdmin)) {
		$itemFields .= sensitiveIO::jsonEncode($fieldAdmin).',';
	}
}
//do some search and replace to allow use of js functions in returned code
$itemFields = str_replace('"scope":"this"', '"scope":this', $itemFields);
function replaceCallBack($parts) {
	return 'function('.str_replace(array('\"','\/'), array('"', '/'), $parts[1]).'}';
}
$itemFields = preg_replace_callback('#"function\((.*)}"#U', 'replaceCallBack', $itemFields);

//Append pub dates if object is a primary resource
$saveAndValidate = '';
$saveIconCls = $saveTooltip = '';
if ($object->isPrimaryResource()) {
	if (!$item->getID()) {
		$dt = new CMS_date();
		$dt->setDebug(false);
		$dt->setNow();
		$pubStart = $dt->getLocalizedDate($cms_language->getDateFormat());
	} else {
		$pubStart = $item->getPublicationDateStart(false)->getLocalizedDate($cms_language->getDateFormat());
	}
	$pubEnd = $item->getPublicationDateEnd(false)->getLocalizedDate($cms_language->getDateFormat());
	$dateMask = $cms_language->getDateFormatMask();
	$itemFields .= "{
		title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SUBTITLE_WEBSITE_PUBS, false, MOD_POLYMOD_CODENAME)}',
		xtype:			'fieldset',
		autoHeight:		true,
		defaultType:	'datefield',
		labelWidth:		140,
		defaults:		{
			width:			100,
			anchor:			'',
			format:			'{$cms_language->getDateFormat()}'
		},
		items:			[{
			fieldLabel:	'<span ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($dateMask))}\" class=\"atm-help\"><span class=\"atm-red\">*</span> {$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)}</span>',
			name:		'pubStart',
			allowBlank:	false,
			value:		'{$pubStart}'
		},{
			fieldLabel:	'<span ext:qtip=\"{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($dateMask))}\" class=\"atm-help\">{$cms_language->getJSMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)}</span>',
			name:		'pubEnd',
			allowBlank:	true,
			value:		'{$pubEnd}'
		}]
	},";
	if ($cms_user->hasValidationClearance($codename)) {
		$saveAndValidate = ",{
			id:				'{$winId}-save-validate',
			xtype:			'button',
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_PUBLISH)}',
			tooltip:		'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE_AND_VALID_DESC, false, MOD_POLYMOD_CODENAME)}',
			iconCls:		'atm-pic-validate',
			name:			'submitAndValidAdmin',
			handler:		submitItem.createDelegate(this, ['save-validate']),
			scope:			this
		}";
		$saveIconCls = 'atm-pic-draft-validation';
		$saveTooltip = $cms_language->getJSMessage(MESSAGE_PAGE_SAVE_PRIMARY_DESC, false, MOD_POLYMOD_CODENAME);
	}
	$saveLabel = $cms_language->getJSMessage(MESSAGE_PAGE_SUBMIT_TO_VALID);
} else {
	$saveLabel = $cms_language->getJSMessage(MESSAGE_PAGE_PUBLISH);
	$saveIconCls = 'atm-pic-validate';
	$saveTooltip = $cms_language->getJSMessage(MESSAGE_PAGE_SAVE_DESC, false, MOD_POLYMOD_CODENAME);
}

//remove last comma
$itemFields = io::substr($itemFields, 0, -1);

$itemControler = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/items-controler.php';

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
		html:			 '{$cms_language->getJSMessage(MESSAGE_TOOLBAR_HELP_DESC, array($objectLabel), MOD_POLYMOD_CODENAME)}',
		dismissDelay:	0
	});
	window.objectId = '{$itemId}';
	
	var submitItem = function (action) {
		var form = Ext.getCmp('{$winId}-form').getForm();
		if (form.isValid()) {
			//disable button
			var saveButton = Ext.getCmp('{$winId}-save');
			if (saveButton) {
				saveButton.disable();
			}
			var publishButton = Ext.getCmp('{$winId}-save-validate');
			if (publishButton) {
				publishButton.disable();
			}
			form.submit({
				params:{
					action:		action,
					module:		'{$codename}',
					type:		'{$objectId}',
					item:		window.objectId
				},
				success:function(form, action){
					//enable button
					var saveButton = Ext.getCmp('{$winId}-save');
					if (saveButton) {
						saveButton.enable();
					}
					var publishButton = Ext.getCmp('{$winId}-save-validate');
					if (publishButton) {
						publishButton.enable();
					}
					if (!action.result || action.result.success == false) {
						Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE_ERROR, false, MOD_POLYMOD_CODENAME)}', '', window);
					}
					//update fields values if any is returned in response
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
					window.objectId = jsonResponse.id;
					if (jsonResponse.datas) {
						for(var i in jsonResponse.datas) {
							if (i != 'success' && form.findField(i)) {
								form.findField(i).setValue(jsonResponse.datas[i]);
							}
						}
					}
				},
				failure:function(form, action){
					//enable button
					var saveButton = Ext.getCmp('{$winId}-save');
					if (saveButton) {
						saveButton.enable();
					}
					var publishButton = Ext.getCmp('{$winId}-save-validate');
					if (publishButton) {
						publishButton.enable();
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
				allowBlank:		false
			},
			items:[{$itemFields}]
		}],
		buttons:[{
			id:				'{$winId}-save',
			text:			'{$saveLabel}',
			tooltip:		'{$saveTooltip}',
			iconCls:		'{$saveIconCls}',
			xtype:			'button',
			name:			'submitAdmin',
			handler:		submitItem.createDelegate(this, ['save']),
			scope:			this
		}{$saveAndValidate}]
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