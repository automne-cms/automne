/**
  * Automne.winPanel Extension Class for Ext.Panel
  * Display a modal window on click on the panel element
  * @class Automne.winPanel
  * @extends Ext.Panel
  */
Automne.winPanel = Ext.extend(Automne.panel, {
	//windows panel
	winPanel: 	false,
	//window url (used accross ajax request to get window content)
	winURL: 	false,
	//current displayed page
	currentPage:false,
	//constructor
	constructor: function(config) { 
		// preprocessing
		this.currentPage = (config.currentPage) ? config.currentPage : false;
		//call constructor
		Automne.winPanel.superclass.constructor.apply(this, arguments); 
	},
	//on destroy, destroy tooltip and windows
	onDestroy: function () {
		if (this.winPanel !== false) {
			this.winPanel.close();
			this.winPanel.destroy();
		}
		Automne.winPanel.superclass.onDestroy.apply(this, arguments);
	},
	beforeActivate: function() {
		//create window element
		this.winPanel = new Automne.Window({
			id:				this.id+'Window',
			currentPage:	this.currentPage,
			autoLoad:		{
				url:		this.winURL,
				params:		{
					winId:		this.id+'Window',
					currentPage:this.currentPage
				},
				nocache:	true,
				scope:		this
			}
		});
		//hide qtip if visible
		if(this.tabTip) this.tabTip.hide();
		//display window
		this.winPanel.show(this.tabEl);
		//set beforeclose event
		this.winPanel.on('beforeclose', this.beforeCloseWin, this, {single:true});
		
		//return false to stop panel activation
		return false;
	},
	beforeCloseWin: function(panel) {
		Ext.get(panel.body).remove();
		return true;
	},
	afterActivate: function () {
		//nothing for now
	},
	setWinTitle: function (title) {
		if (this.winPanel) {
			return this.winPanel.setTitle(title);
		}
	},
	getWinEl: function (title) {
		return this.winPanel;
	},
	setCurrentPage: function (pageId) {
		this.currentPage = pageId;
	}
});
Ext.reg('winPanel', Automne.winPanel);