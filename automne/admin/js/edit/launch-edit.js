/**
  * Automne Javascript file
  * This file is specificaly used to launch Automne edition interface. 
  * It must be the last appended to edit JS file
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: launch-edit.js,v 1.3 2009/04/02 13:55:53 sebastien Exp $
  */
var atmRowsDatas = {};
var atmBlocksDatas = {};
var atmCSDatas = {};
var atmContent;

Ext.onReady(function(){
	//init edition with editId from parent
	atmContent = new Automne.content(Ext.urlDecode(window.location.search).editId);
	//launch edition
	atmContent.edit(atmCSDatas, atmRowsDatas, atmBlocksDatas);
});