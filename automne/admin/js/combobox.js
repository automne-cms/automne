/**
  * Automne.ComboBox Extension Class for Ext.form.ComboBox
  * Provide an autocomplete combo box usable for all sort of searches
  * @class Automne.ComboBox
  * @extends Ext.form.ComboBox
  */
Automne.ComboBox = Ext.extend(Ext.form.ComboBox, {
	/**
     * Sets the specified value into the field.  If the value finds a match, the corresponding record text
     * will be displayed in the field.  If the value does not match the data value of an existing item,
     * and the valueNotFoundText config option is defined, it will be displayed as the default field text.
     * Otherwise the field will be blank (although the value will still be set).
     * @param {String} value The value to match
     */
    setValue : function(v){
        var text = v;
        if (v && this.mode == 'remote' && !this.store.isLoaded()) {
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