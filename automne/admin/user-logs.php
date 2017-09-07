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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+

/**
  * PHP page : Load user logs datas
  * Used accross an Ajax request.
  * Return formated logs infos in JSON format
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_LOGS_ACTION", 910);
define("MESSAGE_PAGE_LOADING", 1321);
define("MESSAGE_PAGE_LOG_X_ON", 567);
define("MESSAGE_PAGE_NO_LOG", 568);
define("MESSAGE_PAGE_FIELD_DATE", 905);
define("MESSAGE_PAGE_FIELD_ACTION", 906);
define("MESSAGE_PAGE_FIELD_COMMENTS", 907);
define("MESSAGE_PAGE_FIELD_STATUS", 909);
define("MESSAGE_PAGE_FIELD_ELEMENT", 1579);

//load interface instance
$view = CMS_view::getInstance();

//set default options
$winId = sensitiveIO::request('winId', '', 'logPanel');
$userId = sensitiveIO::request('user', 'sensitiveIO::isPositiveInteger');
$action = sensitiveIO::request('action', '', 'view');
$start = sensitiveIO::request('start', '', 0);
$limit = sensitiveIO::request('limit', '', CMS_session::getRecordsPerPage());
$order = sensitiveIO::request('sort', '', 'datetime');
$direction = io::strtolower(sensitiveIO::request('dir', '', 'desc'));

//user can view logs only if it has rights on logs or on user edition
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG) && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
	CMS_grandFather::raiseError('User has not rights to view logs ...');
	$view->show();
}

//load user
$user = CMS_profile_usersCatalog::getByID($userId);
if (!$user || $user->hasError()) {
	CMS_grandFather::raiseError('Unknown user for given Id : '.$userId);
	$view->show();
}

//get records / pages
$recordsPerPage = CMS_session::getRecordsPerPage();

switch ($action) {
	case 'view':
		//set default display mode for this page
		$view->setDisplayMode(CMS_view::SHOW_RAW);
		//This file is an admin file. Interface must be secure
		$view->setSecure();
		
		$jscontent = <<<END
			var logPanel = Ext.getCmp('{$winId}');
			
			var store = new Automne.JsonStore({
				autoLoad:			true,
				baseParams:			{
					action:				'search',
					user:		'{$userId}'
				},
				root			: 'items',
				versionProperty	: 'version',
				totalProperty	: 'total_count',
				id				: 'id',
				fields:			['status', 'datetime', 'action', 'element', 'comment'],
				remoteSort:		true,
				sortInfo:		{field: 'date', direction: 'DESC'},
				url:			'{$_SERVER['SCRIPT_NAME']}'
			});
			
			var grid = new Ext.grid.GridPanel({
				title:				'{$cms_language->getJSMessage(MESSAGE_PAGE_LOGS_ACTION, array(io::htmlspecialchars("'".$user->getFullname()."'")))}',
				region:				'center',
				border:				false,
				store:				store,
				enableDragDrop:		false,
				/*autoExpandColumn:	'comment',*/
				cm: 				new Ext.grid.ColumnModel([
					{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_DATE)}", 		width: 110, dataIndex: 'datetime',	sortable: true},
					{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_ELEMENT)}", 	width: 110,	dataIndex: 'element',	sortable: false},
					{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_ACTION)}", 	width: 150, dataIndex: 'action',	sortable: true},
					{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_STATUS)}", 	width: 35, 	dataIndex: 'status',	sortable: false},
					{header: "{$cms_language->getJsMessage(MESSAGE_PAGE_FIELD_COMMENTS)}", 	width: 120, dataIndex: 'comment',	sortable: false}
				]),
				viewConfig: 		{
					forceFit:			true
				},
				
				
				sm:				new Ext.grid.RowSelectionModel(),
				bbar:				new Ext.PagingToolbar({
					pageSize: 			{$recordsPerPage},
					store: 				store,
					displayInfo: 		true,
					displayMsg: 		'{$cms_language->getJsMessage(MESSAGE_PAGE_LOG_X_ON)}',
					emptyMsg: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_NO_LOG)} ...'
				})
			});
			//logPanel.add(top);
			logPanel.add(grid);
			//redo windows layout
			logPanel.doLayout();
END;
		$view->addJavascript($jscontent);
	break;
	case 'search':
		//set default display mode for this page
		$view->setDisplayMode(CMS_view::SHOW_JSON);
		//This file is an admin file. Interface must be secure
		$view->setSecure();
		
		$actionlabels = CMS_log_catalog::getAllActions($cms_language);
		$logs = CMS_log_catalog::search('', 0, $userId, array(), false, false, $start, $limit, $order, $direction);
		
		$feeds = array();
		$feeds['items'] = array();
		/*foreach ($actions as $action) {
			$dt = $action->getDatetime();
			$usr = $action->getUser();
			$status = $action->getResourceStatusAfter();
			$feeds['items'][] = array( 
				'id'			=> $action->getID(),
				'status'		=> $status->getHTML(true, false, false, false, false),
				'datetime'		=> $dt->getLocalizedDate($cms_language->getDateFormat().' H:i:s'), 
				'action'		=> $cms_language->getMessage(array_search($action->getLogAction(), $actionlabels)),
				'user'			=> array($usr->getUserId(),$usr->getFullName()),
				'text'			=> $action->getTextData(),
				
				
				'id'			=> $action->getID(),
				'datetime'		=> $dt->getLocalizedDate($cms_language->getDateFormat().' H:i:s'),
				'element'		=> $element,
				'action'		=> $actionLabel,
				'status'		=> $status,
				'comment'		=> $action->getTextData(),
				
				
	        );
		}*/
		$actions = CMS_log_catalog::getAllActions($cms_language);
		foreach ($logs as $log) {
			$dt = $log->getDatetime();
			//$user = $log->getUser();
			$resource = $log->getResource();
			if ($resource) {
				$status = $log->getResourceStatusAfter()->getHTML(true,false,false,false,false);
				$module = $log->getModule();
				$element = '';
				if ($resource && !$resource->hasError()) {
					$method = '';
					if (method_exists($module, 'getRessourceNameMethod') && $module->getRessourceNameMethod()) {
						$method = $module->getRessourceNameMethod();
					} elseif (method_exists($resource, 'getLabel')) {
						$method = 'getLabel';
					} elseif (method_exists($resource, 'getTitle')) {
						$method = 'getTitle';
					}
					if ($method) {
						$element = $resource->{$method}();
					}
					if (!$element) {
						$element = $resource->getID();
					} else {
						$element .= ' ('.$resource->getID().')';
					}
					//get resource type label
					if (method_exists($module, 'getRessourceTypeLabelMethod') && $module->getRessourceTypeLabelMethod()) {
						$element = $resource->{$module->getRessourceTypeLabelMethod()}($cms_language).' : '.$element;
					} else {
						$element .= ' ('.$module->getLabel($cms_language).')';
					}
				}
			} else {
				$element = $status = '';
			}
			$actionKey = array_search($log->getLogAction(), $actions);
			$actionLabel = io::isPositiveInteger($actionKey) ? $cms_language->getMessage($actionKey) : $actionKey;
			$feeds['items'][] = array( 
				'id'			=> $log->getID(),
				'datetime'		=> $dt->getLocalizedDate($cms_language->getDateFormat().' H:i:s'),
				'element'		=> $element,
				'action'		=> $actionLabel,
				'status'		=> $status,
				'comment'		=> $log->getTextData(),
			);
		}
		
		$feeds['total_count'] = CMS_log_catalog::search('', 0, $userId, array(), false, false, $start, $limit, $order, $direction, true);
		$feeds['version']	= 1;
		
		$view->setContent($feeds);
	break;
}
$view->show();
?>