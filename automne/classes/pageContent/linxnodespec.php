<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: linxnodespec.php,v 1.3 2009/04/15 12:27:02 sebastien Exp $

/**
  * Class CMS_linxNodespec
  *
  * Manages a linx "nodespec" tag representation.
  * Herited from Automne v1, it's a specification of a node (a page) XML encoded.
  * It can be a direct specification or a relative one (ex. the father of the page with ID 12, ...)
  *
  * @package CMS
  * @subpackage pageContent
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_linxNodespec extends CMS_grandFather
{
	/**
	  * The nodespec type, one of "node", "relative"
	  * @var string
	  * @access private
	  */
	protected $_type;
	
	/**
	  * The value, either a page reference (ID) or one of "self", "brother", "father", "root"
	  * @var mixed
	  * @access private
	  */
	protected $_value;
	
	/**
	  * The relative offset, if type is "relative"
	  * @var integer
	  * @access private
	  */
	protected $_relativeOffset;
	
	/**
	  * Does this links display pages accross websites ?
	  * @var boolean (default : false)
	  * @access private
	  */
	protected $_crosswebsite = false;
	

	/**
	  * Constructor.
	  * initializes the linxDisplay.
	  *
	  * @param string $innerContent The tag content.
	  * @return void
	  * @access public
	  */
	function __construct($type, $value, $relativeOffset, $crosswebsite = false)
	{
		$authorized_types = array("node", "relative");
		$authorized_string_values = array("self", "brother", "father", "root");
		$this->_crosswebsite = $crosswebsite;
		if (!SensitiveIO::isInSet($type, $authorized_types)) {
			$this->raiseError("Type unknown : ".$type);
			return;
		}
		if ($type == "node" && !SensitiveIO::isPositiveInteger($value)) {
			$this->raiseError("Bad value for 'node' type : ".$value);
			return;
		}
		if ($type == "relative" && !SensitiveIO::isInSet($value, $authorized_string_values)) {
			$this->raiseError("Bad value for 'relative' type : ".$value);
			return;
		}
		
		$this->_type = $type;
		$this->_value = $value;
		if (!SensitiveIO::isPositiveInteger($value)) {
			$this->_relativeOffset = $relativeOffset;
		}
	}

	/**
	  * Get the relative type if the nodespec type is "relative", false otherwise
	  *
	  * @return string The relative type, or false if not relative
	  * @access public
	  */
	function getRelativeType()
	{
		if ($this->_type == "relative") {
			return $this->_value;
		} else {
			return false;
		}
	}

	/**
	  * Computes the target of the tag.
	  *
	  * @param CMS_page $page The page where the linx tag is.
	  * @param string $publicTree Is the calculus made in the public or edited tree ?
	  * @return CMS_page The target page, of false if no target.
	  * @access public
	  */
	function getTarget(&$page, $publicTree)
	{
		switch ($this->_type) {
		case "node":
			$pg = CMS_tree::getPageByID($this->_value);
			if ($pg && !$pg->hasError()) {
				return $pg;
			} else {
				return false;
			}
			break;
		case "relative" :
			switch ($this->_value) {
			case "root":
				$offset = abs($this->_relativeOffset) * -1;
				$pg = CMS_tree::getAncestor($page, $offset, !$this->_crosswebsite, $publicTree);
				if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
					return $pg;
				} else {
					return false;
				}
				break;
			case "father":
				$offset = abs($this->_relativeOffset);
				$pg = CMS_tree::getAncestor($page, $offset, !$this->_crosswebsite, $publicTree);
				if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
					return $pg;
				} else {
					return false;
				}
				break;
			case "self":
				return $page;
				break;
			case "brother":
				$pg = CMS_tree::getBrother($page, $this->_relativeOffset, $publicTree);
				if ($pg && !$pg->hasError()) {
					return $pg;
				} else {
					return false;
				}
				break;
			}
			break;
		}
	}
	
	/**
	  * Create a CMS_linxNodespec instance from a given DOMElement
	  *
	  * @param DOMElement $tag The DOMElement to convert
	  * @return CMS_linxNodespec The CMS_linxNodespec instance
	  * @access public
	  * @static
	  */
	function createNodespec($tag, $crosswebsite = false) {
		if (!is_a($tag, "DOMElement")) {
			CMS_grandFather::raiseError('Tag is not a DOMElement instance');
			return false;
		}
		if (!$tag->hasAttribute("type") || !$tag->hasAttribute("value")) {
			CMS_grandFather::raiseError('Nodespec property is not well formed');
			return false;
		}
		return new CMS_linxNodespec($tag->getAttribute("type"), $tag->getAttribute("value"), $tag->getAttribute("reloffset"), $crosswebsite);
	}
}

?>
