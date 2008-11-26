/**
  * Automne Javascript main JS file
  *
  * Provide all specific JS codes to manage Automne client viewport
  *
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

Ext.namespace('Automne');

// create application
Automne = {
	/*************************************
	*		Automne public vars		 *
	*************************************/
	//user context vars
	context:		false,
	//logout queried
	logout:			false,
	//interface elements
	tabPanels:		false,
	east:			false,
	viewPort:		false,
	cookie:			false,
	/*************************************
	*		Automne public methods	  *
	*************************************/
	init: function() {
		//check for navigator version
		if (!(Ext.isIE && (Ext.isIE6 || Ext.isIE7)) && !(Ext.isGecko || Ext.isSafari || Ext.isOpera )) {
			window.top.location.replace('./navigator.php');
		}
		//check for inframe
		//if (window.top != window.self) window.top.location.replace('./index.php');
		//init quicktips
		Ext.QuickTips.init();
		// Remove autohide on quicktip
		Ext.apply(Ext.QuickTips.getQuickTip(), {dismissDelay:0});

		//init cookie provider
		Automne.cookie = new Ext.state.CookieProvider({
			path: 		"/",
			expires: 	new Date(new Date().getTime()+(1000*60*60*24*90)) //90 days
			/*,domain: 	window.location.host*/
		});
		Ext.state.Manager.setProvider(Automne.cookie);
		
		//create viewport and first tab panel
		Automne.viewPort = new Ext.Viewport({
			layout:			'border',
			id:				'viewPort',
			items: [
				new Automne.tabPanel({
					region: 		'center',
					height:			'100%',
					xtype: 			'tabpanel',
					hideBorders:	true,
					activeItem: 	0,
					id:				'tabPanels',
					items: {
						title:			'-',
						xtype:			'framePanel',
						frameURL:		'/',
						hideBorders:	true,
						allowFrameNav:	false,
						height:			'100%',
						autoScroll:		true,
						id:				'public'
					}
				}), new Automne.sidePanel({
					region:			'east',
					id:				'sidePanel',
					layout:			'atm-border',
					collapsible: 	true,
					collapseMode:	'mini',
					collapsed:		true,
					split:			true,
					width: 			290,
					minWidth:		290,
					maxWidth:		290,
					border:			false
				}) 
			]
		});
		//set Global Ajax events
		Ext.Ajax.on({'beforerequest': Automne.server.showSpinner, 'requestcomplete': Automne.server.hideSpinner, scope: this});
		
		//check for authenticated user
		Automne.server.call('login.php' + ((Automne.logout) ? '?cms_action=logout' : ''));
		
		//remove loading element
		setTimeout(function(){
			Ext.get('atm-center').remove();
			Ext.get('atm-loading-mask').fadeOut({remove:true, callback:Automne.end});
		}, 250);
	},
	//load Automne admin interface
	load: function() {
		//set viewPort var
		Automne.viewPort = Ext.getCmp('viewPort');
		//set tabPanels var
		Automne.tabPanels = Ext.getCmp('tabPanels');
		//set east panel var
		Automne.east = Ext.getCmp('sidePanel');
		Automne.east.load({
			url:		'side-panel.php',
			params:		{
				winId:		'sidePanel'
			},
			nocache:	true,
			scope:		this
		});
		if (window.location.search.indexOf('pageId') !== -1) {
			//get page to display from url parameters
			var config = Ext.urlDecode(window.location.search.substr(1));
			if (config.tab) {
				config.fromTab = config.tab;
			}
		} else {
			//need to get public frame infos
			var config = {
				pageUrl:		Ext.getCmp('public').getFrameURL(),
				followRedirect:	true
			}
		}
		//get page infos and force reload public frame (if active)
		Automne.tabPanels.getPageInfos(config, function(){
			if (Automne.tabPanels.getActiveTab().id == 'public') {
				Automne.tabPanels.getActiveTab().reload();
			}
		});
		
		//display east panel
		Automne.east.expand();
		//then start timer to collapse it
		Automne.east.collapseTimer();
	},
	end: function() {
		//check for input focus in current page
		if (!Automne.utils.focusinput()) {
			//or check into iframes if any
			var iframes = document.getElementsByTagName('IFRAME');
			var focusok = false;
			if (iframes.length) {
				for (var i = 0;!focusok && i < iframes.length; i++) {
					try {
						focusok = Automne.utils.focusinput(iframes[i].contentWindow.document);
					} catch(e) {
						pr(e);
					}
				}
			}
		}
	}
};

/////////////////////////
// SERVER CALL METHODS //
/////////////////////////
Automne.server = {
	call: function (url, fcn, params, scope) {
		var config = {};
		var defaultConfig = {
			disableCaching:		true,
			success: 			Automne.server.evalResponse,
			failure: 			Automne.server.failureResponse,
			scope:				this
		};
		if (typeof url == 'object') {
			config = Ext.apply(config, url, defaultConfig);
		} else {
			config = Ext.apply(config, {
				url:			url,
				fcnCallback: 	(fcn) ? fcn : '',
				callBackScope: 	(scope) ? scope : false,
				params: 		(params) ? params : ''
			}, defaultConfig);
		}
		// send request
		Ext.Ajax.request(config);
	},
	//show loading spinner on server call
	showSpinner: function (conn, options) {
		if (!options.params || options.params.nospinner !== true) {
			Ext.get('atm-server-call').show();
		}
		//log ajax call for IE
		if (Ext.isIE || Ext.isSafari) {
			pr('Call to '+options.url);
		}
	},
	//hide loading spinner after server call
	hideSpinner: function () {
		Ext.get('atm-server-call').hide();
	},
	//method used for a server call : eval response
	evalResponse: function (response, options) {
		//check for XML content
		if (response.responseXML == undefined) {
			var msg = Automne.locales.ajaxError;
			if (response.responseText) {
				msg += '<br />' + response.responseText;
			}
			//TODOV4 : this message must be on top of all (try to set zindex highter)
			Automne.message.popup({
				msg: 				msg,
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});
			return;
		}
		var content = '';
		//define shortcut
		var xml = response.responseXML;
		//check for errors returned
		if (xml.getElementsByTagName('error').length
			&& xml.getElementsByTagName('error').item(0).firstChild.nodeValue != 0
			&& xml.getElementsByTagName('errormessage').item(0).childNodes.length) {
			Automne.console.throwErrors(xml.getElementsByTagName('errormessage').item(0).firstChild.nodeValue);
		}
		//check for rawdatas returned
		if (xml.getElementsByTagName('rawdatas').length) {
			Automne.console.throwRawDatas(xml.getElementsByTagName('rawdatas').item(0).firstChild.nodeValue);
		}
		//display message if any
		if (options.evalMessage !== false && xml && xml.getElementsByTagName('message').length) {
			var win = Ext.WindowMgr.getActive();
			Automne.message.show('', xml.getElementsByTagName('message').item(0).firstChild.nodeValue, win || document);
		}
		//scripts in progress
		if (xml && xml.getElementsByTagName('scripts').length) {
			Automne.view.scripts(xml.getElementsByTagName('scripts').item(0).firstChild.nodeValue, options);
		} else {
			Automne.view.scripts(0, options);
		}
		//execution stats
		if (xml && xml.getElementsByTagName('stats').length) {
			pr(xml.getElementsByTagName('stats').item(0).firstChild.nodeValue, 'debug');
		}
		//extract json or content datas from response if any
		if (options.evalJSon !== false && xml && xml.getElementsByTagName('jsoncontent').length) {
			var jsonResponse = {};
			try{
				eval('jsonResponse = '+xml.getElementsByTagName('jsoncontent').item(0).firstChild.nodeValue+';');
			} catch(e) {
				pr(e);
			}
		} else if(options.evalContent !== false && xml && xml.getElementsByTagName('content').length) {
			content = xml.getElementsByTagName('content').item(0).firstChild.nodeValue;
		}
		//check for action message returned
		if (options.evalJS !== false && xml && xml.getElementsByTagName('jscontent').length) {
			//otherwise, try to eval JS if any
			try{
				eval(xml.getElementsByTagName('jscontent').item(0).firstChild.nodeValue);
			} catch(e) {
				pr(e);
			}
		}
		if (xml && xml.getElementsByTagName('disconnected').length) {
			Automne.view.disconnect();
		}
		if (options.fcnCallback != '' && typeof options.fcnCallback == 'function') {
			//send to callback if any
			options.fcnCallback.call(options.callBackScope || options.scope || this || window, response, options, jsonResponse || content);
		} else {
			return jsonResponse || content;
		}
	},
	//method used for a server call : eval response
	failureResponse: function (response, options) {
		//TODOV4 : test this function
		var msg = Automne.locales.ajaxError;
		if (response && response.responseText) {
			msg += '<br />' + response.responseText;
		}
		Automne.message.popup({
			msg: 				msg,
			buttons: 			Ext.MessageBox.OK,
			closable: 			false,
			icon: 				Ext.MessageBox.ERROR
		});
	}
};
///////////////////////////
// USER MESSAGES METHODS //
///////////////////////////
Automne.message = {
	msgCt:		false,
	show: function (title, message, el){
		pr('Show message');
		if(!Automne.message.msgCt){
			Automne.message.msgCt = Ext.DomHelper.insertFirst(document.body, {id:'atm-msg-div'}, true);
		}
		if (message && !title) {
			title = message;
			message = null;
		}
		if (message && title) {
			message = '<br />' + message;
		}
		var boxtpl = ['<div class="msg">',
			'<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>',
			'<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><strong>', title, '</strong>', message, '</div></div></div>',
			'<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>',
			'</div>'].join('');
		var win;
		if	(el && el.getEl) {
			win = el;
			el = win.getEl();
		}
		Automne.message.msgCt.alignTo(el || document, 't-t');
		var m = Ext.DomHelper.insertFirst(Automne.message.msgCt, {html:boxtpl}, true);
		m.slideIn('t').pause(4).ghost("t", {remove:true});
		if (win && win.on) {
			win.on('close',function(){m.remove();});
		}
	},
	popup: function(config) {
		return Ext.MessageBox.show(config);
	}
};
///////////////////////
// UTILITIES METHODS //
///////////////////////
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
			Automne.tabPanels.setActiveTab(tab);
		}
		Automne.tabPanels.getPageInfos({
			pageId:		pageId
		});
	},
	//update a resource status anywhere in the view
	updateStatus: function (statusId, newStatus, newTinyStatus) {
		//check for public tab : if status is for current viewved page, it must be reloaded
		if (Automne.tabPanels) {
			var publicPanel = Automne.tabPanels.getItem('public');
			var publicTab = Automne.tabPanels.getTabEl(publicPanel);
			if (publicTab) {
				if (Ext.select('span.' + statusId, false, publicTab).getCount()) {
					Automne.tabPanels.getPageInfos({
						pageUrl:		publicPanel.getFrameURL(),
						regenerate:		(Automne.tabPanels.getActiveTab().id == 'public'),
						reload:			true
					});
					pr('switchStatus : page founded and reloaded');
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
	editor: function(el, startValue) {
		//complete last edit if editor already exists
		if (Automne.utils.edit) Automne.utils.edit.completeEdit();
		//create an editor for this element
		Automne.utils.edit = new Automne.Editor(el);
		//then start edition
		Automne.utils.edit.startEdit(null, startValue);
	},
	//generic function to delete editor
	deleteEditor: function() {
		if (Automne.utils.edit) {
			Automne.utils.edit.cancelEdit();
			Automne.utils.edit.destroy();
			Automne.utils.edit = false;
		}
	},
	//catch all click into root to redirect action
	catchLinks: function(root, source) {
		if (root.dom) {
			root = root.dom;
		}
		//First catch links and area tags
		var links = Ext.DomQuery.select('a', root).concat(Ext.DomQuery.select('area', root));
		for (var i=0; i < links.length; i++) {
			var link = Ext.get(links[i]);
			if (link.dom.target != "_blank" && link.dom.href && link.dom.href.substr(-1) != '#') {
				if (source != 'edit') {
					link.on('click', function(e) {
						pr('Click on link '+this.dom.href);
						e.stopEvent();
						//call server to get page infos using page url
						Automne.tabPanels.getPageInfos({
							pageUrl:		this.dom.href
						});
					}, link);
				} else {
					link.on('click', function(e) {
						pr('Click on link '+this.dom.href);
						e.stopEvent();
						Automne.content.endEdition('link', this);
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
				if (form.dom.target != "_blank" && form.dom.action && form.dom.action.indexOf(root.location.href) === -1) {
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
			}
		}
	}
};
///////////////////////
// USER VIEW METHODS //
///////////////////////
Automne.view = {
	tree: function(eId, heading, currentPage) {
		pr('tree for el : '+eId+', heading : '+heading+ ', page : '+currentPage);
		//create window element
		var winid = Ext.id();
		var win = new Automne.Window({
			id:				winid,
			currentPage:	(currentPage) ? currentPage : 1,
			autoLoad:		{
				url:		'tree.php',
				params:		{
					winId:			winid,
					heading:		heading,
					el:				eId,
					currentPage:	(currentPage) ? currentPage : 1
				},
				nocache:	true,
				scope:		this
			}
		});
		//display window
		win.show(eId);
		//set window specific updater
		win.body.getUpdater().renderer = new Automne.windowRenderer();
		return win;
	},
	user: function(userId) {
		Automne.message.show('TODOV4 : Show user '+ userId +' (function Automne.view.user)');
	},
	maxScripts:		0,
	currentScripts:	0,
	scriptsUpdate: 	false,
	scriptsTip:		false,
	scripts: function(scriptsleft, options) {
		var av = Automne.view;
		av.currentScripts = parseInt(scriptsleft);
		if (av.scriptsUpdate && av.currentScripts == 0) {
			av.scriptsUpdate = scriptsUpdate = false;
		}
		//check for script update
		var scriptsUpdate = false;
		if ((av.scriptsUpdate == false || (options.params && options.params.refreshScripts == true)) && av.currentScripts > 0) {
			av.scriptsUpdate = scriptsUpdate = true;
		}
		//update sidepanel script bar
		if (av.currentScripts > av.maxScripts) {
			av.maxScripts = av.currentScripts;
		}
		if (av.currentScripts || av.scriptsUpdate || scriptsUpdate) {
			pr('current scripts : '+av.currentScripts+', scriptsUpdate : '+av.scriptsUpdate+', update : '+scriptsUpdate);
		}
		var el = Ext.get('headPanelBar');
		if (el) {
			//request scripts count refresh
			if (scriptsUpdate) {
				setTimeout(function(){
					Automne.server.call('scripts.php', '', {
						refreshScripts: true, 
						nospinner: 		true
					});
				}, 5000);
			}
			var size = (av.currentScripts != 0 && av.maxScripts != 0) ? parseInt((av.currentScripts * 247) / av.maxScripts) : 0;
			size += 30; //for padding
			el.setWidth(size, true);
			if (Ext.get('headPanelBarInfos')) {
				if (av.scriptsTip) av.scriptsTip.destroy();
				var toptext = av.currentScripts ? 'Scripts en cours de traitement ... '+av.currentScripts+' scripts restant' : 'Aucun script en cours de traitement.';
				av.scriptsTip = new Ext.ToolTip({
					target: 		Ext.get('headPanelBarInfos'),
					html: 			toptext
				});
			}
		} else {
			av.scriptsUpdate = false;
		}
	},
	disconnect: function() {
		//check for authenticated user
		Automne.server.call('login.php?cms_action=login');
	}
};
/////////////////////////////
// USER CATEGORIES METHODS //
/////////////////////////////
//Modules elements rights functions
Automne.categories = {
	onRow: function (obj) {
		if (obj != 'undefined') {
			obj.style.backgroundColor = '#FDF5A2';
		}
	},
	outRow: function (obj) {
		if (obj != 'undefined') {
			obj.style.backgroundColor = '';
		}
	},
	unselectOthers: function (catID, catValue, count, hash) {
		var clearances = [0,1,2,3];
		var clearancesColors = ['#FF7E71', '#E2FAAA', '#CFE779', '#85A122'];
		var parentClearance;
		
		//for a given UL, get all Li then mark inputs to display or hide. This function use reference vars
		var getInputs = function (el) {
			var childs = el.childNodes;
			var inputs = new Array();
			//get all checkboxes for Lis of this UL
			for (var i = 0, childslen = childs.length; i < childslen; i++) {
				if (childs[i].tagName == 'LI') {
					var checked = false;
					var catId = childs[i].id.split(/-/)[2];
					var liInputs = Ext.get('checkboxes-'+ hash +'-' + catId).dom.getElementsByTagName('INPUT');
					for (var j = 0, inputlen = liInputs.length; j < inputlen; j++) {
						inputs[inputs.length] = liInputs[j];
						if (liInputs[j].checked) {
							checked = true;
						}
					}
					if (!checked && Ext.get('ul-'+ hash +'-' + catId)) {
						getInputs(Ext.get('ul-'+ hash +'-' + catId).dom);
					}
				}
			}
			for (var i = 0, inputlen = inputs.length; i < inputlen; i++) {
				if (inputs[i].value == catValue) {
					if (checkbox.checked == true) {
						inputsToHide[inputsToHide.length] = inputs[i];
					} else {
						inputsToShow[inputsToShow.length] = inputs[i];
					}
				} else if (inputs[i].style.display == 'none') {
					inputsToShow[inputsToShow.length] = inputs[i];
				} else if (checkbox.checked == false && inputs[i].value == parentClearance) {
					inputsToHide[inputsToHide.length] = inputs[i];
				}
			}
		}
		
		//get parent clearance (from the disabled checkbox of this category)
		for (var i = 0, clearlen = clearances.length; i < clearlen; i++) {
			if (clearances[i] != catValue && Ext.get('check-'+ hash +'-' + catID + '_' + clearances[i]) && Ext.get('check-'+ hash +'-' + catID + '_' + clearances[i]).dom.style.display == 'none') {
				parentClearance = clearances[i];
			}
		}
		//set li color and disable other checkbox of the line (if any)
		if (Ext.get('check-'+ hash +'-' + catID + '_' + catValue).dom.checked == true) {
			//unselect others from the same line
			for (var i=0, clearlen = clearances.length; i < clearlen; i++) {
				if (catValue != clearances[i]) {
					if (Ext.get('check-'+ hash +'-' + catID + '_' + clearances[i])) {
						Ext.get('check-'+ hash +'-' + catID + '_' + clearances[i]).dom.checked = false;
					}
				}
			}
			//set color
			Ext.get('li-'+ hash +'-' + catID).dom.style.backgroundColor=clearancesColors[catValue];
		} else {
			//set color
			Ext.get('li-'+ hash +'-' + catID).dom.style.backgroundColor = (count == 1) ? clearancesColors[0] : '';
		}
		//then allow or disallow checkboxes below the checked one
		if (Ext.get('ul-'+ hash +'-' + catID)) {
			var checkbox = Ext.get('check-'+ hash +'-' + catID + '_' + catValue).dom;
			var inputsToHide = new Array();
			var inputsToShow = new Array();
			var resetBackground = new Array();
			var stop = false;
			//for this UL, get all Li directly below then mark inputs to display or hide
			getInputs(Ext.get('ul-'+ hash +'-' + catID).dom);
			for (var i = 0, hidelen = inputsToHide.length; i < hidelen; i++) {
				//if li is already checked, we must reset background
				if (inputsToHide[i].checked) {
					Ext.get('li-'+ hash +'-' + inputsToHide[i].name.substr(3)).dom.style.backgroundColor='';
				}
				inputsToHide[i].checked = false;
				inputsToHide[i].style.display = 'none';
			}
			for (var i = 0, showlen = inputsToShow.length; i < showlen; i++) {
				inputsToShow[i].checked = false;
				inputsToShow[i].style.display = 'block';
			}
		}
		//force clearance 'none' checking
		if (count == 1 && Ext.get('check-'+ hash +'-' + catID + '_' + catValue).dom.checked == false) {
			Ext.get('check-'+ hash +'-' + catID + '_' + 0).dom.checked = true;
			Automne.categories.unselectOthers(catID,0, 1, hash);
		} else {
			Automne.categories.saveValues(hash);
		}
	},
	saveValues: function (hash) {
		//get all checked inputs
		var inputs = Ext.get('categoriesList-'+ hash).dom.getElementsByTagName('INPUT');
		var profileId =  Ext.get('profile-'+ hash).dom.value;
		var module =  Ext.get('module-'+ hash).dom.value;
		var type =  Ext.get('type-'+ hash).dom.value;
		var rights = '';
		for (var i = 0, inputlen = inputs.length; i < inputlen; i++) {
			if (inputs[i].type == 'checkbox' && inputs[i].checked) {
				rights += (rights) ? ';':'';
				rights += inputs[i].name.substr(3) + ',' + inputs[i].value;
			}
		}
		if (type == 'user') {
			Automne.server.call('users-controler.php', Ext.emptyFn, {
				userId:			profileId,
				action:			'categories-rights',
				module:			module,
				rights:			rights,
				catIds:			Ext.get('catIds-'+hash).dom.value
			});
		} else {
			Automne.server.call('groups-controler.php', Ext.emptyFn, {
				groupId:		profileId,
				action:			'categories-rights',
				module:			module,
				rights:			rights,
				catIds:			Ext.get('catIds-'+hash).dom.value
			});
		}
	},
	open: function (catId, hash, el) {
		var profileId =  Ext.get('profile-'+ hash).dom.value;
		var module =  Ext.get('module-'+ hash).dom.value;
		var type =  Ext.get('type-'+ hash).dom.value;
		if (type == 'user') {
			Automne.server.call('modules-categories-rights.php', Automne.categories.opener, {
				userId:			profileId,
				hash:			hash,
				module:			module,
				item:			catId
			});
		} else {
			Automne.server.call('modules-categories-rights.php', Automne.categories.opener, {
				groupId:		profileId,
				hash:			hash,
				module:			module,
				item:			catId
			});
		}
		Ext.get(el).remove();
	},
	opener: function(response, options, content) {
		//define shortcut
		var xml = response.responseXML;
		var li = Ext.get('li-'+ options.params.hash +'-'+ options.params.item);
		li.insertHtml('beforeEnd', content);
	}
};
//////////////////////////
// PAGE CONTENT METHODS //
//////////////////////////
Automne.content = {
	cs: 			{}, 
	updateTimer:	false,
	updateCSMask:	false,
	rowMask:		false,
	rowOver:		false,
	isValidator:	false,
	isValidable:	false,
	hasPreview:		false,
	init: function() {
		var ac = Automne.content;
		//ac.edition = true;
		if (parent.Ext.getCmp('editCancelAdd')) {
			parent.Ext.getCmp('editCancelAdd').hide();
			parent.Ext.getCmp('addRowCombo').hide();
			parent.Ext.getCmp('addSelectedRow').hide();
			parent.Ext.getCmp('editAddRow').show();
			//these buttons must be shown only if context allow it
			parent.Ext.getCmp('editSaveDraft').setVisible(Automne.content.isValidable);
			parent.Ext.getCmp('editValidateDraft').setVisible(Automne.content.isValidator);
			parent.Ext.getCmp('editPrevizDraft').setVisible(Automne.content.hasPreview);
			parent.Ext.get('selectedRow').update('');
		}
		//allow row mask to be displayed
		ac.startRowsMask();
		//add unload event on document to remove listeners
		Ext.getDoc().on('unload', function() {
			pr('Clear edition frame objects');
			//clear update timer interval
			clearInterval(ac.updateTimer);
			//remove all listeners
			for (var csId in ac.cs) {
				ac.cs[csId].removeListeners();
				delete ac.cs[csId];
			}
		}, this);
	},
	edit: function(csDatas, rowsDatas, blocksDatas) {
		var ac = Automne.content;
		//instanciate all rows objects
		var rows = {};
		for (var rowId in rowsDatas) {
			rows[rowId] = new Automne.row(rowsDatas[rowId]);
		}
		//instanciate all blocks objects
		var blocks = {};
		for (var blockId in blocksDatas) {
			blocks[blockId] = eval('new '+blocksDatas[blockId].jsBlockClass+'(blocksDatas[blockId])');
			//add block to row
			if (rows['row-'+blocksDatas[blockId].row]) {
				rows['row-'+blocksDatas[blockId].row].addBlock(blocks[blockId]);
			}
		}
		//instanciate all clientspaces objects
		ac.cs = {};
		for (var csId in csDatas) {
			ac.cs[csId] = new Automne.cs(csDatas[csId]);
			//associate rows and CS
			var count = 0;
			for(var rowId in rows) {
				if (rows[rowId].getCsId() == csId) {
					ac.cs[csId].addRow(rows[rowId]);
				}
			}
			//show CS
			ac.cs[csId].show();
		}
		//then for each CS objects, set brothers clientspaces
		for (var csId in ac.cs) {
			for (var csId2 in ac.cs) {
				if (csId != csId2) {
					ac.cs[csId].setBrother(ac.cs[csId2]);
				}
			}
		}
		ac.updateCSMask = true;
		ac.rowMask = true;
		ac.updateTimer = setInterval(ac.updateCSMasks, 3000);
		//init toolbar and row mask
		ac.init();
	},
	getCS: function(csId) {
		return Automne.content.cs[csId];
	},
	updateCSMasks: function() {
		if (Automne.content.updateCSMask) {
			for (var csId in Automne.content.cs) {
				Automne.content.cs[csId].updateMask();
			}
		}
	},
	showZones: function(type) {
		type = type || 'drop';
		//stop showing rows mask
		Automne.content.stopRowsMask();
		for (var csId in Automne.content.cs) {
			Automne.content.cs[csId].showZones(type);
		}
	},
	hideZones: function() {
		for (var csId in Automne.content.cs) {
			Automne.content.cs[csId].hideZones();
		}
	},
	stopUpdate: function() {
		Automne.content.updateCSMask = false;
	},
	startUpdate: function() {
		Automne.content.updateCSMask = true;
		Automne.content.updateCSMasks();
	},
	startRowsMask: function() {
		Automne.content.rowMask = true;
	},
	stopRowsMask: function() {
		Automne.content.rowMask = false;
	},
	setRowOver: function(row, status) {
		if (status && Automne.content.rowOver !== false && Automne.content.rowOver.getId() != row.getId()) {
			if (status) {
				Automne.content.rowOver.mouseOut();
			} else {
				return;
			}
		}
		Automne.content.rowOver = row;
	},
	endEdition: function(source, el) {
		switch (source) {
			case 'link':
				Automne.message.popup({
					msg: 				Automne.locales.endEdition,
					buttons: 			Ext.MessageBox.YESNOCANCEL,
					animEl: 			el,
					closable: 			false,
					icon: 				Ext.MessageBox.QUESTION,
					scope:				this,
					fn: 				function (button) {
						if (button == 'cancel') {
							return;
						}
						//call server to get page infos using page url
						if (button == 'yes') {
							Automne.tabPanels.getPageInfos({
								pageUrl:		el.dom.href
							}, function(response, params) {
								pr('Submit page content '+ params.params.from +' to validation.');
								//submit content to validation
								Automne.server.call({
									url:				'page-controler.php',
									params: 			{
										currentPage:		params.params.from,
										action:				'submit_for_validation'
									}
								});
							}, {from: Automne.tabPanels.pageId});
						} else {
							Automne.tabPanels.getPageInfos({
								pageUrl:		el.dom.href
							});
						}
						pr('End edition from '+ source +' and unlock page '+ Automne.tabPanels.pageId);
						//unlock page
						Automne.server.call({
							url:				'page-controler.php',
							params: 			{
								currentPage:		Automne.tabPanels.pageId,
								action:				'unlock'
							}
						});
					}
				});
			break;
			case 'tab':
				pr('End edition from '+ source +' and unlock page '+ Automne.tabPanels.pageId);
				//unlock page
				Automne.server.call({
					url:				'page-controler.php',
					params: 			{
						currentPage:		Automne.tabPanels.pageId,
						action:				'unlock'
					}
				});
			break;
		}
		return true;
	}
}
////////////////
// JS LOCALES //
////////////////
Automne.locales = {};

/////////////////////////////
// CONSOLE & DEBUG METHODS //
/////////////////////////////
Automne.console = {
	window:false,
	//send error to user according to current system debug level
	throwErrors: function (errors) {
		errors = eval(errors);
		for(var i = 0; i < errors.length; i++) {
			//if (typeof console != 'undefined' && console.error) console.error(Automne.context.systemLabel +' '+ Automne.context.applicationVersion +' : '+ errors[i].error);
			pr(Automne.context.systemLabel +' '+ Automne.context.applicationVersion +' : '+ errors[i].error, 'error', errors[i].backtrace);
		}
	},
	//send rawdatas to user according to current system debug level
	throwRawDatas: function (rawdatas) {
		rawdatas = eval(rawdatas);
		for(var i = 0; i < rawdatas.length; i++) {
			pr(rawdatas[i], 'debug');
		}
	},
	pr:	function (data, type, backtrace) {
		if (Automne && Automne.context && Automne.context.debug & 1) {
			type = type || 'log'; //use 'dir' for exploring variable in IE
			//use firebug if available
			if (typeof window.console != 'undefined' && window.console.info) {
				switch (type) {
					case 'error': //errors
						window.console.error(data);
					break;
					case 'warning': //?? not used for now
						window.console.warn(data);
					break;
					case 'debug': //php pr output
						window.console.warn(data);
					break;
					case 'log': //default
					default:
						window.console.info(data);
					break;
				}
			} else 
			//use firebuglite if available
			if (typeof window.console != 'undefined' && eval('window.console.'+type)) {
				//window.console.log(data);
				eval('window.console.'+ type +'(data);')
			}
			//show with blackbird
			if (Automne.context.debug & 2) {
				try {
					if(!window.blackbird.isVisible()) {
						window.blackbird.show();
					}
				} catch(e){}
			}
			switch (type) {
				case 'error': //errors
					data += (backtrace) ? ' <a href="'+ backtrace +'" target="_blank">Backtrace</a>' : '';
					window.blackbird.error(data);
				break;
				case 'warning': //?? not used for now
					window.blackbird.warn(data);
				break;
				case 'debug': //php pr output
					window.blackbird.debug('<pre>'+data+'</pre>');
				break;
				case 'log': //default
				default:
					window.blackbird.info(data);
				break;
			}
		}
	}
};
//Magic PR function : Dump any var
if (typeof pr == 'undefined') {
	pr = Automne.console.pr;
}
