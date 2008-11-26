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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: cms_rc_frontend.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * Frontend rc file.
  *
  * Contains declarations for the frontend part.
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//include general configuration file
require_once(dirname(__FILE__)."/cms_rc.php");

//start session
@session_start();

// Start output buffering for compression so we don't prevent
// headers from being sent if there's a blank line in an included file
ob_start( 'compress_handler' );

/**
  * Define User Type if APPLICATION_ENFORCES_ACCESS_CONTROL is True
  */
if (!defined("APPLICATION_USER_TYPE")) {
	define("APPLICATION_USER_TYPE", "frontend");
}

/**
  * Define execution Type
  */
if (!defined("APPLICATION_EXEC_TYPE")) {
	define("APPLICATION_EXEC_TYPE", "http");
}

/**
  * adding classes and constants for checking user access right for each pages of the website
  */
if (APPLICATION_ENFORCES_ACCESS_CONTROL) {
	/**
	  *	FrontEnd login page URL
	  * Frontend login page
	  *	Default : /403.php
	  */
	if (!defined("PATH_FRONTEND_SPECIAL_LOGIN_WR")) {
		define("PATH_FRONTEND_SPECIAL_LOGIN_WR", '/403.php');
	}
	/**
	  *	FrontEnd forbidden page URL (403)
	  * wrong users privilège or session time out redirect to this page
	  *	Default : /403.php
	  */
	if (!defined("PATH_FORBIDDEN_WR")) {
		define("PATH_FORBIDDEN_WR", '/403.php');
	}
}

/**
  * User session management :
  * if not APPLICATION_ENFORCES_ACCESS_CONTROL (default)
  *  - user connected : create user context object
  *  - user disconnected (or session lost) : destroy user context
  *  - user not connected : continue
  * if APPLICATION_ENFORCES_ACCESS_CONTROL
  *  - user connected : create user context object
  *  - user disconnected (or session lost) : destroy user context and create public context
  *  - user not connected : create public context
  */
if (!APPLICATION_ENFORCES_ACCESS_CONTROL) {
	//check if user session exists
	if (isset($_SESSION["cms_context"])) {
		//check session object
		if (is_a($_SESSION["cms_context"], "CMS_context")) {
			$_SESSION["cms_context"]->checkSession();
			//then if session always exists, set some useful vars
			if (is_object($_SESSION["cms_context"])) {
				$cms_context =& $_SESSION["cms_context"];
				$cms_user = $_SESSION["cms_context"]->getUser();
				$cms_language = $cms_user->getLanguage();
			}
		}
	} elseif (isset($cms_user) && is_a($cms_user, "CMS_profile_user")) {
		//user already exists, only need to declare language
		$cms_language = $cms_user->getLanguage();
	}
} else {
	//check if user session exists
	if ($_SESSION["cms_context"]) {
		//check session object
		if (is_a($_SESSION["cms_context"], "CMS_context")) {
			$_SESSION["cms_context"]->checkSession();
			//then if session always exists, set some useful vars
			if (is_object($_SESSION["cms_context"])) {
				$cms_context =& $_SESSION["cms_context"];
				$cms_user = $_SESSION["cms_context"]->getUser();
				$cms_language = $cms_user->getLanguage();
			} else {
				//else initialize public user
				$cms_context = new CMS_context(DEFAULT_USER_LOGIN, DEFAULT_USER_PASSWORD);
				if (!$cms_context->hasError()) {
					$_SESSION["cms_context"] = $cms_context;
					$cms_user = $_SESSION["cms_context"]->getUser();
					$cms_language = $cms_user->getLanguage();
				} else {
					header("Location: ".PATH_FRONTEND_SPECIAL_LOGIN_WR);
					exit;
				}
			}
		}
	} else {
		global $cms_user; //try to get user from global in case it has declared somewhere else
		if (!is_object($cms_user)) {
			//initialize public user
			$cms_context = new CMS_context(DEFAULT_USER_LOGIN, DEFAULT_USER_PASSWORD);
			if (!$cms_context->hasError()) {
				$_SESSION["cms_context"] = $cms_context;
				$cms_user = $_SESSION["cms_context"]->getUser();
				$cms_language = $cms_user->getLanguage();
			} else {
				header("Location: ".PATH_FRONTEND_SPECIAL_LOGIN_WR);
				exit;
			}
		} elseif (is_a($cms_user, "CMS_profile_user")) {
			//user already exists, only need to declare language
			$cms_language = $cms_user->getLanguage();
		}
	}
}

//force module standard loading
if (!class_exists('CMS_module_standard')) {
	die('Cannot find standard module ...');
}

/**
  * This constant is only for compatibility with old modules
  * because this file no longer exists since V3.2.1
  */
if (!defined("PATH_FRONTEND_SPECIAL_SESSION_CHECK_FS")) {
	define("PATH_FRONTEND_SPECIAL_SESSION_CHECK_FS", $_SERVER["DOCUMENT_ROOT"]."/application_enforces_access_control.php");
}

/*******************************\
*     DEPRECATED FUNCTIONS      *
*   Keeped for compatibility    *
\*******************************/
function getWebsites() {
	CMS_grandFather::raiseError('This function is no longer available in this version of Automne');
	return false;
}
/**
  * Gets the URL of a page by its ID (DEPRECATED)
  *
  * @param integer $pageID The DB ID of the page
  * @param boolean $withMainURL, to add main URL (ex : http://domain.com/html/_.php) (not used, since V4 always true)
  * @return string The page URL
  * @access public
  */
function getPageURL($pageID, $withMainURL = true) {
	return CMS_tree::getPageValue($pageID, 'url');
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