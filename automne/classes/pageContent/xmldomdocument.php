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
// $Id: xmldomdocument.php,v 1.9 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_DOMDocument
  *
  * implement PHP class DOMDOcument. Allow usage of exceptions by load and loadXML method
  *
  * @package CMS
  * @subpackage page content
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_DOMDocument extends DOMDocument {
	public function __construct($version = '1.0', $encoding = APPLICATION_DEFAULT_ENCODING) {
		parent::__construct($version, $encoding);
	}
	
	public function loadXML($source, $options = 0, $appendEncoding = true) {
		//convert source encoding if needed
		if (io::isUTF8($source)) {
			if (io::strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
				$source = utf8_decode($source);
			}
		} else {
			if (io::strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8') {
				$source = utf8_encode($source);
			}
		}
		//append xml encoding and DTD if needed
		if ($appendEncoding) {
			$doctype = !APPLICATION_IS_WINDOWS ? '<!DOCTYPE automne SYSTEM "'.PATH_PACKAGES_FS.'/files/xhtml.ent">' : '<!DOCTYPE automne ['.file_get_contents(PATH_PACKAGES_FS.'/files/xhtml.ent').']>';
			$source = '<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>
			'.$doctype.'
			'.$source;
			$options = ($options) ? $options | LIBXML_DTDLOAD : LIBXML_DTDLOAD;
		}
		set_error_handler (array('CMS_DOMDocument','XmlError'));
		$return = parent::loadXml($source, $options);
		restore_error_handler();
		return $return;
	}
	
	function XmlError($errno, $errstr, $errfile, $errline) {
		if ($errno==E_WARNING && (substr_count($errstr,"DOMDocument::loadXML()")>0)) {
			$error = io::substr($errstr, io::strlen('DOMDocument::loadXML() [<a href=\'function.DOMDocument-loadXML\'>function.DOMDocument-loadXML</a>]: '));
			throw new DOMException($error, 1);
		} else {
			return false;
		}
	}
	
	public function DOMElementToString($domelement, $contentOnly = false) {
		if (!is_a($domelement, "DOMElement")) {
			CMS_grandFather::raiseError('Domelement is not a DOMElement instance');
			return false;
		}
		static $autoClosedTagsList;
		if (!$autoClosedTagsList) {
			$xml2Array = new CMS_xml2Array();
			$tagsList = $xml2Array->getAutoClosedTagsList();
			$autoClosedTagsList = implode($tagsList, '|');
		}
		$output = '';
		if ($contentOnly) {
			$output = '';
			foreach ($domelement->childNodes as $node) {
				$output .= $node->ownerDocument->saveXML($node, LIBXML_NOEMPTYTAG);
			}
		} else {
			$output = $domNode->ownerDocument->saveXML($domNode, LIBXML_NOEMPTYTAG);
		}
		//convert output encoding if needed
		if (io::isUTF8($output)) {
			if (io::strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
				$output = utf8_decode($output);
			}
		} else {
			if (io::strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8') {
				$output = utf8_encode($output);
			}
		}
		//replace tags like <br></br> by auto closed tags and strip cariage return arround entities
		$output = preg_replace(array('#\n(&[a-z]+;)\n#U', '#<('.$autoClosedTagsList.')([^>]*)></\1>#U'), array('\1', '<\1\2/>'), $output);
		return $output;
	}
}
?>