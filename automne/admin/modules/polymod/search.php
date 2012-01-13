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
// $Id: search.php,v 1.8 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : Load polyobjects items datas
  * Used accross an Ajax request.
  * Return formated items infos in JSON format
  *
  * @package Automne
  * @subpackage polymod
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');

define("MESSAGE_ERROR_MODULE_RIGHTS",570);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

//get search vars
$objectId = sensitiveIO::request('objectId', 'sensitiveIO::isPositiveInteger');
$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$search = sensitiveIO::request('search');
$sort = sensitiveIO::request('sort');
$dir = sensitiveIO::request('dir');
$start = sensitiveIO::request('start', 'sensitiveIO::isPositiveInteger', 0);
$limit = sensitiveIO::request('limit', 'sensitiveIO::isPositiveInteger', CMS_session::getRecordsPerPage());
$limitToItems = sensitiveIO::request('items');
if ($limitToItems) {
	$limitToItems = explode(',',$limitToItems);
}
$limitToOrderedItems = sensitiveIO::request('itemsOrdered');
if ($limitToOrderedItems) {
	$limitToOrderedItems = explode(',',$limitToOrderedItems);
}
//Some actions to do on items founded
$unlock = sensitiveIO::request('unlock') ? true : false;
$delete = sensitiveIO::request('del') ? true : false;
$undelete = sensitiveIO::request('undelete') ? true : false;
$publish = sensitiveIO::request('publish') ? true : false;
$unpublish = sensitiveIO::request('unpublish') ? true : false;

$itemsDatas = array();
$itemsDatas['results'] = array();

if (!$codename) {
	CMS_grandFather::raiseError('Unknown module ...');
	$view->show();
}
//load module
$module = CMS_modulesCatalog::getByCodename($codename);
if (!$module || !$module->isPolymod()) {
	CMS_grandFather::raiseError('Unknown module or module is not polymod for codename : '.$codename);
	$view->setContent($itemsDatas);
	$view->show();
}
//CHECKS user has module clearance
if (!$cms_user->hasModuleClearance($codename, CLEARANCE_MODULE_EDIT)) {
	CMS_grandFather::raiseError('User has no rights on module : '.$codename);
	$view->setActionMessage($cms_language->getmessage(MESSAGE_ERROR_MODULE_RIGHTS, array($module->getLabel($cms_language))));
	$view->setContent($itemsDatas);
	$view->show();
}
//CHECKS objectId
if (!$objectId) {
	CMS_grandFather::raiseError('Missing objectId to search in module '.$codename);
	$view->setContent($itemsDatas);
	$view->show();
}

//load current object definition
$object = CMS_poly_object_catalog::getObjectDefinition($objectId);
// Check if need to use a specific display for search results
$resultsDefinition = $object->getValue('resultsDefinition');

//load fields objects for object
$objectFields = CMS_poly_object_catalog::getFieldsDefinition($object->getID());

//Add all subobjects to search if any
$fields = array();

$possibleTargets = array();
foreach ($objectFields as $fieldID => $field) {
	if (isset($_REQUEST['items_'.$object->getID().'_'.$fieldID])) {
		$fields[$fieldID] = sensitiveIO::request('items_'.$object->getID().'_'.$fieldID, '', '');
	}
	// get the value of all possible searchable fields in case a target is specified by the user
	if ($field->getValue('searchable')){
		$objectType = $field->getTypeObject();
		if (!method_exists($objectType, 'getListOfNamesForObject')) {
			$possibleTargets[]= $fieldID;
		}
	}
}

//get all search datas from requests
$keywords = sensitiveIO::request('items_'.$object->getID().'_kwrds', '', '');
$keywordsOptions = sensitiveIO::request('items_'.$object->getID().'_kwrds_options', array('any', 'all', 'phrase','beginswith'), 'any');
$keywordsTarget = sensitiveIO::request('kwrds_target_'.$object->getID(), $possibleTargets, -1);
$dateFrom = sensitiveIO::request('items_dtfrm', '', '');
$dateEnd = sensitiveIO::request('items_dtnd', '', '');
$sort = sensitiveIO::request('sort_'.$object->getID(), '', '');
$status = sensitiveIO::request('status_'.$object->getID(), '', '');
$direction = sensitiveIO::request('direction_'.$object->getID(), '', '');

// Set default session search options
CMS_session::setSessionVar('items_'.$object->getID().'_kwrds', $keywords);
//CMS_session::setSessionVar('items_'.$object->getID().'_kwrds_options', $keywordsOptions);
CMS_session::setSessionVar('kwrds_target_'.$object->getID(),$keywordsTarget);
CMS_session::setSessionVar("items_dtfrm", $dateFrom);
CMS_session::setSessionVar("items_dtnd", $dateEnd);
CMS_session::setSessionVar('sort_'.$object->getID(), $sort);
CMS_session::setSessionVar('status_'.$object->getID(), $status);
CMS_session::setSessionVar('direction_'.$object->getID(), $direction);
//Add all subobjects to search if any
foreach ($objectFields as $fieldID => $field) {
	if (isset($fields[$fieldID])) {
		CMS_session::setSessionVar('items_'.$object->getID().'_'.$fieldID, $fields[$fieldID]);
	}
}

// Date format
$dateFormat = $cms_language->getDateFormat(); 		// d/m/Y

// +----------------------------------------------------------------------+
// | Build search                                                         |
// +----------------------------------------------------------------------+

//create search object for current object
$search = new CMS_object_search($object);

//if object is a primary resource
if ($object->isPrimaryResource()) {
	//Order
	$search->setAttribute('orderBy', 'publicationDateStart_rs desc,publicationDateEnd_rs desc, id_moo desc');
	
	// Param : Around publication date
	$dt_today = new CMS_date();
	$dt_today->setDebug(false);
	$dt_today->setNow();
	$dt_today->setFormat($dateFormat);
	
	$dt_from = new CMS_date();
	$dt_from->setDebug(false);
	$dt_from->setFormat($dateFormat);
	if ($dt_from->setLocalizedDate(CMS_session::getSessionVar("items_dtfrm"),true)) {
		$search->addWhereCondition("publication date after", $dt_from);
	}
	
	$dt_end = new CMS_date();
	$dt_end->setDebug(false);
	$dt_end->setFormat($dateFormat);
	if ($dt_end->setLocalizedDate(CMS_session::getSessionVar("items_dtnd"),true)) {
		// Check this date isn't greater than start date given
		if (!CMS_date::compare($dt_from, $dt_end, ">=")) {
			$search->addWhereCondition("publication date before", $dt_end);
		}
	}
	if ($status) {
		$search->addWhereCondition("status", $status);
	}
}
//Add all subobjects to search if any
foreach ($objectFields as $fieldID => $field) {
	//if field is a poly object
	if (CMS_session::getSessionVar('items_'.$object->getID().'_'.$fieldID) != '') {
		$search->addWhereCondition($fieldID, CMS_session::getSessionVar('items_'.$object->getID().'_'.$fieldID));
	}
}
// Param : With keywords (this is best if it is done at last)
if (CMS_session::getSessionVar('items_'.$object->getID().'_kwrds') != '') {
	$kwrd = CMS_session::getSessionVar('items_'.$object->getID().'_kwrds');
	if (!io::isPositiveInteger($kwrd)) {
		if(io::isPositiveInteger($keywordsTarget)) {
			// a specific field target was specified
			$search->addWhereCondition($keywordsTarget, $kwrd, $keywordsOptions);
		}
		else {
			$search->addWhereCondition("keywords", $kwrd, $keywordsOptions);
		}
	} else {
		$search->addWhereCondition("item", $kwrd);
	}
}

//If we must limit to some specific items (usually used during refresh of some listing elements)
if ($limitToItems) {
	$search->addWhereCondition("items", $limitToItems);
} elseif ($limitToOrderedItems) {//If we must limit to some specific items ordered (usually used for polymod multi_poly_object field)
	$search->addWhereCondition("itemsOrdered", $limitToOrderedItems);
} else {
	// Params : paginate limit
	$search->setAttribute('itemsPerPage', $limit);
	$search->setAttribute('page', ($start / $limit));
	
	// Params : set default direction direction
	if(!CMS_session::getSessionVar('direction_'.$object->getID())){
		CMS_session::setSessionVar('direction_'.$object->getID(), 'desc');
	}
	
	// Params : order
	if(CMS_session::getSessionVar('sort_'.$object->getID())){
		$search->addOrderCondition(CMS_session::getSessionVar('sort_'.$object->getID()),CMS_session::getSessionVar('direction_'.$object->getID()));
	} else {
		$search->addOrderCondition('objectID', CMS_session::getSessionVar('direction_'.$object->getID()));
	}
}
//launch search
$search->search(CMS_object_search::POLYMOD_SEARCH_RETURN_INDIVIDUALS_OBJECTS);

// Vars for lists output purpose and pages display, see further
$itemsDatas['total'] = $search->getNumRows();

//Get parsed result definition
if ($resultsDefinition) {
	$definitionParsing = new CMS_polymod_definition_parsing($resultsDefinition, true, CMS_polymod_definition_parsing::PARSE_MODE);
}
//loop on results items
while($item = $search->getNextResult()) {
	//Process actions on item if any
	
	//Unlock item
	if ($unlock && $object->isPrimaryResource()) {
		$item->unlock();
	}
	//Delete item
	if ($delete) {
		$item->delete();
		if (!$object->isPrimaryResource()) {
			unset($item);
			$itemsDatas['total']--;
			continue;
		}
	}
	//Undelete item
	if ($undelete && $object->isPrimaryResource()) {
		$item->undelete();
	}
	//unpublish
	if ($unpublish && $object->isPrimaryResource()) {
		//set item date end to yesterday
		$dt_end = new CMS_date();
		$dt_end->setDebug(false);
		$dt_end->setNow();
		$dt_end->moveDate('-1 day');
		$dateStart = $item->getPublicationDateStart(false);
		if (CMS_date::compare($dateStart, $dt_end, '>')) {
			$dateStart = $dt_end;
		}
		$item->setPublicationDates($dateStart, $dt_end);
		$item->writeToPersistence();
	}
	//publish
	if ($publish && $object->isPrimaryResource()) {
		//clear page date end
		$dt_end = new CMS_date();
		$dateStart = $item->getPublicationDateStart(false);
		$item->setPublicationDates($dateStart, $dt_end);
		$item->writeToPersistence();
	}
	
	//Resource related informations
	$htmlStatus = $pubRange = '';
	$lock = $deleted = $published = $unpublished = false;
	if ($object->isPrimaryResource()) {
		$status = $item->getStatus();
		if (is_object($status)) {
			$htmlStatus = $status->getHTML(false, $cms_user, $codename, $item->getID());
			$pubRange = $status->getPublicationRange($cms_language, false);
			$lock = $item->getLock();
			$deleted = ($item->getProposedLocation() == RESOURCE_LOCATION_DELETED);
		}
		$endPublication = $item->getPublicationDateEnd(false);
		$now = new CMS_date();
		$now->setNow();
		$published = $item->getPublication() == RESOURCE_PUBLICATION_PUBLIC && ($endPublication->isNull() || CMS_date::compare($endPublication, $now, '>'));
		$unpublished = $item->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED && !$endPublication->isNull() && CMS_date::compare($endPublication, $now, '<=');
	}
	//Previz
	$previz = ($object->getValue("previewURL")) ? $item->getPrevizPageURL() : '';
	//Edit
	$edit = false;
	if (!$deleted && (!$lock || $lock == $cms_user->getUserId())) {
		$edit = array(
			'module'		=> $codename,
			'objectId'		=> $objectId,
			'item'			=> $item->getID()
		);
	}
	
	//HTML description
	$description = POLYMOD_DEBUG ? '<span class="atm-text-alert"> (ID : '.$item->getID().')</span>' : '';
	if($resultsDefinition){
		//set execution parameters
		$parameters = array();
		$parameters['module'] 	= $codename;
		$parameters['objectID'] = $object->getID();
		$parameters['public'] 	= false;
		$parameters['item']		= $item;
		$description .= $definitionParsing->getContent(CMS_polymod_definition_parsing::OUTPUT_RESULT, $parameters);
	} else {
		$itemFieldsObjects = $item->getFieldsObjects();
		//Add all needed fields to description
		foreach ($itemFieldsObjects as $fieldID => $itemField) {
			//if field is a poly object
			if ($objectFields[$fieldID]->getValue('searchlist')) {
				$description .= $objectFields[$fieldID]->getLabel($cms_language).' : <strong>'.$itemField->getHTMLDescription().'</strong><br />';
			}
		}
	}
	
	$itemsDatas['results'][] = array(
		'id'			=> $item->getID(),
		'status'		=> $htmlStatus,
		'pubrange'		=> $pubRange,
		'label'			=> $item->getLabel(),
		'description'	=> $description,
		'locked'		=> $lock,
		'deleted'		=> $deleted,
		'previz'		=> $previz,
		'edit'			=> $edit,
		'published'		=> !$lock && !$deleted && $edit && $published,
		'unpublished'	=> !$lock && !$deleted && $edit && $unpublished
	);
}

$view->setContent($itemsDatas);
$view->show();
?>