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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: tree.php,v 1.5 2009/07/20 16:33:15 sebastien Exp $

/**
  * PHP page : Load tree window infos. Presents a portion of the pages tree. Can be used by any admin page.
  * Used accross an Ajax request render page tree in the tree window
  * 
  * REQUEST parameters : 
  * - root : DB ID of the tree root page
  * - editable : display editable only pages (default : false)
  * - backLink : the back link //TODOV4
  * - pageLink : string, will be the link the pages will have. May contain a '%s' which will be replaced by the page DB ID. If not defined, no link on pages
  * - encodedPageLink : same as pageLink but base64 encoded (default)
  * - encodedOnClick : add javascript action on click on a page
  * - pageProperty : string, a page property which will be displayed along the page title. 
  * - title : the title of this page
  * - heading : the heading text of this page
  * - hideMenu : if true, the menu will not be shown
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_TITLE", 62);
define("MESSAGE_PAGE_HEADING", 63);

define("MESSAGE_WINDOW_TITLE", 1031);
define("MESSAGE_TOOLBAR_SEARCH_PAGE", 1091);
define("MESSAGE_TOOLBAR_DISPLAY", 1006);
define("MESSAGE_TOOLBAR_DISPLAY_VISIBLE", 318);
define("MESSAGE_TOOLBAR_DISPLAY_EDITABLE", 319);
define("MESSAGE_SEARCH_LOADING", 1321);
define("MESSAGE_TOOLBAR_FILTER", 322);
define("MESSAGE_TOOLBAR_HELP",1073);
define("MESSAGE_TOOLBAR_HELP_FILTER", 323);
define("MESSAGE_TOOLBAR_HELP_SEARCH", 324);
define("MESSAGE_WINDOW_HELP", 325);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

//simple function used to test a value with the string 'false'
function checkFalse($value) {
	return ($value == 'false');
}
function checkNotFalse($value) {
	return ($value !== 'false');
}
$rootId = sensitiveIO::request('root', 'sensitiveIO::isPositiveInteger', APPLICATION_ROOT_PAGE_ID);
$showRoot = sensitiveIO::request('showRoot', '', true);
$maxlevel = sensitiveIO::request('maxlevel', '', 0);
$editable = (sensitiveIO::request('editable', 'checkNotFalse')) ? true : false;
$pageProperty = sensitiveIO::request('pageProperty');
$onClick = ($onClick = sensitiveIO::request('encodedOnClick')) ? base64_decode($onClick) : false;
if (sensitiveIO::request('encodedOnClick')) {
	$onClick = base64_decode(sensitiveIO::request('encodedOnClick'));
} elseif (sensitiveIO::request('onClick')) {
	$onClick = sensitiveIO::request('onClick');
} else {
	$onClick = false;
}
$onSelect = ($onSelect = sensitiveIO::request('encodedOnSelect')) ? base64_decode($onSelect) : false;
$title = sensitiveIO::request('title', '', $cms_language->getMessage(MESSAGE_WINDOW_TITLE));
$heading = sensitiveIO::request('heading', '', $cms_language->getMessage(MESSAGE_PAGE_HEADING));
$heading = checkNotFalse($heading) ? $heading : '';
$hideMenu = (sensitiveIO::request('hideMenu', 'checkNotFalse')) ? true : false;
$window = sensitiveIO::request('window', '', true);
//$window = (sensitiveIO::request('window', 'checkNotFalse', 'true')) ? 'true' : 'false';
$winId = sensitiveIO::request('winId', '', 'treeWindow');
$el = sensitiveIO::request('el');
$currentPage = sensitiveIO::request('currentPage', 'sensitiveIO::isPositiveInteger');
$enableDD = (sensitiveIO::request('enableDD', 'checkNotFalse')) ? 'true' : 'false';

//THE USER SECTIONS, Check if user has module administration, else hide Modules Frame
$hasSectionsRoots = ($editable) ? $cms_user->hasEditablePages() : $cms_user->hasViewvablePages();

if (!$hasSectionsRoots) {
	CMS_grandFather::raiseError('No sections root founded ...');
	$view->show();
}

//load root page
$root = CMS_tree::getPageByID($rootId);
if (!is_object($root) || $root->hasError()) {
	CMS_grandFather::raiseError('Root page has error ...');
	$view->show();
}

//pageProperty : must be inside the page_properties array
$pageProperties = array("last_creation_date", "template");
if ($pageProperty && !SensitiveIO::isInSet($pageProperty, $pageProperties)) {
	CMS_grandFather::raiseError('Unknown page property : '.$pageProperty);
	$view->show();
}

//set onclick property
if ($enableDD === 'false') {
	if ($el) {
		//replace value of element by clicked page Id
		$onClick = sensitiveIO::sanitizeJSString('
				var el = Ext.get(\''.$el.'\') || Ext.getCmp(\''.$winId.'\').currentEl;
				el.dom.value=\'%s\';
				el.highlight("C3CD31", {duration: 2 });
				Ext.getCmp(\''.$winId.'\').close();
			');
	} elseif (!$onClick) {
		$onClick = sensitiveIO::sanitizeJSString('
				Automne.utils.getPageById(%s);
				Ext.getCmp(\''.$winId.'\').close();
			');
	} else {
		$onClick = sensitiveIO::sanitizeJSString($onClick);
	}
} else {
	$onClick = '';
}
$onSelect = ($onSelect) ? sensitiveIO::sanitizeJSString($onSelect) : '';
$rootnode = array(
	'id'		=>	'root'.$rootId, 
	'leaf'		=>	false, 
	'expanded'	=>	true,
);

//encode nodes array in json
$rootnode = sensitiveIO::jsonEncode($rootnode);

$rootvisible = ($cms_user->hasPageClearance($root->getID(), CLEARANCE_PAGE_VIEW)) ? 'true' : 'false';

$scriptRoot = dirname($_SERVER['SCRIPT_NAME']);

$heading = $heading ? '\''.sensitiveIO::sanitizeJSString($heading).'\'' : 'null';

$imgPath = PATH_ADMIN_IMAGES_WR;
if ($hideMenu) {
	$tbar = "''";
} else {
	$tbar = "new Ext.Toolbar({
			id:				'treeToolbar',
			items:			[";
			if (!$editable) {
				$tbar .= "
				{
					text:		'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_FILTER)}',
					menu: new Ext.menu.Menu({
						id: 	'filterMenu',
						items: [{
									text: 		'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_DISPLAY_VISIBLE)}',
									checked: 	true,
									group: 		'visibility',
									value:		0
								}, {
									text:		'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_DISPLAY_EDITABLE)}',
									checked: 	false,
									group: 		'visibility',
									value:		1
								}]
					})
				},{
					icon:  		'{$imgPath}/help.gif',
					cls: 		'x-btn-icon',
					tooltip: 	{
						title:			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
						text:			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_FILTER)}',
						dismissDelay:	30000
					}
			    },";
			}
			$tbar .= "
				new Ext.Toolbar.Fill(),
				new Automne.ComboBox({
					id: 	'searchBox',
					store: new Ext.data.Store({
						proxy: new Ext.data.HttpProxy({
							url: 				'{$scriptRoot}/search-pages.php',
							disableCaching:		true
						}),
						reader: new Automne.JsonReader({
							root: 				'pages',
							totalProperty: 		'totalCount',
							id: 				'pageId'
						}, [
							{name: 'title', 	mapping: 'title'},
							{name: 'status',	mapping: 'status'}
						])
					}),
					listeners: {'specialkey':function(field, e) {
							if (Ext.EventObject.getKey() == Ext.EventObject.ENTER) {
								field.doQuery(field.getValue());
							}
						},
						scope:this
					},
					displayField:		'title',
					autoLoad:			false,
					typeAhead: 			false,
					width: 				320,
					minListWidth:		320,
					resizable: 			true,
					loadingText:		'{$cms_language->getJsMessage(MESSAGE_SEARCH_LOADING)}',
					minChars:			3,
					maxHeight:			400,
					queryDelay:			350,
					pageSize:			10,
					hideTrigger:		true,
					emptyText:			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_SEARCH_PAGE)}',
					tpl: new Ext.XTemplate(
						'<tpl for=\".\"><div class=\"search-item atm-search-item\">',
							'<h3>{status}&nbsp;{title}</h3>',
						'</div></tpl>'
					),
					itemSelector: 		'div.atm-search-item'
				}),
				new Ext.Toolbar.Spacer(),
				{
					icon:  		'{$imgPath}/help.gif',
					cls: 		'x-btn-icon',
					tooltip: 	{
						title:			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
						text:			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP_SEARCH)}',
						dismissDelay:	30000
					}
			    }
			]
		})
	";
}
$jscontent = <<<END
	var treeWindow = Ext.getCmp('{$winId}');
	//if we are in a window context
	if ({$window}) {
		//set window title
		treeWindow.setTitle('{$title}');
		//set window icon
		treeWindow.setIconClass('atm-pic-tree');
		//set help button on top of page
		treeWindow.tools['help'].show();
		//add a tooltip on button
		var treeTip = new Ext.ToolTip({
			target: 		treeWindow.tools['help'],
			title: 			'{$cms_language->getJsMessage(MESSAGE_TOOLBAR_HELP)}',
			html: 			'{$cms_language->getJsMessage(MESSAGE_WINDOW_HELP)}',
			dismissDelay:	0
	    });
	}
	
	var rootconfig = {$rootnode};
	
	var tree = new Automne.treePanel({
		id:					'treePanel{$winId}',
		title:				{$heading},
		autoScroll:			true,
		animate:			true,
		enableDD:			{$enableDD},
		region:				'center',
		border:				false,
		rootVisible:		false,
		containerScroll:	true,
		loader: 			new Automne.treeLoader({
								dataUrl:		'{$scriptRoot}/tree-nodes.php',
								baseParams:		{
													onClick:		'{$onClick}',
													onSelect:		'{$onSelect}',
													winId:			'{$winId}',
													editable:		'{$editable}',
													pageProperty:	'{$pageProperty}',
													currentPage:	'{$currentPage}',
													root:			'{$rootId}',
													showRoot:		'{$showRoot}',
													maxlevel:		'{$maxlevel}',
													enableDD:		{$enableDD}
												},
								uiProviders:{
									'page': Automne.treeNode
								}
							}),
		root:				new Ext.tree.AsyncTreeNode(rootconfig),
		tbar:				{$tbar}
	});
	
	treeWindow.add(tree);
	
	//redo windows layout
	treeWindow.doLayout();
END;
$view->addJavascript($jscontent);
$view->show();
?>