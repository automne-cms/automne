Automne.PageField = Ext.extend(Ext.form.NumberField,  {
	allowDecimals : false,
	allowNegative : false,
	minValue : 1,
	buttonOffset: 3,
	root:1,
	initComponent : function(){
		Automne.PageField.superclass.initComponent.call(this);
	},
	// private
	onRender : function(ct, position){
		Automne.FileUploadField.superclass.onRender.call(this, ct, position);
		
		this.wrap = this.el.wrap({cls:'x-form-field-wrap x-form-file-wrap'});
		this.el.addClass('x-form-page-text');
		this.wrap.setHeight(22);
		//browse button
		var btnCfg = Ext.applyIf(this.buttonCfg || {}, {
			text: 			Automne.locales.select,
			iconCls:		'atm-pic-tree'
		});
		this.button = new Ext.Button(Ext.apply(btnCfg, {
			renderTo: 		this.wrap,
			cls: 			'x-form-file-btn' + (btnCfg.iconCls ? ' x-btn-text-icon' : '')
		}));
		this.button.on('click', this.selectPages, this);
	},
	// private
	onResize : function(w, h){
		Automne.PageField.superclass.onResize.call(this, w, h);
		this.wrap.setWidth(w);
		var w = w - this.button.getEl().getWidth() - this.buttonOffset;
		this.wrap.setHeight(22);
		this.el.setWidth(w);
	},
	selectPages: function() {
		var onclick = 'var el = Ext.get(\''+this.el.id+'\');'+
			'el.dom.value=\'%s\';'+
			'el.highlight("C3CD31", {duration: 2 });'+
			'Ext.getCmp(\''+this.id+'\').validate();'+
			'Ext.getCmp(\'pagesTree\').close();';
		var win = new Automne.Window({
			id:				'pagesTree',
			currentPage:	this.getValue() || this.root,
			autoLoad:		{
				url:		'tree.php',
				params:		{
					winId:			'pagesTree',
					heading:		'Sélectionner la page de destination dans l\'arborescence',
					onClick:		onclick,
					currentPage:	this.getValue() || this.root
				},
				nocache:	true,
				scope:		this
			}
		});
		//display window
		win.show(this.el.id);
	}
});
Ext.reg('atmPageField', Automne.PageField);