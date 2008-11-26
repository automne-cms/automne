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
// $Id: item.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : module polymod admin
  * Presents one module resource
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
define("MESSAGE_FORM_ERROR_MALFORMED_FIELD", 145);
define("MESSAGE_ERROR_WRITETOPERSISTENCE",178);
define("MESSAGE_PAGE_FIELD_DATE_COMMENT", 148);
define("MESSAGE_PAGE_FIELD_PUBDATE_BEG", 134);
define("MESSAGE_PAGE_FIELD_PUBDATE_END", 135);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_ACTION_CANCELEDIT", 857);
define("MESSAGE_PAGE_ACTION_UNDELETE", 250);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_ACTION_ASSOCIATE", 1267);
define("MESSAGE_PAGE_ACTION_DISASSOCIATE", 1268);
define("MESSAGE_BUTTON_ADD", 260);
define("MESSAGE_BUTTON_EDIT", 87);
define("MESSAGE_PAGE_FIELD_LINK", 274);
define("MESSAGE_PAGE_FIELD_NONE", 10);
define("MESSAGE_PAGE_ACTION_UNLOCK", 82);
define("MESSAGE_PAGE_ACTION_DATE", 1284);
define("MESSAGE_RESOURCE_LOCKED", 278);

//Message of polymod module
define("MESSAGE_PAGE_TITLE", 2);
define("MESSAGE_PAGE_SUBTITLE_WEBSITE_PUBS", 57);
define("MESSAGE_PAGE_ACTION_EMAIL_SUBJECT", 31);
define("MESSAGE_PAGE_ACTION_EMAIL_BODY", 32);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 52);
define("MESSAGE_PAGE_EXISTING_LINK", 6);
define("MESSAGE_PAGE_ACTION_EMAIL_DELETE_SUBJECT", 53);
define("MESSAGE_PAGE_ACTION_EMAIL_DELETE_BODY", 55);

//get polymod codename
$polyModuleCodename = ($_REQUEST["polymod"]) ? $_REQUEST["polymod"]:'';
$object = new CMS_poly_object_definition(($_REQUEST["object"]) ? $_REQUEST["object"]:'');

//back link
$back = ($_REQUEST["back"]) ? $_REQUEST["back"] : 'items.php';

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
} elseif (!$_POST["cms_action"] && $_REQUEST["item"]) {
	$item = new CMS_poly_object($object->getID(), $_REQUEST["item"]);
	
	if ($object->isPrimaryResource()) {
		//put a lock on the resource or redirect to previous page if already locked
		if ($item->getLock()) {
			//header("Location: ".$back."?polymod=".$polyModuleCodename."&object=".$object->getID()."&cms_message_id=".MESSAGE_RESOURCE_LOCKED."&".session_name()."=".session_id());
			//exit;
			die('item '.$_REQUEST["item"].' locked ! ');
		} else {
			$item->lock($cms_user);
		}
	}
}

// +----------------------------------------------------------------------+
// | Session management                                                   |
// +----------------------------------------------------------------------+

// Language
if ($_REQUEST["items_language"] != '') {
	$_SESSION["cms_context"]->setSessionVar("items_language", $_REQUEST["items_language"]);
} elseif ($_SESSION["cms_context"]->getSessionVar("items_language") == '') {
	$_SESSION["cms_context"]->setSessionVar("items_language", $cms_language->getCode());
} elseif(is_a($_SESSION["cms_context"]->getSessionVar("items_language"), 'CMS_language')) {
	$language = $_SESSION["cms_context"]->getSessionVar("items_language");
	$_SESSION["cms_context"]->setSessionVar("items_language", $language->getCode());
}
$items_language = new CMS_language($_SESSION["cms_context"]->getSessionVar("items_language"));

//instanciate object
if (!is_object($item)) {
	$item = new CMS_poly_object($object->getID(), $_POST["item"]);
}

//
// Prepare article default publication dates
//
if (!$item->getID() && $object->isPrimaryResource()) {
	// Set the date intervals
	// Use parameter "default_weeks_delay_before_archiving" to determine
	// news publishing end date
	$dt_beg = new CMS_date();
	$dt_beg->setDebug(false);
	$dt_beg->setFormat($cms_language->getDateFormat());
	$dt_beg->setNow();
	
	$dt_end = new CMS_date();
	$dt_end->setDebug(false);
	$dt_end->setFormat($cms_language->getDateFormat());
	/*$days_before_archiving = (int) $cms_module->getParameters("default_weeks_delay_before_archiving") * 7 ;
	if ($days_before_archiving > 0) {
		$dt_end->setFromDBValue(date("Y-m-d", mktime (0,0,0, date("m"), date("d") + $days_before_archiving, date("Y"))));
	}*/
	if (!$dt_beg->hasError() && !$dt_end->hasError()){
		$item->setPublicationDates($dt_beg, $dt_end);
	}
}

$fieldsObjects = &$item->getFieldsObjects();

// +----------------------------------------------------------------------+
// | Actions                                                              |
// +----------------------------------------------------------------------+
$cms_message = "";
$cms_action = $_POST["cms_action"];

//sub-actions
switch ($cms_action) {
//create object and associate it to field values
case "add":
	//checks and assignments
	$itemToAdd = new CMS_poly_object($fieldsObjects[$_POST["editedField"]]->getObjectID(), $_POST['edit'.$_POST["editedField"]]);
	$itemObject = new CMS_poly_object_definition($fieldsObjects[$_POST["editedField"]]->getObjectID());
	$itemFieldsObjects = &$itemToAdd->getFieldsObjects();
	$itemToAdd->setDebug(false);
	
	//first, check mandatory values
	$allOK = true;
	foreach ($itemFieldsObjects as $fieldID => $aFieldObject) {
		$allOK = (!$itemToAdd->checkMandatory($fieldID, $_POST, $_POST["info"])) ? false:$allOK;
	}
	if (!$allOK) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	}
	
	//second, set values
	foreach ($itemFieldsObjects as $fieldID => $aFieldObject) {
		if (!$itemToAdd->setValues($fieldID, $_POST, $_POST["info"])) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($aFieldObject->getFieldLabel($cms_language)));
		}
	}
	
	//set publication dates if needed
	if ($itemObject->isPrimaryResource()) {
		// Dates management
		$dt_beg = new CMS_date();
		$dt_beg->setDebug(false);
		$dt_beg->setFormat($cms_language->getDateFormat());
		$dt_end = new CMS_date();
		$dt_end->setDebug(false);
		$dt_end->setFormat($cms_language->getDateFormat());
		if (!$dt_set_1 = $dt_beg->setLocalizedDate($_POST["pub_start"], true)) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
						array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)));
		} 
		if (!$dt_set_2 = $dt_end->setLocalizedDate($_POST["pub_end"], true)) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)));
		}
		if ($dt_set_1 && $dt_set_2) {
			$itemToAdd->setPublicationDates($dt_beg, $dt_end);
		}
	}
	if (!$cms_message) {
		//save the data
		if (!$itemToAdd->writeToPersistence()) {
			$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_WRITETOPERSISTENCE);
		}
		//if item is a primary resource, unlock it
		if ($itemObject->isPrimaryResource()) {
			$itemToAdd->unlock();
		}
		//then write ok
		if (!$cms_message) {
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			//and add id to field values (if it's not an edition)
			if (strpos($_POST[$_POST["info"]],$itemToAdd->getID()) === false) {
				$_POST[$_POST["info"]] = ($_POST[$_POST["info"]]) ? $itemToAdd->getID().';'.$_POST[$_POST["info"]] : $itemToAdd->getID();
			}
		}
	}
	//then validate other fields
	$cms_action = "validate";
break;

//add object to associate to field values
case "associate":
	$_POST[$_POST["info"]] = ($_POST[$_POST["info"]]) ? $_POST['associate'.$_POST["editedField"].'_0'].';'.$_POST[$_POST["info"]] : $_POST['associate'.$_POST["editedField"].'_0'];
	//then write ok
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	//then validate other fields
	$cms_action = "validate";
break;

//disassociate object of field values
case "disassociate":
	if ($_POST[$_POST["info"]]) {
		$associated_items = explode(';',$_POST[$_POST["info"]]);
		$key = array_search($_POST["editedField"], $associated_items);
		if ($key !== false) {
			unset($associated_items[$key]);
		}
		$_POST[$_POST["info"]] = implode(';',$associated_items);
		//then write ok
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	//then validate other fields
	$cms_action = "validate";
break;

//edit an associated object
case "edit":
	if ($_POST[$_POST["info"]]) {
		//add a superglobal to pass multi-object in edit mode
		$_POST["edit".$_POST["info"]] = true;
		//then write ok
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	//then validate other fields
	$cms_action = "validate";
break;

//cancel edit of an associated object
case "canceledit":
	$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	//then validate other fields
	$cms_action = "validate";
break;

//delete an associated object
case "delete":
	$itemToDelete = CMS_polymod::getResourceByID($_POST["editedField"]);
	if ($itemToDelete->delete()) {
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	} else {
		$cms_message = $cms_language->getMessage(MESSAGE_PAGE_ACTION_DELETE_ERROR);
	}
	//then disassociate object of field values
	if ($_POST[$_POST["info"]]) {
		$associated_items = explode(';',$_POST[$_POST["info"]]);
		$key = array_search($_POST["editedField"], $associated_items);
		if ($key !== false) {
			unset($associated_items[$key]);
		}
		$_POST[$_POST["info"]] = implode(';',$associated_items);
		//then write ok
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	//then validate other fields
	$cms_action = "validate";
break;
}

//master-actions
switch ($cms_action) {
case "validate":
	//checks and assignments
	$item->setDebug(false);
	
	//first, check mandatory values
	$allOK = true;
	foreach ($fieldsObjects as $fieldID => $aFieldObject) {
		$allOK = (!$item->checkMandatory($fieldID, $_POST,'')) ? false:$allOK;
	}
	if (!$allOK) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	}
	
	//second, set values for all fields
	foreach ($fieldsObjects as $fieldID => $aFieldObject) {
		if (!$item->setValues($fieldID, $_POST,'')) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($aFieldObject->getFieldLabel($cms_language)));
		}
	}
	
	//set publication dates if needed
	if ($object->isPrimaryResource()) {
		// Dates management
		$dt_beg = new CMS_date();
		$dt_beg->setDebug(false);
		$dt_beg->setFormat($cms_language->getDateFormat());
		$dt_end = new CMS_date();
		$dt_end->setDebug(false);
		$dt_end->setFormat($cms_language->getDateFormat());
		if (!$dt_set_1 = $dt_beg->setLocalizedDate($_POST["pub_start"], true)) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
						array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)));
		} 
		if (!$dt_set_2 = $dt_end->setLocalizedDate($_POST["pub_end"], true)) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)));
		}
		//if $dt_beg && $dt_end, $dt_beg must be lower than $dt_end
		if (!$dt_beg->isNull() && !$dt_end->isNull()) {
			if (CMS_date::compare($dt_beg, $dt_end, '>')) {
				$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
						array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)));
				$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)));
				$dt_set_1 = $dt_set_2 = false;
			}
		}
		if ($dt_set_1 && $dt_set_2) {
			$item->setPublicationDates($dt_beg, $dt_end);
		}
	}
	if (!$cms_message) {
		//save the data
		if (!$item->writeToPersistence()) {
			$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_WRITETOPERSISTENCE);
		}
		//if item is a primary resource, unlock it and send emails
		if ($object->isPrimaryResource()) {
			$item->unlock();
		}
		//then redirect to summary
		if (!$cms_message) {
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	}
	break;
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_MODULE, array($cms_module->getLabel($cms_language)))." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, array($object->getLabel($cms_language)), MOD_POLYMOD_CODENAME));

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
//add calendar & popup image javascripts
$dialog->addCalendar();
$dialog->addPopupImage();

if (POLYMOD_DEBUG) {
	$content = '<span class="admin_text_alert">Object type : '.$object->getID().' - Object ID : '.$item->getID().'</span><br /><br />';
}

$content .= '
	<script type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/coordinates.js"></script>
	<script type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/drag.js"></script>
	<script type="text/javascript" src="'.PATH_ADMIN_WR.'/v3/js/dragsort.js"></script>
	<script type="text/javascript">
		<!--
		function sortList() {
			var lists = document.getElementsByTagName("ul");
			if (lists.length > 0) {
				for (var i = 0; i < lists.length; i++) {
					if (lists[i].className.indexOf("sortable") != -1) {
						DragSort.makeListSortable(lists[i]);
					}
				}
			}
		};
		function stopDragging(listID) {
			//get parent UL
			var element = document.getElementById(listID)
			while (element.tagName != "UL") {
				element = element.parentNode;
			}
			var ul = element;
			var fieldsArray;
			var newOrder;
			if (ul.className.indexOf("sortable") != -1) {
				//get new order
				fieldsArray = ul.getElementsByTagName("li");
				for (var j=0; j<fieldsArray.length; j++) {
					newOrder = (newOrder) ? newOrder + ";" + fieldsArray[j].id.substr(1) : fieldsArray[j].id.substr(1);
				}
				//set hidden field with new order
				document.getElementById(ul.id.substr(4)).value=newOrder;
			}
			return true;
		}
		//-->
	</script>

	<table border="0" cellpadding="3" cellspacing="2">
	<form name="frmitem" id="frmitem" action="'.$_SERVER["SCRIPT_NAME"].'" method="post" enctype="multipart/form-data">';
	if (POLYMOD_DEBUG) {
		$content .= '
		<tr>
			<td class="admin" align="right" colspan="2">
				cms_action : 	<input type="text" name="cms_action" id="cms_action" value="validate" class="admin_input_text" /><br />
				item : 			<input type="text" name="item" id="item" value="'.$item->getID().'" class="admin_input_text" /><br />
				polymod : 		<input type="text" name="polymod" id="polymod" value="'.$polyModuleCodename.'" class="admin_input_text" /><br />
				object : 		<input type="text" name="object" id="object" value="'.$object->getID().'" class="admin_input_text" /><br />
				editedField : 	<input type="text" name="editedField" id="editedField" value="" class="admin_input_text" /><br />
				info : 			<input type="text" name="info" id="info" value="" class="admin_input_text" /><br />
				back : 			<input type="text" name="back" id="back" value="'.$back.'" class="admin_input_text" />
			</td>
		</tr>';
	} else {
		$content .= '
		<input type="hidden" name="cms_action" id="cms_action" value="validate" />
		<input type="hidden" name="item" id="item" value="'.$item->getID().'" />
		<input type="hidden" name="polymod" id="polymod" value="'.$polyModuleCodename.'" />
		<input type="hidden" name="object" id="object" value="'.$object->getID().'" />
		<input type="hidden" name="editedField" id="editedField" value="" />
		<input type="hidden" name="info" id="info" value="" />
		<input type="hidden" name="back" id="back" value="'.$back.'" />';
	}
	/*$template = '
	<tr>
		<td class="admin" vailgn="top"><atm-if what="{{mandatory}}"><span class="admin_text_alert">*</span> </atm-if>{{label}}</td>
		<td class="admin">
			<atm-if what="{{description}}"><small>{{description}}</small><br /><br /></atm-if>
			{{fields}}
		</td>
	</tr>';
	$htmlInterface = new CMS_html_interface($template);*/
	foreach ($fieldsObjects as $fieldID => $aFieldObject) {
		$content .= $item->getHTMLAdmin($fieldID, $cms_language,'');//$htmlInterface->getHTML($aFieldObject, $cms_language, '');
	}
	
if ($object->isPrimaryResource()) {
	$pub_start = $item->getPublicationDateStart();
	$pub_end = $item->getPublicationDateEnd();
	$date_mask = $cms_language->getDateFormatMask();
	$content .='
	<tr>
		<td colspan="2" class="admin">
			<!-- Publication dates -->
			<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE_WEBSITE_PUBS, false, MOD_POLYMOD_CODENAME).'</dialog-title></td>
	</tr>
	<tr>
		<td class="admin" align="right">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG).' :<br />
			<small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask)).')</small>
		</td>
		<td class="admin">
			<input type="text" size="15" class="admin_input_text" id="pub_start" name="pub_start" value="'.$pub_start->getLocalizedDate($cms_language->getDateFormat()).'" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'pub_start\'),\''.$cms_language->getCode().'\',this);return false;" /></td>
	</tr>
	<tr>
		<td class="admin" align="right">
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END).' :<br />
			<small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask)).')</small>
		</td>
		<td class="admin">
			<input type="text" size="15" class="admin_input_text" id="pub_end" name="pub_end" value="'.$pub_end->getLocalizedDate($cms_language->getDateFormat()).'" />&nbsp;<img type="image" src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'pub_end\'),\''.$cms_language->getCode().'\',this);return false;" /></td>
	</tr>';
}
$content .= '
	<tr>
		<td colspan="2" align="right">
			<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table><br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />
';
$dialog->setContent($content);
$dialog->show();
if (POLYMOD_DEBUG) {
	pr($_POST);
}
?>
