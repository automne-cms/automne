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
// $Id: serverResponse.php,v 1.2 2010/03/08 16:41:41 sebastien Exp $

/**
  * PHP serverResponse page : send response from serverCall JS methods
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//returned content format : text or xml (default)
$contentType = 'xml';
//var which store returned content
$content = '';
// for XML content only : errors management. Displayed in frontend if SYSTEM_DEBUG, STATS_DEBUG and VIEW_SQL are true
$error = 0;
$errorMessage = '';

// ****************************************************************
// ** MASTER ACTIONS SWITCH                                      **
// ****************************************************************
switch ($_GET["cms_action"]) {
	// ****************************************************************
	// ** POPUP ACTIONS                                              **
	// ****************************************************************
	//popup is closed
	case 'closePopup':
		$popupVars = $cms_context->getSessionVar('popupVars');
		$popupVars['close'] = true;
		$cms_context->setSessionVar('popupVars',$popupVars);
	break;
	//popup is opened
	case 'openPopup':
		$popupVars = $cms_context->getSessionVar('popupVars');
		$popupVars['close'] = false;
		$cms_context->setSessionVar('popupVars',$popupVars);
	break;
	//popup is minimized
	case 'minimizePopup':
		$popupVars = $cms_context->getSessionVar('popupVars');
		$popupVars['minimize'] = true;
		$cms_context->setSessionVar('popupVars',$popupVars);
	break;
	//popup is maximized
	case 'maximizePopup':
		$popupVars = $cms_context->getSessionVar('popupVars');
		$popupVars['minimize'] = false;
		$cms_context->setSessionVar('popupVars',$popupVars);
	break;
	//popup is moved
	case 'movePopup':
		if (is_numeric($_GET['popupX']) && is_numeric($_GET['popupY'])) {
			if ($_GET['popupX'] < 1) {
				$_GET['popupX'] = 1;
			}
			if ($_GET['popupY'] < 1) {
				$_GET['popupY'] = 1;
			}
			$popupVars = $cms_context->getSessionVar('popupVars');
			$popupVars['x'] = $_GET['popupX'];
			$popupVars['y'] = $_GET['popupY'];
			$cms_context->setSessionVar('popupVars',$popupVars);
		} else {
			$error = 1;
			$errorMessage = 'Unkown popup coordinates : X : '.htmlspecialchars($_GET["popupX"]).' - Y : '.htmlspecialchars($_GET["popupY"]);
		}
	break;
	// ****************************************************************
	// ** POPUP PAGE ACTIONS                                         **
	// ****************************************************************
	case 'popupPageUnlock':
		if (sensitiveIO::IsPositiveInteger($_GET['page'])) {
			require_once(PATH_ADMIN_FS.'/popupContent.php');
			$cms_page = new CMS_page($_GET['page']);
			$cms_page->unlock();
			$content = '<popupcontent><![CDATA['.drawPopupContent($cms_page).']]></popupcontent>';
		} else {
			$error = 1;
			$errorMessage = 'Page id must be a positive integer : '.htmlspecialchars($_GET['page']);
		}
	break;
	case 'pageUndel' : 
		if (sensitiveIO::IsPositiveInteger($_GET['page'])) {
			require_once(PATH_ADMIN_FS.'/popupContent.php');
			$cms_page = new CMS_page($_GET['page']);
			$cms_page->removeProposedLocation();
			$cms_page->writeToPersistence();
			$log = new CMS_log();
			$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_UNDELETE, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
			$content = '<popupcontent><![CDATA['.drawPopupContent($cms_page).']]></popupcontent>';
		} else {
			$error = 1;
			$errorMessage = 'Page id must be a positive integer : '.htmlspecialchars($_GET['page']);
		}
	break;
	case 'pageCancelEditions':
		if (sensitiveIO::IsPositiveInteger($_GET['page'])) {
			require_once(PATH_ADMIN_FS.'/popupContent.php');
			$cms_page = new CMS_page($_GET['page']);
			// Copy clientspaces and data from public to edited tables
			$tpl = $cms_page->getTemplate();
			CMS_moduleClientSpace_standard_catalog::moveClientSpaces($tpl->getID(), RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_EDITED, true);
			CMS_blocksCatalog::moveBlocks($cms_page, RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_EDITED, true);
			$cms_page->cancelAllEditions();
			$cms_page->writeToPersistence();
			$log = new CMS_log();
			$log->logResourceAction(CMS_log::LOG_ACTION_RESOURCE_CANCEL_EDITIONS, $cms_user, MOD_STANDARD_CODENAME, $cms_page->getStatus(), "", $cms_page);
			$content = '<popupcontent><![CDATA['.drawPopupContent($cms_page).']]></popupcontent>';
		} else {
			$error = 1;
			$errorMessage = 'Page id must be a positive integer : '.htmlspecialchars($_GET['page']);
		}
	break;
	// ****************************************************************
	// ** MISC. ACTION                                               **
	// ****************************************************************
	case 'pageUnlock':
		if (sensitiveIO::IsPositiveInteger($_GET['page'])) {
			require_once(PATH_ADMIN_FS.'/popupContent.php');
			$cms_page = new CMS_page($_GET['page']);
			$cms_page->unlock();
		} else {
			$error = 1;
			$errorMessage = 'Page id must be a positive integer : '.htmlspecialchars($_GET['page']);
		}
	break;
	// ****************************************************************
	// ** CATEGORIES / PAGES RIGHTS ACTIONS                          **
	// ****************************************************************
	case 'setClearance':
		if (!isset($_GET['mod']) || (!isset($_GET['group']) && !isset($_GET['user'])) || !isset($_GET['rights']) || !isset($_GET['ids'])) {
			$error = 1;
			$errorMessage = 'Missing parameter ...';
			break;
		}
		//instanciate module
		$cms_module = CMS_modulesCatalog::getByCodename($_GET['mod']);
		if (!is_object($cms_module) || $cms_module->hasError()) {
			$error = 1;
			$errorMessage = 'Unknown module codename : '.$_GET['mod'];
			break;
		}
		//instanciate user/group
		if (sensitiveIO::isPositiveInteger($_GET['group'])) {
			$group = CMS_profile_usersGroupsCatalog::getById($_GET['group']);
			if (!is_object($group) || $group->hasError()) {
				$error = 1;
				$errorMessage = 'Unknown group ID : '.$_GET['group'];
				break;
			}
		} elseif (sensitiveIO::isPositiveInteger($_GET['user'])) {
			$user = CMS_profile_usersCatalog::getById($_GET['user']);
			if (!is_object($user) || $user->hasError()) {
				$error = 1;
				$errorMessage = 'Unknown user ID : '.$_GET['user'];
				break;
			}
		} else {
			$error = 1;
			$errorMessage = 'Incorrect user or group parameter ...';
			break;
		}
		if ($cms_module->getCodename() != MOD_STANDARD_CODENAME) {
			// All clearances to assign to user/group (static)
			$modulesClearances = CMS_Profile::getAllModuleCategoriesClearances();
			// Current user/group clearances
			if (is_object($group)) {
				$stackClearances = $group->getModuleCategoriesClearancesStack();
			} elseif (is_object($user)) {
				$stackClearances = $user->getModuleCategoriesClearancesStack();
			}
		} else {
			// All clearances to assign to user/group (static)
			$modulesClearances = CMS_Profile::getAllPageClearances();
			// Current user/group clearances
			if (is_object($group)) {
				$stackClearances = $group->getPageClearances();
			} elseif (is_object($user)) {
				$stackClearances = $user->getPageClearances();
			}
		}
		// Clearances
		$rights = explode(';',$_GET["rights"]);
		$clearances = array();
		foreach ($rights as $right) {
			list($id, $clr) = explode(',',$right);
			$clearances[$id] = $clr;
		}
		// IDs
		$ids = explode(',',$_GET["ids"]);
		//set clearance stack
		if ($ids) {
			foreach ($ids as $id) {
				$stackClearances->delAllWithOneKey($id);
				if (isset($clearances[$id])) {
					$clr = (int) $clearances[$id];
					if (in_array($clr,$modulesClearances)) {
						$stackClearances->add($id, $clr);
					}
				}
			}
		}
		//set new clearances to user/group
		if (is_object($group)) {
			if ($cms_module->getCodename() != MOD_STANDARD_CODENAME) {
				$group->setModuleCategoriesClearancesStack($stackClearances);
			} else {
				$group->setPageClearances($stackClearances);
			}
			if ($group->writeToPersistence()) {
				$group->applyToUsers();
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT, $cms_user, "Group : ".$group->getLabel(). "(Page clearances)");
			} else {
				$error = 1;
				$errorMessage ='Error for writetoPersistence ...';
				break;
			}
		} elseif (is_object($user)) {
			if ($cms_module->getCodename() != MOD_STANDARD_CODENAME) {
				$user->setModuleCategoriesClearancesStack($stackClearances);
			} else {
				$user->setPageClearances($stackClearances);
			}
			if ($user->writeToPersistence()) {
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_PROFILE_USER_EDIT, $cms_user, "User : ".$user->getFirstName()." ".$user->getLastName(). " (Page clearances)");
			} else {
				$error = 1;
				$errorMessage ='Error for writetoPersistence ...';
				break;
			}
		}
	break;
	// ****************************************************************
	// ** DEFAULT (UNKOWN) ACTION                                    **
	// ****************************************************************
	default:
		$error = 1;
		$errorMessage = 'Unkown action : '.htmlspecialchars($_GET["cms_action"]);
	break;
}

//Return content.
if ($contentType == 'xml') {
	//set header content-type
	header("Content-Type: text/xml");
	if ($error) {
		$grandFather = new CMS_grandFather();
		$grandFather->setDebug(false);
		$grandFather->raiseError('Ajax server response : '.$errorMessage);
		$errorMessage = htmlspecialchars(CMS_grandFather::SYSTEM_LABEL.' '.AUTOMNE_VERSION.' error : '.$errorMessage);
	}
	$response = 
	'<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>'."\n".
	'<response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'."\n".
	'	<error>'.htmlspecialchars($error).'</error>'."\n".
	'	<errormessage>'.$errorMessage.'</errormessage>'."\n".
	(($content) ? '	'.$content."\n" : '').
	'</response>';
} else {
	$response = $content;
}
echo $response;
?>