<?php
/**
 * cssmin.php - A simple CSS minifier.
 * --
 * 
 * <code>
 * include("cssmin.php");
 * file_put_contents("path/to/target.css", cssmin::minify(file_get_contents("path/to/source.css")));
 * </code>
 * --
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING 
 * BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, 
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 * --
 *
 * @package 	cssmin
 * @author 		Joe Scylla <joe.scylla@gmail.com>
 * @copyright 	2008 Joe Scylla <joe.scylla@gmail.com>
 * @license 	http://opensource.org/licenses/mit-license.php MIT License
 * @version 	1.0 (2008-01-31)
 */
class cssmin {
	/**
	 * Minifies stylesheet definitions
	 *
	 * @param 	string	$v	Stylesheet definitions as string
	 * @return 	string		Minified stylesheet definitions
	 */
	public static function minify($css) {
		/* Protect all datas inside blocks like :
		 *	/*<<* /
		 *	...
		 *	/*!>>* /
		 * Used to protect copyrights texts
		 */
		$matches = array();
		preg_match_all("#\/\*<{2}\*\/(.*)\/\*\!>{2}\*\/#Us", $css, $matches);
		if (isset($matches[1]) && $matches[1]) {
			$return = '';
			$css = explode('/*<<*/', $css);
			if (trim($css[0]) != '') {
				$return .= cssmin::min($css[0]);
			}
			unset($css[0]);
			$css = array_values($css);
			foreach ($matches[1] as $key => $match) {
				$code = explode('/*!>>*/', $css[$key]);
				$return .= $match."\n".cssmin::min($code[1]);
			}
			return $return;
		} else {
			return cssmin::min($css);
		}
  	}
	
	function min($v) {
		$v = trim($v);
		$v = str_replace("\r\n", "\n", $v);
        $search = array("/\/\*[\d\D]*?\*\/|\t+/", "/\s+/", "/\}\s+/");
        $replace = array(null, " ", "}\n");
		$v = preg_replace($search, $replace, $v);
		$search = array("/\\;\s/", "/\s+\{\\s+/", "/\\:\s+\\#/", "/,\s+/i", "/\\:\s+\\\'/i", "/\\:\s+([0-9]+|[A-F]+)/i");
        $replace = array(";", "{", ":#", ",", ":\'", ":$1");
        $v = preg_replace($search, $replace, $v);
        $v = str_replace("\n", null, $v);
    	return $v;
	}
}
?>