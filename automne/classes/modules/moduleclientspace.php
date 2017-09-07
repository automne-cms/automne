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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: moduleclientspace.php,v 1.5 2010/03/08 16:43:30 sebastien Exp $

/**
  * Class CMS_moduleClientspace
  *
  * represent a module client space
  * Abstract class
  *
  * @package Automne
  * @subpackage modules
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_moduleClientspace extends CMS_grandFather
{
	/**
	  * Attributes of the client space tag
	  * @var array(string=>string)
	  * @access private
	  */
	protected $_attributes;
	
	/**
	  * ID attribute of the client space tag
	  * @var string
	  * @access private
	  */
	protected $_tagID;
	
	/**
	  * Constructor.
	  *
	  * @param integer $attributes The attributes of the clientSpace Tag
	  * @return void
	  * @access public
	  */
	function __construct($attributes)
	{
		if ($attributes && is_array($attributes)) {
			$this->_attributes = $attributes;
		} else {
			$this->setError("Attributes not a valid array");
			return;
		}
	}
	
	/**
	  * Gets the tag ID.
	  *
	  * @return integer the tag ID attribute
	  * @access public
	  */
	function getTagID()
	{
		return $this->_tagID;
	}
	
	/**
	  * Gets the data from the module
	  *
	  * @param CMS_language &$language The language of the administration frontend
	  * @param CMS_page &$page the page parsed
	  * @param integer $visualizationMode the visualization mode
	  * @return string the data from the rows.
	  * @access public
	  */
	function getData(&$language, &$page, $visualizationMode)
	{
	}
	
	/**
	  * Gets the data from all rows
	  *
	  * @param CMS_language &$language The language of the administration frontend
	  * @param CMS_page &$page the page parsed
	  * @param integer $visualizationMode the visualization mode
      * @param boolean $templateHasPages don't display forms if set to true
	  * @return string, The data returned by all rows as a string
	  * @access public
	  */
	function getRawData(&$language, &$page, $visualizationMode, $templateHasPages=false)
	{
	}
	
	/**
	  * Gets the data from the module
	  *
	  * @param string $codename The module codename
	  * @param CMS_language &$language The language of the administration frontend
	  * @param CMS_page &$page the page parsed
	  * @param integer $visualizationMode the visualization mode
	  * @return string the data from the rows.
	  * @access public
	  */
	function getClientspaceData($codename, &$language, &$page, $visualizationMode)
	{
		// Prints wanted template
		$tpl_name = "mod_".$codename."_".io::strtolower($this->_attributes["type"]).".php";
		if (!is_file(PATH_TEMPLATES_FS."/".$tpl_name)) {
			$this->setError("Not a valid file found : ".$tpl_name);
			return false;
		} else {
			$data = $this->_parseTemplateForParameters($tpl_name);
		}
		//make sure all template caracters are in UTF-8
		if (strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8') {
			$data = mb_convert_encoding($data, 'UTF-8', 'ISO-8859-1');
		}
		// Add attributes
		// Foreach attribute, adds a line to $data, after first php tag
		if (is_array($this->_attributes) && $this->_attributes) {
			$attrs = '';
			while (list($k,$v) = each($this->_attributes)) {
				//Foreach attribute, Adding a line to $data, after first php tag
				$attrs .= 
				'$mod_'.$codename.'["'.$k.'"] = '.var_export($v,true).';'."\n";
			}
			// At least declare array of attributes to erase any previous one
			$data = 
				'<?php'."\n".
				'$mod_'.$codename.' = array();'."\n".
				$attrs.
				'?>'."\n".
				$data;
		}
		return $data;
	}
	
	
	/**
	  * Parse the content of a template for module parameters and returns the content.
	  * Usually used by the getData() function to handle template files and feed them with module parameters
	  *
	  * @param string $filename The filename of the template, located in the templates directory
	  * @return string the data from the rows.
	  * @access private
	  */
	protected function _parseTemplateForParameters($filename)
	{
		$module = CMS_modulesCatalog::getByCodename($this->_attributes["module"]);
		if (!($module instanceof CMS_module)) {
			$this->setError("No module defined for the clientspace");
			return false;
		}
		$parameters = $module->getParameters();
		$templateFile = new CMS_file(PATH_TEMPLATES_FS."/".$filename);
		if ($templateFile->exists()) {
			$cdata = $templateFile->getContent();
			
			//no need to be complicated if no parameters
			if (!$parameters) {
				return $cdata;
			}
			//"parse" template for parameters. No XML parsing (PHP code produces strange results)
			//MUST wipe out the linefeeds, because pcre's stop at them !!!
			$cdata_pcre = str_replace("\n", "§§", $cdata);
			while (true) {
				unset($regs);
				preg_match('/(.*)(<module-param [^>]*\/>)(.*)/', $cdata_pcre, $regs);
				if (isset($regs[2])) {
					$param_value = '';
					$domdocument = new CMS_DOMDocument();
					try {
						$domdocument->loadXML('<dummy>'.$regs[2].'</dummy>');
					} catch (DOMException $e) {
						$this->setError('Parse error during search for module-param parameters : '.$e->getMessage()." :\n".io::htmlspecialchars($regs[2]));
						return false;
					}
					$paramsTags = $domdocument->getElementsByTagName('module-param');
					foreach ($paramsTags as $paramTag) {
						$param_value = str_replace("\n", "§§", $parameters[$paramTag->getAttribute("name")]);
					}
					$cdata_pcre = $regs[1].$param_value.$regs[3];
				} else {
					break;
				}
			}
			$cdata = str_replace("§§", "\n", $cdata_pcre);
			return $cdata;
		} else {
			$this->setError("Template ".$filename." isn't readable");
			return false;
		}
	}
}
?>