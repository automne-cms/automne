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
// $Id: polymod_field.php,v 1.3 2009/04/02 13:56:08 sebastien Exp $

/**
  * PHP page : polymod admin
  * Used to manage poly modules
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1237);
define("MESSAGE_PAGE_TITLE_APPLICATIONS", 264);
define("MESSAGE_PAGE_CHOOSE", 1132);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_OBJECTS", 1227);
define("MESSAGE_PAGE_APPLICATION", 1228);
define("MESSAGE_PAGE_FIELD_TITLE", 132);
define("MESSAGE_FORM_ERROR_LINK_MANDATORY", 802);
define("MESSAGE_PAGE_FIELD_TYPE", 1238);
define("MESSAGE_PAGE_FIELD_REQUIRED", 1239);
define("MESSAGE_PAGE_FIELD_FRONTEND", 1240);
define("MESSAGE_PAGE_FIELD_SEARCHLIST", 1241);
define("MESSAGE_PAGE_FIELD_SEARCHABLE", 1242);
define("MESSAGE_PAGE_FIELD_PARAMS", 1243);
define("MESSAGE_PAGE_FIELD_MULTI", 1244);
define("MESSAGE_PAGE_FIELD_STANDARD_OBJECTS", 1247);
define("MESSAGE_PAGE_FIELD_POLY_OBJECTS", 1248);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_TREEH1", 1049);

define("MESSAGE_FIELD_NO", 1082);
define("MESSAGE_FIELD_YES", 1083);

//Polymod messages
define("MESSAGE_PAGE_FIELD_INDEXABLE", 322);

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
//load page objects and vars
$moduleCodename = ($_POST["moduleCodename"]) ? $_POST["moduleCodename"]:$_GET["moduleCodename"];
$object = new CMS_poly_object_definition($_POST["object"]);
$field = new CMS_poly_object_field($_POST["field"]);
$label = new CMS_object_i18nm($field->getValue("labelID"));
$description = new CMS_object_i18nm($field->getValue("descriptionID"));
$availableLanguagesCodes = CMS_object_i18nm::getAvailableLanguages();

$cms_message = "";
// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($_POST["cms_action"]) {
case "validate":
	//checks and assignments
	
	$field->setDebug(false);
	
	if (!$_POST["label".$availableLanguagesCodes[0]] || !$_POST["type"]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	}
case 'switchexplanation';
case "newtype";
	if ($_POST["label".$availableLanguagesCodes[0]]) {
		foreach($availableLanguagesCodes as $aLanguageCode) {
			$label->setValue($aLanguageCode, $_POST["label".$aLanguageCode]);
		}
		if ($_POST["cms_action"] == 'validate') {
			$label->writeToPersistence();
		}
	}
	if ($_POST["description".$availableLanguagesCodes[0]]) {
		foreach($availableLanguagesCodes as $aLanguageCode) {
			$description->setValue($aLanguageCode, $_POST["description".$aLanguageCode]);
		}
		if ($_POST["cms_action"] == 'validate') {
			$description->writeToPersistence();
		}
	}
	if (!$field->setValue("labelID", $label->getID())) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE)));
	}
	if (!$field->setValue("descriptionID", $description->getID())) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION)));
	}
	if ($_POST["type"]) {
		$field->setValue("type",$_POST["type"]);
		$typeObject = $field->getTypeObject(true);
		if (is_object($typeObject) && $typeObject->hasParameters()) {
			$params = $typeObject->treatParams($_POST,'type');
		}
	} else {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_TYPE)));
	}
	if (!$field->setValue("required",$_POST["required"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_REQUIRED)));
	}
	if (!$field->setValue("indexable",$_POST["indexable"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_FRONTEND)));
	}
	if (!$field->setValue("searchlist",$_POST["searchlist"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_SEARCHLIST)));
	}
	if (!$field->setValue("searchable",$_POST["searchable"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_SEARCHABLE)));
	}
	if (is_object($typeObject) && $typeObject->hasParameters()) {
		if (is_object($typeObject) && $params == false) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PARAMS)));
		} else {
			$field->setValue("params",$params);
		}
	}
	$field->setValue("objectID",$object->getID());
	
	if (!$cms_message && $_POST["cms_action"] == "validate") {
		//save the data
		$field->writeToPersistence();
		
		header("Location: modules_admin.php?moduleCodename=".$moduleCodename."&object=".$object->getID()."&field=".$field->getID()."&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
		exit;
	} elseif ($_POST["cms_action"] != "validate") {
		$cms_message = '';
	}
	break;
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_APPLICATIONS)." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, array($object->getLabel($cms_languege))),'picto_modules.gif');
$dialog->setBacklink("modules_admin.php?moduleCodename=".$moduleCodename."&object=".$object->getID()."&field=".$field->getID());
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

if ($moduleCodename) {
	$polymod = CMS_modulesCatalog::getByCodename($moduleCodename);
}

$required = ($field->getValue("required")) ? ' checked="checked"':'';
$indexable = ($field->getValue("indexable")) ? ' checked="checked"':'';
$searchlist = ($field->getValue("searchlist")) ? ' checked="checked"':'';
$searchable = ($field->getValue("searchable")) ? ' checked="checked"':'';
$poly_types = CMS_poly_object_catalog::getObjectsForModule($moduleCodename);
$object_types = CMS_object_catalog::getObjects($field,true);
$typeObject = $field->getTypeObject(true);
$objectUseage = CMS_poly_object_catalog::getObjectUsage($object->getID());

if (is_object($typeObject) && $typeObject->hasParameters()) {
	if (is_a($typeObject, 'CMS_poly_object_definition')) {
		//need to load parameters first
		$typeObject->loadParameters($field);
	}
	$parametersHTML = $typeObject->getHTMLSubFieldsParameters($cms_language, 'type');
}
$content = '
	<table width="80%" border="0" cellpadding="3" cellspacing="2">
	<form name="frm" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" id="cms_action" name="cms_action" value="validate" />
	<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
	<input type="hidden" name="object" value="'.$object->getID().'" />
	<input type="hidden" name="field" value="'.$field->getID().'" />
	<tr>
		<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TYPE).'</td>
		<td class="admin">';
		if (!$field->getID() || !$field->getValue("type")) {
			$content .= '
			<select name="type" class="admin_input_text" onchange="document.getElementById(\'cms_action\').value=\'newtype\';document.frm.submit();">
				<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
				//objects
				if (sizeof($object_types)) {
					$content .= '<optgroup label="'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_STANDARD_OBJECTS).'">';
					foreach ($object_types as $anObjectTypeName => $anObjectType) {
						$selected = ($field->getValue("type") == $anObjectTypeName) ? ' selected="selected"':'';
						$content .= '<option value="'.$anObjectTypeName.'"'.$selected.' title="'.htmlspecialchars($anObjectType->getDescription($cms_language)).'">'.$anObjectType->getObjectLabel($cms_language).'</option>';
					}
					$content .= '</optgroup>';
				}
				//poly objects
				if (sizeof($poly_types) > 1) {
					$content .= '<optgroup label="'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_POLY_OBJECTS).'">';
					foreach ($poly_types as $anObjectType) {
						//a poly object can't use itself or can't use an object who already use itself (infinite loop)
						if ($object->getID() != $anObjectType->getID() && !in_array($anObjectType->getID(),$objectUseage)) {
							//load fields objects for object
							$objectFields = CMS_poly_object_catalog::getFieldsDefinition($anObjectType->getID());
							//a poly object can't be empty
							if(sizeof($objectFields)) {
								$selected = ($field->getValue("type") == $anObjectType->getID()) ? ' selected="selected"':'';
								$content .= '<option value="'.$anObjectType->getID().'"'.$selected.' title="'.htmlspecialchars($anObjectType->getDescription($cms_language)).'">'.$anObjectType->getObjectLabel($cms_language).'</option>';
							}
						}
					}
					$content .= '</optgroup>';
				}
				if (sizeof($poly_types) > 1) {
					$content .= '<optgroup label="'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_MULTI).' '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_POLY_OBJECTS).'">';
					//multi poly objects
					foreach ($poly_types as $anObjectType) {
						//a poly object can't use itself or can't use an object who already use itself (infinite loop)
						if ($object->getID() != $anObjectType->getID() && !in_array($anObjectType->getID(),$objectUseage)) {
							//load fields objects for object
							$objectFields = CMS_poly_object_catalog::getFieldsDefinition($anObjectType->getID());
							//a poly object can't be empty
							if(sizeof($objectFields)) {
								$selected = ($field->getValue("type") == 'multi|'.$anObjectType->getID()) ? ' selected="selected"':'';
								$content .= '<option value="multi|'.$anObjectType->getID().'"'.$selected.' title="'.htmlspecialchars($anObjectType->getDescription($cms_language)).'">'.$anObjectType->getObjectLabel($cms_language).'</option>';
							}
						}
					}
					$content .= '</optgroup>';
				}
				$content .= '
			</select>';
		} else {
			$content .= '
			<strong>'.$typeObject->getObjectLabel($cms_language).'</strong>
			<input type="hidden" name="type" value="'.$field->getValue("type").'" />';
		}
	if (is_object($typeObject)) {
		$content .= '<br /><br /><strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</strong> : '.$typeObject->getDescription($cms_language).'
			</td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</td>
			<td class="admin" width="80%">'.$label->getHTMLAdmin('label').'</td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</td>
			<td class="admin" width="80%">'.$description->getHTMLAdmin('description',true).'</td>
		</tr>';
		if ($parametersHTML) {
			$content .= '
			<tr>
				<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PARAMS).'</td>
				<td class="admin">'.$parametersHTML.'</td>
			</tr>';
		}
		$content .= '
		<tr>
			<td class="admin" align="right" valign="top">&nbsp;</td>
			<td class="admin"><label for="required"><input type="checkbox" id="required" name="required" value="1"'.$required.' />&nbsp;'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REQUIRED).'</label></td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">&nbsp;</td>
			<td class="admin"><label for="searchable"><input type="checkbox" id="searchable" name="searchable" value="1"'.$searchable.' />&nbsp;'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_SEARCHABLE).'</label></td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">&nbsp;</td>
			<td class="admin"><label for="searchlist"><input type="checkbox" id="searchlist" name="searchlist" value="1"'.$searchlist.' />&nbsp;'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_SEARCHLIST).'</label></td>
		</tr>';
		//if ASE module exists, add field indexation options
		if (class_exists('CMS_module_ase')) {
			$content .= '
			<tr>
				<td class="admin" align="right" valign="top">&nbsp;</td>
				<td class="admin"><label for="indexable"><input type="checkbox" id="indexable" name="indexable" value="1"'.$indexable.' />&nbsp;'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_INDEXABLE,false, MOD_POLYMOD_CODENAME).'</label></td>
			</tr>';
		}
		$content .= '
		<tr>
			<td colspan="2"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
		</tr>';
	} else {
		$content .= '</td>
		</tr>';
	}
	$content .= '
	</form>
	</table>';

$content .= '
	<br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />
';

$dialog->setContent($content);
$dialog->show();
?>