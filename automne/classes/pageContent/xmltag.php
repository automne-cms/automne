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
// $Id: xmltag.php,v 1.7 2010/03/08 16:43:33 sebastien Exp $

/**
  * Class CMS_XMLTag
  *
  * Represents a XML Tag. Instanciated by the XMLParser.
  *
  * @package Automne
  * @subpackage pageContent
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_XMLTag extends CMS_grandFather
{
	/**
	  * The name of the tag.
	  * @var string
	  * @access private
	  */
	protected $_name;

	/**
	  * The tag attributes.
	  * @var array(string=>string)
	  * @access private
	  */
	protected $_attributes = array();

	/**
	  * Start byte offset in the file or text where it was found.
	  * @var integer
	  * @access private
	  */
	protected $_startByte;

	/**
	  * End byte offset in the file or text where it was found.
	  * @var integer
	  * @access private
	  */
	protected $_endByte;

	/**
	  * The Text content of the tag, including the tag itself.
	  * @var string
	  * @access private
	  */
	protected $_textContent;

	/**
	  * Constructor.
	  *
	  * @param string $name The name of the tag
	  * @param array(string) $attributes The tag attributes.
	  * @return void
	  * @access public
	  */
	function __construct($name, $attributes)
	{
		$this->_name = $name;
		if (!is_array($attributes)) {
			$this->raiseError("Attributes given are not an array. Fixed by setting an empty array.");
			$this->_attributes = array();
		} else {
			$this->_attributes = $attributes;
		}
  	}
	
	/**
	  * Get the name of the tag
	  *
	  * @return string the tag name
	  * @access public
	  */
	function getName()
	{
		return $this->_name;
	}
	
	/**
	  * Get all the tag attributes
	  *
	  * @return array(string=>string) the tag attributes
	  * @access public
	  */
	function getAttributes()
	{
		return $this->_attributes;
	}
	
	/**
	  * Get the value of an attribute.
	  *
	  * @param string $attribute The attribute we want (its the key of the associative array)
	  * @return string The attribute value
	  * @access public
	  */
	function getAttribute($attribute)
	{
		if (isset($this->_attributes[$attribute])) {
			return $this->_attributes[$attribute];
		} else {
			return false;
		}
	}
	
	/**
	  * Get the start byte position offset.
	  *
	  * @return integer the start byte
	  * @access public
	  */
	function __call($name, $parameters)
	{
		$this->raiseError(__CLASS__.' : Method '.$name.' is no longer available in this version of Automne');
		return false;
	}
	
	/**
	  * Set the text content. This content must include the tag itself.
	  *
	  * @param string $content The tag content including the tag itself
	  * @return boolean true on success, false on failure to set it
	  * @access public
	  */
	function setTextContent($content)
	{
		$content = trim($content);
		if ($content && io::substr($content, 1, io::strlen($this->_name)) == $this->_name) {
			$this->_textContent = $content;
			return true;
		} else {
			$this->raiseError("Content is empty or does not contain self tag");
			return false;
		}
	}
	
	/**
	  * Get the content, which is the text content including the tag definition.
	  *
	  * @return string the XML
	  * @access public
	  */
	function getContent()
	{
		return $this->_textContent;
	}
	
	/**
	  * Get the inner content, which is the text content excluding the tag definition.
	  *
	  * @return string the inner HTML
	  * @access public
	  */
	function getInnerContent()
	{
		$regexp = "#<".$this->_name."[^>]*>(.*)</".$this->_name.">#is";
		preg_match($regexp, $this->_textContent, $args);
		return $args[1];
	}
	
	/**
	  * Get the representation instance, from the tag name
	  * What is needed ?
	  * - $args = array("template"=>template_db_id) and attributes contain "id" key along with value for client spaces
	  * - attributes contain "id" and "type" keys along with values for rows
	  * - attributes contain "id" and "type" keys along with values for blocks
	  *
	  * @param array(mixed) $args The arguments needed to instanciate the representation
	  * @return object An instanciated object of the correct class.
	  * @access public
	  */
	function getRepresentationInstance($args = false)
	{
		//if it's a module tag, ask the representation to the module
		if (isset($this->_attributes["module"]) && $this->_attributes["module"]) {
			//Get the module
			$module = CMS_modulesCatalog::getByCodename($this->_attributes["module"]);
			if (is_a($module, "CMS_module")) {
				//get the instance from the module
				$instance = $module->getTagRepresentation($this, $args);
				if (is_object($instance)) {
					return $instance;
				} else {
					//module didn't returned a valid object instance
					return false;
				}
			} else {
				//the modules catalog didn't returned a module object
				return false;
			}
		}
		
		switch ($this->_name) {
			case "atm-linx":
				if ($this->_attributes["type"] && $args["page"] && isset($args["publicTree"])) {
					$linxArgs = array();
					$linxArgs['id'] = isset($this->_attributes["id"]) ? $this->_attributes["id"] : false;
					$linxArgs['class'] = isset($this->_attributes["class"]) ? $this->_attributes["class"] : false;
					if (isset($this->_attributes["node"]) && io::isPositiveInteger($this->_attributes["node"])) {
						$linxArgs['node'] = $this->_attributes["node"];
					}
					return new CMS_linx($this->_attributes["type"], $this->getContent(), $args["page"], $args["publicTree"], $linxArgs);
				} else {
					return false;
				}
			break;
		}
	}
}
 
?>