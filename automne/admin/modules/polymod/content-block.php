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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: content-block.php,v 1.6 2010/03/08 16:42:06 sebastien Exp $

/**
  * PHP page : Load polymod item interface
  * Used accross an Ajax request. Render a polymod item for edition
  *
  * @package Automne
  * @subpackage polymod
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

define("MESSAGE_PAGE_TITLE_MODULE", 248);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_PAGE_SAVE", 952);

//Message of polymod module
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
define("MESSAGE_PAGE_FIELD_ORDER_RANDOM", 520);
define("MESSAGE_PAGE_SEARCH_FIELDTYPE_ERROR", 133);
define("MESSAGE_PAGE_FIELD_PUBLISHED_FROM", 134);
define("MESSAGE_PAGE_FIELD_PUBLISHED_TO", 135);
define("MESSAGE_PAGE_SEARCH_ORDERTYPE_ERROR", 136);
define("MESSAGE_PAGE_FIELD_ORDER_PUBLICATION_START", 137);
define("MESSAGE_PAGE_FIELD_ORDER_PUBLICATION_END", 138);
define("MESSAGE_TOOLBAR_HELP_DESC", 521);
define("MESSAGE_PAGE_INCORRECT_FORM_VALUES", 522);

define("MESSAGE_VAR_SUBTITLE",643);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);
//This file is an admin file. Interface must be secure
$view->setSecure();

$winId = sensitiveIO::request('winId');
$tpl = sensitiveIO::request('template', 'sensitiveIO::isPositiveInteger');
$rowId = sensitiveIO::request('rowType', 'sensitiveIO::isPositiveInteger');
$rowTag = sensitiveIO::request('rowTag');
$cs = sensitiveIO::request('cs');
$currentPage = sensitiveIO::request('page', 'sensitiveIO::isPositiveInteger', CMS_session::getPageID());
$blockId = sensitiveIO::request('block');
$blockClass = sensitiveIO::request('blockClass');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());

//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename($codename);

$cms_page = CMS_tree::getPageByID($currentPage);

//RIGHTS CHECK
if (!is_object($cms_page) || $cms_page->hasError()
	|| !$cms_user->hasPageClearance($cms_page->getID(), CLEARANCE_PAGE_EDIT)
	|| !$cms_user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('Insufficient rights on page '.$cms_page->getID());
	$view->show();
}

//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('Error, user has no rights on module : '.$codename);
	$view->show();
}

//ARGUMENTS CHECK
if (!$cs
	|| !$rowTag
	|| !$rowId
	|| !$blockId) {
	CMS_grandFather::raiseError('Data missing ...');
	$view->show();
}
//instanciate block
$cms_block = new CMS_block_polymod();
$cms_block->initializeFromID($blockId, $rowId);
//instanciate block module
$cms_module = CMS_modulesCatalog::getByCodename($codename);
//get block datas if any
$data = $cms_block->getRawData($cms_page->getID(), $cs, $rowTag, RESOURCE_LOCATION_EDITION, false);
//get block parameters requirements
$blockParamsDefinition = $cms_block->getBlockParametersRequirement($data["value"], $cms_page, true);
//instanciate row
$row = new CMS_row($rowId);

$winLabel = sensitiveIO::sanitizeJSString($cms_language->getMessage(MESSAGE_PAGE_TITLE, array($row->getLabel(), $cms_module->getLabel($cms_language)), MOD_POLYMOD_CODENAME));
$items = array();
$rowParams = array();

if (isset($blockParamsDefinition['var'])) {
	$blockVarContent = array();
	
	foreach ($blockParamsDefinition['var'] as $varId => $variables) {
		foreach ($variables as $varName => $varAttributes) {
			// indicate that a row param is found
			$rowParams[] = $varName;
			// check mandatory attribute
			$mandatory = ($varAttributes['mandatory'] == "true") ? '<span class="atm-red">*</span> ':'';
			// handle description
			$description = (isset($varAttributes['description'])) ? 
					'<span class="atm-help" ext:qtip="'.sensitiveIO::sanitizeHTMLString(strip_tags($varAttributes['description'])).'">'.sensitiveIO::sanitizeHTMLString(strip_tags($varAttributes['label'])).'</span>' :
					$varAttributes['label'];
			// create label
			$label = $mandatory.$description;
			
			// retrieve the stored value or the default one, if any
			if(isset($data["value"]['var'][$varId][$varName])) {
				$value = $data["value"]['var'][$varId][$varName];
			}
			elseif (isset($varAttributes['default'])) {
				$value = $varAttributes['default'];
			}
			else {
				$value = null;
			}

			//  TODOGF : clean HTML strings for label and descriptions
			if(isset($varAttributes['possibleValues'])) {
				$possibleValues = explode('|',$varAttributes['possibleValues']);
				$extValues = array();
				foreach ($possibleValues as $anOption) {
					$keyPresent = strpos($anOption,':');
					if($keyPresent !== false && $keyPresent != 0 ){
						list($optionValue, $optionLabel) = explode(':', $anOption);
						$extValues[] = array($optionValue,$optionLabel);
					}
					else {
						$extValues[] = array($anOption,$anOption);	
					}
				}
				$item = array(
					'xtype'			=> 'atmCombo',
					'fieldLabel'	=> $label,
					'name'			=> 'value[var]['.$varId.']['.$varName.']',
					'hiddenName'	=> 'value[var]['.$varId.']['.$varName.']',
					'forceSelection'=> true,
					'mode'			=> 'local',
					'valueField'	=> 'id',
					'displayField'	=> 'name',
					'triggerAction'	=> 'all',
					'allowBlank'	=> !$mandatory,
					'selectOnFocus'	=> true,
					'editable'		=> false,
					'value'			=> $value,
					'store'			=> array(
						'xtype'			=> 'arraystore',
						'fields' 		=> array('id', 'name'),
						'data' 			=> $extValues
					)
				);
				$addItem = true;
			}
			else {
				$item = array(
					'name'				=> 'value[var]['.$varId.']['.$varName.']',
					'anchor'			=> '99%',
					'allowBlank'		=> !$mandatory,
					'value'				=> $value,
					'fieldLabel'		=> $label
				);
				$addItem = true;
				switch ($varAttributes['vartype']) {
					case 'integer':
						$item['allowDecimals'] = false;
						$item['xtype'] = 'numberfield';
						if(isset($varAttributes['minValue'])){
							$item['minValue'] = $varAttributes['minValue'];
						}
						if(isset($varAttributes['maxValue'])){
							$item['maxValue'] = $varAttributes['maxValue'];
						}
						break;
					case 'float':
						$item['allowDecimals'] = true;
						$item['xtype'] = 'numberfield';
						if(isset($varAttributes['minValue'])){
							$item['minValue'] = $varAttributes['minValue'];
						}
						if(isset($varAttributes['maxValue'])){
							$item['maxValue'] = $varAttributes['maxValue'];
						}
						if(isset($varAttributes['separator'])){
							$item['decimalSeparator'] = $varAttributes['separator'];
						}
						break;
					case 'string':
						$item['xtype'] = 'textfield';
						if(isset($varAttributes['maxLength'])){
							$item['maxLength'] = $varAttributes['maxLength'];
						}
						/*if(isset($varAttributes['regex'])){
							$item['regex'] = $varAttributes['regex'];
						}
						pr($item);*/
						break;
					case 'boolean':
						$item['xtype'] = 'radiogroup';
						$item['mandatory'] = 'false';
						unset($item['value']);
						$item['items'] = array(
							array('xtype' => 'radio',
								'boxLabel' =>  $cms_language->getMessage(CMS_object_boolean::MESSAGE_OBJECT_BOOLEAN_YES),
								'name'  => 'value[var]['.$varId.']['.$varName.']',
								'inputValue' => true,
								'checked' => ($value == 'true')
							),
							array('xtype' => 'radio',
								'boxLabel' =>  $cms_language->getMessage(CMS_object_boolean::MESSAGE_OBJECT_BOOLEAN_NO),
								'name'  => 'value[var]['.$varId.']['.$varName.']',
								'inputValue' => false,
								'checked' => ($value !== 'true')
							));
						
						break;
					case 'date':
						$date = new CMS_date();
						$item['xtype'] = 'datefield';
						$item['mandatory'] = false;
						$item['width'] = 100;
						$item['anchor'] = false;
						if(isset($varAttributes['format'])){
							$item['format'] = $varAttributes['format'];
						}
						else {
							$item['format'] = $cms_language->getDateFormat();
						}
						break;
					case 'page':
						$item['xtype'] = 'atmPageField';
						$item['mandatory'] = false;
						$item['anchor'] = '97%';
						if(isset($varAttributes['root'])){
							if(!io::isPositiveInteger($varAttributes['root'])) {
								// Assuming the structure {websitecodename:pagecodename}
								$page = trim($varAttributes['root'],"{}");
								if(strpos($page, ":") !== false){
									list($websiteCodename,$pageCodename) = explode(':', $page);
									$website = CMS_websitesCatalog::getByCodename($websiteCodename); 
									if($website){
										$pageID = CMS_tree::getPageByCodename($pageCodename, $website, false, false);
										if($pageID) {
											$item['root'] = $pageID;
										}
									}
								}
							}
							else {
								if(CMS_tree::getPageByID($tag['attributes'][$name])) {
									$item['root'] = $varAttributes['root'];
								}
							}
						}
						break;
					default:
						if(strpos($varAttributes['vartype'], 'fields') !== false) {
							// Assume it's a polymod object field
							$fieldId = io::substr($varAttributes['vartype'],strrpos($varAttributes['vartype'], 'fields')+9,-2);
							$objectId =  CMS_poly_object_catalog::getObjectIDForField($fieldId);
							if(io::isPositiveInteger($objectId)) {
								$objectFields = CMS_poly_object_catalog::getFieldsDefinition($objectId);
								if (sensitiveIO::isPositiveInteger($fieldId)) {
									//subobjects
									$field = $objectFields[$fieldId];
									if (is_object($field)) {
										//check if field has a method to provide a list of names
										$objectType = $field->getTypeObject();
										if (method_exists($objectType, 'getListOfNamesForObject')) {
											//check if we can associate unused objects
											$params = $objectType->getParamsValues();
											if (method_exists($objectType, 'getParamsValues') && isset($params['associateUnused']) && $params['associateUnused']) {
												$objectsNames = $objectType->getListOfNamesForObject(true, array(), false);
											} else {
												$objectsNames = $objectType->getListOfNamesForObject(true);
											}
											$availableItems = array();
											if (is_array($objectsNames) && $objectsNames) {
												foreach ($objectsNames as $id => $aLabel) {
													$availableItems[] = array($id, io::decodeEntities($aLabel));
												}
											} else {
												$availableItems[] = array('', $cms_language(MESSAGE_EMPTY_OBJECTS_SET));
											}
											$mandatory = ($paramValue == true) ? '<span class="atm-red">*</span> ':'';
											//$value = isset($data["value"]['search'][$searchName][$paramType]) ? $data["value"]['search'][$searchName][$paramType] : '';
											
											$item = array(
												'fieldLabel'		=> $label,
												'name'				=> 'value[var]['.$varId.']['.$varName.']',
												'hiddenName'		=> 'value[var]['.$varId.']['.$varName.']',
												'anchor'			=> '99%',
												'xtype' 			=> 'atmCombo',
												'forceSelection' 	=> true,
												'mode' 				=> 'local',
												'valueField' 		=> 'id',
												'displayField' 		=> 'label',
												'triggerAction' 	=> 'all',
												'allowBlank'		=> !$mandatory,
												'selectOnFocus'		=> true,
												'editable'			=> false,
												'value'				=> $value,
												'store' 			=> array(
													'xtype'			=> 'arraystore',
													'fields' 		=> array('id', 'label'),
													'data' 			=> $availableItems
												)
											);
										}
										else {
											$addItem = false;
											$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_FIELD_ERROR, array($varId, $row->getLabel()), MOD_POLYMOD_CODENAME)."\n";
										}
									}
									else {
										$addItem = false;
										$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_FIELD_ERROR, array($varId, $row->getLabel()), MOD_POLYMOD_CODENAME)."\n";
									}
								}
								else {
									$addItem = false;
									$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_FIELDTYPE_ERROR, array($varId, $row->getLabel(), $paramType), MOD_POLYMOD_CODENAME)."\n";
								}
							} 
							else {
								$addItem = false;
								$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_FIELDTYPE_ERROR, array($varId, $row->getLabel(), $paramType), MOD_POLYMOD_CODENAME)."\n";
							}
						}
						else {
							// Assume it's an object
							$objectDefinitionId = io::substr($varAttributes['vartype'],9,-3);
							$object = CMS_poly_object_catalog::getObjectDefinition($objectDefinitionId);
							$item = array(
								'fieldLabel'		=> $label,
								'name'				=> 'value[var]['.$varId.']['.$varName.']',
								'hiddenName'		=> 'value[var]['.$varId.']['.$varName.']',
								'anchor'			=> '99%',
								'xtype' 			=> 'atmCombo',
								'forceSelection' 	=> true,
								'mode' 				=> 'remote',
								'valueField' 		=> 'id',
								'displayField' 		=> 'label',
								'triggerAction' 	=> 'all',
								'allowBlank'		=> !$mandatory,
								'selectOnFocus'		=> true,
								'editable'			=> true,
								'typeAhead'			=> true,
								'value'				=> $value,
								'store' 			=> array(
									'url'			=> PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/list-objects.php',
									'baseParams'	=> array(
										'objectId'		=> $object->getID(),
										'module'		=> $codename
									),
									'root' 			=> 'objects',
									'fields' 		=> array('id', 'label')
								)
							);
						}
						
						break;
				}
			}
			if($addItem){
				$blockVarContent[] = $item;
			}			
		}
	}

	if ($blockVarContent) {
		$items[] = array(
			'title' 		=>	$cms_language->getMessage(MESSAGE_VAR_SUBTITLE, null, MOD_POLYMOD_CODENAME),
			'xtype'			=>	'fieldset',
			'autoHeight'	=>	true,
			'defaults'		=> 	array(
				'anchor'		=>	'97%',
			),
			'items'			=>	$blockVarContent
		);
	}
	
}

if (isset($blockParamsDefinition['search'])) {
	foreach ($blockParamsDefinition['search'] as $searchName => $searchParams) {
		$searchType = $searchParams['searchType'];
		unset($searchParams['searchType']);
		if (!$searchParams) {
			continue;
		}
		//load searched object
		$object = CMS_poly_object_catalog::getObjectDefinition($searchType);
		if (!$object->hasError()) {
			//load fields objects for object
			$objectFields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());
			$searchParamContent = array();
			foreach ($searchParams as $paramType => $paramValue) {
				$rowParams[] = $paramType;
				switch ($paramType) {
					case 'item':
						$mandatory = ($paramValue == true) ? '<span class="atm-red">*</span> ':'';
						$value = isset($data["value"]['search'][$searchName][$paramType]) ? $data["value"]['search'][$searchName][$paramType] : '';
						$searchParamContent[] = array(
							'fieldLabel'		=> $mandatory.$object->getLabel($cms_language),
							'name'				=> 'value[search]['.$searchName.']['.$paramType.']',
							'hiddenName'		=> 'value[search]['.$searchName.']['.$paramType.']',
							'anchor'			=> '99%',
							'xtype' 			=> 'atmCombo',
							'forceSelection' 	=> true,
							'mode' 				=> 'remote',
							'valueField' 		=> 'id',
							'displayField' 		=> 'label',
							'triggerAction' 	=> 'all',
							'allowBlank'		=> !$mandatory,
							'selectOnFocus'		=> true,
							'editable'			=> true,
							'typeAhead'			=> true,
							'value'				=> $value,
							'store' 			=> array(
								'url'			=> PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/list-objects.php',
								'baseParams'	=> array(
									'objectId'		=> $object->getID(),
									'module'		=> $codename
								),
								'root' 			=> 'objects',
								'fields' 		=> array('id', 'label')
							)
						);
					break;
					case 'keywords':
						// Keywords
						$mandatory = ($paramValue == true) ? '<span class="atm-red">*</span> ':'';
						$value = isset($data["value"]['search'][$searchName][$paramType]) ? $data["value"]['search'][$searchName][$paramType] : '';
						$searchParamContent[] = array(
							'fieldLabel'		=> $mandatory.$cms_language->getMessage(MESSAGE_PAGE_FIELD_KEYWORDS, false, MOD_POLYMOD_CODENAME),
							'name'				=> 'value[search]['.$searchName.']['.$paramType.']',
							'anchor'			=> '99%',
							'xtype' 			=> 'textfield',
							'allowBlank'		=> !$mandatory,
							'value'				=> $value,
						);
					break;
					case 'category':
						//categories
						//this search type is deprecated, use direct field id access
					break;
					case 'limit':
						// Limit
						$mandatory = ($paramValue == true) ? '<span class="atm-red">*</span> ':'';
						$value = isset($data["value"]['search'][$searchName][$paramType]) ? $data["value"]['search'][$searchName][$paramType] : '';
						$searchParamContent[] = array(
							'fieldLabel'		=> $mandatory.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LIMIT, false, MOD_POLYMOD_CODENAME),
							'name'				=> 'value[search]['.$searchName.']['.$paramType.']',
							'anchor'			=> '99%',
							'allowNegative'		=> false,
							'allowDecimals'		=> false,
							'xtype' 			=> 'numberfield',
							'allowBlank'		=> !$mandatory,
							'value'				=> $value,
						);
					break;
					case 'order':
						if (sizeof($paramValue)) {
							$orderNameList = array(
								'objectID' => MESSAGE_PAGE_FIELD_ORDER_OBJECTID,
								'random' => MESSAGE_PAGE_FIELD_ORDER_RANDOM,
								'publication date after' => MESSAGE_PAGE_FIELD_ORDER_PUBLICATION_START,
								'publication date before' => MESSAGE_PAGE_FIELD_ORDER_PUBLICATION_END,
							);
							$searchOrderContent = array();
							foreach ($paramValue as $orderName => $orderValue) {
								$fieldLabel = '';
								if (in_array($orderName, CMS_object_search::getStaticOrderConditionTypes())) {
									$fieldLabel = $cms_language->getMessage($orderNameList[$orderName], false, MOD_POLYMOD_CODENAME);
								} else {
									$orderName = trim($orderName, '()');
									if (io::isPositiveInteger($orderName)) {
										$field = new CMS_poly_object_field($orderName);
										if ($field && !$field->hasError()) {
											$label = new CMS_object_i18nm($field->getValue('labelID'));
											$fieldLabel = $label->getValue($cms_language->getCode());
										}
									}
								}
								if ($fieldLabel) {
									// Order direction
									$mandatory = ($paramValue == true) ? '<span class="atm-red">*</span> ':'';
									$value = isset($data["value"]['search'][$searchName][$paramType][$orderName]) ? $data["value"]['search'][$searchName][$paramType][$orderName] : '';
									$searchOrderContent[] = array(
										'xtype'			=> 'atmCombo',
										'fieldLabel'	=> $mandatory.$fieldLabel,
										'name'			=> 'value[search]['.$searchName.']['.$paramType.']['.$orderName.']',
										'hiddenName'	=> 'value[search]['.$searchName.']['.$paramType.']['.$orderName.']',
										'forceSelection'=> true,
										'mode'			=> 'local',
										'valueField'	=> 'id',
										'displayField'	=> 'name',
										'triggerAction'	=> 'all',
										'allowBlank'	=> !$mandatory,
										'selectOnFocus'	=> true,
										'editable'		=> false,
										'value'			=> $value,
										'store'			=> array(
											'xtype'			=> 'arraystore',
											'fields' 		=> array('id', 'name'),
											'data' 			=> array(
												array('', '-'),
												array('asc', $cms_language->getMessage(MESSAGE_PAGE_FIELD_ORDER_ASC, false, MOD_POLYMOD_CODENAME)),
												array('desc', $cms_language->getMessage(MESSAGE_PAGE_FIELD_ORDER_DESC, false, MOD_POLYMOD_CODENAME)),
											)
										)
									);
								} else {
									$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_ORDERTYPE_ERROR, array($searchName, $row->getLabel(), $orderName), MOD_POLYMOD_CODENAME)."\n";
								}
							}
							$searchParamContent[] = array(
								'title' 		=>	$cms_language->getMessage(MESSAGE_PAGE_FIELD_ORDER, false, MOD_POLYMOD_CODENAME),
								'xtype'			=>	'fieldset',
								'autoHeight'	=>	true,
								'defaults'		=> 	array(
									'anchor'		=>	'97%',
								),
								'items'			=>	$searchOrderContent
							);
						}
					break;
					case 'searchType':
						//nothing, this is not a search parameter
					break;
					case 'publication date after':
					case 'publication date before':
						// Dates
						//create object CMS_date
						$date = new CMS_date();
						if (isset($data["value"]['search'][$searchName][$paramType])) {
							$date->setFromDBValue($data["value"]['search'][$searchName][$paramType]);
						}
						$label = ($paramType == 'publication date after') ? MESSAGE_PAGE_FIELD_PUBLISHED_FROM : MESSAGE_PAGE_FIELD_PUBLISHED_TO;
						//$date_mask = $cms_language->getDateFormatMask();
						$value = $date->getLocalizedDate($cms_language->getDateFormat()) ? $date->getLocalizedDate($cms_language->getDateFormat()) : '';
						$mandatory = ($paramValue == true) ? '<span class="atm-red">*</span> ':'';
						$searchParamContent[] = array(
							'fieldLabel'		=> $mandatory.$cms_language->getMessage($label, false, MOD_POLYMOD_CODENAME),
							'name'				=> 'value[search]['.$searchName.']['.$paramType.']',
							'width'				=> 100,
							'format'			=> $cms_language->getDateFormat(),
							'anchor'			=> false,
							'xtype' 			=> 'datefield',
							'allowBlank'		=> !$mandatory,
							'value'				=> $value,
						);
					break;
					default:
						$paramType = trim($paramType, '()'); //remove bracket around field id
						if (sensitiveIO::isPositiveInteger($paramType)) {
							//subobjects
							$field = $objectFields[$paramType];
							if (is_object($field)) {
								//check if field has a method to provide a list of names
								$objectType = $field->getTypeObject();
								if (method_exists($objectType, 'getListOfNamesForObject')) {
									//check if we can associate unused objects
									$params = $objectType->getParamsValues();
									if (method_exists($objectType, 'getParamsValues') && isset($params['associateUnused']) && $params['associateUnused']) {
										$objectsNames = $objectType->getListOfNamesForObject(true, array(), false);
									} else {
										$objectsNames = $objectType->getListOfNamesForObject(true);
									}
									$availableItems = array();
									if (is_array($objectsNames) && $objectsNames) {
										foreach ($objectsNames as $id => $label) {
											$availableItems[] = array($id, io::decodeEntities($label));
										}
									} else {
										$availableItems[] = array('', $cms_language(MESSAGE_EMPTY_OBJECTS_SET));
									}
									$mandatory = ($paramValue == true) ? '<span class="atm-red">*</span> ':'';
									$value = isset($data["value"]['search'][$searchName][$paramType]) ? $data["value"]['search'][$searchName][$paramType] : '';
									$searchParamContent[] = array(
										'fieldLabel'		=> $mandatory.$field->getLabel($cms_language),
										'name'				=> 'value[search]['.$searchName.']['.$paramType.']',
										'hiddenName'		=> 'value[search]['.$searchName.']['.$paramType.']',
										'anchor'			=> '99%',
										'xtype' 			=> 'atmCombo',
										'forceSelection' 	=> true,
										'mode' 				=> 'local',
										'valueField' 		=> 'id',
										'displayField' 		=> 'label',
										'triggerAction' 	=> 'all',
										'allowBlank'		=> !$mandatory,
										'selectOnFocus'		=> true,
										'editable'			=> false,
										'value'				=> $value,
										'store' 			=> array(
											'xtype'			=> 'arraystore',
											'fields' 		=> array('id', 'label'),
											'data' 			=> $availableItems
										)
									);
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
				$items[] = array(
					'title' 		=>	$cms_language->getMessage(MESSAGE_PAGE_SUBTITLE, array($searchName), MOD_POLYMOD_CODENAME),
					'xtype'			=>	'fieldset',
					'autoHeight'	=>	true,
					'defaults'		=> 	array(
						'anchor'		=>	'97%',
					),
					'items'			=>	$searchParamContent
				);
			}
		} else {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_SEARCH_ROW_ERROR, array($searchName, $row->getLabel()), MOD_POLYMOD_CODENAME)."\n";
		}
	}
}
$items = sensitiveIO::jsonEncode($items);

$itemControler = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/items-controler.php';
if (sizeof($rowParams) == 1 && $rowParams[0] == 'item') {
	$md5 = md5(mt_rand().microtime());
	$url = PATH_ADMIN_MODULES_WR.'/polymod/item-selector.php';
	$fieldName = $searchParamContent[0]['name'];
	$selectedItem = $searchParamContent[0]['value'];
	$params = sensitiveIO::jsonEncode(array(
		'winId'			=> 'selector-'.$md5,
		'objectId'		=> $object->getID(),
		'selectedItem'	=> $selectedItem,
		'module'		=> $codename
	));
	//this is only an single item selection, so help selection a little
	$jscontent = <<<END
		var window = Ext.getCmp('{$winId}');
		//set window title
		window.setTitle('{$winLabel}');
		//set help button on top of page
		window.tools['help'].show();
		//add a tooltip on button
		var propertiesTip = new Ext.ToolTip({
			target:		 window.tools['help'],
			title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
			html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC, false, MOD_POLYMOD_CODENAME)}',
			dismissDelay:	0
		});
		var selectedItem = '{$selectedItem}';
		//create center panel
		var center = new Ext.Panel({
			region:				'center',
			border:				false,
			layout:				'fit',
			plain:				true,
			autoScroll:			true,
			buttonAlign:		'center',
			items: [{
				id:		'selector-{$md5}',
				height:	(window.getHeight()-70),
				xtype:	'atmPanel',
				layout:	'atm-border',
				autoLoad:		{
					url:		'{$url}',
					params:		{$params},
					nocache:	true,
					scope:		center
				},
				selectItem:		function(id, params) {
					if (id) {
						selectedItem = id;
					} else {
						selectedItem = '';
					}
				}.createDelegate(this, [{$params}], true)
			}],
			buttons:[{
				text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
				iconCls:		'atm-pic-validate',
				xtype:			'button',
				name:			'submitAdmin',
				handler:		function() {
					Automne.server.call('{$itemControler}', function(response, option, content){}, {
						'{$fieldName}':	selectedItem,
						action:			'setRowParameters',
						page:			'{$cms_page->getID()}',
						cs:				'{$cs}',
						rowTag:			'{$rowTag}',
						rowType:		'{$rowId}',
						block:			'{$blockId}',
						module:			'{$cms_module->getCodename()}'
					}, this);
				},
				scope:			this
			}]
		});
		window.add(center);
		setTimeout(function(){
			//redo windows layout
			window.doLayout();
			if (Ext.isIE7) {
				center.syncSize();
			}
		}, 100);
END;
	$view->addJavascript($jscontent);
	$view->show();
}

$jscontent = <<<END
	var window = Ext.getCmp('{$winId}');
	//set window title
	window.setTitle('{$winLabel}');
	//set help button on top of page
	window.tools['help'].show();
	//add a tooltip on button
	var propertiesTip = new Ext.ToolTip({
		target:		 window.tools['help'],
		title:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
		html:			 '{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_DESC, false, MOD_POLYMOD_CODENAME)}',
		dismissDelay:	0
	});
	
	//create center panel
	var center = new Ext.Panel({
		id:					'{$winId}center',
		region:				'center',
		border:				false,
		autoScroll:			true,
		buttonAlign:		'center',
		items: [{
			id:				'{$winId}-form',
			layout: 		'form',
			bodyStyle: 		'padding:10px',
			border:			false,
			autoWidth:		true,
			autoHeight:		true,
			xtype:			'atmForm',
			url:			'{$itemControler}',
			labelAlign:		'right',
			defaults: {
				xtype:			'textfield',
				anchor:			'97%',
				allowBlank:		false
			},
			items:{$items}
		}],
		buttons:[{
			text:			'{$cms_language->getJSMessage(MESSAGE_PAGE_SAVE)}',
			xtype:			'button',
			iconCls:		'atm-pic-validate',
			name:			'submitAdmin',
			handler:		function() {
				var form = Ext.getCmp('{$winId}-form').getForm();
				if (form.isValid()) {
					form.submit({
						params:{
							action:			'setRowParameters',
							page:			'{$cms_page->getID()}',
							cs:				'{$cs}',
							rowTag:			'{$rowTag}',
							rowType:		'{$rowId}',
							block:			'{$blockId}',
							module:			'{$cms_module->getCodename()}'
						},
						success:function(form, action){
							
						},
						scope:this
					});
				} else {
					Automne.message.show('{$cms_language->getJSMessage(MESSAGE_PAGE_INCORRECT_FORM_VALUES, false, MOD_POLYMOD_CODENAME)}', '', window);
				}
			},
			scope:			this
		}]
	});
	window.add(center);
	setTimeout(function(){
		//redo windows layout
		window.doLayout();
		if (Ext.isIE7) {
			center.syncSize();
		}
	}, 100);
END;
$view->addJavascript($jscontent);

if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$view->show();
?>