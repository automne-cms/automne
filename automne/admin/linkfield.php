<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: linkfield.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : send link field HTML accross ajax request
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_FIELD_YES", 1082);
define("MESSAGE_PAGE_FIELD_NO", 1083);
define("MESSAGE_PAGE_FIELD_PAGE", 1303);
define("MESSAGE_PAGE_FIELD_TO", 1302);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//Get request vars
$module = sensitiveIO::request('module', '', MOD_STANDARD_CODENAME);
$visualmode = sensitiveIO::request('visualmode', '', RESOURCE_DATA_LOCATION_EDITED);
$value = sensitiveIO::request('value', '', '');
$action = sensitiveIO::request('action', '', '');


/*
	$config['admin'] = (isset($_REQUEST['admin']) && $_REQUEST['admin'] == 'false') ? false : true;
	$config['label'] = (isset($_REQUEST['label']) && $_REQUEST['label'] == 'false') ? false : true;
	$config['internal'] = (isset($_REQUEST['internal']) && $_REQUEST['internal'] == 'false') ? false : true;
	$config['external'] = (isset($_REQUEST['external']) && $_REQUEST['external'] == 'false') ? false : true;
	$config['file'] = (isset($_REQUEST['file']) && $_REQUEST['file'] == 'false') ? false : true;
	$config['destination'] = (isset($_REQUEST['destination']) && $_REQUEST['destination'] == 'false') ? false : true;
	$config['currentPage'] = (isset($_REQUEST['currentPage']) && sensitiveIO::isPositiveInteger($_REQUEST['currentPage'])) ? $_REQUEST['currentPage'] : false;
*/
//simple function used to test a value with the string 'false'
function checkFalse($value) {
	return ($value == 'false');
}

//href config
$config = array();
$config['admin'] = (sensitiveIO::request('admin', 'checkFalse')) ? false : true;
$config['label'] = (sensitiveIO::request('label', 'checkFalse')) ? false : true;
$config['internal'] = (sensitiveIO::request('internal', 'checkFalse')) ? false : true;
$config['external'] = (sensitiveIO::request('external', 'checkFalse')) ? false : true;
$config['file'] = (sensitiveIO::request('file', 'checkFalse')) ? false : true;
$config['destination'] = (sensitiveIO::request('destination', 'checkFalse')) ? false : true;
$config['currentPage'] = (sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger')) ? false : true;

$config['no_admin'] = true; //for old V3 compatibility

//create href object
$href = new CMS_href($value);
switch ($action) {
	case 'getdisplay':
		if ($href->hasValidHREF()) {
			$content = $cms_language->getMessage(MESSAGE_PAGE_FIELD_YES).' '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TO).' : ';
			if ($href->getLinkType() == RESOURCE_LINK_TYPE_INTERNAL) {
				$redirectPage = new CMS_page($href->getInternalLink());
				if (!$redirectPage->hasError()) {
					$public = ($visualmode != RESOURCE_DATA_LOCATION_EDITED) ? true : false;
					$label = $cms_language->getMessage(MESSAGE_PAGE_FIELD_PAGE).' "'.$redirectPage->getTitle($public).'" ('.$redirectPage->getID().')';
				}
			} else {
				$label = $href->getExternalLink();
			}
			$href->setTarget('_blank');
			$content .= $href->getHTML($label, $module, $visualmode);
		} else {
			$content = $cms_language->getMessage(MESSAGE_PAGE_FIELD_NO);
		}
	break;
	case 'getform':
	default:
		$redirectlinkDialog = new CMS_dialog_href($href);
		$content = $redirectlinkDialog->getHTMLFields($cms_language, $module, $visualmode, $config);
	break;
}
//send back html
$view->setContent($content);
$view->show();
?>