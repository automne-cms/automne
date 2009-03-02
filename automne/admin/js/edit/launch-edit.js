/**
  * Automne Javascript file
  * This file is specificaly used to launch Automne edition interface. 
  * It must be the last appended to edit JS file
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: launch-edit.js,v 1.2 2009/03/02 11:27:02 sebastien Exp $
  */
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