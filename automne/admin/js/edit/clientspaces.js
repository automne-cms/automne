/**
  * Automne Javascript file
  *
  * Automne.cs Extension Class for Ext.util.Observable
  * Create extendable clientspace content element which is contain rows
  * @class Automne.cs
  * @extends Ext.util.Observable
  * @package CMS
  * @subpackage JS
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: clientspaces.js,v 1.6 2009/11/10 16:57:21 sebastien Exp $
  */
Automne.cs = function(config){
	config = config || {};
	if(config.initialConfig){
		config = config.initialConfig; // component cloning / action set up
	}
	this.rows = []; //to correct a weird reference pb
	this.brothers = {left: false, right: false, top: false, bottom: false};
	this.zones = [];
	this.initialConfig = config;
	Ext.apply(this, config);
	Automne.cs.superclass.constructor.call(this);
	this.initComponent();
};

Ext.extend(Automne.cs, Ext.util.Observable, {
	id : 				false,
	initialConfig:		{},
	template : 			false,
	page : 				false,
	rows : 				[],
	zones : 			[],
	size : 				{width:0, height:0},
	position : 			{x:0, y:0},
	document: 			false,
	mask:				false,
	brothers:			{left: false, right: false, top: false, bottom: false},
	marker:				false,
	visualMode:			1,
	initComponent : function() {
		//get marker
		this.marker = Ext.select('#atm-cs-'+this.getId(), true, this.document).first();
		this.marker.setVisibilityMode(Ext.Element.DISPLAY);
		//create surounding mask
		this.mask = new Automne.contentMask(0, 'atm-cs', this.document);//thickness, cls, document
	},
	addRow: function(row) {
		//remove row from previous CS if any
		if(row.clientspace && row.clientspace.getId() != this.getId()) {
			row.clientspace.removeRow(row);
		}
		var rowslen = this.rows.length;
		this.rows[rowslen] = row;
		this.rows[rowslen].setCSOrder(rowslen);
		this.rows[rowslen].setCS(this);
		//this CS has at least one row so we can hide marker
		this.marker.setVisible(false);
	},
	removeRow: function(row) {
		this.rows = this.rows.remove(row);
		//redo rows index enumeration
		for(var i = 0, rowsLen = this.rows.length; i < rowsLen; i++) {
			this.rows[i].setCSOrder(i);
		}
		//redo CS mask
		atmContent.updateCSMasks();
	},
	getRowsNb: function(row) {
		return this.rows.length;
	},
	getRow: function(index) {
		if (!this.rows[index]) {
			return false;
		}
		return this.rows[index];
	},
	moveRowAt: function(row, newIndex) {
		//get the current row at queried index
		var oldPositionRow = this.getRow(newIndex);
		var sameCS = row.clientspace.getId() == this.getId();
		//check if returned row is before or after the row to move
		if (!oldPositionRow || (oldPositionRow.csOrder > row.csOrder && row.clientspace.getId() == this.getId())) { //insert after
			//if no row at specified index, get last row of CS and put row after
			if (!oldPositionRow) {
				var oldPositionRow = this.getRow(this.getRowsNb() - 1);
				newIndex = (row.clientspace.getId() != this.getId()) ? this.getRowsNb() : oldPositionRow.csOrder;
			}
			//get the element following the last of the old row
			var el = this.getElNextRow(oldPositionRow);
			if (el) {
				this.moveElsBeforeEl(row, el, sameCS);
			}
		} else { //insert before
			this.moveElsBeforeEl(row, oldPositionRow.elements.first(), sameCS);
		}
		//if row is not from this current CS, add it
		if(row.clientspace.getId() != this.getId()) {
			this.addRow(row);
		}
		//if no change in row index, no need to redo enumeration
		if(row.csOrder == newIndex) {
			return;
		}
		//redo rows index enumeration
		var oldIndex = row.csOrder;
		var rows = [];
		var i = 0;
		var curIndex = 0;
		while(this.rows[i] || newIndex >= curIndex) {
			if (i != oldIndex) {
				curIndex = rows.length;
				if (curIndex == newIndex) {
					rows[curIndex] = this.rows[oldIndex];
					rows[curIndex].setCSOrder(curIndex);
					curIndex = rows.length;
				}
				if (this.rows[i]) {
					rows[curIndex] = this.rows[i];
					rows[curIndex].setCSOrder(curIndex);
				}
			}
			i++;
		}
		this.rows = rows;
	},
	getElNextRow: function (row) {
		var el;
		if (row) {
			el = row.elements.last().next();
			var ok = false;
			while(el && !ok) {
				if (el.isVisible() && el.dom.tagName != 'script') {
					ok = true;
				} else {
					el = el.next();
				}
			}
			if (!el) {
				this.marker.show();
				el = this.marker;
			}
		} else {
			el = this.marker;
		}
		return el;
	},
	moveElsBeforeEl: function(rowToMove, targetEl, sameCS) {
		//stop CS update and row mask
		atmContent.stopUpdate();
		atmContent.stopRowsMask();
		
		var elsToMove = rowToMove.elements;
		var elsBox = rowToMove.getBox();
		
		var animateMoveStatus = (parent.Ext.getCmp('editAnimations'+ atmContent.editId)) ? parent.Ext.getCmp('editAnimations'+ atmContent.editId).checked : true;
		if (animateMoveStatus) {
			var positionFrom = elsBox;
			//try to get the row of the target el to get more accurate final position
			var elRow;
			if (elRow = atmContent.getRowForEl(targetEl)) {
				var positionTo = elRow.getBox();
			} else {
				var positionTo = targetEl.getBox();
			}
			//if row is moved in the same CS, keep x position of the row (this is a simple translation)
			if (sameCS) {
				positionTo.x = elsBox.x;
			}
			var moveOffset = {x:0, y:0};
			moveOffset.x = (positionFrom.x < positionTo.x) ? positionTo.x - positionFrom.x : (positionFrom.x > positionTo.x) ? - (positionFrom.x - positionTo.x) : 0;
			if (positionFrom.y < positionTo.y) {
				moveOffset.y = (moveOffset.x == 0) ? positionTo.y - positionFrom.y - elsBox.height : positionTo.y - positionFrom.y;
			} else if (positionFrom.y > positionTo.y) {
				moveOffset.y = - (positionFrom.y - positionTo.y);
			} else {
				moveOffset.y = 0
			}
			var count = 0;
			elsToMove.each(function(el) {
				//clone element to move
				var proxy = el.createProxy({tag:'div'}, targetEl.parent(), true);
				var elClone = el.dom.cloneNode(true);
				elClone.id = Ext.id();
				proxy.appendChild(elClone);
				el.hide();
				var from = el.getXY();
				//move proxy of offset then move element and destroy proxy
				proxy.moveTo(moveOffset.x + from[0], moveOffset.y + from[1], {duration:0.6, callback:function(){
					count++;
					el.insertBefore(targetEl);
					proxy.remove();
					el.show();
					//if this is the last element, restart CS update and row mask
					if(count == elsToMove.getCount()) {
						atmContent.startUpdate();
						atmContent.startRowsMask();
					}
				}, scope:this, remove:true});
			}, this);
		} else {
			elsToMove.insertBefore(targetEl);
			atmContent.startUpdate();
			atmContent.startRowsMask();
		}
		if (targetEl == this.marker) {
			this.marker.hide();
		}
	},
	getBrother: function(position) {
		return this.brothers[position];
	},
	setBrother: function(cs) {
		var box = this.getBox();
		var csBox = cs.getBox();
		//get the absolute distance between two points
		var distance = function(box1, box2) {
			return Math.abs(Math.sqrt(Math.pow(box2.x - box1.x, 2) + Math.pow(box2.y - box1.y, 2)));
		}
		for(var pos in this.brothers) {
			var ok = false;
			switch(pos) {
				case 'left':
					ok = (box.x > csBox.x && (box.x + box.width) > (csBox.x + csBox.width));
				break;
				case 'right':
					ok = (box.x < csBox.x && (box.x + box.width) < (csBox.x + csBox.width));
				break;
				case 'top':
					ok = (box.y > csBox.y && ((box.x <= csBox.x && box.x + box.width - csBox.x > 0) || (box.x >= csBox.x && csBox.x + csBox.width - box.x > 0)));
				break;
				case 'bottom':
					ok = (box.y < csBox.y && ((box.x <= csBox.x && box.x + box.width - csBox.x > 0) || (box.x >= csBox.x && csBox.x + csBox.width - box.x > 0)));
				break;
			}
			//var status = (ok && (!this.brothers[pos] || distance(box, csBox) <= distance(box, this.brothers[pos].getBox()))) ? true : false;
			this.brothers[pos] = (ok && (!this.brothers[pos] || distance(box, csBox) < distance(box, this.brothers[pos].getBox()))) ? cs : this.brothers[pos]; 
			//pr(pos+' : '+status);
			//pr(box);
			//pr(csBox);
			//pr('------');
		}
	},
	getBox: function() {
		var rowsLen = this.rows.length;
		if (rowsLen > 0) {
			//init values
			this.size = {width:0, height:0};
			this.position = {x:0, y:0};
			//then add size of each elements into rows
			for(var i = 0; i < rowsLen; i++) {
				//get row size and position
				var box = this.rows[i].getBox();
				//x
				if (!this.position.x || box.x < this.position.x) {
					this.position.x = parseInt(box.x, 10) - 3;
				}
				//y
				if (!this.position.y || box.y < this.position.y) {
					this.position.y = parseInt(box.y, 10) - 3;
				}
				//width
				if (!this.size.width || (box.width + (box.x - this.position.x)) > this.size.width) {
					this.size.width = parseInt(box.width + (box.x - this.position.x), 10) + 1;
				}
				//height
				if (!this.size.height || (box.height + (box.y - this.position.y)) > this.size.height) {
					this.size.height = parseInt(box.height + (box.y - this.position.y), 10) + 2;
				}
			}
		} else {
			this.marker.setVisible(true);
			var box = this.marker.getBox();
			this.position.x = parseInt(box.x);
			this.position.y = parseInt(box.y);
			this.size.width = parseInt(box.width);
			this.size.height = parseInt(box.height);
		}
		if (this.size.width < 128) {
			this.size.width = 128
		}
		if (this.size.height < 20) {
			this.size.height = 20
		}
		return {x:this.position.x, y:this.position.y, width:this.size.width, height:this.size.height};
	},
	//show cs mask
	show : function(){
		this.getBox();
		//show row border 
		if (!this.mask.show(this.position, this.size)) {
			return false;
		}
		return true;
	},
	//hide cs mask
	hide : function(){
		this.mask.hide();
	},
	//update cs mask position
	updateMask: function() {
		this.getBox();
		//show row border 
		if (!this.mask.show(this.position, this.size, true)) {
			return false;
		}
	},
	/**
	 * Returns the id of this component.
	 * @return {String}
	 */
	getId : function(){
		return this.id;
	},
	showZones: function(type) {
		type = type || 'drop';
		this.zones = [];
		//create a drop zone into each CS rows
		if (this.rows.length) {
			for(var i = 0, rowsLen = this.rows.length; i < rowsLen; i++) {
				var box = this.rows[i].getBox();
				this.registerZone(type, box.x, box.y - 5, box.width, 10);
				//last zone (at end of CS)
				if (i + 1 == rowsLen) {
					this.registerZone(type, box.x, box.y + box.height - 5, box.width, 10);
				}
			}
		} else {
			var box = this.marker.getBox();
			this.registerZone(type, box.x, box.y + 5, box.width, 10);
		}
	},
	hideZones: function(exception) {
		for(var i = 0, dropLen = this.zones.length; i < dropLen; i++) {
			if (!exception || this.zones[i].id != exception.id) {
				if (this.zones[i].dropZone) {
					this.zones[i].dropZone.unreg();
					Ext.destroy(this.zones[i].dropZone);
				} else {
					this.zones[i].removeAllListeners();
				}
				Ext.destroy(this.zones[i]);
			}
		}
		if (!exception) {
			delete this.zones;
			this.zones = [];
		} else {
			this.zones = [exception];
		}
	},
	registerZone: function(type, x, y, width, height) {
		var zonesLen = this.zones.length;
		this.zones[zonesLen] = Ext.get(this.document.body).createChild({cls: 'atm-drop-zone'});
		var zone = this.zones[zonesLen];
		zone.setStyle('position', 'absolute');
		zone.setDisplayed('block');
		zone.setBounds(x, y, width, height);
		zone.cs = this;
		zone.csIndex = zonesLen;
		if (type == 'drop') {
			var drop = new Ext.dd.DropZone(zone, {
				//	  If the mouse is over a target node, return that node. This is
				//	  provided as the "target" parameter in all "onNodeXXXX" node event handling functions
				getTargetFromEvent: function(e) {
					return e.getTarget('.atm-drop-zone');
				},
				//	  On entry into a target node, highlight that node.
				onNodeEnter : function(target, dd, e, data){ 
					Ext.fly(target).addClass('atm-drop-zone-hover');
				},
				//	  On exit from a target node, unhighlight that node.
				onNodeOut : function(target, dd, e, data){ 
					Ext.fly(target).removeClass('atm-drop-zone-hover');
				},
				//	  While over a target node, return the default drop allowed class which
				//	  places a "tick" icon into the drag proxy.
				onNodeOver : function(target, dd, e, data){ 
					return Ext.dd.DropZone.prototype.dropAllowed;
				},
				//	  On node drop, we can interrogate the target node to find the underlying
				//	  application object that is the real target of the dragged data.
				//	  In this case, it is a Record in the GridPanel's Store.
				//	  We can use the data set up by the DragZone's getDragData method to read
				//	  any data we decided to attach.
				onNodeDrop : function(target, dd, e, data){
					//if index to drop and cs to drop are the same of current row position, skip moving row
					if ((dd.row.csOrder != this.el.csIndex && dd.row.csOrder + 1 != this.el.csIndex) || dd.row.clientspace.getId() != this.el.cs.getId()) {
						var newIndex = this.el.csIndex;
						if (dd.row.clientspace.getId() != this.el.cs.getId()) { //row change of CS
							//create blocks infos to move them on server
							var blocks = {};
							for (var blockId in dd.row.blocks) {
								if (dd.row.blocks[blockId].hasContent) {
									blocks[blockId] = dd.row.blocks[blockId].blockClass;
								}
							}
							//send all datas to server to move row from one cs to another
							Automne.server.call('page-content-controler.php', false, {
								action:			'move-row-cs',
								oldCs:			dd.row.clientspace.getId(),
								cs:				this.el.cs.getId(),
								template:		dd.row.template,
								page:			dd.row.clientspace.page,
								rowType:		dd.row.rowType,
								rowTag:			dd.row.rowTagID,
								index:			newIndex,
								blocks:			parent.Ext.util.JSON.encode(blocks),
								visualMode:		this.visualMode
							}, this);
						} else { //row stay in the same cs, so it is only a move
							if (dd.row.csOrder < this.el.csIndex && (this.el.csIndex - 1) >= 0) {
								var newIndex = this.el.csIndex - 1;
							}
							//send all datas to server to move row at queried index
							Automne.server.call('page-content-controler.php', false, {
								action:			'move-row',
								cs:				dd.row.clientspace.getId(),
								template:		dd.row.template,
								page:			dd.row.clientspace.page,
								rowType:		dd.row.rowType,
								rowTag:			dd.row.rowTagID,
								index:			newIndex,
								visualMode:		this.visualMode
							}, this);
						}
						//move row to given CS at given index
						this.el.cs.moveRowAt(dd.row, newIndex);
					} else {
						//allow row mask to be displayed
						atmContent.startRowsMask();
					}
					//hide all drop zones
					atmContent.hideZones();
					return true;
				}
			});
			zone.dropZone = drop;
		} else {
			zone.on('mousedown', function(e, zone) {
				zone = Ext.get(zone);
				zone.removeAllListeners();
				zone.addClass('atm-drop-zone-hover');
				parent.Ext.get('selectedRow'+ atmContent.editId).update(Automne.locales.csSelectRowAdd);
				if (!Automne.popup) {
					parent.Automne.message.show(Automne.locales.csSelectRow, '', parent.Automne.tabPanels.getActiveTab().frameEl);
				}
				parent.Ext.getCmp('addRowCombo'+ atmContent.editId).show();
				var addButton = parent.Ext.getCmp('addSelectedRow'+ atmContent.editId);
				addButton.show();
				if (isNaN(parseInt(parent.Ext.getCmp('addRowCombo'+ atmContent.editId).getValue(),10))) {
					addButton.disable();
				}
				//add new row
				this.cs.getNewRow(this.csIndex);
				//hide all drop zones
				atmContent.hideZones(zone);
			}, zone);
			zone.addClassOnOver('atm-drop-zone-hover');
			zone.dom.title = zone.dom.alt = Automne.locales.csClickToAdd;
		}
	},
	getNewRow: function(index) {
		//display window to select row to add according to queried CS
		var combo = parent.Ext.getCmp('addRowCombo'+ atmContent.editId);
		//set combo params for row queries
		combo.store.baseParams = Ext.apply(combo.store.baseParams, {
			cs:				this.getId(),
			index:			index,
			template:		this.template,
			visualMode:		this.visualMode
		});
		combo.show();
		//needed to correct bug 1209
		combo.store.load({
			cs:				this.getId(),
			index:			index,
			template:		this.template,
			visualMode:		this.visualMode
		});
	},
	addNewRow: function(response, options, content, jsFiles, cssFiles) {
		var newIndex = options.params.index
		//get the current row at queried index
		var oldPositionRow = this.getRow(newIndex);
		//check if returned row is before or after the row to move
		if (!oldPositionRow) { //insert after
			//if no row at specified index, get last row of CS and put row after
			if (!oldPositionRow) {
				var oldPositionRow = this.getRow(this.getRowsNb() - 1);
				newIndex = this.getRowsNb();
			}
			//get the element following the last of the old row
			var el = this.getElNextRow(oldPositionRow);
		} else { //insert before
			var el = oldPositionRow.elements.first();
		}
		//function to append the new row
		var createRow = function() {
			//insert row HTML at specified index
			el.insertHtml('beforebegin',Ext.util.Format.stripScripts(content));
			//load scripts in response
			var re = /(?:<script([^>]*)?>)((\n|\r|.)*?)(?:<\/script>)/ig;
			var atmRowsDatas = {};
			var atmBlocksDatas = {};
			while(match = re.exec(content)){
				if(match[2] && match[2].length > 0){
					eval(match[2]);
				}
			}
			//add row to CS
			for(var rowId in atmRowsDatas) {
				var row = new Automne.row(atmRowsDatas[rowId]);
				this.addRow(row);
			}
			//instanciate all blocks objects
			var blocks = {};
			for (var blockId in atmBlocksDatas) {
				blocks[blockId] = eval('new '+atmBlocksDatas[blockId].jsBlockClass+'(atmBlocksDatas[blockId])');
				//add block to row
				row.addBlock(blocks[blockId]);
			}
			//if no change in row index, no need to redo enumeration
			if(row.csOrder == newIndex) {
				return;
			}
			//redo rows index enumeration
			var oldIndex = row.csOrder;
			var rows = [];
			var i = 0;
			var curIndex = 0;
			while(this.rows[i] || newIndex >= curIndex) {
				if (i != oldIndex) {
					curIndex = rows.length;
					if (curIndex == newIndex) {
						rows[curIndex] = this.rows[oldIndex];
						rows[curIndex].setCSOrder(curIndex);
						curIndex = rows.length;
					}
					if (this.rows[i]) {
						rows[curIndex] = this.rows[i];
						rows[curIndex].setCSOrder(curIndex);
					}
				}
				i++;
			}
			this.rows = rows;
		}
		
		//check if we need to append some css files
		if (cssFiles.files) {
			var documentCSS = Ext.select('link', true, this.document);
			var cssFilesToAppend = [];
			for(var i = 0, jslen = cssFiles.files.length; i < jslen; i++) {
				var exists = false;
				documentCSS.each(function(link) {
					if (link.dom.rel && link.dom.rel=='stylesheet' && link.dom.href.indexOf(cssFiles.files[i]) !== -1) {
						exists = true;
					}
				}, this);
				if (!exists) {
					cssFilesToAppend.push(cssFiles.files[i]);
				}
			}
			if (cssFilesToAppend.length) {
				el.insertHtml('beforebegin','<link rel="stylesheet" type="text/css" href="'+ cssFiles.manager +'&amp;files='+ cssFilesToAppend.toString() +'" media="screen" />');
			}
		}
		//check if we need to append some js files
		if (jsFiles.files) {
			var documentJS = Ext.select('script', true, this.document);
			var jsFilesToAppend = [];
			for(var i = 0, jslen = jsFiles.files.length; i < jslen; i++) {
				var exists = false;
				documentJS.each(function(script) {
					if (script.dom.src && script.dom.src.indexOf(jsFiles.files[i]) !== -1) {
						exists = true;
					}
				}, this);
				if (!exists) {
					jsFilesToAppend.push(jsFiles.files[i]);
				}
			}
			if (jsFilesToAppend.length) {
				if (Ext.isChrome) {
					var body = document.getElementsByTagName('body')[0];
					var script = document.createElement('script');
					script.type = 'text/javascript';
					script.onload = createRow.createDelegate(this);
					script.src = jsFiles.manager +'&files='+ jsFilesToAppend.toString();
					body.appendChild(script);
				} else {
					var scriptEl = el.insertHtml('beforebegin','<script type="text/javascript" src="'+ jsFiles.manager +'&amp;files='+ jsFilesToAppend.toString() +'"></script>', true);
					scriptEl.on('load', createRow, this);
				}
			} else {
				createRow.call(this);
			}
		} else {
			createRow.call(this);
		}
	},
	removeListeners: function() {
		//remove listeners on all rows elements
		for(var i = 0, rowsLen = this.rows.length; i < rowsLen; i++) {
			var box = this.rows[i].removeListeners();
		}
		if (this.mask) {
			//remove mask
			this.mask.destroy();
		}
		delete this.document;
	}
});