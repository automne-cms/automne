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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr>                |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Class CMS_context
  *
  *  Keeps track of dialog context
  *
  * @package Automne
  * @subpackage deprecated
  * @author Antoine Pouch <andre.haynes@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_context extends CMS_grandFather
{
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
	public function __construct($login = '', $password = '', $permanent_cookie=0, $token = null)
	{
		if ($login && $password) {
			$params = array(
				'login'		=> $login,
				'password'	=> $password,
				'remember'	=> $permanent_cookie ? true : false,
				'tokenName'	=> 'xxx',
				'token'		=> $token,
				'disconnect'=> false,
			);
			CMS_session::authenticate($params);
		}
	}
	
	public function __call($name, $arguments) {
		if (is_callable(array('CMS_session', $name))) {
			return call_user_func_array(array('CMS_session', $name) , $arguments );
		} else {
			CMS_grandFather::raiseError('unkown method '.$name.' in CMS_context');
		}
	}
	
	/**
	  * Reset current session ID and cookies
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	public static function resetSessionCookies() {
		// Disconnect user
		CMS_session::authenticate(array('disconnect'=> true));
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
		return CMS_session::setSessionVar($name, $value);
	}
	
	/**
	  *  Gets session variable with name 
	  *
	  * @param string $name
	  * @return void
	  * @access public
	  */
	public static function getSessionVar($name) {
		return CMS_session::getSessionVar($name);
	}
	
	/**
	  * Test auto login through cookie
	  *
	  * @return boolean true if autologin succeeded
	  * @access public
	  * @static
	  */
	public static function autoLoginSucceeded() {
		return CMS_session::autoLoginSucceeded();
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
		return CMS_session::setCookie($name, $value, $expire);
	}
	
	/**
	  * Get autologin cookie name
	  * 
	  * @return string : the autologin cookie name
	  * @access public
	  * @static
	  */
	public static function getAutoLoginCookieName() {
		return CMS_session::getAutoLoginCookieName();
	}
	
	/**
	  * Get current session infos
	  * 
	  * @return array : the user session infos
	  * @access public
	  * @static
	  */
	public static function getSessionInfos() {
		return CMS_session::getSessionInfos();
	}
	
	/**
	  * Get all JS locales for current user (in current language)
	  *
	  * @return string : JS locales
	  * @access public
	  */
	public static function getJSLocales() {
		return CMS_session::getJSLocales();
	}
	
	/**
	  * Get a unique session token value for given token name
	  *
	  * @param string $name, token name to get value
	  * @return string : Token value
	  * @access public
	  */
	public static function getToken ($name) {
		return CMS_session::getToken($name);
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
		return CMS_session::checkToken($name, $token);
	}
	
	/**
	  * Force a token expiration
	  *
	  * @param string $name, token name to expire
	  * @return boolean
	  * @access public
	  */
	public static function expireToken($name) {
		return CMS_session::expireToken($name);
	}
	
	/**
	  * Check if a session token is expired for a given token name
	  *
	  * @param string $name, token name to check
	  * @return boolean : true if token is expired or false otherwise
	  * @access public
	  */
	public static function tokenIsExpired ($name) {
		return CMS_session::tokenIsExpired($name);
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
		return CMS_session::getContextHash($datas);
	}
}
?>