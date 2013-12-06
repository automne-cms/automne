<?php
define("ENABLE_HTTP_COMPRESSION",false);
require_once(dirname(__FILE__).'/cms_rc_frontend.php');
CMS_grandFather::log("call");

$url = urldecode(io::get('url'));
$format = io::get('format');

$page = CMS_tree::analyseURL($url);
if(!$page) {
	die("Incorrect parameters");
}

$oembedDefinition = CMS_polymod_oembed_definition_catalog::getByCodename($page->getCodename());
if(!$oembedDefinition) {
	die("Incorrect parameters");
}

if (!isset($cms_language)) {
	$pageLang = $page->getLanguage(true);
	$cms_language = new CMS_language($pageLang);
}

define('CURRENT_PAGE', $page->getID());

$definition = '';

if($format === 'json') {
	$definition = $oembedDefinition->getJson();
}
elseif ($format === 'xml') {
	$definition = $oembedDefinition->getXml();
}

$module = CMS_poly_object_catalog::getModuleCodenameForObjectType($oembedDefinition->getObjectdefinition());

$polymodModule = CMS_modulesCatalog::getByCodename($module);

$transformedDefinition = $polymodModule->convertDefinitionString($definition, false);

$parameters = array();
$parameters['module'] = CMS_poly_object_catalog::getModuleCodenameForObjectType($oembedDefinition->getObjectdefinition());
$parameters['objectID'] = $oembedDefinition->getObjectdefinition();
$parameters['public'] = true;
$parameters['cache'] = false;
$definitionParsing = new CMS_polymod_definition_parsing($transformedDefinition, true, CMS_polymod_definition_parsing::PARSE_MODE, $parameters['module']);
$compiledDefinition = $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_PHP, $parameters);

$item = 4;
ob_start();
eval(sensitiveIO::stripPHPTags($compiledDefinition));
$data = ob_get_contents();
ob_end_clean();

$html = array(
	'html' => $data
);

$oembed = CMS_polymod_oembed_definition::getResults($html);
if($format === 'json') {
	print json_encode($oembed, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
}
elseif ($format === 'xml') {
	$output = "<?xml version=\"1.0\" encoding=\"utf-8\">\n";
  $output .= "<oembed>\n";
  $output .= CMS_polymod_oembed_definition::format_xml_elements($oembed);
  //$array2xml = new CMS_array2Xml($oembed,'oembed');
  //$output .= $array2xml->getXMLString();
  $output .= "</oembed>";
  print $output;

}