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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: tree.php,v 1.2 2010/03/08 16:41:41 sebastien Exp $

/**
  * PHP page : tree
  * Multi-purpose page : presents a portion of the pages tree. Can be used by any admin page.
  * GET parameters : 
  * - root : DB ID of the tree root page (MANDATORY)
  * - backLink : the back link
  * - pageLink : string, will be the link the pages will have. May contain a '%s' which will be replaced by the page DB ID. If not defined, no link on pages
  * - encodedPageLink : same as pageLink but base64 encoded (default)
  * - encodedOnClick : add javascript action on click on a page
  * - pageProperty : string, a page property which will be displayed along the page title. 
  * - title : the title of this page
  * - heading : the heading text of this page
  * - hideMenu : if true, the menu will not be shown
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//default title and heading if not passed in GET
define("MESSAGE_PAGE_TITLE", 62);
define("MESSAGE_PAGE_HEADING", 63);
define("MESSAGE_PAGE_LEVEL", 230);

//GET arguments checks
if (isset($_GET["loadFromContext"]) && $_GET["loadFromContext"]=='1') {
	//load context info
	if ($cms_context->getPage()) {
		$currentContextPage = $cms_context->getPage();
		$startRoot = $currentContextPage->getID();
		$pageLink = PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.chr(167).chr(167).'page=%s';
		$frame = 1;
	} elseif ($cms_context->getSessionVar('treeHref')) {
		//redirect to this page with good infos from starting context
		header ("Location: ".$cms_context->getSessionVar('treeHref').'&'.session_name().'='.session_id());
		exit;
	} elseif($cms_context->getSessionVar('hauteurArbo') != '0') {
		//lost sessions info, need to reload all
		//so create a new dialog only to reload all frames.
		$dialog = new CMS_dialog();
		$dialog->reloadAll();
		$dialog->show();
		exit;
	}
} else {
	//save context info
	$startRoot = $_GET["root"];
	$hideMenu = $_GET["hideMenu"];
	$pageProperty = $_GET["pageProperty"];
	$title = $_GET["title"];
	$backLink = $_GET["backLink"];
	$pageLink = ($_GET["encodedPageLink"]) ? base64_decode($_GET["encodedPageLink"]):$_GET["pageLink"];
	$heading = $_GET["heading"];
	$frame = $_GET["frame"];
	if ($pageLink=='false' && $_GET["encodedOnClick"]) {
		$onClick = base64_decode($_GET["encodedOnClick"]);
	}
}

$linkTarget = '_self';//($_GET["linkTarget"]) ? $_GET["linkTarget"]:"main";

//root : Must be set
if (!$startRoot) {
	die("Tree : root page not defined");
}

//pageProperty : must be inside the page_properties array
$page_properties = array("last_creation_date", "template");
if ($pageProperty && !SensitiveIO::isInSet($pageProperty, $page_properties)) {
	die("Tree : unknown page property");
}

$dialog = new CMS_dialog();

if ($hideMenu) {
	$dialog->setMenu(false);
}

//add title
$title = ($title) ? SensitiveIO::sanitizeHTMLString($title) : $cms_language->getMessage(MESSAGE_PAGE_TITLE);
$pageTitle = ($frame && !$onClick) ? '<a href="'.$cms_context->getSessionVar('treeHref').'" target="_self" class="admin_frame">'.$title.'</a>':$title;
$dialog->setTitle($pageTitle);
$dialog->changeColor();
//add message if any
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

//add back link
if ($backLink) {
	//links are coded in query string and so ? are replaced by §§ and ampersands are replaced with § to avoid confusion
	$bl = str_replace(chr(167).chr(167), "?", $backLink);
	$bl = str_replace(chr(167), "&", $bl);
	$dialog->setBackLink(SensitiveIO::sanitizeHTMLString($bl));
}

//first make a diff beetween current queried Root and all user sections to see wich sections missing.
$getRoot = array($startRoot);
$displayed=array();
$cms_root=CMS_tree::getRoot();
$sectionsRoots = $cms_context->getSessionVar('sectionsRoots');

foreach ($getRoot as $aRootID) {
	if ($pages[$aRootID]) {
		$treeRoot = $pages[$aRootID];
	} else {
		$treeRoot = CMS_tree::getPageByID($aRootID);
		$pages[$aRootID]=$treeRoot;
	}
	if (!$treeRoot || $treeRoot->hasError()) {
		die("Unknown tree root to display ...");
	}
	$lineages[$aRootID]=CMS_tree::getLineage($cms_root->getID(),$treeRoot->getID(),false);
	if (is_array($sectionsRoots)) {
		foreach ($lineages[$aRootID] as $aLineagePage) {
			if (in_array($aLineagePage,$sectionsRoots)) {
				//remove this section to all user sections
				$sectionsRoots = array_diff ($sectionsRoots, array($aLineagePage));
			}
		}
	}
}
if (is_array($sectionsRoots)) {
	//add missing sections to Root array
	foreach ($sectionsRoots as $aSectionRoot) {
		$getRoot[]=$aSectionRoot;
	}
}
//sort all tree Root
//in lot of case this sorting is buggy, but I leave it in comment for the day I can see a case who is usefull...
//sort($getRoot);

//remove double
$getRoot = array_unique($getRoot);

if ($heading) {
	$content .= '<div class="admin">'.urldecode($heading).'</div><br />';
}

//then display all Trees (queried Root and other user sections)
$content .= '<table border="0" cellpadding="2" cellspacing="0">';
foreach ($getRoot as $aRootID) {
	if ($pages[$aRootID]) {
		$treeRoot = $pages[$aRootID];
	} else {
		$treeRoot = CMS_tree::getPageByID($aRootID);
		$pages[$aRootID]=$treeRoot;
	}
	
	$pl = SensitiveIO::sanitizeHTMLString($pageLink);
	$pl = str_replace(chr(167).chr(167), "?", $pl);
	$pl = str_replace(chr(167), "&amp;", $pl);
	
	$lineage = (is_array($lineages[$aRootID])) ? $lineages[$aRootID]:CMS_tree::getLineage($cms_root->getID(),$treeRoot->getID(),false);
	
	$grand_grand_father=CMS_tree::getAncestor($treeRoot,'3',false);
	$grand_father=CMS_tree::getAncestor($treeRoot,'2',false);
	$father=CMS_tree::getAncestor($treeRoot,'1',false);
	
	if ($grand_grand_father && $cms_user->hasPageClearance($grand_grand_father->getID(), CLEARANCE_PAGE_VIEW)) {
		$brothers = CMS_tree::getSiblings($grand_grand_father,'0');
	} elseif ($grand_father && $cms_user->hasPageClearance($grand_father->getID(), CLEARANCE_PAGE_VIEW)) {
		$brothers = array($grand_father);
	} elseif ($father && $cms_user->hasPageClearance($father->getID(), CLEARANCE_PAGE_VIEW)) {
		$brothers = array($father);
	} else {
		$brothers = array($treeRoot);
	}
	foreach ($brothers as $aBrother) {
		if ($cms_user->hasPageClearance($aBrother->getID(), CLEARANCE_PAGE_VIEW)) {
			if (!in_array($aBrother->getID(),$displayed)) {
				$displayed[]=$aBrother->getID();
				getBigTree($cms_user, $content, $aBrother, '0', $pl, $pageProperty, false);
			}
		}
	}
}
$content .= "</table>";

$dialog->setContent($content);
if ($frame) {
	$dialog->show('arbo');
} else {
	$dialog->show();
}

//recursive function : add the line HTML to $lines
function getBigTree(&$user, &$lines, $page, $offset, $link, $pageProperty = false, $father) {
	global $cms_language;
	global $hideMenu;
	global $pageProperty;
	global $title;
	global $backLink;
	global $pageLink;
	global $onClick;
	global $heading;
	global $frame;
	global $lineage;
	global $startRoot;
	global $linkTarget;
	global $cms_user;
	static $haveRootInDisplay;
	
	if (!$father) {
		$father=$page;
	}
	
	$stop='1';
	$sign='plus';
	
	//get siblings
	$sibs = CMS_tree::getSiblings($page,false,false);
	
	//si pas de fils :
	// => on affiche aucun signe
	// => on sort
	if (!$sibs || !sizeof($sibs)) {
		$sign='';
	} elseif (in_array($page->getID(),$lineage)) {
		$stop='0';
		$sign='minus';
	}
	$status = $page->getStatus();
	if ($link && strpos($link, "%s") !== false) {
		$link_final = sprintf($link, $page->getID());
	} elseif ($link=='false' && $onClick) {
		$link_final="#";
		$link_onClick = ' onClick="'.sprintf($onClick, $page->getID()).'return false;"';
		$linkTarget="_self";
	} else  {
		$link_final = $link;
	}
	
	$pageTitle = (PAGE_LINK_NAME_IN_TREE) ? $page->getLinkTitle():$page->getTitle();
	
	if ($link_final) {
		$link_final = '<a href="' .$link_final. '"'.$link_onClick.' name="n' .$page->getID(). '" target="'.$linkTarget.'" class="admin_tree_page">' .htmlspecialchars($pageTitle). '</a>';
	} else {
		$link_final = htmlspecialchars($pageTitle);
	}
	
	//page cell display
	$cell_display = '<a name="page_'.$page->getID().'"></a>
		<table border="0" cellpadding="2" cellspacing="0">
		<tr>';
		
	$size="0";
	for ($i = 0 ; $i < $offset ; $i++) {
		$size=$size+20;
	}
	if ($page->getID()==APPLICATION_ROOT_PAGE_ID || $haveRootInDisplay) {
		$size=$size-20;
		$haveRootInDisplay=true;
	}
	
	if ($size>0) {
		$cell_display .='<td width="1"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="'.$size.'" height="2" border="0" /></td>';
	}
	switch ($sign) {
		case '':
			$cell_display .='<td width="20"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="20" height="2" border="0" /></td>';
		break;
		case 'minus':
			if ($page->getID()!=APPLICATION_ROOT_PAGE_ID) {
				$cell_display .='<td width="20" align="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="20" height="1" border="0" /><br /><a href="'.$_SERVER["SCRIPT_NAME"].'?root='.$father->getID().'&pageProperty='.$pageProperty.'&hideMenu='.$hideMenu.'&title='.$title.'&backLink='.$backLink.'&frame='.$frame.'&heading='.$heading.'&encodedPageLink='.base64_encode($pageLink).'&encodedOnClick='.base64_encode($onClick).'&linkTarget='.$linkTarget.'#page_'.$page->getID().'" class="admin_tree_sign">-</a></td>';
			}
		break;
		case 'plus':
			$cell_display .= '<td width="20" align="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="20" height="1" border="0" /><br /><a href="'.$_SERVER["SCRIPT_NAME"].'?root='.$page->getID().'&pageProperty='.$pageProperty.'&hideMenu='.$hideMenu.'&title='.$title.'&backLink='.$backLink.'&frame='.$frame.'&heading='.$heading.'&encodedPageLink='.base64_encode($pageLink).'&encodedOnClick='.base64_encode($onClick).'&linkTarget='.$linkTarget.'#page_'.$page->getID().'" class="admin_tree_sign">+</a></td>';
		break;
	}
	
	//property display
	if ($pageProperty) {
		switch ($pageProperty) {
		case "last_creation_date":
			$lng = $user->getLanguage();
			
			$date = $page->getLastFileCreationDate();
			if (is_a($date, "CMS_date")) {
				$date->setFormat($lng->getDateFormat());
				$property_display = $date->getLocalizedDate();
			}
			break;
		case "template":
			$tmp = $page->getTemplate();
			$property_display = (is_a($tmp, "CMS_pageTemplate")) ?  $tmp->getLabel() : '???';
			break;
		}
	} else {
		$property_display = $page->getID();
	}
	$cell_display .= '
			<td class="admin">' .$status->getHTML(true,$cms_user,MOD_STANDARD_CODENAME,$page->getID()). '</td>
			<td class="admin_tree_page" nowrap="nowrap">'.$link_final.' (' .$property_display. ')</td>
		</tr>
		</table>
	' ;
	
	$bgcolor= ($page->getID()==$startRoot) ? ' bgcolor="#DDDAD9"':'';
	
	//add the line
	$lines .= '<tr onMouseOver="changeColor(this,\'DDDAD9\');" onMouseOut="changeColor(this,\'\');">
			<td'.$bgcolor.' nowrap="nowrap">
				' .$cell_display. '
			</td>
		</tr>' . "\n";
	
	if ($stop) {
		return $lines;
	}
	
	//on traite les fils
	$sibs = CMS_tree::getSiblings($page);
	foreach ($sibs as $sib) {
		if ($user->hasPageClearance($sib->getID(), CLEARANCE_PAGE_VIEW)) {
			getBigTree($user, $lines, $sib, $offset + 1, $link, $pageProperty, $page);
		}
	}
}
?>