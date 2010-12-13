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
  * Class CMS_XMLTag_start
  *
  * This script aimed to manage atm-start-tag tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_start extends CMS_XMLTag
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
				'tag' => 'alphanum', 
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
		$attributes = '';
		foreach ($this->_attributes as $attribute => $value) {
			if ($attribute != 'tag') {
				$attributes .= ' '.$attribute.'=\"'.$value.'\"';
			}
		}
		return '$content .= "<'.$this->_attributes["tag"].$attributes.'>";';
	}
}
?>