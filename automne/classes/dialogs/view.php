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
// $Id: view.php,v 1.14 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_view
  *
  * XHTML / JS / XML Interface generation
  * This class is a singleton : it can't be instancied directly. You must use getInstance method
  *
  * @package CMS
  * @subpackage dialogs
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_view extends CMS_grandFather
{
	/**
	  * Class modes
	  */
	  
	//Used to directly send XHTML code without any XML embeding
	const SHOW_HTML = 1;
	
	//Used to  send JSON code embeded into XML controls.
	//Optionally, JS code can be sent with.
	const SHOW_JSON = 2;
	
	//Used to  send XML code embeded into XML controls.
	//Optionally, JS code can be sent with.
	const SHOW_XML = 3;
	
	//Used to send raw datas code embeded into XML controls.
	//Optionally, JS code can be sent with.
	const SHOW_RAW = 4;
	
	/**
	  * Class vars
	  */
	private $_displayMode = self::SHOW_HTML;
	private $_content = '';
	private $_title = '';
	private $_css = array();
	private $_js = array();
	private $_jscontent = '';
	private $_actionmessage = '';
	private $_errors = array();
	private $_rawdatas = array();
	private $_redirect = '';
	private $_disconnected = false;
	private $_sent = false;
	private $_secure = false;
	private $_contentTags = array(
		self::SHOW_JSON => 'jsoncontent',
		self::SHOW_XML => 'content',
		self::SHOW_RAW => 'content',
	);
	/**
	  * Create and get class instance
	  * This is a singleton : the class is always the same anywhere
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	private static $_instance = false;
	private function __constructor() {}
	static public function getInstance() {
		if (!CMS_view::$_instance) {
			CMS_view::$_instance = new CMS_view();
		}
		return CMS_view::$_instance;
	}
	
	/**
	  * Create a link for a group of JS files used into client page
	  *
	  * @param array $files : for static calls : array of files path to send to client (FS relative)
	  * @param string $media : useless for JS files (only for compatibility with getCSS method)
	  * @param boolean $onlyFiles : return only array of JS files to add instead of HTML code (default false)
	  * @return void
	  * @access public
	  */
	function getJavascript($jsarray = array(), $media = 'screen', $onlyFiles = false) {
		if (isset($this) && isset($this->_js)) {
			$jsarray = $this->_js;
			$this->_js = array();
		}
		$version = AUTOMNE_VERSION.'-'.AUTOMNE_LASTUPDATE.(SYSTEM_DEBUG ? 'd':'');
		$return = '';
		if ($onlyFiles) {
			return $jsarray;
		}
		if ($jsarray) {
			$return .= '<script src="'.CMS_view::getJSManagerURL().'&amp;files='.implode(',',$jsarray).'" type="text/javascript"></script>'."\n";
		}
		if (isset($this) && isset($this->_jscontent) && $this->_jscontent) {
			$return .= "\n".'<script type="text/javascript">'.$this->_jscontent.'</script>'."\n";
			$this->_jscontent = '';
		}
		return $return;
	}
	
	function addJSFile($js) {
		if (!in_array($js, $this->_js)) {
			$this->_js[] = $js;
		}
	}
	
	/**
	  * Add javascript
	  *
	  * @param string $js : Javascript code to add
	  * @return void
	  * @access public
	  */
	function addJavascript($js) {
		$this->_jscontent .= $js;
	}
	
	/**
	  * Set javascript
	  *
	  * @param string $js : Javascript code to set
	  * @return void
	  * @access public
	  */
	function setJavascript($js) {
		$this->_jscontent = $js;
	}
	
	function getJSManagerURL() {
		$version = AUTOMNE_VERSION.'-'.AUTOMNE_LASTUPDATE.(SYSTEM_DEBUG ? 'd':'');
		return PATH_JS_WR.'/jsmanager.php?version='.$version;
	}
	
	/**
	  * Create a link for a group of CSS files used into client page
	  *
	  * @param array $files : for static calls : array of files path to send to client (FS relative)
	  * @param string $media : the media to add to CSS HTML code returned (default : screen)
	  * @param boolean $onlyFiles : return only array of CSS files to add instead of HTML code (default false)
	  * @return void
	  * @access public
	  */
	function getCSS($cssarray = array(), $media = 'screen', $onlyFiles = false) {
		$cssarray = (isset($this) && isset($this->_css)) ? $this->_css : $cssarray;
		if ($onlyFiles) {
			return $cssarray;
		}
		if ($cssarray) {
			return '<link rel="stylesheet" type="text/css" href="'.CMS_view::getCSSManagerURL().'&amp;files='.implode(',',$cssarray).'" media="'.$media.'" />'."\n";
		}
		return '';
	}
	
	function addCSSFile($css) {
		if (!in_array($css, $this->_css)) {
			$this->_css[] = $css;
		}
	}
	
	function getCSSManagerURL() {
		$version = AUTOMNE_VERSION.'-'.AUTOMNE_LASTUPDATE.(SYSTEM_DEBUG ? 'd':'');
		return PATH_CSS_WR.'/cssmanager.php?version='.$version;
	}
	
	/**
	  * Quit : global shutdown function for the application
	  * Send errors present in stack
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	static function quit() {
		//check for error to be released
		$view = CMS_view::getInstance();
		if (!$view->isSent() && $view->getDisplayMode() != self::SHOW_HTML) {
			$view->show();
		}
		if ($view->hasErrors()) {
			echo $view->getErrors();
		}
		if ($view->hasRawDatas()) {
			echo $view->getRawDatas();
		}
		exit;
	}
	
	/**
	  * Does the view has been sent to user ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isSent() {
		return $this->_sent;
	}
	
	/**
	  * Set content
	  *
	  * @param string $content
	  * @return void
	  * @access public
	  */
	function setContent($content) {
		$this->_content = $content;
	}
	
	/**
	  * Add content
	  *
	  * @param string $content
	  * @return void
	  * @access public
	  */
	function addContent($content) {
		if (is_array($this->_content) && is_array($content)) {
			$this->_content = array_merge_recursive($this->_content, $content);
		} elseif (is_array($content)) {
			$this->_content = $content;
		} else {
			$this->_content .= $content;
		}
	}
	
	/**
	  * Get content
	  *
	  * @return string : the current view content
	  * @access public
	  */
	function getContent() {
		return $this->_content;
	}
	
	/**
	  * Set display mode
	  *
	  * @param string $mode
	  * @return void
	  * @access public
	  */
	function setDisplayMode($mode = '') {
		$this->_displayMode = ($mode) ? $mode : $this->_displayMode;
	}
	
	/**
	  * Get current display mode
	  *
	  * @return constant : display mode
	  * @access public
	  */
	function getDisplayMode() {
		return $this->_displayMode;
	}
	
	/**
	  * Set page title
	  *
	  * @param string $title
	  * @return void
	  * @access public
	  */
	function setTitle($title) {
		$this->_title = $title;
	}
	
	/**
	  * Set page action message
	  *
	  * @param string $message
	  * @return void
	  * @access public
	  */
	function setActionMessage($message) {
		$this->_actionmessage = $message;
	}
	
	/**
	  * Set disconnected status
	  *
	  * @param boolean $status
	  * @return void
	  * @access public
	  */
	function setDisconnected($status) {
		$this->_disconnected = ($status) ? true : false;
	}
	
	/**
	  * Add an error state to display later
	  *
	  * @param array $error : the error to add
	  * @return void
	  * @access public
	  */
	function addError($error) {
		$this->_errors[] = $error;
	}
	
	/**
	  * Get registered errors at current display mode format
	  *
	  * @param boolean $clean : reset errors stack (default false)
	  * @return string errors
	  * @access public
	  */
	function getErrors($clean = false) {
		$errors = '';
		switch ($this->_displayMode) {
			case self::SHOW_JSON :
			case self::SHOW_RAW :
			case self::SHOW_XML :
				$errors = sensitiveIO::jsonEncode($this->_errors);
			break;
			case self::SHOW_HTML :
			default:
				foreach ($this->_errors as $error) {
					$backTrace = ($error['backtrace']) ? ' (<a href="'.$error['backtrace'].'" target="_blank" class="admin">View BackTrace</a>)' : '';
					$errors .= '<pre><b>'.self::SYSTEM_LABEL.' '.AUTOMNE_VERSION.' error : '.$error['error'].$backTrace."</b></pre>\n";
				}
			break;
		}
		if ($clean) {
			$this->_errors = array();
		}
		return $errors;
	}
	
	/**
	  * Does the current view has errors registered ?
	  *
	  * @return boolean
	  * @access public
	  */
	function hasErrors() {
		return ($this->_errors);
	}
	
	/**
	  * Add an raw data to display later
	  *
	  * @param array $rawData : the raw data to add
	  * @return void
	  * @access public
	  */
	function addRawData($rawData) {
		$this->_rawdatas[] = $rawData;
	}
	
	/**
	  * Get registered raw datas at current display mode format
	  *
	  * @param boolean $clean : reset raw datas stack (default false)
	  * @return string raw datas
	  * @access public
	  */
	function getRawDatas($clean = false) {
		$datas = '';
		switch ($this->_displayMode) {
			case self::SHOW_JSON :
			case self::SHOW_RAW :
			case self::SHOW_XML :
				$datas = sensitiveIO::jsonEncode($this->_rawdatas);
			break;
			case self::SHOW_HTML :
			default:
				foreach ($this->_rawdatas as $rawdata) {
					$datas .= '<pre>'.$rawdata."</pre>\n";
				}
			break;
		}
		if ($clean) {
			$this->_rawdatas = array();
		}
		return $datas;
	}
	
	/**
	  * Does the current view has raw datas registered ?
	  *
	  * @return boolean
	  * @access public
	  */
	function hasRawDatas() {
		return ($this->_rawdatas);
	}
	
	/**
	  * Displays Admin page
	  * This method stop all further script execution
	  *
	  * @param mixed $mode : the display mode to use
	  * @return void
	  * @access public
	  */
	function show($mode = '')
	{
		$this->setDisplayMode($mode);
		header('X-Automne-Response: OK');
		switch ($this->_displayMode) {
			case self::SHOW_JSON :
			case self::SHOW_RAW :
			case self::SHOW_XML :
				header('Content-Type: text/xml; charset='.APPLICATION_DEFAULT_ENCODING, true);
				echo 
				'<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>'."\n".
				'<response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'."\n";
				$this->_showHead();
				$this->_showBody();
				echo '</response>';
			break;
			case self::SHOW_HTML :
			default:
				header('Content-Type: text/html; charset='.APPLICATION_DEFAULT_ENCODING, true);
				if ($this->_disconnected) {
					header("Location: ".PATH_ADMIN_SPECIAL_LOGIN_WR."?cms_action=logout");
					exit;
				}
				echo APPLICATION_XHTML_DTD."\n";
				echo '<html xmlns="http://www.w3.org/1999/xhtml">';
				$this->_showHead();
				$this->_showBody();
				echo '</html>';
			break;
		}
		$this->_sent = true;
		//this method must stop all further script execution
		exit;
	}
	
	/**
	  * Get all display content for a given display mode page
	  *
	  * @param mixed $mode : the display mode to use
	  * @return void
	  * @access public
	  */
	function get($mode = '') {
		$this->setDisplayMode($mode);
		$return = '';
		switch ($this->_displayMode) {
			case self::SHOW_JSON :
			case self::SHOW_RAW :
			case self::SHOW_XML :
				$return .= 
				'<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>'."\n".
				'<response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'."\n";
				$return .= $this->_showHead(true);
				$return .= $this->_showBody(true);
				$return .= '</response>';
			break;
		}
		$this->_sent = true;
		return $return;
	}
	
	/**
	  * add Automne copyright on generated HTML in backend
	  *
	  * @return string : the copyright to add
	  * @access private
	  */
	private function _copyright() {
		$copyright = "\n<!-- \n"
		."+----------------------------------------------------------------------+\n"
		."| Automne (TM) v".AUTOMNE_VERSION." www.automne.ws ".sprintf("%".(39 - io::strlen(AUTOMNE_VERSION))."s",  '')."|\n"
		."| Copyright (c) 2000-".date('Y')." WS Interactive www.ws-interactive.fr         |\n"
		."+----------------------------------------------------------------------+\n"
		."-->\n";
		return $copyright;
	}
	
	/**
	  * Set interface secure. Check request is made from a valid Automne Ajax
	  * Use http header
	  *
	  * @return string : the copyright to add
	  * @access public
	  */
	function setSecure($secure = true) {
		$this->_secure = $secure ? true : false;
		if ($this->_secure) {
			if (isset($_SERVER['HTTP_X_POWERED_BY']) && $_SERVER['HTTP_X_POWERED_BY'] == 'Automne' && isset($_SERVER['HTTP_X_ATM_TOKEN'])) {
				if (CMS_context::checkToken('admin', $_SERVER['HTTP_X_ATM_TOKEN'])) {
					return true;
				}
			}
			$this->raiseError('Unautorized query on a secure interface : Query on '.$_SERVER['SCRIPT_NAME'].' - from '.@$_SERVER['HTTP_REFERER']);
			//$this->raiseError(time());
			//$this->raiseError(print_r(CMS_context::getSessionVar('atm-tokens'), true));
			$this->setDisconnected(true);
			$this->show();
		}
	}
	
	/**
	  * Writes html header
	  *
	  * @return void
	  * @access private
	  */
	private function _showHead($returnValue = false) {
		switch ($this->_displayMode) {
			case self::SHOW_JSON :
			case self::SHOW_RAW :
			case self::SHOW_XML :
				$return = '';
				if ($this->hasErrors()) {
					$return .= 
					'	<error>1</error>'."\n".
					'	<errormessage><![CDATA['.$this->getErrors(true).']]></errormessage>'."\n";
				} else {
					$return .= 
					'	<error>0</error>'."\n";
				}
				if ($this->_secure && CMS_context::tokenIsExpired('admin')) {
					$token = CMS_context::getToken('admin');
					//pr('new token : '.$token);
					$return .= 
					'	<token><![CDATA['.$token.']]></token>'."\n";
				}
				if ($this->hasRawDatas()) {
					$return .= 
					'	<rawdatas><![CDATA['.$this->getRawDatas(true).']]></rawdatas>'."\n";
				}
				if ($this->_actionmessage) {
					$return .= 
					'	<message><![CDATA['.$this->_actionmessage.']]></message>'."\n";
				}
				if ($this->_title) {
					$return .= 
					'	<title><![CDATA['.$this->_title.']]></title>'."\n";
				}
				if ($this->_disconnected) {
					$return .= 
					'	<disconnected>1</disconnected>'."\n";
				}
				$scripts = CMS_scriptsManager::getScriptsNumberLeft();
				if ($scripts) {
					$return .= 
					'	<scripts>'.$scripts.'</scripts>'."\n";
				}
				if (SYSTEM_DEBUG && STATS_DEBUG) {
					$return .= 
					'	<stats><![CDATA['.view_stat(true).']]></stats>'."\n";
				}
				$jsfiles = CMS_view::getJavascript(array(), 'screen', true);
				if ($jsfiles) {
					$files = array(
						'files' 	=> $jsfiles,
						'manager'	=> CMS_view::getJSManagerURL()
					);
					$return .= 
					'	<jsfiles><![CDATA['.sensitiveIO::jsonEncode($files).']]></jsfiles>'."\n";
				}
				$cssfiles = CMS_view::getCSS(array(), 'screen', true);
				if ($cssfiles) {
					$files = array(
						'files' 	=> $cssfiles,
						'manager'	=> CMS_view::getCSSManagerURL()
					);
					$return .= 
					'	<cssfiles><![CDATA['.sensitiveIO::jsonEncode($files).']]></cssfiles>'."\n";
				}
				if (!$returnValue) {
					echo $return;
				} else {
					return $return;
				}
			break;
			case self::SHOW_HTML :
			default:
				$title = ($this->_title) ? '<title>'.APPLICATION_LABEL.' :: '.$this->_title.'</title>' : '';
				echo '<head>
						<meta http-equiv="Content-Type" content="text/html; charset='.APPLICATION_DEFAULT_ENCODING.'" />
						'.$title.'
						'.$this->_copyright().'
						<meta name="generator" content="'.CMS_grandFather::SYSTEM_LABEL.' '.AUTOMNE_VERSION.'" />
						'.CMS_view::getCSS().'
						'.CMS_view::getJavascript().'
					</head>';
					//<meta http-equiv="X-UA-Compatible" content="chrome=1">
			break;
		}
	}
	
	/**
	  * set content tag : overwrite default content tag used
	  *
	  * @param string $tag : the new content tag name to use for current display mode
	  * @return boolean
	  * @access private
	  */
	function setContentTag($tag) {
		if (!$tag) {
			return false;
		}
		$this->_contentTags[$this->_displayMode] = $tag;
		return true;
	}
	
	/**
	  * Shows body of html page
	  *
	  * @return void
	  * @access private
	  */
	private function _showBody($returnValue = false) {
		switch ($this->_displayMode) {
			case self::SHOW_JSON :
				$return = '';
				if ($this->_jscontent) {
					$return .= 
					'	<jscontent><![CDATA['.$this->_jscontent.']]></jscontent>'."\n";
				}
				if ($this->_content) {
					$return .= 
					'	<'.$this->_contentTags[$this->_displayMode].'><![CDATA['.sensitiveIO::jsonEncode($this->_content).']]></'.$this->_contentTags[$this->_displayMode].'>'."\n";
				}
				if (!$returnValue) {
					echo $return;
				} else {
					return $return;
				}
			break;
			case self::SHOW_RAW :
				$return = '';
				if ($this->_jscontent) {
					$return .= 
					'	<jscontent><![CDATA['.$this->_jscontent.']]></jscontent>'."\n";
				}
				if ($this->_content) {
					$return .= 
					'	<'.$this->_contentTags[$this->_displayMode].'><![CDATA['.$this->_content.']]></'.$this->_contentTags[$this->_displayMode].'>'."\n";
				}
				if (!$returnValue) {
					echo $return;
				} else {
					return $return;
				}
			break;
			case self::SHOW_XML :
				$return = '';
				if ($this->_jscontent) {
					$return .= 
					'	<jscontent><![CDATA['.$this->_jscontent.']]></jscontent>'."\n";
				}
				if ($this->_content) {
					//TODOV4 : check for XML conformity of $this->_content
					$return .= 
					'	<'.$this->_contentTags[$this->_displayMode].'>'.$this->_content.'</'.$this->_contentTags[$this->_displayMode].'>'."\n";
				}
				if (!$returnValue) {
					echo $return;
				} else {
					return $return;
				}
			break;
			case self::SHOW_HTML :
			default:
				echo '<body>';
				//display errors
				if ($this->hasErrors()) {
					echo $this->getErrors(true);
				}
				//display raw datas
				if ($this->hasRawDatas()) {
					echo $this->getRawDatas(true);
				}
				//display action message
				if ($this->_actionmessage) {
					echo $this->_actionmessage;
				}
				//display content
				echo $this->_content;
				echo '</body>';
			break;
		}
	}
	
	/**
	  * Redirect page to another one
	  * Take care of redirections inside Automne administration
	  *
	  * @param string $url : the url to redirect to
	  * @param boolean $exit : does the script must exit now ? (default : true)
	  * @param integer $type : the http redirection code to use. Accept 302 and 301 (default : 302)
	  * @return boolean
	  * @access private
	  */
	function redirect($url, $exit = true, $type = 302) {
		if ($type == 302) {
			header('HTTP/1.x 302 Found', true, 302);
		} elseif($type == 301) {
			header('HTTP/1.x 301 Moved Permanently', true, 301);
		}
		//in case of redirect in an admin frame, send to information page
		if (isset($_REQUEST['context']) && $_REQUEST['context'] == 'adminframe') {
			if (strpos($url, PATH_FORBIDDEN_WR) === 0 || strpos($url, PATH_SPECIAL_PAGE_NOT_FOUND_WR) === 0) {
				header('Location: '.$url);
			} else {
				$page = CMS_tree::analyseURL($url);
				if ($page && is_object($page) && !$page->hasError()) {
					header('Location: '.PATH_ADMIN_WR.'/page-redirect-info.php?pageId='.$page->getID());
				} else {
					header('Location: '.PATH_ADMIN_WR.'/page-redirect-info.php?url='.$url);
				}
			}
		} else {
			header('Location: '.$url);
		}
		if ($exit) {
			exit;
		}
		return true;
	}
}