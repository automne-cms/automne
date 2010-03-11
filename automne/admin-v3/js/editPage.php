<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2010 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: editPage.php,v 1.3 2010/03/08 16:42:24 sebastien Exp $

/**
  * PHP JS page : allow frontend page edition
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
//for this page, HTML output compression is not welcome.
define("ENABLE_HTML_COMPRESSION", false);
require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);
define("MESSAGE_POPUP_ACTION_MAXIMIZE", 1313);

//set header content-type
header("Content-Type: text/javascript");
//check popup parameters
if ($_GET['page']) {
	//page
	if (!sensitiveIO::isPositiveInteger($_GET['page']) || !$cms_user->hasPageClearance($_GET['page'], CLEARANCE_PAGE_EDIT)) {
		exit;
	}
	$cms_page = new CMS_page($_GET['page']);
	if ($cms_page->hasError()) {
		exit;
	}
	$object = $cms_page;
} elseif ($_GET['template']) {
	//or template
	if (!sensitiveIO::isPositiveInteger($_GET['template']) || (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES))) {
		exit;
	}
	$object = CMS_pageTemplatesCatalog::getByID($_GET["template"]);
} else {
	exit;
}
//language
if (!$_GET['language'] || strlen($_GET['language']) != 2) {
	exit;
} else {
	$cms_language = new CMS_language($_GET['language']);
	if ($cms_language->hasError()) {
		exit;
	}
}
$replace = array(
	"\n" => '',
	"\r" => '',
	"\t" => '',
	"\\'" => "\\\'",
	"'" => "\'"
);
//get popup vars if any stored in session, else, set default values
$popupVars = $cms_context->getSessionVar('popupVars');
$closed = (isset($popupVars['close'])) ? $popupVars['close'] : false;
$minimized = (isset($popupVars['minimize'])) ? $popupVars['minimize'] : false;
$popupX = (isset($popupVars['x'])) ? $popupVars['x'] : false;
$popupY = (isset($popupVars['y'])) ? $popupVars['y'] : false;
?>
/*Function to create editPopup*/
function CMS_showPopup() {
	//create popupOpener
	var popupOpener = document.createElement("DIV");
	popupOpener.id='CMS_popupOpener';
	//append it to document
	//document.getElementsByTagName('BODY').item(0).appendChild(popupOpener);
	document.body.appendChild(popupOpener);
	<?php 
	if (!$closed) {
		echo 
		'//hide it'."\n".
		'	CMS_hide(\'CMS_popupOpener\');'."\n";
	}
	?>
	//add content
	<?php 
	$content = '<img onclick="CMS_openPopup();" src="'.PATH_ADMIN_IMAGES_WR.'/popup_opener.gif" alt="'.$cms_language->getMessage(MESSAGE_POPUP_ACTION_MAXIMIZE).'" title="'.$cms_language->getMessage(MESSAGE_POPUP_ACTION_MAXIMIZE).'" />';
	echo 'popupOpener.innerHTML = \''.str_replace(array_keys($replace),$replace,$content).'\';'."\n"; ?>
	//create editPopup
	var editPopup = document.createElement("DIV");
	editPopup.id='CMS_editPopup';
	//add content
	<?php
	//draw popup content
	require_once(PATH_ADMIN_FS.'/popupContent.php');
	$content = drawPopupContent($object, $_GET['visualMode']);
	
	echo 'editPopup.innerHTML = \''.str_replace(array_keys($replace),$replace,$content).'\';'."\n";
	//popup position
	if (sensitiveIO::isPositiveInteger($popupX) && sensitiveIO::isPositiveInteger($popupY)) {
		echo 
		'	//move it to previous position'."\n".
		'	editPopup.style.left = \''.$popupX.'px\';'."\n".
		'	editPopup.style.top = \''.$popupY.'px\';'."\n";
	} else {
		echo 
		'	//move it to initial position'."\n".
		'	editPopup.style.right = \'2px\';'."\n".
		'	editPopup.style.top = \'2px\';'."\n";
	}
	?>
	//append it to document
	document.getElementsByTagName('BODY').item(0).appendChild(editPopup);
	<?php 
	if ($closed) {
		echo 
		'//hide it'."\n".
		'	CMS_hide(\'CMS_editPopup\');'."\n";
	}
	if ($minimized) {
		echo 
		'//minimize it'."\n".
		'	CMS_hide(\'CMS_actionMenu\');'."\n".
		'	CMS_hide(\'CMS_imgMinimizePopup\');'."\n".
		'	CMS_show(\'CMS_imgMaximizePopup\');'."\n";
	}
	?>
	//make it dragable
	CMS_makeDraggable(editPopup);
}
function CMS_drawPopupContent(xmlcontent) {
	if (xmlcontent.getElementsByTagName('popupcontent').length > 0) {
		var editPopup = getE('CMS_editPopup');
		editPopup.innerHTML = xmlcontent.getElementsByTagName('popupcontent').item(0).firstChild.nodeValue;
	}
	return true;
}
function CMS_drawPopupContentLoad() {
	CMS_show('CMS_editPopupLoad');
}
function CMS_closePopup() {
	CMS_hide('CMS_editPopup');
	CMS_show('CMS_popupOpener');
	sendServerCall('<?php echo PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR; ?>?cms_action=closePopup', null, true);
}
function CMS_openPopup() {
	CMS_show('CMS_editPopup');
	CMS_hide('CMS_popupOpener');
	sendServerCall('<?php echo PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR; ?>?cms_action=openPopup', null, true);
}
function CMS_minimizePopup() {
	CMS_hide('CMS_actionMenu');
	CMS_hide('CMS_imgMinimizePopup');
	CMS_show('CMS_imgMaximizePopup');
	sendServerCall('<?php echo PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR; ?>?cms_action=minimizePopup', null, true);
	return true;
}
function CMS_maximizePopup() {
	CMS_show('CMS_actionMenu');
	CMS_show('CMS_imgMinimizePopup');
	CMS_hide('CMS_imgMaximizePopup');
	sendServerCall('<?php echo PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR; ?>?cms_action=maximizePopup', null, true);
	return true;
}
var CMS_dragObject  = null;
var CMS_mouseOffset = null;
function CMS_mouseCoords(ev){
	if(ev.pageX || ev.pageY){
		return {x:ev.pageX, y:ev.pageY};
	}
	return {
		x:ev.clientX + document.body.scrollLeft - document.body.clientLeft,
		y:ev.clientY + document.body.scrollTop  - document.body.clientTop
	};
}
function CMS_getMouseOffset(target, ev){
	ev = ev || window.event;
	var docPos    = CMS_getPosition(target);
	var mousePos  = CMS_mouseCoords(ev);
	return {x:mousePos.x - docPos.x, y:mousePos.y - docPos.y};
}
function CMS_getPosition(e){
	var left = 0;
	var top  = 0;
	while (e.offsetParent){
		left += e.offsetLeft;
		top  += e.offsetTop;
		e     = e.offsetParent;
	}
	left += e.offsetLeft;
	top  += e.offsetTop;
	return {x:left, y:top};
}
function CMS_mouseMove(ev){
	ev           = ev || window.event;
	var mousePos = CMS_mouseCoords(ev);
	if(CMS_dragObject){
		if (isIE) {
			if (isIE7 && document.all[0].nodeValue && document.all[0].nodeValue.toLowerCase().indexOf('xhtml')) {
				//IE7 support fixed value only if doctype is declared (no quirk mode)
				CMS_dragObject.style.position = 'fixed';
			} else {
				CMS_dragObject.style.position = 'absolute';
			}
		} else {
			CMS_dragObject.style.position = 'fixed';
		}
		CMS_dragObject.style.top      = (mousePos.y - CMS_mouseOffset.y) + 'px';
		CMS_dragObject.style.left     = (mousePos.x - CMS_mouseOffset.x) + 'px';
		return false;
	}
}
function CMS_mouseUp(){
	var endPosition = CMS_getPosition(CMS_dragObject);
	sendServerCall('<?php echo PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR; ?>?cms_action=movePopup&popupX=' + endPosition.x + '&popupY=' + endPosition.y, null, true);
	CMS_dragObject = null;
}
function CMS_makeDraggable(item){
	if(!item) return;
	item.onmousedown = function(ev){
		CMS_dragObject  = this;
		CMS_mouseOffset = CMS_getMouseOffset(this, ev);
		return false;
	}
	item.onmouseup   = CMS_mouseUp;
	document.onmousemove = CMS_mouseMove;
}

//on windows load create editPopup
CMS_addEvent(window, 'load', function() {CMS_showPopup();});