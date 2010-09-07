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
// $Id: patch.php,v 1.5 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : Patch
  * Allow Automne updates via uploaded archives
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_NO_SERVER_RIGHTS",748);
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
define("MESSAGE_PAGE_RESUME_PATCH", 1192);

//CHECKS user has admin clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no administration rights');
	echo $cms_language->getMessage(MESSAGE_PAGE_NO_SERVER_RIGHTS);
	exit;
}

//ignore user abort to avoid interuption of process
@ignore_user_abort(true);
@set_time_limit(9000);

//Controler vars
$filename = sensitiveIO::request('filename');
$force = sensitiveIO::request('force');
$cms_action = sensitiveIO::request('cms_action');

$cms_message = '';
$content = '';

// +----------------------------------------------------------------------+
// | PATCH MANAGEMENT                                                     |
// +----------------------------------------------------------------------+
//verbose fonction, only send a message to user.
function verbose($text) {
	global $content;
	$content .= $text."<br />";
}
//report fonction, send a message to user and can stop process if it's an error.
function report($text,$isErrror=false) {
	global $report,$force,$cms_language,$content;
	$text = ($isErrror) ? '<span class="atm-red">'.$text.'</span>':'<strong>'.$text.'</strong>';
	verbose($text);
	if ($isErrror && !$force) {
		$send = '<br />
		======'.$cms_language->getMessage(MESSAGE_PAGE_END_OF_INSTALL).'======';
		$content .= $send;
		echo $content;
		exit;
	}
}

if ($filename) {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_TREAT_FILE).' : '.$filename.'<br /><br />';
} elseif($cms_action=='errorsCorrected') {
	$content .= $cms_language->getMessage(MESSAGE_PAGE_RESUME_PATCH).' :<br /><br />';
}

if ($filename || $cms_action=='errorsCorrected') {
	// +----------------------------------------------------------------------+
	// | PATCH FILE TREATMENT                                                 |
	// +----------------------------------------------------------------------+
	$send = '';
	//if it's a patch resume, no need to re-decompress the file
	if ($cms_action!='errorsCorrected') {
		//patch uncompress
		report('Uncompressing patch in progress...');
		$archive = new CMS_gzip_file(PATH_REALROOT_FS.$filename);
		
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
	
	//read patch or export param file and check versions
	verbose('Read working file...');
	$patchFile = new CMS_file(PATH_TMP_FS."/patch");
	$exportFile = new CMS_file(PATH_TMP_FS."/export.xml");
	
	if ($patchFile->exists()) {
		$patch = $patchFile->readContent("array");
	
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
				$send = '
				<div id="correctUpdateErrors"></div>
				<script type="text/javascript">
					Ext.getCmp(\'serverWindow\').correctUpdateErrors();
				</script>';
				$content .= $send;
				echo $content;
				exit;
			}
		} else {
			verbose('-> Install file is correct.');
		}
		
		//start Installation process
		report('Start applying patch file...');
		$automnePatch->doInstall($install);
		$installError = false;
		$return = $automnePatch->getReturn();
		foreach ($return as $line) {
			switch($line['type']) {
				case 'verbose':
					verbose($line['text']);
				break;
				case 'report':
					switch ($line['error']) {
						case 0:
							report($line['text'],false);
						break;
						case 1:
							report($line['text'],true);
							$installError = true;
						break;
					}
				break;
			}
		}
		
		if ($installError) {
			report('Error during installation process :');
			report($installError,true);
		} else {
			report('-> Patch installation done without error.');
		}
	} elseif ($exportFile->exists()) {
		//Module datas to import
		$importDatas = $exportFile->getContent();
		if (!$importDatas) {
			report('Error: no content to import or invalid content...',true);
		}
		$import = new CMS_module_import();
		if (!$import->import($importDatas, 'xml', $cms_language, $importLog)) {
			report('Error during datas importation...');
		}
		if (isset($importLog) && $importLog) {
			verbose('Import log: ');
			verbose($importLog);
		}
	} else {
		report('Error : File '.PATH_TMP_FS.'/patch does not exists ...',true);
	}
	//remove temporary files
	report('Start cleaning temporary files...');
	if (!CMS_file::deltree(PATH_TMP_FS)) {
		report('Error during temporary folder cleaning...');
	} else {
		verbose('-> Cleaning done without error.');
	}
	$content .= $send;
	echo $content;
	exit;
}
?>