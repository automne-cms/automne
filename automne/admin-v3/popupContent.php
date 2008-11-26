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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: popupContent.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP popup page : draw popup content
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_ACTION_EDIT", 87);
define("MESSAGE_PAGE_ACTION_BASEDATA", 88);
define("MESSAGE_PAGE_ACTION_CONTENT", 89);
define("MESSAGE_PAGE_ACTION_CREATE", 90);
define("MESSAGE_PAGE_ACTION_SIBLING", 91);
define("MESSAGE_PAGE_ACTION_DISPLACE", 92);
define("MESSAGE_PAGE_ACTION_DISPLACE_TITLE", 100);
define("MESSAGE_PAGE_ACTION_DISPLACE_HEADING", 101);
define("MESSAGE_PAGE_ACTION_DELETE", 84);
define("MESSAGE_PAGE_ACTION_DELETECONFIRM", 118);
define("MESSAGE_PAGE_ACTION_ARCHIVE", 83);
define("MESSAGE_PAGE_ACTION_ARCHIVECONFIRM", 119);
define("MESSAGE_PAGE_ACTION_UNDELETE", 85);
define("MESSAGE_PAGE_ACTION_UNDELETECONFIRM", 97);
define("MESSAGE_PAGE_ACTION_UNARCHIVE", 86);
define("MESSAGE_PAGE_ACTION_UNARCHIVECONFIRM", 98);
define("MESSAGE_PAGE_ACTION_CANCEL_EDITIONS", 857);
define("MESSAGE_PAGE_ACTION_CANCEL_EDITIONS_CONFIRM", 858);
define("MESSAGE_PAGE_ACTION_OTHER", 81);
define("MESSAGE_PAGE_ACTION_COPY", 1046);
define("MESSAGE_PAGE_ACTION_ROW_CONTENT", 1130);
define("MESSAGE_PAGE_ACTION_VIEW", 78);
define("MESSAGE_PAGE_ACTION_PREVIEW", 79);
define("MESSAGE_PAGE_ACTION_UNLOCK", 82);
define("MESSAGE_PAGE_ACTION_ADMIN", 1316);
define("MESSAGE_POPUP_ACTION_CLOSE", 1315);
define("MESSAGE_POPUP_ACTION_MINIMIZE", 1314);
define("MESSAGE_POPUP_ACTION_MAXIMIZE", 1313);
define('MESSAGE_POPUP_LOADING', 1321);

define("MESSAGE_PAGE_ACTION_VIEW", 78);
define("MESSAGE_PAGE_ACTION_PREVIEW", 79);
define("MESSAGE_PAGE_ACTION_FORM", 179);
define("MESSAGE_PAGE_ACTION_TEMPLATE", 72);
define("MESSAGE_PAGE_ACTION_ACTIONS", 181);
define("MESSAGE_PAGE_CANCEL_CONFIRM", 284);
define("MESSAGE_BUTTON_SAVE", 952);
define("MESSAGE_PAGE_ACTION_CONTENT", 89);
define("MESSAGE_PAGE_ACTION_ROW_CONTENT", 1130);
define("MESSAGE_PAGE_ACTION_SWITCH_ROW_CONTENT", 1322);
define("MESSAGE_PAGE_BUTTON_TEMPLATE", 187);
define("MESSAGE_PAGE_BUTTON_SUBMIT_FOR_VALIDATION", 1422);
define("MESSAGE_PAGE_BUTTON_SAVE_AS_DRAFT", 1423);
define("MESSAGE_BUTTON_CANCEL_DRAFT", 1424);
define("MESSAGE_PAGE_CANCEL_DRAFT_CONFIRM", 1425);

/**
  * Draw a popup content for a given page
  *
  * @param CMS_page or CMS_pageTemplate $object : the page or template to draw popup content
  * @param constant $visualizationMode : The current visualization mode (see constants on top of cms_page class for accepted values).
  * @return string : the popup content
  * @access public
  */
function drawPopupContent(&$object, $visualizationMode = PAGE_VISUALMODE_HTML_PUBLIC) {
	global $cms_user, $cms_language, $cms_context;
	
	if (is_a($object, 'CMS_page')) {
		$page = &$object;
		$status = $page->getStatus();
		$statusHTML = $status->getHTML(false);
	} elseif (is_a($object, 'CMS_pageTemplate')) {
		$template = &$object;
		$statusHTML = '&nbsp;';
	}
	//Popup header
	$content ='
	<table id="CMS_editPopupHead">
		<tr>
			<td>'.$statusHTML.'</td>
			<td width="16"><img id="CMS_editPopupLoad" src="'.PATH_ADMIN_IMAGES_WR.'/popup_loading.gif" alt="'.$cms_language->getMessage(MESSAGE_POPUP_LOADING).'" title="'.$cms_language->getMessage(MESSAGE_POPUP_LOADING).'" /></td>
			<td width="16">
				<img onclick="CMS_minimizePopup();" id="CMS_imgMinimizePopup" src="'.PATH_ADMIN_IMAGES_WR.'/popup_minimize.gif" alt="'.$cms_language->getMessage(MESSAGE_POPUP_ACTION_MINIMIZE).'" title="'.$cms_language->getMessage(MESSAGE_POPUP_ACTION_MINIMIZE).'" />
				<img onclick="CMS_maximizePopup();" id="CMS_imgMaximizePopup" src="'.PATH_ADMIN_IMAGES_WR.'/popup_maximize.gif" alt="'.$cms_language->getMessage(MESSAGE_POPUP_ACTION_MAXIMIZE).'" title="'.$cms_language->getMessage(MESSAGE_POPUP_ACTION_MAXIMIZE).'" />
			</td>
			<td width="16"><img onclick="CMS_closePopup();" id="CMS_imgClosePopup" src="'.PATH_ADMIN_IMAGES_WR.'/popup_close.gif" alt="'.$cms_language->getMessage(MESSAGE_POPUP_ACTION_CLOSE).'" title="'.$cms_language->getMessage(MESSAGE_POPUP_ACTION_CLOSE).'" /></td>
		</tr>
	</table>';
	
	//Popup content
	switch($visualizationMode) {
		case PAGE_VISUALMODE_FORM :
		case PAGE_VISUALMODE_HTML_EDITION :
			$actions = new CMS_subMenus();
			//actions
			$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_ACTIONS),
												$cms_language->getMessage(MESSAGE_PAGE_BUTTON_SUBMIT_FOR_VALIDATION),
												PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR,
												'save_to_publication.gif');
			$one_action->addHidden("cms_action", "validate");
			$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_ACTIONS),
												$cms_language->getMessage(MESSAGE_PAGE_BUTTON_SAVE_AS_DRAFT),
												PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR,
												'draft_save.gif');
			$one_action->addHidden("cms_action", "savedraft");
			
			if ($_GET['use_mode'] == 'creation' && $page->getPublication() == RESOURCE_PUBLICATION_NEVERVALIDATED) {
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_ACTIONS),
													$cms_language->getMessage(MESSAGE_PAGE_BUTTON_TEMPLATE),
													PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=page_template.php",
													'annuler_modifs.gif');
			} else {
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_ACTIONS),
													$cms_language->getMessage(MESSAGE_BUTTON_CANCEL_DRAFT),
													PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR,
													'annuler_modifs.gif');
				$one_action->addHidden("cms_action", "cancel");
				$one_action->addAttribute("onSubmit", "return confirm('".str_replace("'", "\'", $cms_language->getMessage(MESSAGE_PAGE_CANCEL_DRAFT_CONFIRM))."');");
			}
			if ($visualizationMode != PAGE_VISUALMODE_HTML_EDITION) {
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEW),
													$cms_language->getMessage(MESSAGE_PAGE_ACTION_SWITCH_ROW_CONTENT),
													"#",
													'editer_modele.gif');
				$one_action->addAttribute("onSubmit", "switchView();return false;");
				
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEW),
													$cms_language->getMessage(MESSAGE_PAGE_ACTION_PREVIEW),
													PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR,
													'previz.gif');
				$one_action->addHidden("cms_visualmode", PAGE_VISUALMODE_HTML_EDITION);
			}
			if ($visualizationMode != PAGE_VISUALMODE_FORM) {
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEW),
													$cms_language->getMessage(MESSAGE_PAGE_ACTION_FORM),
													PATH_ADMIN_SPECIAL_PAGE_CONTENT_WR,
													'modifier.gif');
				$one_action->addHidden("cms_visualmode", PAGE_VISUALMODE_FORM);
			}
			
			$content .= $actions->getDHTMLMenu(true);
		break;
		case PAGE_VISUALMODE_CLIENTSPACES_FORM:
			$actions = new CMS_subMenus();
			$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_ACTIONS),
												$cms_language->getMessage(MESSAGE_BUTTON_SAVE),
												PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode("templates.php?template=".$template->getID()."&cms_action=validate_clientspace_edition"),
												'sauvegarder.gif');
			$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_ACTIONS),
												$cms_language->getMessage(MESSAGE_BUTTON_CANCEL),
												PATH_ADMIN_SPECIAL_FRAMES_WR."?redir=".urlencode("templates.php?template=".$template->getID()."&cms_action=cancel_clientspace_edition"),
												'annuler_modifs.gif');
			$content .= $actions->getDHTMLMenu(true);
		break;
		case PAGE_VISUALMODE_HTML_PUBLIC:
		default:
			//clean redir session value if any
			$cms_context->setSessionVar("redir",'');
			
			$actions = new CMS_subMenus();
			$grand_root = CMS_tree::getRoot();
			if ($cms_user->hasPageClearance($page->getID(), CLEARANCE_PAGE_EDIT)) {
				if ($lock = $page->getLock()) {
					//actions are impossible, but lock can be eventually removed if its the user who placed the lock
					if ($cms_user->getUserID() == $lock || $cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
						$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
								$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNLOCK),
								'',
								'verrou.gif');
						$one_action->addAttribute("onSubmit", 'sendServerCall(\''.PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR.'?cms_action=popupPageUnlock&page='.$page->getID().'\',\'CMS_drawPopupContent\',true);return false;');
					}
				} else {
					//actions are possible
					if ($page->getProposedLocation() == RESOURCE_LOCATION_DELETED) {
						//there's only one action : undo the page deletion proposal.
						$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
								$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNDELETE),
								'',
								'annul_delete.gif');
						$one_action->addAttribute("onSubmit", 'if (confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_UNDELETECONFIRM, array($page->getTitle()))) . '\')) {sendServerCall(\''.PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR.'?cms_action=pageUndel&page='.$page->getID().'\',\'CMS_drawPopupContent\',true);}return false;');
					} elseif ($page->getProposedLocation() == RESOURCE_LOCATION_ARCHIVED) {	
						//there's only one action : undo the page archiving proposal.
						$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
								$cms_language->getMessage(MESSAGE_PAGE_ACTION_UNARCHIVE),
								'',
								'annul_archiver.gif');
						$one_action->addAttribute("onSubmit", 'if (confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_UNARCHIVECONFIRM, array($page->getTitle()))) . '\')) {sendServerCall(\''.PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR.'?cms_action=pageUndel&page='.$page->getID().'\',\'CMS_drawPopupContent\',true);}return false;');
					} else {
						//page administration
						$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT),
								$cms_language->getMessage(MESSAGE_PAGE_ACTION_ADMIN),
								PATH_ADMIN_SPECIAL_FRAMES_WR,
								'edit_basedata.gif');
						$one_action->addAttribute("method", "get");
						$one_action->addHidden("redir", urlencode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.'?page='.$page->getID()));
						
						//module specific actions (only for standard module)
						$modules = $page->getModules();
						if ($modules) {
							foreach ($modules as $module) {
								if ($cms_user->hasModuleClearance($module->getCodename(), CLEARANCE_MODULE_EDIT)) {
									if ($module->getCodename() == MOD_STANDARD_CODENAME) {
										$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT),
												$cms_language->getMessage(MESSAGE_PAGE_ACTION_CONTENT),
												PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
												'modifier.gif');
										$one_action->addHidden("cms_action", "prepare_content_edition");
										$one_action->addHidden("page", $page->getID());
										$one_action->addHidden("redir[location]", $page->getURL());
										$one_action->addHidden("redir[outframe]", 1);
										
										$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_EDIT),
												$cms_language->getMessage(MESSAGE_PAGE_ACTION_ROW_CONTENT),
												PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR,
												'editer_modele.gif');
										$one_action->addHidden("cms_action", "prepare_row_edition");
										$one_action->addHidden("page", $page->getID());
										$one_action->addHidden("redir[location]", $page->getURL());
										$one_action->addHidden("redir[outframe]", 1);
									}
								}
							}
						}
						//page editions cancelling
						$editions = $status->getEditions();
						if ($page->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED && 
							($editions & RESOURCE_EDITION_CONTENT)) {
							$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_OTHER),
									$cms_language->getMessage(MESSAGE_PAGE_ACTION_CANCEL_EDITIONS),
									'',
									'annuler_modifs.gif');
							$one_action->addAttribute("onSubmit", 'if (confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_ACTION_CANCEL_EDITIONS_CONFIRM, array($page->getTitle()))) . '\')) {sendServerCall(\''.PATH_ADMIN_SPECIAL_SERVER_RESPONSE_WR.'?cms_action=pageCancelEditions&page='.$page->getID().'\',\'CMS_drawPopupContent\',true);}return false;');
						}
					}
				}
			}
			//preview
			$editions = $status->getEditions();
			if ($cms_user->hasPageClearance($page->getID(), CLEARANCE_PAGE_EDIT) && $editions) {
				$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_VIEW),
													$cms_language->getMessage(MESSAGE_PAGE_ACTION_PREVIEW),
													PATH_ADMIN_SPECIAL_PAGEPREVIZ_WR,
													'previz.gif');
				$one_action->addAttribute("target", "_blank");
				$one_action->addAttribute("method", "get");
				$one_action->addHidden("page", $page->getID());
			}
			$content .= $actions->getDHTMLMenu(true);
		break;
	}
	return $content;
}
?>