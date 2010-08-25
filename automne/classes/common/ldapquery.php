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
// $Id: ldapquery.php,v 1.3 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class CMS_ldap_query
  *
  * Launches LDAP query against a given server.
  * Performs basic searches through static methods.
  *
  * @package Automne
  * @subpackage common
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  * @author Sébastien Pauchet <sébastien.pauchet@ws-interactive.fr>
  */

class CMS_ldap_query extends CMS_ldap_connexion
{
	/**
	 * Base DN used for this connexion
	 * 
	 * @var String
	 * @access private
	 */
	protected $_baseDN;
	
	/**
	 * Results obtained after a search
	 * 
	 * @var Resource
	 * @access private
	 */
	protected $_searchResult;
	
	/**
	 * All entries founded in LDAP
	 * 
	 * @var array()
	 * @access private
	 */
	protected $_entries;
	
	/**
	 * Filter to use for search
	 * 
	 * @var string
	 * @access private
	 */
	protected $_filter = "objectClass=*";
	
	/**
     * Attributes we want to obtain from server when query suceeded
     * Strongly recommended in fact to limit number of attributes 
     * returned for performance purpose
     * @var array
     * @access private
     */
    var $_awaitedAttributes;
    
	/**
	 * Number of results founded
	 * @var integer
	 * @access private
	 */
	protected $_numRows = 0;
	
	/**
	  * Constructor.
	  * Initializes the connection and launches the query.
	  *
	  * @param string $filter, Filter to serach with through server
	  * @param array $awaitedAttributes, Filter to serach with through server
	  * @param string $base_dn, The database user
	  * @param string $server, server name
	  * @param integer $port, server port
	  * @param string $auth_user
	  * @param string $auth_pass
	  * @return void
	  * @access public
	  */
	function __construct($filter = false,
								$awaitedAttributes = false, 
								$base_dn = APPLICATION_LDAP_BASE_DN,
								$server = APPLICATION_LDAP_SERVER, 
								$port = APPLICATION_LDAP_PORT,
								$auth_user = APPLICATION_LDAP_AUTH_USER, 
								$auth_pass = APPLICATION_LDAP_AUTH_PASSWORD) {
		
		$this->_baseDN = trim($base_dn);
		
		parent::__construct($server, $port, $auth_user, $auth_pass);
		
		if (is_resource($this->getConnexion())) {
			
			// Prepare filter
			if (trim($filter) != '') {
				$this->_filter = trim($filter);
			}
			
			// Prepare awaited attributes to be returned by search
			if (is_array($awaitedAttributes)) {
				$this->_awaitedAttributes = $awaitedAttributes;
			}
			
			// Proceed to search
			if (is_array($this->_awaitedAttributes)) {
				$this->_searchResult = ldap_search($this->getConnexion(), $base_dn, $this->_filter, $this->_awaitedAttributes);
			} else {
				$this->_searchResult = ldap_search($this->getConnexion(), $base_dn, $this->_filter);
			}
			if (!is_resource($this->_searchResult)) {
				$this->raiseError("Unable to search LDAP server : ".ldap_error($this->getConnexion()).'. Filter : '.$this->_filter);
			} else {
				$this->_numRows = ldap_count_entries($this->getConnexion(), $this->_searchResult);
				$this->_entries = ldap_get_entries($this->getConnexion(), $this->_searchResult);
			}
		} else {
			$this->raiseError("No connexion binded");
		}
		return;
	}
	
	/**
	  * Get all entries founded
	  *
	  * @return array(string=>mixed)
	  * @access public
	  */
	function getEntries()
	{
		return $this->_entries;
	}
	
	/**
	  * Get the number of rows returned.
	  *
	  * @return integer The number of entries
	  * @access public
	  */
	function getNumRows()
	{
		return $this->_numRows;
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
	
    /**
      * Appends given DN with APPLICATION_LDAP_BASE_DN
      *
      * @param string $dn
      * @return  string
      * @access public
      * @static
      */
    function appendWithBaseDN($dn)
    {
    	if (trim($dn) != '' && io::strpos($dn, APPLICATION_LDAP_BASE_DN) === false) {
    		return $dn.','.APPLICATION_LDAP_BASE_DN;
    	} else {
    		return $dn;
    	}
    }
    
    /**
      * Strip APPLICATION_LDAP_BASE_DN from given string
      *
      * @param string $s
      * @return  string
      * @access public
      * @static
      */
    function stripBaseDN($s)
    {
    	return str_replace(','.APPLICATION_LDAP_BASE_DN, '', $s);
    }
}
?>