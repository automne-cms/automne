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
// $Id: polymod_object.php,v 1.2 2010/03/08 16:41:40 sebastien Exp $

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

/*
 * Standard messages
 */
define("MESSAGE_PAGE_TITLE", 1229);
define("MESSAGE_PAGE_TITLE_APPLICATIONS", 264);
define("MESSAGE_PAGE_CHOOSE", 1132);
define("MESSAGE_PAGE_ACTION_NEW", 262);
define("MESSAGE_PAGE_EMPTY_SET", 265);
define("MESSAGE_PAGE_CHOOSE_MODULE", 1225);
define("MESSAGE_PAGE_CHOOSE_OBJECTS", 1226);
define("MESSAGE_PAGE_OBJECTS", 1227);
define("MESSAGE_PAGE_APPLICATION", 1228);
define("MESSAGE_PAGE_FIELD_TITLE", 132);
define("MESSAGE_PAGE_FIELD_ACTIONS", 259);
define("MESSAGE_PAGE_ACTION_DELETE", 252);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_FIELD_RESOURCE",1230);
define("MESSAGE_PAGE_FIELD_RESOURCE_NONE",195);
define("MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY",1231);
define("MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY",1232);
define("MESSAGE_PAGE_FIELD_RESOURCE_EXPLANATION",1233);
define("MESSAGE_FORM_ERROR_LINK_MANDATORY", 802);
define("MESSAGE_PAGE_FIELD_YES", 1082);
define("MESSAGE_PAGE_FIELD_NO", 1083);
define("MESSAGE_PAGE_FIELD_EDITABLE", 1271);
define("MESSAGE_PAGE_FIELD_ONLY_FOR_ADMIN", 1276);
define("MESSAGE_PAGE_FIELD_COMPOSED_LABEL", 1294);
define("MESSAGE_PAGE_FIELD_OBJECT_EXPLANATION", 1297);
define("MESSAGE_PAGE_TREEH1", 1049);

/*
 * Polymod messages
 */
define("MESSAGE_PAGE_FIELD_PREVIEW_URL", 254);
define("MESSAGE_PAGE_PLUGIN_DEFINITIONS", 275);
define("MESSAGE_PAGE_OBJECT_PROPERTIES", 276);
define("MESSAGE_PAGE_ACTION_DELETEPLUGINCONFIRM", 279);
define("MESSAGE_PAGE_OBJECT_INDEXABLE", 325);
define("MESSAGE_PAGE_OBJECT_INDEXATION", 326);
define("MESSAGE_PAGE_OBJECT_INDEXABLE_EXPLANATION", 327);
define("MESSAGE_PAGE_OBJECT_INDEXATION_LINK_TO", 328);
define("MESSAGE_PAGE_OBJECT_INDEXATION_LINK_TO_EXPLANATION", 329);
define("MESSAGE_PAGE_FIELD_SEARCH_RESULTS_DISPLAY", 420);
define("MESSAGE_PAGE_FIELD_SEARCH_RESULTS_DISPLAY_LEGEND", 421);
define("MESSAGE_PAGE_FIELD_OBJECT_SYNTAX", 421);

//checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

$moduleCodename = $_REQUEST["moduleCodename"];
$object = new CMS_poly_object_definition($_REQUEST["object"]);
$label = new CMS_object_i18nm($object->getValue("labelID"));
$description = new CMS_object_i18nm($object->getValue("descriptionID"));
$availableLanguagesCodes = CMS_object_i18nm::getAvailableLanguages();

if ($moduleCodename) {
	$polymod = CMS_modulesCatalog::getByCodename($moduleCodename);
}

// ****************************************************************
// ** ACTIONS MANAGEMENT                                         **
// ****************************************************************
switch ($_POST["cms_action"]) {
case "validate":
case "switchexplanation":
	//checks and assignments
	$cms_message = "";
	$object->setDebug(false);
	if (!$_POST["label".$availableLanguagesCodes[0]] || !$_POST["description".$availableLanguagesCodes[0]]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	}
	
	foreach($availableLanguagesCodes as $aLanguageCode) {
		$label->setValue($aLanguageCode, $_POST["label".$aLanguageCode]);
		$description->setValue($aLanguageCode, $_POST["description".$aLanguageCode]);
	}
	$label->writeToPersistence();
	$description->writeToPersistence();
	if (!$object->setValue("labelID", $label->getID())) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE)));
	}
	if (!$object->setValue("descriptionID", $description->getID())) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION)));
	}
	if (!$object->setValue("admineditable", $_POST["admineditable"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITABLE)));
	}
	if (!$object->setValue("resourceUsage",$_POST["resourceUsage"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE)));
	}
	//composed label
	$composedLabel = ($_POST["composedLabel"]) ? $polymod->convertDefinitionString($_POST["composedLabel"], false) : '';
	if (!$object->setValue("composedLabel",$composedLabel)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_COMPOSED_LABEL)));
	}
	// Admin search results display
	$definitionValue = $polymod->convertDefinitionString($_POST["resultsDefinition"], false);
	$definitionErrors = $object->setValue("resultsDefinition", $definitionValue);
	if ($definitionErrors !== true) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_SEARCH_RESULTS_DISPLAY,false,MOD_POLYMOD_CODENAME).' : '.$definitionErrors));
	}
	
	//previz URL
	if ($_POST["previewURL"]) {
		$previewURL = $polymod->convertDefinitionString($_POST["previewURL"], false);
		$previewPageID = (sensitiveIO::isPositiveInteger($_POST["previewPageID"])) ? $_POST["previewPageID"] : '';
		$previzInfos = $previewPageID.'||'.$previewURL;
		if (!$object->setValue("previewURL",$previzInfos)) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PREVIEW_URL,false,MOD_POLYMOD_CODENAME)));
		}
	} else {
		if (!$object->setValue("previewURL",'')) {
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
				array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PREVIEW_URL,false,MOD_POLYMOD_CODENAME)));
		}
	}
	//IndexURL
	$object->setValue("indexable", $_POST["indexable"]);
	if ($_POST["indexable"] && !$_POST["indexURL"]) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	}
	$indexURLValue = $polymod->convertDefinitionString($_POST["indexURL"], false);
	$URLErrors = $object->setValue("indexURL",$indexURLValue);
	if ($URLErrors !== true) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_OBJECT_INDEXATION_LINK_TO, false, MOD_POLYMOD_CODENAME).' : '.$definitionErrors));
	}
	$object->setValue("module",$moduleCodename);
	
	if (!$cms_message && $_POST["cms_action"] == "validate") {
		//save the data
		$object->writeToPersistence();
		header("Location: modules_admin.php?moduleCodename=".$moduleCodename."&object=".$object->getID()."&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
		exit;
	}
	break;
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_APPLICATIONS)." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE),'picto_modules.gif');
$dialog->setBacklink("modules_admin.php?moduleCodename=".$moduleCodename."&object=".$object->getID());
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
if (method_exists($dialog, 'addStopTab')) {
	$dialog->addStopTab();
	$stopTab = ' onkeydown="return catchTab(this,event)"';
}

$content = '
	<br />
	<table width="80%" border="0" cellpadding="3" cellspacing="2">
	<form name="frm" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="cms_action" id="cms_action" value="validate" />
	<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
	<input type="hidden" name="object" value="'.$object->getID().'" />
	<tr>
		<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</td>
		<td class="admin" width="90%">'.$label->getHTMLAdmin('label').'</td>
	</tr>
	<tr>
		<td class="admin" align="right" valign="top" nowrap="nowrap"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</td>
		<td class="admin">'.$description->getHTMLAdmin('description',true).'</td>
	</tr>
	<tr>
		<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE).'</td>
		<td class="admin">';
		
		if ($object->getID()) {
			$content .= '<strong>';
			switch($object->getValue("resourceUsage")) {
				case 0:
					$content .= $cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_NONE);
				break;
				case 1:
					$content .= $cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY);
				break;
				case 2:
					$content .= $cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY);
				break;
			}
			$content .= '</strong>
			<input type="hidden" name="resourceUsage" value="'.$object->getValue("resourceUsage").'" />';
		} else {
			$hasPrimaryResource = CMS_poly_object_catalog::hasPrimaryResource($moduleCodename);
			$objectResourceStatus = $object->getValue("resourceUsage");
			$selected = array(
				MESSAGE_PAGE_FIELD_RESOURCE_NONE => ($objectResourceStatus === 0 && $object->getID()) ? ' selected="selected"':'' ,
				MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY => ($objectResourceStatus == 2) ? ' selected="selected"':'' ,
			);
			$content .='
			<select name="resourceUsage" class="admin_input_text">
				<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>
				<option value="0"'.$selected[MESSAGE_PAGE_FIELD_RESOURCE_NONE].'>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_NONE).'</option>';
			if ($hasPrimaryResource) {// || $object->getID()) {
				$content .='<option value="2"'.$selected[MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY].'>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY).'</option>';
			} else {
				$content .='<option value="1">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY).'</option>';
			}
			$content .='
			</select>';
		}
		$notEditableSelected = ($object->getValue("admineditable") == 1) ? ' selected="selected"':'';
		$adminEditableSelected = ($object->getValue("admineditable") == 2) ? ' selected="selected"':'';
		
		/*if ($object->getID() && $object->isPrimaryResource()) {
			$content .= '<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY).'</strong>
			<input type="hidden" name="resourceUsage" value="1" />';
		} else {
			$hasPrimaryResource = CMS_poly_object_catalog::hasPrimaryResource($moduleCodename);
			$objectResourceStatus = $object->getValue("resourceUsage");
			$selected = array(
				MESSAGE_PAGE_FIELD_RESOURCE_NONE => ($objectResourceStatus === 0 && $object->getID()) ? ' selected="selected"':'' ,
				MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY => ($objectResourceStatus == 2) ? ' selected="selected"':'' ,
			);
			$content .='
			<select name="resourceUsage" class="admin_input_text">
				<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>
				<option value="0"'.$selected[MESSAGE_PAGE_FIELD_RESOURCE_NONE].'>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_NONE).'</option>';
			if ($hasPrimaryResource) {// || $object->getID()) {
				$content .='<option value="2"'.$selected[MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY].'>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY).'</option>';
			} else {
				$content .='<option value="1">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY).'</option>';
			}
			$content .='
			</select>';
		}
		$notEditableSelected = ($object->getValue("admineditable") == 1) ? ' selected="selected"':'';
		$adminEditableSelected = ($object->getValue("admineditable") == 2) ? ' selected="selected"':'';*/
$content .='
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td class="admin">
		<fieldset>
			<legend>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE).'</legend>
			'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE_EXPLANATION).'
		</fieldset>
		</td>
	</tr>';
	if ($object->getID()) {
		$fields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());
		if (sizeof($fields)) {
			$composedLabel='';
			if ($object->getValue("composedLabel")) {
				$composedLabel = $polymod->convertDefinitionString($object->getValue("composedLabel"), true);
			}
			if ($object->getValue("previewURL")) {
				$previzInfos = explode('||',$object->getValue("previewURL"));
				$previewPageID = (sensitiveIO::isPositiveInteger($previzInfos[0])) ? $previzInfos[0] : '';
				$previewURL = $polymod->convertDefinitionString($previzInfos[1], true);
			}
			$content.='
			<tr>
				<td class="admin" align="right" valign="top" nowrap="nowrap">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COMPOSED_LABEL).'</td>
				<td class="admin"><input type="text" size="100" name="composedLabel" value="'.$composedLabel.'" class="admin_input_text" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td class="admin">
				<fieldset>
					<legend>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_EXPLANATION, array($object->getLabel($cms_language))).'</legend>
					<br />';
					$content.='
					<select name="objectexplanation" class="admin_input_text" onchange="document.getElementById(\'cms_action\').value=\'switchexplanation\';document.frm.submit();">
						<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
						$content.= CMS_poly_module_structure::viewObjectInfosList($moduleCodename, $cms_language, $_POST['objectexplanation'], $object->getID());
					$content.='
					</select><br />';
					if ($_POST['objectexplanation']) {
						//object info
						$content.= CMS_poly_module_structure::viewObjectRowInfos($moduleCodename, $cms_language, $_POST['objectexplanation']);
					}
				$content.='
				</fieldset>
				</td>
			</tr>
			<tr>
				<td class="admin" align="right" valign="top" nowrap="nowrap">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PREVIEW_URL,false,MOD_POLYMOD_CODENAME).'</td>
				<td class="admin">';
				//build tree link
				$grand_root = CMS_tree::getRoot();
				$href = PATH_ADMIN_SPECIAL_TREE_WR;
				$href .= '?root='.$grand_root->getID();
				$href .= '&amp;heading='.$cms_language->getMessage(MESSAGE_PAGE_TREEH1);
				$href .= '&amp;encodedOnClick='.base64_encode("window.opener.document.getElementById('previewPageID').value = '%s';self.close();");
				$href .= '&encodedPageLink='.base64_encode('false');
				$treeLink .= '
							<a href="'.$href.'" class="admin" target="_blank">
							<img src="'.PATH_ADMIN_IMAGES_WR. '/picto-arbo.gif" border="0" align="absmiddle" /></a>';
				$content.='
					<input type="text" class="admin_input_text" id="previewPageID" name="previewPageID" value="'.$previewPageID.'" size="6" />'.$treeLink.'&nbsp;?<input type="text" size="80" name="previewURL" value="'.$previewURL.'" class="admin_input_text" />
				</td>
			</tr>
			';
		}
	}
	$content.='
	<tr>
		<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITABLE).'</td>
		<td class="admin"><select name="admineditable" class="admin_input_text">
				<option value="0">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_YES).'</option>
				<option value="1"'.$notEditableSelected.'>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_NO).'</option>
				<option value="2"'.$adminEditableSelected.'>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ONLY_FOR_ADMIN).'</option>
			</select>
		</td>
	</tr>';
	//if ASE module exists, add field indexation options
	if (class_exists('CMS_module_ase')) {
		//indexURL
		$indexURL = ($_POST["indexURL"]) ? $_POST["indexURL"] : $polymod->convertDefinitionString($object->getValue("indexURL"), true);
		
		
		$indexable = ($object->getValue("indexable")) ? ' checked="checked"':'';
		$content .= '
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_OBJECT_INDEXATION,false, MOD_POLYMOD_CODENAME).'</td>
			<td class="admin">
				<fieldset>
					<legend><label for="indexable"><input id="indexable" type="checkbox" name="indexable" value="1"'.$indexable.' />&nbsp;'.$cms_language->getMessage(MESSAGE_PAGE_OBJECT_INDEXABLE,false, MOD_POLYMOD_CODENAME).'</label></legend>
					'.$cms_language->getMessage(MESSAGE_PAGE_OBJECT_INDEXABLE_EXPLANATION,false, MOD_POLYMOD_CODENAME).'
					<br /><br />
					<span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_OBJECT_INDEXATION_LINK_TO,false, MOD_POLYMOD_CODENAME).' :
					<br />
					<textarea class="admin_textarea"'.$stopTab.' name="indexURL" rows="10" cols="100">'.htmlspecialchars($indexURL).'</textarea>
					'.$cms_language->getMessage(MESSAGE_PAGE_OBJECT_INDEXATION_LINK_TO_EXPLANATION,false, MOD_POLYMOD_CODENAME).'
					<br />';
					//selected value
					$selected['working'] = ($_POST['objectIndexURL'] == 'working') ? ' selected="selected"':'';
					$selected['vars'] = ($_POST['objectIndexURL'] == 'vars') ? ' selected="selected"':'';
					$content .= '
					<select name="objectIndexURL" class="admin_input_text" onchange="document.getElementById(\'cms_action\').value=\'switchexplanation\';document.frm.submit();">
						<option value="">'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_CHOOSE).'</option>
						<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">
							<option value="working"'.$selected['working'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
							<option value="vars"'.$selected['vars'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENRAL_VARS,false,MOD_POLYMOD_CODENAME).'</option>
						</optgroup>
						<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_OBJECTS_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">';
							$content.= CMS_poly_module_structure::viewObjectInfosList($moduleCodename, $cms_language, $_POST['objectIndexURL'], $object->getID());
						$content.= '
						</optgroup>';
				$content.= '
					</select><br />';
					//then display chosen object infos
					if ($_POST['objectIndexURL']) {
						switch ($_POST['objectIndexURL']) {
							case 'working':
								$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_WORKING_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
							break;
							case 'vars':
								$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_BLOCK_GENRAL_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
							break;
							default:
								//object info
								$content.= CMS_poly_module_structure::viewObjectRowInfos($moduleCodename, $cms_language, $_POST['objectIndexURL']);
							break;
						}
					}
				$content.='
				</fieldset>
			</td>
		</tr>';
	}
	if ($object->getID()) {
		// Admin search results display
		$resultsDefinition = ($_REQUEST['resultsDefinition']) ? $_REQUEST['resultsDefinition'] : $polymod->convertDefinitionString($object->getValue("resultsDefinition"),true);
		$resultsDefinition = htmlspecialchars($resultsDefinition);
		$content.='
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_SEARCH_RESULTS_DISPLAY,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin">
				<textarea name="resultsDefinition" '.$stopTab.' cols="130" rows="15" class="admin_textarea">'.$resultsDefinition.'</textarea>
			</td>
		</tr>';
		// Help object syntax
		$content.='
		<tr>
			<td>&nbsp;</td>
			<td class="admin">
			<fieldset>
				<legend>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_SYNTAX, array($object->getLabel($cms_language)),MOD_POLYMOD_CODENAME).'</legend>
				<br />';
				$content.='
				<select name="objectexplanation" class="admin_input_text" onchange="document.getElementById(\'cms_action\').value=\'switchexplanation\';document.frm.submit();">
					<option value="">'.$cms_language->getMessage(MESSAGE_PAGE_CHOOSE).'</option>';
					$content.= CMS_poly_module_structure::viewObjectInfosList($moduleCodename, $cms_language, $_POST['objectexplanation'], $object->getID());
				$content.='
				</select><br />';
				if ($_POST['objectexplanation']) {
					//object info
					$content.= CMS_poly_module_structure::viewObjectRowInfos($moduleCodename, $cms_language, $_POST['objectexplanation']);
				}
			$content.='
			</fieldset>
			</td>
		</tr>';
	}
	// Submit button
	$content.='
	<tr>
		<td colspan="2"><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
	</tr>
	</form>
	</table>
	<br />
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	<br /><br />';

$dialog->setContent($content);
$dialog->show();
?>