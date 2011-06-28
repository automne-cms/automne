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
  * static Class CMS_cache
  * Represent a cache object
  *
  * @package Automne
  * @subpackage files
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_cache extends CMS_grandFather {
	/**
	  * The cache parameters
	  * @var array
	  * @access private
	  */
	protected $_parameters = array();
	
	/**
	  * The Zend cache object
	  * @var object
	  * @access private
	  */
	protected $_cache;
	
	/**
	  * Does the cache has an auto lifetime ?
	  * @var boolean
	  * @access private
	  */
	protected $_auto = false;
	
	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param string $hash the cache hash to use
	  * @param string $type : the type of the cache to use
	  * @param mixed $lifetime : the cache lifetime
	  * @return void
	  * @access public
	  */
	function __construct($hash, $type, $lifetime = null, $contextAware = false) {
		if ($contextAware) {
			$this->_parameters['hash'] = $hash.'_'.CMS_context::getContextHash();
		} else {
			$this->_parameters['hash'] = $hash;
		}
		//normalize cache lifetime
		if ($lifetime == 'false' || $lifetime == '0' || $lifetime === false || $lifetime === 0) {
			$lifetime = false;
		}
		if ($lifetime == 'true' || $lifetime == 'auto' || $lifetime == '1' || $lifetime === true || $lifetime === 1) {
			//this definition do not use PHP so use default cache lifetime
			$lifetime = CACHE_MODULES_DEFAULT_LIFETIME;
			//set this cache as auto lifetime
			$this->_auto = true;
		}
		if (io::isPositiveInteger($lifetime)) {
			$lifetime = (int) $lifetime;
		}
		
		$this->_parameters['type'] = io::sanitizeAsciiString($type);
		$this->_parameters['lifetime'] = $lifetime ? $lifetime : null;
		
		//check cache dir
		$cachedir = new CMS_file(PATH_CACHE_FS.'/'.$this->_parameters['type'], CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
		if (!$cachedir->exists()) {
			$cachedir->writeTopersistence();
		}
		
		//Cache options
		$frontendOptions = array(
			'lifetime' 					=> $this->_parameters['lifetime'],											// cache duration
			'caching' 					=> $this->_parameters['lifetime'] === null ? false : CACHE_MODULES_DATAS,	// activate cache
			'automatic_cleaning_factor'	=> 50,																		// clean cache each 50 writing
			'automatic_serialization'	=> true,																	// automatic cache serialization
		);
		$backendOptions = array(
			'cache_dir'					=> PATH_CACHE_FS.'/'.$this->_parameters['type'],		// Directory where the cache files are stored
			'cache_file_umask'			=> octdec(FILES_CHMOD),
			'hashed_directory_umask'	=> octdec(DIRS_CHMOD),
			'hashed_directory_level'	=> 1,
		);
		// getting a Zend_Cache_Core object
		if (!class_exists('Zend_Cache')) {
			die('not found ....');
		}
		try {
			$this->_cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
		} catch (Zend_Cache_Exception $e) {
			$this->raiseError($e->getMessage());
			return false;
		}
		if (!isset($this->_cache) || !is_object($this->_cache)) {
			$this->raiseError('Error : Zend cache object does not exists');
			return false;
		}
	}
	
	/**
	  * Does cache content exists
	  *
	  * @return boolean
	  * @access public
	  */
	function exist() {
		if (!isset($this->_cache) || !is_object($this->_cache)) {
			$this->raiseError('Error : Zend cache object does not exists');
			return false;
		}
		try {
			return !$_POST && !isset($_REQUEST['atm-skip-cache']) && $this->_cache->test($this->_parameters['hash']);
		} catch (Zend_Cache_Exception $e) {
			$this->raiseError($e->getMessage());
			return false;
		}
	}
	
	/**
	  * Load cache content
	  *
	  * @return string : the cache content
	  * @access public
	  */
	function load() {
		if (!isset($this->_cache) || !is_object($this->_cache)) {
			$this->raiseError('Error : Zend cache object does not exists');
			return false;
		}
		try {
			return $this->_cache->load($this->_parameters['hash']);
		} catch (Zend_Cache_Exception $e) {
			$this->raiseError($e->getMessage());
			return false;
		}
	}
	
	/**
	  * Save cache content
	  *
	  * @param string content : the cache content to save
	  * @param array $metas : the cache metas to set
	  * @return boolean
	  * @access public
	  */
	function save($content, $metas = array()) {
		if (!isset($this->_cache) || !is_object($this->_cache)) {
			$this->raiseError('Error : Zend cache object does not exists');
			return false;
		}
		$tags = $this->_createTags($metas);
		try {
			return $this->_cache->save($content, $this->_parameters['hash'], $tags);
		} catch (Zend_Cache_Exception $e) {
			$this->raiseError($e->getMessage());
			return false;
		}
	}
	
	/**
	  * Clear cache by metas
	  *
	  * @param array $metas : the cache metas to clear cache of
	  * @param contant $mode : the zend cache constant to clean matching cache
	  *		Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG (default)
	  *  	Zend_Cache::CLEANING_MODE_MATCHING_TAG
	  * 	Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG
	  * @return boolean
	  * @access public
	  */
	function clear($metas = array(), $mode = Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG) {
		if (!isset($this->_cache) || !is_object($this->_cache)) {
			$this->raiseError('Error : Zend cache object does not exists');
			return false;
		}
		if ($metas) {
			//delete some module cache which match all given metas
			$tags = $this->_createTags($metas);
			try {
				return $this->_cache->clean($mode, $tags);
			} catch (Zend_Cache_Exception $e) {
				$this->raiseError($e->getMessage());
				return false;
			}
		} else {
			//delete all type cache
			return CMS_file::deltree(PATH_CACHE_FS.'/'.$this->_parameters['type'], false);
		}
	}
	
	/**
	  * Get zend cache ids by metas
	  *
	  * @param array $metas : the cache metas to get
	  * @param contant $mode : the zend cache constant to clean matching cache
	  *		Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG
	  *  	Zend_Cache::CLEANING_MODE_MATCHING_TAG (default)
	  * 	Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG
	  * @return array of Zend cache ids
	  * @access public
	  */
	function getByMetas($metas, $mode = Zend_Cache::CLEANING_MODE_MATCHING_TAG) {
		if (!isset($this->_cache) || !is_object($this->_cache)) {
			$this->raiseError('Error : Zend cache object does not exists');
			return false;
		}
		$tags = $this->_createTags($metas);
		try {
			return $this->_cache->getIdsMatchingTags($mode, $tags);
		} catch (Zend_Cache_Exception $e) {
			$this->raiseError($e->getMessage());
			return false;
		}
	}
	
	/**
	  * Convert cache metas into Zend cache tags
	  *
	  * @param array $metas : the cache metas to convert
	  * @return array Zend cache tags
	  * @access private
	  */
	protected function _createTags($metas) {
		$tags = array();
		if (!is_array($metas)) {
			return $tags;
		}
		foreach ($metas as $name => $value) {
			if (is_array($value)) {
				foreach ($value as $aValue) {
					$tag = str_replace('-', '_', io::sanitizeURLString($name.'-'.$aValue));
					$tags[$tag] = $tag;
				}
			} else {
				$tag = str_replace('-', '_', io::sanitizeURLString($name.'-'.$value));
				$tags[$tag] = $tag;
			}
		}
		$tags = array_values($tags);
		return $tags;
	}
	
	
	/**
	  * Start cache buffering
	  * All output starting from this method call will be recorded to be saved in cache
	  *
	  * @return void
	  * @access public
	  */
	function start() {
		ob_start();
	}
	
	/**
	  * End output buffering and save result to cache
	  *
	  * @return string : the buffered content saved into cache
	  * @access public
	  */
	function endSave() {
		$content = ob_get_contents();
		ob_end_clean();
		if (!$_POST && !isset($_REQUEST['atm-skip-cache'])) {
			//Save content to cache
			$cachedElements = array();
			if (preg_match_all('#<!--{elements:(.*)}-->#Us', $content, $matches)) {
				if (isset($matches[1])) {
					foreach ($matches[1] as $match) {
						$elements = @unserialize(base64_decode($match));
						if (is_array($elements)) {
							$cachedElements = array_merge_recursive($elements, $cachedElements);
						}
						unset($elements);
					}
				}
				unset($matches);
			}
			//do not save content if cache has auto lifetime and content has phpnode or random or form elements
			if ($this->_auto && 
				(isset($cachedElements['phpnode']) && $cachedElements['phpnode'])
				|| (isset($cachedElements['random']) && $cachedElements['random'])
				|| (isset($cachedElements['form']) && $cachedElements['form'])) {
				return $content;
			}
			$this->save($content, $cachedElements);
		}
		return $content;
	}
	
	/**
	  * Clear a type cache
	  *
	  * @param string $type : the cache type to clear
	  * @return boolean
	  * @access public
	  * @static
	  */
	function clearTypeCache($type) {
		$type = io::sanitizeAsciiString($type);
		if (!$type) {
			CMS_grandFather::raiseError('$type must be a valid cache type');
			return false;
		}
		if (is_dir(PATH_CACHE_FS.'/'.$type)) {
			//delete all type cache
			if (!CMS_file::deltree(PATH_CACHE_FS.'/'.$type, false)) {
				CMS_grandFather::raiseError('Cannot clear cache for type '.$type);
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}
	}
	
	/**
	  * Clear type cache using metas
	  *
	  * @param string $type : the cache type to clear
	  * @param array $metas : the cache metas to clear
	  * @param contant $mode : the zend cache constant to clean matching cache
	  *		Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG (default)
	  *  	Zend_Cache::CLEANING_MODE_MATCHING_TAG
	  * 	Zend_Cache::CLEANING_MODE_NOT_MATCHING_TAG
	  * @return boolean
	  * @access public
	  * @static
	  */
	function clearTypeCacheByMetas($type, $metas, $mode = Zend_Cache::CLEANING_MODE_MATCHING_ANY_TAG) {
		$type = io::sanitizeAsciiString($type);
		//Convert metas into tags
		$tags = CMS_cache::_createTags($metas);
		//CMS_grandFather::log('Clear cache '.$type.' for metas '.print_r($tags, true).' ('.io::getCallInfos().')');
		$return = true;
		//check cache dir
		$cachedir = new CMS_file(PATH_CACHE_FS.'/'.$type, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
		if ($cachedir->exists()) {
			//Frontend cache options
			$frontendOptions = array(
				'lifetime' 					=> null,							// cache duration
				'caching' 					=> true,							// activate cache
				'automatic_cleaning_factor'	=> 10,								// clean cache each 10 writing
			);
			//Backend cache options
			$backendOptions = array(
				'cache_dir'					=> PATH_CACHE_FS.'/'.$type,		// Directory where the cache files are stored
				'cache_file_umask'			=> octdec(FILES_CHMOD),
				'hashed_directory_umask'	=> octdec(DIRS_CHMOD),
				'hashed_directory_level'	=> 1,
			);
			// getting a Zend_Cache_Core object
			try {
				$cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
			} catch (Zend_Cache_Exception $e) {
				CMS_grandFather::raiseError($e->getMessage());
			}
			if ($cache) {
				try {
					$return = $cache->clean($mode, $tags);
				} catch (Zend_Cache_Exception $e) {
					CMS_grandFather::raiseError($e->getMessage());
					$return = false;
				}
			} else {
				$return = false;
			}
		}
		return $return;
	}
	
	/**
	  * Wrap given PHP code with PHP cache code
	  *
	  * @param string $hash : the cache hash to use
	  * @param string $content : the PHP code to wrap
	  * @param string $lifetime : the lifetime to use for cache (default : auto)
	  * @return string : the new PHP code wrapped with the cache code
	  * @access public
	  * @static
	  */
	static function wrapCode($hash, $content, $lifetime = 'auto') {
		return '<?php'."\n".
		'$cache_'.$hash.' = new CMS_cache(\''.$hash.'\', \'polymod\', \''.$lifetime.'\', true);'."\n".
		'if ($cache_'.$hash.'->exist()):'."\n".
		'	//Get content from cache'."\n".
		'	$cache_'.$hash.'_content = $cache_'.$hash.'->load();'."\n".
		'else:'."\n".
		'	$cache_'.$hash.'->start();'."\n".
		'	?>'."\n".
			$content."\n".
		'	<?php '."\n".
		'	$cache_'.$hash.'_content = $cache_'.$hash.'->endSave();'."\n".
		'endif;'."\n".
		'unset($cache_'.$hash.');'."\n".
		'echo $cache_'.$hash.'_content;'."\n".
		'unset($cache_'.$hash.'_content);'."\n".
		'?>'."\n";
	}
}
?>