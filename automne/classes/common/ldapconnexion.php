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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// | Author: Sébastien Pauchet <sébastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: ldapconnexion.php,v 1.2 2010/03/08 16:43:27 sebastien Exp $

/**
  * Class CMS_ldap_connexion
  *
  * Launches LDAP query against a given server.
  * Performs basic searches through static methods.
  *
  * @package CMS
  * @subpackage common
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  * @author Sébastien Pauchet <sébastien.pauchet@ws-interactive.fr>
  */

class CMS_ldap_connexion extends CMS_grandFather
{
	
	/**
	 * Connexion binded
	 * @var Resource
	 * @access private
	 */
	protected $_connexion;
	
	/**
	  * Constructor.
	  * Initializes the connection with LDAP server
	  *
	  * @param string $server Server name
	  * @param integer $port, the port to use
	  * @param string $auth_user
	  * @param string $auth_pass
	  * @return void
	  * @access public
	  */
	function __construct($server = APPLICATION_LDAP_SERVER, 
								$port = APPLICATION_LDAP_PORT,
								$auth_user = APPLICATION_LDAP_AUTH_USER, 
								$auth_pass = APPLICATION_LDAP_AUTH_PASSWORD)
	{
		if (!function_exists("ldap_connect")) {
			$this->raiseError("LDAP is not available on this system. Add LDAP library support to PHP");
			return;
		}
		if (!function_exists("ldap_set_option")) {
			$this->raiseError("LDAP function `ldap_set_option` is not present. protocol v3 won't work");
			return;
		}
		$this->_connexion = $this->_connect($server, $port, $auth_user, $auth_pass);
		return;
	}
	
	/**
	  * Initiates connection with the LDAP
	  *
	  * @param string $server, the server to connect to
	  * @param integer $port, the port to use
	  * @param string $auth_user, user to connect with
	  * @param string $auth_pass, user's password
	  * @return Resource if connexion succeded, null otherwise
	  * @access private
	  */
	protected function _connect($server, $port, $auth_user='', $auth_pass='')
	{
		if (function_exists("ldap_set_option") && !@ldap_set_option($connect, LDAP_OPT_PROTOCOL_VERSION, 3)) {
			$this->raiseError("Not a LDAP 3 protocol founded");
		}
		$link = @ldap_connect($server, $port);
		if (!is_resource($link)) {
			$this->raiseError("LDAP connection failed :  ".ldap_error($link));
		} else {
			if (!($bind = @ldap_bind($link, $auth_user, $auth_pass))) {
				$this->raiseError("Unable to bind to server : ".ldap_error($link));
			} else {
				return $link;
			}
		}
		return null;
	}
	
	/**
	  * Get current connexion binded
	  *
	  * @return Resource
	  * @access protected
	  */
	function getConnexion()
	{
		if (!is_resource($this->_connexion)) {
			$this->raiseError("No connexion available.");
			return null;
		} else {
			return $this->_connexion;
		}
	}
	
	/**
	  * Bind with given login and password through current connexion
	  * Test purpose
	  *
	  * @param string $auth_user, user to connect with
	  * @param string $auth_pass, user's password
	  * @return true onsuccess, false on failure
	  * @access protected
	  */
	function bind($auth_user='', $auth_pass='')
	{
		if (!is_resource($this->_connexion)) {
			$this->raiseError("No connexion available.");
			return null;
		} else {
			return @ldap_bind($this->_connexion, $auth_user, $auth_pass);
		}
	}
	
	/**
	 * Closes current connexion
	 * @return void
	 * @access public
	 */
	function close()
	{
		if (is_resource($this->_connexion)) {
			@ldap_unbind ($this->_connexion);
		}
	}
}
?>