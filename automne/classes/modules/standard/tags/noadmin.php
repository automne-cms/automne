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
  * Class CMS_XMLTag_noadmin
  *
  * This script aimed to manage atm-noadmin tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_noadmin extends CMS_XMLTag
{
	/**
	 * Default tag context
	 * @var string the default tag context
	 * @access public
	 */
	protected $_context = CMS_XMLTag::PHP_CONTEXT;
	
	/**
	  * Compute the tag
	  *
	  * @return string the PHP / HTML content computed
	  * @access private
	  */
	protected function _compute() {
		return 'if (!(strpos($_SERVER["REQUEST_URI"], \'automne/admin\') !== false  || (isset($_REQUEST[\'atm-context\']) && $_REQUEST[\'atm-context\'] == \'adminframe\'))): '."\n".
		$this->_computeChilds()."\n".
		'endif; ';
	}
}
?>