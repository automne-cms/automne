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