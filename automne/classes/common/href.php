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
// | Authors: Cédric Soret <cedric.soret@ws-interactive.fr> &             |
// | Authors: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>     |
// +----------------------------------------------------------------------+
//
// $Id: href.php,v 1.8 2010/03/08 16:43:27 sebastien Exp $

/**
  * Class Href
  *
  * Manage and serialize/unserialize an Hypertext reference
  * Give a fully formated XHTML A tag when asked.
  *
  * @package Automne
  * @subpackage common
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_href extends CMS_grandFather
{
	/**
	  * String resulting from serialization
	  * @see getTextDefinition() for precise format
	  * @var String
	  * @access private
	  */
	protected $_textDefinition;
	
	/**
	  * Type of the link provided by the news article
	  * @var integer See resource constants.
	  * @access private
	  */
	protected $_linkType = RESOURCE_LINK_TYPE_NONE;

	/**
	  * Reference (DB ID) of the page for an internal link
	  * @var integer
	  * @access private
	  */
	protected $_internalLink;

	/**
	  * URL for an external link
	  * @var string
	  * @access private
	  */
	protected $_externalLink;
	
	/**
	  * File to link : a filename stored fora the modules
	  * (URL or pathdepending on locations) or a full path
	  * if this href will not be managed through a module
	  * @var string
	  * @access private
	  */
	protected $_fileLink;
	
	/**
	  * The target
	  * @var String
	  * @access private
	  */
	protected $_target;
	
	/**
	  * The label of ther link, enclosed in the "A" tag
	  * @var String
	  * @access private
	  */
	protected $_label;
	
	/**
	  * The pop-up definition in an array
	  * @var array('width'=> integer,'height'=> integer)
	  * @access private
	  */
	protected $_popup = array();
	
	/**
	  * The attributes completing XHTML tag
	  * CSS ID and/or class, etc.
	  * @var array(string "key" => string "value")
	  * @access private
	  */
	protected $_attributes = array();
	
	/**
	  * The separator used for tag definition
	  * @var string
	  * @access private
	  */
	protected $_separator = '|';
	
	/**
	  * The module codename
	  * Needed for all file uploaded and managed through a module
	  * @var string
	  * @access private
	  */
	protected $_moduleCodename = '';
	
	/**
	  * Get the text definition.
	  *
	  * @param string $textDefinition, teh full definition for this Link
	  * format : linkType|internalLink|externalLink|target|use-pop-up|Link
	  * label;
	  * @return void
	  * @access public
	  */
	public function __construct($textDefinition = '')
	{
		if ($textDefinition != '') {
			$this->_textDefinition = $textDefinition;
			$tmp = explode($this->_separator, $this->_textDefinition);
			if (sizeof($tmp) > 1) {
				$this->_linkType = @$tmp[0];
				$this->_internalLink = @$tmp[1];
				$this->_externalLink = @$tmp[2];
				$this->_fileLink = @$tmp[3];
				$this->_target = @$tmp[4];
				// Attributes
				if (isset($tmp[5]) && $tmp[5] != '') {
					$attrs = explode('&&', $tmp[5]);
					if (is_array($attrs) && $attrs) {
						foreach ($attrs as $attr) {
							$t = explode(',', $attr);
							$this->setAttribute($t[0], $t[1]);
						}
					}
				}
				// Popup
				if (isset($tmp[6]) && $tmp[6] != '') {
					$p = explode(',', $tmp[6]);
					if (is_array($p) && $p) {
						$this->setPopup($p[0], $p[1]);
					}
				}
				// Link label
				if (isset($tmp[7]) && $tmp[7] != '') {
					$this->setLabel($tmp[7]);
				}
				return;
			} else {
				$this->setError('Not a valid formated href definition given : '.$textDefinition);
			}
		}
	}
	
	/**
	  * Returns the String definition well formatted
	  * format : {{lynkType}}{{sep}}{{internalLink}}{{sep}}{{externalLink}}{{sep}}{{fileLink}}{{sep}}{{attributes}}{{sep}}{{pop-width}},{{pop-height}}{{sep}}
	  *
	  * @return string The text definition based on the current elements
	  * @access public
	  */
	public function getTextDefinition()
	{
		// Link Type
		$arr = array();
		$arr[0] = $this->_linkType;
		$arr[1] = $this->_internalLink;
		$arr[2] = $this->_externalLink;
		$arr[3] = $this->_fileLink;
		// Target
		$arr[4] = $this->_target;
		// Other attributes
		$text = '';
		if (is_array($this->_attributes) && $this->_attributes) {
			reset($this->_attributes);
			while (list($k,$v) = each ($this->_attributes)) {
				$text .= $k.','.$v.'&&';
			}
		}
		$arr[5] = io::substr($text, 0, -2);
		// Popup
		$arr[6] = @implode(',', $this->_popup);
		// Label
		$arr[7] = $this->_label;
		$this->_textDefinition = implode($this->_separator, $arr);
		return $this->_textDefinition;
	}
	
	/**
	  * Get : The target
	  *
	  * @return string the target
	  * @access public
	  */
	public function getTarget()
	{
		return $this->_target;
	}
	
	/**
	  * Set : The target
	  *
	  * @param string $s, the target
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setTarget($s)
	{
		$this->_target = $s;
		return null;
	}
	
	/**
	  * Get : The label
	  *
	  * @return string the label
	  * @access public
	  */
	public function getLabel()
	{
		return str_replace('{{href}}', '', $this->_label);
	}
	
	/**
	  * Get : The separator
	  *
	  * @return string the separator
	  * @access public
	  */
	public function getSeparator()
	{
		return $this->_separator;
	}
	
	/**
	  * Set : The label
	  *
	  * @param string $s, the label to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setLabel($s)
	{
		$s = preg_replace("#(\r\n)|(\n)|(\r)#", " ", $s);
		$this->_label = str_replace($this->_separator, '', $s);
		return true;
	}
	/**
	  * Gets the type of the link
	  *
	  * @return string The link type
	  * @access public
	  */
	public function getLinkType()
	{
		return $this->_linkType;
	}
	
	/**
	  * Sets the type of link
	  *
	  * @param integer $type The type to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setLinkType($type)
	{
		if (!SensitiveIO::isInSet($type, CMS_resource::getAllLinkTypes())) {
			$this->setError("Type not in the valid set");
			return false;
		}
		$this->_linkType = $type;
		return true;
	}
	
	/**
	  * Gets the internal link (a page ID)
	  *
	  * @return integer
	  * @access public
	  */
	public function getInternalLink()
	{
		return $this->_internalLink;
	}
	
	/**
	  * Gets the internal link (a page or false if no link)
	  *
	  * @return CMS_page
	  * @access public
	  */
	public function getInternalLinkPage()
	{
		if (io::isPositiveInteger($this->_internalLink)) {
			return CMS_tree::getPageByID($this->_internalLink);
		} else {
			return false;
		}
	}
	
	/**
	  * Sets the internal link
	  * Reset the target to "_top"
	  *
	  * @param integer $pageID The DB ID of the page linked
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setInternalLink($pageID)
	{
		$this->_internalLink = $pageID;
		if (SensitiveIO::isPositiveInteger($pageID)) {
			$this->_target = '_top';
		}
		return true;
	}
	
	/**
	  * Gets the URL of the external link
	  *
	  * @return string The URL
	  * @access public
	  */
	public function getExternalLink()
	{
		return $this->_externalLink;
	}
	
	/**
	  * Sets the external link
	  * Reset the target to "_blank"
	  *
	  * @param string $url The url to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setExternalLink($url)
	{
		if (io::substr($url, 0, 4) == "http" 
				|| io::substr($url, 0, 3) == "ftp"
				|| io::substr($url, 0, 6) == "mailto"
				|| io::substr($url, 0, 1) == "/") {
			if ($url != 'http://') {
				$this->_externalLink = $url;
			} else {
				$this->_externalLink = '';
			}
		} elseif ($url) {
			$this->_externalLink = 'http://'.$url;
		}
		if ($url != '') {
			$this->_target = '_blank';
		}
		return true;
	}
	
	
	/**
	  * Gets the URL of a link towards a file managed by this application
	  *
	  * @param boolean $withPath If false, only returns the filename
	  * @param string $module If false, only returns the filename
	  * @param string $dataLocation Where does the data lies ? See CMS_resource constants
	  * @param integer $relativeTo Can be web root or filesystem relative, see base constants
	  * @param boolean $withFilename Should the function return the filename too or only the path ?
	  * @return string The file
	  * @access public
	  */
	public function getFileLink($withPath = false, $module = MOD_STANDARD_CODENAME, $dataLocation = RESOURCE_DATA_LOCATION_EDITED, $relativeTo = PATH_RELATIVETO_WEBROOT, $withFilename = true)
	{
		if ($withPath) {
			if (class_exists("CMS_resource")) {
				if (!SensitiveIO::isInSet($dataLocation, CMS_resource::getAllDataLocations())
					|| $dataLocation == RESOURCE_DATA_LOCATION_DEVNULL) {
					$this->setError("DataLocation not in the valid set : ".$dataLocation);
					return false;
				}
			} else {
				$dataLocation = RESOURCE_DATA_LOCATION_PUBLIC;
			}
			// Prepare module folder name
			$module = ($module != '') ? $module.'/' : '' ;
			// Prepare full path
			switch ($relativeTo) {
			case PATH_RELATIVETO_WEBROOT:
				$path = PATH_MODULES_FILES_WR."/".$module.$dataLocation;
				break;
			case PATH_RELATIVETO_FILESYSTEM:
				$path = PATH_MODULES_FILES_FS."/".$module.$dataLocation;
				break;
			}
			if ($withFilename) {
				return $path . "/" . $this->_fileLink;
			} else {
				return $path;
			}
		} else {
			return $this->_fileLink;
		}
	}
	
	/**
	  * Sets the link to a file
	  * Reset the target to "_blank"
	  *
	  * @param string $s, The link to set (filename only or full location)
	  * @param string $module, the module codename owning this file
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setFileLink($s, $module = '')
	{
		$this->_fileLink = $s;
		if ($s != '') {
			$this->_target = '_blank';
		}
		if ($module != '') {
			$this->_moduleCodename = $module;
		}
		return true;
	}
	
	/**
	  * Get : All the attributes
	  *
	  * @return array(key=>value)
	  * @access public
	  */
	public function getAttributes()
	{
		return $this->_attributes;
	}
	
	/**
	  * Get all attributes as a string
	  *
	  * @return string all attribute ready to be inserted int oa A XHTML tag
	  * @access public
	  */
	public function getAttributesString()
	{
		$s = '';
		if (is_array($this->_attributes) && $this->_attributes) {
			reset($this->_attributes);
			while (list($k, $v) = each($this->_attributes)) {
				$s .= ' '.$k.'="'.$v.'"';
			}
		}
		return $s;
	}
	
	/**
	  * Set : The attributes
	  *
	  * @param array(key=>value) $attrs
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setAttributes($attrs)
	{
		if (is_array($attrs)) {
			$this->_attributes = $attrs;
			return true;
		}
		$this->setError("Bad attributes array given, not an array");
		return false;
	}
	
	/**
	  * Get : an attribute from array
	  *
	  * @param string $k,  The key of wanted attribute
	  * @return string, the value corresponding to key
	  * @access public
	  */
	public function getAttribute($k)
	{
		return $this->_attributes[io::strtolower($k)];
	}
	
	/**
	  * Set : an attribute
	  *
	  * @param string $k,  The key of wanted attribute
	  * @param string $v, the value corresponding to key
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setAttribute($k, $v)
	{
		$this->_attributes[io::strtolower($k)] = str_replace('"', "", io::strtolower($v));
		return true;
	}
	
	
	/**
	  * Get : an attribute from array
	  *
	  * @return array()
	  * @access public
	  */
	public function getPopup()
	{
		return $this->_popup;
	}
	
	/**
	  * Set : an attribute
	  *
	  * @param integer $width, window width to open
	  * @param integer $height, window height to open
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setPopup($width, $height)
	{
		$this->_popup['width'] = (int) $width;
		$this->_popup['height'] = (int) $height;
		return true;
	}
	
	/**
	  * Get : a full XHTML a tag
	  *
	  * @param string $module If false, only returns the filename
	  * @param string $dataLocation Where does the data lies ? @see CMS_resource constants
	  * @param string $attrs, any attributes to append into A tag 
	  * @return string, the XHTML Tag
	  * @access public
	  */
	public function getHTML($label=false, $module = MOD_STANDARD_CODENAME, $dataLocation = RESOURCE_DATA_LOCATION_EDITED, $attrs = false, $hrefOnly = false)
	{
		if ($label) {
			$this->_label = $label;
		}
		// Building href
		$s = '';
		$href = '';
		$onClick = '';
		switch ($this->_linkType) {
		case RESOURCE_LINK_TYPE_INTERNAL:
			// Get internal page URL
			switch ($dataLocation) {
				case RESOURCE_DATA_LOCATION_PUBLIC:
				case RESOURCE_DATA_LOCATION_EDITED:
				default:
					if (sensitiveIO::isPositiveInteger($this->_internalLink) && $href = CMS_tree::getPageValue($this->_internalLink, 'url')) {
						$href = ((PATH_PAGES_WR && strpos($href,PATH_PAGES_WR) !== false) || stripos($href,'http') !== false) ? $href : PATH_PAGES_WR.$href;
					}
					break;
			}
			// Set a popup link, not a trivial link
			if (isset($this->_popup['width']) && isset($this->_popup['height']) && $this->_popup['width'] > 0 && $this->_popup['height'] > 0) {
				$onClick = "javascript:CMS_openPopUpPage('".$href."', 'popup_page', ".$this->_popup['width'].", ".$this->_popup['height'].");return false;";
			}
			break;
		case RESOURCE_LINK_TYPE_EXTERNAL:
			$href = io::htmlspecialchars($this->_externalLink);
			$href = str_replace('&amp;', '&', $href);
			if (strtolower(substr($href, 0, 4)) != 'http') {
				$href = 'http://'.$href;
			}
			// Set a popup link, not a trivial link
			if (isset($this->_popup['width']) && $this->_popup['width'] > 0 && isset($this->_popup['height']) && $this->_popup['height'] > 0) {
				$onClick = "javascript:CMS_openPopUpPage('".$href."', 'external', ".$this->_popup['width'].", ".$this->_popup['height'].");return false;";
			}
			break;
		case RESOURCE_LINK_TYPE_FILE:
			if (is_file($this->getFileLink(true, $module, $dataLocation, PATH_RELATIVETO_FILESYSTEM))) {
				$href = $this->getFileLink(true, $module, $dataLocation, PATH_RELATIVETO_WEBROOT);
				// Set a popup link, not a trivial link
				if (isset($this->_popup['width']) && $this->_popup['width'] > 0 && isset($this->_popup['height']) && $this->_popup['height'] > 0) {
					$onClick = "javascript:CMS_openPopUpPage('".$href."', 'file', ".$this->_popup['width'].", ".$this->_popup['height'].");return false;";
				}
			}
			break;
		}
		if ($hrefOnly) {
			return $href;
		}
		if ($this->_target) {
			$target = ' target="'.$this->_target.'"';
		}
		// Get onClick
		if ($onClick != '') {
			$onClick = ' onClick="'.$onClick.'"';
		}
		// Return Link
		if (trim($href) != '') {
			if (!$attrs) {
				$attrs = $this->getAttributesString();
			}
			$attrs = ' '.trim($attrs);
			$s = '<a href="'.$href.'"'.$onClick.$target.$attrs.'>'.$this->_label.'</a>';
		}
		return $s;
	}
	
	/**
	  * Checks the presence of a valid HREF in this link definition
	  *
	  * @return boolean true if good href found
	  * @access public
	  */
	public function hasValidHREF()
	{
		switch ($this->_linkType) {
		case RESOURCE_LINK_TYPE_INTERNAL:
			if ($this->_internalLink == '') {
				return false;
			}
			break;
		case RESOURCE_LINK_TYPE_EXTERNAL:
			if	($this->_externalLink == 'http://' || $this->_externalLink == '' || !@parse_url($this->_externalLink)) {
				return false;
			}
			break;
		case RESOURCE_LINK_TYPE_FILE:
			if	($this->_fileLink == '') {
				return false;
			}
			break;
		default:
			if ($this->_linkType <= 0) {
				return false;
			}
			break;
		}
		return true;
	}
}
?>