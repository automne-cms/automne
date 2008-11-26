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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: language.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_language
  *
  * Manages a language representation
  *
  * @package CMS
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
	protected $_label = "Français";

	/**
	  * Code (2-chars code)
	  * @var string
	  * @access private
	  */
	protected $_code = "fr";

	/**
	  * Date format, see http://www.php.net/manual/en/function.date.php for available format. Only indicate day, month and year though.
	  * @var string
	  * @access private
	  */
	protected $_dateFormat = "d/m/y";

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
	  * All messages allready gets for this session
	  * @var array(string)
	  * @access private
	  */
	protected $_alreadyGet = array();
	
	/**
	  * Constructor.
	  * Build the language by its code
	  *
	  * @return void
	  * @access public
	  */
	function __construct($code = "fr") {
		static $languageObject;
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
	
	/**
	  * Get the message translated into the specified language
	  *
	  * @param integer $messageId The ID of the message to get
	  * @param array(string) $parameters An array of parameters which will replace %s in the returned string
	  * @param string $module The codename of the module owner of the message
	  * @return string
	  * @access public
	  */
	function getMessage($messageId, $parameters = false, $module = '') {
		static $languageGets;
		if ($module == '' && class_exists('CMS_module_standard')) {
			$module = MOD_STANDARD_CODENAME;
		}
		if (SensitiveIO::isPositiveInteger($messageId)) {
			$this->_alreadyGet = $languageGets;
			if (!isset($this->_alreadyGet[$this->_code.'-'.$messageId.'-'.$module])) {
				$sql = "
					select
						*
					from
						I18NM_messages
					where
						id='".$messageId."' 
						and module='" . $module . "'
				";
				$q = new CMS_query($sql);
				if ($q->getNumRows()) {
					$data = $q->getArray();
					$string = isset($data[$this->_code]) ? $data[$this->_code] : $data[APPLICATION_DEFAULT_LANGUAGE];
					$this->_alreadyGet[$this->_code.'-'.$messageId.'-'.$module]=$string;
					$languageGets = $this->_alreadyGet;
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
					$this->raiseError("Unknown message Id : ".$messageId." for module:".$module);
				}
			} else {
				$string=$this->_alreadyGet[$this->_code.'-'.$messageId.'-'.$module];
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
	function getJsMessage($messageId, $parameters = false, $module = false) {
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
	protected function _setCode($code) {
		static $codeExists;
		$code = trim($code);
		$return = false;
		if (!$codeExists[$code]) {
			$sql = "
				show
					columns
				from
					I18NM_messages
			";
			$q = new CMS_query($sql);
			while ($data = $q->getArray()) {
				if ($data["Field"] == $code) {
					$return = true;
					$this->_code = $code;
					$codeExists[$code] = true;
					break;
				}
			}
		} else {
			$return = true;
			$this->_code = $code;
		}
		return $return;
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
	  * Get the date format.
	  *
	  * @return string The language date format
	  * @access public
	  */
	function getDateFormat() {
		return $this->_dateFormat;
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
	  * Get the array of modules codenames which can't use this language in their backoffice.
	  *
	  * @return array(string)
	  * @access public
	  */
	function getModulesDenied() {
		return $this->_modulesDenied;
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
}
?>