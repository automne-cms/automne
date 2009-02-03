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
// $Id: fckplugin.php,v 1.2 2009/02/03 14:26:20 sebastien Exp $

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
define("MESSAGE_PAGE_ACTION_SHOW", 1006);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_FIELD_STATUS", 256);
define("MESSAGE_PAGE_FIELD_TITLE", 257);
define("MESSAGE_PAGE_FIELD_PUBLICATION", 258);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_ACTION_DATE", 1284);
define("MESSAGE_PAGE_ACTION_PREVIZ", 811);
define("MESSAGE_PAGE_CHOOSE", 1049);

/**
  * Messages from this module 
  */
define("MESSAGE_PAGE_TITLE", 82);
define("MESSAGE_PAGE_ERROR_NO_PLUGIN", 280);
define("MESSAGE_PAGE_CHOOSE_PLUGIN", 281);
define("MESSAGE_PAGE_SUBTITLE_1", 66);
define("MESSAGE_PAGE_FIELD_KEYWORDS", 18);
define("MESSAGE_PAGE_SUBTITLE_DOCS_FOUNDED", 21);
define("MESSAGE_PAGE_FIELD_DATESEARCH_BETWEEN", 19);
define("MESSAGE_PAGE_FIELD_DATESEARCH_AND", 20);
define("MESSAGE_PAGE_TITLE_MODULE", 282);
define("MESSAGE_PAGE_TITLE_CURRENTLY_SELECTED", 283);
define("MESSAGE_PAGE_ACTION_SELECT", 284);
define("MESSAGE_PAGE_ACTION_UNSELECT", 285);
define("MESSAGE_PAGE_SELECTION_ERROR", 286);

//get polymod codename
$polyModuleCodename = ($_REQUEST["polymod"]) ? $_REQUEST["polymod"]:'';
//get ids from wysiwyg
if ($_REQUEST['id']) {
	$ids = explode('-', $_REQUEST['id']);
	$selectedPluginID = (int) $ids[1];
	$selectedItem = (int) $ids[2];
}
//get selected plugin (can be overwrited)
$selectedPluginID = ($_REQUEST["pluginDefinition"]) ? $_REQUEST["pluginDefinition"]:$selectedPluginID;
//get selected item (can be overwrited)
$selectedItem = (isset($_REQUEST["item"])) ? $_REQUEST["item"]:$selectedItem;

//get selected text content from wysiwyg
if ($_REQUEST['content']) {
	$selectedContent = (string) $_REQUEST['content'];
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '
<script type="text/javascript">
	if (typeof CMS_openPopUpPage != "function") {
		function CMS_openPopUpPage(href, id, width, height)
		{
			if (href != "") {
				pagePopupWin = window.open(href, \'CMS_page_\'+id, \'width=\'+width+\',height=\'+height+\',resizable=yes,menubar=no,toolbar=no,scrollbars=yes,status=no,left=0,top=0\');
			}
		}
	}
	document.body.style.backgroundColor=\'#F1F1E3\';
</script>';

//Select WYSIWYG Plugin
$pluginDefinitions = CMS_poly_object_catalog::getAllPluginDefinitionsForObject();
//check for user rights
$availablePlugin = array();
$availablePluginCount = 0;
if (sizeof($pluginDefinitions)) {
	foreach ($pluginDefinitions as $id => $pluginDefinition) {
		$objectID = $pluginDefinition->getValue('objectID');
		$polyModuleCodename = CMS_poly_object_catalog::getModuleCodenameForObjectType($objectID);
		if ($cms_user->hasModuleClearance($polyModuleCodename, CLEARANCE_MODULE_VIEW)) {
			$availablePlugin[$polyModuleCodename][$id] = $pluginDefinition;
			$availablePluginCount++;
		}
	}
}
//if no plugin available, display error and quit
if (!sizeof($availablePlugin)) {
	//page title
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, false, MOD_POLYMOD_CODENAME).' : ');
	//messages
	$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ERROR_NO_PLUGIN, false, MOD_POLYMOD_CODENAME);
	$dialog->setActionMessage($cms_message);
	$dialog->setContent($content);
	$dialog->show();
	exit;
}
//if more than one plugin, display a list of available plugins
if ($availablePluginCount > 1) {
	$selectedPluginIDDefinition = '';
	$selectedPluginIDModuleName = '';
	$content .= '
	<form name="frm" action="'.$_SERVER['SCRIPT_NAME'].'" method="post">
	<input type="hidden" name="id" value="'.(($selectedPluginID && $selectedItem) ? 'polymod-'.$selectedPluginID.'-'.$selectedItem : '').'" />
	<input type="hidden" name="content" value="'.htmlspecialchars($selectedContent).'" />
	'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE_PLUGIN, false, MOD_POLYMOD_CODENAME).' : 
	<select name="pluginDefinition" class="admin_input_text" onchange="submit();">
		<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
	foreach ($availablePlugin as $aPolyModuleCodename => $pluginDefinitions) {
		$polymodule = CMS_modulesCatalog::getByCodename($aPolyModuleCodename);
		$content .= '<optgroup label="'.$polymodule->getLabel($cms_language).'">';
		foreach ($pluginDefinitions as $id => $pluginDefinition) {
			$content .= '<option value="'.$id.'"'.(($selectedPluginID == $id) ? ' selected="selected"':'').' title="'.htmlspecialchars($pluginDefinition->getDescription($cms_language)).'">'.$pluginDefinition->getLabel($cms_language).'</option>';
			if ($selectedPluginID == $id) {
				$selectedPlugin = $pluginDefinition;
				$polyModuleCodename = $aPolyModuleCodename;
				$selectedPluginIDDefinition = $pluginDefinition->getDescription($cms_language);
				$selectedPluginIDModuleName = $polymodule->getLabel($cms_language);
			}
		}
		$content .= '</optgroup>';
	}
	$content .= '
	</select> '.(($selectedPluginIDDefinition) ? '(<strong>'.$selectedPluginIDModuleName.' : </strong>'.$selectedPluginIDDefinition.')' : '').'
	</form>';
} else {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_CHOOSE_PLUGIN, false, MOD_POLYMOD_CODENAME).' : ';
	foreach ($availablePlugin as $aPolyModuleCodename => $pluginDefinitions) {
		$polymodule = CMS_modulesCatalog::getByCodename($aPolyModuleCodename);
		foreach ($pluginDefinitions as $id => $pluginDefinition) {
			$content .= '<strong>'.$pluginDefinition->getLabel($cms_language).'</strong> (<strong>'.$polymodule->getLabel($cms_language).' : </strong>'.$pluginDefinition->getDescription($cms_language).')';
			$selectedPluginID = $id;
			$selectedPlugin = $pluginDefinition;
			$polyModuleCodename = $aPolyModuleCodename;
		}
	}
}
//if no plugin selected, quit here
if (!$selectedPluginID || !is_object($selectedPlugin)) {
	//page title
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, false, MOD_POLYMOD_CODENAME).' : ');
	//messages
	$dialog->setActionMessage($cms_message);
	$dialog->setContent($content);
	$dialog->show();
	exit;
}

//if no module available, display error and quit
if (!$polyModuleCodename) {
	//page title
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, false, MOD_POLYMOD_CODENAME).' : ');
	//messages
	$cms_message = $cms_language->getMessage(MESSAGE_PAGE_CLEARANCE_ERROR);
	$dialog->setActionMessage($cms_message);
	$dialog->setContent($content);
	$dialog->show();
	exit;
}
//if plugin need a selection and none found, send an alert message and quit
if ($selectedPlugin->needSelection() && !$selectedContent) {
	//page title
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, false, MOD_POLYMOD_CODENAME).' : ');
	//messages
	$cms_message = $cms_language->getMessage(MESSAGE_PAGE_SELECTION_ERROR, false, MOD_POLYMOD_CODENAME);
	$dialog->setActionMessage($cms_message);
	$dialog->setContent($content);
	$dialog->show();
	exit;
}

//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename($polyModuleCodename);

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

//load current object definition
$object = new CMS_poly_object_definition($selectedPlugin->getValue('objectID'));

// Check if need to use a specific display for search results
$resultsDefinition = $object->getValue('resultsDefinition');

//load fields objects for object
$objectFields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());

//
// Get default search options
//

//get predefined search values for wysiwyg plugin
$searchSelectedValues = $selectedPlugin->getValue('query');

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
		} elseif ($searchSelectedValues[$fieldID]) {
			$_SESSION["cms_context"]->setSessionVar('items_'.$object->getID().'_'.$fieldID, $searchSelectedValues[$fieldID]);
		}
	}
} else {
	//Add all subobjects to search if any
	foreach ($objectFields as $fieldID => $field) {
		if ($searchSelectedValues[$fieldID]) {
			$_SESSION["cms_context"]->setSessionVar('items_'.$object->getID().'_'.$fieldID, $searchSelectedValues[$fieldID]);
		}
	}
}

// +----------------------------------------------------------------------+
// | Build search                                                         |
// +----------------------------------------------------------------------+

//create search object for current object
$search = new CMS_object_search($object);

if ($selectedItem && $_REQUEST["cms_action"] != 'search' && !$_REQUEST["bookmark"]) {
	//add selected item id as an unique search condition
	$search->addWhereCondition('item', $selectedItem);
} else {
	//if object is a primary resource
	if ($object->isPrimaryResource()) {
		// Param : Around publication date
		$dt_today = new CMS_date();
		$dt_today->setDebug(false);
		$dt_today->setNow();
		$dt_today->setFormat($date_format);
		
		$dt_from = new CMS_date();
		$dt_from->setDebug(false);
		$dt_from->setFormat($date_format);
		if ($dt_from->setLocalizedDate($_SESSION["cms_context"]->getSessionVar("items_dtfrm"))) {
			$search->addWhereCondition("publication date after", $dt_from);
		}
		
		$dt_end = new CMS_date();
		$dt_end->setDebug(false);
		$dt_end->setFormat($date_format);
		if ($dt_end->setLocalizedDate($_SESSION["cms_context"]->getSessionVar("items_dtnd"))) {
			// Check this date isn't greater than start date given
			if (!CMS_date::compare($dt_from, $dt_end, ">=")) {
				$search->addWhereCondition("publication date before", $dt_end);
			}
		}
	}
	
	// Param : With keywords
	if ($_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_kwrds') != '') {
		$search->addWhereCondition("keywords", $_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_kwrds'));
	}
	//Add all subobjects to search if any
	foreach ($objectFields as $fieldID => $field) {
		//if field is a poly object
		if ($_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_'.$fieldID) != '') {
			$search->addWhereCondition($fieldID, $_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_'.$fieldID));
		}
	}
}
// Params : paginate limit
$search->setAttribute('itemsPerPage', $_SESSION["cms_context"]->getRecordsPerPage());
$search->setAttribute('page', $_SESSION["cms_context"]->getBookmark() - 1);

// Params : order
$search->addOrderCondition('objectID','desc');

$items = $search->search();

// Vars for lists output purpose and pages display, see further
$records_count = $search->getNumRows();
$records_per_page = $_SESSION["cms_context"]->getRecordsPerPage();//30;//$cms_module->getParameters("items_per_page");
$bookmark = $_SESSION["cms_context"]->getBookmark();
$pages = $search->getMaxPages();

//page title
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, false, MOD_POLYMOD_CODENAME).' : '.$selectedPlugin->getLabel($cms_language));
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
//add calendar & popup image javascripts
$dialog->addCalendar();
$dialog->addPopupImage();

// Add specific css if we use the resultsDefinition
if($resultsDefinition && file_exists(PATH_CSS_FS.'/modules/'.$polyModuleCodename.'.css')){
	$content.='<link rel="stylesheet" type="text/css" href="'.PATH_CSS_WR.'/modules/'.$polyModuleCodename.'.css" />';
}

//
// Search form
//
$content .= '
<br /><br />
<fieldset style="width:500px;">
	<legend class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE_1, array($object->getLabel($cms_language)), MOD_POLYMOD_CODENAME).'</legend>
	<table width="100%" border="0" cellpadding="3" cellspacing="0">
	<form action="'.$_SERVER["SCRIPT_NAME"].'#results" method="post">
	<input type="hidden" name="cms_action" value="search" />
	<input type="hidden" name="bookmark" value="1" />
	<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
	<input type="hidden" name="object" value="'.$object->getID().'" />
	<input type="hidden" name="pluginDefinition" value="'.$selectedPluginID.'" />
	<input type="hidden" name="id" value="'.(($selectedPluginID && $selectedItem) ? 'polymod-'.$selectedPluginID.'-'.$selectedItem : '').'" />
	<input type="hidden" name="content" value="'.htmlspecialchars($selectedContent).'" />';

// Keywords
$content .= '
	<tr valign="top">
		<td class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_KEYWORDS, false, MOD_POLYMOD_CODENAME).'&nbsp;:</td>
		<td class="admin">
			<input type="text" name="items_'.$object->getID().'_kwrds" value="'.htmlspecialchars($_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_kwrds')).'" class="admin_input_text" size="30" style="width:250px;" /></td>
	</tr>';

if ($object->isPrimaryResource()) {
	// Publication Dates
	$content .= '
		<tr valign="top">
			<td class="admin">'.htmlspecialchars($cms_language->getMessage(MESSAGE_PAGE_FIELD_DATESEARCH_BETWEEN, false, MOD_POLYMOD_CODENAME)).'<br />
					<small>('.$date_mask.')</small></td>
			<td class="admin">
				<input type="text" id="items_dtfrm" name="items_dtfrm" value="'.htmlspecialchars($_SESSION["cms_context"]->getSessionVar("items_dtfrm")).'" class="admin_input_text" size="10" maxlength="10" style="width:85px;" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'items_dtfrm\'),\''.$cms_language->getCode().'\',this);return false;" />
				'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATESEARCH_AND, false, MOD_POLYMOD_CODENAME).'
				<input type="text" id="items_dtnd" name="items_dtnd" value="'.htmlspecialchars($_SESSION["cms_context"]->getSessionVar("items_dtnd")).'" class="admin_input_text" size="10" maxlength="10" style="width:85px;" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'items_dtnd\'),\''.$cms_language->getCode().'\',this);return false;" />
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
				if (!$searchSelectedValues[$fieldID]) {
					$s_object_listbox = CMS_moduleCategories_catalog::getListBox(
						array (
						'field_name' => 'items_'.$object->getID().'_'.$fieldID,		// Select field name to get value in
						'items_possible' => $objectsNames,							// array of all categories availables: array(ID => label)
						'default_value' => $_SESSION["cms_context"]->getSessionVar('items_'.$object->getID().'_'.$fieldID),	// Same format
						'attributes' => 'class="admin_input_text" style="width:250px;"'
						)
					);
				} else {
					$s_object_listbox = $objectsNames[$searchSelectedValues[$fieldID]].'<input type="hidden" name="items_'.$object->getID().'_'.$fieldID.'" value="'.$searchSelectedValues[$fieldID].'" />';
				}
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
if ($selectedItem && $_REQUEST["cms_action"] != 'search' && !$_REQUEST["bookmark"]) {
	$page_sub_title = $cms_language->getMessage(MESSAGE_PAGE_TITLE_CURRENTLY_SELECTED, false, MOD_POLYMOD_CODENAME).' :';
} else {
	$page_sub_title = $cms_language->getMessage(MESSAGE_PAGE_SUBTITLE_DOCS_FOUNDED, array($search->getNumRows(), $object->getLabel($cms_language)), MOD_POLYMOD_CODENAME);
}
$content .= '
	<a name="results"></a>
	<br />
	<div class="admin_h2" style="border-bottom:1px dotted #8FC020;">&gt; '.$page_sub_title.'</div>';
// Result list	
if (!$items || !sizeof($items)) {
	$content .= "<br />".$cms_language->getMessage(MESSAGE_PAGE_EMPTY_SET)."<br /><br />";
} else {
	
	$content .= '
		<br />
		<div class="admin_content" style="position:relative;left:0px;width:95%;">
			<div align="right">
				<dialog-pages maxPages="'.$pages.'">
					<dialog-pages-param name="polymod" value="'.$polyModuleCodename.'" />
					<dialog-pages-param name="object" value="'.$object->getID().'" />
				</dialog-pages>
			</div>
		</div>
		<div class="admin_content" style="position:relative;left:0px;width:95%;">';
	$count = 0;
	
	if ($resultsDefinition) {
		$definitionParsing = new CMS_polymod_definition_parsing($resultsDefinition, true, CMS_polymod_definition_parsing::PARSE_MODE);
	}
	
	foreach ($items as $item) {
		$count++;
		$td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
		$bg_color = ($count % 2 == 0) ? "#F6F6F5" : "#EBEBEA";
		if ($selectedItem == $item->getID()) {
			$td_class = "admin_selectedbg";
			$bg_color = "#FDF5A2";
		}
		$itemFieldsObjects = &$item->getFieldsObjects();
		$content .= '
			<div style="padding:5px 0px 0px 5px;color:#4d4d4d;background-color:'.$bg_color.';">
				<table border="0" width="100%" cellpadding="2" cellspacing="0">
					<tr valign="top">';
					if ($object->isPrimaryResource()) {
						$status = $item->getStatus();
						if (is_object($status)) {
							$content .= '<td width="1" align="center" class="admin">'.$status->getHTML(false, $cms_user, $polyModuleCodename, $item->getID()).'</td>';
						}
					}
		$content .= '
						<td class="admin">';
		// If resultsDefinition : specific xml definition for display results
		if($resultsDefinition){
			//set execution parameters
			$parameters = array();
			$parameters['module'] = $polyModuleCodename;
			$parameters['objectID'] = $object->getID();
			$parameters['public'] = false;
			$parameters['item'] = $item;
			$content .= $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
			
			$content .= '<b>'.((POLYMOD_DEBUG) ? '<span class="admin_text_alert"> (ID : '.$item->getID().')</span>' : '') .'</b><br />';
		} else {
			// Label and publication
			$content .= '
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
		}
		$content .= '
						</td>
						<td valign="middle" align="right">
							<table border="0" cellpadding="2" cellspacing="0">
								<tr>';
					// select / unselect
					if ($selectedItem != $item->getID()) {
						$content .= '
						<form action="'.$_SREVER['SCRIPT_NAME'].'" method="post">
						<input type="hidden" name="item" value="'.$item->getID().'" />
						<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
						<input type="hidden" name="object" value="'.$object->getID().'" />
						<input type="hidden" name="pluginDefinition" value="'.$selectedPluginID.'" />
						<input type="hidden" name="content" value="'.htmlspecialchars($selectedContent).'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_SELECT,false, MOD_POLYMOD_CODENAME).'" /></td>
						</form>';
					} else {
						$content .= '
						<form action="'.$_SREVER['SCRIPT_NAME'].'" method="post">
						<input type="hidden" name="item" value="" />
						<input type="hidden" name="cms_action" value="search" />
						<input type="hidden" name="polymod" value="'.$polyModuleCodename.'" />
						<input type="hidden" name="object" value="'.$object->getID().'" />
						<input type="hidden" name="pluginDefinition" value="'.$selectedPluginID.'" />
						<input type="hidden" name="content" value="'.htmlspecialchars($selectedContent).'" />
							<td class="admin"><input type="submit" class="admin_input_'.$td_class.'" value="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNSELECT,false, MOD_POLYMOD_CODENAME).'" /></td>
						</form>';
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
		<div style="position:relative;width:95%;margin-bottom:5px;margin-top:5px;">
				<div align="right">
					<dialog-pages maxPages="'.$pages.'">
						<dialog-pages-param name="polymod" value="'.$polyModuleCodename.'" />
						<dialog-pages-param name="object" value="'.$object->getID().'" />
					</dialog-pages>
				</div>
		</div>';
}

//then create the code to paste for the current selected object if any
$replace = array(
	"\n" => "",
	"\r" => "",
	"'" => "\'",
);
if (sensitiveIO::isPositiveInteger($selectedItem) && !$selectedPlugin->needSelection()) {
	$item = CMS_poly_object_catalog::getObjectByID($selectedItem);
	$definition = $selectedPlugin->getValue('definition');
	$parameters = array();
	$parameters['itemID'] = $selectedItem;
	$parameters['module'] = $polyModuleCodename;
	$cms_page = $cms_context->getPage();
	if (is_object($cms_page) && !$cms_page->hasError()) {
		$parameters['pageID'] = $cms_page->getID();
	}
	$parameters['selection'] = html_entity_decode($selectedContent);
	$parameters['public'] = false;
	$definitionParsing = new CMS_polymod_definition_parsing($definition, true, CMS_polymod_definition_parsing::PARSE_MODE);
	$codeTopaste = $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
	//add some attributes to images to prevent resizing into editor
    $codeTopaste = str_replace('<img ','<img contenteditable="false" unselectable="on" ', $codeTopaste);
	
	if ($codeTopaste) {
		//add identification span tag arround code to paste
		$codeTopaste = '<span id="polymod-'.$selectedPluginID.'-'.$selectedItem.'" class="polymod" title="'.htmlspecialchars($selectedPlugin->getLabel($cms_language).' : '.$item->getLabel($cms_language)).'">'.$codeTopaste.'</span>';
	}
	$content .= '
	<script type="text/javascript">
		window.parent.document.getElementById(\'codeToPaste\').value = \''.str_replace(array_keys($replace), $replace, htmlspecialchars($codeTopaste)).'\';
	</script>';
} elseif (sensitiveIO::isPositiveInteger($selectedItem) && $selectedPlugin->needSelection()) {
	$codeTopaste = '<span id="polymod-'.$selectedPluginID.'-'.$selectedItem.'" class="polymod">'.$selectedContent.'</span>';
	$content .= '
	<script type="text/javascript">
		window.parent.document.getElementById(\'codeToPaste\').value = \''.str_replace(array_keys($replace), $replace, htmlspecialchars($codeTopaste)).'\';
	</script>';
} else {
	$selectedContent = ($selectedContent) ? $selectedContent : ' ';
	$content .= '
	<script type="text/javascript">
		window.parent.document.getElementById(\'codeToPaste\').value = \''.str_replace(array_keys($replace), $replace, htmlspecialchars($selectedContent)).'\';
	</script>';
}

$dialog->setContent($content);
$dialog->show();
?>