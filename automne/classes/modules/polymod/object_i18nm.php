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
// $Id: object_i18nm.php,v 1.5 2010/03/08 16:43:30 sebastien Exp $

/**
  * Class CMS_object_i18nm
  *
  * represent a i18nm message
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_i18nm extends CMS_grandFather
{
	/**
	  * Integer ID
	  * @var integer
	  * @access private
	  */
	protected $_ID;
	
	/**
	  * languages codes priority (used for missing languages)
	  * @var array
	  * @access private
	  */
	protected $_languageCodesPriority = array();
	
	/**
	  * languages labels
	  * @var array(string "languageCode" => string "label")
	  * @access private
	  */
	protected $_languageLabels = array();
	
	/**
	  * all values by languageCode
	  * @var array	(string "languageCode" => string "value")
	  * @access private
	  */
	protected $_values = array();
	
	/**
	  * all values allready in DB
	  * @var array	(string "languageCode")
	  * @access private
	  */
	protected $_DBKnown = array();
	
	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param integer $id DB id
	  * @param array $dbValues DB values
	  * @return void
	  * @access public
	  */
	public function __construct($id = 0, $dbValues=array())
	{
		static $i18nm;
		//load available languages
		$this->getAvailableLanguages_this();
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->setError("Id is not a positive integer : ".$id);
				return;
			}
			if (!isset($i18nm[$id])) {
				if ($id && !$dbValues) {
					$sql = "
						select
							*
						from
							mod_object_i18nm
						where
							id_i18nm ='".$id."'
					";
					$q = new CMS_query($sql);
					if ($q->getNumRows()) {
						$this->_ID = $id;
						while ($arr = $q->getArray()) {
							$this->_values[$arr["code_i18nm"]] = $arr['value_i18nm'];
							$this->_DBKnown[] = $arr["code_i18nm"];
						}
					} else {
						$this->setError("Unknown ID :".$id);
						return;
					}
				} elseif($id && is_array($dbValues) && $dbValues) {
					$this->_ID = $id;
					foreach ($dbValues as $code => $value) {
						$this->_values[$code] = $value;
						$this->_DBKnown[] = $code;
					}
				}
				$i18nm[$id] = $this;
			} else {
				//$this = $GLOBALS["polyModule"]["i18nm"][$id];
				$this->_ID = $id;
				$this->_values = $i18nm[$id]->_values;
				$this->_DBKnown = $i18nm[$id]->_DBKnown;
			}
		}
	}
	
	/**
	  * Get object ID
	  *
	  * @return integer, the DB object ID
	  * @access public
	  */
	public function getID()
	{
		return isset($this->_ID) ? $this->_ID : null;
	}
	
	/**
	  * Get available languages codes
	  *
	  * @return array, the available languages codes
	  * @access public
	  * @static
	  */
	public static function getAvailableLanguages() {
		static $availableLanguages, $languagesPriority;
		if (!is_array($availableLanguages)) {
			$availableLanguages = array();
			//check for polymod properly loaded
			$module =  (class_exists('CMS_polymod')) ? MOD_POLYMOD_CODENAME : '';
			//order by dateFormat to get fr in first place
			$languages = CMS_languagesCatalog::getAllLanguages($module);
			//set default language as first one
			$firstLanguage = $languages[APPLICATION_DEFAULT_LANGUAGE];
			unset($languages[APPLICATION_DEFAULT_LANGUAGE]);
			$languages = array_merge(array(APPLICATION_DEFAULT_LANGUAGE => $firstLanguage), $languages);
			
			foreach ($languages as $language) {
				$availableLanguages[$language->getCode()] = $language->getLabel();
				$languagesPriority[] = $language->getCode();
			}
		}
		return array_keys($availableLanguages);
	}

	/**
	  * Get available languages codes
	  *
	  * @return array, the available languages codes
	  * @access public
	  * Use for a non-static call of getAvailableLanguages
	  */
	// TODO : renommer la methode
	public function getAvailableLanguages_this(){
		static $availableLanguages, $languagesPriority;
		if (!is_array($availableLanguages)) {
			$availableLanguages = array();
			//check for polymod properly loaded
			$module =  (class_exists('CMS_polymod')) ? MOD_POLYMOD_CODENAME : '';
			//order by dateFormat to get fr in first place
			$languages = CMS_languagesCatalog::getAllLanguages($module);
			//set default language as first one
			$firstLanguage = $languages[APPLICATION_DEFAULT_LANGUAGE];
			unset($languages[APPLICATION_DEFAULT_LANGUAGE]);
			$languages = array_merge(array(APPLICATION_DEFAULT_LANGUAGE => $firstLanguage), $languages);
			
			foreach ($languages as $language) {
				$availableLanguages[$language->getCode()] = $language->getLabel();
				$languagesPriority[] = $language->getCode();
			}
		}
		$this->_languageLabels = $availableLanguages;
		$this->_languageCodesPriority = $languagesPriority;
		return array_keys($availableLanguages);
	}
	
	/**
	  * Sets a value for a given language code.
	  *
	  * @param string $languageCode the language code of the value to set
	  * @param mixed $value the value to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setValue($languageCode, $value)
	{
		if (io::strlen($languageCode) > 5) {
			$this->setError("Can't use a language code longuer than 5 caracters : ".$languageCode);
			return false;
		}
		$this->_values[$languageCode] = $value;
		return true;
	}
	
	/**
	  * get a value for a given language code if exist, else, return value by priority
	  *
	  * @param string $languageCode the language code of the value to get
	  * @param boolean $usePriority : use priority system if value is not found for given code
	  * @return string, the value
	  * @access public
	  */
	public function getValue($languageCode = '', $usePriority = true)
	{
		if ($languageCode && isset($this->_values[$languageCode]) && $this->_values[$languageCode]) {
			return $this->_values[$languageCode];
		}
		if ($usePriority) {
			foreach ($this->_languageCodesPriority as $priorityCode) {
				if (isset($this->_values[$priorityCode]) && $this->_values[$priorityCode]) {
					return $this->_values[$priorityCode];
				}
			}
		}
		return "";
	}
	
	/**
	  * get all the values
	  *
	  * @return	array	 the values
	  * @access	public
	  */
	public static function getValues($id)
	{
		$aLabels = array();
		$oQuery = new CMS_query('
			SELECT `code_i18nm`, `value_i18nm`
			FROM `mod_object_i18nm`
			WHERE `id_i18nm` = '.io::sanitizeSQLString($id).'
		');
		if ($oQuery->getNumRows() > 0) {
			foreach ($oQuery->getAll(PDO::FETCH_ASSOC) as $aRow) {
				$aLabels[$aRow['code_i18nm']] = $aRow['value_i18nm'];
			}
		}
		return $aLabels;
	}
	
	/**
	  * set all the values
	  *
	  * @param array $values the values to set : array(language code => value)
	  * @return	boolean
	  * @access	public
	  */
	public function setValues($values) {
		$return = true;
		foreach ($values as $sLanguageCode => $sLabel) {
			$return &= $this->setValue($sLanguageCode, $sLabel);
		}
		return $return;
	}

	/**
	  * get HTML admin (used to enter object values in admin)
	  *
	  * @return string : the html admin
	  * @access public
	  */
	public function getHTMLAdmin($prefixName, $textareaInput=false) {
		$html = '<table border="0" cellpadding="3" cellspacing="0" style="border-left:1px solid #4d4d4d; width:400px;">';
		$count = 0;
		foreach ($this->_languageLabels as $languageCode => $languageLabel) {
			$required = (!$count) ? '<span class="admin_text_alert">*</span> ':'';
			$input = (!$textareaInput) ? '<input type="text" size="30" name="'.$prefixName.$languageCode.'" class="admin_input_text" value="'.io::htmlspecialchars($this->getValue($languageCode, false)).'" />':'<textarea name="'.$prefixName.$languageCode.'" class="admin_long_textarea" cols="45" rows="2">'.io::htmlspecialchars($this->getValue($languageCode, false)).'</textarea>';
			$html .= '
			<tr>
				<td class="admin" align="right" style="width:80px;">'.$required.$languageLabel.'</td>
				<td class="admin">'.$input.'</td>
			</tr>';
			$count++;
		}
		$html .='
		<input type="hidden" name="'.$prefixName.'" value="'.$this->getID().'" />
		</table>';
		return $html;
	}
	
	/**
	  * Writes object into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function writeToPersistence()
	{
		$valuesToSet = $this->_values;
		$ok = true;
		if (is_array($valuesToSet) && $valuesToSet) {
			//first update code allready known in DB
			if (is_array($this->_DBKnown) && $this->_DBKnown && $this->_ID) {
				foreach ($this->_DBKnown as $aKownCode) {
					$sql = "
						update
							mod_object_i18nm
						set
							value_i18nm='".SensitiveIO::sanitizeSQLString($this->_values[$aKownCode])."'
						where
							id_i18nm='".$this->_ID."'
							and code_i18nm='".$aKownCode."'
					";
					$q = new CMS_query($sql);
					if ($q->hasError()) {
						$this->setError("Can't update value for code : ".$aKownCode);
						$ok = false;
					} else {
						unset($valuesToSet[$aKownCode]);
					}
				}
			}
			//then, add the rest of the values
			if (is_array($valuesToSet) && $valuesToSet) {
				foreach ($valuesToSet as $code => $value) {
					//save data
					$sql_fields = "
						code_i18nm='".SensitiveIO::sanitizeSQLString($code)."',
						value_i18nm='".SensitiveIO::sanitizeSQLString($value)."'
					";
					if ($this->_ID) {
						$sql = "
							insert into
								mod_object_i18nm
							set
								id_i18nm='".$this->_ID."',
								".$sql_fields;
					} else {
						$sql = "
							insert into
								mod_object_i18nm
							set
								".$sql_fields;
					}
					$q = new CMS_query($sql);
					if ($q->hasError()) {
						$this->setError("Can't save object");
						$ok = false;
					} elseif (!$this->_ID) {
						$this->_ID = $q->getLastInsertedID();
					}
				}
			}
			unset($GLOBALS["polyModule"]["i18nm"][$this->_ID]);
			return $ok;
		} else {
			$this->setError("No values to write");
			return false;
		}
	}
	
	/**
	  * Destroy this object, in DB
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function destroy () {
		if ($this->_ID) {
			$sql = "delete from
						mod_object_i18nm
					where
						id_i18nm='".$this->_ID."'
			";
			$q = new CMS_query($sql);
			if ($q->hasError()) {
				$this->setError("Can't destroy object");
				return false;
			}
		}
		$this->__destroy();
		return true;
	}
}
?>
