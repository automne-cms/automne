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
// $Id: cms_forms.php,v 1.2 2009/02/03 14:27:04 sebastien Exp $

/**
  * Codename of the module
  */
define("MOD_CMS_FORMS_CODENAME", "cms_forms");


/**
  * Messages
  */
define("MESSAGE_MOD_CMS_FORMS_ROWS_EXPLANATION", 85);
define("MESSAGE_MOD_CMS_FORMS_TEMPLATE_EXPLANATION", 86);
define('MESSAGE_MOD_CMS_FORMS_PLUGIN', 87);

/**
  * Class CMS_module_cms_forms
  *
  * represent the PDF Forms module.
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_module_cms_forms extends CMS_moduleValidation
{
	/**
	  * Gets a form by its internal ID
	  *
	  * @param integer $ID The DB ID
	  * @return CMS_forms_formular
	  * @access public
	  */
	function getResourceByID($ID) {
		return new CMS_forms_formular($ID);
	}
	
	/** 
	  * Get the default language code for this module
	  * Comes from parameters or Constant
	  * Upgrades constant with parameter founded
	  *
	  * @return String the language codename
	  * @access public
	  */
	function getDefaultLanguageCodename() {
		if ($this->hasParameters() && $s = $this->getParameters("default_language")) {
			return $s;
		} else {
			return "en";
		}
	}
	
	/** 
	  * Get the tags to be treated by this module for the specified treatment mode, visualization mode and object.
	  * @param integer $treatmentMode The current treatment mode (see constants on top of CMS_modulesTags class for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @return array of tags to be treated.
	  * @access public
	  */
	function getWantedTags($treatmentMode, $visualizationMode) 
	{
		$return = array();
		switch ($treatmentMode) {
			case MODULE_TREATMENT_CLIENTSPACE_TAGS :
				$return = array (
					"atm-clientspace" => array("selfClosed" => true, "parameters" => array("module" => MOD_CMS_FORMS_CODENAME)),
				);
			break;
			case MODULE_TREATMENT_BLOCK_TAGS :
				//Call module clientspace content
				$return = array (
					"block" => array("selfClosed" => false, "parameters" => array("module" => MOD_CMS_FORMS_CODENAME)),
				);
			break;
			case MODULE_TREATMENT_PAGECONTENT_TAGS :
				//Add module CSS after atm-meta-tags content
				$return = array (
					"atm-meta-tags" => array("selfClosed" => true, "parameters" => array()),
				);
			break;
		}
		return $return;
	}
	
	/** 
	  * Treat given content tag by this module for the specified treatment mode, visualization mode and object.
	  *
	  * @param string $tag The CMS_XMLTag.
 	  * @param string $tagContent previous tag content.
	  * @param integer $treatmentMode The current treatment mode (see constants on top of CMS_modulesTags class for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  * @return string the tag content treated.
	  * @access public
	  */
	function treatWantedTag(&$tag, $tagContent, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters)
	{
		switch ($treatmentMode) {
			case MODULE_TREATMENT_CLIENTSPACE_TAGS:
				if (!is_a($treatedObject,"CMS_pageTemplate")) {
					$this->raiseError('$treatedObject must be a CMS_pageTemplate object');
					return false;
				}
				if (!is_a($treatmentParameters["page"],"CMS_page")) {
					$this->raiseError('$treatmentParameters["page"] must be a CMS_page object');
					return false;
				}
				if (!is_a($treatmentParameters["language"],"CMS_language")) {
					$this->raiseError('$treatmentParameters["language"] must be a CMS_language object');
					return false;
				}
				if (!sensitiveIO::IsPositiveInteger($tag->getAttribute('formID'))) {
					$this->raiseError('Attribute formID must be a positive integer');
					return false;
				}
				//call cms_forms clientspace content
				$cs = new CMS_moduleClientspace($tag->getAttributes());
				$html = $cs->getClientspaceData(MOD_CMS_FORMS_CODENAME, new CMS_date(), $treatmentParameters["page"], $visualizationMode);
				if ($visualizationMode != PAGE_VISUALMODE_PRINT) {
					//save in global var the page ID who need this module so we can add the header module code later.
					$GLOBALS[MOD_CMS_FORMS_CODENAME]["pageUseModule"][$treatmentParameters["page"]->getID()][] = $tag->getAttribute('formID');
				}
				return $html;
			break;
			case MODULE_TREATMENT_BLOCK_TAGS:
				if (!is_a($treatedObject,"CMS_row")) {
					$this->raiseError('$treatedObject must be a CMS_row object');
					return false;
				}
				if (!is_a($treatmentParameters["page"],"CMS_page")) {
					$this->raiseError('$treatmentParameters["page"] must be a CMS_page object');
					return false;
				}
				if (!is_a($treatmentParameters["language"],"CMS_language")) {
					$this->raiseError('$treatmentParameters["language"] must be a CMS_language object');
					return false;
				}
				if (!is_a($treatmentParameters["clientSpace"],"CMS_moduleClientspace")) {
					$this->raiseError('$treatmentParameters["clientSpace"] must be a CMS_moduleClientspace object');
					return false;
				}
				//create the block data
				$block = $tag->getRepresentationInstance();
				return $block->getData($treatmentParameters["language"], $treatmentParameters["page"], $treatmentParameters["clientSpace"], $treatedObject, $visualizationMode);
			break;
			case MODULE_TREATMENT_PAGECONTENT_TAGS :
				if (!is_a($treatedObject,"CMS_page")) {
					$this->raiseError('$treatedObject must be a CMS_page object');
					return false;
				}
				//Add module CSS after atm-meta-tags content
				if (!$tagContent) {
					$tagContent = $tag->getContent();
				}
				if (isset($GLOBALS[MOD_CMS_FORMS_CODENAME]["pageUseModule"][$treatedObject->getID()]) && sizeof($GLOBALS[MOD_CMS_FORMS_CODENAME]["pageUseModule"][$treatedObject->getID()])) {
					$tagContent .= 
					'	<!-- load the style of '.MOD_CMS_FORMS_CODENAME.' module -->'."\n".
					'	<link rel="stylesheet" type="text/css" href="/css/modules/'.MOD_CMS_FORMS_CODENAME.'.css" />'."\n";
				}
				return $tagContent;
			break;
		}
		return $tag->getContent();
	}
	
	/**
	  * Gets a tag representation instance
	  *
	  * @param CMS_XMLTag $tag The xml tag from which to build the representation
	  * @param array(mixed) $args The arguments needed to build
	  * @return object The module tag representation instance
	  * @access public
	  */
	function getTagRepresentation($tag, $args)
	{
		switch ($tag->getName()) {
		case "block":
			//try to guess the class to instanciate
			$class_name = "CMS_block_cms_forms";
			if (class_exists($class_name)) {
				$instance = new $class_name();
			} else {
				$this->raiseError("Unknown block type : CMS_block_cms_forms");
				return false;
			}
			$instance->initializeFromTag($tag->getAttributes(), $tag->getInnerContent());
			return $instance;
			break;
		case "atm-clientspace":
			if ($tag->getAttribute("type")) {
				$instance = new CMS_moduleClientspace($tag->getAttributes());
				return $instance;
			} else {
				return false;
			}
			break;
		}
	}
	
	/**
	  * Return the module code for the specified treatment mode, visualization mode and object.
	  * 
	  * @param mixed $modulesCode the previous modules codes (usually string)
	  * @param integer $treatmentMode The current treatment mode (see constants on top of this file for accepted values).
	  * @param integer $visualizationMode The current visualization mode (see constants on top of cms_page class for accepted values).
	  * @param object $treatedObject The reference object to treat.
	  * @param array $treatmentParameters : optionnal parameters used for the treatment. Usually an array of objects.
	  *
	  * @return string : the module code to add
	  * @access public
	  */
	function getModuleCode($modulesCode, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters)
	{
		switch ($treatmentMode) {
			case MODULE_TREATMENT_EDITOR_CODE :
				if ($treatmentParameters["editor"] == "fckeditor") {
					$languages = implode(',',array_keys(CMS_languagesCatalog::getAllLanguages(MOD_CMS_FORMS_CODENAME)));
					//This is an exception of the method, because here we return an array, see admin/fckeditor/fckconfig.php for the detail
					
					// add cms_form wizard
					$modulesCode["modulesDeclaration"][] = "FCKConfig.Plugins.Add( 'cms_forms', '".$languages."' );";
					// create specific cms_form toolbar
					$modulesCode["ToolbarSets"][] = 
							"FCKConfig.ToolbarSets['cms_forms'] = [
								['Source','-','Preview'],//['Source','DocProps','-','Save','NewPage','Preview','-','Templates'],
								['Cut','Copy','Paste','PasteText','PasteWord','-','Print'], //'SpellCheck'],
								['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
								['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
								['OrderedList','UnorderedList','-','Outdent','Indent'],
								['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
								['Link','Unlink','Anchor'],
								['Table','Rule','SpecialChar'],//['Image','Flash','Table','Rule','Smiley','SpecialChar','UniversalKey'],
								['Style','FontFormat','FontSize'],//['Style','FontFormat','FontName','FontSize'],
								['TextColor','BGColor'],//
								//'/',
								['cms_forms']//,'Checkbox','Radio','TextField','Textarea','Select','Button','HiddenField']
							];";
					return $modulesCode;
				} else {
					return $modulesCode;
				}
			break;
			case MODULE_TREATMENT_PAGECONTENT_HEADER_CODE :
				//if this page use a row of this module then add the header code to the page (see CMS_block_cms_forms::getData for GLOBAL var creation)
				if ($visualizationMode != PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE && isset($treatedObject) && isset($GLOBALS[MOD_CMS_FORMS_CODENAME]["pageUseModule"][$treatedObject->getID()])) {
					//call clientspace header content
					$cs = new CMS_moduleClientspace(array("module" => MOD_CMS_FORMS_CODENAME,  "id" => "cms_forms_header", "type" => "header", "usedforms" => $GLOBALS[MOD_CMS_FORMS_CODENAME]["pageUseModule"][$treatedObject->getID()]));
					$modulesCode[MOD_CMS_FORMS_CODENAME] = $cs->getClientspaceData(MOD_CMS_FORMS_CODENAME, new CMS_date(), $treatedObject, $visualizationMode);
					return $modulesCode;
				} else {
					return $modulesCode;
				}
			break;
			/*case MODULE_TREATMENT_EDITOR_PLUGINS:
				if ($treatmentParameters["editor"] == "fckeditor") {
					$language = $treatmentParameters["user"]->getLanguage();
					$modulesCode[MOD_CMS_FORMS_CODENAME] = $language->getMessage(MESSAGE_MOD_CMS_FORMS_PLUGIN, false, MOD_CMS_FORMS_CODENAME);
				}
			break;*/
			case MODULE_TREATMENT_ROWS_EDITION_LABELS :
				$modulesCode[MOD_CMS_FORMS_CODENAME] = $treatmentParameters["language"]->getMessage(MESSAGE_MOD_CMS_FORMS_ROWS_EXPLANATION, false, MOD_CMS_FORMS_CODENAME);
				return $modulesCode;
			break;
			case MODULE_TREATMENT_TEMPLATES_EDITION_LABELS :
				$modulesCode[MOD_CMS_FORMS_CODENAME] = $treatmentParameters["language"]->getMessage(MESSAGE_MOD_CMS_FORMS_TEMPLATE_EXPLANATION, false, MOD_CMS_FORMS_CODENAME);
				return $modulesCode;
			break;
		}
		return $modulesCode;
	}
	
	/**
	  * Module autoload handler
	  *
	  * @param string $classname the classname required for loading
	  * @return string : the file to use for required classname
	  * @access public
	  */
	function load($classname) {
		static $classes;
		if (!isset($classes)) {
			$classes = array(
				/**
				 * Module main classes
				 */
				'cms_forms_action' 				=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/action.php",
				'cms_forms_record' 				=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/record.php",
				'cms_forms_field' 				=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/field.php",
				'cms_forms_formular' 			=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/form.php",
				'cms_forms_search' 				=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/formssearch.php",
				'cms_forms_formularcategories' 	=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/formcategories.php",
				'cms_forms_sender' 				=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/sender.php",
				'cms_forms_sendingssearch' 		=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/sendingssearch.php",
				'cms_block_cms_forms' 			=> PATH_MODULES_FS."/".MOD_CMS_FORMS_CODENAME."/block.php",
			);
		}
		$file = '';
		if (isset($classes[strtolower($classname)])) {
			$file = $classes[strtolower($classname)];
		}
		return $file;
	}
}
?>