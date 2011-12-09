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

/**
  * PHP page : Load module alias tree window.
  * Used accross an Ajax request. Render aliases tree for a given module.
  * 
  * @package Automne
  * @subpackage cms_aliases
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$fatherId = sensitiveIO::request('fatherId');
$pageId = sensitiveIO::request('page', 'io::isPositiveInteger');

//Standard messages
define("MESSAGE_ERROR_MODULE_RIGHTS",570);
define("MESSAGE_PAGE_MODIFY", 938);
define("MESSAGE_PAGE_DELETE", 252);
define("MESSAGE_PAGE_NEW", 262);
define("MESSAGE_PAGE_DEPTH_DISPLAYED", 685);

//Specific Alias message
define("MESSAGE_PAGE_ALIASES_DESC", 26);
define("MESSAGE_PAGE_WEBSITE_ROOT", 27);
define("MESSAGE_PAGE_CONFIRM_ALIAS_DELETION", 28);
define("MESSAGE_PAGE_PAGE_ALIASES_DESC", 39);

if (!$winId) {
	CMS_grandFather::raiseError('Unknown window Id ...');
	$view->show();
}
//load module
$codename = 'cms_aliases';
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module) {
	CMS_grandFather::raiseError('Unknown module or module for codename : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}

$moduleLabel = sensitiveIO::sanitizeJSString(io::htmlspecialchars($module->getLabel($cms_language)));

$realRootPath = PATH_REALROOT_WR;
$nodesURL = PATH_ADMIN_MODULES_WR.'/'.$codename.'/nodes.php';
$controlerURL = PATH_ADMIN_MODULES_WR.'/'.$codename.'/controler.php';
$editURL = PATH_ADMIN_MODULES_WR.'/'.$codename.'/alias.php';
if ($pageId) {
	$panelTitle = $cms_language->getJsMessage(MESSAGE_PAGE_PAGE_ALIASES_DESC, false, "cms_aliases");
	$depthToolbar = '';
} else {
	$panelTitle = $cms_language->getJsMessage(MESSAGE_PAGE_ALIASES_DESC, false, "cms_aliases");
	$depthToolbar = "{
			xtype:			'tbtext',
			text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_DEPTH_DISPLAYED)}'
		},{
			xtype:			'numberfield',
			value:			2,
			width:			30,
			allowBlank:		false,
			allowDecimals:	false,
			allowNegative:	false,
			maxValue:		9,
			minValue:		2,
			maxLength:		1,
			listeners:		{
				'valid':	function(field) {
					//reload tree only if field value change
					if (allowChangeMaxdepth && tree.getLoader().baseParams.maxDepth != field.getValue()) {
						tree.getLoader().baseParams.maxDepth = field.getValue();
						tree.getRootNode().reload();
					}
				},
				scope:this
			}
		},'-',";
}
$jscontent = <<<END
	var moduleAliasWindow = Ext.getCmp('{$winId}');
	var fatherWindow = Ext.getCmp('{$fatherId}');
	//do not allow change of maxDepth before layout is completely done
	var allowChangeMaxdepth = false;
	
	var aliasWindows = [];
	
	var tree = new Ext.tree.TreePanel({
		title:			'{$panelTitle}',
		autoScroll:		true,
        animate:		true,
        region:			'center',
		border:			false,
		enableDD:		false,
        containerScroll:true,
		loader: new Automne.treeLoader({
			dataUrl:		'{$nodesURL}',
			baseParams: {
				maxDepth:		2,
				page:			'{$pageId}'
			}
		}),
        root: {
            nodeType:		'async',
            text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_WEBSITE_ROOT, false, "cms_aliases")} {$realRootPath}/',
            draggable:		false,
            id:				'source',
			expanded:		true,
			deletable:		false,
			manageable:		false
        },
		listeners:{
			'click':function(node, e) {
				Ext.getCmp('{$codename}Edit').setDisabled(node.disabled || node.attributes.protected || node.id == 'source');
				Ext.getCmp('{$codename}Create').setDisabled(!node.attributes.manageable && node.id != 'source');
				Ext.getCmp('{$codename}Delete').setDisabled(!node.attributes.deletable);
			},
			'beforemovenode':function(tree, node, oldParent, newParent, index) {
				Automne.server.call({
					url:				'{$controlerURL}',
					params: 			{
						action:			'move',
						alias:			node.attributes.aliasId,
						newParent:		newParent.attributes.aliasId,
						index:			index
					},
					fcnCallback: 		function(response, options, jsonResponse) {
						//reload parents
						if (oldParent.reload) {
							oldParent.reload();
						}
						if (newParent.reload) {
							newParent.reload();
						} else if (newParent.parentNode && newParent.parentNode.reload) {
							newParent.parentNode.reload();
						}
					},
					callBackScope:		this
				});
			},
			scope:this
		},
		tbar:[{$depthToolbar}{
			id:				'{$codename}Edit',
			iconCls:		'atm-pic-modify',
			xtype:			'button',
			text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_MODIFY)}',
			disabled:		true,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				if (!node) {
					button.disable();
					return;
				}
				var aliasId = node.attributes.aliasId;
				if (aliasWindows[node.id]) {
					Ext.WindowMgr.bringToFront(aliasWindows[node.id]);
				} else {
					//create window element
					aliasWindows[node.id] = new Automne.Window({
						id:				'aliasWindow'+aliasId,
						modal:			false,
						father:			fatherWindow,
						allowFrameNav:	true,
						aliasId:		aliasId,
						width:			750,
						height:			580,
						animateTarget:	button.getEl(),
						autoLoad:		{
							url:			'{$editURL}',
							params:			{
								winId:			'aliasWindow'+aliasId,
								alias:			aliasId,
								page:			'{$pageId}'
							},
							nocache:		true,
							scope:			this
						},
						listeners:{
							'close':function(win){
								delete aliasWindows[node.id];
								//reload parent alias
								if (node.parentNode.reload) {
									node.parentNode.reload();
								}
							},
							scope:this
						}
					});
					//display window
					aliasWindows[node.id].show(button.getEl());
				}
			},
			scope:this
		},{
			id:				'{$codename}Delete',
			iconCls:		'atm-pic-deletion',
			xtype:			'button',
			text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_DELETE)}',
			disabled:		true,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				if (!node) {
					button.disable();
					return;
				}
				Automne.message.popup({
					msg: 				'{$cms_language->getJsMessage(MESSAGE_PAGE_CONFIRM_ALIAS_DELETION, false, "cms_aliases")} \''+node.attributes.text+'\' ?',
					buttons: 			Ext.MessageBox.OKCANCEL,
					animEl: 			button.getEl(),
					closable: 			false,
					icon: 				Ext.MessageBox.QUESTION,
					fn: 				function (button) {
						if (button == 'ok') {
							Automne.server.call({
								url:				'{$controlerURL}',
								params: 			{
									action:			'delete',
									alias:			node.attributes.aliasId
								},
								fcnCallback: 		function(response, options, jsonResponse) {
									if (jsonResponse.success == true) {
										//if success, reload parent
										if (node.parentNode.reload) {
											node.parentNode.reload();
										}
									}
								},
								callBackScope:		this
							});
						}
					}
				});
			},
			scope:this
		},'->',{
			id:				'{$codename}Create',
			iconCls:		'atm-pic-add',
			xtype:			'button',
			text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_NEW)}',
			disabled:		false,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				if (!node) {
					button.disable();
					return;
				}
				//create window element
				aliasWindows['createAlias'] = new Automne.Window({
					id:				'aliasWindowCreate',
					modal:			false,
					father:			fatherWindow,
					allowFrameNav:	true,
					aliasId:		'',
					width:			750,
					height:			580,
					animateTarget:	button.getEl(),
					autoLoad:		{
						url:			'{$editURL}',
						params:			{
							winId:			'aliasWindowCreate',
							fatherId:		node.attributes.aliasId,
							page:			'{$pageId}'
						},
						nocache:		true,
						scope:			this
					},
					listeners:{
						'close':function(win){
							delete aliasWindows['createAlias'];
							//reload alias
							if (node.reload) {
								node.reload();
							} else if (node.parentNode.reload) {
								node.parentNode.reload();
							}
							//enable button to allow creation of a other users
							Ext.getCmp('{$codename}Create').enable();
						},
						scope:this
					}
				});
				//display window
				aliasWindows['createAlias'].show(button.getEl());
				//disable button to avoid creation of a second user
				button.disable();
			},
			scope:this
		}]
    });
	//add tree to window
	moduleAliasWindow.add(tree);
	
	//add fake update method
	moduleAliasWindow.updateTab = function() {}
	
	// render the tree
    tree.getRootNode().expand();
	
	//allow change max depth after layout only
	moduleAliasWindow.on('afterlayout', function(){
		allowChangeMaxdepth = true;
		tree.getRootNode().select();
	}, this);
	
	//redo windows layout
	moduleAliasWindow.doLayout();
	
END;
$view->addJavascript($jscontent);
$view->show();
?>