/**
  * Automne Javascript file
  *
  * Automne.treePanel Extension Class for Ext.tree.TreePanel
  * Allow use of a json response embeded in an XML return (for error management)
  * @class Automne.treePanel
  * @extends Ext.tree.TreePanel
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: tree.js,v 1.5 2009/07/20 16:33:16 sebastien Exp $
  */
Automne.treePanel = Ext.extend(Ext.tree.TreePanel, {
	filterMenu:		false,
	searchBox:		false,
	
	//constructor
	constructor: function(config) { 
		// preprocessing
		this.filterSelectBox = (config.filterSelectBox) ? config.filterSelectBox : false;
		// preprocessing
		this.filterSearchBox = (config.filterSearchBox) ? config.filterSearchBox : false;
		//call constructor
		Automne.treePanel.superclass.constructor.apply(this, arguments); 
	},
	//component initialisation (after constructor)
	initComponent: function() {
		// call parent initComponent
		Automne.treePanel.superclass.initComponent.call(this);
		
		//do layout on toolbar to correct combobox position (do not remove !)
		if (Ext.getCmp('treeToolbar')) {
			this.on('render', function(){
				Ext.getCmp('treeToolbar').items.each(function(item) {
					if (item.el && item.el.id == 'searchBox') {
						item.getEl().parent().setWidth(item.el.dom.width);
					}
				});
			}, this);
		}
		//set filter menu
		this.filterMenu = Ext.menu.MenuMgr.get('filterMenu');
		//set combo box
		this.searchBox = Ext.getCmp('searchBox');
	},
	// private
	initEvents : function(){
		Automne.treePanel.superclass.initEvents.call(this);
		if (this.filterMenu) {
			this.filterMenu.items.each(function(item){
				item.on({'checkchange': this.filterVisibility, scope: this});
			}, this);
		}
		if (this.searchBox) {
			this.searchBox.on('beforequery', this.filterSearch, this);
			this.searchBox.on('beforeselect', this.searchBeforeSelect, this);
		}
	},
	filterVisibility: function(el, checked) {
		//check for value change then reload tree
		if (checked) {
			this.getLoader().baseParams.editable = (el.value == 1) ? true : false;
			this.getRootNode().reload();
		}
		return true;
	},
	filterSearch: function(queryEvent) {
		//check for integer search
		if (!isNaN(parseInt(queryEvent.query,10))) {
			//cancel query
			queryEvent.cancel = true;
			//collapse panel if it is open
			queryEvent.combo.collapse();
			//and reload tree with given id
			var nodeId = parseInt(queryEvent.query,10);
			this.getLoader().baseParams.currentPage = nodeId;
			var node = this.getNodeById('page' + nodeId);
			if (node) {
				this.collapseAll();
				this.expandPath(node.getPath());
				node.select();
			} else {
				//call server for queried node lineage
				Automne.server.call({
					url:			'/automne/admin/tree-lineage.php',
					scope:			this,
					fcnCallback:	function(response, options, jsonResponse){
						if (jsonResponse) {
							this.showLineage(jsonResponse);
						} else {
							//send error message
							Automne.message.popup({
								msg: 				Automne.locales.noPageFounded,
								buttons: 			Ext.MessageBox.OK,
								closable: 			true,
								icon: 				Ext.MessageBox.INFO,
								fn:					function(){
									//to correct focus bug
									this.searchBox.focus();
									this.searchBox.hasFocus = true;
								},
								scope:				this
							});
						}
					},
					params:			{
						root:		this.root.id.substr(4),
						node:		nodeId
					}
				});
			}
			//to correct focus bug
			this.searchBox.focus();
			this.searchBox.hasFocus = true;
			return false;
		} else if (queryEvent.query.length < 3) {
			//cancel query
			queryEvent.cancel = true;
			//collapse panel if it is open
			queryEvent.combo.collapse();
			return false;
		}
		queryEvent.cancel = false;
		queryEvent.forceAll = true;
		//to correct focus bug
		this.searchBox.focus();
		this.searchBox.hasFocus = true;
		return true;
	},
	searchBeforeSelect: function(combo, record, index) {
		//reload tree with given page id
		if (!isNaN(parseInt(record.id,10))) {
			var nodeId = parseInt(record.id,10);
			this.getLoader().baseParams.currentPage = nodeId;
			var node = this.getNodeById('page' + nodeId);
			if (node) {
				this.collapseAll();
				this.expandPath(node.getPath());
				node.select();
			} else {
				this.showLineage(record.json.lineage);
			}
		}
		return false;
	},
	showLineage: function(lineage) {
		if (lineage) {
			this.collapseAll();
			var node;
			for(var i = 0; i < lineage.length; i++) {
				node = this.getNodeById('page' + lineage[i]);
				if (node) {
					node.expand();
				} else {
					node = this.getNodeById('root' + lineage[i]);
					if (node) {
						node.expand();
					}
				}
			}
		}
		if (node) {
			node.select();
		}
	}
});
/**
  * Automne.treeNode Extension Class for Ext.tree.TreeNodeUI
  * Display a tree node
  * @class Automne.treeNode
  * @extends Ext.tree.TreeNodeUI
  */
Automne.treeNode = Ext.extend(Ext.tree.TreeNodeUI, {
	render : function(bulkRender){
		var n = this.node, a = n.attributes;
		var targetNode = n.parentNode ? 
			  n.parentNode.ui.getContainer() : n.ownerTree.innerCt.dom;
		
		if(!this.rendered){
			this.rendered = true;

			this.renderElements(n, a, targetNode, bulkRender);

			if(a.qtip){
			   if(this.textNode.setAttributeNS){
				   this.textNode.setAttributeNS("ext", "qtip", a.qtip);
				   if(a.qtipTitle){
					   this.textNode.setAttributeNS("ext", "qtitle", a.qtipTitle);
				   }
			   }else{
				   this.textNode.setAttribute("ext:qtip", a.qtip);
				   if(a.qtipTitle){
					   this.textNode.setAttribute("ext:qtitle", a.qtipTitle);
				   }
			   } 
			}else if(a.qtipCfg){
				a.qtipCfg.target = Ext.id(this.textNode);
				Ext.QuickTips.register(a.qtipCfg);
			}
			this.initEvents();
			if(!this.node.expanded){
				this.updateExpandIcon(true);
			}
		}else{
			if(bulkRender === true) {
				targetNode.appendChild(this.wrap);
			}
		}
	},
	
	// private
	onClick : function(e){
		if(this.dropping){
			e.stopEvent();
			return;
		}
		if(this.fireEvent("beforeclick", this.node, e) !== false){
			var a = e.getTarget('a');
			if(!this.disabled && this.node.attributes.href && a){
				this.fireEvent("click", this.node, e);
				return;
			}else if(!this.disabled && this.node.attributes.onClick && a){
				eval(this.node.attributes.onClick);
				e.stopEvent();
				return;
			}else if(a && e.ctrlKey){
				e.stopEvent();
			}
			e.preventDefault();
			if(this.disabled){
				return;
			}

			if(this.node.attributes.singleClickExpand && !this.animating && this.node.hasChildNodes()){
				this.node.toggle();
			}

			this.fireEvent("click", this.node, e);
		}else{
			e.stopEvent();
		}
	},
	/**
	  * Method used to render a tree element
	  * @param n : the tree node object
	  * @param a : the tree node object config sent by server
	  * @param targetNode : the html element in which the node take place
	  * @param bulkRender : boolean (?)
	  */
	renderElements: function(n, a, targetNode, bulkRender){
	   // add some indent caching, this helps performance when rendering a large tree
		this.indentMarkup = n.parentNode ? n.parentNode.ui.getChildIndent() : '';
		//disabled ?
		if (a.disabled) {
			this.disabled = true;
			var disabledCls = 'atm-tree-disabled';
		} else {
			var disabledCls = '';
			this.disabled = false;
		}
		var href = a.href ? a.href : Ext.isGecko ? "" : "#";
		var text = !a.draggable && !a.allowDrop ? '<a hidefocus="on" class="x-tree-node-anchor" href="'+ href +'" tabIndex="1" '+ (a.hrefTarget ? ' target="'+ a.hrefTarget +'"' : '') + '>'+ n.text +'</a>' : n.text;
		var buf = ['<li class="x-tree-node">',
			'<div ext:tree-node-id="',n.id,'" class="x-tree-node-el x-tree-node-leaf x-unselectable ', a.cls,'" unselectable="on">',
				'<span class="x-tree-node-indent">',this.indentMarkup,'</span>',
				'<img src="', this.emptyIcon, '" class="x-tree-ec-icon x-tree-elbow" />',
				'<img src="', a.icon || this.emptyIcon, '" unselectable="on" />',
				a.status,
				'<span class="atm-tree-page ',disabledCls, a.draggable ? ' atm-drag' : '','" unselectable="on">',
					text,
				'</span>',
			'</div>',
			'<ul class="x-tree-node-ct" style="display:none;"></ul>',
			'</li>'].join('');
			
		var nel;
		if(bulkRender !== true && n.nextSibling && (nel = n.nextSibling.ui.getEl())){
			this.wrap = Ext.DomHelper.insertHtml("beforeBegin", nel, buf);
		}else{
			this.wrap = Ext.DomHelper.insertHtml("beforeEnd", targetNode, buf);
		}
		
		this.elNode = this.wrap.childNodes[0];
		this.ctNode = this.wrap.childNodes[1];
		var cs = this.elNode.childNodes;
		this.indentNode = cs[0];
		this.ecNode = cs[1];
		this.iconNode = cs[2];
		this.anchor = cs[4].firstChild;
		this.textNode = cs[4].firstChild.firstChild;
		this.dragNode = (cs[4]) ? cs[4] : cs[3];
		if (a.expanded) n.expand();
		if (a.selected) {
			n.select();
			if(n.attributes.onSelect){
				var node = n;
				eval(node.attributes.onSelect);
			}
		}
	},
	getDDHandles : function(){
		return [this.dragNode];
	},
	// private
	onMove : function(tree, node, oldParent, newParent, index, refNode){
		// call parent
		Automne.treeNode.superclass.onMove.apply(this, arguments);
		//send new node position to server
		var value = '';
		for (var i = 0; i < newParent.childNodes.length; i++) {
			value += newParent.childNodes[i].id.substr(4) + ((i+1) < newParent.childNodes.length ? ',':'');
		}
		Automne.server.call({
			url:				'page-controler.php',
			params: 			{
				currentPage:	node.id.substr(4),
				action:			'move',
				oldParent:		oldParent.id.substr(4),
				newParent:		newParent.id.substr(4),
				value:			value
			}
		});
	}
});

/**
  * Automne.treeLoader Extension Class for Ext.tree.TreeLoader
  * Allow use of a json response embeded in an XML return (for error management)
  * @class Automne.treeLoader
  * @extends Ext.tree.TreeLoader
  */
Automne.treeLoader = Ext.extend(Ext.tree.TreeLoader, {
	processResponse : function(response, node, sentCallback){
		//redirect to automne evalResponse for errors management
		Automne.server.evalResponse(response, {
			scope:			this,
			node:			node,
			fcnCallback:	this.processJsonResponse,
			sentCallback:	sentCallback
		});
	},
	processJsonResponse : function(response, options, jsonResponse){
		//extract json datas from response
		var jsonResponse;
		if (response.responseXML.getElementsByTagName('jsoncontent').length) {
			jsonResponse = response.responseXML.getElementsByTagName('jsoncontent').item(0).firstChild.nodeValue;
		}
		//overwrite responseText with json response
		response.responseText = jsonResponse;
		//call parent method processResponse to process json datas
		Automne.treeLoader.superclass.processResponse.call(this, response, options.node, options.sentCallback);
	}
});

Ext.tree.TreeDropZone.override({
	// private
	getDropPoint : function(e, n, dd){
		var tn = n.node;
		if(tn.isRoot){
			return tn.allowChildren !== false ? "append" : false; // always append for root
		}
		var dragEl = n.ddel;
		var t = Ext.lib.Dom.getY(dragEl), b = t + dragEl.offsetHeight;
		var y = Ext.lib.Event.getPageY(e);
		var noAppend = tn.allowChildren === false;// || tn.isLeaf(); changed this to allow appening into a leaf node
		if(this.appendOnly || tn.parentNode.allowChildren === false){
			return noAppend ? false : "append";
		}
		var noBelow = false;
		if(!this.allowParentInsert){
			noBelow = tn.hasChildNodes() && tn.isExpanded();
		}
		var q = (b - t) / (noAppend ? 2 : 3);
		if(y >= t && y < (t + q)){
			return "above";
		}else if(!noBelow && (noAppend || y >= b-q && y <= b)){
			return "below";
		}else{
			return "append";
		}
	}
});