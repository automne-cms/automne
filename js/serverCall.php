<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2007 WS Interactive                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license.       |
// | The license text is bundled with this package in the file            |
// | LICENSE-GPL, and is available at through the world-wide-web at       |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: serverCall.php,v 1.1.1.1 2008/11/26 17:12:36 sebastien Exp $

/**
  * PHP JS page : usefull server call functions and other misc methods
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
//set header content-type
header("Content-Type: text/javascript");
$debug = 0;
if (defined('SYSTEM_DEBUG') && SYSTEM_DEBUG) {
	$debug = 1;
	if (defined('STATS') && STATS) {
		$debug += 2;
		if (defined('VIEW_SQL') && VIEW_SQL) {
			$debug += 4;
		}
	}
}

$content = <<<END
//main js debug var
var Debug = {$debug};

/**********************************************
* USEFULL FUNCTIONS                           *
**********************************************/
//declare navigator type
if (navigator.userAgent.toLowerCase().indexOf('msie') != -1 && navigator.userAgent.toLowerCase().indexOf('opera') == -1) {
	var isIE = true;
	//get IE version
	if (navigator.userAgent.toLowerCase().indexOf("msie 5.5") != -1) {
		var isIE55 = true;
	} else if (navigator.userAgent.toLowerCase().indexOf("msie 6") != -1)  {
		var isIE6 = true;
	} else if (navigator.userAgent.toLowerCase().indexOf("msie 7") != -1)  {
		var isIE7 = true;
	}
} else if (navigator.userAgent.toLowerCase().indexOf('opera') != -1) {
	var isOp = true;
} else if (navigator.userAgent.toLowerCase().indexOf('firefox') != -1 || navigator.userAgent.toLowerCase().indexOf('mozilla') != -1) {
	var isMoz = true;
}
/**
  * Add an event on a given object
  * @param html object obj, the object to add event on
  * @param string evType, the event type to add (click, mouseover, blur, etc.)
  * @param string fcn, the function name to call on event
  * @return boolean true on success, false on failure
  */
function CMS_addEvent(obj, evType, fcn) {
	if (obj.addEventListener) {
		obj.addEventListener(evType, fcn, true);
		return true;
	} else if (obj.attachEvent) {
		var r = obj.attachEvent("on"+evType, fcn);
		return r;
	} else {
		return false;
	}
	return true;
}

/**
  * Stop event on a given object
  * @param html object e, the object to stop event on (if none (IE case mostfully), get it from window.event) 
  * @return void
  */
function CMS_cancelEvent(e) {
    var e = e || window.event;
	
    e.cancelBubble = true; // for IE
    if (typeof e.stopPropagation == 'function')
        e.stopPropagation();

    e.returnValue = false; // for IE
    if (typeof e.preventDefault == 'function')
        e.preventDefault();
}

/**
  * Get element by id
  * @param string id, the element id to get
  * @return wanted element or false if not founded
  */
function getE(id) {
	if (document.getElementById(id)) { 
		return document.getElementById(id);
	} else {
		return false;
	}
}
/**
  * Show given element
  * @param string id, the element id to show (html object allowed)
  * @return boolean true on success, false on failure
  */
function CMS_show(id) {
	var f;
	if (typeof(id) == 'string') {
		f = getE(id);
	} else {
		f = id;
	}
	if (f.tagName=='TR' && !isIE) {
		f.style.display = 'table-row';
	} else if (f.tagName=='TD' && !isIE) {
		f.style.display = 'table-cell';
	} else if (f.tagName=='SPAN') {
		f.style.display = 'inline';
	} else {
		f.style.display = 'block';
	}
	return true;
}
/**
  * Hide given element
  * @param string id, the element id to hide (html object allowed)
  * @return boolean true on success, false on failure
  */
function CMS_hide(id) {
	var f;
	if (typeof(id) == 'string') {
		f = getE(id);
	} else {
		f = id;
	}
	f.style.display = 'none';
	return true;
}
/**********************************************
* XML FUNCTIONS                               *
**********************************************/
/*XMLHttpRequest cross browser function*/
function getHTTPObject() {
	var xmlhttp = false;
	responseXML = null;
	/*@cc_on
	@if (@_jscript_version >= 5)
		var msxml = new Array('MSXML2.XMLHTTP.5.0','MSXML2.XMLHTTP.4.0','MSXML2.XMLHTTP.3.0','MSXML2.XMLHTTP','Microsoft.XMLHTTP');
		for(var i=0; i<msxml.length; i++){
			try {
				// Instantiates XMLHttpRequest for IE and assign to xmlhttp.
				xmlhttp = new ActiveXObject(msxml[i]);
				if(xmlhttp){
					break;
				}
			} catch(e){}
		}
		
		@else
			xmlhttp = false;
	@end @*/
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		try {
			xmlhttp = new XMLHttpRequest();
		} catch (e) {
			xmlhttp = false;
		}
	}
	if (xmlhttp) {
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState == 4) {
				if (xmlhttp.status == 200) {
					raiseError(xmlhttp.responseText);
				}
			}
		}
	}
	return xmlhttp;
}
/** 
  * Send server call (ie. Ajax call) using GET sending
  * Then send result to a given function.
  * @access public
  * @param string xmlUrl : url to call (with parameters if needed)
  * @param string fcn : function name to pass the returned result. 
  *  If fcn value is null then do nothing, no treatment needed after call.
  *  Try to launch a loading function (named fcn + 'Load') if exists.
  * @param boolean returnXML : which type of content to send to the result function ? if true : send XML, then send plaintext.
  * @return boolean true on success, false on failure
  */
function sendServerCall(xmlUrl, fcn, returnXML) {
	var xmlhttp = getHTTPObject();
	var response;
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState == 4) {
			if (xmlhttp.status && xmlhttp.status == 200) {
				if (returnXML == true) {
					response = xmlhttp.responseXML;
					//try to get an error and errormessage tags if exists
					if (xmlhttp.getResponseHeader('Content-Type') == 'text/xml' && response.getElementsByTagName('error').length > 0) {
						var error = response.getElementsByTagName('error').item(0).firstChild.nodeValue;
						if (Debug > 0 && error != 0 && response.getElementsByTagName('errormessage').length > 0) {
							var msg = response.getElementsByTagName('errormessage').item(0).firstChild.nodeValue;
							userMessage(msg,'OK',false,false);
							return false;
						}
					} else if (xmlhttp.getResponseHeader('Content-Type') != 'text/xml') {
						if (Debug > 0) {
							var msg = 'Server communication error ... Response was not valid XML.';
							userMessage(msg,'OK',false,false);
						}
						return false;
					}
				} else {
					response = xmlhttp.responseText;
				}
				if (fcn != null && typeof eval(fcn) == 'function') {
					return eval(fcn+"(response);");
				}
				return true;
			} else if (xmlhttp.status) {
				var msg = 'Server communication error ...';
				if (Debug > 0) {
					msg += '<br />Type : ' + xmlhttp.status;
				}
				userMessage(msg,'OK',false,false);
				return false;
			}
		}
	}
	//launch loading function if exists
	if (eval("typeof (" + fcn + "Load)") == 'function') {
		eval(fcn+"Load();");
	}
	//add timestamp at end of query to avoid navigator cache
	var time = new Date();
	xmlUrl += (xmlUrl.indexOf('?') != -1) ? '&time=' + time.getTime() : '?time=' + time.getTime();
	xmlhttp.open("GET", xmlUrl,true);
	xmlhttp.send(null);
	if (Debug > 1) {
		pr('Server call : ' + unescape(xmlUrl));
	}
}
/**********************************************
* MESSAGES & ERRORS FUNCTIONS                 *
**********************************************/
/** 
  * Raise an exception if Debug is true
  * @access public
  * @param string value : the exception to show
  * @return boolean true on success, false on failure
  */
function pr(value) {
	if (Debug > 0) {
		if (typeof(value) != 'string' && typeof(value) != 'undefined' && value != null) {
			value = value.toString();
		}
		if (typeof console != 'undefined' && console.debug) {
			//send error to firebug
			console.debug(value);
		} else {
			if (getE("CMS_prWindow")) {
				getE("CMS_prWindow").innerHTML += "<br />"+value;
				CMS_show('CMS_prWindow');
			} else {
				//create debug window
				var prWindowDiv = document.createElement("DIV");
				prWindowDiv.id='CMS_prWindow';
				prWindowDiv.style.position='absolute';
				prWindowDiv.style.font='bold 10px Verdana,Arial,Helvetica,sans-serif';
				prWindowDiv.style.color='#333333';
				prWindowDiv.style.backgroundColor='#CECECE';
				prWindowDiv.style.border='1px solid';
				prWindowDiv.style.borderColor='#000000';
				prWindowDiv.style.right='0px';
				prWindowDiv.style.top='0px';
				prWindowDiv.style.zIndex='1000';
				prWindowDiv.style.padding='5px';
				prWindowDiv.style.maxWidth='800px';
				document.getElementsByTagName('BODY').item(0).appendChild(prWindowDiv);
				CMS_addEvent(prWindowDiv,'click',function() {
					CMS_hide('CMS_prWindow');
					getE('CMS_prWindow').innerHTML='';
				});
				prWindowDiv.innerHTML = value;
			}
		}
	}
	return true;
}
/** 
  * Raise a message for user
  * @access public
  * @param string value : the message to show
  * @param string messageOK : the ok message to show on button
  * @param string messageCancel : the cancel message to show on button. If false, no cancel button appear.
  * @param string fcnOK : function name to launch if ok button is clicked. If false, no function launched
  * @param string fcnCancel : function name to launch if cancel button is clicked. If false, no function launched
  * @return boolean true on success, false on failure
  */
function userMessage(value, messageOK, messageCancel, fcnOK, fcnCancel) {
	if (typeof(value) != 'string' && typeof(value) != 'undefined') {
		value = value.toString();
	}
	if (!getE("CMS_userMessage")) {
		var userMessageDiv = document.createElement("DIV");
		userMessageDiv.id='CMS_userMessage';
		userMessageDiv.style.position='absolute';
		userMessageDiv.style.top='0px';
		userMessageDiv.style.left='0px';
		userMessageDiv.style.width='100%';
		document.getElementsByTagName('BODY').item(0).appendChild(userMessageDiv);
		var userMessageTextDiv = document.createElement("DIV");
		userMessageTextDiv.id='CMS_userMessageText';
		userMessageTextDiv.style.position='relative';
		userMessageTextDiv.style.font='normal 12px Verdana,Arial,Helvetica,sans-serif';
		userMessageTextDiv.style.background='#FFFFFF url(/automne/admin/img/logo_small.gif) top right no-repeat';
		userMessageTextDiv.style.width='365px';
		userMessageTextDiv.style.margin='50px auto 0 auto';
		userMessageTextDiv.style.border='2px solid #FF0000';
		userMessageTextDiv.style.textAlign='center';
		userMessageTextDiv.style.padding='20px';
		userMessageTextDiv.style.zIndex='1000';
		userMessageDiv.appendChild(userMessageTextDiv);
	}
	if (fcnOK == true || fcnOK == false || typeof eval(fcnOK) != 'function') {
		value = value + '<br /><br /><input type="button" onclick="CMS_hide(\'CMS_userMessage\');return true;" value="' + messageOK +'" />';
	} else {
		value = value + '<br /><br /><input type="button" onclick="CMS_hide(\'CMS_userMessage\');return '+fcnOK+'();" value="' + messageOK +'" />';
	}
	if (messageCancel) {
		if (fcnCancel == true || fcnCancel == false || typeof eval(fcnCancel) != 'function') {
			value = value + '&nbsp;<input type="button" onclick="CMS_hide(\'CMS_userMessage\');return true;" value="' + messageCancel +'" />';
		} else {
			value = value + '&nbsp;<input type="button" onclick="CMS_hide(\'CMS_userMessage\');return '+fcnCancel+'();" value="' + messageCancel +'" />';
		}
	}
	getE("CMS_userMessageText").innerHTML = value;
	window.scrollTo(0,0);
	CMS_show('CMS_userMessage');
	return true;
}

END;
echo $content;
?>