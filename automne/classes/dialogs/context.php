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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr>                |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: context.php,v 1.4 2009/04/02 13:57:59 sebastien Exp $

/**
  * Class CMS_context
  *
  *  Keeps track of dialog context
  *
  * @package CMS
  * @subpackage dialogs
  * @author Antoine Pouch <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_context extends CMS_grandFather
{
	/**
	  * User DB ID
	  *
	  * @var integer
	  * @access private
	  */
	protected $_userID = 0;
	
	/**
	  * Bookmark for a page of data
	  *
	  * @var integer
	  * @access private
	  */
	protected $_bookmark = 1;
	
	/**
	  * How many per page of data by default ?
	  *
	  * @var integer
	  * @access private
	  */
	protected $_recordsPerPage = 30;
	
	/**
	  * Page DB ID
	  *
	  * @var integer
	  * @access private
	  */
	protected $_pageID;
	
	/**
	  * Constructor.
	  * Initializes the user with given login/pass. Raises error if not found.
	  *
	  * @param string $login The user login
	  * @param string $password The user password
	  * @param boolean $permanent_cookie, set to true if we want to allow
	  * permanent connexion for user (autologin)
	  * @return void
	  * @access public
	  */
	function __construct($login, $password, $permanent_cookie=0)
	{
		if (isset($_COOKIE[CMS_context::getAutoLoginCookieName()]) && !$login || !$password) {
			if (!$this->autoLogin()) {
				//remove cookie
				CMS_context::setCookie(CMS_context::getAutoLoginCookieName());
			}
			return;
		}
		// Authenficiation can be processed through LDAP directory
		// unless anonymous connexion awaited
		if (defined('APPLICATION_LDAP_AUTH') && APPLICATION_LDAP_AUTH
				&& $login != DEFAULT_USER_LOGIN) {
			$auth = new CMS_ldap_auth(APPLICATION_LDAP_DEFAULT_GROUP);
			if ($auth->authenticate($login, $password)) {
				$user = $auth->getUser();
				if (is_a($user, 'CMS_profile_user')) {
			 		$this->_startSession($user, $permanent_cookie);
				} else {
					$this->raiseError("Invalid profile returned by authentification");
				}
			} else {
				$this->raiseError("Bad login/password passed to LDAP directory");
			}
		} else {
			$sql = "
				select
					id_pru
				from
					profilesUsers
				where
					login_pru='".SensitiveIO::sanitizeSQLString($login)."'
					and password_pru='".SensitiveIO::sanitizeSQLString(md5($password))."'
					and active_pru=1
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$user = CMS_profile_usersCatalog::getByID($q->getValue("id_pru"));
				if (!$user->hasError()) {
			 		$this->_startSession($user, $permanent_cookie);
				} else {
					$this->raiseError("user_id found don't instanciate a valid user object. ID : ".$user->getUserID());
				}
			} else {
				$this->setDebug(false);
				$this->raiseError("Bad login/password");
			}
		}
		
		if ($this->hasError()) {
			//wait a little (2 seconds) to avoid multiple simultaneous attempts
			$start = gettimeofday();
			$timePassed = 0;
			while ($timePassed < 5) {
				$stop = gettimeofday();
				$timePassed = $stop['sec'] - $start['sec'];
			}
		}
	}
	
	/**
	  * Starts a new session for given user
	  * Stores user's ID in context and starts session
	  * 
	  * @param CMS_profile_user $user, authenticated and valid user
	  * @param boolean $permanent_cookie, set to true if we want to allow
	  * permanent connexion for user (autologin)
	  * @return void
	  * @access private
	  */
	protected function _startSession($user, $permanent_cookie)
	{
		if (is_a($user, "CMS_profile_user")) {
			$this->_userID = $user->getUserId();
			$sql = "
			select 
				id_ses 
			from 
				sessions 
			where 
				phpid_ses='".sensitiveIO::sanitizeSQLString(session_id())."' 
				and user_ses='".sensitiveIO::sanitizeSQLString($this->_userID)."'";
			$q = new CMS_query($sql);
			if ($q->getNumRows() > 0) {
				//delete old session record
				$sql = "
					delete from
						sessions
					where id_ses = '".$q->getValue('id_ses')."'";
				$q = new CMS_query($sql);
			}
			$sql = "
				insert into
					sessions
				set
					lastTouch_ses=NOW(),
					phpid_ses='".sensitiveIO::sanitizeSQLString(session_id())."',
					user_ses='".sensitiveIO::sanitizeSQLString($this->_userID)."',
					remote_addr_ses='".sensitiveIO::sanitizeSQLString($_SERVER['REMOTE_ADDR'])."',
					http_user_agent_ses='".sensitiveIO::sanitizeSQLString($_SERVER['HTTP_USER_AGENT'])."'
			";
			if ($permanent_cookie) {
				$sql .= ",
				cookie_expire_ses = DATE_ADD(NOW(), INTERVAL ".APPLICATION_COOKIE_EXPIRATION." DAY)";
			}
			$q = new CMS_query($sql);
			if (!$q->hasError() && $permanent_cookie) {
				// Cookie expire in APPLICATION_COOKIE_EXPIRATION days
				$expires = time() + 60*60*24*APPLICATION_COOKIE_EXPIRATION;
				CMS_context::setCookie(CMS_context::getAutoLoginCookieName(), base64_encode($q->getLastInsertedID().'|'.session_id()), $expires);
			}
			$this->checkSession();
		}
	}
	
	/**
	  * Get user object
	  *
	  * @return user object
	  * @access public
	  */
	function getUser()
	{
		return CMS_profile_usersCatalog::getByID($this->_userID);
	}
	
	/**
	  * Get user DB ID
	  *
	  * @return integer
	  * @access public
	  */
	function getUserID()
	{
		return $this->_userID;
	}
	
	/**
	  * Set Bookmark
	  *
	  * @param integer $bookmark
	  * @return void
	  * @access public
	  */
	function setBookmark($bookmark)
	{
		
		if (SensitiveIO::isPositiveInteger($bookmark)) {
			$this->_bookmark = $bookmark;
		} else {	
			$this->raiseError("Incorrect bookmark type");
		}
	}
	
	/**
	  * Get Bookmark
	  *
	  * @return integer
	  * @access public
	  */
	function getBookmark()
	{
		return $this->_bookmark;
	}
	
	/**
	  * Set The number of records per page
	  *
	  * @param integer $howMany
	  * @return void
	  * @access public
	  */
	function setRecordsPerPage($howMany)
	{
		if (SensitiveIO::isPositiveInteger($howMany)) {
			$this->_recordsPerPage = $howMany;
		} else {	
			$this->raiseError("Not a positive value");
		}
	}
	
	/**
	  * Get the number of records per page
	  *
	  * @return integer
	  * @access public
	  */
	function getRecordsPerPage()
	{
		return $this->_recordsPerPage;
	}
	
	/**
	  * Set Page
	  *
	  * @param CMS_page $page
	  * @return void
	  * @access public
	  */
	function setPage(&$page)
	{
		if (is_a($page,"CMS_page")) {
			$this->_pageID = $page->getID();
		} else {	
			$this->raiseError("Incorrect Page type");
		}
	}
	
	/**
	  * Get Page
	  *
	  * @return CMS_page The page currently registered, false if none
	  * @access public
	  */
	function getPage()
	{
		if ($this->_pageID) {
			return CMS_tree::getPageByID($this->_pageID);
		} else {
			return false;
		}
	}
	
	/**
	  * Get Page ID
	  *
	  * @return integer
	  * @access public
	  */
	function getPageID()
	{
		return $this->_pageID;
	}
	
	/**
	  * Sets session variable
	  *
	  * @param string $name
	  * @param mixed $value
	  * @return void
	  * @access public|private}
	  */
	function setSessionVar($name, $value)
	{
		$_SESSION[$name] = $value ;
		return $value;
	}
	
	/**
	  *  Gets session variable with name 
	  *
	  * @param string $name
	  * @return void
	  * @access public
	  */
	function getSessionVar($name)
	{
		return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
	}
	
	/**
	  * Updates and checks current session
	  *
	  * @return void
	  * @access public
	  */
	function checkSession()
	{
		//fetch all deletable sessions
		$sql = "
			select
				*
			from
				sessions
			where
				(
					UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastTouch_ses) > ".APPLICATION_SESSION_TIMEOUT."
					and cookie_expire_ses = '0000:00:00 00:00:00'
				) OR (
					cookie_expire_ses != '0000:00:00 00:00:00'
					and TO_DAYS(NOW()) >= cookie_expire_ses
				)
		";
		//$date = new CMS_date();
		//$date->raiseError($sql);
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			// Remove locks
			while ($usr = $q->getValue("user_ses")) {
				$sql = "
					delete from 
						locks 
					where 
						locksmithData_lok='".$usr."'
				";
				$qry = new CMS_query($sql);
			}
		 	// Delete all old sessions
			$sql = "
				delete from
					sessions 
				where
					(
						UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastTouch_ses) > ".APPLICATION_SESSION_TIMEOUT."
						and cookie_expire_ses = '0000:00:00 00:00:00'
					) or (
						cookie_expire_ses != '0000:00:00 00:00:00'
						and TO_DAYS(NOW()) >= cookie_expire_ses
					)
			";
			$q = new CMS_query($sql);
		}
		
		if ($this->_userID) {
			/*we check to see if the user isn't relogging (i.e. session exists in table). 
			 If so, we just update the user and date */
			$sql = "
				select
					*
				from
					sessions
				where
					phpid_ses='".session_id()."'
					and http_user_agent_ses like '".SensitiveIO::sanitizeSQLString($_SERVER['HTTP_USER_AGENT'])."'
			";
			if (CHECK_REMOTE_IP_MASK) {
				//Check for a range in IPv4 or for the exact address in IPv6
				if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
					$a_ip_seq = @explode(".", $_SERVER['REMOTE_ADDR']);
					$sql .= " and remote_addr_ses like '".SensitiveIO::sanitizeSQLString($a_ip_seq[0].".".$a_ip_seq[1].".")."%'
					";
				} else {
					$sql .= " and remote_addr_ses = '".SensitiveIO::sanitizeSQLString($_SERVER['REMOTE_ADDR'])."'
					";
				}
			}
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$sql = "
					update 
						sessions 
					set
						lastTouch_ses=NOW(),
						user_ses='$this->_userID'
					where
					 	phpid_ses='".session_id()."'
				";
				$q = new CMS_query($sql);
			} else {
				@session_destroy();
				unset($this);
				// if admin page, send user to login page
				if(APPLICATION_USER_TYPE == 'admin') {
					//load interface instance
					$view = CMS_view::getInstance();
					//set disconnected status
					$view->setDisconnected(true);
					//$view->show();
				}
			}
		} else {
			@session_destroy();
			unset($this);
			// if admin page, send user to login page
			if(APPLICATION_USER_TYPE == 'admin') {
				//load interface instance
				$view = CMS_view::getInstance();
				//set disconnected status
				$view->setDisconnected(true);
				//$view->show();
			}
		}
		
		//clean locks not corresponding to a session, unless they are labeled "PERMANENT" except if its a frontend user (APPLICATION_ENFORCES_ACCESS_CONTROL)
		if (!(APPLICATION_ENFORCES_ACCESS_CONTROL && APPLICATION_USER_TYPE=='frontend')) {
			$sql = "
				select 
					id_lok
				from
					locks
				left join
					sessions
				on 	
					locksmithData_lok=user_ses
				where
					id_ses is null 
			";
			$q = new CMS_query($sql);
			while ($lock_id = $q->getValue("id_lok")) {
				$sql = "
					delete from 
						locks 
					where 
						id_lok='".$lock_id."'
				";
				$qry = new CMS_query($sql);
			}
			//check the page in session. If invalid (or outside userspace), remove
			if ($this->_pageID && class_exists('CMS_tree') && class_exists('CMS_page')) {
				$pg = CMS_tree::getPageByID($this->_pageID);
				if (!is_a($pg, "CMS_page") || $pg->getLocation() != RESOURCE_LOCATION_USERSPACE) {
					$this->_pageID = false;
				}
			}
		}
	}
	
	/**
	  * Test user auto logon from cookie values
	  * 
	  * @return boolean true if autologin accepted, false otherwise
	  * @access public
	  */
	function autoLogin() {
		$attrs = @explode("|", base64_decode($_COOKIE[CMS_context::getAutoLoginCookieName()]));
		$id_ses = (int) $attrs[0];
		$session_id = $attrs[1];
		if ($id_ses > 0 && $session_id) {
			$sql = "
				select
					*
				from
					sessions
				where
					id_ses='".SensitiveIO::sanitizeSQLString($id_ses)."'
					and phpid_ses='".SensitiveIO::sanitizeSQLString($session_id)."'
					and http_user_agent_ses like '".SensitiveIO::sanitizeSQLString($_SERVER['HTTP_USER_AGENT'])."'
					and cookie_expire_ses != '0000:00:00 00:00:00'
			";
			if (CHECK_REMOTE_IP_MASK) {
				//Check for a range in IPv4 or for the exact address in IPv6
				if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
					$a_ip_seq = @explode(".", $_SERVER['REMOTE_ADDR']);
					$sql .= "and remote_addr_ses like '".SensitiveIO::sanitizeSQLString($a_ip_seq[0].".".$a_ip_seq[1].".")."%'
					";
				} else {
					$sql .= "and remote_addr_ses = '".SensitiveIO::sanitizeSQLString($_SERVER['REMOTE_ADDR'])."'
					";
				}
			}
			$q = new CMS_query($sql);
			if ($q->getNumRows() == 1) {
				$user = CMS_profile_usersCatalog::getByID($q->getValue('user_ses'));
				if (!$user->hasError()) {
			 		$this->_startSession($user, true);
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	  * Test auto login through cookie
	  *
	  * @return boolean true if autologin succeeded
	  * @access public
	  * @static
	  */
	static function autoLoginSucceeded() {
		if (isset($_COOKIE[CMS_context::getAutoLoginCookieName()])) {
			$cms_context = new CMS_context("", "", true);
			if (!$cms_context->hasError()) {
				$_SESSION["cms_context"] = $cms_context;
				return true;
			}
			CMS_context::setCookie(CMS_context::getAutoLoginCookieName());
		}
		return false;
	}
	
	/**
	  * Reset current session ID and cookies
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	static function resetSessionCookies() {
		//Regenerate session id
		//session_id(md5(uniqid(mt_rand(), true)));
		session_regenerate_id(true);
		//Start session
		//start_atm_session();
		//unset session
		unset($_SESSION) ;
		//remove cookies
		if (isset($_COOKIE[session_name()])) {
			CMS_context::setCookie(session_name());
		}
		if (isset($_COOKIE[CMS_context::getAutoLoginCookieName()])) {
			CMS_context::setCookie(CMS_context::getAutoLoginCookieName());
		}
		//remove phpMyAdmin cookie if any
		@setcookie(session_name(), '', time() - 3600, '/automne/phpMyAdmin/', '', 0);
		//then destroy session
		@session_destroy();
	}
	
	/**
	  * Sets a cookie given at least its name
	  * If value is empty, deletes cookie
	  * 
	  * @param string $name, cookie name
	  * @param string $value, the value to store
	  * @param int $expire, represents time in which cookie will expire
	  * if not set, expires at the end of the session
	  * @access public
	  * @static
	  */
	static function setCookie($name, $value=false, $expire=false) {
		if (!$value) {
			unset($_COOKIE[$name]);
			@setcookie($name, $value, time()-42000, '/');
		} else {
			$_COOKIE[$name] = $value;
			@setcookie($name, $value, $expire, "/");
		}
	}
	
	/**
	  * Get autologin cookie name
	  * 
	  * @return string : the autologin cookie name
	  * @access public
	  * @static
	  */
	static function getAutoLoginCookieName() {
		$input = APPLICATION_LABEL."_autologin";
		$sanitized = strtr($input, " àâäéèëêïîöôùüû", "_aaaeeeeiioouuu");
		$sanitized = ereg_replace("[^[a-zA-Z0-9_-]]*", "", $sanitized); //TODOV4
		return $sanitized;
	}
	
	/**
	  * Get current session infos
	  * 
	  * @return array : the user session infos
	  * @access public
	  * @static
	  */
	static function getSessionInfos() {
		if (!isset($_SESSION["cms_context"])) {
			return array();
		}
		$sessionInfos = array();
		$user = $_SESSION["cms_context"]->getUser();
		$sessionInfos['fullname'] = $user->getFullName();
		$sessionInfos['userId'] = $user->getUserId();
		$sessionInfos['language'] = $user->getLanguage()->getCode();
		$sessionInfos['animation'] = $user->getAnimation();
		$sessionInfos['tooltips'] = $user->getTooltips();
		$sessionInfos['scriptsInProgress'] = CMS_scriptsManager::getScriptsNumberLeft();
		$sessionInfos['hasValidations'] = $user->hasValidationClearance();
		$sessionInfos['awaitingValidation'] = CMS_modulesCatalog::getValidationsCount($user);
		$sessionInfos['applicationLabel'] = APPLICATION_LABEL;
		$sessionInfos['applicationVersion'] = AUTOMNE_VERSION;
		$sessionInfos['systemLabel'] = CMS_grandFather::SYSTEM_LABEL;
		
		$sessionInfos['debug'] = '';
		$sessionInfos['debug'] += (SYSTEM_DEBUG) ? 1 : 0;
		$sessionInfos['debug'] += (STATS_DEBUG) ? 2 : 0;
		$sessionInfos['debug'] += (POLYMOD_DEBUG) ? 4 : 0;
		$sessionInfos['debug'] += (VIEW_SQL) ? 8 : 0;
		
		return $sessionInfos;
	}
	
	/**
	  * Get all JS locales for current user (in current language)
	  *
	  * @return string : JS locales
	  * @access public
	  */
	function getJSLocales() {
		$locales = '';
		if (!isset($_SESSION["cms_context"])) {
			return $locales;
		}
		$user = $_SESSION["cms_context"]->getUser();
		//add all JS locales
		$languageCode = $user->getLanguage()->getCode();
		
		//Get Ext locales
		if ($languageCode != 'en') { //english is defined as default language so we should not add it again
			$extLocaleFile = PATH_MAIN_FS.'/ext/source/locale/ext-lang-'.$languageCode.'.js';
			if (file_exists($extLocaleFile)) {
				$fileContent = file_get_contents($extLocaleFile);
				//remove BOM if any
				if(substr($fileContent, 0, 3) == 'ï»¿') {
					$fileContent = substr($fileContent, 3);
				}
				$locales .= (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? utf8_decode($fileContent) : $fileContent;
			}
		}
		//add Automne locales
		$atmLocaleFile = PATH_ADMIN_FS.'/js/locales/'.$languageCode.'.js';
		if (is_file($atmLocaleFile)) {
			$locales .= (strtolower(APPLICATION_DEFAULT_ENCODING) == 'utf-8') ? utf8_encode(file_get_contents($atmLocaleFile)) : file_get_contents($atmLocaleFile);
		}
		return $locales;
	}
}
?>