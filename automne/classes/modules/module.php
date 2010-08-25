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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &    |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: module.php,v 1.9 2010/03/08 16:43:30 sebastien Exp $

/**
  * Class CMS_module
  *
  * represent a module.
  * Abstract class.
  *
  * @package Automne
  * @subpackage modules
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_module extends CMS_grandFather
{
	/**
	  * Standard Messages
	  */
	const MESSAGE_PAGE_ADMIN_CATEGORIES = 1206;
	const MESSAGE_PAGE_CHOOSE = 1132;
	const MESSAGE_PAGE_CATEGORIES = 636;
	const MESSAGE_PAGE_MANAGE_OBJECTS = 635;
	const MESSAGE_PAGE_CATEGORIES_USED = 637;
	
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_id;

	/**
	  * label message ID
	  * @var integer
	  * @access private
	  */
	protected $_labelMessageID;

	/**
	  * codename
	  * @var string
	  * @access private
	  */
	protected $_codename;

	/**
	  * Administration frontend
	  * @var string
	  * @access private
	  */
	protected $_administrationFrontend;

	/**
	  * Does the odule have parameters ?
	  * @var boolean
	  * @access private
	  */
	protected $_hasParameters = false;

	/**
	  * is this a poly module
	  * @var boolean
	  * @access private
	  */
	protected $_isPolymod = false;

	/**
	  * Constructor.
	  * initializes the module if the codename is given
	  *
	  * @param string $codename The module codename
	  * @return void
	  * @access public
	  */
	function CMS_module($datas = '') {
		static $modules;
		if (is_string($datas)) {
			$codename = $datas;
			if ($codename) {
				if (isset($modules[$codename])) {
					$this->_id = $modules[$codename]->_id;
					$this->_labelMessageID = $modules[$codename]->_labelMessageID;
					$this->_codename = $modules[$codename]->_codename;
					$this->_administrationFrontend = $modules[$codename]->_administrationFrontend;
					$this->_hasParameters = $modules[$codename]->_hasParameters;
					$this->_isPolymod = $modules[$codename]->_isPolymod;
				} else {
					$sql = "
						select
							*
						from
							modules
						where
							codename_mod='".SensitiveIO::sanitizeSQLString($codename)."'
					";
					$q = new CMS_query($sql);
					if ($q->getNumRows()) {
						$data = $q->getArray();
						$this->_id = $data["id_mod"];
						$this->_labelMessageID = $data["label_mod"];
						$this->_codename = $data["codename_mod"];
						$this->_administrationFrontend = $data["administrationFrontend_mod"];
						$this->_hasParameters = $data["hasParameters_mod"];
						$this->_isPolymod = $data["isPolymod_mod"];
						$modules[$codename] = $this;
					} else {
						$this->raiseError("Unknown codename : ".SensitiveIO::sanitizeAsciiString($codename));
					}
				}
			}
		} else if (is_array($datas)) {
			$codename = $datas["codename_mod"];
			$this->_id = $datas["id_mod"];
			$this->_labelMessageID = $datas["label_mod"];
			$this->_codename = $datas["codename_mod"];
			$this->_administrationFrontend = $datas["administrationFrontend_mod"];
			$this->_hasParameters = $datas["hasParameters_mod"];
			$this->_isPolymod = $datas["isPolymod_mod"];
			$modules[$codename] = $this;
		} else {
			parent::raiseError("Unknown datas type : ".gettype($datas));
			return false;
		}
	}
	
	/**
	  * Gets the DB ID of the instance.
	  *
	  * @return integer the DB id
	  * @access public
	  */
	function getID()
	{
		return $this->_id;
	}
	
	/**
	  * Gets the label.
	  *
	  * @param CMS_language $language The language of the label
	  * @return string The label
	  * @access public
	  */
	function getLabel($language)
	{
		if (!is_object($language)) {
			$this->raiseError("Missing language to get module label ... ");
			return '';
		}
		return $language->getMessage($this->_labelMessageID, false, $this->_codename);
	}
	
	/**
	  * Gets the label id.
	  *
	  * @return integer The label id
	  * @access public
	  */
	function getLabelID()
	{
		return $this->_labelMessageID;
	}
	
	/**
	  * Sets the label.
	  *
	  * @param string $label The new label to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setLabel($labelMessageID)
	{
		if (SensitiveIO::isPositiveInteger($labelMessageID)) {
			$this->_labelMessageID = $labelMessageID;
			return true;
		} else {
			$this->raiseError("Label must be a positive integer");
			return false;
		}
	}
	
	/**
	  * Does the module have parameters ?
	  *
	  * @return boolean
	  * @access public
	  */
	function hasParameters()
	{
		return $this->_hasParameters;
	}
	
	/**
	  * Is given module is a poly module ?
	  *
	  * @param string $codename the codename of the module to check
	  * @return boolean true if yes, false otherwise
	  * @access public
	  */
	function isPolymod() {
		return ($this->_isPolymod) ? true : false;
	}
	
	/**
	  * Sets the polymod status of the module
	  *
	  * @param boolean $isPolymod The polymod status to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setPolymod($isPolymod) {
		$this->_isPolymod = ($isPolymod) ? true : false;
		return true;
	}
	
	/**
	  * Get the module parameters. Search for a file name "CODENAME_rc.xml" in PATH_MODULES_FS
	  *
	  * @param string $onlyOne The name of a single parameter wanted
	  * @return array(string=>string) The parameters from the file, or false if no file found
	  * @access public
	  */
	function getParameters($onlyOne = false, $withType=false, $reset = false)
	{
		if ($this->_hasParameters) {
			if ($reset) {
				unset($moduleParameters);
			}
			if (!isset($moduleParameters[$this->_codename])) {
				$filename = PATH_MODULES_FS."/".$this->_codename."_rc.xml";
				if (file_exists($filename)) {
					$file = new CMS_DOMDocument();
					$file->loadXML(file_get_contents($filename));
					$paramTags = $file->getElementsByTagName('param');
					$moduleParameters[$this->_codename] = array();
					foreach ($paramTags as $paramTag) {
						$value = (io::strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? utf8_decode(trim($paramTag->nodeValue)) : trim($paramTag->nodeValue);
						if ($withType) {
							$moduleParameters[$this->_codename][$paramTag->getAttribute("name")] = array($value, $paramTag->getAttribute("type"));
						} else {
							$moduleParameters[$this->_codename][$paramTag->getAttribute("name")] = trim($value);
						}
					}
				} else {
					$this->raiseError('Malformed definition file : '.PATH_MODULES_FS.'/'.$this->_codename.'_rc.xml');
					$moduleParameters[$this->_codename] = array();
				}
			}
			//return all or only one of the parameters
			if ($onlyOne && isset($moduleParameters[$this->_codename][$onlyOne])) {
				return $moduleParameters[$this->_codename][$onlyOne];
			} elseif ($onlyOne) {
				return '';
			} else {
				return $moduleParameters[$this->_codename];
			}
		} else {
			return false;
		}
	}
	
	/**
	  * Set and write to disc the module parameters file
	  *
	  * @param array(string=>string) $parameters The parameters array indexed by label
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setAndWriteParameters($parameters)
	{
		if (!is_array($parameters)) {
			$this->raiseError("Parameters not an array");
			return false;
		}
		
		$filename = PATH_MODULES_FS."/".$this->_codename."_rc.xml";
		if (file_exists($filename)) {
			$fh = @fopen($filename, "wb");
			if (is_resource($fh)) {
				$cdata = "<cms-module-parameters>\n";
				foreach ($parameters as $label => $value) {
					//don't put the PHPSESSID var, which can happen under IE
					if ($label != session_name()) {
						if (is_array($value)) {
							$cdata .= "\t".'<param name="'.$label.'" type="'.$value[1].'">'.$value[0].'</param>'."\n";
						} else {
							$cdata .= "\t".'<param name="'.$label.'">'.$value.'</param>'."\n";
						}
					}
				}
				$cdata .= "</cms-module-parameters>";
				
				fwrite($fh, $cdata);
				fclose($fh);
				@chmod ($filename, octdec(FILES_CHMOD));
				return true;
			}
		}
		$this->raiseError("File not found or writable");
		return false;
	}
	
	/**
	  * Gets the codename.
	  *
	  * @return string The codename
	  * @access public
	  */
	function getCodename()
	{
		return $this->_codename;
	}
	
	/**
	  * Sets the codename.
	  *
	  * @param string $codename The new codename to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setCodename($codename)
	{
		if ($codename) {
			$this->_codename = $codename;
			return true;
		} else {
			$this->raiseError("Can't set a null codename");
			return false;
		}
	}
	
	/**
	  * Gets the administration frontend path.
	  *
	  * @param integer $relativeTo Can be to webroot or filesystem. See constants.
	  * @return string The administration frontend path
	  * @access public
	  */
	function getAdminFrontendPath($relativeTo)
	{
		switch ($relativeTo) {
		case PATH_RELATIVETO_FILESYSTEM:
			$base_path = PATH_ADMIN_MODULES_FS;
			break;
		case PATH_RELATIVETO_WEBROOT:
			$base_path = PATH_ADMIN_MODULES_WR;
			break;
		default:
			$this->raiseError("RelativeTo unknown");
			return false;
			break;
		}
		if ($this->_isPolymod) {
			return $base_path."/polymod/".$this->_administrationFrontend."?polymod=".$this->_codename;
		} else {
			return $base_path."/".$this->_codename."/".$this->_administrationFrontend;
		}
	}
	
	/**
	  * Does the current module has an admin backend
	  *
	  * @return boolean
	  * @access public
	  */
	function hasAdmin()
	{
		if (!$this->_administrationFrontend || $this->_administrationFrontend == '' || $this->_administrationFrontend == 'false' || $this->_administrationFrontend == false) {
			return false;
		}
		return true;
		
	}
	
	/**
	  * Sets the administration frontend filename. It must exists of course.
	  *
	  * @param string $adminFrontend The new administration frontend filename to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setAdminFrontend($adminFrontend)
	{
		$directory = ($this->_isPolymod) ? 'polymod' : $this->_codename;
		if (file_exists(PATH_ADMIN_MODULES_FS."/".$directory."/".$adminFrontend)) {
			$this->_administrationFrontend = $adminFrontend;
			return true;
		} else {
			$this->raiseError("File doesn't exists : ".$adminFrontend);
			return false;
		}
	}
	
	/**
	  * Gets resource by its internal ID (not the resource table DB ID)
	  *
	  * @param integer $resourceID The DB ID of the resource in the module table(s)
	  * @return CMS_resource The CMS_resource subclassed object
	  * @access public
	  */
	function getResourceByID($resourceID)
	{
		if (!SensitiveIO::isPositiveInteger($resourceID)) {
			$this->raiseError("Resource ID is not a positive integer");
			return false;
		}
	}
	
	/**
	  * Gets a tag representation instance
	  *
	  * @param string $tagName The name of the tag
	  * @param array(string=>string) $tagAttributes The tag attributes
	  * @return object The module tag representation instance
	  * @access public
	  */
	function getTagRepresentation($tagName, $tagAttributes, $args = false)
	{
	}
	
	/**
	  * Gets the module validations
	  *
	  * @param CMS_user $user The user we want the validations for
	  * @return array(CMS_resourceValidation) The resourceValidations objects, false if none found
	  * @access public
	  */
	function getValidations($user)
	{
	}
	
	/**
	  * Process the module validations. Note that the EMails sent to either the transferred validator or the editors were sent before.
	  *
	  * @param CMS_resourceValidation $resourceValidation The resource validation to process
	  * @param integer $result The result of the validation process. See VALIDATION_OPTION constants
	  * @param boolean $lastValidation Is this the last validation done in a load of multiple validations (or the only one) ?
	  * @return boolean true on success, false on failure to process
	  * @access public
	  */
	function processValidation($resourceValidation, $result, $lastValidation = true)
	{
		if (!is_a($resourceValidation, "CMS_resourceValidation")) {
			$this->raiseError("ResourceValidation is not a valid CMS_resourceValidation object");
			return false;
		}
		if (!SensitiveIO::isInSet($result, CMS_resourceValidation::getAllValidationOptions())) {
			$this->raiseError("Result is not a valid validation option");
			return false;
		}
		
		//Tell the resource of the changes
		$resource = $resourceValidation->getResource();
		$editions = $resourceValidation->getEditions();
		
		//add a call to all modules for validation specific treatment
		$modulesCodes = new CMS_modulesCodes();
		//add a call to modules before validation
		$modulesCodes->getModulesCodes(MODULE_TREATMENT_BEFORE_VALIDATION_TREATMENT, '', $resource, array('result' => $result, 'lastvalidation' => $lastValidation, 'module' => $this->_codename));
		
		switch ($result) {
		case VALIDATION_OPTION_REFUSE:
			//validation was refused, adjust the array of validations refused
			$all_editions = CMS_resourceStatus::getAllEditions();
			foreach ($all_editions as $aEdition) {
				if ($aEdition & $editions) {
					$resource->addValidationRefused($aEdition);
				}
			}
			break;
		case VALIDATION_OPTION_ACCEPT:
			//if one of the edition was the location, only treat this one. Move the data.
			if ($editions & RESOURCE_EDITION_LOCATION) {
				if ($resource->getLocation() == RESOURCE_LOCATION_USERSPACE) {
					//pulling resource out of USERSPACE
					switch ($resource->getProposedLocation()) {
					case RESOURCE_LOCATION_ARCHIVED:
						$locationTo = RESOURCE_DATA_LOCATION_ARCHIVED;
						break;
					case RESOURCE_LOCATION_DELETED:
						$locationTo = RESOURCE_DATA_LOCATION_DELETED;
						break;
					}
					//first, move edited
					$this->_changeDataLocation($resource, RESOURCE_DATA_LOCATION_EDITED, $locationTo);
					//then delete public
					$this->_changeDataLocation($resource, RESOURCE_DATA_LOCATION_PUBLIC, RESOURCE_DATA_LOCATION_DEVNULL);
				} else {
					if ($resource->getProposedLocation() == RESOURCE_LOCATION_USERSPACE) {
						//Pushing resource to USERSPACE
						switch ($resource->getLocation()) {
						case RESOURCE_LOCATION_ARCHIVED:
							$locationFrom = RESOURCE_DATA_LOCATION_ARCHIVED;
							break;
						case RESOURCE_LOCATION_DELETED:
							$locationFrom = RESOURCE_DATA_LOCATION_DELETED;
							break;
						}
						//if resource was published, copy data to public table
						if ($resource->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED) {
							$this->_changeDataLocation($resource, $locationFrom, RESOURCE_DATA_LOCATION_PUBLIC, true);
						}
						//move data from its location to edited 
						$this->_changeDataLocation($resource, $locationFrom, RESOURCE_DATA_LOCATION_EDITED);
					} else {
						//the move entirely takes place outside of USERSPACE (archived to deleted hopefully)
						switch ($resource->getLocation()) {
						case RESOURCE_LOCATION_ARCHIVED:
							$locationFrom = RESOURCE_DATA_LOCATION_ARCHIVED;
							break;
						case RESOURCE_LOCATION_DELETED:
							$locationFrom = RESOURCE_DATA_LOCATION_DELETED;
							break;
						}
						switch ($resource->getProposedLocation()) {
						case RESOURCE_LOCATION_ARCHIVED:
							$locationTo = RESOURCE_DATA_LOCATION_ARCHIVED;
							break;
						case RESOURCE_LOCATION_DELETED:
							$locationTo = RESOURCE_DATA_LOCATION_DELETED;
							break;
						}
						$this->_changeDataLocation($resource, $locationFrom, $locationTo);
					}
				}

				$resource->validateProposedLocation();
			} else {
				$all_editions = CMS_resourceStatus::getAllEditions();
				$this->_changeDataLocation($resource, RESOURCE_DATA_LOCATION_EDITED, RESOURCE_DATA_LOCATION_PUBLIC, true);
				
				foreach ($all_editions as $aEdition) {
					if ($aEdition & $editions) {
						$resource->validateEdition($aEdition);
					}
				}
			}
			break;
		}
		$resource->writeToPersistence();
		//add a call to modules after validation
		$modulesCodes->getModulesCodes(MODULE_TREATMENT_AFTER_VALIDATION_TREATMENT, '', $resource, array('result' => $result, 'lastvalidation' => $lastValidation, 'module' => $this->_codename));
		return true;
	}
	
	/**
	  * Process the daily routine, which typically put out of userspace resources which have a past publication date
	  *
	  * @return void
	  * @access public
	  */
	function processDailyRoutine()
	{
	}
	
	/**
	  * Changes The page data (in the DB) from one location to another.
	  *
	  * @param CMS_page $resource The resource concerned by the data location change
	  * @param string $locationFrom The starting location among the available RESOURCE_DATA_LOCATION
	  * @param string $locationTo The ending location among the available RESOURCE_DATA_LOCATION
	  * @param boolean $copyOnly If true, data is not deleted from the original location
	  * @return void
	  * @access private
	  */
	protected function _changeDataLocation($resource, $locationFrom, $locationTo, $copyOnly = false)
	{
		if (!is_a($resource, "CMS_resource")) {
			$this->raiseError("Resource is not a CMS_resource");
			return false;
		}
		if (!SensitiveIO::isInSet($locationFrom, CMS_resource::getAllDataLocations())
			|| !SensitiveIO::isInSet($locationTo, CMS_resource::getAllDataLocations())) {
			$this->raiseError("Locations are not in the set");
			return false;
		}
		
		return true;
	}
	
	/**
	  * Get array of categories this module can use to archive its datas
	  * 
	  * @access public
	  * @param array $attrs, array of attributes to determine which level of categoryies wanted, etc.
	  *        format : array(language => CMS_language, lebvel => integer, root => integer, attrs => array())
	  * @return array(CMS_moduleCategory)
	  * @static
	  */
	function getModuleCategories($attrs)
	{
		if (!$attrs["module"] && $this->_codename) {
			$attrs["module"] = $this->_codename;
		}
		if (!$attrs["module"]) {
			CMS_grandFather::raiseError("No codename defined to get its categories");
			return false;
		}
		if (APPLICATION_ENFORCES_ACCESS_CONTROL != false
				&& !is_a($attrs["cms_user"], "CMS_profile")) {
			CMS_grandFather::raiseError("Not valid CMS_profile given as enforced access control is active");
			return false;
		}
		if (is_a($attrs["cms_user"], "CMS_profile")
				&& $attrs["cms_user"]->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			// If current user is an adminsitrator, let's show all categories anytime
			unset($attrs["cms_user"]);
		}
		if (is_array($attrs) && $attrs) {
			$items = CMS_moduleCategories_catalog::getAll($attrs);
		}
		return $items;
	}
	
	/**
	  * Get module categories usage
	  *
	  * @return boolean
	  * @access public
	  */
	function useCategories() {
		$sql = "
			select
				1
			from
				modulesCategories
			where
				module_mca = '".$this->_codename."'
				and root_mca != '".CMS_moduleCategory::LINEAGE_PARK_POSITION."'
		";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? true : false;
	}
	
	/**
	  * Totally destroys the module from database, and launch the file which is charged to destroy all the module files.
	  *
	  * @return void
	  * @access public
	  */
	function destroy()
	{
		if ($this->_id) {
			//delete from database
			$sql = "
				delete
				from
					modules
				where
					id_mod='".$this->_id."'
			";
			$q = new CMS_query($sql);
		}
	}
	
	/**
	  * Writes the module into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		$sql_fields = "
			label_mod='".SensitiveIO::sanitizeSQLString($this->_labelMessageID)."',
			codename_mod='".SensitiveIO::sanitizeSQLString($this->_codename)."',
			administrationFrontend_mod='".SensitiveIO::sanitizeSQLString($this->_administrationFrontend)."',
			hasParameters_mod='".SensitiveIO::sanitizeSQLString($this->_hasParameters)."',
			isPolymod_mod='".SensitiveIO::sanitizeSQLString($this->_isPolymod)."'
		";
		if ($this->id) {
			$sql = "
				update
					modules
				set
					".$sql_fields."
				where
					id_mod='".$this->_id."'
			";
		} else {
			$sql = "
				insert into
					modules
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_id) {
			$this->_id = $q->getLastInsertedID();
		}
		return true;
	}
	
	/**
	  * Get the tags to be treated by this module for the specified treatment mode, visualization mode and object.
	  * @param integer $treatmentMode The current treatment mode (see constants on top of CMS_modulesTags class for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @return array of tags to be treated.
	  * @access public
	  */
	function getWantedTags($treatmentMode, $visualizationMode)
	{
		$return = array();
		switch ($treatmentMode) {
			case MODULE_TREATMENT_CLIENTSPACE_TAGS :
				$return = array (
					"atm-clientspace" => array("selfClosed" => true, "parameters" => array("module" => $this->_codename)),
				);
			break;
			case MODULE_TREATMENT_BLOCK_TAGS :
				$return = array (
					"block" => array("selfClosed" => false, "parameters" => array("module"	=> $this->_codename)),
				);
			break;
			case MODULE_TREATMENT_PAGEHEADER_TAGS :
				$return["atm-css-tags"] = array("selfClosed" => true, "parameters" => array());
				$return["atm-js-tags"] = array("selfClosed" => true, "parameters" => array());
				$return["atm-meta-tags"] = array("selfClosed" => true, "parameters" => array());
			break;
		}
		return $return;
	}
	
	/** 
	  * Treat given content tag by this module for the specified treatment mode, visualization mode and object.
	  *
	  * @param string $tag The CMS_XMLTag.
	  * @param string $tagContent previous tag content.
	  * @param integer $treatmentMode The current treatment mode (see constants on top of CMS_modulesTags class for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  * @return string the tag content treated.
	  * @access public
	  */
	function treatWantedTag(&$tag, $tagContent, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters)
	{
		switch ($treatmentMode) {
			case MODULE_TREATMENT_CLIENTSPACE_TAGS:
				if (!is_a($treatedObject,"CMS_pageTemplate")) {
					$this->raiseError('$treatedObject must be a CMS_pageTemplate object');
					return false;
				}
				if (!is_a($treatmentParameters["page"],"CMS_page")) {
					$this->raiseError('$treatmentParameters["page"] must be a CMS_page object');
					return false;
				}
				if (!is_a($treatmentParameters["language"],"CMS_language")) {
					$this->raiseError('$treatmentParameters["language"] must be a CMS_language object');
					return false;
				}
				$args = array("template" => $treatedObject->getID());
				if ($visualizationMode == PAGE_VISUALMODE_CLIENTSPACES_FORM
					|| $visualizationMode == PAGE_VISUALMODE_HTML_EDITION
					|| $visualizationMode == PAGE_VISUALMODE_FORM) {
					$args["editedMode"] = true;
				}
				$cs = $tag->getRepresentationInstance($args);
				if (is_object($cs)) {
					$html = $cs->getData($treatmentParameters["language"], $treatmentParameters["page"], $visualizationMode, false);
				} else {
					//call generic module clientspace content
					$cs = new CMS_moduleClientspace($tag->getAttributes());
					$html = $cs->getClientspaceData($this->_codename, $treatmentParameters["language"], $treatmentParameters["page"], $visualizationMode);
				}
				if ($visualizationMode != PAGE_VISUALMODE_PRINT) {
					//save in global var the page ID who need this module so we can add the header code later.
					CMS_module::moduleUsage($treatmentParameters["page"]->getID(), $this->_codename, array('block' => true));
				}
				return $html;
			break;
			case MODULE_TREATMENT_BLOCK_TAGS:
				if (!is_a($treatedObject,"CMS_row")) {
					$this->raiseError('$treatedObject must be a CMS_row object');
					return false;
				}
				if (!is_a($treatmentParameters["page"],"CMS_page")) {
					$this->raiseError('$treatmentParameters["page"] must be a CMS_page object');
					return false;
				}
				if (!is_a($treatmentParameters["language"],"CMS_language")) {
					$this->raiseError('$treatmentParameters["language"] must be a CMS_language object');
					return false;
				}
				if (!is_a($treatmentParameters["clientSpace"],"CMS_moduleClientspace")) {
					$this->raiseError('$treatmentParameters["clientSpace"] must be a CMS_moduleClientspace object');
					return false;
				}
				$attributes = $tag->getAttributes();
				//create the block data
				$block = $tag->getRepresentationInstance();
				//if block exists, use it
				if ($block) {
					$return = $block->getData($treatmentParameters["language"], $treatmentParameters["page"], $treatmentParameters["clientSpace"], $treatedObject, $visualizationMode);
					if ($return) {
						//save in global var the page ID who need this module so we can add the header code later.
						CMS_module::moduleUsage($treatmentParameters["page"]->getID(), $this->_codename, array('block' => true));
					}
					return $return;
				} else {
					//else call module clientspace content
					$cs = new CMS_moduleClientspace($tag->getAttributes());
					$return = $cs->getClientspaceData($this->_codename, new CMS_date(), $treatmentParameters["page"], $visualizationMode);
					if ($visualizationMode != PAGE_VISUALMODE_PRINT && $return) {
						//save in global var the page ID who need this module so we can add the header code later.
						CMS_module::moduleUsage($treatmentParameters["page"]->getID(), $this->_codename, array('block' => true));
					}
					return $return;
				}
			break;
			case MODULE_TREATMENT_PAGEHEADER_TAGS :
				switch ($tag->getName()) {
					case "atm-js-tags":
					case "atm-css-tags":
						$usage = CMS_module::moduleUsage($treatedObject->getID(), $this->_codename);
						$return = ''; //overwrite previous modules return to append files of this module
						//only if current page use a block of this module
						if (isset($usage['block'])) {
							//save in global var the page ID who use this tag
							CMS_module::moduleUsage($treatedObject->getID(), $this->_codename, array($tag->getName() => true));
							//save new modules files
							switch ($tag->getName()) {
								case "atm-js-tags":
									if (!isset($usage['js-files'])) {
										//get old files for this tag already needed by other modules
										$files = CMS_module::moduleUsage($treatedObject->getID(), "atm-js-tags");
										$files = is_array($files) ? $files : array();
										
										//append module js files
										$files = array_merge($files, $this->getJSFiles());
										//save files
										CMS_module::moduleUsage($treatedObject->getID(), $tag->getName(), $files, true);
										//save JS handled
										CMS_module::moduleUsage($treatedObject->getID(), $this->_codename, array('js-files' => true));
									}
								break;
								case "atm-css-tags":
									$media = $tag->getAttribute('media') ? $tag->getAttribute('media') : 'all';
									if (!isset($usage['css-media'][$media])) {
										$return = ''; //overwrite previous modules return to append files of this module
										//get old files for this tag already needed by other modules
										$files = CMS_module::moduleUsage($treatedObject->getID(), "atm-css-tags");
										$files = is_array($files) ? $files : array();
										//append module css files
										$moduleCSSFiles = $this->getCSSFiles();
										foreach ($moduleCSSFiles as $filesMedia => $mediaFiles) {
											if (!isset($files[$filesMedia])) {
												$files[$filesMedia] = array();
											}
											$files[$filesMedia] = array_merge($files[$filesMedia], $moduleCSSFiles[$filesMedia]);
										}
										//save files
										CMS_module::moduleUsage($treatedObject->getID(), "atm-css-tags", $files, true);
										//save media handled
										CMS_module::moduleUsage($treatedObject->getID(), $this->_codename, array('css-media' => array($media => true)));
									}
								break;
							}
							//Create return for all saved modules files
							switch ($tag->getName()) {
								case "atm-js-tags":
									//get old files for this tag already needed by other modules
									$files = CMS_module::moduleUsage($treatedObject->getID(), "atm-js-tags");
									$return .= '<?php echo CMS_view::getJavascript(array(\''.implode('\',\'', $files).'\')); ?>'."\n";
								break;
								case "atm-css-tags":
									$media = $tag->getAttribute('media') ? $tag->getAttribute('media') : 'all';
									//get old files for this tag already needed by other modules
									$files = CMS_module::moduleUsage($treatedObject->getID(), "atm-css-tags");
									if (isset($files[$media])) {
										$return .= '<?php echo CMS_view::getCSS(array(\''.implode('\',\'', $files[$media]).'\'), \''.$media.'\'); ?>'."\n";
									}
								break;
							}
							return $return;
						}
					break;
					case 'atm-meta-tags':
						//if this page use a row of this module then add the css file if exists to the page
						$usage = CMS_module::moduleUsage($treatedObject->getID(), $this->_codename);
						if (isset($usage['block'])) {
							//append module css files
							$moduleCSSFiles = $this->getCSSFiles();
							foreach ($moduleCSSFiles as $media => $mediaFiles) {
								if (!isset($usage['css-media'][$media])) {
									$tagContent .= "\n".
									'	<!-- load the style of '.$this->_codename.' module for media '.$media.' -->'."\n";
									foreach ($moduleCSSFiles[$media] as $cssfile) {
										$tagContent .= '	<link rel="stylesheet" type="text/css" href="'.$cssfile.'" media="'.$media.'" />'."\n";
									}
									//save media handled
									CMS_module::moduleUsage($treatedObject->getID(), $this->_codename, array('css-media' => array($media => true)));
								}
							}
							if (!isset($usage['atm-js-tags'])) {
								$jsFiles = $this->getJSFiles();
								if ($jsFiles) {
									$tagContent .= "\n".'	<!-- load js file of '.$this->_codename.' module -->'."\n";
									foreach ($jsFiles as $jsfile) {
										$tagContent .= '	<script type="text/javascript" src="'.$jsfile.'"></script>'."\n";
									}
								}
								//save JS handled
								CMS_module::moduleUsage($treatedObject->getID(), $this->_codename, array('js-files' => true));
							}
						}
						return $tagContent;
					break;
				}
			break;
		}
		return $tagContent;
	}
	
	/**
	  * Return the module JS files
	  * 
	  * @return array : the module js file in /js/modules/codename
	  * @access public
	  */
	function getJSFiles() {
		$files = array();
		if (@is_dir(PATH_JS_FS.'/modules/'.$this->_codename)) {
			try{
				foreach ( new DirectoryIterator(PATH_JS_FS.'/modules/'.$this->_codename) as $file) {
					if ($file->isFile() && io::substr($file->getFilename(), -3) == ".js") {
						$filename = str_replace(PATH_REALROOT_FS, '', $file->getPathname());
						$files[] = $filename;
					}
				}
			} catch(Exception $e) {}
			sort($files);
		}
		return $files;
	}
	
	/**
	  * Return the module CSS files
	  * 
	  * @return array : the module css file in /css/modules/codename
	  * @access public
	  */
	function getCSSFiles() {
		$files = array();
		$medias = array('all', 'aural', 'braille', 'embossed', 'handheld', 'print', 'projection', 'screen', 'tty', 'tv');
		foreach ($medias as $media) {
			if ($media == 'all') {
				if (file_exists(PATH_CSS_FS.'/modules/'.$this->_codename.'.css')) {
					$files['all'][] = str_replace(PATH_REALROOT_FS, '', PATH_CSS_FS.'/modules/'.$this->_codename.'.css');
				}
			}
			if (file_exists(PATH_CSS_FS.'/modules/'.$this->_codename.'-'.$media.'.css')) {
				$files[$media][] = str_replace(PATH_REALROOT_FS, '', PATH_CSS_FS.'/modules/'.$this->_codename.'-'.$media.'.css');
			}
		}
		return $files;
	}

	/**
	  * Return the module code for the specified treatment mode, visualization mode and object.
	  * 
	  * @param mixed $modulesCode the previous modules codes (usually string)
	  * @param integer $treatmentMode The current treatment mode (see constants on top of this file for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  *
	  * @return string : the module code to add
	  * @access public
	  */
	function getModuleCode($modulesCode, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters)
	{
		//nothing
		return $modulesCode;
	}
	
	/**
	  * If module use CMS_moduleCategory, does it use it
	  *
	  * @param CMS_moduleCategory $category The to check useage by module
	  * @return Boolean true/false
	  * @access public
	  */
	function isCategoryUsed($category)
	{
		//we don't know it here so assume yes to avoid errors
		return true;
	}
	
	/**
	  * Set or get the module useage for a given page id
	  * 
	  * @param integer $pageID page ID to get or set useage
	  * @param string $module module codename to set or get useage (default = polymod for generic polymod useage).
	  * @param boolean $setUseage, if false (get mode : default), return the useage of the module for the given page ID, else (set mode), set the useage of the module for the given page ID
	  * @param boolean $reset: reset all usage for given module and page ID
	  *
	  * @return boolean : for setUseage = false (get mode) : the module useage for given page ID else for setUseage = true (set mode) true on success, false on failure
	  * @access public
	  * @static
	  */
	function moduleUsage($pageID, $module = '', $setUseage = false, $reset = false) {
		static $moduleUseage;
		if(!$module && $this->_codename) {
			$module = $this->_codename;
		} elseif(!$module) {
			$this->raiseError('$module not set');
			return false;
		}
		if ($reset && isset($moduleUseage[$module]["pageUseModule"][$pageID])) {
			unset($moduleUseage[$module]["pageUseModule"][$pageID]);
		}
		if ($setUseage) {
			if (!is_array($setUseage)) $setUseage = array($setUseage);
			if (!isset($moduleUseage[$module]["pageUseModule"][$pageID])) {
				//save page id for given module codename
				$moduleUseage[$module]["pageUseModule"][$pageID] = $setUseage;
			} else {
				//save page id for given module codename
				$moduleUseage[$module]["pageUseModule"][$pageID] = array_merge_recursive($moduleUseage[$module]["pageUseModule"][$pageID], $setUseage);
			}
			return true;
		} else {
			return isset($moduleUseage[$module]["pageUseModule"][$pageID]) ? $moduleUseage[$module]["pageUseModule"][$pageID] : null;
		}
	}
	
	/**
	  * Module script task : default function, return true
	  *
	  * @param array $parameters the task parameters
	  * @return Boolean true/false
	  * @access public
	  */
	function scriptTask($parameters) {
		return true;
	}
	
	/**
	  * Module script info : get infos for a given script parameters
	  *
	  * @param array $parameters the task parameters
	  * @return string : scripts infos
	  * @access public
	  */
	function scriptInfo($parameters) {
		return 'Unknown script for module '.$this->_codename;
	}

	public function asArray()
	{
		if (!$this->_isPolymod) {
			return false;
		}
		$aModule = array(
			'codename'	=> $this->_codename,
			'labels'	=> CMS_language::getMessages(1, $this->_codename),
			'classes'	=> array(),
		);

		$oQuery = new CMS_query('
			SELECT `id_mod`
			FROM `mod_object_definition`
			WHERE `module_mod` = \''.$this->_codename.'\'
		');
		if ($oQuery->getNumRows() > 0) {
			foreach ($oQuery->getAll(PDO::FETCH_ASSOC) as $aRow) {
				$oObjectDefinition = new CMS_poly_object_definition($aRow['id_mod']);
				$aModule['classes'][] = $oObjectDefinition->asArray();
			}
		}

		return $aModule;
	}
}
?>
