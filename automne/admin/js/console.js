/**
  * Automne Javascript file
  *
  * Automne.console
  * Provide console and debug methods
  * @class Automne.console
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: console.js,v 1.2 2009/06/25 13:57:23 sebastien Exp $
  */
Automne.console = {
	window:false,
	//send error to user according to current system debug level
	throwErrors: function (errors) {
		errors = eval(errors);
		for(var i = 0; i < errors.length; i++) {
			//if (typeof console != 'undefined' && console.error) console.error(Automne.context.systemLabel +' '+ Automne.context.applicationVersion +' : '+ errors[i].error);
			pr(Automne.context.systemLabel +' '+ Automne.context.applicationVersion +' : '+ errors[i].error, 'error', errors[i].backtrace);
		}
	},
	//send rawdatas to user according to current system debug level
	throwRawDatas: function (rawdatas) {
		rawdatas = eval(rawdatas);
		for(var i = 0; i < rawdatas.length; i++) {
			pr(rawdatas[i], 'debug');
		}
	},
	pr:	function (data, type, backtrace) {
		if (Automne && Automne.context && Automne.context.debug & 1) {
			//uncomment this line to view function caller
			//data += ' '+pr.caller.toString();
			var type = type || 'log'; //use 'dir' for exploring variable in IE
			//use firebug if available
			if (typeof window.console != 'undefined' && window.console.info) {
				switch (type) {
					case 'error': //errors
						window.console.error(data);
					break;
					case 'warning': //?? not used for now
						window.console.warn(data);
					break;
					case 'debug': //php pr output
						window.console.warn(data);
					break;
					case 'log': //default
					default:
						window.console.info(data);
					break;
				}
			} else 
			//use firebuglite if available
			if (typeof window.console != 'undefined' && eval('window.console.'+type)) {
				//window.console.log(data);
				eval('window.console.'+ type +'(data);')
			}
			//show with blackbird
			if (Automne.context.debug & 8) {
				try {
					if(!window.blackbird.isVisible()) {
						window.blackbird.show();
					}
				} catch(e){}
			}
			//Use prettyPrint to dump objects vars
			if (data && (typeof data != 'string') && prettyPrint != undefined) {
				Automne.varDump = data;
				var showDump = function() {
					var win = new Automne.Window({
						width:			750,
						height:			580,
						title:			'Javascript Var Dump',
						html:			'',
						bodyStyle:		'padding:5px;',
						autoScroll:		true,
						listeners:		{'show':function(win){
							win.body.dom.appendChild(prettyPrint(Automne.varDump));
						},'scope':this}
					});
					win.show();
				}
				data = data.toString()+ ' <a href="#" onclick="('+Ext.util.Format.htmlEncode(showDump.toString())+')();">[Var Dump]</a>';
			}
			switch (type) {
				case 'error': //errors
					data += (backtrace) ? ' <a href="'+ backtrace +'" target="_blank">[Backtrace]</a>' : '';
					window.blackbird.error(data);
				break;
				case 'warning': //?? not used for now
					window.blackbird.warn(data);
				break;
				case 'debug': //php pr output
					window.blackbird.debug('<pre>'+data+'</pre>');
				break;
				case 'log': //default
				default:
					window.blackbird.info(data);
					//window.Ext.log(data); //use this to log info within Ext console
				break;
			}
		}
	}
};
//Magic PR function : Dump any var
if (typeof pr == 'undefined') {
	pr = Automne.console.pr;
}