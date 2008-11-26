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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// | Author: Sébastien Pauchet <sébastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: contactdataldap.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_ldap_contactData
  *
  * Represent a contact data when APPLICATION_LDAP_AUTH is on
  * So all user data must come from LDAP external directory
  *
  * @package CMS
  * @subpackage common
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  * @author Sébastien Pauchet <sébastien.pauchet@ws-interactive.fr>
  */

class CMS_ldap_contactData extends CMS_contactData
{
	/**
	  * LDAP distinguished name
	  *
	  * @var string
	  * @access private
	  */
	protected $_dn;
	
	/**
      * LDAP firstname
      *
      * @var string
      * @access private
      */
    protected $_firstname;

    /**
      * LDAP lastname
      *
      * @var string
      * @access private
      */
    protected $_lastname;
	
	/**
     * User array of datas founded in LDAP
     * @var array()
     * @access private
     */
    protected $_ldapData = array();
	
	/**
     * User array of datas founded in LDAP
     * @var array()
     * @access private
     */
    protected $_ldapDatas = array();
    
	/**
	 * Serach to submit to LDAP server
	 * @var string
	 * @access private
	 */
	protected $_filter;
	
    /**
     * Attributes we want to obtain from server when search succeeded
     * Strongly recommended to limit returned attributes for performance
     * We need to map each method from CMS_contactData with new values
     * from LDAP directory
     * 
     * @var array
     * @access private
     */
    protected $_awaitedAttributes = array(
						'email'                 => APPLICATION_LDAP_USER_EMAIL,
						'jobTitle'              => APPLICATION_LDAP_USER_JOBTITLE,
						'service'               => APPLICATION_LDAP_USER_SERVICE,
						'phone'                 => APPLICATION_LDAP_USER_PHONE,
						'cellphone'             => APPLICATION_LDAP_USER_CELLPHONE,
						'fax'                   => APPLICATION_LDAP_USER_FAX,
						'addressField1'			=> APPLICATION_LDAP_USER_ADDRESS1,
						'addressField2'			=> APPLICATION_LDAP_USER_ADDRESS2,
						'addressField3'  		=> APPLICATION_LDAP_USER_ADDRESS3,
						'city'                  => APPLICATION_LDAP_USER_CITY,
						'zip'                   => APPLICATION_LDAP_USER_ZIPCODE,
						'country'               => APPLICATION_LDAP_USER_COUNTRY,
						'state'                 => APPLICATION_LDAP_USER_REGIONSTATE,
						'gecos' => '',
						'givenName' => '',
						'roomNumber' => '',
						'facsimileTelephoneNumber' => '_fax',
						'description' => '',
						'o' => '',
						'title' => '_jobTitle',
						'userPassword' => '',
						'loginShell' => '',
						'manager' => '',
						'mail' => '_email'
						);
    
	/**
	  * Constructor.
	  * Initializes the contactData if the $dn is given
	  *
	  * @param string user $dn, to get datas from
	  * @param integer $id, to save datas
	  * @return void
	  * @access public
	  */
	function __construct($dn='', $id='')
	{
		parent::__construct();
		if (SensitiveIO::isPositiveInteger($id)) {
			$this->_id = $id;
		}
		$this->_dn = $dn;
		$this->retrieveData();
	}
	
	/**
	  * Retrives user infos from LDAP server
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function retrieveData()
	{
		if ($this->_dn != '') {
			// Prepare filter
			// How to proceed, first, if we can determine that first part of user DN
			// is in the array of login attributes used to build authentication filter
			// we build a filter base on this first part of DN
			// otherwize, we use all DN except Base DN to search for user infos
			$loginAttributes = CMS_ldap_auth::getLoginAttributes();
			if (is_array($loginAttributes) && $loginAttributes) {
				// Compare first part founded in DN with loginAttributes registered in LDAP auth
				$dn_parts = explode(",", CMS_ldap_query::stripBaseDN($this->_dn));
				$first_part = $dn_parts[0];
				$filter = '';
				foreach ($loginAttributes as $att) {
					if (!$filter && strtolower(substr($first_part, 0, strlen($att))) == strtolower($att)) {
						$filter = "(".utf8_encode($first_part).")";
					}
				}
			} else {
				$filter = "(&(uid=".CMS_ldap_query::stripBaseDN(utf8_encode($this->_dn)).")(ou=people))";
			}
			//add filter here to limit attributes (see _awaitedAttributes var)
			//$q = new CMS_ldap_query($filter, array_keys($this->_awaitedAttributes));
			$q = new CMS_ldap_query($filter);
			if (!$q->getnumRows()) {
				$this->raiseError("Search failed for filter $filter.");
			} elseif ($q->getNumRows() == 1) {
				$e = $q->getEntries();
				if (is_array($e) && $e['count'] == 1) {
					while (list($k, $v) = each($e[0])) {
						if (!is_integer($k) && $k != 'count') {
							$k = strtolower($k);
							if (is_array($v)) {
								$this->_ldapData[$k] = utf8_decode($v[0]);
								$this->_ldapDatas[$k] = array_map("utf8_decode",$v);
							} else {
								$this->_ldapData[$k] = utf8_decode($v);
								$this->_ldapDatas[$k] = utf8_decode($v);
							}
							// Map cd private attributes with corresponding values from LDAP directory
							if ($this->_ldapData[$k] && in_array($k, $this->_awaitedAttributes)) {
								$key = '_'.array_search($k , $this->_awaitedAttributes );
								$this->$key = $this->_ldapData[$k];
							}
						}
					}
					$q->close();
					return true;
				}
			} else {
				$this->raiseError("Search gave more than one result for filter $filter.");
			}
			$q->close();
		}
		return false;
	}
	
    /**
      * Get one user info or all user info array if no parameter passed
      *
      * @param string $name, key of attribute to return value of
      * @return  string
      * @access public
      */
    function getLDAPData($name = false)
    {
        if (!$name) {
        	return $this->_ldapData;
        } else {
        	return $this->_ldapData[strtolower($name)];
        }
    }
	
    /**
      * Get all user infos or all user infos array if no parameter passed
      *
      * @param string $name, key of attribute to return value of
      * @return  string
      * @access public
      */
    function getLDAPDatas($name = false)
    {
        if (!$name) {
        	return $this->_ldapDatas;
        } else {
        	return $this->_ldapDatas[strtolower($name)];
        }
    }
	 
	 /**
      * Set one or more user info
      *
		* @param array $values, values of attribute to set (format array('attributeName' => 'attributeValue'))
      * @return  boolean
      * @access public
      */
    function setLDAPData($values)
    {
        if ($this->_dn != '') {
		  		$q = new CMS_ldap_set($this->_dn, $values);
				return $q->getReturnValue();
		  } else {
		  		$this->raiseError("No DN set for user.");
				return false;
		  }
    }
	 
	 /**
      * Set an encrypted password in ldap (userpassword field)
      *
		* @param string $pass, the new password to set
		* @param string $type, the encryption type to use (MD5 or SSHA for now)
		* @param string $fieldname, the password field name to modify (default : userpassword)
      * @return  boolean
      * @access public
      */
	 function setLDAPPassword($pass, $type='SSHA', $fieldname='userpassword') {
	 	switch($type) {
			case 'SSHA':
				$userpassword = '{SSHA}' .base64_encode(pack("H*", sha1($pass)));
			break;
			case 'MD5':
				$userpassword = '{MD5}' .base64_encode(pack("H*", md5($pass)));
			break;
			default:
				$this->raiseError("Unknown password encryption type : ".$type);
				return false;
			break;
		}
		return $this->setLDAPData(array($fieldname => $userpassword));
	 }
}
?>