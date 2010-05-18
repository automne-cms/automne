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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: module.php,v 1.3 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : module admin
  * Used to manage a module
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//CHECKS
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	Header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_CLEARANCE_INSUFFICIENT."&".session_name()."=".session_id());
	exit;
}
if ($_POST["moduleCodename"]) {
	$moduleCodename = $_POST["moduleCodename"];
	$module = CMS_modulesCatalog::getByCodename($moduleCodename);
}

//Messages
define("MESSAGE_PAGE_TITLE_EDIT", 1304);
define("MESSAGE_PAGE_TITLE_CREATE", 1305);
define("MESSAGE_PAGE_FIELD_LABEL", 814);
define("MESSAGE_PAGE_ACTION_EDIT", 261);
define("MESSAGE_PAGE_FIELD_CODENAME", 1306);
define("MESSAGE_PAGE_FIELD_CODENAME_ALPHANUM", 1307);
define("MESSAGE_FORM_ERROR_CODENAME_USED", 1308);
define("MESSAGE_FORM_ERROR_DIRECTORY_CREATION", 1309);
define("MESSAGE_PAGE_FIELD_PROTECT_FILES", 1354);
define("MESSAGE_PAGE_FIELD_PROTECT_FILES_EXPLANATION", 1355);

switch ($_POST["cms_action"]) {
	case 'validate':
		if (is_object($module)) {
			//checks
			$languages = CMS_languagesCatalog::getAllLanguages();
			foreach ($languages as $aLanguage) {
				if (!$_POST['label'.$aLanguage->getCode()]) {
					$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
						array($aLanguage->getLabel()));
				}
			}
			if (!$cms_message) {
				//update module label
				//this is a direct sql query cause no writing interface exists now for messages table
				foreach ($languages as $aLanguage) {
					$sql = "
						update
							messages
						set
							message_mes = '".SensitiveIO::sanitizeSQLString($_POST['label'.$aLanguage->getCode()])."'
						where
							id_mes = '".SensitiveIO::sanitizeSQLString($module->getLabelID())."'
							and module_mes = '".SensitiveIO::sanitizeSQLString($moduleCodename)."'
							and language_mes = '".SensitiveIO::sanitizeSQLString($aLanguage->getCode())."'
					";
					$q = new CMS_query($sql);
				}
				//create/delete all needed .htaccess files
				if (isset($_POST['hasprotect']) && $_POST['protect'] == 1) {
					//archived
					if (is_dir(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/archived')) {
						CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_file', PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/archived/.htaccess');
						CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/archived/.htaccess');
					}
					//edited
					if (is_dir(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edited')) {
						CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_file', PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edited/.htaccess');
						CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edited/.htaccess');
					}
					//edition
					if (is_dir(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edition')) {
						CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_file', PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edition/.htaccess');
						CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edition/.htaccess');
					}
					//public
					if (is_dir(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/public')) {
						CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_file', PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/public/.htaccess');
						CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/public/.htaccess');
					}
				} elseif (isset($_POST['hasprotect'])) {
					//archived
					if (file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/archived/.htaccess')) {
						CMS_file::deleteFile(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/archived/.htaccess');
					}
					//edited
					if (file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edited/.htaccess')) {
						CMS_file::deleteFile(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edited/.htaccess');
					}
					//edition
					if (file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edition/.htaccess')) {
						CMS_file::deleteFile(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edition/.htaccess');
					}
					//public
					if (file_exists(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/public/.htaccess')) {
						CMS_file::deleteFile(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/public/.htaccess');
					}
				}
				//set htaccess in deleted directory
				if (is_dir(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/deleted')) {
					CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_no', PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/deleted/.htaccess');
					CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/deleted/.htaccess');
				}
				header("Location: modules_admin.php?moduleCodename=".$moduleCodename."&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
				exit;
			}
		} else {
			//checks
			if (!$_POST["codename"] || $_POST["codename"] != sensitiveIO::sanitizeAsciiString($_POST["codename"])) {
				$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_CODENAME)));
			} else {
				//check for codename not already used
				$modules = CMS_modulesCatalog::getAll("label", false);
				foreach ($modules as $aModule) {
					if ($aModule->getCodename() == $_POST["codename"]) {
						$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_CODENAME_USED);
					}
				}
			}
			$languages = CMS_languagesCatalog::getAllLanguages();
			foreach ($languages as $aLanguage) {
				if (!$_POST['label'.$aLanguage->getCode()]) {
					$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD, 
						array($aLanguage->getLabel()));
				}
			}
			
			if (!$cms_message) {
				//create the new module
				$moduleCodename = $_POST["codename"];
				$module = new CMS_module();
				$module->setCodename($moduleCodename);
				$module->setLabel(1);
				$module->setPolymod(true);
				$module->setAdminFrontend('index.php');
				$module->writeToPersistence();
				//create module label
				//this is a direct sql query cause no writing interface exists now for messages table
				
				$count = 0;
				foreach ($languages as $aLanguage) {
					$sql = "
						insert into 
							messages
						set
							id_mes = '1',
							module_mes = '".SensitiveIO::sanitizeSQLString($moduleCodename)."',
							language_mes = '".SensitiveIO::sanitizeSQLString($aLanguage->getCode())."',
							message_mes = '".SensitiveIO::sanitizeSQLString($_POST['label'.$aLanguage->getCode()])."'
					";
					$q = new CMS_query($sql);
				}
				//create module files directories
				$moduledir = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename, CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
				$moduleDeleted = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/deleted', CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
				$moduleEdited = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edited', CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
				$modulePublic = new CMS_file(PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/public', CMS_file::FILE_SYSTEM, CMS_file::TYPE_DIRECTORY);
				if ($moduledir->writeToPersistence()
					&& $moduleDeleted->writeToPersistence()
					&& $moduleEdited->writeToPersistence()
					&& $modulePublic->writeToPersistence()) {
					//create all needed .htaccess files
					if (isset($_POST['hasprotect']) && $_POST['protect'] == 1) {
						CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_file', PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edited/.htaccess');
						CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/edited/.htaccess');
						CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_file', PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/public/.htaccess');
						CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/public/.htaccess');
					}
					CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_no', PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/deleted/.htaccess');
					CMS_file::chmodFile(FILES_CHMOD, PATH_MODULES_FILES_FS.'/'.$moduleCodename.'/deleted/.htaccess');
					
					header("Location: modules_admin.php?moduleCodename=".$moduleCodename."&cms_message_id=".MESSAGE_ACTION_OPERATION_DONE."&".session_name()."=".session_id());
					exit;
				} else {
					$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_DIRECTORY_CREATION, array($moduledir->getName(), $moduleDeleted->getName(), $moduleEdited->getName(), $modulePublic->getName()));
				}
			}
		}
	break;
}

//page dialog
$dialog = new CMS_dialog();
if (is_object($module)) {
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_EDIT, array($module->getLabel($cms_language))));
	$dialog->setBackLink('modules_admin.php?moduleCodename='.$moduleCodename);
} else {
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_CREATE));
	$dialog->setBackLink('modules_admin.php');
}
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}

$content ='
<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
<input type="hidden" name="cms_action" value="validate" />
<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
<table border="0" cellpadding="2" cellspacing="2">
<tr>
	<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_LABEL).'</td>
	<td>
		<table border="0" cellpadding="3" cellspacing="0" style="border-left:1px solid #4d4d4d;">
';
if (is_object($module)) {
	$moduleLabel = $module->getLabelID();
}
$languages = CMS_languagesCatalog::getAllLanguages();
foreach ($languages as $aLanguage) {
	if (is_object($module)) {
		$label = $aLanguage->getMessage($moduleLabel, false, $module->getCodename());
	} else {
		$label = $_POST['label'.$aLanguage->getCode()];
	}
	$content .= '
	<tr>
		<td class="admin"><span class="admin_text_alert">*</span> '.$aLanguage->getLabel().'</td>
		<td class="admin"><input type="text" size="30" class="admin_input_text" value="'.htmlspecialchars($label).'" name="label'.$aLanguage->getCode().'" /></td>
	</tr>';
}
$content .= '
		</table>
	</td>
</tr>
';
//codename
if (!is_object($module)) {
	$content .= '
	<tr>
		<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CODENAME).'</td>
		<td class="admin"><input type="text" maxlength="20" size="30" class="admin_input_text" value="'.htmlspecialchars($_POST["codename"]).'" name="codename" /> <small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CODENAME_ALPHANUM).')</small></td>
	</tr>';
} else {
	$content .= '
	<tr>
		<td class="admin" align="right">'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CODENAME).'</td>
		<td class="admin">'.$module->getCodename().'</td>
	</tr>';
}
if (!is_object($module) || is_dir(PATH_MODULES_FILES_FS.'/'.$module->getCodename().'/edited') || is_dir(PATH_MODULES_FILES_FS.'/'.$module->getCodename().'/public')) {
	if (is_object($module) && (file_exists(PATH_MODULES_FILES_FS.'/'.$module->getCodename().'/edited/.htaccess')
		|| file_exists(PATH_MODULES_FILES_FS.'/'.$module->getCodename().'/public/.htaccess'))) {
		$checked = ' checked="checked"';
	} else {
		$checked = '';
	}
	$content .= '
	<tr>
		<td class="admin"><input type="hidden" name="hasprotect" value="1" /></td>
		<td class="admin"><label for="protect"><input id="protect" type="checkbox" name="protect" value="1"'.$checked.' /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PROTECT_FILES).'</label><br /><br /><small>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_PROTECT_FILES_EXPLANATION).'</small></td>
	</tr>';
}

$content .= '
</table>
<br />
<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" />
</form>
<br />
'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
<br /><br />';

$dialog->setContent($content);
$dialog->show();
?>