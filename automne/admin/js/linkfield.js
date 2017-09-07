/**
  * Automne Javascript file
  *
  * Automne.LinkField Extension Class for Ext.form.Field
  * Provide a form field using specific Automne links format
  * This field should replace Automne.linkField (xtype : linkfield) as soon as possible.
  * @class Automne.LinkField
  * @extends Ext.form.Field
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: linkfield.js,v 1.3 2009/06/05 15:01:06 sebastien Exp $
  */
Automne.LinkField = Ext.extend(Ext.form.Field,  {
	separator:'|',
	disabled:false,
	initComponent : function(){
		Automne.LinkField.superclass.initComponent.call(this);
		//default link field config
		this.linkConfig = Ext.applyIf(this.linkConfig, {
			label:		true,				// Link has label ?
			internal:	true,				// Link can target an Automne page ?
			external:	true,				// Link can target an external resource ?
			file:		true,				// Link can target a file ?
			destination:true,				// Can select a destination for the link ?
			admin:		true,				// Use admin JS and classes instead of direct actions (default = true)
			currentPage:1					// Current page to open tree panel (default : CMS_tree::getRoot())
		});
	},
	// private
	onRender : function(ct, position){
		var fieldItems = [];
		this.types = [];
		var al = Automne.locales;
		//Label
		if (this.linkConfig.label) {
			fieldItems[fieldItems.length] = {
				fieldLabel:		al.title,
				name:			'label',
				value:			'',
				allowBlank:		true
			}
		}
		this.types[this.types.length] = ['0', al.none];
		//Internal
		if (this.linkConfig.internal) {
			this.types[this.types.length] = ['1', al.internalLink];
		}
		//External
		if (this.linkConfig.external) {
			this.types[this.types.length] = ['2', al.externalLink];
		}
		//File
		if (this.linkConfig.file) {
			this.types[this.types.length] = ['3', al.fileLink];
		}
		//Select Type
		if (this.types.length > 1) {
			fieldItems[fieldItems.length] = {
				disabled:		this.disabled,
				fieldLabel:		al.type,
				xtype:			'combo',
				store:			new Ext.data.SimpleStore({
					fields: 		['id', 'type'],
					data : 			this.types
				}),
				name:			'typecombo',
				displayField:	'type',
				mode:			'local',
				triggerAction:	'all',
				editable:		false,
				forceSelection:	true,
				valueField:		'id',
				value:			'0',
				listeners:{
					'select':		this.showField,
					scope:			this
				}
			}
		}
		fieldItems[fieldItems.length] = {
			disabled:		this.disabled,
			xtype:			'atmPageField',
			fieldLabel:		al.page,
			name:			'pagelink',
			value:			'',
			allowBlank:		true,
			itemCls:		(this.types.length > 1) ? 'x-hide-display' : ''
		}
		fieldItems[fieldItems.length] = {
			disabled:		this.disabled,
			fieldLabel:		'<span class="atm-help" ext:qtip="'+ al.externalLinkHelp +'">'+ al.url +'</span>',
			name:			'urllink',
			value:			'',
			allowBlank:		true,
			itemCls:		(this.types.length > 1) ? 'x-hide-display' : ''
		}
		fieldItems[fieldItems.length] = {
			disabled:		this.disabled,
			xtype:			'atmFileUploadField',
			fieldLabel:		al.file,
			uploadCfg:		this.uploadCfg,
			fileinfos:		this.fileinfos,
			name:			'filelink',
			value:			'',
			allowBlank:		true,
			itemCls:		(this.types.length > 1) ? 'x-hide-display' : '',
			listeners:{
				'render':		this.showField,
				scope:			this
			}
		}
		if (this.linkConfig.destination) {
			fieldItems[fieldItems.length] = {
				disabled:		this.disabled,
				fieldLabel:		al.destination,
				xtype:			'combo',
				store:			new Ext.data.SimpleStore({
					fields:			['id', 'type'],
					data :			[['_top', al.currentWindow],['_blank', al.newWindow],['popup', al.popupWindow]]
				}),
				name:			'targetcombo',
				displayField:	'type',
				mode:			'local',
				triggerAction:	'all',
				editable:		false,
				forceSelection:	true,
				valueField:		'id',
				value:			'_top',
				listeners:{
					'select':		this.showPopup,
					scope:			this
				}
			}
			fieldItems[fieldItems.length] = {
				layout:			'column',
				xtype:			'panel',
				name:			'popupsize',
				border:			false,
				cls:			'x-hide-display',
				items:[{
					columnWidth:	.5,
					layout: 		'form',
					border:			false,
					labelWidth:		70,
					items: [{
						disabled:		this.disabled,
						fieldLabel:		al.width,
						xtype:			'numberfield',
						allowDecimals : false,
						allowNegative : false,
						minValue : 		1,
						name:			'popupwidth',
						anchor:			'98%',
						allowBlank:		true
					}]
				},{
					columnWidth:	.5,
					layout: 		'form',
					border:			false,
					labelWidth:		70,
					items: [{
						disabled:		this.disabled,
						fieldLabel:		al.height,
						xtype:			'numberfield',
						allowDecimals : false,
						allowNegative : false,
						minValue : 		1,
						name:			'popupheight',
						anchor:			'100%',
						allowBlank:		true,
						listeners:{
							'render':		this.showPopup,
							scope:			this
						}
					}]
				}]
			}
		}
		
		this.form = new Ext.Panel({
			layout: 		'form',
			bodyStyle: 		'padding:5px',
			border:			false,
			autoWidth:		true,
			autoHeight:		true,
			labelAlign:		'right',
			renderTo:		ct,
			labelWidth:		70,
			cls:			'atm-link-field',
			defaults: {
				xtype:			'textfield',
				anchor:			'97%',
				allowBlank:		false,
				hideMode:		'offsets'
			},
			listeners:{
				'render':function(form){
					//set fields items
					form.items.each(function(item){
						switch(item.name) {
							case 'label':
								this.labelfield = item;
							break;
							case 'typecombo':
								this.typecombo = item;
							break;
							case 'targetcombo':
								this.targetcombo = item;
							break;
							case 'pagelink':
								this.internal = item;
							break;
							case 'urllink':
								this.external = item;
							break;
							case 'filelink':
								this.file = item;
							break;
							case 'popupsize':
								this.popupsize = item;
								var popups = item.findByType('numberfield');
								this.popupwidth = popups[0];
								this.popupheight = popups[1];
							break;
						}
					}, this);
				},
				scope:this
			},
			items:fieldItems
		});
		
		if(!this.el){
			var cfg = this.getAutoCreate();
			if(!cfg.name){
				cfg.name = this.name || this.id;
			}
			cfg.type = 'hidden';
			this.el = ct.createChild(cfg, position);
		}
		var type = this.el.dom.type;
		if(type){
			this.el.addClass('x-form-'+type);
		}
	},
	setValue : function(v) {
		Automne.LinkField.superclass.setValue.call(this, v);
		var values = v ? v.split(this.separator) : [];
		if (this.typecombo && values[0] && values[0] != '0') {
			this.typecombo.setValue(values[0]);
		}
		if (this.labelfield) {
			this.labelfield.setValue(values[7]);
		}
		this.internal.setValue(values[1]);
		this.external.setValue(values[2]);
		this.file.setValue(values[3]);
		if (this.targetcombo) {
			var popupsizes = values[6] ? values[6].split(',') : [];
			if (parseInt(popupsizes[0]) > 0 || parseInt(popupsizes[1]) > 0) {
				this.popupwidth.setValue(popupsizes[0]);
				this.popupheight.setValue(popupsizes[1]);
				this.targetcombo.setValue('popup');
			} else if(values[4]) {
				this.targetcombo.setValue(values[4]);
			}
		}
		this.showField();
		this.showPopup();
	},
	getValue : function() {
		var value = '';
		if (this.typecombo) {
			value += this.typecombo.getValue();
		} else {
			value += this.types[0][0];
		}
		value += this.separator;
		value += this.internal.getValue();
		value += this.separator;
		value += this.external.getValue();
		value += this.separator;
		value += this.file.getValue();
		value += this.separator;
		if (this.targetcombo) {
			value += (this.targetcombo.getValue() != 'popup') ? this.targetcombo.getValue() : '_top';
			value += this.separator;
			//nothing for attributes here
			value += this.separator;
			value += this.popupwidth.getValue()+','+this.popupheight.getValue();
		} else {
			value += '_top'+this.separator+this.separator;
		}
		value += this.separator;
		value += (this.labelfield) ? this.labelfield.getValue() : '';
		this.el.dom.value = value;
		return Automne.LinkField.superclass.getValue.call(this);
	},
	getRawValue : function() {
		return this.getValue();
	},
	showField: function() {
		if (!this.typecombo) {
			return;
		}
		try {
			this.internal.container.parent().addClass('x-hide-display');
			this.external.container.parent().addClass('x-hide-display');
			this.file.container.parent().addClass('x-hide-display');
			switch(this.typecombo.value) {
				case '1':
					this.internal.container.parent().removeClass('x-hide-display');
					this.internal.syncSize();
				break;
				case '2':
					this.external.container.parent().removeClass('x-hide-display');
				break;
				case '3':
					this.file.container.parent().removeClass('x-hide-display');
					this.file.syncSize();
				break;
			}
		}catch(e){
			pr(e, 'error');
		}
	},
	showPopup: function() {
		if (!this.targetcombo) {
			return;
		}
		if (this.targetcombo.value == 'popup') {
			this.popupsize.el.removeClass('x-hide-display');
			this.popupsize.syncSize();
		} else {
			this.popupsize.el.addClass('x-hide-display');
		}
	},
	onResize : function(w, h){
		Automne.LinkField.superclass.onResize.call(this, w, h);
		this.form.setWidth(w);
	}
});
Ext.reg('atmLinkField', Automne.LinkField);