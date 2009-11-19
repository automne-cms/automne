/**
  * Automne Javascript file
  *
  * Automne.utils
  * Provide utilities methods
  * @class Automne.utils
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: utils.js,v 1.5 2009/11/19 16:09:14 sebastien Exp $
  */
Automne.utils = {
	edit:		false,
	//catch all text inputs in page and put focus on the first one
	focusinput: function(target) {
		var input, inputs = (target || document).getElementsByTagName('INPUT');
		for (var i = 0;i < inputs.length; i++) {
			if (inputs[i].type == 'text') {
				input = Ext.get(inputs[i]);
				if (input.dom.value){ input.dom.select(); } else { input.focus();}
				return true;
			}
		}
		return false;
	},
	getPageById: function (pageId, tab) {
		pr('getPageById : '+pageId);
		if (tab) {
			Automne.tabPanels.getPageInfos({
				pageId:		pageId
			}, Automne.tabPanels.setActiveTab.createDelegate(Automne.tabPanels, [tab]));
		} else {
			Automne.tabPanels.getPageInfos({
				pageId:		pageId
			});
		}
	},
	//update a resource status anywhere in the view
	updateStatus: function (statusId, newStatus, newTinyStatus, unlock) {
		//check for public tab : if status is for current viewved page, it must be reloaded
		if (Automne.tabPanels) {
			var publicPanel = Automne.tabPanels.getItem('public');
			if (publicPanel) {
				var publicTab = Automne.tabPanels.getTabEl(publicPanel);
				if (publicTab) {
					if (Ext.select('span.' + statusId, false, publicTab).getCount()) {
						Automne.tabPanels.getPageInfos({
							pageId:			publicPanel.pageId,
							regenerate:		(Automne.tabPanels.getActiveTab().id == 'public'),
							unlock:			(unlock == true ? false : true)
						});
						pr('switchStatus : page founded and reloaded');
					}
				}
			}
		}
		//then found all status icon
		var count = 0;
		Ext.select('span.' + statusId, true).each(function(el) {
			if (el.hasClass('atm-status')) {
				Ext.DomHelper.insertBefore(el, newStatus);
				el.remove();
				count++;
			} else if (el.hasClass('atm-status-tiny')) {
				Ext.DomHelper.insertBefore(el, newTinyStatus);
				el.remove();
				count++;
			}
		});
		//try to refresh validation panel
		var validationPanel = Ext.getCmp('validationsPanel');
		if (validationPanel) validationPanel.refresh();
		pr('switchStatus : '+ statusId +' : '+ count +' statuses switched');
	},
	//remove a resource anywhere in the view.
	removeResource: function (module, resourceId) {
		//TODOV4 : handle page deletion / archive
		//check in all components if one use the resource
		Ext.ComponentMgr.all.each(function(cmp){
			if (cmp.updateResource) {
				cmp.updateResource('delete', module, resourceId);
			}
		});
	},
	getValidationByID: function (el, module, resourceId) {
		pr('getValidationByID for module : '+module+', resource : '+resourceId);
		var el = Ext.get(el);
		var e = Ext.EventObject;
		if (el.dom.ownerDocument != document) {
			//if call came from a frame, open directly the validations page (cannot create menu in frame)
			var win = new Automne.Window({
				id:				'validationsWindow',
				autoLoad:		{
					url:			'validations.php',
					params:			{
						winId:			'validationsWindow',
						resource:		resourceId,
						module:			module
					},
					nocache:	true,
					scope:		this
				}
			});
			//display window
			win.show(el);
			return true;
		}
		//check if menu exists, else create it
		if (!Ext.menu.MenuMgr.get('validationMenu')) {
			var menu = new Automne.Menu({
				id: 'validationMenu'
			});
		} else {
			var menu = Ext.menu.MenuMgr.get('validationMenu');
			menu.removeAll();
		}
		//set menu title
		if (el.first('img') && el.first('img').getAttributeNS('ext', 'qtip')) {
			menu.addText(el.first('img').getAttributeNS('ext', 'qtip'));
			menu.addSeparator();
		}
		//add validate item
		menu.addItem(new Ext.menu.Item({
			text: 				Automne.locales.validate,
			handler: 			function() {
				Automne.server.call('validations-controler.php', function(response, options, jsonResponse){
					if (!jsonResponse.success) {
						//get validation message
						if (response.responseXML && response.responseXML.getElementsByTagName('message').length) {
							var message = response.responseXML.getElementsByTagName('message').item(0).firstChild.nodeValue;
						}
						Automne.message.popup({
							msg: 				message,
							buttons: 			Ext.MessageBox.OK,
							closable: 			false,
							icon: 				Ext.MessageBox.WARNING
						});
					}
				}, {
					action:				'validateById',
					resource:			resourceId,
					module:				module,
					evalMessage:		false
				});
			}
		}));
		//add validate options item
		menu.addItem(new Ext.menu.Item({
			text: 				Automne.locales.validateOptions,
			handler: 			function() {
				var win = new Automne.Window({
					id:				'validationsWindow',
					autoLoad:		{
						url:			'validations.php',
						params:			{
							winId:			'validationsWindow',
							resource:		resourceId,
							module:			module
						},
						nocache:	true,
						scope:		this
					}
				});
				//display window
				win.show(el);
			}
		}));
		//hide current qtip if any
		Ext.QuickTips.getQuickTip().hide();
		//view menu
		if (e.type == 'mouseup') {
			if (menu.isVisible()) {
				menu.hide();
			} else {
				menu.show(el);
			}
		}
	},
	//catch all click into root to redirect action
	catchLinks: function(root, source, win) {
		if (root.dom) {
			root = root.dom;
		}
		//First catch links and area tags
		var links = Ext.DomQuery.select('a', root).concat(Ext.DomQuery.select('area', root));
		for (var i=0; i < links.length; i++) {
			var link = Ext.get(links[i]);
			//only links with href, which are not in a new window, not an anchor and not a javascript instruction
			if (link.dom.target != "_blank" && link.dom.href && link.dom.href.substr(-1) != '#' && link.dom.href.indexOf('javascript') === -1) {
				if (source != 'edit') {
					//do not catch anchor link to the same page
					var isAnchor = false;
					if (link.dom.href.indexOf('#') !== -1) {
						var partsLink = link.dom.href.split('#');
						if (root.location.href.indexOf(partsLink[0]) !== -1) {
							isAnchor = true;
						}
					}
					if (!isAnchor) {
						link.on('click', function(e) {
							pr('Click on link '+this.dom.href);
							e.stopEvent();
							//call server to get page infos using page url
							Automne.tabPanels.getPageInfos({
								pageUrl:		this.dom.href
							});
						}, link);
					}
				} else {
					link.on('click', function(e) {
						pr('Click on link '+this.dom.href);
						e.stopEvent();
						win.atmContent.endEdition('link', this);
					}, link);
				}
			}
		}
		//Then catch forms
		var forms = Ext.DomQuery.select('form', root);
		for (var i=0; i < forms.length; i++) {
			var form = Ext.get(forms[i]);
			if (source != 'public') { //stop all forms submition except for public frame
				if (form.dom.target != "_blank") {
					form.on('submit', function(e) {
						e.stopEvent();
						//send a message to user
						Automne.message.popup({
							title: Automne.locales.actionImpossible, 
							msg: Automne.locales.cantSubmitFormPage,
							buttons: Ext.MessageBox.OK,
							icon: Ext.MessageBox.WARNING,
							animEl: this
						});
					}, form);
				}
			} else {
				if (form.getAttribute('target') != "_blank") {
					form.dom.target = '_blank';
				}
				form.on('submit', function(e) {
					e.stopEvent();
					//send a message to user
					Automne.message.popup({
						title:			Automne.locales.formSubmit, 
						msg:			Automne.locales.formSubmitDesc,
						buttons:		Ext.MessageBox.OKCANCEL,
						icon:			Ext.MessageBox.QUESTION,
						animEl:			this,
						scope:			this,
						fn: 		function (button) {
							if (button == 'cancel') {
								return;
							}
							this.dom.submit();
						}
					});
				}, form);
			}
		}
	}
};