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
// $Id: modules-categories.php,v 1.4 2009/06/09 13:42:57 sebastien Exp $

/**
  * PHP page : Load module categories tree window.
  * Used accross an Ajax request. Render categories tree for a given module.
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

$winId = sensitiveIO::request('winId');
$fatherId = sensitiveIO::request('fatherId');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());

//Standard messages
define("MESSAGE_ERROR_MODULE_RIGHTS",570);

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
if (!$winId) {
	CMS_grandFather::raiseError('Unknown window Id ...');
	$view->show();
}
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module) {
	CMS_grandFather::raiseError('Unknown module or module for codename : '.$codename);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_message->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->show();
}

$moduleLabel = sensitiveIO::sanitizeJSString($module->getLabel($cms_language));

$jscontent = <<<END
	var moduleCategoriesWindow = Ext.getCmp('{$winId}');
	var fatherWindow = Ext.getCmp('{$fatherId}');
	//do not allow change of maxDepth before layout is completely done
	var allowChangeMaxdepth = false;
	
	var categoryWindows = [];
	
	var tree = new Ext.tree.TreePanel({
		title:			'Glissez déposez les catégories pour les réorganiser',
		autoScroll:		true,
        animate:		true,
        region:			'center',
		border:			false,
		enableDD:		true,
        containerScroll:true,
		loader: new Automne.treeLoader({
			dataUrl:		'modules-categories-nodes.php',
			baseParams: {
				module:			'{$codename}',
				maxDepth:		2
			}
		}),
        root: {
            nodeType:		'async',
            text:			'Catégories du module {$moduleLabel}',
            draggable:		false,
            id:				'source',
			expanded:		true,
			deletable:		false,
			manageable:		false
        },
		listeners:{
			'click':function(node, e) {
				Ext.getCmp('{$codename}CatsEdit').setDisabled(node.disabled || node.id == 'source');
				Ext.getCmp('{$codename}CatsCreate').setDisabled(!node.attributes.manageable && node.id != 'source');
				Ext.getCmp('{$codename}CatsDelete').setDisabled(!node.attributes.deletable);
			},
			'beforemovenode':function(tree, node, oldParent, newParent, index) {
				/*if (oldParent == newParent) {
					return false;
				}*/
				Automne.server.call({
					url:				'modules-categories-controler.php',
					params: 			{
						action:			'move',
						category:		node.attributes.catId,
						newParent:		newParent.attributes.catId,
						index:			index,
						module:			'{$codename}'
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
		tbar:[{
			xtype:			'tbtext',
			text:			'Profondeur affichée'
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
		},'-',{
			id:				'{$codename}CatsEdit',
			xtype:			'button',
			text:			'Modifier',
			disabled:		true,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				if (!node) {
					button.disable();
					return;
				}
				var categoryId = node.attributes.catId;
				if (categoryWindows[node.id]) {
					Ext.WindowMgr.bringToFront(categoryWindows[node.id]);
				} else {
					//create window element
					categoryWindows[node.id] = new Automne.Window({
						id:				'catWindow'+categoryId,
						modal:			false,
						father:			fatherWindow,
						allowFrameNav:	true,
						categoryId:		categoryId,
						width:			750,
						height:			580,
						animateTarget:	button.getEl(),
						autoLoad:		{
							url:			'modules-category.php',
							params:			{
								winId:			'catWindow'+categoryId,
								category:		categoryId,
								module:			'{$codename}'
							},
							nocache:		true,
							scope:			this
						},
						listeners:{
							'close':function(win){
								delete categoryWindows[node.id];
								//reload parent category
								if (node.parentNode.reload) {
									node.parentNode.reload();
								}
							},
							scope:this
						}
					});
					//display window
					categoryWindows[node.id].show(button.getEl());
				}
			},
			scope:this
		},{
			id:				'{$codename}CatsDelete',
			xtype:			'button',
			text:			'Supprimer',
			disabled:		true,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				if (!node) {
					button.disable();
					return;
				}
				Automne.message.popup({
					msg: 				'Confirmer la suppression de la catégorie \''+node.attributes.text+'\' ?',
					buttons: 			Ext.MessageBox.OKCANCEL,
					animEl: 			button.getEl(),
					closable: 			false,
					icon: 				Ext.MessageBox.QUESTION,
					fn: 				function (button) {
						if (button == 'ok') {
							Automne.server.call({
								url:				'modules-categories-controler.php',
								params: 			{
									action:			'delete',
									category:		node.attributes.catId,
									module:			'{$codename}'
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
			id:				'{$codename}CatsCreate',
			xtype:			'button',
			text:			'Nouveau',
			disabled:		true,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				if (!node) {
					button.disable();
					return;
				}
				//create window element
				categoryWindows['createCat'] = new Automne.Window({
					id:				'catWindowCreate',
					modal:			false,
					father:			fatherWindow,
					allowFrameNav:	true,
					categoryId:		'',
					width:			750,
					height:			580,
					animateTarget:	button.getEl(),
					autoLoad:		{
						url:			'modules-category.php',
						params:			{
							winId:			'catWindowCreate',
							fatherId:		node.attributes.catId,
							module:			'{$codename}'
						},
						nocache:		true,
						scope:			this
					},
					listeners:{
						'close':function(win){
							delete categoryWindows['createCat'];
							//reload category
							if (node.reload) {
								node.reload();
							} else if (node.parentNode.reload) {
								node.parentNode.reload();
							}
							//enable button to allow creation of a other users
							Ext.getCmp('{$codename}CatsCreate').enable();
						},
						scope:this
					}
				});
				//display window
				categoryWindows['createCat'].show(button.getEl());
				//disable button to avoid creation of a second user
				button.disable();
			},
			scope:this
		}]
    });
	//add tree to window
	moduleCategoriesWindow.add(tree);
	
	// render the tree
    tree.getRootNode().expand();
	//allow change max depth after layout only
	moduleCategoriesWindow.on('afterlayout', function(){
		allowChangeMaxdepth = true;
	}, this);
	
	//redo windows layout
	moduleCategoriesWindow.doLayout();
	
END;
$view->addJavascript($jscontent);
$view->show();
?>