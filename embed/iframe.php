<?php
define("ENABLE_HTTP_COMPRESSION",false);
require_once(dirname(__FILE__).'/../cms_rc_frontend.php');

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


$htmlDefinition = $oembedDefinition->getHtml();

$module = CMS_poly_object_catalog::getModuleCodenameForObjectType($oembedDefinition->getObjectdefinition());

$polymodModule = CMS_modulesCatalog::getByCodename($module);

$transformedDefinition = $polymodModule->convertDefinitionString($htmlDefinition, false);

$parameters = array();
$parameters['module'] = CMS_poly_object_catalog::getModuleCodenameForObjectType($oembedDefinition->getObjectdefinition());
$parameters['objectID'] = $oembedDefinition->getObjectdefinition();
$parameters['public'] = true;
$parameters['cache'] = false;
$definitionParsing = new CMS_polymod_definition_parsing($transformedDefinition, true, CMS_polymod_definition_parsing::PARSE_MODE, $parameters['module']);
$compiledDefinition = $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_PHP, $parameters);

$urlParts = parse_url($url);
if(!isset($urlParts['query'])) {
	die("Incorrect parameters");
}
parse_str($urlParts['query']);

$parameterName = $oembedDefinition->getParameter();

$embededObject = CMS_poly_object_catalog::getObjectByID($$parameterName, false,true);
if(!$embededObject) {
	die("Incorrect parameters");
}

// get label
ob_start();
eval(sensitiveIO::stripPHPTags($compiledDefinition));
$data = ob_get_contents();
ob_end_clean();
/*
$html = array(
	'html' => $data,
	'title' => $embededObject->getLabel(),
	'height' => io::get('height'),
	'width' => io::get('width'),
);

$oembed = CMS_polymod_oembed_definition::getResults($html);
*/
echo '<html>
<head>
	<title>'.$embededObject->getLabel().'</title>
	<style>
		body {
			margin:		0px;
			padding:	0px;
		}
	</style>
</head>
<body>
'.$data.'
</body>
</html>';