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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: languagescatalog.php,v 1.3 2010/03/08 16:43:27 sebastien Exp $

/**
  * Class CMS_languagesCatalog
  *
  * Manages the langauges collection
  *
  * @package Automne
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
	  * @param string $orderBy The ordering key to use (default : label_lng)
	  * @return array(CMS_language) The available languages sorted by label
	  * @access public
	  */
	static function getAllLanguages($module = false, $orderBy="label_lng") {
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
		
		if (!$module && $module != 'all') {
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
	static function getByCode($code) {
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
	static function getDefaultLanguage($guessFromNavigator = false)
	{
		if ($guessFromNavigator) {
			//load language object from get value if any
			if (isset($_GET["language"]) && SensitiveIO::isInSet($_GET["language"], array_keys(CMS_languagesCatalog::getAllLanguages()))) {
				$language = CMS_languagesCatalog::getByCode($_GET["language"]);
				if ($language) {
					return $language;
				}
			} elseif (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) && SensitiveIO::isInSet(io::substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), array_keys(CMS_languagesCatalog::getAllLanguages()))) {
				$language = CMS_languagesCatalog::getByCode(io::substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2));
				if ($language) {
					return $language;
				}
			}
		}
		return CMS_languagesCatalog::getByCode(APPLICATION_DEFAULT_LANGUAGE);
	}
	
	/**
	  * Search messages
	  * Static function.
	  *
	  * @param string module : module to search messages
	  * @param string search : search message by value
	  * @param array languagesOnly : limit search to given languages codes
	  * @param array options : search options
	  * @param string direction : search is ordered by results id. Specify order direction (asc or desc). Default : asc
	  * @param integer start : search start offset
	  * @param integer limit : search limit (default : 0 : unlimited)
	  * @param integer resultsnb : return results count by reference
	  * @return array(id => msg)
	  * @access public
	  */
	static function searchMessages($module, $search = '', $languagesOnly = array(), $options = array(), $direction = 'asc', $start = 0, $limit = 0, &$resultsnb) {
		$start = (int) $start;
		$limit = (int) $limit;
		$direction = (in_array(io::strtolower($direction), array('asc', 'desc'))) ? io::strtolower($direction) : 'asc';
		
		$emptyOnly = $idsOnly = false;
		if (is_array($options)) {
			$emptyOnly = isset($options['empty']) && $options['empty'] ? true : false;
			$idsOnly = isset($options['ids']) && is_array($options['ids']) ? $options['ids'] : false;
		}
		
		$keywordsWhere = $languagesWhere = $emptyWhere = $orderBy = $orderClause = $idsWhere = '';
		
		//get ids for which one message is missing
		if ($emptyOnly) {
			$qLanguages = new CMS_query("
				select 
					distinct language_mes
				from 
					messages
				where
					module_mes = '".io::sanitizeSQLString($module)."'
			");
			$qIds = new CMS_query("
				select 
					distinct id_mes
				from 
					messages
				where
					module_mes = '".io::sanitizeSQLString($module)."'
			");
			$allIds = $qIds->getAll(PDO::FETCH_COLUMN|PDO::FETCH_UNIQUE, 0);
			$missingIds = array();
			while ($language = $qLanguages->getValue('language_mes')) {
				$qLang = new CMS_query("
					select 
						distinct id_mes
					from 
						messages
					where
						module_mes = '".io::sanitizeSQLString($module)."'
						and language_mes='".$language."'
						and message_mes != ''
				");
				$ids = $qLang->getAll(PDO::FETCH_COLUMN|PDO::FETCH_UNIQUE, 0);
				$missingIds = array_merge($missingIds, array_diff($allIds, $ids));
			}
			if (!$missingIds) {
				$resultsnb = 0;
				return array();
			}
			$emptyWhere = ' and id_mes in ('.implode($missingIds, ',').')';
		}
		if ($idsOnly) {
			$idsWhere = ' and id_mes in ('.io::sanitizeSQLString(implode($idsOnly, ',')).')';
		}
		if ($search) {
			//clean user keywords (never trust user input, user is evil)
			$search = strtr($search, ",;", "  ");
			if (isset($options['phrase']) && $options['phrase']) {
				$search = str_replace(array('%','_'), array('\%','\_'), $search);
				if (htmlentities($search) != $search) {
					$keywordsWhere .= " and (
						message_mes like '%".sensitiveIO::sanitizeSQLString($search)."%' or message_mes like '%".sensitiveIO::sanitizeSQLString(htmlentities($search))."%'
					)";
				} else {
					$keywordsWhere .= " and message_mes like '%".sensitiveIO::sanitizeSQLString($search)."%'";
				}
			} else {
				$words=array();
				$words=array_map("trim",array_unique(explode(" ", io::strtolower($search))));
				$cleanedWords = array();
				foreach ($words as $aWord) {
					if ($aWord && $aWord!='' && io::strlen($aWord) >= 3) {
						$aWord = str_replace(array('%','_'), array('\%','\_'), $aWord);
						$cleanedWords[] = $aWord;
					}
				}
				if (!$cleanedWords) {
					//if no words after cleaning, return
					return array();
				}
				foreach ($cleanedWords as $cleanedWord) {
					$keywordsWhere .= ($keywordsWhere) ? " and " : '';
					if (htmlentities($aWord) != $aWord) {
						$keywordsWhere .= " (
							message_mes like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%' or message_mes like '%".sensitiveIO::sanitizeSQLString(htmlentities($cleanedWord))."%'
						)";
					} else {
						$keywordsWhere .= " (
							message_mes like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'
						)";
					}
				}
				$keywordsWhere = ' and ('.$keywordsWhere.')';
			}
		}
		if (is_array($languagesOnly) && $languagesOnly) {
			$languagesWhere = ' and language_mes in (\''.implode($languagesOnly,'\',\'').'\')';
		}
		
		$orderClause = "order by
			id_mes
			".$direction;
		
		$sql = "
			select
				id_mes as id
			from
				messages
			where 
			module_mes = '".io::sanitizeSQLString($module)."'
			".$keywordsWhere."
			".$languagesWhere."
			".$emptyWhere."
			".$idsWhere."
		";
		
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			$resultsnb = 0;
			return array();
		}
		$messageIds = array();
		$messageIds = $q->getAll(PDO::FETCH_COLUMN|PDO::FETCH_UNIQUE, 0);
		$sql = "
			select
				id_mes as id,
				module_mes as module,
				language_mes as language,
				message_mes as message
			from
				messages
			where 
				module_mes = '".io::sanitizeSQLString($module)."'
				and id_mes in (".implode($messageIds, ',').")
				".$orderClause."
		";
		
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			$resultsnb = 0;
			return array();
		}
		$messageGroups = array();
		$messageGroups = $q->getAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);
		
		$resultsnb = count($messageGroups);
		if ($limit) {
			$messageGroups = array_slice($messageGroups, $start, $limit, true);
		}
		$messages = array();
		foreach ($messageGroups as $key => $messageGroup) {
			$messages[$key]['id'] = $key;
			foreach ($messageGroup as $message) {
				$messages[$key][$message['language']] = $message['message'];
			}
		}
		return $messages;
	}
	
	/**
	  * Get all available languages codes from ISO 639-1 standard
	  * Static function.
	  *
	  * @return array(code => label)
	  * @access public
	  */
	public static function getAllLanguagesCodes() {
		if (!file_exists(PATH_PACKAGES_FS.'/files/iso639-1.txt')) {
			return array();
		}
		$codeFile = new CMS_file(PATH_PACKAGES_FS.'/files/iso639-1.txt');
		$languagesCodes = $codeFile->readContent('array');
		$return = array();
		foreach ($languagesCodes as $languagesCode) {
			if (substr($languagesCode, 0, 1) != '#') {
				list($code, $label) = explode("\t", $languagesCode);
				if (io::strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
					$label = utf8_decode($label);
				}
				$return[$code] = ucfirst($label);
			}
		}
		return $return;
	}
}
?>