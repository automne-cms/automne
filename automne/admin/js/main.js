/**
  * Automne Javascript main JS file
  *
  * Provide all specific JS codes to manage Automne client viewport
  *
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: main.js,v 1.16 2009/06/24 10:05:00 sebastien Exp $
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
				//Test native JSON support
				try {
					if (Ext.USE_NATIVE_JSON && window.JSON && window.JSON.toString() == '[object JSON]') {
						pr('Native JSON is active.');
					}
				} catch(e){}
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
		/*if (!Automne.utils.focusinput()) {
			//or check into iframes if any
			var iframes = document.getElementsByTagName('IFRAME');
			pr(iframes);
			var focusok = false;
			if (iframes.length) {
				for (var i = 0;!focusok && i < iframes.length; i++) {
					try {
						focusok = Automne.utils.focusinput(iframes[i].contentWindow.document);
					} catch(e) {
						//pr(e, 'error');
					}
				}
			}
		}*/
	}
};
////////////////
// JS LOCALES //
////////////////
Automne.locales = {};
