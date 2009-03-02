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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &    |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: pagetemplate.php,v 1.4 2009/03/02 11:29:38 sebastien Exp $

/**
  * Class CMS_pageTemplate
  *
  * represent a page template.
  *
  * @package CMS
  * @subpackage tree
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_pageTemplate extends CMS_grandFather
{
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_id;
	
	/**
	  * Label of the template
	  * @var string
	  * @access private
	  */
	protected $_label;

	/**
	  * image showing the template in action
	  * @var string
	  * @access private
	  */
	protected $_image;

	/**
	  * Template groups this template belongs to
	  * @var CMS_stack
	  * @access private
	  */
	protected $_groups;

	/**
	  * Modules that will be called by client spaces included in the template
	  * @var CMS_stack
	  * @access private
	  */
	protected $_modules;

	/**
	  * Template definition file
	  * @var string
	  * @access private
	  */
	protected $_definitionFile;

	/**
	  * Client sapces tags as XMLTag objects
	  * @var array(CMS_XMLTag)
	  * @access private
	  */
	protected $_clientSpacesTags = array();

	/**
	  * Is the template useable by users ?
	  * @var boolean
	  * @access private
	  */
	protected $_useable = false;

	/**
	  * Is the template private (i.e. won't appear in page creation nor template management) ?
	  * @var boolean
	  * @access private
	  */
	protected $_private = false;

	/**
	  * Array of the clientspaces order for printing
	  * @var array(string)
	  * @access private
	  */
	protected $_printingClientSpaces = array();
	
	/**
	  * Template description
	  * @var string
	  * @access private
	  */
	protected $_description = '';
	
	/**
	  * Websites denied for the template
	  * @var string
	  * @access private
	  */
	protected $_websitesdenied;
	
	/**
	  * Constructor.
	  * initializes the template if the id is given.
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access public
	  */
	function __construct($id = 0)
	{
		$this->_groups = new CMS_stack();
		$this->_modules = new CMS_stack();
		$this->_websitesdenied = new CMS_stack();
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					pageTemplates
				where
					id_pt='$id'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_id = $id;
				$this->_label = $data["label_pt"];
				$this->_image = $data["image_pt"];
				$this->_definitionFile = $data["definitionFile_pt"];
				$this->_groups->setTextDefinition($data["groupsStack_pt"]);
				$this->_modules->setTextDefinition($data["modulesStack_pt"]);
				$this->_useable = $data["inUse_pt"];
				$this->_private = $data["private_pt"];
				$this->_printingClientSpaces = trim($data["printingCSOrder_pt"]) ? explode(";", $data["printingCSOrder_pt"]) : array();
				$this->_description = $data["description_pt"];
				$this->_websitesdenied->setTextDefinition($data["websitesdenied_pt"]);
			} else {
				$this->raiseError("Unknown ID :".$id);
			}
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
	  * Gets the label
	  *
	  * @return string The label
	  * @access public
	  */
	function getLabel()
	{
		return $this->_label;
	}
	
	/**
	  * Sets the label.
	  *
	  * @param string $label The label to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setLabel($label)
	{
		if ($label) {
			$this->_label = $label;
			return true;
		} else {
			$this->raiseError("Label can't be empty");
			return false;
		}
	}
	
	/**
	  * Gets the description
	  *
	  * @return string The label
	  * @access public
	  */
	function getDescription()
	{
		return $this->_description;
	}
	
	/**
	  * Sets the description.
	  *
	  * @param string $label The label to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setDescription($description)
	{
		$this->_description = $description;
		return true;
	}
	
	/**
	  * Rename the template and all sub-templates
	  *
	  * @param string $label The label to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function renameTemplate($label)
	{
		if ($label) {
			$this->_label = $label;
			
			$sql = "
				update
					pageTemplates
				set
					label_pt='".SensitiveIO::sanitizeSQLString($this->_label)."'
				where
					definitionFile_pt = '".$this->_definitionFile."'
			";
			$q = new CMS_query($sql);
			
			return true;
		} else {
			$this->raiseError("Label can't be empty");
			return false;
		}
	}
	
	/**
	  * Is the module useable by users ?
	  *
	  * @return boolean 
	  * @access public
	  */
	function isUseable()
	{
		return $this->_useable;
	}
	
	/**
	  * Sets the usability
	  *
	  * @param boolean $usability The new usablility to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setUsability($usability)
	{
		$this->_useable = ($usability) ? true : false;
		return true;
	}
	
	/**
	  * Sets the private flag
	  *
	  * @param boolean $private The new flag to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setPrivate($private)
	{
		$this->_private = ($private) ? true : false;
		return true;
	}
	
	/**
	  * is the template have private flag
	  *
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function isPrivate()
	{
		return $this->_private;
	}
	
	/**
	  * Gets the image file.
	  *
	  * @return string the image file name
	  * @access public
	  */
	function getImage()
	{
		return $this->_image;
	}
	
	/**
	  * Sets the image. Can be empty. Must have the gif, jpg, jpeg or png extension.
	  *
	  * @param string $image the image to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function setImage($image = 'nopicto.gif')
	{
		if (!trim($image)) {
			$image = 'nopicto.gif';
		}
		$extension = substr($image, strrpos($image, ".") + 1);
		if (SensitiveIO::isInSet(strtolower($extension), array("jpg", "jpeg", "gif", "png"))) {
			$this->_image = $image;
			return true;
		} else {
			$this->_image = 'nopicto.gif';
			return true;
		}
	}
	
	/**
	  * Gets the groups the template belongs to.
	  *
	  * @return array(string) The groups represented by their string in an array
	  * @access public
	  */
	function getGroups()
	{
		$groups_arrayed = $this->_groups->getElements();
		$groups = array();
		foreach ($groups_arrayed as $group_arrayed) {
			$groups[$group_arrayed[0]] = $group_arrayed[0];
		}
		return $groups;
	}
	
	/**
	  * Gets the websites denied for the template.
	  *
	  * @return array(integer) The websites denied id
	  * @access public
	  */
	function getWebsitesDenied()
	{
		$websitesDenied = $this->_websitesdenied->getElements();
		$websites = array();
		foreach ($websitesDenied as $websiteDenied) {
			$websites[$websiteDenied[0]] = $websiteDenied[0];
		}
		return $websites;
	}
	
	/**
	  * Add a denied website to the list.
	  *
	  * @param integer $website The website to denied
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function denyWebsite($website)
	{
		if (sensitiveIO::isPositiveInteger($website) && CMS_websitesCatalog::getById($website)) {
			$websites = $this->getWebsitesDenied();
			if (!in_array($website, $websites)) {
				$this->_websitesdenied->add($website);
			}
			return true;
		} else {
			$this->raiseError("Trying to deny an invalid website");
			return false;
		}
	}
	
	/**
	  * Remove a denied website from the list.
	  *
	  * @param integer $website The website to remove
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function delDeniedWebsite($website)
	{
		if ($website) {
			$this->_websitesdenied->del($website);
			return true;
		} else {
			$this->raiseError("Trying to remove an empty website");
			return false;
		}
	}
	
	/**
	  * Deletes all the websites denied stack
	  *
	  * @return void
	  * @access public
	  */
	function delAllWebsiteDenied()
	{
		$this->_websitesdenied = new CMS_stack();
	}
	
	/**
	  * Gets the client spaces tags arrays.
	  *
	  * @return array(CMS_xmlTag) The tag interpreted by parser, a client space
	  * @access public
	  */
	function getClientSpacesTags()
	{
		if (!$this->_definitionFile) {
			return array();
		}
		$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_CLIENTSPACE_TAGS,PAGE_VISUALMODE_HTML_EDITED,$this);
		//If parser produce no error
		if ($this->_clientSpacesTags || (!$this->_clientSpacesTags && $this->_parseDefinitionFile($modulesTreatment) === true)) {
			return $this->_clientSpacesTags;
		} else {
			return array();
		}
	}
	
	/**
	  * Gets the modules included in the template.
	  *
	  * @return array(codename => CMS_module) The modules present in the template via module client spaces
	  * @access public
	  */
	function getModules() {
		$elements = $this->_modules->getElements();
		$modules = array();
		foreach ($elements as $element) {
			$modules[$element[0]] = CMS_modulesCatalog::getByCodename($element[0]);
		}
		ksort($modules);
		return $modules;
	}
	
	/**
	  * Does the template has the specified group in its stack ?.
	  *
	  * @param string $group The group we want to test
	  * @return boolean true if the template belongs to that group, false otherwise
	  * @access public
	  */
	function belongsToGroup($group)
	{
		$grps = $this->_groups->getElementsWithOneValue($group, 1);
		return (is_array($grps) && $grps);
	}
	
	/**
	  * Add a group to the list.
	  *
	  * @param string $group The group to add
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function addGroup($group)
	{
		if ($group && $group == SensitiveIO::sanitizeSQLString($group)) {
			$groups = $this->getGroups();
			if (!in_array($group, $groups)) {
				$this->_groups->add($group);
			}
			return true;
		} else {
			$this->raiseError("Trying to set an empty group or which contains illegal characters");
			return false;
		}
	}
	
	/**
	  * Remove a group from the list.
	  *
	  * @param string $group The group to remove
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function delGroup($group)
	{
		if ($group) {
			$this->_groups->del($group);
			return true;
		} else {
			$this->raiseError("Trying to remove an empty group");
			return false;
		}
	}
	
	/**
	  * Deletes all the groups stack
	  *
	  * @return void
	  * @access public
	  */
	function delAllGroups()
	{
		$this->_groups = new CMS_stack();
	}
	
	/**
	  * Get the definition file name
	  *
	  * @return string The definition file name.
	  * @access public
	  */
	function getDefinitionFile()
	{
		return $this->_definitionFile;
	}
	
	/**
	  * Set the definition file name
	  *
	  * @param string $filename The name of the file (without any path information)
	  * @return string the parsing error if any, false otherwise
	  * @access public
	  */
	function setDefinitionFile($filename)
	{
		if ($filename == SensitiveIO::sanitizeAsciiString($filename)) {
			$fp = @fopen(PATH_TEMPLATES_FS."/".$filename, 'rb');
			if (is_resource($fp)) {
				fclose($fp);
				
				//parse the definition file to get the client spaces XMLTags
				$old_filename = $this->_definitionFile;
				$this->_definitionFile = $filename;
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_CLIENTSPACE_TAGS,PAGE_VISUALMODE_HTML_EDITED,$this);
				$error = $this->_parseDefinitionFile($modulesTreatment);
				if ($error !== true) {
					$this->_definitionFile = $old_filename;
					return $error;
				}
				return false;
			} else {
				$this->raiseError("Can't set definition file that doesn't exist or is not readable : ".$filename);
				return "XMLParser : Unreadable file";
			}
		} else {
			$this->raiseError("Can't set definition file which contains illegal characters : ".$filename);
			return "XMLParser : Filename contains illegal characters";
		}
	}
	
	/**
	  * Gets the definition as string data, taken from the definition file
	  *
	  * @return string the definition
	  * @access public
	  */
	function getDefinition()
	{
		if ($file = $this->getDefinitionFile()) {
			$fp = fopen(PATH_TEMPLATES_FS."/".$file, 'rb');
			if (is_resource($fp)) {
				$data = fread($fp, filesize(PATH_TEMPLATES_FS."/".$file));
				fclose($fp);
				return $data;
			}
		}
		return false;
	}
	
	/**
	  * Sets the definition from a string. Must write the definition to file and try to parse it
	  * The file must be in a specific directory : PATH_TEMPLATES_FS (see constants from rc file)
	  *
	  * @param string $definition The definition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setDefinition($definition)
	{
		$filename = $this->getDefinitionFile();
		if (!$filename) {
			//must write it to persistence to have its ID
			if (!$this->_id) {
				$this->writeToPersistence();
			}
			//build the filename
			$filename = 'pt'.$this->_id.'_'.SensitiveIO::sanitizeAsciiString($this->_label).'.xml';
		}
		
		//save old definition (before replacement)
		$old_definition = @file_get_contents(PATH_TEMPLATES_FS."/".$filename);
		
		$fp = @fopen(PATH_TEMPLATES_FS."/".$filename, 'wb');
		if (!is_resource($fp)) {
			$this->raiseError("Can't open the definition file for writing");
			return false;
		}
		
		fwrite($fp, $definition, strlen($definition));
		$this->_definitionFile = $filename;
		fclose($fp);
		@chmod (PATH_TEMPLATES_FS."/".$filename, octdec(FILES_CHMOD));
		
		//then parse file to get modules and CS datas
		$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_CLIENTSPACE_TAGS,PAGE_VISUALMODE_HTML_EDITED,$this);
		$error = $this->_parseDefinitionFile($modulesTreatment);
		if ($error !== true) {
			$fp = @fopen(PATH_TEMPLATES_FS."/".$filename, 'wb');
			fwrite($fp, $old_definition, strlen($definition));
			fclose($fp);
			@chmod (PATH_TEMPLATES_FS."/".$filename, octdec(FILES_CHMOD));
			return $error;
		}
		
		return true;
	}
	
	/**
	  * Get the content of the template for the specified page and visualization mode.
	  * Doesn't translates the atm-linx tags.
	  *
	  * @param CMS_language $language The language of the administration frontend (for FORM visualization mode)
	  * @param CMS_page $page The page we want the content of
	  * @param integer $visualizationMode The visualization mode of the page
	  * @return string the content
	  * @access private
	  */
	function getContent(&$language, &$page, $visualizationMode)
	{
		if (!is_a($page, "CMS_page") || !SensitiveIO::isInSet($visualizationMode, CMS_page::getAllvisualizationModes())) {
			$this->raiseError("Page must be a CMS_page and visualization mode in the possibles");
			return false;
		}
		$returnIndexableContent = false;
		if ($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE) {
			$visualizationMode = PAGE_VISUALMODE_PRINT;
			$returnIndexableContent = true;
		}
		
		$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_CLIENTSPACE_TAGS, $visualizationMode, $this);
		$modulesTreatment->setTreatmentParameters(array("page" => $page, "language" => $language));
		if ($this->_parseDefinitionFile($modulesTreatment) === true) {
			if ($visualizationMode == PAGE_VISUALMODE_PRINT || $returnIndexableContent) {
				$data = '';
				$tags = $modulesTreatment->getTags(array(), true);
				foreach ($tags as $tag) {
					$data .= $modulesTreatment->treatWantedTag($tag);
				}
			} else {
				$data = $modulesTreatment->treatContent(true);
			}
			//if we only need indexable content, return data here without any treatment on template
			if ($returnIndexableContent) {
				return '<html><body>'.$data.'</body></html>';
			}
			//separate processing for PRINT visualmode
			if ($visualizationMode == PAGE_VISUALMODE_PRINT) {
				//now put the data inside the template
				$template_data = file_get_contents(PATH_PRINT_TEMPLATES_FS);
				return str_replace("{{data}}", $data, $template_data);
			} else {
				//add the cdata that is after the last tag
				//$data .= substr($definition, $offset);
				
				//eval() the PHP if needed
				if ($visualizationMode == PAGE_VISUALMODE_CLIENTSPACES_FORM) {
					$data = sensitiveIO::evalPHPCode($data);
					//replace {{pageID}} tag in all page content.
					$data = str_replace('{{pageID}}', $page->getID(), $data);
				}
				return $data;
			}
			return false;
		} else {
			return false;
		}
	}
	
	/**
	  * is this template content in draft ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isDraft() {
		if (!sensitiveIO::isPositiveInteger($this->getID())) {
			return false;
		}
		$sql = "select 
					*
				from 
					mod_standard_clientSpaces_edition 
				where 
					template_cs='".$this->getID()."'";
		$q = new CMS_query($sql);
		return ($q->getNumRows(true)) ? true : false;
	}
	
	/**
	  * Get the clientspaces order
	  *
	  * @return array(string) The clientspaces tag IDs attributes
	  * @access public
	  */
	function getPrintingClientSpaces()
	{
		return $this->_printingClientSpaces;
	}
	
	/**
	  * Set the clientspaces order. Must be an array of CS Ids
	  *
	  * @param array $CSTagsIDs
	  * @return void
	  * @access public
	  */
	function setPrintingClientSpaces($CSTagsIDs)
	{
		if (!is_array($CSTagsIDs)) {
			$this->_raiseError('$CSTagsIDs must be an array of CS Ids.');
			return false;
		}
		$this->_printingClientSpaces = $CSTagsIDs;
	}
	
	/**
	  * Has this template any pages based on it ?
	  *
	  * @return boolean
	  * @access public
	  */
	function hasPages()
	{
		if (!$this->_id) {
			return false;
		}
		$sql = "
			select
				count(id_pag) as c
			from
				pages,
				pageTemplates
			where
				template_pag=id_pt
				and definitionFile_pt = '".$this->_definitionFile."'
		";
		$q = new CMS_query($sql);
		if ($q->getValue("c")) {
			return true;
		}
		return false;
	}
	
	/**
	  * Get the pages based on this template or templates clones
	  *
	  * @param boolean $withClones : get also all pages based on the clones (default : false)
	  * @return array(CMS_page) The pages
	  * @access private
	  */
	function getPages($withClones = false)
	{
		if (!$this->_id) {
			return array();
		}
		if ($withClones) {
			$sql = "
				select
					id_pag
				from
					pages,
					pageTemplates
				where
					template_pag=id_pt
					and definitionFile_pt = '".$this->_definitionFile."'
			";
		} else {
			$sql = "
				select
					id_pag
				from
					pages
				where
					template_pag='".$this->_id."'
			";
		}
		$q = new CMS_query($sql);
		$pages = array();
		while ($id = $q->getValue("id_pag")) {
			$pg = CMS_tree::getPageByID($id);
			if (!$pg->hasError()) {
				$pages[] = $pg;
			}
		}
		return $pages;
	}
	
	/**
	  * Parse the definition file as to get the client spaces
	  *
	  * @param CMS_modulesTags $modulesTreatment tags object treatment
	  * @return string The error string from the parser, false if no error
	  * @access private
	  */
	protected function _parseDefinitionFile(&$modulesTreatment)
	{
		$filename = PATH_TEMPLATES_FS."/".$this->_definitionFile;
		$tpl = new CMS_file(PATH_TEMPLATES_FS."/".$this->_definitionFile);
		if (!$tpl->exists()) {
			$this->raiseError('Can not found template file '.PATH_TEMPLATES_FS."/".$this->_definitionFile);
			return false;
		}
		$definition = $tpl->readContent();
		//we need to remove doctype if any
		$definition = preg_replace('#<!doctype[^>]*>#siU', '', $definition);
		$modulesTreatment->setDefinition($definition);
		
		//test to see if there are they duplicates in client spaces IDs, and also get client spaces modules codename
		$this->_clientSpacesTags = $modulesTreatment->getTags(array('atm-clientspace'), true);
		if (is_array($this->_clientSpacesTags)) {
			$modules = array();
			$ids = array();
			foreach ($this->_clientSpacesTags as $cs_tag) {
				if ($cs_tag->getAttribute("id") && in_array($cs_tag->getAttribute("id"), $ids)) {
					$this->raiseError('Malformed template file to set : contains redundant clientSpaces ids');
					$this->_clientSpacesTags = array();
					return "pageTemplate : malformed template file to set : contains redundant clientSpaces ids";
				} else {
					if ($cs_tag->getAttribute("module")=='standard') {
						$ids[] = $cs_tag->getAttribute("id");
					}
				}
				if ($cs_tag->getAttribute("module")) {
					$modules[] = $cs_tag->getAttribute("module");
				}
			}
			$modules = array_unique($modules);
			$this->_modules->emptyStack();
			foreach ($modules as $module) {
				$this->_modules->add($module);
			}
			return true;
		} else {
			$this->raiseError("Malformed definition file : ".$this->_definitionFile."<br />".$modulesTreatment->getParsingError());
			return $modulesTreatment->getParsingError();
		}
	}
	
	/**
	  * Totally destroys the template, including its definition file
	  *
	  * @return void
	  * @access public
	  */
	function destroy($withDefinitionFile=false)
	{
		if ($this->_id) {
			//destroy the template from its table
			$sql = "
				delete
				from
					`pageTemplates`
				where
					`id_pt`='".$this->_id."'
			";
			$q = new CMS_query($sql);
			
			// Also destroys the client spaces from their table
			$sql = "
				delete
				from
					`mod_standard_clientSpaces_edited`
				where
					`template_cs`='".$this->_id."'
			";
			$q = new CMS_query($sql);
			$sql = "
				delete
				from
					`mod_standard_clientSpaces_edition`
				where
					`template_cs`='".$this->_id."'
			";
			$q = new CMS_query($sql);
			$sql = "
				delete
				from
					`mod_standard_clientSpaces_public`
				where
					`template_cs`='".$this->_id."'
			";
			$q = new CMS_query($sql);
			
			if ($withDefinitionFile) {
				//deletes the definition file
				if ($this->getDefinitionFile()) {
					@unlink(PATH_TEMPLATES_FS."/".$this->getDefinitionFile());
				}
	            
	            //deletes the image file
				if ($this->getImage() && $this->getImage() != 'nopicto.gif') {
					@unlink(PATH_TEMPLATES_IMAGES_FS."/".$this->getImage());
				}
			}
		}
		unset($this);
	}
	
	/**
	  * Writes the template into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		$sql_fields = "
			label_pt='".SensitiveIO::sanitizeSQLString($this->_label)."',
			image_pt='".SensitiveIO::sanitizeSQLString($this->_image)."',
			definitionFile_pt='".SensitiveIO::sanitizeSQLString($this->_definitionFile)."',
			groupsStack_pt='".SensitiveIO::sanitizeSQLString($this->_groups->getTextDefinition())."',
			modulesStack_pt='".SensitiveIO::sanitizeSQLString($this->_modules->getTextDefinition())."',
			inUse_pt='".$this->_useable."',
			description_pt='".SensitiveIO::sanitizeSQLString($this->_description)."',
			websitesdenied_pt='".SensitiveIO::sanitizeSQLString($this->_websitesdenied->getTextDefinition())."',
			private_pt='".$this->_private."',
			printingCSOrder_pt='".SensitiveIO::sanitizeSQLString(implode(";", $this->_printingClientSpaces))."'
		";
		if ($this->_id) {
			// Some changes must be applied
			// to all private templates similar to this one using same xml file
			$sql = "
				update
					pageTemplates
				set
					label_pt='".SensitiveIO::sanitizeSQLString($this->_label)."',
					image_pt='".SensitiveIO::sanitizeSQLString($this->_image)."',
					groupsStack_pt='".SensitiveIO::sanitizeSQLString($this->_groups->getTextDefinition())."',
					modulesStack_pt='".SensitiveIO::sanitizeSQLString($this->_modules->getTextDefinition())."',
					printingCSOrder_pt='".SensitiveIO::sanitizeSQLString(implode(";", $this->_printingClientSpaces))."'
				where
					definitionFile_pt like '".SensitiveIO::sanitizeSQLString($this->_definitionFile)."'
					and private_pt='1'
			";
			$q = new CMS_query($sql);
			$sql = "
				update
					pageTemplates
				set
					".$sql_fields."
				where
					id_pt='".$this->_id."'
			";
		} else {
			$sql = "
				insert into
					pageTemplates
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		//pr($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_id) {
			$this->_id = $q->getLastInsertedID();
		}
		return true;
	}
	
	function getJSonDescription($user, $cms_language, $withDefinition = false) {
		//get websites
		$websites = CMS_websitesCatalog::getAll();
		$hasPages = $this->hasPages();
		$websitesList = '';
		$websitesDenied = $this->getWebsitesDenied();
		foreach ($websites as $id => $website) {
			if (!isset($websitesDenied[$id])) {
				$websitesList .= ($websitesList) ? ', ':'';
				$websitesList .= $website->getLabel();
			}
		}
		$description = sensitiveIO::ellipsis($this->getDescription(), 50);
		if ($description != $this->getDescription()) {
			$description = '<span ext:qtip="'.htmlspecialchars($this->getDescription()).'">'.$description.'</span>';
		}
		$description = $withDefinition ? $description.'<br />' : '';
		//append template definition if needed
		$definitionDatas = ($withDefinition) ? $this->getDefinition() : '';
		if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
			$edit = array(
				'url' 		=> 'template.php',
				'params'	=> array(
					'template' => $this->getID()
				)
			);
		} else {
			$edit = false;
		}
		return array(
			'id'			=> $this->getID(),
			'label'			=> $this->getLabel(),
			'type'			=> 'Modèle de page',
			'image'			=> PATH_TEMPLATES_IMAGES_WR.'/'. (($this->getImage()) ? $this->getImage() : 'nopicto.gif'),
			'groups'		=> implode(', ', $this->getGroups()),
			'websites'		=> $websitesList,
			'desc'			=> $this->getDescription(),
			'filter'		=> $this->getLabel().' '.implode(', ', $this->getGroups()),
			'description'	=> 	'<div'.(!$this->isUseable() ? ' class="atm-inactive"' : '').'>'.
									'<img src="'.(PATH_TEMPLATES_IMAGES_WR.'/'. (($this->getImage()) ? $this->getImage() : 'nopicto.gif')).'" style="float:left;margin-right:3px;width:80px;" />'.
									$description.
									'Sites : <strong>'.$websitesList.'</strong><br />'.
									'Groupes : <strong>'.implode(', ', $this->getGroups()).'</strong><br />'.
									'Actif : <strong>'.($this->isUseable() ? 'Oui':'Non').'</strong><br />'.
									'Employé : <strong>'.($hasPages ? 'Oui':'Non').'</strong>'.($hasPages ? ' - <a href="#" onclick="Automne.view.search(\'template:'.$this->getID().'\');return false;">Voir</a>'.
									($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) ? ' / <a href="#" onclick="Automne.server.call(\'templates-controler.php\', \'\', {templateId:'.$this->getID().', action:\'regenerate\'});return false;">Régénérer</a>' : '').' les pages.' : '').
									'<br class="x-form-clear" />'.
								'</div>',
			'activated'		=> $this->isUseable() ? true : false,
			'used'			=> $hasPages,
			'definition'	=> $definitionDatas,
			'edit'			=> $edit
		);
	}
}
?>