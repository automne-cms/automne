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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: content_block.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : page content block edition : text
  * Used to edit a block of text data inside a page.
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//Standard module messages
define("MESSAGE_PAGE_VALIDATE_ERROR", 178);
define("MESSAGE_PAGE_FIELD_DATE_COMMENT", 148);
define("MESSAGE_PAGE_ACTION_DATE", 1284);
define("MESSAGE_EMPTY_OBJECTS_SET", 265);

//Messages specific to polymodule
define("MESSAGE_PAGE_TITLE", 124);
define("MESSAGE_PAGE_SUBTITLE", 125);
define("MESSAGE_PAGE_FIELD_KEYWORDS", 18);
define("MESSAGE_PAGE_SEARCH_ROW_ERROR", 126);
define("MESSAGE_PAGE_SEARCH_FIELD_ERROR", 127);
define("MESSAGE_PAGE_FIELD_LIMIT", 128);
define("MESSAGE_PAGE_FIELD_ORDER_ASC", 129);
define("MESSAGE_PAGE_FIELD_ORDER_DESC", 130);
define("MESSAGE_PAGE_FIELD_ORDER", 131);
define("MESSAGE_PAGE_FIELD_ORDER_OBJECTID", 132);
define("MESSAGE_PAGE_SEARCH_FIELDTYPE_ERROR", 133);
define("MESSAGE_PAGE_FIELD_PUBLISHED_FROM", 134);
define("MESSAGE_PAGE_FIELD_PUBLISHED_TO", 135);
define("MESSAGE_PAGE_SEARCH_ORDERTYPE_ERROR", 136);
define("MESSAGE_PAGE_FIELD_ORDER_PUBLICATION_START", 137);
define("MESSAGE_PAGE_FIELD_ORDER_PUBLICATION_END", 138);

//RIGHTS CHECK
$cms_page = $cms_context->getPage();
if (!is_object($cms_page) || $cms_page->hasError()
	|| !$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id()));
	exit;
}

//ARGUMENTS CHECK
if (!SensitiveIO::isPositiveInteger($_POST["page"])
	|| !$_POST["clientSpace"]
	|| !$_POST["row"]
	|| !$_POST["rowID"]
	|| !$_POST["block"]) {
	die("Data missing.");
}
//instanciate block
$cms_block = new CMS_block_polymod();
$cms_block->initializeFromID($_POST["block"], $_POST["rowID"]);
//instanciate block module
$cms_module = CMS_modulesCatalog::getByCodename($cms_block->getAttribute('module'));
//get block datas if any
$data = $cms_block->getRawData($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false);
//get block parameters requirements
$blockParamsDefinition = $cms_block->getBlockParametersRequirement($data["value"], $cms_page, true);
//instanciate row
$row = new CMS_row($_POST["rowID"]);

//Action management	
switch ($_POST["cms_action"]) {
case "setParameters":
	$cms_message = "";
	//checks and assignments
	$formok = true;
	if (sizeof($blockParamsDefinition['search'])) {
		foreach ($blockParamsDefinition['search'] as $searchName => $searchParams) {
			foreach ($searchParams as $paramType => $paramValue) {
				switch ($paramType) {
					case 'keywords':
					case 'category':
					case 'limit':
						if ($paramValue && !$_POST["value"]['search'][$searchName][$paramType]) { //mandatory ?
							$formok = false;
						}
						if ($paramType == 'limit' && $_POST["value"]['search'][$searchName][$paramType] && !sensitiveIO::IspositiveInteger($_POST["value"]['search'][$searchName][$paramType])) {
							$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
								array($cms_language->getMessage(MESSAGE_PAGE_FIELD_LIMIT, false, MOD_POLYMOD_CODENAME)))."\n";
						}
					break;
					case 'publication date after':
					case 'publication date before':
							if ($paramValue && !$_POST["value"]['search'][$searchName][$paramType]) { //mandatory ?
								$formok = false;
							} elseif ($_POST["value"]['search'][$searchName][$paramType]) {
								//replace localised date value by db format corresponding value
								$date = new CMS_date();
								$date->setFormat($cms_language->getDateFormat());
								if ($date->setLocalizedDate($_POST["value"]['search'][$searchName][$paramType])) {
									$_POST["value"]['search'][$searchName][$paramType] = $date->getDBValue();
								} else {
									$label = ($paramType == 'publication date after') ? MESSAGE_PAGE_FIELD_PUBLISHED_FROM : MESSAGE_PAGE_FIELD_PUBLISHED_TO;
									$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
										array($cms_language->getMessage($label, false, MOD_POLYMOD_CODENAME)))."\n";
								}
							}
						break;
					case 'order':
						if (sizeof($paramValue)) {
							foreach ($paramValue as $orderName => $orderValue) {
								// Order direction
								if ($paramValue && !$_POST["value"]['search'][$searchName][$paramType][$orderName]) { //mandatory ?
									$formok = false;
								}
							}
						}
					break;
					default:
						if (sensitiveIO::isPositiveInteger($paramType)) {
							if ($paramValue && !$_POST["value"]['search'][$searchName][$paramType]) { //mandatory ?
								$formok = false;
							}
						}
					break;
				}
			}
		}
	}
	if (!$formok) {
		$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
	} else {
		if (!$cms_block->writeToPersistence($_POST["page"], $_POST["clientSpace"], $_POST["row"], RESOURCE_LOCATION_EDITION, false, array("value"=>$_POST['value']))) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_VALIDATE_ERROR)."\n";
		}
		if (!$cms_message) {
			header("Location: ".PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR."?".session_name()."=".session_id());
			exit;
		}
	}
	$data["value"] = $_POST["value"];
	break;
}

// +----------------------------------------------------------------------+
// | Render                                                               |
// +----------------------------------------------------------------------+

$content = '';
$dialog = new CMS_dialog();
$dialog->setBackLink(PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR);
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE, array($row->getLabel(), $cms_module->getLabel($cms_language)), MOD_POLYMOD_CODENAME));
//add calendar javascript
$dialog->addCalendar();

if (sizeof($blockParamsDefinition['search'])) {
	$content .= '
	<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
	<input type="hidden" name="page" value="'.$_POST['page'].'" />
	<input type="hidden" name="clientSpace" value="'.$_POST['clientSpace'].'" />
	<input type="hidden" name="row" value="'.$_POST['row'].'" />
	<input type="hidden" name="rowID" value="'.$_POST['rowID'].'" />
	<input type="hidden" name="block" value="'.$_POST['block'].'" />
	<input type="hidden" name="cms_action" value="setParameters" />
	<input type="hidden" name="polymod" value="'.$cms_module->getCodename().'" />';
	foreach ($blockParamsDefinition['search'] as $searchName => $searchParams) {
		//load searched object
		$object = new CMS_poly_object_definition($searchParams['searchType']);
		if (!$object->hasError()) {
			//load fields objects for object
			$objectFields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());
			$searchParamContent = '';
			foreach ($searchParams as $paramType => $paramValue) {
				switch ($paramType) {
					case 'keywords':
						// Keywords
						$mandatory = ($paramValue == true) ? '<span class="admin_text_alert">*</span> ':'';
						$searchParamContent .= '
							<tr valign="top">
								<td class="admin">'.$mandatory.$cms_language->getMessage(MESSAGE_PAGE_FIELD_KEYWORDS, false, MOD_POLYMOD_CODENAME).'&nbsp;:</td>
								<td class="admin">
									<input type="text" name="value[search]['.$searchName.']['.$paramType.']" value="'.str_replace('"', '\"', $data["value"]['search'][$searchName][$paramType] ).'" class="admin_input_text" size="30" style="width:250px;" /></td>
							</tr>';
					break;
					case 'category':
						//categories
						//this search type is deprecated, keep it for compatibility but now it is replaced by direct field id access
						$mandatory = ($paramValue == true) ? '<span class="admin_text_alert">*</span> ':'';
						$fieldsCategories = $object->hasCategories();
						$fieldIDCategories = $fieldsCategories[0];
						if (sensitiveIO::IsPositiveInteger($fieldIDCategories)) {
							$fieldCategories = $objectFields[$fieldIDCategories];
							$objectCategories = $fieldCategories->getTypeObject();
							// Categories
							$a_all_categories = $objectCategories->getAllCategoriesAsArray($cms_language, false, $cms_module->getCodename());
							if (sizeof($a_all_categories)) {
								$s_categories_listbox = CMS_moduleCategories_catalog::getListBox(
									array (
									'field_name' 		=> 'value[search]['.$searchName.']['.$paramType.']',	// Select field name to get value in
									'items_possible' 	=> $a_all_categories,									// array of all categories availables: array(ID => label)
									'default_value' 	=> $data["value"]['search'][$searchName][$paramType],	// Same format
									'attributes' 		=> 'class="admin_input_text" style="width:250px;"'
									)
								);
								$searchParamContent .= '
									<tr>
										<td class="admin">'.$mandatory.$fieldCategories->getLabel($cms_language).'&nbsp;:</td>
										<td class="admin">'.$s_categories_listbox.'</td>
									</tr>';
							}
						}
					break;
					case 'limit':
						// Limit
						$mandatory = ($paramValue == true) ? '<span class="admin_text_alert">*</span> ':'';
						$searchParamContent .= '
							<tr valign="top">
								<td class="admin">'.$mandatory.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LIMIT, false, MOD_POLYMOD_CODENAME).'&nbsp;:</td>
								<td class="admin">
									<input type="text" name="value[search]['.$searchName.']['.$paramType.']" value="'.str_replace('"', '\"', $data["value"]['search'][$searchName][$paramType] ).'" class="admin_input_text" size="5" /></td>
							</tr>';
					break;
					case 'order':
						if (sizeof($paramValue)) {
							$searchParamContent .= '
							<tr valign="top">
										<td class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ORDER, false, MOD_POLYMOD_CODENAME).'&nbsp;:</td>
										<td class="admin"><table border="0" cellpadding="3" cellspacing="0" style="border-left:1px solid #4d4d4d;">';
							foreach ($paramValue as $orderName => $orderValue) {
								if (in_array($orderName, CMS_object_search::getStaticOrderConditionTypes())) {
									// Order direction
									$mandatory = ($paramValue == true) ? '<span class="admin_text_alert">*</span> ':'';
									$orderNameList = array(
										'objectID' => MESSAGE_PAGE_FIELD_ORDER_OBJECTID,
										'publication date after' => MESSAGE_PAGE_FIELD_ORDER_PUBLICATION_START,
										'publication date before' => MESSAGE_PAGE_FIELD_ORDER_PUBLICATION_END,
									);
									$selectedAsc = ($data["value"]['search'][$searchName][$paramType][$orderName] == 'asc') ? ' selected="selected"':'';
									$selectedDesc = ($data["value"]['search'][$searchName][$paramType][$orderName] == 'desc') ? ' selected="selected"':'';
									$searchParamContent .= '
										<tr valign="top">
											<td class="admin" nowrap="nowrap">'.$mandatory.$cms_language->getMessage($orderNameList[$orderName], false, MOD_POLYMOD_CODENAME).'&nbsp;:</td>
											<td class="admin">
												<select name="value[search]['.$searchName.']['.$paramType.']['.$orderName.']" class="admin_input_text">
													<option value=""></option>
													<option value="asc"'.$selectedAsc.'>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ORDER_ASC, false, MOD_POLYMOD_CODENAME).'</option>
													<option value="desc"'.$selectedDesc.'>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_ORDER_DESC, false, MOD_POLYMOD_CODENAME).'</option>
												</select>
											</td>
										</tr>';
								} else {
									$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_ORDERTYPE_ERROR, array($searchName, $row->getLabel(), $orderName), MOD_POLYMOD_CODENAME)."\n";
								}
							}
							$searchParamContent .= '</table></td></tr>';
						}
					break;
					case 'searchType':
						//nothing, this is not a search parameter
					break;
					case 'publication date after':
					case 'publication date before':
						// Dates
						$mandatory = ($paramValue == true) ? '<span class="admin_text_alert">*</span> ':'';
						//create object CMS_date
						$date = new CMS_date();
						$date->setFromDBValue($data["value"]['search'][$searchName][$paramType]);
						$label = ($paramType == 'publication date after') ? MESSAGE_PAGE_FIELD_PUBLISHED_FROM : MESSAGE_PAGE_FIELD_PUBLISHED_TO;
						$date_mask = $cms_language->getDateFormatMask();
						$searchParamContent .= '
							<tr valign="top">
								<td class="admin">'.$mandatory.$cms_language->getMessage($label, false, MOD_POLYMOD_CODENAME).'&nbsp;:<br /><small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DATE_COMMENT, array($date_mask)).')</small></td>
								<td class="admin" valign="top">
									<input type="text" size="15" class="admin_input_text" id="value[search]['.$searchName.']['.$paramType.']" name="value[search]['.$searchName.']['.$paramType.']" value="'.$date->getLocalizedDate($cms_language->getDateFormat()).'" />&nbsp;<img src="' .PATH_ADMIN_IMAGES_WR .'/calendar/calendar.gif" class="admin_input_submit_content" align="absmiddle" title="'.$cms_language->getMessage(MESSAGE_PAGE_ACTION_DATE).'" onclick="displayCalendar(document.getElementById(\'value[search]['.$searchName.']['.$paramType.']\'),\''.$cms_language->getCode().'\',this);return false;" />
								</td>
							</tr>';
					break;
					default:
						if (sensitiveIO::isPositiveInteger($paramType)) {
							//subobjects
							$mandatory = ($paramValue == true) ? '<span class="admin_text_alert">*</span> ':'';
							$field = $objectFields[$paramType];
							if (is_object($field)) {
								//check if field has a method to provide a list of names
								$objectType = $field->getTypeObject();
								if (method_exists($objectType, 'getListOfNamesForObject')) {
									//check if we can associate unused objects
									if (method_exists($objectType, 'getParamsValues') && $params = $objectType->getParamsValues() && isset($params['associateUnused']) && isset($params['associateUnused'])) {
										$objectsNames = $objectType->getListOfNamesForObject(true, array(), false);
									} else {
										$objectsNames = $objectType->getListOfNamesForObject(true);
									}
									if (sizeof($objectsNames)) {
										$s_object_listbox = CMS_moduleCategories_catalog::getListBox(
											array (
											'field_name' 		=> 'value[search]['.$searchName.']['.$paramType.']',		// Select field name to get value in
											'items_possible' 	=> $objectsNames,							// array of all categories availables: array(ID => label)
											'default_value' 	=> $data["value"]['search'][$searchName][$paramType],	// Same format
											'attributes' 		=> 'class="admin_input_text" style="width:250px;"'
											));
									} else {
										$s_object_listbox = $cms_language(MESSAGE_EMPTY_OBJECTS_SET);
									}
									$searchParamContent .= '
										<tr>
											<td class="admin">'.$mandatory.$field->getLabel($cms_language).'&nbsp;:</td>
											<td class="admin">'.$s_object_listbox.'</td>
										</tr>';
								} else {
									$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_FIELD_ERROR, array($searchName, $row->getLabel()), MOD_POLYMOD_CODENAME)."\n";
								}
							} else {
								$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_FIELD_ERROR, array($searchName, $row->getLabel()), MOD_POLYMOD_CODENAME)."\n";
							}
						} else {
							$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_FIELDTYPE_ERROR, array($searchName, $row->getLabel(), $paramType), MOD_POLYMOD_CODENAME)."\n";
						}
					break;
				}
			}
			if ($searchParamContent) {
				$content .= '
				<fieldset style="width:500px;">
					<legend class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE, array($searchName), MOD_POLYMOD_CODENAME).'</legend>
					<table width="100%" border="0" cellpadding="3" cellspacing="0">
					'.$searchParamContent.'
					</table>
				</fieldset><br />';
			}
		} else {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_ROW_ERROR, array($searchName, $row->getLabel()), MOD_POLYMOD_CODENAME)."\n";
		}
	}
	$content .= '
	'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'<br /><br />
	<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" />
	</form>
	';
}
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$dialog->setContent($content);
$dialog->show();
?>