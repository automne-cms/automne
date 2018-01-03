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
// | Author: Jérémie Bryon <jeremie.bryon@ws-interactive.fr>     		  |
// +----------------------------------------------------------------------+
//
// $Id: object_page.php,v 1.5 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_object_page
  *
  * represent a simple page object
  *
  * @package Automne
  * @subpackage polymod
  * @author Jérémie Bryon <jeremie.bryon@ws-interactive.fr>
  */

class CMS_object_page extends CMS_object_integer
{
	/**
 	 * Polymod Messages
 	 */
	const MESSAGE_OBJECT_PAGE_LABEL = 406;
	const MESSAGE_OBJECT_PAGE_DESCRIPTION = 407;
	const MESSAGE_PAGE_TREEH1 = 1049;
	const MESSAGE_OBJECT_PAGE_PAGE_TITLE_DESCRIPTION = 532;
	const MESSAGE_OBJECT_PAGE_PAGE_URL_DESCRIPTION = 533;
	const MESSAGE_OBJECT_PAGE_PAGE_ID_DESCRIPTION = 534;
	const MESSAGE_OBJECT_PAGE_CODENAME = 647;
	const MESSAGE_OBJECT_PAGE_KEYWORDS = 648;
	const MESSAGE_OBJECT_PAGE_WEBSITE = 649;
	const MESSAGE_OBJECT_PAGE_CATEGORY = 650;
	const MESSAGE_OBJECT_PAGE_AUTHOR = 651;
	const MESSAGE_OBJECT_PAGE_REPLYTO = 652;
	const MESSAGE_OBJECT_PAGE_COPYRIGHT = 653;
	const MESSAGE_OBJECT_PAGE_LANGUAGE = 654;
	const MESSAGE_OBJECT_PAGE_ROBOTS = 655;
	const MESSAGE_OBJECT_PAGE_PRAGMA = 656;
	const MESSAGE_OBJECT_PAGE_REFRESH = 657;
	const MESSAGE_OBJECT_PAGE_METAS = 658;
	const MESSAGE_OBJECT_PAGE_LEVEL = 659;
	const MESSAGE_OBJECT_PAGE_PRINTURL = 660;
	const MESSAGE_OBJECT_PAGE_LINK = 661;
	const MESSAGE_OBJECT_PAGE_LINKTITLE = 662;
	const MESSAGE_OBJECT_PAGE_PAGE_DESCRIPTION = 663;


	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	var $_objectLabel = self::MESSAGE_OBJECT_PAGE_LABEL;

	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	var $_objectDescription = self::MESSAGE_OBJECT_PAGE_DESCRIPTION;

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
	public function __construct($datas=array(), &$field, $public=false)
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
	public function getHTMLAdmin($fieldID, $language, $prefixName) {
		$return = parent::getHTMLAdmin($fieldID, $language, $prefixName);
		$params = $this->getParamsValues();
		$return['xtype'] =	'atmPageField';
		unset($return['allowDecimals']);
		unset($return['allowNegative']);
		unset($return['minValue']);
		unset($return['anchor']);
		unset($return['width']);
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
	public function getInput($fieldID, $language, $inputParams) {
		//hidden field : use parent method
		if (isset($inputParams['hidden']) && ($inputParams['hidden'] == 'true' || $inputParams['hidden'] == 1)) {
			return parent::getInput($fieldID, $language, $inputParams);
		}
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
			$windowTitle = SensitiveIO::sanitizeHTMLString($language->getMessage(self::MESSAGE_PAGE_TREEH1));
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
	public function setValues($values,$prefixName, $newFormat = false) {
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

	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	public function getStructure() {
		$structure = parent::getStructure();
		$structure['pageTitle'] = '';
		$structure['pageURL'] = '';
		$structure['pageID'] = '';
		$structure['codename'] = '';
		$structure['keywords'] = '';
		$structure['description'] = '';
		$structure['category'] = '';
		$structure['author'] = '';
		$structure['replyto'] = '';
		$structure['copyright'] = '';
		$structure['language'] = '';
		$structure['robots'] = '';
		$structure['pragma'] = '';
		$structure['refresh'] = '';
		$structure['metas'] = '';
		$structure['level'] = '';
		$structure['printurl'] = '';
		$structure['link'] = '';
		$structure['linktitle'] = '';
		$structure['website'] = '';
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
	public function getValue($name, $parameters = '') {
		switch($name) {
			case 'pageTitle':
				return CMS_tree::getPageValue($this->_subfieldValues[0]->getValue(), 'title');
			break;
			case 'pageID':
				return $this->_subfieldValues[0]->getValue();
			break;
			case 'pageURL':
				return CMS_tree::getPageValue($this->_subfieldValues[0]->getValue(), 'url');
			break;
			default:
				$possibleValues = array('codename', 'keywords', 'description', 'category', 'author', 'replyto', 'copyright', 'language',
										'robots', 'pragma', 'refresh', 'metas', 'level', 'printurl', 'link', 'linktitle', 'website');
				if(in_array($name, $possibleValues)) {
					return CMS_tree::getPageValue($this->_subfieldValues[0]->getValue(), $name);
				}
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
	public function getLabelsStructure(&$language, $objectName = '') {
		$params = $this->getParamsValues();
		$labels = parent::getLabelsStructure($language, $objectName);
		$labels['structure']['pageTitle'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_PAGE_TITLE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['pageURL'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_PAGE_URL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['pageID'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_PAGE_ID_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['codename'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_CODENAME,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['keywords'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_KEYWORDS,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['description'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_PAGE_DESCRIPTION,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['category'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_CATEGORY,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['author'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_AUTHOR,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['replyto'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_REPLYTO,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['copyright'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_COPYRIGHT,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['language'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_LANGUAGE,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['robots'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_ROBOTS,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['pragma'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_PRAGMA,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['refresh'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_REFRESH,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['metas'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_METAS,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['level'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_LEVEL,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['printurl'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_PRINTURL,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['link'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_LINK,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['linktitle'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_LINKTITLE,false,MOD_POLYMOD_CODENAME);
		$labels['structure']['website'] = $language->getMessage(self::MESSAGE_OBJECT_PAGE_WEBSITE,false,MOD_POLYMOD_CODENAME);;
		return $labels;
	}

	/**
	  * get object HTML description for admin search detail. Usually, the label.
	  *
	  * @return string : object HTML description
	  * @access public
	  */
	public function getHTMLDescription() {
		global $cms_language;
		if (is_object($this->_subfieldValues[0]) && $this->_subfieldValues[0]->getValue()) {
			return '<a href="#" href="#" onclick="Automne.utils.getPageById('.$this->_subfieldValues[0]->getValue().');Ext.WindowMgr.getActive().close();">'.CMS_tree::getPageValue($this->_subfieldValues[0]->getValue(), 'title').' ('.$this->_subfieldValues[0]->getValue().')</a>';
		}
		return '';
	}
}

?>