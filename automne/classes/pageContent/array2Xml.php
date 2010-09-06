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
  * Class CMS_array2Xml
  *
  * Return an XML string from a given array.
  * Caution, this class output is only compatible with CMS_xml2Array class if parameter CMS_xml2Array::XML_ARRAY2XML_FORMAT is used
  *
  * @package Automne
  * @subpackage pageContent
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_array2Xml extends CMS_grandFather {
	protected $_doc;
	
	function __construct($array, $tag) {
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
	
	protected function _2xml($array) {
		$xml="";
		foreach ($array as $key => $value) {
			if ($value !== '') {
				if (is_array($value)) {
					$value = $this->_2xml($value);
				} elseif (is_numeric($value)) {
					$value = $value;
				} elseif (is_bool($value)) {
					$value = (int) $value;
				} else {
					$value = '<![CDATA['.$value.']]>';
				}
				if (!is_numeric($key)) {
					$xml .= "<$key>".$value."</$key>";
				} else {
					$xml .= "<value key=\"$key\">".$value."</value>";
				}
			} else {
				if (!is_numeric($key)) {
					$xml .= "<$key />";
				} else {
					$xml .= "<value key=\"$key\" />";
				}
			}
		}
		return $xml;
	}
}
?>