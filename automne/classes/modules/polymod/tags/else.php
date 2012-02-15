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
  * Class CMS_XMLTag_else
  *
  * This script aimed to manage atm-else tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_else extends CMS_XMLTag
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
	function __construct($name, $attributes, $children, $parameters) {
		parent::__construct($name, $attributes, $children, $parameters);
		//check tags requirements
		if (!$this->checkTagRequirements(array(
				'for' => 'alphanum', 
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
		if (isset($this->_attributes['what']) && $this->_attributes['what']) {
			//decode ampersand
			$this->_attributes['what'] = io::decodeEntities($this->_attributes['what']);
			$return = '
			if (isset($atmIfResults[\''.$this->_attributes['for'].'\'][\'if\']) && $atmIfResults[\''.$this->_attributes['for'].'\'][\'if\'] === false):
				$ifcondition_'.$this->_uniqueID.' = CMS_polymod_definition_parsing::replaceVars("'.$this->replaceVars($this->_attributes['what'], false, false, array($this, 'encloseWithPrepareVar')).'", @$replace);
				if ($ifcondition_'.$this->_uniqueID.'):
					$func_'.$this->_uniqueID.' = @create_function("","return (".$ifcondition_'.$this->_uniqueID.'.");");
					if ($func_'.$this->_uniqueID.' === false) {
						CMS_grandFather::raiseError(\'Error in atm-else ['.$this->_uniqueID.'] syntax : \'.$ifcondition_'.$this->_uniqueID.');
					}
					if ($func_'.$this->_uniqueID.' && $func_'.$this->_uniqueID.'()):
					';
					//if attribute name is set, store if result
					if (isset($this->_attributes['for']) && $this->_attributes['for']) {
						$return .= '$atmIfResults[\''.$this->_attributes ['for'].'\'][\'if\'] = true;';
					}
					$return .= '
						'.$this->_computeChilds().'
					endif;
					unset($func_'.$this->_uniqueID.');
				endif;
				unset($ifcondition_'.$this->_uniqueID.');
			endif;
			';
		} else {
			$return = '
			if (isset($atmIfResults[\''.$this->_attributes['for'].'\'][\'if\']) && $atmIfResults[\''.$this->_attributes['for'].'\'][\'if\'] === false):
				'.$this->_computeChilds().'
			endif;
			';
		}
		return $return;
	}
}
?>