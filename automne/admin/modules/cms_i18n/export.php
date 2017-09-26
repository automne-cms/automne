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
  * cms_i18n export controler
  * Used accross an Ajax request. Make export of cms_i18n items
  *
  * @package Automne
  * @subpackage cms_i18n
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

//disactive HTML compression
define("ENABLE_HTML_COMPRESSION", false);

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

define("MESSAGE_ERROR_MODULE_RIGHTS",570);

//cms_i18n messages
define("MESSAGE_PAGE_ERROR_UPDATE", 27);
define("MESSAGE_PAGE_ERROR_CREATE", 28);
define("MESSAGE_PAGE_ERROR_DELETE", 29);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_HTML);

//Controler vars
$action = sensitiveIO::request('action', array('export'));
$itemId = sensitiveIO::request('item', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module');
$messages = sensitiveIO::request('messages', 'is_array');
$format = sensitiveIO::request('format', array('xml', 'sql', 'po', 'xls', 'xlsx', 'ods'));
$language = sensitiveIO::request('language');
$currentsearch = sensitiveIO::request('currentsearch') ? true : false;
//search options
$languages = sensitiveIO::request('languages', 'is_array', array());
$keywords = sensitiveIO::request('items_'.$codename.'_kwrds');
$options = sensitiveIO::request('options', 'is_array', array());
if (io::isPositiveInteger($keywords)) {
	$options['ids'] = array($keywords);
	$keywords = '';
}

$itemsDatas = array();
$itemsDatas['results'] = array();

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
if (!$format) {
	CMS_grandFather::raiseError('Unknown export format ...');
	$view->show();
}
//load module
if ($codename != 'cms_i18n_vars' && !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($codename)));
	$view->show();
}

//get all search datas from requests
$keywords = sensitiveIO::request('items_'.$codename.'_kwrds');
$options = sensitiveIO::request('options', 'is_array', array());

if (io::isPositiveInteger($keywords)) {
	$options['ids'] = array($keywords);
	$keywords = '';
}

//get messages
$resultCount = 0;
$messages = CMS_languagesCatalog::searchMessages($codename, $keywords, $languages, $options, 'asc', 0, 0, $resultCount);

// Vars for lists output purpose and pages display, see further
$itemsDatas['total'] = $resultCount;

//loop on results items to arrange results
foreach($messages as $message) {
	$id = $message['id'];
	unset($message['id']);
	if ($language != 'all' && $format != 'po') { //keep only wanted language (only if po format is not queried)
		if (isset($message[$language])) {
			$itemsDatas['results'][$id][$language] = $message[$language];
		}
	} else {
		$itemsDatas['results'][$id] = $message;
	}
}

$filename = $codename.'-messages'.($language != 'all' ? '-'.$language : '').'-'.date('Ymd').'.'.$format;

switch ($format) {
	case 'xml':
		$xml = new CMS_array2Xml(array($codename => $itemsDatas['results']), 'messages', 'id');
		$exportDatas = $xml->getXMLString();
		$file = new CMS_file(PATH_TMP_FS.'/'.$filename);
		$file->setContent($exportDatas);
		$file->writeToPersistence();
	break;
	case 'sql':
		$sqlDatas = array();
		foreach($itemsDatas['results'] as $id => $message) {
			foreach ($message as $lang => $value) {
				if (!isset($sqlDatas[$lang])) {
					$sqlDatas[$lang] = '#----------------------------------------------------------------'."\n".
						'# Messages content for module '.$codename."\n".
						'# Language : '.$lang."\n".
						'#----------------------------------------------------------------'."\n".
						"\n";
					if ($currentsearch) {
						$sqlDatas[$lang] .= 'DELETE FROM messages WHERE module_mes = \''.$codename.'\' and language_mes = \''.$lang.'\' and id_mes in ('.implode(array_keys($itemsDatas['results']), ',').');'."\n\n";
					} else {
						$sqlDatas[$lang] .= 'DELETE FROM messages WHERE module_mes = \''.$codename.'\' and language_mes = \''.$lang.'\';'."\n\n";
					}
				}
				$sqlDatas[$lang] .= 'INSERT INTO `messages` (`id_mes`, `module_mes`, `language_mes`, `message_mes`) VALUES('.$id.', \''.$codename.'\', \''.$lang.'\', \''.io::sanitizeSQLString($value).'\');'."\n";
			}
		}
		$exportDatas = '';
		foreach ($sqlDatas as $sqlData) {
			$exportDatas .= $sqlData."\n\n";
		}
		$file = new CMS_file(PATH_TMP_FS.'/'.$filename);
		$file->setContent($exportDatas);
		$file->writeToPersistence();
	break;
	case 'xls':
	case 'xlsx':
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator(CMS_grandFather::SYSTEM_LABEL)
							 ->setLastModifiedBy($cms_user->getFullName())
							 ->setTitle("Message for module ".$codename)
							 ->setSubject("Message for module ".$codename);
		$objPHPExcel->setActiveSheetIndex(0);
		$startChr = 65; //Letter A (first column)
		$columnIndexes = array();
		$index = 0;
		$line = 2; //First line is for headline titles
		foreach($itemsDatas['results'] as $id => $message) {
			if (!isset($columnIndexes['id'])) {
				$columnIndexes['id'] = chr($startChr + $index);
				$index++;
				$objPHPExcel->getActiveSheet()->setCellValue($columnIndexes['id'].'1', 'id');
			}
			$objPHPExcel->getActiveSheet()->setCellValue($columnIndexes['id'].$line, $id);
			foreach ($message as $lang => $value) {
				if (!isset($columnIndexes[$lang])) {
					$columnIndexes[$lang] = chr($startChr + $index);
					$index++;
					$objPHPExcel->getActiveSheet()->setCellValue($columnIndexes[$lang].'1', $lang);
				}
				$objPHPExcel->getActiveSheet()->setCellValue($columnIndexes[$lang].$line, $value);
			}
			$line++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		switch ($format) {
			case 'xls':
				$writer = 'Excel5';
				$contentType = 'application/vnd.ms-excel';
			break;
			case 'xlsx':
				$writer = 'Excel2007';
				$contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
			break;
		}
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $writer);
		$objWriter->save(PATH_TMP_FS.'/'.$filename);
	break;
	case 'po':
		//use user language as a key for export
		$keyLang = $cms_user->getLanguage()->getCode();
		
		$po = new CMS_PO();
		//Set PO headers
		$po->set_header('Project-Id-Version', CMS_grandFather::SYSTEM_LABEL);
		$po->set_header('X-Automne-Module', $codename);
		$po->set_header('X-Automne-Key-Language', $keyLang);
		$po->set_header('X-Automne-Translation-Language', $language);
		$po->set_header('X-Automne-Export-date', date('Ymd'));
		$po->set_header('MIME-Version', '1.0');
		$po->set_header('Content-Type', 'text/plain; charset=utf-8');
		$po->set_header('Content-Transfer-Encoding', '8bit');
		
		foreach($itemsDatas['results'] as $id => $message) {
			$entryKey = $entryValue = '';
			foreach ($message as $lang => $value) {
				if ($lang == $keyLang) {
					$entryKey = $value;
				}
				if ($lang == $language) {
					$entryValue = $value;
				}
			}
			if ($entryKey) {
				/*
				 * 	- singular (string) -- the string to translate, if omitted and empty entry will be created
				 * 	- plural (string) -- the plural form of the string, setting this will set {@link $is_plural} to true
				 * 	- translations (array) -- translations of the string and possibly -- its plural forms
				 * 	- context (string) -- a string differentiating two equal strings used in different contexts
				 * 	- translator_comments (string) -- comments left by translators
				 * 	- extracted_comments (string) -- comments left by developers
				 * 	- references (array) -- places in the code this strings is used, in relative_to_root_path/file.php:linenum form
				 * 	- flags (array) -- flags like php-format
				*/
				$entry = new CMS_po_entry(array(
					'singular'			=> trim($entryKey),
					'context'			=> $id,
					'translations'		=> array($entryValue),
					'extracted_comments'=> io::jsonEncode(array('codename' => $codename, 'id' => $id, 'keylang' => $keyLang, 'msglang' => $language)),
				));
				$po->add_entry($entry);
			}
		}
		$exportDatas = $po->export();
		$file = new CMS_file(PATH_TMP_FS.'/'.$filename);
		$file->setContent($exportDatas);
		$file->writeToPersistence();
	break;
}
if (file_exists(PATH_TMP_FS.'/'.$filename)) {
	CMS_file::downloadFile(PATH_TMP_FS.'/'.$filename, false, true, isset($contentType) ? $contentType : false);
} else {
	CMS_grandFather::raiseError('Export error : exported file does not exists ...');
	$view->show();
}
?>