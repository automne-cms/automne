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
// $Id: items-controler.php,v 1.1 2009/06/05 15:01:07 sebastien Exp $

/**
  * PHP page : Load polymod item interface
  * Used accross an Ajax request. Render a polymod item for edition
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

define("MESSAGE_PAGE_FIELD_PUBDATE_BEG", 134);
define("MESSAGE_PAGE_FIELD_PUBDATE_END", 135);
define("MESSAGE_ERROR_WRITETOPERSISTENCE",178);

//Controler vars
$action = sensitiveIO::request('action', array('save'));
$objectId = sensitiveIO::request('type', 'sensitiveIO::isPositiveInteger');
$itemId = sensitiveIO::request('item', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());

$fieldsValues = sensitiveIO::request('polymodFieldsValue', 'is_array', array());
$pubStart = sensitiveIO::request('pubStart');
$pubEnd = sensitiveIO::request('pubEnd');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
$content = array('success' => false);

//instanciate module
$cms_module = CMS_modulesCatalog::getByCodename($codename);

//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('Error, user has no rights on module : '.$codename);
	$view->setContent($content);
	$view->show();
}

//load object
if ($objectId) {
	$object = new CMS_poly_object_definition($objectId);
	$objectLabel = sensitiveIO::sanitizeJSString($object->getLabel($cms_language));
}
if (!isset($object) || $object->hasError()) {
	CMS_grandFather::raiseError('Error, objectId does not exists or has an error : '.$objectId);
	$view->setContent($content);
	$view->show();
}
//load item if any
if ($itemId) {
	$item = new CMS_poly_object($objectId, $itemId);
	$itemLabel = sensitiveIO::sanitizeJSString($item->getLabel());
	if ($object->isPrimaryResource()) {
		//put a lock on the resource or warn user if item is already locked by another user
		if ($lock = $item->getLock()) {
			$lockUser = CMS_profile_usersCatalog::getById($lock);
			if ($lockUser->getUserId() != $cms_user->getUserId()) {
				$lockDate = $item->getLockDate();
				$date = $lockDate ? $lockDate->getLocalizedDate($cms_language->getDateFormat().' à H:i:s') : '';
				$name = sensitiveIO::sanitizeJSString($lockUser->getFullName());
				CMS_grandFather::raiseError('Error, item '.$itemId.' is locked by '.$lockUser->getFullName());
				$jscontent = "
				Automne.message.popup({
					msg: 				'L\'élément \'{$itemLabel}\' que vous cherchez à éditer est vérouillé par {$name} le {$date}.',
					buttons: 			Ext.MessageBox.OK,
					closable: 			false,
					icon: 				Ext.MessageBox.ERROR
				});";
				$view->addJavascript($jscontent);
				$view->setContent($content);
				$view->show();
			}
		} else {
			$item->lock($cms_user);
		}
	}
	//check user rights on item
	if (!$item->userHasClearance($cms_user, CLEARANCE_MODULE_EDIT)) {
		CMS_grandFather::raiseError('Error, user has no rights item '.$itemId);
		$jscontent = "
		Automne.message.popup({
			msg: 				'Vous n\'avez pas le droit d\'éditer l\'élément \'{$itemLabel}\'.',
			buttons: 			Ext.MessageBox.OK,
			closable: 			false,
			icon: 				Ext.MessageBox.ERROR
		});";
		$view->addJavascript($jscontent);
		$view->setContent($content);
		$view->show();
	}
} else { //instanciate clean object (creation)
	$item = new CMS_poly_object($object->getID(), '');
}

$cms_message = '';
switch ($action) {
	case 'save':
		//checks and assignments
		$item->setDebug(false);
		$fieldsObjects = $item->getFieldsObjects();
		//first, check mandatory values
		$allOK = true;
		foreach ($fieldsObjects as $fieldID => $aFieldObject) {
			$allOK &= $item->checkMandatory($fieldID, $fieldsValues, '', true);
			//pr($fieldID.' : '.$allOK);
		}
		if (!$allOK) {
			$cms_message .= $cms_language->getMessage(MESSAGE_FORM_ERROR_MANDATORY_FIELDS);
		}
		
		//second, set values for all fields
		foreach ($fieldsObjects as $fieldID => $aFieldObject) {
			if (!$item->setValues($fieldID, $fieldsValues, '', true)) {
				$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
						array($aFieldObject->getFieldLabel($cms_language)));
			}
		}
		
		//set publication dates if needed
		if ($object->isPrimaryResource()) {
			// Dates management
			$dt_beg = new CMS_date();
			$dt_beg->setDebug(false);
			$dt_beg->setFormat($cms_language->getDateFormat());
			$dt_end = new CMS_date();
			$dt_end->setDebug(false);
			$dt_end->setFormat($cms_language->getDateFormat());
			if (!$dt_set_1 = $dt_beg->setLocalizedDate($pubStart, true)) {
				$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
							array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)));
			} 
			if (!$dt_set_2 = $dt_end->setLocalizedDate($pubEnd, true)) {
				$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
						array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)));
			}
			//if $dt_beg && $dt_end, $dt_beg must be lower than $dt_end
			if (!$dt_beg->isNull() && !$dt_end->isNull()) {
				if (CMS_date::compare($dt_beg, $dt_end, '>')) {
					$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
							array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_BEG)));
					$cms_message .= "\n".$cms_language->getMessage(MESSAGE_FORM_ERROR_MALFORMED_FIELD,
						array($cms_language->getMessage(MESSAGE_PAGE_FIELD_PUBDATE_END)));
					$dt_set_1 = $dt_set_2 = false;
				}
			}
			if ($dt_set_1 && $dt_set_2) {
				$item->setPublicationDates($dt_beg, $dt_end);
			}
		}
		if (!$cms_message) {
			//save the data
			if (!$item->writeToPersistence()) {
				$cms_message .= $cms_language->getMessage(MESSAGE_ERROR_WRITETOPERSISTENCE);
			}
			//then redirect to summary
			if (!$cms_message) {
				$cms_message = $cms_language->getMessage(MESSAGE_ACTION_OPERATION_DONE);
				$content = array('success' => true, 'id' => $item->getID());
			}
		}
	break;
}
//pr($fieldsValues);
//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
//beware, here we add content (not set) because object saving can add his content to (uploaded file infos updated)
$view->addContent($content);
$view->show();
?>