/**
  * Automne Javascript file
  *
  * Automne.framePanel Extension Class for Ext.Panel
  * Provide all events and watch for contained frames
  * @class Automne.framePanel
  * @extends Ext.Panel
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: framepanel.js,v 1.13 2009/04/20 15:13:04 sebastien Exp $
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
			height:			'100%',
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
						Automne.message.show(al.csClickOnRed, '', Automne.tabPanels.getActiveTab().frameEl);
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
						fields:				['id', 'label', 'image'],
						id: 				'id'
					}),
					forceSelection:		true,
					valueField:			'id',
					hiddenName: 		'addRow',
					displayField:		'label',
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
							'<table border="0"><tr><td valign="middle" style="width:72px;"><img src="{image}" /></td><td valign="middle" style="padding:4px;"><strong>{label}</strong></td></tr></table>',
						'</div></tpl>'
					),
					itemSelector: 		'div.atm-search-item'
				}),{
					id:				'addSelectedRow'+ this.editId,
					xtype:			'tbbutton',
					text:			al.add,
					tooltip:		al.csAddRowToPosition,
					scope:			this,
					hidden:			true,
					iconCls:		'atm-pic-ok',
					handler:		function() {
						//display window to select row to add according to queried CS
						var combo = Ext.getCmp('addRowCombo'+this.editId);
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
						var cs = this.frameEl.dom.contentWindow.atmContent.getCS(comboParams.cs);
						//send all datas to server to create new row and get row HTML code
						Automne.server.call('page-content-controler.php', cs.addNewRow, params, cs);
						//hide all drop zones
						this.frameEl.dom.contentWindow.atmContent.hideZones();
						//init toolbar and row mask
						this.frameEl.dom.contentWindow.atmContent.init();
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
								Automne.server.call({
									url:				'page-controler.php',
									params: 			{
										currentPage:		this.pageId,
										action:				'validate_draft'
									}
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
					text:			'Aperçu',
					tooltip:		'Aperçu de votre contenu en cours de modification.',
					scope:			this,
					hidden:			true,
					iconCls:		'atm-pic-preview',
					handler:		function(button) {
						var window = new Automne.frameWindow({
							id:				'editPrevizDraftWindow',
							frameURL:		'/automne/admin/page-previsualization.php?currentPage='+this.pageId+'&draft=true',
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
		if (oldTab && oldTab.id == 'edit' && (newTab.id == 'edited' || newTab.id == 'public') && oldTab.frameEl && oldTab.frameEl.dom && oldTab.frameEl.dom.contentWindow && oldTab.frameEl.dom.contentWindow.atmContent) {
			oldTab.frameEl.dom.contentWindow.atmContent.endEdition('tab');
		}
		if (force && this.disabled) {
			this.setDisabled(false);
		}
		//if frame element is known (this is not the first activation of panel), then force reload it
		if (!this.noReload && this.frameEl && (this.pageId != Automne.tabPanels.pageId || (this.frameDocument && this.frameDocument.location.href.indexOf(this.frameURL) === -1) || newTab.id == 'edit')) {
			this.reload();
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
		//get frame and document from event
		this.loadFrameDocument();
		var win = this.getWin();
		Automne.catchF5(this.getDoc(), win);
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
			//force reload page infos without reloading the frame itself
			Automne.tabPanels.getPageInfos({
				pageUrl:	win.location.href,
				noreload:	true
			}, function(response){
				if (response.getResponseHeader['X-Automne-PageId']) {
					//add page to history
					Ext.History.add('page:' + response.getResponseHeader['X-Automne-PageId'], true);
				}
			});
		} else if(this.id == 'public' && this.pageId && this.pageId != 'false') {
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
		this.frameEl.setWidth(this.body.getBox().width);
		this.frameEl.setHeight(this.body.getBox().height);
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
				pr('Reload '+ this.id +' tab => Get : '+this.frameURL);
				//set mask on frame during reload
				if (this.id != 'public' && !Ext.isIE) {
					this.getEl().mask(Automne.locales.loading);
				}
				this.frameDocument.location = this.frameURL + ((this.frameURL.indexOf('?') === -1) ? '?' : '&') + '_dc='+ (new Date()).getTime() + ((this.editable) ? '&editId='+ this.editId : '');
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
	}
});
Ext.reg('framePanel', Automne.framePanel);