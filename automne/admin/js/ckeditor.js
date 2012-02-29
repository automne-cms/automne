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
/*Ext.form.FCKeditor = function(config){
	this.config	 = config;
	var defaultEditorConfig = {
		BasePath :		Automne.context.path + '/automne/fckeditor/',
		Config : {
			BaseHref: 		window.location.href
		},
		ToolbarSet:		'Default'
	};
	//change the config with the correct dirs
	if (this.config.editor) {
		this.config.editor = Ext.applyIf(this.config.editor, defaultEditorConfig);
	} else {
		this.config.editor = defaultEditorConfig;
	}
	Ext.form.FCKeditor.superclass.constructor.call(this, config);
	this.MyisLoaded = false;
	this.MyValue	= '';
	this.fckInstance= undefined; // to avoid using FCKAPI, this is a reference to instance created on FCKeditor_OnComplete
};
 
Ext.extend(Ext.form.FCKeditor, Ext.form.TextArea,  {
	onRender : function(ct, position){
		if(!this.el){
			this.defaultAutoCreate = {
				tag: "textarea",
				style:"width:100px;height:60px;",
				autocomplete: "off"
			};
		}
		Ext.form.TextArea.superclass.onRender.call(this, ct, position);
		if(this.grow){
			this.textSizeEl = Ext.DomHelper.append(document.body, {
				tag: "pre", cls: "x-form-grow-sizer"
			});
			if(this.preventScrollbars){
				this.el.setStyle("overflow", "hidden");
			}
			this.el.setHeight(this.growMin);
		}
		//setTimeout("loadFCKeditor('"+this.id+"',"+ this.config.height +");",100);
		
		var load = new Ext.util.DelayedTask(this.load, this);
		load.delay(100);
	},
	setValue : function(value){
		this.MyValue = value;
		if (this.MyisLoaded){
			FCKeditorSetValue(this.id,value);
		} else {
			Ext.form.TextArea.superclass.setValue.call(this, value);
		}
	},
	getValue : function(){
		if (this.MyisLoaded){
			value = FCKeditorGetValue(this.id);
			Ext.form.TextArea.superclass.setValue.apply(this,[value]);
			return Ext.form.TextArea.superclass.getValue.apply(this);
		} else {
			return this.MyValue;
		}
	},
	getRawValue : function(){
		if (this.MyisLoaded){
			value=FCKeditorGetValue(this.id);
			Ext.form.TextArea.superclass.setRawValue.apply(this,[value]);
			return Ext.form.TextArea.superclass.getRawValue.apply(this);
		} else {
			return this.MyValue;
		}
	},
	load: function (){
		oFCKeditor						 = new FCKeditor(this.id);
		oFCKeditor.Height				 = this.config.height;
		Ext.apply(oFCKeditor,this.config.editor)
		oFCKeditor.ReplaceTextarea();
	}
});
Ext.reg('fckeditor', Ext.form.FCKeditor);
 
function FCKeditor_OnComplete(editorInstance){
	Ext.getCmp(editorInstance.Name).MyisLoaded  = true;
	Ext.getCmp(editorInstance.Name).fckInstance = editorInstance;
}
function FCKeditorSetValue(name,value){
	if (name != undefined){
		var extCmp = Ext.getCmp(name);
		if (extCmp != undefined) {
			extCmp.fckInstance.SetData(value);
		}
	}
}
function FCKeditorGetValue(name){
	if (name != undefined){
		var data = '';
		var extCmp = Ext.getCmp(name);
		if (extCmp != undefined) {
			data = extCmp.fckInstance.GetData();
		}
		return data;
	}
}*/