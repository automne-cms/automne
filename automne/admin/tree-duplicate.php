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
// $Id: tree-duplicate.php,v 1.1 2009/06/05 15:01:05 sebastien Exp $

/**
  * PHP page : Load duplicate branch backend window
  * Used accross an Ajax request
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_TOOLBAR_HELP",1073);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

$winId = sensitiveIO::request('winId');

//CHECKS user has duplication clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH)) {
	CMS_grandFather::raiseError('User has no rights to duplicate branch...');
	$view->setActionMessage('Vous n\'avez pas le droit de dupliquer les branches d\'arborescences.');
	$view->show();
}

$jscontent = <<<END
	var duplicateWindow = Ext.getCmp('{$winId}');
	//set window title
	duplicateWindow.setTitle('Duplication de branches d\'arborescence.');
	//set help button on top of page
	duplicateWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		duplicateWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'Cette page vous permet de dupliquer une branche complète de l\'arborescence de pages. Toutes les pages de la branche sélectionnée seront recréées avec leurs contenus sous la page que vous désignerez.',
		dismissDelay:	0
	});
	
	var onclickFrom = 'this.node.select();Ext.getCmp(\'{$winId}\').pageFrom = \'%s\';Ext.getCmp(\'{$winId}\').validateDuplication();';
	var onclickTo = 'this.node.select();Ext.getCmp(\'{$winId}\').pageTo = \'%s\';Ext.getCmp(\'{$winId}\').validateDuplication();';
	
	duplicateWindow.pageFrom = duplicateWindow.pageTo = '';
	
	duplicateWindow.validateDuplication = function() {
		if (!(isNaN(parseInt(duplicateWindow.pageFrom)) || isNaN(parseInt(duplicateWindow.pageTo)))) {
			Ext.getCmp('duplicateButton').enable();
		}
	}
	
	//create center panel
	var center = new Ext.Panel({
        region:				'center',
		border:				false,
		layout:				'hbox',
		layoutConfig: {
			align : 'stretch',
			pack  : 'start'
		},
		items:[{
			xtype:		'atmPanel',
			id:			'pageFromDuplicate',
			flex:		1,
			autoScroll:	true,
			autoLoad:		{
				url:		'tree.php',
				params:		{
					winId:		'pageFromDuplicate',
					root:		'1',
					hideMenu:	true,
					window:		false,
					editable:	true,
					onClick:	onclickFrom,
					heading:	'Choisissez la branche à dupliquer'
				},
				nocache:	true,
				scope:		this
			}
		},{
			xtype:		'atmPanel',
			id:			'pageToDuplicate',
			flex:		1,
			autoScroll:	true,
			autoLoad:		{
				url:		'tree.php',
				params:		{
					winId:		'pageToDuplicate',
					root:		'1',
					hideMenu:	true,
					window:		false,
					editable:	true,
					onClick:	onclickTo,
					heading:	'Choisissez la page de destination'
				},
				nocache:	true,
				scope:		this
			}
		}],
		buttons:[{
			id:			'duplicateButton',
			text:		'Dupliquer',
			disabled:	true,
			handler:	function(button) {
				//get duplicate infos
				var treeFrom = Ext.getCmp('treePanelpageFromDuplicate');
				var treeTo = Ext.getCmp('treePanelpageToDuplicate');
				var pageFrom = treeFrom.selModel.getSelectedNode().id.substr(4);
				var pageFromLabel = treeFrom.selModel.getSelectedNode().text;
				var pageTo = treeTo.selModel.getSelectedNode().id.substr(4);
				var pageToLabel = treeTo.selModel.getSelectedNode().text;
				
				var message = 'Vous allez dupliquer l\'ensemble des pages (ainsi que leur contenu) se trouvant sous la page '+pageFromLabel+'.<br /><br />La page sous laquelle seront recréées les pages dupliquées sera '+pageToLabel+'.<br /><br />Confirmez-vous cette opération ?';
				
				Automne.message.popup({
					msg: 				message,
					buttons: 			Ext.MessageBox.OKCANCEL,
					animEl: 			button,
					closable: 			false,
					icon: 				Ext.MessageBox.QUESTION,
					scope:				{
						pageFrom:		pageFrom,
						pageTo:			pageTo
					},
					fn: 				function (button) {
						if (button == 'ok') {
							Automne.server.call({
								url:				'page-controler.php',
								params: 			{
									pageFrom:			this.pageFrom,
									pageTo:				this.pageTo,
									action:				'tree-duplicate'
								}
							});
							duplicateWindow.close();
						}
					}
				});
			},
			scope:		duplicateWindow
		}]
    });
	
	duplicateWindow.add(center);
	//redo windows layout
	duplicateWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>