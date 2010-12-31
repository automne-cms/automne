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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Class CMS_language
  *
  * Manages a language representation
  *
  * @package Automne
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Andre Haynes <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
 */

class CMS_language extends CMS_grandFather
{
	/**
	  * label
	  * @var string
	  * @access private
	  */
	protected $_label;

	/**
	  * Code (2-chars code)
	  * @var string
	  * @access private
	  */
	protected $_code;

	/**
	  * Date format, see http://www.php.net/manual/en/function.date.php for available format. Only indicate day, month and year though.
	  * @var string
	  * @access private
	  */
	protected $_dateFormat;

	/**
	  * Is the language available for backoffice use ?
	  * @var boolean
	  * @access private
	  */
	protected $_availableForBackoffice = false;

	/**
	  * What are the codenames of the modules that can't use this language
	  * @var array(string)
	  * @access private
	  */
	protected $_modulesDenied = array();

	/**
	  * All messages allready prefetched for this session
	  * @var array(string)
	  * @access private
	  */
	protected $_prefetched = array();
	
	/**
	  * All messages constant declaration.
	  * @var array(string)
	  * @access private
	  */
	protected $_prefetchStatus = array();
	
	/**
	  * Constructor.
	  * Build the language by its code
	  *
	  * @return void
	  * @access public
	  */
	function __construct($code = '') {
		static $languageObject;
		if ($code) {
			if (!isset($languageObject[$code])) {
				// Get Language label
				$sql = "
					select 
						*
					from
						languages
					where
						code_lng='".SensitiveIO::sanitizeSQLString($code)."'
				";
				$q = new CMS_query($sql);
				
				if ($q->getNumRows()) {
					$data = $q->getArray();
					$this->_code = $code;
					$this->_label = $data["label_lng"];
					$this->_dateFormat = $data["dateFormat_lng"];
					$this->_availableForBackoffice = $data["availableForBackoffice_lng"];
					$this->_modulesDenied = explode(';', $data["modulesDenied_lng"]);
				} else {
					$this->raiseError("Unknown code: ".$code);
				}
				$languageObject[$code] = $this;
			} else {
				$this->_code = $languageObject[$code]->_code;
				$this->_label = $languageObject[$code]->_label;
				$this->_dateFormat = $languageObject[$code]->_dateFormat;
				$this->_availableForBackoffice = $languageObject[$code]->_availableForBackoffice;
				$this->_modulesDenied = $languageObject[$code]->_modulesDenied;
			}
		}
	}
	
	/**
	  * Get the message translated into the specified language
	  *
	  * @param integer $messageId The ID of the message to get
	  * @param array(string) $parameters An array of parameters which will replace %s in the returned string
	  * @param string $module The codename of the module owner of the message
	  * @param boolean $usePriority : If message does not exists, use language priority to get it (default : true).
	  * @return string
	  * @access public
	  */
	function getMessage($messageId, $parameters = false, $module = MOD_STANDARD_CODENAME, $usePriority = true) {
		if (SensitiveIO::isPositiveInteger($messageId)) {
			if (!($string = $this->_getPrefetchedMessage($messageId, $module))) {
				$sql = "
					select
						*
					from
						messages
					where
						id_mes = '".io::sanitizeSQLString($messageId)."' 
						and module_mes = '" .io::sanitizeSQLString($module). "'
						and language_mes = '" .io::sanitizeSQLString($this->_code). "'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
					$this->_storeMessage($messageId, $module, $data['message_mes']);
					if ($parameters) {
						$replacement = SensitiveIO::arraySprintf($data['message_mes'], $parameters);
						if (!$replacement) {
							return $data['message_mes'];
						} else {
							return $replacement;
						}
					} else {
						return $data['message_mes'];
					}
				} elseif ($usePriority) {
					$sql = "
						select
							*
						from
							messages
						where
							id_mes = '".io::sanitizeSQLString($messageId)."' 
							and module_mes = '" .io::sanitizeSQLString($module). "'
							and language_mes = '" .io::sanitizeSQLString(APPLICATION_DEFAULT_LANGUAGE). "'
					";
					$q = new CMS_query($sql);
					if ($q->getNumRows()) {
						$data = $q->getArray();
						$this->_storeMessage($messageId, $module, $data['message_mes']);
						if ($parameters) {
							$replacement = SensitiveIO::arraySprintf($data['message_mes'], $parameters);
							if (!$replacement) {
								return $data['message_mes'];
							} else {
								return $replacement;
							}
						} else {
							return $data['message_mes'];
						}
					}
				}
				//try to get message from old table
				$sql = "SHOW TABLES LIKE 'I18NM_messages'";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$string = $this->_getOldMessage($messageId, $parameters, $module);
					if (!$string) {
						$this->raiseError("Unknown message Id : ".$messageId." for module:".$module);
						return '';
					}
				} else {
					$this->raiseError("Unknown message Id : ".$messageId." for module:".$module);
					return '';
				}
				return $string;
			} else {
				if ($parameters) {
					$replacement = SensitiveIO::arraySprintf($string, $parameters);
					if (!$replacement) {
						return $string;
					} else {
						return $replacement;
					}
				} else {
					return $string;
				}
			}
		} else {
			$this->raiseError("messageId is not a positive integer : ".$messageId);
			return $messageId;
		}
	}

	/**
	  * Get all the messages
	  *
	  * @param integer $messageId The ID of the message to get
	  * @param string $module The codename of the module owner of the message
	  * @return string
	  *
	  * @access public
	  */
	public static function getMessages($messageId, $module=MOD_STANDARD_CODENAME) {
		if (!SensitiveIO::isPositiveInteger($messageId)) {
			$this->raiseError("messageId is not a positive integer : ".$messageId);
			return false;
		}
		$oQuery = new CMS_query('
			SELECT `language_mes`, `message_mes`
			FROM `messages`
			WHERE `module_mes` = \''.io::sanitizeSQLString($module).'\'
			AND `id_mes` = 1
		');
		if ($oQuery->getNumRows() < 1) {
			return false;
		}
		$aLabels = array();
		foreach ($oQuery->getAll(PDO::FETCH_ASSOC) as $aRow) {
			$aLabels[$aRow['language_mes']] = $aRow['message_mes'];
		}
		return $aLabels;
	}

	/**
      * Get the message translated into the specified language
	  * old function keeped for compatibility with old modules
      *
      * @param integer $messageId The ID of the message to get
      * @param array(string) $parameters An array of parameters which will replace %s in the returned string
      * @param string $module The codename of the module owner of the message
      * @return string
      * @access private
      */
    protected function _getOldMessage($messageId, $parameters = false, $module = '') {
    	if (SensitiveIO::isPositiveInteger($messageId)) {
			if (!($string = $this->_getPrefetchedMessage($messageId, $module))) {
				$sql = "
					select
						*
					from
						I18NM_messages
					where
						id='".io::sanitizeSQLString($messageId)."' 
						and module='" .io::sanitizeSQLString($module). "'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
					$string = isset($data[$this->_code]) ? $data[$this->_code] : $data[APPLICATION_DEFAULT_LANGUAGE];
					$this->_storeMessage($messageId, $module, $string);
					if ($parameters) {
						$replacement = SensitiveIO::arraySprintf($string, $parameters);
						if (!$replacement) {
							return $string;
						} else {
							return $replacement;
						}
					} else {
						return $string;
					}
				} else {
					return '';
				}
			} else {
				if ($parameters) {
					$replacement = SensitiveIO::arraySprintf($string, $parameters);
					if (!$replacement) {
						return $string;
					} else {
						return $replacement;
					}
				} else {
					return $string;
				}
			}
		} else {
			$this->raiseError("messageId is not a positive integer : ".$messageId);
			return $messageId;
		}
	}
	
	/**
	  * Get the message with simple quotes escaped
	  *
	  * @param integer $messageId The ID of the message to get
	  * @param array(string) $parameters An array of parameters which will replace %s in the returned string
	  * @param string $module The codename of the module owner of the message
	  * @return string
	  * @access public
	  */
	function getJsMessage($messageId, $parameters = false, $module = MOD_STANDARD_CODENAME) {
		return sensitiveIO::sanitizeJSString($this->getMessage($messageId, $parameters, $module));
	}
	
	/**
	  * Get the code.
	  *
	  * @return string The language code
	  * @access public
	  */
	function getCode() {
		return $this->_code;
	}
	
	/**
	  * Set the code.
	  *
	  * @return boolean
	  * @access public
	  */
	function setCode($code) {
		$this->_code = $code;
		return true;
	}
	
	/**
	  * Get the label.
	  *
	  * @return string The language label
	  * @access public
	  */
	function getLabel() {
		return $this->_label;
	}
	
	/**
	  * Set the label.
	  *
	  * @return boolean
	  * @access public
	  */
	function setLabel($label) {
		$this->_label = $label;
		return true;
	}
	
	/**
	  * Get the date format.
	  *
	  * @return string The language date format
	  * @access public
	  */
	function getDateFormat() {
		return $this->_dateFormat;
	}
	
	/**
	  * Set the date format.
	  *
	  * @return boolean
	  * @access public
	  */
	function setDateFormat($format) {
		$this->_dateFormat = $format;
		return true;
	}
	
	/**
	  * Is this language available for backoffice use ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isAvailableForBackoffice() {
		return $this->_availableForBackoffice;
	}
	
	/**
	  * Is this language available for backoffice use ?
	  *
	  * @return boolean
	  * @access public
	  */
	function setAvailableForBackoffice($status) {
		$this->_availableForBackoffice = $status ? true : false;
		return true;
	}
	
	/**
	  * Get the array of modules codenames which can't use this language in their backoffice.
	  *
	  * @return array(string)
	  * @access public
	  */
	function getModulesDenied() {
		return $this->_modulesDenied;
	}
	
	/**
	  * Set the array of modules codenames which can't use this language in their backoffice.
	  *
	  * @return array(string)
	  * @access public
	  */
	function setModulesDenied($modules) {
		if (!is_array($modules)) {
			return false;
		}
		$this->_modulesDenied = $modules;
		return true;
	}
	
	/**
	  * Writes the language Data into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		if (!$this->_code) {
			$this->raiseError("missing language code");
			return false;
		}
		$sql_fields = "
			code_lng='".SensitiveIO::sanitizeSQLString($this->_code)."',
			label_lng='".SensitiveIO::sanitizeSQLString($this->_label)."',
			dateFormat_lng='".SensitiveIO::sanitizeSQLString($this->_dateFormat)."',
			availableForBackoffice_lng='".SensitiveIO::sanitizeSQLString($this->_availableForBackoffice)."',
			modulesDenied_lng='".SensitiveIO::sanitizeSQLString(implode(';', $this->_modulesDenied))."'
		";
		$sql = "
			replace into
				languages
			set
				".$sql_fields;
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		}
		return true;
	}
	
	/**
	  * Get the date format mask.
	  *
	  * @return string The language date format mask
	  * @access public
	  */
	function getDateFormatMask() {
		$mask = str_replace("d", $this->getMessage(MESSAGE_ABBREVIATION_DAY), $this->_dateFormat);
		$mask = str_replace("m", $this->getMessage(MESSAGE_ABBREVIATION_MONTH), $mask);
		$mask = str_replace("Y", $this->getMessage(MESSAGE_ABBREVIATION_YEAR), $mask);
		return $mask;
	}
	
	/**
	  * Start prefetching for a given module 
	  * - Start constant declarion comparaison
	  *
	  * @param string $module The codename of the module owner of the message
	  * @return boolean
	  * @access public
	  */
	function startPrefetch($module = MOD_STANDARD_CODENAME) {
		$constants = get_defined_constants(true);
		if (isset($constants['user'])) {
			$this->_prefetchStatus[$module] = $constants['user'];
		} else {
			$this->_prefetchStatus[$module] = array();
		}
		return true;
	}
	
	/**
	  * End prefetching for a given module 
	  * - End constant declarion comparaison
	  * - Get all messages for all new constants declared
	  *
	  * @param string $module The codename of the module owner of the message
	  * @return boolean
	  * @access public
	  */
	function endPrefetch($module = MOD_STANDARD_CODENAME) {
		$constants = get_defined_constants(true);
		if (!isset($this->_prefetchStatus[$module]) || !is_array($this->_prefetchStatus[$module])) {
			$this->raiseError("Try to end message prefetch which not already started");
			return false;
		}
		$diff = array_diff_assoc((array) @$constants['user'], $this->_prefetchStatus[$module]);
		if (!$diff) {
			return true;
		}
		$sql = "
			select
				*
			from
				messages
			where
				id_mes in (".implode($diff, ',').")
				and module_mes = '" . $module . "'
				and language_mes = '" .io::sanitizeSQLString($this->_code). "'
		";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			while ($data = $q->getArray()) {
				$this->_storeMessage($data['id_mes'], $data['module_mes'], $data['message_mes']);
			}
		}
		return true;
	}
	
	/**
	  * Store a message already loaded from DB for further access
	  *
	  * @param integer $messageId The message Id to store
	  * @param string $module The codename of the module owner of the message
	  * @param string $message The message to store
	  * @return boolean
	  * @access private
	  */
	protected function _storeMessage($messageId, $module = MOD_STANDARD_CODENAME, $message) {
		$this->_prefetched[$module][$this->_code][$messageId] = $message;
		return true;
	}
	
	/**
	  * Get a message stored
	  *
	  * @param integer $messageId The message Id to store
	  * @param string $module The codename of the module owner of the message
	  * @return string if message is already prefetched, false otherwise
	  * @access private
	  */
	protected function _getPrefetchedMessage($messageId, $module = MOD_STANDARD_CODENAME) {
		if (!isset($this->_prefetched[$module][$this->_code][$messageId])) {
			return false;
		}
		return $this->_prefetched[$module][$this->_code][$messageId];
	}
	
	/**
	 * Return the next module message id
	 * @return	the highest module message id + 1
	 */
	public function getNextMessageId($sCodename) {
		$oQuery = new CMS_query("
			SELECT max(id_mes) as max
			FROM messages
			WHERE module_mes = '".SensitiveIO::sanitizeSQLString($sCodename)."'
		");
		if ($oQuery->getNumRows() > 0) {
			return 1 + (int) $oQuery->getValue('max');
		} else {
			return 1;
		}
	}

	/**
	 * Create messages.
	 * @var	string	$sCodename	Module's codename.
	 * @var	array	$aMessages	Localised message. $sLanguageCode => $sMessage
	 * @return					Id of the inserted message.
	 */
	public function createMessage($sCodename, $aMessages) {
		$iId = CMS_language::getNextMessageId($sCodename);
		foreach ($aMessages as $sLanguageCode => $sMessage) {
			$oQuery = new CMS_query("
				INSERT INTO
					messages
				SET
					id_mes = ".SensitiveIO::sanitizeSQLString($iId).",
					module_mes = '".SensitiveIO::sanitizeSQLString($sCodename)."',
					language_mes = '".SensitiveIO::sanitizeSQLString($sLanguageCode)."',
					message_mes = '".SensitiveIO::sanitizeSQLString($sMessage)."'
			");
		}
		return $iId;
	}
	
	/**
	 * Update messages.
	 * @var	string	$sCodename	Module's codename.
	 * @var	integer	$iId		Messages id.
	 * @var	array	$aMessages	Localised message. $sLanguageCode => $sMessage
	 * @return					boolean
	 */
	public function updateMessage($sCodename, $iId, $aMessages) {
		foreach ($aMessages as $sLanguageCode => $sMessage) {
			$oQuery = new CMS_query("
				replace into
					messages
				set
					id_mes = ".SensitiveIO::sanitizeSQLString($iId).",
					module_mes = '".SensitiveIO::sanitizeSQLString($sCodename)."',
					language_mes = '".SensitiveIO::sanitizeSQLString($sLanguageCode)."',
					message_mes = '".SensitiveIO::sanitizeSQLString($sMessage)."'
			");
			if ($oQuery->hasError()) {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Delete messages.
	 * @var	string	$sCodename	Module's codename.
	 * @var	integer	$iId		Messages id.
	 * @return					boolean
	 */
	public function deleteMessage($sCodename, $iId) {
		$oQuery = new CMS_query("
			delete from
				messages
			where
				id_mes = ".SensitiveIO::sanitizeSQLString($iId)."
				and module_mes = '".SensitiveIO::sanitizeSQLString($sCodename)."'
		");
		if ($oQuery->hasError()) {
			return false;
		}
		return true;
	}
}
?>