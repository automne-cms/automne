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
//
// $Id: object_file.php,v 1.16 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_object_file
  *
  * represent a file object
  *
  * @package Automne
  * @subpackage polymod
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_file extends CMS_object_common
{
	const MESSAGE_OBJECT_FILE_LABEL = 227;
	const MESSAGE_OBJECT_FILE_DESCRIPTION = 228;
	const MESSAGE_OBJECT_FILE_PARAMETER_THUMBMAXWIDTH = 229;
	const MESSAGE_OBJECT_FILE_PARAMETER_THUMBMAXHEIGHT = 414;
  	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXWIDTH_DESC = 212;
  	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXHEIGHT_DESC = 412;
  	const MESSAGE_OBJECT_FILE_IMAGEMAXWIDTH_DESCRIPTION = 229;
  	const MESSAGE_OBJECT_FILE_IMAGEMAXHEIGHT_DESCRIPTION = 414;
  	const MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT = 415;
  	const MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT_AND_WIDTH = 416;
	const MESSAGE_OBJECT_FILE_FIELD_LABEL = 37;
	const MESSAGE_OBJECT_FILE_FIELD_THUMBNAIL = 206;
	const MESSAGE_OBJECT_FILE_FIELD_DESC = 208;
	const MESSAGE_OBJECT_FILE_PARAMETER_MAXWIDTH_DESC = 212;
	const MESSAGE_OBJECT_FILE_FIELD_DELETE = 240;
	const MESSAGE_OBJECT_FILE_FIELD_ACTUAL_FILE = 241;
	const MESSAGE_OBJECT_FILE_FILEHTML_DESCRIPTION = 242;
	const MESSAGE_OBJECT_FILE_FILELABEL_DESCRIPTION = 243;
	const MESSAGE_OBJECT_FILE_FILENAME_DESCRIPTION = 244;
	const MESSAGE_OBJECT_FILE_FILETHUMBNAME_DESCRIPTION = 245;
	const MESSAGE_OBJECT_FILE_FILEPATH_DESCRIPTION = 246;
	const MESSAGE_OBJECT_FILE_THUMBWIDTH_DESCRIPTION = 247;
	const MESSAGE_OBJECT_FILE_THUMBHEIGHT_DESCRIPTION = 248;
	const MESSAGE_OBJECT_FILE_FILESIZE_DESCRIPTION = 251;
	const MESSAGE_OBJECT_FILE_PARAMETER_USETHUMBNAIL = 230;
	const MESSAGE_OBJECT_FILE_PARAMETER_ICONS = 231;
	const MESSAGE_OBJECT_FILE_FIELD_SOURCEFILE = 232;
	const MESSAGE_OBJECT_FILE_FIELD_EXTERNALSOURCEFILE = 233;
	const MESSAGE_OBJECT_FILE_PARAMETER_FTP_DIRECTORY = 234;
	const MESSAGE_OBJECT_FILE_PARAMETER_FTP_DIRECTORY_DESC = 235;
	const MESSAGE_OBJECT_FILE_FIELD_MAX_FILESIZE = 236;
	const MESSAGE_OBJECT_FILE_FIELD_EXTERNALSOURCEFILE_FTP = 237;
	const MESSAGE_OBJECT_FILE_FILEICON_DESCRIPTION = 238;
	const MESSAGE_OBJECT_FILE_FILEEXTENTION_DESCRIPTION = 239;
	const MESSAGE_OBJECT_FILE_PARAMETER_ALLOW_FTP = 249;
	const MESSAGE_OBJECT_FILE_PARAMETER_ALLOW_FTP_DESC = 250;
	const MESSAGE_OBJECT_FILE_PARAMETER_ALLOWED_TYPE = 374;
	const MESSAGE_OBJECT_FILE_PARAMETER_ALLOWED_TYPE_DESC = 375;
	const MESSAGE_OBJECT_FILE_PARAMETER_DISALLOWED_TYPE = 376;
	const MESSAGE_OBJECT_FILE_PARAMETER_DISALLOWED_TYPE_DESC = 375;
	const MESSAGE_OBJECT_FILE_PARAMETER_ALTERNATIVE_DOMAIN = 664;
	const MESSAGE_OBJECT_FILE_PARAMETER_ALTERNATIVE_DOMAIN_DESC = 665;
	const MESSAGE_OBJECT_FILE_FILE_DESCRIPTION = 574;
	const MESSAGE_OBJECT_FILE_THUMB_DESCRIPTION = 575;
	const MESSAGE_OBJECT_FILE_IMAGEWIDTH_DESCRIPTION = 576;
	const MESSAGE_OBJECT_FILE_IMAGEHEIGHT_DESCRIPTION = 577;
	const MESSAGE_OBJECT_FILE_THUMBEXTENTION_DESCRIPTION = 578;
	
	//Standard Message
	const MESSAGE_ALL_FILE = 530;
	const MESSAGE_SELECT_FILE = 534;
	const MESSAGE_SELECT_PICTURE = 528;
	
	/**
	  * File types constants
	  */
	const OBJECT_FILE_TYPE_INTERNAL = 1;
	const OBJECT_FILE_TYPE_EXTERNAL = 2;
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_FILE_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_FILE_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'filename',
									),
							1 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'thumbnail',
									),
							2 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'filesize',
									),
							3 => array(
										'type' 			=> 'integer',
										'required' 		=> true,
										'internalName'	=> 'destinationtype',
									),
							4 => array(
										'type' 			=> 'string',
										'required' 		=> true,
										'internalName'	=> 'file',
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array(0 => '',1 => '',2 => '',3 => self::OBJECT_FILE_TYPE_INTERNAL,4 => '');
	
	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array(0 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'useThumbnail',
										'externalName'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_USETHUMBNAIL,
									),
							1 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'thumbMaxWidth',
										'externalName'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_THUMBMAXWIDTH,
										'description'   => self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXWIDTH_DESC,
									),
							2 => array(
										'type'			=> 'integer',
										'required'		=> false,
										'internalName'  => 'thumbMaxHeight',
										'externalName'  => self::MESSAGE_OBJECT_FILE_PARAMETER_THUMBMAXHEIGHT,
										'description'   => self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXHEIGHT_DESC,
									),
							3 => array(
										'type' 			=> 'fileIcons',
										'required' 		=> false,
										'internalName'	=> 'fileIcons',
										'externalName'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_ICONS,
									),
							4 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'allowFtp',
										'externalName'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_ALLOW_FTP,
										'description'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_ALLOW_FTP_DESC,
									),
							5 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'ftpDir',
										'externalName'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_FTP_DIRECTORY,
										'description'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_FTP_DIRECTORY_DESC,
									),
							6 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'allowedType',
										'externalName'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_ALLOWED_TYPE,
										'description'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_ALLOWED_TYPE_DESC,
									),
							7 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'disallowedType',
										'externalName'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_DISALLOWED_TYPE,
										'description'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_DISALLOWED_TYPE_DESC,
									),
							8 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'altDomain',
										'externalName'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_ALTERNATIVE_DOMAIN,
										'description'	=> self::MESSAGE_OBJECT_FILE_PARAMETER_ALTERNATIVE_DOMAIN_DESC,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => false,
										1 => '',
										2 => '',
										3 => array ('doc' => 'doc.gif','gif' => 'gif.gif','html' => 'html.gif','htm' => 'html.gif','jpg' => 'jpg.gif','jpeg' => 'jpg.gif','jpe' => 'jpg.gif','mov' => 'mov.gif','mp3' => 'mp3.gif','pdf' => 'pdf.gif','png' => 'png.gif','ppt' => 'ppt.gif','pps' => 'ppt.gif','swf' => 'swf.gif','sxw' => 'sxw.gif','url' => 'url.gif','xls' => 'xls.gif','xml' => 'xml.gif',),
										4 => false,
										5 => '/automne/tmp/',
										6 => '',
										7 => FILE_UPLOAD_EXTENSIONS_DENIED,
										8 => '');
	
	/**
	  * all images extension allowed
	  * @var array()
	  * @access private
	  */
	protected $_allowedExtensions = array("gif","jpg","png");
	
	/**
	  * Constructor.
	  * initialize object.
	  *
	  * @param array $datas DB object values : array(integer "subFieldID" => mixed)
	  * @param CMS_object_field reference
	  * @param boolean $public values are public or edited ? (default is edited)
	  * @return void
	  * @access public
	  */
	function __construct($datas=array(), &$field, $public=false)
	{
		parent::__construct($datas, $field, $public);
	}
	
	/**
	  * get HTML admin subfields parameters (used to enter object categories parameters values in admin)
	  *
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLSubFieldsParametersfileIcons($language, $prefixName) {
		$values = $this->_parameterValues;
		$input = '';
		$parameters = $this->getSubFieldParameters();
		foreach($parameters as $parameterID => $parameter) {
			$paramValue = $values[$parameterID];
			if ($parameter["type"] == "fileIcons") {
				//for now, only store it in a hidden field
				$input = '<input type="hidden" name="'.$prefixName.$parameter['internalName'].'" value="'.base64_encode(serialize($paramValue)).'" />';
			}
		}
		return $input;
	}
	
	/**
	  * treat all params then return array of values treated or false if error
	  *
	  * @param array $post the posted datas
	  * @param string $prefix the prefix for datas name
	  * @return array, the treated datas
	  * @access public
	  */
	function treatParams($post, $prefix) {
		$params = parent::treatParams($post, $prefix);
		if (isset($params['fileIcons']) && is_string($params['fileIcons'])) {
			$params['fileIcons'] = unserialize(base64_decode($params['fileIcons']));
		}
		return $params;
	}
	
	/**
	  * get object label
	  *
	  * @return string : the label
	  * @access public
	  */
	function getLabel() {
		if (!is_object($this->_subfieldValues[0])) {
			$this->setError("No subField to get for label : ".print_r($this->_subfieldValues,true));
			return false;
		}
		return $this->_subfieldValues[0]->getValue();
	}
	
	/**
	  * check object Mandatories Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @param boolean newFormat : new automne v4 format (default false for compatibility)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function checkMandatory($values, $prefixName, $newFormat = false) {
		//load parameters
		$params = $this->getParamsValues();
		if ($newFormat) {
			//check for image extension before doing anything
			if (isset($values[$prefixName.$this->_field->getID().'_1']) && $values[$prefixName.$this->_field->getID().'_1']
				 && !in_array(io::strtolower(pathinfo($values[$prefixName.$this->_field->getID().'_1'], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
				return false;
			}
			//if field is required check values
			if ($this->_field->getValue('required')) {
				// FTP file
				if($params['allowFtp'] && is_dir(PATH_REALROOT_FS.$params['ftpDir']) && isset($values[$prefixName.$this->_field->getID().'_externalfile']) && $values[$prefixName.$this->_field->getID().'_externalfile']){
					$filename = $values[$prefixName.$this->_field->getID().'_externalfile'];
					$ftp_dir = PATH_REALROOT_FS.$params['ftpDir'];
					if (!file_exists($ftp_dir.$filename) || !is_file($ftp_dir.$filename)) {
						return false;
					}
				} else if(!$values[$prefixName.$this->_field->getID().'_4']) {
					return false;
				}
			}
			
			//check files extension
			if ($params['allowedType'] || $params['disallowedType']) {
				//for external file if any
				if (isset($values[$prefixName.$this->_field->getID().'_externalfile']) && $values[$prefixName.$this->_field->getID().'_externalfile']) {
					$extension = io::strtolower(pathinfo($values[$prefixName.$this->_field->getID().'_externalfile'], PATHINFO_EXTENSION));
					if (!$extension) return false;
					//extension must be in allowed list
					if ($params['allowedType'] && !in_array($extension, explode(',',io::strtolower($params['allowedType'])))) {
						return false;
					}
					//extension must not be in disallowed list
					if ($params['disallowedType'] && in_array($extension, explode(',',io::strtolower($params['disallowedType'])))) {
						return false;
					}
				}
				//for uploaded file if any
				if (isset($values[$prefixName.$this->_field->getID().'_4']) && $values[$prefixName.$this->_field->getID().'_4']) {
					$extension = io::strtolower(pathinfo($values[$prefixName.$this->_field->getID().'_4'], PATHINFO_EXTENSION));
					if (!$extension) return false;
					//extension must be in allowed list
					if ($params['allowedType'] && !in_array($extension, explode(',',io::strtolower($params['allowedType'])))) {
						return false;
					}
					//extension must not be in disallowed list
					if ($params['disallowedType'] && in_array($extension, explode(',',io::strtolower($params['disallowedType'])))) {
						return false;
					}
				}
			}
			return true;
		} else {
			//check for image extension before doing anything
			if (isset($_FILES[$prefixName.$this->_field->getID().'_1']) && $_FILES[$prefixName.$this->_field->getID().'_1']["name"]
				 && !in_array(io::strtolower(pathinfo($_FILES[$prefixName.$this->_field->getID().'_1']["name"], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
				return false;
			}
			//if field is required check values
			if ($this->_field->getValue('required')) {
				// FTP file
				if($params['allowFtp'] && is_dir(PATH_REALROOT_FS.$params['ftpDir'])){
					$filename = $values[$prefixName.$this->_field->getID().'_externalfile'];//io::substr($values[$prefixName.$this->_field->getID().'_externalfile'], 1);
					$ftp_dir = PATH_REALROOT_FS.$params['ftpDir'];
					if (@file_exists($ftp_dir.$filename) && is_file($ftp_dir.$filename)) {
						return true;
					}
				}
				//must have file in upload field or in hidden field or file must be already set
				//if deleted is checked, file must be set in upload field
				if((!$this->_subfieldValues[4]->getValue() && !$_FILES[$prefixName.$this->_field->getID().'_4']['name'] && (!isset($values[$prefixName.$this->_field->getID().'_4_hidden']) || !$values[$prefixName.$this->_field->getID().'_4_hidden'])) || (isset($values[$prefixName.$this->_field->getID().'_delete']) && $values[$prefixName.$this->_field->getID().'_delete'] == 1 && !$_FILES[$prefixName.$this->_field->getID().'_4']['name'])) {
					return false;
				}
			}
			
			//check files extension
			if ($params['allowedType'] || $params['disallowedType']) {
				//for external file if any
				if (isset($values[$prefixName.$this->_field->getID().'_externalfile']) && $values[$prefixName.$this->_field->getID().'_externalfile']) {
					$extension = io::strtolower(pathinfo($values[$prefixName.$this->_field->getID().'_externalfile'], PATHINFO_EXTENSION));
					if (!$extension) return false;
					//extension must be in allowed list
					if ($params['allowedType'] && !in_array($extension, explode(',',io::strtolower($params['allowedType'])))) {
						return false;
					}
					//extension must not be in disallowed list
					if ($params['disallowedType'] && in_array($extension, explode(',',io::strtolower($params['disallowedType'])))) {
						return false;
					}
				}
				//for uploaded file if any
				if (isset($_FILES[$prefixName.$this->_field->getID().'_4']) && $_FILES[$prefixName.$this->_field->getID().'_4']['name']) {
					$extension = io::strtolower(pathinfo($_FILES[$prefixName.$this->_field->getID().'_4']['name'], PATHINFO_EXTENSION));
					if (!$extension) return false;
					//extension must be in allowed list
					if ($params['allowedType'] && !in_array($extension, explode(',',io::strtolower($params['allowedType'])))) {
						return false;
					}
					//extension must not be in disallowed list
					if ($params['disallowedType'] && in_array($extension, explode(',',io::strtolower($params['disallowedType'])))) {
						return false;
					}
				}
			}
			return true;
		}
	}
	
	/**
	  * get HTML admin (used to enter object values in admin)
	  *
	  * @param integer $fieldID, the current field id (only for poly object compatibility)
	  * @param CMS_language $language, the current admin language
	  * @param string prefixname : the prefix to use for post names
	  * @return string : the html admin
	  * @access public
	  */
	function getHTMLAdmin($fieldID, $language, $prefixName) {
		$return = parent::getHTMLAdmin($fieldID, $language, $prefixName);
		$params = $this->getParamsValues();
		$maxFileSize = CMS_file::getMaxUploadFileSize('K');
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		
		//Title
		unset($return['items'][0]['hideLabel']);
		$return['items'][0]['fieldLabel']	= $language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_LABEL, false, MOD_POLYMOD_CODENAME);
		$return['items'][0]['allowBlank']	= true;
		
		//File
		unset($return['items'][4]['hideLabel']);
		$return['items'][4]['fieldLabel']	= $language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_SOURCEFILE, false, MOD_POLYMOD_CODENAME);
		$return['items'][4]['xtype']		= 'atmFileUploadField';
		$return['items'][4]['emptyText']	= $language->getMessage(self::MESSAGE_SELECT_FILE);
		$return['items'][4]['uploadCfg']	= array(
			'file_size_limit'					=> $maxFileSize,
			'file_types_description'			=> $language->getMessage(self::MESSAGE_ALL_FILE).' ...'
		);
		$return['items'][4]['uploadCfg']['file_types'] = $params['allowedType'] ? '*.'.str_replace(',', ';*.', $params['allowedType']) : '*.*';
		if ($params['disallowedType']) {
			$return['items'][4]['uploadCfg']['disallowed_file_types'] = '*.'.str_replace(',', ';*.', $params['disallowedType']);
		}
		//File datas
		if ($this->_subfieldValues[4]->getValue() && file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue())) {
			$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue());
			$fileDatas = array(
				'filename'		=> $file->getName(false),
				'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
				'filesize'		=> $file->getFileSize(),
				'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
				'extension'		=> $file->getExtension(),
			);
		} else {
			$fileDatas = array(
				'filename'		=> '',
				'filepath'		=> '',
				'filesize'		=> '',
				'fileicon'		=> '',
				'extension'		=> '',
			);
		}
		$return['items'][4]['fileinfos']	= $fileDatas;
		$return['items'][4]['fileinfos']['module']			= $moduleCodename;
		$return['items'][4]['fileinfos']['visualisation']	= RESOURCE_DATA_LOCATION_EDITED;
		
		if ($params['useThumbnail']) {
			//Thumbnail
			unset($return['items'][1]['hideLabel']);
			$return['items'][1]['xtype']		= 'atmImageUploadField';
			$return['items'][1]['emptyText']	= $language->getMessage(self::MESSAGE_SELECT_PICTURE);
			$return['items'][1]['fieldLabel']	= $language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_THUMBNAIL, false, MOD_POLYMOD_CODENAME);
			$return['items'][1]['allowBlank']	= true;
			if ($params['thumbMaxWidth']) {
				$return['items'][1]['maxWidth'] = $params['thumbMaxWidth'];
			}
			if ($params['thumbMaxHeight']) {
				$return['items'][1]['maxHeight'] = $params['thumbMaxHeight'];
			}
			$return['items'][1]['uploadCfg']	= array(
				'file_size_limit'					=> $maxFileSize,
				'file_types'						=> '*.jpg;*.png;*.gif',
				'file_types_description'			=> $language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_THUMBNAIL, false, MOD_POLYMOD_CODENAME).' ...'
			);
			if ($params['disallowedType']) {
				$return['items'][1]['uploadCfg']['disallowed_file_types'] = '*.'.str_replace(',', ';*.', $params['disallowedType']);
			}
			if ($this->_subfieldValues[1]->getValue() && file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue())) {
				$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue());
				$imageDatas = array(
					'filename'		=> $file->getName(false),
					'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
					'filesize'		=> $file->getFileSize(),
					'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
					'extension'		=> $file->getExtension(),
				);
			} else {
				$imageDatas = array(
					'filename'		=> '',
					'filepath'		=> '',
					'filesize'		=> '',
					'fileicon'		=> '',
					'extension'		=> '',
				);
			}
			$return['items'][1]['fileinfos']	= $imageDatas;
			$return['items'][1]['fileinfos']['module']			= $moduleCodename;
			$return['items'][1]['fileinfos']['visualisation']	= RESOURCE_DATA_LOCATION_EDITED;
		} else {
			unset($return['items'][1]);
		}
		$return['items'][2]['xtype'] = 'hidden';
		$return['items'][3]['xtype'] = 'hidden';
		if($params['allowFtp'] && is_dir(PATH_REALROOT_FS.$params['ftpDir'])){
			$return['items'][] = array(
				'xtype'				=> 'textfield',
				'allowBlank'		=> true,
				'name'				=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_externalfile]',
				'fieldLabel'		=> '<span ext:qtip="'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_EXTERNALSOURCEFILE_FTP, array($params['ftpDir']), MOD_POLYMOD_CODENAME).'" class="atm-help">'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_EXTERNALSOURCEFILE, false, MOD_POLYMOD_CODENAME).'</span>',
			);
			$return['items'][4]['allowBlank'] = true;
		}
		//reset key numbers
		$return['items'] = array_values($return['items']);
		return $return;
	}
	
	/**
      * Return the needed form field tag for current object field
      *
      * @param array $values : parameters values array(parameterName => parameterValue) in :
      *     id : the form field id to set
      * @param multidimentionnal array $tags : xml2Array content of atm-function tag
      * @return string : the form field HTML tag
      * @access public
      */
	function getInput($fieldID, $language, $inputParams) {
		//hidden field : use parent method
		if (isset($inputParams['hidden']) && ($inputParams['hidden'] == 'true' || $inputParams['hidden'] == 1)) {
			return parent::getInput($fieldID, $language, $inputParams);
		}
		
		$params = $this->getParamsValues();
		if (isset($inputParams['prefix'])) {
			$prefixName = $inputParams['prefix'];
		} else {
			$prefixName = '';
		}
		//serialize all htmlparameters 
		$htmlParameters = $this->serializeHTMLParameters($inputParams);
		$tdclass = (isset($inputParams['tdclass'])) ? ' class="'.$inputParams['tdclass'].'"' : '';
		$thclass = (isset($inputParams['thclass'])) ? ' class="'.$inputParams['thclass'].'"' : '';
		
		$html = '
		<table>
		<tr>
			<th'.$thclass.'>'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_LABEL, false, MOD_POLYMOD_CODENAME).'</th>
			<td'.$tdclass.'><input'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_0" value="'.$this->_subfieldValues[0]->getValue().'" type="text" /></td>
		</tr>';
		if ($params['useThumbnail']) {
			$html .= '
			<tr>
				<th'.$thclass.'>'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_THUMBNAIL, false, MOD_POLYMOD_CODENAME).'</th>
				<td'.$tdclass.'><input'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_1" type="file" />';
				if ($params['thumbMaxWidth'] > 0 && !$params['thumbMaxHeight']) {
					$html .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_DESC, array($params['thumbMaxWidth']), MOD_POLYMOD_CODENAME).'</small>';
				} elseif ($params['thumbMaxHeight'] > 0 && !$params['thumbMaxWidth']) {
					$html .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT, array($params['thumbMaxHeight']), MOD_POLYMOD_CODENAME).'</small>';
				} elseif ($params['thumbMaxWidth'] && $params['thumbMaxHeight']) {
					$html .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT_AND_WIDTH, array($params['thumbMaxWidth'],$params['thumbMaxHeight']), MOD_POLYMOD_CODENAME).'</small>';
				}
				$html .= '</td>
			</tr>';
		}
		$html .= '
			<tr>
				<th'.$thclass.'>'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_SOURCEFILE, false, MOD_POLYMOD_CODENAME).'</th>
				<td'.$tdclass.'><input'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_4" type="file" />&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_MAX_FILESIZE, array(CMS_file::getMaxUploadFileSize('M'). 'M'), MOD_POLYMOD_CODENAME).'</small></td>
			</tr>';
		if ($params['allowFtp'] && is_dir(PATH_REALROOT_FS.$params['ftpDir'])) {
			$html .= '
			<tr>
				<th'.$thclass.'>'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_EXTERNALSOURCEFILE, false, MOD_POLYMOD_CODENAME).'</th>
				<td'.$tdclass.'><input'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_externalfile" type="text" />&nbsp;<br /><small>'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_EXTERNALSOURCEFILE_FTP, array($params['ftpDir']), MOD_POLYMOD_CODENAME).'</small></td>
			</tr>';
		}
		// If delete old file and no new file, set "delete" hidden input to mandatory check
		if((!isset($_FILES[$prefixName.$this->_field->getID().'_4']) || !$_FILES[$prefixName.$this->_field->getID().'_4']['name']) && isset($_REQUEST[$prefixName.$this->_field->getID().'_delete']) && $_REQUEST[$prefixName.$this->_field->getID().'_delete']){
			$html .='<input name="'.$prefixName.$this->_field->getID().'_delete" id="'.$prefixName.$this->_field->getID().'_delete" type="hidden" value="1" />';
		}
		//current file
		if ($this->_subfieldValues[4]->getValue()) {
			//get module codename
			$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			$filepath = ($this->_subfieldValues[3]->getValue() == self::OBJECT_FILE_TYPE_INTERNAL) ? PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue() : $this->_subfieldValues[4]->getValue();
			$thumbnail = ($this->_subfieldValues[1]->getValue()) ? '<br /><a href="'.$filepath.'" target="_blank"><img src="'.PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue().'" alt="'.$this->_subfieldValues[0]->getValue().'" title="'.$this->_subfieldValues[0]->getValue().'" border="0" /></a>' : '';
			$icon = $this->_getFileIcon();
			if ($icon) {
				$icon = '<img src="'.$icon.'" alt="'.$this->_getFileExtension().'" title="'.$this->_getFileExtension().'" border="0" />&nbsp;';
			}
			$file = '<a href="'.$filepath.'" target="_blank">'.$icon.$this->_subfieldValues[0]->getValue().'</a> ('.$this->_subfieldValues[2]->getValue().'Mo)';
			$html .= '
			<tr>
				<th'.$thclass.'>'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_ACTUAL_FILE, false, MOD_POLYMOD_CODENAME).'</th>
				<td'.$tdclass.'>'.$file.' <label for="'.$prefixName.$this->_field->getID().'_delete"><input name="'.$prefixName.$this->_field->getID().'_delete" id="'.$prefixName.$this->_field->getID().'_delete" type="checkbox" value="1" />'.$language->getMessage(self::MESSAGE_OBJECT_FILE_FIELD_DELETE, false, MOD_POLYMOD_CODENAME).'</label><br />'
					.$thumbnail.'
					<input type="hidden" name="'.$prefixName.$this->_field->getID().'_1_hidden" value="'.$this->_subfieldValues[1]->getValue().'" />
					<input type="hidden" name="'.$prefixName.$this->_field->getID().'_2_hidden" value="'.$this->_subfieldValues[2]->getValue().'" />
					<input type="hidden" name="'.$prefixName.$this->_field->getID().'_3_hidden" value="'.$this->_subfieldValues[3]->getValue().'" />
					<input type="hidden" name="'.$prefixName.$this->_field->getID().'_4_hidden" value="'.$this->_subfieldValues[4]->getValue().'" />
				</td>
			</tr>';
		}
		if (POLYMOD_DEBUG) {
			$html .= '	<tr>
							<td'.$tdclass.' colspan="2"><span class="admin_text_alert">(Field : '.$this->_field->getID().'
							<br />File : '.$this->_subfieldValues[4]->getValue().'
							<br />Filesize : '.$this->_subfieldValues[2]->getValue().'
							<br />Thumbnail : '.$this->_subfieldValues[1]->getValue().'
							<br />DestinationType : '.$this->_subfieldValues[3]->getValue().')</span></td>
						</tr>';
		}
		$html .= '</table>';
		//append html hidden field which store field name
		if ($html) {
			$html .= '<input type="hidden" name="polymodFields['.$this->_field->getID().']" value="'.$this->_field->getID().'" />';
		}
		return $html;
	}
	
	/**
	  * return the extension of the current document.
	  *
	  * @return string : the extension of the current document
	  * @access public
	  */
	protected function _getFileExtension() {
		if (!$this->_subfieldValues[4]->getValue()) {
			return '';
		}
		$path_parts = pathinfo($this->_subfieldValues[4]->getValue());
		return io::strtolower($path_parts['extension']);
	}
	
	/**
	  * return the extension of the current thumbnail.
	  *
	  * @return string : the extension of the current document
	  * @access public
	  */
	protected function _getThumbExtension() {
		if (!$this->_subfieldValues[1]->getValue()) {
			return '';
		}
		$path_parts = pathinfo($this->_subfieldValues[1]->getValue());
		return io::strtolower($path_parts['extension']);
	}
	
	/**
	  * return the fileicon path if any for the current document.
	  *
	  * @return void
	  * @access public
	  */
	protected function _getFileIcon() {
		//get field parameters
		$parameters = $this->getParamsValues();
		$extension = $this->_getFileExtension();
		if ($parameters['fileIcons'] && $extension && 
			(isset($parameters['fileIcons'][$extension]) && file_exists(PATH_MODULES_FILES_FS.'/standard/icons/'.$parameters['fileIcons'][$extension]))
			|| file_exists(PATH_MODULES_FILES_FS.'/standard/icons/'.$extension.'.gif')) {
			$icon = file_exists(PATH_MODULES_FILES_FS.'/standard/icons/'.$extension.'.gif') ? $extension.'.gif' : $parameters['fileIcons'][$extension];
			return PATH_MODULES_FILES_WR.'/standard/icons/'.$icon;
		}
		return '';
	}
	
	/**
	  * blank method, only needed to inform the need of an object id when set object values (method setValues)
	  *
	  * @return void
	  * @access public
	  */
	function needIDToSetValues() {
		return void;
	}
	
	/**
	  * set object Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @param boolean newFormat : new automne v4 format (default false for compatibility)
	  * @param integer $objectID : the current object id. Must be set, but default is blank for compatibility with other objects
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValues($values, $prefixName, $newFormat = false, $objectID = '') {
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			$this->setError('ObjectID must be a positive integer : '.$objectID);
			return false;
		}
		//get field parameters
		$params = $this->getParamsValues();
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		if ($newFormat) {
			//delete old files ?
			//thumbnail
			if ($this->_subfieldValues[1]->getValue() && (!$values[$prefixName.$this->_field->getID().'_1'] || pathinfo($values[$prefixName.$this->_field->getID().'_1'], PATHINFO_BASENAME) != $this->_subfieldValues[1]->getValue())) {
				@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue());
				$this->_subfieldValues[1]->setValue('');
			}
			//file
			if ($this->_subfieldValues[4]->getValue() && (!$values[$prefixName.$this->_field->getID().'_4'] || pathinfo($values[$prefixName.$this->_field->getID().'_4'], PATHINFO_BASENAME) != $this->_subfieldValues[4]->getValue())) {
				@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue());
				$this->_subfieldValues[4]->setValue('');
				//reset filesize
				if (!$this->_subfieldValues[2]->setValue(0)) {
					return false;
				}
			}
			
			if (!(isset($values[$prefixName.$this->_field->getID().'_0']) && $this->_subfieldValues[0]->setValue(io::htmlspecialchars($values[$prefixName.$this->_field->getID().'_0'])))) {
			    return false;
			}
			
			//thumbnail
			if (isset($values[$prefixName.$this->_field->getID().'_1']) && $values[$prefixName.$this->_field->getID().'_1'] && io::strpos($values[$prefixName.$this->_field->getID().'_1'], PATH_UPLOAD_WR.'/') !== false) {
				$filename = $values[$prefixName.$this->_field->getID().'_1'];
				//check for image type before doing anything
				if (!in_array(io::strtolower(pathinfo($filename, PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
					return false;
				}
				//destroy old image if any
				if ($this->_subfieldValues[1]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue());
					$this->_subfieldValues[1]->setValue('');
				}
				//move and rename uploaded file 
				$filename = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $filename);
				$basename = pathinfo($filename, PATHINFO_BASENAME);
				
				//set thumbnail
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED;
				$newBasename = "r".$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($basename));
				
				//rename image
				$path_parts = pathinfo($newBasename);
				$extension = io::strtolower($path_parts['extension']);
				$newBasename = io::substr($path_parts['basename'],0,-(io::strlen($extension)+1)).'_thumbnail.'.$extension;
				if (io::strlen($newBasename) > 255) {
					$newBasename = sensitiveIO::ellipsis($newBasename, 255, '-', true);
				}
				$newFilename = $path.'/'.$newBasename;
				//move file from upload dir to new dir
				CMS_file::moveTo($filename, $newFilename);
				CMS_file::chmodFile(FILES_CHMOD, $newFilename);
				
				//resize thumbnail if needed
				if ($params['thumbMaxWidth'] > 0 || $params['thumbMaxHeight'] > 0) {
					$oImage = new CMS_image($newFilename);
					//get current file size
					$sizeX = $oImage->getWidth();
					$sizeY = $oImage->getHeight();
					//check thumbnail size
					list($sizeX, $sizeY) = @getimagesize($newFilename);
					if (($params['thumbMaxWidth'] && $sizeX > $params['thumbMaxWidth']) || ($params['thumbMaxHeight'] && $sizeY > $params['thumbMaxHeight'])) {
						$newSizeX = $sizeX;
						$newSizeY = $sizeY;
						// Check width
						if ($params['thumbMaxWidth'] && $newSizeX > $params['thumbMaxWidth']) {
							$newSizeY = round(($params['thumbMaxWidth']*$newSizeY)/$newSizeX);
							$newSizeX = $params['thumbMaxWidth'];
						}
						if($params['thumbMaxHeight'] && $newSizeY > $params['thumbMaxHeight']){
							$newSizeX = round(($params['thumbMaxHeight']*$newSizeX)/$newSizeY);
							$newSizeY = $params['thumbMaxHeight'];
						}
						if (!$oImage->resize($newSizeX, $newSizeY, $newFilename)) {
							return false;
						}
					}
				}
				//set thumbnail
				if (!$this->_subfieldValues[1]->setValue($newBasename)) {
					return false;
				}
			}
			//File
			//1- from external location
			if (isset($values[$prefixName.$this->_field->getID().'_externalfile']) && $values[$prefixName.$this->_field->getID().'_externalfile']) {
				
				//from FTP directory
				$filename = $values[$prefixName.$this->_field->getID().'_externalfile'];
				
				//check file extension
				if ($params['allowedType'] || $params['disallowedType']) {
					$extension = io::strtolower(pathinfo($filename, PATHINFO_EXTENSION));
					if (!$extension) return false;
					//extension must be in allowed list
					if ($params['allowedType'] && !in_array($extension, explode(',',io::strtolower($params['allowedType'])))) {
						return false;
					}
					//extension must not be in disallowed list
					if ($params['disallowedType'] && in_array($extension, explode(',',io::strtolower($params['disallowedType'])))) {
						return false;
					}
				}
				//destroy old file if any
				if ($this->_subfieldValues[4]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue());
					$this->_subfieldValues[4]->setValue('');
				}
				
				$new_filename = 'r'.$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($filename));
				if (io::strlen($new_filename) > 255) {
					$new_filename = sensitiveIO::ellipsis($new_filename, 255, '-', true);
				}
				$destination_path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/';
				$ftp_dir = PATH_REALROOT_FS.$params['ftpDir'];
				if (@file_exists($ftp_dir.$filename) && is_file($ftp_dir.$filename)) {
					if (CMS_file::moveTo($ftp_dir.$filename, $destination_path.'/'.$new_filename)) {
						CMS_file::chmodFile(FILES_CHMOD, $destination_path.'/'.$new_filename);
						//set label as file name if none set
						if (!$values[$prefixName.$this->_field->getID().'_0']) {
							if (!$this->_subfieldValues[0]->setValue(io::htmlspecialchars($filename))) {
								return false;
							}
						}
						//set it
						if (!$this->_subfieldValues[4]->setValue($new_filename)) {
							return false;
						}
						//and set filesize
						$filesize = @filesize($destination_path.'/'.$new_filename);
						if ($filesize !== false && $filesize > 0) {
							//convert in MB
							$filesize = round(($filesize/1048576),2);
						} else {
							$filesize = '0';
						}
						if (!$this->_subfieldValues[2]->setValue($filesize)) {
							return false;
						}
						//set file type
						if (!$this->_subfieldValues[3]->setValue(self::OBJECT_FILE_TYPE_INTERNAL)) {
							return false;
						}
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else
			//2- from post
			if ($values[$prefixName.$this->_field->getID().'_4'] && io::strpos($values[$prefixName.$this->_field->getID().'_4'], PATH_UPLOAD_WR.'/') !== false) {
				//check file extension
				if ($params['allowedType'] || $params['disallowedType']) {
					$extension = io::strtolower(pathinfo($values[$prefixName.$this->_field->getID().'_4'], PATHINFO_EXTENSION));
					if (!$extension) return false;
					//extension must be in allowed list
					if ($params['allowedType'] && !in_array($extension, explode(',',io::strtolower($params['allowedType'])))) {
						return false;
					}
					//extension must not be in disallowed list
					if ($params['disallowedType'] && in_array($extension, explode(',',io::strtolower($params['disallowedType'])))) {
						return false;
					}
				}
				//set file type
				if (!$this->_subfieldValues[3]->setValue(self::OBJECT_FILE_TYPE_INTERNAL)) {
					return false;
				}
				//destroy old file if any
				if ($this->_subfieldValues[4]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue());
					$this->_subfieldValues[4]->setValue('');
				}
				
				//move and rename uploaded file 
				$filename = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $values[$prefixName.$this->_field->getID().'_4']);
				$basename = pathinfo($filename, PATHINFO_BASENAME);
				
				//create file path
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED;
				$newBasename = "r".$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($basename));
				if (io::strlen($newBasename) > 255) {
					$newBasename = sensitiveIO::ellipsis($newBasename, 255, '-', true);
				}
				$newFilename = $path.'/'.$newBasename;
				if (!CMS_file::moveTo($filename, $newFilename)) {
					return false;
				}
				CMS_file::chmodFile(FILES_CHMOD, $newFilename);
				//set it
				if (!$this->_subfieldValues[4]->setValue($newBasename)) {
					return false;
				}
				//and set filesize
				$filesize = @filesize($newFilename);
				if ($filesize !== false && $filesize > 0) {
					//convert in MB
					$filesize = round(($filesize/1048576),2);
				} else {
					$filesize = '0';
				}
				if (!$this->_subfieldValues[2]->setValue($filesize)) {
					return false;
				}
			}
			// If label not set yet, set it
			if(!$this->_subfieldValues[0]->getValue()){
				if($this->_subfieldValues[4]->getValue()){
					$this->_subfieldValues[0]->setValue($this->_subfieldValues[4]->getValue());
				}
			}
			//update files infos if needed
			if ($this->_subfieldValues[1]->getValue() && file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue())) {
				$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue());
				$imageDatas = array(
					'filename'		=> $file->getName(false),
					'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
					'filesize'		=> $file->getFileSize(),
					'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
					'extension'		=> $file->getExtension(),
				);
			} else {
				$imageDatas = array(
					'filename'		=> '',
					'filepath'		=> '',
					'filesize'		=> '',
					'fileicon'		=> '',
					'extension'		=> '',
				);
			}
			//update files infos if needed
			if ($this->_subfieldValues[4]->getValue() && file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue())) {
				$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue());
				$fileDatas = array(
					'filename'		=> $file->getName(false),
					'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
					'filesize'		=> $file->getFileSize(),
					'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
					'extension'		=> $file->getExtension(),
				);
			} else {
				$fileDatas = array(
					'filename'		=> '',
					'filepath'		=> '',
					'filesize'		=> '',
					'fileicon'		=> '',
					'extension'		=> '',
				);
			}
			$imageDatas['module']		= $fileDatas['module']			= $moduleCodename;
			$imageDatas['visualisation']= $fileDatas['visualisation']	= RESOURCE_DATA_LOCATION_EDITED;
			$content = array('datas' => array(
				'polymodFieldsValue['.$prefixName.$this->_field->getID().'_1]' => $imageDatas,
				'polymodFieldsValue['.$prefixName.$this->_field->getID().'_4]' => $fileDatas,
				'polymodFieldsValue['.$prefixName.$this->_field->getID().'_externalfile]' => '',
				'polymodFieldsValue['.$prefixName.$this->_field->getID().'_0]' => sensitiveIO::decodeEntities($this->_subfieldValues[0]->getValue()),
			));
			
			$view = CMS_view::getInstance();
			$view->addContent($content);
			return true;
		} else { //Old format
			//delete old files ?
			if (isset($values[$prefixName.$this->_field->getID().'_delete']) && $values[$prefixName.$this->_field->getID().'_delete'] == 1) {
				//thumbnail
				if ($this->_subfieldValues[1]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue());
					$this->_subfieldValues[1]->setValue('');
				} elseif ($values[$prefixName.$this->_field->getID().'_1_hidden']) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$values[$prefixName.$this->_field->getID().'_1_hidden']);
					$this->_subfieldValues[1]->setValue('');
				}
				//file
				if ($this->_subfieldValues[4]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue());
					$this->_subfieldValues[4]->setValue('');
				} elseif ($values[$prefixName.$this->_field->getID().'_4_hidden']) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$values[$prefixName.$this->_field->getID().'_4_hidden']);
					$this->_subfieldValues[4]->setValue('');
				}
				//reset filesize
				if (!$this->_subfieldValues[2]->setValue(0)) {
					return false;
				}
			}
			
			if (!(isset($values[$prefixName.$this->_field->getID().'_0']) && $this->_subfieldValues[0]->setValue(io::htmlspecialchars($values[$prefixName.$this->_field->getID().'_0'])))) {
			    return false;
			}
			
			//thumbnail
			if (isset($_FILES[$prefixName.$this->_field->getID().'_1']) && $_FILES[$prefixName.$this->_field->getID().'_1']['name'] && !$_FILES[$prefixName.$this->_field->getID().'_1']['error']) {
				//check for image type before doing anything
				if (!in_array(io::strtolower(pathinfo($_FILES[$prefixName.$this->_field->getID().'_1']["name"], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
					return false;
				}
				
				//destroy old image if any
				if ($this->_subfieldValues[1]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[1]->getValue());
					$this->_subfieldValues[1]->setValue('');
				} elseif ($values[$prefixName.$this->_field->getID().'_1_hidden']) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$values[$prefixName.$this->_field->getID().'_1_hidden']);
					$this->_subfieldValues[1]->setValue('');
				}
				
				//set thumbnail (resize it if needed)
				
				//create thumbnail path
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED;
				$filename = "r".$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($_FILES[$prefixName.$this->_field->getID().'_1']["name"]));
				if (io::strlen($filename) > 255) {
					$filename = sensitiveIO::ellipsis($filename, 255, '-', true);
				}
				//move uploaded file
				$fileDatas = CMS_file::uploadFile($prefixName.$this->_field->getID().'_1', PATH_TMP_FS);
				if ($fileDatas['error']) {
					return false;
				}
				if (!CMS_file::moveTo(PATH_TMP_FS.'/'.$fileDatas['filename'], $path."/".$filename)) {
					return false;
				}
				if ($params['thumbMaxWidth'] > 0 || $params['thumbMaxHeight'] > 0) {
					$oImage = new CMS_image($path."/".$filename);
					//get current file size
					$sizeX = $oImage->getWidth();
					$sizeY = $oImage->getHeight();
					//check thumbnail size
					if ($sizeX > $params['thumbMaxWidth'] || $sizeX > $params['thumbMaxHeight']) {
						$newSizeX = $sizeX;
						$newSizeY = $sizeY;
						// Check width
						if ($params['thumbMaxWidth'] && $newSizeX > $params['thumbMaxWidth']) {
							$newSizeY = round(($params['thumbMaxWidth']*$newSizeY)/$newSizeX);
							$newSizeX = $params['thumbMaxWidth'];
						}
						if($params['thumbMaxHeight'] && $newSizeY > $params['thumbMaxHeight']){
							$newSizeX = round(($params['thumbMaxHeight']*$newSizeX)/$newSizeY);
							$newSizeY = $params['thumbMaxHeight'];
						}
						//resize image
						$srcfilepath = $path."/".$filename;
						$path_parts = pathinfo($srcfilepath);
						$thumbnailFilename = io::substr($path_parts['basename'],0,-(io::strlen($path_parts['extension'])+1)).'.png';
						$destfilepath = $path."/".$thumbnailFilename;
						
						if (!$oImage->resize($newSizeX, $newSizeY, $destfilepath)) {
							return false;
						}
						//destroy original image
						@unlink($srcfilepath);
						//set resized thumbnail
						if (!$this->_subfieldValues[1]->setValue($thumbnailFilename)) {
							return false;
						}
					} else {
						//no need to resize thumbnail (below the maximum width), so set it
						if (!$this->_subfieldValues[1]->setValue($filename)) {
							return false;
						}
					}
				} else {
					//no need to resize thumbnail (no size limit), so set it
					if (!$this->_subfieldValues[1]->setValue($filename)) {
						return false;
					}
				}
			} elseif (isset($_FILES[$prefixName.$this->_field->getID().'_1']) && $_FILES[$prefixName.$this->_field->getID().'_1']['name'] && $_FILES[$prefixName.$this->_field->getID().'_1']['error'] != 0) {
				return false;
			} elseif (isset($values[$prefixName.$this->_field->getID().'_1_hidden']) && $values[$prefixName.$this->_field->getID().'_1_hidden'] && $values[$prefixName.$this->_field->getID().'_delete'] != 1) {
				if(!$this->_subfieldValues[1]->setValue($values[$prefixName.$this->_field->getID().'_1_hidden'])) {
					return false;
				}
			}
			//File
			//1- from external location
			if (isset($values[$prefixName.$this->_field->getID().'_externalfile']) && $values[$prefixName.$this->_field->getID().'_externalfile']) {
				//destroy old file if any
				if ($this->_subfieldValues[4]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue());
					$this->_subfieldValues[4]->setValue('');
				} elseif ($values[$prefixName.$this->_field->getID().'_4_hidden']) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$values[$prefixName.$this->_field->getID().'_4_hidden']);
					$this->_subfieldValues[4]->setValue('');
				}
				
				//from FTP directory
				$filename = $values[$prefixName.$this->_field->getID().'_externalfile'];//io::substr($values[$prefixName.$this->_field->getID().'_externalfile'], 1);
				
				//check file extension
				if ($params['allowedType'] || $params['disallowedType']) {
					$extension = io::strtolower(pathinfo($filename, PATHINFO_EXTENSION));
					if (!$extension) return false;
					//extension must be in allowed list
					if ($params['allowedType'] && !in_array($extension, explode(',',io::strtolower($params['allowedType'])))) {
						return false;
					}
					//extension must not be in disallowed list
					if ($params['disallowedType'] && in_array($extension, explode(',',io::strtolower($params['disallowedType'])))) {
						return false;
					}
				}
				
				$new_filename = 'r'.$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($filename));
				if (io::strlen($new_filename) > 255) {
					$new_filename = sensitiveIO::ellipsis($new_filename, 255, '-', true);
				}
				$destination_path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/';
				$ftp_dir = PATH_REALROOT_FS.$params['ftpDir'];
				if (@file_exists($ftp_dir.$filename) && is_file($ftp_dir.$filename)) {
					if (@copy($ftp_dir.$filename, $destination_path.'/'.$new_filename)) {
						@chmod($destination_path.'/'.$new_filename, octdec(FILES_CHMOD));
						//set label as file name if none set
						if (!$values[$prefixName.$this->_field->getID().'_0']) {
							if (!$this->_subfieldValues[0]->setValue(io::htmlspecialchars($filename))) {
								return false;
							}
						}
						//set it
						if (!$this->_subfieldValues[4]->setValue($new_filename)) {
							return false;
						}
						//and set filesize
						$filesize = @filesize($destination_path.'/'.$new_filename);
						if ($filesize !== false && $filesize > 0) {
							//convert in MB
							$filesize = round(($filesize/1048576),2);
						} else {
							$filesize = '0';
						}
						if (!$this->_subfieldValues[2]->setValue($filesize)) {
							return false;
						}
						//set file type
						if (!$this->_subfieldValues[3]->setValue(self::OBJECT_FILE_TYPE_INTERNAL)) {
							return false;
						}
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else
			//2- from post
			if (isset($_FILES[$prefixName.$this->_field->getID().'_4']) && $_FILES[$prefixName.$this->_field->getID().'_4']['name'] && !$_FILES[$prefixName.$this->_field->getID().'_4']['error']) {
				//check file extension
				if ($params['allowedType'] || $params['disallowedType']) {
					$extension = io::strtolower(pathinfo($_FILES[$prefixName.$this->_field->getID().'_4']['name'], PATHINFO_EXTENSION));
					if (!$extension) return false;
					//extension must be in allowed list
					if ($params['allowedType'] && !in_array($extension, explode(',',io::strtolower($params['allowedType'])))) {
						return false;
					}
					//extension must not be in disallowed list
					if ($params['disallowedType'] && in_array($extension, explode(',',io::strtolower($params['disallowedType'])))) {
						return false;
					}
				}
				//set label as image name if none set
				if (!$values[$prefixName.$this->_field->getID().'_0']) {
					if (!$this->_subfieldValues[0]->setValue(io::htmlspecialchars($_FILES[$prefixName.$this->_field->getID().'_4']["name"]))) {
						return false;
					}
				}
				//set file type
				if (!$this->_subfieldValues[3]->setValue(self::OBJECT_FILE_TYPE_INTERNAL)) {
					return false;
				}
				//destroy old file if any
				if ($this->_subfieldValues[4]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue());
					$this->_subfieldValues[4]->setValue('');
				}
				
				//create thumnail path
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED;
				$filename = "r".$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($_FILES[$prefixName.$this->_field->getID().'_4']["name"]));
				if (io::strlen($filename) > 255) {
					$filename = sensitiveIO::ellipsis($filename, 255, '-', true);
				}
				
				//move uploaded file
				$fileDatas = CMS_file::uploadFile($prefixName.$this->_field->getID().'_4', PATH_TMP_FS);
				if ($fileDatas['error']) {
					return false;
				}
				if (!CMS_file::moveTo(PATH_TMP_FS.'/'.$fileDatas['filename'], $path."/".$filename)) {
					return false;
				}
				//set it
				if (!$this->_subfieldValues[4]->setValue($filename)) {
					return false;
				}
				//and set filesize
				$filesize = @filesize($path."/".$filename);
				if ($filesize !== false && $filesize > 0) {
					//convert in MB
					$filesize = round(($filesize/1048576),2);
				} else {
					$filesize = '0';
				}
				if (!$this->_subfieldValues[2]->setValue($filesize)) {
					return false;
				}
			} elseif (isset($_FILES[$prefixName.$this->_field->getID().'_4']) && $_FILES[$prefixName.$this->_field->getID().'_4']['name'] && $_FILES[$prefixName.$this->_field->getID().'_4']['error'] != 0) {
				return false;
			} else
			//from hidden fields (previously set but not already saved)
			if (isset($values[$prefixName.$this->_field->getID().'_4_hidden']) && $values[$prefixName.$this->_field->getID().'_4_hidden'] && (!isset($values[$prefixName.$this->_field->getID().'_delete']) || $values[$prefixName.$this->_field->getID().'_delete'] != 1)) {
				//set label as image name if none set
				if ($values[$prefixName.$this->_field->getID().'_0']) {
					if (!$this->_subfieldValues[0]->setValue(io::htmlspecialchars($values[$prefixName.$this->_field->getID().'_0']))) {
						return false;
					}
				}
				//set filesize
				if (!$this->_subfieldValues[2]->setValue($values[$prefixName.$this->_field->getID().'_2_hidden'])) {
					return false;
				}
				//set file type
				if (!$this->_subfieldValues[3]->setValue($values[$prefixName.$this->_field->getID().'_3_hidden'])) {
					return false;
				}
				if(!$this->_subfieldValues[4]->setValue($values[$prefixName.$this->_field->getID().'_4_hidden'])) {
					return false;
				}
			}
			// If label not set yet, set it
			if(!$this->_subfieldValues[0]->getValue()){
				if($this->_subfieldValues[4]->getValue()){
					$this->_subfieldValues[0]->setValue($this->_subfieldValues[4]->getValue());
				}
			}
			return true;
		}
	}
	
	/**
	  * get object HTML description for admin search detail.
	  *
	  * @return string : object HTML description
	  * @access public
	  */
	function getHTMLDescription() {
		//icon tag with link to file
		$file = '';
		if ($this->_subfieldValues[4]->getValue()) {
			$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			$filepath = ($this->_subfieldValues[3]->getValue() == self::OBJECT_FILE_TYPE_INTERNAL) ? PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[4]->getValue() : $this->_subfieldValues[4]->getValue();
			$icon = $this->_getFileIcon();
			if ($icon) {
				$icon = '<img src="'.$icon.'" alt="'.$this->_getFileExtension().'" title="'.$this->_getFileExtension().'" border="0" />&nbsp;';
			}
			$file = '<a href="'.$filepath.'" class="admin" target="_blank">'.$icon.$this->_subfieldValues[0]->getValue().'</a> ('.$this->_subfieldValues[2]->getValue().'Mo)';
		}
		return $file;
	}
	
	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
		$structure = parent::getStructure();
		unset($structure['value']);
		$structure['file'] = '';
		$structure['thumb'] = '';
		$structure['fileHTML'] = '';
		$structure['fileLabel'] = '';
		$structure['filename'] = '';
		$structure['thumbname'] = $structure['thumbnail'] = '';
		$structure['filePath'] = '';
		$structure['thumbWidth'] = '';
		$structure['thumbHeight'] = '';
		$structure['imageWidth'] = '';
		$structure['imageHeight'] = '';
		$structure['thumbMaxWidth'] = '';
		$structure['thumbMaxHeight'] = '';
		$structure['fileSize'] = '';
		$structure['fileIcon'] = '';
		$structure['fileExtension'] = '';
		$structure['thumbExtension'] = '';
		$structure['alternativeDomain'] = '';
		return $structure;
	}
	
	/**
	  * get an object value
	  *
	  * @param string $name : the name of the value to get
	  * @param string $parameters (optional) : parameters for the value to get
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getValue($name, $parameters = '') {
		switch($name) {
			case 'file':
			case 'thumb':
				if($name == 'file') {
					$fieldIndex = 4;
					$fielfPrefix = 'image';
				}
				else {
					$fieldIndex = 1;
					$fielfPrefix = 'thumb';
				}
				// If we have a value and there are additionnal cropping parameters
				if ($this->_subfieldValues[$fieldIndex]->getValue() && $parameters && in_array($this->getValue($name.'Extension'), array('jpg', 'jpeg', 'png', 'gif'))) {
					@list($x, $y) = explode(',',str_replace(';', ',', $parameters));
					if ((io::isPositiveInteger($x) && $x < $this->getValue($fielfPrefix.'Width')) || (io::isPositiveInteger($y) && $y < $this->getValue($fielfPrefix.'Height'))) {
						$crop = ($x && $y) ? 1 : 0;
						//get module codename
						$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
						//set location
						$location = ($this->isPublic()) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
						//resized image path
						$pathInfo = pathinfo($this->_subfieldValues[$fieldIndex]->getValue());
						$resizedImage = $pathInfo['filename'] .'-'. $x .'-'. $y .($crop ? '-c' : '').'.'. $pathInfo['extension'];
						//resized image path
						$resizedImagepathFS = PATH_MODULES_FILES_FS . '/' . $moduleCodename . '/'.$location.'/' . $resizedImage;
						//if file already exists, no need to resize file send it
						
						if(file_exists($resizedImagepathFS)) {
							return $this->getValue('filePath') . '/' . $resizedImage;
						} else {
							return CMS_websitesCatalog::getCurrentDomain() . PATH_REALROOT_WR .'/image-file'.(!STRIP_PHP_EXTENSION ? '.php' : '').'?image='. $this->_subfieldValues[$fieldIndex]->getValue() .'&amp;module='. $moduleCodename .'&amp;x='. $x .'&amp;y='. $y.'&amp;crop='.$crop.($location != RESOURCE_DATA_LOCATION_PUBLIC ? '&amp;location='.$location : '');
						}
					}
				}
				if ($this->_subfieldValues[$fieldIndex]->getValue()) {
					// If we have a value but no cropping params
					return $this->getValue('filePath'). '/' .$this->_subfieldValues[$fieldIndex]->getValue();
				}
				return '';
			break;
			case 'fileHTML':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				$filepath = ($this->_subfieldValues[3]->getValue() == self::OBJECT_FILE_TYPE_INTERNAL) ?
						PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.$location.'/'.$this->_subfieldValues[4]->getValue() :
						$this->_subfieldValues[4]->getValue();

				//append website url if missing
				if (io::substr($filepath,0,1) == '/') {
					$filepath = CMS_websitesCatalog::getCurrentDomain() . $filepath;
				}
				//link content
				$linkContent = ($parameters) ? $parameters : $this->_subfieldValues[0]->getValue();
				$file = '<a href="'.$filepath.'" target="_blank" title="'.$this->_subfieldValues[0]->getValue().'">'.$linkContent.'</a>';
				return $file;
			break;
			case 'fileLabel':
				return $this->_subfieldValues[0]->getValue();
			break;
			case 'filename':
				return $this->_subfieldValues[4]->getValue();
			break;
			case 'thumbnail':
			case 'thumbname':
				return $this->_subfieldValues[1]->getValue();
			break;
			case 'filePath':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->isPublic()) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				$altDomain = $this->getAlternativeDomain();
				// If we are serving a public file and there is an alternative domain set up, change the url
				if($this->isPublic() && $altDomain) {
					return $altDomain . PATH_MODULES_FILES_WR . '/' . $moduleCodename . '/'.$location;
				}
				else {
					return CMS_websitesCatalog::getCurrentDomain() . PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.$location;
				}
			break;
			case 'thumbMaxWidth':
				//get field parameters
				$params = $this->getParamsValues();
				return ($params['thumbMaxWidth']) ? $params['thumbMaxWidth'] : '';
			break;
			case 'thumbMaxHeight':
				//get field parameters
				$params = $this->getParamsValues();
				return ($params['thumbMaxHeight']) ? $params['thumbMaxHeight'] : '';
			break;
			case 'thumbWidth':
			case 'thumbHeight':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->isPublic()) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.$location;
				$imgPath = $path."/".$this->_subfieldValues[1]->getValue();
				$sizeX = $sizeY = 0;
				if(file_exists($imgPath)){
				    list($sizeX, $sizeY) = @getimagesize($imgPath);
				}
				if ($name == 'thumbWidth') {
					return (string) $sizeX;
				} else {
					return (string) $sizeY;
				}
			break;
			case 'imageWidth':
			case 'imageHeight':
				if ($this->_subfieldValues[4]->getValue() && in_array($this->getValue('fileExtension'), array('jpg', 'jpeg', 'png', 'gif'))) {
					//get module codename
					$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
					//set location
					$location = ($this->isPublic()) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
					$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.$location;
					$imgPath = $path."/".$this->_subfieldValues[4]->getValue();
					$sizeX = $sizeY = 0;
					if(file_exists($imgPath)){
					    list($sizeX, $sizeY) = @getimagesize($imgPath);
					}
					if ($name == 'imageWidth') {
						return (string) $sizeX;
					} else {
						return (string) $sizeY;
					}
				}
				return 0;
			break;
			case 'fileSize':
				return $this->_subfieldValues[2]->getValue();
			break;
			case 'fileIcon':
				return $this->_getFileIcon();
			break;
			case 'fileExtension':
				return $this->_getFileExtension();
			break;
			case 'thumbExtension':
				return $this->_getThumbExtension();
			break;
			case 'alternativeDomain':
				return $this->getAlternativeDomain();
			default:
				return parent::getValue($name, $parameters);
			break;
		}
	}
	
	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	function getLabelsStructure(&$language, $objectName = '') {
		$labels = parent::getLabelsStructure($language, $objectName);
		unset($labels['structure']['value']);
		
		$labels['structure']['file|width,height'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['thumb|width,height'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_THUMB_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['fileHTML'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILEHTML_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['fileLabel'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILELABEL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['filename'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILENAME_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['thumbname'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILETHUMBNAME_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['filePath'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILEPATH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['thumbWidth'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_THUMBWIDTH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['thumbHeight'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_THUMBHEIGHT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageWidth'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_IMAGEWIDTH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageHeight'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_IMAGEHEIGHT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['thumbMaxWidth'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_IMAGEMAXWIDTH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['thumbMaxheight'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_IMAGEMAXHEIGHT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['fileSize'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILESIZE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['fileIcon'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILEICON_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['fileExtension'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_FILEEXTENTION_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['thumbExtension'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_THUMBEXTENTION_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['alternativeDomain'] = $language->getMessage(self::MESSAGE_OBJECT_FILE_PARAMETER_ALTERNATIVE_DOMAIN,false ,MOD_POLYMOD_CODENAME);
		return $labels;
	}
	
	/**
      * Get field order SQL request (used by class CMS_object_search)
      *
      * @param integer $fieldID : this field id in object (aka $this->_field->getID())
      * @param mixed $direction : the direction to search (asc/desc)
      * @param string $operator : additionnal search operator
      * @param string $where : where clauses to add to SQL
      * @param boolean $public : values are public or edited ? (default is edited)
      * @return string : the SQL request
      * @access public
      */
	function getFieldOrderSQL($fieldID, $direction, $operator, $where, $public = false) {
		$statusSuffix = ($public) ? "_public":"_edited";
		//operators are not supported for now : TODO
		$supportedOperator = array();
		if ($operator && !in_array($operator, $supportedOperator)) {
			$this->setError("Unkown search operator : ".$operator.", use default search instead");
			$operator = false;
		}
		$sql = '';
		
		//only add tables used by subfields
		foreach ($this->_subfields as $subFieldID => $subFieldDefinition) {
			$types[$subFieldDefinition['type']] = true;
		}
		//choose table
		$fromTable = 'mod_subobject_string';
		
		// create sql
		$sql = "
		select
			distinct objectID
		from
			".$fromTable.$statusSuffix."
		where
			objectFieldID = '".SensitiveIO::sanitizeSQLString($fieldID)."'
			and objectSubFieldID = '0'
			$where
		order by value ".$direction;
		return $sql;
	}

	/**
	 * Return the alternative domain to use for this object, or false if not set up
	 * @return mixed the domain to use, or false
	 */
	private function getAlternativeDomain(){
		return !empty($this->_parameterValues[8]) ? $this->_parameterValues[8] : false;
	}
}
?>