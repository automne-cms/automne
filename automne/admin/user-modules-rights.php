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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: user-modules-rights.php,v 1.5 2010/03/08 16:41:22 sebastien Exp $

/**
  * PHP page : Load page rights detail for given user.
  * Used accross an Ajax request. Render user informations.
  * 
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);
define("MESSAGE_PAGE_USER_ADMINISTRATOR_MODULE", 507);
define("MESSAGE_PAGE_NO_RIGHTS_MODIFY", 508);
define("MESSAGE_PAGE_GROUP_ADMINISTRATOR_MODULE", 509);
define("MESSAGE_PAGE_AUTH_VALIDATION_USER_ADMINISTRATOR", 510);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_VALIDATION_RIGHTS", 511);
define("MESSAGE_PAGE_NO_GROUP_ON_TEMPLATES", 512);
define("MESSAGE_PAGE_NO_GROUP_ON_ROWS", 513);
define("MESSAGE_PAGE_TEMPLATES_RIGHTS", 514);
define("MESSAGE_PAGE_TEMPLATES_RIGHTS_INFO", 515);
define("MESSAGE_PAGE_ROWS_TEMPLATE_RIGHTS", 516);
define("MESSAGE_PAGE_ROWS_TEMPLATE_RIGHTS_INFO", 517);
define("MESSAGE_PAGE_ROWS_GENERAL_MODULE_ACCESS", 518);
define("MESSAGE_PAGE_ROWS_CONTENT_ACCESS", 519);


$winId = sensitiveIO::request('winId', '', 'profileModulePanel');
$userId = sensitiveIO::request('userId', 'sensitiveIO::isPositiveInteger');
$groupId = sensitiveIO::request('groupId', 'sensitiveIO::isPositiveInteger');
$fatherId = sensitiveIO::request('fatherId');
$moduleCodename = sensitiveIO::request('module', '', MOD_STANDARD_CODENAME);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//check user rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has no users management rights ...');
	$view->show();
}

//load profile if any
$isUser = false;
if ($userId) {
	$profile = CMS_profile_usersCatalog::getByID($userId);
	$isUser = true;
	$controler = 'users-controler.php';
	$userId = $profile->getUserId();
} elseif($groupId) {
	$profile = CMS_profile_usersGroupsCatalog::getByID($groupId);
	$controler = 'groups-controler.php';
	$groupId = $profile->getGroupId();
}
$profileId = $profile->getId();
if (!isset($profile) || $profile->hasError()) {
	CMS_grandFather::raiseError('Unknown profile for given Id : '.$profileId);
	$view->show();
}

//get profile clearances for module
$moduleClearancesStack = $profile->getModuleClearances();
$moduleClearance = $moduleClearancesStack->getElementValueFromKey($moduleCodename);
if (!$moduleClearance) {
	$moduleClearance = CLEARANCE_MODULE_NONE;
}
if ($moduleCodename == MOD_STANDARD_CODENAME && $moduleClearance == CLEARANCE_MODULE_NONE) {
	$moduleClearance = CLEARANCE_PAGE_VIEW; //users has always this right on standard module
}

//if user is admin, then it has all rights on module
if ($isUser) {
	if ($profile->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
		$disableFields = true;
		$moduleClearance = CLEARANCE_MODULE_EDIT;
		$disableFieldsDesc = "{
			cls:	'atm-text-alert',
			html:	'{$cms_language->getJSMessage(MESSAGE_PAGE_USER_ADMINISTRATOR_MODULE)}'
		},";
	} else {
		//if user belongs to groups, all fields are disabled
		$disableFields = sizeof(CMS_profile_usersGroupsCatalog::getGroupsOfUser($profile, true)) ? true : false;
		$disableFieldsDesc = '';
		if ($disableFields) {
			$disableFieldsDesc = "{
				cls:	'atm-text-alert',
				html:	'{$cms_language->getJSMessage(MESSAGE_PAGE_NO_RIGHTS_MODIFY)}'
			},";
		}
	}
} else {
	$disableFields = false;
	$disableFieldsDesc = '';
	if ($profile->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
		$disableFields = true;
		$moduleClearance = CLEARANCE_MODULE_EDIT;
		$disableFieldsDesc = "{
			cls:	'atm-text-alert',
			html:	'{$cms_language->getJSMessage(MESSAGE_PAGE_GROUP_ADMINISTRATOR_MODULE)}'
		},";
	}
}

//Module clearances
$allclearances = CMS_profile::getAllModuleClearances();
$moduleAccess = '';
foreach ($allclearances as $clearance => $messages) {
	$standardDisableNone = false;
	if ($moduleCodename == MOD_STANDARD_CODENAME && $clearance == CLEARANCE_PAGE_NONE) {
		$standardDisableNone = true;
	}
	$moduleAccess .= "{
		boxLabel:		'<span ext:qtip=\"".$cms_language->getJSMessage($messages['description'])."\" class=\"atm-help\">".$cms_language->getJSMessage($messages['label'])."</span>',
		name:			'{$moduleCodename}-access-{$profileId}',
		".($clearance == CLEARANCE_MODULE_NONE ? "id:'{$moduleCodename}-access-{$profileId}'," : '')."
		inputValue:		".$clearance.",
		checked:		".($moduleClearance == $clearance ? 'true' : 'false').",
		disabled:		".(($standardDisableNone || $disableFields || !$cms_user->hasModuleClearance($moduleCodename, $clearance)) ? 'true' : 'false')."
	},";
}
//validations clearance
$moduleAccess .= "{
	boxLabel:		'<span ext:qtip=\"".$cms_language->getJSMessage(MESSAGE_PAGE_AUTH_VALIDATION_USER_ADMINISTRATOR)."\" class=\"atm-help\">".$cms_language->getJSMessage(MESSAGE_PAGE_VALIDATION_RIGHTS)."</span>',
	id:				'{$moduleCodename}-validate-{$profileId}',
	inputValue:		'1',
	xtype:			'checkbox',
	checked:		".($profile->hasValidationClearance($moduleCodename) ? 'true' : 'false').",
	disabled:		".(($disableFields || !$cms_user->hasValidationClearance($moduleCodename)) ? 'true' : 'false')."
}";

$moduleAccessSubmit = '';
if (!$disableFields) {
	$moduleAccessSubmit = ",buttons:[{
		text:			'".$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)."',
		iconCls:		'atm-pic-validate',
		xtype:			'button',
		anchor:			'',
		handler:		function() {
			var access = Ext.getCmp('{$moduleCodename}-access-{$profileId}');
			var validation = Ext.getCmp('{$moduleCodename}-validate-{$profileId}');
			Automne.server.call('{$controler}', Ext.emptyFn, {
				userId:			'{$userId}',
				groupId:		'{$groupId}',
				action:			'module-rights',
				access:			access.getGroupValue(),
				validation:		(validation.getValue() ? 1 : 0),
				module:			'{$moduleCodename}'
			});
		}
	}]";
}

$maxDepth = sensitiveIO::isPositiveInteger(CMS_session::getSessionVar("modules_clearances_max_depth")) ? CMS_session::getSessionVar("modules_clearances_max_depth") : 3;

$moduleElements = "{
	id:				'categories-rights-{$moduleCodename}-{$profileId}',
	html:			'',
	border:			false,
	xtype:			'atmPanel',
	autoLoad:		{
		url:		'modules-categories-rights.php',
		params:			{
			userId:			'{$userId}',
			groupId:		'{$groupId}',
			module:			'{$moduleCodename}'
		},
		nocache:	true,
		scope:		Ext.emptyFn
	},
	listeners:{'render':function(panel) {
		panel.getUpdater().on('update', function() {
			if (Ext.fly('maxDepth-{$moduleCodename}-{$profileId}')) {
				var maxDepthField = new Ext.form.NumberField({
					applyTo:		'maxDepth-{$moduleCodename}-{$profileId}',
					maxValue:		20,
					minValue:		2,
					allowDecimals:	false,
					allowNegative:	false
				});
				maxDepthField.on('valid', function() {
					this.update({
						url:		'modules-categories-rights.php',
						params:			{
							userId:			'{$userId}',
							groupId:		'{$groupId}',
							module:			'{$moduleCodename}',
							maxDepth:		maxDepthField.getValue()
						},
						nocache:	true,
						scope:		Ext.emptyFn
					});
				}, this, {buffer:300});
			}
		});
	}}
}";

//rights specific to standard module
if ($moduleCodename == MOD_STANDARD_CODENAME) {
	//TEMPLATES
	$templategroups = CMS_pageTemplatesCatalog::getAllGroups();
	//Create templates checkboxes
	$templatesCheckboxes = $templateGroupsSubmit = '';
	if ($templategroups) {
		foreach ($templategroups as $templategroup) {
			// Check if in template groups denied
			$checked = (!$profile->hasTemplateGroupsDenied($templategroup)) ? 'checked="true"' : '';
			$disabled = ($cms_user->hasTemplateGroupsDenied($templategroup) || $disableFields || $profile->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? ' disabled="disabled"':'';
			$templatesCheckboxes .= '<label for="template-'.base64_encode($templategroup).'-'.$moduleCodename.'-'.$profileId.'"><input type="checkbox" name="templates['.base64_encode($templategroup).']" id="template-'.base64_encode($templategroup).'-'.$moduleCodename.'-'.$profileId.'" '.$checked.$disabled.' /> '.$templategroup.'</label> ';
		}
		if (!$disableFields) {
			$templateGroupsSubmit = ",buttons:[{
				text:			'".$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)."',
				iconCls:		'atm-pic-validate',
				xtype:			'button',
				anchor:			'',
				handler:		function() {
					var tpl = Ext.getCmp('tpl-form-{$moduleCodename}-{$profileId}').getForm();
					Automne.server.call('{$controler}', Ext.emptyFn, Ext.apply(tpl.getValues(), {
						userId:			'{$userId}',
						groupId:		'{$groupId}',
						action:			'templates-rights'
					}));
				}
			}]";
		}
	} else {
		$templatesCheckboxes = $cms_language->getJSMessage(MESSAGE_PAGE_NO_GROUP_ON_TEMPLATES);
	}
	// ROWS
	$rowsgroups = CMS_rowsCatalog::getAllGroups();
	//Create rows checkboxes
	$rowsCheckboxes = $rowGroupsSubmit = '';
	if ($rowsgroups) {
		foreach ($rowsgroups as $rowgroup) {
			// Check if in row groups denied
			$checked = (!$profile->hasRowGroupsDenied($rowgroup)) ? 'checked="true"' : '';
			$disabled = ($cms_user->hasRowGroupsDenied($rowgroup) || $disableFields || $profile->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) ? ' disabled="disabled"':'';
			$rowsCheckboxes .= '<label for="row-'.base64_encode($rowgroup).'-'.$moduleCodename.'-'.$profileId.'"><input type="checkbox" name="rows['.base64_encode($rowgroup).']" id="row-'.base64_encode($rowgroup).'-'.$moduleCodename.'-'.$profileId.'" '.$checked.$disabled.' /> '.$rowgroup.'</label> ';
		}
		if (!$disableFields) {
			$rowGroupsSubmit = ",buttons:[{
				text:			'".$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)."',
				iconCls:		'atm-pic-validate',
				xtype:			'button',
				anchor:			'',
				handler:		function() {
					var row = Ext.getCmp('row-form-{$moduleCodename}-{$profileId}').getForm();
					Automne.server.call('{$controler}', Ext.emptyFn, Ext.apply(row.getValues(), {
						userId:			'{$userId}',
						groupId:		'{$groupId}',
						action:			'rows-rights'
					}));
				}
			}]";
		}
	} else {
		$rowsCheckboxes = $cms_language->getJSMessage(MESSAGE_PAGE_NO_GROUP_ON_ROWS);
	}
	$standardTplRights = ",{
			title:			'".$cms_language->getJSMessage(MESSAGE_PAGE_TEMPLATES_RIGHTS)."',
			collapsed:		true,
			items:[{
				html:			'".$cms_language->getJSMessage(MESSAGE_PAGE_TEMPLATES_RIGHTS_INFO)."',
				border:			false
			},{
				xtype:			'form',
				id:				'tpl-form-{$moduleCodename}-{$profileId}',
				bodyStyle: 		'padding:10px 0px',
				border:			false,
				items:[{
					html:			'{$templatesCheckboxes}',
					border:			false
				}]
			}]
			{$templateGroupsSubmit}
		},{
			title:			'".$cms_language->getJSMessage(MESSAGE_PAGE_ROWS_TEMPLATE_RIGHTS)."',
			collapsed:		true,
			items:[{
				html:			'".$cms_language->getJSMessage(MESSAGE_PAGE_ROWS_TEMPLATE_RIGHTS_INFO)."',
				border:			false
			},{
				xtype:			'form',
				id:				'row-form-{$moduleCodename}-{$profileId}',
				bodyStyle: 		'padding:10px 0px',
				border:			false,
				items:[{
					html:			'{$rowsCheckboxes}',
					autoHeight:		true,
					border:			false
				}]
			}]
			{$rowGroupsSubmit}
		}";
} else {
	$standardTplRights = '';
}

$jscontent = <<<END
	var profileModulePanel = Ext.getCmp('{$winId}');
	
	//create center panel
	var profileModule = new Ext.Panel({
		id:					'profileModulePanel-{$profileId}',
		layout: 			'form',
		region:				'center',
		border:				false,
		autoScroll:			true,
		bodyStyle: 			'padding:5px',
		defaults: {
			layout: 		'form',
			xtype:			'fieldset',
			autoHeight:		true,
			collapsible:	true,
			animCollapse:	true,
			autoWidth:		true,
			buttonAlign:	'center'
		},
		items:[{$disableFieldsDesc}{
			id:				'{$moduleCodename}-access-panel-{$profileId}',
			title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ROWS_GENERAL_MODULE_ACCESS)}',
			collapsed:		false,
			bodyStyle: 		'height:70px',
			defaults: {
				xtype:			'radio',
				group:			'access-{$moduleCodename}-{$profileId}',
				hideLabel:		true
			},
			items:[{$moduleAccess}]
			$moduleAccessSubmit
		},{
			id:				'{$moduleCodename}-elements-access-panel-{$profileId}',
			title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ROWS_CONTENT_ACCESS)}',
			collapsed:		false,
			items:[{$moduleElements}]
		}{$standardTplRights}]
	});
	profileModulePanel.add(profileModule);
	//redo windows layout
	profileModulePanel.doLayout();
	//center.syncSize();
END;
$view->addJavascript($jscontent);
$view->show();
?>