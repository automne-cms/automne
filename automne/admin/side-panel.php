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
// $Id: side-panel.php,v 1.12 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP page : Load side panel infos.
  * Presents north panel with connection infos and logo and center panel with all administration panels according to user rights
  * Used accross an Ajax request render Automne side panel
  *
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_VALIDATIONS_PENDING", 60);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);
define("MESSAGE_PAGE_NO_VALIDATIONS_PENDING", 1113);
define("MESSAGE_PAGE_REFRESH_ZONE_CONTENT", 340);

define("MESSAGE_PAGE_BOOKMARKS", 436);
define("MESSAGE_PAGE_ARCHIVED_PAGES", 437);
define("MESSAGE_PAGE_BRANCHE_DUPLICATION", 438);
define("MESSAGE_PAGE_PAGE_MANAGEMENT", 243);
define("MESSAGE_PAGE_MODULE_PARAMETERS", 439);
define("MESSAGE_PAGE_YOUR_PROFILE", 120);
define("MESSAGE_PAGE_USERS_PROFILE", 73);
define("MESSAGE_PAGE_GROUPS_PROFILE", 75);
define("MESSAGE_PAGE_USERS_MANAGEMENT", 77);
define("MESSAGE_PAGE_TEMPLATES", 30);
define("MESSAGE_PAGE_PAGE_TEMPLATES", 440);
define("MESSAGE_PAGE_ROWS_TEMPLATES", 441);
define("MESSAGE_PAGE_STYLES", 442);
define("MESSAGE_PAGE_WYSIWYG_STYLES", 443);
define("MESSAGE_PAGE_WYSIWYG_TOOLBAR", 444);
define("MESSAGE_PAGE_SCRIPTS_MANAGEMENT", 445);
define("MESSAGE_PAGE_ACTIONS_LOG", 894);
define("MESSAGE_PAGE_SITE_MANAGEMENT", 821);
define("MESSAGE_PAGE_LANGUAGE_MANAGEMENT", 446);
define("MESSAGE_PAGE_SERVER_SETTINGS", 447);
define("MESSAGE_PAGE_AUTUMN_SETTINGS", 448);
define("MESSAGE_PAGE_ADMIN", 449);
define("MESSAGE_PAGE_MODULE_ADMIN", 569);
define("MESSAGE_PAGE_VIEW_WEBSITE", 639);
define("MESSAGE_PAGE_VISIT_WEBSITE", 640);
define("MESSAGE_PAGE_LOCK_PANEL", 641);
define("MESSAGE_PAGE_END_SESSION", 642);
define("MESSAGE_PAGE_DISCONNECT", 643);
define("MESSAGE_PAGE_ABOUT_AUTOMNE", 644);
define("MESSAGE_PAGE_NO_BOOKMARK", 645);
define("MESSAGE_PAGE_SCRIPTS", 646);
define("MESSAGE_PAGE_MODULES_MANAGEMENT", 647);
define("MESSAGE_PAGE_DATABASE", 648);
define("MESSAGE_PAGE_TPL_HELP", 1468);
define("MESSAGE_PAGE_ROW_HELP", 727);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//set default options
$winId = sensitiveIO::request('winId', '', 'sidePanel');

//VALIDATIONS PENDING
$validationsPanel = '';
if ($cms_user->hasValidationClearance() && APPLICATION_ENFORCES_WORKFLOW) {
	$modulesValidations = CMS_modulesCatalog::getAllValidations($cms_user,true);
	$validationsCount = 0;
	//panel content
	$contentEl = '<div id="validationsDivPanel">';
	if ($modulesValidations && sizeof($modulesValidations)) {
		foreach ($modulesValidations as $codename => $moduleValidations) {
			//if module is not standard, echo its name, the number of validations to do and a link to its admin frontend
			if ($codename == MOD_STANDARD_CODENAME) {
				$modLabel = $cms_language->getMessage(MESSAGE_PAGE_STANDARD_MODULE_LABEL);
			} else {
				$mod = CMS_modulesCatalog::getByCodename($codename);
				$modLabel = $mod->getLabel($cms_language);
			}
			$contentEl .= '<h3>'.$modLabel.' :</h3>
			<ul>';
			//sort the validations by type label
			$validationsSorted = array();
			foreach ($moduleValidations as $validation) {
				$validationsSorted[$validation->getValidationTypeLabel()][] = $validation;
			}
			ksort($validationsSorted);
			$count = 0;
			foreach ($validationsSorted as $label => $validations) {
				$count++;
				$validation = $validations[0];
				$validationsCount += sizeof($validations);
				$editions = $validation->getEditions();
				if ($editions & RESOURCE_EDITION_CONTENT || $editions & RESOURCE_EDITION_BASEDATA) {
					$class = 'atm-validations';
				} elseif ($editions & RESOURCE_EDITION_LOCATION) {
					$class = 'atm-delete';
				} elseif ($editions & RESOURCE_EDITION_SIBLINGSORDER) {
					$class = 'atm-order';
				} elseif ($editions & RESOURCE_EDITION_MOVE) {
					$class = 'atm-move';
				}
				$contentEl .= '<li><div class="'.$class.' atm-sidepic"></div><a atm:action="validations" atm:module="'.$codename.'" atm:editions="'.$editions.'" href="#">'.$label." : ".sizeof($validations).'</a></li>';
			}
			$contentEl .= '</ul>';
		}
	} else {
		$contentEl .= $cms_language->getMessage(MESSAGE_PAGE_NO_VALIDATIONS_PENDING);
	}
	$contentEl .= '</div>';
	//panel
	$validationsPanel = "{
		id:					'validationsSidePanel',
		frame:				true,
		xtype:				'atmPanel',
		title: 				'{$cms_language->getMessage(MESSAGE_PAGE_VALIDATIONS_PENDING)} : {$validationsCount}',
		collapsible:		true,
		titleCollapse: 		true,
		collapsed:			true,
		html:				'".sensitiveIO::sanitizeJSString($contentEl)."',
		listeners:			{'expand': scrollPanel},
		hideCollapseTool:	true,
		refresh:			function() {
			this.load({
				url: 		'validations-sidepanel.php',
				nocache: 	true
			});
		},
		tools: [{
			id:				'refresh',
			handler:		function(e, toolEl, panel){
				panel.refresh();
			},
			qtip:			'{$cms_language->getMessage(MESSAGE_PAGE_REFRESH_ZONE_CONTENT)}'
		}, {
			id:				'toggle',
			handler:		function(e, toolEl, panel){
				panel.toggleCollapse(true);
			}
		}]
	},{
		border:			false,
		html:			'<div class=\"atm-hr\"></div>'
	},";
}

$modules = CMS_modulesCatalog::getALL();
$modulesPanels = '';
//MODULE STANDARD
if (isset($modules[MOD_STANDARD_CODENAME]) && $cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_VIEW)) {
	$module = $modules[MOD_STANDARD_CODENAME];
	$contentEl = '
	<div id="module'.$module->getCodename().'DivPanel">
		<ul>
			<li><div class="atm-favorite atm-sidepic"></div>'.$cms_language->getMessage(MESSAGE_PAGE_BOOKMARKS).'
			<div id="atm-favorites-pages">';
			$favorites = $cms_user->getFavorites();
			if ($favorites) {
				$contentEl .= '<ul>';
				foreach($favorites as $pageId) {
					$page = CMS_tree::getPageById($pageId);
					if (is_object($page) && !$page->hasError()) {
						$contentEl .= '<li><a href="#" atm:action="favorite" atm:page="'.$pageId.'" alt="'.io::htmlspecialchars($page->getTitle()).'" title="'.io::htmlspecialchars($page->getTitle()).'">'.$page->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $page->getID()).'&nbsp;'.sensitiveIO::ellipsis($page->getTitle(), 32).'&nbsp;('.$pageId.')</a></li>';
					}
				}
				$contentEl .= '</ul>';
			} else {
				$contentEl .= $cms_language->getMessage(MESSAGE_PAGE_NO_BOOKMARK);
			}
			$contentEl .= '</div></li>';
	if ($cms_user->hasValidationClearance(MOD_STANDARD_CODENAME)) {
		$contentEl .= '<li><div class="atm-archives atm-sidepic"></div><a atm:action="archives" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_ARCHIVED_PAGES).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH)) {
		$contentEl .= '<li><div class="atm-duplicate-branch atm-sidepic"></div><a atm:action="duplicate-branch" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_BRANCHE_DUPLICATION).'</a></li>';
	}
	$contentEl .= '
		</ul>
	</div>';
	//panel
	$modulesPanels .= "{
		id:					'module{$module->getCodename()}SidePanel',
		frame:				true,
		title: 				'".$cms_language->getMessage(MESSAGE_PAGE_PAGE_MANAGEMENT)."',
		collapsible:		true,
		titleCollapse: 		true,
		collapsed:			true,
		html:				'".sensitiveIO::sanitizeJSString($contentEl)."',
		listeners:			{'expand': scrollPanel},
		hideCollapseTool:	true,
		refresh:			function() {
			var favorites = Ext.get('atm-favorites-pages');
			if (favorites) {
				favorites.getUpdater().renderer = new Automne.windowRenderer();
				favorites.load({
					url: 		'favorites-sidepanel.php',
					nocache: 	true
				});
			}
		},
		tools: [{
			id:				'refresh',
			handler:		function(e, toolEl, panel){
				panel.refresh();
			},
			qtip:			'{$cms_language->getMessage(MESSAGE_PAGE_REFRESH_ZONE_CONTENT)}'
		},";
	//add module parameters
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
		$modulesPanels .= "{
			id:				'gear',
			handler:		function(e, toolEl, panel){
				var window = new Automne.frameWindow({
					id:				'modulesWindow',
					frameURL:		'".PATH_MAIN_WR."/admin-v3/modules_admin.php?moduleCodename={$module->getCodename()}',
					allowFrameNav:	true,
					width:			750,
					height:			580,
					animateTarget:	e
				});
				window.show();
			},
			qtip:			'".$cms_language->getMessage(MESSAGE_PAGE_MODULE_PARAMETERS)."'
		},";
	}
	$modulesPanels .= "{
			id:				'toggle',
			handler:		function(e, toolEl, panel){
				panel.toggleCollapse(true);
			}
		}]
	},";
}

//OTHER MODULES ADMINISTRATIONS
foreach ($modules as $module) {
	if ($module->hasAdmin()
		&& $module->getCodename() != MOD_STANDARD_CODENAME
		&& $cms_user->hasModuleClearance($module->getCodename(), CLEARANCE_MODULE_EDIT)) {

		$modLabel = sensitiveIO::sanitizeJSString($module->getLabel($cms_language));
		if ($modLabel) {
			$contentEl = '
			<div id="module'.$module->getCodename().'DivPanel">
				<ul>';
					if (!method_exists($module,'getObjectsInfos')) {
						$options = io::htmlspecialchars(sensitiveIO::jsonEncode(array('admin' => $module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT))));
						$contentEl .= '<li><div class="atm-modules atm-sidepic"></div><a atm:action="module" atm:module="'.$module->getCodename().'" atm:version="3" href="#" atm:options="'.$options.'">'.$cms_language->getMessage(MESSAGE_PAGE_MODULE_ADMIN, array(io::htmlspecialchars($module->getLabel($cms_language)))).'</a></li>';
					} else {
						$objectsInfos = $module->getObjectsInfos($cms_user);
						foreach ($objectsInfos as $objectsInfo) {
							if (isset($objectsInfo['class']) && $objectsInfo['class'] == 'atm-separator') {
								$contentEl .= '<li><div class="atm-separator"></div></li>';
							} else {
								$version = isset($objectsInfo['version']) ? $objectsInfo['version'] : 4;
								if (isset($objectsInfo['description'])) {
									$description = ' ext:qtip="'.io::htmlspecialchars($objectsInfo['description']).'"';
									unset($objectsInfo['description']);
								} else {
									$description = '';
								}
								if (isset($objectsInfo['adminLabel'])) {
									$label = io::htmlspecialchars($objectsInfo['adminLabel']);
									unset($objectsInfo['adminLabel']);
								} else {
									$label = $cms_language->getMessage(MESSAGE_PAGE_MODULE_ADMIN, array(io::htmlspecialchars($module->getLabel($cms_language))));
								}
								$class = isset($objectsInfo['class']) ? $objectsInfo['class'] : 'atm-modules';
								$contentEl .= '<li><div class="'.$class.' atm-sidepic"></div><a atm:action="module"'.$description.' atm:module="'.$module->getCodename().'" atm:version="'.$version.'" atm:options="'.io::htmlspecialchars(sensitiveIO::jsonEncode($objectsInfo)).'" href="#">'.$label.'</a></li>';
							}
						}
					}
			$contentEl .= '
				</ul>
			</div>';
			//panel
			$modulesPanels .= "{
				id:					'module{$module->getCodename()}SidePanel',
				frame:				true,
				title: 				'{$modLabel}',
				collapsible:		true,
				titleCollapse: 		true,
				collapsed:			true,
				html:				'".sensitiveIO::sanitizeJSString($contentEl)."',
				listeners:			{'expand': scrollPanel}";
			//add modules parameters
			if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
				$modulesPanels .= ",
				hideCollapseTool:	true,
				tools: [{
					id:				'gear',
					handler:		function(e, toolEl, panel){
						var window = new Automne.frameWindow({
							id:				'modulesWindow',
							frameURL:		'".PATH_MAIN_WR."/admin-v3/modules_admin.php?moduleCodename={$module->getCodename()}',
							allowFrameNav:	true,
							width:			750,
							height:			580,
							animateTarget:	e
						});
						window.show();
					},
					qtip:			'".$cms_language->getMessage(MESSAGE_PAGE_MODULE_PARAMETERS)."'
				}, {
					id:				'toggle',
					handler:		function(e, toolEl, panel){
						panel.toggleCollapse(true);
					}
				}]";
			}
			$modulesPanels .= "
			},";
		}
	}
}

//USERS
$usersPanel = '';

$sepPanel = "{
	border:			false,
	html:			'<div class=\"atm-hr\"></div>'
},";

$contentEl = '
<div id="usersDivPanel">
	<ul>
		<li><div class="atm-profile atm-sidepic"></div><a atm:action="profile" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_YOUR_PROFILE).'</a></li>';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	$contentEl .= '
		<li><div class="atm-users atm-sidepic"></div><a atm:action="users" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_USERS_PROFILE).'</a></li>
		<li><div class="atm-groups atm-sidepic"></div><a atm:action="groups" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_GROUPS_PROFILE).'</a></li>';
}
$contentEl .= '
	</ul>
</div>';
//panel
$usersPanel = "{
	id:					'usersSidePanel',
	frame:				true,
	title: 				'".$cms_language->getMessage(MESSAGE_PAGE_USERS_MANAGEMENT)."',
	collapsible:		true,
	titleCollapse: 		true,
	collapsed:			true,
	html:				'".sensitiveIO::sanitizeJSString($contentEl)."',
	listeners:			{'expand': scrollPanel}
},";

//AFJ
if (date(base64_decode('ZC1t')) == base64_decode('MDEtMDQ=')) {
	eval(base64_decode('JGNvbnRlbnRFbCA9ICc8ZGl2IGlkPSJhZmpEaXZQYW5lbCI+PHVsPjxsaT48ZGl2IGNsYXNzPSJhdG0tc2VydmVyIGF0bS1zaWRlcGljIj48L2Rpdj48YSBhdG06YWN0aW9uPSJhdG0tYWZqIiBocmVmPSIjIj4nLigkY21zX2xhbmd1YWdlLT5nZXRDb2RlKCkgPT0gJ2ZyJyA/ICdGYWl0IG1vaSB1biBjYWYmZWFjdXRlOycgOiAnTWFrZSBtZSBzb21lIGNvZmZlZScpLic8L2E+PC9saT48bGk+PGRpdiBjbGFzcz0iYXRtLXNlcnZlciBhdG0tc2lkZXBpYyI+PC9kaXY+PGEgYXRtOmFjdGlvbj0iYXRtLWpzdCIgaHJlZj0iIyI+VGV0cmlzPC9hPjwvbGk+PC91bD48L2Rpdj4nOyRzZXBQYW5lbCAuPSAie2lkOidhZmpTaWRlUGFuZWwnLGZyYW1lOnRydWUsdGl0bGU6JyIuKCRjbXNfbGFuZ3VhZ2UtPmdldENvZGUoKSA9PSAnZnInID8gJ0ZvbmN0aW9ucyBVdGlsZXMnIDogJ1VzZWZ1bCBGdW5jdGlvbnMnKS4iJyxjb2xsYXBzaWJsZTp0cnVlLHRpdGxlQ29sbGFwc2U6dHJ1ZSxjb2xsYXBzZWQ6dHJ1ZSxodG1sOiciLnNlbnNpdGl2ZUlPOjpzYW5pdGl6ZUpTU3RyaW5nKCRjb250ZW50RWwpLiInLGxpc3RlbmVyczp7J2V4cGFuZCc6IHNjcm9sbFBhbmVsfX0sIjs='));
}

//TEMPLATES
$templatesPanel = '';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	$contentEl = '
	<div id="templatesDivPanel">
		<ul>';
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
		$contentEl .= '<li><div class="atm-templates atm-sidepic"></div><div id="template-help-button" class="atm-sidepic-help" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_TPL_HELP).'"></div><a atm:action="templates" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_PAGE_TEMPLATES).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
		$contentEl .= '<li><div class="atm-rows atm-sidepic"></div><div id="row-help-button" class="atm-sidepic-help" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_ROW_HELP).'"></div><a atm:action="rows" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_ROWS_TEMPLATES).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
		$contentEl .= '<li><div class="atm-styles atm-sidepic"></div><a atm:action="styles" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_STYLES).'</a></li>
		<li><div class="atm-wysiwyg-toolbar atm-sidepic"></div><a atm:action="wysiwyg-toolbar" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_WYSIWYG_TOOLBAR).'</a></li>';
	}
	$contentEl .= '
		</ul>
	</div>';
	//panel
	$templatesPanel = "{
		id:					'templatesSidePanel',
		frame:				true,
		title: 				'".$cms_language->getMessage(MESSAGE_PAGE_TEMPLATES)."',
		collapsible:		true,
		titleCollapse: 		true,
		collapsed:			true,
		html:				'".sensitiveIO::sanitizeJSString($contentEl)."',
		listeners:			{'expand': scrollPanel}
	},";
}

//ADMINISTRATION
$adminPanel = '';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
	$contentEl = '
	<div id="adminDivPanel">
		<ul>';
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
		$contentEl .= '<li><div class="atm-scripts atm-sidepic"></div><a atm:action="scripts" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_MANAGEMENT).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
		$contentEl .= '<li><div class="atm-logs atm-sidepic"></div><a atm:action="logs" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_ACTIONS_LOG).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
		$contentEl .= '
			<li><div class="atm-modules atm-sidepic"></div><a atm:action="modules" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_MODULES_MANAGEMENT).'</a></li>
			<li><div class="atm-websites atm-sidepic"></div><a atm:action="websites" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_SITE_MANAGEMENT).'</a></li>
			<li><div class="atm-languages atm-sidepic"></div><a atm:action="languages" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_LANGUAGE_MANAGEMENT).'</a></li>
			<li><div class="atm-separator"></div></li>';
		if(!defined('DISABLE_PHP_MYADMIN')) {
			$contentEl .= '<li><div class="atm-database atm-sidepic"></div><a href="'.PATH_PHPMYADMIN_WR.'" target="_blank">'.$cms_language->getMessage(MESSAGE_PAGE_DATABASE).'</a></li>';
		}
		$contentEl .= '<li><div class="atm-server atm-sidepic"></div><a atm:action="server" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_SERVER_SETTINGS).'</a></li>
			<li><div class="atm-parameters atm-sidepic"></div><a atm:action="parameters" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_AUTUMN_SETTINGS).'</a></li>';
	}
	$contentEl .= '
		</ul>
	</div>';
	//panel
	$adminPanel = "{
		id:					'adminSidePanel',
		frame:				true,
		title: 				'".$cms_language->getMessage(MESSAGE_PAGE_ADMIN)."',
		collapsible:		true,
		titleCollapse: 		true,
		collapsed:			true,
		html:				'".sensitiveIO::sanitizeJSString($contentEl)."',
		listeners:			{'expand': scrollPanel}
	},";
}

//remove the last comma on all panels
$userPanels = io::substr($validationsPanel.$modulesPanels.$sepPanel.$usersPanel.$templatesPanel.$adminPanel, 0, -1);

$topPanel = sensitiveIO::sanitizeJSString('
<div id="headPanel">
	<div id="headPanelBar"></div>
	<div id="headPanelContent">
		<div id="headPanelSite" ext:qtip="Automne Version '.AUTOMNE_VERSION.'">'.APPLICATION_LABEL.'</div>
		<div id="headPanelClient">'.$cms_user->getFullName().'</div>
		<a href="'.PATH_REALROOT_WR.'/" id="headPanelSiteLink" target="_blank" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_VIEW_WEBSITE).'"></a>
		<a href="http://www.automne-cms.org" id="headPanelAutomneLink" target="_blank" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_VISIT_WEBSITE).'"></a>
		<div id="headPanelStick" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_LOCK_PANEL).'"></div>
		<div id="headPanelLogout" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_END_SESSION).'">'.$cms_language->getMessage(MESSAGE_PAGE_DISCONNECT).'</div>
		<div id="headPanelAutomneHelp" ext:qtip="'.$cms_language->getMessage(MESSAGE_PAGE_ABOUT_AUTOMNE).'"></div>
		<div id="headPanelBarInfos"></div>
	</div>
</div>');

$automnePath = PATH_MAIN_WR;

$jscontent = <<<END
	var sidePanel = Ext.getCmp('{$winId}');
	var scrollPanel = function(p) {
		p.getEl().scrollIntoView(center.body);
	}
	var doAction = function(e, t){
		t = Ext.get(t);
		var action = t.getAttributeNS('atm', 'action' );
		if (action) {
			e.stopEvent();
			if (actions[action]) {
				actions[action](t);
			} else {
				Automne.message.show('action '+action+' not found');
			}
		}
    }
	var center = new Ext.Panel({
		id:					'sidePanel-center',
		region:				'center',
		border:				false,
		autoScroll:			true,
		bodyStyle:			'background:#F3F3F3;',
		items:				[{$userPanels}],
		listeners:{'render':function(){
			center.body.on('mousedown', doAction, null, {delegate:'a'});
		},
		scope:this}
	});

	// Panel for the north
	var top = new Ext.Panel({
		id:				'sidePanel-north',
		region:			'north',
		height:			148,
		border:			false,
		html: 			'{$topPanel}',
		listeners:{'afterrender':function(){
			Ext.get('headPanelLogout').on('mousedown', function(){
				//remove all events on window
				Ext.EventManager.removeAll(window);
				window.location.href = '{$automnePath}/admin/?cms_action=logout';
			}, this);
			//over on disconnect button
			Ext.get('headPanelLogout').addClassOnOver('over');
			Ext.get('headPanelAutomneHelp').on('mousedown', function(){
				//create window element
				var win = new Automne.Window({
					id:				'atmHelpWindow',
					width:			515,
					height:			450,
					resizable:		false,
					maximizable:	false,
					autoLoad:		{
						url:		'help.php',
						params:		{winId:'atmHelpWindow'},
						nocache:	true,
						scope:		this
					}
				});
				//display window
				win.show(Ext.get('headPanelAutomneHelp'));
			}, this);
			Ext.get('headPanelAutomneHelp').addClassOnOver('over');

			//side panel collapse stick
			var panelStick = Ext.get('headPanelStick');
			panelStick.addClassOnOver('over');
			//get state of side panel (collapsed or not)
			if (!Ext.state.Manager.get('side-panel-collapsible', true)) {
				Automne.east.collapsible = false;
				panelStick.addClass('pinned');
			} else {
				//then start timer to collapse it
				Automne.east.collapseTimer();
			}
			panelStick.on('mousedown', function(e, el){
				var el = Ext.get(el);
				if (Automne.east.collapsible == true) {
					Ext.state.Manager.set('side-panel-collapsible', false);
					Automne.east.collapsible = false;
					el.addClass('pinned');
				} else {
					Ext.state.Manager.set('side-panel-collapsible', true);
					Automne.east.collapsible = true;
					el.removeClass('pinned');
				}
			}, this);
		},
		scope:this}
	});

	//add panel regions
	sidePanel.add(top);
	sidePanel.add(center);

	//redo layout
	sidePanel.doLayout();

	var openWindow = function(t, url, params, width, height, popupable) {
		var action = t.getAttributeNS('atm', 'action' );
		//create window element
		var win = new Automne.Window({
			id:				params.id || action+'Window',
			width:			width,
			height:			height,
			popupable:		(popupable ? true : false),
			autoLoad:		{
				url:		url,
				params:		Ext.apply({winId:action+'Window'},params),
				nocache:	true,
				scope:		this
			}
		});
		//display window
		win.show(t);
		return win;
	}

	var actions = {
    	'validations' : function(t){
    		var win = openWindow(t, 'validations.php', {
				module:		t.getAttributeNS('atm', 'module'),
				editions:	t.getAttributeNS('atm', 'editions')
			}, 800, 600);
			win.on('close', function() {
				//try to refresh validation panel
				var validationPanel = Ext.getCmp('validationsSidePanel');
				if (validationPanel) validationPanel.refresh();
			});
    	},
		'favorite' : function(t){
    		Automne.utils.getPageById(t.getAttributeNS('atm', 'page'));
    	},
		'archives' : function(t){
    		var window = new Automne.frameWindow({
				id:				'archiveWindow',
				frameURL:		'{$automnePath}/admin-v3/archives.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	},
		'duplicate-branch' : function(t){
    		openWindow(t, 'tree-duplicate.php', {}, 750, 580);
    	},
		'atm-afj' : function(t){
    		var window = new Automne.frameWindow({
				id:				'afjWindow',
				frameURL:		'{$automnePath}/admin/navigator.php?afj=1',
				allowFrameNav:	true,
				width:			450,
				height:			260,
				animateTarget:	t
			});
			window.show();
    	},
		'atm-jst' : function(t){
    		var window = new Automne.frameWindow({
				id:				'jstWindow',
				frameURL:		'{$automnePath}/admin/jst.php',
				allowFrameNav:	true,
				width:			450,
				height:			500,
				animateTarget:	t
			});
			window.show();
    	},
		'module' : function(t){
    		switch(t.getAttributeNS('atm', 'version')) {
				case '3':
					if (t.getAttributeNS('atm', 'module') && t.getAttributeNS('atm', 'options')) {
						try {
							eval('var options = '+t.getAttributeNS('atm', 'options')+';');
						} catch(e){}
						if (options.admin) {
							var moduleWindow = new Automne.frameWindow({
								id:				'module'+ t.getAttributeNS('atm', 'module') +'Window',
								frameURL:		options.admin,
								allowFrameNav:	true,
								width:			750,
								height:			580,
								animateTarget:	t
							});
							moduleWindow.show();
						}
					}
				break;
				case '4':
				default:
					openWindow(t, 'module.php', {
						id:			'module'+ t.getAttributeNS('atm', 'module') +'Window',
						module:		t.getAttributeNS('atm', 'module'),
						options:	t.getAttributeNS('atm', 'options')
					}, 750, 580, true);
				break;
			}
    	},
		'profile' : function(t){
    		openWindow(t, 'user.php', {
				userId:		{$cms_user->getUserId()}
			}, 750, 580, true);
    	},
		'users' : function(t){
    		openWindow(t, 'users-groups.php', {
				type:		'users'
			}, 750, 580, true);
    	},
		'groups' : function(t){
    		openWindow(t, 'users-groups.php', {
				type:		'groups'
			}, 750, 580, true);
    	},
		'templates' : function(t){
    		openWindow(t, 'templates.php', {
				type:		'template'
			}, 750, 580, true);
		},
		'rows' : function(t){
    		openWindow(t, 'templates.php', {
				type:		'row'
			}, 750, 580, true);
    	},
		'styles' : function(t){
    		openWindow(t, 'templates.php', {type:'styles'}, 750, 580, true);
    	},
		'wysiwyg-toolbar' : function(t){
			openWindow(t, 'templates.php', {
				type:		'wysiwyg-toolbar'
			}, 750, 580, true);
    	},
		'modules' : function(t){
    		var window = new Automne.frameWindow({
				id:				'modulesWindow',
				frameURL:		'{$automnePath}/admin-v3/modules_admin.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	},
		'scripts' : function(t){
    		openWindow(t, 'server-scripts.php', {}, 750, 580, true);
    	},
		'logs' : function(t){
    		openWindow(t, 'logs.php', {}, 750, 580, true);
    	},
		'websites' : function(t){
    		var window = new Automne.frameWindow({
				id:				'websitesWindow',
				frameURL:		'{$automnePath}/admin-v3/websites.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	},
		'languages' : function(t){
    		openWindow(t, 'languages.php', {}, 750, 580, true);
    	},
		'server' : function(t){
    		openWindow(t, '{$automnePath}/admin/server.php', {}, 750, 580, true);
    	},
		'parameters' : function(t){
    		openWindow(t, 'module-parameters.php', {
				module:		'standard'
			}, 750, 580, true);
    	}
    };

	//help windows
	var tplHelp = Ext.get('template-help-button');
	if (tplHelp) {
		tplHelp.on('click', function(el) {
			var windowId = 'templateHelpWindow';
			if (Ext.WindowMgr.get(windowId)) {
				Ext.WindowMgr.bringToFront(windowId);
			} else {
				//create window element
				var win = new Automne.Window({
					id:				windowId,
					modal:			false,
					popupable:		true,
					autoLoad:		{
						url:			'template-help.php',
						params:			{
							winId:			windowId
						},
						nocache:		true,
						scope:			this
					}
				});
				//display window
				win.show(el);
			}
		});
	}
	var knm = new Knm();knm.code=function(){var window=new Automne.frameWindow({id:'jstWindow',frameURL:'{$automnePath}/admin/jst.php',allowFrameNav:true,width:450,height:500});window.show();};knm.load();
	var rowHelp = Ext.get('row-help-button');
	if (rowHelp) {
		rowHelp.on('click', function(el) {
			var windowId = 'rowHelpWindow';
			if (Ext.WindowMgr.get(windowId)) {
				Ext.WindowMgr.bringToFront(windowId);
			} else {
				//create window element
				var win = new Automne.Window({
					id:				windowId,
					modal:			false,
					popupable:		true,
					autoLoad:		{
						url:			'row-help.php',
						params:			{
							winId:			windowId
						},
						nocache:		true,
						scope:			this
					}
				});
				//display window
				win.show(el);
			}
		});
	}
END;
$view->addJavascript($jscontent);

$view->show();
?>