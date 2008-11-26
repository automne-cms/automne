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
// | Authors: Antoine Pouch <antoine.pouch@ws-interactive.fr>             |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: sensitiveio.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class SensitiveIO
  *
  * Collection of static methods used to validate user input and output
  *
  * @package CMS
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Tomas V.V.Cox <cox@idecnet.com> (For isValidEmail())
  * @author Pierre-Alain Joye <pajoye@phpindex.com> (For isValidEmail())
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class SensitiveIO extends CMS_grandfather
{
	/**
	  * Filter request input
	  * Static method.
	  *
	  * @param string $name The request name to filter
	  * @param mixed $filter The filter to use. Can be :
	  *		- a string of a function name or static object method (class::method) to use for the check (must return true / false)
	  *		- a string for a regular expression to validate with preg_match
	  *		- an array of possible values (case sensitive)
	  *		- nothin, in this case, the request value is returned as it (if it exists)
	  * @param mixed $default The default value to return if request is empty or does not match the filter rule (default : false)
	  * @return mixed : the original value if it pass the filter or boolean false otherwise
	  * @access public
	  */
	function request($name, $filter = '', $default = false) {
		if (!isset($_REQUEST[$name])) {
			return $default;
		}
		if (is_string($filter)) {
			if ($filter == '') { //no filter set, just return request value
				return $_REQUEST[$name];
			} elseif (is_callable($filter, true)) {//check if function/method name exists
				if (strpos($filter, '::') !== false) {//static method call
					$method = explode('::', $filter);
					return (call_user_func(array($method[0], $method[1]), $_REQUEST[$name]) ? $_REQUEST[$name] : $default);
				} elseif(call_user_func($filter, $_REQUEST[$name])) { //function call
					return $_REQUEST[$name];
				} else {
					return $default;
				}
			} elseif (preg_match($filter, $_REQUEST[$name])) { //else assume this is a regexp pattern to check
				return $_REQUEST[$name];
			}
		} elseif(is_array($filter)) {
			if (in_array($_REQUEST[$name], $filter)) {
				return $_REQUEST[$name];
			}
		}
		return $default;
	}

	/**
	  * Unset request input
	  * Static method.
	  *
	  * @param string/array $requests The request(s) name to unset
	  * @return void
	  * @access public
	  */
	function unsetRequest($requests) {
		if (!is_array($requests)) {
			$requests = array($requests);
		}
		foreach ($requests as $request) {
			if (isset($_POST[$request])) {
				unset($_POST[$request]);
			}
			if (isset($_GET[$request])) {
				unset($_GET[$request]);
			}
			if (isset($_REQUEST[$request])) {
				unset($_REQUEST[$request]);
			}
		}
	}

	/**
	  * Tests the input to see if it is a positive integer.
	  * Static method.
	  *
	  * @param mixed $input The sensitive input
	  * @return boolean true if the input is a positive integer, false otherwise
	  * @access public
	  */
	function isPositiveInteger($input) {
		return (is_numeric($input) && $input > 0 && (int)$input == $input);
	}

	/**
	  * Tests the input to see if it is part of a given set of values.
	  * Static method.
	  *
	  * @param mixed $input The sensitive input.
	  * @param array(mixed) $set The set the input should be part of
	  * @return boolean true if the input is part of the set, false otherwise
	  * @access public
	  */
	function isInSet($input, $set) {
		return (is_array($set) && in_array($input, $set));
	}

	/**
	  * Cleans a string that is to be put into a SQL query.
	  * Actually, only escapes single quotes that are not already escaped.
	  * Static method.
	  *
	  * @param mixed $input The sensitive input.
	  * @return string the sanitized string
	  * @access public
	  */
	function sanitizeSQLString($input) {
		return CMS_query::echap($input);
	}

	/**
	  * Cleans a string that must not contain php opening and closing tags
	  * Static method.
	  *
	  * @param mixed $input The sensitive input.
	  * @return string the sanitized string
	  * @access public
	  */
	function stripPHPTags($input) {
		return str_replace(array("<?php", "<?", "?>"), "", $input);
	}

	/**
	  * Cleans a string that is to be put echoed to the user.
	  * Actually, only escapes HTML entities.
	  * Static method.
	  *
	  * @param mixed $input The sensitive input.
	  * @return string the sanitized string
	  * @access public
	  */
	function sanitizeHTMLString($input) {
		return htmlspecialchars($input);
	}

	/**
	  * Cleans a string containing other thing than [a..zA..Z0..9_-]
	  * but translates spaces to _ and accentuated chars to their non-accentuated counterpart before.
	  * Static method.
	  *
	  * @param mixed $input The sensitive input.
	  * @return string the sanitized string
	  * @access public
	  */
	function sanitizeAsciiString($input) {
		$sanitized = strtr($input, " ÀÁÂÃÄÅÆàáâãäåæÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñÞßÿý",
								   "_AAAAAAAaaaaaaaOOOOOOOooooooEEEEeeeeeCceIIIIiiiiUUUUuuuuNntsyy");
		$sanitized = preg_replace("#[^[a-zA-Z0-9_.-]]*#", "", $sanitized);
		return $sanitized;
	}

	/**
	  * Cleans a string containing other thing than [a..z0..9-]
	  * Translates spaces to - and accentuated chars to their non-accentuated counterpart before.
	  * Then lower the case of the sring
	  * Static method.
	  *
	  * @param mixed $input The sensitive input.
	  * @return string the sanitized string
	  * @access public
	  */
	function sanitizeURLString($input) {
		//convert accentuated characters
		$sanitized = strtr(trim($input), "’' @ÀÁÂÃÄÅÆàáâãäåæÒÓÔÕÕÖØòóôõöøÈÉÊËèéêëðÇçÐÌÍÎÏìíîïÙÚÛÜùúûüÑñÞßÿý",
								   		 "---aaaaaaaaaaaaaaaoooooooooooooeeeeeeeeecceiiiiiiiiuuuuuuuunntsyy");
		//remove all non alpha characters
		$sanitized = preg_replace("#[^[a-zA-Z0-9-]]*#", "", $sanitized);
		//remove multiple indent
		$sanitized = preg_replace("#-+#", "-", $sanitized);
		//to lower case
		$sanitized = strtolower($sanitized);
		return $sanitized;
	}

	/**
	  * Cleans a string to use it in a JS var
	  * Remove line breaks and add slashes to single quotes
	  *
	  * @param mixed $input: The sensitive input.
	  * @param boolean $minimize: Use jsmin to minimise JS, this will also strip comments (default : false)
	  * @param boolean $addslashes: add slashes around single quotes (default : true);
	  * @return string the sanitized string
	  * @access public
	  */
	function sanitizeJSString($input, $minimize = false, $addslashes = true) {
		if ($minimize) {
			$input = JSMin::minify($input);
		}
		if ($addslashes) {
			$input = addcslashes($input, "'\\");
		}
		$sanitized = str_replace(array("\r", "\n", "\t"), '', $input);
		return $sanitized;
	}

	/**
	  * Parses input string for email format correctness
	  * Static method.
	  *
	  * @param String $email.
	  * @return boolean
	  * @access public
	  */
	function isValidEmail($email, $checkDomain = false) {
		if (is_array($email)) {
			extract($email);
		}
		if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.
                 	'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
			'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email)) { //TODOV4

			if ($checkDomain && function_exists('checkdnsrr')) {
				list (, $domain)  = explode('@', $email);
				if (checkdnsrr($domain, 'MX') || checkdnsrr($domain, 'A')) {
					return true;
				}
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	  * Parses input string as if it is a password, and return the "well-formed" status : must be at least 5 chars long, ...
	  * Static method.
	  *
	  * @param string $input the user input to be login
	  * @return boolean
	  * @access public
	  */
	function isValidPassword($input) {
		return strlen($input) >= MINIMUM_PASSWORD_LENGTH;
	}

	/**
	  * Replaces each succesive %s with succesive array items
	  * Note if no %s in string or no $formatStringParameters then
	  * returns formatString
	  *
	  * @param String $formatString containing %s
	  * @param array(String) $formatStringParameters The array of parameters to replace the %s with
	  * @return String
	  * @access public
	  */
	function arraySprintf($formatString, $formatStringParameters = false) {
		// To do catch error so that same number of %s as values in array
		if (is_array($formatStringParameters)) {
			// Check equal amount of parameters for concatination
			if (count($formatStringParameters) != substr_count($formatString, "%s")) {
				//TODOV4 : remove ."\n".print_r(debug_backtrace(), true) at end of this error message
				CMS_grandFather::raiseError("Invalid format :\nParameters : ".
					count($formatStringParameters)."\nReplacements to do : " .
					substr_count($formatString,"%s"). "\n".'('.implode(' - ',$formatStringParameters).' -> '.$formatString.')'."\n".print_r(debug_backtrace(), true));
			} else {
				// Replace %s
				$exploded = explode("%s", $formatString);
				foreach ($formatStringParameters as $key => $value) {
					$exploded[$key] .= $value;
				}
				$formatString = "";
				//rebuild format string
				foreach ($exploded as $value) {
					 $formatString .= $value;
				}
			}
		}
		return $formatString;
	}

	/**
	  * Tests the input to see if it is an integer between min and max value.
	  * Static method.
	  *
	  * @param mixed $input The sensitive input
	  * @param mixed $min The min value
	  * @param mixed $max The max value
	  * @return boolean true if the input is in range, false otherwise
	  * @access public
	  */
	function isUnderRange($input, $min, $max) {
		return ($input && intval($input) == $input && $input <= $max && $input >= $min);
	}

	/**
	  * Replace special chars returned by Windows shell or Word copy/paste by standard ISO 8859-1 chars
	  * Static method.
	  *
	  * @param string $input The sensitive input
	  * @return string decoded
	  * @access public
	  */
	function decodeWindowsChars($input) {
	    if (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
			$entities = array(
		        '‚' => '&#8218;',
		        'ƒ' => '&#402;',
		        '„' => '&#8222;',
		        '…' => '&#8230;',
		        '†' => '&#8224;',
		        '‡' => '&#8225;',
		        'ˆ' => '&#710;',
		        '‰' => '&#8240;',
		        'Š' => '&#352;',
		        '‹' => '&#8249;',
		        'Œ' => '&#338;',
		        '‘' => '&#8216;',
		        '’' => '&#8217;',
		        '“' => '&#8220;',
		        '”' => '&#8221;',
		        '•' => '&#8226;',
		        '–' => '&#8211;',
		        '—' => '&#8212;',
		        '˜' => '&#732;',
		        '™' => '&#8482;',
		        'š' => '&#353;',
		        '›' => '&#8250;',
		        'œ' => '&#339;',
		        'Ÿ' => '&#376;',
		        '€' => '&#8364;',
				'ÿ' => ' ',
				'‡' => 'f',
				'‚' => 'é',
				'ˆ' => 'ê',
				'’' => '\'',
				'…' => '...',
			);
		} else {
			$entities = array();
		}
		return str_replace(array_keys($entities),$entities,$input);
	}

	/**
	  * Evaluate all php blocks (like <?php ... ? >) founded in input string
	  * Static method.
	  *
	  * @param string $input The input string in which eval the code
	  * @return string with code evalued (all PHP code is replaced by his output value)
	  * @access public
	  */
	function evalPHPCode($input) {
		//write all content to evaluate as a tmp file.
		$tmpFile = new CMS_file(PATH_TMP_FS.'/eval_'.md5(mt_rand().microtime()).'.tmp');
		$tmpFile->setContent($input);
		$tmpFile->writeTopersistence();
		//then execute it as a require file (this is most like a real PHP execution)
		ob_start();
    	require $tmpFile->getFilename();
    	$return = ob_get_clean();
		$tmpFile->delete();
		return $return;
	}

	/**
	  * Encode a multidimentionnal array in json format
	  * Convert datas in utf-8 if needed
	  *
	  * @param array $datas The datas to convert
	  * @return string json encoded datas
	  * @access public
	  */
	function jsonEncode ($datas) {
		if (!is_array($datas)) {
			CMS_grandFather::raiseError('Datas must be an array ...');
			return array();
		}
		//encode nodes array in utf-8 if needed
		if (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
			$func = create_function('&$data,$key', '$data = is_string($data) ? utf8_encode($data) : $data;');
			array_walk_recursive($datas, $func);
		}
		return json_encode($datas);
	}

	/**
	  * Truncate a string and add an ellipsis ('...') to the end if it exceeds the specified length
	  *
	  * @param string $value The string value to troncate
	  * @param integer $length The maximum length of the returned string
	  * @return string the value troncated
	  * @access public
	  */
	function ellipsis($value, $length) {
		if (strlen($value) <= $length) {
			return $value;
		}
		return substr($value, 0, ceil(($length - 3)/2)) . '...' . substr($value, - floor(($length - 3)/2));
	}

	/**
	  * Get call infos of the caller function which call this one
	  *
	  * @return string the caller call info
	  * @access public
	  */
	function getCallInfos() {
		$callInfos = '';
		$bt = debug_backtrace();
		if (isset($bt[3]) && $bt[2]['class'] == 'CMS_grandFather' && ($bt[2]['function'] == '__call')) {
			//if error is sent by generic __call or autoload method of grandFather class, display point of call
			$callInfos = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bt[3]['file']).' (line '.$bt[3]['line'].')';
		} elseif (isset($bt[4]) && $bt[2]['class'] == 'CMS_grandFather' && ($bt[2]['function'] == 'autoload')) {
			//if error is sent by generic __call or autoload method of grandFather class, display point of call
			$callInfos = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bt[4]['file']).' (line '.$bt[4]['line'].')';
		} elseif (isset($bt[2])) {
			//if error came from object execution
			if ($bt[2]['function'] != 'PHPErrorHandler') {
				$callInfos = (isset($bt[2]['class']) ? $bt[2]['class'].$bt[2]['type'] : '').$bt[2]['function'].' (line '.$bt[1]['line'].')';
			}
		} elseif (isset($bt[1])) {
			//if error came from file execution
			$callInfos = str_replace($_SERVER['DOCUMENT_ROOT'], '', $bt[1]['file']).' (line '.$bt[1]['line'].')';
		}
		return $callInfos;
	}
}
?>