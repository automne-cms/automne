/**
  * Automne Javascript file
  *
  * Ext.ux.form.CKEditor Extension Class for Ext.form.TextArea
  * Provide CKeditor support as form field
  * @class Ext.ux.form.CKEditor
  * @extends Ext.form.TextArea
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author Users of ExtJS on ExtJS forum (see http://www.sencha.com/forum/showthread.php?79031-CKEditor-Extension)
  */
Ext.namespace("Ext.ux.form");

Ext.ux.form.CKEditor = function(config){
	this.config = config;
	this.config.CKConfig = Ext.apply({}, this.config.editor);
	//load custom config
	if (this.config.editor.atmToolbar) {
		this.config.CKConfig.customConfig = Automne.context.path +'/automne/ckeditor/config.php?toolbar=' + this.config.editor.atmToolbar;
	} else {
		this.config.CKConfig.customConfig = Automne.context.path +'/automne/ckeditor/config.php?toolbar=Default';
	}
	Ext.ux.form.CKEditor.superclass.constructor.call(this, this.config);
};

Ext.extend(Ext.ux.form.CKEditor, Ext.form.TextArea,  {
    onRender : function(ct, position){
        if(!this.el){
            this.defaultAutoCreate = {
                tag: "textarea",
                autocomplete: "off"
            };
        }
        Ext.form.TextArea.superclass.onRender.call(this, ct, position);
        CKEDITOR.replace(this.id, this.config.CKConfig);
    },
    
    setValue : function(value){
        Ext.form.TextArea.superclass.setValue.call(this,[value]);
        var ck = CKEDITOR.instances[this.id];
        if (ck){
            ck.setData( value );
        }
    },

    getValue : function(){
        var ck = CKEDITOR.instances[this.id];
        if (ck){
            ck.updateElement();
        }
        return Ext.form.TextArea.superclass.getValue.call(this); 
    },

    isDirty: function () {
        if (this.disabled || !this.rendered) {
	    return false;
        }
        return String(this.getValue()) !== String(this.originalValue);
    },

    getRawValue : function(){
        var ck = CKEDITOR.instances[this.id];
        if (ck){
            ck.updateElement();
        }
        return Ext.form.TextArea.superclass.getRawValue.call(this);
    },

    destroyInstance: function(){
        var ck = CKEDITOR.instances[this.id];
        if (ck){
            delete ck;
        }
    }  
});

Ext.reg('ckeditor', Ext.ux.form.CKEditor);
Ext.reg('fckeditor', Ext.ux.form.CKEditor); //for compatibility
