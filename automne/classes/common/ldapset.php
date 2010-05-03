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
// $Id: ldapset.php,v 1.2 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class CMS_ldap_query
  *
  * Launches LDAP query against a given server.
  * Performs basic searches through static methods.
  *
  * @package CMS
  * @subpackage common
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  * @author Sébastien Pauchet <sébastien.pauchet@ws-interactive.fr>
  */

class CMS_ldap_set extends CMS_ldap_connexion
{
	/**
	 * Base DN used for this connexion
	 * 
	 * @var String
	 * @access private
	 */
	protected $_baseDN;
	
	/**
	 * returned value for this query
	 * 
	 * @var Bollean
	 * @access private
	 */
	protected $_returnValue;
	
	/**
	  * Constructor.
	  * Initializes the connection and launches the query.
	  *
	  * @param string user $dn, to set datas
	  * @param array $values, values of attribute to set (format array('attributeName' => 'attributeValue'))
	  * @param string $base_dn, The database user
	  * @param string $server, server name
	  * @param integer $port, server port
	  * @param string $auth_user
	  * @param string $auth_pass
	  * @return void
	  * @access public
	  */
	function __construct($dn,
								 $values,
								$base_dn = APPLICATION_LDAP_BASE_DN,
								$server = APPLICATION_LDAP_SERVER, 
								$port = APPLICATION_LDAP_PORT,
								$auth_user = APPLICATION_LDAP_AUTH_USER, 
								$auth_pass = APPLICATION_LDAP_AUTH_PASSWORD) {
		
		$this->_baseDN = trim($base_dn);
		
		parent::__construct($server, $port, $auth_user, $auth_pass);
		$encodedValues = array();
		if (is_array($values) && $values) {
			foreach ($values as $key => $value) {
				$encodedValues[utf8_encode($key)] = utf8_encode($value);
			}
		} else {
			$this->raiseError("No values passed");
			return;
		}
		if (is_resource($this->getConnexion())) {
			$this->_returnValue = @ldap_modify ( $this->getConnexion(), $dn, $encodedValues);
			
		} else {
			$this->raiseError("No connexion binded");
		}
		return;
	}
	
	/**
	 * return returned query value
	 * @return boolean
	 * @access public
	 */
	function getReturnValue() {
		return $this->_returnValue;
	}
	
	/**
	 * Closes connexion and destoys this object
	 * @return void
	 * @access public
	 */
	function close()
	{
		parent::close();
		unset($this);
	}
}
?>