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
// $Id: items-controler.php,v 1.8 2010/03/08 16:42:07 sebastien Exp $

/**
  * cms_i18n item controler
  * Used accross an Ajax request. Make actions on cms_i18n items
  *
  * @package Automne
  * @subpackage cms_i18n
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

define("MESSAGE_ERROR_MODULE_RIGHTS",570);

//cms_i18n messages
define("MESSAGE_PAGE_ERROR_UPDATE", 27);
define("MESSAGE_PAGE_ERROR_CREATE", 28);
define("MESSAGE_PAGE_ERROR_DELETE", 29);
define("MESSAGE_PAGE_ERROR_KEY_EXISTS", 44);

define("MESSAGE_PAGE_ERROR_SENDING_FILE", 50);
define("MESSAGE_PAGE_ERROR_EMPTY_FILE", 51);
define("MESSAGE_PAGE_ERROR_XML_MALFORMED", 52);
define("MESSAGE_PAGE_ERROR_MESSAGE_MALFORMED", 53);
define("MESSAGE_PAGE_ERROR_SQL_MALFORMED", 54);
define("MESSAGE_PAGE_ERROR_SQL_ERROR", 55);
define("MESSAGE_PAGE_ERROR_PO_MALFORMED", 56);
define("MESSAGE_PAGE_ERROR_METAS_MALFORMED", 57);
define("MESSAGE_PAGE_ERROR_MISSING_METAS", 58);
define("MESSAGE_PAGE_ERROR_EXCEL_MALFORMED", 59);
define("MESSAGE_PAGE_ERROR_IMPORT_ERROR", 60);
define("MESSAGE_PAGE_IMPORT_DONE", 61);



//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//Controler vars
$action = sensitiveIO::request('action', array('update', 'delete', 'import'));
$itemId = sensitiveIO::request('item', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module');
$messages = sensitiveIO::request('messages', 'is_array');
$filename = sensitiveIO::request('filename');
$format = sensitiveIO::request('format', array('xml', 'sql', 'po', 'xls', 'xlsx', 'ods'));

if (!$action) {
	CMS_grandFather::raiseError('Unknown action ... '.$action);
	$view->show();
}
if (!$codename) {
	CMS_grandFather::raiseError('Missing module codename ... ');
	$view->show();
}
//set default content
$content = array('success' => false);

//load module
if ($codename != 'cms_i18n_vars' && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($codename)));
	$view->setContent($content);
	$view->show();
}

$cms_message = '';
switch ($action) {
	case 'update':
		if ($itemId) {
			if (isset($messages['key']) && $messages['key']) {
				//check for key unicity
				$q = new CMS_query("select * from messages where id_mes!='".io::sanitizeSQLString($itemId)."' and module_mes='".io::sanitizeSQLString($codename)."' and language_mes='key' and message_mes='".io::sanitizeSQLString($messages['key'])."'");
				if ($q->getNumRows()) {
					$jscontent = "
					Automne.message.popup({
						msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_KEY_EXISTS, false, MOD_CMS_I18N_CODENAME)}',
						buttons: 			Ext.MessageBox.OK,
						closable: 			false,
						icon: 				Ext.MessageBox.ERROR
					});";
					$view->addJavascript($jscontent);
					$view->setContent($content);
					$view->show();
				}
			}
			
			if (CMS_language::updateMessage($codename, $itemId, $messages)) {
				$content = array('success' => true);
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			} else {
				$jscontent = "
				Automne.message.popup({
					msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_UPDATE, false, MOD_CMS_I18N_CODENAME)}',
					buttons: 			Ext.MessageBox.OK,
					closable: 			false,
					icon: 				Ext.MessageBox.ERROR
				});";
				$view->addJavascript($jscontent);
				$view->setContent($content);
				$view->show();
			}
		} else {
			if (isset($messages['key']) && $messages['key']) {
				//check for key unicity
				$q = new CMS_query("select * from messages where module_mes='".io::sanitizeSQLString($codename)."' and language_mes='key' and message_mes='".io::sanitizeSQLString($messages['key'])."'");
				if ($q->getNumRows()) {
					$jscontent = "
					Automne.message.popup({
						msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_KEY_EXISTS, false, MOD_CMS_I18N_CODENAME)}',
						buttons: 			Ext.MessageBox.OK,
						closable: 			false,
						icon: 				Ext.MessageBox.ERROR
					});";
					$view->addJavascript($jscontent);
					$view->setContent($content);
					$view->show();
				}
			}
			$msgId = CMS_language::createMessage($codename, $messages);
			if (io::isPositiveInteger($msgId)) {
				$content = array('success' => true, 'id' => $msgId);
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
			} else {
				$jscontent = "
				Automne.message.popup({
					msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_CREATE, false, MOD_CMS_I18N_CODENAME)}',
					buttons: 			Ext.MessageBox.OK,
					closable: 			false,
					icon: 				Ext.MessageBox.ERROR
				});";
				$view->addJavascript($jscontent);
				$view->setContent($content);
				$view->show();
			}
		}
	break;
	case 'delete':
		if (CMS_language::deleteMessage($codename, $itemId)) {
			$content = array('success' => true);
			$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
		} else {
			$jscontent = "
			Automne.message.popup({
				msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_DELETE, false, MOD_CMS_I18N_CODENAME)}',
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});";
			$view->addJavascript($jscontent);
			$view->setContent($content);
			$view->show();
		}
	break;
	case 'import':
		if (!$format) {
			CMS_grandFather::raiseError('Missing import format ... ');
			$view->show();
		}
		$importFile = new CMS_file($filename, CMS_file::WEBROOT);
		if (!$importFile->exists()) {
			$jscontent = "
			Automne.message.popup({
				msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_SENDING_FILE, false, MOD_CMS_I18N_CODENAME)}',
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});";
			$view->addJavascript($jscontent);
			$view->setContent($content);
			$view->show();
		}
		$importContent = $importFile->getContent();
		if (!$importContent) {
			$jscontent = "
			Automne.message.popup({
				msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_EMPTY_FILE, false, MOD_CMS_I18N_CODENAME)}',
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});";
			$view->addJavascript($jscontent);
			$view->setContent($content);
			$view->show();
		}
		$cms_import_message = '';
		switch ($format) {
			case 'xml':
				$xml = new CMS_xml2Array($importContent, CMS_xml2Array::XML_ARRAY2XML_FORMAT);
				$importedArray = $xml->getParsedArray();
				if (!is_array($importedArray) || !$importedArray) {
					$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_XML_MALFORMED, false, MOD_CMS_I18N_CODENAME).'<br />';
				}
				if (!$cms_import_message) {
					foreach ($importedArray as $codename => $messages) {
						foreach ($messages as $id => $message) {
							if (!CMS_language::updateMessage($codename, $id, $message)) {
								$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_MESSAGE_MALFORMED, array($codename, $id), MOD_CMS_I18N_CODENAME).'<br />';
							}
						}
					}
				}
			break;
			case 'sql':
				//check SQL Format
				if (!CMS_patch::executeSqlScript($_SERVER["DOCUMENT_ROOT"].'/'.$filename, true)) {
					$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_SQL_MALFORMED, false, MOD_CMS_I18N_CODENAME).'<br />';
				} else {
					if (!CMS_patch::executeSqlScript($_SERVER["DOCUMENT_ROOT"].'/'.$filename)) {
						$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_SQL_ERROR, false, MOD_CMS_I18N_CODENAME).'<br />';
					}
				}
			break;
			case 'po':
				$po = new CMS_PO();
				$po->import_from_file($_SERVER["DOCUMENT_ROOT"].'/'.$filename);
				if (!is_array($po->entries) || !$po->entries) {
					$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_PO_MALFORMED, false, MOD_CMS_I18N_CODENAME).'<br />';
				}
				if (!$cms_import_message) {
					foreach ($po->entries as $entry) {
						if (isset($entry->translations[0])) {
							$metasDatas = $entry->extracted_comments;
							if ($metasDatas) {
								$metas = json_decode($metasDatas, true);
								if ($metas && isset($metas['codename']) && isset($metas['id']) && isset($metas['msglang'])) {
									if (!CMS_language::updateMessage($metas['codename'], $metas['id'], array($metas['msglang'] => $entry->translations[0]))) {
										$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_MESSAGE_MALFORMED, array($metas['codename'], $metas['id']), MOD_CMS_I18N_CODENAME).'<br />';
									}
								} else {
									$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_METAS_MALFORMED, false, MOD_CMS_I18N_CODENAME).'<br />';
								}
							} else {
								$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_MISSING_METAS, false, MOD_CMS_I18N_CODENAME).'<br />';
							}
						}
					}
				}
			break;
			case 'xls':
			case 'xlsx':
				$objPHPExcel = PHPExcel_IOFactory::load($_SERVER["DOCUMENT_ROOT"].'/'.$filename);
				$objPHPExcel->setActiveSheetIndex(0);
				$objWorksheet = $objPHPExcel->getActiveSheet();
				
				$line = 0;
				$columns = array();
				$importedArray = array();
				foreach ($objWorksheet->getRowIterator() as $row) {
					$cellIterator = $row->getCellIterator();
					$message = array();
					$id = '';
					foreach ($cellIterator as $i => $cell) {
						if (!$line) {
							//first line is column titles
							$columns[$i] = $cell->getValue();
						} else {
							if ($columns[$i] == 'id') {
								$id = $cell->getValue();
							} else {
								$message[$columns[$i]] = $cell->getValue();
							}
						}
					}
					if ($id) {
						$importedArray[$id] = $message;
					}
					$line++;
				}
				unset($objWorksheet);
				$objPHPExcel->disconnectWorksheets();
				unset($objPHPExcel);
				
				if (!is_array($importedArray) || !$importedArray) {
					$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_EXCEL_MALFORMED, false, MOD_CMS_I18N_CODENAME).'<br />';
				}
				if (!$cms_import_message) {
					foreach ($importedArray as $id => $message) {
						if (!CMS_language::updateMessage($codename, $id, $message)) {
							$cms_import_message .= $cms_language->getJSMessage(MESSAGE_PAGE_ERROR_MESSAGE_MALFORMED, array($codename, $id), MOD_CMS_I18N_CODENAME).'<br />';
						}
					}
				}
			break;
		}
		if ($cms_import_message) {
			$jscontent = "
			Automne.message.popup({
				msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_ERROR_IMPORT_ERROR, false, MOD_CMS_I18N_CODENAME)}<br />{$cms_import_message}',
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});";
			$view->addJavascript($jscontent);
			$view->setContent($content);
			$view->show();
		}
		$jscontent = "
		Automne.message.popup({
			msg: 				'{$cms_language->getJSMessage(MESSAGE_PAGE_IMPORT_DONE, false, MOD_CMS_I18N_CODENAME)}',
			buttons: 			Ext.MessageBox.OK,
			closable: 			false,
			icon: 				Ext.MessageBox.INFO
		});";
		$view->addJavascript($jscontent);
		$view->setContent($content);
		$view->show();
	break;
}
//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
//beware, here we add content (not set) because object saving can add his content to (uploaded file infos updated)
$view->addContent($content);
$view->show();
?>