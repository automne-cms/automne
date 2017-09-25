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
//
// $Id: xmldomdocument.php,v 1.9 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_DOMDocument
  *
  * implement PHP class DOMDOcument. Allow usage of exceptions by load and loadXML method
  *
  * @package Automne
  * @subpackage pageContent
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_DOMDocument extends DOMDocument {
	public function __construct($version = '1.0', $encoding = APPLICATION_DEFAULT_ENCODING) {
		parent::__construct($version, $encoding);
	}
	
	public function loadXML($source, $options = 0, $appendEncoding = true, $appendDTD = true) {
		//append xml encoding and DTD if needed
		if ($appendEncoding) {
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
			if ($appendDTD) {
				$options = ($options) ? $options | LIBXML_DTDLOAD : LIBXML_DTDLOAD;
				$doctype = !APPLICATION_IS_WINDOWS ? '<!DOCTYPE automne SYSTEM "'.PATH_PACKAGES_FS.'/files/xhtml.ent">' : '<!DOCTYPE automne ['.file_get_contents(PATH_PACKAGES_FS.'/files/xhtml.ent').']>';
			}
			$source = '<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>
			'.($appendDTD ? $doctype : '').'
			'.$source;
		}
		set_error_handler (array('CMS_DOMDocument','XmlError'));
		$return = parent::loadXml($source, $options);
		restore_error_handler();
		return $return;
	}
	
	public static function XmlError($errno, $errstr, $errfile, $errline) {
		if ($errno==E_WARNING && (substr_count($errstr,"DOMDocument::loadXML()")>0)) {
			$error = str_replace('[<a href=\'domdocument.loadxml\'>domdocument.loadxml</a>]', '', $errstr);
			//log error
			CMS_grandFather::raiseError($error);
			//throw exception to inform user of the error
			throw new DOMException($error, 1);
		} else {
			return false;
		}
	}
	
	public static function DOMElementToString($domelement, $contentOnly = false) {
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
		//to correct a bug in libXML < 2.6.27
		if (LIBXML_VERSION < 20627 && strpos($output, '&#x') !== false) {
			$output = preg_replace_callback('/(&#x[0-9A-Z]+;)/U', create_function('$matches', 'return io::decodeEntities($matches[0]);'), $output);
		}
		
		//replace tags like <br></br> by auto closed tags and strip cariage return arround entities
		$output = preg_replace(array('#\n(&[a-z]+;)\n#U', '#<('.$autoClosedTagsList.')([^>]*)></\1>#U'), array('\1', '<\1\2/>'), $output);
		return $output;
	}
}
?>