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
  * Class CMS_XMLTag_js_add
  *
  * This script aimed to manage atm-js-add tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage standard
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_js_add extends CMS_XMLTag
{
	/**
	 * Default tag context
	 * @var string the default tag context
	 * @access public
	 */
	protected $_context = CMS_XMLTag::HTML_CONTEXT;
	
	/**
	  * Constructor.
	  *
	  * @param string $name The name of the tag
	  * @param array(string) $attributes The tag attributes.
	  * @return void
	  * @access public
	  */
	public function __construct($name, $attributes, $children, $parameters) {
		parent::__construct($name, $attributes, $children, $parameters);
		//check tags requirements
		if (!$this->checkTagRequirements(array(
				'file' => true, 
			))) {
			return;
		}
	}
	
	/**
	  * Compute the tag
	  *
	  * @return string the PHP / HTML content computed
	  * @access private
	  */
	protected function _compute() {
		if (!isset($this->_computeParams['object']) || !($this->_computeParams['object'] instanceof CMS_page)) {
			CMS_grandFather::raiseError('atm-js-add tag must be outside of <block> tags');
			return '';
		}
		if (!isset($this->_attributes['file'])) {
			CMS_grandFather::raiseError('atm-js-add tag must have file parameter');
			return '';
		}
		$files = CMS_module::moduleUsage($this->_computeParams['object']->getID(), "atm-js-tags-add");
		$files = is_array($files) ? $files : array();
		//append module js files
		$files = array_merge($files, array($this->_attributes['file']));
		//save files
		CMS_module::moduleUsage($this->_computeParams['object']->getID(), "atm-js-tags-add", $files, true);
	}
}
?>