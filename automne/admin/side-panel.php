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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: side-panel.php,v 1.3 2009/03/02 11:25:15 sebastien Exp $

/**
  * PHP page : Load side panel infos.
  * Presents north panel with connection infos and logo and center panel with all administration panels according to user rights
  * Used accross an Ajax request render Automne side panel
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

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
define("MESSAGE_PAGE_STYLESHEETS", 442);
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

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//set default options
$winId = sensitiveIO::request('winId', '', 'sidePanel');

$content = '
<div id="headPanel">
	<div id="headPanelBar"></div>
	<div id="headPanelContent">
		<div id="headPanelSite" ext:qtip="Automne Version '.AUTOMNE_VERSION.'">'.APPLICATION_LABEL.'</div>
		<div id="headPanelClient">'.$cms_user->getFullName().'</div>
		<a href="/" id="headPanelSiteLink" target="_blank" ext:qtip="Voir votre site dans une nouvelle fenêtre"></a>
		<a href="http://www.automne.ws/" id="headPanelAutomneLink" target="_blank" ext:qtip="Aller sur le site d\'Automne"></a>
		<div id="headPanelStick" ext:qtip="Bloquer / Débloquer la position du panneau latéral"></div>
		<div id="headPanelLogout" ext:qtip="Terminer la session en cours et vous déconnecter">Déconnexion</div>
		<div id="headPanelBarInfos"></div>
	</div>
</div>';

//VALIDATIONS PENDING
$validationsPanel = '';
if ($cms_user->hasValidationClearance() && APPLICATION_ENFORCES_WORKFLOW) {
	$modulesValidations = CMS_modulesCatalog::getAllValidations($cms_user,true);
	$validationsCount = 0;
	//panel content
	$content .= '<div id="validationsDivPanel">';
	if ($modulesValidations && sizeof($modulesValidations)) {
		foreach ($modulesValidations as $codename => $moduleValidations) {
			//if module is not standard, echo its name, the number of validations to do and a link to its admin frontend
			if ($codename == MOD_STANDARD_CODENAME) {
				$modLabel = $cms_language->getMessage(MESSAGE_PAGE_STANDARD_MODULE_LABEL);
			} else {
				$mod = CMS_modulesCatalog::getByCodename($codename);
				$modLabel = $mod->getLabel($cms_language);
			}
			$content .= '<h3>'.$modLabel.' :</h3>
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
				$content .= '<li><div class="'.$class.' atm-sidepic"></div><a atm:action="validations" atm:module="'.$codename.'" atm:editions="'.$editions.'" href="#">'.$label." : ".sizeof($validations).'</a></li>';
			}
			$content .= '</ul>';
		}
	} else {
		$content .= $cms_language->getMessage(MESSAGE_PAGE_NO_VALIDATIONS_PENDING);
	}
	$content .= '</div>';
	//panel
	$validationsPanel = "{
		id:					'validationsPanel',
		frame:				true,
		xtype:				'atmPanel',
		title: 				'{$cms_language->getMessage(MESSAGE_PAGE_VALIDATIONS_PENDING)} : {$validationsCount}',
		collapsible:		true,
		titleCollapse: 		true,
		collapsed:			true,
		contentEl:			'validationsDivPanel',
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
if (isset($modules[MOD_STANDARD_CODENAME]) && $cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	$module = $modules[MOD_STANDARD_CODENAME];
	$content .= '
	<div id="module'.$module->getCodename().'DivPanel">
		<ul>
			<li><div class="atm-favorite atm-sidepic"></div>'.$cms_language->getMessage(MESSAGE_PAGE_BOOKMARKS).'
			<div id="atm-favorites-pages">';
			$favorites = $cms_user->getFavorites();
			if ($favorites) {
				$content .= '<ul>';
				foreach($favorites as $pageId) {
					$page = CMS_tree::getPageById($pageId);
					if (is_object($page) && !$page->hasError()) {
						$content .= '<li><a href="#" atm:action="favorite" atm:page="'.$pageId.'" alt="'.htmlspecialchars($page->getTitle()).'" title="'.htmlspecialchars($page->getTitle()).'">'.$page->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $page->getID()).'&nbsp;'.sensitiveIO::ellipsis($page->getTitle(), 32).'&nbsp;('.$pageId.')</a></li>';
					}
				}
				$content .= '</ul>';
			} else {
				$content .= 'Aucune page dans vos favoris.';
			}
			$content .= '</div></li>';
	if ($cms_user->hasValidationClearance(MOD_STANDARD_CODENAME)) {
		$content .= '<li><div class="atm-archives atm-sidepic"></div><a atm:action="archives" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_ARCHIVED_PAGES).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH)) {
		$content .= '<li><div class="atm-duplicate-branch atm-sidepic"></div><a atm:action="duplicate-branch" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_BRANCHE_DUPLICATION).'</a></li>';
	}
	$content .= '
		</ul>
	</div>';
	//panel
	$modulesPanels .= "{
		id:					'module{$module->getCodename()}Panel',
		frame:				true,
		title: 				'".$cms_language->getMessage(MESSAGE_PAGE_PAGE_MANAGEMENT)."',
		collapsible:		true,
		titleCollapse: 		true,
		collapsed:			true,
		contentEl:			'module{$module->getCodename()}DivPanel',
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
					frameURL:		'/automne/admin-v3/modules_admin.php?moduleCodename={$module->getCodename()}',
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
		$content .= '
		<div id="module'.$module->getCodename().'DivPanel">
			<ul>';
				if (!method_exists($module,'getObjectsInfos')) {
					$options = htmlspecialchars(sensitiveIO::jsonEncode(array('admin' => $module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT))));
					$content .= '<li><div class="atm-modules atm-sidepic"></div><a atm:action="module" atm:module="'.$module->getCodename().'" atm:version="3" href="#" atm:options="'.$options.'">'.$cms_language->getMessage(MESSAGE_PAGE_MODULE_ADMIN, array(htmlspecialchars($module->getLabel($cms_language)))).'</a></li>';
				} else {
					$objectsInfos = $module->getObjectsInfos($cms_user);
					foreach ($objectsInfos as $objectsInfo) {
						$version = isset($objectsInfo['version']) ? $objectsInfo['version'] : 4;
						if (isset($objectsInfo['description'])) {
							$description = ' ext:qtip="'.htmlspecialchars($objectsInfo['description']).'"';
							unset($objectsInfo['description']);
						} else {
							$description = '';
						}
						if (isset($objectsInfo['adminLabel'])) {
							$label = htmlspecialchars($objectsInfo['adminLabel']);
							unset($objectsInfo['adminLabel']);
						} else {
							$label = $cms_language->getMessage(MESSAGE_PAGE_MODULE_ADMIN, array(htmlspecialchars($module->getLabel($cms_language))));
						}
						$class = isset($objectsInfo['class']) ? $objectsInfo['class'] : 'atm-modules';
						$content .= '<li><div class="'.$class.' atm-sidepic"></div><a atm:action="module"'.$description.' atm:module="'.$module->getCodename().'" atm:version="'.$version.'" atm:options="'.htmlspecialchars(sensitiveIO::jsonEncode($objectsInfo)).'" href="#">'.$label.'</a></li>';
					}
				}
		$content .= '
			</ul>
		</div>';
		//panel
		$modLabel = sensitiveIO::sanitizeJSString($module->getLabel($cms_language));
		$modulesPanels .= "{
			id:					'module{$module->getCodename()}Panel',
			frame:				true,
			title: 				'{$modLabel}',
			collapsible:		true,
			titleCollapse: 		true,
			collapsed:			true,
			contentEl:			'module{$module->getCodename()}DivPanel',
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
						frameURL:		'/automne/admin-v3/modules_admin.php?moduleCodename={$module->getCodename()}',
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

//USERS
$usersPanel = '';

$content .= '
<div id="usersDivPanel">
	<ul>
		<li><div class="atm-profile atm-sidepic"></div><a atm:action="profile" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_YOUR_PROFILE).'</a></li>';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	$content .= '
		<li><div class="atm-users atm-sidepic"></div><a atm:action="users" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_USERS_PROFILE).'</a></li>
		<li><div class="atm-groups atm-sidepic"></div><a atm:action="groups" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_GROUPS_PROFILE).'</a></li>';
}
$content .= '
	</ul>
</div>';
//panel
$usersPanel = "{
	id:					'usersPanel',
	frame:				true,
	title: 				'".$cms_language->getMessage(MESSAGE_PAGE_USERS_MANAGEMENT)."',
	collapsible:		true,
	titleCollapse: 		true,
	collapsed:			true,
	contentEl:			'usersDivPanel',
	listeners:			{'expand': scrollPanel}
},";


//TEMPLATES
$templatesPanel = '';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	$content .= '
	<div id="templatesDivPanel">
		<ul>';
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
		$content .= '<li><div class="atm-templates atm-sidepic"></div><a atm:action="templates" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_PAGE_TEMPLATES).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES)) { //rows
		$content .= '<li><div class="atm-rows atm-sidepic"></div><a atm:action="rows" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_ROWS_TEMPLATES).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) { //templates
		//TODOV4
		/*$content .= '<li><div class="atm-styles atm-sidepic"></div><a atm:action="styles" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_STYLESHEETS).'</a></li>
		<li><div class="atm-wysiwyg-styles atm-sidepic"></div><a atm:action="wysiwyg-styles" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_WYSIWYG_STYLES).'</a></li>*/
		$content .= '<li><div class="atm-wysiwyg-toolbar atm-sidepic"></div><a atm:action="wysiwyg-toolbar" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_WYSIWYG_TOOLBAR).'</a></li>';
	}
	$content .= '
		</ul>
	</div>';
	//panel
	$templatesPanel = "{
		id:					'templatesPanel',
		frame:				true,
		title: 				'".$cms_language->getMessage(MESSAGE_PAGE_TEMPLATES)."',
		collapsible:		true,
		titleCollapse: 		true,
		collapsed:			true,
		contentEl:			'templatesDivPanel',
		listeners:			{'expand': scrollPanel}
	},";
}

//ADMINISTRATION
$adminPanel = '';
if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
	$content .= '
	<div id="adminDivPanel">
		<ul>';
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
		$content .= '<li><div class="atm-scripts atm-sidepic"></div><a atm:action="scripts" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_MANAGEMENT).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
		$content .= '<li><div class="atm-logs atm-sidepic"></div><a atm:action="logs" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_ACTIONS_LOG).'</a></li>';
	}
	if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
		$content .= '
			<li><div class="atm-modules atm-sidepic"></div><a atm:action="modules" href="#">Gestion des modules</a></li>
			<li><div class="atm-websites atm-sidepic"></div><a atm:action="websites" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_SITE_MANAGEMENT).'</a></li>';
			//TODOV4
			/*<li><div class="atm-languages atm-sidepic"></div><a atm:action="languages" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_LANGUAGE_MANAGEMENT).'</a></li>*/
		$content .= '<li><div class="atm-server atm-sidepic"></div><a href="'.PATH_PHPMYADMIN_WR.'" target="_blank">Base de données</a></li>
			<li><div class="atm-server atm-sidepic"></div><a atm:action="server" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_SERVER_SETTINGS).'</a></li>
			<li><div class="atm-parameters atm-sidepic"></div><a atm:action="parameters" href="#">'.$cms_language->getMessage(MESSAGE_PAGE_AUTUMN_SETTINGS).'</a></li>';
	}
	$content .= '
		</ul>
	</div>';
	//panel
	$adminPanel = "{
		id:					'adminPanel',
		frame:				true,
		title: 				'".$cms_language->getMessage(MESSAGE_PAGE_ADMIN)."',
		collapsible:		true,
		titleCollapse: 		true,
		collapsed:			true,
		contentEl:			'adminDivPanel',
		listeners:			{'expand': scrollPanel}
	},";
}

$sepPanel = "{
	border:			false,
	html:			'<div class=\"atm-hr\"></div>'
},";

//remove the last comma on all panels
$userPanels = substr($validationsPanel.$modulesPanels.$sepPanel.$usersPanel.$templatesPanel.$adminPanel, 0, -1);

$jscontent = <<<END
	var sidePanel = Ext.getCmp('{$winId}');
	
	var scrollPanel = function(p) {
		p.getEl().scrollIntoView(center.body);
	}
	
	var center = new Ext.Panel({
		region:				'center',
		border:				false,
		autoScroll:			true,
		bodyStyle:			'background:#F3F3F3;',
		items:[{$userPanels}]
	});
	
	// Panel for the north
	var top = new Ext.BoxComponent({
		region:			'north',
		height:			148,
		border:			false,
		el: 			'headPanel',
		listeners:{'render':function(){
			Ext.get('headPanelLogout').on('mousedown', function(){
				//remove all events on window
				Ext.EventManager.removeAll(window);
				window.location.href = '/automne/admin/?cms_action=logout';
			}, this);
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
	var openWindow = function(t, url, params, width, height) {
		var action = t.getAttributeNS('atm', 'action' );
		//create window element
		var win = new Automne.Window({
			id:				params.id || action+'Window',
			width:			width,
			height:			height,
			autoLoad:		{
				url:		url,
				params:		Ext.apply({winId:action+'Window'},params),
				nocache:	true,
				scope:		this
			}
		});
		//display window
		win.show(t);
	}
	
	if (center.body) {
		center.body.on('mousedown', doAction, null, {delegate:'a'});
	}
    var actions = {
    	'validations' : function(t){
    		openWindow(t, 'validations.php', {
				module:		t.getAttributeNS('atm', 'module'),
				editions:	t.getAttributeNS('atm', 'editions')
			}, 800, 600);
    	},
		'favorite' : function(t){
    		Automne.utils.getPageById(t.getAttributeNS('atm', 'page'));
    	},
		'archives' : function(t){
    		var window = new Automne.frameWindow({
				id:				'archiveWindow',
				frameURL:		'/automne/admin-v3/archives.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	},
		'duplicate-branch' : function(t){
    		var window = new Automne.frameWindow({
				id:				'duplicateWindow',
				frameURL:		'/automne/admin-v3/tree_duplicate_branch.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
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
					}, 800, 600);
				break;
			}
    	},
		'profile' : function(t){
    		openWindow(t, 'user.php', {
				userId:		{$cms_user->getUserId()}
			});
    	},
		'users' : function(t){
    		openWindow(t, 'users-groups.php', {
				type:		'users'
			}, 800, 600);
    	},
		'groups' : function(t){
    		openWindow(t, 'users-groups.php', {
				type:		'groups'
			}, 800, 600);
    	},
		'templates' : function(t){
    		openWindow(t, 'templates.php', {
				type:		'template'
			}, 800, 600);
		},
		'rows' : function(t){
    		openWindow(t, 'templates.php', {
				type:		'row'
			}, 800, 600);
    	},
		'styles' : function(t){
    		/*openWindow(t, 'templates.php', {
				type:		'css'
			}, 800, 600);*/
			Automne.message.show('TODOV4 : Show styles panel');
    	},
		'wysiwyg-styles' : function(t){
    		/*openWindow(t, 'templates.php', {
				type:		'wysiwyg-style'
			}, 800, 600);*/
			Automne.message.show('TODOV4 : Show wysiwyg-styles panel');
    	},
		'wysiwyg-toolbar' : function(t){
			openWindow(t, 'templates.php', {
				type:		'wysiwyg-toolbar'
			}, 800, 600);
    	},
		'modules' : function(t){
    		var window = new Automne.frameWindow({
				id:				'modulesWindow',
				frameURL:		'/automne/admin-v3/modules_admin.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	},
		'scripts' : function(t){
    		var window = new Automne.frameWindow({
				id:				'scriptsWindow',
				frameURL:		'/automne/admin-v3/meta_admin.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	},
		'logs' : function(t){
    		var window = new Automne.frameWindow({
				id:				'logsWindow',
				frameURL:		'/automne/admin-v3/logs.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	},
		'websites' : function(t){
    		var window = new Automne.frameWindow({
				id:				'websitesWindow',
				frameURL:		'/automne/admin-v3/websites.php',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	},
		'languages' : function(t){
    		Automne.message.show('TODOV4 : Show languages panel');
    	},
		'server' : function(t){
    		openWindow(t, 'server.php', {}, 800, 600);
    	},
		'parameters' : function(t){
    		var window = new Automne.frameWindow({
				id:				'parametersWindow',
				frameURL:		'/automne/admin-v3/module_parameters.php?module=standard',
				allowFrameNav:	true,
				width:			750,
				height:			580,
				animateTarget:	t
			});
			window.show();
    	}
    };
	
	//over on disconnect button
	Ext.get('headPanelLogout').addClassOnOver('over');
	
END;
$view->addJavascript($jscontent);


//send content
$view->setContent($content);
$view->show();
?>