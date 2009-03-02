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
// $Id: readStandardParam.php,v 1.2 2009/03/02 11:28:31 sebastien Exp $

/**
  *function needed to easylly read the standard_rc.xml file
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

$filename = PATH_MODULES_FS.'/standard_rc.xml';
if (file_exists($filename)) {
	$source = file_get_contents($filename);
	$doctype = !APPLICATION_IS_WINDOWS ? '<!DOCTYPE automne SYSTEM "'.PATH_PACKAGES_FS.'/files/xhtml.ent">' : '<!DOCTYPE automne ['.file_get_contents(PATH_PACKAGES_FS.'/files/xhtml.ent').']>';
	$source = '<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>
	'.$doctype.'
	'.$source;
	$options = LIBXML_DTDLOAD;
	$file = new DOMDocument('1.0', APPLICATION_DEFAULT_ENCODING);
	$file->loadXml($source, $options);
	$paramTags = $file->getElementsByTagName('param');
	foreach ($paramTags as $paramTag) {
		$parameters[$paramTag->getAttribute("name")] = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? utf8_decode(trim($paramTag->nodeValue)) : trim($paramTag->nodeValue);
	}
} else {
	print_r('<pre>'.basename(__FILE__).' : malformed definition file : '.PATH_MODULES_FS.'/standard_rc.xml</pre>');
	//file unreadable, initialize parameters with empty array
	$parameters = array();
}
foreach ($parameters as $paramName => $paramValue) {
	if (!defined($paramName)) {
		define($paramName, ($paramValue === '0') ? false : (($paramValue === '1') ? true : $paramValue));
	}
}
?>