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
// $Id: object_string.php,v 1.8 2010/03/08 16:43:34 sebastien Exp $

/**
  * Class CMS_object_string
  *
  * represent a simple string object
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_object_oembed extends CMS_object_common
{
	/**
 	 * Polymod Messages
 	 */
	const MESSAGE_OBJECT_OEMBED_LABEL = 611;
	const MESSAGE_OBJECT_OEMBED_DESCRIPTION = 612;
	const MESSAGE_OBJECT_IMAGE_TITLE_DESCRIPTION = 613;
	const MESSAGE_OBJECT_IMAGE_URL_DESCRIPTION = 614;
	const MESSAGE_OBJECT_IMAGE_HTML_DESCRIPTION = 615;
	const MESSAGE_OBJECT_IMAGE_THUMB_DESCRIPTION = 616;
	const MESSAGE_OBJECT_IMAGE_WIDTH_DESCRIPTION = 617;
	const MESSAGE_OBJECT_IMAGE_HEIGHT_DESCRIPTION = 618;
	const MESSAGE_OBJECT_IMAGE_TYPE_DESCRIPTION = 619;
	const MESSAGE_OBJECT_IMAGE_DESCRIPTION_DESCRIPTION = 620;
	const MESSAGE_OBJECT_IMAGE_AUTHORNAME_DESCRIPTION = 621;
	const MESSAGE_OBJECT_IMAGE_AUTHORURL_DESCRIPTION = 622;
	const MESSAGE_OBJECT_IMAGE_PROVIDERNAME_DESCRIPTION = 623;
	const MESSAGE_OBJECT_IMAGE_PROVIDERURL_DESCRIPTION = 624;
	const MESSAGE_OBJECT_IMAGE_HASVALUE_DESCRIPTION = 625;
	const MESSAGE_OBJECT_IMAGE_DATAS_DESCRIPTION = 626;
	
	/**
	  * object label
	  * @var integer
	  * @access private
	  */
	protected $_objectLabel = self::MESSAGE_OBJECT_OEMBED_LABEL;
	
	/**
	  * object description
	  * @var integer
	  * @access private
	  */
	protected $_objectDescription = self::MESSAGE_OBJECT_OEMBED_DESCRIPTION;
	
	/**
	  * all subFields definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_subfields = array(0 => array(
										'type' 			=> 'text',
										'required' 		=> false,
										'internalName'	=> 'string',
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_subfieldValues = array(0 => '');
	
	/**
	  * all parameters definition
	  * @var array(integer "subFieldID" => array("type" => string "(string|boolean|integer|date)", "required" => boolean, 'internalName' => string [, 'externalName' => i18nm ID]))
	  * @access private
	  */
	protected $_parameters = array();
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array();
	
	/**
	  * all oembed objects (in different sizes)
	  * @var array()
	  * @access private
	  */
	protected $_oembedObjects = array();
	
	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	function getLabelsStructure(&$language, $objectName) {
		$labels = parent::getLabelsStructure($language, $objectName);
		unset($labels['structure']['set']);
		unset($labels['structure']['label']);
		$labels['structure']['title'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_TITLE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['url'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_URL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['html|maxwidth,maxheight'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_HTML_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['thumb'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_THUMB_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['width'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_WIDTH_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['height'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_HEIGHT_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['type'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_TYPE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['description'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_DESCRIPTION_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['authorName'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_AUTHORNAME_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['authorUrl'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_AUTHORURL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['providerName'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_PROVIDERNAME_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['providerUrl'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_PROVIDERURL_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['hasValue'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_HASVALUE_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		$labels['structure']['datas'] = $language->getMessage(self::MESSAGE_OBJECT_IMAGE_DATAS_DESCRIPTION,false ,MOD_POLYMOD_CODENAME);
		
		return $labels;
	}
	
	/**
	  * get object values structure available with getValue method
	  *
	  * @return multidimentionnal array : the object values structure
	  * @access public
	  */
	function getStructure() {
		$structure = parent::getStructure();
		unset($structure['set']);
		unset($structure['label']);
		$structure['title'] = '';
		$structure['url'] = '';
		$structure['type'] = '';
		$structure['html'] = '';
		$structure['thumb'] = '';
		$structure['width'] = '';
		$structure['height'] = '';
		$structure['description'] = '';
		$structure['authorName'] = '';
		$structure['authorUrl'] = '';
		$structure['providerName'] = '';
		$structure['providerUrl'] = '';
		$structure['hasValue'] = '';
		$structure['datas'] = '';
		
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
		if (in_array($name, array('fieldname', 'required', 'fieldID', 'value'))) {
			return parent::getValue($name, $parameters);
		}
		if ($name == 'hasValue') {
			return $this->_subfieldValues[0]->getValue() ? true : false;
		}
		//oembed values : first, get size parameters
		@list($width, $height) = explode(',',str_replace(';', ',', $parameters));
		if (!io::isPositiveInteger($width)) {
			$width = '';
		}
		if (!io::isPositiveInteger($height)) {
			$height = '';
		}
		//load oembed object
		if (in_array($name, array('html', 'width', 'height'))) { //size specific values : get oembed object at queried size
			if (!isset($this->_oembedObjects[$width.'-'.$height])) {
				$this->_oembedObjects[$width.'-'.$height] = new CMS_oembed($this->_subfieldValues[0]->getValue(), $width, $height);
			}
			$oembed = $this->_oembedObjects[$width.'-'.$height];
		} else {
			if ($this->_oembedObjects) {
				//load current oembed object
				$oembed = current($this->_oembedObjects);
			} else {
				$this->_oembedObjects[$width.'-'.$height] = new CMS_oembed($this->_subfieldValues[0]->getValue(), $width, $height);
				$oembed = $this->_oembedObjects[$width.'-'.$height];
			}
		}
		if (!$oembed->hasProvider()) {
			return '';
		}
		if ($name == 'authorName') {
			$name = 'author_name';
		}
		if ($name == 'authorUrl') {
			$name = 'author_url';
		}
		if ($name == 'authorName') {
			$name = 'author_name';
		}
		if ($name == 'providerUrl') {
			$name = 'provider_url';
		}
		switch($name) {
			case 'html':
				return $oembed->getHTML(array(
					'class'	=> 'atm-embed'
				));
			break;
			case 'thumb':
				return $oembed->getThumbnail(array(
					'class'	=> 'atm-thumb-embed'
				));
			break;
			case 'providerName':
				return io::htmlspecialchars($oembed->getProviderName());
			break;
			case 'url':
				return $this->_subfieldValues[0]->getValue();
			break;
			case 'datas':
				return $oembed->getDatas();
			break;
			default:
				return io::htmlspecialchars($oembed->getData($name));
			break;
		}
	}
}
?>