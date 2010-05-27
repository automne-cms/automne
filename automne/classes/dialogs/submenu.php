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
//
// $Id: submenu.php,v 1.3 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_subMenu
  *
  * Utility class : used to show a subMenu inside a pack,  which are post forms
  *
  * @package Automne
  * @subpackage common
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_subMenu extends CMS_grandFather
{
	/**
	  * Action label
	  *
	  * @var string
	  * @access private
	  */
	protected $_label = '';
	
	/**
	  * Icon filename
	  *
	  * @var string
	  * @access private
	  */
	protected $_picto = '';
	
	/**
	  * Action attribute of the form
	  *
	  * @var string
	  * @access private
	  */
	protected $_formAction = '';
	
	/**
	  * Array of hidden inputs
	  *
	  * @var array(string=>string) The hiddens indexed by name and with the value as array value
	  * @access private
	  */
	protected $_formHiddens = array();
	
	/**
	  * Array of text inputs
	  *
	  * @var array(string=>array("value"=>$value,"size"=>$size)) The text indexed by name and with the value and size as array value
	  * @access private
	  */
	protected $_formTexts = array();
	
	/**
	  * Array of form attributes
	  *
	  * @var array(string=>string) The attributes indexed by name and with the value as array value
	  * @access private
	  */
	protected $_formAttributes = array();
	
	
	/**
	  * Constructor.
	  * Initializes the action with its label and form action
	  *
	  * @param string $label The button label
	  * @param string $action The form action atribute
	  * @return void
	  * @access public
	  */
	function __construct($label, $action, $picto=false)
	{
		$this->_label = $label;
		$this->_formAction = $action;
		$this->_picto = $picto;
	}
	
	function addHidden($name, $value)
	{
		$this->_formHiddens[$name] = $value;
	}
	
	function addText($name, $value='', $size='30', $arroundCode='')
	{
		$this->_formTexts[$name] = array("value"=>$value, "size"=>$size, "code"=>$arroundCode);
	}
	
	function addAttribute($name, $value)
	{
		$this->_formAttributes[$name] = $value;
	}
	
	function getContent($type='menu')
	{
		//create a random name (useful for onSubmit purposes among other)
		$form_name = md5(mt_rand());
		$onSubmit='0';
		$method = (isset($this->_formAttributes["method"])) ? $this->_formAttributes["method"] : "post";
		if ($method!='post') {
			$onSubmit='1';
		}
		if ($type=='DHTML' || $type=='popup') {
			$content = '<tr><td width="100%" height="34" valign="top" nowrap="nowrap">';
		} else {
			$content = '<td width="34" height="35" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" valign="center" align="center">';
		}
		$content .= '<form name="'.$form_name.'" method="'.$method.'" action="' .$this->_formAction. '" ';
		foreach ($this->_formAttributes as $name => $value) {
			if ($name != "method" && $name != "onSubmit" && $name != "onsubmit" && $name != "target") {
				$content .= $name . '="' . io::htmlspecialchars($value) . '" ';
			}
			if ($name == "onSubmit" || $name == "onsubmit") {
				$content .= $name . '="' . io::htmlspecialchars($value) . '" ';
				$onSubmit='1';
			}
			if ($name == "target") {
				if ($value=="_blank") {
					$onSubmit='1';
				}
				$content .= $name . '="' . io::htmlspecialchars($value) . '" ';
			}
		}
		if (!$onSubmit && $type != 'popup') {
			$content .= ' onSubmit="check();" ';
		}
		$content .= '>';
		foreach ($this->_formHiddens as $name=>$value) {
			$value = str_replace("\n", "", $value);
			$value = str_replace("\r", "", $value);
			$value = io::htmlspecialchars($value);
			$content .= '<input type="hidden" name="' .$name. '" value="' .$value. '" />';
		}
		
		
		foreach ($this->_formTexts as $name=>$textArray) {
			$value= $textArray["value"];
			$size= $textArray["size"];
			$code= $textArray["code"];
			$replace = array(
				"\n" => '',
				"\r" => ''
			);
			$value = str_replace(array_keys($replace),$replace, $value);
			$value = htmlspecialchars($value);
			$content .= SensitiveIO::arraySprintf($code, array('<input type="text" class="admin_input_text" name="' .$name. '" value="' .$value. '" size="' .$size. '" />'));
		}
		if ($type=='DHTML' || $type=='popup') {
			if ($this->_picto) {
				$content .='<input align="absmiddle" type="image" src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/'.$this->_picto.'" alt="' .$this->_label. '" title="' .$this->_label. '" value="' .$this->_label. '" /><input type="submit" onMouseOver="this.style.backgroundColor=\'#D0CBCA\';" onMouseOut="this.style.backgroundColor=\'#FFFFFF\';" class="CMS_dhtml_input_submit" value="' .$this->_label. '" />';
			} else {
				$content .='<input type="submit" class="admin_input_submit" value="' .$this->_label. '" style="width:130px" />';
			}
		} else {
			if ($this->_picto) {
				$content .='<input type="image" src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/'.$this->_picto.'" alt="' .$this->_label. '" title="' .$this->_label. '" value="' .$this->_label. '" />';
			} else {
				$content .='<input type="submit" class="admin_input_submit" value="' .$this->_label. '" style="width:130px" />';
			}
		}
		
		if ($type=='DHTML' || $type=='popup') {
				$content .= '</form></td></tr>';
		} else {
				$content .= '</form></td>';
		}
		
		
		return $content;
	}
}

?>