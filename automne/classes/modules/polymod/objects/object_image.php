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
// $Id: object_image.php,v 1.15 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_object_image
  *
  * represent an image object
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_image extends CMS_object_common
{

	const MESSAGE_OBJECT_IMAGE_LABEL = 200;
	const MESSAGE_OBJECT_IMAGE_DESCRIPTION = 201;
	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXWIDTH = 202;
	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXWIDTH_DESC = 212;
  	const MESSAGE_OBJECT_IMAGE_IMAGEMAXWIDTH_DESCRIPTION = 253;
  	const MESSAGE_OBJECT_IMAGE_IMAGEMAXHEIGHT_DESCRIPTION = 413;
  	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXHEIGHT = 423;
  	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXHEIGHT_DESC = 412;
	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAKEZOOM = 205;
	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXZOOMWIDTH = 549;
	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXZOOMWIDTH_DESC = 550;
  	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXZOOMHEIGHT = 551;
  	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXZOOMHEIGHT_DESC = 552;
	const MESSAGE_OBJECT_IMAGE_FIELD_LABEL = 581;
	const MESSAGE_OBJECT_IMAGE_FIELD_THUMBNAIL = 206;
	const MESSAGE_OBJECT_IMAGE_FIELD_ZOOM = 207;
	const MESSAGE_OBJECT_IMAGE_FIELD_DESC = 208;
	const MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT = 415;
  	const MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT_AND_WIDTH = 416;
	const MESSAGE_OBJECT_IMAGE_PARAMETER_USEDISTINCTZOOM = 209;
	const MESSAGE_OBJECT_IMAGE_FIELD_USE_ORIGINAL_AS_ZOOM = 211;
	const MESSAGE_OBJECT_IMAGE_PARAMETER_MAXWIDTHPREVIZ = 409;
	const MESSAGE_OBJECT_IMAGE_FIELD_DELETE = 213;
	const MESSAGE_OBJECT_IMAGE_FIELD_ACTUAL_IMAGE = 214;
	const MESSAGE_OBJECT_IMAGE_IMAGEHTML_DESCRIPTION = 215;
	const MESSAGE_OBJECT_IMAGE_IMAGELABEL_DESCRIPTION = 216;
	const MESSAGE_OBJECT_IMAGE_IMAGENAME_DESCRIPTION = 217;
	const MESSAGE_OBJECT_IMAGE_IMAGEZOOMNAME_DESCRIPTION = 218;
	const MESSAGE_OBJECT_IMAGE_IMAGEPATH_DESCRIPTION = 219;
	const MESSAGE_OBJECT_IMAGE_IMAGEWIDTH_DESCRIPTION = 220;
	const MESSAGE_OBJECT_IMAGE_IMAGEHEIGHT_DESCRIPTION = 221;
	const MESSAGE_OBJECT_IMAGE_IMAGEZOOMWIDTH_DESCRIPTION = 222;
	const MESSAGE_OBJECT_IMAGE_IMAGEZOOMHEIGHT_DESCRIPTION = 223;
	const MESSAGE_OBJECT_IMAGE_IMAGESIZE_DESCRIPTION = 224;
	const MESSAGE_OBJECT_IMAGE_IMAGEZOOMSIZE_DESCRIPTION = 225;
	const MESSAGE_OBJECT_IMAGE_FIELD_MAX_FILESIZE = 236;
	const MESSAGE_OBJECT_IMAGE_IMAGE_DESCRIPTION = 579;
	const MESSAGE_OBJECT_IMAGE_IMAGEZOOM_DESCRIPTION = 580;
	const MESSAGE_OBJECT_IMAGE_PARAMETER_LEGENDMANDATORY = 582;
	
	//standard messages
	const MESSAGE_SELECT_PICTURE = 528;
	
	/**
	  * Name of the enlarged image pop-up file
	  */
	const OBJECT_IMAGE_POPUP_FILE = "imagezoom.php";
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_IMAGE_LABEL;

	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_IMAGE_DESCRIPTION;

	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'string',
										'required' 		=> true,
										'internalName'	=> 'image',
									),
							1 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'imagename',
									),
							2 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'imagezoom',
									),
							);


	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array(0 => '',1 => '',2 => '');

	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array(
							0 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'maxWidth',
										'externalName'	=> self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXWIDTH,
										'description' 	=> self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXWIDTH_DESC,
									),
							1 => array(
										'type'			=> 'integer',
										'required'		=> false,
										'internalName'  => 'maxHeight',
										'externalName'  => self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXHEIGHT,
										'description'   => self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXHEIGHT_DESC,
									),
							2 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'makeZoom',
										'externalName'	=> self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAKEZOOM,
									),
							3 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'maxZoomWidth',
										'externalName'	=> self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXZOOMWIDTH,
										'description' 	=> self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXZOOMWIDTH_DESC,
									),
							4 => array(
										'type'			=> 'integer',
										'required'		=> false,
										'internalName'  => 'maxZoomHeight',
										'externalName'  => self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXZOOMHEIGHT,
										'description'   => self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXZOOMHEIGHT_DESC,
									),
							5 => array(
										'type' 			=> 'boolean',
										'required' 		=> false,
										'internalName'	=> 'useDistinctZoom',
										'externalName'	=> self::MESSAGE_OBJECT_IMAGE_PARAMETER_USEDISTINCTZOOM,
									),
							6 => array(
										'type'			=> 'integer',
										'required'		=> false,
										'internalName'  => 'maxWidthPreviz',
										'externalName'  => self::MESSAGE_OBJECT_IMAGE_PARAMETER_MAXWIDTHPREVIZ,
									),
							7 => array(
										'type'			=> 'boolean',
										'required'		=> false,
										'internalName'  => 'legendMandatory',
										'externalName'  => self::MESSAGE_OBJECT_IMAGE_PARAMETER_LEGENDMANDATORY,
									),
							);

	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => '',1 => '',2 => true,3 => '',4 => '',5 => false,6 => '16',7 => false);

	/**
	  * all images extension allowed
	  * @var array()
	  * @access private
	  */
	protected $_allowedExtensions = array("gif","jpg","jpeg","png");

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
	  * get object label
	  *
	  * @return string : the label
	  * @access public
	  */
	function getLabel() {
		if (!is_object($this->_subfieldValues[1])) {
			$this->raiseError("No subField to get for label : ".print_r($this->_subfieldValues,true));
			return false;
		}
		return $this->_subfieldValues[1]->getValue();
	}

	/**
	  * check object Mandatories Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function checkMandatory($values,$prefixName, $newFormat = false) {
		if ($newFormat) {
			//check for image extension before doing anything
			if (isset($values[$prefixName.$this->_field->getID().'_0'])
				 && $values[$prefixName.$this->_field->getID().'_0']
				 && !in_array(io::strtolower(pathinfo($values[$prefixName.$this->_field->getID().'_0'], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
				return false;
			}
			//check for image extension before doing anything
			if (isset($values[$prefixName.$this->_field->getID().'_2'])
				 && $values[$prefixName.$this->_field->getID().'_2']
				 && !in_array(io::strtolower(pathinfo($values[$prefixName.$this->_field->getID().'_2'], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
				return false;
			}
			//if field is required check minimum values
			if ($this->_field->getValue('required')) {
				//must have image in image field
				if(!$values[$prefixName.$this->_field->getID().'_0']) {
					return false;
				}
			}
			$params = $this->getParamsValues();
			//check if legend if set if it is mandatory
			if (isset($params['legendMandatory']) && $params['legendMandatory']) {
				//must have image in image field
				if($values[$prefixName.$this->_field->getID().'_0'] && !$values[$prefixName.$this->_field->getID().'_1']) {
					return false;
				}
			}
			return true;
		} else {
			//check for image extension before doing anything
			if (isset($_FILES[$prefixName.$this->_field->getID().'_0']["name"]) && $_FILES[$prefixName.$this->_field->getID().'_0']["name"]
				 && !in_array(strtolower(pathinfo($_FILES[$prefixName.$this->_field->getID().'_0']["name"], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
				return false;
			}
			//check for image extension before doing anything
			if (isset($_FILES[$prefixName.$this->_field->getID().'_2']) && $_FILES[$prefixName.$this->_field->getID().'_2']["name"]
				 && !in_array(io::strtolower(pathinfo($_FILES[$prefixName.$this->_field->getID().'_2']["name"], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
				return false;
			}
			//if field is required check values
			if ($this->_field->getValue('required')) {
				//must have image in upload field or in hidden field or image must be already set
				//if deleted is checked, image must be set in upload field
				if ((!$this->_subfieldValues[0]->getValue() && !$_FILES[$prefixName.$this->_field->getID().'_0']['name'] && (!isset($values[$prefixName.$this->_field->getID().'_0_hidden']) || !$values[$prefixName.$this->_field->getID().'_0_hidden'])) || (isset($values[$prefixName.$this->_field->getID().'_delete']) && $values[$prefixName.$this->_field->getID().'_delete'] == 1 && !$_FILES[$prefixName.$this->_field->getID().'_0']['name'])) {
					return false;
				}
			}
			$params = $this->getParamsValues();
			//check if legend if set if it is mandatory
			if (isset($params['legendMandatory']) && $params['legendMandatory']) {
				//must have image in image field
				if (($_FILES[$prefixName.$this->_field->getID().'_0']['name'] || $this->_subfieldValues[0]->getValue()) && !$values[$prefixName.$this->_field->getID().'_1']) {
					return false;
				}
			}
		}
		return true;
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
		//Image datas
		if ($this->_subfieldValues[0]->getValue() && file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue())) {
			$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue());
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
		//move title from offset 1 to offset 0
		$titleField = $return['items'][1];
		$return['items'][1] = $return['items'][0];
		$return['items'][0] = $titleField;
		//Title
		unset($return['items'][0]['hideLabel']);
		if (isset($params['legendMandatory']) && $params['legendMandatory']) {
			$return['items'][0]['fieldLabel']	= '<span class="atm-red">*</span> '.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_LABEL, false, MOD_POLYMOD_CODENAME);
		} else {
			$return['items'][0]['fieldLabel']	= $language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_LABEL, false, MOD_POLYMOD_CODENAME);
		}
		$return['items'][0]['allowBlank']	= ($this->_field->getValue('required') && isset($params['legendMandatory']) && $params['legendMandatory']) ? false : true;
		
		//Thumbnail
		unset($return['items'][1]['hideLabel']);
		$return['items'][1]['xtype']		= 'atmImageUploadField';
		$return['items'][1]['emptyText']	= $language->getMessage(self::MESSAGE_SELECT_PICTURE);
		$return['items'][1]['fieldLabel']	= $language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_THUMBNAIL, false, MOD_POLYMOD_CODENAME);
		if (!$params['makeZoom']) {
			if ($params['maxWidth']) {
				$return['items'][1]['maxWidth'] = $params['maxWidth'];
			}
			if ($params['maxHeight']) {
				$return['items'][1]['maxHeight'] = $params['maxHeight'];
			}
		}
		$return['items'][1]['uploadCfg']	= array(
			'file_size_limit'					=> $maxFileSize,
			'file_types'						=> '*.jpg;*.jpeg;*.png;*.gif',
			'file_types_description'			=> $language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_THUMBNAIL, false, MOD_POLYMOD_CODENAME).' ...'
		);
		$return['items'][1]['fileinfos']	= $imageDatas;
		$return['items'][1]['fileinfos']['module']			= $moduleCodename;
		$return['items'][1]['fileinfos']['visualisation']	= RESOURCE_DATA_LOCATION_EDITED;
		$checkBoxId = 'check'.md5(mt_rand().microtime());
		//Image datas
		if ($params['useDistinctZoom'] || $params['makeZoom']) {
			$zoomId = 'zoom'.md5(mt_rand().microtime());
			if ($this->_subfieldValues[2]->getValue() && file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[2]->getValue())) {
				$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[2]->getValue());
				$zoomDatas = array(
					'filename'		=> $file->getName(false),
					'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
					'filesize'		=> $file->getFileSize(),
					'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
					'extension'		=> $file->getExtension(),
				);
			} else {
				$zoomDatas = array(
					'filename'		=> '',
					'filepath'		=> '',
					'filesize'		=> '',
					'fileicon'		=> '',
					'extension'		=> '',
				);
			}
			unset($return['items'][2]['hideLabel']);
			$return['items'][2]['id']			= $zoomId;
			$return['items'][2]['allowBlank']	= true;
			$return['items'][2]['xtype']		= 'atmImageUploadField';
			$return['items'][2]['emptyText']	= $language->getMessage(self::MESSAGE_SELECT_PICTURE);
			$return['items'][2]['fieldLabel']	= $language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_ZOOM, false, MOD_POLYMOD_CODENAME);
			$return['items'][2]['uploadCfg']	= array(
				'file_size_limit'					=> $maxFileSize,
				'file_types'						=> '*.jpg;*.jpeg;*.png;*.gif',
				'file_types_description'			=> $language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_THUMBNAIL, false, MOD_POLYMOD_CODENAME).' ...'
			);
			$return['items'][2]['fileinfos']	= $zoomDatas;
			$return['items'][2]['fileinfos']['module']			= $moduleCodename;
			$return['items'][2]['fileinfos']['visualisation']	= RESOURCE_DATA_LOCATION_EDITED;
			if ($params['maxZoomWidth']) {
				$return['items'][2]['maxWidth'] = $params['maxZoomWidth'];
			}
			if ($params['maxZoomHeight']) {
				$return['items'][2]['maxHeight'] = $params['maxZoomHeight'];
			}
			if (!$this->_subfieldValues[2]->getValue() && $params['makeZoom']) {
				$return['items'][2]['listeners'] = array('render' => sensitiveIO::sanitizeJSString('function(el){
					var fieldCt = el.label.parent();
					if (fieldCt) {
						fieldCt.setVisibilityMode(Ext.Element.DISPLAY);
						fieldCt.hide();
					}
				}', false, false));
			}
		} else {
			$return['items'][2]['xtype'] = 'hidden';
		}
		if ($params['makeZoom']) {
			$boxLabel = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_USE_ORIGINAL_AS_ZOOM, false, MOD_POLYMOD_CODENAME);
			if ($params['maxWidth'] > 0 && !$params['maxHeight']) {
				$boxLabel .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DESC, array($params['maxWidth']), MOD_POLYMOD_CODENAME).'</small>';
			} elseif($params['maxHeight'] && !$params['maxWidth']){
				$boxLabel .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT, array($params['maxHeight']), MOD_POLYMOD_CODENAME).'</small>';
			} elseif($params['maxWidth'] && $params['maxHeight']){
				$boxLabel .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT_AND_WIDTH, array($params['maxWidth'],$params['maxHeight']), MOD_POLYMOD_CODENAME).'</small>';
			}
			$checkField = array(
				'allowBlank'		=> true,
				'xtype'				=> 'checkbox',
				'id'				=> $checkBoxId,
				'checked'			=> !$params['useDistinctZoom'] && !$this->_subfieldValues[2]->getValue(),
				'inputValue'		=> 1,
				'name'				=> 'polymodFieldsValue['.$prefixName.$this->_field->getID().'_makeZoom]',
				'boxLabel'			=> $boxLabel,
				'height'			=> 'auto',
				'labelSeparator'	=> ''
			);
			if (isset($zoomId)) {
				$checkField['listeners'] = array('check' => sensitiveIO::sanitizeJSString('function(el, checked){
					var fieldCt = Ext.getCmp(\''.$zoomId.'\').label.parent();
					if (fieldCt) {
						fieldCt.setVisibilityMode(Ext.Element.DISPLAY);
						if (checked) {
							fieldCt.hide(true);
						} else {
							fieldCt.show(true);
							Ext.getCmp(\''.$zoomId.'\').syncSize();
						}
					}
				}', false, false));
			}
			//set checkbox to offset 2
			$return['items'][3] = $return['items'][2];
			$return['items'][2] = $checkField;
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
		$rowspan = ($params['makeZoom']) ? 2 : 1;
		$mandatoryTtitle = (isset($params['legendMandatory']) && $params['legendMandatory']) ? '<span class="atm-red">*</span> ' : '';
		
		
		$html = '
		<table>
		<tr>
			<th'.$thclass.'>'.$mandatoryTtitle.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_LABEL, false, MOD_POLYMOD_CODENAME).'</th>
			<td'.$tdclass.'><input'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_1" value="'.$this->_subfieldValues[1]->getValue().'" type="text" /></td>
		</tr>
		<tr>
			<th'.$thclass.' rowspan="'.$rowspan.'">'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_THUMBNAIL, false, MOD_POLYMOD_CODENAME).'</th>
			<td'.$tdclass.'><input'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_0" type="file" />';
			if ($params['maxWidth'] > 0 && !$params['maxHeight']) {
				$html .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DESC, array($params['maxWidth']), MOD_POLYMOD_CODENAME).'</small>';
			} elseif($params['maxHeight'] && !$params['maxWidth']){
				$html .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT, array($params['maxHeight']), MOD_POLYMOD_CODENAME).'</small>';
			} elseif($params['maxWidth'] && $params['maxHeight']){
				$html .= '&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DESC_HEIGHT_AND_WIDTH, array($params['maxWidth'],$params['maxHeight']), MOD_POLYMOD_CODENAME).'</small>';
			}

			$html .= '</td>
		</tr>';
		if ($params['makeZoom']) {
			$checked = (!$params['useDistinctZoom']) ? ' checked="checked"':'';
			$html .= '
			<tr>
				<td'.$tdclass.'><label for="'.$prefixName.$this->_field->getID().'_makeZoom"><input name="'.$prefixName.$this->_field->getID().'_makeZoom" id="'.$prefixName.$this->_field->getID().'_makeZoom" type="checkbox"'.$checked.' value="1" />'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_USE_ORIGINAL_AS_ZOOM, false, MOD_POLYMOD_CODENAME).'</label></td>
			</tr>';
		}
		if ($params['useDistinctZoom']) {
			$html .= '
			<tr>
				<th'.$thclass.'>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_ZOOM, false, MOD_POLYMOD_CODENAME).'</th>
				<td'.$tdclass.'><input'.$htmlParameters.' name="'.$prefixName.$this->_field->getID().'_2" type="file" />&nbsp;<small>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_MAX_FILESIZE, array(ini_get("upload_max_filesize")), MOD_POLYMOD_CODENAME).'</small></td>
			</tr>';
		}
		//current image
		if ($this->_subfieldValues[0]->getValue()) {
			//get module codename
			$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			$img = '<img src="'.PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue().'" border="0" alt="'.$this->_subfieldValues[1]->getValue().'" title="'.$this->_subfieldValues[1]->getValue().'" />';
			if ($this->_subfieldValues[2]->getValue()) {
				$href = CMS_websitesCatalog::getMainURL(). PATH_REALROOT_WR . "/" . self::OBJECT_IMAGE_POPUP_FILE . '?location='.RESOURCE_DATA_LOCATION_EDITED.'&amp;file=' . $this->_subfieldValues[2]->getValue() . '&amp;label=' . urlencode($this->_subfieldValues[1]->getValue()).'&amp;module='.$moduleCodename;
				$popup = (OPEN_ZOOMIMAGE_IN_POPUP) ? ' onclick="javascript:CMS_openPopUpImage(\''.addslashes($href).'\');return false;"':'';
				$img = '<a target="_blank" href="'. $href . '"'.$popup.' title="'.$this->_subfieldValues[1]->getValue().'">' . $img . '</a>';
			}
			$html .= '
			<tr>
				<th'.$thclass.'>'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_ACTUAL_IMAGE, false, MOD_POLYMOD_CODENAME).'</th>
				<td'.$tdclass.'>'
					.$img.'
					<input type="hidden" name="'.$prefixName.$this->_field->getID().'_0_hidden" value="'.$this->_subfieldValues[0]->getValue().'" />
					<input type="hidden" name="'.$prefixName.$this->_field->getID().'_2_hidden" value="'.$this->_subfieldValues[2]->getValue().'" /><br />
					<label for="'.$prefixName.$this->_field->getID().'_delete"><input name="'.$prefixName.$this->_field->getID().'_delete" id="'.$prefixName.$this->_field->getID().'_delete" type="checkbox" value="1" />'.$language->getMessage(self::MESSAGE_OBJECT_IMAGE_FIELD_DELETE, false, MOD_POLYMOD_CODENAME).'</label>
				</td>
			</tr>';
		}
		if (POLYMOD_DEBUG) {
			$html .= '	<tr>
							<td'.$tdclass.' colspan="2"><span class="admin_text_alert">(Field : '.$this->_field->getID().' - Image : '.$this->_subfieldValues[0]->getValue().')</span></td>
						</tr>';
		}
		$html .= '
		</table>';
		//append html hidden field which store field name
		if ($html) {
			$html .= '<input type="hidden" name="polymodFields['.$this->_field->getID().']" value="'.$this->_field->getID().'" />';
		}
		return $html;
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
	function setValues($values,$prefixName, $newFormat = false, $objectID = '') {
		if (!sensitiveIO::isPositiveInteger($objectID)) {
			$this->raiseError('ObjectID must be a positive integer : '.$objectID);
			return false;
		}
		//get field parameters
		$params = $this->getParamsValues();
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		if ($newFormat) {
			//delete old images ?
			//thumbnail
			if ($this->_subfieldValues[0]->getValue() && (!$values[$prefixName.$this->_field->getID().'_0'] || pathinfo($values[$prefixName.$this->_field->getID().'_0'], PATHINFO_BASENAME) != $this->_subfieldValues[0]->getValue())) {
				@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue());
				$this->_subfieldValues[0]->setValue('');
			}
			//image zoom
			if (
				$this->_subfieldValues[2]->getValue()
				&& (
					!isset($values[$prefixName.$this->_field->getID().'_2'])
					|| !$values[$prefixName.$this->_field->getID().'_2']
					|| pathinfo($values[$prefixName.$this->_field->getID().'_2'], PATHINFO_BASENAME) != $this->_subfieldValues[2]->getValue()
				)
			) {
				@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[2]->getValue());
				$this->_subfieldValues[2]->setValue('');
			}
			//set label from label field
			if (!$this->_subfieldValues[1]->setValue(io::htmlspecialchars($values[$prefixName.$this->_field->getID().'_1']))) {
				return false;
			}
			//image zoom (if needed)
			if ((
					!isset($values[$prefixName.$this->_field->getID().'_makeZoom'])
					|| $values[$prefixName.$this->_field->getID().'_makeZoom'] != 1
				)
				&& isset($values[$prefixName.$this->_field->getID().'_2'])
				&& $values[$prefixName.$this->_field->getID().'_2']
				&& io::strpos($values[$prefixName.$this->_field->getID().'_2'], PATH_UPLOAD_WR.'/') !== false
			) {
				$filename = $values[$prefixName.$this->_field->getID().'_2'];
				//check for image type before doing anything
				if (!in_array(io::strtolower(pathinfo($filename, PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
					return false;
				}
				//destroy old image if any
				if ($this->_subfieldValues[2]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[2]->getValue());
					$this->_subfieldValues[2]->setValue('');
				}
				//move and rename uploaded file 
				$filename = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $filename);
				$basename = pathinfo($filename, PATHINFO_BASENAME);
				
				//set thumbnail
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED;
				$zoomBasename = "r".$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($basename));
				if (io::strlen($zoomBasename) > 255) {
					$zoomBasename = sensitiveIO::ellipsis($zoomBasename, 255, '-', true);
				}
				$zoomFilename = $path.'/'.$zoomBasename;
				CMS_file::moveTo($filename, $zoomFilename);
				CMS_file::chmodFile(FILES_CHMOD, $zoomFilename);
				//set it
				if (!$this->_subfieldValues[2]->setValue($zoomBasename)) {
					return false;
				}
			}
			//thumbnail
			if ($values[$prefixName.$this->_field->getID().'_0'] && io::strpos($values[$prefixName.$this->_field->getID().'_0'], PATH_UPLOAD_WR.'/') !== false) {
				$filename = $values[$prefixName.$this->_field->getID().'_0'];
				//check for image type before doing anything
				if (!in_array(io::strtolower(pathinfo($filename, PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
					return false;
				}
				//destroy old image if any
				if ($this->_subfieldValues[0]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue());
					$this->_subfieldValues[0]->setValue('');
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
				
				//if we use original image as image zoom, set it
				if (isset($values[$prefixName.$this->_field->getID().'_makeZoom']) && $values[$prefixName.$this->_field->getID().'_makeZoom'] == 1) {
					$zoomFilename = str_replace('_thumbnail.'.$extension, '.'.$extension, $newFilename);
					//copy image as zoom
					CMS_file::copyTo($newFilename, $zoomFilename);
					$zoomBasename = pathinfo($zoomFilename, PATHINFO_BASENAME);
					//set image zoom
					if (!$this->_subfieldValues[2]->setValue($zoomBasename)) {
						return false;
					}
				}
				//resize thumbnail if needed
				if ($params['maxWidth'] > 0 || $params['maxHeight'] > 0) {
					$oImage = new CMS_image($newFilename);
					//get current file size
					$sizeX = $oImage->getWidth();
					$sizeY = $oImage->getHeight();
					
					//check thumbnail size
					if (($params['maxWidth'] && $sizeX > $params['maxWidth']) || ($params['maxHeight'] && $sizeY > $params['maxHeight'])) {
						$newSizeX = $sizeX;
						$newSizeY = $sizeY;
						// Check width
						if ($params['maxWidth'] && $newSizeX > $params['maxWidth']) {
							$newSizeY = round(($params['maxWidth']*$newSizeY)/$newSizeX);
							$newSizeX = $params['maxWidth'];
						}
						if($params['maxHeight'] && $newSizeY > $params['maxHeight']){
							$newSizeX = round(($params['maxHeight']*$newSizeX)/$newSizeY);
							$newSizeY = $params['maxHeight'];
						}
						if (!$oImage->resize($newSizeX, $newSizeY, $newFilename)) {
							return false;
						}
					}
				}
				//set thumbnail
				if (!$this->_subfieldValues[0]->setValue($newBasename)) {
					return false;
				}
			}
			// If label not set yet, set it
			/*if(!$this->_subfieldValues[1]->getValue()){
				if($this->_subfieldValues[0]->getValue()){
					$this->_subfieldValues[1]->setValue($this->_subfieldValues[0]->getValue());
				}
			}*/
			//if we had an imagezoom, check his size
			if ($this->_subfieldValues[2]->getValue() && ($params['maxZoomWidth'] > 0 || $params['maxZoomHeight'] > 0)) {
				//resize zoom if needed
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED;
				$basename = $this->_subfieldValues[2]->getValue();
				$filename = $path.'/'.$basename;
				$extension = io::strtolower(pathinfo($basename, PATHINFO_EXTENSION));
				
				$oImage = new CMS_image($filename);
				//get current file size
				$sizeX = $oImage->getWidth();
				$sizeY = $oImage->getHeight();
				
				//check zoom size
				if (($params['maxZoomWidth'] && $sizeX > $params['maxZoomWidth']) || ($params['maxZoomHeight'] && $sizeY > $params['maxZoomHeight'])) {
					$newSizeX = $sizeX;
					$newSizeY = $sizeY;
					// Check width
					if ($params['maxZoomWidth'] && $newSizeX > $params['maxZoomWidth']) {
						$newSizeY = round(($params['maxZoomWidth']*$newSizeY)/$newSizeX);
						$newSizeX = $params['maxZoomWidth'];
					}
					if($params['maxZoomHeight'] && $newSizeY > $params['maxZoomHeight']){
						$newSizeX = round(($params['maxZoomHeight']*$newSizeX)/$newSizeY);
						$newSizeY = $params['maxZoomHeight'];
					}
					if (!$oImage->resize($newSizeX, $newSizeY, $filename)) {
						return false;
					}
				}
			}
			
			//update files infos if needed
			if ($this->_subfieldValues[0]->getValue() && file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue())) {
				$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue());
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
			$imageDatas['module']		= $moduleCodename;
			$imageDatas['visualisation']= RESOURCE_DATA_LOCATION_EDITED;
			if ($params['useDistinctZoom'] || $this->_subfieldValues[2]->getValue()) {
				//update files infos if needed
				if ($this->_subfieldValues[2]->getValue() && file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[2]->getValue())) {
					$file = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[2]->getValue());
					$zoomDatas = array(
						'filename'		=> $file->getName(false),
						'filepath'		=> $file->getFilePath(CMS_file::WEBROOT),
						'filesize'		=> $file->getFileSize(),
						'fileicon'		=> $file->getFileIcon(CMS_file::WEBROOT),
						'extension'		=> $file->getExtension(),
					);
				} else {
					$zoomDatas = array(
						'filename'		=> '',
						'filepath'		=> '',
						'filesize'		=> '',
						'fileicon'		=> '',
						'extension'		=> '',
					);
				}
				$zoomDatas['module']			= $moduleCodename;
				$zoomDatas['visualisation']		= RESOURCE_DATA_LOCATION_EDITED;
			} else {
				$zoomDatas = '';
			}
			$content = array('datas' => array(
				'polymodFieldsValue['.$prefixName.$this->_field->getID().'_0]' => $imageDatas,
				'polymodFieldsValue['.$prefixName.$this->_field->getID().'_2]' => $zoomDatas,
				'polymodFieldsValue['.$prefixName.$this->_field->getID().'_1]' => sensitiveIO::decodeEntities($this->_subfieldValues[1]->getValue()),
			));
			
			$view = CMS_view::getInstance();
			$view->addContent($content);
			return true;
		} else { //Old format
			//delete old images ?
			if (isset($values[$prefixName.$this->_field->getID().'_delete']) && $values[$prefixName.$this->_field->getID().'_delete'] == 1) {
				if ($this->_subfieldValues[0]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue());
					$this->_subfieldValues[0]->setValue('');
				} elseif (isset($values[$prefixName.$this->_field->getID().'_0_hidden']) && $values[$prefixName.$this->_field->getID().'_0_hidden']) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$values[$prefixName.$this->_field->getID().'_0_hidden']);
					$this->_subfieldValues[0]->setValue('');
				}
				if ($this->_subfieldValues[2]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[2]->getValue());
					$this->_subfieldValues[2]->setValue('');
				} elseif (isset($values[$prefixName.$this->_field->getID().'_2_hidden']) && $values[$prefixName.$this->_field->getID().'_2_hidden']) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$values[$prefixName.$this->_field->getID().'_2_hidden']);
					$this->_subfieldValues[2]->setValue('');
				}
			}
			//set label from label field
			if (!$this->_subfieldValues[1]->setValue(io::htmlspecialchars(@$values[$prefixName.$this->_field->getID().'_1']))) {
				return false;
			}
			//thumbnail
			if (isset($_FILES[$prefixName.$this->_field->getID().'_0']) && $_FILES[$prefixName.$this->_field->getID().'_0']['name'] && !$_FILES[$prefixName.$this->_field->getID().'_0']['error']) {
				//check for image type before doing anything
				if (!in_array(io::strtolower(pathinfo($_FILES[$prefixName.$this->_field->getID().'_0']["name"], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
					return false;
				}
				//set label as image name if none set
				/*if (!$values[$prefixName.$this->_field->getID().'_1']) {
					if (!$this->_subfieldValues[1]->setValue(io::htmlspecialchars($_FILES[$prefixName.$this->_field->getID().'_0']["name"]))) {
						return false;
					}
				}*/
				//destroy all old images if any
				if ($this->_subfieldValues[0]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue());
					$this->_subfieldValues[0]->setValue('');
				} elseif (isset($values[$prefixName.$this->_field->getID().'_0_hidden']) && $values[$prefixName.$this->_field->getID().'_0_hidden']) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$values[$prefixName.$this->_field->getID().'_0_hidden']);
					$this->_subfieldValues[0]->setValue('');
				}
				if ($this->_subfieldValues[2]->getValue()) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[2]->getValue());
					$this->_subfieldValues[2]->setValue('');
				} elseif (isset($values[$prefixName.$this->_field->getID().'_2_hidden']) && $values[$prefixName.$this->_field->getID().'_2_hidden']) {
					@unlink(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$values[$prefixName.$this->_field->getID().'_2_hidden']);
					$this->_subfieldValues[2]->setValue('');
				}
	
				//set thumbnail (resize it if needed)
	
				//create thumbnail path
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED;
				$filename = "r".$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($_FILES[$prefixName.$this->_field->getID().'_0']["name"]));
				if (io::strlen($filename) > 255) {
					$filename = sensitiveIO::ellipsis($filename, 255, '-', true);
				}
				
				//move uploaded file
				$fileDatas = CMS_file::uploadFile($prefixName.$this->_field->getID().'_0', PATH_TMP_FS);
				if ($fileDatas['error']) {
					return false;
				}
				if (!CMS_file::moveTo(PATH_TMP_FS.'/'.$fileDatas['filename'], $path."/".$filename)) {
					return false;
				}
				//check uploaded file
				$tmp = new CMS_file($path."/".$filename);
				if (!$tmp->checkUploadedFile()) {
					$tmp->delete();
					return false;
				}
				unset($tmp);
				if ($params['maxWidth'] > 0) {
					$oImage = new CMS_image($path."/".$filename);
					//get current file size
					$sizeX = $oImage->getWidth();
					$sizeY = $oImage->getHeight();
					
					//check thumbnail size
					if ($sizeX > $params['maxWidth'] ||  $sizeY > $params['maxHeight']) {
						$newSizeX = $sizeX;
						$newSizeY = $sizeY;
	
						// Check width
						if ($params['maxWidth'] && $newSizeX > $params['maxWidth']) {
							$newSizeY = round(($params['maxWidth']*$newSizeY)/$newSizeX);
							$newSizeX = $params['maxWidth'];
						}
						if($params['maxHeight'] && $newSizeY > $params['maxHeight']){
							$newSizeX = round(($params['maxHeight']*$newSizeX)/$newSizeY);
							$newSizeY = $params['maxHeight'];
						}
						//resize image
						$srcfilepath = $path."/".$filename;
						$path_parts = pathinfo($srcfilepath);
						$thumbnailFilename = io::substr($path_parts['basename'],0,-(io::strlen($path_parts['extension'])+1)).'_thumbnail.png';
						$destfilepath = $path."/".$thumbnailFilename;
						$extension = io::strtolower($path_parts['extension']);
						
						if (!$oImage->resize($newSizeX, $newSizeY, $destfilepath)) {
							return false;
						}
						
						//if we use original image as image zoom, set it
						if ($values[$prefixName.$this->_field->getID().'_makeZoom'] == 1) {
							//set image zoom
							if (!$this->_subfieldValues[2]->setValue($filename)) {
								return false;
							}
						} else {
							//destroy original image
							unlink($srcfilepath);
						}
						//set resized thumbnail
						if (!$this->_subfieldValues[0]->setValue($thumbnailFilename)) {
							return false;
						}
					} else {
						//no need to resize thumbnail (below the maximum width), so set it
						if (!$this->_subfieldValues[0]->setValue($filename)) {
							return false;
						}
						//if we use original image as image zoom, set it
						if ($values[$prefixName.$this->_field->getID().'_makeZoom'] == 1) {
							//set image zoom
							if (!$this->_subfieldValues[2]->setValue($filename)) {
								return false;
							}
						}
					}
				} else {
					//no need to resize thumbnail, so set it
					if (!$this->_subfieldValues[0]->setValue($filename)) {
						return false;
					}
					//if we use original image as image zoom, set it
					if ($values[$prefixName.$this->_field->getID().'_makeZoom'] == 1) {
						//set image zoom
						if (!$this->_subfieldValues[2]->setValue($filename)) {
							return false;
						}
					}
				}
			} elseif (isset($_FILES[$prefixName.$this->_field->getID().'_0']) && $_FILES[$prefixName.$this->_field->getID().'_0']['name'] && $_FILES[$prefixName.$this->_field->getID().'_0']['error'] != 0) {
				return false;
			} elseif (isset($values[$prefixName.$this->_field->getID().'_0_hidden']) && $values[$prefixName.$this->_field->getID().'_0_hidden'] && isset($values[$prefixName.$this->_field->getID().'_delete']) && $values[$prefixName.$this->_field->getID().'_delete'] != 1) {
				//set label as image name if none set
				/*if ($values[$prefixName.$this->_field->getID().'_1']) {
					if (!$this->_subfieldValues[1]->setValue(io::htmlspecialchars($values[$prefixName.$this->_field->getID().'_1']))) {
						return false;
					}
				}*/
				if(!$this->_subfieldValues[0]->setValue($values[$prefixName.$this->_field->getID().'_0_hidden'])) {
					return false;
				}
			}
			//image zoom (if needed)
			if (isset($values[$prefixName.$this->_field->getID().'_makeZoom']) && $values[$prefixName.$this->_field->getID().'_makeZoom'] != 1 && isset($_FILES[$prefixName.$this->_field->getID().'_2']['name']) && $_FILES[$prefixName.$this->_field->getID().'_2']['name'] && !$_FILES[$prefixName.$this->_field->getID().'_2']['error']) {
				//check for image type before doing anything
				if (!in_array(io::strtolower(pathinfo($_FILES[$prefixName.$this->_field->getID().'_2']["name"], PATHINFO_EXTENSION)), $this->_allowedExtensions)) {
					return false;
				}
				//create thumbnail path
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED;
				$filename = "r".$objectID."_".$this->_field->getID()."_".io::strtolower(SensitiveIO::sanitizeAsciiString($_FILES[$prefixName.$this->_field->getID().'_2']["name"]));
				if (io::strlen($filename) > 255) {
					$filename = sensitiveIO::ellipsis($filename, 255, '-', true);
				}
				
				//move uploaded file
				$fileDatas = CMS_file::uploadFile($prefixName.$this->_field->getID().'_2', PATH_TMP_FS);
				if ($fileDatas['error']) {
					return false;
				}
				if (!CMS_file::moveTo(PATH_TMP_FS.'/'.$fileDatas['filename'], $path."/".$filename)) {
					return false;
				}
				//check uploaded file
				$tmp = new CMS_file($path."/".$filename);
				if (!$tmp->checkUploadedFile()) {
					$tmp->delete();
					return false;
				}
				unset($tmp);
				//set it
				if (!$this->_subfieldValues[2]->setValue($filename)) {
					return false;
				}
			} elseif (isset($_FILES[$prefixName.$this->_field->getID().'_2']) && $_FILES[$prefixName.$this->_field->getID().'_2']['name'] && $_FILES[$prefixName.$this->_field->getID().'_2']['error'] != 0) {
				return false;
			} elseif (isset($values[$prefixName.$this->_field->getID().'_2_hidden']) && $values[$prefixName.$this->_field->getID().'_2_hidden'] && isset($values[$prefixName.$this->_field->getID().'_delete']) && $values[$prefixName.$this->_field->getID().'_delete'] != 1) {
				if(!$this->_subfieldValues[2]->setValue($values[$prefixName.$this->_field->getID().'_2_hidden'])) {
					return false;
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
		//image tag with link to image or image zoom if any
		$img = '';
		if ($this->_subfieldValues[0]->getValue()) {
			$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
			$params = $this->getParamsValues();
			$img = '<img width="'.$params['maxWidthPreviz'].'" src="'.PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.RESOURCE_DATA_LOCATION_EDITED.'/'.$this->_subfieldValues[0]->getValue().'" border="0" alt="'.$this->_subfieldValues[1]->getValue().'" title="'.$this->_subfieldValues[1]->getValue().'" align="center" />';
			if ($this->_subfieldValues[2]->getValue()) {
				$href = CMS_websitesCatalog::getMainURL() . PATH_REALROOT_WR . "/" . self::OBJECT_IMAGE_POPUP_FILE . '?location='.RESOURCE_DATA_LOCATION_EDITED.'&amp;file=' . $this->_subfieldValues[2]->getValue() . '&amp;label=' . urlencode($this->_subfieldValues[1]->getValue()).'&amp;module='.$moduleCodename;
				$popup = (OPEN_ZOOMIMAGE_IN_POPUP) ? ' onclick="javascript:CMS_openPopUpImage(\''.addslashes($href).'\');return false;"':'';
				$img = '<a target="_blank" href="'. $href . '"'.$popup.' title="'.$this->_subfieldValues[1]->getValue().'">' . $img . '</a>';
			} else {
				$href = CMS_websitesCatalog::getMainURL() . PATH_REALROOT_WR . "/" . self::OBJECT_IMAGE_POPUP_FILE . '?location='.RESOURCE_DATA_LOCATION_EDITED.'&amp;file=' . $this->_subfieldValues[0]->getValue() . '&amp;label=' . urlencode($this->_subfieldValues[1]->getValue()).'&amp;module='.$moduleCodename;
				$popup = (OPEN_ZOOMIMAGE_IN_POPUP) ? ' onclick="javascript:CMS_openPopUpImage(\''.addslashes($href).'\');return false;"':'';
				$img = '<a target="_blank" href="'. $href . '"'.$popup.' title="'.$this->_subfieldValues[1]->getValue().'">' . $img . '</a>';
			}
			$img = $this->_subfieldValues[1]->getValue().' : '.$img;
		}
		return $img;
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
		$structure['image'] = '';
		$structure['imageZoom'] = '';
		$structure['imageHTML'] = '';
		$structure['imageLabel'] = '';
		$structure['imageName'] = '';
		$structure['imageZoomName'] = '';
		$structure['imagePath'] = '';
		$structure['imageMaxWidth'] = '';
		$structure['imageMaxHeight'] = '';
		$structure['imageWidth'] = '';
		$structure['imageHeight'] = '';
		$structure['imageZoomWidth'] = '';
		$structure['imageZoomHeight'] = '';
		$structure['imageSize'] = '';
		$structure['imageZoomSize'] = '';
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
			case 'label':
				return $this->getLabel();
			break;
			case 'image':
				if ($this->_subfieldValues[0]->getValue() && $parameters) {
					@list($x, $y) = explode(',',str_replace(';', ',', $parameters));
					if ((io::isPositiveInteger($x) && $x < $this->getValue('imageWidth')) || (io::isPositiveInteger($y) && $y < $this->getValue('imageHeight'))) {
						//get module codename
						$crop = ($x && $y) ? 1 : 0;
						//get module codename
						$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
						//set location
						$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
						//resized image path
						$pathInfo = pathinfo($this->_subfieldValues[0]->getValue());
						$resizedImage = $pathInfo['filename'] .'-'. $x .'-'. $y .($crop ? '-c' : '').'.'. $pathInfo['extension'];
						//resized image path
						$resizedImagepathFS = PATH_MODULES_FILES_FS . '/' . $moduleCodename . '/'.$location.'/' . $resizedImage;
						//if file already exists, no need to resize file send it
						if(file_exists($resizedImagepathFS)) {
							return CMS_websitesCatalog::getMainURL() . PATH_MODULES_FILES_WR . '/' . $moduleCodename . '/'.$location.'/' . $resizedImage;
						} else {
							return CMS_websitesCatalog::getMainURL() . PATH_REALROOT_WR .'/image-file.php?image='. $this->_subfieldValues[0]->getValue() .'&amp;module='. $moduleCodename .'&amp;x='. $x .'&amp;y='. $y.'&amp;crop='.$crop.($location != RESOURCE_DATA_LOCATION_PUBLIC ? '&amp;location='.$location : '');
						}
					}
				}
				if ($this->_subfieldValues[0]->getValue()) {
					return $this->getValue('imagePath'). '/' .$this->_subfieldValues[0]->getValue();
				}
				return '';
			break;
			case 'imageZoom':
				if ($this->_subfieldValues[2]->getValue() && $parameters) {
					@list($x, $y) = explode(',',str_replace(';', ',', $parameters));
					if ((io::isPositiveInteger($x) && $x < $this->getValue('imageZoomWidth')) || (io::isPositiveInteger($y) && $y < $this->getValue('imageZoomHeight'))) {
						//get module codename
						$crop = ($x && $y) ? 1 : 0;
						//get module codename
						$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
						//set location
						$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
						//resized image path
						$pathInfo = pathinfo($this->_subfieldValues[2]->getValue());
						$resizedImage = $pathInfo['filename'] .'-'. $x .'-'. $y .($crop ? '-c' : '').'.'. $pathInfo['extension'];
						//resized image path
						$resizedImagepathFS = PATH_MODULES_FILES_FS . '/' . $moduleCodename . '/'.$location.'/' . $resizedImage;
						//if file already exists, no need to resize file send it
						if(file_exists($resizedImagepathFS)) {
							return CMS_websitesCatalog::getMainURL() . PATH_MODULES_FILES_WR . '/' . $moduleCodename . '/'.$location.'/' . $resizedImage;
						} else {
							return CMS_websitesCatalog::getMainURL() . PATH_REALROOT_WR .'/image-file.php?image='. $this->_subfieldValues[2]->getValue() .'&amp;module='. $moduleCodename .'&amp;x='. $x .'&amp;y='. $y.'&amp;crop='.$crop.($location != RESOURCE_DATA_LOCATION_PUBLIC ? '&amp;location='.$location : '');
						}
					}
				}
				if ($this->_subfieldValues[2]->getValue()) {
					return $this->getValue('imagePath'). '/' .$this->_subfieldValues[2]->getValue();
				}
				return '';
			break;
			case 'imageHTML':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				//link content
				$img = '';
				if ($parameters) {
					$img = $parameters;
				} elseif($this->_subfieldValues[0]->getValue()) { //bug 1380
					$img = '<img src="'.$this->getValue('image').'" alt="'.$this->_subfieldValues[1]->getValue().'" />';
				}
				//add link to zoom if any
				if ($img && $this->_subfieldValues[2]->getValue()) {
					$href = CMS_websitesCatalog::getMainURL() . PATH_REALROOT_WR . "/" . self::OBJECT_IMAGE_POPUP_FILE . '?'.(($location != RESOURCE_DATA_LOCATION_PUBLIC) ? 'location='.RESOURCE_DATA_LOCATION_EDITED.'&amp;':'').'file=' . $this->_subfieldValues[2]->getValue() . '&amp;label=' . urlencode($this->_subfieldValues[1]->getValue()).'&amp;module='.$moduleCodename;
					$popup = (OPEN_ZOOMIMAGE_IN_POPUP) ? ' onclick="javascript:CMS_openPopUpImage(\''.addslashes($href).'\');return false;"':'';
					$img = '<a target="_blank" rel="atm-enlarged" href="'. $href . '"'.$popup.' title="'.$this->_subfieldValues[1]->getValue().'">' . $img . '</a>';
				}
				return $img;
			break;
			case 'imageLabel':
				return $this->_subfieldValues[1]->getValue();
			break;
			case 'imageName':
				return $this->_subfieldValues[0]->getValue();
			break;
			case 'imageZoomName':
				return $this->_subfieldValues[2]->getValue();
			break;
			case 'imagePath':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				return CMS_websitesCatalog::getMainURL() . PATH_MODULES_FILES_WR.'/'.$moduleCodename.'/'.$location;
			break;
			case 'imageMaxWidth':
				//get field parameters
				$params = $this->getParamsValues();
				return ($params['maxWidth']) ? $params['maxWidth'] : '';
			break;
			case 'imageMaxHeight':
				//get field parameters
				$params = $this->getParamsValues();
				return ($params['maxHeight']) ? $params['maxHeight'] : '';
			break;
			case 'imageWidth':
			case 'imageHeight':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.$location;
				list($sizeX, $sizeY) = @getimagesize($path."/".$this->_subfieldValues[0]->getValue());
				if ($name == 'imageWidth') {
					return $sizeX;
				} else {
					return $sizeY;
				}
			break;
			case 'imageZoomWidth':
			case 'imageZoomHeight':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.$location;
				list($sizeX, $sizeY) = @getimagesize($path."/".$this->_subfieldValues[2]->getValue());
				if ($name == 'imageZoomWidth') {
					return $sizeX;
				} else {
					return $sizeY;
				}
			break;
			case 'imageSize':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.$location;
				$filesize = @filesize($path."/".$this->_subfieldValues[0]->getValue());
				if ($filesize !== false && $filesize > 0) {
					//convert in MB
					$filesize = round(($filesize/1048576),2).' M';
				} else {
					$filesize = '0 M';
				}
				return $filesize;
			break;
			case 'imageZoomSize':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				$path = PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/'.$location;
				$filesize = @filesize($path."/".$this->_subfieldValues[2]->getValue());
				if ($filesize !== false && $filesize > 0) {
					//convert in MB
					$filesize = round(($filesize/1048576),2).' M';
				} else {
					$filesize = '0 M';
				}
				return $filesize;
			break;
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
	function getLabelsStructure(&$language) {
		$labels = parent::getLabelsStructure($language);
		unset($labels['structure']['value']);
		
		$labels['structure']['image|width,height'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageZoom|width,height'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEZOOM_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageHTML'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEHTML_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageLabel'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGELABEL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageName'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGENAME_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageZoomName'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEZOOMNAME_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imagePath'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEPATH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageMaxWidth'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEMAXWIDTH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageMaxheight'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEMAXHEIGHT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageWidth'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEWIDTH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageHeight'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEHEIGHT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageZoomWidth'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEZOOMWIDTH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageZoomHeight'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEZOOMHEIGHT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageSize'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGESIZE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['imageZoomSize'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_IMAGEZOOMSIZE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
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
                    $this->raiseError("Unkown search operator : ".$operator.", use default search instead");
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
                    and objectSubFieldID = '1'
                    $where
            order by value ".$direction;
            return $sql;
    }
}
?>
