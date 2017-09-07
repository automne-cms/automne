/**
  * Automne Javascript file
  *
  * Automne.JsonReader Extension Class for Ext.data.JsonReader
  * Manager for json update through ajax request. Allow fine error management
  * @class Automne.JsonReader
  * @extends Ext.data.JsonReader
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: json.js,v 1.3 2009/06/05 15:01:06 sebastien Exp $
  */
Automne.JsonReader = Ext.extend(Ext.data.JsonReader, {
	read : function(response){
		//eval response for errors management
		var json = Automne.server.evalResponse(response, {scope:this});
		return this.readRecords(json);
	},
	readRecords : function(o){
		//call parent method to process json datas
		var records = Automne.JsonReader.superclass.readRecords.call(this, o);
		//replace success value by success return if any
		if (o.success && records.success) {
			records.success = o.success;
		}
		return records;
	}
});
/**
  * Automne.JsonStore Extension Class for Ext.data.Store
  * Manager for json data store through ajax request. Allow fine error management
  * @class Automne.JsonStore
  * @extends Ext.data.Store
  */
Automne.JsonStore = function(config){
	/*Automne.JsonStore.superclass.constructor.call(this, Ext.apply(c, {
		proxy: !c.data ? new Ext.data.HttpProxy({url: c.url}) : undefined,
		reader: new Automne.JsonReader(c, c.fields)
	}));*/
	
	Automne.JsonStore.superclass.constructor.call(this, Ext.apply(config, {
		reader: new Automne.JsonReader(config)
	}));
};
Ext.extend(Automne.JsonStore, Ext.data.Store, {
	loadRecords : function(o, options, success){
		if (o && o.records) {
			for(var i = 0, len = o.records.length; i < len; i++){
				o.records[i].data = this.prepareData(o.records[i].data);
			}
		}
		Automne.JsonStore.superclass.loadRecords.call(this, o, options, success);
	},
	/**
	 * Function that can be overridden to provide custom formatting for the data that is sent to the template for each node.
	 * @param {Array/Object} data The raw data (array of colData for a data model bound view or
	 * a JSON object for an Updater bound view).
	 */
	prepareData : function(data){
		return data;
	}
});
Ext.reg('atmJsonstore', Automne.JsonStore);