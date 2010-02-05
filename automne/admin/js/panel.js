/**
  * Automne Javascript file
  *
  * Automne.panel Extension Class for Ext.Panel
  * Add some basic controls on panel such as beforeactivate events, tooltip management, ...
  * Use Automne format for all panel content update
  * @class Automne.panel
  * @extends Ext.Panel
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: panel.js,v 1.5 2010/02/05 14:01:25 sebastien Exp $
  */
Automne.panel = Ext.extend(Ext.Panel, {
	//tab element
	tabEl: 		false,
	//tab tooltip element
	tabTip: 	false,
	// private
	initComponent : function(){
		this.resources = {};
		Automne.panel.superclass.initComponent.call(this);
		this.addEvents(
			/**
			 * @event beforeactivate
			 * Fires before the Panel has been activated. A handler can return false to cancel activation.
			 */
			'beforeactivate'
		);
	},
	//on destroy, destroy tooltip and windows
	onDestroy: function () {
		if (this.tabTip !== false) {
			this.tabTip.destroy();
		}
		Automne.panel.superclass.onDestroy.apply(this, arguments);
	},
	beforeActivate: function() {
		return (this.fireEvent('beforeactivate', this, Ext.EventObject.browserEvent) === false) ? false : true;
	},
	//load tab element from parent
	loadTabEl: function() {
		this.tabEl = Ext.getCmp('tabPanels').getTabEl(this);
	},
	//tooltip management
	setToolTip: function (title, body) {
		if (this.tabTip !== false) {
			this.tabTip.destroy();
		}
		if (this.tabEl === false) {
			this.loadTabEl();
		}
		if (this.id == 'public') {
			this.tabTip = new Ext.ToolTip({
				id:				this.id + 'Tip',
				target: 		this.tabEl,
				title: 			title,
				html: 			body,
				dismissDelay:	20000
			});
		} else {
			this.tabTip = new Ext.ToolTip({
				target: 		this.tabEl,
				title: 			title,
				html: 			body,
				dismissDelay:	20000
			});
		}
		return true;
	},
	// private
	doAutoLoad : function(){
		//set Automne renderer
		this.body.getUpdater().renderer = new Automne.windowRenderer();
		//set failure event
		this.body.getUpdater().on('failure', this.failure);
		return Automne.panel.superclass.doAutoLoad.apply(this, arguments); 
	},
	load : function(){
		if (this.body) {
			//set Automne renderer
			this.body.getUpdater().renderer = new Automne.windowRenderer();
			//set failure event
			this.body.getUpdater().on('failure', this.failure);
			return Automne.panel.superclass.load.apply(this, arguments); 
		}
	},
	failure: function(el, response) {
		if (response.status != '200') {
			if (el.dom) {
				el.dom.innerHTML = Automne.locales.loadingError+ ' (code : '+ response.status +')';
			} else {
				Automne.message.popup({
					msg: 				Automne.locales.loadingError+ ' (code : '+ response.status +')',
					buttons: 			Ext.MessageBox.OK,
					closable: 			false,
					icon: 				Ext.MessageBox.ERROR
				});
			}
		}
	},
	updateResource: function (action, module, resourceId) {
		if (action == 'delete' && this.resources[module] && this.resources[module][resourceId] && this.update) {
			this.update();
		}
	},
	addResource: function (module, resourceId) {
		if (!this.resources[module]) {
			this.resources[module] = {};
		}
		this.resources[module][resourceId] = true;
	},
	resetResources: function() {
		this.resources = {};
	}
});
Ext.reg('atmPanel', Automne.panel);