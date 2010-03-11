/**
  * Automne Javascript file
  *
  * Ext.form.FCKeditor Extension Class for Ext.form.TextArea
  * Provide FCKeditor support as form field
  * @class Ext.form.FCKeditor
  * @extends Ext.form.TextArea
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author Users of ExtJS on ExtJS forum (see http://extjs.com/forum/showthread.php?t=17423)
  * $Id: fckeditor.js,v 1.1 2009/06/05 15:01:06 sebastien Exp $
  */
Ext.form.FCKeditor = function(config){
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
}