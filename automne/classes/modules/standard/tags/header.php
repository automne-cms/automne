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
  * Class CMS_XMLTag_header
  *
  * This script aimed to manage atm-header tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_header extends CMS_XMLTag
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
		$headCode = '';
		if ($this->_parameters['context'] == CMS_XMLTag::HTML_CONTEXT) {
			$headCode.= 'ob_start();';
			$xml = new CMS_xml2Array($this->_computeChilds());
			$headCode .= $xml->toXML($xml->getParsedArray(), false, true).'<?php ';
			$headCode.= '$content = ob_get_contents();
			ob_end_clean();
			$replace=array();';
			$footcode = 'if (trim($content)) {echo $content;}'."\n";
		} else {
			$headCode.= $this->_computeChilds().'
			if (trim($content)) {echo $content;}';
		}
		
		
		
		if ($this->_parameters['context'] == CMS_XMLTag::HTML_CONTEXT) {
			$code = array('code' => CMS_XMLTag::indentPHP(CMS_XMLTag::cleanComputedDefinition($this->_returnComputedDatas($headCode))));
			CMS_module::moduleUsage($this->_computeParams['object']->getID(), MOD_STANDARD_CODENAME, array('headCallback' => array($code)));
		} else {
			$this->_tagHeaderCode = array('code' => CMS_XMLTag::indentPHP(CMS_XMLTag::cleanComputedDefinition($headCode)));
		}
		return '';
	}
}
?>