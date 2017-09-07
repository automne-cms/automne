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

//for this page, HTML output compression is not welcome.
define("ENABLE_HTML_COMPRESSION", false);
//load requirements (FE only because it can be used in FE and BO)
require_once(dirname(__FILE__).'/../../cms_rc_frontend.php');

// Prevent the browser from caching the result.
// Date in the past
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
// always modified
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
// HTTP/1.1
header('Cache-Control: no-store, no-cache, must-revalidate') ;
header('Cache-Control: post-check=0, pre-check=0', false) ;
// HTTP/1.0
header('Pragma: no-cache') ;
//send document UTF-8 BOM (do not remove)
header('Content-type: text/javascript; charset=UTF-8');
$content = '﻿
CKEDITOR.addTemplates( \'default\',
{
	imagesPath:CKEDITOR.getUrl(CKEDITOR.plugins.getPath(\'templates\')+\'templates/images/\'),
	// The templates definitions.
	templates :';


//append XML templates
$filename = PATH_CSS_FS.'/editortemplates.xml';
if (file_exists($filename)) {
	$source = file_get_contents($filename);
	$file = new DOMDocument('1.0', APPLICATION_DEFAULT_ENCODING);
	$file->loadXml($source, $options);
	$tplsTags = $file->getElementsByTagName('Template');
	$tpls = array();
	foreach ($tplsTags as $tplTag) {
		$tpl = new stdClass;
		$tpl->title = $tplTag->getAttribute("title");
		$descTags = $tplTag->getElementsByTagName('Description');
		if ($descTags->length) {
			foreach ($descTags as $descTag) {
				$tpl->description = $descTag->nodeValue;
			}
		}
		$htmlTags = $tplTag->getElementsByTagName('Html');
		if ($htmlTags->length) {
			foreach ($htmlTags as $htmlTag) {
				$tpl->html = $htmlTag->nodeValue;
			}
		}
		
		$tpls[] = $tpl;
	}
	$content .= io::jsonEncode($tpls);
}

$content .= '});';
echo $content;
?>