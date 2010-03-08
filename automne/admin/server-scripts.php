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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: server-scripts.php,v 1.7 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP page : Load server detail window.
  * Used accross an Ajax request. Render server informations.
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

$winId = sensitiveIO::request('winId', '', 'scriptsWindow');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_NO_SERVER_RIGHTS",748);
define("MESSAGE_PAGE_REGENERATION",770);
define("MESSAGE_PAGE_REGENERATION_DESC",771);
define("MESSAGE_PAGE_SCRIPTS_IN_PROGRESS",772);
define("MESSAGE_PAGE_SCRIPTS_IN_PROGRESS_DESC",773);
define("MESSAGE_PAGE_SCRIPTS_MANAGEMENT",774);
define("MESSAGE_TOOLBAR_HELP_DESC",775);
define("MESSAGE_PAGE_REGEN_ALL",776);
define("MESSAGE_PAGE_REGEN_ALL_DESC",777);
define("MESSAGE_PAGE_REGEN_TREE",778);
define("MESSAGE_PAGE_REGEN_TREE_DESC",779);
define("MESSAGE_PAGE_REGEN_TREE_SELECT",780);
define("MESSAGE_PAGE_REGEN_SELECTED",781);
define("MESSAGE_PAGE_REGEN_SELECTED_DESC",782);
define("MESSAGE_PAGE_REGEN_SELECT_PAGES",783);
define("MESSAGE_PAGE_REGEN_TREE_SELECT_DEST",784);
define("MESSAGE_PAGE_REGEN",785);
define("MESSAGE_PAGE_RESTART_SCRIPTS",786);
define("MESSAGE_PAGE_RESTART_SCRIPTS_DESC",787);
define("MESSAGE_PAGE_STOP_SCRIPTS",788);
define("MESSAGE_PAGE_STOP_SCRIPTS_DESC",789);
define("MESSAGE_PAGE_CLEAR_QUEUE",790);
define("MESSAGE_PAGE_CLEAR_QUEUE_DESC",791);
define("MESSAGE_PAGE_SCRIPTS_DETAIL",792);
define("MESSAGE_PAGE_QUEUE_DETAIL",793);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

//CHECKS user has scripts admin clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
	CMS_grandFather::raiseError('User has no regeneration rights');
	$view->setActionMessage($cms_language->getMessage(MESSAGE_PAGE_NO_SERVER_RIGHTS));
	$view->show();
}
//Scripts content
$content = '
	<h1>'.$cms_language->getMessage(MESSAGE_PAGE_REGENERATION).'</h1>
	<div style="width:100%;">
		'.$cms_language->getMessage(MESSAGE_PAGE_REGENERATION_DESC).'<br /><br />
		<div id="regeneratePages"></div>
		<br />
		<table cellspacing="5">
			<tr>
				<td id="regenerateAll"></td>
				<td id="regenerateTree"></td>
			</tr>
		</table>
		<br />
		<h1>'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_IN_PROGRESS).'</h1>
		'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_IN_PROGRESS_DESC).'<br /><br />
		<table cellspacing="5">
			<tr>
				<td id="scriptsRestart"></td>
				<td id="scriptsStop"></td>
				<td id="scriptsClear"></td>
			</tr>
		</table><br />
		
		<div style="height:35px;"><div id="scriptsProgress" style="height:30px;"></div></div><br />
		<div id="scriptsDetail"></div><br />
		<div id="scriptsQueue"></div>
	</div>
';
$content = sensitiveIO::sanitizeJSString($content);

$jscontent = <<<END
	var serverWindow = Ext.getCmp('{$winId}');
	//set window title
	serverWindow.setTitle('{$cms_language->getJsMessage(MESSAGE_PAGE_SCRIPTS_MANAGEMENT)}');
	//set help button on top of page
	serverWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 serverWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC)}',
		dismissDelay:	0
	});
	
	//create objects
	var progressScripts = new Ext.ProgressBar({
		id:				'scriptsProgressBar'
    });
	var regenerateAll = new Ext.Button({
		id:				'regenerateAll',
		text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_ALL)}',
		tooltip:		'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_ALL_DESC)}',
		listeners:		{'click':function(){
			Automne.server.call({
				url:				'server-scripts-controler.php',
				params: 			{
					action:				'regenerate-all'
				}
			});
		},scope:this}
    });
	var regenerateTree = new Ext.Button({
		id:				'regenerateTree',
		text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_TREE)}',
		tooltip:		'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_TREE_DESC)}',
		listeners:		{'click':function(e){
			var winid = Ext.id();
			var onclick = 'Automne.server.call({url:\'server-scripts-controler.php\',params:{action:\'regenerate-tree\',page:\'%s\'}});Ext.getCmp(\''+winid+'\').close();';
			//create window element
			var win = new Automne.Window({
				id:				winid,
				autoLoad:		{
					url:		'tree.php',
					params:		{
						winId:			winid,
						title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_TREE)}',
						heading:		'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_TREE_SELECT)}',
						onClick:		onclick,
						currentPage:	1
					},
					nocache:	true,
					scope:		this
				}
			});
			//display window
			win.show(e);
		},scope:this}
    });
	var regeneratePages = new Ext.form.FieldSet({
		title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_SELECTED)}',
		collapsed:		false,
		width:			'97%',
		autoScroll:		true,
		layout: 		'form',
		labelWidth:		120,
		buttonAlign:	'center',
		keys: {
			key: 			Ext.EventObject.ENTER,
			scope:			this,
			handler:		function() {
				var field = Ext.getCmp('regeneratePagesField');
				if (field.getValue()) {
					Automne.server.call({
						url:				'server-scripts-controler.php',
						params: 			{
							action:				'regenerate-pages',
							pages:				field.getValue()
						}
					});
				}
			}
		},
		items:[{
			anchor:			'97%',
			xtype:			'atmPageField',
			id:				'regeneratePagesField',
			fieldLabel:		'<span class="atm-help" ext:qtip="{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_SELECTED_DESC)}">{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_SELECT_PAGES)}</span>',
			name:			'page',
			value:			'',
			validateOnBlur:	false,
			baseChars:		'01231456789,-',
			setValue : function(v){
				Ext.form.NumberField.superclass.setValue.call(this, v);
			},
			validateValue : function(value){
		        return Ext.form.NumberField.superclass.validateValue.call(this, value);
		    },
			parseValue : function(value){
		        return value;
		    },
			fixPrecision : function(value){
				return value;
			},
			selectPages: function() {
				var onclick = 'var el = Ext.get(\''+this.el.id+'\');'+
					'var value = \'%s\';'+
					'el.dom.value = !el.dom.value ? value : el.dom.value +\',\'+ value;'+
					'el.highlight("C3CD31", {duration: 2 });'+
					'Ext.getCmp(\''+this.id+'\').validate();'+
					'Ext.getCmp(\'pagesTree\').close();';
				var win = new Automne.Window({
					id:				'pagesTree',
					currentPage:	this.getValue() || this.root,
					autoLoad:		{
						url:		'tree.php',
						params:		{
							winId:			'pagesTree',
							heading:		'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN_TREE_SELECT_DEST)}',
							onClick:		onclick,
							currentPage:	this.getValue() || this.root
						},
						nocache:	true,
						scope:		this
					}
				});
				//display window
				win.show(this.el.id);
			}
		}],
		buttons:[{
			text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_REGEN)}',
			scope:			this,
			anchor:			'',
			handler:		function() {
				var field = Ext.getCmp('regeneratePagesField');
				if (field.getValue()) {
					Automne.server.call({
						url:				'server-scripts-controler.php',
						params: 			{
							action:				'regenerate-pages',
							pages:				field.getValue()
						}
					});
				}
			}
		}]
	});
	
	var scriptsRestart = new Ext.Button({
		id:				'scriptsRestart',
		text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_RESTART_SCRIPTS)}',
		tooltip:		'{$cms_language->getJsMessage(MESSAGE_PAGE_RESTART_SCRIPTS_DESC)}',
		listeners:		{'click':function(){
			Automne.server.call({
				url:				'server-scripts-controler.php',
				params: 			{
					action:				'restart-scripts'
				}
			});
		},scope:this}
    });
	var scriptsStop = new Ext.Button({
		id:				'scriptsStop',
		text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_STOP_SCRIPTS)}',
		tooltip:		'{$cms_language->getJsMessage(MESSAGE_PAGE_STOP_SCRIPTS_DESC)}',
		listeners:		{'click':function(){
			Automne.server.call({
				url:				'server-scripts-controler.php',
				params: 			{
					action:				'stop-scripts'
				}
			});
		},scope:this}
    });
	var scriptsClear = new Ext.Button({
		id:				'scriptsClear',
		text:			'{$cms_language->getJsMessage(MESSAGE_PAGE_CLEAR_QUEUE)}',
		tooltip:		'{$cms_language->getJsMessage(MESSAGE_PAGE_CLEAR_QUEUE_DESC)}',
		listeners:		{'click':function(){
			Automne.server.call({
				url:				'server-scripts-controler.php',
				params: 			{
					action:				'clear-scripts'
				}
			});
		},scope:this}
    });
	var scriptsDetail = new Ext.form.FieldSet({
		title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_SCRIPTS_DETAIL)}',
		collapsible:	true,
		collapsed:		true,
		height:			100,
		autoScroll:		true,
		html:			'<div id="scriptsDetailText"></div>',
		listeners:{
			'beforeexpand':function(){
				Automne.view.getScriptsDetails = true;
			},
			'beforecollapse': function(){
				Automne.view.getScriptsDetails = false;
			},
			scope:this
		}
	});
	var scriptsQueue = new Ext.form.FieldSet({
		title:			'{$cms_language->getJsMessage(MESSAGE_PAGE_QUEUE_DETAIL)}',
		collapsible:	true,
		collapsed:		true,
		height:			200,
		autoScroll:		true,
		html:			'<div id="scriptsQueueText"></div>',
		listeners:{
			'beforeexpand':function(){
				Automne.view.getScriptsQueue = true;
			},
			'beforecollapse': function(){
				Automne.view.getScriptsQueue = false;
			},
			scope:this
		}
	});
	
	//create center panel
	var center = new Ext.Panel({
		activeTab:			 0,
		id:					'serverScriptsPanels',
		region:				'center',
		border:				false,
		autoScroll:			true,
		bodyStyle: 			'padding:5px',
		html:				'$content',
		listeners:			{
			'bodyresize':function(){
				if (!regenerateAll.rendered) {
					regenerateAll.render('regenerateAll');
				}
				if (!regenerateTree.rendered) {
					regenerateTree.render('regenerateTree');
				}
				if (!regeneratePages.rendered) {
					regeneratePages.render('regeneratePages');
				}
				if (!scriptsRestart.rendered) {
					scriptsRestart.render('scriptsRestart');
				}
				if (!scriptsStop.rendered) {
					scriptsStop.render('scriptsStop');
				}
				if (!scriptsClear.rendered) {
					scriptsClear.render('scriptsClear');
				}
				if (!scriptsDetail.rendered) {
					scriptsDetail.render('scriptsDetail');
				}
				if (!scriptsQueue.rendered) {
					scriptsQueue.render('scriptsQueue');
				}
				if (!progressScripts.rendered) {
					progressScripts.on('afterrender', function(){
						Automne.view.updateScriptBars();
					}, this);
					progressScripts.render('scriptsProgress');
				}
				
			},
			scope:this}
	});
	serverWindow.add(center);
	//redo windows layout (timeout is for IE)
	setTimeout(function(){serverWindow.doLayout();}, 100);
	serverWindow.on({
		'beforeclose':function(){
			Automne.view.getScriptsDetails = false;
			Automne.view.getScriptsQueue = false;
		},
		scope:this
	});
END;
$view->addJavascript($jscontent);
$view->show();
?>