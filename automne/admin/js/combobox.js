/**
  * Automne Javascript file
  *
  * Automne.ComboBox Extension Class for Ext.form.ComboBox
  * Provide an autocomplete combo box usable for all sort of searches
  * @class Automne.ComboBox
  * @extends Ext.form.ComboBox
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: combobox.js,v 1.4 2009/07/20 16:33:16 sebastien Exp $
  */
Automne.ComboBox = Ext.extend(Ext.form.ComboBox, {
	initComponent : function(){
		if (this.store && this.store.xtype && !(this.store instanceof Ext.Component)) {
			this.store = Ext.ComponentMgr.create(this.store, this.store.xtype);
		}
		//test store, if exists but is not a valid object, load Automne.JsonStore instead
		if (this.store && !this.store.isLoaded) {
			this.store = new Automne.JsonStore(this.store); 
		}
		Automne.ComboBox.superclass.initComponent.call(this);
	},
	/**
	 * Sets the specified value into the field.  If the value finds a match, the corresponding record text
	 * will be displayed in the field.  If the value does not match the data value of an existing item,
	 * and the valueNotFoundText config option is defined, it will be displayed as the default field text.
	 * Otherwise the field will be blank (although the value will still be set).
	 * @param {String} value The value to match
	 */
	setValue : function(v){
		var text = v;
		if (this.autoLoad !== false && v && this.mode == 'remote' && !this.store.isLoaded()) {
			this.lastQuery = '';
			this.store.load({
				scope: this,
				params: this.getParams(),
				callback: function(){
					this.setValue(v)
				}
			})
		}
		if(this.valueField){
			var r = this.findRecord(this.valueField, v);
			if(r){
				text = r.data[this.displayField];
			}else if(this.valueNotFoundText !== undefined){
				text = this.valueNotFoundText;
			}
		}
		this.lastSelectionText = text;
		if(this.hiddenField){
			this.hiddenField.value = v;
		}
		Ext.form.ComboBox.superclass.setValue.call(this, text);
		this.value = v;
	}
});

Ext.reg('atmCombo', Automne.ComboBox);