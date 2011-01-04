/**
  * Automne Javascript file
  *
  * Automne.view
  * Provide interface methods
  * @class Automne.view
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: view.js,v 1.3 2010/01/29 10:34:14 sebastien Exp $
  */
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
							url:		Automne.context.path + '/automne/admin/search.php',
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
		var toptext = av.currentScripts ? String.format(Automne.locales.nScripts, av.currentScripts) : Automne.locales.noScript;
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
			if (progressScripts.el.dom && progressScripts.el.dom.firstChild) {
				v = av.currentScripts / av.maxScripts;
				if (!isNaN(v) && v != 0) {
					progressScripts.updateProgress((av.currentScripts / av.maxScripts), toptext, true );
				} else {
					progressScripts.updateProgress(0, toptext, true );
				}
			}
		}
	},
	disconnect: function() {
		if (Automne.context !== false) {
			//check for authenticated user
			Automne.server.call('login.php?cms_action=reconnect');
			//clear context
			Automne.context = false;
		}
		//clear ping if any
		if (Automne.sessionPing) {
			Automne.sessionPing.cancel();
		}
	}
};