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
// $Id: object_href.php,v 1.7 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_object_href
  *
  * represent an href object
  *
  * @package CMS
  * @subpackage module
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_href extends CMS_object_common
{
	/**
  * Polymod Messages
  */
	const MESSAGE_OBJECT_HREF_HREFVALUE_DESCRIPTION = 151;
	const MESSAGE_OBJECT_HREF_HREFLABEL_DESCRIPTION = 152;
	const MESSAGE_OBJECT_HREF_HREFTARGET_DESCRIPTION = 153;
	const MESSAGE_OBJECT_HREF_HREFTYPE_DESCRIPTION = 154;
	const MESSAGE_OBJECT_HREF_HREFHTML_DESCRIPTION = 155;
	const MESSAGE_OBJECT_HREF_POPUPWIDTH_DESCRIPTION = 425;
  	const MESSAGE_OBJECT_HREF_POPUPHEIGHT_DESCRIPTION = 426;
	const MESSAGE_OBJECT_HREF_LABEL = 175;
	const MESSAGE_OBJECT_HREF_DESCRIPTION = 176;
	const MESSAGE_OBJECT_HREF_VALIDHREF_DESCRIPTION = 252;
	const MESSAGE_OBJECT_HREF_EXISTING_LINK = 6;
	/**
	  * Standard Messages
	  */
	const MESSAGE_OBJECT_HREF_FIELD_NONE = 10;
	const MESSAGE_OBJECT_HREF_ALL_FILES = 530;
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_HREF_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_HREF_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|text|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'href',
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array(0 => '');
	
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
		if (!is_object($this->_subfieldValues[0])) {
			$this->raiseError("No subField to get for label : ".print_r($this->_subfieldValues,true));
			return false;
		}
		//create object CMS_href & CMS_dialog_href
		$href = new CMS_href($this->_subfieldValues[0]->getValue());
		return $href->getLabel();
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
	function checkMandatory($values,$prefixName, $newFormat = false) {
		//if field is required check values
		if ($this->_field->getValue('required')) {
			if ($newFormat) {
				$href = new CMS_href($values['href'.$prefixName.$this->_field->getID().'_0']);
				if (!$href->hasValidHREF()) {
					return false;
				}
			} else {
				//create a sub prefix
				$subPrefixName = 'href'.$prefixName.$this->_field->getID().'_0';
				//must have type and label
				if (!$values[$subPrefixName."link_type"] || !$values[$subPrefixName.'link_label']) {
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
		//$params = $this->getParamsValues();
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		//create field value
		$maxFileSize = CMS_file::getMaxUploadFileSize('K');
		$value = $this->_subfieldValues[0]->getValue();
		$return['name'] = /*$return['id'] =*/ 'polymodFieldsValue[href'.$prefixName.$this->_field->getID().'_0]';
		$return['xtype'] =	'atmLinkField';
		$return['value'] =	(string) $value;
		$return['uploadCfg'] =	array(
			'file_size_limit'		=> $maxFileSize,
			'file_types'			=>	'*.*',
			'file_types_description'=> $language->getMessage(self::MESSAGE_OBJECT_HREF_ALL_FILES).' ...'
		);
		$return['fileinfos'] =	array(
			'module'				=> $moduleCodename,
			'visualisation'			=> RESOURCE_DATA_LOCATION_EDITED
		);
		$return['linkConfig'] =	array();
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
		if (!isset($inputParams['no_admin'])) {
			$options['no_admin'] = true;
		}
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		//create a sub prefix for CMS_dialog_href object
		$subPrefixName = 'href'.$prefixName.$this->_field->getID().'_0';
		//create object CMS_href & CMS_dialog_href
		$href = new CMS_href($this->_subfieldValues[0]->getValue());
		foreach ($inputParams as $k => $v) {
			if (in_array($k, array('id','class','style','tabindex','disabled','dir','lang','width','height','alt','title',))) {
				$href->setAttribute($k, $v);
			}
		}
		//redefine temporarily this constant here, because it is defined in cms_rc_admin and sometimes, only cms_rc_frontend is available
		if (!defined("PATH_ADMIN_WR")) {
			define("PATH_ADMIN_WR", PATH_MAIN_WR."/admin");
		}
		if (!defined("PATH_ADMIN_IMAGES_WR")) {
			define("PATH_ADMIN_IMAGES_WR", PATH_ADMIN_WR."/img");
		}
		$hrefDialog = new CMS_dialog_href($href, $subPrefixName);
		$existingLink = ($hrefDialog->getHTML($moduleCodename)) ? $hrefDialog->getHTML($moduleCodename) : $language->getMessage(self::MESSAGE_OBJECT_HREF_FIELD_NONE);
		$html .= $hrefDialog->getHTMLFields($language, $moduleCodename, RESOURCE_DATA_LOCATION_EDITED, $options).'<br />'.$language->getMessage(self::MESSAGE_OBJECT_HREF_EXISTING_LINK, false, MOD_POLYMOD_CODENAME).' : '.$existingLink;
		if (POLYMOD_DEBUG) {
			$html .= ' <span class="admin_text_alert">(Field : '.$this->_field->getID().' - SubField : 0)</span>';
		}
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
	  * @param string $prefixname : the prefix used for post names
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
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		//create a sub prefix for CMS_dialog_href object
		$subPrefixName = 'href'.$prefixName.$this->_field->getID().'_0';
		//create object CMS_href & CMS_dialog_href
		$hrefDialog = new CMS_dialog_href(new CMS_href($this->_subfieldValues[0]->getValue()), $subPrefixName);
		if ($newFormat) {
			$hrefDialog->create($values[$subPrefixName], $moduleCodename, $objectID, $this->_field->getID());
			if ($hrefDialog->hasError()) {
				return false;
			}
			$href = $hrefDialog->getHREF();
			if (!$this->_subfieldValues[0]->setValue($href->getTextDefinition())) {
				return false;
			}
			$content = array('datas' => array(
				'polymodFieldsValue['.$subPrefixName.']' => sensitiveIO::decodeEntities($this->_subfieldValues[0]->getValue()),
			));
			$view = CMS_view::getInstance();
			$view->addContent($content);
		} else {
			//check for http://
			if ($values[$subPrefixName.'link_external'] && io::strpos($values[$subPrefixName.'link_external'], 'http://') !== 0) {
				$values[$subPrefixName.'link_external'] = 'http://'.$values[$subPrefixName.'link_external'];
			}
			$hrefDialog->doPost($moduleCodename, $objectID, $this->_field->getID());
			if ($hrefDialog->hasError()) {
				return false;
			}
			$href = $hrefDialog->getHREF();
			if (!$this->_subfieldValues[0]->setValue($href->getTextDefinition())) {
				return false;
			}
		}
		return true;
	}
	
	/**
	  * get object HTML description for admin search detail.
	  *
	  * @return string : object HTML description
	  * @access public
	  */
	function getHTMLDescription() {
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		//create object CMS_href & CMS_dialog_href
		$href = new CMS_href($this->_subfieldValues[0]->getValue());
		$href->setAttribute("class", "admin");
		$hrefDialog = new CMS_dialog_href($href);
		return ($hrefDialog->getHTML($moduleCodename)) ? $hrefDialog->getHTML($moduleCodename) : '';
	}
	
	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
		$structure = parent::getStructure();
		//unset($structure['value']);
		$structure['validhref'] = '';
		$structure['hrefvalue'] = '';
		$structure['hreflabel'] = '';
		$structure['hreftarget'] = '';
		$structure['hreftype'] = '';
		$structure['popupWidth'] = '';
		$structure['popupHeight'] = '';
		$structure['hrefHTML'] = '';
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
		$href = new CMS_href($this->_subfieldValues[0]->getValue());
		switch($name) {
			case 'validhref':
				return $href->hasValidHREF();
			break;
			case 'hrefvalue':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				return $href->getHTML(false, $moduleCodename, $location, false, true);
			break;
			case 'hreflabel':
				return io::htmlspecialchars($href->getLabel());
			break;
			case 'hreftarget':
				return $href->getTarget();
			break;
			case 'hreftype':
				return $href->getLinkType();
			break;
			case 'popupWidth':
				$popup = $href->getPopup();
				return $popup['width'];
			break;
			case 'popupHeight':
				$popup = $href->getPopup();
				return $popup['height'];
			break;
			case 'hrefHTML':
				//get module codename
				$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
				//set location
				$location = ($this->_public) ? RESOURCE_DATA_LOCATION_PUBLIC : RESOURCE_DATA_LOCATION_EDITED;
				
				//add link title (if any)
				if ($parameters) {
					$title = $parameters;
					//add title attribute to link
					$href->setAttributes(array('title' => io::htmlspecialchars($href->getLabel().' ('.$title.')')));
				} else {
					$title = false;
					//add title attribute to link
					$href->setAttributes(array('title' => io::htmlspecialchars($href->getLabel())));
				}
				
				return $href->getHTML($title, $moduleCodename, $location);
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
		$labels['structure']['validhref'] = $language->getMessage(self::MESSAGE_OBJECT_HREF_VALIDHREF_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['hrefvalue'] = $language->getMessage(self::MESSAGE_OBJECT_HREF_HREFVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['hreflabel'] = $language->getMessage(self::MESSAGE_OBJECT_HREF_HREFLABEL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['hreftarget'] = $language->getMessage(self::MESSAGE_OBJECT_HREF_HREFTARGET_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['hreftype'] = $language->getMessage(self::MESSAGE_OBJECT_HREF_HREFTYPE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['popupWidth'] = $language->getMessage(self::MESSAGE_OBJECT_HREF_POPUPWIDTH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['popupHeight'] = $language->getMessage(self::MESSAGE_OBJECT_HREF_POPUPHEIGHT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['hrefHTML'] = $language->getMessage(self::MESSAGE_OBJECT_HREF_HREFHTML_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		return $labels;
	}
}

?>