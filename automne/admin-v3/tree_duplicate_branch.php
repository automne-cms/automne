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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: tree_duplicate_branch.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : tree_duplicate_branch
  * 
  * Allows duplication of a tree branch of main website
  * Excepted the whole website
  * 
  * Actions:
  * 1. Choose start of tree duplication in "tree.php" page
  * 2. Choose destination page in "tree.php" page
  * 3. Determine templates replacements from page copied to those created
  * 4. A check is done with a report upon templates compatibility
  * 5. finally proceed with duplication.
  * 
  * GET parameters : 
  * - cms_action, action to perform in current page from start to end
  *       . tree_duplication_start_page
  *       . tree_duplication_end_page
  *       . tree_duplication_templates_correspondance
  *       . tree_duplication_templates_correspondance_checks
  *       . tree_duplication_do
  * - duplicationNodeFrom as an integer, node of first page of tree branch to copy
  * - duplicationNodeTo as an integer, node of page receiving tree branch copy
  * - templatesReplacements as an array or integers
  * 
  * @package CMS
  * @subpackage admin
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//Messages from standard module
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_TITLE", 975);								//Copie de branche d'arborescence
define("MESSAGE_PAGE_SUBTITLE_REPLACETEMPLATES", 1001);			//Substitution de modèles
define("MESSAGE_PAGE_SUBTITLE_COMPARE", 1003);					//From template "%s" to "%s"
define("MESSAGE_PAGE_FIELD_COMPARE", 997);						//Comparaison des modèles
define("MESSAGE_PAGE_FIELD_STATUS", 160);						//Statut
define("MESSAGE_PAGE_FIELD_CLIENTSPACES", 829);					//Espaces client
define("MESSAGE_PAGE_FIELD_MODULES", 999);						//Modules
define("MESSAGE_PAGE_FIELD_ROWS", 1000);						//Rangées
define("MESSAGE_PAGE_FIELD_USABILITY", 998);					//Modèle inutilisable
define("MESSAGE_PAGE_HEADING1", 976);							//Sélectionnez la première page de la branche à copier (Elle sera copiée elle_même).
define("MESSAGE_PAGE_HEADING2", 977);							//Sélectionnez la page recevant la copie de la branche sélctionnée comme enfant
define("MESSAGE_PAGE_HEADING3", 978);							//Les pages sélectionnées pour la duplication d'arborescence semblent incorrectes
define("MESSAGE_PAGE_HEADING4", 979);							//Les pages on été créées. Vérifiez l'arborescence créée
define("MESSAGE_PAGE_HEADING5", 980);							//Sélectionnez les modèles de remplacement des pages ...
define("MESSAGE_PAGE_HEADING6", 981);							//Le modèle <b>%s</b> est remplacé par
define("MESSAGE_PAGE_HEADING7", 991);							//Vérifiez la correspondance des rangées de contenus des modèles ...
define("MESSAGE_PAGE_ERROR_UNACTIVE", 992);						//Un des modèles n'est pas actif
define("MESSAGE_PAGE_ERROR_MODULES_UNEQUALS", 993);				//Les modèles ne font pas appel aux mêmes modules
define("MESSAGE_PAGE_ERROR_CLIENTSPACES_UNEQUALS", 994);		//les espaces clients ne correspondent pas entre les modèles
define("MESSAGE_PAGE_CONFIRM_NOREPLACES", 1004);				//Assuming pages will be created with same template
define("MESSAGE_PAGE_CONFIRM_TEMPLATES_IDENTICALS", 995);		//Templates absolutely identical
define("MESSAGE_PAGE_CONFIRM_TEMPLATES_UNIDENTICALS", 1002);	//Templates absolutely not identical
define("MESSAGE_PAGE_ERROR_ROWS_UNEQUALS", 996);				//les rangées de contenus ne correspondent pas entre les modèles

//Checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

//Dialog
$dialog = new CMS_dialog();

//Title
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));

//Actions
switch ($_GET["cms_action"]) {
case "tree_duplication_do":
	//Proceeds with tree duplication
	//First node page
	$pageToDuplicate = CMS_tree::getPageByID($_GET["duplicationNodeFrom"]);
	//First destination page
	$pageToAttachTo = CMS_tree::getPageByID($_GET["duplicationNodeTo"]);
	
	$pageDuplicated = array();
	//Do recursivly
	duplicatePage($cms_user, $pageToDuplicate, $pageToAttachTo) ;
	
	//Message
	header('Location:entry.php?cms_message='.urlencode($cms_language->getMessage(MESSAGE_PAGE_HEADING4))."&".session_name()."=".session_id());
	exit;
	break;
//Get end of tree branch
case "tree_duplication_end_page":
	$_linkToTreePage = 'tree.php?'.
				'root=1'.
				'&encodedPageLink='.base64_encode (
										$_SERVER["SCRIPT_NAME"].'?cms_action=tree_duplication_do'.
										'&duplicationNodeFrom='.SensitiveIO::sanitizeAsciiString($_GET["duplicationNodeFrom"]).
										'&duplicationNodeTo=%s'
										).
				'&pageProperty='.
				'&title='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TITLE)).
				'&heading='.urlencode($cms_language->getMessage(MESSAGE_PAGE_HEADING2)).
				'&hideMenu=' ;
				if (SensitiveIO::isPositiveInteger($_GET["duplicationNodeFrom"]) && $_GET["duplicationNodeFrom"]>APPLICATION_ROOT_PAGE_ID) {
		//Uses tree.php as an interface
		header("Location: ".$_linkToTreePage."&".session_name()."=".session_id());
		exit;
	}
	break;
case "tree_duplication_start_page":
default:
	$_linkToTreePage = 'tree.php?'.
				'root=1'.
				'&encodedPageLink='.base64_encode(
										$_SERVER["SCRIPT_NAME"].'?cms_action=tree_duplication_end_page'.
										'&duplicationNodeFrom=%s'.
										'&duplicationNodeTo='.SensitiveIO::sanitizeAsciiString($_GET["duplicationNodeTo"])
										).
				'&pageProperty='.
				'&title='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TITLE)).
				'&heading='.urlencode($cms_language->getMessage(MESSAGE_PAGE_HEADING1)).
				'&hideMenu=' ;
	//Uses tree.php as an interface
	header("Location: ".$_linkToTreePage."&".session_name()."=".session_id());
	exit;
	break;
}

//Message if any
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$dialog->setContent($content);
$dialog->show();









//Function recursive
//To obtain template ID in the whole tree branch to duplicate
function getTemplateID(&$user, $page, &$templatesIdsFrom)
{
	//Adds template to array
	$tpl = $page->getTemplate();
	if (!in_array($tpl->getID(), $templatesIdsFrom)) {
		$templatesIdsFrom[] = $tpl->getID();
	}
	
	$sibs = CMS_tree::getSiblings($page);
	if (!$sibs || !sizeof($sibs)) {
		return $templatesIdsFrom;
	}
	foreach ($sibs as $sib) {
		if ($user->hasPageClearance($sib->getID(), CLEARANCE_PAGE_VIEW)) {
			getTemplateID($user, $sib, $templatesIdsFrom);
		}
	}
}

//Function recursive
//To obtain template ID in the whole tree branch to duplicate

function duplicatePage(&$user, $page, &$pageToAttachTo)
{
	global $pageDuplicated;
	
	if (is_a($page, "CMS_page") && is_a($pageToAttachTo, "CMS_page") && $page->getTemplate()) {
		//Duplicate page template
		$tpl = $page->getTemplate();
		$tpl_copy = CMS_pageTemplatesCatalog::getCloneFromID($tpl->getID(), false, true, false, $tpl->getID());
		$_tplID = $tpl_copy->getID();
		//Create copy of given page
		$newPage = $page->duplicate($user, $_tplID) ;
		//Move to destination in tree
		if (is_null($newPage) || !CMS_tree::attachPageToTree($newPage, $pageToAttachTo) ) {
			return null;
		}
		
		$pageDuplicated[] = $newPage->getID();
		
		//Proceed with siblings
		$sibs = CMS_tree::getSiblings($page);
		if (!$sibs || !sizeof($sibs)) {
			return $pageToAttachTo;
		} else {
			$pageToAttachTo = &$newPage ;
		}
		foreach ($sibs as $sib) {
			if ($user->hasPageClearance($sib->getID(), CLEARANCE_PAGE_EDIT) && !in_array($sib->getID(),$pageDuplicated)) {
				duplicatePage($user, $sib, $pageToAttachTo);
			}
		}
	}
}

?>