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
// $Id: validations.php,v 1.10 2010/03/08 16:41:23 sebastien Exp $

/**
  * PHP page : Load page validations window.
  * Used accross an Ajax request. Render validations window.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_STANDARD_MODULE_LABEL", 213);
define("MESSAGE_PAGE_VALIDATIONS_PENDING", 60);
define("MESSAGE_PAGE_VALIDATIONS_PENDING_COUNT", 338);
define("MESSAGE_PAGE_SHORT_LABEL", 814);
define("MESSAGE_PAGE_STATUS", 160);
define("MESSAGE_PAGE_EDITORS", 339);

define("MESSAGE_PAGE_VALIDATION_PENDING_INFO", 421);
define("MESSAGE_PAGE_NO_WAIT_VALIDATION", 422);
define("MESSAGE_PAGE_X_VALIDATIONS_ON", 423);
define("MESSAGE_PAGE_NO_VALIDATION_DISPLAY", 424);
define("MESSAGE_PAGE_VALIDATE_LOT", 425);
define("MESSAGE_PAGE_CLOSE", 426);
define("MESSAGE_PAGE_VALIDATION_PENDING_DETAIL", 427);
define("MESSAGE_PAGE_VALIDATION_CLOSE_CONFIRM", 428);
define("MESSAGE_PAGE_ERROR_FUNCTION", 429);
define("MESSAGE_PAGE_ACCEPT_VALIDATION", 430);
define("MESSAGE_PAGE_REFUSE_VALIDATION", 431);
define("MESSAGE_PAGE_TRANSFERT_VALIDATION", 432);
define("MESSAGE_PAGE_TO", 433);
define("MESSAGE_PAGE_VALIDATION", 434);
define("MESSAGE_PAGE_COMMENT", 907);
define("MESSAGE_PAGE_SAVE", 952);
define("MESSAGE_PAGE_NO_PENDING_VALIDATION_SELECTED", 435);
define("MESSAGE_PAGE_VALIDATION_CHOICE", 1599);


//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId', '', 'validationsWindow');
$module = sensitiveIO::request('module');
$editions = sensitiveIO::request('editions', 'sensitiveIO::isPositiveInteger');
$resource = sensitiveIO::request('resource', 'sensitiveIO::isPositiveInteger');

$resourceId = 0;

if (!$module) {
	CMS_grandFather::raiseError('Module not set ...');
	$view->show();
}
if (!$editions && !$resource) {
	CMS_grandFather::raiseError('Module editions not set ...');
	$view->show();
} elseif ($resource) {//get current edition for given resource
	//load module
	$mod = CMS_modulesCatalog::getByCodename($module);
	//load module resource by ID
	$resource = $mod->getResourceByID($resource);
	$validation = false;
	//Clean old validations
	CMS_resourceValidation::cleanOldValidations();
	if (is_object($resource) && !$resource->hasError()) {
		if (method_exists($mod, "getValidationByID")) {
			$validation = $mod->getValidationByID($resource->getID(),$cms_user);
			if (!is_a($validation,"CMS_resourceValidation") || $validation->hasError()) {
				$validation = false;
			}
		} else {
			$validations = $mod->getValidations($cms_user);
			if (is_array($validations)) {
				foreach ($validations as $aValidation) {
					if ($aValidation->getResourceID() == $resource->getID() && !$aValidation->hasError()) {
						$validation = $aValidation;
					}
				}
			}
		}
	}
	if ($validation) {
		$editions = $validation->getEditions();
		$resourceId = $resource->getID();
	} else {
		CMS_grandFather::raiseError('Can\'t get editions from given resource ID '.$resource->getID().' for module '.$module.' ...');
		$view->show();
	}
}
if (!$cms_user->hasValidationClearance($module)) {
	CMS_grandFather::raiseError('User has no validation clearance on module '.$module.' ...');
	$view->show();
}
if (!APPLICATION_ENFORCES_WORKFLOW) {
	CMS_grandFather::raiseError('No APPLICATION_ENFORCES_WORKFLOW set ...');
	$view->show();
}
//MODULES VALIDATIONS PENDING
$modulesValidations = CMS_modulesCatalog::getAllValidations($cms_user,true);
$validationsCount = 0;

//validations types
$validationsType = array();
$validationsType['validationsType'] = array();
$count = 1;
$selectedValidations = false;
if ($modulesValidations && sizeof($modulesValidations)) {
	foreach ($modulesValidations as $codename => $moduleValidations) {
		//if module is not standard, echo its name, the number of validations to do and a link to its admin frontend
		if ($codename == MOD_STANDARD_CODENAME) {
			$modLabel = $cms_language->getMessage(MESSAGE_PAGE_STANDARD_MODULE_LABEL);
		} else {
			$mod = CMS_modulesCatalog::getByCodename($codename);
			$modLabel = $mod->getLabel($cms_language);
		}
		
		//sort the validations by type label
		$validationsSorted = array();
		foreach ($moduleValidations as $validation) {
			$validationsSorted[$validation->getValidationTypeLabel()][] = $validation;
		}
		ksort($validationsSorted);
		
		foreach ($validationsSorted as $label => $validations) {
			$label = io::decodeEntities($label);
			$validation = $validations[0];
			$validationsType['validationsType'][] = array(
				'id' 		=> $count,
				'module'	=> $codename,
				'editions'	=> $validation->getEditions(),
				'label' 	=> $modLabel.' : '.$label.' : '.sizeof($validations).' '.$cms_language->getMessage(MESSAGE_PAGE_VALIDATIONS_PENDING_COUNT),
			);
			if ($codename == $module && $validation->getEditions() & $editions) {
				$selectedValidations = $count;
			}
			$count++;
		}
	}
}
//json encode validations types
$validationsType = sensitiveIO::jsonEncode($validationsType);
//get records / pages
$recordsPerPage = CMS_session::getRecordsPerPage();

$jscontent = <<<END
	var validationsWindow = Ext.getCmp('{$winId}');
	//set window title
	validationsWindow.setTitle('{$cms_language->getJSMessage(MESSAGE_PAGE_VALIDATIONS_PENDING)}');
	//set help button on top of page
	validationsWindow.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target: 		validationsWindow.tools['help'],
		title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_VALIDATION_PENDING_INFO)}',
		dismissDelay:	0
	});
	//Loading mask
	var loadMask = new Ext.LoadMask(validationsWindow.body, {});
	
	//checkboxes selection Model
	var sm = new Ext.grid.CheckboxSelectionModel();
	
	//validations types
	var validationsTypeStore = new Ext.data.JsonStore({
		id:				'id',
		root: 			'validationsType',
		fields: 		['id', 'label', 'module', 'editions'],
		data:			{$validationsType},
		listeners:		{
			'load': 		{fn:function(store, records, options){
				var validationsType = Ext.getCmp('validationsType');
				if (validationsType && module && editions) {
					//if store is empty, reset the combo
					if (store.totalLength == 0) {
						validationsType.reset();
						validationsType.disable();
					} else 
					//if selected combo value does not exists in store, select the first index
					if (!store.getById(validationsType.getValue())) {
						validationsType.reset();
					} else {
						//reselect the same value to update displayed value
						validationsType.setValue(validationsType.getValue());
					}
				}
			}}
		}
	});
	
	//validations store
	var store = new Automne.JsonStore({
		url: 			'validations-datas.php',
		root: 			'validations',
		totalProperty:	'totalCount',
		validators:		'validators',
		id:				'validationId',
		fields:			['validationId', 'resource', 'shortLabel', 'label', 'status', 'actions', 'editors', 'accept', 'refuse', 'transfer'],
		listeners:		{
			'load': 		{fn:function(store, records, options){
				//select first row
				sm.selectRow(0);
				//if no row selected, display no selection message
				if (sm.getCount() == 0) noSelection();
				
				//then load validators datas if exists
				if (store.reader.jsonData.validators) {
					validators.loadData(store.reader.jsonData.validators);
				}
				//set module
				if (store.reader.jsonData.module) {
					module = store.reader.jsonData.module;
				}
				//set editions
				if (store.reader.jsonData.editions) {
					editions = store.reader.jsonData.editions;
				}
				//reload validations type combo
				if (store.reader.jsonData.validationsType) {
					validationsTypeStore.loadData({validationsType: store.reader.jsonData.validationsType});
				}
				
				loadMask.hide();
			}},
			'beforeload': 	{fn:function(store, options){ 
				if (!options.params.module || !options.params.editions) {
					var validationsType = Ext.getCmp('validationsType');
					if (validationsType) {
						var record = validationsTypeStore.getById(validationsType.getValue());
						options.params.module = record.get('module');
						options.params.editions = record.get('editions');
					}
				}
				return true;
			}}
		}
	});
	
	//validators store
	var validators = new Ext.data.Store({
		reader: new Ext.data.ArrayReader({}, [
	       {name: 'id'},
	       {name: 'user'}
	    ])
	});
	//create vars which store current module and editions
	var module, editions;
	
	//results grid
	var grid = new Ext.grid.GridPanel({
		id:				'validations-grid',
		store: 			store,
		enableHdMenu:	false,
		cm: 			new Ext.grid.ColumnModel([
			sm,
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_STATUS)}", width: 30, dataIndex: 'status'},
			{id:'id',header: "ID", width: 30, dataIndex: 'resource'},
			{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_SHORT_LABEL)}", dataIndex: 'shortLabel'}
		]),
		sm: sm,
		anchor:				'0 -242',
		viewConfig: 	{
			forceFit:		true
		},
		// inline toolbars
		tbar:['Types de validations : ', {
			xtype:				'combo',
			id:					'validationsType',
			name:				'validationsType',
			forceSelection:		true,
			mode:				'local',
			width:				600,
			triggerAction:		'all',
			valueField:			'id',
			displayField:		'label',
			value:				'{$selectedValidations}',
			store:				validationsTypeStore,
			valueNotFoundText:	'{$cms_language->getJsMessage(MESSAGE_PAGE_NO_WAIT_VALIDATION)}',
			allowBlank: 		false,
			selectOnFocus:		true,
			editable:			false
		}],
		bbar: new Ext.PagingToolbar({
			pageSize: 		{$recordsPerPage},
			store: 			store,
			displayInfo: 	true,
			displayMsg: 	'{$cms_language->getJsMessage(MESSAGE_PAGE_X_VALIDATIONS_ON)}',
			emptyMsg: 		"{$cms_language->getJsMessage(MESSAGE_PAGE_NO_VALIDATION_DISPLAY)}"
		})
	});
	var center = new Ext.Panel({
		region:				'center',
		border: 			false,
		layout: 			'anchor',
		items: [grid, {
				id: 			'validationDetailPanel',
				border:			false,
				bodyStyle: {
					background: 	'#ffffff',
					padding: 		'0px'
				}
			}
		]
	});
	validationsWindow.add(center);
	
	//add buttons
	var buttons = [new Ext.Button({
		id:			'batchValidation',
		text:		'{$cms_language->getJsMessage(MESSAGE_PAGE_VALIDATE_LOT)}',
		handler:	function() {
			//display loading mask
			loadMask.show();
			
			//get all validations ids selected
			var selections = sm.getSelections();
			var selectionsLength = selections.length;
			var selectionsIds = [];
			for (var i = 0; i < selectionsLength; i++) {
				selectionsIds[selectionsIds.length] = selections[i].id;
			}
			Automne.server.call('validations-controler.php', function(response, options) {
				//reload store and refresh validation pending combo
				this.reload({params:{
					start:						0,
					limit:						{$recordsPerPage},
					module:						options.params.module,
					editions:					options.params.editions,
					withValidationsPending:		true
				}});
			}, {
				action:				'batch-validate',
				validationIds:		selectionsIds.toString(),
				module:				module,
				editions:			editions
			}, store);
		},
		scope:		validationsWindow,
		disabled:	true
	}), new Ext.Button({
		text:		'{$cms_language->getJSMessage(MESSAGE_PAGE_CLOSE)}',
		handler:	function() {this.close();},
		scope:		validationsWindow
	})];
	validationsWindow.addButtons(buttons);
	
	//load validations store
	store.load({params:		{
		start:			0,
		limit:			{$recordsPerPage},
		module:			'{$module}',
		editions:		{$editions},
		resource:		{$resourceId}
	}});
	//validations detail template
	var validationTplMarkup = [
		'<div>',
			'<div id="validation-actions"></div>',
			'<div style="padding:5px;">',
				'<h3 style="">{status} {label} (ID : {resource})</h3><br/>',
				'<strong>{$cms_language->getJSMessage(MESSAGE_PAGE_EDITORS)} :</strong> {editorsHTML}<br/>',
			'</div>',
		'</div>',
		'<div id="validation-form"></div>'
	];
	var validationTpl = new Ext.Template(validationTplMarkup);
	validationTpl.compile();
	//what append if no selection is made on grid
	var noSelection = function () {
		var detailPanel = Ext.getCmp('validationDetailPanel');
		detailPanel.body.update('<div style="padding:5px;">{$cms_language->getJSMessage(MESSAGE_PAGE_NO_PENDING_VALIDATION_SELECTED)}</div>');
		Ext.getCmp('batchValidation').disable();
	}
	var selectionChange = function (sm, rowIdx, r) {
		var detailPanel = Ext.getCmp('validationDetailPanel');
		if (sm.getCount() == 0) {
			noSelection();
		} else if (sm.getCount() > 1) {
			detailPanel.body.update('<div style="padding:5px;">' + sm.getCount() + ' {$cms_language->getJsMessage(MESSAGE_PAGE_VALIDATION_PENDING_DETAIL)}</div>');
			Ext.getCmp('batchValidation').enable();
		} else if (sm.getCount() == 1) {
			//create editors names
			r.data.editorsHTML = '';
			var editorsLength = r.data.editors.length;
			for(var i = 0; i < editorsLength; i++) {
				r.data.editorsHTML += '<a href="#" onclick="Automne.view.user('+ r.data.editors[i][0] +');">'+ r.data.editors[i][1] +'</a>';
				r.data.editorsHTML += (i+1 < editorsLength) ? ', ':'';
			}
			//render validation detail
			detailPanel.body.hide();
			validationTpl.overwrite(detailPanel.body, r.data);
			//create actions buttons
			var actionsLength = r.data.actions.length;
			if (actionsLength) {
				var buttons = ['->'];
				for(var i = 0; i < actionsLength; i++) {
					//set button handlers
					if (r.data.actions[i][3]) {
						//execute script
						var buttonHandler = function() {
							Automne.message.popup({
								msg: 				'{$cms_language->getJsMessage(MESSAGE_PAGE_VALIDATION_CLOSE_CONFIRM)}',
								buttons: 			Ext.MessageBox.OKCANCEL,
								animEl: 			this.getEl(),
								closable: 			false,
								icon: 				Ext.MessageBox.QUESTION,
								fn: 				function (button) {
									if (button == 'ok') {
										eval(this.js);
										validationsWindow.close();
									}
								},
								scope:				this
							});
						}
					} else if (r.data.actions[i][1]) {
						//open a frame window with given URL
						var buttonHandler = function() {
							var actionWindow = new Automne.frameWindow({
								id:				'actionWindow',
								frameURL:		Ext.util.Format.htmlDecode(this.url),
								allowFrameNav:	true,
								width:			750,
								height:			550,
								animateTarget:	this.getEl()
							});
							actionWindow.show();
						};
					} else {
						//unknown function type
						var buttonHandler = function() {
							Automne.message.popup({
								msg: 				'{$cms_language->getJsMessage(MESSAGE_PAGE_ERROR_FUNCTION)}',
								buttons: 			Ext.MessageBox.OK,
								animEl: 			this.getEl(),
								closable: 			false,
								icon: 				Ext.MessageBox.ERROR
							});
						}
					}
					//create action button
					buttons[buttons.length] = {
						text:				r.data.actions[i][0],
						url:				r.data.actions[i][1],
						target:				r.data.actions[i][2],
						js:					r.data.actions[i][3],
						handler:			buttonHandler
					};
				}
				//create actions buttons toolbar
				var actionbar = new Ext.Toolbar({
					renderTo:			'validation-actions',
					items:				buttons
				});
			}
			//set validation options
			var items = [];
			if (r.data.accept) {
				items[items.length] = {
					xtype:				'radio',
					fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_ACCEPT_VALIDATION)}',
					name:				'accept',
					inputValue:			'accept',
					checked:			true
				};
			}
			if (r.data.refuse) {
				items[items.length] = {
					xtype:				'radio',
					fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_REFUSE_VALIDATION)}',
					name:				'accept',
					inputValue:			'refuse'
				};
			}
			if (r.data.transfer) {
				items[items.length] = {
					xtype:				'radio',
					fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_TRANSFERT_VALIDATION)}',
					name:				'accept',
					inputValue:			'transfer',
					listeners:			{
						'check': 		{fn:function(checkbox, checked){
							if (checked) {
								Ext.getCmp('validation-transfer').enable();
							} else {
								Ext.getCmp('validation-transfer').disable();
							}
						}}
					}
				};
				items[items.length] = {
					xtype:				'combo',
					id:					'validation-transfer',
					name:				'transfer',
					forceSelection:		false,
					mode:				'local',
					triggerAction:		'all',
					valueField:			'id',
					displayField:		'user',
					store:				validators,
					allowBlank: 		false,
					selectOnFocus:		true,
					editable:			false,
					fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_TO)}',
					disabled:			true
				};
			}
			//create validation form
			var validateForm = new Automne.FormPanel({
				url:				'validations-controler.php',
				renderTo:			'validation-form',
				padding:			'5px 5px 0',
				title:				'{$cms_language->getJSMessage(MESSAGE_PAGE_VALIDATION)}',
				anchor:				'100%',
				border:				false,
				labelAlign:			'right',
				buttonAlign:		'right',
				items: [{
					layout:				'column',
					border:				false,
					items:[{
						columnWidth:		.5,
						layout:				'form',
						labelAlign:			'right',
						labelWidth:			130,
						border:				false,
						items: 				items
					},{
						columnWidth:		.5,
						layout:				'form',
						labelAlign:			'top',
						border:				false,
						items: [{
							xtype:				'textarea',
							fieldLabel:			'{$cms_language->getJSMessage(MESSAGE_PAGE_COMMENT)}',
							name:				'comment',
							anchor:				'95%'
						}]
					}]
				}],
				buttons: [{
					text: 					'{$cms_language->getJSMessage(MESSAGE_PAGE_VALIDATION_CHOICE)}',
					handler:				function() {
						var form = validateForm.getForm();
						//set mask events on form validation
						form.on({
							'beforeaction': 		{fn:function(form, action){
								if (action.type == 'submit') {
									//display loading mask
									loadMask.show();
								}
							}},
							'actioncomplete': 		{fn:function(form, action){
								if (action.type == 'submit') {
									//reload store and refresh validation pending combo
									store.reload({params:{
										start:						0,
										limit:						{$recordsPerPage},
										module:						module,
										editions:					editions,
										withValidationsPending:		true
									}});
								}
							}}
						});
						//submit form
						form.submit({params:{
							action:				'validate',
							validationId:		r.data.validationId,
							resource:			r.data.resource,
							module:				module,
							editions:			editions,
							transferUser:		form.findField('transfer').getValue()
						}});
					},
					scope:					this
				}]
			});
			Ext.getCmp('batchValidation').disable();
			detailPanel.body.slideIn('b', {stopFx:true,duration:.3});
			setTimeout(function(){
				validateForm.doLayout();
			}, 100);
		}
	}
	//add selection events to selection model
	sm.on('rowselect', selectionChange);
	//deselect a row in grid
	sm.on('rowdeselect', selectionChange);
	
	//redo windows layout
	validationsWindow.doLayout();
	
	//add event on combo box to switch validations type
	setTimeout(function(){
		Ext.getCmp('validationsType').on('select', function(combo, record, index) {
			module = record.data.module;
			editions = record.data.editions;
			//display loading mask
			loadMask.show();
			//reload validations store
			store.reload({params:{
				start:			0,
				limit:			{$recordsPerPage},
				module:			record.data.module,
				editions:		record.data.editions
			}});
		});
	}, 100);
END;
$view->addJavascript($jscontent);
$view->show();
?>