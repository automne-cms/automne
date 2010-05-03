/**
  * Automne Javascript file
  *
  * Automne.FormPanel Extension Class for Ext.FormPanel
  * Use an Automne.BasicForm instead of Ext.form.BasicForm to handle Automne return format
  * @class Automne.FormPanel
  * @extends Ext.FormPanel
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: form.js,v 1.3 2009/06/05 15:01:06 sebastien Exp $
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
	   {name: 'infos'}
	]))
});