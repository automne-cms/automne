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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: csv.php,v 1.4 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : module cms_forms frontend
  * Export form datas to CSV file
  *
  * @package Automne
  * @subpackage cms_forms
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//CHECKS
$cms_module = CMS_modulesCatalog::getByCodename(MOD_CMS_FORMS_CODENAME);

if (!$cms_user->hasModuleClearance(MOD_CMS_FORMS_CODENAME, CLEARANCE_MODULE_EDIT)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_name());
	exit;
}
if (!$_GET["form"] || !sensitiveIO::isPositiveInteger($_GET["form"])) {
	CMS_grandFather::raiseError("Formular export : Missing form ID parameter");
	exit;
}

$replace = array(
	'"' 	=> '""',
	'\r\n' 	=> '\n',
);
function cleanvalue($value) {
	global $replace;
	return str_replace(array_keys($replace), $replace, $value);
}

$form = new CMS_forms_formular($_GET["form"]);

//get array of form datas
$formDatas = $form->getAllRecordDatas(false, ($_GET["withDate"] ? true : false));

//create array of fields names (for CSV header)
$fields = $form->getFields(true);
$fileFields = array();
if (sizeof($fields)) {
	if ($_GET["withDate"]) {
		$header[0] = '"Date"';
	}
	foreach ($fields as $field) {
		if ($field->getAttribute('type') != 'submit') { //remove submit field
			$header[$field->getID()] = '"' . cleanvalue($field->getAttribute('label')) . '"';
		}
		//check for file field in form
		if ($field->getAttribute('type') == 'file') {
			$fileFields[$field->getID()] = true;
		}
	}
}
//prepare files path if needed
if (sizeof($fileFields)) {
	$filesPath = CMS_websitesCatalog::getMainURL().PATH_MODULES_FILES_WR.'/'.MOD_CMS_FORMS_CODENAME.'/';
}
//then create CVS file

//CSV header
$csv = implode(';', $header)."\n";

//CSV content
if (sizeof($formDatas)) {
	foreach ($formDatas as $formData) {
		$count = 0;
		foreach ($header as $fieldID => $head) {
			$csv .= ($count) ? ';' : '';
			if (!$fileFields[$fieldID]) {
				$csv .= '"' . cleanvalue($formData[$fieldID]) . '"';
			} else {
				if ($formData[$fieldID]) {
					$csv .= '"' . $filesPath.cleanvalue($formData[$fieldID]) . '"';
				} else {
					$csv .= '""';
				}
			}
			$count++;
		}
		$csv .= "\n";
	}
}

//Then send CSV file
header("Cache-Control: public"); //This is needed to avoid bug with IE in HTTPS
header("Pragma:"); //This is needed to avoid bug with IE in HTTPS
header('Content-type: text/csv; charset='.APPLICATION_DEFAULT_ENCODING);
header("Content-Disposition: attachment; filename=export_".sensitiveIO::sanitizeAsciiString($form->getAttribute('name'))."_".date('Ymd').".csv");
echo $csv;
?>