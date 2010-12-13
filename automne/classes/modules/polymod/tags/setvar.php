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
  * Class CMS_XMLTag_setvar
  *
  * This script aimed to manage atm-setvar tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_setvar extends CMS_XMLTag
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
				'varname' => 'alphanum', 
				'vartype' => 'request|session|var', 
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
		$return = '
		//SETVAR TAG START '.$this->_uniqueID;
		if ($this->_attributes["vartype"] == 'request') {
			$return .= '
			$_REQUEST[\''.$this->_attributes["varname"].'\'] = CMS_polymod_definition_parsing::replaceVars('.$this->replaceVars(var_export($this->_attributes["value"],true),true).',@$replace);';
		} elseif ($this->_attributes["vartype"] == 'session') {
			$return .= '
			$_SESSION[\''.$this->_attributes["varname"].'\'] = CMS_polymod_definition_parsing::replaceVars('.$this->replaceVars(var_export($this->_attributes["value"],true),true).',@$replace);';
		} else {
			$return .= '
			$'.$this->_attributes["varname"].' = CMS_polymod_definition_parsing::replaceVars('.$this->replaceVars(var_export($this->_attributes["value"],true),true).',@$replace);';
		}
		$return .= '
		//SETVAR TAG END '.$this->_uniqueID.'
		';
		return $return;
	}
}
?>