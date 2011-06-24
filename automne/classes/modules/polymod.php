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
// $Id: polymod.php,v 1.14 2010/03/08 16:43:31 sebastien Exp $

/**
  * Class CMS_polymod
  *
  * Represent a poly module.
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Polymod Codename
if (!defined('MOD_POLYMOD_CODENAME')) {
	define("MOD_POLYMOD_CODENAME", "polymod");
}

class CMS_polymod extends CMS_modulePolymodValidation
{
	/**
	  * Standard Messages
	  */
	const MESSAGE_PAGE_WORKING_TAGS = 1704;
	const MESSAGE_PAGE_WORKING_TAGS_EXPLANATION = 1703;
	const MESSAGE_PAGE_BLOCK_GENERAL_VARS = 1706;
	const MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION = 1705;
	
	/**
	  * Polymod Messages
	  */
	const MESSAGE_PAGE_ROW_TAGS_EXPLANATION = 111;
	const MESSAGE_PAGE_ROW_OBJECTS_VARS_EXPLANATION = 112;
	const MESSAGE_PAGE_SEARCH_TAGS = 109;
	const MESSAGE_PAGE_SEARCH_TAGS_EXPLANATION = 110;
	const MESSAGE_PAGE_WORKING_POLYMOD_TAGS = 113;
	const MESSAGE_PAGE_WORKING_POLYMOD_TAGS_EXPLANATION = 114;
	const MESSAGE_PAGE_BLOCK_TAGS = 115;
	const MESSAGE_PAGE_BLOCK_TAGS_EXPLANATION = 116;
	const MESSAGE_PAGE_BLOCK_FORMS = 382;
	const MESSAGE_PAGE_BLOCK_FORMS_EXPLANATION = 383;
	const MESSAGE_PAGE_CATEGORIES_USED = 500;
	const MESSAGE_ALERT_LEVEL_VALIDATION = 514;
	const MESSAGE_ALERT_LEVEL_VALIDATION_DESCRIPTION = 513;
	const MESSAGE_PAGE_RSS_TAG_EXPLANATION = 313;
	const MESSAGE_PAGE_ROW_TAGS_CHOOSE = 519;
	
	/**
	  * Gets resource by its internal ID (not the resource table DB ID)
	  * This function need to stay here because sometimes it is directly queried
	  *
	  * @param integer $resourceID The DB ID of the resource in the module table(s)
	  * @return CMS_resource The CMS_resource subclassed object
	  * @access public
	  */
	function getResourceByID($resourceID)
	{
		//parent::getResourceByID($resourceID);
		return CMS_poly_object_catalog::getObjectByID($resourceID);
	}

	/**
	  * Get all poly objects for current poly module
	  *
	  * @return array(CMS_poly_object_definition)
	  * @access public
	  */
	function getObjects() {
		return CMS_poly_object_catalog::getObjectsForModule($this->_codename);
	}
	
	/**
	  * Gets module ressource name method (method to get the name of resource objects of the module)
	  *
	  * @return string : the method name to get objects label
	  * @access public
	  */
	function getRessourceNameMethod() {
		return 'getLabel';
	}
	
	/**
	  * Gets module ressource type method (method to get the type of resource objects of the module)
	  *
	  * @return string : the method type to get objects type label
	  * @access public
	  */
	function getRessourceTypeLabelMethod() {
		return 'getTypeLabel';
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
		$return = parent::getWantedTags($treatmentMode, $visualizationMode);
		switch ($treatmentMode) {
			case MODULE_TREATMENT_PAGECONTENT_TAGS :
				//get all plugins IDs for this module
				$pluginsIDs = CMS_poly_object_catalog::getAllPluginDefIDForModule($this->_codename);
				if (is_array($pluginsIDs) && $pluginsIDs) {
					$return["span"] = array("selfClosed" => false, "parameters" => array('id' => 'polymod-('.implode('|',$pluginsIDs).')-(.*)'));
				}
				$return["atm-if"] 			= array("selfClosed" => false,	"parameters" => array(), 'class' => 'CMS_XMLTag_if');
				$return["atm-else"] 		= array("selfClosed" => false,	"parameters" => array(), 'class' => 'CMS_XMLTag_else');
				$return["atm-start-tag"] 	= array("selfClosed" => true,	"parameters" => array(), 'class' => 'CMS_XMLTag_start');
				$return["atm-end-tag"] 		= array("selfClosed" => true,	"parameters" => array(), 'class' => 'CMS_XMLTag_end');
				$return["atm-setvar"] 		= array("selfClosed" => true,	"parameters" => array(), 'class' => 'CMS_XMLTag_setvar');
				
			break;
			case MODULE_TREATMENT_WYSIWYG_OUTER_TAGS :
			case MODULE_TREATMENT_WYSIWYG_INNER_TAGS :
				//get all plugins IDs for this module
				$pluginsIDs = CMS_poly_object_catalog::getAllPluginDefIDForModule($this->_codename);
				if (is_array($pluginsIDs) && $pluginsIDs) {
					$return = array (
						"span" => array("selfClosed" => false, "parameters" => array('id' => 'polymod-('.implode('|',$pluginsIDs).')-(.*)')),
					);
				}
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
			case MODULE_TREATMENT_BLOCK_TAGS:
				return parent::treatWantedTag($tag, $tagContent, $treatmentMode, $visualizationMode, $treatedObject, $treatmentParameters);
			break;
			case MODULE_TREATMENT_CLIENTSPACE_TAGS:
				return parent::treatWantedTag($tag, $tagContent, $treatmentMode, $visualizationMode, $treatedObject, $treatmentParameters);
			break;
			case MODULE_TREATMENT_PAGECONTENT_TAGS :
				if (!($treatedObject instanceof CMS_page)) {
					$this->raiseError('$treatedObject must be a CMS_page object');
					return false;
				}
				switch ($tag->getName()) {
					case "span":
						$ids = explode('-', $tag->getAttribute('id'));
						$selectedPluginID = (int) $ids[1];
						$selectedItem = (int) $ids[2];
						//then create the code to paste for the current selected object if any
						if (sensitiveIO::isPositiveInteger($selectedItem) && sensitiveIO::isPositiveInteger($selectedPluginID)) {
							//get plugin
							$selectedPlugin = new CMS_poly_plugin_definitions($selectedPluginID);
							//get plugin definition
							$definition = $selectedPlugin->getValue('compiledDefinition');
							//set parsing parameters
							$parameters = array();
							$parameters['itemID'] = $selectedItem;
							$parameters['pageID'] = $treatedObject->getID();
							$parameters['public'] = ($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC || $visualizationMode == PAGE_VISUALMODE_PRINT || $visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE) ? true : false;
							//get originaly selected text
							if (!$selectedPlugin->needSelection()) {
								$parameters['selection'] = '';
							} else {
								$hasSelection = preg_match('#<!--(.*)-->#s', $tag->getInnerContent(), $matches);
								$parameters['selection'] = io::decodeEntities($hasSelection ? $matches[1] : $tag->getInnerContent());
								//$parameters['selection'] = io::decodeEntities($tag->getInnerContent());
							}
							$tagContent =
							'<?php $parameters = '.var_export($parameters, true).';'."\n".
							io::substr($definition,5);
							//save in global var the page ID who need this module so we can add the header code later.
							CMS_module::moduleUsage($treatedObject->getID(), $this->_codename, array('block' => true));
							//Cache management
							if ($parameters['public']) {
								//create definition hash
								$cacheHash = md5(serialize(array(
									'definition' => $tagContent, 
									'parameters' => $parameters,
								)));
								$tagContent = CMS_cache::wrapCode($cacheHash, $tagContent);
							}
						}
						return $tagContent;
					break;
				}
			break;
			case MODULE_TREATMENT_PAGEHEADER_TAGS :
				return parent::treatWantedTag($tag, $tagContent, $treatmentMode, $visualizationMode, $treatedObject, $treatmentParameters);
			break;
			case MODULE_TREATMENT_WYSIWYG_INNER_TAGS :
				switch ($tag->getName()) {
					case "span":
						global $cms_language;
						$ids = explode('-', $tag->getAttribute('id'));
						$selectedPluginID = (int) $ids[1];
						$selectedItem = (int) $ids[2];
						//then create the code to paste for the current selected object if any
						if (sensitiveIO::isPositiveInteger($selectedItem) && sensitiveIO::isPositiveInteger($selectedPluginID)) {
							//get plugin
							$selectedPlugin = new CMS_poly_plugin_definitions($selectedPluginID);
							//get selected item
							$item = CMS_poly_object_catalog::getObjectByID($selectedItem, false, ($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC || $visualizationMode == PAGE_VISUALMODE_PRINT || $visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE) ? true : false);
							if ($item && !$item->hasError()) {
								//get originaly selected text if any
								$selectedText = '';
								if ($selectedPlugin->needSelection()) {
									$hasSelection = preg_match('#<!--(.*)-->#s', $tag->getInnerContent(), $matches);
									$selectedText = $hasSelection ? $matches[1] : $tag->getInnerContent();
									$tagContent = '<span id="polymod-'.$selectedPluginID.'-'.$selectedItem.'" class="polymod" title="'.io::htmlspecialchars($selectedPlugin->getLabel($cms_language).' : '.trim($item->getLabel($cms_language))).'">'.$selectedText.'</span>';
								} else {
									$tagContent = '<span id="polymod-'.$selectedPluginID.'-'.$selectedItem.'" class="polymod" title="'.io::htmlspecialchars($selectedPlugin->getLabel($cms_language).' : '.trim($item->getLabel($cms_language))).'">'.CMS_poly_definition_functions::pluginCode($selectedPluginID, $selectedItem, '', ($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC || $visualizationMode == PAGE_VISUALMODE_PRINT || $visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE) ? true : false, true).'</span>';
								}
							} else {
								$tagContent = '';
							}
						}
						//strip cache comment
						$tagContent = preg_replace('#<!--{cache:(.*)}-->#Us', '', $tagContent);
						//encode all ampersand without reencode already encoded ampersand
						$tagContent = sensitiveIO::reencodeAmpersand($tagContent);
						return $tagContent;
					break;
				}
				return $tagContent;
			break;
			case MODULE_TREATMENT_WYSIWYG_OUTER_TAGS :
				switch ($tag->getName()) {
					case "span":
						$ids = explode('-', $tag->getAttribute('id'));
						$selectedPluginID = (int) $ids[1];
						$selectedItem = (int) $ids[2];
						//then create the code to paste for the current selected object if any
						if (sensitiveIO::isPositiveInteger($selectedItem) && sensitiveIO::isPositiveInteger($selectedPluginID)) {
							//get plugin
							$selectedPlugin = new CMS_poly_plugin_definitions($selectedPluginID);
							//get originaly selected text if any
							$selectedText = $commentSelectedText = '';
							if ($selectedPlugin->needSelection()) {
								$hasSelection = preg_match('#<!--(.*)-->#s', $tag->getInnerContent(), $matches);
								$selectedText = $hasSelection ? $matches[1] : $tag->getInnerContent();
								$commentSelectedText = '<!--'.($hasSelection ? $matches[1] : $tag->getInnerContent()).'-->';
							}
							$tagContent =
							'<span id="polymod-'.$selectedPluginID.'-'.$selectedItem.'" class="polymod">'."\n".
							'<?php echo CMS_poly_definition_functions::pluginCode(\''.$selectedPluginID.'\', \''.$selectedItem.'\', '.var_export($selectedText,true).', true); ?>'."\n".
							$commentSelectedText.'</span>';
						}
						return $tagContent;
					break;
				}
				return $tagContent;
			break;
		}
		return $tag->getContent();
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
			case MODULE_TREATMENT_PAGECONTENT_HEADER_CODE :
				//if this page use a row of this module then add the header code to the page
				if ($usage = CMS_module::moduleUsage($treatedObject->getID(), $this->_codename)) {
					//CMS_grandFather::log($usage);
					$modulesCode[$this->_codename] = '<?php require_once(PATH_REALROOT_FS.\'/automne/classes/polymodFrontEnd.php\'); ?>';
					if (isset($usage['headCallback'])) {
						foreach ($usage['headCallback'] as $headCallback) {
							//add header codes
							if (isset($headCallback['tagsCallback'])) {
								foreach ($headCallback['tagsCallback'] as $key => $headcode) {
									if (isset($headcode['code'])) {
										$modulesCode[$this->_codename] .= '<?php'."\n".$headCallback['headcode']."\n".$headcode['code']."\n".'?>';
									}
								}
							}
							//add forms header if needed
							if (isset($headCallback['form']) && $headCallback['form']) {
								$modulesCode[$this->_codename] .= '<?php CMS_poly_definition_functions::formActions('.var_export($headCallback['form'],true).', \''.$treatedObject->getID().'\', \''.$headCallback['language'].'\', '.(($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC || $visualizationMode == PAGE_VISUALMODE_PRINT || $visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE) ? 'true' : 'false').', $polymodFormsError, $polymodFormsItems); ?>';
							}
							//add forms callback if needed
							if (isset($headCallback['formsCallback']) && is_array($headCallback['formsCallback']) && isset($headCallback['headcode'])) {
								foreach ($headCallback['formsCallback'] as $formName => $formCallback) {
									foreach ($formCallback as $formFieldID => $callback) {
										if (io::isPositiveInteger($formFieldID)) {
											$modulesCode[$this->_codename] .= '<?php'."\n".
											'//callback function to check field '.$formFieldID.' for atm-form '.$formName."\n".
											'function form_'.$formName.'_'.$formFieldID.'($formName, $fieldID, &$item) {'."\n".
											'		global $cms_user;'."\n".
											'		global $public_search;'."\n".
											'		global $cms_language;'."\n".
											'       $object[$item->getObjectID()] = $item;'."\n".
											'       '.$headCallback['headcode']."\n".
											'       '.$callback."\n".
											'       return false;'."\n".
											'}'."\n".
											'?>';
										} elseif ($formFieldID == 'form') {
											$modulesCode[$this->_codename] .= '<?php'."\n".
											'//callback function for atm-form '.$formName."\n".
											'function form_'.$formName.'($formName, &$item) {'."\n".
											'		global $cms_user;'."\n".
											'		global $public_search;'."\n".
											'		global $cms_language;'."\n".
											'       $object[$item->getObjectID()] = $item;'."\n".
											'       '.$headCallback['headcode']."\n".
											'       '.$callback."\n".
											'       return true;'."\n".
											'}'."\n".
											'?>';
										}
									}
								}
							}
						}
					}
				}
				return $modulesCode;
			break;
			case MODULE_TREATMENT_ROWS_EDITION_LABELS :
				$modulesCode[$this->_codename] = '';
				//if user has rights on module
				if ($treatmentParameters["user"]->hasModuleClearance($this->_codename, CLEARANCE_MODULE_EDIT)) {
					if (!isset($treatmentParameters['request'])) {
						//add form to choose object to display
						$modulesCode[$this->_codename] = '
							<h1>'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_ROW_TAGS_CHOOSE,false,MOD_POLYMOD_CODENAME).'<select onchange="Ext.get(\'help'.$this->_codename.'\').getUpdater().update({url: \''.PATH_ADMIN_WR.'/help-detail.php\',params: {module: \''.$this->_codename.'\',object: this.value, mode:'.MODULE_TREATMENT_ROWS_EDITION_LABELS.'}});">
								<option value="">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_CHOOSE).'</option>
								<optgroup label="'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_ROW_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">
									<option value="block">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
									<option value="search">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_SEARCH_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
									<option value="working">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_TAGS).'</option>
									<option value="working-polymod">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_POLYMOD_TAGS,false,MOD_POLYMOD_CODENAME).'</option>
									<option value="vars">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_GENERAL_VARS).'</option>
									<option value="forms">'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_FORMS,false,MOD_POLYMOD_CODENAME).'</option>
								</optgroup>
								<optgroup label="'.$treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_ROW_OBJECTS_VARS_EXPLANATION,false,MOD_POLYMOD_CODENAME).'">';
									$modulesCode[$this->_codename] .= CMS_poly_module_structure::viewObjectInfosList($this->_codename, $treatmentParameters["language"], @$treatmentParameters['request'][$this->_codename.'object']);
								$modulesCode[$this->_codename] .= '
								</optgroup>';
							$modulesCode[$this->_codename] .= '
							</select></h1>
							<div id="help'.$this->_codename.'"></div>
						';
					}
					//then display chosen object infos
					if (isset($treatmentParameters['request'][$this->_codename]) && isset($treatmentParameters['request'][$this->_codename.'object'])) {
						switch ($treatmentParameters['request'][$this->_codename.'object']) {
							case 'block':
								$moduleLanguages = CMS_languagesCatalog::getAllLanguages($this->_codename);
								foreach ($moduleLanguages as $moduleLanguage) {
									$moduleLanguagesCodes[] = $moduleLanguage->getCode();
								}
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_TAGS_EXPLANATION,array($this->_codename, implode(', ',$moduleLanguagesCodes)),MOD_POLYMOD_CODENAME);
							break;
							case 'search':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_SEARCH_TAGS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
							break;
							case 'working':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_TAGS_EXPLANATION);
							break;
							case 'working-polymod':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_WORKING_POLYMOD_TAGS_EXPLANATION,array(implode(', ', CMS_modulesCatalog::getAllCodenames())),MOD_POLYMOD_CODENAME);
							break;
							case 'vars':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_GENERAL_VARS_EXPLANATION,array($treatmentParameters["language"]->getDateFormatMask(),$treatmentParameters["language"]->getDateFormatMask(),$treatmentParameters["language"]->getDateFormatMask()));
							break;
							case 'forms':
								$modulesCode[$this->_codename] .= $treatmentParameters["language"]->getMessage(self::MESSAGE_PAGE_BLOCK_FORMS_EXPLANATION,false,MOD_POLYMOD_CODENAME);
							break;
							default:
								//object info
								$modulesCode[$this->_codename] .= CMS_poly_module_structure::viewObjectRowInfos($this->_codename, $treatmentParameters["language"], $treatmentParameters['request'][$this->_codename.'object']);
							break;
						}
					}
				}
				return $modulesCode;
			break;
			case MODULE_TREATMENT_EDITOR_CODE :
				if ($treatmentParameters["editor"] == "fckeditor" && $treatmentParameters["user"]->hasModuleClearance($this->_codename, CLEARANCE_MODULE_EDIT)) {
					if (!isset($modulesCode["Default"]['polymod'])) {
						$pluginDefinitions = CMS_poly_object_catalog::getAllPluginDefinitionsForObject();
						if (is_array($pluginDefinitions) && $pluginDefinitions) {
							$languages = implode(',',array_keys(CMS_languagesCatalog::getAllLanguages()));
							//This is an exception of the method, because here we return an array, see admin/fckeditor/fckconfig.php for the detail
							$modulesCode["Default"]['polymod'] = "'polymod'";
							$modulesCode["modulesDeclaration"]['polymod'] = "FCKConfig.Plugins.Add( 'polymod', '".$languages."' );";
						}
					}
					$plugins = array();
					//get all objects for module
					$moduleObjects = CMS_poly_object_catalog::getObjectsForModule($this->_codename);
					foreach ($moduleObjects as $object) {
						$fields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());
						foreach ($fields as $field) {
							$fieldObject = $field->getTypeObject(true);
							if (method_exists($fieldObject, 'getUsedPlugins')) {
								$plugins = array_merge($plugins, $fieldObject->getUsedPlugins());
							}
						}
					}
					$plugins = array_unique($plugins);
					// create specific polymod toolbar
					$modulesCode["ToolbarSets"][] =
							"FCKConfig.ToolbarSets[\"".$this->_codename."\"] = [
								['Source','Undo','Redo'],
								['Cut','Copy','Paste','PasteText','PasteWord'],
								['OrderedList','UnorderedList','-','Outdent','Indent'],
								['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
								['Link','Unlink','Anchor'". (($plugins) ? ','.implode(",",$plugins) : '') ."],
								['Table','Rule','SpecialChar']
							];";
				}
				return $modulesCode;
			break;
			case MODULE_TREATMENT_EDITOR_PLUGINS:
				if ($treatmentParameters["editor"] == "fckeditor" && $treatmentParameters["user"]->hasModuleClearance($this->_codename, CLEARANCE_MODULE_EDIT)) {
					if (!isset($modulesCode['polymod'])) {
						$modulesCode['polymod'] = '';
						$pluginDefinitions = CMS_poly_object_catalog::getAllPluginDefinitionsForObject();
						if (is_array($pluginDefinitions) && $pluginDefinitions) {
							foreach ($pluginDefinitions as $pluginDefinition) {
								$modulesCode['polymod'] .= ($modulesCode['polymod']) ? ', ' : '';
								$modulesCode['polymod'] .= $pluginDefinition->getLabel($treatmentParameters["user"]->getLanguage());
							}
						}
					}
				}
			break;
			case MODULE_TREATMENT_AFTER_VALIDATION_TREATMENT :
				//if object is a polyobject and module is the current object's module
				if (($treatedObject instanceof CMS_poly_object) && $this->_codename == CMS_poly_object_catalog::getModuleCodenameForObject($treatedObject->getID())) {
					//send notification of the validation result to polyobject
					$treatedObject->afterValidation($treatmentParameters['result']);
				}
			break;
			case MODULE_TREATMENT_ALERTS :
				//only if user has validation clearances
				if ($treatmentParameters['user']->hasValidationClearance($this->_codename)) {
					$modulesCode[$this->_codename] = array(
							ALERT_LEVEL_VALIDATION 	=> array('label' => self::MESSAGE_ALERT_LEVEL_VALIDATION,		'description' => self::MESSAGE_ALERT_LEVEL_VALIDATION_DESCRIPTION),
						);
				}
				return $modulesCode;
			break;
		}
		return $modulesCode;
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
			$class_name = "CMS_block_polymod";
			if (class_exists($class_name)) {
				$instance = new $class_name();
			} else {
				$this->raiseError("Unknown block type : CMS_block_polymod");
				return false;
			}
			//pr(io::htmlspecialchars($tag->getInnerContent()));
			$instance->initializeFromTag($tag->getAttributes(), $tag->getInnerContent());
			return $instance;
			break;
		}
	}

	/**
	  * Convert variables of a given definition string (usually a row definition)
	  *
	  * @param string $definition the definition string to convert
	  * @param boolean $toHumanReadableFormat if true, convert founded variables to a human readable format, else to a machine readable format
	  * @param boolean $reset if true, reset convertion table if already loaded
	  *
	  * @return string : the module definition string converted
	  * @access public
	  */
	function convertDefinitionString($definition, $toHumanReadableFormat, $reset = false) {
		global $cms_language;
		static $modulesConversionTable;
		$count = 1;
		//loop on text for vars to replace if any
		while (preg_match_all("#\{[^{}]+[|}]{1}#U", $definition, $matches) && $count) {
			$matches = array_unique($matches[0]);
			//get module variables conversion table
			if (!isset($modulesConversionTable[$this->getCodename()]) || $reset) {
				$modulesConversionTable[$this->getCodename()] = CMS_poly_module_structure::getModuleTranslationTable($this->getCodename(), $cms_language);
			}
			$convertionTable = $toHumanReadableFormat ? array_flip($modulesConversionTable[$this->getCodename()]) : $modulesConversionTable[$this->getCodename()];
			//create definition conversion table
			$replace = array();
			$count = 0;
			foreach ($matches as $variable) {
				$strippedVar = io::substr($variable, 1, io::strlen($variable)-2);
				if (isset($convertionTable[$strippedVar])) {
					$replace[$variable] = '{' . $convertionTable[$strippedVar] . io::substr($variable, -1);
					$count++;
				}
			}
			//then replace variables in definition
			$definition = str_replace(array_keys($replace), $replace, $definition);
		}
		return $definition;
	}

	/**
	  * If module use CMS_moduleCategory, does it use it
	  *
	  * @param CMS_moduleCategory $category The to check useage by module
	  * @return Boolean true/false
	  * @access public
	  */
	function isCategoryUsed($category)
	{
		static $moduleUseCategories, $moduleFieldsCategories;
		if (!isset($moduleUseCategories)) {
			$moduleUseCategories = CMS_poly_object_catalog::moduleHasCategories($this->_codename);
		}
		if (!$moduleUseCategories) {
			return false;
		}
		if (!isset($moduleFieldsCategories)) {
			$moduleFieldsCategories = array();
			//get all module objects fields which uses categories
			$moduleObjects = CMS_poly_object_catalog::getObjectsForModule($this->_codename);
			foreach ($moduleObjects as $object) {
				$moduleFieldsCategories = array_merge(CMS_poly_object_catalog::objectHasCategories($object->getID()), $moduleFieldsCategories);
			}
		}
		//then check for category value in this fields (edited)
		$sql = "select
					id
				from
					mod_subobject_integer_edited
				where
					objectFieldID in (".implode(',', $moduleFieldsCategories).")
					and value = '".$category->getID()."'
				";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			return true;
		}
		//then check for category value in this fields (public)
		$sql = "select
					id
				from
					mod_subobject_integer_public
				where
					objectFieldID in (".implode(',', $moduleFieldsCategories).")
					and value = '".$category->getID()."'
				";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? true : false;
	}

	/**
	  * Module script task
	  * @param array $parameters the task parameters
	  *		task : string task to execute
	  *		object : string module codename for the task
	  *		field : string module uid
	  *		...	: optional field relative parameters
	  * @return Boolean true/false
	  * @access public
	  */
	function scriptTask($parameters) {
		if (!isset($parameters['object']) || !sensitiveIO::isPositiveInteger($parameters['object'])) {
			return false;
		}
		//instanciate root user to avoid rights problems during item loading
		$GLOBALS['cms_user'] = new CMS_profile_user(ROOT_PROFILEUSER_ID);
		//instanciate script related item (use edited object because the script can launch writing of values into object)
		$item = CMS_poly_object_catalog::getObjectByID($parameters['object'],false,false);
		if (!is_object($item) || $item->hasError()) {
			return false;
		}
		//then pass task to object
		return $item->scriptTask($parameters);
	}

	/**
	  * Module script info : get infos for a given script parameters
	  *
	  * @param array $parameters the task parameters
	  *		task : string task to execute
	  *		module : string module codename for the task
	  *		uid : string module uid
	  * @return string : HTML scripts infos
	  * @access public
	  */
	function scriptInfo($parameters) {
		if (!isset($parameters['object']) || !sensitiveIO::isPositiveInteger($parameters['object'])) {
			return parent::scriptInfo($parameters);
		}
		//instanciate script related object (use edited object because the script can launch writing of values into object)
		$object = CMS_poly_object_catalog::getObjectByID($parameters['object'],false,false);
		global $cms_language;
		if (!is_object($object) || $object->hasError()) {
			return $this->getLabel($cms_language). ' : '.parent::scriptInfo($parameters);
		}
		//then pass query to object
		$return = $object->scriptInfo($parameters);
		return $this->getLabel($cms_language). ' : '.(($return) ? $return : parent::scriptInfo($parameters));
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
				'cms_poly_object_field' 			=> PATH_MODULES_FS.'/polymod/polyobjects/poly_object_field.php',
				'cms_poly_object' 					=> PATH_MODULES_FS.'/polymod/polyobjects/poly_object.php',
				'cms_poly_object_definition' 		=> PATH_MODULES_FS.'/polymod/polyobjects/poly_object_definition.php',
				'cms_poly_object_catalog' 			=> PATH_MODULES_FS.'/polymod/polyobjects/poly_object_catalog.php',
				'cms_multi_poly_object' 			=> PATH_MODULES_FS.'/polymod/polyobjects/multi_poly_object.php',
				'cms_object_search' 				=> PATH_MODULES_FS.'/polymod/object_search.php',
				'cms_poly_plugin_definitions' 		=> PATH_MODULES_FS.'/polymod/poly_plugin_definition.php',
				'cms_object_i18nm' 					=> PATH_MODULES_FS.'/polymod/object_i18nm.php',
				'cms_polymod_definition_parsing' 	=> PATH_MODULES_FS.'/polymod/poly_definition_parsing.php',
				'cms_poly_module_structure' 		=> PATH_MODULES_FS.'/polymod/poly_module_structure.php',
				'cms_poly_rss_definitions' 			=> PATH_MODULES_FS.'/polymod/poly_rss_definition.php',
				'cms_block_polymod' 				=> PATH_MODULES_FS.'/polymod/block.php',
				'cms_poly_definition_functions' 	=> PATH_MODULES_FS.'/polymod/poly_definition_functions.php',
				'cms_xmltag_if' 					=> PATH_MODULES_FS.'/polymod/tags/if.php',
				'cms_xmltag_else' 					=> PATH_MODULES_FS.'/polymod/tags/else.php',
				'cms_xmltag_start' 					=> PATH_MODULES_FS.'/polymod/tags/start.php',
				'cms_xmltag_end' 					=> PATH_MODULES_FS.'/polymod/tags/end.php',
				'cms_xmltag_setvar' 				=> PATH_MODULES_FS.'/polymod/tags/setvar.php',
			);
		}
		$file = '';
		if (isset($classes[io::strtolower($classname)])) {
			$file = $classes[io::strtolower($classname)];
		} elseif (io::strpos($classname, 'CMS_object_') === 0 //polymod objects lazy loading
					&& file_exists(PATH_MODULES_FS.'/polymod/objects/object_'.io::substr($classname,11).'.php')) {
			$file = PATH_MODULES_FS.'/polymod/objects/object_'.io::substr($classname,11).'.php';
		} elseif (io::strpos($classname, 'CMS_subobject_') === 0 //polymod subobjects lazy loading
					&& file_exists(PATH_MODULES_FS.'/polymod/subobjects/subobject_'.io::substr($classname,14).'.php')) {
			$file = PATH_MODULES_FS.'/polymod/subobjects/subobject_'.io::substr($classname,14).'.php';
		}
		return $file;
	}

	/**
	  * Return a list of objects infos to be displayed in module index according to user privileges
	  *
	  * @return string : HTML scripts infos
	  * @access public
	  */
	function getObjectsInfos($user) {
		$objectsInfos = array();
		$cms_language = $user->getLanguage();
		$catFieldsNames = array();
		//objects
		$objects = $this->getObjects();
		if (APPLICATION_ENFORCES_ACCESS_CONTROL === false ||
			 (APPLICATION_ENFORCES_ACCESS_CONTROL === true
				&& $user->hasModuleClearance($this->getCodename(), CLEARANCE_MODULE_EDIT)) ) {
			foreach ($objects as $anObjectType) {
				//if object is editable or if user has full privileges
				if ($anObjectType->getValue("admineditable") == 0 || ($anObjectType->getValue("admineditable") == 2 && $user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL))) {
					//load fields objects for object
					$objectFields = CMS_poly_object_catalog::getFieldsDefinition($anObjectType->getID());
					if(sizeof($objectFields)) {
						$objectsInfos[] = array(
							'label'			=> $anObjectType->getLabel($cms_language),
							'adminLabel'	=> $anObjectType->getLabel($cms_language),
							//'adminLabel'	=> $cms_language->getMessage(self::MESSAGE_PAGE_MANAGE_OBJECTS, array($anObjectType->getLabel($cms_language))),
							'description'	=> $anObjectType->getDescription($cms_language),
							'objectId'		=> $anObjectType->getID(),
							'url'			=> PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/items.php',
							'module'		=> $this->getCodename(),
							'class'			=> 'atm-elements',
						);
						//get categories fields for object
						if (count($catFieldsNames) < 3) {
							$thisFieldsCategories = CMS_poly_object_catalog::objectHasCategories($anObjectType->getID());
							if ($thisFieldsCategories) {
								$fields = CMS_poly_object_catalog::getFieldsDefinition($anObjectType->getID());
								foreach ($thisFieldsCategories as $catField) {
									if (isset($fields[$catField]) && is_object($fields[$catField])) {
										$label = new CMS_object_i18nm($fields[$catField]->getValue("labelID"));
										$catFieldsNames[] = $label->getValue($cms_language->getCode()). ' ('.$anObjectType->getLabel($cms_language).')';
									}
								}
							}
						} else {
							if (!in_array('...', $catFieldsNames)) {
								$catFieldsNames[] = '...';
							}
						}
					}
				}
			}
		}
		//Categories
		//if user has some categories to manage
		$userManageCategories = $user->getRootModuleCategoriesManagable($this->getCodename());
		if ($catFieldsNames && ((is_array($userManageCategories) && $userManageCategories) || $user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL))) {
			$objectsInfos[] = array(
				'label'			=> $cms_language->getMessage(self::MESSAGE_PAGE_CATEGORIES),
				'adminLabel'	=> $cms_language->getMessage(self::MESSAGE_PAGE_ADMIN_CATEGORIES),
				'description'	=> $cms_language->getMessage(self::MESSAGE_PAGE_CATEGORIES_USED, false, MOD_POLYMOD_CODENAME).io::htmlspecialchars(implode(', ', $catFieldsNames)),
				'objectId'		=> 'categories',
				'url'			=> PATH_ADMIN_WR.'/modules-categories.php',
				'module'		=> $this->getCodename(),
				'class'			=> 'atm-categories',
			);
		}
		return $objectsInfos;
	}
	
	/**
	  * Module replacements vars
	  *
	  * @return array of replacements values (pattern to replace => replacement)
	  * @access public
	  */
	function getModuleReplacements() {
		$replace = array();
		//replace {plugin:selection} values
		$replace["#^\{plugin:selection\}$#U"]								= '$parameters[\'selection\']';
		//replace 'fieldID' value by corresponding fieldID
		$replace["#^\{.*\[([n0-9]+)\]\['fieldID'\]\}$#U"] 					= '(\1)';
		//create the real object path to vars
		$replace["#\['fields'\]\[([n0-9]+)\]\}?#"] 							= '->objectValues(\1)';
		$replace["#\['values'\]\[([n0-9]+)\]\['([a-zA-Z]+)'\]\}$#U"]		= '->getValue(\'\1\',\'\2\')';
		$replace["#\['([a-zA-Z]+)'\]\|?\"\.([^|}]*)\.\"\}$#U"] 				= '->getValue(\'\1\',\2)';
		
		$replace["#\['([a-zA-Z]+)'\]\|?([^|}]*)\}$#U"] 						= '->getValue(\'\1\',\'\2\')';
		
		$replace["#^\{\['object([0-9]+)'\]#U"] 								= '$object[\1]';
		$replace["#\[([n0-9]+)]}$#U"] 										= '[\1]';
		//replace the loop 'n' value by $key
		$replace["#\(([n0-9]+)\)->objectValues(\(n\))#U"] 					= '(\1)->objectValues($key_\1)';
		$replace["#\(([n0-9]+)\)->getValue\(('n')#U"] 						= '(\1)->getValue($key_\1';
		return $replace;
	}
	
	/**
	  * Search module objects by Id
	  *
	  * @param string $keyword : the search keywords
	  * @param CMS_profile_user $user : the user which make the search
	  * @param booolean : public search (default : false)
	  * @param array : the results score returned by reference
	  * @return array : results elements Ids
	  * @access public
	  */
	function search ($keyword, &$user, $public = false, &$score = array()) {
		//objects
		$objects = $this->getObjects();
		$results = array();
		$score = array();
		foreach ($objects as $object) {
			//create search object for current object
			$search = new CMS_object_search($object);
			$search->addWhereCondition("keywords", $keyword);
			$results = $search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_IDS) + $results;
			$score = $search->getScore() + $score;
			//sort results score
			arsort($score, SORT_NUMERIC);
		}
		return $results;
	}
	
	/**
	  * Get search results objects for module by Id
	  *
	  * @param array : the results score ids
	  * @return array : results elements (cms_page)
	  * @access public
	  */
	function getSearchResults($resultsIds, &$user) {
		if (!$resultsIds || !is_array($resultsIds)) {
			return array();
		}
		$cms_language = $user->getLanguage();
		//get results object types
		$sql = "
			select
				object_type_id_moo as type, id_moo as id
			from
				mod_object_polyobjects
			where
				id_moo in (".sensitiveIO::sanitizeSQLString(implode(',', $resultsIds)).")
		";
		$q = new CMS_query($sql);
		$resultsType = array();
		while($r = $q->getArray()) {
			$resultsType[$r['type']][] = $r['id'];
		}
		$results = array();
		foreach ($resultsType as $type => $ids) {
			//load current object definition
			$object = new CMS_poly_object_definition($type);
			//create search object for current object
			$search = new CMS_object_search($object);
			$search->addWhereCondition("items", $ids);
			$search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS); //launch search
			$objectLabel = $object->getLabel($cms_language);
			// Check if need to use a specific display for search results
			$resultsDefinition = $object->getValue('resultsDefinition');
			if ($resultsDefinition) {
				$definitionParsing = new CMS_polymod_definition_parsing($resultsDefinition, true, CMS_polymod_definition_parsing::PARSE_MODE);
				$itemsResourcesFiles = '';
				// Add specific css and js files we use the resultsDefinition
				if (file_exists(PATH_CSS_FS.'/modules/'.$this->getCodename().'.css')){
					$itemsResourcesFiles .= '<link rel="stylesheet" type="text/css" href="'.PATH_CSS_WR.'/modules/'.$this->getCodename().'.css" />';
				}
				$jsFiles = $this->getJSFiles();
				if ($jsFiles) {
					foreach ($jsFiles as $jsfile) {
						$itemsResourcesFiles .= '<script type="text/javascript" src="'.$jsfile.'"></script>'."\n";
					}
				}
				
			} else {
				//load fields objects for object
				$objectFields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());
			}
			//loop on results items
			while($item = $search->getNextResult()) {
				//Resource related informations
				$htmlStatus = $pubRange = '';
				$lock = $deleted = $primaryResource = false;
				if ($object->isPrimaryResource()) {
					$status = $item->getStatus();
					if (is_object($status)) {
						$htmlStatus = $status->getHTML(false, $user, $this->getCodename(), $item->getID());
						$pubRange = $status->getPublicationRange($cms_language);
						$lock = $item->getLock();
						$deleted = ($item->getProposedLocation() == RESOURCE_LOCATION_DELETED);
					}
					$primaryResource = true;
				}
				//Edit
				$edit = false;
				if (!$deleted && (!$lock || $lock == $user->getUserId())) {
					$edit = array(
						'url'		=> PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/item.php',
						'type'		=> 'window',
						'params'	=> array(
							'module'	=>	$this->getCodename(),
							'type'		=>	$type,
							'item'		=>	$item->getID()
						)
					);
				}
				//Previz
				$view = false;
				if ($object->getValue("previewURL")) {
					$view = array(
						'url'		=> $item->getPrevizPageURL(),
						'type'		=> 'frame',
					);
				}
				//HTML description
				$description = POLYMOD_DEBUG ? '<span class="atm-text-alert"> (ID : '.$item->getID().')</span>' : '';
				if($resultsDefinition){
					//set execution parameters
					$parameters = array();
					$parameters['module'] 	= $this->getCodename();
					$parameters['objectID'] = $object->getID();
					$parameters['public'] 	= false;
					$parameters['item']		= $item;
					$description .= $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
					if ($itemsResourcesFiles) {
						$description = $itemsResourcesFiles.$description;
					}
				} else {
					$itemFieldsObjects = $item->getFieldsObjects();
					//Add all needed fields to description
					foreach ($itemFieldsObjects as $fieldID => $itemField) {
						//if field is a poly object
						if ($objectFields[$fieldID]->getValue('searchlist')) {
							$description .= $objectFields[$fieldID]->getLabel($cms_language).' : <strong>'.$itemField->getHTMLDescription().'</strong><br />';
						}
					}
				}
				$results[$item->getID()] = array(
					'id'			=> $item->getID(),
					'type'			=> $objectLabel,
					'status'		=> $htmlStatus,
					'pubrange'		=> $pubRange,
					'label'			=> $item->getLabel(),
					'description'	=> $description,
					//these parameters are sent to resource-controler.php when edit window is closed (used to unlock item)
					'resource'		=> $primaryResource ? array('module' => $this->getCodename(), 'resource' => $item->getID(), 'action' => 'unlock') : false,
					'edit'			=> $edit,
					'view'			=> $view,
				);
			}
		}
		return $results;
	}
	
	/**
	  * Force compilation for all stored definitions
	  *
	  * @return void
	  * @access public
	  */
	function compileDefinitions() {
		//foreach definition, plugin and rss, recompile stored values if exists
		$modules = CMS_modulesCatalog::getAll("id", true);
		$hasPolyModule = false;
		foreach ($modules as $module) {
			if ($module->isPolymod()) {
				$hasPolyModule = true;
				//get objects definition for module
				$objects = CMS_poly_object_catalog::getObjectsForModule($module->getCodename());
				foreach ($objects as $object) {
					if ($object->getValue('indexURL')) {
						$object->compileDefinition();
						$object->writeToPersistence();
					}
				}
				//get plugins for module
				$plugins = CMS_poly_object_catalog::getAllPluginDefIDForModule($module->getCodename());
				foreach ($plugins as $pluginID) {
					$plugin = new CMS_poly_plugin_definitions($pluginID);
					if ($plugin->getValue('definition') && method_exists($plugin, 'compileDefinition')) {
						$plugin->compileDefinition();
						$plugin->writeToPersistence();
					}
				}
			}
		}
		if ($hasPolyModule) {
			//get all RSS definition
			$rssDefinitions = CMS_poly_object_catalog::getAllRSSDefinitionsForObject();
			foreach ($rssDefinitions as $rssDefinition) {
				if ($rssDefinition->getValue('definition')) {
					$rssDefinition->compileDefinition();
					$rssDefinition->writeToPersistence();
				}
			}
		}
	}
	
	/**
	  * Get object as an array structure used for export
	  *
	  * @param array $params The export parameters.
	  *		array(
	  *				objects	=> false|true : export module objects structures (default : true)
	  *			)
	  * @param array $files The reference to the founded files used by object
	  * @return array : the object array structure
	  * @access public
	  */
	public function asArray($params = array(), &$files) {
		$aModule = parent::asArray($params, $files);
		if (in_array('objects', $params)) {
			//get all objects definitions
			$objectsDefinitions = CMS_poly_object_catalog::getObjectsForModule($this->_codename);
			if ($objectsDefinitions) {
				$aModule['objects'] = array();
				foreach ($objectsDefinitions as $object) {
					//objects structures
					$objectDatas = $object->asArray($params, $files);
					//rss structures
					$rssFeeds = CMS_poly_object_catalog::getAllRSSDefinitionsForObject($object->getID());
					if ($rssFeeds) {
						$objectDatas['rss'] = array();
						foreach ($rssFeeds as $rssFeed) {
							$objectDatas['rss'][] = $rssFeed->asArray($params, $files);
						}
					}
					//plugins structure
					$plugins = CMS_poly_object_catalog::getAllPluginDefinitionsForObject($object->getID());
					if ($plugins) {
						$objectDatas['plugins'] = array();
						foreach ($plugins as $plugin) {
							$objectDatas['plugins'][] = $plugin->asArray($params, $files);
						}
					}
					
					$aModule['objects'][] = $objectDatas;
				}
			}
		}
		$aModule['polymod'] = true;
		return $aModule;
	}
	
	/**
	  * Import module from given array datas
	  *
	  * @param array $data The module datas to import
	  * @param array $params The import parameters.
	  *		array(
	  *				create	=> false|true : create missing objects (default : true)
	  *				update	=> false|true : update existing objects (default : true)
	  *				files	=> false|true : use files from PATH_TMP_FS (default : true)
	  *			)
	  * @param CMS_language $cms_language The CMS_langage to use
	  * @param array $idsRelation : Reference : The relations between import datas ids and real imported ids
	  * @param string $infos : Reference : The import infos returned
	  * @return boolean : true on success, false on failure
	  * @access public
	  */
	function fromArray($data, $params, $cms_language, &$idsRelation, &$infos) {
		$this->setPolymod(true);
		$return = true;
		$return &= parent::fromArray($data, $params, $cms_language, $idsRelation, $infos);
		//append codename to parameters
		$params['module'] = $this->_codename;
		//add objects
		if (isset($data['objects']) && $data['objects']) {
			if (!CMS_poly_object_catalog::fromArray($data['objects'], $params, $cms_language, $idsRelation, $infos)) {
				$infos .= 'Error during objects import ...'."\n";
				$return = false;
			}
		}
		//import of module is complete so compile all definitions
		if (isset($idsRelation['definitionToConvert'])&& $idsRelation['definitionToConvert']) {
			foreach ($idsRelation['definitionToConvert'] as $objectToCompile) {
				if (method_exists($objectToCompile, 'convertDefinitions')) {
					$objectToCompile->convertDefinitions($this);
				}
			}
		}
		//convert params of imported fields
		if (isset($idsRelation['paramsFieldsToConvert'])&& $idsRelation['paramsFieldsToConvert']) {
			foreach ($idsRelation['paramsFieldsToConvert'] as $field) {
				$fieldObject = $field->getTypeObject();
				if (method_exists($fieldObject, 'importParams')) {
					$params = $fieldObject->getParamsValues();
					$params = $fieldObject->importParams($params, $cms_language, $idsRelation, $infos);
					if ($params) {
						$field->setValue("params", $params);
						$field->writeToPersistence();
					}
				}
			}
		}
		return $return;
	}
	
	/**
	  * Does this module is destroyable ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isDestroyable() {
		global $cms_user;
		// Check module exists and is polymod
		if($this->hasError() || !$this->isPolymod()){
			return false;
		}
		//check if user is admin
		if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			return false;
		}
		//check if module has objects
		if (CMS_poly_object_catalog::getObjectsForModule($this->_codename)) {
			return false;
		}
		// CHECK USED ROWS
		$usedRows = array();
		$rowsIds = CMS_rowsCatalog::getByModules(array($this->_codename), false, false);
		if($rowsIds){
			foreach($rowsIds as $rowId){
				if (CMS_rowsCatalog::getPagesByRow($rowId, false, false)) {
					$usedRows[] = $rowId;
				}
			}
		}
		// If any used rows : alert user and break module deletion
		if($usedRows){
			return false;
		}
		return true;
	}
	
	/**
	  * Destroy the module
	  *
	  * @return void
	  * @access public
	  */
	function destroy () {
		global $cms_user;
		// Check module exists and is polymod
		if (!$this->isDestroyable()) {
			return false;
		}
		// CHECK USED ROWS
		$rowsIds = CMS_rowsCatalog::getByModules(array($this->_codename), false, false);
		//delete all module rows
		foreach ($rowsIds as $rowId) {
			$row = CMS_rowsCatalog::getByID($rowId);
			if (is_object($row)) {
				$row->destroy();
			}
		}
		
		// TREAT CATEGORIES
		$attrs = array ( 
			"module" => $this->_codename,
			"language" => CMS_languagesCatalog::getDefaultLanguage(),
			"level" => -1,
			"root" => -1,
			"cms_user" => $cms_user,
			"clearanceLevel" => CLEARANCE_MODULE_EDIT,
			"strict" => false,
		);
		$cats = CMS_moduleCategories_catalog::getAll($attrs);
		if($cats){
			foreach($cats as $cat){
				// Destroy category
				$cat->destroy();
			}
		}
		
		// TREAT MODULE & VALIDATIONS RIGHTS
		$sql = "
			select 
				*
			from
				profiles
			where
				moduleClearancesStack_pr like '".io::sanitizeSQLString($this->_codename).",%'
				 or moduleClearancesStack_pr like '%;".io::sanitizeSQLString($this->_codename).",%'
		 ";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			while($r = $q->getArray()) {
				$stack = new CMS_stack();
				$stack->setTextDefinition($r['moduleClearancesStack_pr']);
				$stack->delAllWithOneKey($this->_codename);
				$qInsert = new CMS_query("update profiles set moduleClearancesStack_pr='".io::sanitizeSQLString($stack->getTextDefinition())."' where id_pr='".$r['id_pr']."'");
			}
		}
		$sql = "
			select 
				*
			from
				profiles
			where
				validationClearancesStack_pr like '".io::sanitizeSQLString($this->_codename).";%'
				 or validationClearancesStack_pr like '%;".io::sanitizeSQLString($this->_codename).";%'
				 or validationClearancesStack_pr = '".io::sanitizeSQLString($this->_codename)."'
			";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			while($r = $q->getArray()) {
				$stack = new CMS_stack();
				$stack->setTextDefinition($r['validationClearancesStack_pr']);
				$stack->delAllWithOneKey($this->_codename);
				$qInsert = new CMS_query("update profiles set validationClearancesStack_pr='".io::sanitizeSQLString($stack->getTextDefinition())."' where id_pr='".$r['id_pr']."'");
			}
		}
		
		//remove module files
		if (CMS_file::deltreeSimulation(PATH_MODULES_FILES_FS.'/'.$this->_codename, true)) {
			CMS_file::deltree(PATH_MODULES_FILES_FS.'/'.$this->_codename, true);
		}
		
		//remove JS and CSS
		if (is_dir(PATH_JS_FS.'/modules/'.$this->_codename) && CMS_file::deltreeSimulation(PATH_JS_FS.'/modules/'.$this->_codename, true)) {
			CMS_file::deltree(PATH_JS_FS.'/modules/'.$this->_codename, true);
		}
		$cssFiles = $this->getCSSFiles();
		foreach ($cssFiles as $mediaCssFiles) {
			foreach ($mediaCssFiles as $cssFile) {
				CMS_file::deleteFile(PATH_REALROOT_FS.'/'.$cssFile);
			}
		}
		//Clear polymod cache
		CMS_cache::clearTypeCacheByMetas('polymod', array('module' => $this->_codename));
		
		// Destroy module
		return parent::destroy();
	}
}
?>