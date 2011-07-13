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
// $Id: templates-files.php,v 1.6 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP page : Load module categories tree window.
  * Used accross an Ajax request. Render categories tree for a given module.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_MODIFY", 938);
define("MESSAGE_PAGE_DELETE", 252);
define("MESSAGE_PAGE_NEW", 262);
define("MESSAGE_PAGE_DEPTH_DISPLAYED", 685);
define("MESSAGE_PAGE_WEBSITES_CSS", 1496);
define("MESSAGE_PAGE_WEBSITES_JS", 1497);
define("MESSAGE_PAGE_DELETE_CONFIRM", 1498);
define("MESSAGE_PAGE_DELETE_WARNING", 1499);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$fatherId = sensitiveIO::request('fatherId');

if (!$winId) {
	CMS_grandFather::raiseError('Unknown window Id ...');
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	CMS_grandFather::raiseError('User has no rights on page templates ...');
	$view->show();
}

$jscontent = <<<END
	var moduleCSSWindow = Ext.getCmp('{$winId}');
	var fatherWindow = Ext.getCmp('{$fatherId}');
	//do not allow change of maxDepth before layout is completely done
	var allowChangeMaxdepth = false;
	
	var CSSWindows = [];
	
	var tree = new Ext.tree.TreePanel({
		autoScroll:		true,
        animate:		true,
        region:			'center',
		border:			false,
		enableDD:		false,
        containerScroll:true,
		rootVisible: false,
		loader: new Automne.treeLoader({
			dataUrl:		'templates-files-nodes.php',
			baseParams: {
				maxDepth:		2
			}
		}),
		root: {
            nodeType:		'async',
            draggable:		false,
            id:				'source',
			expanded:		true
        },
		listeners:{
			'click':function(node, e) {
				Ext.getCmp('atmFileEdit').setDisabled(!node.isLeaf() || node.id == 'source');
				Ext.getCmp('atmFileCreate').setDisabled(node.isLeaf());
				Ext.getCmp('atmFileDelete').setDisabled(!node.attributes.deletable || node.id == 'source');
			},
			scope:this
		},
		tbar:[{
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
		},'-',{
			id:				'atmFileEdit',
			iconCls:		'atm-pic-modify',
			xtype:			'button',
			text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_MODIFY)}',
			disabled:		true,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				var fileId = node.id;
				if (CSSWindows[node.id]) {
					Ext.WindowMgr.bringToFront(CSSWindows[node.id]);
				} else {
					//create window element
					CSSWindows[node.id] = new Automne.Window({
						id:				'fileWindow'+fileId,
						modal:			false,
						father:			fatherWindow,
						allowFrameNav:	true,
						width:			750,
						height:			580,
						animateTarget:	button.getEl(),
						autoLoad:		{
							url:			'templates-file.php',
							params:			{
								winId:			'fileWindow'+fileId,
								node:			fileId
							},
							nocache:		true,
							scope:			this
						},
						listeners:{
							'close':function(win){
								delete CSSWindows[node.id];
								//reload parent category
								if (node.parentNode.reload) {
									node.parentNode.reload();
								}
							},
							scope:this
						}
					});
					//display window
					CSSWindows[node.id].show(button.getEl());
				}
			},
			scope:this
		},{
			id:				'atmFileDelete',
			iconCls:		'atm-pic-deletion',
			xtype:			'button',
			text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_DELETE)}',
			disabled:		true,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				Automne.message.popup({
					msg: 				'{$cms_language->getJsMessage(MESSAGE_PAGE_DELETE_CONFIRM)} \''+node.attributes.text+'\' ?<br />{$cms_language->getJsMessage(MESSAGE_PAGE_DELETE_WARNING)}',
					buttons: 			Ext.MessageBox.OKCANCEL,
					animEl: 			button.getEl(),
					closable: 			false,
					icon: 				Ext.MessageBox.WARNING,
					fn: 				function (button) {
						if (button == 'ok') {
							//pr(node);
							Automne.server.call({
								url:				'templates-files-controler.php',
								params: 			{
									action:			'delete',
									node:			node.id
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
			id:				'atmFileCreate',
			iconCls:		'atm-pic-add',
			xtype:			'button',
			text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_NEW)}',
			disabled:		true,
			handler:		function(button) {
				var node = tree.getSelectionModel().getSelectedNode();
				//create window element
				CSSWindows['createFile'] = new Automne.Window({
					id:				'fileWindowCreate',
					modal:			false,
					father:			fatherWindow,
					width:			750,
					height:			580,
					animateTarget:	button.getEl(),
					autoLoad:		{
						url:			'templates-file.php',
						params:			{
							winId:			'fileWindowCreate',
							node:			node.id
						},
						nocache:		true,
						scope:			this
					},
					listeners:{
						'close':function(win){
							delete CSSWindows['createFile'];
							//reload category
							if (node.reload) {
								node.reload();
							} else if (node.parentNode.reload) {
								node.parentNode.reload();
							}
							//enable button to allow creation of a other users
							Ext.getCmp('atmFileCreate').enable();
						},
						scope:this
					}
				});
				//display window
				CSSWindows['createFile'].show(button.getEl());
				//disable button to avoid creation of a second user
				button.disable();
			},
			scope:this
		}]
    });
	//add tree to window
	moduleCSSWindow.add(tree);
	
	// render the tree
    tree.getRootNode().expand();
	//allow change max depth after layout only
	moduleCSSWindow.on('afterlayout', function(){
		allowChangeMaxdepth = true;
	}, this);
	
	//redo windows layout
	moduleCSSWindow.doLayout();
	
END;
$view->addJavascript($jscontent);
$view->show();
?>