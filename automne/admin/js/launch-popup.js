/**
  * Automne Javascript file
  * This file is specificaly used to launch Automne Popup interface. 
  * It must be the last appended to main JS file
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
Ext.onReady(function() {
	if (window.opener) {
		//Get opener vars as reference
		Automne.locales = window.opener.Automne.locales;
		Automne.context = window.opener.Automne.context;
		Automne.tabPanels = window.opener.Automne.tabPanels;
		Automne.east = window.opener.Automne.east;
		Automne.scripts = window.opener.Automne.scripts;
		//set blank image path
		Ext.BLANK_IMAGE_URL = Automne.context.path +'/automne/admin/img/s.gif';
		// Header to pass in every Ajax request. Used to prevent CSRF attacks on action requests
		Ext.Ajax.defaultHeaders = {
		    'X-Powered-By': 'Automne',
			'X-Atm-Token':	Automne.context.token
		};
		//init Automne interface
		Automne.initPopup();
	} else {
		alert('Error : Automne main window has been closed...');
	}
});