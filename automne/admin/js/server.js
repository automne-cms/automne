/**
  * Automne Javascript file
  *
  * Automne.server
  * Provide server communications methods
  * @class Automne.server
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: server.js,v 1.5 2010/01/18 15:24:30 sebastien Exp $
  */
Automne.server = {
	call: function (url, fcn, params, scope) {
		var config = {};
		var defaultConfig = {
			disableCaching:		true,
			success: 			Automne.server.evalResponse,
			failure: 			Automne.server.failureResponse,
			timeout:			120000,
			scope:				this
		};
		if (typeof url == 'object') {
			config = Ext.applyIf(url, defaultConfig);
		} else {
			config = Ext.apply(config, {
				url:			url,
				fcnCallback: 	(fcn) ? fcn : '',
				callBackScope: 	(scope) ? scope : false,
				params: 		(params) ? params : ''
			}, defaultConfig);
		}
		// send request and return request number
		return Ext.Ajax.request(config);
	},
	//show loading spinner on server call
	showSpinner: function (conn, options) {
		if (!options.params || options.params.nospinner !== true) {
			var spinner = Ext.get('atm-server-call');
			if (spinner) {
				spinner.show();
			}
		}
		//log ajax call for IE
		if (Ext.isIE || Ext.isSafari) {
			pr('Call to '+options.url);
		}
		//set token header
		if (conn.defaultHeaders) {
			conn.defaultHeaders['X-Atm-Token'] = Automne.context.token;
		}
	},
	//hide loading spinner after server call
	hideSpinner: function (ajax, response, options) {
		if (!Ext.Ajax.isLoading()) {
			var spinner = Ext.get('atm-server-call');
			if (spinner) {
				spinner.hide();
			}
		}
		//check for return error
		if (!(options && options.isUpload) && (
				response == undefined || 
				(response.responseXML == undefined && response.getResponseHeader('Content-Type').indexOf('text/xml') !== -1) 
				|| response.responseText == ''
				|| !response.getResponseHeader('X-Automne-Response'))
			) {
			Automne.server.failureResponse(response, options, null, 'call timeout');
		}
	},
	//method used for a server call : eval response
	evalResponse: function (response, options) {
		//check for XML content
		if (response == undefined || response.responseXML == undefined) {
			//here, error is handled by hideSpinner method, so simply quit
			return;
		}
		var content = '';
		//define shortcut
		var xml = response.responseXML;
		//check for token update
		if (xml.getElementsByTagName('token').length) {
			// Update token to pass in every Ajax request. Used to prevent CSRF attacks on action requests
			Automne.context.token = xml.getElementsByTagName('token').item(0).firstChild.nodeValue;
		}
		//check for errors returned
		if (xml.getElementsByTagName('error').length
			&& xml.getElementsByTagName('error').item(0).firstChild.nodeValue != 0
			&& xml.getElementsByTagName('errormessage').item(0).childNodes.length) {
			Automne.console.throwErrors(xml.getElementsByTagName('errormessage').item(0).firstChild.nodeValue);
		}
		//check for rawdatas returned
		if (xml.getElementsByTagName('rawdatas').length) {
			Automne.console.throwRawDatas(xml.getElementsByTagName('rawdatas').item(0).firstChild.nodeValue);
		}
		//display message if any
		if (options.evalMessage !== false && xml && xml.getElementsByTagName('message').length) {
			var win = Ext.WindowMgr.getActive();
			Automne.message.show('', xml.getElementsByTagName('message').item(0).firstChild.nodeValue, win || document);
		}
		//scripts in progress
		if (xml && xml.getElementsByTagName('scripts').length) {
			Automne.scripts.set(xml.getElementsByTagName('scripts').item(0).firstChild.nodeValue, options);
		} else {
			Automne.scripts.set(0, options);
		}
		//execution stats
		if (xml && xml.getElementsByTagName('stats').length) {
			pr(xml.getElementsByTagName('stats').item(0).firstChild.nodeValue, 'debug');
		}
		//extract json or content datas from response if any
		if (options.evalJSon !== false && xml && xml.getElementsByTagName('jsoncontent').length) {
			var jsonResponse = {};
			try{
				//eval('jsonResponse = '+xml.getElementsByTagName('jsoncontent').item(0).firstChild.nodeValue+';');
				jsonResponse = Ext.decode(xml.getElementsByTagName('jsoncontent').item(0).firstChild.nodeValue);
			} catch(e) {
				jsonResponse = {};
				pr(e, 'error');
				Automne.server.failureResponse(response, options, e, 'json');
			}
		} else if(options.evalContent !== false && xml && xml.getElementsByTagName('content').length) {
			content = xml.getElementsByTagName('content').item(0).firstChild.nodeValue;
		}
		//check for action message returned
		if (options.evalJS !== false && xml && xml.getElementsByTagName('jscontent').length) {
			//otherwise, try to eval JS if any
			try{
				eval(xml.getElementsByTagName('jscontent').item(0).firstChild.nodeValue);
			} catch(e) {
				pr(e, 'error');
				Automne.server.failureResponse(response, options, e, 'js');
			}
		}
		//extract json jsfiles and cssfiles in response if any
		var jsFiles = {}, cssFiles = {};
		if (options.evalJSon !== false && xml && xml.getElementsByTagName('jsfiles').length) {
			try{
				jsFiles = Ext.decode(xml.getElementsByTagName('jsfiles').item(0).firstChild.nodeValue);
			} catch(e) {
				jsFiles = {};
				pr(e, 'error');
			}
		}
		if (options.evalJSon !== false && xml && xml.getElementsByTagName('cssfiles').length) {
			try{
				cssFiles = Ext.decode(xml.getElementsByTagName('cssfiles').item(0).firstChild.nodeValue);
			} catch(e) {
				cssFiles = {};
				pr(e, 'error');
			}
		}
		if (xml && xml.getElementsByTagName('disconnected').length) {
			Automne.view.disconnect();
		}
		if (options.fcnCallback != '' && typeof options.fcnCallback == 'function') {
			//send to callback if any
			options.fcnCallback.call(options.callBackScope || options.scope || this || window, response, options, jsonResponse || content, jsFiles, cssFiles);
		} else {
			return jsonResponse || content;
		}
	},
	//method used for a server call : request exception
	requestException: function(conn, response, options) {
		Automne.server.hideSpinner(conn, response, options);
		if (options && options.isUpload) {
			return true;
		}
		Automne.server.failureResponse(response, options, null, 'http');
	},
	//method used for a server call : failure response
	failureResponse: function (response, options, e, type) {
		if (response && response.responseXML && response.responseXML.getElementsByTagName && response.responseXML.getElementsByTagName('disconnected').length) {
			//failure can be the result of a disconnection so return 
			return;
		}
		if (!(Automne && Automne.context && Automne.context.debug & 1)) {
			//debug is not active so skip message
			return;
		}
		var al = Automne.locales;
		var msg = '';
		switch(type) {
			case 'js':
				msg = al.jsError;
			break;
			case 'json':
				msg = al.jsonError;
			break;
			case 'html':
			default:
				msg = al.loadingError;
				if (type == undefined) {
					type = al.loadingError;
				}
			break;
		}
		msg += '<br /><br />'+ al.contactAdministrator +'<br /><br />';
		msg += 'Error type : '+ type +'<br /><br />';
		if (e || response) {
			if (e) {
				msg += 'Message : '+ e.name +' : '+ e.message +'<br /><br />';
				if (e.lineNumber && e.fileName) {
					msg += 'Line : '+ e.lineNumber +' of file '+ e.fileName +'<br /><br />';
				}
			}
			if (response) {
				if (response.argument) {
					msg += 'Address : '+ response.argument.url +'<br /><br />'+
					'Parameters : '+ Ext.urlEncode(response.argument.params) +'<br /><br />';
				} else if (options.url) {
					msg += 'Address : '+ options.url +'<br /><br />';
					if (options.params) {
						msg += 'Parameters : '+ Ext.urlEncode(options.params) +'<br /><br />';
					}
				}
				if (response.status) {
					msg += 'Status : '+ response.status +' ('+ response.statusText +')<br /><br />'+
					'Response Headers : <pre class="atm-debug">'+ response.getAllResponseHeaders() +'</pre>';
				}
				if (response.responseText) {
					msg += '<br />Server return : <pre class="atm-debug">' + (!e && !response.responseXML ? response.responseText :  Ext.util.Format.htmlEncode(response.responseText)) +'</pre><br />';
				}
			}
		}
		Automne.message.popup({
			msg: 				msg,
			buttons: 			Ext.MessageBox.OK,
			closable: 			false,
			icon: 				Ext.MessageBox.ERROR,
			minWidth:			500
		});
	}
};