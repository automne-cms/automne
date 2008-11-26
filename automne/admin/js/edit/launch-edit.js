var atmRowsDatas = {};
var atmBlocksDatas = {};
var atmCSDatas = {};

Ext.onReady(function(){
	//copy some parent vars
	if (parent) {
		pr = parent.pr;
		Automne.locales = parent.Automne.locales;
		Automne.message = parent.Automne.message;
		Ext.MessageBox = parent.Ext.MessageBox;
	}
	//set validator status
	Automne.content.isValidator = atmIsValidator;
	//set validator status
	Automne.content.isValidable = atmIsValidable;
	//set preview status
	Automne.content.hasPreview = atmHasPreview;
	//launch edition
	Automne.content.edit(atmCSDatas, atmRowsDatas, atmBlocksDatas);
});