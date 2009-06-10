/**
  * Automne Javascript main JS file
  *
  * Provide all specific JS codes to manage Automne client viewport
  *
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: main.js,v 1.14 2009/06/10 10:11:17 sebastien Exp $
  */

//Declare Automne namespace
Ext.namespace('Automne');

//Create application
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
		if (Ext.isGecko2 || Ext.isIE6 ||  Ext.isSafari2 || !(Ext.isIE || Ext.isGecko || Ext.isSafari || Ext.isOpera || Ext.isChrome)) {
			window.top.location.replace('./navigator.php');
		}
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
		
		//set Global Ajax events
		Ext.Ajax.on({'beforerequest': Automne.server.showSpinner, 'requestcomplete': Automne.server.hideSpinner, 'requestexception': Automne.server.requestException, scope: this});
		// Default headers to pass in every request
		Ext.Ajax.defaultHeaders = {
		    'X_Powered_By': 'Automne'
		};
		//create viewport
		Automne.createViewPort();
		
		//check for authenticated user
		Automne.server.call('login.php' + ((Automne.logout) ? '?cms_action=logout' : ''));
		//remove loading element
		setTimeout(function(){
			Ext.get('atm-center').remove();
			Ext.get('atm-loading-mask').fadeOut({remove:true, callback:Automne.end});
		}, 250);
	},
	//load Automne admin interface
	load: function(context) {
		//keep old user Id
		var oldUser = false;
		if (Automne.context && Automne.context.userId) {
			oldUser = Automne.context.userId
		}
		//set new context.
		Automne.context = context;
		//if it is a new connexion or a new user, load interface
		if (!oldUser || oldUser != Automne.context.userId) {
			//if user is not the same than the old one, recreate viewport.
			if (oldUser && oldUser != Automne.context.userId && Ext.get('sidePanel')) {
				Automne.createViewPort();
			} else {
				//set window events
				Automne.preventUnload();
				Automne.catchF5(document, window);
				Automne.historyChange();
			}
			//load east panel
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
			//if token history is founded, use it
			if (window.location.hash.indexOf('#') !== -1) {
				Automne.getToHistory(window.location.hash);
			} else {
				//get page infos and force reload public frame (if active)
				Automne.tabPanels.getPageInfos(config, function(){
					if (Automne.tabPanels.getActiveTab().id == 'public') {
						Automne.tabPanels.getActiveTab().reload();
					}
				});
			}
			//display east panel
			Automne.east.expand();
		}
	},
	catchF5: function(doc, win) {
		var catchF5 = function(e) {
			var ev = !Ext.isIE ? e.browserEvent : this.event;
			if (ev && ev.keyCode == Ext.EventObject.F5 && ev.charCode != Ext.EventObject.F5/* && (!e || (e && !e.ctrlKey && !e.shiftKey))*/) {
				if (!Ext.isIE) {
					e.stopEvent();
				} else {
					ev.keyCode=0;
				}
				Automne.tabPanels.getActiveTab().reload();
				Automne.message.show(Automne.locales.refresh, '', Automne.tabPanels.getActiveTab());
				return false;
			}
			return true;
		}
		//set F5 event
		if (doc) {
			if (!Ext.isOpera && !Ext.isSafari && !Ext.isChrome) {
				if (!Ext.isIE) {
					Ext.EventManager.on(doc, 'keypress', catchF5);
				} else if (win) {
					doc.onkeydown = catchF5.createDelegate(win);
				}
			}
		}
	},
	preventUnload: function() {
		//set window unload event
		Ext.EventManager.on(window, 'beforeunload', function(e) {
			e.stopEvent();
			e.browserEvent.returnValue = Automne.locales.quitConfirm;
			return false;
		});
	},
	historyChange: function() {
		Ext.History.init();
		// Handle history change event in order to restore the UI to the appropriate history state
	    Ext.History.on('change', function(token){
			if(token){
				Automne.getToHistory(token);
			}
		});
	},
	getToHistory: function(token)  {
		if (token.indexOf('#') === 0) {
			token = token.substr(1);
		}
		var parts = token.split(':');
		var action = parts[0];
		var value = parts[1].trim();
		switch (action) {
			case 'page':
				//go to the page only if it is not already displayed
				if (value != Automne.tabPanels.pageId) {
					//call server to get page infos using page url
					Automne.tabPanels.getPageInfos({
						pageId:		value
					});
				} else {
					pr('History query page : '+ value +', which is already displayed so skip query');
				}
			break;
		}
	},
	createViewPort: function() {
		//if viewport already exists : destroy it
		if (Automne.viewPort) {
			Automne.viewPort.destroy();
		}
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
					collapsed:		!Ext.state.Manager.get('side-panel-collapsible', true),
					split:			true,
					width: 			290,
					minWidth:		290,
					maxWidth:		290,
					border:			false
				}) 
			]
		});
		//set tabPanels var
		Automne.tabPanels = Ext.getCmp('tabPanels');
		//set east panel var
		Automne.east = Ext.getCmp('sidePanel');
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
						pr(e, 'error');
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
		// send request and return request number
		return Ext.Ajax.request(config);
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
	hideSpinner: function (ajax, response, options) {
		if (!Ext.Ajax.isLoading()) {
			Ext.get('atm-server-call').hide();
		}
		//check for return error
		if (!(options && options.isUpload) && (response == undefined || (response.responseXML == undefined && response.getResponseHeader('Content-Type').indexOf('text/xml') !== -1) || response.responseText == '')) {
			Automne.server.failureResponse(response, options, null, 'call');
		}
	},
	//method used for a server call : eval response
	evalResponse: function (response, options) {
		//check for XML content
		if (response == undefined || response.responseXML == undefined) {
			//here, error is handled by hideSpinner method, so simply quit
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
				//eval('jsonResponse = '+xml.getElementsByTagName('jsoncontent').item(0).firstChild.nodeValue+';');
				jsonResponse = Ext.decode(xml.getElementsByTagName('jsoncontent').item(0).firstChild.nodeValue);
			} catch(e) {
				jsonResponse = {};
				pr(e, 'error');
				Automne.server.failureResponse(response, options, e, 'json');
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
				pr(e, 'error');
				Automne.server.failureResponse(response, options, e, 'js');
			}
		}
		//extract json jsfiles and cssfiles in response if any
		var jsFiles = {}, cssFiles = {};
		if (options.evalJSon !== false && xml && xml.getElementsByTagName('jsfiles').length) {
			try{
				//eval('jsFiles = '+xml.getElementsByTagName('jsfiles').item(0).firstChild.nodeValue+';');
				jsFiles = Ext.decode(xml.getElementsByTagName('jsfiles').item(0).firstChild.nodeValue);
			} catch(e) {
				jsFiles = {};
				pr(e, 'error');
			}
		}
		if (options.evalJSon !== false && xml && xml.getElementsByTagName('cssfiles').length) {
			try{
				//eval('cssFiles = '+xml.getElementsByTagName('cssfiles').item(0).firstChild.nodeValue+';');
				cssFiles = Ext.decode(xml.getElementsByTagName('cssfiles').item(0).firstChild.nodeValue);
			} catch(e) {
				cssFiles = {};
				pr(e, 'error');
			}
		}
		if (xml && xml.getElementsByTagName('disconnected').length) {
			Automne.view.disconnect();
		}
		if (options.fcnCallback != '' && typeof options.fcnCallback == 'function') {
			//send to callback if any
			options.fcnCallback.call(options.callBackScope || options.scope || this || window, response, options, jsonResponse || content, jsFiles, cssFiles);
		} else {
			return jsonResponse || content;
		}
	},
	//method used for a server call : request exception
	requestException: function(conn, response, options) {
		Automne.server.hideSpinner();
		Automne.server.failureResponse(response, options, null, 'http');
	},
	//method used for a server call : failure response
	failureResponse: function (response, options, e, type) {
		var al = Automne.locales;
		var msg = '';
		switch(type) {
			case 'js':
				msg = al.jsError;
			break;
			case 'json':
				msg = al.jsonError;
			break;
			case 'html':
			default:
				msg = al.loadingError;
			break;
		}
		msg += '<br /><br />'+ al.contactAdministrator +'<br /><br />';
		if (e || response) {
			if (e) {
				msg += 'Message : '+ e.name +' : '+ e.message +'<br /><br />';
				if (e.lineNumber && e.fileName) {
					msg += 'Line : '+ e.lineNumber +' of file '+ e.fileName +'<br /><br />';
				}
			}
			if (response) {
				if (response.argument) {
					msg += 'Address : '+ response.argument.url +'<br /><br />'+
					'Parameters : '+ Ext.urlEncode(response.argument.params) +'<br /><br />';
				} else if (options.url) {
					msg += 'Address : '+ options.url +'<br /><br />';
					if (options.params) {
						msg += 'Parameters : '+ Ext.urlEncode(options.params) +'<br /><br />';
					}
				}
				if (response.status) {
					msg += 'Status : '+ response.status +' ('+ response.statusText +')<br /><br />'+
					'Response Headers : <pre class="atm-debug">'+ response.getAllResponseHeaders() +'</pre>';
				}
				if (response.responseText) {
					msg += '<br />Server return : <pre class="atm-debug">' + (!e ? response.responseText :  Ext.util.Format.htmlEncode(response.responseText)) +'</pre><br />';
				}
			}
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
		m.slideIn('t').pause(3).ghost("t", {remove:true});
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
	updateStatus: function (statusId, newStatus, newTinyStatus, unlock) {
		//check for public tab : if status is for current viewved page, it must be reloaded
		if (Automne.tabPanels) {
			var publicPanel = Automne.tabPanels.getItem('public');
			var publicTab = Automne.tabPanels.getTabEl(publicPanel);
			if (publicTab) {
				if (Ext.select('span.' + statusId, false, publicTab).getCount()) {
					Automne.tabPanels.getPageInfos({
						pageId:			publicPanel.pageId,
						regenerate:		(Automne.tabPanels.getActiveTab().id == 'public'),
						reload:			(unlock == true ? false : true)
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
			if (link.dom.target != "_blank" && link.dom.href && link.dom.href.substr(-1) != '#' && link.dom.href.indexOf('javascript') !== 0) {
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
				//pr(root.location.href);
				//pr(form.dom.action);
				//pr(form.dom.action.indexOf(root.location.href));
				//pr(root.location.href.indexOf(form.dom.action));
				/*if (form.dom.target != "_blank" && form.dom.action && form.dom.action.indexOf && form.dom.action.indexOf(root.location.href) === -1 && root.location.href.indexOf(form.dom.action) === -1) {
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
				}*/
			}
		}
	}
};
///////////////////////
// USER VIEW METHODS //
///////////////////////
Automne.view = {
	tree: function(eId, heading, currentPage) {
		if (typeof eId == 'object') {
			var e =  Ext.get(eId);
			eId = e.id;
		} else {
			var e = Ext.get(eId);
		}
		if (!e) {
			pr('Can\'t get element '+ eId +'for tree');
			return false;
		}
		pr('Tree for el : '+eId+', heading : '+heading+ ', page : '+currentPage);
		//create window element
		var winid = Ext.id();
		var win = new Automne.Window({
			id:				winid,
			currentPage:	(currentPage) ? currentPage : 1,
			currentEl:		e,
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
		win.show(e);
		return win;
	},
	user: function(userId) {
		Automne.view.search('user:'+userId);
	},
	search: function(search) {
		if (search) {
			//if search is a positive integer, get page
			if (!isNaN(parseInt(search, 10))) {
				//force reload page infos without reloading the frame itself
				Automne.tabPanels.getPageInfos({
					pageId:		search
				});
			} else {
				var windowId = 'searchWindow';
				if (Ext.WindowMgr.get(windowId)) {
					Ext.WindowMgr.bringToFront(windowId);
					Ext.WindowMgr.get(windowId).search(search);
				} else {
					//create window element
					var win = new Automne.Window({
						id:				'searchWindow',
						width:			800,
						height:			600,
						autoLoad:		{
							url:		'/automne/admin/search.php',
							params:		{
								winId:	'searchWindow',
								search:	search
							},
							nocache:	true,
							scope:		this
						}
					});
					//display window
					win.show();
				}
			}
		}
	},
	removeSearch: function() {
		var searchField = Ext.getCmp('atmSearchPanel');
		if (searchField) {
			if (searchField.rendered) {
				var field = searchField.findByType('trigger')[0];
				field.fireEvent('blur', field);
			}
		}
	},
	//Scripts related methods
	maxScripts:		0,
	currentScripts:	0,
	scriptsUpdate: 	false,
	scriptsTip:		false,
	getScriptsDetails:false,
	getScriptsQueue:false,
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
			pr('Scripts left : '+av.currentScripts+', scriptsUpdate : '+av.scriptsUpdate+', update : '+scriptsUpdate);
		}
		var el = Ext.get('headPanelBar');
		if (el) {
			//request scripts count refresh
			if (scriptsUpdate || av.getScriptsDetails || av.getScriptsQueue) {
				setTimeout(function(){
					Automne.server.call('scripts.php', '', {
						refreshScripts: 	true, 
						nospinner: 			true,
						details:			av.getScriptsDetails,
						queue:				av.getScriptsQueue
					});
				}, 5000);
			}
			Automne.view.updateScriptBars();
		} else {
			av.scriptsUpdate = false;
		}
	},
	updateScriptBars: function() {
		var av = Automne.view;
		var el = Ext.get('headPanelBar');
		var toptext = av.currentScripts ? 'Scripts en cours de traitement ... '+av.currentScripts+' scripts restant' : 'Aucun script en cours de traitement.';
		if (el) {
			var size = (av.currentScripts != 0 && av.maxScripts != 0) ? parseInt((av.currentScripts * 247) / av.maxScripts) : 0;
			size += 30; //for padding
			el.setWidth(size, true);
			if (Ext.get('headPanelBarInfos')) {
				if (av.scriptsTip) av.scriptsTip.destroy();
				av.scriptsTip = new Ext.ToolTip({
					target: 		Ext.get('headPanelBarInfos'),
					html: 			toptext
				});
			}
		}
		if (Ext.getCmp('scriptsProgressBar')) {
			var progressScripts = Ext.getCmp('scriptsProgressBar');
			v = av.currentScripts / av.maxScripts;
			if (!isNaN(v) && v != 0) {
				progressScripts.updateProgress((av.currentScripts / av.maxScripts), toptext );
			} else {
				progressScripts.reset();
				progressScripts.updateProgress(0, toptext );
			}
			
		}
	},
	disconnect: function() {
		//check for authenticated user
		Automne.server.call('login.php?cms_action=reconnect');
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
			//uncomment this line to view function caller
			//data += ' '+pr.caller.toString();
			var type = type || 'log'; //use 'dir' for exploring variable in IE
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
			if (Automne.context.debug & 8) {
				try {
					if(!window.blackbird.isVisible()) {
						window.blackbird.show();
					}
				} catch(e){}
			}
			//Use prettyPrint to dump objects vars
			if ((typeof data != 'string') && prettyPrint != undefined) {
				Automne.varDump = data;
				var showDump = function() {
					var win = new Automne.Window({
						width:			750,
						height:			580,
						title:			'Javascript Var Dump',
						html:			'',
						bodyStyle:		'padding:5px;',
						autoScroll:		true,
						listeners:		{'show':function(win){
							win.body.dom.appendChild(prettyPrint(Automne.varDump));
						},'scope':this}
					});
					win.show();
				}
				data = data.toString()+ ' <a href="#" onclick="('+Ext.util.Format.htmlEncode(showDump.toString())+')();">[Var Dump]</a>';
			}
			switch (type) {
				case 'error': //errors
					data += (backtrace) ? ' <a href="'+ backtrace +'" target="_blank">[Backtrace]</a>' : '';
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
					//window.Ext.log(data); //use this to log info within Ext console
				break;
			}
		}
	}
};
//Magic PR function : Dump any var
if (typeof pr == 'undefined') {
	pr = Automne.console.pr;
}
