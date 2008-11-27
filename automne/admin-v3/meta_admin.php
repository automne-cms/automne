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
// $Id: meta_admin.php,v 1.2 2008/11/27 17:25:37 sebastien Exp $

/**
  * PHP page : logs by user
  * Used to view the log for one user
  *
  * @package CMS
  * @subpackage admin
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 903);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_ACTION_REGENERATE", 900);
define("MESSAGE_PAGE_ACTION_REGENALL", 901);
define("MESSAGE_PAGE_ACTION_REGENONE_BYTREE", 902);
define("MESSAGE_PAGE_ACTION_REGENONE_TITLE", 942);
define("MESSAGE_PAGE_ACTION_REGENONE_HEADING", 943);
define("MESSAGE_PAGE_ACTION_REGENERATION", 944);
define("MESSAGE_PAGE_ACTION_REMAININGPAGES", 945);
define("MESSAGE_PAGE_ACTION_RESTART", 946);
define("MESSAGE_PAGE_ACTION_PAGES_LEFT", 947);
define("MESSAGE_PAGE_ACTION_SCRIPTS_LEFT_NONE", 10);
define("MESSAGE_PAGE_ACTION_DUPLICATE_TITLE", 982);//Duplications
define("MESSAGE_PAGE_ACTION_DUPLICATE_BRANCH", 983);//Une branche
define("MESSAGE_PAGE_ACTION_CLEAR_TABLE", 1060);
define("MESSAGE_PAGE_ACTION_REGENONE_BYID", 1061);
define("MESSAGE_PAGE_SCRIPT_TITLE", 132);
define("MESSAGE_PAGE_SCRIPT_LAUNCH_ON", 1062);
define("MESSAGE_PAGE_SCRIPT_PIDFILE", 1063);
define("MESSAGE_PAGE_PIDFILE_PRESENT", 1064);
define("MESSAGE_PAGE_PIDFILE_ABSENT", 1065);
define("MESSAGE_PAGE_PAGES_INPROGRESS", 1066);
define("MESSAGE_PAGE_SCRIPTS_INPROGRESS", 1067);
define("MESSAGE_PAGE_WEBSITES", 812);
define("MESSAGE_PAGE_WEBSITES_VIEW", 938);
define("MESSAGE_PAGE_WEBSITES_NEW", 262);
define("MESSAGE_PAGE_WEBSITES_TREE_TITLE", 822);
define("MESSAGE_PAGE_WEBSITES_TREE_HEADING", 823);
define("MESSAGE_PAGE_PARAMETERS", 807);
define("MESSAGE_PAGE_DATABASE", 1112);
define("MESSAGE_PAGE_UPDATE", 1174);
define("MESSAGE_PAGE_FILE_ACCESSES_RIGHTS", 1298);
define("MESSAGE_PAGE_ACTION_REFRESH_PAGE", 1330);
define("MESSAGE_PAGE_ACTION_STOP_SCRIPTS", 1331);
define("MESSAGE_PAGE_WYSIWYG", 1399);
define("MESSAGE_PAGE_ACTION_REGENTREE_BYTREE", 1432);
define("MESSAGE_PAGE_ACTION_REGENTREE_HEADING", 1434);
define("MESSAGE_PAGE_ACTION_REGENTREE_TITLE", 1433);

//checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES)) {
    header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
    exit;
}

//get all running scripts
$runningScripts = processManager::getRunningScript();
$scriptsLeft = CMS_scriptsManager::getScriptsNumberLeft();

switch ($_REQUEST["cms_action"]) {
case "regenerate_all":
    //give it more time
    @set_time_limit(1000);
    
    CMS_tree::regenerateAllPages(true);
    $cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
    break;
case "regeneration_viewpages":
    //get the pages
    $scripts = CMS_scriptsManager::getScriptsLeft();
    if (is_array($scripts) && sizeof($scripts)) {
		$additional_content2 = '<ol>';
		foreach ($scripts as $script) {
            $additional_content2 .= '<li>'.$script.'</li>';
        }
		$additional_content2 .= '</ol>';
    } else {
        $additional_content2 .= $cms_language->getMessage(MESSAGE_PAGE_ACTION_SCRIPTS_LEFT_NONE);
    }
    $additional_content = "<br />".$cms_language->getMessage(MESSAGE_PAGE_ACTION_PAGES_LEFT) . " :<br /><br />";
    $additional_content .= $additional_content2;
    break;
case "regeneration_restart":
    CMS_scriptsManager::startScript(true);
    $cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
    break;
case "clear_table":
    CMS_scriptsManager::clearScripts();
    if (!USE_BACKGROUND_REGENERATOR) {
        //clear regeneration popup infos
        $_SESSION["cms_context"]->setSessionVar('scriptpopup_TotalScripts','');
        $_SESSION["cms_context"]->setSessionVar('start_script',false);
        $_SESSION["cms_context"]->setSessionVar('scriptpopup_is_open',false);
        $_SESSION["cms_context"]->setSessionVar('scriptpopup_opening_try',0);
    }
    $cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
    break;
case "stop_regen":
     CMS_scriptsManager::clearScripts();
    if (!USE_BACKGROUND_REGENERATOR) {
        //clear regeneration popup infos
        $_SESSION["cms_context"]->setSessionVar('scriptpopup_TotalScripts','');
        $_SESSION["cms_context"]->setSessionVar('start_script',false);
        $_SESSION["cms_context"]->setSessionVar('scriptpopup_is_open',false);
        $_SESSION["cms_context"]->setSessionVar('scriptpopup_opening_try',0);
    }
    CMS_scriptsManager::startScript(true);
    $cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
    break;
case "regenerate_one":
	$pages = array();
	$tmpPages = preg_split('#[ ;,]#', $_GET["action_page"]);
	foreach ($tmpPages as $p) {
		$p=trim($p);
		if (SensitiveIO::isPositiveInteger($p)) {
			$pages[] = $p;		
		} elseif (ereg ("[0-9]+\-[0-9]+", $p)) { //TODOV4
			$subPages = split('-', $p);
			sort($subPages);
			for ($idp = $subPages[0]; $idp <= $subPages[1]; $idp++) {
				$pages[] = $idp;
			}
		}
	}
	$pages = array_unique($pages);
	sort($pages);
	if (sizeof($pages)) {
		$validPages = CMS_tree::pagesExistsInUserSpace($pages);
		if (sizeof($validPages)) {
			if (sizeof($validPages) > 3) {
				//submit pages to regenerator
				CMS_tree::submitToRegenerator($validPages, true);
			} else {
				//regenerate pages
				@set_time_limit(1000);
				foreach ($validPages as $pageID) {
					$pg = CMS_tree::getPageByID($pageID);
					if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
					    $pg->regenerate(true);
					}
				}
			}
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		}
	}
	break;
	case "regenerate_tree":
	if (sensitiveIO::isPositiveInteger($_GET["action_page"])) {
		$pages = CMS_tree::getAllSiblings($_GET["action_page"], true);
		if (sizeof($pages) > 3) {
			//submit pages to regenerator
			CMS_tree::submitToRegenerator($pages, true);
		} else {
			//regenerate pages
			@set_time_limit(1000);
			foreach ($pages as $pageID) {
				$pg = CMS_tree::getPageByID($pageID);
				if (is_a($pg, 'CMS_page') && !$pg->hasError()) {
				    $pg->regenerate(true);
				}
			}
		}
		$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
	}
	break;
}

$grand_root = CMS_tree::getRoot();

$actions = new CMS_actions();

//ACTIONS : page regenerations ***********************
if (!sizeof($scripts) && $_REQUEST["cms_action"] != "regenerate_all") {
    //all pages
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATE),
                                        $cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENALL),
                                        $_SERVER["SCRIPT_NAME"]);
    $one_action->addHidden("cms_action", "regenerate_all");
}
//tree by tree
$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATE),
                                    $cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENTREE_BYTREE),
                                    PATH_ADMIN_SPECIAL_TREE_WR);
$one_action->addAttribute("method", "get");
$one_action->addHidden("root", $grand_root->getID());
$one_action->addHidden("encodedPageLink", base64_encode($_SERVER["SCRIPT_NAME"].chr(167).chr(167).'cms_action=regenerate_tree'.chr(167).'action_page=%s'));
$one_action->addHidden("backLink", $_SERVER["SCRIPT_NAME"]);
$one_action->addHidden("title", $cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENTREE_TITLE));
$one_action->addHidden("heading", $cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENTREE_HEADING));
//one page by tree
$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATE),
                                    $cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENONE_BYTREE),
                                    PATH_ADMIN_SPECIAL_TREE_WR);
$one_action->addAttribute("method", "get");
$one_action->addHidden("root", $grand_root->getID());
$one_action->addHidden("encodedPageLink", base64_encode($_SERVER["SCRIPT_NAME"].chr(167).chr(167).'cms_action=regenerate_one'.chr(167).'action_page=%s'));
$one_action->addHidden("backLink", $_SERVER["SCRIPT_NAME"]);
$one_action->addHidden("title", $cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENONE_TITLE));
$one_action->addHidden("heading", $cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENONE_HEADING));

//one page by ID
$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATE),
                                    $cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENONE_BYID),
                                    $_SERVER["SCRIPT_NAME"]);
$one_action->addAttribute("method", "get");
$one_action->addHidden("cms_action", "regenerate_one");
$one_action->addText("action_page",$_GET["action_page"],'15','%s<br />');

//ACTIONS : 'regenerator' script-related ***********************
if ($scriptsLeft || sizeof($runningScripts) || strpos($_REQUEST["cms_action"], 'regen') !== false) {
    //remaining pages
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATION),
                                         $cms_language->getMessage(MESSAGE_PAGE_ACTION_REFRESH_PAGE),
                                        $_SERVER["SCRIPT_NAME"]);
}
if (sizeof($runningScripts)) {
    //stop script
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATION),
                                         $cms_language->getMessage(MESSAGE_PAGE_ACTION_STOP_SCRIPTS),
                                        $_SERVER["SCRIPT_NAME"]);
    $one_action->addHidden("cms_action", "stop_regen");
}
//restart
if (USE_BACKGROUND_REGENERATOR) {
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATION),
                                        $cms_language->getMessage(MESSAGE_PAGE_ACTION_RESTART),
                                        $_SERVER["SCRIPT_NAME"]);
    $one_action->addHidden("cms_action", "regeneration_restart");
}
if ($scriptsLeft) {
    //remaining pages
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATION),
                                        $cms_language->getMessage(MESSAGE_PAGE_ACTION_REMAININGPAGES),
                                        $_SERVER["SCRIPT_NAME"]);
    $one_action->addHidden("cms_action", "regeneration_viewpages");
}
//empty table
$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_REGENERATION),
                                    $cms_language->getMessage(MESSAGE_PAGE_ACTION_CLEAR_TABLE),
                                    $_SERVER["SCRIPT_NAME"]);
$one_action->addHidden("cms_action", "clear_table");

if ($cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
    //ACTIONS : tree manipulation ***********************
    //Duplicate a branch
    /*$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_ACTION_DUPLICATE_TITLE),
                                        $cms_language->getMessage(MESSAGE_PAGE_ACTION_DUPLICATE_BRANCH),
                                        'tree_duplicate_branch.php');
    $one_action->addAttribute("method", "get");
    $one_action->addHidden("cms_action", "tree_duplication_start_page");
    
    //WEBSITES ADMINISTRATION
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_PARAMETERS),
                                        $cms_language->getMessage(MESSAGE_PAGE_WEBSITES),
                                        'websites.php');
    
     //WYSIWYG ADMINISTRATION
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_PARAMETERS),
                                        $cms_language->getMessage(MESSAGE_PAGE_WYSIWYG),
                                        'wysiwyg.php');
    
    //AUTOMNE PARAMETERS
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_PARAMETERS),
                                        'Automne',
                                        'module_parameters.php');
    $one_action->addHidden("module", "standard");
    $one_action->addAttribute("method", "get");
    
    //phpMyAdmin
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_PARAMETERS),
                                        $cms_language->getMessage(MESSAGE_PAGE_DATABASE),
                                        PATH_PHPMYADMIN_WR);
    $one_action->addAttribute("target", "_blank");
    
    //Patch
    $one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_PARAMETERS),
                                        $cms_language->getMessage(MESSAGE_PAGE_UPDATE),
                                        'patch.php');
	*/
	//Accesses rights to the files
    /*$one_action =& $actions->addAction($cms_language->getMessage(MESSAGE_PAGE_PARAMETERS),
                                        $cms_language->getMessage(MESSAGE_PAGE_FILE_ACCESSES_RIGHTS),
                                        'patch.php');
	$one_action->addHidden("cms_action", "validate");
	$one_action->addHidden("verbose", "1");
	$one_action->addHidden("report", "1");
	$one_action->addHidden("force", "1");
	$one_action->addHidden("commandLine", "rc");*/
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE),'pic_meta.gif');
if ($cms_message) {
    $dialog->setActionMessage($cms_message);
}

//by user
$content .= $actions->getContent();

if (is_array($runningScripts) && sizeof($runningScripts)) {
    $content .= '<br /><dialog-title type="admin_h3">'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPTS_INPROGRESS).' :</dialog-title>
                <table border="0" cellpadding="3" cellspacing="2">
                <tr>
                    <th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPT_PIDFILE).'</th>
                       <th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPT_TITLE).'</th>
                    <th class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_SCRIPT_LAUNCH_ON).'</th>
                </tr>';
    $count = 0;
    foreach ($runningScripts as $runningScript) {
        $count++;
        $td_class = ($count % 2 == 0) ? "admin_lightgreybg" : "admin_darkgreybg";
        $date= new CMS_date();
        $date->setFromDBValue($runningScript["Date"]);
        
        switch ($runningScript["PIDFile"]) {
            case '0':
                $PID='<img src="img/status/tiny/rond-r.gif" alt="Aucun fichier PID trouvé" title="Aucun fichier PID trouvé" border="0" />';
            break;
            case '1':
                $PID='<img src="img/status/tiny/carre_pub-v.gif" alt="Fichier PID trouvé" title="Fichier PID trouvé" border="0" />';
            break;
            case '2':
                $PID='<img src="img/status/tiny/carre_sup-v.gif" alt="Fichier PID trouvé sans référence en Base de données" title="Fichier PID trouvé sans référence en Base de données" border="0" />';
            break;
            case '3':
                $PID='<img src="img/status/tiny/carre_sup-o.gif" alt="Fichier PID trouvé et script marqué comme terminé" title="Fichier PID trouvé et script marqué comme terminé" border="0" />';
            break;
        }
        
        $content .= '
             <tr>
                <td align="center" class="'.$td_class.'">'.$PID.'</td>
                   <td class="'.$td_class.'">'.$runningScript["Title"].'</td>
                <td class="'.$td_class.'">'.$date->getLocalizedDate($cms_language->getDateFormat()." H:i:s").'</td>
            </tr>
         ';
    }
    $content .= '</table>';
}

if ($scriptsLeft > 0) {
    $content .= '<br /><dialog-title type="admin_h3">'.$cms_language->getMessage(MESSAGE_PAGE_PAGES_INPROGRESS).' : ' . $scriptsLeft . '</dialog-title>';
}

//add additional content (pages lefts)
if (isset($additional_content)) {
    $content .= $additional_content;
}

$dialog->setContent($content);
$dialog->show();
?>