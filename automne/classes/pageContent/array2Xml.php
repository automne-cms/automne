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

/**
  * Class CMS_array2Xml
  *
  * Return an XML string from a given array.
  * Caution, this class output is only compatible with CMS_xml2Array class if parameter CMS_xml2Array::XML_ARRAY2XML_FORMAT is used
  *
  * @package Automne
  * @subpackage pageContent
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_array2Xml extends CMS_grandFather {
	protected $_doc;
	
	protected $_keyname;
	
	function __construct($array, $tag, $keyname='key') {
		$this->_keyname = $keyname;
		$this->_doc = new CMS_DOMDocument();
		$this->_doc->loadXML("<$tag>".$this->_2xml($array)."</$tag>", 0, true, false);
		$this->_doc->formatOutput = true; 
		return;
	}
	
	function getXML() {
		return $this->_doc;
	}
	
	function getXMLString() {
		return $this->_doc->saveXML();
	}
	
	/**
	  * Escape cdata end tag in text to avoid error in returned content
	  *
	  * @param string $text : the text to escape
	  * @return string : the escaped content
	  * @access private
	  */
	private function _espaceCdata($text) {
		return str_replace(']]>', ']]\>', $text);
	}
	
	protected function _2xml($array) {
		$xml="";
		foreach ($array as $key => $value) {
			if ($value !== '') {
				if (is_array($value)) {
					$value = $this->_2xml($value);
				} elseif (is_numeric($value)) {
					//$value = $value;
				} elseif (is_bool($value)) {
					$value = (int) $value;
				} else {
					$value = '<![CDATA['.$this->_espaceCdata($value).']]>';
				}
				if (!is_numeric($key)) {
					$xml .= "<$key>".$value."</$key>";
				} else {
					$xml .= "<value ".$this->_keyname."=\"$key\">".$value."</value>";
				}
			} else {
				if (!is_numeric($key)) {
					$xml .= "<$key />";
				} else {
					$xml .= "<value ".$this->_keyname."=\"$key\" />";
				}
			}
		}
		return $xml;
	}
}
?>