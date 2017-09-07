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
  * Class CMS_XMLTag_redirect
  *
  * This script aimed to manage atm-redirect tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage standard
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_redirect extends CMS_XMLTag
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
				'url' => 'alphanum',
			))) {
			return;
		}
		if (isset($this->_attributes['type']) && $this->_attributes['type']) {
			if (!$this->checkTagRequirements(array(
					'type' => 'alphanum',
					'vartype' => '301|302', 
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
		$url = $this->replaceVars($this->_attributes['url']);
		$type = isset($this->_attributes['type']) ? $this->_attributes['type'] : '302';
		$return = 'if (!CMS_view::redirect("'.$url.'", true, '.$type.')) {'."\n".
		'	CMS_grandFather::raiseError("Cannot make redirection to url '.$url.'");'."\n".
		'}'."\n";
		return $return;
	}
}
?>