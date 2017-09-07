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
  * Class CMS_auth
  *
  * Manage standard user authentification
  *
  * @package Automne
  * @subpackage user
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_auth extends CMS_grandFather implements Zend_Auth_Adapter_Interface
{
    var $_params;
	var $_result;
	var $_messages = array();
	
	const AUTH_MISSING_CREDENTIALS = 0;
	const AUTH_VALID_CREDENTIALS = 1;
	const AUTH_INVALID_CREDENTIALS = 2;
	const AUTH_INVALID_USER = 3;
	const AUTH_VALID_USER_SESSION = 4;
	const AUTH_INVALID_USER_SESSION = 5;
	const AUTH_AUTOLOGIN_VALID = 6;
	const AUTH_AUTOLOGIN_INVALID_USER = 7;
	const AUTH_INVALID_TOKEN = 8;
	const AUTH_SSOLOGIN_VALID = 9;
	const AUTH_SSOLOGIN_INVALID_USER = 10;
	
	/**
     * Set authentification paramaters
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->_params = $params;
    }
	
    /**
     * Try to authenticate user from :
	 * SSO
	 * COOKIE
	 * Given parameters
	 * SESSION
     *
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
		if (isset($this->_params['authType'])) {
			switch ($this->_params['authType']) {
				case 'credentials':
					if (isset($this->_params['login']) && isset($this->_params['password']) && $this->_params['login'] && $this->_params['password']) {
						//check token
						if (isset($this->_params['tokenName']) && $this->_params['tokenName']
							&& (!isset($this->_params['token']) || !$this->_params['token'] || !CMS_session::checkToken($this->_params['tokenName'], $this->_params['token']))) {
							
							$this->_messages[] = self::AUTH_INVALID_TOKEN;
							$this->_result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null, $this->_messages);
						} else {
							//check user credentials from DB
							$sql = "
								select
									id_pru
								from
									profilesUsers
								where
									login_pru = '".SensitiveIO::sanitizeSQLString($this->_params['login'])."'
									and (
										password_pru = '".SensitiveIO::sanitizeSQLString(md5($this->_params['password']))."'
										or password_pru = '{sha}".SensitiveIO::sanitizeSQLString(sha1($this->_params['password']))."'
									)
									and password_pru != ''
									and active_pru = 1
									and deleted_pru = 0
							";
							$q = new CMS_query($sql);
							if ($q->getNumRows()) {
								$userId = $q->getValue("id_pru");
								$this->_user = CMS_profile_usersCatalog::getByID($userId);
								if ($this->_user && !$this->_user->hasError() && !$this->_user->isDeleted() && $this->_user->isActive()) {
									$this->_messages[] = self::AUTH_VALID_CREDENTIALS;
									$this->_result = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_user->getUserId(), $this->_messages);
									//remove previous autologin cookie if exists
									if (isset($_COOKIE[CMS_session::getAutoLoginCookieName()])) {
										CMS_session::setCookie(CMS_session::getAutoLoginCookieName());
									}
									return $this->_result;
								} else {
									$this->_messages[] = self::AUTH_INVALID_USER;
									$this->_result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null, $this->_messages);
									$this->setError("user_id found don't instanciate a valid user object. ID : ".$userId);
								}
							} else {
								$this->_messages[] = self::AUTH_INVALID_CREDENTIALS;
								$this->_result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, null, $this->_messages);
								
								//wait a little (5 seconds) to avoid multiple simultaneous attempts
								sleep(5);
							}
						}
					}
				break;
				case 'session':
					$authStorage = new Zend_Auth_Storage_Session('atm-auth');
					$userId = $authStorage->read();
					if (io::isPositiveInteger($userId)) {
						if (!isset($this->_params['disconnect']) || !$this->_params['disconnect']) {
							//check user from session table
							if ($this->_checkSession($userId)) {
								$this->_user = CMS_profile_usersCatalog::getByID($userId);
								if ($this->_user && !$this->_user->hasError() && !$this->_user->isDeleted() && $this->_user->isActive()) {
									$this->_messages[] = self::AUTH_VALID_USER_SESSION;
									$this->_result = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_user->getUserId(), $this->_messages);
									return $this->_result;
								} else {
									$this->_messages[] = self::AUTH_INVALID_USER_SESSION;
									$this->_result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null, $this->_messages);
									//clear session content
									CMS_session::deleteSession(true);
								}
							} else {
								//clear session content
								CMS_session::deleteSession();
							}
						}
					}
				break;
				case 'cookie':
					if (isset($_COOKIE[CMS_session::getAutoLoginCookieName()])) {
						if (!isset($this->_params['disconnect']) || !$this->_params['disconnect']) {
							if (!$this->_autoLogin()) {
								//remove cookie
								CMS_session::setCookie(CMS_session::getAutoLoginCookieName());
							} else {
								return $this->_result;
							}
						}
					}
				break;
				case 'sso':
					if (!(isset($this->_params['login']) && isset($this->_params['password']) && $this->_params['login'] && $this->_params['password'])) {
						if (defined('MOD_STANDARD_SSO_LOGIN') && MOD_STANDARD_SSO_LOGIN) {
							$this->_user = CMS_profile_usersCatalog::getByLogin(MOD_STANDARD_SSO_LOGIN);
							if ($this->_user && !$this->_user->hasError()) {
								$this->_messages[] = self::AUTH_SSOLOGIN_VALID;
								$this->_result = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_user->getUserId(), $this->_messages);
								return $this->_result;
							} else {
								$this->_messages[] = self::AUTH_SSOLOGIN_INVALID_USER;
								$this->_result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null, $this->_messages);
							}
						} elseif (defined('MOD_STANDARD_SSO_FUNCTION') && MOD_STANDARD_SSO_FUNCTION) {
							if (is_callable(MOD_STANDARD_SSO_FUNCTION, false)) {//check if function/method name exists.
								$login = '';
								if (io::strpos(MOD_STANDARD_SSO_FUNCTION, '::') !== false) {//static method call
									$method = explode('::', MOD_STANDARD_SSO_FUNCTION);
									$login = call_user_func(array($method[0], $method[1]));
								} else { //function call
									$login = call_user_func(MOD_STANDARD_SSO_FUNCTION);
								}
								if ($login) {
									$this->_user = CMS_profile_usersCatalog::getByLogin($login);
									if ($this->_user && !$this->_user->hasError()) {
										$this->_messages[] = self::AUTH_SSOLOGIN_VALID;
										$this->_result = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_user->getUserId(), $this->_messages);
										return $this->_result;
									} else {
										$this->_messages[] = self::AUTH_SSOLOGIN_INVALID_USER;
										$this->_result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null, $this->_messages);
									}
								}
							} else {
								$this->setError('Cannot call SSO method/function: '.MOD_STANDARD_SSO_FUNCTION);
							}
						}
					}
				break;
				default:
					CMS_grandFather::raiseError('Unknown authType: '.$this->_params['authType']);
				break;
			}
		}
		//Nothing found
		if (!$this->_result) {
			$this->_messages[] = self::AUTH_MISSING_CREDENTIALS;
			$this->_result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, null, $this->_messages);
		}
		return $this->_result;
    }
    
    /**
	  * Get CMS_profile_user from his Id
	  * 
	  * @param integer $userId the user id to get
	  * @return CMS_profile_user, false otherwise
	  * @access public
	  */
    function getUser($userId) {
    	return CMS_profile_usersCatalog::getByID($userId);
    }
	
	/**
	  * Test user auto login from cookie values
	  * 
	  * @return boolean true if autologin accepted, false otherwise
	  * @access private
	  */
	function _autoLogin() {
		$attrs = @explode("|", base64_decode($_COOKIE[CMS_session::getAutoLoginCookieName()]));
		$id_ses = (int) $attrs[0];
		$session_id = $attrs[1];
		if ($id_ses > 0 && $session_id) {
			$sql = "
				select
					*
				from
					sessions
				where
					id_ses = '".SensitiveIO::sanitizeSQLString($id_ses)."'
					and phpid_ses = '".SensitiveIO::sanitizeSQLString($session_id)."'
					and cookie_expire_ses != '0000-00-00 00:00:00'
			";
			if (CHECK_REMOTE_IP_MASK && isset($_SERVER['REMOTE_ADDR'])) {
				//Check for a range in IPv4 or for the exact address in IPv6
				if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
					$a_ip_seq = explode(".", $_SERVER['REMOTE_ADDR']);
					$sql .= "and remote_addr_ses like '".SensitiveIO::sanitizeSQLString($a_ip_seq[0].".".$a_ip_seq[1].".")."%'
					";
				} else {
					$sql .= "and remote_addr_ses = '".SensitiveIO::sanitizeSQLString($_SERVER['REMOTE_ADDR'])."'
					";
				}
			}
			$q = new CMS_query($sql);
			if ($q->getNumRows() == 1) {
				$this->_user = CMS_profile_usersCatalog::getByID($q->getValue('user_ses'));
				if ($this->_user && !$this->_user->hasError() && !$this->_user->isDeleted() && $this->_user->isActive()) {
					$this->_messages[] = self::AUTH_AUTOLOGIN_VALID;
					$this->_result = new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_user->getUserId(), $this->_messages);
					return true;
				} else {
					$this->_messages[] = self::AUTH_AUTOLOGIN_INVALID_USER;
					$this->_result = new Zend_Auth_Result(Zend_Auth_Result::FAILURE, null, $this->_messages);
				}
			}
		}
		return false;
	}
	
	/**
	  * Test user auto login to see if it is active
	  * 
	  * @return boolean true if autologin is active, false otherwise
	  * @access public
	  * @static
	  */
	public static function autoLoginActive() {
		if (!isset($_COOKIE[CMS_session::getAutoLoginCookieName()])) {
			return false;
		}
		$attrs = @explode("|", base64_decode($_COOKIE[CMS_session::getAutoLoginCookieName()]));
		$id_ses = (int) $attrs[0];
		$session_id = $attrs[1];
		if ($id_ses > 0 && $session_id) {
			$sql = "
				select
					*
				from
					sessions
				where
					id_ses = '".SensitiveIO::sanitizeSQLString($id_ses)."'
					and phpid_ses = '".SensitiveIO::sanitizeSQLString($session_id)."'
					and cookie_expire_ses != '0000-00-00 00:00:00'
			";
			if (CHECK_REMOTE_IP_MASK && isset($_SERVER['REMOTE_ADDR'])) {
				//Check for a range in IPv4 or for the exact address in IPv6
				if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
					$a_ip_seq = explode(".", $_SERVER['REMOTE_ADDR']);
					$sql .= "and remote_addr_ses like '".SensitiveIO::sanitizeSQLString($a_ip_seq[0].".".$a_ip_seq[1].".")."%'
					";
				} else {
					$sql .= "and remote_addr_ses = '".SensitiveIO::sanitizeSQLString($_SERVER['REMOTE_ADDR'])."'
					";
				}
			}
			$q = new CMS_query($sql);
			if ($q->getNumRows() == 1) {
				return true;
			}
		}
		return false;
	}
	
	/**
	  * Checks if current session exists in session table
	  *
	  * @return void
	  * @access private
	  */
	function _checkSession($userId)
	{
		if (io::isPositiveInteger($userId)) {
			$sql = "
				select
					*
				from
					sessions
				where
					phpid_ses='".io::sanitizeSQLString(Zend_Session::getId())."'
					and user_ses='".io::sanitizeSQLString($userId)."'
					and UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(lastTouch_ses) <= ".io::sanitizeSQLString(APPLICATION_SESSION_TIMEOUT)."
			";
			if (CHECK_REMOTE_IP_MASK && isset($_SERVER['REMOTE_ADDR'])) {
				//Check for a range in IPv4 or for the exact address in IPv6
				if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
					$a_ip_seq = explode(".", $_SERVER['REMOTE_ADDR']);
					$sql .= " and remote_addr_ses like '".io::sanitizeSQLString($a_ip_seq[0].".".$a_ip_seq[1].".")."%'
					";
				} else {
					$sql .= " and remote_addr_ses = '".io::sanitizeSQLString($_SERVER['REMOTE_ADDR'])."'
					";
				}
			}
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				return true;
			}
		}
		return false;
	}
}
?>
