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
  * PHP page : module export
  * Used to export a module definition
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Antoine Cézar <antoine.cezar@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define('MESSAGE_PAGE_ERROR_MODULE_RIGHTS', 65);
define('MESSAGE_PAGE_ERROR_UNKNOWN_MODULE', 809);
define('MESSAGE_PAGE_MODULE_EXPORT_TITLE', 1632);
define('MESSAGE_PAGE_MODULE_NO_EXPORT', 1633);
define('MESSAGE_PAGE_EXPORT_FORMAT', 1634);
define('MESSAGE_PAGE_EXPORT_PATCH_FORMAT', 1635);
define('MESSAGE_PAGE_EXPORT_XML_FORMAT', 1636);
define('MESSAGE_PAGE_EXPORT_PHP_FORMAT', 1637);
define('MESSAGE_PAGE_EXPORT_OPTIONS', 1638);
define('MESSAGE_PAGE_EXPORT_MODULE', 1639);
define('MESSAGE_PAGE_EXPORTED_DATAS', 1640);
define('MESSAGE_PAGE_FILE_ERROR', 1641);
define('MESSAGE_PAGE_ARCHIVE_ERROR', 1642);
define('MESSAGE_PAGE_UNKNOWN_FORMAT', 1643);

//Create page object
$dialog = new CMS_dialog();

//checks rights
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	$dialog->setContent($cms_language->getMessage(MESSAGE_PAGE_ERROR_MODULE_RIGHTS));
	$dialog->show();
	exit;
}
$moduleCodename = io::request('moduleCodename');
if (!$moduleCodename) {
	$dialog->setContent($cms_language->getMessage(MESSAGE_PAGE_ERROR_UNKNOWN_MODULE));
	$dialog->show();
	exit;
}
$module = CMS_modulesCatalog::getByCodename($moduleCodename);
if (!is_object($module) || $module->hasError()) {
	$dialog->setContent($cms_language->getMessage(MESSAGE_PAGE_ERROR_UNKNOWN_MODULE));
	$dialog->show();
	exit;
}

$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_MODULE_EXPORT_TITLE, array($module->getLabel($cms_language))));
$dialog->setBackLink('modules_admin.php?moduleCodename='.$moduleCodename);

$export = new CMS_module_export($moduleCodename);
if (!$export->hasExport()) {
	$dialog->setContent($cms_language->getMessage(MESSAGE_PAGE_MODULE_NO_EXPORT));
	$dialog->show();
	exit;
}

$format = io::post('format', array('xml', 'php', 'patch'), 'patch');
$options = io::post('options', 'is_array', (!io::post('action') ? $export->getDefaultParameters() : array()));

$content = '<form action="'.$_SERVER['SCRIPT_NAME'].'#exportDatas" method="post">
				<input type="hidden" name="moduleCodename" value="'.$moduleCodename.'" />
				<input type="hidden" name="action" value="export" />
				<fieldset>
					<legend>'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_FORMAT).'</legend>
					<label>
						<input type="radio" name="format" value="patch"'.($format == 'patch' ? ' checked="checked"' : '').' />
						'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_PATCH_FORMAT).'
					</label>
					<label>
						<input type="radio" name="format" value="xml"'.($format == 'xml' ? ' checked="checked"' : '').' />
						'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_XML_FORMAT).'
					</label>
					<label>
						<input type="radio" name="format" value="php"'.($format == 'php' ? ' checked="checked"' : '').' />
						'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_PHP_FORMAT).'
					</label>
				</fieldset>
				<fieldset>
					<legend>'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_OPTIONS).'</legend>';
					$exportParams = $export->getAvailableParameters($cms_language);
					foreach ($exportParams as $param => $label) {
						$content .= '<label>
							<input type="checkbox" name="options[]" value="'.$param.'"'.(in_array($param, $options) ? ' checked="checked"' : '').' />
							'.$label.'
						</label><br />';
					}
$content .= '	</fieldset>
				<fieldset>
					<legend>Inclure une description</legend>
					<textarea style="width:100%;height:150px;" name="desc">'.io::htmlspecialchars(io::post('desc')).'</textarea>
				</fieldset><br /><br />
				<input type="submit" class="admin_input_submit" value="'.$cms_language->getMessage(MESSAGE_PAGE_EXPORT_MODULE).'" />
			</form>';

switch (io::post('action')) {
	case 'export':
		if (io::post('desc')) {
			$options['description'] = io::post('desc');
		}
		//set export parameters
		$export->setParameters($options);
		//export datas
		$exportDatas = $export->export($format);
		
		switch ($format) {
			case 'php':
				$content .= '
				<br /><a name="exportDatas"></a>
				<fieldset>
					<legend>'.$cms_language->getMessage(MESSAGE_PAGE_EXPORTED_DATAS).'</legend>
					<textarea style="width:100%;height:300px;">'.htmlspecialchars(var_export($exportDatas, true)).'</textarea>
				</fielset>';
			break;
			case 'xml':
				$content .= '
				<br /><a name="exportDatas"></a>
				<fieldset>
					<legend>'.$cms_language->getMessage(MESSAGE_PAGE_EXPORTED_DATAS).'</legend>
					<textarea style="width:100%;height:300px;">'.htmlspecialchars($exportDatas).'</textarea>
				</fielset>';
			break;
			case 'patch':
				//check archive
				if (file_exists($exportDatas)) {
					//send to browser
					CMS_file::downloadFile($exportDatas, false, true, 'application/x-compressed');
					$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_FILE_ERROR)."\n";
				} else {
					$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_ARCHIVE_ERROR)."\n";
				}
			break;
			default:
				$cms_message .= $cms_language->getMessage(MESSAGE_PAGE_UNKNOWN_FORMAT)."\n";
			break;
		}
	break;
}
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}
//draw content
$dialog->setContent($content);
$dialog->show();
?>
