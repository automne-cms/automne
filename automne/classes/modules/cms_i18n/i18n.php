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
  * Add useful methods for internationalization
  *
  * @package Automne
  * @subpackage cms_i18n
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_i18n extends CMS_grandFather
{
	/**
	  * Class vars
	  */
	private $_page = null;
	private $_pageId = null;
	private $_language = null;
	/**
	  * Create and get class instance
	  * This is a singleton : the class is always the same anywhere
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	private static $_instance = false;
	protected function __construct() {}
	static public function getInstance() {
		if (!CMS_i18n::$_instance) {
			CMS_i18n::$_instance = new CMS_i18n();
		}
		return CMS_i18n::$_instance;
	}

	public function getPage() {
		if (!is_object($this->_page) && io::isPositiveInteger($this->_pageId)) {
			$this->_page = CMS_tree::getPageByID($this->_pageId);
		} elseif(!is_object($this->_page)) {
			return false;
		}
		return $this->_page;
	}

	public function setPageId($pageID) {
		$this->_pageId = $pageID;
	}

	public function getPageId($pageID) {
		return $this->_pageId;
	}

	public function setLanguageCode($languageCode) {
		$this->_language = $languageCode;
	}

	public function getLanguageCode() {
		return $this->_language;
	}
	
	/**
	  * Set current CMS_i18n instance context
	  * 
	  * @param integer $pageID the id of the current page
	  * @param string $languageCode The language code to get translation to
	  * @return boolean
	  * @access public
	  * @static
	  */
	public static function setContext($pageID = '', $languageCode = '') {
		$instance = CMS_i18n::getInstance();
		if (io::isPositiveInteger($pageID)) {
			$instance->setPageId($pageID);
		}
		if ($languageCode) {
			$instance->setLanguageCode($languageCode);
		}
		return true;
	}
	
	/**
	  * Return a translated string for a given key
	  * 
	  * @param string $key the string key to get translation
	  * @param string $language The language code to get translation to
	  * @param mixed $parameters The parameters to replace in translation. Array or string (in this case, each parameter must be separated by :: )
	  * @return string : the stanslated string
	  * @access public
	  * @static
	  */
	public static function getTranslation($key, $language = '', $parameters = '') {
		static $messages;
		global $cms_language;
		//get current language if none given
		if (!$language) {
			$instance = CMS_i18n::getInstance();
			if ($instance->getLanguageCode()) {
				$language = $instance->getLanguageCode();
			} else {
				if (is_object($cms_language)) {
					$language = $cms_language->getCode();
				} else {
					//try to get language from page instance
					if (is_object($instance->getPage())) {
						$page = $instance->getPage();
						//get language from current page
						if (is_object($page) && !$page->hasError()) {
							$language = $page->getLanguage(true);
						}
					}
				}
				if ($language) {
					$instance->setLanguageCode($language);
				}
			}
		}
		if (!$language) {
			return false;
		}
		//does user want to show/hide used keys ?
		if (io::request('i18n-hide-keys')) {
			CMS_session::setSessionVar('i18n-show-keys', false);
		}
		if (io::request('i18n-show-keys') || CMS_session::getSessionVar('i18n-show-keys')) {
			if (!CMS_session::getSessionVar('i18n-show-keys')) {
				CMS_session::setSessionVar('i18n-show-keys', true);
			}
			return '['.$language.': '.$key.']';
		}
		if (!isset($messages[$key][$language])) {
			$q = new CMS_query("
				SELECT 
					msgref.message_mes as msg
				FROM 
					messages as keyref , messages as msgref 
				WHERE 
					keyref.module_mes = 'cms_i18n_vars'
					and msgref.module_mes = 'cms_i18n_vars'
					and keyref.module_mes = msgref.module_mes 
					and keyref.message_mes = '".io::sanitizeSQLString($key)."' 
					and keyref.id_mes = msgref.id_mes 
					and msgref.language_mes = '".io::sanitizeSQLString($language)."'
					and msgref.message_mes != ''
					GROUP BY 'msg'
			"); //group by for bug id 2474
			if ($q->getNumRows() == 1) {
				$messages[$key][$language] = $q->getValue('msg');
			} else {
				$messages[$key][$language] = false;
			}
		}
		if ($messages[$key][$language] === false) {
			if (SYSTEM_DEBUG) {
				return !CMS_i18n::keyExists($key) ? '[Unknown key: '.$key.']' : '[No &quot;'.$language.'&quot; message for key: '.$key.']';
			} else {
				if ($language != APPLICATION_DEFAULT_LANGUAGE) {
					return CMS_i18n::getTranslation($key, APPLICATION_DEFAULT_LANGUAGE, $parameters);
				}
				return '';
			}
		}
		if ($parameters) {
			$parameters = !is_array($parameters) ? explode('::', $parameters) : $parameters;
			// Allows to use %1$s, %2$s, ... , %n$s format.
			$replacement = vsprintf($messages[$key][$language], $parameters);
			if (!$replacement) {
				return $messages[$key][$language];
			} else {
				return $replacement;
			}
		}
		return $messages[$key][$language];
	}
	
	/**
	  * Does the given key translation exists
	  * Beware : an empty translation is a translation (and will return true)
	  * 
	  * @param string $key the string key to check
	  * @param string $language The specific language code to check. If false, method will return true if any language exists for the key. (default false)
	  * @return boolean
	  * @access public
	  * @static
	  */
	public static function keyExists($key, $language = false) {
		$sql = "
			SELECT 
				msgref.message_mes as msg
			FROM 
				messages as keyref , messages as msgref 
			WHERE 
				keyref.module_mes = 'cms_i18n_vars'
				and msgref.module_mes = 'cms_i18n_vars'
				and keyref.module_mes = msgref.module_mes 
				and keyref.message_mes = '".io::sanitizeSQLString($key)."' 
				and keyref.id_mes = msgref.id_mes ";
			if ($language) {
				$sql .= " and msgref.language_mes = '".io::sanitizeSQLString($language)."'";
			}
		$q = new CMS_query($sql);
		return $q->getNumRows() ? true : false;
	}
	
	/**
	  * Create a translation for a given key
	  * 
	  * @param string $key the string key to create
	  * @param mixed $value the translation string(s) to create. If a language is given, just a string is needed. If no language given, pass an array of strings. Format array(languageCode => string)
	  * @param string $language The language code to create (default false)
	  * @return boolean
	  * @access public
	  * @static
	  */
	public static function create($key, $value, $language = false) {
		if (CMS_i18n::keyExists($key, $language)) {
			CMS_grandFather::raiseError('Key '.$key.' already exists'.($language ? ' for language '.$language : ''));
			return false;
		}
		if (is_array($value) && !$language) {
			$value['key'] = $key;
			return CMS_language::createMessage('cms_i18n_vars', $value);
		} elseif (is_array($value) && $language && isset($value[$language])) {
			$value = array(
				'key'		=> $key,
				$language 	=> $value[$language]
			);
			return CMS_language::createMessage('cms_i18n_vars', $value);
		} elseif (!is_array($value) && $language) {
			$value = array(
				'key'		=> $key,
				$language 	=> $value
			);
			return CMS_language::createMessage('cms_i18n_vars', $value);
		}
		CMS_grandFather::raiseError('Incorrect value/language parameters given');
		return false;
	}
	
	/**
	  * Update a translation for a given key
	  * 
	  * @param string $key the string key to update
	  * @param mixed $value the translation string(s) to update. If a language is given, just a string is needed. If no language given, pass an array of strings. Format array(languageCode => string)
	  * @param string $language The language code to update (default false)
	  * @return boolean
	  * @access public
	  * @static
	  */
	public static function update($key, $value, $language = false) {
		if (!CMS_i18n::keyExists($key, $language)) {
			CMS_grandFather::raiseError('Key '.$key.' does not exists'.($language ? ' for language '.$language : ''));
			return false;
		}
		$id = CMS_i18n::getIdForKey($key);
		if (!io::isPositiveInteger($id)) {
			CMS_grandFather::raiseError('No messages Id found for key '.$key);
			return false;
		}
		if (is_array($value) && !$language) {
			$value['key'] = $key;
			return CMS_language::updateMessage('cms_i18n_vars', $id, $value);
		} elseif (is_array($value) && $language && isset($value[$language])) {
			$value = array(
				'key'		=> $key,
				$language 	=> $value[$language]
			);
			return CMS_language::updateMessage('cms_i18n_vars', $id, $value);
		} elseif (!is_array($value) && $language) {
			$value = array(
				'key'		=> $key,
				$language 	=> $value
			);
			return CMS_language::updateMessage('cms_i18n_vars', $id, $value);
		}
		CMS_grandFather::raiseError('Incorrect value/language parameters given');
		return false;
	}
	
	/**
	  * Delete a given key translation
	  * 
	  * @param string $key the string key to delete
	  * @return boolean
	  * @access public
	  * @static
	  */
	public static function delete($key) {
		if (!CMS_i18n::keyExists($key)) {
			CMS_grandFather::raiseError('Key '.$key.' does not exists');
			return false;
		}
		$id = CMS_i18n::getIdForKey($key);
		if (!io::isPositiveInteger($id)) {
			CMS_grandFather::raiseError('No messages Id found for key '.$key);
			return false;
		}
		return CMS_language::deleteMessage('cms_i18n_vars', $id);
	}
	
	/**
	  * Get messages Ids for a given translation key
	  * 
	  * @param string $key the string key to get id for
	  * @return integer
	  * @access public
	  * @static
	  */
	public static function getIdForKey($key) {
		$sql = "
			SELECT 
				id_mes
			FROM 
				messages
			WHERE 
				module_mes = 'cms_i18n_vars'
				and message_mes = '".io::sanitizeSQLString($key)."'";
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			return false;
		}
		return $q->getValue('id_mes');
	}
}