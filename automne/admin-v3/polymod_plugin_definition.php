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
// $Id: polymod_plugin_definition.php,v 1.2 2010/03/08 16:41:41 sebastien Exp $

/**
  * PHP page : polymod admin
  * Used to manage poly modules
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_FIELD_TITLE", 132);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_TITLE_APPLICATIONS", 264);
define("MESSAGE_PAGE_FIELD_OBJECT_EXPLANATION", 1297);
define("MESSAGE_PAGE_FIELD_DEFINITION", 846);
define("MESSAGE_FORM_ERROR_LINK_MANDATORY", 802);

/*
 * Polymod messages
 */
define("MESSAGE_PAGE_TITLE", 277);
define("MESSAGE_PAGE_FIELD_OBJECT_PARAMETERS", 199);
define("MESSAGE_PAGE_WORKING_TAGS", 113);
define("MESSAGE_PAGE_WORKING_TAGS_EXPLANATION", 114);
define("MESSAGE_PAGE_BLOCK_GENRAL_VARS", 140);
define("MESSAGE_PAGE_BLOCK_GENRAL_VARS_EXPLANATION", 139);
define("MESSAGE_PAGE_FIELD_PLUGIN_DEF_EXPLANATION", 278);
define("MESSAGE_PAGE_PLUGIN_TAG", 287);
define("MESSAGE_PAGE_PLUGIN_TAG_EXPLANATION", 288);

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
//load page objects and vars
$moduleCodename = ($_POST["moduleCodename"]) ? $_POST["moduleCodename"]:$_GET["moduleCodename"];
$object = new CMS_poly_object_definition($_POST["object"]);
$pluginDefinition = new CMS_poly_plugin_definitions($_POST["pluginDefinition"]);

$label = new CMS_object_i18nm($pluginDefinition->getValue("labelID"));
$description = new CMS_object_i18nm($pluginDefinition->getValue("descriptionID"));

$availableLanguagesCodes = CMS_object_i18nm::getAvailableLanguages();

if ($moduleCodename) {
	$polymod = CMS_modulesCatalog::getByCodename($moduleCodename);
}

$cms_message = "";
// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($_POST["cms_action"]) {
case "validate":
case "switchexplanation":
	//checks and assignments
	$pluginDefinition->setDebug(false);
	//set objectID
	$pluginDefinition->setValue("objectID",$object->getID());
	
	if (!$_POST["label".$availableLanguagesCodes[0]] || !$_POST["description".$availableLanguagesCodes[0]] || !$_POST["definition"]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	}
	
	if ($_POST["label".$availableLanguagesCodes[0]]) {
		foreach($availableLanguagesCodes as $aLanguageCode) {
			$label->setValue($aLanguageCode, $_POST["label".$aLanguageCode]);
		}
		if ($_POST["cms_action"] == 'validate') {
			$label->writeToPersistence();
		}
	}
	if (!$pluginDefinition->setValue("labelID", $label->getID())) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE)));
	}
	
	if ($_POST["description".$availableLanguagesCodes[0]]) {
		foreach($availableLanguagesCodes as $aLanguageCode) {
			$description->setValue($aLanguageCode, $_POST["description".$aLanguageCode]);
		}
		if ($_POST["cms_action"] == 'validate') {
			$description->writeToPersistence();
		}
	}
	if (!$pluginDefinition->setValue("descriptionID", $description->getID())) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION)));
	}
	//Definition
	$definitionValue = $polymod->convertDefinitionString($_POST["definition"], false);
	$definitionErrors = $pluginDefinition->setValue("definition",$definitionValue);
	if ($definitionErrors !== true) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_DEFINITION).' : '.$definitionErrors));
	}
	if (!$pluginDefinition->setValue("query",$_POST["searchedObjects"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_PARAMETERS,false,MOD_POLYMOD_CODENAME)));
	}
	
	if (!$cms_message && $_POST["cms_action"] == "validate") {
		//save the data
		$pluginDefinition->writeToPersistence();
		
		header("Location: modules_admin.php?moduleCodename=".$moduleCodename."&object=".$object->getID()."&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
		exit;
	} elseif ($_POST["cms_action"] != "validate") {
		$cms_message = '';
	}
	break;
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_APPLICATIONS)." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, array($object->getLabel($cms_languege)), MOD_POLYMOD_CODENAME),'picto_modules.gif');
$dialog->setBacklink("modules_admin.php?moduleCodename=".$moduleCodename."&object=".$object->getID());
if (method_exists($dialog, 'addStopTab')) {
	$dialog->addStopTab();
	$stopTab = ' onkeydown="return catchTab(this,event)"';
}

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$searchParameters = $object->getHTMLSubFieldsParametersSearch($cms_language, '', $pluginDefinition->getValue("query"));
//Definition
$definition = ($_POST["definition"]) ? $_POST["definition"] : $polymod->convertDefinitionString($pluginDefinition->getValue("definition"), true);

$content = '
	<table width="80%" border="0" cellpadding="3" cellspacing="2">
	<form name="frm" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" id="cms_action" name="cms_action" value="validate" />
	<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
	<input type="hidden" name="object" value="'.$object->getID().'" />
	<input type="hidden" name="pluginDefinition" value="'.$pluginDefinition->getID().'" />
		<tr>
			<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</td>
			<td class="admin" width="80%">'.$label->getHTMLAdmin('label').'</td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top" nowrap="nowrap"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</td>
			<td class="admin" width="80%">'.$description->getHTMLAdmin('description',true).'</td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_PARAMETERS,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin">'.$searchParameters.'</td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DEFINITION).'</td>
			<td class="admin">
				<textarea class="admin_textarea"'.$stopTab.' name="definition" rows="15" cols="130">'.htmlspecialchars($definition).'</textarea>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td class="admin">
			<fieldset>
				<legend>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PLUGIN_DEF_EXPLANATION, array($object->getLabel($cms_language)), MOD_POLYMOD_CODENAME).'</legend>
				<br />';
				//selected value
				$selected['working'] = ($_POST['objectexplanation'] == 'working') ? ' selected="selected"':'';
				$selected['vars'] = ($_POST['objectexplanation'] == 'vars') ? ' selected="selected"':'';
				$selected['plugins'] = ($_POST['objectexplanation'] == 'plugins') ? ' selected="selected"':'';
				
				$content.= '
				<select name="objectexplanation" class="admin_input_text" onchange="document.getElementById(\'cms_action\').value=\'switchexplanation\';document.frm.submit();">
					<option value="">'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_CHOOSE).'</option>
					<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">
						<option value="plugins"'.$selected['plugins'].'>'.$cms_language->getMessage(MESSAGE_PAGE_PLUGIN_TAG,false,MOD_POLYMOD_CODENAME).'</option>
						<option value="working"'.$selected['working'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
						<option value="vars"'.$selected['vars'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENRAL_VARS,false,MOD_POLYMOD_CODENAME).'</option>
					</optgroup>
					<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_OBJECTS_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">';
						$content.= CMS_poly_module_structure::viewObjectInfosList($moduleCodename, $cms_language, $_POST['objectexplanation'], $object->getID());
					$content.= '
					</optgroup>';
				$content.= '
				</select><br /><br />';
				
				
				//then display chosen object infos
				if ($_POST['objectexplanation']) {
					switch ($_POST['objectexplanation']) {
						case 'plugins':
							$moduleLanguages = CMS_languagesCatalog::getAllLanguages($moduleCodename);
							foreach ($moduleLanguages as $moduleLanguage) {
								$moduleLanguagesCodes[] = $moduleLanguage->getCode();
							}
							$content.= $cms_language->getMessage(MESSAGE_PAGE_PLUGIN_TAG_EXPLANATION,array(implode(', ',$moduleLanguagesCodes)),MOD_POLYMOD_CODENAME);
						break;
						case 'working':
							$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
						break;
						case 'vars':
							$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENRAL_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
						break;
						default:
							//object info
							$content.= CMS_poly_module_structure::viewObjectRowInfos($moduleCodename, $cms_language, $_POST['objectexplanation']);
						break;
					}
				}
			$content.='
			</fieldset>
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
		</tr>
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