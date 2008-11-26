/**
  * Automne.framePanel Extension Class for Ext.Panel
  * Provide all events and watch for contained frames
  * @class Automne.framePanel
  * @extends Ext.Panel
  */
Automne.framePanel = Ext.extend(Automne.panel, { 
	//frame url to use at next frame reload
	frameURL:			'',
	pageId:				false,
	//does the frame currently has events attached to it
	frameEvents:		false,
	//iframe element
	frameEl:			false,
	//iframe inner document
	frameDocument: 		false,
	//is navigation allowed into frame ?
	allowFrameNav: 		false,
	//force next frame reload (even if url is the same)
	forceReload:		false,
	//does this frame is editable ?
	editable:			false,
	//constructor
	constructor: function(config) { 
		// preprocessing
		if (config.frameURL) {
			this.setFrameURL(config.frameURL);
		}
		this.allowFrameNav = (config.allowFrameNav) ? config.allowFrameNav : true;
		//call constructor
		Automne.framePanel.superclass.constructor.apply(this, arguments); 
	},
	//component initialisation (after constructor)
	initComponent: function() {
		var al = Automne.locales;
		Ext.apply(this, {
			html:  			'<iframe id="' + this.id + 'Frame" width="100%" height="100%" frameborder="no" src="#">&nbsp;</iframe>',
			hideBorders:	true,
			height:			'100%',
			autoScroll:		true,
			//only for edit frame panel
			tbar:			!this.editable ? false : new Ext.Toolbar({
				items:			[{
					text:			al.options,
					tooltip:		al.optionsDetail,
					iconCls:		'atm-pic-option',
					menu: 			{
						id: 			'editOptionsMenu',
						items: [{
							id:				'editAnimations',
							text: 			'<span ext:qtip="'+ al.optAnimateDetail +'">'+ al.optAnimate +'</span>',
							checked: 		true,
							stateful:		true,
							stateEvents:	['checkchange'],
							getState: 		function() {
								return {checked: this.checked};
							}
						},{
							id:				'editScroll',
							text: 			'<span ext:qtip="'+ al.optMoveDetail +'">'+ al.optMove +'</span>',
							checked: 		true,
							stateful:		true,
							stateEvents:	['checkchange'],
							getState: 		function() {
								return {checked: this.checked};
							}
						}
					]}
				},'-',{
					id:				'editAddRow',
					xtype:			'tbbutton',
					text:			al.newRow,
					tooltip:		al.newRowTip,
					scope:			this,
					iconCls:		'atm-pic-add',
					handler:		function() {
						Ext.getCmp('editAddRow').hide();
						Ext.getCmp('editValidateDraft').hide();
						Ext.getCmp('editSaveDraft').hide();
						Ext.getCmp('editCancelAdd').show();
						Ext.get('selectedRow').update('<span class="atm-text-alert">'+ al.csClickOnRed +'</span>');
						this.frameEl.dom.contentWindow.Automne.content.showZones('add');
					}
				},{
					id:				'editCancelAdd',
					xtype:			'tbbutton',
					text:			'Annuler',
					tooltip:		al.csCancelRowAdd,
					hidden:			true,
					scope:			this,
					iconCls:		'atm-pic-cancel',
					handler:		function() {
						//init toolbar and row mask
						this.frameEl.dom.contentWindow.Automne.content.init();
						//hide all drop zones
						this.frameEl.dom.contentWindow.Automne.content.hideZones();
					}
				},'-',{
					xtype:			'tbtext',
					text:			'<span id="selectedRow"></span>'
				},new Automne.ComboBox({
					id: 	'addRowCombo',
					store: new Automne.JsonStore({
						url: 				'page-rows-datas.php',
						root: 				'results',
						totalProperty: 		'total',
						fields:				['id', 'name', 'image'],
						id: 				'id'
					}),
					forceSelection:		true,
					valueField:			'id',
					hiddenName: 		'addRow',
					displayField:		'name',
					typeAhead: 			false,
					allowBlank: 		false,
					selectOnFocus:		true,
					editable:			false,
					width: 				420,
					minListWidth:		420,
					resizable: 			true,
					loadingText:		al.loading,
					maxHeight:			600,
					pageSize:			10,
					triggerAction:		'all',
					emptyText:			al.csSelectRow,
					hidden:				true,
					tpl: new Ext.XTemplate(
						'<tpl for=\".\"><div class=\"search-item atm-search-item\">',
							'<table border="0"><tr><td valign="middle" style="width:72px;"><img src="{image}" /></td><td valign="middle" style="padding:4px;"><strong>{name}</strong></td></tr></table>',
						'</div></tpl>'
					),
					itemSelector: 		'div.atm-search-item'
				}),{
					id:				'addSelectedRow',
					xtype:			'tbbutton',
					text:			al.add,
					tooltip:		al.csAddRowToPosition,
					scope:			this,
					hidden:			true,
					iconCls:		'atm-pic-ok',
					handler:		function() {
						//display window to select row to add according to queried CS
						var combo = Ext.getCmp('addRowCombo');
						var comboParams = combo.store.baseParams;
						//get combo value
						var params = {
							action:			'add-row',
							cs:				comboParams.cs,
							index:			comboParams.index,
							template:		comboParams.template,
							/*page:			comboParams.page,*/
							rowType:		combo.getValue(),
							visualMode:		comboParams.visualMode
						};
						var cs = this.frameEl.dom.contentWindow.Automne.content.getCS(comboParams.cs);
						//send all datas to server to create new row and get row HTML code
						Automne.server.call('page-content-controler.php', cs.addNewRow, params, cs);
						//init toolbar and row mask
						this.frameEl.dom.contentWindow.Automne.content.init();
					}
				}, '->',{
					id:				'editValidateDraft',
					xtype:			'tbbutton',
					iconCls:		'atm-pic-validate',
					text:			al.validateDraft,
					tooltip:		al.validateDraftDetail,
					hidden:			true,
					scope:			this,
					handler:		function() {
						Automne.message.popup({
							msg: 				al.validateDraftConfirm,
							buttons: 			Ext.MessageBox.OKCANCEL,
							animEl: 			this.getEl(),
							closable: 			false,
							icon: 				Ext.MessageBox.QUESTION,
							scope:				this,
							fn: 				function (button) {
								if (button == 'cancel') {
									return;
								}
								//goto public tab
								Automne.tabPanels.setActiveTab('public', true);
								pr('set public as active after validation');
								Automne.server.call({
									url:				'page-controler.php',
									params: 			{
										currentPage:		this.pageId,
										action:				'validate_draft'
									}/*,
									fcnCallback: 		function() {
										
									},
									callBackScope:		this*/
								});
							}
						});
					}
				},{
					id:				'editSaveDraft',
					xtype:			'tbbutton',
					iconCls:		'atm-pic-draft-validation',
					text:			al.SubmitToValid,
					tooltip:		al.SubmitToValidDetail,
					hidden:			true,
					scope:			this,
					handler:		function() {
						Automne.message.popup({
							msg: 				al.submitDraftConfirm,
							buttons: 			Ext.MessageBox.OKCANCEL,
							animEl: 			this.getEl(),
							closable: 			false,
							icon: 				Ext.MessageBox.QUESTION,
							scope:				this,
							fn: 				function (button) {
								if (button == 'cancel') {
									return;
								}
								//goto previz tab
								Automne.tabPanels.setActiveTab('edited', true);
								pr('set edited as active after submit to validation');
								Automne.server.call({
									url:				'page-controler.php',
									params: 			{
										currentPage:		this.pageId,
										action:				'submit_for_validation'
									}/*,
									fcnCallback: 		function() {
										
										
									},
									callBackScope:		this*/
								});
							}
						});
					}
				},{
					id:				'editPrevizDraft',
					xtype:			'tbbutton',
					iconCls:		'atm-pic-draft-previz',
					text:			'Aperçu',
					tooltip:		'Aperçu de votre contenu en cours de modification.',
					scope:			this,
					hidden:			true,
					iconCls:		'atm-pic-preview',
					handler:		function(button) {
						var window = new Automne.frameWindow({
							id:				'editPrevizDraftWindow',
							frameURL:		'/automne/admin/page-previsualization.php?page='+this.pageId+'&draft=true',
							allowFrameNav:	false,
							width:			750,
							height:			580
						});
						window.show(button);
					}
				}]
			})
		});
		// call parent initComponent
		Automne.framePanel.superclass.initComponent.call(this);
	},
	//on destroy, destroy tooltip and iframe
	onDestroy: function () {
		//destroy frame
		if (this.frameEl !== false && this.frameEl.destroy) this.frameEl.destroy();
		//call parent
		Automne.framePanel.superclass.onDestroy.apply(this, arguments);
	},
	//before panel is activated (tab panel clicked)
	beforeActivate: function(tabPanel, newTab, oldTab, force) {
		if (oldTab && oldTab.id == 'edit' && (newTab.id == 'edited' || newTab.id == 'public')) {
			Automne.content.endEdition('tab');
		}
		if (force && this.disabled) {
			this.setDisabled(false);
		}
		//if frame element is known (this is not the first activation of panel), then force reload it
		if (this.frameEl && (this.pageId != Automne.tabPanels.pageId || this.frameDocument.documentURI.indexOf(this.frameURL) === -1 || newTab.id == 'edit')) {
			this.reload();
		}
		return true;
	},
	//after panel is activated (tab panel clicked)
	afterActivate: function (tabPanel, newTab, force) {
		if (force && this.disabled) {
			this.setDisabled(false);
		}
		//if frame element is not known (first activation of panel), then set event on it and load it
		if (!this.frameEl) {
			this.frameEl = Ext.get(this.id + 'Frame');
			if (this.frameEl) {
				//set frame events
				this.setFrameEvents();
				this.resize();
				this.reload();
			}
		} else {
			this.resize();
		}
	},
	//set load and resize events on frame if not already exists
	setFrameEvents: function() {
		if (this.frameEvents === false && this.frameEl) {
			this.frameEl.on('load', this.loadFrameInfos, this);
			this.on('resize', this.resize, this);
			this.frameEvents = true;
		}
	},
	//function called after each load of a new page frame
	loadFrameInfos: function() {
		if (this.disabled) {
			this.setDisabled(false);
		}
		//get frame and document from event
		this.loadFrameDocument();
		//catch frame links
		if (!this.allowFrameNav) {
			pr('Catch '+ this.id +' frame links');
			this.catchFrameLinks();
		}
		//if this frame is the edit one, launch edition mode
		if (this.id == 'edit' && this.frameEl.dom.contentWindow && this.frameEl.dom.contentWindow.launchEdit) {
			pr('launch edit mode');
		}
	},
	//resize frame according to panel size
	resize: function() {
		if (!this.frameEl || !this.body) {
			return;
		}
		this.frameEl.setWidth(this.body.getBox().width);
		this.frameEl.setHeight(this.body.getBox().height);
	},
	//catch all click into frame links and form submission to redirect action
	catchFrameLinks: function () {
		Automne.utils.catchLinks(this.frameDocument, this.id);
	},
	//reload frame content
	reload: function (force) {
		this.forceReload = force || this.forceReload;
		if (this.loadFrameDocument()) {
			if (this.frameDocument) {
				pr('Reload '+ this.id +' tab => Get : '+this.frameURL);
				this.frameDocument.location = this.frameURL;
				this.forceReload = false;
			}
		}
	},
	//set a flag to force next reload of the frame (even if url is the same)
	setForceReload: function(force) {
		this.forceReload = force;
	},
	//frame url setters and getters
	setFrameURL: function(url) { 
		/*if (url != this.getFrameURL()) {
			this.forceReload = true;
			pr('force reload of '+this.id+' frame ('+this.getFrameURL()+') with url '+url);
		}*/
		this.frameURL = url;
	},
	getFrameURL: function(withDomain) {
		if (!this.loadFrameDocument()) {
			return false;
		}
		return this.frameURL;
	},
	setPageId: function(pageId) {
		this.pageId = pageId;
	},
	loadFrameDocument: function () {
		if (!this.frameEl) {
			return false;
		}
		this.frameDocument = (Ext.isIE) ? this.frameEl.dom.contentWindow.document : this.frameEl.dom.contentDocument;
		return true;
	}
});
Ext.reg('framePanel', Automne.framePanel);