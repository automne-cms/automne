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
// $Id: modulesTags.php,v 1.4 2010/03/08 16:43:31 sebastien Exp $

/**
  * Class CMS_modulesTags
  *
  * represent all modules tags processing.
  *
  * @package Automne
  * @subpackage modules
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_modulesTags extends CMS_grandFather
{
	/**
	  * The modules treatment definition.
	  * @var multidimensional array
	  * @access private
	  */
	protected $_modulesTreatment = array();
	
	/**
	  * Automne modules
	  * @var array
	  * @access private
	  */
	protected $_modules = array();
	
	/**
	  * The current treatment mode.
	  * @var integer
	  * @access private
	  */
	protected $_treatmentMode = '';
	
	/**
	  * The current visualization mode.
	  * @var integer
	  * @access private
	  */
	protected $_visualizationMode = '';
	
	/**
	  * The current object treated.
	  * @var object
	  * @access private
	  */
	protected $_treatedObject = '';
	
	protected $_parser;
	protected $_definitionArray = array();
	protected $_definition;
	protected $_wantedTags;
	protected $_treatmentParameters;
	protected $_tagsCallback;
	
	/**
	  * Constructor.
	  * initializes object.
	  * @param integer $treatmentMode The current treatment mode (see constants in cms_rc.php for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants in cms_rc.php for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  *
	  * @return void
	  * @access public
	  */
	function __construct($treatmentMode, $visualizationMode, &$treatedObject) 
	{
		$this->_treatmentMode = $treatmentMode;
		$this->_visualizationMode = $visualizationMode;
		$this->_treatedObject = &$treatedObject;
		$this->_modules = CMS_modulesCatalog::getAll("id");
		foreach ($this->_modules as $codename => $aModule) {
			$moduleTreatment = $aModule->getWantedTags($this->_treatmentMode, $this->_visualizationMode, $this->_treatedObject);
			if ($treatmentMode == MODULE_TREATMENT_PAGECONTENT_TAGS && isset($moduleTreatment['atm-meta-tags'])) {
				$this->raiseError("Tag atm-meta-tags must be treated in MODULE_TREATMENT_PAGEHEADER_TAGS mode. Module ".$codename." try to use atm-meta-tags in MODULE_TREATMENT_PAGECONTENT_TAGS mode which is deprecated since Automne V4.0.0RC3. Edit file ".$codename.".php and change MODULE_TREATMENT_PAGECONTENT_TAGS by MODULE_TREATMENT_PAGEHEADER_TAGS in methods getWantedTags and treatWantedTag for tag atm-meta-tags");
				unset($moduleTreatment['atm-meta-tags']);
			}
			if (is_array($moduleTreatment) && $moduleTreatment) {
				//if module return tags, save it.
				$this->_modulesTreatment[$codename] = $moduleTreatment;
			} else {
				//else remove useless modules from list
				unset ($this->_modules[$codename]);
			}
		}
		return true;
	}
	
	/** 
	  * Get the tags to be treated by modules for the specified treatment mode, visualization mode and object.
	  *
	  * @return array of tags to be treated.
	  * @access public
	  */
	function getWantedTags() {
		if (!isset($this->_wantedTags)) {
			$this->_wantedTags = array();
			if (is_array($this->_modules) && $this->_modules) {
				foreach ($this->_modules as $aModule) {
					if (is_array($this->_modulesTreatment[$aModule->getCodename()]) && $this->_modulesTreatment[$aModule->getCodename()]) {
						foreach ($this->_modulesTreatment[$aModule->getCodename()] as $tagName => $aTagToTreat) {
							$this->_wantedTags[]=array("tagName" => $tagName, "selfClosed" => $aTagToTreat["selfClosed"], "parameters" => $aTagToTreat["parameters"]);
							if (isset($aTagToTreat["class"]) && $aTagToTreat["class"]) {
								$this->_tagsCallback[$tagName] = $aTagToTreat["class"];
							}
						}
					}
				}
			}
		}
		return $this->_wantedTags;
	}
	
	/** 
	  * Treat given content tag by modules for the specified treatment mode, visualization mode and object.
	  *
	  * @param string $tag The CMS_XMLTag.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  * @return string the tag content treated.
	  * @access public
	  */
	function treatWantedTag(&$tag, $treatmentParameters = array()) 
	{
		if (!$this->_modules || !$this->_modulesTreatment) {
			$this->raiseError("Object not initialized");
			return false;
		}
		if (!($tag instanceof CMS_XMLTag)) {
			$this->raiseError("Tag parameter must be a CMS_XMLTag object");
			return false;
		}
		if ($treatmentParameters) {
			$this->_treatmentParameters = $treatmentParameters;
		}
		$tagContents = '';
		$hasMatch = false;
		foreach ($this->_modulesTreatment as $aModuleCodeName => $moduleTags) {
			if (isset($moduleTags[$tag->getName()]) && is_array($moduleTags[$tag->getName()]) && $moduleTags[$tag->getName()]) {
				//check if tag parameters match to query the module
				if (is_array($moduleTags[$tag->getName()]["parameters"]) && $moduleTags[$tag->getName()]["parameters"]) {
					$match = true;
					foreach ($moduleTags[$tag->getName()]["parameters"] as $aParameter => $value) {
						$match = ($tag->getAttribute($aParameter) == $value || preg_match('/^'.$value.'$/i', $tag->getAttribute($aParameter)) > 0) ? $match:false;
					}
					if ($match) {
						$hasMatch = true;
						if (isset($this->_tagsCallback[$tag->getName()])) {
							$tagContents = $tag->compute(array(
								'mode'			=> $this->_treatmentMode,
								'visualization' => $this->_visualizationMode,
								'object'		=> $this->_treatedObject,
								'parameters'	=> $this->_treatmentParameters
							));
						} else {
							$tagContents = $this->_modules[$aModuleCodeName]->treatWantedTag($tag, $tagContents, $this->_treatmentMode, $this->_visualizationMode, $this->_treatedObject, $this->_treatmentParameters);
						}
					}
				} else {
					//else no tag parameters so query the module
					$hasMatch = true;
					if (isset($this->_tagsCallback[$tag->getName()])) {
						$tagContents = $tag->compute(array(
							'mode'			=> $this->_treatmentMode,
							'visualization' => $this->_visualizationMode,
							'object'		=> $this->_treatedObject,
							'parameters'	=> $this->_treatmentParameters
						));
					} else {
						$tagContents = $this->_modules[$aModuleCodeName]->treatWantedTag($tag, $tagContents, $this->_treatmentMode, $this->_visualizationMode, $this->_treatedObject, $this->_treatmentParameters);
					}
				}
			}
		}
		if (!$hasMatch) {
			return $tag->getContent();
		}
		return $tagContents;
	}
	
	function setTreatmentParameters($treatmentParameters = array()) {
		$this->_treatmentParameters = $treatmentParameters;
		return true;
	}
	
	function setDefinition($definition) {
		$this->_definition = trim($definition);
	}
	
	protected function _parse($options) {
		if (!$this->_definition) {
			$this->raiseError('Can\'t parse empty definition');
			return false;
		}
		//load wanted tags if not already done
		$this->getWantedTags();
		//parse definiton
		$this->_parser = new CMS_xml2Array($this->_definition, $options);
		if ($this->_parser->hasError()) {
			$this->raiseError('Malformed definition to compute : '.$this->_parser->getParsingError());
			return false;
		}
		//get parsed definition array
		$this->_definitionArray = $this->_parser->getParsedArray();
	}
	
	function getParsingError() {
		if (!is_object($this->_parser)) {
			return false;
		}
		return $this->_parser->getParsingError();
	}
	
	function getTags($tagFilters = array(), $enclose = false) {
		if (!$this->_parser) {
			if ($enclose) {
				$options = CMS_xml2Array::XML_PROTECT_ENTITIES
						 | CMS_xml2Array::XML_DONT_THROW_ERROR
						 | CMS_xml2Array::XML_ENCLOSE;
			} else {
				$options = CMS_xml2Array::XML_PROTECT_ENTITIES
						  | CMS_xml2Array::XML_DONT_THROW_ERROR;
			}
			$this->_parse($options);
		}
		if (!$this->_definitionArray) {
			$this->raiseError('Can\'t treat empty definition');
			return false;
		}
		//then return tags definition
		return $this->_getTags($this->_definitionArray, $tagFilters, 0);
	}
	
	/**
	  * Compute recursively all parsed definition tags 
	  * and send them to callback methods (according to $this->_tagsCallBack)
	  *
	  * @param multidimentionnal array $definition : the reference of the definition to compute
	  * @param integer $level : the current level of recursion (default : 0)
	  * @return string the PHP / HTML content computed
	  * @access private
	  */
	protected function _getTags(&$definition, $tagFilters, $level = 0) {
		$tags = array();
		if (is_array($definition) && is_array($definition[0])) {
			//loop on subtags
			foreach (array_keys($definition) as $key) {
				if (isset($definition[$key]['childrens'])) {
					$tags = array_merge($this->_getTags($definition[$key]['childrens'], $tagFilters, ++$level), $tags);
				}
				if (isset($definition[$key]['nodename']) && $this->_isWanted($definition[$key]) && (!$tagFilters || in_array($definition[$key]['nodename'], $tagFilters))) {
					$className = isset($this->_tagsCallback[$definition[$key]['nodename']]) ? $this->_tagsCallback[$definition[$key]['nodename']] : 'CMS_XMLTag';
					if (!class_exists($className)) {
						$this->raiseError('Unknown class '.$className.'. Cannot compute tag '.$definition[$key]['nodename']);
						return false;
					}
					$xmlTag = new $className(
						$definition[$key]['nodename'], 
						$definition[$key]['attributes'], 
						(isset($definition[$key]['childrens']) ? $definition[$key]['childrens'] : array()),
						array(
							'context'			=> CMS_XMLTag::HTML_CONTEXT,
							'childrenCallback'	=> array($this, 'computeTags'),
						)
					);
					$xml = array($definition[$key]);
					$tags[] = $xmlTag;
				}
			}
		}
		return $tags;
	}
	
	function treatContent($enclose = false) {
		if (!$this->_parser) {
			if ($enclose) {
				$options = CMS_xml2Array::XML_PROTECT_ENTITIES
						 | CMS_xml2Array::XML_DONT_THROW_ERROR
						 | CMS_xml2Array::XML_ENCLOSE;
			} else {
				$options = CMS_xml2Array::XML_PROTECT_ENTITIES
						  | CMS_xml2Array::XML_DONT_THROW_ERROR;
			}
			$this->_parse($options);
		}
		if (!$this->_definitionArray) {
			$this->raiseError('Can\'t treat empty definition');
			return false;
		}
		//then return computed definition
		return $this->computeTags($this->_definitionArray);
	}
	
	/**
	  * Compute recursively all parsed definition tags 
	  * and send them to callback methods (according to $this->_tagsCallBack)
	  *
	  * @param multidimentionnal array $definition : the XML tags definition to compute
	  * @param integer $level : the current level of recursion (default : 0)
	  * @return string the PHP / HTML content computed
	  */
	function computeTags($definition, $level = 0) {
		$code = '';
		if (is_array($definition) && is_array($definition[0])) {
			//loop on subtags
			foreach (array_keys($definition) as $key) {
				if (isset($definition[$key]['nodename']) && $this->_isWanted($definition[$key]) && !isset($definition[$key]['childrens'])) {
					$className = isset($this->_tagsCallback[$definition[$key]['nodename']]) ? $this->_tagsCallback[$definition[$key]['nodename']] : 'CMS_XMLTag';
					if (!class_exists($className)) {
						$this->raiseError('Unknown class '.$className.'. Cannot compute tag '.$definition[$key]['nodename']);
						return false;
					}
					$xmlTag = new $className(
						$definition[$key]['nodename'], 
						$definition[$key]['attributes'], 
						array(), 
						array(
							'context'			=> CMS_XMLTag::HTML_CONTEXT
						)
					);
					$xml = array($definition[$key]);
					$code .= $this->treatWantedTag($xmlTag);
				} elseif (isset($definition[$key]['childrens'])) {
					$computedChildren = $this->computeTags($definition[$key]['childrens'], ++$level);
					unset($definition[$key]['childrens']);
					$definition[$key]['childrens'][0]['textnode'] = $computedChildren;
					$xml = array($definition[$key]);
					if (isset($definition[$key]['nodename']) && $this->_isWanted($definition[$key])) {
						$className = isset($this->_tagsCallback[$definition[$key]['nodename']]) ? $this->_tagsCallback[$definition[$key]['nodename']] : 'CMS_XMLTag';
						if (!class_exists($className)) {
							$this->raiseError('Unknown class '.$className.'. Cannot compute tag '.$definition[$key]['nodename']);
							return false;
						}
						$xmlTag = new $className(
							$definition[$key]['nodename'], 
							$definition[$key]['attributes'], 
							$definition[$key]['childrens'],
							array(
								'context'			=> CMS_XMLTag::HTML_CONTEXT,
								'childrenCallback'	=> array($this, 'computeTags'),
							)
						);
						$code .= $this->treatWantedTag($xmlTag);
					} else {
						//append computed tags as code
						$code .= $this->_parser->toXML($xml, false, (isset($this->_treatmentParameters['replaceVars']) && $this->_treatmentParameters['replaceVars'] == true));
					}
				} else {
					//append text node
					$xml = array($definition[$key]);
					$code .= $this->_parser->toXML($xml, false, (isset($this->_treatmentParameters['replaceVars']) && $this->_treatmentParameters['replaceVars'] == true));
				}
			}
		}
		if (is_a($this->_treatedObject, 'CMS_page') && isset($this->_treatmentParameters['replaceVars']) && $this->_treatmentParameters['replaceVars'] == true) {
			$code = str_replace('{{pageID}}', $this->_treatedObject->getID(), $code);
		}
		return $code;
	}
	
	protected function _isWanted($node) {
		foreach ($this->_wantedTags as $tag) {
			if ($node['nodename'] == $tag['tagName']) {
				return true;
			}
		}
		return false;
	}
}
?>