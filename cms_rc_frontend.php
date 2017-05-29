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

/**
  * AUTOMNE Frontend rc file.
  * Contains declarations and includes for the frontend part.
  * 
  * @package Automne
  * @subpackage config
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  */

/**
  * Define User Type
  */
if (!defined("APPLICATION_USER_TYPE")) {
	define("APPLICATION_USER_TYPE", "frontend");
}
//include general configuration file
require_once(dirname(__FILE__)."/cms_rc.php");

/**
  * This constant is only for compatibility with old modules
  * because this file no longer exists since V3.2.1
  */
if (!defined("PATH_FRONTEND_SPECIAL_SESSION_CHECK_FS")) {
	define("PATH_FRONTEND_SPECIAL_SESSION_CHECK_FS", PATH_REALROOT_FS."/application_enforces_access_control.php");
}

/*******************************\
*     DEPRECATED FUNCTIONS      *
*   Keeped for compatibility    *
\*******************************/

/**
  * Gets the URL of a page by its ID (DEPRECATED)
  *
  * @param integer $pageID The DB ID of the page
  * @param boolean $withMainURL, to add main URL (ex : http://domain.com/html/_.php) (not used, since V4 always true)
  * @return string The page URL
  * @access public
  */
function getPageURL($pageID, $withMainURL = true) {
	if (!$withMainURL) {
		CMS_grandFather::raiseError('$withMainURL parameter is no longer available in this version of Automne');
	}
	return CMS_tree::getPageValue($pageID, 'url');
}
function getWebsites() {
	CMS_grandFather::raiseError('This function is no longer available in this version of Automne');
	return false;
}
function getLineage() {
	CMS_grandFather::raiseError('This function is no longer available in this version of Automne');
	return false;
}
function getPageFilename() {
	CMS_grandFather::raiseError('This function is no longer available in this version of Automne');
	return false;
}
function getMainURL() {
	CMS_grandFather::raiseError('This function is no longer available in this version of Automne');
	return false;
}
/**
  * Builds a link from a linktype and a link template which may contain the special string {{href}}
  *
  * @param integer $type The type of the link
  * @param array(string) $parameters The links parameters in this order : internalLink page ID, external URL, file URL
  * @param string $template The link template
  * @param array $popup The popup parameter $popupInfo[0] : boolean is popup active ?, $popupInfo[1] : integer popup size X, $popupInfo[2] : integer popup size Y
  * @return string The link built.
  * @access public
  */
function buildLink($type, $parameters, $template, $popupInfo=false) {
	switch ($type) {
	case RESOURCE_LINK_TYPE_INTERNAL:
		$href = CMS_tree::getPageValue($parameters[0], 'url');
		$target="_top";
		break;
	case RESOURCE_LINK_TYPE_EXTERNAL:
		$href = $parameters[1];
		if (substr($href, 0, 4) != 'http') {
			$href = 'http://' . $href;
		}
		$target = "_blank";
		break;
	case RESOURCE_LINK_TYPE_FILE:
		$href = $parameters[2];
		if (substr($href, 0, 4) != 'http') {
			$href = 'http://' . $href;
		}
		$target = "_blank";
		break;
	default:
		return '';
		break;
	}
	if ($popupInfo!=false && is_array($popupInfo) && $popupInfo[0]!=0 && $href) {
		$href = "javascript:openWindow('".$href."', 'popup', ".$popupInfo[1].", ".$popupInfo[2].", 'yes', 'yes', 'no', 40, 40);";
		$target = "";
	}
	if ($href) {
		$template = str_replace("{{target}}", $target, $template);
		return str_replace("{{href}}", $href, $template);
	}
}
?>