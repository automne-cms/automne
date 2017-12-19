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

/**
  * Class CMS_PO
  *
  * This script aimed to manage po files for translation
  * It is an adaptation of the PO class from Wordpress
  *
  * @package Automne
  * @subpackage cms_i18n
  * @author Wordpress dev team
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
class CMS_PO extends CMS_grandFather {
	const PO_MAX_LINE_LEN = 79;
	
	public $entries = array();
	public $headers = array();

	/**
	 * Add entry to the PO structure
	 *
	 * @param object &$entry
	 * @return bool true on success, false if the entry doesn't have a key
	 */
	public function add_entry($entry) {
		if (is_array($entry)) {
			$entry = new CMS_po_entry($entry);
		}
		$key = $entry->key();
		if (false === $key) return false;
		$this->entries[$key] = &$entry;
		return true;
	}

	/**
	 * Sets $header PO header to $value
	 *
	 * If the header already exists, it will be overwritten
	 *
	 * TODO: this should be out of this class, it is gettext specific
	 *
	 * @param string $header header name, without trailing :
	 * @param string $value header value, without trailing \n
	 */
	public function set_header($header, $value) {
		$this->headers[$header] = $value;
	}

	public function set_headers(&$headers) {
		if ($headers) {
			foreach($headers as $header => $value) {
				$this->set_header($header, $value);
			}
		}
	}

	public function get_header($header) {
		return isset($this->headers[$header])? $this->headers[$header] : false;
	}
	
	
	/**
	 * Exports headers to a PO entry
	 *
	 * @return string msgid/msgstr PO entry for this PO file headers, doesn't contain newline at the end
	 */
	public function export_headers() {
		$header_string = '';
		foreach($this->headers as $header => $value) {
			$header_string.= "$header: $value\n";
		}
		$poified = CMS_PO::poify($header_string);
		return rtrim("msgid \"\"\nmsgstr $poified");
	}

	/**
	 * Exports all entries to PO format
	 *
	 * @return string sequence of mgsgid/msgstr PO strings, doesn't containt newline at the end
	 */
	public function export_entries() {
		//TODO sorting
		return implode("\n\n", array_map(array('CMS_PO', 'export_entry'), $this->entries));
	}

	/**
	 * Exports the whole PO file as a string
	 *
	 * @param bool $include_headers whether to include the headers in the export
	 * @return string ready for inclusion in PO file string for headers and all the enrtries
	 */
	public function export($include_headers = true) {
		$res = '';
		if ($include_headers) {
			$res .= $this->export_headers();
			$res .= "\n\n";
		}
		$res .= $this->export_entries();
		return $res;
	}

	/**
	 * Same as {@link export}, but writes the result to a file
	 *
	 * @param string $filename where to write the PO string
	 * @param bool $include_headers whether to include tje headers in the export
	 * @return bool true on success, false on error
	 */
	public function export_to_file($filename, $include_headers = true) {
		$fh = fopen($filename, 'w');
		if (false === $fh) return false;
		$export = $this->export($include_headers);
		$res = fwrite($fh, $export);
		if (false === $res) return false;
		return fclose($fh);
	}

	/**
	 * Formats a string in PO-style
	 *
	 * @static
	 * @param string $string the string to format
	 * @return string the poified string
	 */
	public static function poify($string) {
		$quote = '"';
		$slash = '\\';
		$newline = "\n";

		$replaces = array(
			"$slash" 	=> "$slash$slash",
			"$quote"	=> "$slash$quote",
			"\t" 		=> '\t',
			"\r" 		=> '',
		);

		$string = str_replace(array_keys($replaces), array_values($replaces), $string);

		$po = $quote.implode("${slash}n$quote$newline$quote", explode($newline, $string)).$quote;
		// add empty string on first line for readbility
		if (false !== strpos($string, $newline) &&
				(substr_count($string, $newline) > 1 || !($newline === substr($string, -strlen($newline))))) {
			$po = "$quote$quote$newline$po";
		}
		// remove empty strings
		$po = str_replace("$newline$quote$quote", '', $po);
		return $po;
	}

	/**
	 * Gives back the original string from a PO-formatted string
	 *
	 * @static
	 * @param string $string PO-formatted string
	 * @return string enascaped string
	 */
	public static function unpoify($string) {
		$escapes = array('t' => "\t", 'n' => "\n", '\\' => '\\');
		$lines = array_map('trim', explode("\n", $string));
		$lines = array_map(array('CMS_PO', 'trim_quotes'), $lines);
		$unpoified = '';
		$previous_is_backslash = false;
		foreach($lines as $line) {
			preg_match_all('/./u', $line, $chars);
			$chars = $chars[0];
			foreach($chars as $char) {
				if (!$previous_is_backslash) {
					if ('\\' == $char)
						$previous_is_backslash = true;
					else
						$unpoified .= $char;
				} else {
					$previous_is_backslash = false;
					$unpoified .= isset($escapes[$char])? $escapes[$char] : $char;
				}
			}
		}
		return $unpoified;
	}

	/**
	 * Inserts $with in the beginning of every new line of $string and
	 * returns the modified string
	 *
	 * @static
	 * @param string $string prepend lines in this string
	 * @param string $with prepend lines with this string
	 */
	public static function prepend_each_line($string, $with) {
		$php_with = var_export($with, true);
		$lines = explode("\n", $string);
		// do not prepend the string on the last empty line, artefact by explode
		if ("\n" == substr($string, -1)) unset($lines[count($lines) - 1]);
		$res = implode("\n", array_map(create_function('$x', "return $php_with.\$x;"), $lines));
		// give back the empty line, we ignored above
		if ("\n" == substr($string, -1)) $res .= "\n";
		return $res;
	}

	/**
	 * Prepare a text as a comment -- wraps the lines and prepends #
	 * and a special character to each line
	 *
	 * @access private
	 * @param string $text the comment text
	 * @param string $char character to denote a special PO comment,
	 * 	like :, default is a space
	 */
	protected function comment_block($text, $char=' ') {
		$text = wordwrap($text, self::PO_MAX_LINE_LEN - 3);
		return CMS_PO::prepend_each_line($text, "#$char ");
	}

	/**
	 * Builds a string from the entry for inclusion in PO file
	 *
	 * @static
	 * @param object &$entry the entry to convert to po string
	 * @return string|bool PO-style formatted string for the entry or
	 * 	false if the entry is empty
	 */
	public static function export_entry(&$entry) {
		if (is_null($entry->singular)) return false;
		$po = array();
		if (!empty($entry->translator_comments)) $po[] = CMS_PO::comment_block($entry->translator_comments);
		if (!empty($entry->extracted_comments)) $po[] = CMS_PO::comment_block($entry->extracted_comments, '.');
		if (!empty($entry->references)) $po[] = CMS_PO::comment_block(implode(' ', $entry->references), ':');
		if (!empty($entry->flags)) $po[] = CMS_PO::comment_block(implode(", ", $entry->flags), ',');
		if (!is_null($entry->context)) $po[] = 'msgctxt '.CMS_PO::poify($entry->context);
		$po[] = 'msgid '.CMS_PO::poify($entry->singular);
		if (!$entry->is_plural) {
			$translation = empty($entry->translations)? '' : $entry->translations[0];
			$po[] = 'msgstr '.CMS_PO::poify($translation);
		} else {
			$po[] = 'msgid_plural '.CMS_PO::poify($entry->plural);
			$translations = empty($entry->translations)? array('', '') : $entry->translations;
			foreach($translations as $i => $translation) {
				$po[] = "msgstr[$i] ".CMS_PO::poify($translation);
			}
		}
		return implode("\n", $po);
	}

	public function import_from_file($filename) {
		$f = fopen($filename, 'r');
		if (!$f) return false;
		$lineno = 0;
		while (true) {
			$res = $this->read_entry($f, $lineno);
			if (!$res) break;
			if ($res['entry']->singular == '') {
				$this->set_headers($this->make_headers($res['entry']->translations[0]));
			} else {
				$this->add_entry($res['entry']);
			}
		}
		CMS_PO::read_line($f, 'clear');
		return $res !== false;
	}

	public function read_entry($f, $lineno = 0) {
		$entry = new CMS_po_entry();
		// where were we in the last step
		// can be: comment, msgctxt, msgid, msgid_plural, msgstr, msgstr_plural
		$context = '';
		$msgstr_index = 0;
		$is_final = create_function('$context', 'return $context == "msgstr" || $context == "msgstr_plural";');
		while (true) {
			$lineno++;
			$line = CMS_PO::read_line($f);
			if (!$line)  {
				if (feof($f)) {
					if ($is_final($context))
						break;
					elseif (!$context) // we haven't read a line and eof came
						return null;
					else
						return false;
				} else {
					return false;
				}
			}
			if ($line == "\n") continue;
			$line = trim($line);
			if (preg_match('/^#/', $line, $m)) {
				// the comment is the start of a new entry
				if ($is_final($context)) {
					CMS_PO::read_line($f, 'put-back');
					$lineno--;
					break;
				}
				// comments have to be at the beginning
				if ($context && $context != 'comment') {
					return false;
				}
				// add comment
				$this->add_comment_to_entry($entry, $line);
			} elseif (preg_match('/^msgctxt\s+(".*")/', $line, $m)) {
				if ($is_final($context)) {
					CMS_PO::read_line($f, 'put-back');
					$lineno--;
					break;
				}
				if ($context && $context != 'comment') {
					return false;
				}
				$context = 'msgctxt';
				$entry->context .= CMS_PO::unpoify($m[1]);
			} elseif (preg_match('/^msgid\s+(".*")/', $line, $m)) {
				if ($is_final($context)) {
					CMS_PO::read_line($f, 'put-back');
					$lineno--;
					break;
				}
				if ($context && $context != 'msgctxt' && $context != 'comment') {
					return false;
				}
				$context = 'msgid';
				$entry->singular .= CMS_PO::unpoify($m[1]);
			} elseif (preg_match('/^msgid_plural\s+(".*")/', $line, $m)) {
				if ($context != 'msgid') {
					return false;
				}
				$context = 'msgid_plural';
				$entry->is_plural = true;
				$entry->plural .= CMS_PO::unpoify($m[1]);
			} elseif (preg_match('/^msgstr\s+(".*")/', $line, $m)) {
				if ($context != 'msgid') {
					return false;
				}
				$context = 'msgstr';
				$entry->translations = array(CMS_PO::unpoify($m[1]));
			} elseif (preg_match('/^msgstr\[(\d+)\]\s+(".*")/', $line, $m)) {
				if ($context != 'msgid_plural' && $context != 'msgstr_plural') {
					return false;
				}
				$context = 'msgstr_plural';
				$msgstr_index = $m[1];
				$entry->translations[$m[1]] = CMS_PO::unpoify($m[2]);
			} elseif (preg_match('/^".*"$/', $line)) {
				$unpoified = CMS_PO::unpoify($line);
				switch ($context) {
					case 'msgid':
						$entry->singular .= $unpoified; break;
					case 'msgctxt':
						$entry->context .= $unpoified; break;
					case 'msgid_plural':
						$entry->plural .= $unpoified; break;
					case 'msgstr':
						$entry->translations[0] .= $unpoified; break;
					case 'msgstr_plural':
						$entry->translations[$msgstr_index] .= $unpoified; break;
					default:
						return false;
				}
			} else {
				return false;
			}
		}
		if (array() == array_filter($entry->translations, create_function('$t', 'return $t || "0" === $t;'))) {
			$entry->translations = array();
		}
		return array('entry' => $entry, 'lineno' => $lineno);
	}

	public static function read_line($f, $action = 'read') {
		static $last_line = '';
		static $use_last_line = false;
		if ('clear' == $action) {
			$last_line = '';
			return true;
		}
		if ('put-back' == $action) {
			$use_last_line = true;
			return true;
		}
		$line = $use_last_line? $last_line : fgets($f);
		$last_line = $line;
		$use_last_line = false;
		return $line;
	}

	public static function add_comment_to_entry(&$entry, $po_comment_line) {
		$first_two = substr($po_comment_line, 0, 2);
		$comment = trim(substr($po_comment_line, 2));
		if ('#:' == $first_two) {
			$entry->references = array_merge($entry->references, preg_split('/\s+/', $comment));
		} elseif ('#.' == $first_two) {
			$entry->extracted_comments = trim($entry->extracted_comments . "\n" . $comment);
		} elseif ('#,' == $first_two) {
			$entry->flags = array_merge($entry->flags, preg_split('/,\s*/', $comment));
		} else {
			$entry->translator_comments = trim($entry->translator_comments . "\n" . $comment);
		}
	}

	public static function trim_quotes($s) {
		if ( substr($s, 0, 1) == '"') $s = substr($s, 1);
		if ( substr($s, -1, 1) == '"') $s = substr($s, 0, -1);
		return $s;
	}
	
	public static function make_headers($translation) {
		$headers = array();
		// sometimes \ns are used instead of real new lines
		$translation = str_replace('\n', "\n", $translation);
		$lines = explode("\n", $translation);
		foreach($lines as $line) {
			$parts = explode(':', $line, 2);
			if (!isset($parts[1])) continue;
			$headers[trim($parts[0])] = trim($parts[1]);
		}
		return $headers;
	}
}
?>