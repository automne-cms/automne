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
// $Id: date.php,v 1.5 2010/03/08 16:43:27 sebastien Exp $

/**
  * Class CMS_date
  *
  * Manages a date representation. Such instances can be fed with DB dates (MySQL for now), or 
  * with its elements separately (month, day, year, ...), or with a date expressed with its format.
  * The format permits to return or set the date in the preferred user format.
  * The stereotype formats are the same that the date() function, and typically are :
  *   "m/d/Y" for english dates
  *   "d/m/Y" for french dates
  *
  * @package Automne
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class CMS_date extends CMS_grandFather
{
	/**
	  * day part
	  * @var string
	  * @access private
	  */
	protected $_day = "00";

	/**
	  * month part
	  * @var string
	  * @access private
	  */
	protected $_month = "00";

	/**
	  * year part
	  * @var string
	  * @access private
	  */
	protected $_year = "0000";

	/**
	  * hour part
	  * @var string
	  * @access private
	  */
	protected $_hour = "00";

	/**
	  * minutes part
	  * @var string
	  * @access private
	  */
	protected $_minutes = "00";

	/**
	  * seconds part
	  * @var string
	  * @access private
	  */
	protected $_seconds = "00";

	/**
	  * date() function format
	  * @var string
	  * @access private
	  */
	protected $_format="m/d/Y";
	
	
	/**
	  * Fills a DB datetime field
	  *
	  * @param boolean $dateOnly Set to true if you don't want the time
	  * @return string the value needed by MySQL for a datetime field
	  * @access public
	  */
	function getDBValue($dateOnly = false)
	{
		$value = $this->_year."-".$this->_month."-".$this->_day;
		if (!$dateOnly && ($this->_hour || $this->_minutes || $this->_seconds)) {
			$value .= " ".$this->_hour.":".$this->_minutes.":".$this->_seconds;
		}
		return $value;
	}
	
	/**
	  * Initialize the date with a value picked from a MySQL datetime field : yyyy-mm-dd hh:mm:ss
	  *
	  * @param string $value a MySQL datetime field
	  * @return void
	  * @access public
	  */
	function setFromDBValue($value)
	{
		$this->_year = $this->_fillWithZeros(io::substr($value, 0, 4), 4);
		$this->_month = $this->_fillWithZeros(io::substr($value, 5, 2), 2);
		$this->_day = $this->_fillWithZeros(io::substr($value, 8, 2), 2);
		$this->_hour = $this->_fillWithZeros(io::substr($value, 11, 2), 2);
		$this->_minutes = $this->_fillWithZeros(io::substr($value, 14, 2), 2);
		$this->_seconds = $this->_fillWithZeros(io::substr($value, 17, 2), 2);
	}
	
	/**
	  * Get the formatted date
	  *
	  * @param string $format Optional format if not already set
	  * @return string the date value formatted for user viewing according to the language format
	  * @access public
	  */
	function getLocalizedDate($format = false)
	{
		if ($format) {
			$this->_format = $format;
		}
		$ts = $this->getTimeStamp();
		if (!$this->isNull()) {
			return date($this->_format, $ts);
		} else {
			return false;
		}
	}
	
	/**
	  * Sets the value from a formatted date
	  *
	  * @param string $date The date formatted with the current format
	  * @param boolean $canBeNull If set to true, the function won't complain if the date is set to a null value
	  * @return boolean true is successful to set it
	  * @access public
	  */
	function setLocalizedDate($date, $canBeNull = false)
	{
	
		if (!$this->_format) {
			$this->raiseError("Format not set");
			return false;
		}
		if (!$date) {
			if ($canBeNull) {
				$this->_day = $this->_month = $this->_hours = $this->_minutes = $this->_seconds = "00";
				$this->_year = "0000";
				return true;
			} else {
				$this->raiseError("Date null");
				return false;
			}
		}
		
		//analyse format
		$year_found = 0;
		switch (io::substr($this->_format, 0, 1)) {
		case "d":
			$day_pos = 0;
			break;
		case "m":
			$month_pos = 0;
			break;
		case "Y":
			$year_pos = 0;
			$year_found = 1;
			break;
		}
		switch (io::substr($this->_format, 2, 1)) {
		case "d":
			$day_pos = 3 + $year_found * 2;
			break;
		case "m":
			$month_pos = 3 + $year_found * 2;
			break;
		case "Y":
			$year_pos = 3;
			$year_found = 1;
			break;
		}
		switch (io::substr($this->_format, 4, 1)) {
		case "d":
			$day_pos = 6 + $year_found * 2;
			break;
		case "m":
			$month_pos = 6 + $year_found * 2;
			break;
		case "Y":
			$year_pos = 6;
			break;
		}

		return 	$this->setDay(io::substr($date, $day_pos, 2))
				&& $this->setMonth(io::substr($date, $month_pos, 2))
				&& $this->setYear(io::substr($date, $year_pos, 4));
	}
	
	/**
	  * Gets the unix timestamp for the date
	  *
	  * @return string the unix timestamp for the date
	  * @access public
	  */
	function getTimestamp()
	{
		$year = ($this->_year == '0000') ? '70' : $this->_year;
		return mktime($this->_hour, $this->_minutes, $this->_seconds, $this->_month, $this->_day, $year);
	}
	
	/**
	  * Gets the Year part
	  *
	  * @return string the year, 0-left-filled to 4 chars
	  * @access public
	  */
	function getYear()
	{
		return $this->_year;
	}
	
	/**
	  * Sets the year part of the date
	  *
	  * @param string $value the year to set to
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setYear($value)
	{
		if(!ctype_digit((string) $value)){
			$this->_raiseError(__CLASS__.' : '.__FUNCTION__.' : value must be numeric : '.$value);
			return false;
		}
		//$value = $this->_fillWithZeros($value, 4);
		$value = (int) $value;
		if ($value < 100) {
			$value += ($value > 30) ? 1900 : 2000;
		}
		if (!$value || io::strlen((string) $value) != 4) {
			$this->_raiseError("Date : incorrect year : ".$value);
			return false;
		} else {
			$this->_year = $value;
			return true;
		}
	}
	
	/**
	  * Returns the Month part
	  *
	  * @return string the month, 0-left-filled to 2 chars
	  * @access public
	  */
	function getMonth()
	{
		return $this->_month;
	}
	
	/**
	  * Sets the month part of the date
	  *
	  * @param string $value the month to set to
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setMonth($value)
	{
		if(!ctype_digit((string) $value)){
			$this->raiseError('Value must be numeric : '.$value);
			return false;
  	    }
		$m = $this->_fillWithZeros($value, 2);
		if ($m === false || $m > 12) {
			$this->raiseError("Incorrect month : ".$value);
			return false;
		} else {
			$this->_month = $m;
			return true;
		}
	}
	
	/**
	  * Gets the Week part
	  *
	  * @return string the week
	  * @access public
	  */
	function getWeek()
	{
		return date("W",$this->getTimestamp());
	}
	
	/**
	  * Gets the Week day (0 to 6 value : 0 for sunday, 6 for saturday)
	  *
	  * @return string the day of the week
	  * @access public
	  */
	function getDayOfWeek()
	{
		return date("w",$this->getTimestamp());
	}
	
	/**
	  * Gets the day part
	  *
	  * @return string the day, 0-left-filled to 2 chars
	  * @access public
	  */
	function getDay()
	{
		return $this->_day;
	}
	
	/**
	  * Sets the day part of the date
	  *
	  * @param string $value the day to set to
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setDay($value)
	{
		if(!ctype_digit((string) $value)){
			$this->raiseError('Value must be numeric : '.$value);
			return false;
		}
		$d = $this->_fillWithZeros($value, 2);
		if ($d === false || $d > 31) {
			$this->raiseError("Incorrect day : ".$value);
			return false;
		} else {
			$this->_day = $d;
			return true;
		}
	}
	
	/**
	  * Gets the hour part
	  *
	  * @return string the hour, 0-left-filled to 2 chars
	  * @access public
	  */
	function getHour()
	{
		return  $this->_fillWithZeros($this->_hour,2);
	}
	
	/**
	  * Sets the hour part of the date
	  *
	  * @param string $value the hour to set to
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setHour($value)
	{
		$h = $this->_fillWithZeros($value, 2);
		if ($h === false || $h > 23) {
			$this->raiseError("Incorrect hour : ".$value);
			return false;
		} else {
			$this->_hour = $h;
			return true;
		}
	}
	
	/**
	  * Gets the minutes part
	  *
	  * @return string the minutes, 0-left-filled to 2 chars
	  * @access public
	  */
	function getMinute()
	{
		return $this->_fillWithZeros($this->_minutes,2);
	}
	
	/**
	  * Sets the minute part of the date
	  *
	  * @param string $value the minute to set to
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setMinute($value)
	{
		$m = $this->_fillWithZeros($value, 2);
		if ($m === false || $m > 59) {
			$this->raiseError("Incorrect minute : ".$value);
			return false;
		} else {
			$this->_minutes = $m;
			return true;
		}
	}
	
	/**
	  * Gets the seconds part
	  *
	  * @return string the seconds, 0-left-filled to 2 chars
	  * @access public
	  */
	function getSecond()
	{
		return $this->_fillWithZeros($this->_seconds,2);
	}
	
	/**
	  * Sets the seconds part of the date
	  *
	  * @param string $value the seconds to set to
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setSecond($value)
	{
		$s = $this->_fillWithZeros($value, 2);
		if ($s === false || $s > 59) {
			$this->raiseError("Incorrect seconds : ".$value);
			return false;
		} else {
			$this->_seconds = $s;
			return true;
		}
	}
	
	/**
	  * Sets the date to now
	  *
	  * @param boolean $dateOnly Set to true if you don't want to set the time
	  * @return void
	  * @access public
	  */
	function setNow($dateOnly = false)
	{
		$now = time();
		if (!$dateOnly) {
			$this->_hour = date("H", $now);
			$this->_minutes = date("i", $now);
			$this->_seconds = date("s", $now);
		}
		$this->_day = date("d", $now);
		$this->_month = date("m", $now);
		$this->_year = date("Y", $now);
	}
	
	/**
	  * Sets the date localized version format
	  *
	  * @param string $format The format to set. No check is done on it.
	  * @return void
	  * @access public
	  */
	function setFormat($format)
	{
		$this->_format = $format;
	}
	
	/**
	  * Is the date null ? 0000-00-00 is a null date.
	  *
	  * @return boolean
	  * @access public
	  */
	function isNull()
	{
		//return $this->getTimestamp() <= 1; //bugy with dates before 01/01/1970 (unix timestamp start)
		return !((int) $this->_day && (int) $this->_month && (int) $this->_year);
	}
	
	/**
	  * Left-fills a string with zeros
	  *
	  * @param string $value the data to left-fill
	  * @param integer $length the length to fill to
	  * @return mixed false if length of value is greater than the desired length, the filled or untouched string otherwise
	  * @access private
	  */
	protected function _fillWithZeros($value, $length)
	{
		return sprintf("%0".$length."s", $value);
	}
	
	/**
	  * Compares two dates using the given operator.
	  * Static function.
	  *
	  * @param CMS_date $date1 The leftmost date of the comparison
	  * @param CMS_date $date2 The rightmost date of the comparison
	  * @param string $operator the comparison operator. Can be one of ==,>=,>,<=,<
	  * @return boolean true if the comparison is true, false otherwise
	  * @access public
	  */
	static function compare($date1, $date2, $operator)
	{
		$allowed_operators = array("==", ">=", ">", "<", "<=");
		if (SensitiveIO::isInSet($operator, $allowed_operators)) {
			$func_body = sprintf('if (%s %s %s) { return true ; } else { return false ; }',
							$date1->getTimestamp(), $operator, $date2->getTimestamp()) ;
			$func = create_function('', $func_body);
			if (!$func) {
				return false;
			}
			return $func();
		} else {
			return false;
		}
	}
	
	/**
	  * move a CMS_date to a given value
	  *
	  * @param $moveTo string : valid PHP strtotime() function parameter (see www.php.net for more)
	  * 
	  * @return cms_date object moved
	  */
	function moveDate($moveTo)
	{
		if ($this->isNull()) {
			$this->raiseError("Can't move a null date");
			return false;
		}
		$timestamp = $this->getTimestamp();
		$movedTimestamp = strtotime($moveTo, $timestamp);
		if ($movedTimestamp === -1) {
			$this->raiseError("Invalid moveTo parameter, need to be a valid PHP strtotime() function parameter (see www.php.net for more)");
			return false;
		} else {
			$this->setFromDBValue(date('Y-m-d H:i:s',$movedTimestamp));
			return true;
		}
	}
}

?>