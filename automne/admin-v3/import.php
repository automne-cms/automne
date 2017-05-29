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
// | Author: Antoine Cézar <antoine.cezar@ws-interactive.fr>    		  |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: module.php,v 1.3 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : module import
  * Used to import a module definition
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Antoine Cézar <antoine.cezar@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define('MESSAGE_PAGE_MODULE_IMPORT_TITLE', 1644);
define('MESSAGE_PAGE_MODULE_IMPORT_PATCH', 1645);
define('MESSAGE_PAGE_MODULE_IMPORT_DATAS', 1646);
define('MESSAGE_PAGE_MODULE_TECH_NOTES', 1647);
define('MESSAGE_PAGE_MODULE_TECH_NOTES_DESC', 1648);
define('MESSAGE_PAGE_MODULE_IMPORT', 1649);
define('MESSAGE_PAGE_ERROR_FILE_UPLOAD', 1650);
define('MESSAGE_PAGE_ERROR_FILE_EXTRACT', 1651);
define('MESSAGE_PAGE_ERROR_FILE_DIR', 1652);
define('MESSAGE_PAGE_MODULE_EXTRACT_DONE', 1653);
define('MESSAGE_PAGE_MODULE_EXTRACT_ERROR', 1654);
define('MESSAGE_PAGE_MODULE_NO_EXPORT', 1655);
define('MESSAGE_PAGE_MODULE_ERROR_NO_IMPORT_DATA', 1656);
define('MESSAGE_PAGE_MODULE_IMPORT_ERROR', 1657);
define('MESSAGE_PAGE_MODULE_IMPORT_DONE', 1658);
define('MESSAGE_PAGE_MODULE_ERROR_CLEANING_DIR', 1659);
define('MESSAGE_PAGE_MODULE_IMPORT_LOG', 1660);
define('MESSAGE_PAGE_ERROR_MODULE_RIGHTS', 65);
define('MESSAGE_PAGE_EXPORT_XML_FORMAT', 1636);
define('MESSAGE_PAGE_EXPORT_PHP_FORMAT', 1637);
define('MESSAGE_PAGE_EXPORT_OPTIONS', 1638);

//Create page object
$dialog = new CMS_dialog();

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	$dialog->setContent($cms_language->getMessage(MESSAGE_PAGE_ERROR_MODULE_RIGHTS));
	$dialog->show();
	exit;
}

$import = new CMS_module_import();

$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_MODULE_IMPORT_TITLE));

$format = io::post('format', '', 'xml');
$options = io::post('options', 'is_array', (!io::post('action') ? $import->getDefaultParameters() : array()));

$dialog->setBackLink('modules_admin.php');
$content = '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data">
				<input type="hidden" name="action" value="import" />
				<fieldset>
					<legend>'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_OPTIONS).'</legend>';
					$importParams = $import->getAvailableParameters($cms_language);
					foreach ($importParams as $param => $label) {
						$content .= '<label>
							<input type="checkbox" name="options[]" value="'.$param.'"'.(in_array($param, $options) ? ' checked="checked"' : '').' />
							'.$label.'
						</label><br />';
					}
$content .= '	</fieldset><br />
				<fieldset>
					<legend>'.$cms_language->getMessage(MESSAGE_PAGE_MODULE_IMPORT_PATCH).'</legend>
					<input type="file" name="file" />
				</fieldset><br />
				<fieldset>
					<legend>'.$cms_language->getMessage(MESSAGE_PAGE_MODULE_IMPORT_DATAS).'</legend>
					Format : 
					<label>
						<input type="radio" name="format" value="xml"'.($format == 'xml' ? ' checked="checked"' : '').' />
						'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_XML_FORMAT).'
					</label>
					<label>
						<input type="radio" name="format" value="php"'.($format == 'php' ? ' checked="checked"' : '').' />
						'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_PHP_FORMAT).'
					</label><br /><br />
					<fieldset>
						<legend>'.$cms_language->getMessage(MESSAGE_PAGE_MODULE_TECH_NOTES).'</legend>
						'.$cms_language->getMessage(MESSAGE_PAGE_MODULE_TECH_NOTES_DESC, array(PATH_TMP_WR, PATH_TMP_WR)).'
					</fieldset><br />
					<textarea style="width:100%;height:300px;" name="import">'.io::htmlspecialchars(io::post('import')).'</textarea><br /><br />
				</fieldset>
				<br />
				<br />
				<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_MODULE_IMPORT).'" />
			</form>';
$cms_message = '';
switch (io::post('action')) {
	case 'import':
		//set import options
		$import->setParameters($options);
		
		if (isset($_FILES['file']['error']) && $_FILES['file']['tmp_name'] && $_FILES['file']['error'] != UPLOAD_ERR_OK) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ERROR_FILE_UPLOAD)."\n";
			break;
		}
		if (isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name'] && file_exists($_FILES['file']['tmp_name'])) {
			$fileDatas = CMS_file::uploadFile('file', PATH_TMP_FS);
			if ($fileDatas['error']) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ERROR_FILE_UPLOAD)."\n";
				break;
			}
			$filename = $fileDatas['filename'];
			$archive = new CMS_gzip_file(PATH_TMP_FS.'/'.$filename);
			if (!$archive->hasError()) {
				$archive->set_options(array('basedir'=>PATH_TMP_FS."/", 'overwrite'=>1, 'level'=>1, 'dontUseFilePerms'=>1, 'forceWriting'=>1));
				if (is_dir(PATH_TMP_FS) && is_writable(PATH_TMP_FS))  {
					if (!method_exists($archive, 'extract_files') || !$archive->extract_files()) {
						$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ERROR_FILE_EXTRACT, array($filename))."\n";
					}
				} else {
					$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ERROR_FILE_DIR, array(PATH_TMP_FS))."\n";
					break;
				}
			} else {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ERROR_FILE_EXTRACT, array($filename))."\n";
				break;
			}
			if (!$archive->hasError()) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_MODULE_EXTRACT_DONE)."\n";
			} else {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_MODULE_EXTRACT_ERROR)."\n";
				break;
			}
			unset($archive);
			
			$file = new CMS_file(PATH_TMP_FS.'/export.xml');
			if (!$file->exists()) {
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_MODULE_NO_EXPORT)."\n";
				break;
			}
			$importDatas = $file->getContent();
			$format = 'xml';
		} elseif (io::post('import')) {
			$importDatas = io::post('import');
			if ($format == 'php') {
				//try to eval PHP Array
				try {
					$importDatas = eval('return '.$importDatas.';');
				} catch (Exception $e) {}
			}
		} else {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_MODULE_ERROR_NO_IMPORT_DATA)."\n";
			break;
		}
		if (!$importDatas) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_MODULE_ERROR_NO_IMPORT_DATA)."\n";
			break;
		}
		//import datas
		if (!$import->import($importDatas, $format, $cms_language, $importLog)) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_MODULE_IMPORT_ERROR)."\n";
		} else {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_MODULE_IMPORT_DONE)."\n";
		}
		
		if (!CMS_file::deltree(PATH_TMP_FS)) {
			$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_MODULE_ERROR_CLEANING_DIR)."\n";
		}
		break;
}
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
if (isset($importLog) && $importLog) {
	$content = '
	<fieldset>
		<legend>'.$cms_language->getMessage(MESSAGE_PAGE_MODULE_IMPORT_LOG).'</legend>
		'.nl2br($importLog).'
	</fieldset><br />
	'.$content;
}
//draw content
$dialog->setContent($content);
$dialog->show();
?>
