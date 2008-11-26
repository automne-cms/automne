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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: action.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_action
  *
  * Utility class : used to show an action inside a pack,  which are post forms
  *
  * @package CMS
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_action extends CMS_grandFather
{
	/**
	  * Action label
	  *
	  * @var string
	  * @access private
	  */
	protected $_label = '';
	
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
	function __construct($label, $action)
	{
		$this->_label = $label;
		$this->_formAction = $action;
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
	
	function getContent($class="admin")
	{
		//create a random name (useful for onSubmit purposes among other)
		$form_name = md5(mt_rand());
		$onSubmit='0';
		$method = (isset($this->_formAttributes["method"])) ? $this->_formAttributes["method"] : "post";
		if ($method!='post') {
			$onSubmit='1';
		}
		$content = '<form name="'.$form_name.'" method="'.$method.'" action="' .$this->_formAction. '" ';
		
		foreach ($this->_formAttributes as $name => $value) {
			if ($name != "method" && $name != "onSubmit" && $name != "onsubmit" && $name != "target") {
				$content .= $name . '="' . htmlspecialchars($value) . '" ';
			}
			if ($name == "onSubmit" || $name == "onsubmit") {
				$content .= $name . '="' . htmlspecialchars($value) . '" ';
				$onSubmit='1';
			}
			if ($name == "target") {
				if ($value=="_blank") {
					$onSubmit='1';
				}
				$content .= $name . '="' . htmlspecialchars($value) . '" ';
			}
		}
		if (!$onSubmit) {
			$content .= ' onSubmit="check();" ';
		}
		$content .= '><tr>';
		foreach ($this->_formHiddens as $name=>$value) {
			$value = str_replace("\n", "", $value);
			$value = str_replace("\r", "", $value);
			$value = htmlspecialchars($value);
			$content .= '<input type="hidden" name="' .$name. '" value="' .$value. '" />';
		}
		$content .= '<td class="'.$class.'" align="center">';
		foreach ($this->_formTexts as $name=>$textArray) {
			$value= $textArray["value"];
			$size= $textArray["size"];
			$code= $textArray["code"];
			$value = str_replace("\n", "", $value);
			$value = str_replace("\r", "", $value);
			$value = htmlspecialchars($value);
			$content .= SensitiveIO::arraySprintf($code, array('<input type="text" class="admin_input_text" name="' .$name. '" value="' .$value. '" size="' .$size. '" />'));
		}
		$content .= '<input type="submit" class="admin_input_'.$class.'" value="' .$this->_label. '" style="width:130px" /></td>
			</tr>
			</form>
		';
		
		return $content;
	}
}

?>