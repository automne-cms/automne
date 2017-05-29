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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: logcatalog.php,v 1.6 2010/03/08 16:43:28 sebastien Exp $

/**
  * Class CMS_log_catalog
  *
  * Keeps track of logging action
  *
  * @package Automne
  * @subpackage common
  * @author Andre Haynes <andre.haynes@ws-interactive.fr>
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_log_catalog extends CMS_grandFather
{
	/**
	  * Search log
	  *
	  * @return array(CMS_log)
	  * @access public
	  */
	static function search($moduleCodename = '', $resourceId = 0, $userId = 0, $types = array(), $datestart = false, $dateend = false, $start = 0, $limit = false, $order = 'datetime', $direction = 'desc', $returnCount = false) {
		$start = (int) $start;
		$limit = ($limit) ? (int) $limit : false;
		$order = (in_array($order, array('datetime', 'user', 'action'))) ? $order.'_log' : 'datetime_log';
		$direction = (in_array($direction, array('asc', 'desc'))) ? $direction : 'desc';
		
		$where = '';
		if ($moduleCodename) {
			$where .= "
				module_log='".sensitiveIO::sanitizeSQLString($moduleCodename)."'";
		}
		if (sensitiveIO::isPositiveInteger($resourceId) && $moduleCodename) {
			$where .= $where ? ' and ' : '';
			$where .= "
				resource_log='".sensitiveIO::sanitizeSQLString($resourceId)."'";
		}
		if (sensitiveIO::isPositiveInteger($userId)) {
			$where .= $where ? ' and ' : '';
			$where .= "
				user_log='".sensitiveIO::sanitizeSQLString($userId)."'";
		}
		if ($datestart && is_a($datestart, 'CMS_date')) {
			$where .= $where ? ' and ' : '';
			$where .= "
				datetime_log >= '".sensitiveIO::sanitizeSQLString($datestart->getDBValue(true))."'";
		}
		if ($dateend && is_a($dateend, 'CMS_date')) {
			$dateend->moveDate('+1 day');
			$where .= $where ? ' and ' : '';
			$where .= "
				datetime_log <= '".sensitiveIO::sanitizeSQLString($dateend->getDBValue(true))."'";
		}
		if (is_array($types) && $types) {
			$where .= $where ? ' and ' : '';
			$where .= "
				action_log in (".implode(',', $types).")";
		}
		$where = $where ? ' where '.$where : '';
		$sql = "
			select
				*
			from
				log
			".$where;
		
		if (!$returnCount) {
			$sql .= "order by ".$order." ".$direction;
			if ($limit && sensitiveIO::isPositiveInteger($limit)) {
				$sql .= " limit ".$start.", ".$limit;
			}
		}
		//pr($sql);
		$q = new CMS_query($sql);
		if ($returnCount) {
			return $q->getNumRows();
		}
		$logs = array();
		if ($q->getNumRows()) {
			while ($r = $q->getArray()) {
				$user = CMS_profile_usersCatalog::getByID($r["user_log"]);
				$log = new CMS_log($r, $user);
				if (!$log->hasError()) {
					$logs[] = $log;
				}
			}
		}
		return $logs;
	}
	
	/**
	  * Purge (delete) log
	  *
	  * @return boolean
	  * @access public
	  */
	static function purge($moduleCodename = '', $resourceId = 0, $userId = 0, $types = array()) {
		$where = ' UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(datetime_log) > 5184000';
		if ($moduleCodename) {
			$where .= " and module_log='".sensitiveIO::sanitizeSQLString($moduleCodename)."'";
		}
		if (sensitiveIO::isPositiveInteger($resourceId) && $moduleCodename) {
			$where .= " and resource_log='".sensitiveIO::sanitizeSQLString($resourceId)."'";
		}
		if (sensitiveIO::isPositiveInteger($userId)) {
			$where .= " and user_log='".sensitiveIO::sanitizeSQLString($userId)."'";
		}
		if (is_array($types) && $types) {
			$where .= " and action_log in (".implode(',', $types).")";
		}
		$sql = "
			delete
			from
				log
			where
			".$where;
		$q = new CMS_query($sql);
		return true;
	}
	
	/**
	  * Get by resource
	  *
	  * @param CMS_
	  * @return array(CMS_log)
	  * @access public
	  */
	static function getByResource($moduleCodename, $resourceId, $start = 0, $limit = false, $order = 'datetime', $direction = 'desc', $returnCount = false) {
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
	  * Get by resource
	  *
	  * @param CMS_
	  * @return array(CMS_log)
	  * @access public
	  */
	static function getByResourceAction($moduleCodename, $resourceId, $action, $limit=false) {
		$sql = "
			select
				*
			from
				log
			where
				module_log='".sensitiveIO::sanitizeSQLString($moduleCodename)."'
				and resource_log='".sensitiveIO::sanitizeSQLString($resourceId)."'";
		if (is_array($action)) {
			$sql .= " and action_log in (".sensitiveIO::sanitizeSQLString(implode(',', $action)).")";
		} else {
			$sql .= " and action_log='".sensitiveIO::sanitizeSQLString($action)."'";
		}
		$sql .= "
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
	static function getResourceActions()
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
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_START_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_START_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_DRAFT			=> CMS_log::LOG_ACTION_RESOURCE_EDIT_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DELETE_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_DELETE_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_SUBMIT_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DIRECT_VALIDATION	=> CMS_log::LOG_ACTION_RESOURCE_DIRECT_VALIDATION);
	}

	/**
	  * Get All the misc actions possible
	  *
	  * @return array(integer=>integer) The actions indexed by their messages
	  * @access public
	  */
	static function getMiscActions()
	{
		return array(	CMS_log::MESSAGE_LOG_ACTION_WEBSITE_ADD					=> CMS_log::LOG_ACTION_WEBSITE_ADD,
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
						CMS_log::MESSAGE_LOG_ACTION_TEMPLATE_DELETE_FILE		=> CMS_log::LOG_ACTION_TEMPLATE_DELETE_FILE);
	}
	
	/**
	  * Get All the login actions possible
	  *
	  * @return array(integer=>integer) The actions indexed by their messages
	  * @access public
	  */
	static function getLoginActions()
	{
		return array(	CMS_log::MESSAGE_LOG_ACTION_LOGIN						=> CMS_log::LOG_ACTION_LOGIN,
						CMS_log::MESSAGE_LOG_ACTION_AUTO_LOGIN					=> CMS_log::LOG_ACTION_AUTO_LOGIN,
						CMS_log::MESSAGE_LOG_ACTION_DISCONNECT					=> CMS_log::LOG_ACTION_DISCONNECT,);
	}
	
	/**
	  * Get All the emails actions possible
	  *
	  * @return array(integer=>integer) The actions indexed by their messages
	  * @access public
	  */
	static function getEmailActions() {
		return array(	CMS_log::MESSAGE_LOG_ACTION_SEND_EMAIL					=> CMS_log::LOG_ACTION_SEND_EMAIL);
	}
	
	/**
	  * Get All the modules actions possible
	  *
	  * @return array(integer=>integer) The actions indexed by their messages
	  * @access public
	  */
	static function getModulesActions($cms_language) {
		$modules = CMS_modulesCatalog::getAll();
		$actions = array();
		foreach ($modules as $module) {
			if (method_exists($module , 'getLogActions')) {
				foreach ($module->getLogActions() as $msg => $action) {
					$actions[$cms_language->getMessage($msg, false, $module->getCodename())] = $action;
				}
			}
		}
		return $actions;
	}
	
	/**
	  * Get All the actions possible
	  *
	  * @return array(integer=>integer) The actions indexed by their messages
	  * @access public
	  */
	static function getAllActions($cms_language) {
		$modulesActions = CMS_log_catalog::getModulesActions($cms_language);
		$defaultActions = array(	CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_BASEDATA		=> CMS_log::LOG_ACTION_RESOURCE_EDIT_BASEDATA,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_CONTENT		=> CMS_log::LOG_ACTION_RESOURCE_EDIT_CONTENT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER	=> CMS_log::LOG_ACTION_RESOURCE_EDIT_SIBLINGSORDER,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_MOVE			=> CMS_log::LOG_ACTION_RESOURCE_EDIT_MOVE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DELETE				=> CMS_log::LOG_ACTION_RESOURCE_DELETE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_UNDELETE			=> CMS_log::LOG_ACTION_RESOURCE_UNDELETE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_ARCHIVE			=> CMS_log::LOG_ACTION_RESOURCE_ARCHIVE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_UNARCHIVE			=> CMS_log::LOG_ACTION_RESOURCE_UNARCHIVE,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_CANCEL_EDITIONS	=> CMS_log::LOG_ACTION_RESOURCE_CANCEL_EDITIONS,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_VALIDATE_EDITION	=> CMS_log::LOG_ACTION_RESOURCE_VALIDATE_EDITION,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_START_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_START_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_EDIT_DRAFT			=> CMS_log::LOG_ACTION_RESOURCE_EDIT_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DELETE_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_DELETE_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_SUBMIT_DRAFT		=> CMS_log::LOG_ACTION_RESOURCE_SUBMIT_DRAFT,
						CMS_log::MESSAGE_LOG_ACTION_RESOURCE_DIRECT_VALIDATION	=> CMS_log::LOG_ACTION_RESOURCE_DIRECT_VALIDATION,
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
						CMS_log::MESSAGE_LOG_ACTION_SEND_EMAIL					=> CMS_log::LOG_ACTION_SEND_EMAIL,
						CMS_log::MESSAGE_LOG_ACTION_LOGIN						=> CMS_log::LOG_ACTION_LOGIN,
						CMS_log::MESSAGE_LOG_ACTION_AUTO_LOGIN					=> CMS_log::LOG_ACTION_AUTO_LOGIN,
						CMS_log::MESSAGE_LOG_ACTION_DISCONNECT					=> CMS_log::LOG_ACTION_DISCONNECT,
		);
		return $modulesActions ? ($modulesActions + $defaultActions) : $defaultActions;
	}
}
?>