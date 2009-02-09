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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: view.php,v 1.4 2009/02/09 10:03:05 sebastien Exp $

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
		$jsarray = (isset($this) && isset($this->_js)) ? $this->_js : $jsarray;
		$version = AUTOMNE_VERSION.'-'.AUTOMNE_SUBVERSION.(SYSTEM_DEBUG ? 'd':'');
		$return = '';
		if ($onlyFiles) {
			return $jsarray;
		}
		if ($jsarray) {
			$return .= '<script src="'.CMS_view::getJSManagerURL().'&amp;files='.implode(',',$jsarray).'" type="text/javascript"></script>'."\n";
		}
		if (isset($this) && isset($this->_jscontent) && $this->_jscontent) {
			$return .= "\n".'<script type="text/javascript">'.$this->_jscontent.'</script>'."\n";
		}
		return $return;
	}
	
	function addJSFile($js) {
		if (!in_array($js, $this->_js)) {
			$this->_js[] = $js;
		}
	}
	
	function addJavascript($js) {
		$this->_jscontent .= $js;
	}
	
	function getJSManagerURL() {
		$version = AUTOMNE_VERSION.'-'.AUTOMNE_SUBVERSION.(SYSTEM_DEBUG ? 'd':'');
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
		$version = AUTOMNE_VERSION.'-'.AUTOMNE_SUBVERSION.(SYSTEM_DEBUG ? 'd':'');
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
		if ($view->hasErrors()) {
			echo $view->getErrors();
		}
		if ($view->hasRawDatas()) {
			echo $view->getRawDatas();
		}
		exit;
	}
	
	/**
	  * Redirect to page according to current mode
	  *
	  * @param string $redirect
	  * @return void
	  * @access public
	  */
	function redirect($redirect) {
		//TODOV4
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
		switch ($this->_displayMode) {
			case self::SHOW_JSON :
			case self::SHOW_RAW :
			case self::SHOW_XML :
				header('Content-Type: text/xml');
				echo 
				'<?xml version="1.0" encoding="'.APPLICATION_DEFAULT_ENCODING.'"?>'."\n".
				'<response xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">'."\n";
				$this->_showHead();
				$this->_showBody();
				echo '</response>';
			break;
			case self::SHOW_HTML :
			default:
				header('Content-Type: text/html');
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
		//this method must stop all further script execution
		exit;
	}
	
	/**
	  * add Automne copyright on generated HTML in backend
	  *
	  * @return string : the copyright to add
	  * @access private
	  */
	private function _copyright()
	{
		$copyright = "\n<!-- \n"
		."+----------------------------------------------------------------------+\n"
		."| Automne (TM) v".AUTOMNE_VERSION." www.automne.ws ".sprintf("%".(39 - strlen(AUTOMNE_VERSION))."s",  '')."|\n"
		."| Copyright (c) 2000-".date('Y')." WS Interactive www.ws-interactive.fr         |\n"
		."+----------------------------------------------------------------------+\n"
		."-->\n";
		return $copyright;
	}
	
	/**
	  * Writes html header
	  *
	  * @return void
	  * @access private
	  */
	private function _showHead() {
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
				echo $return;
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
			break;
		}
	}
	
	/**
	  * Shows body of html page
	  *
	  * @return void
	  * @access private
	  */
	private function _showBody() {
		switch ($this->_displayMode) {
			case self::SHOW_JSON :
				$return = '';
				if ($this->_jscontent) {
					$return .= 
					'	<jscontent><![CDATA['.$this->_jscontent.']]></jscontent>'."\n";
				}
				if ($this->_content) {
					$return .= 
					'	<jsoncontent><![CDATA['.sensitiveIO::jsonEncode($this->_content).']]></jsoncontent>'."\n";
				}
				echo $return;
			break;
			case self::SHOW_RAW :
				$return = '';
				if ($this->_jscontent) {
					$return .= 
					'	<jscontent><![CDATA['.$this->_jscontent.']]></jscontent>'."\n";
				}
				if ($this->_content) {
					$return .= 
					'	<content><![CDATA['.$this->_content.']]></content>'."\n";
				}
				echo $return;
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
					'	<content>'.$this->_content.'</content>'."\n";
				}
				echo $return;
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
}