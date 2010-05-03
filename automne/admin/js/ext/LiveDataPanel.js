Ext.ux.LiveDataPanel = Ext.extend(Ext.Panel, {
	limit: 10,
	scripts: false,
	currPage: 0,
	loadingTxt: Ext.LoadMask.prototype.msg,
	loadingIndicatorTxt: '{0} of {1} entries',
	loading: false,
	triggerScrollOffset: 150,
	initComponent: function(){
		var offset = this.frame ? 35 : 20;
		this.autoScroll = true;
		var dvConfig = Ext.applyIf({
			itemId: 'dv',
			xtype: 'dataview',
			autoScroll: true,
			width: this.width - offset,
			tpl: this.tpl,
			scripts: this.scripts,
			store: this.store,
			itemSelector: this.itemSelector
		}, this.dataView || {});
		this.items = [dvConfig];
		Ext.ux.LiveDataPanel.superclass.initComponent.call(this);
		this.dv = this.getComponent('dv');
	},
	onRender: function(ct, pos){
		Ext.ux.LiveDataPanel.superclass.onRender.apply(this, arguments);
		this.indicatorEl = this.el.createChild({
			tag: 'div',
			cls: 'load-indicator',
			html: '<img src="/automne/admin/img/loading.gif" /><span></span>'
		});
		this.dv.store.on('load', function(){
			this.indicatorEl.anchorTo(this.el, 'br-br?', [-25, -10]);
		}, this);
		this.body.on('scroll', function(e, t){
			var ds = this.dv.store;
			if ((t.scrollTop + t.clientHeight + this.triggerScrollOffset >= t.scrollHeight) && ds.getCount() !== ds.getTotalCount() && this.loading === false) {					
				this.nextPage();				
			}
		}, this);
	},
	nextPage: function(pageNum) {		
		this.currPage++;
		this.updateIndicator();
		this.indicatorEl.show();		
		var start = this.currPage * this.limit;			
		this.loading = true;
		//this is needed to correct a reference pb
		this.dv.store.baseParams.start = start;
		this.dv.store.load({
			params: {
				start: start,
				limit: this.limit					
			},
			callback: function() {
				this.indicatorEl.hide();					
				this.loading = false;
			},
			scope: this,
			add: true
		});
	},
	updateIndicator: function() {
		var to = (this.currPage+1) * this.limit < this.dv.store.getTotalCount() ? (this.currPage+1) * this.limit : this.dv.store.getTotalCount();
		var txt = String.format(this.loadingIndicatorTxt, to, this.dv.store.getTotalCount());
		this.indicatorEl.down('span').update(txt);
	}
});
Ext.reg('livedatapanel', Ext.ux.LiveDataPanel);

Ext.DataView.override({
	/**
	 * Refreshes the view by reloading the data from the store and re-rendering the template.
	 */
	refresh : function(){
		this.clearSelections(false, true);
		this.el.update("");
		var records = this.store.getRange();
		if(records.length < 1){
			if(!this.deferEmptyText || this.hasSkippedEmptyText){
				this.el.update(this.emptyText);
			}
			this.hasSkippedEmptyText = true;
			this.all.clear();
			return;
		}
		this.tpl.overwrite(this.el, this.collectData(records, 0));
		this.all.fill(Ext.query(this.itemSelector, this.el.dom));
		//execute all JS in page if needed
		if (this.scripts) {
			//load scripts in response
			var re = /(?:<script([^>]*)?>)((\n|\r|.)*?)(?:<\/script>)/ig;
			while(match = re.exec(this.el.dom.innerHTML)){
				if(match[2] && match[2].length > 0){
					eval(match[2]);
				}
			}
		}
		this.updateIndexes(0);
	},
	// private
	bufferRender : function(records){
		var div = document.createElement('div');
		this.tpl.overwrite(div, this.collectData(records));
		//execute all JS in element if needed
		if (this.scripts && div.innerHTML) {
			//load scripts in response
			var re = /(?:<script([^>]*)?>)((\n|\r|.)*?)(?:<\/script>)/ig;
			while(match = re.exec(div.innerHTML)){
				if(match[2] && match[2].length > 0){
					eval(match[2]);
				}
			}
		}
		return Ext.query(this.itemSelector, div);
	},
	onAdd : function(ds, records, index){
		if(this.all.getCount() == 0){
			this.refresh();
			return;
		}
		var nodes = this.bufferRender(records, index), n, a = this.all.elements;		
		if(index < this.all.getCount()){
			n = this.all.item(index).insertSibling(nodes, 'before', true);
			a.splice.apply(a, [index, 0].concat(nodes));
		}else{
			nodes.reverse();
			n = this.all.last().insertSibling(nodes, 'after', true);
			nodes.reverse();
			a.push.apply(a, nodes);
		}
		this.updateIndexes(index);
	},
	// private
	onUpdate : function(ds, record, operation){
		//break to avoid infinite loop
		if (operation == 'update-data-view') {
			return;
		}
		var index = this.store.indexOf(record);
		var sel = this.isSelected(index);
		var original = this.all.elements[index];
		var node = this.bufferRender([record], index)[0];
		this.all.replaceElement(index, node, true);
		if(sel){
			this.selected.replaceElement(original, node);
			this.all.item(index).addClass(this.selectedClass);
		}
		this.updateIndexes(index, index);
		if (operation == 'commit') {
			//fire store update
			ds.fireEvent('update', ds, record, 'update-data-view', node);
		}
	},
	// private
	onRemove : function(ds, record, index){
		var node = Ext.get(this.getNode(index));
		this.deselect(index);
		this.all.removeElement(index, false);
		this.updateIndexes(index);
		node.switchOff({remove:true});
	},
	updateIndexes : function(startIndex, endIndex){
		var ns = this.all.elements;
		startIndex = startIndex || 0;
		endIndex = endIndex || ((endIndex === 0) ? 0 : (ns.length - 1));
		for(var i = startIndex; i <= endIndex; i++){
			ns[i].viewIndex = i;
		}
	}
});
if (Ext.isIE) {
	Ext.BoxComponent.override({
		setSize : function(w, h){
			if(typeof w == 'object'){
				h = w.height;
				w = w.width;
			}
			if(!this.boxReady){
				this.width = w;
				this.height = h;
				return this;
			}
			if(this.lastSize && this.lastSize.width == w && this.lastSize.height == h){
				return this;
			}
			this.lastSize = {width: w, height: h};
			var adj = this.adjustSize(w, h);
			var aw = adj.width, ah = adj.height;
			
			var rz = this.getResizeEl();
			if(!this.deferHeight && aw !== undefined && ah !== undefined){
				rz.setSize(aw, ah);
			}else if(!this.deferHeight && ah !== undefined){
				rz.setHeight(ah);
			}else if(aw !== undefined && !isNaN(aw)){
				rz.setWidth(aw);
			}
			if(aw !== undefined || ah !== undefined){
				this.onResize(aw, ah, w, h);
			}
			this.fireEvent('resize', this, aw, ah, w, h);
			
			return this;
		}
	});
}