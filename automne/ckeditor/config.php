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
$content = 'ï»¿
CKEDITOR.editorConfig = function( config )
{
	config.uiColor = \'#D6DCDF\';
	config.disableObjectResizing = true;'."\n";
	if (file_exists(PATH_CSS_FS.'/editor.css')) {
		$content .= 'config.contentsCss = [\''.PATH_MAIN_WR.'/ckeditor/contents.css\', \''.PATH_CSS_WR.'/editor.css\'];'."\n";
	} else {
		$content .= 'config.contentsCss = \''.PATH_MAIN_WR.'/ckeditor/contents.css\';'."\n";
	}
	$content .= '
	config.baseHref = \''.PATH_REALROOT_WR.'/\';
	config.extraPlugins = \'automneLinks,polymod\';
	
	config.entities = '.(strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8' ? 'false' : 'true').';
	config.entities_processNumerical = '.(strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8' ? 'false' : 'true').';
	
	var toolbarSets = {};
	//set default toolbar
	toolbarSets["Default"] = [[\'Source\'],[\'ShowBlocks\'],[\'Preview\',\'Templates\'],[\'Cut\',\'Copy\',\'Paste\',\'PasteText\',\'PasteFromWord\'],[\'Print\'],[\'Undo\',\'Redo\'],[\'Find\',\'Replace\'],[\'SelectAll\',\'RemoveFormat\'],[\'Bold\',\'Italic\',\'Underline\',\'Strike\'],[\'Subscript\',\'Superscript\'],[\'NumberedList\',\'BulletedList\'],[\'Outdent\',\'Indent\'],[\'JustifyLeft\',\'JustifyCenter\',\'JustifyRight\',\'JustifyBlock\'],[\'Link\',\'Unlink\',\'Anchor\'],[\'Table\',\'SpecialChar\'],[\'Styles\', \'Format\',\'FontSize\'],[\'TextColor\',\'BGColor\'],[\'automneLinks\',\'polymod\']];
	';
	//get all modules toolbars
	$modulesCodes = new CMS_modulesCodes();
	$modulesCodeInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_EDITOR_CODE, '', new CMS_date(), array("editor" => "ckeditor", "toolbar" => "Default|Basic|BasicLink", "user" => $cms_user));
	if (isset($modulesCodeInclude["ToolbarSets"])) {
		$content .= implode("\n\n",$modulesCodeInclude["ToolbarSets"]);
	}
	
	//get all defined toolbars
	$toolbars = CMS_wysiwyg_toolbar::getAll($cms_user);
	foreach ($toolbars as $toolbar) {
		$content .= $toolbar->getDefinition();
	}
	if (io::request('toolbar')) {
		$content .= 'config.toolbar = typeof toolbarSets[\''.io::request('toolbar').'\'] == \'undefined\' ? toolbarSets[\'Default\'] : toolbarSets[\''.io::request('toolbar').'\'];'."\n";
	} else {
		$content .= 'config.toolbar = toolbarSets[\'Default\'];'."\n";
	}
	//append XML styles
	$filename = PATH_CSS_FS.'/editorstyles.xml';
	if (file_exists($filename)) {
		$source = file_get_contents($filename);
		$file = new DOMDocument('1.0', APPLICATION_DEFAULT_ENCODING);
		$file->loadXml($source, $options);
		$stylesTags = $file->getElementsByTagName('Style');
		$styles = array();
		foreach ($stylesTags as $styleTag) {
			$style = new stdClass;
			$style->name = $styleTag->getAttribute("name");
			$style->element = $styleTag->getAttribute("element");
			$attrTags = $styleTag->getElementsByTagName('Attribute');
			if ($attrTags->length) {
				$style->attributes = new stdClass;
				foreach ($attrTags as $attrTag) {
					$name = $attrTag->getAttribute("name");
					$style->attributes->{$name} = $attrTag->getAttribute("value");
				}
			}
			$styles[] = $style;
		}
		$content .= 'config.stylesSet = '.io::jsonEncode($styles).';'."\n";
	}
	$content .='config.allowedContent = true;';
	$content .= '
	config.templates_files = [\''.PATH_MAIN_WR.'/ckeditor/templates.php\'];
	config.menu_groups = \'clipboard,tablecell,tablecellproperties,tablerow,tablecolumn,table,anchor,link,automneLinks,editPlugin\';
};
';
echo $content;