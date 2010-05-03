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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: linxcondition.php,v 1.4 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_linxCondition
  *
  * Manages a linx "condition" tag representation
  *
  * @package CMS
  * @subpackage pageContent
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_linxCondition extends CMS_grandFather
{
	/**
	  * The page property to test
	  * @var string
	  * @access private
	  */
	protected $_pageProperty;

	/**
	  * The operator for the comparison. Beware ! '>' must be coded '&gt;' and '<' must be coded '&lt;'
	  * @var string
	  * @access private
	  */
	protected $_operator;

	/**
	  * The type of value to test : if this var is true, it's a plain value, else it's a value to get from a nodespec.
	  * @var boolean
	  * @access private
	  */
	protected $_valueIsScalar = true;

	/**
	  * The scalar value to test.
	  * @var mixed
	  * @access private
	  */
	protected $_valueScalar;

	/**
	  * The nodespec value to test
	  * @var CMS_XMLTag
	  * @access private
	  */
	protected $_valueNodespec;

	/**
	  * The property of the nodespec we will test
	  * @var string
	  * @access private
	  */
	protected $_valueNodespecProperty;


	/**
	  * Constructor.
	  * initializes the linxCondition.
	  *
	  * @param string $property The page property we're gonna test. Only a set of these are available here.
	  * @param string $operator The comparison operator serving to test the condition.
	  * @param string $tagContent The tag content.
	  * @return void
	  * @access public
	  */
	function __construct($tag)
	{
		$authorized_properties =array("rank", "title", "id", "lvl", "father");
		$property = $tag->getAttribute('property');
		$operator = $tag->getAttribute('operator');
		if (SensitiveIO::isInSet($property, $authorized_properties)) {
			$this->_pageProperty = $property;
			$this->_operator = io::decodeEntities(io::decodeEntities(io::decodeEntities($operator)));
			$values = $tag->getElementsByTagName('value');
			if ($values->length > 0) {
				$value = $values->item(0);
				//if value type is "nodeproperty", we must parse the inner content to find a nodespec tag
				if ($value->hasAttribute("type") && $value->getAttribute("type") == "nodeproperty") {
					$this->_valueIsScalar = false;
					$this->_valueNodespecProperty = $value->getAttribute("property");
					$nodespecs = $value->getElementsByTagName('nodespec');
					if ($nodespecs->length > 0) {
						$nodespec = $nodespecs->item(0);
						$this->_valueNodespec = CMS_linxNodespec::createNodespec($nodespec);
					}
				} else {
					$this->_valueScalar = $value->nodeValue;
				}
			} else {
				$this->raiseError("Malformed innerContent");
				return;
			}
		} else {
			$this->raiseError("Unknown property : ".$property);
		}
	}

	/**
	  * Test to see if a page passes the condition
	  *
	  * @param CMS_page $page The parsed page : the one which contains the linx tag
	  * @param CMS_page $page The page to test
	  * @param boolean $publicTree Is the test conducted inside the public or edited tree ?
	  * @param integer $rank The rank of the page in the pre-condition targets
	  * @return boolean true if the page passes the condition, false otherwise
	  * @access public
	  */
	function pagePasses(&$parsedPage, &$page, $publicTree, $rank)
	{
		//set the condition value
		if ($this->_valueIsScalar) {
			$condition_value = $this->_valueScalar;
		} else {
			$condition_target = $this->_valueNodespec->getTarget($parsedPage, $publicTree);
			$condition_value = $this->_getPageProperty($condition_target, $this->_valueNodespecProperty, $publicTree);
		}
		if (is_null($condition_value)) {
			return false;
		}
		//build the body of the test function
		if ($this->_pageProperty == "rank") {
			$func_body = sprintf('return (%s %s %s);', $rank, $this->_operator, $condition_value);
		} else {
			$page_value = $this->_getPageProperty($page, $this->_pageProperty, $publicTree);
			if (is_null($page_value)) {
				return false;
			}
			$func_body = sprintf('return (%s %s %s);', $page_value, $this->_operator, $condition_value);
		}
		$func = @create_function('', $func_body);
		return @$func();
	}
	
	/**
	  * Test to see if a level passes the condition
	  *
	  * @param integer $level The level to check
	  * @return boolean true if the level passes the condition, false otherwise
	  * @access public
	  */
	function levelPasses($level)
	{
		//set the condition value
		if (!$this->_valueIsScalar || $this->_pageProperty != "lvl") {
			$this->raiseError("Incorrect linx condition");
			return false;
		}
		//build the body of the test function
		if ($func = @create_function('', 'return ('.$level.' '.$this->_operator.' '.$this->_valueScalar.');')) {
			return $func();
		} else {
			$this->raiseError('Error during creation of runtime-function : return ('.$level.' '.$this->_operator.' '.$this->_valueScalar.');');
			return false;
		}
	}

	/**
	  * Get the page property specified
	  *
	  * @param CMS_page $page The page we want the property of
	  * @param string $property The property we want
	  * @param boolean $public Do we want the public or edited property ?
	  * @return mixed The property value
	  * @access private
	  */
	protected function _getPageProperty(&$page, $property, $public)
	{
		if (!is_a($page, "CMS_page")) {
			$this->raiseError("Page parameter must be an object");
			return;
		}
		switch ($property) {
		case "title":
			return $page->getTitle($public);
			break;
		case "father":
			return CMS_tree::getFather($page, false, $public);
			break;
		case "id":
			return $page->getID();
			break;
		}
	}
	
	/**
	  * Create a CMS_linxCondition instance from a given DOMElement
	  *
	  * @param DOMElement $tag The DOMElement to convert
	  * @return CMS_linxNodespec The CMS_linxCondition instance
	  * @access public
	  * @static
	  */
	function createCondition($tag) {
		if (!is_a($tag, "DOMElement")) {
			CMS_grandFather::raiseError('Tag is not a DOMElement instance');
			return false;
		}
		if (!$tag->hasAttribute("property") || !$tag->hasAttribute("operator")) {
			$this->raiseError('Condition property is not well formed');
			return false;
		}
		return new CMS_linxCondition($tag);
	}
}
?>