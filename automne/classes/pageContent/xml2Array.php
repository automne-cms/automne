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
// $Id: xml2Array.php,v 1.6 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_xml2Array
  *
  * return an array from an XML string
  *
  * @package Automne
  * @subpackage pageContent
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_xml2Array extends CMS_grandFather
{
	const XML_ENCLOSE			= 1;
	const XML_PROTECT_ENTITIES	= 2;
	const XML_CORRECT_ENTITIES	= 4;
	const XML_DONT_THROW_ERROR	= 8;
	const XML_DONT_ADD_XMLDECL	= 16;
	const XML_ARRAY2XML_FORMAT	= 32;
	const ARRAY2XML_START_TAG	= 1;
	const ARRAY2XML_END_TAG		= -1;
	
	static $autoClosedTagsList = array('br', 'base', 'hr', 'meta', 'input', 'img', 'link', 'area', 'param', 'col', 'frame', 'nodespec', 'command', 'embed', 'keygen', 'source');
	
	protected $_params;
	
	protected $_arrOutput = array();
	
	protected $_parsingError;
	
	function __construct($xml = '', $params = self::XML_ENCLOSE)
	{
		$this->_params = $params;
		if ($xml) {
			if ($this->_params & self::XML_ARRAY2XML_FORMAT) {
				$domDocument = new CMS_DOMDocument();
		        $domDocument->loadXML($xml, 0, false, false);
				$this->_arrOutput = $this->_xml2Array($domDocument->documentElement, $domDocument->encoding);
			} else {
				$parser = xml_parser_create(APPLICATION_DEFAULT_ENCODING);
				xml_set_object($parser,$this);
				xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
				xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
				xml_set_element_handler($parser, "_tagOpen", "_tagClosed");
				xml_set_character_data_handler($parser, "_charData");
				xml_set_processing_instruction_handler ($parser, "_piData" );
				xml_set_default_handler($parser, "_tagData" );
				//enclose with html tag
				if ($this->_params & self::XML_ENCLOSE) {
					$xml = '<html>'.$xml.'</html>';
				}
				//add encoding declaration
				if ($this->_params ^ self::XML_DONT_ADD_XMLDECL) {
					$xml = '<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>'."\n".$xml;
				}
				if ($this->_params & self::XML_PROTECT_ENTITIES) {
					$xml = $this->_codeEntities($xml);
				}
				if(!xml_parse($parser, $xml )) {
					$this->_parsingError = sprintf("Parse error %s at line %d",
							xml_error_string(xml_get_error_code($parser)),
							xml_get_current_line_number($parser));
					if ($this->_params & ~self::XML_DONT_THROW_ERROR) {
						$this->raiseError($this->_parsingError." :\n".$xml, true);
					}
				}
				xml_parser_free($parser);
				unset($parser);
			}
		}
	}
	
	/**
	  * Recursive method to convert given DOMNode (from CMS_array2Xml) to an array
	  * Used by XML_ARRAY2XML_FORMAT mode
	  *
	  * @param DOMNode $domElement The dom element to convert
	  * @return array
	  * @access public
	  */
	private function _xml2Array($domElement, $encoding) {
		$array = array();
		if (is_object($domElement)) {
			foreach ($domElement->childNodes as $node) {
				if ($node->nodeType == XML_ELEMENT_NODE && $node->hasChildNodes()) {
					if ($node->childNodes->length > 1) {
						$value = $this->_xml2Array($node, $encoding);
					} else {
						$value = $node->textContent;
						//check encoding and transcode if source is utf and current encoding is iso (not needed otherwise)
						if ($encoding == 'utf-8') {
							if (io::strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
								$value = utf8_decode($value);
							}
						}
					}
				} else {
					$value = $node->textContent;
					//check encoding and transcode if source is utf and current encoding is iso (not needed otherwise)
					if ($encoding == 'utf-8') {
						if (io::strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
							$value = utf8_decode($value);
						}
					}
				}
				if ($node->nodeType == XML_ELEMENT_NODE && $node->attributes->length == 1) {
					foreach ($node->attributes as $name => $attribute) {
						$array[$attribute->value] = $value;
					}
				} elseif ($value && (is_array($value) || trim($value))) {
					$array[$node->nodeName] = $value;
				}
			}
		}
		return $array;
	}
	
	/**
	  * Get the list of all auto closed tags supported
	  *
	  * @return array
	  * @access public
	  */
	function getAutoClosedTagsList() {
		return CMS_xml2Array::$autoClosedTagsList;
	}
	
	/**
	  * Replaces the entities found in the text by special strings that will be translated back after parsing
	  *
	  * @param string $data The data to parse for XML entities
	  * @return string
	  * @access private
	  */
	protected function _codeEntities($data)
	{
		$entities = array(
			'/amp]'		=> '&amp;',
			'/nbsp]'	=> '&nbsp;',
			'/lt]'		=> '&lt;',
			'/gt]'		=> '&gt;',
			'||amp||'	=> '&',
			'||lts||'	=> '< '
		);
		$data = str_replace($entities, array_keys($entities), $data);
		return $data;
	}
	
	/**
	  * Replaces the coded entities found in the text by original entities
	  *
	  * @param string $data The data to parse for coded entities
	  * @return string
	  * @access private
	  */
	protected function _decodeEntities($data)
	{
		$entities = array(
			'/amp]' 	=> '&amp;',
			'/nbsp]'	=> '&nbsp;',
			'/lt]'		=> '&lt;',
			'/gt]'		=> '&gt;',
			'||amp||'	=> '&',
			'||lts||'	=> '< ',
		);
		$data = str_replace(array_keys($entities), $entities, $data);
		return $data;
	}
	
	protected function _unProtectPIEntities($data) {
		$replace = array(
			'&amp;&amp;' => '&&',
			'&amp;$' => '&$',
			'&amp;new ' => '&new ',
		);
		return str_replace(array_keys($replace), $replace, $data);
	}
	
	function getParsingError() {
		return $this->_parsingError;
	}
	
	//called on each xml tree
	protected function _tagOpen($parser, $name, $attrs) {
		if ($this->_params & self::XML_PROTECT_ENTITIES) {
			$attrs = array_map(array($this,"_decodeEntities"),$attrs);
		}
		$tag = array("nodename" => $name, "attributes" => $attrs);
		array_push($this->_arrOutput, $tag);
	}
	
	//called on data for xml
	protected function _tagData($parser, $tagData) {
		if($tagData) {
			if ($this->_params & self::XML_PROTECT_ENTITIES) {
				$tagData = $this->_decodeEntities($tagData);
			}
			$last_element = count($this->_arrOutput) - 1;
			$this->_arrOutput[$last_element]['childrens'][] = array("textnode" => $tagData);
		}
	}
	
	//called on data for xml
	protected function _charData($parser, $tagData) {
		//here we have a mess with & so try to correct it
		if($tagData) {
			if ($this->_params & self::XML_PROTECT_ENTITIES) {
				$tagData = $this->_decodeEntities($tagData);
			}
			$last_element = count($this->_arrOutput) - 1;
			$this->_arrOutput[$last_element]['childrens'][] = array("textnode" => $tagData);
		}
	}
	
	//called when finished parsing
	protected function _tagClosed($parser, $name) {
		$count = count($this->_arrOutput);
		$this->_arrOutput[$count - 2]['childrens'][] = $this->_arrOutput[$count - 1];
		array_pop($this->_arrOutput);
	}
	
	//called on PI data for xml
	protected function _piData($parser, $piType, $piData) {
		if(trim($piData) && $piType == 'php') {
			$last_element=count($this->_arrOutput)-1;
			if ($this->_params & self::XML_PROTECT_ENTITIES) {
				$piData = $this->_decodeEntities($piData);
				$piData = $this->_unProtectPIEntities($piData);
			}
			$this->_arrOutput[$last_element]['childrens'][] = array('phpnode' => $piData);
		}
	}
	
	function toXML(&$definition, $part = false, $replaceVars = false) {
		//return back xml
		$result = "";
		if(!$definition && is_object($this)){
			$definition = $this->_arrOutput;
		}
		if(!$definition){
			parent::raiseError("No definition found");
			return '';
		}
		$c = 0;
		while(isset($definition[$c])) {
			//assign node value
          	if( isset($definition[$c]["textnode"]) ){
				
				//replacements on text nodes
				if ($replaceVars) {
					$dummyTag = new CMS_XMLTag('html', array(), array(), array('context' => CMS_XMLTag::HTML_CONTEXT));
					$result .= $dummyTag->replaceVars($definition[$c]["textnode"]);
				} else {
					$result .= $definition[$c]["textnode"];
				}
				
			} elseif (isset($definition[$c]["phpnode"]) ){
				$result .= '<?php '.$definition[$c]["phpnode"].' ?>';
			} else {
				$autoclosed = (in_array($definition[$c]["nodename"], CMS_xml2Array::$autoClosedTagsList) || (substr($definition[$c]["nodename"],0,3) == 'atm' && !isset($definition[$c]["childrens"])));
				if (!$part || $part == self::ARRAY2XML_START_TAG) {
					$tagOpening = '<' . $definition[$c]["nodename"];
					if(is_array($definition[$c]["attributes"])) {
						while (list($key, $value) = each($definition[$c]["attributes"])){
							$tagOpening .=' ' . $key.'="' . $value . '"';
						}
					}
					$tagOpening .= $autoclosed ? ' />' : '>';
					
					$tagOpenReplaced = false;
					if ($replaceVars) {
						$dummyTag = new CMS_XMLTag('html', array(), array(), array('context' => CMS_XMLTag::HTML_TAG_CONTEXT));
						$prepared = addcslashes($tagOpening, '"');
						$replaced = $dummyTag->replaceVars($prepared);
						if ($replaced != $prepared) {
							$tagOpening = '<?php echo "'.$replaced.'"; ?>';
							$tagOpenReplaced = true;
						}
					}
					
					$result .= $tagOpening;
				}
				if (!$part) {
					if( isset($definition[$c]["childrens"]) ){
						$result .= $this->toXML($definition[$c]["childrens"], $part/*, $replaceVars*/);
					}
				}
				if ((!$part || $part == self::ARRAY2XML_END_TAG) && !$autoclosed) {
					$tagClose = '</' . $definition[$c]["nodename"] . '>';
					if (isset($tagOpenReplaced) && $tagOpenReplaced) {
						$tagClose = '<?php echo "'.$tagClose.'"; ?>';
					}
					$result .= $tagClose;
				}
			}
			$c++;
		}
		return $result;
	}
	
	function getParsedArray() {
		if ($this->_params & self::XML_ENCLOSE) {
			//remove enclose tag
			return isset($this->_arrOutput[0]['childrens']) ? $this->_arrOutput[0]['childrens'] : array();
		} else {
			return $this->_arrOutput;
		}
	}
	
	function getXMLInTag($definition, $tagname) {
		//jump directly to childrens
		if (isset($definition['childrens'])) {
			$definition = $definition['childrens'];
		}
		if (is_array($definition) && is_array($definition[0])) {
			//loop on subtags
			foreach (array_keys($definition) as $key) {
				if (isset($definition[$key]['nodename']) && $definition[$key]['nodename'] == $tagname && isset($definition[$key]['childrens'])) {
					return $this->toXML($definition[$key]['childrens']);
				} elseif (isset($definition[$key]['nodename']) && $definition[$key]['nodename'] == $tagname) {
					return false;
				} elseif (is_array($definition[$key]) && isset($definition[$key]['childrens'])) {
					$return = $this->getXMLInTag($definition[$key]['childrens'], $tagname);
					if ($return) {
						return $return;
					}
				}
			}
		} else {
			$this->raiseError("Malformed definition to compute : ".print_r($definition, true));
			return false;
		}
		return false;
	}
}
?>