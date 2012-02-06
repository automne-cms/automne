/**
  * Automne Javascript file
  *
  * Automne.scripts
  * Provide scripts management methods
  * @class Automne.scripts
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
Automne.scripts = {
	maxScripts:		0,
	currentScripts:	0,
	scriptsUpdate: 	false,
	scriptsTip:		false,
	getScriptsDetails:false,
	getScriptsQueue:false,
	scriptsDetailText:'',
	scriptsQueueText:'',
	set: function(scriptsleft, options) {
		var as = Automne.scripts;
		as.currentScripts = parseInt(scriptsleft);
		if (as.scriptsUpdate && as.currentScripts == 0) {
			as.scriptsUpdate = scriptsUpdate = false;
		}
		//check for script update
		var scriptsUpdate = false;
		if ((as.scriptsUpdate == false || (options.params && options.params.refreshScripts == true)) && as.currentScripts > 0) {
			as.scriptsUpdate = scriptsUpdate = true;
		}
		//update sidepanel script bar
		if (as.currentScripts > as.maxScripts) {
			as.maxScripts = as.currentScripts;
		}
		if (as.currentScripts || as.scriptsUpdate || scriptsUpdate) {
			pr('Scripts left : '+as.currentScripts+', scriptsUpdate : '+as.scriptsUpdate+', update : '+scriptsUpdate);
		}
		var el = Ext.get('headPanelBar');
		if (el) {
			//request scripts count refresh
			if (scriptsUpdate || as.getScriptsDetails || as.getScriptsQueue) {
				setTimeout(function(){
					Automne.server.call('scripts.php', '', {
						refreshScripts: 	true, 
						nospinner: 			true,
						details:			as.getScriptsDetails,
						queue:				as.getScriptsQueue
					});
				}, 5000);
			}
			Automne.scripts.update();
		} else {
			as.scriptsUpdate = false;
		}
	},
	update: function() {
		var as = Automne.scripts;
		var el = Ext.get('headPanelBar');
		var toptext = as.currentScripts ? String.format(Automne.locales.nScripts, as.currentScripts) : Automne.locales.noScript;
		if (el) {
			var size = (as.currentScripts != 0 && as.maxScripts != 0) ? parseInt((as.currentScripts * 247) / as.maxScripts) : 0;
			size += 30; //for padding
			el.setWidth(size, true);
			if (Ext.get('headPanelBarInfos')) {
				if (as.scriptsTip) as.scriptsTip.destroy();
				as.scriptsTip = new Ext.ToolTip({
					target: 		Ext.get('headPanelBarInfos'),
					html: 			toptext
				});
			}
		}
		if (Ext.getCmp('scriptsProgressBar')) {
			var progressScripts = Ext.getCmp('scriptsProgressBar');
			if (progressScripts.el.dom && progressScripts.el.dom.firstChild) {
				v = as.currentScripts / as.maxScripts;
				if (!isNaN(v) && v != 0) {
					progressScripts.updateProgress((as.currentScripts / as.maxScripts), toptext, true );
				} else {
					progressScripts.updateProgress(0, toptext, true );
				}
			}
		}
	}
};