/**
 * @class Automne.block
 * @extends Ext.util.Observable
 * @constructor
 * @param {Object} config The configuration options. All block specifications
 */
Automne.block = function(config){
	config = config || {};
	if(config.initialConfig){
		config = config.initialConfig; // component cloning / action set up
	}
	this.controls = {}; //to correct a weird reference pb
	//this initial config
	this.initialConfig = config;
	//apply config
	Ext.apply(this, config);
	//to correct a pb on IE
	this.elements = config.elements;
	Automne.block.superclass.constructor.call(this);
	this.initComponent();
};

Ext.extend(Automne.block, Ext.util.Observable, {
	id : 				false,
	template : 			false,
	clientSpaceTagID : 	false,
	row:				{},
	blockClass:			false,
	hasContent:			false,
	editable:			false,
	administrable:		false,
	elements : 			[],
	size : 				{width:0, height:0},
	position : 			{x:0, y:0},
	controls:			{},
	document:			false,
	mask:				false,
	value:				false,
	jsBlockClass:		'Automne.block',
	disabledTabs:		[],
	initComponent : function() {
		//get all elements with HTML elements
		this.elements = (this.elements.length) ? Ext.select('#'+this.elements.join(',#'), true, this.document) : new Ext.CompositeElement();
	},
	getId : function(){
		return this.id;
	},
	setRow: function(row) {
		this.row = row;
	},
	getBox: function() {
		//init values
		this.size = {width:0, height:0};
		this.position = {x:0, y:0};
		//then add size of each elements into rows
		this.elements.each(function(el) {
			//get el size and position
			var box = el.getBox();
			//x
			if (!this.position.x || box.x < this.position.x) {
				this.position.x = parseInt(box.x, 10);
			}
			//y
			if (!this.position.y || box.y < this.position.y) {
				this.position.y = parseInt(box.y, 10);
			}
			//width
			if (!this.size.width || (box.width + (box.x - this.position.x)) > this.size.width) {
				this.size.width = parseInt(box.width + (box.x - this.position.x), 10);
			}
			//height
			if (!this.size.height || (box.height + (box.y - this.position.y)) > this.size.height) {
				this.size.height = parseInt(box.height + (box.y - this.position.y), 10);
			}
		}, this);
		return {x:this.position.x, y:this.position.y, width:this.size.width, height:this.size.height};
	},
	createControls: function() {
		if (!this.mask) {
			this.getBox();
			var bd = Ext.get(this.document.body);
			this.mask = bd.createChild({cls: 'atm-block-mask'});
			this.mask.setVisibilityMode(Ext.Element.DISPLAY);
			this.mask.on({
				'mouseover':{
					fn: 		this.onMouseIn,
					scope:		this
				},
				'mouseout':{
					fn: 		this.onMouseOut,
					scope:		this
				}
			});
		}
		this.controls['modify'] = this.mask.insertHtml('beforeEnd','<span class="atm-block-control atm-block-control-modify"></span>', true);
		this.controls['del'] 	= this.mask.insertHtml('beforeEnd','<span class="atm-block-control atm-block-control-del"></span>', true);
		this.controls['admin']	= this.mask.insertHtml('beforeEnd','<span class="atm-block-control atm-block-control-admin"></span>', true);
		//add events on controls elements
		for (var controlId in this.controls) {
			//ucfirst controlId name
			var ControlId = controlId.substr(0,1).toUpperCase() + controlId.substr(1);
			//on click/drag
			this.controls[controlId].on('mousedown', eval('this.on' + ControlId), this);
			//over
			this.controls[controlId].addClassOnOver('atm-block-control-'+ controlId +'-on');
			//alt text
			this.controls[controlId].dom.title = this.controls[controlId].dom.alt = eval('Automne.locales.block' + ControlId);
		}
	},
	showControls : function() {
		var position = 8;
		for (var controlId in this.controls) {
			var ctrl = this.controls[controlId];
			//check for each controls if they should be visible or not
			var visible = false;
			switch(controlId) {
				case 'del':
					visible = (this.row.userRight && this.hasContent) ? true : false;
				break;
				case 'modify':
					visible = (this.row.userRight && this.editable) ? true : false;
				break;
				case 'admin':
					visible = (this.row.userRight && this.administrable) ? true : false;
				break;
			}
			ctrl.setVisible(visible);
			if (visible) {
				//set controls positions
				ctrl.dom.style.left = position+'px';
				position += 20;
			}
		}
		this.getBox();
		//var y = (this.size.height - 20 > 0) ? this.position.y + this.size.height - 20 : this.position.y; 
		var y = (this.size.height - 20 > 0) ? this.position.y + 2 : this.position.y; 
		this.mask.setStyle('position', 'absolute');
		this.mask.setDisplayed('block');
		/*var right = false;
		this.elements.each(function(el){
			if (el.getStyle('float') == 'right') {
				right = true;
			}
		}, this);*/
		//this.mask.setBounds(this.position.x + (right ? (this.size.width - (position + 4)) : 0), y, (position + 4), 20);
		this.mask.setBounds(this.position.x + parseInt((this.size.width - (position + 4)) / 2), y, (position + 4), 20);
		this.mask.show();
	},
	onMouseIn: function() {
		this.row.onMouseIn();
		this.elements.addClass('atm-block-on');
	},
	onMouseOut: function() {
		this.row.onMouseOut();
		this.elements.removeClass('atm-block-on');
	},
	show: function() {
		if (!this.mask) {
			//create block controls
			this.createControls();
		}
		//show controls
		this.showControls();
	},
	hide: function() {
		if (this.mask) {
			this.mask.hide();
		}
	},
	onDel: function() {
		pr('del');
		Automne.message.popup({
			msg: 				Automne.locales.blockDeleteConfirm,
			buttons: 			parent.Ext.MessageBox.OKCANCEL,
			closable: 			false,
			icon: 				parent.Ext.MessageBox.WARNING,
			scope:				this,
			fn: 				this.clearContent
		});
	},
	clearContent: function(button) {
		if (button && button != 'ok') {
			return false;
		}
		//send all datas to server to clear block content and get new row HTML code
		Automne.server.call('page-content-controler.php', this.row.replaceContent, {
			action:			'clear-block',
			cs:				this.row.clientspace.getId(),
			page:			this.row.clientspace.page,
			template:		this.row.template,
			rowType:		this.row.rowType,
			rowTag:			this.row.rowTagID,
			block:			this.getId(),
			blockClass:		this.blockClass
		}, this.row);
	},
	onModify: function() {
		if (typeof this.edit == 'function') {
			this.stopEditInterface();
			//launch edition
			this.edit();
		}
	},
	stopEdition: function() {
		this.endModify();
	},
	endModify: function() {
		this.startEditInterface();
	},
	onAdmin: function() {
		if (typeof this.admin == 'function') {
			this.stopEditInterface();
			//launch edition
			this.admin();
		}
	},
	stopEditInterface: function() {
		this.elements.removeClass('atm-block-on');
		this.row.mouseOut();
		//stop showing rows mask
		Automne.content.stopRowsMask();
		//disable buttons
		if (parent.Ext.getCmp('editAddRow')) {
			parent.Ext.getCmp('editAddRow').hide();
			parent.Ext.getCmp('editSaveDraft').hide();
			parent.Ext.getCmp('editValidateDraft').hide();
			//disable all tabs
			this.disabledTabs = parent.Automne.tabPanels.disableTabs(['edit']);
		}
	},
	startEditInterface: function() {
		//allow row mask to be displayed
		Automne.content.startRowsMask();
		//enable add row
		if (parent.Ext.getCmp('editAddRow')) {
			parent.Ext.getCmp('editAddRow').show();
			//these buttons must be shown only if context allow it
			parent.Ext.getCmp('editSaveDraft').setVisible(Automne.content.isValidable);
			parent.Ext.getCmp('editValidateDraft').setVisible(Automne.content.isValidator);
			//enable all tabs
			parent.Automne.tabPanels.enableTabs(this.disabledTabs);
			this.disabledTabs = [];
		}
	},
	destroy: function() {
		//hide mask and controls
		this.hide();
		if (this.mask) {
			//destroy controls
			for (var controlId in this.controls) {
				this.controls[controlId].remove();
			}
			delete this.controls;
			//destroy mask
			this.mask.remove();
		}
		delete this.document;
	},
	removeListeners: function() {
		//remove events on elements and mask controls
		for (var controlId in this.controls) {
			this.controls[controlId].removeAllListeners();
		}
		//destroy controls
		delete this.controls;
		//remove mask listeners
		if (this.mask) {
			this.mask.removeAllListeners();
		}
		delete this.document;
	}
});