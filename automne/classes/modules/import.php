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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Class CMS_module_import
  *
  * Import datas to module
  *
  * @package Automne
  * @subpackage modules
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_module_import extends CMS_grandFather
{
	/**
	* Messages
	*/
	const MESSAGE_PARAM_CREATE = 1661;
	const MESSAGE_PARAM_UPDATE = 1662;
	const MESSAGE_PARAM_FILES = 1663;
	const MESSAGE_PARAM_UPDATE_ROWS = 1664;
	const MESSAGE_PARAM_UPDATE_JS = 1665;
	const MESSAGE_PARAM_UPDATE_CSS = 1666;
	const MESSAGE_PARAM_UPDATE_IMG = 1761;
	
	/**
	 * Import parameters
	 * @var array
	 * @access private
	 */
	protected $_parameters = "";
	
	/**
	 * Default import parameters
	 * @var array
	 * @access private
	 */
	protected $_defaultParameters = array();
	
	/**
	 * Available import parameters
	 * @var array
	 * @access private
	 */
	protected $_availableParameters = array();
	
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	public function __construct() {
		
		$this->_defaultParameters = array('create', 'update', 'files');
		$this->_availableParameters = array(
			'create'		=> self::MESSAGE_PARAM_CREATE,
			'update'		=> self::MESSAGE_PARAM_UPDATE,
			'files'			=> self::MESSAGE_PARAM_FILES,
			'updateRows'	=> self::MESSAGE_PARAM_UPDATE_ROWS,
			'updateJs'		=> self::MESSAGE_PARAM_UPDATE_JS,
			'updateCss'		=> self::MESSAGE_PARAM_UPDATE_CSS,
			'updateImg'		=> self::MESSAGE_PARAM_UPDATE_IMG,
		);
	}
	
	/**
	 * Set import parameter
	 * 
	 * @param string $parameter, the parameter name to set
	 * @param mixed $value, the parameter value to set
	 * @return void
	 */
	public function setParameter($parameter, $value) {
		$this->_parameters[$parameter] = $value;
	}
	
	/**
	 * Get import parameter
	 * 
	 * @param string $parameter, the parameter name to get
	 * @return mixed : the current parameter value
	 */
	public function getParameter($parameter) {
		if (isset($this->_parameters[$parameter])) {
			return $this->_parameters[$parameter];
		}
		return null;
	}
	
	/**
	 * Set all import parameters
	 * 
	 * @param array $parameters, the parameters to set
	 * @return void
	 */
	public function setParameters($parameters) {
		$this->_parameters = $parameters;
	}
	
	/**
	 * Get all import parameter
	 * 
	 * @return array : the current parameters values
	 */
	public function getParameters() {
		return $this->_parameters;
	}
	
	/**
	 * Get all default parameters (parameters which are set if no parameter exists for them)
	 * 
	 * @return array : the default parameters names
	 */
	public function getDefaultParameters() {
		return $this->_defaultParameters;
	}
	
	/**
	 * Get all available parameters names and labels
	 * 
	 * @param CMS_language $cms_language, the label language
	 * @return array : the parameters names and labels
	 */
	public function getAvailableParameters($cms_language) {
		$return = array();
		foreach ($this->_availableParameters as $key => $label) {
			$return[$key] = $cms_language->getMessage($label);
		}
		return $return;
	}
	
	/**
	 * Import module datas
	 * 
	 * @param mixed $datas, the import datas
	 * @param string $format, the import format in : php (default), xml
	 * @param CMS_language $cms_language, the current cms_language to use. Passed by reference to temporary overwrite it with import language
	 * @param string $infos (reference), the returned import infos
	 * @return boolean : the import status
	 */
	public function import($datas, $format = 'php', &$cms_language, &$infos) {
		$infos = '';
		$return = true;
		switch ($format) {
			case 'xml':
				//convert XML to PHP array
				$xml2Array = new CMS_xml2Array($datas, CMS_xml2Array::XML_ARRAY2XML_FORMAT);
				$importedArray = $xml2Array->getParsedArray();
				break;
			case 'php':
				//try to eval PHP Array
				if (!is_array($datas)) {
					$infos .= 'Error : PHP datas must be a valid PHP array ... '."\n";
					return false;
				} else {
					$importedArray = $datas;
				}
				break;
			default:
				$infos .= 'Error : Unknown import format ... '.$format."\n";
				return false;
				break;
		}
		if (!isset($importedArray) || !is_array($importedArray)) {
			$infos .= 'Error : no datas to import or incorrect datas ...'."\n";
			return false;
		}
		if (isset($importedArray['version'])) {
			$version = $importedArray['version'];
			unset($importedArray['version']);
		} else {
			$version = '';
		}
		//Check for version compliance
		if ($version && version_compare(AUTOMNE_VERSION, $version, '<')) {
			$infos .= 'Error: Automne version below the version of imported datas'."\n";
			return false;
		}
		if (isset($importedArray['language'])) {
			//force import language to overwrite user language because imported datas refer to this language
			$oldLanguage = $cms_language->getCode();
			$cms_language = CMS_languagesCatalog::getByCode($importedArray['language']);
			if (!$cms_language || $cms_language->hasError()) {
				//reload user language
				$cms_language = CMS_languagesCatalog::getByCode($oldLanguage);
			}
			unset($importedArray['language']);
		}
		
		//return import description if exists
		if (isset($importedArray['description']) && $importedArray['description']) {
			$infos .= '--------------------------------------------------------------------------------------------------------'."\n";
			$infos .= 'Import description: '."\n";
			$infos .= io::htmlspecialchars($importedArray['description'])."\n";
			$infos .= '--------------------------------------------------------------------------------------------------------'."\n";
			unset($importedArray['description']);
		}
		foreach ($importedArray as $type => $data) {
			switch ($type) {
				case 'modules':
					$idsRelation = array();
					$importInfos = '';
					if (CMS_modulesCatalog::fromArray($data, $this->_parameters, $cms_language, $idsRelation, $importInfos)) {
						$infos .= 'Import completed successfully'.($importInfos ? ': '."\n".$importInfos : '')."\n";
					} else {
						$infos .= 'Error: '."\n".$importInfos."\n";
						$return &= false;
					}
				break;
				default:
					$infos .= 'Error: Unknown data type to import : '.$type."\n";
					$return &= false;
				break;
			}
		}
		if (isset($importedArray['language'])) {
			//reload user language
			$cms_language = CMS_languagesCatalog::getByCode($oldLanguage);
		}
		return $return;
	}
}
?>