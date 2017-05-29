/**
  * Automne Javascript file
  *
  * Automne.framePanel Extension Class for Ext.Panel
  * Provide all events and watch for contained frames
  * @class Automne.framePanel
  * @extends Ext.Panel
  * @package CMS
  * @subpackage JS
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: framepanel.js,v 1.21 2010/01/18 15:24:30 sebastien Exp $
  */
Automne.framePanel = Ext.extend(Automne.panel, { 
	xtype:				'framePanel',
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
	//avoid auto page reload
	noReload:			false,
	//does this frame is editable ?
	editable:			false,
	//buttons edition id suffix
	editId:				null,
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
		if (this.editable) {
			this.editId = this.id + 'Frame';
		}
		Ext.apply(this, {
			html:  			'<iframe id="' + this.id + 'Frame" width="100%" height="100%" frameborder="no"' + (!Ext.isIE ? ' class="x-hide-visibility"' : '') + ' src="' + Ext.SSL_SECURE_URL + '">&nbsp;</iframe>',
			hideBorders:	true,
			ctCls:			'atm-iframe', //used to remove overflow-x in xtheme-automne.css
			autoScroll:		true,
			//only for edit frame panel
			tbar:			!this.editable ? false : new Ext.Toolbar({
				items:			[{
					text:			al.options,
					tooltip:		al.optionsDetail,
					iconCls:		'atm-pic-option',
					menu: 			{
						items: [{
							id:				'editAnimations'+ this.editId,
							text: 			'<span ext:qtip="'+ al.optAnimateDetail +'">'+ al.optAnimate +'</span>',
							checked: 		true,
							stateful:		true,
							stateEvents:	['checkchange'],
							getState: 		function() {
								return {checked: this.checked};
							}
						},{
							id:				'editScroll'+ this.editId,
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
					id:				'editAddRow'+ this.editId,
					xtype:			'tbbutton',
					text:			al.newRow,
					tooltip:		al.newRowTip,
					scope:			this,
					iconCls:		'atm-pic-add',
					handler:		function() {
						Ext.getCmp('editAddRow'+ this.editId).hide();
						Ext.getCmp('editValidateDraft'+ this.editId).hide();
						Ext.getCmp('editSaveDraft'+ this.editId).hide();
						Ext.getCmp('editCancelAdd'+ this.editId).show();
						Ext.get('selectedRow'+ this.editId).update('<span class="atm-text-alert">'+ al.csClickOnRed +'</span>');
						if (!Automne.popup) {
							Automne.message.show(al.csClickOnRed, '', Automne.tabPanels.getActiveTab().frameEl);
						}
						this.frameEl.dom.contentWindow.atmContent.showZones('add');
					}
				},{
					id:				'editCancelAdd'+ this.editId,
					xtype:			'tbbutton',
					text:			'Annuler',
					tooltip:		al.csCancelRowAdd,
					hidden:			true,
					scope:			this,
					iconCls:		'atm-pic-cancel',
					handler:		function() {
						//init toolbar and row mask
						this.frameEl.dom.contentWindow.atmContent.init();
						//hide all drop zones
						this.frameEl.dom.contentWindow.atmContent.hideZones();
					}
				},'-',{
					xtype:			'tbtext',
					text:			'<span id="selectedRow'+ this.editId +'"></span>'
				},new Automne.ComboBox({
					id: 	'addRowCombo'+ this.editId,
					store: new Automne.JsonStore({
						url: 				'page-rows-datas.php',
						root: 				'results',
						totalProperty: 		'total',
						fields:				['id', 'label', 'image', 'shortdesc'],
						id: 				'id',
						listeners:{
							'beforeload':function(e, options ) {
								//correct a bug in pagination when combo is reloaded
								if (!options.params.limit) {
									options.params.limit = 10;
									options.params.page = 0;
								}
							},
							scope:this
						}
					}),
					forceSelection:		true,
					valueField:			'id',
					hiddenName: 		'addRow',
					displayField:		'label',
					typeAhead: 			false,
					allowBlank: 		true,
					selectOnFocus:		true,
					editable:			true,
					width: 				420,
					minListWidth:		420,
					resizable: 			true,
					loadingText:		al.loading,
					queryParam:			'keyword',
					queryDelay:			350,
					minChars:			3,
					maxHeight:			600,
					pageSize:			10,
					triggerAction:		'all',
					enableKeyEvents:	true,
					emptyText:			al.csSelectRow,
					hidden:				true,
					tpl: new Ext.XTemplate(
						'<tpl for=\".\"><div class=\"search-item atm-search-item\">',
							'<table border="0"><tr><td valign="middle" style="width:72px;"><img src="{image}" /></td><td valign="middle" style="padding:4px;"><strong>{label}</strong><tpl if="shortdesc"><br />{shortdesc}</tpl></td></tr></table>',
						'</div></tpl>'
					),
					itemSelector: 		'div.atm-search-item',
					listeners:{
						'specialkey':function(field, e) {
							if (Ext.EventObject.getKey() == Ext.EventObject.ENTER) {
								field.doQuery(field.getValue());
							}
							Ext.getCmp('addSelectedRow'+ this.editId).disable();
						},
						'valid':function(field, e) {
							if (isNaN(parseInt(field.getValue(),10))) {
								Ext.getCmp('addSelectedRow'+ this.editId).disable();
							}
						},
						'keypress':function(field, e) {
							Ext.getCmp('addSelectedRow'+ this.editId).disable();
						},
						'select':function(field, e) {
							Ext.getCmp('addSelectedRow'+ this.editId).enable();
						},
						scope:this
					}
				}),{
					id:				'addSelectedRow'+ this.editId,
					xtype:			'tbbutton',
					text:			al.add,
					tooltip:		al.csAddRowToPosition,
					scope:			this,
					hidden:			true,
					disabled:		true,
					iconCls:		'atm-pic-ok',
					handler:		function() {
						//display window to select row to add according to queried CS
						var combo = Ext.getCmp('addRowCombo'+this.editId);
						var comboParams = combo.store.baseParams;
						var value = combo.getValue();
						if (!isNaN(parseInt(value,10))) {
							//get combo value
							var params = {
								action:			'add-row',
								cs:				comboParams.cs,
								index:			comboParams.index,
								template:		comboParams.template,
								rowType:		value,
								visualMode:		comboParams.visualMode
							};
							var cs = this.frameEl.dom.contentWindow.atmContent.getCS(comboParams.cs);
							//send all datas to server to create new row and get row HTML code
							Automne.server.call('page-content-controler.php', cs.addNewRow, params, cs);
							//hide all drop zones
							this.frameEl.dom.contentWindow.atmContent.hideZones();
							//init toolbar and row mask
							this.frameEl.dom.contentWindow.atmContent.init();
						} else {
							Ext.getCmp('addSelectedRow'+ this.editId).disable();
						}
					}
				}, '->',{
					id:				'editValidateDraft'+ this.editId,
					xtype:			'tbbutton',
					iconCls:		'atm-pic-validate',
					text:			al.validateDraft,
					tooltip:		al.validateDraftDetail,
					hidden:			true,
					scope:			this,
					handler:		function() {
						Ext.getCmp('editValidateDraft'+ this.editId).disable();
						Ext.getCmp('editSaveDraft'+ this.editId).disable();
						Automne.message.popup({
							msg: 				al.validateDraftConfirm,
							buttons: 			Ext.MessageBox.OKCANCEL,
							animEl: 			this.getEl(),
							closable: 			false,
							icon: 				Ext.MessageBox.QUESTION,
							scope:				this,
							fn: 				function (button) {
								if (button == 'cancel') {
									Ext.getCmp('editValidateDraft'+ this.editId).enable();
									Ext.getCmp('editSaveDraft'+ this.editId).enable();
									return;
								}
								Automne.server.call({
									url:				'page-controler.php',
									params: 			{
										currentPage:		this.pageId,
										action:				'validate_draft'
									},
									fcnCallback: 		function() {
										Ext.getCmp('editValidateDraft'+ this.editId).enable();
										Ext.getCmp('editSaveDraft'+ this.editId).enable();
									},
									callBackScope:		this
								});
							}
						});
					}
				},{
					id:				'editSaveDraft'+ this.editId,
					xtype:			'tbbutton',
					iconCls:		'atm-pic-draft-validation',
					text:			al.SubmitToValid,
					tooltip:		al.SubmitToValidDetail,
					hidden:			true,
					scope:			this,
					handler:		function() {
						Ext.getCmp('editValidateDraft'+ this.editId).disable();
						Ext.getCmp('editSaveDraft'+ this.editId).disable();
						Automne.message.popup({
							msg: 				al.submitDraftConfirm,
							buttons: 			Ext.MessageBox.OKCANCEL,
							animEl: 			this.getEl(),
							closable: 			false,
							icon: 				Ext.MessageBox.QUESTION,
							scope:				this,
							fn: 				function (button) {
								if (button == 'cancel') {
									Ext.getCmp('editValidateDraft'+ this.editId).enable();
									Ext.getCmp('editSaveDraft'+ this.editId).enable();
									return;
								}
								Automne.server.call({
									url:				'page-controler.php',
									params: 			{
										currentPage:		this.pageId,
										action:				'submit_for_validation'
									},
									fcnCallback: 		function() {
										//then reload page infos
										Automne.tabPanels.getPageInfos({
											pageId:		this.pageId,
											noreload:	true
										});
										Ext.getCmp('editValidateDraft'+ this.editId).enable();
										Ext.getCmp('editSaveDraft'+ this.editId).enable();
									},
									callBackScope:		this
								});
							}
						});
					}
				},{
					id:				'editPrevizDraft'+ this.editId,
					xtype:			'tbbutton',
					iconCls:		'atm-pic-draft-previz',
					text:			al.previzDraft,
					tooltip:		al.previzDraftDetail,
					scope:			this,
					hidden:			true,
					iconCls:		'atm-pic-preview',
					handler:		function(button) {
						var window = new Automne.frameWindow({
							id:				'editPrevizDraftWindow',
							frameURL:		Automne.context.path + '/automne/admin/page-previsualization.php?currentPage='+this.pageId+'&draft=true',
							allowFrameNav:	false,
							width:			750,
							height:			580
						});
						window.show(button);
					}
				}]
			})
		});
		this.on({'afterrender': function(){
			if (this.id == 'public') {
				//pr('Rendering Workarround !');
				this.afterActivate();
			}
		}, scope: this});
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
		if (oldTab && oldTab.id == 'edit' && (newTab.id == 'edited' || newTab.id == 'public') && oldTab.frameEl && oldTab.frameEl.dom && oldTab.frameEl.dom.contentWindow && oldTab.frameEl.dom.contentWindow.atmContent) {
			oldTab.frameEl.dom.contentWindow.atmContent.endEdition('tab');
		}
		if (force && this.disabled) {
			this.setDisabled(false);
		}
		//if frame element is known (this is not the first activation of panel), then force reload it
		try {
			if (!this.noReload && this.frameEl && (
					this.pageId != Automne.tabPanels.pageId || 
					(this.frameDocument && this.frameDocument.location && (this.frameDocument.location.href.indexOf(this.frameURL) === -1 || this.frameURL.indexOf('?') !== -1 || this.frameURL.indexOf('?') != this.frameDocument.location.href.indexOf('?'))) || 
					newTab.id == 'edit')) {
				this.reload();
			}
		} catch (e) {
			//an error occured during frame location analysis. Recreate frame content.
			this.resetFrame();
		}
		this.noReload = false;
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
			this.frameEl.on({
				'load': this.loadFrameInfos, scope:this
			});
			this.on('resize', this.resize, this);
			this.frameEvents = true;
		}
	},
	//function called after each load of a new page frame
	loadFrameInfos: function() {
		if (this.id != 'public' && this.getEl().isMasked()) {
			//remove mask on frame
			this.getEl().unmask();
		}
		if (this.disabled) {
			this.setDisabled(false);
		}
		try {
			//get frame and document from event
			this.loadFrameDocument();
			var win = this.getWin();
			Automne.catchF5(this.getDoc(), win);
		} catch (e) {
			//an error occured during frame location analysis. Recreate frame content.
			this.resetFrame();
		}
		
		//for all browsers except gecko, set an onclick event to remove search engine if displayed
		//use onclick because ext event does not work on iframe document
		try {
			if (!Ext.isGecko && !this.frameDocument.onclick) {
				this.frameDocument.onclick = Automne.view.removeSearch;
			}
		} catch (e) {
			pr(e, 'error');
		}
		//catch frame links
		if (!this.allowFrameNav) {
			pr('Catch '+ this.id +' frame links');
			this.catchFrameLinks();
		}
		//if this frame is the edit one, launch edition mode
		if (this.id == 'edit' && this.getDoc()) {
			pr('Launch edit mode');
			//force reload page infos without reloading the frame itself
			Automne.tabPanels.getPageInfos({
				pageId:		this.pageId,
				noreload:	true
			});
		}
		//check if page load came from a valid frame click
		if (this.id == 'public' && win.location.href && win.location.search.indexOf('_dc') === -1) {
			//try to guess automne installation path if not already set
			if (Automne.context == false || (Automne.context.path == undefined && window.location.pathname.indexOf('/automne/admin/') >= 1)) {
				Automne.context = {};
				Automne.context.path = window.location.pathname.substr(0, window.location.pathname.indexOf('/automne/admin/'));
			}
			if (win.location.href.indexOf(Automne.context.path + '/automne/admin/') === -1) {
				//display redirection message
				this.setFrameURL(Automne.context.path + '/automne/admin/page-redirect-info.php?url=' + win.location.href);
				this.reload();
			}
		} else if(this.pageId && this.pageId != 'false') {
			//add page to history
			Ext.History.add('page:' + this.pageId, true);
		}
		//show frame
		this.frameEl.removeClass('x-hide-visibility');
		//to avoid IE bug on frame load
		if (Ext.isIE) {
			this.resize();
		}
	},
	//resize frame according to panel size
	resize: function() {
		if (!this.frameEl || !this.body) {
			return;
		}
		var box = this.body.getBox();
		if (!box.width || !box.height) {
			return;
		}
		this.frameEl.setWidth(box.width);
		this.frameEl.setHeight(box.height);
	},
	//catch all click into frame links and form submission to redirect action
	catchFrameLinks: function () {
		Automne.utils.catchLinks(this.frameDocument, this.id, this.frameEl.dom.contentWindow);
	},
	//reload frame content
	reload: function (force) {
		this.forceReload = force || this.forceReload;
		if (this.loadFrameDocument()) {
			if (this.frameDocument) {
				if (!this.frameURL) {
					pr('Reload '+ this.id +' tab queried but no URL found for frame => skip.');
					return false;
				}
				pr('Reload '+ this.id +' tab => Get : '+this.frameURL);
				//set mask on frame during reload
				if (this.id != 'public' && !Ext.isIE) {
					this.getEl().mask(Automne.locales.loading);
				}
				try {
					var location = '';
					var parts = this.frameURL.split('#');
					if (parts[1]) {
						location = parts[0] + ((parts[0].indexOf('#') === -1) ? '?' : '&') + '_dc='+ (new Date()).getTime() + ((this.editable) ? '&editId='+ this.editId : '') + '&atm-context=adminframe';
						location += '#' + parts[1];
					} else {
						location = this.frameURL + ((this.frameURL.indexOf('?') === -1) ? '?' : '&') + '_dc='+ (new Date()).getTime() + ((this.editable) ? '&editId='+ this.editId : '') + '&atm-context=adminframe';
					}
					this.frameDocument.location = location;
				} catch (e) {
					pr(e, 'error');
				}
				this.forceReload = false;
			}
		}
	},
	setReloadable: function(reloadable) {
		this.reloadable = reloadable;
		if (Automne.tabPanels.getActiveTab().id == this.id) {
			var el = Automne.tabPanels.getTabEl(this);
        	if(reloadable) {
				Ext.fly(el).addClass('x-tab-strip-reloadable');
			} else {
				Ext.fly(el).removeClass('x-tab-strip-reloadable');
			}
		}
	},
	//noreload of the page
	noreload: function() {
		this.noReload = true;
	},
	//set a flag to force next reload of the frame (even if url is the same)
	setForceReload: function(force) {
		this.forceReload = force;
	},
	//frame url setters and getters
	setFrameURL: function(url) { 
		this.frameURL = url;
	},
	getFrameURL: function() {
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
		this.frameDocument = this.getDoc();
		return true;
	},
	getDoc : function(){
		if (!this.frameEl) return false;
		return Ext.isIE ? this.getWin().document : (this.frameEl.dom.contentDocument || this.getWin().document);
	},
	// private
	getWin : function(){
		if (!this.frameEl) {
			return false;
		}
		var win = false;
		try {
			win = this.frameEl.dom.contentWindow || window.frames[this.frameEl.dom.name];
		} catch (e) {
			pr(e, 'error');
		}
		return win;
	},
	resetFrame: function() {
		pr('Iframe error : reset it');
		if (this.frameEl) {
			//pr(this.frameEl);
			//pr(this.frameEl.dom.contentDocument.URL);
			var frameParent = this.frameEl.parent();
			this.frameEl.remove();
			this.frameEl = frameParent.createChild({tag:'iframe', id:this.id + 'Frame', width:'100%', height:'100%', frameborder:'no', src:Ext.SSL_SECURE_URL});
			this.setFrameURL(Automne.context.path + '/automne/admin/frame-error.php');
			if (this.frameEl) {
				this.frameEvents = false;
				//set frame events
				this.setFrameEvents();
				this.resize();
				this.reload();
			}
		}
	}
});
Ext.reg('framePanel', Automne.framePanel);