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
// $Id: server-scripts.php,v 1.2 2009/04/10 15:26:41 sebastien Exp $

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

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//CHECKS user has scripts admin clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
	CMS_grandFather::raiseError('User has no regeneration rights');
	$view->setActionMessage('Vous n\'avez pas les droits d\'administrer les scripts ...');
	$view->show();
}
//Scripts content
$content = '
	<h1>Régénération des pages : </h1>
	Permet recréer les pages visibles coté client des différents sites.<br /><br />
	<div id="regeneratePages"></div>
	<br />
	<table cellspacing="5">
		<tr>
			<td id="regenerateAll"></td>
			<td id="regenerateTree"></td>
		</tr>
	</table>
	<br />
	<h1>Scripts en cours : </h1>
	Permet de visualiser les scripts en cours de traitement sur le serveur.<br /><br />
	<table cellspacing="5">
		<tr>
			<td id="scriptsRestart"></td>
			<td id="scriptsStop"></td>
			<td id="scriptsClear"></td>
		</tr>
	</table><br />
	<div id="scriptsProgress"></div><br />
	<div id="scriptsDetail"></div><br />
	<div id="scriptsQueue"></div>
';
$content = sensitiveIO::sanitizeJSString($content);

$jscontent = <<<END
	var serverWindow = Ext.getCmp('{$winId}');
	//set window title
	serverWindow.setTitle('Gestion des scripts');
	//set help button on top of page
	serverWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 serverWindow.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 'Cette page vous permet de gérer les différents scripts en tâche de fond ainsi que la régénération des pages du site. Régénérer une page permet de recréer le cache de cette page qui sert à sa consultation coté client.',
		dismissDelay:	0
	});
	
	//create objects
	var progressScripts = new Ext.ProgressBar({
		id:				'scriptsProgressBar',
		updateProgress : function(value, text){
	        this.value = value || 0;
	        if(text){
	            this.updateText(text);
	        }
	        if(this.rendered && this.el && this.el.dom && this.el.dom.firstChild && !isNaN(value)){
				var w = Math.floor(value*this.el.dom.firstChild.offsetWidth);
		        if (w) {
					this.progressBar.setWidth(w, true);
			        if(this.textTopEl){
			            //textTopEl should be the same width as the bar so overflow will clip as the bar moves
			            this.textTopEl.removeClass('x-hidden').setWidth(w, true);
			        }
				}
	        }
	        this.fireEvent('update', this, value, text);
	        return this;
	    }
    });
	var regenerateAll = new Ext.Button({
		id:				'regenerateAll',
		text:			'Tout Régénérer',
		tooltip:		'Régénère l\'ensemble des pages de tous les sites.',
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
		text:			'Régénérer une branche',
		tooltip:		'Régénère l\'ensemble des pages sous la page sélectionnée.',
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
						title:			'Régénérer une branche',
						heading:		'Sélectionnez la page parente de l\'arborescence à régénérer.',
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
		title:			'Régénération des pages sélectionnées',
		collapsed:		false,
		height:			95,
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
			fieldLabel:		'<span class="atm-help" ext:qtip="Régénère l\'ensemble des pages dont l\'identifiant est précisé. Employez le tiret pour spécifier un groupe de pages. Exemple : 1,3,10-15.">Spécifiez les Pages</span>',
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
							heading:		'Sélectionner la page de destination dans l\'arborescence',
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
			text:			'Régénérer',
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
		text:			'Relancer les scripts',
		tooltip:		'Relance le traitement des scripts dans la file d\'attente si les scripts ne sont pas déjà en cours de traitement.',
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
		text:			'Stopper les scripts',
		tooltip:		'Arrête le traitement de la file d\'attente des scripts.',
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
		text:			'Effacer la file',
		tooltip:		'Vide la file d\'attente des scripts.',
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
		title:			'Détails des scripts en cours',
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
		title:			'Détails de la file d\'attente',
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
				if (!progressScripts.rendered) {
					progressScripts.render('scriptsProgress');
				}
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
				Automne.view.updateScriptBars();
			},
			scope:this}
	});
	
	serverWindow.add(center);
	//redo windows layout
	serverWindow.doLayout();
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