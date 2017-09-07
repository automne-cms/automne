/**
  * Automne Javascript file
  *
  * Automne.row Extension Class for Ext.util.Observable
  * Create extendable row content element which is embeded into clientspaces and contains block elements
  * @class Automne.row
  * @extends Ext.util.Observable
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: rows.js,v 1.9 2010/03/08 15:20:22 sebastien Exp $
  */
Automne.row = function(config){
	config = config || {};
	if(config.initialConfig){
		config = config.initialConfig; // component cloning / action set up
	}
	//to correct a weird reference pb
	this.controls = {}; 
	this.csOrder = 0;
	this.clientspace = false;
	this.dragZone = {};
	this.blocks = {};
	//this initial config
	this.initialConfig = config;
	//apply config
	Ext.apply(this, config);
	//to correct a pb on IE
	this.elements = config.elements;
	Automne.row.superclass.constructor.call(this);
	this.initComponent();
};

Ext.extend(Automne.row, Ext.util.Observable, {
	id : 				false,
	template : 			false,
	clientSpaceTagID : 	false,
	rowTagID : 			false,
	rowType : 			false,
	userRight : 		false,
	elements : 			[],
	size : 				{width:0, height:0},
	position : 			{x:0, y:0},
	hasMouseOver : 		false,
	mouseOutTimeOut : 	false,
	document: 			false,
	active : 			false,
	mask:				false,
	clientspace:		false,
	label:				'',
	controls:			{},
	csOrder:			0,
	dragZone:			{},
	blocks:				{},
	visualMode:			1,
	initComponent : function() {
		//get all elements with HTML elements
		this.elements = (this.elements.length) ? Ext.select('#'+this.elements.join(',#'), true, this.document) : new Ext.CompositeElement();
		//put events on elements
		this.elements.each(function(el) {
			el.on({
				'mouseover':{
					fn: 		this.onMouseIn,
					scope:		this
				},
				'mouseout':{
					fn: 		this.onMouseOut,
					scope:		this
				}
			});
		}, this);
		//check box height
		var box = this.getBox();
		if (box.height < 3) {
			this.elements.first().addClass('atm-dummy-row-tag atm-empty-row');
		}
	},
	getId : function(){
		return this.id;
	},
	getCsId : function() {
		return this.clientSpaceTagID;
	},
	setCS: function(clientspace) {
		this.clientspace = clientspace;
	},
	setCSOrder: function(order) {
		this.csOrder = order;
	},
	addBlock: function(block) {
		this.blocks[block.id] = block;
		this.blocks[block.id].setRow(this);
	},
	hasElement: function(el) {
		if (this.elements.indexOf(el) !== -1) {
			return true;
		}
		return false;
	},
	getBox: function() {
		//init values
		this.size = {width:0, height:0};
		this.position = {x:0, y:0};
		//then add size of each elements into rows
		this.elements.each(function(el) {
			if (el.dom.tagName.toLowerCase() != 'br') {
				//get el size and position
				var box = el.getBox();
				//x
				if (!this.position.x || (box.x < this.position.x && box.x)) {
					this.position.x = parseInt(box.x, 10);
				}
				//y
				if (!this.position.y || (box.y < this.position.y && box.y)) {
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
			}
		}, this);
		//pr('x : '+this.position.x+' - y : '+this.position.y + ' - width : '+this.size.width + ' - height : '+this.size.height);
		return {x:this.position.x, y:this.position.y, width:this.size.width, height:this.size.height};
	},
	onMouseIn : function () {
		if (this.mouseOutTimeOut != undefined && this.mouseOutTimeOut !== false) {
			this.mouseOutTimeOut.cancel();
		}
		if (this.hasMouseOver !== false) {
			return;
		}
		this.getBox();
		if (this.show()) {
			//pr('Over '+ this.id +' - Index : '+ this.csOrder );
			this.hasMouseOver = true;
			atmContent.setRowOver(this, true);
		}
	},
	//on mouseout : launch timer to hide zone
	onMouseOut : function () {
		if (this.mouseOutTimeOut == undefined) {
			return;
		}
		if (this.mouseOutTimeOut === false) {
			this.mouseOutTimeOut = new Ext.util.DelayedTask(function(){
				//mouse is out of row elements, but check if it is still in row box
				var xy = Ext.EventObject.getXY();
				var box = this.getBox();
				if (xy[0] >= box.x && xy[0] <= (box.x + box.width) && xy[1] >= box.y && xy[1] <= (box.y + box.height)) {
					this.mouseOutTimeOut.delay(20);
					return;
				}
				this.mouseOut();
			}, this);
		}
		this.mouseOutTimeOut.delay(20);
	},
	//timer is over, launch mouseout actions
	mouseOut: function() {
		if (this.mouseOutTimeOut != undefined && this.mouseOutTimeOut !== false) {
			this.mouseOutTimeOut.cancel();
		}
		this.hasMouseOver = false;
		atmContent.setRowOver(this, false);
		//pr('Out '+this.id);
		this.hide();
	},
	//show row control elements
	show : function(){
		if (!atmContent.rowMask) {
			return false;
		}
		//if surounding mask does not exists, create it
		if (!this.mask) {
			this.mask = new Automne.contentMask(3, 'atm-row', this.document);//thickness, cls, document
			//put events on top mask element
			this.mask.top.on({
				'mouseover':{
					fn: 		this.onMouseIn,
					scope:		this
				},
				'mouseout':{
					fn: 		this.onMouseOut,
					scope:		this
				}
			});
			//create rows controls
			this.createControls();
		}
		//show row border 
		if (!this.mask.show(this.position, this.size)) {
			return false;
		}
		//show block controls
		for (var blockId in this.blocks) {
			this.blocks[blockId].show();
		}
		//augment size of top element to add controlers
		this.mask.top.setHeight(20).move('t',17);
		//scroll frame if necessary
		this.scroll();
		//append template and rows name to top bar
		if (parent.Ext.get('selectedRow'+ atmContent.editId)) {
			parent.Ext.get('selectedRow'+ atmContent.editId).update(Automne.locales.rowType +' <strong>'+ this.label +'</strong>');
			parent.Ext.get('selectedRow'+ atmContent.editId).dom.className = this.id;
		}
		//add controls to top bar
		this.addControls();
		return true;
	},
	//hide row control elements
	hide : function(){
		if (!atmContent.rowMask) {
			return false;
		}
		if (this.mask && this.mask.hide) {
			this.mask.hide();
		}
		//hide block controls
		for (var blockId in this.blocks) {
			this.blocks[blockId].hide();
		}
		//remove top label if another row is not already displayed
		if (parent.Ext.get('selectedRow'+ atmContent.editId) && parent.Ext.get('selectedRow'+ atmContent.editId).hasClass(this.id)) {
			parent.Ext.get('selectedRow'+ atmContent.editId).update('');
		}
	},
	//scroll frame if necessary to show the top of row mask
	scroll: function () {
		var scrollStatus = (parent.Ext.getCmp('editScroll'+ atmContent.editId)) ? parent.Ext.getCmp('editScroll'+ atmContent.editId).checked : true;
		if (scrollStatus) {
			var html = Ext.get(this.document.body.parentNode);
			var box = this.getBox();
			var body = Ext.get(this.document.body);
			var scroll = body.getScroll();
			if ((box.y - 20) < scroll.top) {
				html.scrollTo('top', (box.y - 20), true);
			}
			if (box.x < scroll.left) {
				html.scrollTo('left', box.x, true);
			}
		}
	},
	createControls : function() {
		//beware here, orders matters
		this.controls['del'] 	= this.mask.top.insertHtml('beforeEnd','<span class="atm-row-control atm-row-control-del"></span>', true);
		this.controls['drag'] 	= this.mask.top.insertHtml('beforeEnd','<span class="atm-row-drag atm-row-control-drag"></span>', true);
		this.controls['top'] 	= this.mask.top.insertHtml('beforeEnd','<span class="atm-row-control atm-row-control-top"></span>', true);
		this.controls['bottom'] = this.mask.top.insertHtml('beforeEnd','<span class="atm-row-control atm-row-control-bottom"></span>', true);
		this.controls['up'] 	= this.mask.top.insertHtml('beforeEnd','<span class="atm-row-control atm-row-control-up"></span>', true);
		this.controls['down'] 	= this.mask.top.insertHtml('beforeEnd','<span class="atm-row-control atm-row-control-down"></span>', true);
		this.controls['right'] 	= this.mask.top.insertHtml('beforeEnd','<span class="atm-row-control atm-row-control-right"></span>', true);
		this.controls['left'] 	= this.mask.top.insertHtml('beforeEnd','<span class="atm-row-control atm-row-control-left"></span>', true);
		//add events on controls elements
		for (var controlId in this.controls) {
			//ucfirst controlId name
			var ControlId = controlId.substr(0,1).toUpperCase() + controlId.substr(1);
			//on click/drag
			if (controlId != 'drag') {
				this.controls[controlId].on('mousedown', eval('this.on' + ControlId), this);
			} else {
				this.dragZone = new Ext.dd.DragZone(this.controls['drag'], {
					// On receipt of a mousedown event, see if it is within a draggable element.
					// Return a drag data object if so. The data object can contain arbitrary application
					// data, but it should also contain a DOM element in the ddel property to provide
					// a proxy to drag.
					getDragData: function(e) {
						var proxy = this.row.elements.first().parent().createChild({tag:'div'});
						var box = this.row.getBox();
						//add 25px for width and 8px for height
						proxy.setSize((box.width < 375 ? box.width + 25 : 400), (box.height < 200 ? box.height + 8 : 208));
						proxy.addClass('atm-row-drag-proxy');
						proxy.setVisibilityMode(Ext.Element.DISPLAY);
						proxy.hide();
						this.row.elements.each(function(el) {
							var clone = el.dom.cloneNode(true);
							clone.id = Ext.id();
							proxy.appendChild(clone);
						}, this);
						return {
							sourceEl: this.row.controls['drag'],
							repairXY: [box.x,box.y],
							ddel: proxy.dom
						}
					},
					// Provide coordinates for the proxy to slide back to on failed drag.
					// This is the original XY coordinates of the draggable element.
					getRepairXY: function() {
						return this.dragData.repairXY;
					},
					onInitDrag : function(x, y){
						var clone = Ext.get(this.dragData.ddel.cloneNode(true));
						clone.show();
						this.proxy.update(clone.dom);
						this.onStartDrag(x, y);
						//hide row mask
						this.row.hide();
						//show all drop zones
						atmContent.showZones('drop');
						return true;
					},
					afterRepair: function() {
						this.dragging = false;
						//hide all drop zones
						atmContent.hideZones();
						//allow row mask to be displayed
						atmContent.startRowsMask();
					},
					onDrag: function(e) {
						//check scroll top position
						var scrollTop = this.row.document.documentElement.scrollTop;
						if (scrollTop > 0 && e.xy[1] - scrollTop < 20) {
							Ext.fly(this.row.document.body.parentNode).scrollTo('top', scrollTop - 50);
						}
					},
					row:this,
					containerScroll:true
				});
			}
			//over
			this.controls[controlId].addClassOnOver('atm-row-control-'+ controlId +'-on');
			//alt text
			this.controls[controlId].dom.title = this.controls[controlId].dom.alt = eval('Automne.locales.row' + ControlId);
		}
	},
	addControls : function() {
		var rightPosition, topPosition, position;
		rightPosition = position = this.mask.top.getWidth() - 3;
		topPosition = 0;
		var hasMoveCtrl = false;
		for (var controlId in this.controls) {
			var ctrl = this.controls[controlId];
			//check for each controls if they should be visible or not
			var visible = false;
			switch(controlId) {
				case 'del':
					visible = this.userRight;
				break;
				case 'top':
					visible = this.csOrder > 1;
					hasMoveCtrl = visible ? true : hasMoveCtrl;
				break;
				case 'bottom':
					visible = (this.csOrder + 2 < this.clientspace.getRowsNb());
					hasMoveCtrl = visible ? true : hasMoveCtrl;
				break;
				case 'left':
					visible = this.clientspace.getBrother('left') ? true : false;
					hasMoveCtrl = visible ? true : hasMoveCtrl;
				break;
				case 'right':
					visible = this.clientspace.getBrother('right') ? true : false;
					hasMoveCtrl = visible ? true : hasMoveCtrl;
				break;
				case 'up':
					visible = (this.csOrder > 0 || this.clientspace.getBrother('top')) ? true : false;
					hasMoveCtrl = visible ? true : hasMoveCtrl;
				break;
				case 'down':
					visible = ((this.csOrder + 1 < this.clientspace.getRowsNb()) || this.clientspace.getBrother('bottom')) ? true : false;
					hasMoveCtrl = visible ? true : hasMoveCtrl;
				break;
				case 'drag':
					visible = true;
				break;
			}
			ctrl.setVisible(visible);
			//set controls positions
			if (visible && controlId != 'del') {
				if ((position < 32 && topPosition == 0) || (position < 16 && topPosition != 0)) {
					topPosition += 16;
					position = rightPosition;
				}
				position -= 16;
				ctrl.dom.style.left = position+'px';
				if (topPosition != 0) {
					ctrl.dom.style.top = topPosition+'px';
				}
			} else if (visible && controlId == 'del') {
				ctrl.dom.style.left = '3px';
			}
		}
		if (topPosition != 0) {
			this.mask.top.setBounds(
				this.mask.top.getX(),
				this.mask.top.getY() - topPosition,
				this.mask.top.getWidth(),
				this.mask.top.getHeight() + topPosition);
		}
		//remove drag if their is no others move controls
		if (!hasMoveCtrl) {
			this.controls['drag'].setVisible(false);
		}
	},
	onDel: function() {
		Automne.message.popup({
			msg: 				String.format(Automne.locales.rowDeleteConfirm, this.label),
			buttons: 			parent.Ext.MessageBox.OKCANCEL,
			closable: 			false,
			icon: 				parent.Ext.MessageBox.WARNING,
			scope:				this,
			fn: 				this.destroy
		});
	},
	onTop: function() {
		this.moveAt(0);
	},
	onBottom: function() {
		this.moveAt(this.clientspace.getRowsNb() - 1);
	},
	onLeft: function() {
		this.moveToCS(this.clientspace.getBrother('left'), 'bottom');
	},
	onRight: function() {
		this.moveToCS(this.clientspace.getBrother('right'), 'bottom');
	},
	onUp: function() {
		if (this.csOrder > 0) {
			this.moveAt(this.csOrder - 1);
		} else {
			this.moveToCS(this.clientspace.getBrother('top'), 'bottom');
		}
	},
	onDown: function() {
		if (this.csOrder + 1 < this.clientspace.getRowsNb()) {
			this.moveAt(this.csOrder + 1);
		} else {
			this.moveToCS(this.clientspace.getBrother('bottom'), 'top');
		}
	},
	moveAt: function(index) {
		//hide controls
		this.hide();
		//move row to specified index
		this.clientspace.moveRowAt(this, index);
		//scroll frame if necessary
		this.scroll();
		//send all datas to server to move row at queried index
		Automne.server.call('page-content-controler.php', false, {
			action:			'move-row',
			cs:				this.clientspace.getId(),
			template:		this.template,
			page:			this.clientspace.page,
			rowType:		this.rowType,
			rowTag:			this.rowTagID,
			index:			index,
			visualMode:		this.visualMode
		}, this);
	},
	moveToCS: function(cs, where) {
		//hide controls
		this.hide();
		//get index to move row at
		var index = where == 'top' ? 0 : cs.getRowsNb();
		//scroll frame if necessary
		this.scroll();
		//create blocks infos to move them on server
		var blocks = {};
		for (var blockId in this.blocks) {
			if (this.blocks[blockId].hasContent) {
				blocks[blockId] = this.blocks[blockId].blockClass;
			}
		}
		//send all datas to server to move row from one cs to another
		Automne.server.call('page-content-controler.php', false, {
			action:			'move-row-cs',
			oldCs:			this.clientspace.getId(),
			cs:				cs.getId(),
			template:		this.template,
			page:			this.clientspace.page,
			rowType:		this.rowType,
			rowTag:			this.rowTagID,
			index:			index,
			blocks:			parent.Ext.util.JSON.encode(blocks),
			visualMode:		this.visualMode
		}, this);
		//move row
		cs.moveRowAt(this, index);
	},
	destroy : function(button){
		pr('Destroy row');
		if (button && button != 'ok') {
			return false;
		}
		//hide mask and controls
		this.hide();
		//unregister drag control
		if (this.dragZone && this.dragZone.unreg) {
			this.dragZone.unreg();
		}
		//destroy controls
		for (var controlId in this.controls) {
			this.controls[controlId].remove();
		}
		delete this.controls;
		//destroy row mask
		this.mask.destroy();
		//remove rows elements
		this.elements.each(function(el){
			el.switchOff({remove:true});
		});
		//create blocks infos to clear them on server
		var blocks = {};
		for (var blockId in this.blocks) {
			if (this.blocks[blockId].hasContent) {
				blocks[blockId] = this.blocks[blockId].blockClass;
			}
			this.blocks[blockId].destroy();
		}
		//send all datas to server to create new row and get row HTML code
		Automne.server.call('page-content-controler.php', false, {
			action:			'del-row',
			cs:				this.clientspace.getId(),
			template:		this.template,
			page:			this.clientspace.page,
			rowType:		this.rowType,
			rowTag:			this.rowTagID,
			blocks:			parent.Ext.util.JSON.encode(blocks),
			visualMode:		this.visualMode
		}, this);
		//remove row from CS
		this.clientspace.removeRow(this);
		delete this.document;
	},
	replaceContent: function(response, option) {
		//force mouse out
		this.mouseOut();
		if (response.responseXML.getElementsByTagName('content').length) {
			//get new row content from server response
			var content = response.responseXML.getElementsByTagName('content').item(0).firstChild.nodeValue;
			//get the first old row element
			var el = this.elements.first();
			//insert row new HTML before old element
			el.insertHtml('beforebegin', Ext.util.Format.stripScripts(content));
			//remove old blocks infos
			for (var blockId in this.blocks) {
				this.blocks[blockId].destroy();
			}
			this.blocks = {};
			//then remove all old elements
			this.elements.remove();
			//load scripts in response
			var re = /(?:<script([^>]*)?>)((\n|\r|.)*?)(?:<\/script>)/ig;
			var atmRowsDatas = {};
			var atmBlocksDatas = {};
			while(match = re.exec(content)){
				if(match[2] && match[2].length > 0){
					eval(match[2]);
				}
			}
			//pr(atmRowsDatas);
			//pr(atmBlocksDatas);
			//replace row datas
			for(var rowId in atmRowsDatas) {
				if(rowId == this.getId()) {
					//apply new config
					Ext.apply(this, atmRowsDatas[rowId]);
				}
			}
			//init component (create elements events)
			this.initComponent();
			//instanciate all new blocks objects and add them to row
			for (var blockId in atmBlocksDatas) {
				var block = eval('new '+atmBlocksDatas[blockId].jsBlockClass+'(atmBlocksDatas[blockId]);');
				//pr(blocks[blockId]);
				this.addBlock(block);
			}
			//then, finally, catch all click possibilities
			for (var blockId in this.blocks) {
				var elLen = this.blocks[blockId].elements.getCount();
				this.blocks[blockId].elements.each(function(el){
					parent.Automne.utils.catchLinks(el, 'edit');
				});
			}
		}
	},
	removeListeners: function() {
		//remove listeners on all blocks elements
		for (var blockId in this.blocks) {
			var box = this.blocks[blockId].removeListeners();
		}
		//unregister drag control
		if (this.dragZone && this.dragZone.unreg) {
			try {
				this.dragZone.unreg();
			} catch(e) {}
		}
		//remove events on elements and mask controls
		for (var controlId in this.controls) {
			this.controls[controlId].removeAllListeners();
		}
		this.elements.removeAllListeners();
		//destroy controls
		delete this.controls;
		//remove mask
		if (this.mask) {
			this.mask.destroy();
		}
		delete this.document;
	},
	checkBlockControlIntersection: function(id, mask) {
		for (var blockId in this.blocks) {
			if (blockId != id && this.blocks[blockId].mask && this.blocks[blockId].mask.isDisplayed()) {
				if (this.blocks[blockId].mask.getRegion().intersect(mask.getRegion())) {
					return false;
				}
			}
		}
		return true;
	}
});

/**
 * @class Automne.contentMask
 * @extends Ext.util.Observable
 * @constructor
 * @param {Integer} thickness : the mask borders thickness
 * @param {String} cls : the mask borders class name
 * @param {HTML element} document : the document where the mask should be created
 */
Automne.contentMask = function(thickness, cls, document) {
	this.document = document;
	this.cls = cls;
	this.thickness = thickness;
	this.createElements();
};
Automne.contentMask.prototype = {
	right: 				false,
	left: 				false,
	top: 				false,
	bottom: 			false,
	all: 				false,
	active: 			false,
	position:			false,
	size:				false,
	cls:				'',
	thickness:			2,
	document:			false,
	createElements : function(){
		var bd = Ext.get(this.document.body);
		this.right = bd.createChild({cls: this.cls +' '+ this.cls +'-right'});
		this.left = bd.createChild({cls: this.cls +' '+ this.cls +'-left'});
		this.top = bd.createChild({cls: this.cls +' '+ this.cls +'-top'});
		this.bottom = bd.createChild({cls: this.cls +' '+ this.cls +'-bottom'});
		this.all = new Ext.CompositeElement([this.right, this.left, this.top, this.bottom]);
	},
	show : function(position, size, force){
		this.position = position;
		this.size = size;
		if (this.active && !force) {
			return false;
		}
		if(!this.right){
			this.createElements();
		}
		this.all.setStyle('position', 'absolute');
		this.all.setDisplayed('block');
		this.right.setBounds(
				this.position.x + this.size.width,
				this.position.y - this.thickness,
				this.thickness,
				this.size.height + (this.thickness * 2));
		this.left.setBounds(
				this.position.x - this.thickness,
				this.position.y - this.thickness,
				this.thickness,
				this.size.height + (this.thickness * 2));
		this.top.setBounds(
				this.position.x - this.thickness,
				this.position.y - this.thickness,
				this.size.width + (this.thickness * 2),
				this.thickness);
		this.bottom.setBounds(
				this.position.x - this.thickness,
				this.position.y + this.size.height,
				this.size.width + (this.thickness * 2),
				this.thickness + 1);
		this.active = true;
		return true;
	},
	hide : function(){
		if (this.active) {
			this.active = false;
			this.all.setDisplayed(false);
		}
	},
	destroy: function(){
		this.hide();
		try {
			this.right.remove();
			this.left.remove();
			this.top.remove();
			this.bottom.remove();
		} catch(e){}
		delete this.all;
		return true;
	}
};