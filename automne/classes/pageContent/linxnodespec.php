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
// $Id: linxnodespec.php,v 1.5 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_linxNodespec
  *
  * Manages a linx "nodespec" tag representation.
  * Herited from Automne v1, it's a specification of a node (a page) XML encoded.
  * It can be a direct specification or a relative one (ex. the father of the page with ID 12, ...)
  *
  * @package Automne
  * @subpackage pageContent
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_linxNodespec extends CMS_grandFather
{
	/**
	  * The nodespec type, one of "node", "relative", "codename"
	  * @var string
	  * @access private
	  */
	protected $_type;
	
	/**
	  * The value, either a page reference (ID) or one of "self", "brother", "father", "root" or a page codename
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
	  * Does this links display pages from a specific website ?
	  * @var string : the website name
	  * @access private
	  */
	protected $_website;
	

	/**
	  * Constructor.
	  * initializes the linxDisplay.
	  *
	  * @param string $innerContent The tag content.
	  * @return void
	  * @access public
	  */
	function __construct($type, $value, $relativeOffset, $crosswebsite = false, $website = '')
	{
		$authorized_types = array("node", "relative", "codename");
		$authorized_string_values = array("self", "brother", "father", "root");
		$this->_crosswebsite = $crosswebsite;
		if (!SensitiveIO::isInSet($type, $authorized_types)) {
			$this->setError("Type unknown : ".$type);
			return;
		}
		if ($type == 'node' && !SensitiveIO::isPositiveInteger($value)) {
			$this->setError("Bad value for 'node' type : ".$value);
			return;
		}
		if ($type == 'relative' && !SensitiveIO::isInSet($value, $authorized_string_values)) {
			$this->setError("Bad value for 'relative' type : ".$value);
			return;
		}
		if ($type == 'codename' && strtolower(io::sanitizeAsciiString($value)) != $value) {
			$this->setError("Bad value for 'codename' type : ".$value);
			return;
		}
		if ($type == 'codename' && strtolower(io::sanitizeAsciiString($website)) != $website) {
			$this->setError("Bad value for 'website' : ".$website);
			return;
		}
		$this->_type = $type;
		$this->_value = $value;
		$this->_website = $website;
		if ($this->_type == 'relative') {
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
		$pg = false;
		switch ($this->_type) {
		case "node":
			$pg = CMS_tree::getPageByID($this->_value);
			if ($pg && !$pg->hasError()) {
				return $pg;
			} else {
				return false;
			}
			break;
		case "codename":
			if ($this->_website) {
				$website = CMS_websitesCatalog::getByCodename($this->_website);
				if ($website) {
					$pg = CMS_tree::getPageByCodename($this->_value, $website, $publicTree, true);
				}
			} else {
				if ($this->_crosswebsite) {
					return CMS_tree::getPagesByCodename($this->_value, $publicTree, true);
				} else {
					$pg = CMS_tree::getPageByCodename($this->_value, $page->getWebsite(), $publicTree, true);
				}
			}
			if ($pg && !$pg->hasError()) {
				return $pg;
			} else {
				return false;
			}
			break;
		case "relative" :
			switch ($this->_value) {
				case "root":
					if ($this->_website) {
						$website = CMS_websitesCatalog::getByCodename($this->_website);
						if ($website) {
							$pg = $website->getRoot();
						}
					} else {
						$offset = abs($this->_relativeOffset) * -1;
						$pg = CMS_tree::getAncestor($page, $offset, !$this->_crosswebsite, false); //here we do not want to use public tree because, in public tree, some page may be unpublished or in this case, it break the lineage and root page cannot be found
					}
				break;
				case "father":
					$offset = abs($this->_relativeOffset);
					$pg = CMS_tree::getAncestor($page, $offset, !$this->_crosswebsite, $publicTree);
				break;
				case "self":
					$pg = $page;
				break;
				case "brother":
					$pg = CMS_tree::getBrother($page, $this->_relativeOffset, $publicTree);
				break;
			}
			if ($this->_website && is_a($pg, 'CMS_page') && !$pg->hasError()) {
				if ($pg->getCodename()) {
					$website = CMS_websitesCatalog::getByCodename($this->_website);
					$pg = $website ? CMS_tree::getPageByCodename($pg->getCodename(), $website, $publicTree, true) : false;
				} else {
					$pg = false;
				}
			}
			if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
				return $pg;
			} else {
				return false;
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
	static function createNodespec($tag, $crosswebsite = false) {
		if (!is_a($tag, "DOMElement")) {
			CMS_grandFather::raiseError('Tag is not a DOMElement instance');
			return false;
		}
		if (!$tag->hasAttribute("type") || !$tag->hasAttribute("value")) {
			CMS_grandFather::raiseError('Nodespec property is not well formed');
			return false;
		}
		return new CMS_linxNodespec($tag->getAttribute("type"), $tag->getAttribute("value"), $tag->getAttribute("reloffset"), $crosswebsite, $tag->getAttribute("website"));
	}
}

?>
