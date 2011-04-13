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
class CMS_XMLTag_anchor extends CMS_XMLTag {
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
		if (!isset($this->_attributes['href'])) {
			return '';
		}
		$anchor = $this->replaceVars($this->_attributes['href']);
		$attributes = '';
		foreach ($this->_attributes as $attribute => $value) {
			if ($attribute != 'href') {
				$attributes .= ' '.$attribute.'=\"'.$this->replaceVars($value).'\"';
			}
		}
		return '$content .= CMS_XMLTag_anchor::anchorStart(\''.$this->_name.'\', "'.$anchor.'", "'.$attributes.'");
			'.$this->_computeChilds().'
			$content .= CMS_XMLTag_anchor::anchorEnd(\''.$this->_name.'\');';
	}
	
	/**
	  * Output the anchor start tag
	  *
	  * @return string the HTML content
	  * @access private
	  */
	function anchorStart($tagName, $anchor, $attributes) {
		if (strpos($_SERVER['SCRIPT_NAME'], PATH_ADMIN_WR) !== false) {
			return '<'.$tagName.' href="'.$anchor.'"'.$attributes.'>';
		}
		return '<'.$tagName.' href="'.(pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_BASENAME) != 'index.php' ? $_SERVER['SCRIPT_NAME'] : (pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME) . (pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME) == '/' ? '' : '/'))).($_SERVER["QUERY_STRING"] ? '?'.io::htmlspecialchars($_SERVER["QUERY_STRING"]) : '').$anchor.'"'.$attributes.'>';
	}
	
	/**
	  * Output the anchor end tag
	  *
	  * @return string the HTML content
	  * @access private
	  */
	function anchorEnd($tagName) {
		return '</'.$tagName.'>';
	}
}
?>