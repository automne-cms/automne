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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr> &              |
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: page_copy.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page_copy
  * 
  * Allows copy of a page in a very similar way to the duplication of a tree
  * branch (page tree_duplicate_branch.php)
  * 
  * Actions:
  * 1. Choose user's section where the copied page will stay
  * 2. Choose destination page in "tree.php" page
  * 3. Determine templates replacement from page copied to the created
  * 4. A check is done with a report on templates compatibility
  * 5. finally proceed with duplication.
  * 
  * GET parameters : 
  * - cms_action, action to perform in current page from start to end
  *       . pc_select_section
  *       . pc_templates_correspondance
  *       . pc_templates_correspondance_checks
  *       . pc_do
  * - duplicationNodeFrom as an integer, id of the page to copy
  * - duplicationNodeTo as an integer, id of the father of the new page
  * - templatesReplacements as an array or integers
  * 
  * @package CMS
  * @subpackage admin
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//Messages from standard module
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_TITLE", 1048);
define("MESSAGE_PAGE_COPY_DATA", 1050);			//Substitution de modèles
define("MESSAGE_PAGE_SUBTITLE_CONFIRM", 1004);
define("MESSAGE_PAGE_PAGE_FROM", 992);
define("MESSAGE_PAGE_PAGE_TO", 993);
define("MESSAGE_PAGE_SUBTITLE_COMPARE", 1003);					//From template "%s" to "%s"
define("MESSAGE_PAGE_FIELD_COMPARE", 997);						//Comparaison des modèles
define("MESSAGE_PAGE_FIELD_STATUS", 160);						//Statut
define("MESSAGE_PAGE_FIELD_CLIENTSPACES", 829);					//Espaces client
define("MESSAGE_PAGE_FIELD_MODULES", 999);						//Modules
define("MESSAGE_PAGE_FIELD_ROWS", 1000);						//Rangées
define("MESSAGE_PAGE_FIELD_USABILITY", 998);					//Modèle inutilisable
define("MESSAGE_PAGE_HEADING1", 1049);							//Sélectionnez la première page de la branche à copier (Elle sera copiée elle_même).
define("MESSAGE_PAGE_HEADING2", 977);							//Sélectionnez la page recevant la copie de la branche sélctionnée comme enfant
define("MESSAGE_PAGE_HEADING3", 978);							//Les pages sélectionnées pour la duplication d'arborescence semblent incorrectes
define("MESSAGE_PAGE_HEADING4", 979);							//Les pages on été créées. Vérifiez l'arborescence créée
define("MESSAGE_PAGE_HEADING6", 981);							//Le modèle <b>%s</b> est remplacé par
define("MESSAGE_PAGE_HEADING7", 991);							//Vérifiez la correspondance des rangées de contenus des modèles ...
define("MESSAGE_PAGE_ERROR_CLIENTSPACES_UNEQUALS", 994);		//les espaces clients ne correspondent pas entre les modèles
define("MESSAGE_PAGE_CONFIRM_TEMPLATES_IDENTICALS", 995);		//Templates absolutely identical
define("MESSAGE_PAGE_CONFIRM_TEMPLATES_UNIDENTICALS", 1002);	//Templates absolutely not identical
define("MESSAGE_PAGE_ERROR_ROWS_UNEQUALS", 996);				//les rangées de contenus ne correspondent pas entre les modèles
define("MESSAGE_PAGE_SECTIONS_CHOOSE", 1047);
define("MESSAGE_PAGE_REPLACE_TEMPLATE", 1095);
define("MESSAGE_PAGE_NO_TEMPLATE_MATCH", 1096);


//Checks page from
if (!$cms_user->hasPageClearance($_REQUEST["duplicationNodeFrom"], CLEARANCE_PAGE_VIEW)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

//Checks page to
if ($_REQUEST["duplicationNodeTo"] && !$cms_user->hasPageClearance($_REQUEST["duplicationNodeTo"], CLEARANCE_PAGE_EDIT)) {
	header("Location: ".$_SERVER["SCRIPT_NAME"]."?cms_action=pc_select_section&duplicationNodeFrom=".$_REQUEST["duplicationNodeFrom"]."&cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

//Dialog
$dialog = new CMS_dialog();

//Title
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));

//Actions
switch ($_GET["cms_action"]) {
case "pc_do":
	//Proceeds with tree duplication
	//First node page
	$pageToDuplicate = CMS_tree::getPageByID($_GET["duplicationNodeFrom"]);
	//First destination page
	$pageToAttachTo = CMS_tree::getPageByID($_GET["duplicationNodeTo"]);
	//duplicate template
	$originalTemplate = $pageToDuplicate->getTemplate();
	if (!$_GET["replaceTpl"]) {
		$tpl_original = $pageToDuplicate->getTemplate();
		$tpl_copy = CMS_pageTemplatesCatalog::getCloneFromID($tpl_original->getID(), false, true, false, $originalTemplate->getID());
	} else {
		$tpl = new CMS_pageTemplate($_GET["templateReplacement"]);
		$tpl_copy = CMS_pageTemplatesCatalog::getCloneFromID($tpl->getID(), false, true, false, $originalTemplate->getID());
	}
	
	//Do recursivly
	$newPageID = duplicatePage($cms_user, $pageToDuplicate, $pageToAttachTo, $tpl_copy->getID(), $_GET["copydata"]) ;
	//Message
	if ($newPageID) {
		header('Location:'.PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR . '?page='.$newPageID.'&cms_message='.urlencode($cms_language->getMessage(MESSAGE_PAGE_HEADING4))."&".session_name()."=".session_id());
	} else {
		header('Location:entry.php?cms_message='.urlencode($cms_language->getMessage(MESSAGE_PAGE_HEADING4))."&".session_name()."=".session_id());
	}
	exit;
	break;
case "pc_select_content":
	$dialog->setBackLink(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR . "?page=" . $_GET["duplicationNodeFrom"]);
	if (SensitiveIO::isPositiveInteger($_GET["duplicationNodeFrom"])
			&& SensitiveIO::isPositiveInteger($_GET["duplicationNodeTo"])) {
		
		//check all templates from catalog and select wich are useable for replacement
		
		//the tplFrom
		$startPage = CMS_tree::getPageByID($_GET["duplicationNodeFrom"]);
		$tplFrom = $startPage->getTemplate();
		
		//All templates avalaibles for this user
		$templatesReplacements = CMS_pageTemplatesCatalog::getAll();
		$useableTpl = array();
		
		//modules called in tplFrom
		$tplFromModules = $tplFrom->getModules();
		
		//clientSpaces in tplFrom
		//Variable de stockage pour facilité de lecture : array('id' => 'module');
		$oldClientSpaces = array();
		foreach ($tplFrom->getClientSpacesTags() as $tag) {
			$id = ($tag->getAttribute("id")!='') ? $tag->getAttribute("id") : 'NO ID';
			$oldClientSpacesLabels[] = 'id: '.$tag->getAttribute("id").', module: '.$tag->getAttribute("module");
			$oldClientSpaces[] = array($id => $tag->getAttribute("module"));
		}
		ksort($oldClientSpaces);
		
		foreach ($templatesReplacements as $tplTo) {
			
			//remove the same tpl
			if ($tplFrom->getDefinitionFile()!=$tplTo->getDefinitionFile()) {
				
				//remove templates wich not use same modules
				$tplToModules = $tplTo->getModules();
				if ($tplToModules==$tplFromModules) {
					
					//remove templates wich not have same ClientSpaces
					$newClientSpaces = array();
					foreach ($tplTo->getClientSpacesTags() as $tag) {
						$id = ($tag->getAttribute("id")!='') ? $tag->getAttribute("id") : 'NO ID';
						$newClientSpacesLabels[] = 'id: '.$tag->getAttribute("id").', module: '.$tag->getAttribute("module");
						$newClientSpaces[] = array($id => $tag->getAttribute("module"));
					}
					ksort($newClientSpaces);
					if ($oldClientSpaces == $newClientSpaces) {
						
						//here templates are repleceable so add it to the array
						$useableTpl[]=$tplTo;
					}
				}
			}
		}
		
		$from = CMS_tree::getPageByID($_GET["duplicationNodeFrom"]);		
		$to = CMS_tree::getPageByID($_GET["duplicationNodeTo"]);		
				
		//Ask the user if he wants to copy the content or not
		$content .= '
			<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE_CONFIRM).'</dialog-title>
			<br />
			<strong>' . $cms_language->getMessage(MESSAGE_PAGE_PAGE_FROM) . '</strong> : ' . $from->getTitle() . '<br />
			<strong>' . $cms_language->getMessage(MESSAGE_PAGE_PAGE_TO) . '</strong> : ' . $to->getTitle() . '
			
			<form action="'.$_SERVER["SCRIPT_NAME"].'" method="GET">
			<input type="hidden" name="cms_action" value="pc_do" />
			<input type="hidden" name="duplicationNodeFrom" value="'.$_GET["duplicationNodeFrom"].'" />
			<input type="hidden" name="duplicationNodeTo" value="'.$_GET["duplicationNodeTo"].'" />';
			if (sizeof($useableTpl)) {
				$content .='
				<input type="checkbox" name="replaceTpl" value="1" /><strong> ' . $cms_language->getMessage(MESSAGE_PAGE_REPLACE_TEMPLATE) . '</strong>&nbsp;
				<select name="templateReplacement" size="1" class="admin_input_text">';
				foreach ($useableTpl as $aUseableTpl) {
					$content .= '
						<option value="'.$aUseableTpl->getID().'">'.$aUseableTpl->getLabel().'</option>';
				}
				$content .= '
				</select>
				';
			} else {
				$content .= nl2br($cms_language->getMessage(MESSAGE_PAGE_NO_TEMPLATE_MATCH));
			}
		$content .='<br /><br />
			<input type="checkbox" name="copydata" value="1" checked="checked" /><strong> ' . $cms_language->getMessage(MESSAGE_PAGE_COPY_DATA) . '</strong>
			<br /><br /><input type="submit" name="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" />
			</form>
		';
	} else {
		//Message
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_HEADING3);
	}
	break;
case "pc_select_section":
default:
	//Back link
	$dialog->setBackLink(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR . "?page=" . $_GET["duplicationNodeFrom"]);
	
	$sections_roots = $cms_user->getEditablePageClearanceRoots();
	$sections = array();
	foreach ($sections_roots as $rootID) {
		$pg = CMS_tree::getPageByID($rootID);
		if ($pg && !$pg->hasError()) {
			$sections[] = $pg;
		}
	}
	
	$content .= '
		<div class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_SECTIONS_CHOOSE).'</div>
		<ul type="disc" class="admin">
	';
	foreach ($sections as $section_root) {
		//build tree link
		$href = PATH_ADMIN_SPECIAL_TREE_WR;
		$href .= '?root='.$section_root->getID();
		$href .= '&title='.urlencode($cms_language->getMessage(MESSAGE_PAGE_TITLE));
		$href .= '&heading='.urlencode($cms_language->getMessage(MESSAGE_PAGE_HEADING1));
		//$href .= '&pageLink='.urlencode($_SERVER["SCRIPT_NAME"].'?cms_action=pc_select_content&duplicationNodeTo=%s&duplicationNodeFrom=' . $_GET["duplicationNodeFrom"]);
		$href .= '&encodedPageLink='.base64_encode($_SERVER["SCRIPT_NAME"].'?cms_action=pc_select_content&duplicationNodeTo=%s&duplicationNodeFrom=' . $_GET["duplicationNodeFrom"]);
		$href .= '&backLink='.urlencode($_SERVER["SCRIPT_NAME"]."?cms_action=pc_select_section&duplicationNodeFrom=" . $_GET["duplicationNodeFrom"]);
		$content .= '
			<li class="admin">
				<a href="'.$href.'" class="admin">
				'.htmlspecialchars($section_root->getTitle()).'</a>
			</li>
		' ;
	}
	$content .= '</ul><br />';
	break;
}

//Back link
if (!$dialog->getBackLink()) {
	$dialog->setBackLink("meta_admin.php");
}

//Message if any
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$dialog->setContent($content);
$dialog->show();

function getTemplateID($page)
{
	$tpl = $page->getTemplate();
	return $tpl->getID();
}



//Function recursive
//To obtain template ID in the whole tree branch to duplicate
function duplicatePage(&$user, $page, &$pageToAttachTo, $templateReplacement, $duplicateContent)
{
	if (is_a($page, "CMS_page") && is_a($pageToAttachTo, "CMS_page")) {
		//Replaces page current template with the one selected
		$_tplID = $templateReplacement;
		//Create copy of given page
		$newPage = $page->duplicate($user, $_tplID, !$duplicateContent) ;
		//Move to destination in tree
		if (is_null($newPage) || !CMS_tree::attachPageToTree($newPage, $pageToAttachTo) ) {
			return null;
		} else {
			return $newPage->getID();
		}
	}
}

?>