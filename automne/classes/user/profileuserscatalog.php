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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: profileuserscatalog.php,v 1.8 2010/03/08 16:43:35 sebastien Exp $

/**
  * Class CMS_profile_usersCatalog
  *
  *  Manages the collection of users profiles.
  *
  * @package Automne
  * @subpackage user
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_profile_usersCatalog extends CMS_grandFather
{
	
	/**
	  * Returns a CMS_profile_user when given an ID
	  * Static function.
	  *
	  * @param integer $id The DB ID of the wanted CMS_profile_user
	  * @param boolean $reset : Reset the local cache (force to reload user from DB)
	  * @return CMS_profile_user or false on failure to find it
	  * @access public
	  */
	static function getByID($id, $reset = false)
	{
		static $users;
		if (!isset($users[$id]) || $reset) {
			$users[$id] = new CMS_profile_user($id);
			if ($users[$id]->hasError()) {
				$users[$id] = false;
			}
		}
		return $users[$id];
	}
	
	/**
	  * Returns an active CMS_profile_user with a given user login
	  * Static function.
	  *
	  * @param string $login The user login of the wanted CMS_profile_user
	  * @param boolean $reset : Reset the local cache (force to reload user from DB)
	  * @return CMS_profile_user or false on failure to find it
	  * @access public
	  */
	static function getByLogin($login, $reset = false)
	{
		static $users;
		if (!isset($users[$login]) || $reset) {
			$sql = "
				select
					id_pru
				from
					profilesUsers
				where
					login_pru = '".SensitiveIO::sanitizeSQLString($login)."'
					and deleted_pru='0'
					and active_pru='1'
			";
			$q = new CMS_query($sql);
			if($q->getNumRows() == 1){
				$users[$login] = new CMS_profile_user($q->getValue('id_pru'));
				if ($users[$login]->hasError()) {
					$users[$login] = false;
				}
			} else {
				$users[$login] = false;
			}
		}
		return $users[$login];
	}
	
	/**
	  * Returns a queried CMS_profile_user value
	  * Static function.
	  *
	  * @param mixed $id The DB ID of the wanted CMS_profile_user or "self" to get info from the user passed in third parameter
	  * @param string $type The value type to get
	  * @param integer $currentUserId The user Id to get the value if first parameter is "self"
	  * @return CMS_profile_user value or false on failure to find it
	  * @access public
	  */
	static function getUserValue($id, $type, $currentUserId = null) {
		static $userInfos;
		if ($id == 'self' && SensitiveIO::isPositiveInteger($currentUserId)) {
			$id = $currentUserId;
		} elseif (!SensitiveIO::isPositiveInteger($id)) {
			CMS_grandFather::raiseError("User id must be positive integer : ".$id);
			return false;
		}
		if (!isset($userInfos[$id][$type])) {
			$user = CMS_profile_usersCatalog::getByID($id);
			if (!$user) {
				return false;
			} else {
				$userInfos[$id][$type] = $user->getValue($type);
			}
		}
		return $userInfos[$id][$type];
	}
	
	/**
	  * Returns a CMS_profile_user when given a LDAP dn
	  * 
	  * @param string $dn The LDAP dn to search a user with
	  * @return CMS_profile_user or false on failure
	  * @access public
	  * @static
	  */
	static function getByDN($dn)
	{
		if (trim($dn) != '') {
			// Check that dn fields exist
			$sql = "
				DESCRIBE profilesUsers dn_pru
			";
			$q = new CMS_query($sql);
			if (!$q->getNumRows() || io::strtolower($q->getValue("Type")) != 'varchar(255)') {
				$sqls[] = "
					ALTER TABLE 
						profilesUsers
					ADD
						dn_pru VARCHAR( 255 ) NOT NULL
					AFTER
						textEditor_pru
				";
				$sqls[] = "
					ALTER TABLE
						profilesUsers ADD INDEX ( dn_pru )
				";
				$sqls[] = "
					ALTER TABLE
						profilesUsersGroups
					ADD 
						dn_prg VARCHAR( 255 ) NOT NULL
				";
				$sqls[] = "
					ALTER TABLE
						profilesUsersGroups ADD INDEX ( `dn_prg` )
				";
				foreach ($sqls as $sql) {
					$qa = new CMS_query($sql);
				}
			}
			$sql = "
				select
					id_pru as id
				from
					profilesUsers
				where
					dn_pru like '".SensitiveIO::sanitizeSQLString($dn)."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows() == 1) {
				$obj = new CMS_profile_user($q->getValue("id"), true);
				if (!$obj->hasError()) {
					return $obj;
				}
			}
		}
		return false;
	}
	
	/**
	  * Has a user the right to view a page biven by its ID ?
	  * Static function.
	  *
	  * @param CMS_profile_user $user The user viewing the page
	  * @param integer $pageID The DB ID of the page
	  * @return CMS_profile_user or false on failure to find it
	  * @access public
	  */
	static function hasPageViewClearance(&$cms_user, $pageID)
	{
		if (is_a($cms_user, 'CMS_profile_user')) {
			return $cms_user->hasPageClearance($pageID, CLEARANCE_PAGE_VIEW);
		} else {
			return false;
		}
	}
	
	/**
	  * Returns all the profile users, sorted by last name + first name.
	  * Static function.
	  *
	  * @param boolean activeOnly : return only active users (default : false)
	  * @param boolean withDeleted : return deleted users also (default false)
	  * @param boolean returnObjects : return CMS_profile_user objects (default) or array of userId
	  * @param array attrs : filter for search : array($attrName => $attrValue)
	  * @return array(CMS_profile_user)
	  * @access public
	  */
	static function getAll($activeOnly = false, $withDeleted = false, $returnObjects = true, $attrs = array()) {
        $attrWhere = '';
		$from = '';
		if($attrs and is_array($attrs)){
			$availableAttrs = array('id_pru', 'login_pru', 'firstName_pru', 'lastName_pru', 'contactData_pru', 'profile_pru', 'language_pru', 'dn_pru', 'textEditor_pru', 'email_cd');
			foreach($attrs as $attrName => $attrValue){
				// Check $attrName is available
				if(in_array($attrName,$availableAttrs)){
					$and = ($attrWhere || (!$attrWhere && (!$withDeleted || $activeOnly))) ? " and " : "";
					// Sanitize value and set operator
					if (!is_array($attrValue)) {
						if($attrName == 'email_cd'){
							// Special case : parameter is contactData email
							$attrValue = sensitiveIO::sanitizeSQLString($attrValue);
							if(SensitiveIO::isValidEmail($attrValue)){
								$attrWhere .= $and." ".$attrName." = '".$attrValue."' and contactData_pru=id_cd";
								$from .= ',contactDatas';
							}
						} else {
							$attrValue = sensitiveIO::sanitizeSQLString($attrValue);
							$attrWhere .= $and." ".$attrName." = '".$attrValue."'";
						}
					} elseif (is_array($attrValue)) {
						$attrValue = array_map(array('sensitiveIO', 'sanitizeSQLString'), $attrValue);
						foreach($attrValue as $key => $value){
							$attrValue[$key] = "'".$value."'";
						}
						$attrWhere .= $and." ".$attrName." in (".implode(',',$attrValue).")";
					}
				} else {
					CMS_grandFather::_raiseError(__CLASS__.' : '.__FUNCTION__.' : attrName must be in availableAttrs array');
				}
			}
		}
		$sql = "
			select
				id_pru
			from
				profilesUsers 
				".$from."
			".(!$withDeleted || $activeOnly || $attrWhere ? " where " : '')."
			".(!$withDeleted ? " deleted_pru='0'" : '')."
			".(!$withDeleted && $activeOnly ? " and " : '')."
			".($activeOnly ? " active_pru='1' " : '')."
			".$attrWhere."
			order by
				lastName_pru,
				firstName_pru
		";
		$q = new CMS_query($sql);
		$users = array();
		while ($id = $q->getValue("id_pru")) {
			if ($returnObjects) {
				$usr = CMS_profile_usersCatalog::getByID($id);
				if (is_object($usr)) {
					if (($activeOnly && $usr->isActive()) || !$activeOnly) {
						$users[] = $usr;
					}
				}
			} else {
				$users[] = $id;
			}
		}
		return $users;
	}
	
	/**
	 * Get user by ID
	 * 
	 * @access public
	 * @param integer $userId The user ID
	 * @return string XML definition object
	 */
	static function soapGetUser($userId = 0) {
	    $xml = '';
	    $user = (SensitiveIO::isPositiveInteger($userId)) ? CMS_profile_usersCatalog::getByID($userId) : new CMS_profile_user();
        $user = CMS_profile_usersCatalog::getByID($userId);
        if($user && !$user->hasError() && $user->isActive()){
            $contactData = $user->getContactData();
            $language = $user->getLanguage();
            
            // Groups
            $xmlGroups = '<groups>';
            $userGroupsIds = CMS_profile_usersGroupsCatalog::getGroupsOfUser($user, false, true);
            if($userGroupsIds){
                foreach($userGroupsIds as $userGroup){
                    $xmlGroups .= 
                    '<group id="'.$userGroup->getGroupId().'">
                        <label><![CDATA['.$userGroup->getLabel().']]></label>
                        <description><![CDATA['.$userGroup->getDescription().']]></description>
                    </group>';
                }
            } else {
                $xmlGroups .= '<group id=""></group>';
            }
            $xmlGroups .= '</groups>';
            
            // User
            $xml .= 
            '<user>
                <firstName><![CDATA['.$user->getFirstName().']]></firstName>
                <lastName><![CDATA['.$user->getLastName().']]></lastName>
                <login><![CDATA['.$user->getLogin().']]></login>
                <active><![CDATA['.$user->isActive().']]></active>
                <deleted><![CDATA['.$user->isDeleted().']]></deleted>
                <language label="'.SensitiveIO::sanitizeHTMLString($language->getLabel()).'"><![CDATA['.$language->getCode().']]></language>
                <contactData>
                    <email><![CDATA['.$contactData->getEmail().']]></email>
                    <service><![CDATA['.$contactData->getService().']]></service>
                    <jobTitle><![CDATA['.$contactData->getJobTitle().']]></jobTitle>
                    <addressField1><![CDATA['.$contactData->getAddressField1().']]></addressField1>
                    <addressField2><![CDATA['.$contactData->getAddressField1().']]></addressField2>
                    <addressField3><![CDATA['.$contactData->getAddressField1().']]></addressField3>
                    <zip><![CDATA['.$contactData->getZip().']]></zip>
                    <city><![CDATA['.$contactData->getCity().']]></city>
                    <state><![CDATA['.$contactData->getState().']]></state>
                    <country><![CDATA['.$contactData->getCountry().']]></country>
                    <phone><![CDATA['.$contactData->getPhone().']]></phone>
                    <cellphone><![CDATA['.$contactData->getCellPhone().']]></cellphone>
                    <fax><![CDATA['.$contactData->getFax().']]></fax>
                </contactData>'
                .$xmlGroups.
            '</user>';
        }
	    return $xml;
	}
	
	/**
	 * Search users by xml definition. Return XML
	 * 
	 * @access public
	 * @param string $searchConditions XML definition to search with ('id','login','firstName','lastName','contactData','profile','language','dn')
	 * @return string XML definition of users IDs
	 */
	static function soapSearch($searchConditions = '') {
	    $xml = '';
	    $attrs = array();
	    
	    if($searchConditions){
            $domdocument = new CMS_DOMDocument();
		    try {
			    $domdocument->loadXML($searchConditions, 0, false);
		    } catch (DOMException $e) {
			    CMS_profile_usersCatalog::raiseError('Parse error for xml : '.$e->getMessage()." :\n".$xml);
			    return $xml;
		    }
            // Conditions tag must be the root tag
            $conditionsTags = $domdocument->getElementsByTagName('conditions');
            if(count($conditionsTags) == 1){
                $conditionTags = $domdocument->getElementsByTagName('condition');
                foreach($conditionTags as $conditionTag){
                    $type = $conditionTag->getAttribute('type');
                    $value = $conditionTag->nodeValue;
                    $attrs[$type.'_pru'] = $value;
                }
            }
        }
        
        $items = CMS_profile_usersCatalog::getAll(true, false, false, $attrs);
        
        if($items){
            $xml .= '<results count="'.count($items).'">'."\n";
            foreach($items as $itemID){
                $xml .= '<result>'.$itemID.'</result>'."\n";
            }
            $xml .= '</results>';
        }
	    
	    return $xml;
	}
	
	/**
	  * Search users
	  * Static function.
	  *
	  * @param string search : search user by lastname, firstname or login
	  * @param string letter : search user by first lastname letter
	  * @param integer group : search user by group ID
	  * @param string order : order by fieldname (without suffix). default : lastname, firstname
	  * @param integer start : search start offset
	  * @param integer limit : search limit (default : 0 : unlimited)
	  * @param boolean activeOnly : return only active users (default : false)
	  * @param boolean returnObjects : return CMS_profile_user objects (default) or array of userId
	  * @return array(CMS_profile_user)
	  * @access public
	  */
	static function search($search = '', $letter = '', $group = '', $order = '', $direction = 'asc', $start = 0, $limit = 0, $activeOnly = false, $returnObjects = true, &$score = array()) {
		$start = (int) $start;
		$limit = (int) $limit;
		$group = (int) $group;
		$direction = (in_array(io::strtolower($direction), array('asc', 'desc'))) ? io::strtolower($direction) : 'asc';
		$keywordsWhere = $letterWhere = $groupWhere = $orderBy = $orderClause = $idWhere = '';
		$select = 'id_pru';
		if (io::strpos($search, ':noroot:') !== false) {
			$idWhere = " and id_pru != '".ROOT_PROFILEUSER_ID."'";
			$search = trim(str_replace(':noroot:', '', $search));
		}
		if (io::substr($search, 0, 5) == 'user:' && sensitiveIO::isPositiveInteger(io::substr($search, 5))) {
			$idWhere = " and id_pru = '".sensitiveIO::sanitizeSQLString(io::substr($search, 5))."'";
			$search = '';
		}
		if (io::substr($search, 0, 6) == 'group:' && sensitiveIO::isPositiveInteger(io::substr($search, 6))) {
			$group = io::substr($search, 6);
			$search = '';
		}
		if ($search) {
			//clean user keywords (never trust user input, user is evil)
			$keyword = strtr($search, ",;", "  ");
			$words=array();
			$words=array_map("trim",array_unique(explode(" ", io::strtolower($keyword))));
			$cleanedWords = array();
			foreach ($words as $aWord) {
				if ($aWord && $aWord!='' && io::strlen($aWord) >= 3) {
					$aWord = str_replace(array('%','_'), array('\%','\_'), $aWord);
					if (htmlentities($aWord) != $aWord) {
						$cleanedWords[] = htmlentities($aWord);
					}
					$cleanedWords[] = $aWord;
				}
			}
			if (!$cleanedWords) {
				//if no words after cleaning, return
				return array();
			}
			foreach ($cleanedWords as $cleanedWord) {
				$keywordsWhere .= ($keywordsWhere) ? " and " : '';
				$keywordsWhere .= " (
					lastName_pru like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'
					or firstName_pru like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'
					or login_pru like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'
				)";
			}
			$keywordsWhere = ' and (('.$keywordsWhere.')';
			$select .= " , MATCH (lastName_pru, firstName_pru, login_pru) AGAINST ('".sensitiveIO::sanitizeSQLString($search)."') as m ";
			$keywordsWhere .= " or MATCH (lastName_pru, firstName_pru, login_pru) AGAINST ('".sensitiveIO::sanitizeSQLString($search)."') )";
		}
		if ($letter && io::strlen($letter) === 1) {
			$letterWhere = " and lastName_pru like '".sensitiveIO::sanitizeSQLString($letter)."%'";
		}
		if ($group) {
			$groupUsers = CMS_profile_usersGroupsCatalog::getGroupUsers($group, false);
			if (!$groupUsers) {
				return array();
			}
			$groupWhere = " and id_pru in (".implode(',',$groupUsers).")";
		}
		if ($order != 'score') {
			if ($order) {
				$founded = false;
				$sql = "DESCRIBE profilesUsers";
				$q = new CMS_query($sql);
				while ($field = $q->getValue('Field')) {
					if ($field == $order.'_pru') {
						$founded = true;
					}
				}
				if ($founded) {
					$orderBy = $order.'_pru';
				} else {
					$orderBy = 'lastName_pru,firstName_pru';
				}
			} else {
				$orderBy = 'lastName_pru,firstName_pru';
			}
			if ($orderBy) {
				$orderClause = "order by
					".$orderBy."
					".$direction;
			}
		} elseif ($search) {
			$orderClause = " order by m ".$direction;
		}
		$sql = "
			select
				".$select."
			from
				profilesUsers
			where 
			 deleted_pru='0'
			".($activeOnly ? " and  active_pru='1' " : '')."
			".$keywordsWhere."
			".$letterWhere."
			".$groupWhere."
			".$idWhere."
			".$orderClause."
		";
		if ($limit) {
			$sql .= "limit 
				".$start.", ".$limit;
		}
		$q = new CMS_query($sql);
		//pr($sql);
		//pr($q->getNumRows());
		$users = array();
		while ($r = $q->getArray()) {
			$id = $r['id_pru'];
			//set match score if exists
			if (isset($r['m'])) {
				$score[$id] = $r['m'];
			}
			if ($returnObjects) {
				$usr = CMS_profile_usersCatalog::getByID($id);
				if (is_a($usr, "CMS_profile_user") && !$usr->hasError()) {
					if (($activeOnly && $usr->isActive()) || !$activeOnly) {
						$users[] = $usr;
					}
				}
			} else {
				$users[] = $id;
			}
		}
		//pr($score);
		return $users;
	}
	
	/**
	  * Get all users labels
	  *
	  * @return array(id => firstname lastname) users label
	  * @access public
	  * @static
	  */
	static function getUsersLabels($activeOnly = false, $lastNameFirst = false) {
		$sql = "
			select
				id_pru as id,
				firstName_pru as firstname,
				lastName_pru as lastname
			from
				profilesUsers
			where 
				deleted_pru != '1'
			";
		if ($activeOnly) {
			$sql .= " and active_pru='1' ";
		}
		$sql .= "
			order by 
				lastName_pru asc, 
				firstName_pru asc";
		$q = new CMS_query($sql);
		$usersLabel = array();
		if ($q->getNumRows()) {
			while ($r = $q->getArray()) {
				if (!$lastNameFirst) {
					$usersLabel[$r['id']] = ucfirst($r['firstname']).($r['firstname'] && $r['lastname'] ? ' ' : '').ucfirst($r['lastname']);
				} else {
					$usersLabel[$r['id']] = ucfirst($r['lastname']).($r['firstname'] && $r['lastname'] ? ' ' : '').ucfirst($r['firstname']);
				}
			}
		}
		return $usersLabel;
	}
	
	/**
	  * Returns all the validators.
	  * Static function.
	  *
	  * @param string $moduleCodename The codename of the module to validate
	  * @return array(CMS_profile_user)
	  * @access public
	  */
	static function getValidators($moduleCodename)
	{
		$sql = "
			select
				userId_puv
			from
				profilesUsers_validators,
				profilesUsers
			where
				module_puv='".SensitiveIO::sanitizeSQLString($moduleCodename)."'
				and userId_puv = id_pru
				and active_pru = 1
				and deleted_pru = 0
		";
		$q = new CMS_query($sql);
		$users = array();
		$users_ids = array();
		while ($id = $q->getValue("userId_puv")) {
			$usr = CMS_profile_usersCatalog::getByID($id);
			if (!$usr->hasError()) {
				$users[$usr->getLastName().'-'.$id] = $usr;
				$users_ids[] = $id;
			}
		}
		
		//add the users with 'edit & validate all' right
		$sql = "
			select
				id_pru
			from
				profilesUsers,
				profiles
			where
				profile_pru = id_pr
				and administrationClearance_pr & " . CLEARANCE_ADMINISTRATION_EDITVALIDATEALL . "
				and active_pru = 1
				and deleted_pru = 0
		";
		$q = new CMS_query($sql);
		while ($id = $q->getValue("id_pru")) {
			if (!in_array($id, $users_ids)) {
				$usr = CMS_profile_usersCatalog::getByID($id);
				if (!$usr->hasError()) {
					$users[$usr->getLastName().'-'.$id] = $usr;
				}
			}
		}
		//sort users by last name
		uksort($users, array('io','natcasecmp'));
		
		return $users;
	}
	
	/**
	  * Checks all the profile users, except $user
	  * to see if LDAP dn doesnt exist. Static function.
	  *
	  * @param CMS_profile_user $user
	  * @param string $dn
	  * @return boolean
	  * @access public
	  */
	static function dnExists($dn, &$user)
	{
		$sql = "
			select
				*
			from
				profilesUsers
			where
				dn_pru = '".SensitiveIO::sanitizeSQLString($dn)."'
			  and
				id_pru <> '".$user->getUserId()."'
		";
		$q = new CMS_query($sql);
		return $q->getNumRows();
	}
	
	/**
	  * Checks all the profile users, except $user
	  * to see if login doesnt exist.
	  * Static function.
	  *
	  * @param CMS_profile_user $user
	  * @param string $login
	  * @param boolean $returnProfileUserId : if true, return the user ID
	  * @return boolean
	  * @access public
	  */
	static function loginExists($login, &$user, $returnProfileUserId = false)
	{
		$sql = "
			select
				*
			from
				profilesUsers
			where
				login_pru = '".SensitiveIO::sanitizeSQLString($login)."'
			  and
				id_pru != '".$user->getUserId()."'
		";
		$q = new CMS_query($sql);
		if($q->getNumRows() && $returnProfileUserId){
			return $q->getValue('id_pru');
		} else {
			return $q->getNumRows();
		}
	}
	
	/**
	  * Get all the letters that have a least one user with a lastname beginning with
	  * Static function.
	  *
	  * @return array(string)
	  * @access public
	  */
	static function getLettersForLastName()
	{
		$sql = "
			select
				left(lastName_pru, 1) as initial
			from
				profilesUsers
			where
				deleted_pru=0
			group by
				initial
			order by
				initial
		";
		$q = new CMS_query($sql);
		$letters = array();
		while (($letter = $q->getValue("initial")) !== false) {
			if (trim($letter)) {
				$letters[] = ucfirst($letter);
			}
		}
		return $letters;
	}
	
	/**
	  * Deny all given rows groups to all users
	  *
	  * @param array $groups : the groups name to deny
	  * @return Boolean
	  * @access public
	  * @static
	  */
	static function denyRowGroupsToUsers($groups) {
		$sql = "select 
					distinct rowGroupsDeniedStack_pr
				from 
					profiles";
		$q = new CMS_query($sql);
		while($r = $q->getArray()) {
			//do not use getValue directly because it can grab null value which break the while loop ...
			$v = $r['rowGroupsDeniedStack_pr'];
			$rowsDenied = explode(';',$v);
			$rowsDenied = array_merge($rowsDenied, $groups);
			$rowsDenied = array_unique($rowsDenied);
			$rowsDenied = array_filter($rowsDenied);
			$rowsDeniedString = implode(';',$rowsDenied);
			new CMS_query("
				update
					profiles
				set
					rowGroupsDeniedStack_pr='".$rowsDeniedString."'
				where
					rowGroupsDeniedStack_pr='".$v."'");
		}
		return true;
	}
	
	/**
	  * Deny all given templates groups to all users
	  *
	  * @param array $groups : the groups name to deny
	  * @return Boolean
	  * @access public
	  * @static
	  */
	static function denyTemplateGroupsToUsers($groups) {
		$sql = "select 
					distinct templateGroupsDeniedStack_pr
				from 
					profiles";
		$q = new CMS_query($sql);
		while($r = $q->getArray()) {
			//do not use getValue directly because it can grab null value which break the while loop ...
			$v = $r['templateGroupsDeniedStack_pr'];
			$tplDenied = explode(';',$v);
			$tplDenied = array_merge($tplDenied, $groups);
			$tplDenied = array_unique($tplDenied);
			$tplDenied = array_filter($tplDenied);
			$tplDeniedString = implode(';',$tplDenied);
			new CMS_query("
				update
					profiles
				set
					templateGroupsDeniedStack_pr='".$tplDeniedString."'
				where
					templateGroupsDeniedStack_pr='".$v."'");
		}
		return true;
	}
}
?>