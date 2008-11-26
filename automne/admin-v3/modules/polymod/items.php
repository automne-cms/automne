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
// $Id: items.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : module polymod admin
  * Presents list of all items, through search process
  *
  * @package CMS
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

/**
  * Messages from standard module 
  */
define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_UNLOCK", 82);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_SHOW", 1006);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_ACTION_UNDELETE", 250);
define("MESSAGE_PAGE_ACTION_UNARCHIVE", 251);
define("MESSAGE_PAGE_ACTION_ARCHIVE", 253);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_ACTION_PREVISUALIZATION", 811);
define("MESSAGE_PAGE_ACTION_CHANGE", 820);
define("MESSAGE_PAGE_FIELD_STATUS", 256);
define("MESSAGE_PAGE_FIELD_TITLE", 257);
define("MESSAGE_PAGE_FIELD_PUBLICATION", 258);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_ACTION_EDIT", 12); //Editer
define("MESSAGE_PAGE_FIELD_LANGUAGE", 96); //Language
define("MESSAGE_PAGE_ACTION_DATE", 1284);
define("MESSAGE_PAGE_ACTION_PREVIZ", 811);

/**
  * Messages from this module 
  */
define("MESSAGE_PAGE_TITLE", 82);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 52);
define("MESSAGE_PAGE_ACTION_EMAIL_DELETE_SUBJECT", 53);
define("MESSAGE_PAGE_ACTION_EMAIL_DELETE_BODY", 55);
define("MESSAGE_PAGE_FIELD_KEYWORDS", 18);
define("MESSAGE_PAGE_FIELD_DATESEARCH_BETWEEN", 19);
define("MESSAGE_PAGE_FIELD_DATESEARCH_AND", 20);
define("MESSAGE_PAGE_SUBTITLE_DOCS_FOUNDED", 21);
define("MESSAGE_PAGE_FIELD_LABEL", 37);
define("MESSAGE_PAGE_FIELD_DOCUMENT", 30);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 39);
define("MESSAGE_PAGE_SUBTITLE_1", 66);
define("MESSAGE_PAGE_FIELD_WITHOUT_CATEGORIES", 258);

//get polymod codename
$polyModuleCodename = ($_REQUEST["polymod"]) ? $_REQUEST["polymod"]:'';

//CHECK Module
if (!$polyModuleCodename) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_name());
	exit;
}

//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename($polyModuleCodename);

//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($polyModuleCodename, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_name());
	exit;
}

// Useful date mask
$date_mask = $cms_language->getDateFormatMask(); 	// jj/mm/AAAA
$date_format = $cms_language->getDateFormat(); 		// d/m/Y

// +----------------------------------------------------------------------+
// | Session management                                                   |
// +----------------------------------------------------------------------+

// Page management
if ($_GET["records_per_page"]) {
	$_SESSION["cms_context"]->setRecordsPerPage($_GET["records_per_page"]);
}
if ($_GET["bookmark"]) {
	$_SESSION["cms_context"]->setBookmark($_GET["bookmark"]);
}
// Get a message to print from URL
if (SensitiveIO::isPositiveInteger($_GET["cms_message_module_id"])) {
	$cms_message .= $cms_language->getMessage(SensitiveIO::sanitizeAsciiString($_GET["cms_message_module_id"]), false, MOD_POLYMOD_CODENAME);
}

//load current object definition
$object = new CMS_poly_object_definition(($_REQUEST["object"]) ? $_REQUEST["object"]:'');

//load fields objects for object
$objectFields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());

//
// Get default search options
//
// Date start, if no date given ever, use one month ago
if (is_null($_SESSION["cms_context"]->getSessionVar("items_dtfrm"))) {
	$one_year_ago = date($date_format, mktime(0, 0, 0, date('m'), date('d'), date('Y') - 1));
	$_SESSION["cms_context"]->setSessionVar("items_dtfrm", $one_year_ago);
}

// Get search options from posted datas
if ($_POST["cms_action"] == 'search') {
	//reset page number
	$_SESSION["cms_context"]->setBookmark(1);
	//add search options
	$_SESSION["cms_context"]->setSessionVar('items_'.$object->getID().'_kwrds', $_POST['items_'.$object->getID().'_kwrds']);
	$_SESSION["cms_context"]->setSessionVar("items_dtfrm", $_POST["items_dtfrm"]);
	$_SESSION["cms_context"]->setSessionVar("items_dtnd", $_POST["items_dtnd"]);
	//Add all subobjects to search if any
	foreach ($objectFields as $fieldID => $field) {
		if (isset($_POST['items_'.$object->getID().'_'.$fieldID])) {
			$_SESSION["cms_context"]->setSessionVar('items_'.$object->getID().'_'.$fieldID, $_POST['items_'.$object->getID().'_'.$fieldID]);
		}
	}
}


// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+

switch ($_POST["cms_action"]) {
case "delete":
	$item = CMS_polymod::getResourceByID($_POST["item"]);
	if ($item->delete()) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
	break;
case "undelete":
	$item = CMS_polymod::getResourceByID($_POST["item"]);
	$item->undelete();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
case "unlock":
	$item = CMS_polymod::getResourceByID($_POST["item"]);
	$item->unlock();
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	break;
}

//occasional unlocking
if ($_GET["item"]) {
	if ($object->isPrimaryResource()) {
		$itm = CMS_polymod::getResourceByID($_GET["item"]);
		if ($itm->getLock() == $cms_user->getUserID()) {
			$itm->unlock();
		}
	}
}

// +----------------------------------------------------------------------+
// | Build search                                                         |
// +----------------------------------------------------------------------+

//create search object for current object
$search = new CMS_object_search($object);

//if object is a primary resource
if ($object->isPrimaryResource()) {
	//Order
	$search->setAttribute('orderBy', 'publicationDateStart_rs desc,publicationDateEnd_rs desc, id_moo desc');
	
	// Param : Around publication date
	$dt_today = new CMS_date();
	$dt_today->setDebug(false);
	$dt_today->setNow();
	$dt_today->setFormat($date_format);
	
	$dt_from = new CMS_date();
	$dt_from->setDebug(false);
	$dt_from->setFormat($date_format);
	if ($dt_from->setLocalizedDate($_SESSION["cms_context"]->getSessionVar("items_dtfrm"),true)) {
		$search->addWhereCondition("publication date after", $dt_from);
	}
	
	$dt_end = new CMS_date();
	$dt_end->setDebug(false);
	$dt_end->setFormat($date_format);
	if ($dt_end->setLocalizedDate($_SESSION["cms_context"]->getSessionVar("items_dtnd"),true)) {
		// Check this date isn't greater than start date given
		if (!CMS_date::compare($dt_from, $dt_end, ">=")) {
			$search->addWhereCondition("publication date before", $dt_end);
		}
	}
}
//Add all subobjects to search if any
foreach ($objectFields as $fieldID => $field) {
	//if field is a poly object
	if ($_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_'.$fieldID) != '') {
		$search->addWhereCondition($fieldID, $_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_'.$fieldID));
	}
}
// Param : With keywords (this is best if it is done at last)
if ($_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_kwrds') != '') {
	$search->addWhereCondition("keywords", $_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_kwrds'));
}
// Params : paginate limit
$search->setAttribute('itemsPerPage', $_SESSION["cms_context"]->getRecordsPerPage());
$search->setAttribute('page', $_SESSION["cms_context"]->getBookmark() - 1);

// Params : order
//$search->addOrderCondition('publication date after','desc'); //test for sorting by publication date
$search->addOrderCondition('objectID','desc');

$items = $search->search();

// Vars for lists output purpose and pages display, see further
$records_count = $search->getNumRows();
$records_per_page = $_SESSION["cms_context"]->getRecordsPerPage();//30;//$cms_module->getParameters("items_per_page");
$bookmark = $_SESSION["cms_context"]->getBookmark();
$pages = $search->getMaxPages();


// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, array($object->getLabel($cms_language)), MOD_POLYMOD_CODENAME));
$dialog->setBacklink($cms_module->getAdminFrontendPath(PATH_RELATIVETO_WEBROOT));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
//add calendar & popup image javascripts
$dialog->addCalendar();
$dialog->addPopupImage();
//
// Search form
//
$content .= '
<fieldset style="width:500px;">
	<legend class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE_1, array($object->getLabel($cms_language)), MOD_POLYMOD_CODENAME).'</legend>

	<table width="100%" border="0" cellpadding="3" cellspacing="0">
	<form action="'.$_SERVER["SCRIPT_NAME"].'#results" method="post">
	<input type="hidden" name="cms_action" value="search" />
	<input type="hidden" name="bookmark" value="1" />
	<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
	<input type="hidden" name="object" value="'.$object->getID().'" />';

// Keywords
$content .= '
	<tr valign="top">
		<td class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_KEYWORDS, false, MOD_POLYMOD_CODENAME).'&nbsp;:</td>
		<td class="admin">
			<input type="text" name="items_'.$object->getID().'_kwrds" value="'.str_replace('"', '\"', $_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_kwrds')).'" class="admin_input_text" size="30" style="width:250px;" /></td>
	</tr>';

if ($object->isPrimaryResource()) {
	// Publication Dates
	$content .= '
		<tr valign="top">
			<td class="admin">'.htmlspecialchars($cms_language->getMessage(MESSAGE_PAGE_FIELD_DATESEARCH_BETWEEN, false, MOD_POLYMOD_CODENAME)).'<br />
					<small>('.$date_mask.')</small></td>
			<td class="admin">
				<input type="text" id="items_dtfrm" name="items_dtfrm" value="'.str_replace('"', '', $_SESSION["cms_context"]->getSessionVar("items_dtfrm")).'" class="admin_input_text" size="10" maxlength="10" style="width:85px;" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'items_dtfrm\'),\''.$cms_language->getCode().'\',this);return false;" />
				'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATESEARCH_AND, false, MOD_POLYMOD_CODENAME).'
				<input type="text" id="items_dtnd" name="items_dtnd" value="'.str_replace('"', '', $_SESSION["cms_context"]->getSessionVar("items_dtnd")).'" class="admin_input_text" size="10" maxlength="10" style="width:85px;" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'items_dtnd\'),\''.$cms_language->getCode().'\',this);return false;" />
			</td>
		</tr>';
}
//Add all subobjects or special fields (like categories) to search if any
foreach ($objectFields as $fieldID => $field) {
	//check if field is searchable
	if ($field->getValue('searchable')) {
		//check if field has a method to provide a list of names
		$objectType = $field->getTypeObject();
		if (method_exists($objectType, 'getListOfNamesForObject')) {
			$objectsNames = $objectType->getListOfNamesForObject();
			if (sizeof($objectsNames)) {
				$s_object_listbox = CMS_moduleCategories_catalog::getListBox(
					array (
					'field_name' => 'items_'.$object->getID().'_'.$fieldID,		// Select field name to get value in
					'items_possible' => $objectsNames,							// array of all categories availables: array(ID => label)
					'default_value' => $_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_'.$fieldID),	// Same format
					'attributes' => 'class="admin_input_text" style="width:250px;"'
					)
				);
				$content .= '
				<tr>
					<td class="admin">'.$field->getLabel($cms_language).'&nbsp;:</td>
					<td class="admin">'.$s_object_listbox.'</td>
				</tr>';
			}
		}
	}
}
$content .= '
	<tr>
		<td class="admin" colspan="2">
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_SHOW).'" /></td>
	</tr>
	</form>
	</table>
</fieldset>';


//
// All resources founded by search
//

// Sub title
if (!$page_sub_title) {
	$page_sub_title = $cms_language->getMessage(MESSAGE_PAGE_SUBTITLE_DOCS_FOUNDED, array($search->getNumRows(), $object->getLabel($cms_language)), MOD_POLYMOD_CODENAME);
}
$content .= '
	<script type="text/javascript">
		if (typeof CMS_openPopUpPage != "function") {
			function CMS_openPopUpPage(href, id, width, height)
			{
				if (href != "") {
					pagePopupWin = window.open(href, \'CMS_page_\'+id, \'width=\'+width+\',height=\'+height+\',resizable=yes,menubar=no,toolbar=no,scrollbars=yes,status=no,left=0,top=0\');
				}
			}
		}
	</script>
	<a name="results"></a>
	<br />
	<dialog-title type="admin_h2">'.$page_sub_title.'</dialog-title>';
// Result list	
if (!$items || !sizeof($items)) {
	$content .= "<br />".$cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
} else {
	
	$content .= '
		<br />
		<form action="item.php" method="post">
		<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
		<input type="hidden" name="object" value="'.$object->getID().'" />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
		</form>
		<div class="admin_content" style="position:relative;left:0px;width:750px;">
			<div align="right">
				<dialog-pages maxPages="'.$pages.'">
					<dialog-pages-param name="polymod" value="'.$polyModuleCodename.'" />
					<dialog-pages-param name="object" value="'.$object->getID().'" />
				</dialog-pages>
			</div>
		</div>
		<div class="admin_content" style="position:relative;left:0px;width:750px;">';
	
	$count = 0;
	foreach ($items as $item) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		$bg_color = ($count % 2 == 0) ? "#F6F6F5" : "#EBEBEA";
		
		$itemFieldsObjects = &$item->getFieldsObjects();
		
		$content .= '
			<div style="width:750px;padding:5px 0px 0px 5px;color:#4d4d4d;background-color:'.$bg_color.';">
				<table border="0" width="100%" cellpadding="2" cellspacing="0">
					<tr valign="top">';
					if ($object->isPrimaryResource()) {
						$status = $item->getStatus();
						if (is_object($status)) {
							$content .= '<td width="1" align="center" class="admin">'.$status->getHTML(false, $cms_user, $polyModuleCodename, $item->getID()).'</td>';
						}
					}
		$content .= '
						<td class="admin">
							<b>' . $item->getLabel() . ((POLYMOD_DEBUG) ? '<span class="admin_text_alert"> (ID : '.$item->getID().')</span>' : '') .'</b><br />';
					if ($object->isPrimaryResource()) {
						if (is_object($status)) {
							$content .= $cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBLICATION).' : 
								<span class="admin_subTitle">'.htmlspecialchars($status->getPublicationRange($cms_language)).'</span><br />';
						}
					}
					//Add all needed fields to description
		foreach ($itemFieldsObjects as $fieldID => $itemField) {
			//if field is a poly object
			if ($objectFields[$fieldID]->getValue('searchlist')) {
				$content .= $objectFields[$fieldID]->getLabel($cms_language).' : <span class="admin_subTitle">'.$itemField->getHTMLDescription().'</span><br />';
			}
		}
		$content .= '
						</td>
						<td valign="middle" align="right">
							<table border="0" cellpadding="2" cellspacing="0">
								<tr>';
					// Careful lock
					if ($object->isPrimaryResource() && $lock = $item->getLock()) {
						//actions are impossible, but lock can be eventually removed if :
						// - it is the user who placed the lock
						// - user is an administrator
						if ($cms_user->getUserID() == $lock ||
							$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
							$content .= '
								<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
								<input type="hidden" name="cms_action" value="unlock" />
								<input type="hidden" name="item" value="'.$item->getID().'" />
								<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
								<input type="hidden" name="object" value="'.$object->getID().'" />
									<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNLOCK).'" /></td>
								</form>';
						}
					} else {
						if ($object->isPrimaryResource() && is_object($status) && $item->getProposedLocation() == RESOURCE_LOCATION_DELETED) {
							// Undelete
							$content .= '
								<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
								<input type="hidden" name="cms_action" value="undelete" />
								<input type="hidden" name="item" value="'.$item->getID().'" />
								<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
								<input type="hidden" name="object" value="'.$object->getID().'" />
									<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNDELETE).'" /></td>
								</form>';
						} else {
							// Edit & Delete
							$content .= '
								<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETECONFIRM, array(htmlspecialchars($object->getLabel($cms_language)),htmlspecialchars($item->getLabel())), MOD_POLYMOD_CODENAME)) . ' ?\')">
								<input type="hidden" name="cms_action" value="delete" />
								<input type="hidden" name="item" value="'.$item->getID().'" />
								<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
								<input type="hidden" name="object" value="'.$object->getID().'" />
									<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE).'" /></td>
								</form>
								<form action="item.php" method="post">
								<input type="hidden" name="item" value="'.$item->getID().'" />
								<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
								<input type="hidden" name="object" value="'.$object->getID().'" />
									<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT).'" /></td>
								</form>';
						}
					}
					// object previz if defined
					if ($object->getValue("previewURL")) {
						$itemPrevizURL = $item->getPrevizPageURL();
						if ($itemPrevizURL) {
							$content .= '
							<form action="'.$itemPrevizURL.'" method="post" target="_blank">
								<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_PREVIZ).'" /></td>
							</form>';
						}
					}
					$content .= '
			               		</tr>
							</table>
						</td>
					</tr>
				</table>
			</div>';
		$content .= '
			<div style="clear:both;"></div>';
	}
	
	$content .= '
		</div>
		<div style="position:relative;width:750px;margin-bottom:5px;margin-top:5px;">
				<div align="right">
					<dialog-pages maxPages="'.$pages.'">
						<dialog-pages-param name="polymod" value="'.$polyModuleCodename.'" />
						<dialog-pages-param name="object" value="'.$object->getID().'" />
					</dialog-pages>
				</div>
		</div>';
}

// Add new resource
$content .= '
	<a name="new"></a>
	<form action="item.php" method="post">
	<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
	<input type="hidden" name="object" value="'.$object->getID().'" />
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_NEW).'" />
	</form>
	<br />';

$dialog->setContent($content);
$dialog->show();
?>
