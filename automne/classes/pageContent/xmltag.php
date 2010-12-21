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
// $Id: xmltag.php,v 1.7 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_XMLTag
  *
  * Represents a XML Tag. Instanciated by the XMLParser.
  *
  * @package Automne
  * @subpackage pageContent
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_XMLTag extends CMS_grandFather
{
	const HTML_CONTEXT = 1;
	const PHP_CONTEXT = 2;
	const HTML_TAG_CONTEXT = 3;
	
	/**
	  * The name of the tag.
	  * @var string
	  * @access private
	  */
	protected $_name;

	/**
	  * The tag attributes.
	  * @var array(string name => string value)
	  * @access private
	  */
	protected $_attributes = array();

	/**
	  * The tag children.
	  * @var array(string name => string value)
	  * @access private
	  */
	protected $_children = array();

	/**
	  * The Text content of the tag, including the tag itself.
	  * @var string
	  * @access private
	  */
	protected $_textContent;
	
	/**
	 * Default tag context
	 * @var string the default tag context
	 * @access public
	 */
	protected $_context = self::HTML_CONTEXT;
	
	/**
	  * The current treatments parameters
	  * @var string
	  * @access private
	  */
	protected $_parameters;
	
	/**
	  * The current tag errors
	  * @var string
	  * @access private
	  */
	protected $_tagError;
	
	/**
	  * The current tag references
	  * @var array
	  * @access private
	  */
	protected $_tagReferences = array();
	
	/**
	  * The tag compute parameters
	  * @var array
	  * @access private
	  */
	protected $_computeParams;
	
	/**
	  * The tag compute unique ID
	  * @var string
	  * @access private
	  */
	protected $_uniqueID;
	
	/**
	  * Constructor.
	  *
	  * @param string $name The name of the tag
	  * @param array(string) $attributes The tag attributes.
	  * @param array(string) $parameters The current treatments parameters.
	  * @return void
	  * @access public
	  */
	function __construct($name, $attributes = array(), $children = array(), $parameters = array()) {
		$this->_name = $name;
		$this->_parameters = $parameters;
		$this->_children = $children;
		if (!is_array($attributes)) {
			$this->raiseError("Attributes given are not an array. Fixed by setting an empty array.");
			$this->_attributes = array();
		} else {
			$this->_attributes = $attributes;
		}
  	}
	
	/**
	  * Get the name of the tag
	  *
	  * @return string the tag name
	  * @access public
	  */
	function getName()
	{
		return $this->_name;
	}
	
	/**
	  * Get all the tag attributes
	  *
	  * @return array(string=>string) the tag attributes
	  * @access public
	  */
	function getAttributes()
	{
		return $this->_attributes;
	}
	
	/**
	  * Get the value of an attribute.
	  *
	  * @param string $attribute The attribute we want (its the key of the associative array)
	  * @return string The attribute value
	  * @access public
	  */
	function getAttribute($attribute)
	{
		if (isset($this->_attributes[$attribute])) {
			return $this->_attributes[$attribute];
		} else {
			return false;
		}
	}
	
	/**
	  * Get the start byte position offset.
	  *
	  * @return integer the start byte
	  * @access public
	  */
	function __call($name, $parameters)
	{
		$this->raiseError(__CLASS__.' : Method '.$name.' is not available in this version of Automne');
		return false;
	}
	
	/**
	  * Set the text content. This content must include the tag itself.
	  *
	  * @param string $content The tag content including the tag itself
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	function setTextContent($content)
	{
		$content = trim($content);
		if ($content && io::substr($content, 1, io::strlen($this->_name)) == $this->_name) {
			$this->_textContent = $content;
			return true;
		} else {
			$this->raiseError("Content is empty or does not contain self tag");
			return false;
		}
	}
	
	/**
	  * Get the content, which is the text content including the tag definition.
	  *
	  * @return string the XML
	  * @access public
	  */
	function getContent()
	{
		if (!$this->_textContent) {
			$xml = array(
				'nodename' 	=> $this->_name,
				'attributes'=> $this->_attributes
			);
			if ($this->_children) {
				$xml['childrens'] = $this->_children;
			}
			$xml = array($xml);
			$parser = new CMS_xml2Array();
			$this->_textContent = $parser->toXML($xml);
		}
		return $this->_textContent;
	}
	
	/**
	  * Get the inner content, which is the text content excluding the tag definition.
	  *
	  * @return string the inner HTML
	  * @access public
	  */
	function getInnerContent()
	{
		$regexp = "#<".$this->_name."[^>]*>(.*)</".$this->_name.">#is";
		preg_match($regexp, $this->getContent(), $args);
		return $args[1];
	}
	
	/**
	  * Get the representation instance, from the tag name
	  * What is needed ?
	  * - $args = array("template"=>template_db_id) and attributes contain "id" key along with value for client spaces
	  * - attributes contain "id" and "type" keys along with values for rows
	  * - attributes contain "id" and "type" keys along with values for blocks
	  *
	  * @param array(mixed) $args The arguments needed to instanciate the representation
	  * @return object An instanciated object of the correct class.
	  * @access public
	  */
	function getRepresentationInstance($args = false)
	{
		//if it's a module tag, ask the representation to the module
		if (isset($this->_attributes["module"]) && $this->_attributes["module"]) {
			//Get the module
			$module = CMS_modulesCatalog::getByCodename($this->_attributes["module"]);
			if ($module instanceof CMS_module) {
				//get the instance from the module
				$instance = $module->getTagRepresentation($this, $args);
				if (is_object($instance)) {
					return $instance;
				} else {
					//module didn't returned a valid object instance
					return false;
				}
			} else {
				//the modules catalog didn't returned a module object
				return false;
			}
		}
		
		switch ($this->_name) {
			case "atm-linx":
				if ($this->_attributes["type"] && $args["page"] && isset($args["publicTree"])) {
					$linxArgs = array();
					$linxArgs['id'] = isset($this->_attributes["id"]) ? $this->_attributes["id"] : false;
					$linxArgs['class'] = isset($this->_attributes["class"]) ? $this->_attributes["class"] : false;
					if (isset($this->_attributes["node"]) && io::isPositiveInteger($this->_attributes["node"])) {
						$linxArgs['node'] = $this->_attributes["node"];
					}
					return new CMS_linx($this->_attributes["type"], $this->getContent(), $args["page"], $args["publicTree"], $linxArgs);
				} else {
					return false;
				}
			break;
		}
	}
	
	/**
	  * Compute the current tag according to compute parameters
	  *
	  * @return string the computed tag results
	  * @access private
	  * @static
	  */
	function compute($parameters = array()) {
		$this->_computeParams = (array) $parameters;
		$this->_uniqueID = CMS_XMLTag::getUniqueID();
		if (isset($this->_parameters['context']) && $this->_parameters['context'] && $this->_parameters['context'] != $this->_context) {
			if ($this->_context == CMS_XMLTag::PHP_CONTEXT) {
				$return = '<?php '."\n".
				'//'.strtoupper($this->_name).' TAG START [ref. '.$this->_uniqueID."]\n".
				'$content = $replace = "";'."\n";
				if (isset($this->_tagReferences['module']) && in_array(MOD_STANDARD_CODENAME, $this->_tagReferences['module'])) {
					//set pageID if any
					if (isset($this->_computeParams['object']) && ($this->_computeParams['object'] instanceof CMS_page) && sensitiveIO::isPositiveInteger($this->_computeParams['object']->getID())) {
						$return .= '$parameters[\'pageID\'] = \''.$this->_computeParams['object']->getID().'\';'."\n";
					}
				}
				$return .= $this->_compute()."\n".
				'echo $content;'."\n".
				'unset($content, $replace);'."\n".
				'//'.strtoupper($this->_name).' TAG END [ref. '.$this->_uniqueID."]\n".
				'?>';
			} else {
				return ' ?> '.$this->_compute().' <?php ';
				
				$return .= '/* '.strtoupper($this->_name).' TAG START [ref. '.$this->_uniqueID."]*/ ?>".
				$this->_compute().
				'<?php /* '.strtoupper($this->_name).' TAG END [ref. '.$this->_uniqueID."]*/ \n";
			}
		} else {
			if ($this->_context == CMS_XMLTag::PHP_CONTEXT) {
				$return = '//'.strtoupper($this->_name).' TAG START [ref. '.$this->_uniqueID."]\n";
			} else {
				$return = '<?php /* '.strtoupper($this->_name).' TAG START [ref. '.$this->_uniqueID.']*/ ?>';
			}
			$return .= $this->_compute();
			if ($this->_context == CMS_XMLTag::PHP_CONTEXT) {
				$return .= '//'.strtoupper($this->_name).' TAG END [ref. '.$this->_uniqueID."]\n";
			} else {
				$return .= '<?php /* '.strtoupper($this->_name).' TAG END [ref. '.$this->_uniqueID.']*/ ?>';
			}
		}
		return $return;
	}
	
	/**
	  * Use a callback function to compute children tags
	  *
	  * @return string the computed children results
	  * @access private
	  * @static
	  */
	protected function _computeChilds () {
		$return = '';
		if (isset($this->_children) && $this->_children && isset($this->_parameters['childrenCallback']) && $this->_parameters['childrenCallback'] && is_callable($this->_parameters['childrenCallback'])) {
			$return = call_user_func($this->_parameters['childrenCallback'], $this->_children);
			if (isset($this->_parameters['context']) && $this->_parameters['context'] && $this->_parameters['context'] != $this->_context) {
				if ($this->_context == CMS_XMLTag::PHP_CONTEXT) {
					$return = 
					'$replace_'.$this->_uniqueID.' = $replace; $content_'.$this->_uniqueID.' = $content;'."\n".
					' ?>'.$return.'<?php '."\n".
					'$content = $content_'.$this->_uniqueID.'; $replace = $replace_'.$this->_uniqueID.';'."\n".
					'unset($replace_'.$this->_uniqueID.', $content_'.$this->_uniqueID.');'."\n";
				} else {
					$return = '<?php '.$return.' ?>';
				}
			}
		}
		return $return;
	}
	
	/**
	  * Return an unique ID
	  * formatted as id_rand where id is the number of unique ids queried and rand a 6 alphanumerical random characters string
	  *
	  * @return string the unique ID
	  * @access public
	  * @static
	  */
	static function getUniqueID () {
		static $count;
		$count++;
		return ($count+1).'_'.io::substr(md5(mt_rand().microtime()),0,6);
	}
	
	/**
	  * Return tag errors founded
	   *
	  * @return string the parsing errors
	  * @access public
	  */
	function getTagError() {
		return $this->_tagError;
	}
	
	/**
	  * Return tag references founded
	   *
	  * @return array the tag references
	  * @access public
	  */
	function getTagReferences() {
		return $this->_tagReferences;
	}
	
	/**
	  * Check tags attributes requirements 
	  *
	  * @param array $requirements : tag attributes requirements at the following format :
	  		array(string attributeName => mixed attributeType)
			With attributeType in :
			- boolean true : check only presence of an attribute value
			- alphanum : attribute value must be a simple alphanumeric value without special chars
	  		- language : attribute value must be a valid language code
			- orderType : attribute value must be a valid order type
			- valid PERL regular expression : attribute value must be mattch the regular expression
	  * @return string indented php code
	  * @access public
	  */
	function checkTagRequirements($requirements) {
		if (!is_array($requirements)) {
			$this->raiseError('Tag requirements must be an array');
			return false;
		}
		foreach ($requirements as $name => $requirementType) {
			//check parameter existence
			if (!isset($this->_attributes[$name])) {
				$this->_tagError .= "\n".'Malformed '.$this->_name.' tag : missing \''.$name.'\' attribute';
				return false;
			} elseif ($requirementType !== true) {//if any, check value requirement
				switch ($requirementType) {
					case 'alphanum' :
						if ($this->_attributes[$name] != sensitiveIO::sanitizeAsciiString($this->_attributes[$name], '', '_')) {
							$this->_tagError .= "\n".'Malformed '.$this->_name.' tag : \''.$name.'\' attribute must only be composed with alphanumeric caracters (0-9a-z_) : '.$this->_attributes[$name];
							return false;
						}
					break;
					case 'language' :
						if (isset($this->_parameters['module'])) {
							$languages = CMS_languagesCatalog::getAllLanguages($this->_parameters['module']);
						} else {
							$languages = CMS_languagesCatalog::getAllLanguages();
						}
						if (!isset($languages[$this->_attributes[$name]])) {
							$this->_tagError .= "\n".'Malformed '.$this->_name.' tag : \''.$name.'\' attribute must only be a valid language code : '.$this->_attributes[$name];
							return false;
						}
					break;
					case 'object':
						if (!sensitiveIO::isPositiveInteger(io::substr($this->_attributes[$name],9,-3))) {
							$this->_tagError .= "\n".'Malformed '.$this->_name.' tag : \''.$name.'\' attribute does not represent a valid object';
							return false;
						}
					break;
					case 'field':
						if (strrpos($this->_attributes[$name], 'fields') === false || !sensitiveIO::isPositiveInteger(io::substr($this->_attributes[$name],strrpos($this->_attributes[$name], 'fields')+9,-2))) {
							$this->_tagError .= "\n".'Malformed '.$this->_name.' tag : \''.$name.'\' attribute does not represent a valid object field';
							return false;
						}
					break;
					case 'paramType' :
						if (!in_array($this->_attributes[$name], CMS_object_search::getStaticSearchConditionTypes()) && !sensitiveIO::isPositiveInteger($this->_attributes[$name]) && io::substr($this->_attributes[$name], -12) != "['fieldID']}") {
							$this->_tagError .= "\n".'Malformed '.$this->_name.' tag : \''.$name.'\' attribute, must be one of these values : '.implode(', ', CMS_object_search::getStaticSearchConditionTypes());
							return false;
						}
					break;
					case 'orderType' :
						if (!in_array($this->_attributes[$name], CMS_object_search::getStaticOrderConditionTypes()) && !sensitiveIO::isPositiveInteger($this->_attributes[$name]) && io::substr($this->_attributes[$name], -12) != "['fieldID']}") {
							$this->_tagError .= "\n".'Malformed '.$this->_name.' tag : \''.$name.'\' attribute, must be one of these values : '.implode(', ', CMS_object_search::getStaticOrderConditionTypes());
							return false;
						}
					break;
					default: //check 
						if (!preg_match('#^'.$requirementType.'$#i', $this->_attributes[$name])) {
							$this->_tagError .= "\n".'Malformed '.$this->_name.' tag : \''.$name.'\' attribute must match expression \''.$requirementType.'\' : '.$this->_attributes[$name];
							return false;
						}
					break;
				}
			}
		}
		return true;
	}
	
	/**
	  * Replace vars like {object:field:type} or {var|session|request|page:name:type}. Called during definition compilation
	  *
	  * @param string $text : the text which need to be replaced
	  * @param boolean reverse : reverse single and double quotes useage (default is false : double quotes)
	  * @param boolean $cleanNotMatches : remove vars without matches
	  * @param mixed $matchCallback : function name or array(object classname, object method) which represent a valid callback function to execute on matches
	  * @return text : the text replaced
	  * @access public
	  * @static
	  */
	function replaceVars($text, $reverse = false, $cleanNotMatches = false, $matchCallback = null, $returnMatchedVarsArray = false) {
		static $replacements;
		$enclosePHP = false;
		if ($matchCallback === null) {
			$matchCallback = array($this, 'encloseString');
			if ($this->_context == self::HTML_CONTEXT && $this->_parameters['context'] != self::HTML_TAG_CONTEXT) {
				$enclosePHP = true;
			}
		}
		//if no text => return
		if (!$text || !trim($text)) {
			return $text;
		}
		$count = 1;
		//loop on text for vars to replace if any
		while (preg_match_all("#{[^{}\n]+}#", $text, $matches) && $count) {
			$matches = array_unique($matches[0]);
			//get all tags handled by modules
			if (!$replacements) {
				//create replacement array
				$replacements = array();
				$modules = CMS_modulesCatalog::getAll("id");
				foreach ($modules as $codename => $aModule) {
					$moduleReplacements = $aModule->getModuleReplacements('parameters');
					if (is_array($moduleReplacements) && $moduleReplacements) {
						foreach ($moduleReplacements as $pattern => $replacement) {
							$replacements[$pattern] = $replacement;
						}
					}
				}
			}
			$replace = $replacements;
			
			if ($reverse) {
				$reversedReplace = array();
				foreach ($replace as $key => $value) {
					$reversedReplace[str_replace("'", "\\\'", $key)] = $value;
				}
				$replace = $reversedReplace;
			}
			
			$count = 0;
			$matchesValues = preg_replace(array_keys($replace), $replace, $matches, -1, $count);
			//create vars conversion table
			$replace = array();
			if ($matchesValues) {
				if (isset($this->_parameters['module'])) {
					$externalReferences = CMS_poly_object_catalog::getFieldsReferencesUsage($this->_parameters['module']);
				} else {
					$externalReferences = CMS_poly_object_catalog::getFieldsReferencesUsage();
				}
				foreach ($matches as $key => $match) {
					//record external references for cache reference
					if ($externalReferences) {
						foreach ($externalReferences as $id => $type) {
							if (strpos($match , '[\'fields\']['.$id.']') !== false || strpos($match , '[\\\'fields\\\']['.$id.']') !== false) {
								//CMS_grandFather::log(print_r($this->_tagReferences, true));
								$this->_tagReferences = array_merge_recursive($type, (array) $this->_tagReferences);
								//CMS_grandFather::log(print_r($this->_tagReferences, true));
							}
						}
					}
					//record used pages for cache reference
					if (strpos($match, '{page:') !== false) {
						$this->_tagReferences['module'][] = MOD_STANDARD_CODENAME;
					}
					//record used users for cache reference
					if (strpos($match, '{user:') !== false) {
						$this->_tagReferences['resource'][] = 'users';
					}
					if ($match != $matchesValues[$key]) {
						$matchValue = $matchesValues[$key];
					} else {
						$matchValue = null;
					}
					//apply callback if any to value
					if (isset($matchValue)) {
						if ($matchCallback) {
							if (is_callable($matchCallback)) {
								$replace[$match] = call_user_func($matchCallback, $matchValue, $reverse);
							} else {
								CMS_grandFather::raiseError("Unknown callback function : ".$matchCallback);
								return false;
							}
						} else {
							$replace[$match] = $matchValue;
						}
					} 
					//clean not matches if needed
					elseif ($cleanNotMatches) {
						$replace[$match] = '';
					}
				}
			}
			//return matched vars if needed
			if ($returnMatchedVarsArray) {
				return $replace;
			} 
			//else replace vars in text
			else {
				//then replace variables in text and return it
				$text = str_replace(array_keys($replace), $replace, $text);
				if ($enclosePHP && $replace) {
					//save last replacements
					$lastReplace = $replace;
				}
			}
		}
		if ($enclosePHP && isset($lastReplace) && $lastReplace) {
			//use last replacements to enclose replacement values with php tags
			$replace = array();
			foreach ($lastReplace as $replacement) {
				$replace[$replacement] = '<?php echo "'.$replacement.'"; ?>';
			}
			$text = CMS_XMLTag::cleanComputedDefinition(str_replace(array_keys($replace), $replace, $text));
		}
		return $text;
	}
	
	/**
	  * Enclose a given var with CMS_polymod_definition_parsing::prepareVar method
	  *
	  * @param mixed $var : the var to enclose
	  * @return mixed : the var enclosed
	  * @access public
	  */
	function encloseWithPrepareVar($var) {
		return $this->encloseString("CMS_polymod_definition_parsing::prepareVar(".$var.")",false);
	}
	
	/**
	  * Enclose a given string with double quotes or single quotes according to reverse value
	  *
	  * @param mixed $var : the var to enclose
	  * @param boolean $reverse : enclose with double or single quotes
	  * @return mixed : the var enclosed
	  * @access public
	  */
	function encloseString($var, $reverse) {
		return ($reverse) ? "'.".$var.".'" : '".'.$var.'."';
	}
	
	/**
	  * Do some replacements to clean produced definition code
	  *
	  * @param string $definition : php code to clean
	  * @return string cleaned php code
	  * @access public
	  * @static
	  */
	 static function cleanComputedDefinition($definition) {
		$replace = array(
			'$content .="";' => '',
			'("".' 	=> '(',
			'="".' 	=> '=',
			'.""' 	=> '',
			' "".' 	=> ' ',
			'["".' 	=> '[',
			"\t".'"".' 	=> "\t",
			'\'\'.' => '',
			'.\'\'' => '',
		);
		$pregreplace = array(
			'#\$content .="\n\s+";#' 	=> '',
			'#\<\!\-\-(.*)\-\-\>#sU' 	=> '', //Strip multi lines HTML comments
		);
		return preg_replace(array_keys($pregreplace), $pregreplace, str_replace(array_keys($replace), $replace, $definition));
	}
}
?>