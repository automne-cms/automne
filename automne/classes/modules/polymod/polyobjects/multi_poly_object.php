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
// $Id: multi_poly_object.php,v 1.12 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_multi_poly_object
  *
  * represent a collection of polymorphic objects
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_multi_poly_object extends CMS_object_common
{
	/**
	  * Polymod Messages
	  */
	const MESSAGE_MULTI_OBJECT_LABEL_DESCRIPTION = 363;
	const MESSAGE_MULTI_OBJECT_FIELDNAME_DESCRIPTION = 118;
	const MESSAGE_MULTI_OBJECT_FIELDID_DESCRIPTION = 119;
	const MESSAGE_MULTI_OBJECT_OBJECTTYPE_DESCRIPTION = 145;
	const MESSAGE_MULTI_OBJECT_FIELDS_DESCRIPTION = 148;
	const MESSAGE_MULTI_OBJECT_OBJECTNAME_DESCRIPTION = 143;
	const MESSAGE_MULTI_OBJECT_OBJECTDESC_DESCRIPTION = 144;
	const MESSAGE_MULTI_OBJECT_COUNT_DESCRIPTION = 149;
	const MESSAGE_MULTI_OBJECT_LABEL = 190;
	const MESSAGE_MULTI_OBJECT_DESCRIPTION = 191;
	const MESSAGE_MULTI_OBJECT_PARAMETER_EDITABLE = 192;
	const MESSAGE_MULTI_OBJECT_CREATE_ZONE = 193;
	const MESSAGE_MULTI_OBJECT_EDIT_ZONE = 194;
	const MESSAGE_MULTI_OBJECT_LIST_ZONE = 195;
	const MESSAGE_MULTI_OBJECT_ADD_ZONE = 196;
	const MESSAGE_MULTI_OBJECT_PARAMETER_LOADSUBOBJECTS = 197;
	const MESSAGE_MULTI_OBJECT_PARAMETER_LOADSUBOBJECTS_DESCRIPTION = 198;
	const MESSAGE_MULTI_OBJECT_PARAMETER_SEARCHEDOBJECTS = 199;
	const MESSAGE_MULTI_OBJECT_FUNCTION_SELECTOPTIONS_DESCRIPTION = 162;
	const MESSAGE_MULTI_OBJECT_PARAMETER_INDEXONLYLASTSUBOBJECTS = 330;
	const MESSAGE_MULTI_OBJECT_PARAMETER_INDEXONLYLASTSUBOBJECTS_DESCRIPTION = 331;
	const MESSAGE_MULTI_OBJECT_PARAMETER_DONOTUSEEXTERNALSUBOBJECTS = 332;
	const MESSAGE_MULTI_OBJECT_PARAMETER_DONOTUSEEXTERNALSUBOBJECTS_DESCRIPTION = 333;
	const MESSAGE_MULTI_OBJECT_REQUIRED_DESCRIPTION = 366;
	const MESSAGE_MULTI_OBJECT_IDS_DESCRIPTION = 398;
  	const MESSAGE_MULTI_OBJECT_FIELD_DESC_DESCRIPTION = 402;
	const MESSAGE_MULTI_OBJECT_EDIT_ELEMENT = 516;
  	const MESSAGE_MULTI_OBJECT_DISASSOCIATE_ELEMENT = 517;
  	const MESSAGE_MULTI_OBJECT_CHOOSE_ELEMENT = 518;
	
	const MESSAGE_EMPTY_OBJECTS_SET = 265;
	const MESSAGE_CHOOSE_OBJECT = 1132;
	const MESSAGE_PAGE_ACTION_MODIFIY = 261;
	const MESSAGE_PAGE_ACTION_NEW = 262;
	const MESSAGE_PAGE_ACTION_DESASSOCIATE = 1268;
	const MESSAGE_PAGE_ACTION_ASSOCIATE = 1267;
	const MESSAGE_PAGE_ACTION_DESASSOCIATE_CONFIRM = 607;
	const MESSAGE_MULTI_OBJECT_SELECT_BEFORE = 608;

	/**
	  * CMS_object_field reference
	  * @var CMS_object_field
	  * @access private
	  */
	protected $_field;

	/**
	  * object id in catalog (relative to id in mod_object_def table)
	  * @var array('string dbvarname' => 'string var type')
	  * @access private
	  */
	protected $_objectID;

	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_MULTI_OBJECT_LABEL;

	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_MULTI_OBJECT_DESCRIPTION;

	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, "isParameter" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array();

	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array();

	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array(0 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'editable',
										'externalName'	=> self::MESSAGE_MULTI_OBJECT_PARAMETER_EDITABLE,
									),
							 1 => array(
										'type' 			=> 'search',
										'required' 		=> false,
										'internalName'	=> 'searchedObjects',
										'externalName'	=> self::MESSAGE_MULTI_OBJECT_PARAMETER_SEARCHEDOBJECTS,
									),
							 2 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'loadSubObjects',
										'externalName'	=> self::MESSAGE_MULTI_OBJECT_PARAMETER_LOADSUBOBJECTS,
										'description'	=> self::MESSAGE_MULTI_OBJECT_PARAMETER_LOADSUBOBJECTS_DESCRIPTION,
									),
							 3 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'doNotUseExternalSubObjects',
										'externalName'	=> self::MESSAGE_MULTI_OBJECT_PARAMETER_DONOTUSEEXTERNALSUBOBJECTS,
										'description'	=> self::MESSAGE_MULTI_OBJECT_PARAMETER_DONOTUSEEXTERNALSUBOBJECTS_DESCRIPTION,
									),
							 4 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'indexOnlyLastSubObjects',
										'externalName'	=> self::MESSAGE_MULTI_OBJECT_PARAMETER_INDEXONLYLASTSUBOBJECTS,
										'description'	=> self::MESSAGE_MULTI_OBJECT_PARAMETER_INDEXONLYLASTSUBOBJECTS_DESCRIPTION,
									),
							);

	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => false, 1 => array(), 2 => false, 3 => false, 4 => false);

	/**
	  * all sub objects (CMS_poly_object)
	  * @var array(CMS_poly_object)
	  * @access private
	  */
	public $_objectValues = array();

	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param integer $objectID the object type id in catalog (relative to id in mod_object_def table)
	  * @param array $datas the object and sub objects values
	  * @param boolean $public, object values are public or edited ? (default is edited)
	  * @param CMS_object_field reference
	  * @return void
	  * @access public
	  */
	function __construct($objectID, $datas = array(), $field, $public = false)
	{
		//first, remove paramters 3 if no module ASE founded
		if (!class_exists('CMS_module_ase')) {
			unset($this->_parameters[4]);
			unset($this->_parameterValues[4]);
		}
		//check object defined internal vars
		if (sizeof($this->_subfields) != sizeof($this->_subfieldValues)) {
			$this->raiseError('Object internal vars hasn\'t the same count of parameters, check $_subfields, $_subfieldValues.');
			return;
		}
		if (!is_array($datas)) {
			$this->raiseError("Datas need to be an array : ".print_r($datas,true));
			return;
		}
		//check object type id
		if (sensitiveIO::isPositiveInteger($objectID)) {
			//set $this->_objectID
			$this->_objectID = $objectID;
		} else {
			$this->raiseError("ObjectID is not a positive Integer : ".$objectID);
			return;
		}
		//Set public values
		$this->_public = $public;
		//set $this->_field
		$this->_field = &$field;
		//set $this->_parameterValues
		foreach ($this->_parameters as $parameterID => $parameter) {
			$param = $field->getParameter($parameter['internalName']);
			if (isset($param)) {
				$this->_parameterValues[$parameterID] = $param;
			}
		}
		//set $this->_subfieldValues
		foreach ($datas as $subFieldID => $aSubFieldData) {
			$this->_subfieldValues[$subFieldID] = new CMS_subobject_integer($aSubFieldData['id'],array(),$aSubFieldData, $this->_public);
		}
		ksort($this->_subfieldValues);
	}

	/**
	  * Get object ID
	  *
	  * @return integer, the DB object ID
	  * @access public
	  */
	function getObjectID()
	{
		return $this->_objectID;
	}

	/**
	  * Get all associated object ids
	  *
	  * @return array, the associated object ids
	  * @access public
	  */
	function getIDs() {
		$ids = array();
		foreach ($this->_subfieldValues as $subFieldID => $aSubFieldData) {
			$value = $this->_subfieldValues[$subFieldID]->getValue();
			if (sensitiveIO::isPositiveInteger($value)) {
				$ids[] = $value;
			}
		}
		return $ids;
	}

	/**
	  * get object resource status
	  * beware, for secondary resources, real status is not checked, use isSecondaryResource method of CMS_poly_object_definition instead
	  *
	  * @return integer, the object resource status
	  * @access public
	  */
	function getObjectResourceStatus() {
		$objectDef = $this->getObjectDefinition();
		return $objectDef->getValue("resourceUsage");
	}

	/**
	  * Sets subobjects Values
	  *
	  * @param array datas : array created by parent loadObject method
	  * 		array(integer objectID => array(integer objectFieldID => array(integer objectSubFieldID => array(DB values))))
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	function populateSubObjectsValues($datas) {
		if (!is_array($datas)) {
			$this->raiseError("Datas need to be an array : ".print_r($datas,true));
			return false;
		}
		$params = $this->getParamsValues();
		$neededObject = array();
		foreach (array_keys($this->_subfieldValues) as $subFieldID) {
			if (is_object($this->_subfieldValues[$subFieldID])) {

				//if object datas does not exists and if we need it
				if ($params['loadSubObjects'] && !isset($datas[$this->_subfieldValues[$subFieldID]->getValue()])) {
					//store object id we need datas for current field
					$neededObject[$subFieldID] = $this->_subfieldValues[$subFieldID]->getValue();
				} elseif (isset($datas[$this->_subfieldValues[$subFieldID]->getValue()])) { //this condition is needed to avoid loading of a deleted object
					//load poly objects
					$this->_objectValues[$subFieldID] = new CMS_poly_object($this->_objectID, $this->_subfieldValues[$subFieldID]->getValue(), $datas, $this->_public, false);
				}
			}
		}
		if (is_array($neededObject) && $neededObject) {
			//get object definition
			$objectDef = $this->getObjectDefinition();
			$search = new CMS_object_search($objectDef,$this->_public);
			$search->addWhereCondition('items', $neededObject);
			$datas = $search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_DATAS);
			foreach ($neededObject as $subFieldID => $objectID) {
				if (isset($datas[$objectID])) { //this condition is needed to avoid loading of a deleted object
					//load poly objects
					$this->_objectValues[$subFieldID] = new CMS_poly_object($this->_objectID, $objectID, $datas, $this->_public, false);
				}
			}
		}
		return true;
	}

	/**
	  * load all subobjects values from DB
	  *
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _loadSubObjectsValues() {
		//get all subobjects ids
		$subObjectsIds = array();
		foreach (array_keys($this->_subfieldValues) as $subFieldID) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				//load poly object
				$subObjectsIds[] = $this->_subfieldValues[$subFieldID]->getValue();
			}
		}
		if (is_array($subObjectsIds) && $subObjectsIds) {
			//get object definition
			$objectDef = $this->getObjectDefinition();
			//create new search to get all DB values for this object and all subobjects
			$search = new CMS_object_search($objectDef,$this->_public);
			//limit to this object
			$search->addWhereCondition('items',$subObjectsIds);
			//launch search
			$datas = $search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_DATAS);
			unset($search);

			//then populate object(s) values
			$this->populateSubObjectsValues($datas);
		}
		return true;
	}

	/**
	  * Get object Definition (CMS_poly_object_definition)
	  *
	  * @return CMS_poly_object_definition
	  * @access public
	  */
	function getObjectDefinition () {
		//create cache object
		$cache = new CMS_cache('object'.$this->_objectID, 'atm-polymod-structure', 2592000, false);
		$datas = '';
		if (!$cache->exist() || !($datas = $cache->load())) {
			//datas does not exists : load it
			$datas = new CMS_poly_object_definition($this->_objectID);
			if ($cache) {
				$cache->save($datas, array('type' => 'object'));
			}
		}
		return $datas;
	}

	/**
	  * get object label (same as getLabel, for objects compatibility)
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string, the label
	  * @access public
	  */
	function getObjectLabel($language) {
		//get object definition
		$objectDef = $this->getObjectDefinition();
		if (is_a($language, "CMS_language")) {
			return $language->getMessage($this->_objectLabel,array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME);
		} else {
			$tmplanguage = new CMS_language($language);
			return $tmplanguage->getMessage($this->_objectLabel,array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME);
		}
	}

	/**
	  * get object description
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for description
	  * @return string, the description
	  * @access public
	  */
	function getDescription($language) {
		//get object definition
		$objectDef = $this->getObjectDefinition();
		$description = new CMS_object_i18nm($objectDef->getValue("descriptionID"));
		if (is_a($language, "CMS_language")) {
			$subdesc = $description->getValue($language->getCode());
			return $language->getMessage($this->_objectDescription, array($subdesc), MOD_POLYMOD_CODENAME);
		} else {
			$subdesc = $description->getValue($language);
			$tmplanguage = new CMS_language($language);
			return $tmplanguage->getMessage($this->_objectDescription, array($subdesc), MOD_POLYMOD_CODENAME);
		}
	}

	/**
	  * get HTML admin subfields parameters (used to enter object search parameters values in admin)
	  *
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLSubFieldsParametersSearch($language, $prefixName) {
		global $polymodCodename;
		$input = '';

		//get params values
		$params = $this->getParamsValues();
		$values = $params['searchedObjects'];

		//get object definition
		$objectDef = $this->getObjectDefinition();
		//load object fields
		$objectFields = CMS_poly_object_catalog::getFieldsDefinition($this->_objectID);

		//Add all subobjects or special fields (like categories) to search if any
		foreach ($objectFields as $fieldID => $field) {
			//check if field is searchable
			if ($field->getValue('searchable')) {
				//check if field has a method to provide a list of names
				$objectType = $field->getTypeObject();
				if (method_exists($objectType, 'getListOfNamesForObject')) {
					$objectsNames = $objectType->getListOfNamesForObject();
					if (is_array($objectsNames) && $objectsNames) {
						$s_object_listbox = CMS_moduleCategories_catalog::getListBox(
							array (
							'field_name' 		=> $prefixName.'searchedObjects['.$fieldID.']',	// Select field name to get value in
							'items_possible' 	=> $objectsNames,								// array of all categories availables: array(ID => label)
							'default_value' 	=> $values[$fieldID],							// Same format
							'attributes' 		=> 'class="admin_input_text" style="width:250px;"'
							)
						);
						$input .= '
						<tr>
							<td class="admin" align="right">'.$field->getLabel($language).'&nbsp;:</td>
							<td class="admin">'.$s_object_listbox.'</td>
						</tr>';
					}
				}
			}
		}
		$input = ($input) ? '<table border="0" cellpadding="3" cellspacing="0" style="border-left:1px solid #4d4d4d;">'.$input.'</table>' : '';
		return $input;
	}

	/**
	  * get HTML admin (used to enter object values in admin)
	  *
	  * @param CMS_language $language, the current admin language
	  * @param string prefixname : the prefix to use for post names
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLAdmin($fieldID, $language, $prefixName) {
		global $cms_user;
		$params = $this->getParamsValues();
		
		//is this field mandatory ?
		$mandatory = $this->_field->getValue('required') ? '<span class="atm-red">*</span> ' : '';
		$desc = $this->getFieldDescription($language);
		if (POLYMOD_DEBUG) {
			$values = array();
			foreach (array_keys($this->_subfieldValues) as $subFieldID) {
				if (is_object($this->_subfieldValues[$subFieldID])) {
					$values[$subFieldID] = sensitiveIO::ellipsis(strip_tags($this->_subfieldValues[$subFieldID]->getValue()), 50);
				}
			}
			$desc .= $desc ? '<br />' : '';
			$desc .= '<span class="atm-red">Field : '.$fieldID.' - Value(s) : <ul>';
			foreach ($values as $subFieldID => $value) {
				$desc .= '<li>'.$subFieldID.'&nbsp;:&nbsp;'.$value.'</li>';
			}
			$desc .= '</ul></span>';
		}
		
		$label = $desc ? '<span class="atm-help" ext:qtip="'.io::htmlspecialchars($desc).'">'.$mandatory.$this->getFieldLabel($language).'</span>' : $mandatory.$this->getFieldLabel($language);
		
		$listId = 'list'.md5(mt_rand().microtime());
		$listId2 = 'list'.md5(mt_rand().microtime());
		if ($params['editable']) {
			//get object definition
			$objectDef = $this->getObjectDefinition();
			$associatedItems = array();
			foreach (array_keys($this->_subfieldValues) as $subFieldID) {
				if (is_object($this->_subfieldValues[$subFieldID])) {
					$associatedItems[$this->_subfieldValues[$subFieldID]->getValue()] = $this->_subfieldValues[$subFieldID]->getValue();
				}
			}
			$items = array();
			$editURL = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/item.php';
			$associateURL = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/associate-items.php';
			$searchURL = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/search.php';
			$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			
			if (!$cms_user->hasModuleClearance($moduleCodename, CLEARANCE_MODULE_EDIT)) {
				define("MESSAGE_ERROR_MODULE_RIGHTS",570);
				$module = CMS_modulesCatalog::getByCodename($moduleCodename);
				$items[] = array(
						'width'			=> '100%',
						'layout'		=> 'fit',
						'border'		=> false,
						'bodyStyle'		=> 'margin:5px 0 3px 0',
						'html'			=> $language->getMessage(MESSAGE_ERROR_MODULE_RIGHTS,array($module->getLabel($language)))
					);
			} else {
				$items[] = array(
						'width'			=> '100%',
						'layout'		=> 'fit',
						'border'		=> false,
						'bodyStyle'		=> 'margin:5px 0 3px 0',
						'html'			=> $language->getMessage(self::MESSAGE_MULTI_OBJECT_LIST_ZONE,array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME)
					);
				
				$items[] = array(
					'xtype'			=> "multiselect2",
		            'hideLabel'		=> true,
		            'id'			=> $listId2,
					'name'			=> 'polymodFieldsValue[list'.$prefixName.$this->_field->getID().'_0]',
					'allowBlank'	=> !$this->_field->getValue('required'),
		            'valueField'	=> 'id',
					'displayField'	=> 'label',
					'tpl'			=> sensitiveIO::sanitizeJSString('<tpl for="rows">
						<dl>
							<tpl for="parent.columns">
								<dt style="width:100%;text-align:{align};" class="MultiselectDD">
									<div unselectable="on" class="atm-result x-unselectable" id="object-{parent.id}">
										<div class="atm-title">
											<table>
												<tr>
													<td class="atm-label" ext:qtip="ID: {parent.id}">{parent.status}&nbsp;{parent.label}</td>
													<td class="atm-pubrange">{parent.pubrange}</td>
													<td class="atm-drag">&nbsp;</td>
												</tr>
											</table>
										</div>
										<div class="atm-description">{parent.description}<div style="clear:both;height:1px;">&nbsp;</div></div>
									</div>
								</dt>
							</tpl>
							<div class="x-clear"></div>
						</dl>
	                </tpl>'),
					'store'			=> array(
						'xtype'				=> 'atmJsonstore',
						'root'				=> 'results',
						'totalProperty'		=> 'total',
						'url'				=> $searchURL,
						'id'				=> 'id',
						'remoteSort'		=> true,
						'baseParams'		=> array(
							'module'			=> $moduleCodename,
							'objectId'			=> $this->_objectID
						),
						'fields'			=> array('id', 'status', 'pubrange', 'label', 'description', 'locked', 'deleted', 'previz', 'edit')
					),
					'value' 		=> implode(',',$associatedItems),
		            'width'			=> 'auto',
					'height'		=> 'auto',
					'cls'			=> 'x-list-body',
					'tbar'			=> array(
						((!$params['doNotUseExternalSubObjects']) ? array(
							'text'		=> $language->getMessage(self::MESSAGE_PAGE_ACTION_ASSOCIATE),
							'tooltip'	=> $language->getMessage(self::MESSAGE_MULTI_OBJECT_CHOOSE_ELEMENT,array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME),
							'handler'	=> sensitiveIO::sanitizeJSString('function(button){
								var windowId = \'module'.$moduleCodename.'AssociateWindow\';
								/*create window element*/
								var window = new Automne.Window({
									id:				windowId,
									objectId:		\'\',
									autoLoad:		{
										url:			\''.$associateURL.'\',
										params:			{
											winId:			windowId,
											module:			\''.$moduleCodename.'\',
											type:			\''.$this->_objectID.'\'
										},
										nocache:		true,
										scope:			this
									},
									modal:			true,
									width:			750,
									height:			580,
									animateTarget:	button,
									listeners:{\'close\':function(window){
										var cmp = Ext.getCmp(\''.$listId2.'\');
										if (window.selectedItems && window.selectedItems.split) {
											var values = cmp.getRawValue();
											var items = window.selectedItems.split(\',\');
											for (var i = 0, itemsLen = items.length; i < itemsLen; i++) {
												if (values.indexOf(items[i]) === -1) {
													values.unshift(items[i]);
												}
											}
											cmp.setValue(values.join(cmp.delimiter));
										}
									}}
								});
								/*display window*/
								window.show(button.getEl());
							}', false, false),
							'scope'		=> 'this'
						) : ''), 
						array(
							'text'		=> $language->getMessage(self::MESSAGE_PAGE_ACTION_DESASSOCIATE),
							'tooltip'	=> $language->getMessage(self::MESSAGE_MULTI_OBJECT_DISASSOCIATE_ELEMENT, false, MOD_POLYMOD_CODENAME),
							'handler'	=> sensitiveIO::sanitizeJSString('function(button){
								var cmp = Ext.getCmp(\''.$listId2.'\');
								var selected = cmp.view.getSelectedRecords();
								if (!selected.length || selected.length > 1) {
									Automne.message.popup({
										msg: 				\''.$language->getJSMessage(self::MESSAGE_MULTI_OBJECT_SELECT_BEFORE, false, MOD_POLYMOD_CODENAME).'\',
										buttons: 			Ext.MessageBox.OKCANCEL,
										animEl: 			button.getEl(),
										closable: 			false,
										icon: 				Ext.MessageBox.INFO
									});
									return;
								}
								Automne.message.popup({
									msg: 				\''.io::htmlspecialchars($language->getMessage(self::MESSAGE_PAGE_ACTION_DESASSOCIATE_CONFIRM, array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME)).'\',
									buttons: 			Ext.MessageBox.OKCANCEL,
									animEl: 			button.getEl(),
									closable: 			false,
									icon: 				Ext.MessageBox.WARNING,
									scope:				this,
									fn: 				function (button) {
										if (button == \'ok\') {
											var cmp = Ext.getCmp(\''.$listId2.'\');
											var selected = cmp.view.getSelectedRecords();
											if (!selected.length || selected.length > 1) {
												return;
											}
											var objectId = selected[0].id;
											var values = cmp.getRawValue();
											values.remove(objectId);
											cmp.setValue(values.join(cmp.delimiter));
											if (\''.$listId.'\') {
												var list = Ext.getCmp(\''.$listId.'\');
												if (list) {
													list.store.baseParams.removeIds = values.join(cmp.delimiter);
													list.store.load();
												}
											}
										}
									}
								});
							}', false, false),
							'scope'		=> 'this'
						),'->', array(
							'text'		=> $language->getMessage(self::MESSAGE_PAGE_ACTION_MODIFIY),
							'tooltip'	=> $language->getMessage(self::MESSAGE_MULTI_OBJECT_EDIT_ELEMENT, false, MOD_POLYMOD_CODENAME),
							'iconCls'	=> 'atm-pic-modify',
							'handler'	=> sensitiveIO::sanitizeJSString('function(button){
								var cmp = Ext.getCmp(\''.$listId2.'\');
								var selected = cmp.view.getSelectedRecords();
								if (!selected.length || selected.length > 1) {
									Automne.message.popup({
										msg: 				\''.$language->getJSMessage(self::MESSAGE_MULTI_OBJECT_SELECT_BEFORE, false, MOD_POLYMOD_CODENAME).'\',
										buttons: 			Ext.MessageBox.OKCANCEL,
										animEl: 			button.getEl(),
										closable: 			false,
										icon: 				Ext.MessageBox.INFO
									});
									return;
								}
								var objectId = selected[0].id;
								var windowId = \'module'.$moduleCodename.'EditWindow\'+objectId;
								/*create window element*/
								var window = new Automne.Window({
									id:				windowId,
									objectId:		objectId,
									autoLoad:		{
										url:			\''.$editURL.'\',
										params:			{
											winId:			windowId,
											module:			\''.$moduleCodename.'\',
											type:			\''.$this->_objectID.'\',
											item:			objectId
										},
										nocache:		true,
										scope:			this
									},
									modal:			true,
									width:			750,
									height:			580,
									animateTarget:	button,
									listeners:{\'close\':function(window){
										var cmp = Ext.getCmp(\''.$listId2.'\');
										cmp.store.reload();
									}}
								});
								/*display window*/
								window.show(button.getEl());
							}', false, false),
							'scope'		=> 'this'
						), array(
							'text'		=> $language->getMessage(self::MESSAGE_PAGE_ACTION_NEW),
							'tooltip'	=> $language->getMessage(self::MESSAGE_MULTI_OBJECT_CREATE_ZONE,array($objectDef->getObjectLabel($language)), MOD_POLYMOD_CODENAME),
							'iconCls'	=> 'atm-pic-add',
							'handler'	=> sensitiveIO::sanitizeJSString('function(button){
								var objectId = \'create\';
								var windowId = \'module'.$moduleCodename.'EditWindow\'+objectId;
								/*create window element*/
								var window = new Automne.Window({
									id:				windowId,
									objectId:		\'\',
									autoLoad:		{
										url:			\''.$editURL.'\',
										params:			{
											winId:			windowId,
											module:			\''.$moduleCodename.'\',
											type:			\''.$this->_objectID.'\'
										},
										nocache:		true,
										scope:			this
									},
									modal:			true,
									width:			750,
									height:			580,
									animateTarget:	button,
									listeners:{\'close\':function(window){
										var cmp = Ext.getCmp(\''.$listId2.'\');
										if (window.objectId) {
											var values = cmp.getRawValue();
											values.unshift(window.objectId);
											cmp.setValue(values.join(cmp.delimiter));
										}
									}}
								});
								/*display window*/
								window.show(button.getEl());
							}', false, false),
							'scope'		=> 'this'
						),
					),
		            'ddReorder'		=> true
				);
			}
			$return = array(
				'title' 		=>	$label,
				'xtype'			=>	'fieldset',
				'autoHeight'	=>	true,
				'layout'		=>	'form',
				'defaults'		=> 	array(
					'anchor'		=> '97%',
				),
				'items'			=>	$items
			);
			return $return;
		} else {
			$return = array(
				'allowBlank'	=>	!$this->_field->getValue('required'),
				'fieldLabel' 	=>	$label,
				'name'			=>	'polymodFieldsValue[list'.$prefixName.$this->_field->getID().'_0]'
			);
			//get searched objects conditions
			$searchedObjects = (is_array($params['searchedObjects'])) ? $params['searchedObjects'] : array();
			$objectsNames = CMS_poly_object_catalog::getListOfNamesForObject($this->_objectID, false, $searchedObjects);
			$associatedItems = $availableItems = array();
			if (is_array($objectsNames) && $objectsNames) {
				foreach (array_keys($this->_subfieldValues) as $subFieldID) {
					if (is_object($this->_subfieldValues[$subFieldID])) {
						$associatedItems[$this->_subfieldValues[$subFieldID]->getValue()] = $this->_subfieldValues[$subFieldID]->getValue();
					}
				}
				foreach ($objectsNames as $id => $name) {
					$availableItems[] = array($id, $name);
				}
			} else {
				$availableItems[] = array('', $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET));
				$return['disabled'] 	= true;
			}
			/*$return['xtype'] 			= 'multiselect';
			$return['dataFields'] 		= array('id', 'label');
			$return['data'] 			= $availableItems;
			$return['value'] 			= implode(',',$associatedItems);
			$return['valueField'] 		= "id";
			$return['displayField'] 	= "label";
			$return['width'] 			= '100%';*/
			
			$return['xtype'] 			= 'superboxselect';
			$return['dataFields'] 		= array('id', 'label');
			$return['store'] 			= $availableItems;
			$return['mode'] 			= 'local';
			$return['value'] 			= implode(',',$associatedItems);
			$return['valueField'] 		= "id";
			$return['displayField'] 	= "label";
			$return['width'] 			= '100%';
			$return['stackItems'] 		= true;
			
			return $return;
		}
	}

	/**
      * Return the needed form field tag for current object field
      *
      * @param array $values : parameters values array(parameterName => parameterValue) in :
      *     id : the form field id to set
      * @param multidimentionnal array $tags : xml2Array content of atm-function tag
      * @return string : the form field HTML tag
      * @access public
      */
	function getInput($fieldID, $language, $inputParams) {
		$params = $this->getParamsValues();
		if (isset($inputParams['prefix'])) {
			$prefixName = $inputParams['prefix'];
		} else {
			$prefixName = '';
		}
		$html = '';
		//get searched objects conditions
		$searchedObjects = (is_array($params['searchedObjects'])) ? $params['searchedObjects'] : array();
		$objectsNames = CMS_poly_object_catalog::getListOfNamesForObject($this->_objectID, false, $searchedObjects);
		$searchedObjectsIDs = array_keys($objectsNames);
		if (is_array($objectsNames) && $objectsNames) {
			$associated_items = array();
			foreach (array_keys($this->_subfieldValues) as $subFieldID) {
				//if object is not in the objectsNames array then it is certainly deleted or excluded so remove it from list
				if (is_object($this->_subfieldValues[$subFieldID]) && in_array($this->_subfieldValues[$subFieldID]->getValue(), $searchedObjectsIDs)) {
					$associated_items[] = $this->_subfieldValues[$subFieldID]->getValue();
				}
			}
			//set some default parameters
			if (!isset($inputParams['no_admin'])) {
				$inputParams['no_admin'] = true;
			}
			if (!isset($inputParams['position'])) {
				$inputParams['position'] = 'horizontal';
			}
			if (isset($inputParams['width']) && !isset($inputParams['select_width'])) {
				$inputParams['select_width'] = $inputParams['width'];
			}
			if (isset($inputParams['height']) && !isset($inputParams['select_height'])) {
				$inputParams['select_height'] = $inputParams['height'];
			}
			$listboxesParameters = array (
				'field_name' 		=> 'list'.$prefixName.$this->_field->getID().'_0',// Hidden field name to get value in
				'items_possible' 	=> $objectsNames,			// array of all categories availables: array(ID => label)
				'items_selected' 	=> $associated_items,		// array of selected ids
				'select_width' 		=> '300px',					// Width of selects, default 200px
				'select_height' 	=> '100px',					// Height of selects, default 140px
				'form_name' 		=> $inputParams['form']		// Javascript form name
			);
			//append optional attributes
			foreach ($inputParams as $k => $v) {
				if (in_array($k, array('select_width','select_height','no_admin','leftTitle','rightTitle','position','description','selectIDFrom','selectIDTo','disableIDs','items_possible','items_selected','keepOrder',))) {
					$listboxesParameters[$k] = $v;
				}
			}
			$html = CMS_dialog_listboxes::getListBoxes($listboxesParameters);
			if (POLYMOD_DEBUG) {
				$html .= '<span class="admin_text_alert"> (Field : '.$fieldID.' - Multi of : '.$this->_objectID.' - Values : '.implode(';',$associated_items).')</span>';
			}
		} else {
			$html .= $language->getMessage(self::MESSAGE_EMPTY_OBJECTS_SET);
		}
		//append html hidden field which store field name
		if ($html) {
			$html .= '<input type="hidden" name="polymodFields['.$this->_field->getID().']" value="'.$this->_field->getID().'" />';
		}
		return $html;
	}

	/**
	  * get object HTML description for admin search detail. Usually, the label.
	  *
	  * @parameter string $glue : string glue between each objets labels (default : comma)
	  * @return string : object HTML description
	  * @access public
	  */
	function getHTMLDescription($glue = '') {
		$labels = array();
		foreach (array_keys($this->_subfieldValues) as $subFieldID) {
			if (isset($this->_subfieldValues[$subFieldID]) && is_object($this->_subfieldValues[$subFieldID]) && isset($this->_objectValues[$subFieldID]) && is_object($this->_objectValues[$subFieldID])) {
				//get poly objects labels
				$objectHTMLDescription = $this->_objectValues[$subFieldID]->getHTMLDescription();
				if ($objectHTMLDescription ) {
					$labels[] = $objectHTMLDescription ;
				}
			}
		}
		$glue = ($glue) ? $glue : ', ';
		return implode($glue,$labels);
	}

	/**
	  * check object Mandatories Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @param boolean newFormat : new automne v4 format (default false for compatibility)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function checkMandatory($values,$prefixName, $newFormat = false) {
		//if field is required check values
		if ($this->_field->getValue('required')) {
			//if this multi object hasn't editable param
			$params = $this->getParamsValues();
			//if (!$params['editable']) {
				if (!$values['list'.$prefixName.$this->_field->getID().'_0']) {
					return false;
				}
			//}
		}
		return true;
	}

	/**
	  * set object Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @param boolean newFormat : new automne v4 format (default false for compatibility)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValues($values,$prefixName, $newFormat = false) {
		if (isset($values['list'.$prefixName.$this->_field->getID().'_0'])) {
			$values['list'.$prefixName.$this->_field->getID().'_0'] = str_replace(',',';',$values['list'.$prefixName.$this->_field->getID().'_0']);
			$valuesArray = explode(';',$values['list'.$prefixName.$this->_field->getID().'_0']);
			foreach(array_keys($this->_subfieldValues) as $subFieldID) {
				$value = (isset($valuesArray[$subFieldID])) ? $valuesArray[$subFieldID] : false;
				if (is_object($this->_subfieldValues[$subFieldID]) && $value !== false && sensitiveIO::isPositiveInteger($value)) {
					//replace value
					$this->_subfieldValues[$subFieldID]->setValue($value);
				} else if  (is_object($this->_subfieldValues[$subFieldID]) && ($value === false || !sensitiveIO::isPositiveInteger($value))) {
					//remove unused $this->_subfieldValues
					$this->_subfieldValues[$subFieldID]->destroy();
					unset($this->_subfieldValues[$subFieldID]);
				}
			}
			foreach ($valuesArray as $subFieldID => $aValue) {
				if (!isset($this->_subfieldValues[$subFieldID]) && sensitiveIO::isPositiveInteger($aValue)) {
					$this->_subfieldValues[$subFieldID] = new CMS_subobject_integer();
					$this->_subfieldValues[$subFieldID]->setValue($aValue);
				}
			}

			//and reload all subObject values
			$this->_loadSubObjectsValues();
		}
		return true;
	}

	/**
	  * Get subfields definition for current object
	  *
	  * @param integer $objectTypeID the object type ID who requests these infos
	  * @param integer (can be null) $objectID the object ID who requests these infos
	  * @param CMS_poly_object_field $field, the object field
	  * @return array(integer "subFieldID" =>  array("type" => string [integer|string|text|date], "objectID" => integer, "fieldID" => integer, "subFieldID" => integer))
	  * @access public
	  */
	function getSubFieldsDefinition($objectTypeID,$objectID,$field) {
		$subFieldsDefinition=array();
		$subFieldsDefinition[0] = array('type' 		=> $objectTypeID,
										'objectID'	=> $objectID,
										'fieldID'	=> $field->getID(),
										'subFieldID'=> 0,
										);
		return $subFieldsDefinition;
	}

	/**
	  * Set subfields definition for current object
	  *
	  * @param $subFieldsDefinition array(integer "subFieldID" =>  array("type" => string [integer|string|text|date], "objectID" => integer, "fieldID" => integer, "subFieldID" => integer))
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setSubFieldsDefinition($subFieldsDefinition) {
		foreach(array_keys($this->_subfieldValues) as $subFieldID) {
			if (is_object($this->_subfieldValues[$subFieldID])) {
				$subFieldsDefinition[0]['subFieldID'] = $subFieldID;
				$this->_subfieldValues[$subFieldID]->setDefinition($subFieldsDefinition[0]);
			}
		}
		return true;
	}

	/**
	  * Writes all subobjects into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence() {
		if ($this->_public) {
			$this->raiseError("Can't write public object");
			return false;
		}
		$ok = true;
		foreach (array_keys($this->_subfieldValues) as $subFieldID) {
			if (is_object($this->_subfieldValues[$subFieldID]) && $ok) {
				$ok = ($this->_subfieldValues[$subFieldID]->writeToPersistence()) ? $ok:false;
			}
		}
		return $ok;
	}

	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
		$structure = array();
		$structure['label'] = '';
		$structure['fieldname'] = '';
		$structure['fieldID'] = '';
		$structure['objecttype'] = '';
		$structure['required'] = '';
		$structure['ids'] = '';
		$structure['fields'] = '';
		$structure['count'] = '';
		$structure['description'] = '';
		return $structure;
	}

	/**
	  * get an object field
	  *
	  * @param integer $fieldID : the field to get
	  * @return mixed : the object field
	  * @access public
	  */
	function objectValues($fieldID) {
		if (!isset($this->_objectValues[$fieldID])) {
			global $cms_language;
			$language = $cms_language ? $cms_language : CMS_languagesCatalog::getDefaultLanguage();
			$objectDef = $this->getObjectDefinition();
			$this->raiseError('Object field with ID '.$fieldID.' does not exists as a field of object '.$objectDef->getObjectLabel($language));
			return $this;
		}
		return $this->_objectValues[$fieldID];
	}

	/**
	  * get an object value
	  *
	  * @param string $name : the name of the value to get
	  * @param string $parameters (optional) : parameters for the value to get
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getValue($name, $parameters = '') {
		global $cms_language;
		switch ($name) {
			case 'label':
				return $this->getHTMLDescription($parameters);
			break;
			case 'fieldname':
				return $this->getFieldLabel($cms_language);
			break;
			case 'objecttype':
				return $this->_objectID;
			break;
			case 'objectname':
				$object = new CMS_poly_object($this->_objectID);
				return $object->getFieldLabel($cms_language);
			break;
			case 'objectdescription':
				$object = new CMS_poly_object($this->_objectID);
				return $object->getFieldDesc($cms_language);
			break;
			case 'required':
				return ($this->_field->getValue('required')) ? true : false;
			break;
			case 'ids':
				/*$ids = array();
				if($this->_objectValues){
					foreach($this->_objectValues as $polyObject){
						$ids[$polyObject->getID()] = $polyObject->getID();
					}
				} else if ($this->_subfieldValues) { //in case object is not loaded
					foreach($this->_subfieldValues as $subObject){
						$ids[$subObject->getValue()] = $subObject->getValue();
					}
				}
				return $ids;*/
				return $this->getIDs();
				break;
			case 'fields':
				return $this->_objectValues;
			break;
			case 'count':
				return sizeof($this->_objectValues);
			break;
			case 'fieldID':
				return $this->_field->getID();
			break;
			case 'description':
				return io::htmlspecialchars($this->getFieldDescription($cms_language));
			break;
			default:
				$this->raiseError("Unknown value to get : ".$name);
				return false;
			break;
		}
	}

	/**
	  * For a given object type, return options tag list (for a select tag) of all objects labels
	  *
	  * @param array $values : parameters values array(parameterName => parameterValue) in :
	  * 	selected : the object id which is selected (optional)
	  * @param multidimentionnal array $tags : xml2Array content of atm-function tag (nothing for this one)
	  * @return string : options tag list
	  * @access public
	  */
	function selectOptions($values, $tags) {
		$objectValues = CMS_poly_object_catalog::getListOfNamesForObject($this->_objectID, true);
		$return = "";
		if (is_array($objectValues) && $objectValues) {
			foreach ($objectValues as $objectID => $objectLabel) {
				$selected = (isset($values['selected']) && $objectID == $values['selected']) ? ' selected="selected"':'';
				$return .= '<option title="'.io::htmlspecialchars($objectLabel).'" value="'.$objectID.'"'.$selected.'>'.$objectLabel.'</option>';
			}
		}
		return $return;
	}

	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	function getLabelsStructure(&$language, $objectName) {
		$labels = array();
		$object = new CMS_poly_object($this->_objectID);
		$labels['structure']['label'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_LABEL_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['fieldname'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_FIELDNAME_DESCRIPTION,array($this->getFieldLabel($language)),MOD_POLYMOD_CODENAME);
		$labels['structure']['fieldID'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_FIELDID_DESCRIPTION,array($this->_field->getID()),MOD_POLYMOD_CODENAME);
		$labels['structure']['required'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_REQUIRED_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['objectname'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_OBJECTNAME_DESCRIPTION,array($object->getFieldLabel($language)) ,MOD_POLYMOD_CODENAME);
		$labels['structure']['objectdescription'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_OBJECTDESC_DESCRIPTION,array($object->getFieldDesc($language)) ,MOD_POLYMOD_CODENAME);
		$labels['structure']['objecttype'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_OBJECTTYPE_DESCRIPTION,array($this->_objectID),MOD_POLYMOD_CODENAME);
		$labels['structure']['ids'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_IDS_DESCRIPTION,array($object->getFieldLabel($language)),MOD_POLYMOD_CODENAME);
		$labels['structure']['fields'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_FIELDS_DESCRIPTION,array($object->getFieldLabel($language)),MOD_POLYMOD_CODENAME);
		$labels['structure']['count'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_COUNT_DESCRIPTION,array($object->getFieldLabel($language)),MOD_POLYMOD_CODENAME);
		$labels['structure']['description'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_FIELD_DESC_DESCRIPTION,array(io::htmlspecialchars($this->getFieldDescription($language))),MOD_POLYMOD_CODENAME);
		$labels['function']['selectOptions'] = $language->getMessage(self::MESSAGE_MULTI_OBJECT_FUNCTION_SELECTOPTIONS_DESCRIPTION,array('{'.$objectName.'}') ,MOD_POLYMOD_CODENAME);

		return $labels;
	}

	/**
	  * Return a list of all objects names of given type
	  *
	  * @param boolean $public are the needed datas public ? (default false)
	  * @param array $searchConditions, search conditions to add. Format : array(conditionType => conditionValue)
	  * @return array(integer objectID => string objectName)
	  * @access public
	  * @static
	  */
	function getListOfNamesForObject($public = false, $searchConditions = array()) {
		return CMS_poly_object_catalog::getListOfNamesForObject(io::substr($this->_field->getValue('type'),6), $public, $searchConditions);
	}

	/**
	  * Get field search SQL request (used by class CMS_object_search)
	  *
	  * @param integer $fieldID : this field id in object
	  * @param mixed $value : the value to search
	  * @param string $operator : additionnal search operator
	  * @param string $where : where clauses to add to SQL
	  * @param boolean $public : values are public or edited ? (default is edited)
	  * @return string : the SQL request
	  * @access public
	  */
	function getFieldSearchSQL($fieldID, $value, $operator, $where, $public = false) {
		$statusSuffix = ($public) ? "_public":"_edited";
		$sql = "
		select
			distinct objectID
		from
			mod_subobject_integer".$statusSuffix."
		where
			objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
			and value ".(is_array($value) ? "in (".SensitiveIO::sanitizeSQLString(implode(',',$value)).")" : "= '".SensitiveIO::sanitizeSQLString($value)."'")."
			$where
		";
		return $sql;
	}
}
?>
