/**
  * Automne.FormPanel Extension Class for Ext.FormPanel
  * Use an Automne.BasicForm instead of Ext.form.BasicForm to handle Automne return format
  * @class Automne.FormPanel
  * @extends Ext.FormPanel
  */
Automne.FormPanel = Ext.extend(Ext.FormPanel, {
	// private
    createForm: function(){
        delete this.initialConfig.listeners;
        return new Automne.BasicForm(null, this.initialConfig);
    }
});
Ext.reg('atmForm', Automne.FormPanel);
/**
  * Automne.BasicForm Extension Class for Ext.form.BasicForm
  * Handle Automne return format
  * @class Automne.BasicForm
  * @extends Ext.form.BasicForm
  */
Automne.BasicForm = Ext.extend(Ext.form.BasicForm, {
	errorReader:		new Automne.JsonReader({}, new Ext.data.Record.create([
	   {name: 'success'},
	   {name: 'errors'}
	]))
});