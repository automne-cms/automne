/**
  * Automne.Editor Extension Class for Ext.Editor
  * Provide an inline editor to update any object field
  * @class Automne.Editor
  * @extends Ext.Editor
  */
Automne.Editor = Ext.extend(Ext.Editor, { 
	hideEl:				true,
	completeOnEnter:	true,
	cancelOnEsc:		true,
	updateEl:			true,
	ignoreNoChange:		true,
	boundEl:			false,
	updateConfig:		false,
	fieldName:			false,
	value:				'',
	height:				'',
	width:				'',
	allowBlur:			false,
	renderer:			false,
	updater:			false,
	alignment:			'l-l?',
	alignmentOfset:		[5,0],
	autosize:			true,
	//constructor
	constructor: function(el, config) { 
		// preprocessing
		this.boundEl = el;
		//create field from atm:config attribute if exists or create blank generic field instead
		if(el.getAttributeNS('atm', 'config')) {
			var editorConfig = Ext.StoreMgr.get(el.getAttributeNS('atm', 'config'));
			this.updateConfig = editorConfig.updateConfig || false;
			
			this.height = (editorConfig.height) ? editorConfig.height : this.height;
			this.width = (editorConfig.width) ? editorConfig.width : this.width;
			this.autosize = (editorConfig.autosize) ? editorConfig.autosize : this.autosize;
			this.allowBlur = (editorConfig.allowBlur) ? editorConfig.allowBlur : false;
			this.renderer = (editorConfig.renderer) ? editorConfig.renderer : false;
			this.updater = (editorConfig.updater) ? editorConfig.updater : false;
			//get initial field value if any
			if (editorConfig.value !== undefined) {
				//store initial value in a hidden input if no value previously found for field
				var e = this.boundEl.select('input[type=hidden]:last');
				if (!e.getCount()) {
					this.value = editorConfig.value;
					this.boundEl.createChild({tag:'input', type:'hidden', value:this.value});
				}
			}
			var field = Ext.ComponentMgr.create(editorConfig, editorConfig.xtype);
		} else {
			var field = Ext.form.Field();
		}
		//get field name updated from atm:field attribute if exists
		if(el.getAttributeNS('atm', 'field')) {
			this.fieldName = el.getAttributeNS('atm', 'field');
		}
		//call constructor
		Automne.Editor.superclass.constructor.call(this, field, config); 
	},
	/**
	 * Starts the editing process and shows the editor.
	 * @param {Mixed} el The element to edit
	 * @param {String} value (optional) A value to initialize the editor with. If a value is not provided, it defaults
	  * to the innerHTML of el.
	 */
	startEdit : function(el, startValue){
		el = el || this.boundEl;
		if(this.editing){
			this.completeEdit();
		}
		this.boundEl = Ext.get(el);
		
		var e = el.select('input[type=hidden]:last');
		var v = (e.getCount()) ? e.first().dom.value : el.dom.innerHTML;
		
		this.startValue = (startValue) ? startValue : v;
		//html decode value
		v = Ext.util.Format.htmlDecode(v);
		try{
			this.field.setValue(v);
		} catch(e){}
		//render field
		this.render(this.parentEl || document.body);
		//put zindex to the right number
		var active_win = Ext.WindowMgr.getActive();
		if (active_win) this.getEl().setStyle('z-index', active_win.lastZIndex + 2);
		if(this.fireEvent("beforestartedit", this, el, v) === false){
			return;
		}
		//autosize
		if (this.autosize === true) {
			this.setSize(el.getSize(true));
		} else if (this.autosize === 'width') {
			this.setSize(el.getSize(true).width, '');
		} else if (this.autosize === 'height') {
			this.setSize('', el.getSize(true).height);
		}
		//if no height specified, autosize editor in boudEl, else, use specified height
		if (!this.height && !this.width) {
			//this.doAutoSize();
		} else {
			var size = {
				width:		(this.width) ? this.width : el.getSize(true).width,
				height:		(this.height) ? this.height : el.getSize(true).height
			};
			var boudElSize = {
				width:		(this.width && (this.width + 20) > el.getSize().width) ? this.width + 20 : el.getSize().width,
				height:		(this.height && (this.height + 20) > el.getSize().height) ? this.height + 20 : el.getSize().height
			};
			this.setSize(size);
			el.setSize(boudElSize);
		}
		this.el.alignTo(el, this.alignment, this.alignmentOfset);
		this.editing = true;
		if (this.allowBlur === true) {
			//append validation button
			var validation = this.el.createChild({tag:'div', cls:'atm-validate-field'});
			validation.on('click', this.completeEdit, this);
		}
		this.show();
	},
	/**
	 * Ends the editing process, persists the changed value to the underlying field, and hides the editor.
	 * @param {Boolean} remainVisible Override the default behavior and keep the editor visible after edit (defaults to false)
	 */
	completeEdit : function(remainVisible){
		if(!this.editing){
			return;
		}
		//get field value from renderer if any or from field directly
		var displayValue = (this.renderer) ? this.renderer.call(this, this.field, this.boundEl) : Ext.util.Format.htmlEncode(this.getValue());
		
		//get value to update from updater if exists of from field directly
		var updateValue = (this.updater) ? this.updater.call(this, this.field) : Ext.util.Format.htmlEncode(this.getValue());
		
		if(this.revertInvalid !== false && !this.field.isValid()){
			displayValue = this.startValue;
			this.cancelEdit(true);
		}
		if(String(updateValue) === String(this.startValue) && this.ignoreNoChange){
			this.editing = false;
			this.hide();
			return;
		}
		//set bound value
		if(this.fireEvent("beforecomplete", this, updateValue, this.startValue) !== false){
			this.editing = false;
			if(this.updateEl && this.boundEl){
				this.boundEl.update(displayValue);
			}
			if(remainVisible !== true){
				this.hide();
			}
		}
		this.fireEvent("complete", this, updateValue, this.startValue);
		//send update request to server
		if (this.updateConfig) {
			//append fieldname if any
			if (this.fieldName) {
				this.updateConfig.params.action = 'update';
				this.updateConfig.params.field = this.fieldName;
			}
			this.updateConfig.params.value = updateValue;
			this.updateConfig.el = this.boundEl;
			this.updateConfig.el.startValue = this.startValue;
			this.updateConfig.fcnCallback = function(response, options) {
				//no error : send message (if any)
				if ((!response.responseXML.getElementsByTagName('error').length || response.responseXML.getElementsByTagName('error').item(0).firstChild.nodeValue == 0) 
					&& response.responseXML.getElementsByTagName('message').length) {
					/*
					var win = Ext.WindowMgr.getActive();
					var el = (win) ? win.getEl() : null;
					Automne.message.show('',response.responseXML.getElementsByTagName('message').item(0).firstChild.nodeValue, el || document);*/
				}
				//error : display alert
				else if (response.responseXML.getElementsByTagName('error').length
					&& response.responseXML.getElementsByTagName('error').item(0).firstChild.nodeValue != 0
					&& response.responseXML.getElementsByTagName('message').length) { 
					
					Automne.message.popup({
						msg: 				response.responseXML.getElementsByTagName('message').item(0).firstChild.nodeValue,
						buttons: 			Ext.MessageBox.OKCANCEL,
						animEl: 			options.el,
						closable: 			false,
						icon: 				Ext.MessageBox.ERROR,
						scope: 				options.el,
						fn: 				function (button) {
							if (button == 'ok') {
								Automne.utils.editor(this, this.startValue);
							} else {
								this.update(this.startValue).highlight('FF0000', {duration: 2});
							}
						}
					});
				}
			};
			//send server call
			Automne.server.call(this.updateConfig);
		}
	},
	/**
     * Cancels the editing process and hides the editor without persisting any changes.  The field value will be
     * reverted to the original starting value.
     * @param {Boolean} remainVisible Override the default behavior and keep the editor visible after
     * cancel (defaults to false)
     */
    cancelEdit : function(remainVisible){
		if(this.editing){
			this.setValue(this.startValue);
			this.editing = false;
			if(remainVisible !== true){
				this.hide();
			}
		}
	}
});