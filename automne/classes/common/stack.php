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
// $Id: stack.php,v 1.3 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class CMS_stack
  *
  * Manages a stack. This stack is usually recorded into DB as a string
  * and consists of a non-sorted stack of arrays.
  * The arrays contains one or two values. It is decided when looking at the text definition
  * or when adding the first element.
  * The text definition format is : 
  *   "key1,value1;key2,value2" for two-elements stacks
  *   "value1;value2" for one-elements stacks
  *----------------------------------------------------------
  * TODO : Completely remove this class from Automne
  * This is a relicat from Automne v1 and this kind of data management is a pain in the ass but it is used in all oldest class
  * Using native array functions of PHP is much more simple and fast.
  * Seb
  *
  * @package Automne
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

 class CMS_stack extends CMS_grandFather {
	/**
	  * Number of values in the arrays
	  * @var boolean
	  * @access private
	  */
	protected $_valuesByAtom = 2;
	
	/**
	  * Stack elements
	  * @var array(miwed=>mixed)
	  * @access private
	  */
	protected $_elements = array();
	
	/**
	  * Get the text definition.
	  *
	  * @return string The text definition based on the current elements
	  * @access public
	  */
	function getTextDefinition()
	{
		$text = '';
		foreach ($this->_elements as $atom) {
			$text .= $atom[0];
			if ($this->_valuesByAtom == 2) {
				$text .= "," . $atom[1];
			}
			$text .= ";";
		}
		$text = io::substr($text, 0, -1);
		return $text;
	}
	
	/**
	  * Sets the text definition.
	  * The string format is : 
	  *   "key1,value1;key2,value2" for two-values arrays
	  *   "value1;value2" for one-value arrays
	  *
	  * @param string $text The text definition. 
	  * @return boolean false on malformed string, true else.
	  * @access private
	  */
	function setTextDefinition($text)
	{
		$text = trim($text);
		if ($text) {
			$this->emptyStack();
			$atomsCount = preg_match_all("#([^,;]+)\,?([^,;]*)#", $text , $atoms);
			if (sizeof($atoms[1]) != $atomsCount || sizeof($atoms[2]) != $atomsCount) {
				$this->raiseError('Stack malformed : feeded with mixed one-value and two-values definition text');
				return false;
			} else {
				//guess the number of values by atom
				$this->_valuesByAtom = ($atoms[2][0] === '') ? 1 : 2;
				foreach ($atoms[1] as $k => $v) {
					$this->_elements[] = ($this->_valuesByAtom == 2) ? array($v, $atoms[2][$k]) : array($v);
				}
			}
		}
		return true;
	}
	
	/**
	  * Adds an element to the array
	  *
	  * @param mixed $value1 The mandatory value
	  * @param mixed $value2 The optional value. Will be ignored if the stack is mono-value
	  * @return void
	  * @access public
	  */
	function add($value1, $value2 = false)
	{
		//if stack is empty, we must analyse this element to know if it's a one- or two-values stack
		if (!$this->_elements) {
			$this->_valuesByAtom = ($value2 === false) ? 1 : 2;
		}
		if ($this->_valuesByAtom == 2) {
			$this->_elements[] = array($value1, $value2);
		} else {
			$this->_elements[] = array($value1);
		}
	}
	
	/**
	  * Deletes an element off the array
	  *
	  * @param mixed $value1 The mandatory value we're looking to remove.
	  * @param mixed $value2 The optional value of the element we're looking to remove. Will be ignored if it's a one-value stack.
	  * @return void
	  * @access public
	  */
	function del($value1, $value2 = false)
	{
		if ($this->_valuesByAtom == 2) {
			$tobedeleted = array($value1, $value2);
		} else {
			$tobedeleted = array($value1);
		}
		
		$newElements = array();
		foreach ($this->_elements as $atom) {
			if ($atom != $tobedeleted) {
				$newElements[] = $atom;
			}
		}
		$this->_elements = $newElements;
	}
	
	/**
	  * Deletes an element off the array that have the given key (at the first position)
	  *
	  * @param mixed $key The key we're looking to remove.
	  * @return void
	  * @access public
	  */
	function delAllWithOneKey($key)
	{
		$newElements = array();
		foreach ($this->_elements as $atom) {
			if ($atom[0] != $key) {
				$newElements[] = $atom;
			}
		}
		$this->_elements = $newElements;
	}
	
	/**
	  * Deletes all the elements off the array that have the given value at the position given.
	  *
	  * @param mixed $value The value we're looking to remove.
	  * @param integer $position The position of the value we're looking to remove. Can be 1 or 2.
	  * @return void
	  * @access public
	  */
	function delAllWithOneValue($value, $position)
	{
		$newElements = array();
		foreach ($this->_elements as $atom) {
			if ($atom[$position - 1] != $value) {
				$newElements[] = $atom;
			}
		}
		$this->_elements = $newElements;
	}
	
	/**
	  * Gets all the elements of the array.
	  *
	  * @return array(array(mixed=>mixed)) the elements of the stack.
	  * @access public
	  */
	function getElements()
	{
		return $this->_elements;
	}
	
	/**
	  * Gets a value of first element corresponding to given key
	  *
	  * @param mixed $key The key we're looking for value
	  * @return mixed, the value of the stack matching the key given
	  * @access public
	  */
	function getElementValueFromKey($key)
	{
		foreach ($this->_elements as $element) {
			if ($element[0] == $key) {
				return $element[1];
			}
		}
		return false;
	}
	
	/**
	  * Gets all the elements of the array with the value given as the first or second value (depends of the position).
	  *
	  * @param mixed $value The value we search for
	  * @param integer $position The position of the value in the array (1 or 2)
	  * @return array(array(mixed=>mixed)) the elements of the stack matching the value at the position.
	  * @access public
	  */
	function getElementsWithOneValue($value, $position)
	{
		$elts = array();
		foreach ($this->_elements as $element) {
			if ($element[$position - 1] == $value) {
				$elts[] = $element;
			}
		}
		return $elts;
	}
	
	/**
	  * Empties the stack.
	  *
	  * @return void
	  * @access public
	  */
	function emptyStack()
	{
		$this->_elements = array();
		$this->_valuesByAtom = 2;
	}
	
	/**
	  * Sets values by atom.
	  *
	  * @param integer
	  * @return void
	  * @access public
	  */
	function setValuesByAtom($nElem)
	{
		$this->_valuesByAtom = $nElem;
	}
	
	/**
	  * Gets values by atom.
	  *
	  * @return integer
	  * @access public
	  */
	function getValuesByAtom()
	{
		return $this->_valuesByAtom;
	}
}
?>