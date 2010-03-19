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
// $Id: patch_error_correction.php,v 1.2 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : Patch error correction
  * Correct errors found in patch
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1165);
define("MESSAGE_PAGE_ERROR_CANT_CORRECT", 1185);
define("MESSAGE_PAGE_NEXT_ERROR", 1186);
define("MESSAGE_PAGE_RETURN_TO_PATCH", 1187);
define("MESSAGE_PAGE_ORIGINAL_PROTECTED_FILE", 1188);
define("MESSAGE_PAGE_PATCH_FILE", 1189);
define("MESSAGE_PAGE_PASTE_NEW_PATCH_FILE", 1190);
define("MESSAGE_PAGE_ERROR_5_LABEL", 1191);
define("MESSAGE_PAGE_CORRECTION_DONE", 1610);

if (!$_SESSION["cms_context"]->getSessionVar('patchErrors')) {
	die('Missing parameter...');
	exit;
}

switch ($_POST["cms_action"]) {
	case "validate":
		$errorCorrected = false;
		//correct first error of the array
		$errors = $_SESSION["cms_context"]->getSessionVar('patchErrors');
		$error = $errors[0];
		
		switch ($error['no']) {
			case 5 : //try to update a protected file (UPDATE.DENY)
				if ($_POST["updated_file"]) {
					$installParams = array_map("trim",explode("\t",$error['command']));
					$updatedFile = new CMS_file(PATH_TMP_FS.$installParams[1]);
					$updatedFile->setContent(trim($_POST["updated_file"]));
					//add a flag file to mark file is updated
					$flagFile = new CMS_file(PATH_TMP_FS.$installParams[1].'.updated');
					$flagFile->setContent('ok');
					if ($updatedFile->writeToPersistence() && $flagFile->writeToPersistence()) {
						$errorCorrected = true;
					}
				} else {
					$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
				}
			break;
			default:
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ERROR_CANT_CORRECT);
			break;
		}
		if ($errorCorrected && !$cms_message) {
			unset($errors[0]);
			
		}
		if (!sizeof($errors)) {
			$dialog = new CMS_dialog();
			$content = $cms_language->getMessage(MESSAGE_PAGE_CORRECTION_DONE);
			$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));
			$dialog->setContent($content);
			$dialog->show();
			exit;
		} else {
			$updateErrors = array();
			foreach ($errors as $anError) {
				$updateErrors[] = $anError;
			}
			$_SESSION["cms_context"]->setSessionVar('patchErrors',$updateErrors);
		}
	break;
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE));

//correct first error of the array
$errors = $_SESSION["cms_context"]->getSessionVar('patchErrors');
$error = $errors[0];

//button message
$validate_msg = (!is_array($errors[1])) ? MESSAGE_PAGE_RETURN_TO_PATCH : MESSAGE_PAGE_NEXT_ERROR;

switch ($error['no']) {
	case 5 : //try to update a protected file (UPDATE.DENY)
		$content .= $cms_language->getMessage(MESSAGE_PAGE_ERROR_5_LABEL).'<br /><br />';
		$installParams = array_map("trim",explode("\t",$error['command']));
		//get files
		$file = $installParams[1];
		$content .= '
		'.$cms_language->getMessage(MESSAGE_PAGE_ORIGINAL_PROTECTED_FILE).' :
		<div class="cms_code">
			'.(file_exists(PATH_REALROOT_FS.$file) ? highlight_file(PATH_REALROOT_FS.$file,true) : '').'
		</div>
		'.$cms_language->getMessage(MESSAGE_PAGE_PATCH_FILE).' :
		<div class="cms_code">
			'.(file_exists(PATH_TMP_FS.$file) ? highlight_file(PATH_TMP_FS.$file,true) : '').'
		</div>
		<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
		<span class="admin_text_alert">*</span> '.$cms_language->getMessage(MESSAGE_PAGE_PASTE_NEW_PATCH_FILE).' :<br />
		<input type="hidden" name="cms_action" value="validate" />
		<textarea class="admin_textarea" name="updated_file" rows="30" style="width:95%"></textarea><br />
		<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage($validate_msg).'" />
		</form>
		';
	break;
	default:
		$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ERROR_CANT_CORRECT);
	break;
}

if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
$dialog->setContent($content);
$dialog->show();
?>