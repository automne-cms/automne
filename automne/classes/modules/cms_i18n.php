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

/**
  * Class CMS_i18n
  *
  * Represent the Internationalization module.
  *
  * @package Automne
  * @subpackage cms_i18n
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//Polymod Codename
define("MOD_CMS_I18N_CODENAME", "cms_i18n");

class CMS_module_CMS_i18n extends CMS_module
{
	const MESSAGE_PAGE_MODELS_LABELS = 2;
	const MESSAGE_PAGE_MODELS_LABELS_MANAGEMENT = 3;
	const MESSAGE_PAGE_MODELS_MODULE_MANAGEMENT = 4;
	const MESSAGE_POLYMOD_MODULE = 5;
	const MESSAGE_POLYMOD_MODULE_LABELS_MANAGEMENT = 6;
	const MESSAGE_TEMPLATE_EXPLANATION = 62;
	
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
	public function getModuleCode($modulesCode, $treatmentMode, $visualizationMode, &$treatedObject, $treatmentParameters)
	{
		switch ($treatmentMode) {
			case MODULE_TREATMENT_PAGECONTENT_HEADER_CODE :
				$modulesCode[MOD_CMS_I18N_CODENAME] = '';
				//Append usefull class in top of HTML code and top and bottom contents
				$modulesCode[MOD_CMS_I18N_CODENAME] = '<?php '."\n".
				' /*set cms_i18n context*/'."\n".
				'	CMS_i18n::setContext(\''.$treatedObject->getID().'\', \''.$treatedObject->getLanguage(true).'\');'."\n".
				'	?>';
			break;
			case MODULE_TREATMENT_EDITOR_CODE :
				if ($treatmentParameters["editor"] == "fckeditor") {
					$languages = implode(',',array_keys(CMS_languagesCatalog::getAllLanguages(MOD_CMS_I18N_CODENAME)));
					//This is an exception of the method, because here we return an array, see admin/fckeditor/fckconfig.php for the detail
					
					// create specific cms_form toolbar
					$modulesCode["ToolbarSets"][] = 
							"FCKConfig.ToolbarSets['".MOD_CMS_I18N_CODENAME."'] = [
								['Source','-','FitWindow','ShowBlocks','Preview'],
								['Cut','Copy','Paste','PasteText','PasteWord','-','Print'],
								['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
								['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript'],
								['OrderedList','UnorderedList','-','Outdent','Indent'],
								['JustifyLeft','JustifyCenter','JustifyRight','JustifyFull'],
								['Link','Unlink','Anchor'],
								['Table','Rule','SpecialChar'],
								['Style','FontFormat','FontSize'],
								['TextColor','BGColor']
							];";
					return $modulesCode;
				} else {
					return $modulesCode;
				}
			break;
			case MODULE_TREATMENT_ROWS_EDITION_LABELS :
				$modulesCode[MOD_CMS_I18N_CODENAME] = $treatmentParameters["language"]->getMessage(self::MESSAGE_TEMPLATE_EXPLANATION, false, MOD_CMS_I18N_CODENAME);
				return $modulesCode;
			break;
			case MODULE_TREATMENT_TEMPLATES_EDITION_LABELS :
				$modulesCode[MOD_CMS_I18N_CODENAME] = $treatmentParameters["language"]->getMessage(self::MESSAGE_TEMPLATE_EXPLANATION, false, MOD_CMS_I18N_CODENAME);
				return $modulesCode;
			break;
		}
		return $modulesCode;
	}
	
	/**
	  * Module replacements vars
	  *
	  * @return array of replacements values (pattern to replace => replacement)
	  * @access public
	  */
	public function getModuleReplacements() {
		$replace = array();
		//replace '{i18n:language:msgid|parameter}' value by corresponding call
		$replace["#^\{i18n\:([^:]*?(::)?[^:]*?)\:([^:]*?(::)?[^:]*?)\|(([^:]*?(::)?[^:]*?)*)\}$#U"] = 'CMS_i18n::getTranslation("\3", "\1", "\5")';
		//replace '{i18n:language:msgid}' value by corresponding call
		$replace["#^\{i18n\:([^:]*?(::)?[^:]*?)\:([^:]*?(::)?[^:]*?)\}$#U"] = 'CMS_i18n::getTranslation("\3", "\1")';
		
		//replace '{i18n:msgid|parameter}' value by corresponding call
		$replace["#^\{i18n\:([^:]*?(::)?[^:]*?)\|(([^:]*?(::)?[^:]*?)*)\}$#U"] = 'CMS_i18n::getTranslation("\1", "", "\3")';
		//replace '{i18n:msgid}' value by corresponding call
		$replace["#^\{i18n\:([^:]*?(::)?[^:]*?)\}$#U"] = 'CMS_i18n::getTranslation("\1")';
		
		return $replace;
	}
	
	/**
	  * Module autoload handler
	  *
	  * @param string $classname the classname required for loading
	  * @return string : the file to use for required classname
	  * @access public
	  */
	public function load($classname) {
		static $classes;
		if (!isset($classes)) {
			$classes = array(
				'cms_i18n' 		=> PATH_MODULES_FS.'/'.MOD_CMS_I18N_CODENAME.'/i18n.php',
				'cms_po'		=> PATH_MODULES_FS.'/'.MOD_CMS_I18N_CODENAME.'/po.php',
				'cms_po_entry'	=> PATH_MODULES_FS.'/'.MOD_CMS_I18N_CODENAME.'/poentry.php',
			);
		}
		$file = '';
		if (isset($classes[io::strtolower($classname)])) {
			$file = $classes[io::strtolower($classname)];
		}
		return $file;
	}
	
	/**
	  * Return a list of objects infos to be displayed in module index according to user privileges
	  *
	  * @return string : HTML scripts infos
	  * @access public
	  */
	public static function getObjectsInfos($user) {
		$objectsInfos = array();
		$cms_language = $user->getLanguage();
		
		$objectsInfos[] = array(
			'label'			=> $cms_language->getMessage(self::MESSAGE_PAGE_MODELS_LABELS, false, MOD_CMS_I18N_CODENAME),
			'adminLabel'	=> $cms_language->getMessage(self::MESSAGE_PAGE_MODELS_LABELS, false, MOD_CMS_I18N_CODENAME),
			'description'	=> $cms_language->getMessage(self::MESSAGE_PAGE_MODELS_LABELS_MANAGEMENT, false, MOD_CMS_I18N_CODENAME),
			'objectId'		=> 'cms_i18n_vars',
			'url'			=> PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/items.php',
			'module'		=> 'cms_i18n_vars',
			'class'			=> 'atm-elements',
		);
		
		//Get all modules messages
		if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
			$objectsInfos[] = array(
				'class'			=> 'atm-separator',
			);
			$modules = CMS_modulesCatalog::getAll();
			foreach ($modules as $module) {
				if (!$module->isPolymod()) {
					$objectsInfos[] = array(
						'label'			=> $module->getLabel($cms_language),
						'adminLabel'	=> $module->getLabel($cms_language),
						'description'	=> $cms_language->getMessage(self::MESSAGE_PAGE_MODELS_MODULE_MANAGEMENT, array($module->getLabel($cms_language)), MOD_CMS_I18N_CODENAME),
						'objectId'		=> $module->getCodename(),
						'url'			=> PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/items.php',
						'module'		=> $module->getCodename(),
						'class'			=> 'atm-elements',
					);
				}
			}
			$objectsInfos[] = array(
				'label'			=> $cms_language->getMessage(self::MESSAGE_POLYMOD_MODULE, false, MOD_CMS_I18N_CODENAME),
				'adminLabel'	=> $cms_language->getMessage(self::MESSAGE_POLYMOD_MODULE, false, MOD_CMS_I18N_CODENAME),
				'description'	=> $cms_language->getMessage(self::MESSAGE_POLYMOD_MODULE_LABELS_MANAGEMENT, false, MOD_CMS_I18N_CODENAME),
				'url'			=> PATH_ADMIN_MODULES_WR.'/'.MOD_CMS_I18N_CODENAME.'/items.php',
				'module'		=> 'polymod',
				'objectId'		=> 'polymod',
				'class'			=> 'atm-elements',
			);
		}
		return $objectsInfos;
	}
}
?>