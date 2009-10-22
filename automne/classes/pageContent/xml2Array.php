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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: xml2Array.php,v 1.4 2009/10/22 16:30:05 sebastien Exp $

/**
  * Class CMS_xml2Array
  *
  * return an array from an XML string
  *
  * @package CMS
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_xml2Array extends CMS_grandFather
{
	const XML_ENCLOSE = 1;
	const XML_PROTECT_ENTITIES = 2;
	const XML_CORRECT_ENTITIES = 4;
	const XML_DONT_THROW_ERROR = 8;
	const ARRAY2XML_START_TAG = 1;
	const ARRAY2XML_END_TAG = -1;
	
	protected $_autoClosedTagsList = array('br', 'hr', 'meta', 'input', 'img', 'link', 'area', 'param', 'col', 'frame', 'nodespec');
	
	protected $_params;
	
	protected $_arrOutput = array();
	
	protected $_parsingError;
	
	function __construct($xml = '', $params = self::XML_ENCLOSE)
	{
		$this->_params = $params;
		if ($xml) {
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
			$xml = '<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>'."\n".$xml;
			if ($this->_params & self::XML_PROTECT_ENTITIES) {
				$xml = $this->_codeEntities($xml);
			}
			if ($this->_params & self::XML_CORRECT_ENTITIES) {
				$xml = $this->_correctEntities($xml);
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
	
	function getAutoClosedTagsList() {
		return $this->_autoClosedTagsList;
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
			'/amp]' => '&amp;',
			'/nbsp]' => '&nbsp;',
			'/lt]' => '&lt;',
			'/gt]' => '&gt;',
		);
		$data = str_replace($entities, array_keys($entities), $data);
		//translate ones that are not HTMLized
		$entities = array(
			'&' => '-|amp|-',
			'< ' => '-|lts|-',
		);
		$data = str_replace(array_keys($entities), $entities, $data);
		return $data;
	}
	
	/**
	  * Cleans the entities uncoded
	  *
	  * @param string $data The data to parse for XML entities
	  * @return string
	  * @access private
	  */
	protected function _correctEntities($data)
	{
		$entities = array(
			'&' => '-|amp|-',
			'< ' => '-|lts|-',
		);
		$data = str_replace(array_keys($entities), $entities, $data);
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
			'/amp]' => '&amp;',
			'/nbsp]' => '&nbsp;',
			'/lt]' => '&lt;',
			'/gt]' => '&gt;',
		);
		$data = str_replace(array_keys($entities), $entities, $data);
		return $data;
	}
	
	/**
	  * Un-Cleans the entities uncoded
	  *
	  * @param string $data The data to parse for XML entities
	  * @return string
	  * @access private
	  */
	protected function _uncorrectEntities($data)
	{
		$entities = array(
			'&' => '-|amp|-',
			'< ' => '-|lts|-',
		);
		$data = str_replace($entities, array_keys($entities), $data);
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
		if ($this->_params & self::XML_CORRECT_ENTITIES) {
			$attrs = array_map(array($this,"_uncorrectEntities"),$attrs);
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
			if ($this->_params & self::XML_CORRECT_ENTITIES) {
				$tagData = $this->_uncorrectEntities($tagData);
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
			if ($this->_params & self::XML_CORRECT_ENTITIES) {
				$tagData = $this->_uncorrectEntities($tagData);
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
			}
			if ($this->_params & self::XML_CORRECT_ENTITIES) {
				$piData = $this->_uncorrectEntities($piData);
			}
			if ($this->_params & self::XML_PROTECT_ENTITIES) {
				$piData = $this->_unProtectPIEntities($piData);
			}
			$this->_arrOutput[$last_element]['childrens'][] = array('phpnode' => $piData);
		}
	}
	
	function toXML(&$definition, $part = false)
	{
		//return back xml
		$result = "";
		if(!$definition && is_object($this)){
			$definition = $this->_arrOutput;
		}
		if(!$definition){
			parent::raiseError("No definition found");
			return '';
		}
		$defLen = count($definition);
		for ($c = 0; $c < $defLen; $c++){
			//assign node value
          	if( isset($definition[$c]["textnode"]) ){
				$result .= $definition[$c]["textnode"];
			} elseif (isset($definition[$c]["phpnode"]) ){
				$result .= '<?php '.$definition[$c]["phpnode"].' ?>';
			} else {
				$autoclosed = (in_array($definition[$c]["nodename"], $this->_autoClosedTagsList) || (io::strpos($definition[$c]["nodename"], 'atm') === 0 && !isset($definition[$c]["childrens"])));
				if (!$part || $part == self::ARRAY2XML_START_TAG) {
					$result .='<' . $definition[$c]["nodename"];
					if(is_array($definition[$c]["attributes"])) {
						while (list($key, $value) = each($definition[$c]["attributes"])){
							$result .=' ' . $key.'="' . $value . '"';
						}
					}
					$result .= $autoclosed ? ' />' : '>';
				}
				if (!$part) {
					if( isset($definition[$c]["childrens"]) ){
						$result .= $this->toXML($definition[$c]["childrens"], $part);
					}
				}
				if ((!$part || $part == self::ARRAY2XML_END_TAG) && !$autoclosed) {
					$result .= '</' . $definition[$c]["nodename"] . '>';
				}
			}
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