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
// $Id: polymod_rss_definition.php,v 1.2 2010/03/08 16:41:41 sebastien Exp $

/**
  * PHP page : polymod admin
  * Used to manage poly modules
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
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
define("MESSAGE_PAGE_TITLE", 292);
define("MESSAGE_PAGE_WORKING_TAGS", 113);
define("MESSAGE_PAGE_WORKING_TAGS_EXPLANATION", 114);
define("MESSAGE_PAGE_BLOCK_GENRAL_VARS", 140);
define("MESSAGE_PAGE_BLOCK_GENRAL_VARS_EXPLANATION", 139);
define("MESSAGE_PAGE_FIELD_RSS_DEF_EXPLANATION", 293);
define("MESSAGE_PAGE_RSS_TAG", 294);
define("MESSAGE_PAGE_RSS_TAG_EXPLANATION", 313);
define("MESSAGE_PAGE_SEARCH_TAGS", 109);
define("MESSAGE_PAGE_SEARCH_TAGS_EXPLANATION", 110);
define("MESSAGE_PAGE_FIELD_LINK", 296);
define("MESSAGE_PAGE_FIELD_LINK_EXPLANATION", 297);
define("MESSAGE_PAGE_FIELD_AUTHOR", 298);
define("MESSAGE_PAGE_FIELD_EMAIL", 299);
define("MESSAGE_PAGE_FIELD_COPYRIGHT", 300);
define("MESSAGE_PAGE_FIELD_CATEGORIES", 301);
define("MESSAGE_PAGE_FIELD_CATEGORIES_EXPLANATION", 302);
define("MESSAGE_PAGE_FIELD_UPDATE", 303);
define("MESSAGE_PAGE_FIELD_UPDATE_EXPLANATION", 304);
define("MESSAGE_PAGE_FIELD_FREQUENCY", 305);
define("MESSAGE_PAGE_FIELD_HOURLY", 306);
define("MESSAGE_PAGE_FIELD_DAILY", 307);
define("MESSAGE_PAGE_FIELD_WEEKLY", 308);
define("MESSAGE_PAGE_FIELD_MONTHLY", 309);
define("MESSAGE_PAGE_FIELD_YEARLY", 310);

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}
//load page objects and vars
$moduleCodename = ($_POST["moduleCodename"]) ? $_POST["moduleCodename"]:$_GET["moduleCodename"];
$object = new CMS_poly_object_definition($_POST["object"]);
$RSSDefinition = new CMS_poly_rss_definitions($_POST["RSSDefinition"]);

$label = new CMS_object_i18nm($RSSDefinition->getValue("labelID"));
$description = new CMS_object_i18nm($RSSDefinition->getValue("descriptionID"));

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
	$RSSDefinition->setDebug(false);
	//set objectID
	$RSSDefinition->setValue("objectID",$object->getID());
	
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
	if (!$RSSDefinition->setValue("labelID", $label->getID())) {
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
	if (!$RSSDefinition->setValue("descriptionID", $description->getID())) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION)));
	}
	//Definition
	$definitionValue = $polymod->convertDefinitionString($_POST["definition"], false);
	$definitionErrors = $RSSDefinition->setValue("definition",$definitionValue);
	if ($definitionErrors !== true) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_DEFINITION).' : '.$definitionErrors));
	}
	if (!$RSSDefinition->setValue("link",$_POST["link"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_LINK,false,MOD_POLYMOD_CODENAME)));
	}
	if (!$RSSDefinition->setValue("author",$_POST["author"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_AUTHOR,false,MOD_POLYMOD_CODENAME)));
	}
	if (!$RSSDefinition->setValue("copyright",$_POST["copyright"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_COPYRIGHT,false,MOD_POLYMOD_CODENAME)));
	}
	if (!$RSSDefinition->setValue("categories",$_POST["categories"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORIES,false,MOD_POLYMOD_CODENAME)));
	}
	if ($_POST["email"] && !$RSSDefinition->setValue("email",$_POST["email"])) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_EMAIL,false,MOD_POLYMOD_CODENAME)));
	}
	//TTL (Time to live in minutes)//TTL
	$baseList = array(
		'hourly' 	=> 60,
		'daily' 	=> 1440,
		'weekly' 	=> 10080,
		'monthly' 	=> 43200,
		'yearly' 	=> 525600,
	);
	if (!sensitiveIO::isPositiveInteger($_POST['frequency'])) {
		$_POST['frequency'] = 1;
	}
	$ttl = (int) ($baseList[$_POST['update']] / $_POST['frequency']);
	if (!$ttl) {
		$ttl = 1440;
	} elseif ($ttl < 30) {
		$ttl = 30;
	}
	if (!$RSSDefinition->setValue("ttl",$ttl)) {
		$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
			array($cms_language->getMessage(MESSAGE_PAGE_FIELD_FREQUENCY,false,MOD_POLYMOD_CODENAME)));
	}
	
	if (!$cms_message && $_POST["cms_action"] == "validate") {
		//save the data
		$RSSDefinition->writeToPersistence();
		
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

//TTL (Time to live in minutes)
$baseList = array(
	'hourly' 	=> 60,
	'daily' 	=> 1440,
	'weekly' 	=> 10080,
	'monthly' 	=> 43200,
	'yearly' 	=> 525600,
);
$baseListLabels = array(
	'hourly' 	=> MESSAGE_PAGE_FIELD_HOURLY,
	'daily' 	=> MESSAGE_PAGE_FIELD_DAILY,
	'weekly' 	=> MESSAGE_PAGE_FIELD_WEEKLY,
	'monthly' 	=> MESSAGE_PAGE_FIELD_MONTHLY,
	'yearly' 	=> MESSAGE_PAGE_FIELD_YEARLY,
);
$selectedBaseList = '';
foreach ($baseList as $key => $value) {
	if (!$selectedBaseList && $value % $RSSDefinition->getValue('ttl') == 0) {
		$selectedBaseList = $key;
		$updateFrequency = $value / $RSSDefinition->getValue('ttl');
	}
}
if (!$selectedBaseList) {
	$selectedBaseList = 'daily';
}
if (!$updateFrequency) {
	$updateFrequency = 1;
}
$updateList = '';
foreach ($baseListLabels as $key => $listLabel) {
	$updateList .= '<option value="'.$key.'"'.(($key == $selectedBaseList) ? ' selected="selected"':'').'>'.$cms_language->getMessage($listLabel, false, MOD_POLYMOD_CODENAME).'</option>';
}

//Definition
$definition = ($_POST["definition"]) ? $_POST["definition"] : $polymod->convertDefinitionString($RSSDefinition->getValue("definition"), true);

$content = '
	<table width="80%" border="0" cellpadding="3" cellspacing="2">
	<form name="frm" action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" id="cms_action" name="cms_action" value="validate" />
	<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
	<input type="hidden" name="object" value="'.$object->getID().'" />
	<input type="hidden" name="RSSDefinition" value="'.$RSSDefinition->getID().'" />
		<tr>
			<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_TITLE).'</td>
			<td class="admin" width="80%">'.$label->getHTMLAdmin('label').'</td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top" nowrap="nowrap"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).'</td>
			<td class="admin" width="80%">'.$description->getHTMLAdmin('description',true).'</td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LINK,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin" width="80%"><input type="text" class="admin_input_long_text" name="link" value="'.$RSSDefinition->getValue('link').'" /><br /><small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LINK_EXPLANATION,array(CMS_websitesCatalog::getMainURL()),MOD_POLYMOD_CODENAME).')</small></td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_AUTHOR,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin" width="80%"><input type="text" class="admin_input_long_text" name="author" value="'.$RSSDefinition->getValue('author').'" /></td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EMAIL,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin" width="80%"><input type="text" class="admin_input_long_text" name="email" value="'.$RSSDefinition->getValue('email').'" /></td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COPYRIGHT,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin" width="80%"><input type="text" class="admin_input_long_text" name="copyright" value="'.$RSSDefinition->getValue('copyright').'" /></td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORIES,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin" width="80%"><input type="text" class="admin_input_long_text" name="categories" value="'.$RSSDefinition->getValue('categories').'" /><br /><small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CATEGORIES_EXPLANATION,false,MOD_POLYMOD_CODENAME).')</small></td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_UPDATE,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin" width="80%"><select name="update" class="admin_input_text">'.$updateList.'</select><br /><small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_UPDATE_EXPLANATION,false,MOD_POLYMOD_CODENAME).')</small></td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FREQUENCY,false,MOD_POLYMOD_CODENAME).'</td>
			<td class="admin" width="80%"><input type="text" class="admin_input_text" name="frequency" value="'.$updateFrequency.'" /></td>
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
				<legend>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RSS_DEF_EXPLANATION, array($object->getLabel($cms_language)), MOD_POLYMOD_CODENAME).'</legend>
				<br />';
				//selected value
				$selected['working'] = ($_POST['objectexplanation'] == 'working') ? ' selected="selected"':'';
				$selected['search'] = ($_POST['objectexplanation'] == 'search') ? ' selected="selected"':'';
				$selected['vars'] = ($_POST['objectexplanation'] == 'vars') ? ' selected="selected"':'';
				$selected['rss'] = ($_POST['objectexplanation'] == 'rss') ? ' selected="selected"':'';
				
				$content.= '
				<select name="objectexplanation" class="admin_input_text" onchange="document.getElementById(\'cms_action\').value=\'switchexplanation\';document.frm.submit();">
					<option value="">'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_CHOOSE).'</option>
					<optgroup label="'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_ROW_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">
						<option value="rss"'.$selected['rss'].'>'.$cms_language->getMessage(MESSAGE_PAGE_RSS_TAG,false,MOD_POLYMOD_CODENAME).'</option>
						<option value="search"'.$selected['search'].'>'.$cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_SEARCH_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
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
						case 'rss':
							$moduleLanguages = CMS_languagesCatalog::getAllLanguages($moduleCodename);
							foreach ($moduleLanguages as $moduleLanguage) {
								$moduleLanguagesCodes[] = $moduleLanguage->getCode();
							}
							$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_RSS_TAG_EXPLANATION,array(implode(', ',$moduleLanguagesCodes)),MOD_POLYMOD_CODENAME);
						break;
						case 'search':
							$content.= $cms_language->getMessage(CMS_polymod::MESSAGE_PAGE_SEARCH_TAGS_EXPLANATION,array(implode(', ',CMS_object_search::getStaticSearchConditionTypes()), implode(', ',CMS_object_search::getStaticOrderConditionTypes())),MOD_POLYMOD_CODENAME);
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