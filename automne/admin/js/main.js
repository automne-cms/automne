/**
  * Automne Javascript main JS file
  *
  * Provide all specific JS codes to manage Automne client viewport
  *
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: main.js,v 1.26 2010/02/04 15:49:59 sebastien Exp $
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
	session:		false,
	/*************************************
	*		Automne public methods	  *
	*************************************/
	init: function() {
		//check for iframe embeding
		if (window.top != window.self) {
	    	if (Ext) {
				Ext.EventManager.removeAll(window);
			}
			window.top.location.replace('/automne/admin/');
		}
		//check for navigator version
		if (Ext.isIE6) {
			window.top.location.replace('./ie6.php');
		}
		if (Ext.isGecko2 ||  Ext.isSafari2 || !(Ext.isIE || Ext.isGecko || Ext.isSafari || Ext.isOpera || Ext.isChrome)) {
			window.top.location.replace('./navigator.php');
		}
		//init config
		Automne.initConfig();
		
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
	//Initialize some basic configurations (cookies, qtips, ajax)
	initConfig: function() {
		//init quicktips
		Ext.QuickTips.init();
		// Remove autohide on quicktip
		Ext.apply(Ext.QuickTips.getQuickTip(), {dismissDelay:20000});//autohide qtip after 20s

		//init cookie provider
		Automne.cookie = new Ext.state.CookieProvider({
			path: 		"/",
			expires: 	new Date(new Date().getTime()+(1000*60*60*24*90)) //90 days
			/*,domain: 	window.location.host*/
		});
		Ext.state.Manager.setProvider(Automne.cookie);
		
		//set Global Ajax events
		Ext.Ajax.on({'beforerequest': Automne.server.showSpinner, 'requestcomplete': Automne.server.hideSpinner, 'requestexception': Automne.server.requestException, scope: this});
		
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
		// Header to pass in every Ajax request. Used to prevent CSRF attacks on action requests
		Ext.Ajax.defaultHeaders = {
		    'X-Powered-By': 'Automne',
			'X-Atm-Token':	context.token
		};
		//if it is a new connexion or a new user, load interface
		if (!oldUser || oldUser != Automne.context.userId || !Automne.east.rendered) {
			//if user is not the same than the old one, recreate viewport.
			if (oldUser && oldUser != Automne.context.userId && Ext.get('sidePanel')) {
				Automne.createViewPort();
			} else {
				//set window events
				Automne.preventUnload();
				Automne.catchF5(document, window);
				Automne.historyChange();
				//Test native JSON support
				try {
					if (Ext.USE_NATIVE_JSON && window.JSON && window.JSON.toString() == '[object JSON]') {
						pr('Native JSON is active.');
					}
				} catch(e){}
			}
			//load east panel
			if (!Automne.east.items.length) {
				Automne.east.load({
					url:		'side-panel.php',
					params:		{
						winId:		'sidePanel'
					},
					nocache:	true,
					scope:		this
				});
			}
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
			setTimeout(function(){
				Automne.east.expand();
			}, 500);
			//set session "pause" if session is permanent
			if (Automne.context.permanent) {
				if (Automne.context && Automne.context.sessionDuration && parseInt(Automne.context.sessionDuration) > 29) {
					Automne.sessionPing = new Ext.util.DelayedTask(function(){
					    //send ping to server to force session persistence
						Automne.server.call('ping.php', '', {
							nospinner: 			true
						});
						if (Automne.context && Automne.context.sessionDuration && parseInt(Automne.context.sessionDuration) > 29) {
							Automne.sessionPing.delay((parseInt(Automne.context.sessionDuration) - 10) * 1000);
						}
					});
					Automne.sessionPing.delay((parseInt(Automne.context.sessionDuration) - 10) * 1000);
				}
			} else if (Automne.sessionPing) {
				Automne.sessionPing.cancel();
			}
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
				//reload page
				Automne.tabPanels.getActiveTab().reload();
				//then reload page infos
				Automne.tabPanels.getPageInfos({
					pageId:		Automne.tabPanels.pageId,
					noreload:	true
				});
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
		if (parts[1]) {
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
					}
				break;
			}
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
						frameURL:		'/automne/admin/empty.php',
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
					collapsed:		false,
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
		//Nothing for now
	}
};
////////////////
// JS LOCALES //
////////////////
Automne.locales = {};
