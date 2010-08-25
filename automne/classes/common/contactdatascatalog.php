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
// +----------------------------------------------------------------------+
//
// $Id: contactdatascatalog.php,v 1.3 2010/03/08 16:43:27 sebastien Exp $

/**
  * Class CMS_contactDatas_catalog
  *
  * Keeps track of logging action
  *
  * @package Automne
  * @subpackage common
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_contactDatas_catalog extends CMS_grandFather
{
	/**
	  * Get a contact data by Id
	  *
	  * @param integer or array $data
	  * @return CMS_contactData or null
	  * @access public
	  */
	function getById($data)
	{
		if (SensitiveIO::isPositiveInteger($data) || is_array($data)) {
			$obj = new CMS_contactData($data);
			if (!$obj->hasError()) {
				return $obj;
			}
		}
		return new CMS_contactData();
	}
	
	/**
	  * Get a contact data by DN
	  *
	  * @param string $dn
	  * @param integer $id : the Automne contact data ID associated
	  * @return CMS_ldap_contactData or null
	  * @access public
	  */
	function getByDN($dn, $id = false)
	{
		if (trim($dn) != '') {
			$obj = new CMS_ldap_contactData(trim($dn), $id);
			if (!$obj->hasError()) {
				return $obj;
			}
		}
		return new CMS_ldap_contactData();
	}
	
	/**
	  * Get array of contacts data by Email
	  *
	  * @param string $data
	  * @return array of CMS_profile_user
	  * @access public
	  */
	function getByEmail($data)
	{
		if (!SensitiveIO::isValidEmail($data) ) {
			 CMS_grandFather::raiseError('$data must be a valid email : '.$data);
			 return array();
		}
		$aUsers = array();
		
		//create the request to look for the data
		$sql = 'select `id_cd` 
			from `contactDatas`
			where `email_cd` = "'.sensitiveIO::sanitizeSQLString($data).'"';
		//launching the request
		$q = new CMS_query($sql);
		
		//checking if ok and looping on results
		if(!$q->hasError()){
			while( ($oTmpUserId = $q->getValue("id_cd")) !== false ){
				//creating the user and filling the data
				$oTmpUser = CMS_profile_usersCatalog::getByID( $oTmpUserId );
				if(!$oTmpUser->hasError()){
					$oTmpUser->getContactData();
					if(!$oTmpUser->hasError()){
						$aUsers[] = $oTmpUser;
					}
				}
			}
			unset($oTmpUser , $oTmpUserId);
		}
		return $aUsers;
	}

	/**
	  * Get by user : returns the contact data for given user
	  * Depend on LDAP authentification status
	  * @param boolean getLDAPDatas : if LDAP connection is used, force getting CD from LDAP to get fresh datas (default false)
	  * @param array $data : datas from DB (loaded by CMS_profile_user) or CMS_profile_user object
	  * @return CMS_contactData or CMS_ldap_contactData
	  * @access public
	  */
	function getByUser($data, $getLDAPDatas = false)
	{
		if (is_array($data)) {
			if (defined("APPLICATION_LDAP_AUTH") && APPLICATION_LDAP_AUTH != false && $getLDAPDatas) {
				return CMS_contactDatas_catalog::getByDN($data["dn_pru"], $data["contactData_pru"]);
			} else {
				return CMS_contactDatas_catalog::getById($data);
			}
		} elseif (is_a($data, 'CMS_profile_user')) {
			if (defined("APPLICATION_LDAP_AUTH") && APPLICATION_LDAP_AUTH != false && $getLDAPDatas) {
				$cd = $data->getContactData();
				return CMS_contactDatas_catalog::getByDN($data->getDN(), $cd->getID());
			} else {
				//ugly method but need it for compatibility
				//I do not think that it is very often useful, so ...
				$user = new CMS_profile_user($data->getUserID());
				return $user->getContactData();
			}
		} else {
			return null;
		}
	}
}
?>