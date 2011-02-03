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
  * Class CMS_XMLTag_anchor
  *
  * This script aimed to manage anchors tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage standard
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_anchor extends CMS_XMLTag
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
		$href = $this->_attributes['href'];
		$attributes = '';
		foreach ($this->_attributes as $attribute => $value) {
			if ($attribute != 'href') {
				$attributes .= ' '.$attribute.'=\"'.$this->replaceVars($value).'\"';
			}
		}
		return '$content .= "<'.$this->_name.' href=\"".$_SERVER[\'SCRIPT_NAME\'].($_SERVER["QUERY_STRING"] ? \'?\'.$_SERVER["QUERY_STRING"] : \'\')."'.$href.'\"'.$attributes.'>";
			'.$this->_computeChilds().'
			$content .= "</'.$this->_name.'>";';
	}
}
?>