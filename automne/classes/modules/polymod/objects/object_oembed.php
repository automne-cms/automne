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
	const MESSAGE_OBJECT_OEMBED_MEDIA_URL = 630;
	const MESSAGE_OBJECT_OEMBED_MEDIA_URL_DESC = 629;
	const MESSAGE_OBJECT_OEMBED_PARAMETER_EMBEDLYKEY = 631;
	const MESSAGE_OBJECT_OEMBED_PARAMETER_EMBEDLYKEY_DESCRIPTION = 632;
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
	protected $_parameters = array(0 => array(
										'type' 			=> 'string',
										'required' 		=> false,
										'internalName'	=> 'embedlyKey',
										'externalName'	=> self::MESSAGE_OBJECT_OEMBED_PARAMETER_EMBEDLYKEY,
										'description'	=> self::MESSAGE_OBJECT_OEMBED_PARAMETER_EMBEDLYKEY_DESCRIPTION,
									),
							);
	
	/**
	  * all subFields values for object
	  * @var array(integer "subFieldID" => mixed)
	  * @access private
	  */
	protected $_parameterValues = array(0 => OEMBED_EMBEDLY_KEY);
	
	/**
	  * all oembed objects (in different sizes)
	  * @var array()
	  * @access private
	  */
	protected $_oembedObjects = array();
	
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
		//get module codename
		$moduleCodename = CMS_poly_object_catalog::getModuleCodenameForField($this->_field->getID());
		//is this field mandatory ?
		$mandatory = $this->_field->getValue('required') ? '<span class="atm-red">*</span> ' : '';
		$desc = $this->getFieldDescription($language);
		if (POLYMOD_DEBUG) {
			$values = array();
			foreach (array_keys($this->_subfieldValues) as $subFieldID) {
				if (is_object($this->_subfieldValues[$subFieldID])) {
					$values[$subFieldID] = sensitiveIO::ellipsis(strip_tags($this->_subfieldValues[$subFieldID]->getValue()), 50);
				}
			}
			$desc .= $desc ? '<br />' : '';
			$desc .= '<span class="atm-red">Field : '.$fieldID.' - Value(s) : <ul>';
			foreach ($values as $subFieldID => $value) {
				$desc .= '<li>'.$subFieldID.'&nbsp;:&nbsp;'.$value.'</li>';
			}
			$desc .= '</ul></span>';
		}
		
		$label = $desc ? '<span class="atm-help" ext:qtip="'.io::htmlspecialchars($desc).'">'.$mandatory.$this->getFieldLabel($language).'</span>' : $mandatory.$this->getFieldLabel($language);
		
		$ids = 'oembed-'.md5(mt_rand().microtime());
		$oembedURL = PATH_ADMIN_MODULES_WR.'/'.MOD_POLYMOD_CODENAME.'/oembed.php';
		$loadingURL = PATH_ADMIN_IMAGES_WR.'/loading-old.gif';
		$params = $this->getParamsValues();
		$fields = array();
		$fields[] = array(
			'fieldLabel' 	=>	'<span class="atm-help" ext:qtip="'.io::htmlspecialchars($language->getMessage(self::MESSAGE_OBJECT_OEMBED_MEDIA_URL_DESC, false, MOD_POLYMOD_CODENAME)).'">'.$language->getMessage(self::MESSAGE_OBJECT_OEMBED_MEDIA_URL, false, MOD_POLYMOD_CODENAME).'</span>',
			'xtype'			=>	'textfield',
			'name'			=>	'polymodFieldsValue['.$prefixName.$this->_field->getID().'_0]',
			'value'			=>	($this->_subfieldValues[0]->getValue() ? sensitiveIO::decodeEntities($this->_subfieldValues[0]->getValue()) : ''),
			'enableKeyEvents'=> true,
			'listeners'		=>	array(
				'blur' => array(
					'fn' =>	sensitiveIO::sanitizeJSString('function(el){
						/*call server for oembed HTML content*/
						Ext.get(\''.$ids.'-view\').update(\'<img src="'.$loadingURL.'" />\');
						Automne.server.call({
							url:			\''.$oembedURL.'\',
							scope:			this,
							fcnCallback:	function(response, options, htmlResponse){
								Ext.get(\''.$ids.'-view\').update(htmlResponse);
							},
							params:			{
								module:			\''.$moduleCodename.'\',
								url:			el.getValue(),
								width:			600,
								height:			250,
								key:			\''.$params['embedlyKey'].'\'
							}
						});
					}', false, false), 
					'buffer'=> 600
				)
			)
		);
		$fields[] = array(
			'xtype'		=> 'panel',
			'border'	=> false,
			'html'		=> '<div id="'.$ids.'-view" style="overflow:auto;text-align:center;">'.($this->getValue('hasValue') ? $this->getValue('html', '600,250') : '').'</div>',
		);
		$return = array();
		$return = array(
			'title' 		=>	$label,
			'xtype'			=>	'fieldset',
			'autoHeight'	=>	true,
			'defaultType'	=>	'textfield',
			'defaults'		=> 	array(
				'anchor'		=>	'97%',
				'allowBlank'	=>	!$this->_field->getValue('required')
			),
			'items'			=>	$fields
		);
		return $return;
	}
	
	/**
	  * get labels for object structure and functions
	  *
	  * @return array : the labels of object structure and functions
	  * @access public
	  */
	public function getLabelsStructure(&$language, $objectName = '') {
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
	public function getStructure() {
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
	public function getValue($name, $parameters = '') {
		if (in_array($name, array('fieldname', 'required', 'fieldID', 'value'))) {
			return parent::getValue($name, $parameters);
		}
		$params = $this->getParamsValues();
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
				$this->_oembedObjects[$width.'-'.$height] = new CMS_oembed($this->_subfieldValues[0]->getValue(), $width, $height, $params['embedlyKey']);
			}
			$oembed = $this->_oembedObjects[$width.'-'.$height];
		} else {
			if ($this->_oembedObjects) {
				//load current oembed object
				$oembed = current($this->_oembedObjects);
			} else {
				$this->_oembedObjects[$width.'-'.$height] = new CMS_oembed($this->_subfieldValues[0]->getValue(), $width, $height, $params['embedlyKey']);
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