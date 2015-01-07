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
  * Class CMS_session
  *
  *  Keeps track of user session context and manage authentification with modules
  *
  * @package Automne
  * @subpackage user
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_session extends CMS_grandFather
{
	const MESSAGE_USER_JS_LOCALES = 1547;

	/**
	  * User DB ID
	  *
	  * @var integer
	  * @access private
	  */
	private static $_userID = 0;

	/**
	  * Bookmark for a page of data
	  *
	  * @var integer
	  * @access private
	  */
	private static $_bookmark = 1;

	/**
	  * How many per page of data by default ?
	  *
	  * @var integer
	  * @access private
	  */
	private static $_recordsPerPage = 30;

	/**
	  * Page DB ID
	  *
	  * @var integer
	  * @access private
	  */
	private static $_pageID;

	/**
	  * User tokens
	  *
	  * @var array
	  * @access private
	  */
	private static $_token;

	/**
	  * User use permanent session
	  *
	  * @var boolean
	  * @access private
	  */
	private static $_permanent = false;

	/**
	  * Authentification result
	  *
	  * @var Zend_Auth_Result
	  * @access private
	  */
	private static $_result;

	/**
     * Constructor overriding - make sure that a developer cannot instantiate
     */
    protected function __construct(){}

	/**
	  * Start session and load existant user if any
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	public static function init() {
		if (!@function_exists('session_name')) {
		    die('Session is not available');
		} elseif (ini_get('session.auto_start') == true && session_name() != 'AutomneSession') {
		    // Do not delete the existing session, it might be used by other
		    // applications; instead just close it.
		    session_write_close();
		}
		//if session already exists, return
		if (session_name() == 'AutomneSession') {
			return;
		}

		//check session dir as writable
		$sessionPath = session_save_path();
		if ($sessionPath && @is_dir($sessionPath) && !@is_writable($sessionPath)) {
			if(PATH_PHP_TMP && @is_dir(PATH_PHP_TMP) && is_object(@dir(PATH_PHP_TMP)) && is_writable(PATH_PHP_TMP)) {
				$sessionPath = PATH_PHP_TMP;
			} elseif (@is_dir(PATH_TMP_FS) && is_object(@dir(PATH_TMP_FS)) && is_writable(PATH_TMP_FS)){
				$sessionPath = PATH_TMP_FS;
			} else {
				CMS_grandFather::raiseError('Can\'t find writable session path ...');
			}
		}
		else {
			// $sessionPath is not a directory, we need to specify the save handler to Zend_Session
			$iniHandler = ini_get('session.save_handler');
			switch ($iniHandler) {
				case 'memcached':
				case 'memcache':
                    $saveHandler = new Zend_Session_SaveHandler_Cache();
                    $urlParts = parse_url($sessionPath);
                    $backendOptions = array();
                    if($urlParts !== false && isset($urlParts['host']) && isset($urlParts['port'])) {
                        $backendOptions = array(
                        'servers' => array(array(
                            'host'   => $urlParts['host'],
                            'port'   => $urlParts['port'],
                        ))
                      );
                    }
                    $backendName = ($iniHandler === 'memcached') ? 'Libmemcached' : 'Memcached';
                    $_cache = Zend_Cache::factory('Core', $backendName, array(), $backendOptions);
                    $saveHandler->setCache($_cache);
                    Zend_Session::setSaveHandler($saveHandler);

                    // disable phpmyadmin link as the sso mecanism isn't working
                    if(!defined('DISABLE_PHP_MYADMIN')) {
                        define('DISABLE_PHP_MYADMIN',true);
                    }
				default:
					// do nothing
					break;
			}

		}

		Zend_Session::setOptions(array(
			'name'					=> 'AutomneSession',
			'gc_maxlifetime'		=> APPLICATION_SESSION_TIMEOUT,
			'hash_function'			=> 1,		// use more secure session ids
			'use_cookies'			=> true,
			'use_only_cookies'		=> true,
			'cookie_lifetime'		=> 0,		// delete session cookies when browser is closed
			'cookie_path'			=> '/',
			'cookie_secure'			=> false,
			'cookie_domain'			=> APPLICATION_COOKIE_DOMAIN,
			'save_path'				=> $sessionPath,
			'cookie_httponly'		=> true,
			'remember_me_seconds'	=> (60 * 60 * 24 * APPLICATION_COOKIE_EXPIRATION),
			'use_trans_sid'			=> false,	//remove session trans sid to prevent session fixation
		));

		try {
			Zend_Session::start();
		} catch (Zend_Session_Exception $e) {
			CMS_grandFather::raiseError($e->getMessage());
		}
		//Then load existant user if any without launching authentification process
		CMS_session::authenticate(array('authenticate' => false));
	}

	/**
	  * Authenticate user
	  * This method can
	  * - authenticate user throught authentification process
	  * - load already authenticated user in current session (or SSO)
	  * - disconnect user
	  *
	  * @param array $params : indexed array of authentification parameters (default : nothing)
	  * Accepted array keys are :
	  * - authenticate : boolean : default true if disconnect is not set
	  * - disconnect : boolean : default false
	  * - login : string : user login to authenticate
	  * - password : string : user password to authenticate
	  * - remember : boolean : default false
	  * - tokenName : string
	  * - token : string
	  * - type : string : type of authentification (admin|frontend) : default APPLICATION_USER_TYPE contant
	  * - ... and any parameter needed by authentifications processes handled by modules
	  * @return void
	  * @access public
	  * @static
	  */
	public static function authenticate($params = array()) {
		//first clean old sessions datas from database
		CMS_session::_cleanSessions();

		// Get Zend Auth instance
		$auth = Zend_Auth::getInstance();

		// Use CMS_auth as session storage space
		$auth->setStorage(new Zend_Auth_Storage_Session('atm-auth'));
		//set authentification type
		if (!isset($params['type'])) {
			$params['type']	= APPLICATION_USER_TYPE;
		}
		//set permanent auth status
		if (isset($params['remember']) && $params['remember']) {
			self::$_permanent = true;
		} else {
			$params['remember'] = false;
		}
		//clear auth storage if disconnection is queried and set default authenticate value
		if (isset($params['disconnect']) && $params['disconnect']) {
			//log disconection if user exists
			$storageValue = $auth->getStorage()->read();
			if (io::isPositiveInteger($storageValue)) {
				//load user
				$user = CMS_profile_usersCatalog::getByID($storageValue);
				if ($user) {
					//log new session
					$log = new CMS_log();
					$log->logMiscAction(CMS_log::LOG_ACTION_DISCONNECT, $user, 'IP: '.@$_SERVER['REMOTE_ADDR'].', UA: '.@$_SERVER['HTTP_USER_AGENT']);
				}
			}

			//clear session content
			CMS_session::deleteSession(true);
			if (!isset($params['authenticate'])) {
				$params['authenticate'] = false;
			}
		} else {
			$params['disconnect'] = false;
			if (!isset($params['authenticate'])) {
				$params['authenticate'] = true;
			}
		}
		//init authenticated boolean
		$authenticated = false;
		//keep old storage value, because storage will be reseted by each module authentification
		$storageValue = $auth->getStorage()->read();
		//loop on each authentification types suupported
		foreach (array('credentials', 'session', 'cookie', 'sso') as $authType) {
			//load modules
			$modules = CMS_modulesCatalog::getAll('id');
			//get last module
			$module = array_pop($modules);
			//set authentification type as param
			$params['authType'] = $authType;
			//then try it for each modules
			do {
				//if module has auth method, try it
				if (method_exists($module, 'getAuthAdapter')) {
					//overwrite auth storage value with old value
					$auth->getStorage()->write($storageValue);
					//get module auth adapter
					$authAdapter = $module->getAuthAdapter($params);
                    if(!$authAdapter) {
                        $module = array_pop($modules);
                        continue;
                    }

					//authenticate user
					self::$_result = $auth->authenticate($authAdapter);

					//To debug Auth process easily, discomment this line
					//CMS_grandFather::log($_SERVER['SCRIPT_NAME'].' - '.$module->getCodename().' - Auth type : '.$authType.'/'.$params['type'].' - Auth result : '.self::$_result->getCode().($auth->hasIdentity() ? ' - Identity : '.$auth->getIdentity() : '').' - Message : '.(sizeof(self::$_result->getMessages()) == 1 ? array_pop(self::$_result->getMessages()) : print_r(self::$_result->getMessages(), true)));

					switch (self::$_result->getCode()) {
						case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND: //user crendentials does not exists (ex: no login/pass provided)
					        //nothing for now
						break;
						case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID: //invalid login/pass
					        //nothing for now
						break;
						case Zend_Auth_Result::SUCCESS:
							if ($auth->hasIdentity()) {
							    // get user from identity found
							    $user = $authAdapter->getUser($auth->getIdentity());
								//check if user is valid
								if (isset($user) && $user && !$user->hasError() && !$user->isDeleted() && $user->isActive()) {
									$authenticated = true;
									//overwrite auth identity with valid user Id
									$auth->getStorage()->write($user->getUserId());
								} else {
									unset($user);
								}
							}
						break;
						case Zend_Auth_Result::FAILURE: //user found but has error during loading (user inactive or deleted)
							//nothing for now
						break;
						default: //other unidentified cases : thrown an error
							CMS_grandFather::raiseError('Authentification return code '.self::$_result->getCode().' for module '.$module->getCodename().' with parameters '.print_r($params, true));
						break;
					}
				}
				//get next last module
				$module = array_pop($modules);
			} while (!$authenticated && $module);
			//if user is authenticated, break authentification foreach
			if ($authenticated) {
				break;
			}
		}

		//if authenticated : set or refresh session datas in table, regenerate session Id
		if ($authenticated && $user) {
			$q = new CMS_query("
			select
				id_ses, cookie_expire_ses
			from
				sessions
			where
				phpid_ses='".sensitiveIO::sanitizeSQLString(Zend_Session::getId())."'
				and user_ses='".sensitiveIO::sanitizeSQLString($user->getUserId())."'");
			//get old session Id
			$oldSessionId = Zend_Session::getId();
			if ($q->getNumRows() > 0) { //if session already exists : update it
				//regenerate session Id randomly (arround 1/100 times)
				//removed : cause session instability
				/*if (!rand(0, 100)) {
					//session id should not be regenerated each times because in case of a lot of concurrent calls, session can be destroyed
					Zend_Session::regenerateId();
				}*/
				$r = $q->getArray();
				$id = $r['id_ses'];

				//Cookie
				if (self::$_permanent || $r['cookie_expire_ses'] != '0000-00-00 00:00:00') {
					self::$_permanent = true;

					// Cookie expire in APPLICATION_COOKIE_EXPIRATION days
					$expires = time() + 60*60*24*APPLICATION_COOKIE_EXPIRATION;
					CMS_session::setCookie(CMS_session::getAutoLoginCookieName(), base64_encode($id.'|'.Zend_Session::getId()), $expires);
				}
				//DB session
				$sql = "
					update
						sessions
					set
						lastTouch_ses=NOW(),
						user_ses='".sensitiveIO::sanitizeSQLString($user->getUserId())."',
						phpid_ses='".sensitiveIO::sanitizeSQLString(Zend_Session::getId())."',
						remote_addr_ses='".sensitiveIO::sanitizeSQLString(@$_SERVER['REMOTE_ADDR'])."'";
				if (self::$_permanent) {
					$sql .= ",
						cookie_expire_ses = DATE_ADD(NOW(), INTERVAL ".APPLICATION_COOKIE_EXPIRATION." DAY)";
				}
				$sql .= "
					where
					 	id_ses='".sensitiveIO::sanitizeSQLString($id)."'";

				$q = new CMS_query($sql);

				//if autologin : log it
				if (in_array(CMS_auth::AUTH_AUTOLOGIN_VALID, self::$_result->getMessages())) {
					//log autologin session
					$log = new CMS_log();
					$log->logMiscAction(CMS_log::LOG_ACTION_AUTO_LOGIN, $user, 'IP: '.@$_SERVER['REMOTE_ADDR'].', UA: '.@$_SERVER['HTTP_USER_AGENT']);
				}

			} else { //otherwhise, create user session
				//regenerate session Id
				Zend_Session::regenerateId();
				//delete old session record if any
				$q = new CMS_query("
					delete
					from
						sessions
					where
						phpid_ses='".sensitiveIO::sanitizeSQLString($oldSessionId)."'");
				//insert new session record
				$sql = "
					insert into
						sessions
					set
						lastTouch_ses=NOW(),
						phpid_ses='".sensitiveIO::sanitizeSQLString(Zend_Session::getId())."',
						user_ses='".sensitiveIO::sanitizeSQLString($user->getUserId())."',
						remote_addr_ses='".sensitiveIO::sanitizeSQLString(@$_SERVER['REMOTE_ADDR'])."'
				";
				if (self::$_permanent) {
					$sql .= ",
					cookie_expire_ses = DATE_ADD(NOW(), INTERVAL ".APPLICATION_COOKIE_EXPIRATION." DAY)";
				}
				$q = new CMS_query($sql);

				if (!$q->hasError() && self::$_permanent) {
					// Cookie expire in APPLICATION_COOKIE_EXPIRATION days
					$expires = time() + 60*60*24*APPLICATION_COOKIE_EXPIRATION;
					CMS_session::setCookie(CMS_session::getAutoLoginCookieName(), base64_encode($q->getLastInsertedID().'|'.Zend_Session::getId()), $expires);
				}
				//log new session
				$log = new CMS_log();
				$log->logMiscAction(CMS_log::LOG_ACTION_LOGIN, $user, 'Permanent cookie: '.(self::$_permanent ? 'Yes' : 'No').', IP: '.@$_SERVER['REMOTE_ADDR'].', UA: '.@$_SERVER['HTTP_USER_AGENT']);
			}
			//set user as currently logged user
			self::$_userID = $user->getUserId();
		} else {
			if (APPLICATION_USER_TYPE == "frontend" && APPLICATION_ENFORCES_ACCESS_CONTROL) {
				//set public user as currently logged user
				self::$_userID = ANONYMOUS_PROFILEUSER_ID;
			}
		}
		//for backward compatibility
		$_SESSION["cms_context"] = new CMS_context();
	}

	/**
	  * Clean old sessions datas
	  *
	  * @return void
	  * @access private
	  */
	protected function _cleanSessions() {
		//fetch all deletable sessions
		$sql = "
			select
				*
			from
				sessions
			where
				(
					UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastTouch_ses) > ".io::sanitizeSQLString(APPLICATION_SESSION_TIMEOUT)."
					and cookie_expire_ses = '0000-00-00 00:00:00'
				) OR (
					cookie_expire_ses != '0000-00-00 00:00:00'
					and TO_DAYS(NOW()) >= cookie_expire_ses
				)
		";
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			// Remove locks
			while ($usr = $q->getValue("user_ses")) {
				$sql = "
					delete from
						locks
					where
						locksmithData_lok='".io::sanitizeSQLString($usr)."'
				";
				$qry = new CMS_query($sql);
			}
		 	// Delete all old sessions
			$sql = "
				delete from
					sessions
				where
					(
						UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastTouch_ses) > ".io::sanitizeSQLString(APPLICATION_SESSION_TIMEOUT)."
						and cookie_expire_ses = '0000-00-00 00:00:00'
					) or (
						cookie_expire_ses != '0000-00-00 00:00:00'
						and TO_DAYS(NOW()) >= cookie_expire_ses
					)
			";
			$q = new CMS_query($sql);
		}
	}

	/**
	  * Delete current session datas
	  *
	  * @param boolean $force : force removing persistent session (default false)
	  * @return void
	  * @access public
	  * @static
	  */
	static function deleteSession($force = false) {
		//clear session storage
		$authStorage = new Zend_Auth_Storage_Session('atm-auth');
		$authStorage->clear();
		//clear session table
		$sql = "
			delete
			from
				sessions
			where
				phpid_ses='".io::sanitizeSQLString(Zend_Session::getId())."'
		";
		if (!$force) { //keep session with persistent cookie
			$sql .= "
				and (
					UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastTouch_ses) > ".io::sanitizeSQLString(APPLICATION_SESSION_TIMEOUT)."
					and cookie_expire_ses = '0000-00-00 00:00:00'
				) or (
					cookie_expire_ses != '0000-00-00 00:00:00'
					and TO_DAYS(NOW()) >= cookie_expire_ses
				)
			";
		} else {
			//remove autologin cookie if exists
			if (isset($_COOKIE[CMS_session::getAutoLoginCookieName()])) {
				//remove cookie
				CMS_session::setCookie(CMS_session::getAutoLoginCookieName());
			}
		}
		$q = new CMS_query($sql);
		//remove phpMyAdmin cookies if any
		@setcookie(session_name(), false, time() - 3600, PATH_REALROOT_WR.'/automne/phpMyAdmin/', '', 0);
		@setcookie('phpMyAdmin', false, time() - 3600, PATH_REALROOT_WR.'/automne/phpMyAdmin/', '', 0);

		return true;
	}

	/**
	  * Get user object
	  *
	  * @return user object
	  * @access public
	  */
	public static function getUser() {
		if (!io::isPositiveInteger(self::$_userID)) {
			return false;
		}
		return CMS_profile_usersCatalog::getByID(self::$_userID);
	}

	/**
	  * Get user DB ID
	  *
	  * @return integer
	  * @access public
	  */
	public static function getUserID() {
		return self::$_userID;
	}

	/**
	  * Get permanent status for the session
	  *
	  * @return boolean
	  * @access public
	  */
	public static function getPermanent() {
		return self::$_permanent;
	}

	/**
	  * Get authentification result
	  *
	  * @return Zend_Auth_Result
	  * @access public
	  */
	public static function getAuthResult() {
		return self::$_result;
	}

	/**
	  * Set Bookmark
	  *
	  * @param integer $bookmark
	  * @return void
	  * @access public
	  */
	public static function setBookmark($bookmark) {
		if (io::isPositiveInteger($bookmark)) {
			self::$_bookmark = $bookmark;
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
	public static function getBookmark() {
		return self::$_bookmark;
	}

	/**
	  * Set The number of records per page
	  *
	  * @param integer $howMany
	  * @return void
	  * @access public
	  */
	public static function setRecordsPerPage($howMany) {
		if (SensitiveIO::isPositiveInteger($howMany)) {
			self::$_recordsPerPage = $howMany;
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
	public static function getRecordsPerPage() {
		return self::$_recordsPerPage;
	}

	/**
	  * Set Page
	  *
	  * @param CMS_page $page
	  * @return void
	  * @access public
	  */
	public static function setPage(&$page) {
		if ($page instanceof CMS_page) {
			$sessionNS = new Zend_Session_Namespace('atm-page');
			$sessionNS->pageId = $page->getID();
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
	public static function getPage() {
		$sessionNS = new Zend_Session_Namespace('atm-page');
		if (isset($sessionNS->pageId) && io::isPositiveInteger($sessionNS->pageId)) {
			return CMS_tree::getPageByID($sessionNS->pageId);
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
	public static function getPageID() {
		$sessionNS = new Zend_Session_Namespace('atm-page');
		if (!isset($sessionNS->pageId)) {
			return false;
		}
		return $sessionNS->pageId;
	}

	/**
	  * Sets session variable
	  *
	  * @param string $name
	  * @param mixed $value
	  * @return void
	  * @access public
	  */
	public static function setSessionVar($name, $value) {
		$sessionNS = new Zend_Session_Namespace('atm-context');
		$sessionNS->{$name} = $value;
		return $value;
	}

	/**
	  *  Gets session variable with name
	  *
	  * @param string $name
	  * @return void
	  * @access public
	  */
	public static function getSessionVar($name) {
		$sessionNS = new Zend_Session_Namespace('atm-context');
		return isset($sessionNS->{$name}) ? $sessionNS->{$name} : null;
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
	public static function setCookie($name, $value=false, $expire=false) {
		if ($value === false) {
			unset($_COOKIE[$name]);
			@setcookie($name, false, time()-42000, '/', APPLICATION_COOKIE_DOMAIN);
		} else {
			$_COOKIE[$name] = $value;
			@setcookie($name, $value, $expire, "/", APPLICATION_COOKIE_DOMAIN, 0, true);
		}
	}

	/**
	  * Get autologin cookie name
	  *
	  * @return string : the autologin cookie name
	  * @access public
	  * @static
	  */
	public static function getAutoLoginCookieName() {
		$input = APPLICATION_LABEL."_autologin";
		$sanitized = io::sanitizeAsciiString($input, '', '_-');
		return $sanitized;
	}

	/**
	  * Test auto login through cookie
	  *
	  * @return boolean true if autologin succeeded
	  * @access public
	  * @static
	  */
	public static function autoLoginSucceeded() {
		$result = CMS_session::getAuthResult();
		if (!$result) {
			return false;
		}
		return in_array(CMS_auth::AUTH_AUTOLOGIN_VALID, $result->getMessages()) || CMS_auth::autoLoginActive();
	}

	/**
	  * Get current session infos
	  *
	  * @return array : the user session infos
	  * @access public
	  * @static
	  */
	public static function getSessionInfos() {
		$sessionInfos = array();
		$user = CMS_session::getUser();
		if (!$user) {
			return array();
		}
		$sessionInfos['fullname'] = $user->getFullName();
		$sessionInfos['userId'] = $user->getUserId();
		$sessionInfos['language'] = $user->getLanguage()->getCode();
		$sessionInfos['scriptsInProgress'] = CMS_scriptsManager::getScriptsNumberLeft();
		$sessionInfos['hasValidations'] = $user->hasValidationClearance();
		$sessionInfos['awaitingValidation'] = CMS_modulesCatalog::getValidationsCount($user);
		$sessionInfos['applicationLabel'] = APPLICATION_LABEL;
		$sessionInfos['applicationVersion'] = AUTOMNE_VERSION;
		$sessionInfos['systemLabel'] = CMS_grandFather::SYSTEM_LABEL;
		$sessionInfos['token'] = CMS_session::getToken('admin');
		$sessionInfos['sessionDuration'] = APPLICATION_SESSION_TIMEOUT;
		$sessionInfos['permanent'] = CMS_session::getPermanent();
		$sessionInfos['path'] = PATH_REALROOT_WR;
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
	public static function getJSLocales() {
		$locales = '';
		$user = CMS_session::getUser();
		if (!$user) {
			return $locales;
		}
		//add all JS locales
		$language = $user->getLanguage();

		$languageCode = $language->getCode();

		//Get Ext locales
		if ($languageCode != 'en') { //english is defined as default language so we should not add it again
			$extLocaleFile = PATH_MAIN_FS.'/ext/src/locale/ext-lang-'.$languageCode.'.js';
			if (file_exists($extLocaleFile)) {
				$fileContent = file_get_contents($extLocaleFile);
				//remove BOM if any
				if(substr($fileContent, 0, 3) == 'ï»¿') {
					$fileContent = substr($fileContent, 3);
				}
				$locales .= (io::strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') ? utf8_decode($fileContent) : $fileContent;
			}
		}
		//add Automne locales
		$locales .= $language->getMessage(self::MESSAGE_USER_JS_LOCALES);
		return $locales;
	}

	/**
	  * Get a unique session token value for given token name
	  *
	  * @param string $name, token name to get value
	  * @return string : Token value
	  * @access public
	  */
	public static function getToken ($name) {
		$tokensDatas = CMS_session::getSessionVar('atm-tokens');
		$tokens = $tokensDatas['tokens'];
		$tokensTime = $tokensDatas['time'];
		$expiredTokens = $tokensDatas['expired'];
		$time = time();
		if (isset($tokens[$name])) {
			//token already exists so check age
			if (($time - $tokensTime[$name]) <= SESSION_TOKEN_MAXAGE) {
				//token is still valid, so return it
				return $tokens[$name];
			} else {
				//set old token into expired tokens
				$expiredTokens[$name] = $tokens[$name];
				$tokensTime[$name] = $time;
				unset($tokens[$name]);
			}
		}
		//token not exists or too old, create it
		$tokens[$name] = sha1(uniqid(rand(), TRUE));
		$tokensTime[$name] = $time;
		//save tokens datas
		$tokensDatas = array(
			'tokens'	=> $tokens,
			'time'		=> $tokensTime,
			'expired'	=> $expiredTokens
		);
		CMS_session::setSessionVar('atm-tokens', $tokensDatas);
		//return token value
		return $tokens[$name];
	}

	/**
	  * Check a session token value for a given token name
	  *
	  * @param string $name, token name to check
	  * @param string $token, token value to check
	  * @return boolean : true if token is valid or false otherwise
	  * @access public
	  */
	public static function checkToken ($name, $token) {
		//if session token check is disabled, always return true
		if (!defined('SESSION_TOKEN_CHECK') || !SESSION_TOKEN_CHECK) {
			return true;
		}
		$tokensDatas = CMS_session::getSessionVar('atm-tokens');
		$tokens = $tokensDatas['tokens'];
		$tokensTime = $tokensDatas['time'];
		$expiredTokens = $tokensDatas['expired'];
		$time = time();
		//check if token exists, verify value and not too old
		if (isset($tokens[$name]) && $tokens[$name] == $token && ($time - $tokensTime[$name]) <= SESSION_TOKEN_MAXAGE) {
			//token exists, is correct and not too old, return true
			return true;
		}
		//check if token exists, verify value and is too old
		if (isset($tokens[$name]) && $tokens[$name] == $token && ($time - $tokensTime[$name]) > SESSION_TOKEN_MAXAGE) {
			//token exists, is correct but too old, return true and set token as expired

			//set old token into expired tokens
			$expiredTokens[$name] = $tokens[$name];
			$tokensTime[$name] = $time;
			unset($tokens[$name]);

			//save tokens datas
			$tokensDatas = array(
				'tokens'	=> $tokens,
				'time'		=> $tokensTime,
				'expired'	=> $expiredTokens
			);
			CMS_session::setSessionVar('atm-tokens', $tokensDatas);

			return true;
		}
		//check if token expired but into expiration time
		if (isset($expiredTokens[$name]) && $expiredTokens[$name] == $token && ($time - $tokensTime[$name]) <= SESSION_EXPIRED_TOKEN_MAXAGE) {
			//token is expired but in exiration validity time, return true
			return true;
		}
		//in all other cases, return false
		return false;
	}

	/**
	  * Force a token expiration
	  *
	  * @param string $name, token name to expire
	  * @return boolean
	  * @access public
	  */
	public static function expireToken($name) {
		$tokensDatas = CMS_session::getSessionVar('atm-tokens');
		$tokens = $tokensDatas['tokens'];
		if (isset($tokens[$name])) {
			unset($tokens[$name]);
		}
		CMS_session::setSessionVar('atm-tokens', $tokensDatas);
		return true;
	}

	/**
	  * Check if a session token is expired for a given token name
	  *
	  * @param string $name, token name to check
	  * @return boolean : true if token is expired or false otherwise
	  * @access public
	  */
	public static function tokenIsExpired ($name) {
		//if session token check is disabled, always return false (token never expire)
		if (!defined('SESSION_TOKEN_CHECK') || !SESSION_TOKEN_CHECK) {
			return false;
		}
		$tokensDatas = CMS_session::getSessionVar('atm-tokens');
		$tokens = $tokensDatas['tokens'];
		$tokensTime = $tokensDatas['time'];
		$expiredTokens = $tokensDatas['expired'];
		$time = time();
		if (!isset($tokens[$name])
			 || (isset($tokens[$name]) && ($time - $tokensTime[$name]) > SESSION_TOKEN_MAXAGE)) {
			return true;
		}
		return false;
	}

	/**
	  * Get current context hash (usually used for cache)
	  *
	  * @param array $datas, additionnal datas to use for cache
	  * @return string : the current context cache
	  * @access public
	  * @static
	  */
	public static function getContextHash($datas = array()) {
		global $cms_user;
		$aContextRef = array();
		//external datas
		$aContextRef['datas'] = $datas;
		//user if any
		if (is_object($cms_user)) {
			$aContextRef['user'] = $cms_user;
		}
		//get vars
		$aContextRef['get'] = $_GET;
		//remove specific Automne vars
		if (isset($aContextRef['get']['_dc'])) {
			unset($aContextRef['get']['_dc']);
		}
		if (isset($aContextRef['get']['context'])) {
			unset($aContextRef['get']['context']);
		}
		//sort get datas
		ksort($aContextRef['get']);
		//post vars
		$aContextRef['post'] = $_POST;
		//sort post datas
		ksort($aContextRef['post']);
		$return = md5(serialize($aContextRef));

		return $return;
	}
}
?>
