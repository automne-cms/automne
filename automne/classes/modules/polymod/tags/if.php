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
  * Class CMS_XMLTag_if
  *
  * This script aimed to manage atm-if tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_if extends CMS_XMLTag
{
	/**
	 * Default tag context
	 * @var string the default tag context
	 * @access public
	 */
	protected $_context = CMS_XMLTag::PHP_CONTEXT;
	
	/**
	  * Constructor.
	  *
	  * @param string $name The name of the tag
	  * @param array(string) $attributes The tag attributes.
	  * @return void
	  * @access public
	  */
	function __construct($name, $attributes, $parameters) {
		parent::__construct($name, $attributes, $parameters);
		//check tags requirements
		if (!$this->checkTagRequirements(array(
				'what' => true, 
			))) {
			return;
		}
		if (isset($this->_attributes['name']) && $this->_attributes['name']) {
			if (!$this->checkTagRequirements(array(
					'name' => 'alphanum', 
				))) {
				return;
			}
		}
	}
	
	/**
	  * Compute the tag
	  *
	  * @return string the PHP / HTML content computed
	  * @access private
	  */
	protected function _compute() {
		//decode ampersand
		$this->_attributes['what'] = io::decodeEntities($this->_attributes['what']);
		$return = '
		//IF TAG START '.$this->_uniqueID.'
		$ifcondition_'.$this->_uniqueID.' = CMS_polymod_definition_parsing::replaceVars("'.$this->replaceVars($this->_attributes['what'], false, false, array('CMS_polymod_definition_parsing', 'encloseWithPrepareVar')).'", @$replace);
		if ($ifcondition_'.$this->_uniqueID.') {
			$func_'.$this->_uniqueID.' = create_function("","return (".$ifcondition_'.$this->_uniqueID.'.");");';
			//if attribute name is set, store if result
			if (isset($this->_attributes['name']) && $this->_attributes['name']) {
				$return .= '$atmIfResults[\''.$this->_attributes['name'].'\'][\'if\'] = false;';
			}
		$return .= '
			if ($func_'.$this->_uniqueID.'()) {';
				//if attribute name is set, store if result
				if (isset($this->_attributes['name']) && $this->_attributes['name']) {
					$return .= '$atmIfResults[\''.$this->_attributes ['name'].'\'][\'if\'] = true;';
				}
			$return .= '
				'.$this->_computeChilds().'
			}
			unset($func_'.$this->_uniqueID.');
		}
		unset($ifcondition_'.$this->_uniqueID.');
		//IF TAG END '.$this->_uniqueID.'
		';
		return $return;
	}
}
?>