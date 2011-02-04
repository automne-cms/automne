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
// $Id: object_search.php,v 1.16 2010/03/08 16:43:30 sebastien Exp $

/**
  * Class CMS_object_search
  *
  * represent a search object
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_search extends CMS_grandFather
{
	const POLYMOD_SEARCH_RETURN_OBJECTS = 0;
	const POLYMOD_SEARCH_RETURN_IDS = 1;
	const POLYMOD_SEARCH_RETURN_DATAS = 2;
	const POLYMOD_SEARCH_RETURN_OBJECTSLIGHT = 3;
	const POLYMOD_SEARCH_RETURN_OBJECTSLIGHT_EDITED = 4;
	const POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS = 5;
	
	/**
	  * Number of items founded
	  * If it set before searching then number of items to be searched is limited to this number
	  * 
	  * @var integer
	  * @access private
	  */
	protected $_numRows;
	
	/**
	  * ORDER BY clause of SQL statement
	  * 
	  * @var array(string fieldname => string direction)
	  * @access private
	  */
	protected $_orderConditions = array();
	
	/**
	  * Array of statements to build SQLs
	  * 
	  * @var array(type => array(value => string, operator => string))
	  * @access private
	  */
	protected $_whereConditions = array();
	
	/**
	  * Array of founded results ids unsorted
	  * 
	  * @var array(integer id => integer id)
	  * @access private
	  */
	protected $_resultsIds = array();
	
	/**
	  * Array of founded results ids sorted
	  * 
	  * @var array(integer id => integer id)
	  * @access private
	  */
	protected $_sortedResultsIds = array();
	
	/**
	  * Array of founded results subobjects ids
	  * 
	  * @var array(integer id => integer id)
	  * @access private
	  */
	protected $_resultsSubObjectsIds = array();
	
	/**
	  * Array of founded results objects (and subobjects) values
	  * 
	  * @var array(objectID => array(objectFieldID => array(objectSubfieldId => array(sql datas))))
	  * @access private
	  */
	protected $_values = array();
	
	/**
	  * Current page to return
	  * @var integer
	  * @access private
	  */
	protected $_page = 0;

	/**
	  * Number of items to return on each page
	  * @var integer
	  * @access private
	  */
	protected $_itemsPerPage;
	
	/**
	  * Search in public datas only if set tot true
	  * 
	  * @var boolean
	  * @access private
	  */
	protected $_public = false;

	/**
	  * Current search object definition
	  * 
	  * @var CMS_poly_object_definition
	  * @access private
	  */
	protected $_object;

	/**
	  * Current search object fields definitions
	  * 
	  * @var CMS_poly_object_definition
	  * @access private
	  */
	protected $_fieldsDefinitions;
	
	/**
	  * Current search results score (only for keywords search)
	  * 
	  * @var array(integer $resultId => float score)
	  * @access private
	  */
	protected $_score = array();
	
	/**
	  * Current search return mode
	  * 
	  * @var integer
	  * @access private
	  */
	protected $_searchMode = false;
	
	/**
	  * Current search results objects values
	  * 
	  * @var mixed (false if not populated, array otherwise)
	  * @access private
	  */
	protected $_objectsValues = false;
	
	/**
	  * Count objects returned by method getNextResult
	  * 
	  * @var integer
	  * @access private
	  */
	protected $_objectsCount = 0;
	
	/**
	  * Constructor
	  * 
	  * @access public
	  * @param $objectDefinition CMS_poly_object_definition the current search object definition or the ID of the CMS_poly_object_definition
	  * @param boolean $public
	  */
	function __construct($objectDefinition, $public = false) {
		global $cms_user;
		if (io::isPositiveInteger($objectDefinition)) {
            $objectDefinition = new CMS_poly_object_definition($objectDefinition);
        }
		if (!is_a($objectDefinition,'CMS_poly_object_definition')) {
			$this->raiseError('ObjectDefinition must be a valid CMS_poly_object_definition.');
			return false;
		}
		$this->_object = $objectDefinition;
		// Set public status
		$this->_public = $public;
		
		//add search object type condition
		$this->addWhereCondition("object", $this->_object);
		//if cms_user exists, check user rights
		if (is_object($cms_user)) {
			$this->addWhereCondition("profile", $cms_user);
		}
		
		//add resource condition if any
		if ($this->_object->isPrimaryResource()) {
			//if this is a public search, add limitation to resource publications dates
			if ($this->_public) {
				$limitDate = new CMS_date();
				$limitDate->setNow();
				$this->addWhereCondition("publication date before",$limitDate);
				$this->addWhereCondition("publication date end",$limitDate);
			}
		}
	}
	
	/**
	 * Getter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name
	 * @return string
	 */
	function getAttribute($name) {
		$name = '_'.$name;
		return $this->$name;
	}
	
	/**
	 * Setter for any private attribute on this class
	 *
	 * @access public
	 * @param string $name name of attribute to set
	 * @param $value , the value to give
	 */
	function setAttribute($name, $value) {
		if ($name == 'page' && $value < 0) {
			$value = 0;
		}
		$name = '_'.$name;
		$this->$name = $value;
		return true;
	}
	
	/**
	 * Get all static where conditions types
	 *
	 * @return array of condition types
	 * @access public
	 * @static
	 */
	static function getStaticSearchConditionTypes() {
		return array(
			"object",
			"item",
			"items",
			"itemsOrdered",
			"archives",
			//"profile",
			//"category",
			"keywords",
			"publication date after", //Date start (from)
			"publication date before", //Date end (to)
			"status", //Publication status
			//"publication date end" //end of publication : system field : hidden
		);
	}
	
	/**
	 * Get all results score for current search
	 *
	 * @return array of results score array(integer $resultId => float score)
	 * @access public
	 */
	function getScore() {
		return $this->_score;
	}
	
	/**
	 * Builds where statement with a key and its value
	 * The key can be a known string, this class will create statements in consequence
	 * or it can be a field id
	 *
	 * @access public
	 * @param string $key name of statement to set
	 * @param string $value , the value to give
	 * @param string $operator, additional optional search operator
	 * @return void or false if an error occured
	 */
	function addWhereCondition($type, $value, $operator = false) {
		if (!$type || (!$value && !$operator)) {
			return;
		}
		//clean value
		if (!is_object($value) && !is_array($value)) {
			$value = sensitiveIO::sanitizeSQLString($value);
		} elseif(is_array($value)) {
			$value = array_map(array('sensitiveIO', 'sanitizeSQLString'), $value);
		}
		$operator = $operator ? io::decodeEntities($operator) : false;
		$statusSuffix = ($this->_public) ? "_public":"_edited";
		switch($type) {
		case "object":
			if ($value && !is_a($value,'CMS_poly_object_definition')) {
				$this->raiseError('Value must be a valid CMS_poly_object_definition.');
				return false;
			}
			$this->_object = $value;
			$this->_whereConditions['object'][] = array('value' => $value, 'operator' => $operator);
			break;
		case "item":
			if (!sensitiveIO::isPositiveInteger($value)) {
				$this->raiseError("Value must be a positive Integer.");
				return false;
			}
			$this->_whereConditions['item'][] = array('value' => $value, 'operator' => $operator);
			break;
		case "items":
			if (!$value) {
				$this->raiseError('Value must be a populated array.');
				return false;
			}
			$this->_whereConditions['items'][] = array('value' => $value, 'operator' => $operator);
			break;
		case 'archives':
			if ($this->_public && $this->_object->isPrimaryResource() && ($value == 1 || $value == 'true' || $value == true)) {
				unset($this->_whereConditions['publication date before']);
				unset($this->_whereConditions['publication date end']);
			}
		break;
		case "itemsOrdered":
			if (!$value) {
				$this->raiseError('Value must be a populated array.');
				return false;
			}
			$this->_whereConditions['items'][] = array('value' => $value, 'operator' => $operator);
			$this->_orderConditions['itemsOrdered']['order'] = $value;
			break;
		case "profile":
			if (!is_a($value,'CMS_profile_user')) {
				$this->raiseError('Value must be a valid CMS_profile_user.');
				return false;
			}
			$this->_whereConditions['profile'][] = array('value' => $value, 'operator' => $operator);
			break;
		case "category":
			//this search type is deprecated, keep it for compatibility but now it is replaced by direct field id access
			
			//get field of categories for searched object type (assume it uses categories)
			$categoriesFields = CMS_poly_object_catalog::objectHasCategories($this->_object->getId());
			
			$this->_whereConditions[$categoriesFields[0]][] = array('value' => $value, 'operator' => $operator);
			break;
		case "keywords":
			if ($value) {
				$this->_whereConditions['keywords'][] = array('value' => $value, 'operator' => $operator);
			}
			break;
		case "publication date after": // Date start
			if ($this->_object->isPrimaryResource()) {
				if (!is_a($value, 'CMS_date')) {
					$this->raiseError('Value must be a valid CMS_date.');
					return false;
				}
				$this->_whereConditions['publication date after'][] = array('value' => $value, 'operator' => $operator);
			}
			break;
		case "publication date before": // Date End
			if ($this->_object->isPrimaryResource()) {
				if (!is_a($value, 'CMS_date')) {
					$this->raiseError('Value must be a valid CMS_date.');
					return false;
				}
				$this->_whereConditions['publication date before'][] = array('value' => $value, 'operator' => $operator);
			}
			break;
		case "publication date end": // End Date of publication
			if ($this->_object->isPrimaryResource()) {
				if (!is_a($value, 'CMS_date')) {
					$this->raiseError('Value must be a valid CMS_date.');
					return false;
				}
				$this->_whereConditions['publication date end'][] = array('value' => $value, 'operator' => $operator);
			}
			break;
		case "status": // Publication status
			if ($this->_object->isPrimaryResource()) {
				if (!in_array($value, array('online', 'offline', 'validated', 'awaiting'))) {
					$this->raiseError('Status value must be one of them : online, offline, public, awaiting');
					return false;
				}
				$this->_whereConditions['status'][] = array('value' => $value, 'operator' => $operator);
			}
			break;
		default:
			if (sensitiveIO::IsPositiveInteger($type)) {
				$this->_whereConditions[$type][] = array('value' => $value, 'operator' => $operator);
				break;
			}
			$this->raiseError('Unknown type : '.$type.' or value '.$value);
			return false;
			break;
		}
	}
	
	/**
	 * Get all static order conditions types
	 *
	 * @return array of condition types
	 * @access public
	 * @static
	 */
	static function getStaticOrderConditionTypes() {
		$orderConditions = array(
			"objectID",
			"random",
			"publication date after", //Date start
			"publication date before", //Date end
			"publication date start",
			"publication date end",
		);
		//if ASE module exists, add a sort by relevance
		if (class_exists('CMS_module_ase')) {
			$orderConditions[] = "relevance";
		}
		return $orderConditions;
	}
	
	/**
	 * Builds order statement with a key and its value
	 * The key can be a known string or it can be a field id, this method will create statements in consequence
	 *
	 * @access public
	 * @param string $key name of statement to set
	 * @param string $direction , the direction to give (asc or desc, default is asc)
	 * @return void or false if an error occured
	 */
	function addOrderCondition($type, $direction = 'asc', $operator = false) {
		if (!$type || !in_array($direction,array('asc','desc'))) {
			return;
		}
		$value = array('direction' => $direction, 'operator' => $operator);
		switch($type) {
		case "objectID":
			$this->_orderConditions['objectID'] = $value;
			break;
			if ($this->_object->isPrimaryResource()) {
				$this->_orderConditions['publication date after'] = $value;
			}
			break;
		case "publication date after": // Date start
		case "publication date before":
		case "publication date start":
		case "publication date end":
			if ($this->_object->isPrimaryResource()) {
				$this->_orderConditions[$type] = $value;
			}
			break;
		case "random": // Random ordering
			$this->_orderConditions['random'] = $value;
			break;
		case "relevance": // Only if ASE module exists
			if (class_exists('CMS_module_ase')) {
				$this->_orderConditions['relevance'] = $value;
			} else {
				$this->raiseError('Sorting by relevance is not active if module ASE does not exists ... ');
				return false;
			}
			break;
		default:
			if (sensitiveIO::IsPositiveInteger($type)) {
				$this->_orderConditions[$type] = $value;
				break;
			}
			$this->raiseError('Unknown type : '.$type);
			return false;
			break;
		}
	}
	
	/**
	 * Count items founded with query COUNT(*)
	 * 
	 * @access public
	 * @return integer
	 */
	function getNumRows() {
		if (!isset($this->_numRows)) {
			$this->raiseError('Can\'t get numRows if search is not done');
			return false;
		}
		return $this->_numRows;
	}
	
	/**
	 * Count and returns how many of pages in resultset with 
	 * current itemsPerpage value
	 * 
	 * @access public
	 * @return integer
	 */
	function getMaxPages() {
		if (!isset($this->_numRows)) {
			return 0;
		}
		$maxPages = 0;
		if ($this->_itemsPerPage > 0) {
			$maxPages = @ceil($this->_numRows / $this->_itemsPerPage);
		}
		return $maxPages;
	}
	
	/**
	 * Get all searched objects ids
	 * 
	 * @access private
	 * @return array of object ids unsorted
	 */
	protected function _getIds() {
		$IDs = array();
		$statusSuffix = ($this->_public) ? "_public":"_edited";
		//loop on each conditions
		foreach ($this->_whereConditions as $type => $typeWhereConditions) {
			foreach ($typeWhereConditions as $whereConditionsValues) {
				$value = $whereConditionsValues['value'];
				$operator = $whereConditionsValues['operator'];
				$sql = '';
				switch($type) {
				case "object":
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' and id_moo in ('.implode(',',$IDs).')':'';
					
					//to remove deleted objects from results
					$sql = "
					select
						id_moo as objectID
					from
						mod_object_polyobjects
					where
						object_type_id_moo  = '".$this->_object->getID()."'
						and deleted_moo = '0'
						$where
					";
					break;
				case "item":
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
					//check operator
					$supportedOperator = array(
						'=',
						'!=',
					);
					if ($operator && !in_array($operator, $supportedOperator)) {
						$this->raiseError("Unknown search operator : ".$operator.", use default search instead");
						$operator = false;
					}
					if (!$operator) {
						$operator = '=';
					}
					$sql = "
					select
						distinct objectID
					from
						mod_subobject_text".$statusSuffix."
					where
						objectID ".$operator." '".$value."'
						$where
					union distinct
					select
						distinct objectID
					from
						mod_subobject_integer".$statusSuffix."
					where
						objectID ".$operator." '".$value."'
						$where
					union distinct
					select
						distinct objectID
					from
						mod_subobject_string".$statusSuffix."
					where
						objectID ".$operator." '".$value."'
						$where
					union distinct
					select
						distinct objectID
					from
						mod_subobject_date".$statusSuffix."
					where
						objectID ".$operator." '".$value."'
						$where
					";
					break;
				case "items":
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
					//check operator
					$supportedOperator = array(
						'not in'
					);
					if ($operator && !in_array($operator, $supportedOperator)) {
						$this->raiseError("Unknown search operator : ".$operator.", use default search instead");
						$operator = false;
					}
					if (!$operator) {
						$operator = 'in';
					}
					//no values to found so break search
					if ((!is_array($value) || !$value) && $operator == 'in') {
						$IDs = array();
						break;
					}
					$sql = "
					select
						distinct objectID
					from
						mod_subobject_text".$statusSuffix."
					where
						objectID ".$operator." (".implode(',',$value).")
						$where
					union distinct
					select
						distinct objectID
					from
						mod_subobject_integer".$statusSuffix."
					where
						objectID ".$operator." (".implode(',',$value).")
						$where
					union distinct
					select
						distinct objectID
					from
						mod_subobject_string".$statusSuffix."
					where
						objectID ".$operator." (".implode(',',$value).")
						$where
					union distinct
					select
						distinct objectID
					from
						mod_subobject_date".$statusSuffix."
					where
						objectID ".$operator." (".implode(',',$value).")
						$where
					";
					break;
				case "profile":
					//if user has no right on module, he cannot search object on it
					if (!$value->hasModuleClearance($this->_object->getValue('module'), CLEARANCE_MODULE_VIEW)) {
						break;
					}
					//if object has categories, check rights on it
					if ($this->_object->hasCategories()) {
						//get field of categories for searched object type (assume it uses categories)
						$categoriesFields = CMS_poly_object_catalog::objectHasCategories($this->_object->getId());
						//BUG : in websites without APPLICATION_ENFORCES_ACCESS_CONTROL, backend rights on categories are checked on visibility instead of edition
						if (/*APPLICATION_ENFORCES_ACCESS_CONTROL && */!$this->_public)  {
							$clearance = CLEARANCE_MODULE_EDIT;
							$strict = true;
						} else {
							$clearance = CLEARANCE_MODULE_VIEW;
							$strict = false;
						}
						//get a list of all viewvable categories for current user
						$cats = array_keys(CMS_moduleCategories_catalog::getViewvableCategoriesForProfile($value, $this->_object->getValue('module'), true, $clearance, $strict));
						
						foreach ($categoriesFields as $categoriesField) {
							//load category field if not exists
							if (!isset($this->_fieldsDefinitions[$categoriesField]) || !is_object($this->_fieldsDefinitions[$categoriesField])) {
								//get object fields definition
								$this->_fieldsDefinitions = CMS_poly_object_catalog::getFieldsDefinition($this->_object->getID());
							}
							if (!isset($this->_fieldsDefinitions[$categoriesField])) {
								break;
							}
							//we can see objects without categories only if is not public or field is not required and user has admin right on module
							if (($this->_public && !$this->_fieldsDefinitions[$categoriesField]->getValue('required')) || (!$this->_public && $value->hasModuleClearance($this->_object->getValue('module'), CLEARANCE_MODULE_EDIT))) {
								//add deleted cats to searchs
								$viewvableCats = array_merge(CMS_moduleCategories_catalog::getDeletedCategories($this->_object->getValue('module')), $cats);
								//add zero value for objects without categories
								$viewvableCats[] = 0;
							} else {
								$viewvableCats = $cats;
								//add zero value for objects without categories
								$viewvableCats[] = 0;
							}
							//if no viewvable categories, user has no rights to view anything
							if (!$viewvableCats) {
								break;
							}
							$removedIDs = array();
							//add previously founded IDs to where clause
							$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
							$sqlTmp = "
								select
									distinct objectID
								from
									mod_subobject_integer".$statusSuffix."
								where
									objectFieldID = '".$categoriesField."'
									and value not in (".@implode(',', $viewvableCats).")
									$where
							";
							$qTmp = new CMS_query($sqlTmp);
							while ($r = $qTmp->getArray()) {
								if ($r['objectID'] && isset($IDs[$r['objectID']])) {
									$removedIDs[$r['objectID']] = $r['objectID'];
								}
							}
							//add (again) ids which has a category visible and a category not visible
							if ($removedIDs) {
								$sqlTmp = "
									select
										distinct objectID
									from
										mod_subobject_integer".$statusSuffix."
									where
										objectFieldID = '".$categoriesField."'
										and value in (".@implode(',', $viewvableCats).")
										$where
								";
								$qTmp = new CMS_query($sqlTmp);
								while ($r = $qTmp->getArray()) {
									if ($r['objectID'] && isset($removedIDs[$r['objectID']])) {
										unset($removedIDs[$r['objectID']]);
									}
								}
								//then finally remove ids
								foreach ($removedIDs as $idToRemove) {
									unset($IDs[$idToRemove]);
								}
							}
							//if no IDs break
							if (!$IDs) {
								break;
							}
							//if field is required and if it is a public search, object must have this category in DB
							if ($this->_fieldsDefinitions[$categoriesField]->getValue('required') && $this->_public) {
								$sqlTmp = "
									select
										distinct objectID
									from
										mod_subobject_integer".$statusSuffix."
									where
										objectFieldID = '".$categoriesField."'
										and objectID in (".@implode(',', $IDs).")
								";
								$qTmp = new CMS_query($sqlTmp);
								$IDs = array();
								while ($r = $qTmp->getArray()) {
									$IDs[$r['objectID']] = $r['objectID'];
								}
							}
							//if no IDs break
							if (!$IDs) {
								break;
							}
						}
						//if no IDs break
						if (!$IDs) {
							break;
						}
					} elseif (!$this->_public && !$value->hasModuleClearance($this->_object->getValue('module'), CLEARANCE_MODULE_EDIT)) {
						break;
					} elseif ($this->_public && !$value->hasModuleClearance($this->_object->getValue('module'), CLEARANCE_MODULE_VIEW)) {
						break;
					}
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' id_moo in ('.implode(',',$IDs).')':'';
					$sql = "
						select
							distinct id_moo as objectID
						from
							mod_object_polyobjects
						where
							$where
						";
					break;
				case "keywords":
					if ($value) {
						//check operators
						$supportedOperator = array(
							'any',
							'all',
							'phrase',
						);
						if ($operator && !in_array($operator, $supportedOperator)) {
							$this->raiseError("Unkown search operator : ".$operator.", use default search instead");
							$operator = 'any';
						} elseif(!$operator) {
							$operator = 'any';
						}
						
						//if ASE module exists and object is indexed, and search is public, use it to do this search
						if ($operator == 'any' && class_exists('CMS_module_ase') && $this->_object->getValue('indexable') && $this->_public) {
							//get language code for stemming
							$languageCode = '';
							if ($languageFieldIDs = CMS_poly_object_catalog::objectHasLanguageField($this->_object->getID())) {
								$languageFieldID = array_shift($languageFieldIDs);
								//if any query use this field, use the queried value for stemming strategy
								if (isset($this->_whereConditions[$languageFieldID]) && $this->_whereConditions[$languageFieldID]) {
									$languageCode = $this->_whereConditions[$languageFieldID][0]['value'];
								}
							}
							//otherwise, we use current language
							if (!$languageCode) {
								global $cms_language;
								$languageCode = $cms_language->getCode();
							}
							if (!$languageCode) {
								$languageCode = io::strtolower(APPLICATION_DEFAULT_LANGUAGE);
							}
							$module = $this->_object->getValue('module');
							//create Xapian search object
							$search = new CMS_XapianQuery(trim($value), array($module), $languageCode, true);
							
							//load module interface
							if (!($moduleInterface = CMS_ase_interface_catalog::getModuleInterface($module))) {
								$this->raiseError('No active Xapian interface for module : '.$module);
								return false;
							}
							//add previously founded IDs to search filters
							$moduleInterface->addFilter('items', $IDs);
							//set module interface to search engine
							$search->setModuleInterface($module, $moduleInterface);
							//set page number and max results for xapian query
							//we must do a complete search all the time so we start from page 0
							$page = 0;
							//we limit to a maximum of 1000 results
							$maxResults = 1000;
							//then search
							if (!$search->query($page, $maxResults)) {
								$this->raiseError('Error in Xapian query for search : '.io::htmlspecialchars($value));
								return false;
							}
							//pr($search->getQueryDesc(true));
							//if no results : break
							if (!$search->getMatchesNumbers()) {
								break;
							}
							$xapianResults = $search->getMatches();
						} else {
							//get fields
							if (!isset($this->_fieldsDefinitions[$type]) || !is_object($this->_fieldsDefinitions[$type])) {
								//get object fields definition
								$this->_fieldsDefinitions = CMS_poly_object_catalog::getFieldsDefinition($this->_object->getID());
							}
							//search only in "searchable" fields
							$fields = array();
							$aseExists = (class_exists('CMS_module_ase') && $this->_object->getValue('indexable')) ? true : false;
							foreach ($this->_fieldsDefinitions as $fieldDefinition) {
								if ($fieldDefinition->getValue(($aseExists ? 'indexable' : 'searchable'))) {
									$fields[] = $fieldDefinition->getID();
								}
							}
							if (!$fields) {
								//if no fields after cleaning, return
								break;
							}
							//add previously founded IDs to where clause
							$where = ($IDs) ? ' objectID in ('.implode(',',$IDs).') and ':'';
							//filter on specified fields
							$where .= ($fields) ? ' objectFieldID  in ('.implode(',',$fields).') and ':'';
							
							//first do a fulltext search
							//fulltext is removed because it does not work with operators "all" and "phrase"
							/*$tables = array(
								'mod_subobject_text',
								'mod_subobject_string',
							);
							$fullTextResults = array();
							foreach ($tables as $key => $table) {
								$sqlTmp = "
									select 
										objectID, match (value) against ('".$value."') as m1 ".($value != htmlentities($value) ? ", match (value) against ('".htmlentities($value)."') as m2" : '')."
									from
										".$table.$statusSuffix."
									where
										".$where."
										(match (value) against ('".$value."')
										".($value != htmlentities($value) ? "or match (value) against ('".htmlentities($value)."')" : '').")
								";
								$qTmp = new cms_query($sqlTmp);
								$IDs = array();
								while ($r = $qTmp->getArray()) {
									if (!isset($this->_score[$r['objectID']]) || (isset($this->_score[$r['objectID']]) && $r['m1'] > $this->_score[$r['objectID']])) {
										$this->_score[$r['objectID']] = $r['m1'];
									}
									if (isset($r['m2']) && (!isset($this->_score[$r['objectID']]) || (isset($this->_score[$r['objectID']]) && $r['m2'] > $this->_score[$r['objectID']]))) {
										$this->_score[$r['objectID']] = $r['m2'];
									}
									$fullTextResults[$r['objectID']] = $r['objectID'];
								}
							}*/
							//clean user keywords (never trust user input, user is evil)
							$value = strtr($value, ",;", "  ");
							$words = array();
							$words = array_map("trim",array_unique(explode(" ", $value)));
							$cleanedWords = array();
							foreach ($words as $aWord) {
								if ($aWord && $aWord!='' && io::strlen($aWord) >= 3) {
									$aWord = str_replace(array('%','_'), array('\%','\_'), $aWord);
									$cleanedWords[] = $aWord;
								}
							}
							if (!$cleanedWords) {
								//if no words after cleaning, return
								break;
							}
							switch ($operator) {
								case 'any';
									$where .= '(';
									//then add keywords
									$count='0';
									foreach ($cleanedWords as $aWord) {
										$where.= ($count) ? ' or ':'';
										$count++;
										$where .= "value like '%".$aWord."%'";
										if (htmlentities($aWord) != $aWord) {
											$where .= " or value like '%".htmlentities($aWord)."%'";
										}
									}
									$where .= ')';
								break;
								case 'all':
									$where .= '(';
									//then add keywords
									$count='0';
									foreach ($cleanedWords as $aWord) {
										$where.= ($count) ? ' and ':'';
										$count++;
										if (htmlentities($aWord) != $aWord) {
											$where .= "(value like '%".$aWord."%' or value like '%".htmlentities($aWord)."%')";
										} else {
											$where .= "value like '%".$aWord."%'";
										}
									}
									$where .= ')';
								break;
								case 'phrase':
									$value = str_replace(array('%','_'), array('\%','\_'), trim($value));
									if (htmlentities($value) != $value) {
										$where .= "(value like '%".$value."%' or value like '%".htmlentities($value)."%')";
									} else {
										$where .= "value like '%".$value."%'";
									}
								break;
							}
							
							$sql = "
								select
									distinct objectID
								from
									mod_subobject_text".$statusSuffix."
								where
									$where
								union distinct
								select
									distinct objectID
								from
									mod_subobject_integer".$statusSuffix."
								where
									$where
								union distinct
								select
									distinct objectID
								from
									mod_subobject_string".$statusSuffix."
								where
									$where
								union distinct
								select
									distinct objectID
								from
									mod_subobject_date".$statusSuffix."
								where
									$where
							";
							//append fulltext results if any
							/*if ($fullTextResults) {
								$sql .= "
								union distinct
								select
									distinct id_moo as objectID
								from
									mod_object_polyobjects
								where
									id_moo in (".implode(',', $fullTextResults).")";
							}*/
						}
					}
					break;
				case "publication date after": // Date start
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
					
					$sql = "
							select
								distinct objectID
							from
								mod_subobject_integer".$statusSuffix.",
								resources,
								resourceStatuses
							where
								objectFieldID = '0'
								and value = id_res
								and status_res=id_rs
								and publicationDateStart_rs >= '".$value->getDBValue(true)."'
								and publicationDateStart_rs != '0000-00-00'
								$where
							";
					break;
				case "publication date before": // Date End
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
					
					$sql = "
							select
								distinct objectID
							from
								mod_subobject_integer".$statusSuffix.",
								resources,
								resourceStatuses
							where
								objectFieldID = '0'
								and value = id_res
								and status_res=id_rs
								and publicationDateStart_rs <= '".$value->getDBValue(true)."'
								and publicationDateStart_rs != '0000-00-00'
								$where
							";
					break;
				case "publication date end": // End Date of publication
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
					
					$sql = "
							select
								distinct objectID
							from
								mod_subobject_integer".$statusSuffix.",
								resources,
								resourceStatuses
							where
								objectFieldID = '0'
								and value = id_res
								and status_res=id_rs
								and (publicationDateEnd_rs >= '".$value->getDBValue(true)."'
								or publicationDateEnd_rs = '0000-00-00')
								$where
							";
					break;
				case "status": // Publication status
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
					switch ($value) {
						case 'online':
							$sql = "
								select
									distinct objectID
								from
									mod_subobject_integer".$statusSuffix.",
									resources,
									resourceStatuses
								where
									objectFieldID = '0'
									and value = id_res
									and status_res=id_rs
									and location_rs='".RESOURCE_LOCATION_USERSPACE."'
									and publication_rs='".RESOURCE_PUBLICATION_PUBLIC."'
									and publicationDateStart_rs <= '".date('Y-m-d')."'
									and publicationDateStart_rs != '0000-00-00'
									and (publicationDateEnd_rs >= '".date('Y-m-d')."'
									or publicationDateEnd_rs = '0000-00-00')
									$where
								";
						break;
						case 'offline':
							$sql = "
								select
									distinct objectID
								from
									mod_subobject_integer".$statusSuffix.",
									resources,
									resourceStatuses
								where
									objectFieldID = '0'
									and value = id_res
									and status_res=id_rs
									and (publication_rs='".RESOURCE_PUBLICATION_NEVERVALIDATED."' or publication_rs='".RESOURCE_PUBLICATION_VALIDATED."')
									and (publicationDateStart_rs > '".date('Y-m-d')."' or publicationDateEnd_rs < '".date('Y-m-d')."')
									$where
								";
						break;
						case 'validated':
							$sql = "
								select
									distinct objectID
								from
									mod_subobject_integer".$statusSuffix.",
									resources,
									resourceStatuses
								where
									objectFieldID = '0'
									and value = id_res
									and status_res=id_rs
									and editions_rs=0
									$where
								";
						break;
						case 'awaiting':
							$sql = "
								select
									distinct objectID
								from
									mod_subobject_integer".$statusSuffix.",
									resources,
									resourceStatuses
								where
									objectFieldID = '0'
									and value = id_res
									and status_res=id_rs
									and editions_rs!=0
									$where
								";
						break;
					}
					break;
				default:
					//add previously founded IDs to where clause
					$where = ($IDs) ? ' and objectID in ('.implode(',',$IDs).')':'';
					if (!isset($this->_fieldsDefinitions[$type]) || !is_object($this->_fieldsDefinitions[$type])) {
						//get object fields definition
						$this->_fieldsDefinitions = CMS_poly_object_catalog::getFieldsDefinition($this->_object->getID());
					}
					//get type object for field
					if (isset($this->_fieldsDefinitions[$type])) {
						$objectField = $this->_fieldsDefinitions[$type]->getTypeObject();
						$sql = $objectField->getFieldSearchSQL($type, $value, $operator, $where, $this->_public);
					} else {
						$this->raiseError('Unknown field '.$type.' to filter with value '.print_r($value, true));
					}
					break;
				}
				if ($sql || isset($xapianResults) || isset($fullTextResults)) {
				    if ($sql) {
						//pr($sql);
					   	//$this->raiseError($sql);
					    $q = new CMS_query($sql);
					    $IDs = array();
					    if (!$q->hasError()) {
					        while ($id = $q->getValue('objectID')) {
					            $IDs[$id] = $id;
					        }
					    }
					} elseif (isset($xapianResults)) {
						$IDs = array();
						foreach ($xapianResults as $id) {
							$IDs[$id] = $id;
						}
						//if we only have objectID as orderCondition or if order by relevance is queried, use order provided by Xapian
						if ((isset($this->_orderConditions['objectID']) && $this->_orderConditions['objectID'] && sizeof($this->_orderConditions) <= 1) 
							|| (isset($this->_orderConditions['relevance']) && $this->_orderConditions['relevance'])) {
							if ($this->_orderConditions['relevance'] == 'desc') {
								$this->_orderConditions = array('itemsOrdered' => array('order' => array_reverse($IDs,true)));
							} else {
								$this->_orderConditions = array('itemsOrdered' => array('order' => $IDs));
							}
							if (isset($this->_orderConditions['relevance']) && $this->_orderConditions['relevance']) {
								unset($this->_orderConditions['relevance']);
							}
						}
					} else {
						//if we only have objectID as orderCondition or if order by relevance is queried, use order provided by MySQL Fulltext
						if (isset($this->_orderConditions['relevance']) && $this->_orderConditions['relevance']) {
							if ($this->_orderConditions['relevance'] == 'desc') {
								$this->_orderConditions = array('itemsOrdered' => array('order' => array_reverse($fullTextResults,true)));
							} else {
								$this->_orderConditions = array('itemsOrdered' => array('order' => $fullTextResults));
							}
							unset($this->_orderConditions['relevance']);
						}
					}
					//if no results, no need to continue
				    if (!$IDs) {
				        $IDs = array();
				        $this->_numRows = 0;
				        return $IDs;
				    }
				} else {
				    //if no sql request, then no results (can be used by 'profile'), no need to continue
				    $IDs = array();
				    $this->_numRows = sizeof($IDs);
				    return $IDs;
				}
			}
		}
		$this->_numRows = sizeof($IDs);
		return $IDs;
	}
	
	/**
	 * Get all subobjects values for searched objects results
	 * 
	 * @access private
	 * @return array of subobject ids sorted
	 */
	protected function _getSubObjectsIds() {
		$ids = array();
		$subObjectsFieldsIds = array();
		//load fields objects for object
		$objectFields = CMS_poly_object_catalog::getFieldsDefinition($this->_object->getID());
		//Add all subobjects to search if any
		foreach (array_keys($objectFields) as $fieldID) {
			//if field is a poly object or a multi poly object, add it to search
			if (sensitiveIO::isPositiveInteger($objectFields[$fieldID]->getValue('type')) || io::strpos($objectFields[$fieldID]->getValue('type'),"multi|") !== false) {
				$subObjectsFieldsIds[] = $fieldID;
			}
		}
		if (is_array($subObjectsFieldsIds) && $subObjectsFieldsIds) {
			// Prepare conditions
			$where = "
			where
				objectID in (".implode($this->_sortedResultsIds,',').")
				and objectFieldID in (".implode($subObjectsFieldsIds,',').")";
			$statusSuffix = ($this->_public) ? "_public":"_edited";
			$sql = "select
						distinct value
					from
						mod_subobject_integer".$statusSuffix."
						$where
					";
			
			$q = new CMS_query($sql);
			//pr($sql);
			if (!$q->hasError()) {
				while ($r = $q->getArray()) {
					if ($r['value']) {
						$ids[$r['value']] = $r['value'];
					}
				}
			}
		}
		return $ids;
	}
	
	/**
	 * Sort and limit founded ids by orders and limit clauses
	 * This method limit results to existant objects too
	 * 
	 * @access private
	 * @return array of object ids sorted
	 */
	protected function _sortIds() {
		$statusSuffix = ($this->_public) ? "_public":"_edited";
		$ids = array();
		if ($this->_orderConditions) {
			//reverse order conditions (needed to get natural order)
			$orderConditions = array_reverse($this->_orderConditions, true);
			//loop on each order conditions
			foreach ($orderConditions as $type => $value) {
				$sql = '';
				if (!isset($value['direction']) || !$value['direction']) {
					$value['direction'] = 'asc';
				}
				if (!isset($value['operator']) || !$value['operator']) {
					$value['operator'] = '';
				}
				$direction = $value['direction'];
				$operator = $value['operator'];
				//add previously founded ids to where clause
				$where = (is_array($this->_resultsIds) && $this->_resultsIds) ? ' and objectID in ('.implode(',',$this->_resultsIds).')':'';
				switch($type) {
					case "publication date after": // Date start
					case "publication date before": // Date start
					case "publication date start": // Date start
						$sql = "
								select
									distinct objectID
								from
									mod_subobject_integer".$statusSuffix.",
									resources,
									resourceStatuses
								where
									objectFieldID = '0'
									and value = id_res
									and status_res=id_rs
									$where
								order by publicationDateStart_rs ".$direction;
						break;
					case "publication date end": // Date end
						$sql = "
								select
									distinct objectID
								from
									mod_subobject_integer".$statusSuffix.",
									resources,
									resourceStatuses
								where
									objectFieldID = '0'
									and value = id_res
									and status_res=id_rs
									$where
								order by publicationDateEnd_rs ".$direction;
						break;
					case 'objectID':
						$ids = $ids ? $ids : $this->_resultsIds;
						ksort($ids, SORT_NUMERIC);
						$ids = ($direction == 'asc') ? $ids : array_reverse($ids, true);
					break;
					case 'itemsOrdered':
						$ids = ($direction == 'asc') ? $this->_orderConditions['itemsOrdered']['order'] : array_reverse($this->_orderConditions['itemsOrdered']['order'], true);
					break;
					case 'random':
						$tmpIds = $ids ? $ids : $this->_resultsIds;
						shuffle($tmpIds);
						$ids = array();
						foreach ($tmpIds as $id) {
							$ids[$id] = $id;
						}
					break;
					case "relevance":
						//this order condition is replaced by an itemsOrdered order at the end of _getIds method
					break;
					default:
						if(sensitiveIO::isPositiveInteger($type)) {
							if (!is_object($this->_fieldsDefinitions[$type])) {
								//get object fields definition
								$this->_fieldsDefinitions = CMS_poly_object_catalog::getFieldsDefinition($this->_object->getID());
							}
							//get type object for field
							$objectField = $this->_fieldsDefinitions[$type]->getTypeObject();
							$operator = isset($operator) ? $operator : '';
							$sql = $objectField->getFieldOrderSQL($type, $direction, $operator, $where, $this->_public);
						}
					break;
				}
				if ($sql) {
					if (isset($ids) && $ids) {
						$sql .= " , field(objectID, ".implode(',',array_reverse($ids)).") desc ";
					}
					$q = new CMS_query($sql);
					$orderedIds = array();
					if (!$q->hasError()) {
						//save ordered ids
						while ($id = $q->getValue('objectID')) {
							$orderedIds[$id] = $id;
						}
					}
					$ids = $orderedIds;
				}
			}
		} else {
			$ids = $this->_resultsIds;
		}
		
		//check for results existance in objects datas tables
		if ($ids) {
			$where = ' objectID in ('.implode(',',$ids).')';
			$sql = "
				select
					distinct objectID
				from
					mod_subobject_text".$statusSuffix."
				where
					$where
				union distinct
				select
					distinct objectID
				from
					mod_subobject_integer".$statusSuffix."
				where
					$where
				union distinct
				select
					distinct objectID
				from
					mod_subobject_string".$statusSuffix."
				where
					$where
				union distinct
				select
					distinct objectID
				from
					mod_subobject_date".$statusSuffix."
				where
					$where
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows() != count($ids)) {
				$foundedIds = $q->getAll(PDO::FETCH_COLUMN, 0);
				if ($foundedIds) {
					$ids = array_intersect($ids , $foundedIds);
					//update count of results
					$this->_numRows = sizeof($ids);
				} else {
					$ids = array();
					$this->_numRows = 0;
				}
			}
		}
		
		//Limit results if needed
		if ($ids && $this->_numRows > 0 && $this->_itemsPerPage > 0) {
			$ids = array_slice($ids, ($this->_page * $this->_itemsPerPage), $this->_itemsPerPage, true);
		}
		return $ids;
	}
	
	/**
	 * Get all searched objects (and subobjects) values
	 * 
	 * @access private
	 * @return array of values array(objectID => array(objectFieldID => array(objectSubfieldId => array(sql datas))))
	 */
	protected function _getObjectValues() {
		$datas = array();
		// Prepare conditions
		if (is_array($this->_sortedResultsIds) && $this->_sortedResultsIds) {
			$where = " where objectID in (".implode($this->_sortedResultsIds,',');
			if (is_array($this->_resultsSubObjectsIds) && $this->_resultsSubObjectsIds) {
				$where .= ",".implode($this->_resultsSubObjectsIds,',');
			}
			$where .= ")";
		}
		$statusSuffix = ($this->_public) ? "_public":"_edited";
		$sql = "select
					*
				from
					mod_subobject_text".$statusSuffix."
					$where
				
				union distinct
				
				select
					*
				from
					mod_subobject_integer".$statusSuffix."
					$where
				
				union distinct
				
				select
					*
				from
					mod_subobject_string".$statusSuffix."
					$where
				
				union distinct
				
				select
					*
				from
					mod_subobject_date".$statusSuffix."
					$where
				";
		$q = new CMS_query($sql);
		//pr($sql);
		if (!$q->hasError()) {
			//create multidimentionnal array of results values
			while ($arr = $q->getArray()) {
				$datas[$arr["objectID"]][$arr["objectFieldID"]][$arr["objectSubFieldID"]] = $arr;
			}
		}
		return $datas;
	}
	
	/**
	 * Proceed to search and returns the array of results, null if none 
	 * founded. All search options had been set yet.
	 * 
	 * @access public
	 * @param $return, the returned values in : 
	 *	self::POLYMOD_SEARCH_RETURN_IDS for array of ids sorted
	 *	self::POLYMOD_SEARCH_RETURN_DATAS for db datas
	 *	self::POLYMOD_SEARCH_RETURN_OBJECTS for objetcs (default)
	 *	self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT for light objects (without subobjects datas)
	 *  self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT_EDITED for edited light objects. /!\ This method must not be used for objects which should be saved (used by getListOfNamesForObject only) /!\
	 *	self::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS use this method to get individual results with method getNextResult
	 * @param boolean $loadSubObjects : all the founded objects can load theirs own sub objects (default false)
	 * 	/!\ CAUTION : Pass this option to true can generate a lot of subqueries /!\
	 * @return mixed array(CMS_poly_object) or boolean (for POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS)
	 */
	function search($return = self::POLYMOD_SEARCH_RETURN_OBJECTS, $loadSubObjects = false) {
		global $cms_user;
		if ($return == self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT && !$this->_public) {
			$this->raiseError('Return type can\'t be self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT in a non-public search.');
			$return = self::POLYMOD_SEARCH_RETURN_OBJECTS;
		}
		//this is a hack to allow light search in edited userspace. /!\ Objects must not be saved after /!\
		if ($return == self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT_EDITED) {
			$return = self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT;
		}
		$items = array();
		if ($return == self::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS) {
			//reset result stack if needed
			reset($this->_sortedResultsIds);
		}
		$this->_searchMode = $return;
		// Check module rights : to get any results, user should has at least CLEARANCE_MODULE_VIEW
		if((!$this->_public || ($this->_public && APPLICATION_ENFORCES_ACCESS_CONTROL)) && (!is_object($cms_user) || !$cms_user->hasModuleClearance($this->_object->getValue('module'),CLEARANCE_MODULE_VIEW))){
			if (!is_object($cms_user)) {
				$this->_raiseError(__CLASS__.' : '.__FUNCTION__.' : cms_user not loaded when trying to get objects subject to rights ...');
			}
			return ($return == self::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS) ? false : $items;
		}
		//get all ids and numrows
		$this->_resultsIds = $this->_getIds();
		//if results
		if (is_array($this->_resultsIds) && $this->_resultsIds) {
			//sort and limit ids to order and limit clause and to existant objects
			$this->_sortedResultsIds = $this->_sortIds();
			//if return anything than ids
			if ($return != self::POLYMOD_SEARCH_RETURN_IDS && is_array($this->_sortedResultsIds) && $this->_sortedResultsIds) {
				//get subobjects ids
				if ($return != self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT) {
					$this->_resultsSubObjectsIds = $this->_getSubObjectsIds();
				}
				//then load all values for objects and subobjects (if needed)
				$this->_values = $this->_getObjectValues();
			}
		} else {
			return ($return == self::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS) ? true : array();
		}
		//return datas
		if ($return == self::POLYMOD_SEARCH_RETURN_DATAS) {
			return $this->_values;
		}
		//return individuals objects with method getNextResult
		if ($return == self::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS) {
			return true;
		}
		//return ids
		if ($return == self::POLYMOD_SEARCH_RETURN_IDS) {
			return $this->_sortedResultsIds;
		}
		//return objects
		$count = 0;
		if ($this->_values && $this->_sortedResultsIds) {
			//1- create objects values : all subObjects founded for searched objects
			$subObjectValues = array();
			foreach ($this->_resultsSubObjectsIds as $subObjectId) {
				$subObjectValues[$subObjectId] = &$this->_values[$subObjectId];
			}
			//load sub objects values
			$loadSubObjectsValues = ($return != self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT);
			//create objects
			foreach ($this->_sortedResultsIds as $aResultID) {
				//2- add object values to objects values
				$objectValues = $subObjectValues;
				$objectValues[$aResultID] = &$this->_values[$aResultID];
				//instanciate object
				$obj = new CMS_poly_object($this->_object->getID(), $aResultID, $objectValues, $this->_public, $loadSubObjects, $loadSubObjectsValues);
				if (!$obj->hasError()) {
					$items[$aResultID] = $obj;
					$count++;
				}
			}
		}
		return $items;
	}
	
	/**
	 * Returns the next result in the current search results stack, false if no results left
	 * Search must be already done using search method and mode self::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS.
	 * 
	 * @access public
	 * @param $return, the returned values in : 
	 *	self::POLYMOD_SEARCH_RETURN_OBJECTS for objetcs (default)
	 *	self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT for light objects (without subobjects datas)
	 *  self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT_EDITED for edited light objects. /!\ This method must not be used for objects which should be saved (used by getListOfNamesForObject only) /!\
	 * @param boolean $loadSubObjects : all the founded objects can load theirs own sub objects (default false)
	 * 	/!\ CAUTION : Pass this option to true can generate a lot of subqueries /!\
	 * @return array(CMS_poly_object)
	 */
	function getNextResult($return = self::POLYMOD_SEARCH_RETURN_OBJECTS, $loadSubObjects = false) {
		if ($return == self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT && !$this->_public) {
			$this->raiseError('Return type can\'t be self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT in a non-public search.');
			$return = self::POLYMOD_SEARCH_RETURN_OBJECTS;
		}
		//this is a hack to allow light search in edited userspace. /!\ Objects must not be saved after /!\
		if ($return == self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT_EDITED) {
			$return = self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT;
		}
		if ($this->_searchMode !== self::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS) {
			$this->raiseError('You cannot use this method if search was not launched with mode self::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS');
			return false;
		}
		if ($return == self::POLYMOD_SEARCH_RETURN_IDS) {
			$currentResult = each($this->_sortedResultsIds);
			if ($currentResult !== false) {
				$this->_objectsCount++;
				return $currentResult['value'];
			}
			return false;
		}
		//return objects
		if ($this->_values && $this->_sortedResultsIds) {
			//1- create objects values : all subObjects founded for searched objects
			if ($this->_objectsValues === false) {
				$this->_objectsValues = array();
				foreach ($this->_resultsSubObjectsIds as $subObjectId) {
					$this->_objectsValues[$subObjectId] = &$this->_values[$subObjectId];
				}
			}
			//load sub objects values
			$loadSubObjectsValues = ($return != self::POLYMOD_SEARCH_RETURN_OBJECTSLIGHT);
			//create object
			$currentResult = each($this->_sortedResultsIds);
			if ($currentResult !== false) {
				//2- add object values to objects values
				if (!isset($this->_objectsValues[$currentResult['value']])) {
					$this->_objectsValues[$currentResult['value']] = &$this->_values[$currentResult['value']];
				}
				//instanciate and return object
				$this->_objectsCount++;
				return new CMS_poly_object($this->_object->getID(), $currentResult['value'], $this->_objectsValues, $this->_public, $loadSubObjects, $loadSubObjectsValues);
			}
		}
		return false;
	}
	
	/**
	 * Does last result returned by method getNextResult is the last of the stack
	 * @return boolean
	 * @access public
	 */
	function isLastResult() {
		return $this->_objectsCount == sizeof($this->_sortedResultsIds);
	}
	
	/**
	 * Reset the results stack returned by the method getNextResult
	 * @return void
	 * @access public
	 */
	function resetResultStack() {
		reset($this->_sortedResultsIds);
	}
	
	/**
	 * Search items by xml definition. Return XML
	 * 
	 * @access public
	 * @param string $searchConditions XML definition to search with
	 * @return string XML definition of results IDs
	 */
	function soapSearch($searchConditions = '') {
	    $xml = '';
	    
	    if($searchConditions){
	        $myXML = new CMS_DOMDocument();
            $myXML->loadXML($searchConditions, 0, false);
            
            // Conditions tag must be the root tag
            $conditionsTags = $myXML->getElementsByTagName('conditions');
            if(count($conditionsTags) == 1){
                $conditionTags = $myXML->getElementsByTagName('condition');
                foreach($conditionTags as $conditionTag){
                    $type = $conditionTag->getAttribute('type');
                    $operator = $conditionTag->getAttribute('operator');
                    $value = $conditionTag->nodeValue;
                    $this->addWhereCondition($type, $value, $operator);
                }
            }
        }
        
        $items = $this->search(CMS_object_search::POLYMOD_SEARCH_RETURN_IDS);
        
        if($items){
            $xml .= '<results count="'.count($items).'">'."\n";
            foreach($items as $itemID){
                $xml .= '<result>'.$itemID.'</result>'."\n";
            }
            $xml .= '</results>';
        }
	    
	    return $xml;
	}
}
?>
