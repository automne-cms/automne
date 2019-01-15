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
  * Class CMS_XMLTag_xml
  *
  * This script aimed to manage atm-xml tags. it extends CMS_XMLTag
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_XMLTag_xml extends CMS_XMLTag
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
	public function __construct($name, $attributes, $children, $parameters) {
		parent::__construct($name, $attributes, $children, $parameters);
		//check tags requirements
		if (!$this->checkTagRequirements(array(
				'what' => true, 
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
		//return code
		$return = $this->_computeChilds();
		$strict = isset($this->_attributes['strict']) && ($this->_attributes['strict'] == 'true' || $this->_attributes['strict'] == true || $this->_attributes['strict'] == 1) ? true : false;
		//Ajax code
		$ajaxCode = '
		if(io::request(\'out\') == \'xml\') {
			$xmlCondition = CMS_polymod_definition_parsing::replaceVars("'.$this->replaceVars($this->_attributes['what'], false, false, array($this, 'encloseWithPrepareVar')).'", $replace);
			if ($xmlCondition) {
				//$func = create_function("","return (".$xmlCondition.");");
				$func = function() use ($xmlCondition) {
					return $xmlCondition;
				};
				if ($func && $func()) {
					$cms_view = CMS_view::getInstance();
					$content = $replace = \'\';';
		if ($this->_parameters['context'] == CMS_XMLTag::HTML_CONTEXT) {
			$ajaxCode.= 'ob_start();';
			$xml = new CMS_xml2Array($return);
			$xmlParsedArray = $xml->getParsedArray();
			$ajaxCode .= $xml->toXML($xmlParsedArray, false, true).'<?php ';
			$ajaxCode.= '$content = ob_get_contents();
			ob_end_clean();
			$replace=array();';
		} else {
			$ajaxCode.= $return;
		}
		$ajaxCode.= '$content = CMS_polymod_definition_parsing::replaceVars($content, $replace);
					$cms_view->setDisplayMode('.($strict ? 'CMS_view::SHOW_XML' : 'CMS_view::SHOW_RAW').');
					$cms_view->setContent($content);
					//output empty XML response
					unset($content);
					unset($replace);
					$cms_view->setContentTag(\'data\');
					$cms_view->show();
				}
			}
			unset($xmlCondition);
		}';
		if ($this->_parameters['context'] == CMS_XMLTag::HTML_CONTEXT) {
			$code = array('code' => CMS_XMLTag::indentPHP(CMS_XMLTag::cleanComputedDefinition($this->_returnComputedDatas($ajaxCode))));
			CMS_module::moduleUsage($this->_computeParams['object']->getID(), MOD_STANDARD_CODENAME, array('headCallback' => array($code)));
		} else {
			$this->_tagHeaderCode = array('code' => CMS_XMLTag::indentPHP(CMS_XMLTag::cleanComputedDefinition($ajaxCode)));
		}
		return $return;
	}
}
?>