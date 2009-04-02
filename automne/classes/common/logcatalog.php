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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr>                |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: logcatalog.php,v 1.3 2009/04/02 13:57:59 sebastien Exp $

/**
  * Class CMS_log_catalog
  *
  * Keeps track of logging action
  *
  * @package CMS
  * @subpackage common
  * @author Andre Haynes <andre.haynes@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_log_catalog extends CMS_grandFather
{
	/**
	  * Get by resource
	  *
	  * @param CMS_
	  * @return array(CMS_log)
	  * @access public
	  */
	function getByResource($moduleCodename, $resourceId, $start = 0, $limit = false, $order = 'datetime', $direction = 'desc', $returnCount = false) {
		$start = (int) $start;
		$limit = ($limit) ? (int) $limit : false;
		$order = (in_array($order, array('datetime', 'user', 'action'))) ? $order.'_log' : 'datetime_log';
		$direction = (in_array($direction, array('asc', 'desc'))) ? $direction : 'desc';
		
		$sql = "
			select
				*
			from
				log
			where
				module_log='".sensitiveIO::sanitizeSQLString($moduleCodename)."'
				and resource_log='".sensitiveIO::sanitizeSQLString($resourceId)."'";
		if (!$returnCount) {
			$sql .= "order by ".$order." ".$direction;
			if ($limit && sensitiveIO::isPositiveInteger($limit)) {
				$sql .= " limit ".$start.", ".$limit;
			}
		}
		$q = new CMS_query($sql);
		if ($returnCount) {
			return $q->getNumRows();
		}
		$logs = array();
		if ($q->getNumRows()) {
			$users = array();
			while ($r = $q->getArray()) {
				if (!isset($users[$r["user_log"]])) {
					$users[$r["user_log"]] = CMS_profile_usersCatalog::getByID($r["user_log"]);
				}
				$lg = new CMS_log($r, $users[$r["user_log"]]);
				if (!$lg->hasError()) {
					$logs[] = $lg;
				}
			}
		}
		return $logs;
	}
	
	/**
	  * Get by user : returns the log actions for a user
	  *
	  * @param integer $userID
	  * @param boolean $includeResourceActions If set to true, the resource actions are also included in the result set
	  * @return array(CMS_log)
	  * @access public
	  */
	function getByUser($userID, $includeResourceActions = false) {
		if (!SensitiveIO::isPositiveInteger($userID)) {
			return array();
		}
		$sql = "
			select
				*
			from
				log
			where
				user_log='".sensitiveIO::sanitizeSQLString($userID)."'
			order by
				datetime_log desc
		";
		$logs = array();
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			$users = array();
			while ($r = $q->getArray()) {
				if (!isset($users[$r["user_log"]])) {
					$users[$r["user_log"]] = CMS_profile_usersCatalog::getByID($r["user_log"]);
				}
				$lg = new CMS_log($r, $users[$r["user_log"]]);
				if (!$lg->hasError()) {
					$logs[] = $lg;
				}
			}
		}
		return $logs;
	}
	
	/**
	  * Get by resource
	  *
	  * @param CMS_
	  * @return array(CMS_log)
	  * @access public
	  */
	function getByResourceAction($moduleCodename, $resourceId, $action, $limit=false) {
		$sql = "
			select
				*
			from
				log
			where
				module_log='".sensitiveIO::sanitizeSQLString($moduleCodename)."'
				and resource_log='".sensitiveIO::sanitizeSQLString($resourceId)."'
				and action_log='".sensitiveIO::sanitizeSQLString($action)."'
			order by
				datetime_log desc
		";
		if ($limit && sensitiveIO::isPositiveInteger($limit)) {
			$sql .= " limit 0, ".$limit;
		}
		$logs = array();
		$q = new CMS_query($sql);
		if ($q->getNumRows()) {
			$users = array();
			while ($r = $q->getArray()) {
				if (!isset($users[$r["user_log"]])) {
					$users[$r["user_log"]] = CMS_profile_usersCatalog::getByID($r["user_log"]);
				}
				$lg = new CMS_log($r, $users[$r["user_log"]]);
				if (!$lg->hasError()) {
					$logs[] = $lg;
				}
			}
		}
		return $logs;
	}
	
	/**
	  * Get All the resource actions possible
	  *
	  * @return array(integer=>integer) The actions indexed by their messages
	  * @access public
	  */
	function getResourceActions()
	{
		return array(	CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_BASEDATA		=> CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_CONTENT		=> CMS_log::LOG_ACTION_RESOURCE_EDIT_CONTENT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DELETE				=> CMS_log::LOG_ACTION_RESOURCE_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_UNDELETE			=> CMS_log::LOG_ACTION_RESOURCE_UNDELETE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_ARCHIVE			=> CMS_log::LOG_ACTION_RESOURCE_ARCHIVE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_UNARCHIVE			=> CMS_log::LOG_ACTION_RESOURCE_UNARCHIVE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_CANCEL_EDITIONS	=> CMS_log::LOG_ACTION_RESOURCE_CANCEL_EDITIONS,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_VALIDATE_EDITION	=> CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_DRAFT			=> CMS_log::LOG_ACTION_RESOURCE_EDIT_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DELETE_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_DELETE_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_SUBMIT_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT);
	}

	/**
	  * Get All the misc actions possible
	  *
	  * @return array(integer=>integer) The actions indexed by their messages
	  * @access public
	  */
	function getMiscActions()
	{
		return array(	CMS_log::MESSAGE_LOG_ACTION_WEBSITE_ADD							=> CMS_log::LOG_ACTION_WEBSITE_ADD,
						CMS_log::MESSAGE_LOG_ACTION_WEBSITE_EDIT						=> CMS_log::LOG_ACTION_WEBSITE_EDIT,
						CMS_log::MESSAGE_LOG_ACTION_WEBSITE_DELETE						=> CMS_log::LOG_ACTION_WEBSITE_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_PROFILE_GROUP_EDIT					=> CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT,
						CMS_log::MESSAGE_LOG_ACTION_PROFILE_GROUP_DELETE				=> CMS_log::LOG_ACTION_PROFILE_GROUP_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_PROFILE_USER_EDIT					=> CMS_log::LOG_ACTION_PROFILE_USER_EDIT,
						CMS_log::MESSAGE_LOG_ACTION_PROFILE_USER_DELETE					=> CMS_log::LOG_ACTION_PROFILE_USER_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_EDIT						=> CMS_log::LOG_ACTION_TEMPLATE_EDIT,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_EDIT_ROW					=> CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_DELETE						=> CMS_log::LOG_ACTION_TEMPLATE_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_DELETE_ROW					=> CMS_log::LOG_ACTION_TEMPLATE_DELETE_ROW,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_EDIT_FILE					=> CMS_log::LOG_ACTION_TEMPLATE_EDIT_FILE,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_DELETE_FILE				=> CMS_log::LOG_ACTION_TEMPLATE_DELETE_FILE,
						CMS_log::MESSAGE_LOG_ACTION_SEND_EMAIL							=> CMS_log::LOG_ACTION_SEND_EMAIL);
	}

	/**
	  * Get All the actions possible
	  *
	  * @return array(integer=>integer) The actions indexed by their messages
	  * @access public
	  */
	function getAllActions()
	{
		return array(	CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_BASEDATA		=> CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_CONTENT		=> CMS_log::LOG_ACTION_RESOURCE_EDIT_CONTENT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER	=> CMS_log::LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_MOVE			=> CMS_log::LOG_ACTION_RESOURCE_EDIT_MOVE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DELETE				=> CMS_log::LOG_ACTION_RESOURCE_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_UNDELETE			=> CMS_log::LOG_ACTION_RESOURCE_UNDELETE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_ARCHIVE			=> CMS_log::LOG_ACTION_RESOURCE_ARCHIVE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_UNARCHIVE			=> CMS_log::LOG_ACTION_RESOURCE_UNARCHIVE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_CANCEL_EDITIONS	=> CMS_log::LOG_ACTION_RESOURCE_CANCEL_EDITIONS,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_VALIDATE_EDITION	=> CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_DRAFT			=> CMS_log::LOG_ACTION_RESOURCE_EDIT_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DELETE_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_DELETE_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_SUBMIT_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_WEBSITE_ADD					=> CMS_log::LOG_ACTION_WEBSITE_ADD,
						CMS_log::MESSAGE_LOG_ACTION_WEBSITE_EDIT				=> CMS_log::LOG_ACTION_WEBSITE_EDIT,
						CMS_log::MESSAGE_LOG_ACTION_WEBSITE_DELETE				=> CMS_log::LOG_ACTION_WEBSITE_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_PROFILE_GROUP_EDIT			=> CMS_log::LOG_ACTION_PROFILE_GROUP_EDIT,
						CMS_log::MESSAGE_LOG_ACTION_PROFILE_GROUP_DELETE		=> CMS_log::LOG_ACTION_PROFILE_GROUP_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_PROFILE_USER_EDIT			=> CMS_log::LOG_ACTION_PROFILE_USER_EDIT,
						CMS_log::MESSAGE_LOG_ACTION_PROFILE_USER_DELETE			=> CMS_log::LOG_ACTION_PROFILE_USER_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_EDIT				=> CMS_log::LOG_ACTION_TEMPLATE_EDIT,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_EDIT_ROW			=> CMS_log::LOG_ACTION_TEMPLATE_EDIT_ROW,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_DELETE				=> CMS_log::LOG_ACTION_TEMPLATE_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_DELETE_ROW			=> CMS_log::LOG_ACTION_TEMPLATE_DELETE_ROW,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_EDIT_FILE			=> CMS_log::LOG_ACTION_TEMPLATE_EDIT_FILE,
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_DELETE_FILE		=> CMS_log::LOG_ACTION_TEMPLATE_DELETE_FILE,
						CMS_log::MESSAGE_LOG_ACTION_SEND_EMAIL					=> CMS_log::LOG_ACTION_SEND_EMAIL);
	}
}
?>