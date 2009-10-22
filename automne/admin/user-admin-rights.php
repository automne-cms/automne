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
// $Id: user-admin-rights.php,v 1.3 2009/10/22 16:26:27 sebastien Exp $

/**
  * PHP page : Load modules categories rights interface
  * Used accross an Ajax request. Render categories list
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

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

define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_USER_ADMINISTRATOR", 504);
define("MESSAGE_PAGE_USER_RIGHT", 505);
define("MESSAGE_PAGE_ADMINISTRATION", 449);
define("MESSAGE_PAGE_ADMINISTRATION_RIGHTS", 506);


$userId = (int) sensitiveIO::request('userId', 'sensitiveIO::isPositiveInteger');
$groupId = (int) sensitiveIO::request('groupId', 'sensitiveIO::isPositiveInteger');
$winId = sensitiveIO::request('winId', '', 'userAdmin-'.$userId);

//load profile if any
$isUser = false;
if ($userId) {
	$profile = CMS_profile_usersCatalog::getByID($userId);
	$controler = 'users-controler.php';
	$isUser = true;
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

//if user is admin, then it has all rights on module
$disableFields = $disableFieldsDesc = '';
if ($isUser) {
	if ($profile->getUserId() == ROOT_PROFILEUSER_ID) {
		$disableFields = 'disabled:true,';
		$disableFieldsDesc = "<br /><br />".$cms_language->getJSMessage(MESSAGE_PAGE_USER_ADMINISTRATOR);
	} else {
		//if user belongs to groups, all fields are disabled
		$disableFields = sizeof(CMS_profile_usersGroupsCatalog::getGroupsOfUser($profile, true)) ? 'disabled:true,' : '';
		$disableFieldsDesc = '';
		if ($disableFields) {
			$disableFieldsDesc = "<br /><br />".$cms_language->getJSMessage(MESSAGE_PAGE_USER_RIGHT);
		}
	}
}
$adminTab = '';
// Admin clearance rows
$admins = CMS_profile::getAllAdminClearances();
foreach ($admins as $level => $messages) {
	if ($cms_user->hasAdminClearance($level)) {
		$checked = $profile->hasAdminClearance($level) ? 'checked:true,':'';
		$adminTab .= "{
			".$disableFields."
			".$checked."
			boxLabel: 	'<span ext:qtip=\"".$cms_language->getJSMessage($messages['description'])."\" class=\"atm-help\">".$cms_language->getJSMessage($messages['label'])."</span>',
			name: 		'admin[]',
			inputValue:	'".$level."',
			listeners:	{'check':function(checkbox, checked){
				//enable or disable others checkboxes if admin check if touched
				if (checkbox.getRawValue() == 1) {
					var form = Ext.getCmp('userAdminPanel-{$profileId}');
					var checkboxes = form.findByType('checkbox');
					for(var i = 0, checklen = checkboxes.length; i < checklen; i++) {
						if (checkboxes[i].getRawValue() != 1) {
							if (checked) {
								checkboxes[i].disable();
							} else {
								checkboxes[i].enable();
							}
						}
					}
				}
			}}
		},";
	}
}
$adminTab = io::substr($adminTab, 0, -1);
$adminTabSubmit = '';
if (!$disableFields) {
	$adminTabSubmit = ",buttons:[{
		text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
		xtype:			'button',
		name:			'submitAdmin',
		handler:		function() {
			var form = Ext.getCmp('userAdminPanel-{$profileId}').getForm();
			form.submit({params:{
				action:		'admin-rights',
				userId:		'{$userId}',
				groupId:	'{$groupId}'
			}});
		}
	}]";
}

$jscontent = <<<END
	var adminWindow = Ext.getCmp('{$winId}');
	
	//create center panel
	var center = new Automne.FormPanel({
		id:				'userAdminPanel-{$profileId}',
		title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ADMINISTRATION)}',
		layout: 		'form',
		url:			'{$controler}',
		defaultType:	'checkbox',
		bodyStyle: 		'padding:10px',
		border:			false,
		defaults: {
			xtype:			'checkbox',
			anchor:			'97%',
			hideLabel:		true,
			labelSeparator:	''
		},
		autoWidth:		true,
		autoHeight:		true,
		items:[{
			xtype:			'panel',
			bodyStyle: 		'padding:0 0 10px 0',
			html:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ADMINISTRATION_RIGHTS)}<span class="atm-text-alert">{$disableFieldsDesc}</span>',
			border:			false
		},{$adminTab}]
		{$adminTabSubmit}
	});
	
	adminWindow.add(center);
	//redo windows layout
	adminWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>