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
// $Id: patch.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : Patch
  * Allow Automne updates via uploaded archives
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//for this page, HTML output compression is not welcome.
define("ENABLE_HTML_COMPRESSION", false);
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1165);
define("MESSAGE_PAGE_CLEARANCE_ERROR", 65);
define("MESSAGE_PAGE_FIELD_UPDATE", 1166);
define("MESSAGE_PAGE_FIELD_VERBOSE", 1167);
define("MESSAGE_PAGE_FIELD_FORCE", 1168);
define("MESSAGE_PAGE_FIELD_REPORT", 1169);
define("MESSAGE_PAGE_FILE_UPLOAD_TOO_BIG", 1045);
define("MESSAGE_PAGE_CLEAN_TMP_ERROR", 1170);
define("MESSAGE_PAGE_FIELD_COMMAND_LINE", 1171);
define("MESSAGE_PAGE_FIELD_OR", 1098);
define("MESSAGE_PAGE_TREAT_FILE", 1172);
define("MESSAGE_PAGE_TREAT_COMMAND", 1173);
define("MESSAGE_PAGE_FILE_ERROR", 839);
define("MESSAGE_PAGE_BEWARE_PATCH", 1175);
define("MESSAGE_PAGE_FIELD_CLICK_TO_FINALIZE", 1176);
define("MESSAGE_PAGE_END_OF_INSTALL", 1177);
define("MESSAGE_PAGE_DONT_FINALIZE_IF_ERRORS", 1178);
define("MESSAGE_PAGE_FIELD_CONFIRM", 1179);
define("MESSAGE_PAGE_FIELD_CLICK_TO_CORRECT", 1184);
define("MESSAGE_PAGE_RESUME_PATCH", 1192);

//checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

// +----------------------------------------------------------------------+
// | VARS                                                                 |
// +----------------------------------------------------------------------+

$cms_action = ($_GET["cms_action"]) ? $_GET["cms_action"]:$_POST["cms_action"];
$verbose = ($_GET["verbose"]) ? $_GET["verbose"]:$_POST["verbose"];
$force = ($_GET["force"]) ? $_GET["force"]:$_POST["force"];
$report = ($_GET["report"]) ? $_GET["report"]:$_POST["report"];

// +----------------------------------------------------------------------+
// | ACTIONS                                                              |
// +----------------------------------------------------------------------+

switch ($cms_action) {
	case"validate":
		//file upload management
		if ($_FILES["file"]["name"]) {
			// Check file size and server max uploading file size
			if ($_FILES['file']['error']==1 || $_FILES["file"]["size"] > (ini_get("post_max_size")*1048576)) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_UPLOAD_TOO_BIG, array(ini_get("post_max_size")))."\n";
				break;
			}
			//clean tmp directory
			if (!CMS_file::deltree(PATH_TMP_FS)) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_CLEAN_TMP_ERROR,array(PATH_TMP_FS))."\n";
				break;
			}
			
			if (!$_FILES['file']['error'] && $_FILES["file"]["name"]) {
				$path = PATH_TMP_FS;
				$filename = SensitiveIO::sanitizeAsciiString($_FILES["file"]["name"]);
				if (!move_uploaded_file($_FILES["file"]["tmp_name"], $path."/".$filename)) {
					$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
					$filename = '';
				} else {
					@chmod ($path."/".$filename, octdec(FILES_CHMOD));
				}
			} else {
				$filename = '';
			}
		} elseif($_POST["commandLine"]) {
			$commandLine = explode("\n",str_replace("  ","\t",$_POST["commandLine"]));
		} else {
			$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_UPDATE)));
			$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
					array($cms_language->getMessage(MESSAGE_PAGE_FIELD_COMMAND_LINE)));
		}
	break;
}

// +----------------------------------------------------------------------+
// | DEFAULT SCREEN                                                       |
// +----------------------------------------------------------------------+

if ($cms_message || (!$filename && !$commandLine && !$cms_action)) {
	//file upload form
	$dialog = new CMS_dialog();
	$content = '';
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
	$dialog->setBackLink("meta_admin.php");
	if ($cms_message) {
		$dialog->setActionMessage($cms_message);
	}
	$content .= '
		<br />
		<table border="0" cellpadding="3" cellspacing="2">
		<form method="post" action="'.$_SERVER["SCRIPT_NAME"].'" enctype="multipart/form-data">
		<input type="hidden" name="cms_action" value="validate" />
		<tr>
			<td class="admin" align="right"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_UPDATE).'</td>
			<td class="admin"><input type="file" name="file" class="admin_input_text" /> (max : '.ini_get('post_max_size').'o)</td>
		</tr>
		<tr>
			<td class="admin" align="right" valign="top"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OR).' '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COMMAND_LINE).'</td>
			<td class="admin"><textarea cols="65" rows="8" class="admin_textarea" name="commandLine"></textarea></td>
		</tr>
		<tr>
			<td class="admin" align="right">&nbsp;</td>
			<td class="admin">
				<label for="verbose"><input id="verbose" type="checkbox" name="verbose" value="1" checked="checked" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_VERBOSE).'</label><br />
				<label for="report"><input id="report" type="checkbox" name="report" value="1" checked="checked" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_REPORT).'</label><br />
				<label for="force"><input id="force" type="checkbox" name="force" value="1" /> '.$cms_language->getMessage(MESSAGE_PAGE_FIELD_FORCE).'</label>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="admin">'.$cms_language->getMessage(MESSAGE_PAGE_BEWARE_PATCH).'<br /><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_BUTTON_VALIDATE).'" /></td>
		</tr>
		</form>
		</table>
		<br />
		'.$cms_language->getMessage(MESSAGE_FORM_MANDATORY_FIELDS).'
	';
	
	$dialog->setContent($content);
	$dialog->show();
	
} else {
	// +----------------------------------------------------------------------+
	// | PATCH MANAGEMENT                                                     |
	// +----------------------------------------------------------------------+
	$reporting='';
	//verbose fonction, only send a message to user.
	function verbose($text) {
		global $verbose;
		if ($verbose) {
			CMS_LoadingDialog::sendToUser($text."<br />");
		}
	}
	//report fonction, send a message to user and can stop process if it's an error.
	function report($text,$isErrror=false) {
		global $report,$force,$reporting,$verbose,$cms_language;
		if ($report && !$verbose) {
			$reporting .= ($isErrror) ? '<span class="admin_text_alert">'.$text.'</span><br />':'<strong>'.$text.'</strong><br />';
		} elseif($verbose) {
			$text = ($isErrror) ? '<span class="admin_text_alert">'.$text.'</span>':'<strong>'.$text.'</strong>';
			verbose($text);
		}
		if ($isErrror && !$force) {
			$send = $reporting.'<br />
			======'.$cms_language->getMessage(MESSAGE_PAGE_END_OF_INSTALL).'======';
			CMS_LoadingDialog::sendAndClose($send);
		}
	}
	
	$dialog = new CMS_dialog();
	$content = '';
	$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
	if ($filename) {
		$content .= $cms_language->getMessage(MESSAGE_PAGE_TREAT_FILE).' : '.$filename.'<br /><br />';
	} elseif($cms_action=='errorsCorrected') {
		$content .= $cms_language->getMessage(MESSAGE_PAGE_RESUME_PATCH).' :<br /><br />';
	} elseif($commandLine) {
		$dialog->setBackLink("patch.php");
		$content .= $cms_language->getMessage(MESSAGE_PAGE_TREAT_COMMAND).' :<br />'.implode("<br />",$commandLine);
	}
	$dialog->setContent($content);
	//launch dialog in loading mode
	$dialog->show("loading");
	
	if ($filename || $cms_action=='errorsCorrected') {
		// +----------------------------------------------------------------------+
		// | PATCH FILE TREATMENT                                                 |
		// +----------------------------------------------------------------------+
		
		//if it's a patch resume, no need to re-decompress the file
		if ($cms_action!='errorsCorrected') {
			//patch uncompress
			report('Uncompressing patch in progress...');
			$archive = new CMS_gzip_file(PATH_TMP_FS."/".$filename);
			
			if (!$archive->hasError()) {
				$archive->set_options(array('basedir'=>PATH_TMP_FS."/", 'overwrite'=>1, 'level'=>1, 'dontUseFilePerms'=>1, 'forceWriting'=>1));
				if (is_dir(PATH_TMP_FS))  {
					if (method_exists($archive, 'extract_files') && $archive->extract_files()) {
						verbose('-> Extract '.$filename.' to '.PATH_TMP_FS);
					}
				} else {
					report('Error : Extraction directory does not exist',true);
				}
			} else {
				report('Error : Unable to extract archive wanted '.$filename.'. It is not a valid format...',true);
			}
			
			if (!$archive->hasError()) {
				verbose('-> Extraction successfull');
			} else {
				report('Extraction error...',true);
			}
			unset($archive);
		}
		//Check files content
		report('Start patching process...');
		$automnePatch = new CMS_patch($cms_user);
		
		//read patch param file and check versions
		verbose('Read patch file...');
		$patchFile = new CMS_file(PATH_TMP_FS."/patch");
		
		if ($patchFile->exists()) {
			$patch = $patchFile->readContent("array");
		} else {
			report('Error : File '.PATH_TMP_FS.'/patch does not exists ...',true);
		}
		if (!$automnePatch->checkPatch($patch)) {
			report('Error : Patch does not match current version ...',true);
		} else {
			verbose('-> Patch version match.');
		}
		
		//read install param file and do maximum check on it before starting the installation process
		verbose('Read install file...');
		$installFile = new CMS_file(PATH_TMP_FS."/install");
		if ($installFile->exists()) {
			$install = $installFile->readContent("array");
		} else {
			report('Error : File '.PATH_TMP_FS.'/install does not exists ...',true);
		}
		$installError = $automnePatch->checkInstall($install,$errorsInfos);
		if ($installError) {
			report('Error : Invalid install file :');
			$stopProcess = ($automnePatch->canCorrectErrors($errorsInfos)) ? false:true;
			report($installError,$stopProcess);
			if (!$force) {
				//if process continue, then we can correct patch errors.
				//save errors infos
				$_SESSION["cms_context"]->setSessionVar('patchErrors',$errorsInfos);
				//go to errors correction page
				$send = $reporting.'
				<table border="0" cellpadding="3" cellspacing="2">
				<form method="post" action="patch_error_correction.php">
				<input type="hidden" name="verbose" value="'.$verbose.'" />
				<input type="hidden" name="force" value="'.$force.'" />
				<input type="hidden" name="report" value="'.$report.'" />
				<tr>
					<td><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CLICK_TO_CORRECT).'" /></td>
				</tr>
				</form>
				</table>';
				
				CMS_LoadingDialog::sendAndClose($send);
			}
		} else {
			verbose('-> Install file is correct.');
		}
		
		//start Installation process
		report('Start applying patch file...');
		$installError = $automnePatch->doInstall($install);
		if ($installError) {
			report('Error during installation process :');
			report($installError,true);
		} else {
			report('-> Patch installation done without error.');
		}
		
		//remove temporary files
		report('Start cleaning temporary files...');
		if (!CMS_file::deltree(PATH_TMP_FS)) {
			report('Error during temporary folder cleaning...');
		} else {
			verbose('-> Cleaning done without error.');
		}
		
		//confirm patch finalisation
		/*$send = $reporting.'
		<table border="0" cellpadding="3" cellspacing="2">
		<form method="post" action="'.$_SERVER["SCRIPT_NAME"].'" onSubmit="return confirm(\''.addslashes($cms_language->getMessage(MESSAGE_PAGE_FIELD_CONFIRM)) . '\')">
		<input type="hidden" name="cms_action" value="finalize" />
		<input type="hidden" name="verbose" value="'.$verbose.'" />
		<input type="hidden" name="force" value="'.$force.'" />
		<input type="hidden" name="report" value="'.$report.'" />
		<tr>
			<td class="admin"><strong>'.$cms_language->getMessage(MESSAGE_PAGE_DONT_FINALIZE_IF_ERRORS).'</strong></td>
		</tr>
		<tr>
			<td><input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_CLICK_TO_FINALIZE).'" /></td>
		</tr>
		</form>
		</table><br /><br />';*/
		
		CMS_LoadingDialog::sendAndClose($send);
		
	} elseif($commandLine) {
		// +----------------------------------------------------------------------+
		// | PATCH COMMAND LINE TREATMENT                                         |
		// +----------------------------------------------------------------------+
		
		report('Start command process...');
		$automnePatch = new CMS_patch($cms_user);
		
		//read command lines and do maximum check on it before starting the installation process
		$installError = $automnePatch->checkInstall($commandLine,$errorsInfos);
		if ($installError) {
			report('Error : Invalid command :');
			report($installError,true);
		} else {
			verbose('-> Commands are correct.');
		}
		
		//start command process
		report('Start applying commands...');
		$automnePatch->doInstall($commandLine,array('ex'));
		
		verbose('-> Command lines execution done.');
		
		$send = $reporting.'<br />
		======'.$cms_language->getMessage(MESSAGE_PAGE_END_OF_INSTALL).'======';
		CMS_LoadingDialog::sendAndClose($send);
		
	} elseif($cms_action=='finalize') {
		// +----------------------------------------------------------------------+
		// | PATCH FINALIZE TREATMENT                                             |
		// +----------------------------------------------------------------------+
		
		//apply chmod script to Automne
		report('Start chmod script...');
		$force=true;
		if (CMS_patch::automneGeneralChmodScript()) {
			report('-> Chmod script done without error.');
		} else {
			report('Error during Chmod script execution...');
		}
		
		$send = $reporting.'<br />
		======'.$cms_language->getMessage(MESSAGE_PAGE_END_OF_INSTALL).'======';
		CMS_LoadingDialog::sendAndClose($send);
	}
}
?>