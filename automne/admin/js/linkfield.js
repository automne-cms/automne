/**
 * @class Automne.linkField
 * @extends Ext.form.Field
 * Automne Links field.
 * @constructor
 * Creates a new linkField
 * @param {Object} config Configuration options
 */
Automne.linkField = Ext.extend(Ext.form.Field,  {
    linkConfig:				false,
	/**
	 * @cfg {String/Object} autoCreate A DomHelper element spec, or true for a default element spec (defaults to
	 * {tag: "input", type: "checkbox", autocomplete: "off"})
	 */
	defaultAutoCreate: {tag: "div", autocomplete: "off", 'class':'x-html-editor-wrap'},
	separator: '|',
	//constructor
	constructor: function(config) { 
		//preprocessing
		this.linkConfig = config.linkConfig;
		//call constructor
		Automne.linkField.superclass.constructor.call(this, config); 
	},
	// private
    onRender : function(ct, position){
        Automne.linkField.superclass.onRender.call(this, ct, position);
        //get field from server
		var config = this.linkConfig;
		config.value = this.value;
		config.ct = ct;
		config.position = position;
		config.action = 'getform';
		Automne.server.call('linkfield.php', function(response, options) {
		if (response.responseXML && response.responseXML.getElementsByTagName('content').length) {
				//append element content
				Ext.DomHelper.append( this.el, response.responseXML.getElementsByTagName('content').item(0).firstChild.nodeValue);
			}
		}, config, this);
    },
	getValue: function () {
		//{{lynkType}}|{{internalLink}}|{{externalLink}}|{{fileLink}}|{{attributes}}|{{pop-width}},{{pop-height}}|
		var lynkType = '' , internalLink = '' , externalLink = '' , fileLink = '' , attributes = '_top' , popwidth = '' , popheight = '' ;
		this.el.select('input').each(function(el) {
			if (el.dom.id.indexOf('type') !== -1 && el.dom.checked) {
				lynkType = el.dom.value;
			} else if (el.dom.id.indexOf('internal') !== -1) {
				internalLink = el.dom.value;
			} else if (el.dom.id.indexOf('external') !== -1) {
				externalLink = el.dom.value;
			}
		});
		if (lynkType != 0) {
			this.value = lynkType + this.separator + internalLink + this.separator + externalLink + this.separator + fileLink + this.separator + attributes + this.separator + popwidth + this.separator + popheight + this.separator;
		} else {
			this.value = '';
		}
		return this.value;
	},
	isValid: function() {
		var valid = false
		this.el.select('input').each(function(el) {
			if (el.dom.id.indexOf('type') !== -1 && el.dom.checked) {
				valid = true;
			}
		});
		return valid;
	},
	getComputedValue: function(el) {
		//get field from server
		var config = this.linkConfig;
		config.action = 'getdisplay';
		config.el = el;
		config.value = this.getValue();
		Automne.server.call('linkfield.php', function(response, options) {
			if (response.responseXML && response.responseXML.getElementsByTagName('content').length) {
				options.params.el.update(response.responseXML.getElementsByTagName('content').item(0).firstChild.nodeValue);
				options.params.el.createChild({tag:'input', type:'hidden', value:options.params.value});
			}
		}, config, this);
	}
});
Ext.reg('linkfield', Automne.linkField);