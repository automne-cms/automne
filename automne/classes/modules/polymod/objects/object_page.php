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
// | Author: Jérémie Bryon <jeremie.bryon@ws-interactive.fr>     		  |
// +----------------------------------------------------------------------+
//
// $Id: object_page.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_object_page
  *
  * represent a simple page object
  *
  * @package CMS
  * @subpackage module
  * @author Jérémie Bryon <jeremie.bryon@ws-interactive.fr>
  */

/**
  * Polymod Messages
  */
define("MESSAGE_OBJECT_PAGE_LABEL", 406);
define("MESSAGE_OBJECT_PAGE_DESCRIPTION", 407);

class CMS_object_page extends CMS_object_integer
{
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	var $_objectLabel = MESSAGE_OBJECT_PAGE_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	var $_objectDescription = MESSAGE_OBJECT_PAGE_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	var $_subfields = array(0 => array(
										'type' 			=> 'integer',
										'required' 		=> false,
										'internalName'	=> 'page',
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	var $_subfieldValues = array(0 => '');
	
	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	var $_parameters = array();
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	var $_parameterValues = array();
	
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
	function CMS_object_page($datas=array(), &$field, $public=false)
	{
		parent::__construct($datas, $field, $public);
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
		//is this field mandatory ?
		$mandatory = ($this->_field->getValue('required')) ? '<span class="admin_text_alert">*</span> ':'';
		//create html for each subfields
		$html = '<tr><td class="admin" align="right" valign="top">'.$mandatory.'<label for="'.$prefixName.$this->_field->getID().'_0'.'">'.$this->getFieldLabel($language).'</label></td><td class="admin">'."\n";
		//add description if any
		if ($this->getFieldDescription($language)) {
			$html .= '<dialog-title type="admin_h3">'.$this->getFieldDescription($language).'</dialog-title><br />';
		}
		$inputParams = array(
			'class' 	=> 'admin_input_text',
			'prefix'	=>	$prefixName,
			'size'  	=> 6,
			'form'		=> 'frmitem',
		);
		$html .= $this->getInput($fieldID, $language, $inputParams);
		$html .= '</td></tr>'."\n";
		return $html;
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
		if (isset($inputParams['prefix'])) {
			$prefixName = $inputParams['prefix'];
			unset($inputParams['prefix']);
		} else {
			$prefixName = '';
		}
		$params = $this->getParamsValues();
		//serialize all htmlparameters 
		$htmlParameters = $this->serializeHTMLParameters($inputParams);
		$html = '';
		
		//create fieldname
		$fieldName = $prefixName.$this->_field->getID().'_0';
		//append field id to html field parameters (if not already exists)
		$htmlParameters .= (!isset($inputParams['id'])) ? ' id="'.$prefixName.$this->_field->getID().'_0"' : '';
		//create field value
		$value = ($this->_subfieldValues[0]->getValue()) ? $this->_subfieldValues[0]->getValue() : '';
		//then create field HTML
		$html .= ($html) ? '<br />':'';
		$html .= 
		'<input '.$htmlParameters.' type="text" name="'.$fieldName.'" value="'.$value.'" />'."\n";
			//build tree link
			$grand_root = CMS_tree::getRoot();
			$href = PATH_ADMIN_SPECIAL_TREE_WR;
			$href .= '?root='.$grand_root->getID();
			$windowTitle = SensitiveIO::sanitizeHTMLString($language->getMessage(MESSAGE_PAGE_TREEH1));
			$href .= '&amp;heading='.$windowTitle;
			$href .= '&amp;encodedOnClick='.base64_encode("window.opener.document.getElementById('".$fieldName."').value = '%s';self.close();");
			$href .= '&encodedPageLink='.base64_encode('false');
			$html .= '&nbsp;<a href="'.$href.'" class="admin" target="_blank"><img title="'.$windowTitle.'" alt="'.$windowTitle.'" src="'.PATH_ADMIN_IMAGES_WR. '/picto-arbo.gif" border="0" align="absmiddle" /></a>
			';
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
	  * set object Values
	  *
	  * @param array $values : the POST result values
	  * @param string prefixname : the prefix used for post names
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setValues($values,$prefixName) {
		if (empty($values[$prefixName.$this->_field->getID().'_0'])) {
			$values[$prefixName.$this->_field->getID().'_0'] = 0;
		}
		if ($values[$prefixName.$this->_field->getID().'_0']) {
			//must be positive integer
			if (!sensitiveIO::isPositiveInteger($values[$prefixName.$this->_field->getID().'_0'])) {
				return false;
			}
		}
		if (!$this->_subfieldValues[0]->setValue($values[$prefixName.$this->_field->getID().'_0'])) {
			return false;
		}
		return true;
	}
}

?>