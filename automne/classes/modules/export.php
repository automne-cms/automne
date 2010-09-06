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
  * Class CMS_module_export
  *
  * Export datas from modules
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_module_export extends CMS_grandFather
{
	/**
	* Messages
	*/
	const MESSAGE_PARAM_OBJECTS = 1667;
	const MESSAGE_PARAM_CATEGORIES = 1668;
	const MESSAGE_PARAM_ROWS = 1669;
	const MESSAGE_PARAM_CSS = 1670;
	const MESSAGE_PARAM_JS = 1671;
	
	/**
	 * Export parameters
	 * @var array
	 * @access private
	 */
	protected $_parameters = "";
	
	/**
	 * Module codename to export
	 * @var string
	 * @access private
	 */
	protected $_module = "";
	
	/**
	 * Does queried module has export capabilities
	 * @var boolean
	 * @access private
	 */
	protected $_hasExport = false;
	
	/**
	 * Default export parameters for module
	 * @var array
	 * @access private
	 */
	protected $_defaultParameters = array();
	
	/**
	 * Available export parameters for module
	 * @var array
	 * @access private
	 */
	protected $_availableParameters = array();
	
	/**
	 * Constructor
	 * 
	 * @param string $codename, the codename of the module to export datas
	 * @return void
	 */
	function __construct($codename) {
		if (!in_array($codename, CMS_modulesCatalog::getAllCodenames())) {
			$this->raiseError('Unknown module : '.$codename);
			return false;
		}
		$this->_module = $codename;
		//only polymod for now, but can be switched by modules later
		$this->_hasExport = CMS_modulesCatalog::isPolymod($this->_module);
		if ($this->_hasExport) {
			$this->_defaultParameters = array('objects', 'categories', 'rows', 'css', 'js');
			$this->_availableParameters = array(
				'objects'		=> self::MESSAGE_PARAM_OBJECTS,
				'categories'	=> self::MESSAGE_PARAM_CATEGORIES,
				'rows'			=> self::MESSAGE_PARAM_ROWS,
				'css'			=> self::MESSAGE_PARAM_CSS,
				'js'			=> self::MESSAGE_PARAM_JS,
			);
		}
	}
	
	/**
	 * Does current element has datas to export
	 * 
	 * @param string $name, the full filename of the file or dir
	 * @param integer $from, the file path is : self::FILE_SYSTEM or self::WEBROOT
	 * @param integer $type, the type of the current object : self::TYPE_FILE for a file, self::TYPE_DIRECTORY for a dir, false for undefined
	 * @return void
	 */
	function hasExport() {
		return $this->_hasExport;
	}
	
	/**
	 * Set export parameter
	 * 
	 * @param string $parameter, the parameter name to set
	 * @param mixed $value, the parameter value to set
	 * @return void
	 */
	function setParameter($parameter, $value) {
		$this->_parameters[$parameter] = $value;
	}
	
	/**
	 * Get export parameter
	 * 
	 * @param string $parameter, the parameter name to get
	 * @return mixed : the current parameter value
	 */
	function getParameter($parameter) {
		if (isset($this->_parameters[$parameter])) {
			return $this->_parameters[$parameter];
		}
		return null;
	}
	
	/**
	 * Set all export parameters
	 * 
	 * @param array $parameters, the parameters to set
	 * @return void
	 */
	function setParameters($parameters) {
		$this->_parameters = $parameters;
	}
	
	/**
	 * Get all export parameter
	 * 
	 * @return array : the current parameters values
	 */
	function getParameters() {
		return $this->_parameters;
	}
	
	/**
	 * Get all default parameters (parameters which are set if no parameter exists for them)
	 * 
	 * @return array : the default parameters names
	 */
	function getDefaultParameters() {
		return $this->_defaultParameters;
	}
	
	/**
	 * Get all available parameters names and labels
	 * 
	 * @param CMS_language $cms_language, the label language
	 * @return array : the parameters names and labels
	 */
	function getAvailableParameters($cms_language) {
		$return = array();
		foreach ($this->_availableParameters as $key => $label) {
			$return[$key] = $cms_language->getMessage($label);
		}
		return $return;
	}
	
	/**
	 * Export module datas
	 * 
	 * @param string $format, the export format in : php (default), xml, patch
	 * @return mixed : the exported datas
	 */
	function export($format = 'php') {
		$aExport = array();
		if ($this->_hasExport) {
			$oModule = CMS_modulesCatalog::getByCodename($this->_module);
			if (!$oModule->hasError()) {
				$aModule = $oModule->asArray($this->_parameters, $files);
				//append files to exported module datas
				$aModule['files'] = array();
				if ($files) {
					$aModule['files'] = $files;
				}
				//create export datas
				$aExport = array(
					'version'=> AUTOMNE_VERSION,
					'modules' => array($aModule),
				);
			}
			$return = '';
			switch ($format) {
				case 'php':
					$return = $aExport;
				break;
				case 'xml':
					$array2Xml = new CMS_array2Xml($aExport,"export");
					$return = $array2Xml->getXMLString();
				break;
				case 'patch':
					//create patch datas
					$archiveFile = PATH_TMP_WR.'/'.$this->_module.'-'.date('Ymd-His').'.tgz';
					$archive = new CMS_gzip_file(substr($archiveFile, 1));
					$archive->set_options(array('basedir' => PATH_REALROOT_FS));
					if (isset($aExport['modules'])) {
						foreach ($aExport['modules'] as $moduleDatas) {
							if (isset($moduleDatas['files'])) {
								foreach ($moduleDatas['files'] as $file) {
									if (file_exists(PATH_REALROOT_FS.$file)) {
										$archive->add_files(array(substr($file, 1))); //strip initial slash
									}
								}
							}
						}
					}
					$array2Xml = new CMS_array2Xml($aExport, "export");
					$sOutput = $array2Xml->getXMLString();
					
					$datas = new CMS_file(PATH_REALROOT_FS.'/export.xml');
					$datas->setContent($sOutput);
					$datas->writeToPersistence();
					$archive->add_files(array('export.xml'));
					//create archive
					if ($archive->create_archive()) {
						$return = PATH_REALROOT_FS.$archiveFile;
					} else {
						$this->raiseError('Error during archive creation ...');
					}
					//delete tmp file
					$datas->delete();
				break;
				default:
					$this->raiseError('Unknown format : '.$format);
					return false;
				break;
			}
		}
		return $return;
	}
}
?>