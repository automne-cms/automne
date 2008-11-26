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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: profileusersgroupscatalog.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Class CMS_profile_usersGroupsCatalog
  *
  *  Manages the collection of users groups profiles.
  *
  * @package CMS
  * @subpackage user
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_profile_usersGroupsCatalog extends CMS_grandFather
{
	/**
	  * Returns a CMS_profile_usersGroups when given an ID
	  * Static function.
	  *
	  * @param integer $id The DB ID of CMS_profile_usersGroups
	  * @param boolean $reset Reset groups before loading them
	  * @return CMS_profile_usersGroup or false on failure
	  * @access public
	  * @static
	  */
	function &getByID($id, $reset = false)
	{
		static $groups;
		if($reset){
			unset($groups);
		}
		if (!isset($groups[$id])) {
			$groups[$id] = new CMS_profile_usersGroup($id);
			if ($groups[$id]->hasError()) {
				$groups[$id] = false;
			}
		}
		return $groups[$id];
	}
	
	/**
	  * Returns a CMS_profile_usersGroups when given a LDAP dn
	  * 
	  * @param string $dn The LDAP dn to search a group with
	  * @return CMS_profile_usersGroup or false on failure
	  * @access public
	  * @static
	  */
	/*function getByDN($dn)
	{
		if (trim($dn) != '') {
			$attribute = substr($dn,0,strpos($dn,'=')+1);
			$sql = "
				select
					id_prg as id
				from
					profilesUsersGroups
				where
					(dn_prg = '".SensitiveIO::sanitizeSQLString($dn)."' and invertdn_prg=0";
			if ($attribute) {
				$sql .= " or  (dn_prg LIKE '".$attribute."%' and dn_prg != '".SensitiveIO::sanitizeSQLString($dn)."' and invertdn_prg=1)";
			}
			$sql .= " )";
			$q = new CMS_query($sql);
			if ($q->getNumRows() == 1) {
				$obj = CMS_profile_usersGroupsCatalog::getById($q->getValue("id"));
				if (!$obj->hasError()) {
					return $obj;
				}
			}
		}
		return false;
	}*/
	
	/**
	  * Returns all the profile usersGroups, sorted by label.
	  * Static function.
	  *
	  * @return array(CMS_profile_usersGroup)
	  * @access public
	  */
	function getAll()
	{
		$sql = "
			select
				id_prg
			from
				profilesUsersGroups
			order by
				label_prg
		";
		$q = new CMS_query($sql);
		$groups = array();
		while ($id = $q->getValue("id_prg")) {
			$grp = CMS_profile_usersGroupsCatalog::getById($id);
			if (!$grp->hasError()) {
				$groups[] = $grp;
			}
		}
		return $groups;
	}
	
	/**
	  * Search groups
	  * Static function.
	  *
	  * @param string search : search group by lastname, firstname or login
	  * @param string letter : search group by first lastname letter
	  * @param integer userId : search group which user belongs to
	  * @param string order : order by fieldname (without suffix). default : label
	  * @param integer start : search start offset
	  * @param integer limit : search limit (default : 0 : unlimited)
	  * @param boolean returnObjects : return CMS_profile_usersGroup objects (default) or array of groupId
	  * @return array(CMS_profile_usersGroup)
	  * @access public
	  */
	function search($search = '', $letter = '', $userId = false, $order = '', $direction = 'asc', $start = 0, $limit = 0, $returnObjects = true) {
		$start = (int) $start;
		$limit = (int) $limit;
		$direction = (in_array(strtolower($direction), array('asc', 'desc'))) ? strtolower($direction) : 'asc';
		$keywordsWhere = $letterWhere = $groupWhere = $orderBy = '';
		if ($search) {
			//clean user keywords (never trust user input, user is evil)
			$keyword = strtr($search, ",;", "  ");
			$words=array();
			$words=array_map("trim",array_unique(explode(" ", strtolower($keyword))));
			$cleanedWords = array();
			foreach ($words as $aWord) {
				if ($aWord && $aWord!='' && strlen($aWord) >= 3) {
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
				$keywordsWhere .= ($keywordsWhere) ? ' and ' : '';
				$keywordsWhere .= " label_prg like '%".sensitiveIO::sanitizeSQLString($cleanedWord)."%'";
			}
		}
		if ($letter && strlen($letter) === 1) {
			$letterWhere .= ($keywordsWhere) ? ' and ' : '';
			$letterWhere .= " label_prg like '".sensitiveIO::sanitizeSQLString($letter)."%'";
		}
		if ($userId && sensitiveIO::isPositiveInteger($userId)) {
			$userGroups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($userId, true);
			if (!$userGroups) {
				return array();
			}
			$groupWhere .= ($keywordsWhere || $letterWhere) ? ' and ' : '';
			$groupWhere .= " id_prg in (".implode(',',$userGroups).")";
		}
		if ($order) {
			$founded = false;
			$sql = "DESCRIBE profilesUsersGroups";
			$q = new CMS_query($sql);
			while ($field = $q->getValue('Field')) {
				if ($field == $order.'_prg') {
					$founded = true;
				}
			}
			if ($founded) {
				$orderBy = $order.'_prg';
			} else {
				$orderBy = 'label_prg';
			}
		} else {
			$orderBy = 'label_prg';
		}
		$sql = "
			select
				id_prg
			from
				profilesUsersGroups
			".(($keywordsWhere || $letterWhere || $groupWhere) ? 'where' : '')."
			".$keywordsWhere."
			".$letterWhere."
			".$groupWhere."
			order by
				".$orderBy."
				".$direction."
		";
		if ($limit) {
			$sql .= "limit 
				".$start.", ".$limit;
		}
		$q = new CMS_query($sql);
		//pr($sql);
		//pr($q->getNumRows());
		$groups = array();
		while ($id = $q->getValue("id_prg")) {
			if ($returnObjects) {
				$group = CMS_profile_usersGroupsCatalog::getById($id);
				if (is_a($group, "CMS_profile_usersGroup") && !$group->hasError()) {
					$groups[] = $group;
				}
			} else {
				$groups[] = $id;
			}
		}
		return $groups;
	}
	
	/**
	  * Returns all the userGroup, to which a user belongs to
	  * Returns empty group if no group found
	  * Static function.
	  * 
	  * @param CMS_profile_user|integer $user
	  * @param boolean $returnIds : return array of groups ids instead of CMS_profile_usersGroup (faster, default : false)
	  * @return array(groupID => CMS_profile_usersGroup)
	  * @access public
	  */
	function getGroupsOfUser($user, $returnIds = false, $reset = false) {
		static $userGroups;
		if ($reset) {
			unset($userGroups);
		}
		if (is_a($user,"CMS_profile_user")) {
			$user = $user->getUserId();
		}
		if (!SensitiveIO::isPositiveInteger($user)) {
			return array();
		}
		if (!isset($userGroups)) {
			$sql = "
				select
					userId_gu,
					groupId_gu
				from
					profileUsersByGroup,
					profilesUsersGroups
				where
					groupId_gu = id_prg
				order by label_prg asc
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$userGroups = array();
				while($data = $q->getArray()) {
					$userGroups[$data['userId_gu']][$data['groupId_gu']] = $data['groupId_gu'];
				}
			}
		}
		if (!isset($userGroups[$user])) {
			return array();
		} else {
			if ($returnIds) {
				return $userGroups[$user];
			} else {
				$groups = array();
				foreach($userGroups[$user] as $groupdId) {
					$groups[$groupdId] = CMS_profile_usersGroupsCatalog::getById($groupdId,$reset);
				}
				return $groups;
			}
		}
	}
	
	/**
	  * Deprecated, Returns the first userGroup, to which a user belongs to
	  * Returns empty group if no group found
	  * Static function.
	  * 
	  * @param CMS_profile_user|integer $user
	  * @return CMS_profile_usersGroup
	  * @access public
	  */
	function getGroupOfUser($user) {
		CMS_grandFather::raiseError('This function is deprecated since Automne 3.3.0, You must use getGroupsOfUser instead !');
		$groups = CMS_profile_usersGroupsCatalog::getGroupsOfUser($user);
		if (is_array($groups) && $groups) {
			return array_shift($groups);
		} else {
			return new CMS_profile_usersGroup();
		}
	}
	
	/**
	  * Returns boolean depending on wheather label exists or not
	  * Static function.
	  * 
	  * @param string $label
	  * @param integer $groupId
	  * @access public
	  */
	function labelExists($label, $groupId=0)
	{
		if ((SensitiveIO::isPositiveInteger($groupId) 
								|| $groupId==0) && $label) {
			$sqlWhere = '';
			if ($groupId) {
				$sqlWhere = "
					id_prg  != '".$groupId."' 
				 and ";	
			}
			$sql = "
				select distinct
					*
				from
					profilesUsersGroups
				where
					".$sqlWhere."
					label_prg='".trim(sensitiveIO::sanitizeSQLString($label))."'
			";
			$q = new CMS_query($sql);
		   return $q->getNumRows();
		}
		// As label may exist
		return true;
	}
	
	/**
	  * Checks all the profile groups, except $group to see if LDAP dn doesnt
	  * exist. Static function.
	  *
	  * @param CMS_profile_userGroup $group
	  * @param string $dn
	  * @return boolean
	  * @access public
	  */
	function dnExists($dn, &$group)
	{
		if($group->getInvertDN()) {
			$attribute = substr($dn,0,strpos($dn,'=')+1);
			$sql = "
				select
					*
				from
					profilesUsersGroups
				where
					dn_prg LIKE '".$attribute."%' 
					and dn_prg != '".SensitiveIO::sanitizeSQLString($dn)."' 
					and invertdn_prg=1
					and id_prg != '".$group->getGroupId()."'
			";
		} else {
			$sql = "
				select
					*
				from
					profilesUsersGroups
				where
					dn_prg = '".SensitiveIO::sanitizeSQLString($dn)."' 
					and invertdn_prg=0
					and id_prg != '".$group->getGroupId()."'
			";
		}
		$q = new CMS_query($sql);
		return $q->getNumRows();
	}
	
	/**
	  * Gets the users for a group
	  * Static function.
	  * 
	  * @param integer $groupID
	  * @param boolean returnObjects : return CMS_profile_user objects (default) or array of userId
	  * @access public
	  */
	function getGroupUsers($groupID, $returnObjects = true)
	{
		$sql = "
			select
				id_pru
			from
				profilesUsers,
				profileUsersByGroup
			where
				userId_gu=id_pru
				and deleted_pru=0
				and groupId_gu='".SensitiveIO::sanitizeSQLString($groupID)."'
			order by
				lastName_pru,
				firstName_pru
		";
		$q = new CMS_query($sql);
		
		$users = array();
		while ($id = $q->getValue("id_pru")) {
			if ($returnObjects) {
				$usr = CMS_profile_usersCatalog::getByID($id);
				if (is_a($usr, "CMS_profile_user") && !$usr->hasError()) {
					$users[$id] = $usr;
				}
			} else {
				$users[$id] = $id;
			}
		}
		return $users;
	}
	
	/**
	  * Get all the letters that have a least one group with a title beginning with
	  * Static function.
	  *
	  * @return array(string)
	  * @access public
	  */
	function getLettersForTitle()
	{
		$sql = "
			select
				left(label_prg, 1) as initial
			from
				profilesUsersGroups
			group by
				initial
			order by
				initial
		";
		$q = new CMS_query($sql);
		$letters = array();
		while ($letter = $q->getValue("initial")) {
			$letters[] = ucfirst($letter);
		}
		return $letters;
	}
	
	/**
	  * Is user belongs to given group ?
	  *
	  * @return boolean
	  * @access public
	  * @static
	  */
	function userBelongsToGroup($userID, $groupID) {
		if (!sensitiveIO::isPositiveInteger($userID) || !sensitiveIO::isPositiveInteger($groupID)) {
			CMS_grandFather::raiseError('User id and group id must be positive integers');
			return false;
		}
		$sql = "
			select
				1
			from
				profileUsersByGroup
			where
				userId_gu = '".SensitiveIO::sanitizeSQLString($userID)."'
				and groupId_gu = '".SensitiveIO::sanitizeSQLString($groupID)."'
		";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? true : false;
	}
	
	/**
	  * Get all groups labels
	  *
	  * @return array(id => label) groups label
	  * @access public
	  * @static
	  */
	function getGroupsLabels() {
		$sql = "
			select
				id_prg as id,
				label_prg as label
			from
				profilesUsersGroups
			order by 
				label_prg asc
		";
		$q = new CMS_query($sql);
		$groupsLabel = array();
		if ($q->getNumRows()) {
			while ($r = $q->getArray()) {
				$groupsLabel[$r['id']] = $r['label'];
			}
		}
		return $groupsLabel;
	}
	
	/**
      * Get all groups DNs infos
      *
      * @return array(id => dn) groups dn
      * @access public
      * @static
      */
    function getGroupsDN() {
            $sql = "
                    select
                            id_prg as id,
                            dn_prg as dn
                    from
                            profilesUsersGroups
                    where
                            dn_prg != ''
                    order by
                            dn_prg asc
            ";
            $q = new CMS_query($sql);
            $groupsDN = array();
            if ($q->getNumRows()) {
                    while ($r = $q->getArray()) {
                            $dnInfos = explode('§§', $r['dn']);
                            $ldapDN = (isset($dnInfos[0])) ? $dnInfos[0] : '';
                            $ldapFilter = (isset($dnInfos[1])) ? $dnInfos[1] : '';
                            $groupsDN[$r['id']] = array('dn' => $ldapDN, 'filter' => $ldapFilter);
                    }
            }
            return $groupsDN;
    }
}
?>