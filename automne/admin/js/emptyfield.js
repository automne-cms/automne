/**
  * Automne Javascript file
  *
  * Automne.EmptyField Extension Class for Ext.form.Field
  * Provide an empty form field which can be used to display text
  * @class Automne.EmptyField
  * @extends Ext.form.Field
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: emptyfield.js,v 1.1 2009/03/02 11:26:53 sebastien Exp $
  */
Automne.EmptyField = Ext.extend(Ext.form.Field,  {
    /**
     * @cfg {Boolean} enableKeyEvents True to enable the proxying of key events for the HTML input field (defaults to false)
     */
	fieldClass:'x-form-emptyfield',
	
    initComponent : function(){
        Ext.form.TextField.superclass.initComponent.call(this);
    },

    // private
    initEvents : function(){
        Ext.form.TextField.superclass.initEvents.call(this);
    },
	// private
    initValue : function(){
        this.setValue(this.value);
    },
	/**
     * Sets the underlying DOM field's value directly, bypassing validation.  To set the value with validation see {@link #setValue}.
     * @param {Mixed} value The value to set
     * @return {Mixed} value The field value that is set
     */
    setRawValue : function(v){
        this.setValue(v);
		return v;
    },

    /**
     * Sets a data value into the field and validates it.  To set the value directly without validation see {@link #setRawValue}.
     * @param {Mixed} value The value to set
     */
    setValue : function(v){
        this.value = v;
        if(this.rendered){
            this.el.update(v);
        }
    },
    processValue : function(value){
        return value;
    },
    /**
     * Resets the current field value to the originally-loaded value and clears any validation messages.
     * Also adds emptyText and emptyClass if the original value was blank.
     */
    reset : function(){
        Ext.form.TextField.superclass.reset.call(this);
    },
    
    
    /**
     * Validates a value according to the field's validation rules and marks the field as invalid
     * if the validation fails
     * @param {Mixed} value The value to validate
     * @return {Boolean} True if the value is valid, else false
     */
    validateValue : function(value){
        return true;
    },
	
	// private
    onRender : function(ct, position){
        Ext.form.Field.superclass.onRender.call(this, ct, position);
        if(!this.el){
            var cfg = this.getAutoCreate();
            cfg.tag = 'div';
			delete cfg.size;
			delete cfg.type;
			this.el = ct.createChild(cfg, position);
        }
        this.el.addClass([this.fieldClass, this.cls]);
    }
});
Ext.reg('atmEmptyfield', Automne.EmptyField);