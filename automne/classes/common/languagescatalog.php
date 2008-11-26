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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: languagescatalog.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_languagesCatalog
  *
  * Manages the langauges collection
  *
  * @package CMS
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_languagesCatalog extends CMS_grandFather
{
	/**
	  * Get all the available languages for backoffice use (no module specified) or for a module backoffice.
	  * Static function.
	  *
	  * @param string $module The codename of a module we want the languages of.
	  * @return array(CMS_language) The available languages sorted by label
	  * @access public
	  */
	function getAllLanguages($module = false, $orderBy="label_lng")
	{
		static $languagesCatalog;
		if (isset($languagesCatalog[($module) ? $module : 'all'])) {
			return $languagesCatalog[($module) ? $module : 'all'];
		}
		$sql = "
			select
				code_lng
			from
				languages
		";
		
		if (!$module) {
			$sql .= 'where availableForBackoffice_lng=1';
		}
		if ($orderBy) {
			$sql .= '
				order by
					'.$orderBy.'
			';
		}
		$q = new CMS_query($sql);
		$languages = array();
		while ($code = $q->getValue("code_lng")) {
			$lng = new CMS_language($code);
			if (!$lng->hasError() && (!$module || !in_array($module, $lng->getModulesDenied()))) {
				$languages[$code] = $lng;
			}
		}
		$languagesCatalog[($module) ? $module : 'all'] = $languages;
		return $languages;
	}
	
	/**
	  * Get a language by its code.
	  * Static function.
	  *
	  * @param string $code The language code
	  * @return CMS_language The found language, false if not found
	  * @access public
	  */
	function getByCode($code) {
		static $languages;
		if (!isset($languages[$code])) {
			$languages[$code] = new CMS_language($code);
			if ($languages[$code]->hasError()) {
				unset($languages[$code]);
				return false;
			}
		} 
		return $languages[$code];
	}
	
	/**
	  * Get the default language.
	  *
	  * @param boolean guessFromNavigator : try to guess default user language from HTTP_ACCEPT_LANGUAGE (default : false)
	  * @return CMS_language The default language
	  * @access public
	  */
	function getDefaultLanguage($guessFromNavigator = false)
	{
		if ($guessFromNavigator) {
			//load language object from get value if any
			if (isset($_GET["language"]) && SensitiveIO::isInSet($_GET["language"], array_keys(CMS_languagesCatalog::getAllLanguages()))) {
				$language = CMS_languagesCatalog::getByCode($_GET["language"]);
				if ($language) {
					return $language;
				}
			} elseif (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) && SensitiveIO::isInSet(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), array_keys(CMS_languagesCatalog::getAllLanguages()))) {
				$language = CMS_languagesCatalog::getByCode(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2));
				if ($language) {
					return $language;
				}
			}
		}
		return CMS_languagesCatalog::getByCode(ADMINISTRATION_DEFAULT_LANGUAGE);
	}
}
?>