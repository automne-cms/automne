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
// | Authors: Antoine Pouch <antoine.pouch@ws-interactive.fr>			  |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: sensitiveio.php,v 1.12 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class SensitiveIO
  *
  * Collection of static methods used to validate user input and output
  *
  * @package Automne
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Tomas V.V.Cox <cox@idecnet.com> (For isValidEmail())
  * @author Pierre-Alain Joye <pajoye@phpindex.com> (For isValidEmail())
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class SensitiveIO extends CMS_grandFather
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
	static function request($name, $filter = '', $default = false) {
		if (!isset($_REQUEST[$name])) {
			return $default;
		}
		return io::filter($_REQUEST[$name], $filter, $default);
	}
	static function get($name, $filter = '', $default = false) {
		if (!isset($_GET[$name])) {
			return $default;
		}
		return io::filter($_GET[$name], $filter, $default);
	}
	static function post($name, $filter = '', $default = false) {
		if (!isset($_POST[$name])) {
			return $default;
		}
		return io::filter($_POST[$name], $filter, $default);
	}
	static function filter($value, $filter = '', $default = false) {
		if (!isset($value)) {
			return $default;
		}
		if (is_string($filter)) {
			if ($filter == '') { //no filter set, just return request value
				return $value;
			} elseif (is_callable($filter, true)) {//check if function/method name exists
				if (io::strpos($filter, '::') !== false) {//static method call
					$method = explode('::', $filter);
					return (call_user_func(array($method[0], $method[1]), $value) ? $value : $default);
				} elseif(call_user_func($filter, $value)) { //function call
					return $value;
				} else {
					return $default;
				}
			} elseif (preg_match($filter, $value)) { //else assume this is a regexp pattern to check
				return $value;
			}
		} elseif(is_array($filter)) {
			if (in_array($value, $filter)) {
				return $value;
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
	static function unsetRequest($requests) {
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
	static function isPositiveInteger($input) {
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
	static function isInSet($input, $set) {
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
	static function sanitizeSQLString($input) {
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
	static function stripPHPTags($input) {
		return str_replace(array("<?php", "<?", "?>"), "", $input);
	}

	/**
	  * Cleans a string that has to be echoed to the user.
	  * Static method.
	  *
	  * @param mixed $input The sensitive input.
	  * @return string the sanitized string
	  * @access public
	  */
	static function htmlspecialchars($input) {
		if (version_compare(phpversion(), "5.2.3") !== -1) {
			return htmlspecialchars($input, ENT_QUOTES, 'ISO-8859-1', false);
		} else {
			return preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", htmlspecialchars($input, ENT_QUOTES, 'ISO-8859-1'));
		}
	}
	static function sanitizeHTMLString($input) {
		return io::htmlspecialchars($input);
	}
	
	/**
	  * Cleans a string that has to be used in an exec command
	  * For now, remove backticks ` in string
	  * Static method.
	  *
	  * @param mixed $input The sensitive input.
	  * @return string the sanitized string
	  * @access public
	  */
	static function sanitizeExecCommand($input) {
		return strtr($input, "\x60", '\'');
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
	static function sanitizeAsciiString($input) {
		$map = io::sanitizeAsciiMap();
		$map = array_merge($map, array(" " => "_"));
		if (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
			$sanitized = strtr($input, $map);
			$sanitized = preg_replace("#[^[a-zA-Z0-9_.-]]*#", "", $sanitized);
		} else {
			$input = utf8_decode($input);
			$sanitized = strtr($input, $map);
			$sanitized = preg_replace("#[^[a-zA-Z0-9_.-]]*#", "", $sanitized);
			$sanitized = utf8_encode($sanitized);
		}
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
	static function sanitizeURLString($input) {
		$map = io::sanitizeAsciiMap();
		$map = array_map('strtolower', $map);
		$map = array_merge($map, array("\x92" => "-", "'" => "-", " " => "-", "@" => "a", ));
		if (strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8') {
			$input = utf8_decode($input);
		}
		$sanitized = strtr(trim($input), $map);
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
	static function sanitizeJSString($input, $minimize = false, $addslashes = true, $keepCariageReturn = false) {
		if ($minimize) {
			$input = JSMin::minify($input);
		}
		if (!$keepCariageReturn) {
			if ($addslashes) {
				$input = addcslashes($input, "'\\");
			}
			$sanitized = str_replace(array("\r", "\n", "\t"), '', $input);
		} else {
			if ($addslashes) {
				$input = addcslashes($input, '"\\');
			}
			$sanitized = str_replace(array("\r", "\n", "\t"), array('', '\n', ''), $input);
		}
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
	static function isValidEmail($email, $checkDomain = false) {
		if (is_array($email)) {
			extract($email);
		}
		if (preg_match('§^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.
				 	'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
			'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$§', $email)) {

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
	* Check if the login is valid
	*
	* @param string $login
	* @return boolean true on success, false on failure
	* @access public
	*/
	function isValidLogin($login){
		if (!$login) {
			return false;
		}
		// Search non alphanum characters
		if (preg_match("#[^[a-zA-Z0-9_.-]]*#", $login)){
			return false;
		}
		return true;
	}
	
	/**
	  * Parses input string as if it is a password, and return the "well-formed" status : must be at least 5 chars long, ...
	  * Static method.
	  *
	  * @param string $input the user input to be login
	  * @return boolean
	  * @access public
	  */
	static function isValidPassword($input) {
		return io::strlen($input) >= MINIMUM_PASSWORD_LENGTH;
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
	static function arraySprintf($formatString, $formatStringParameters = false) {
		// To do catch error so that same number of %s as values in array
		if (is_array($formatStringParameters)) {
			// Check equal amount of parameters for concatination
			if (count($formatStringParameters) != substr_count($formatString, "%s")) {
				CMS_grandFather::raiseError("Invalid format :\nParameters : ".
					count($formatStringParameters)."\nReplacements to do : " .
					substr_count($formatString,"%s"). "\n".'('.implode(' - ',$formatStringParameters).' -> '.$formatString.')');/*."\n".print_r(debug_backtrace(), true))*/
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
	static function isUnderRange($input, $min, $max) {
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
	static function decodeWindowsChars($input) {
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
	static function evalPHPCode($input) {
		global $cms_user, $cms_language;
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
	static function jsonEncode ($datas) {
		if (!is_array($datas)) {
			CMS_grandFather::raiseError('Datas must be an array ... (from : '.io::getCallInfos().')');
			return $datas;
		}
		//encode nodes array in utf-8 if needed
		if (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
			$func = create_function('&$data,$key', '$data = is_string($data) ? io::utf8Encode($data) : $data;');
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
	static function ellipsis($value, $length, $ellipsis = '...', $center = false) {
		if (io::strlen($value) <= $length) {
			return $value;
		}
		if ($center) {
			return io::substr($value, 0, ceil(($length - io::strlen($ellipsis))/2)) . $ellipsis . io::substr($value, - floor(($length - io::strlen($ellipsis))/2));
		} else {
			return io::substr($value, 0, ($length - io::strlen($ellipsis))) . $ellipsis;
		}
	}

	/**
	  * Get call infos of the caller function which call this one
	  *
	  * @return string the caller call info
	  * @access public
	  */
	static function getCallInfos($deep = 1) {
		$callInfos = '';
		$bt = debug_backtrace();
		for ($level = 1; $level <= $deep; $level++) {
			if ($level != 1) {
				$callInfos .= ' &laquo; ';
			}
			if (isset($bt[$level + 2]) && isset($bt[$level + 1]['class']) && $bt[$level + 1]['class'] == 'CMS_grandFather' && ($bt[$level + 1]['function'] == '__call' && isset($bt[$level + 2]['file']))) {
				//if error is sent by generic __call or autoload method of grandFather class, display point of call
				$callInfos .= str_replace($_SERVER['DOCUMENT_ROOT'], '', $bt[$level + 2]['file']).' (line '.$bt[$level + 2]['line'].')';
			} elseif (isset($bt[$level + 3]) && isset($bt[$level + 1]['class']) && $bt[$level + 1]['class'] == 'CMS_grandFather' && ($bt[$level + 1]['function'] == 'autoload' || $bt[$level + 1]['function'] == '__call')) {
				//if error is sent by generic __call or autoload method of grandFather class, display point of call
				$callInfos .= str_replace($_SERVER['DOCUMENT_ROOT'], '', @$bt[$level + 3]['file']).' (line '.@$bt[$level + 3]['line'].')';
			} elseif (isset($bt[$level + 1]) && $bt[$level + 1]['function'] == 'require') {
				//if error came from direct require, display point of call
				$callInfos .= str_replace($_SERVER['DOCUMENT_ROOT'], '', @$bt[$level]['file']).' (line '.@$bt[$level]['line'].')';
			} elseif (isset($bt[$level + 1])) {
				//if error came from object execution
				if ($bt[$level + 1]['function'] != 'PHPErrorHandler') {
					$callInfos .= (isset($bt[$level + 1]['class']) ? $bt[$level + 1]['class'].$bt[$level + 1]['type'] : '').$bt[$level + 1]['function'].' (line '.$bt[$level]['line'].')';
				}
			} elseif (isset($bt[$level])) {
				//if error came from file execution
				$callInfos .= str_replace($_SERVER['DOCUMENT_ROOT'], '', $bt[$level]['file']).' (line '.$bt[$level]['line'].')';
			}
		}
		return $callInfos;
	}
	
	static function printBackTrace($backtrace) {
		if (!is_array($backtrace)) {
			return false;
		}
		$output = '';
		foreach ($backtrace as $bt) {
			$args = '';
			if (isset($bt['args']) && is_array($bt['args'])) {
		  		foreach ($bt['args'] as $a) {
					 if ($args) {
						 $args .= ', ';
					 }
					 switch (gettype($a)) {
						 case 'integer':
						 case 'double':
							 $args .= $a;
							 break;
						 case 'string':
							 $a = io::htmlspecialchars(io::substr($a, 0, 64)).((io::strlen($a) > 64) ? '...' : '');
							 $args .= "\"$a\"";
							 break;
						 case 'array':
							 $args .= 'Array('.count($a).')';
							 break;
						 case 'object':
							 $args .= 'Object('.get_class($a).')';
							 break;
						 case 'resource':
							 $args .= 'Resource('.strstr($a, '#').')';
							 break;
						 case 'boolean':
							 $args .= $a ? 'True' : 'False';
							 break;
						 case 'NULL':
							 $args .= 'Null';
							 break;
						 default:
							 $args .= 'Unknown';
							 break;
					 }
				 }
			}
			$output .= "<br />\n";
			if(!isset($bt['file'])){
                $bt['file'] = 'Unknown File';
            }
			if(!isset($bt['line'])){
                $bt['line'] = 'Unknown Line';
            }
			$output .= "<b>file:</b> {$bt['line']} - {$bt['file']}<br />\n";
			if (isset($bt['class']) && isset($bt['type'])) {
				$output .= "<b>call:</b> {$bt['class']}{$bt['type']}{$bt['function']}($args)<br />\n";
			} else {
				$output .= "<b>call:</b> {$bt['function']}($args)<br />\n";
			}
		}
		return $output;
	}
	
	/**
	  * Convert textBody to HTMLBody, convert all links and \n tags
	  *
	  * @param string $body The body to convert
	  * @param boolean $withNl2Br : Use nl2br on returned text (default : true)
	  * @return string, the body converted in html
	  * @access public
	  */
	function convertTextToHTML($body, $withNl2Br = true) {
		$HTMLBody = preg_replace(
				array(
					'/(?(?=<a[^>]*>.+<\/a>)
					(?:<a[^>]*>.+<\/a>)
					|
					([^="\']?)((?:https?|ftp|bf2|):\/\/[^<> \n\r]+)
					)/iex',
					'/<a([^>]*)target="?[^"\']+"?/i',
					'/<a([^>]+)>/i',
					'/(^|\s)(www.[^<> \n\r]+)/iex',
					'/(([_A-Za-z0-9-]+)(\\.[_A-Za-z0-9-]+)*@([A-Za-z0-9-]+)
					(\\.[A-Za-z0-9-]+)*)/iex'
				),
				array(
					"stripslashes((strlen('\\2')>0?'\\1<a href=\"\\2\" target=\"_blank\">\\2</a>\\3':'\\0'))",
					'<a\\1',
					'<a\\1 target="_blank">',
					"stripslashes((strlen('\\2')>0?'\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>\\3':'\\0'))",
					"stripslashes((strlen('\\2')>0?'<a href=\"mailto:\\0\">\\0</a>':'\\0'))"
				),$body);
		return $withNl2Br ? nl2br($HTMLBody) : $HTMLBody;
	}
	
	/**
	  * Check a value for XHTML errors
	  *
	  * @param string $value The value to check
	  * @param string &$errors : Errors founded, returned by reference
	  * @return boolean : true on success, false on failure
	  * @access public
	  */
	function checkXHTMLValue($value, &$errors) {
		//Check XHTML validity
		$value = str_replace('&#9;','',$value);
		/*if (defined('ALLOW_WYSIWYG_XHTML_VALIDATION') && ALLOW_WYSIWYG_XHTML_VALIDATION) {
			global $CMS_Xhtml_tagDefinition;
			include(PATH_MAIN_FS.'/xhtmlValidator/taglist.php');
			$v = new XhtmlValidator($value, $CMS_Xhtml_tagDefinition);
			try {
				$v->load();
				//$errors = $v->show_tree();
			} catch (valid_except $e) {
				$s = new valid_show($value,$e);
				$errors = $s->show(200);
				return false;
			}
		}*/
		//Check XML validity
		$defXML = new CMS_DOMDocument();
		try {
			$defXML->loadXML('<dummy>'.$value.'</dummy>');
		} catch (DOMException $e) {
			CMS_grandFather::raiseError('Parse error for xhtml content text in page : '.$e->getMessage());
			return false;
		}
		//Check Some Word or Open Office common copy/paste tags
		if (io::strpos($value, '<w:') !== false || io::strpos($value, '<meta ') !== false) {
			return false;
		}
		return true;
	}
	
	/**
	  * Generate a random ascii key of determined length
	  *
	  * @param int keyLength the desired length of the key
	  * @return string the generated key
	  * @access public
	  */
	function generateKey($keyLength) {
		$string = "abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ0123456789-";
		$strLen = strlen($string);
		$key = '';
		for($i = 1; $i <= $keyLength; $i++) {
			$strPos = mt_rand(0, ($strLen - 1));
			$key .= $string[$strPos];
		}
		return $key;
	}
	
	/**
	  * Check a value and force reencode of ampersand without double encode them :
	  * &			=> &amp;
	  * &amp;		=> &amp;
	  * &eacute;	=> &eacute;
	  *	&#123;		=> &#123;
	  *
	  * @param string $text The HTML value to reencode
	  * @return string : the value reencoded
	  * @access public
	  */
	function reencodeAmpersand($text) {
		return preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", str_replace('&', '&amp;', $text));
	}
	
	/**
	  * Decode HTML entities (charset insensitive)
	  *
	  * @param string $text The HTML value to decode
	  * @return string : the value decoded
	  * @access public
	  */
	function decodeEntities($text) {
		return html_entity_decode($text, ENT_QUOTES, (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8' ? 'ISO-8859-1' : 'UTF-8'));
	}
	
	/**
	  * Encode ISO8859-1 string to UTF8 with support of cp1252 charset
	  *
	  * @param string $text The to encode
	  * @return string : the value encoded
	  * @access public
	  */
	function utf8Encode($text) {
		$cp1252Map = io::cp1252ToUtf8Map();
		return  strtr(utf8_encode($text), $cp1252Map);
	}
	
	/**
	  * Decode String from UTF8 to latin1 with support of cp1252 charset
	  *
	  * @param string $text The to decode
	  * @return string : the value decoded
	  * @access public
	  */
	function utf8Decode($text) {
		$cp1252Map = io::cp1252ToUtf8Map();
		return  utf8_decode(strtr($text, array_flip($cp1252Map)));
	}
	
	/**
	  * Map of CP1252 characters not supported into latin to utf8 encoding
	  *
	  * @return array : the map
	  * @access public
	  */
	function cp1252ToUtf8Map() {
		return array(
		    "\xc2\x80" => "\xe2\x82\xac", /* EURO SIGN */
		    "\xc2\x82" => "\xe2\x80\x9a", /* SINGLE LOW-9 QUOTATION MARK */
		    "\xc2\x83" => "\xc6\x92",     /* LATIN SMALL LETTER F WITH HOOK */
		    "\xc2\x84" => "\xe2\x80\x9e", /* DOUBLE LOW-9 QUOTATION MARK */
		    "\xc2\x85" => "\xe2\x80\xa6", /* HORIZONTAL ELLIPSIS */
		    "\xc2\x86" => "\xe2\x80\xa0", /* DAGGER */
		    "\xc2\x87" => "\xe2\x80\xa1", /* DOUBLE DAGGER */
		    "\xc2\x88" => "\xcb\x86",     /* MODIFIER LETTER CIRCUMFLEX ACCENT */
		    "\xc2\x89" => "\xe2\x80\xb0", /* PER MILLE SIGN */
		    "\xc2\x8a" => "\xc5\xa0",     /* LATIN CAPITAL LETTER S WITH CARON */
		    "\xc2\x8b" => "\xe2\x80\xb9", /* SINGLE LEFT-POINTING ANGLE QUOTATION */
		    "\xc2\x8c" => "\xc5\x92",     /* LATIN CAPITAL LIGATURE OE */
		    "\xc2\x8e" => "\xc5\xbd",     /* LATIN CAPITAL LETTER Z WITH CARON */
		    "\xc2\x91" => "\xe2\x80\x98", /* LEFT SINGLE QUOTATION MARK */
		    "\xc2\x92" => "\xe2\x80\x99", /* RIGHT SINGLE QUOTATION MARK */
		    "\xc2\x93" => "\xe2\x80\x9c", /* LEFT DOUBLE QUOTATION MARK */
		    "\xc2\x94" => "\xe2\x80\x9d", /* RIGHT DOUBLE QUOTATION MARK */
		    "\xc2\x95" => "\xe2\x80\xa2", /* BULLET */
		    "\xc2\x96" => "\xe2\x80\x93", /* EN DASH */
		    "\xc2\x97" => "\xe2\x80\x94", /* EM DASH */
		    "\xc2\x98" => "\xcb\x9c",     /* SMALL TILDE */
		    "\xc2\x99" => "\xe2\x84\xa2", /* TRADE MARK SIGN */
		    "\xc2\x9a" => "\xc5\xa1",     /* LATIN SMALL LETTER S WITH CARON */
		    "\xc2\x9b" => "\xe2\x80\xba", /* SINGLE RIGHT-POINTING ANGLE QUOTATION*/
		    "\xc2\x9c" => "\xc5\x93",     /* LATIN SMALL LIGATURE OE */
		    "\xc2\x9e" => "\xc5\xbe",     /* LATIN SMALL LETTER Z WITH CARON */
		    "\xc2\x9f" => "\xc5\xb8"      /* LATIN CAPITAL LETTER Y WITH DIAERESIS*/
		);
	}
	
	/**
	  * Map of non-ascii characters to convert in ascii equivalent
	  *
	  * @return array : the map
	  * @access public
	  */
	function sanitizeAsciiMap() {
		return array(
			"\xc0" => "A", "\xc1" => "A", "\xc2" => "A", "\xc3" => "A", "\xc4" => "A", 
			"\xc5" => "A", "\xc6" => "A", "\xe0" => "a", "\xe1" => "a", "\xe2" => "a", 
			"\xe3" => "a", "\xe4" => "a", "\xe5" => "a", "\xe6" => "a", "\xd2" => "O", 
			"\xd3" => "O", "\xd4" => "O", "\xd5" => "O", "\xd5" => "O", "\xd6" => "O", 
			"\xd8" => "O", "\xf2" => "o", "\xf3" => "o", "\xf4" => "o", "\xf5" => "o", 
			"\xf6" => "o", "\xf8" => "o", "\xc8" => "E", "\xc9" => "E", "\xca" => "E", 
			"\xcb" => "E", "\xe8" => "e", "\xe9" => "e", "\xea" => "e", "\xeb" => "e", 
			"\xf0" => "e", "\xc7" => "C", "\xe7" => "c", "\xd0" => "e", "\xcc" => "I", 
			"\xcd" => "I", "\xce" => "I", "\xcf" => "I", "\xec" => "i", "\xed" => "i", 
			"\xee" => "i", "\xef" => "i", "\xd9" => "U", "\xda" => "U", "\xdb" => "U", 
			"\xdc" => "U", "\xf9" => "u", "\xfa" => "u", "\xfb" => "u", "\xfc" => "u", 
			"\xd1" => "N", "\xf1" => "n", "\xde" => "t", "\xdf" => "s", "\xff" => "y", 
			"\xfd" => "y",
		);
	}
	
	/**
	  * Try to detect UTF-8 content
	  *
	  * @author chris AT w3style.co DOT uk
	  * @return boolean true/false
	  * @access private
	  */
	function isUTF8($string) {
		if (function_exists('mb_check_encoding') && version_compare(PHP_VERSION, "5.2.6") >= 0) {
			return mb_check_encoding($string, 'UTF-8');
		}
		return (bool) preg_match('%(?:
		[\xC2-\xDF][\x80-\xBF]        		# non-overlong 2-byte
		|\xE0[\xA0-\xBF][\x80-\xBF]			# excluding overlongs
		|[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}	# straight 3-byte
		|\xED[\x80-\x9F][\x80-\xBF]			# excluding surrogates
		|\xF0[\x90-\xBF][\x80-\xBF]{2}		# planes 1-3
		|[\xF1-\xF3][\x80-\xBF]{3}			# planes 4-15
		|\xF4[\x80-\x8F][\x80-\xBF]{2}		# plane 16
		)+%xs', $string);
	}
	
	/**
	  * Rewrite some PHP functions to be charset insensitive
	  *
	  * @return mixed
	  * @access public
	  */
	function substr() {
		$func = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? 'substr' : 'mb_substr';
		$args = func_get_args();
		return call_user_func_array ($func, $args);
	}
	function strlen() {
		$func = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? 'strlen' : 'mb_strlen';
		$args = func_get_args();
		return call_user_func_array ($func, $args);
	}
	function strpos() {
		$func = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? 'strpos' : 'mb_strpos';
		$args = func_get_args();
		return call_user_func_array ($func, $args);
	}
	function strtolower() {
		$func = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? 'strtolower' : 'mb_strtolower';
		$args = func_get_args();
		return call_user_func_array ($func, $args);
	}
	function strtoupper() {
		$func = (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? 'strtoupper' : 'mb_strtoupper';
		$args = func_get_args();
		return call_user_func_array ($func, $args);
	}
}
/**
  * Class io
  * Shortcut to SensitiveIO class
  * @package Automne
  * @subpackage common
  */
class io extends SensitiveIO {} 
?>