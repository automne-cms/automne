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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
  
/**
  * PHP page : Load page logs datas
  * Used accross an Ajax request.
  * Return formated logs infos in JSON format
  *
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_LOGS_ACTION", 910);
define("MESSAGE_PAGE_LOADING", 1321);

define("MESSAGE_PAGE_DATE", 905);
define("MESSAGE_PAGE_MESSAGE", 362);
define("MESSAGE_PAGE_AUTHOR", 1033);
define("MESSAGE_PAGE_SUPPLEMENT", 363);
define("MESSAGE_PAGE_LOG_X_ON", 567);
define("MESSAGE_PAGE_NO_LOG", 568);

//load interface instance
$view = CMS_view::getInstance();

//set default options
$winId = sensitiveIO::request('winId', '', 'logPanel');
$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger');
$action = sensitiveIO::request('action', '', 'view');
$start = sensitiveIO::request('start', '', 0);
$limit = sensitiveIO::request('limit', '', CMS_session::getRecordsPerPage());
$order = sensitiveIO::request('sort', '', 'datetime');
$direction = io::strtolower(sensitiveIO::request('dir', '', 'desc'));

//user can view logs only if it has rights on logs or on page edition
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG) && !$cms_user->hasPageClearance($currentPage, CLEARANCE_PAGE_EDIT)) {
	CMS_grandFather::raiseError('User has not rights to view logs ...');
	$view->show();
}

//load page
$cms_page = CMS_tree::getPageByID($currentPage);
if (!$cms_page || $cms_page->hasError()) {
	CMS_grandFather::raiseError('Selected page ('.$currentPage.') has error ...');
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
					currentPage:		'{$currentPage}'
				},
				root			: 'items',
				versionProperty	: 'version',
				totalProperty	: 'total_count',
				id				: 'id',
				fields:			['status', 'datetime', 'action', 'user', 'text'],
				remoteSort:		true,
				sortInfo:		{field: 'date', direction: 'DESC'},
				url:			'{$_SERVER['SCRIPT_NAME']}'
			});
			var grid = new Ext.grid.GridPanel({
				title:			'{$cms_language->getJSMessage(MESSAGE_PAGE_LOGS_ACTION, array(io::htmlspecialchars("'".$cms_page->getTitle()."'")))}',
				region:			'center',
				border:			false,
				store:			store,
				enableDragDrop:	false,
				columns:		[
					{header: "&nbsp;",													align : 'left',	width: 35, sortable: false, dataIndex: 'status'},
					{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_DATE)}",		align : 'left',	width: 120, sortable: true, dataIndex: 'datetime'},
					{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_MESSAGE)}",		align : 'left',	width: 200,	sortable: true, dataIndex: 'action',	id: 'action'},
					{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_AUTHOR)}",		align : 'left',	width: 160, sortable: true, dataIndex: 'user',		renderer:function(value) {return '<a href="#" onclick="Automne.view.user('+ value[0] +');">'+ value[1] +'</a>';}},
					{header: "{$cms_language->getJSMessage(MESSAGE_PAGE_SUPPLEMENT)}",	align : 'left',	width: 160, sortable: false, dataIndex: 'text'}
				],
				sm:				new Ext.grid.RowSelectionModel(),
				bbar:				new Ext.PagingToolbar({
					pageSize: 			{$recordsPerPage},
					store: 				store,
					displayInfo: 		true,
					displayMsg: 		'{$cms_language->getJsMessage(MESSAGE_PAGE_LOG_X_ON)}',
					emptyMsg: 			'{$cms_language->getJsMessage(MESSAGE_PAGE_NO_LOG)} ...'
				})
			});
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
		$actions = CMS_log_catalog::getByResource(MOD_STANDARD_CODENAME, $cms_page->getID(), $start, $limit, $order, $direction);
		$feeds = array();
		$feeds['items'] = array();
		foreach ($actions as $action) {
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
	        );
		}
		
		$feeds['total_count'] = CMS_log_catalog::getByResource(MOD_STANDARD_CODENAME, $cms_page->getID(), $start, $limit, $order, $direction, true);
		$feeds['version']	= 1;
		
		$view->setContent($feeds);
	break;
}
$view->show();
?>