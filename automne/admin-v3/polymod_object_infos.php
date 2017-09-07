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
// $Id: polymod_object_infos.php,v 1.3 2010/03/08 16:41:40 sebastien Exp $

/**
  * PHP page : polymod admin
  * Used to manage poly modules
  *
  * @package Automne
  * @subpackage admin-v3
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

define("MESSAGE_PAGE_TITLE", 1280);
define("MESSAGE_PAGE_TITLE_APPLICATIONS", 264);
define("MESSAGE_PAGE_FIELD_DESCRIPTION", 139);
define("MESSAGE_PAGE_FIELD_RESOURCE",1230);
define("MESSAGE_PAGE_FIELD_EDITABLE", 1271);
define("MESSAGE_PAGE_FIELD_RESOURCE_NONE",195);
define("MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY",1231);
define("MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY",1232);
define("MESSAGE_PAGE_FIELD_YES", 1082);
define("MESSAGE_PAGE_FIELD_NO", 1083);
define("MESSAGE_ACTION_OBJECT_STRUCTURE", 1279);
define("MESSAGE_PAGE_FIELD_OBJECT", 1234);
define("MESSAGE_PAGE_FIELD_OBJECT_USEAGE", 1281);
define("MESSAGE_PAGE_FIELD_OBJECT_USED", 1282);
define("MESSAGE_PAGE_FIELD_OBJECT_GRAYED_INFOS", 1292);
define("MESSAGE_PAGE_FIELD_COMPOSED_LABEL", 1294);
define("MESSAGE_PAGE_FIELD_ONLY_FOR_ADMIN", 1276);
//Polymod messages
define("MESSAGE_PAGE_FIELD_MULTI", 190);

//checks
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	header("Location: ".PATH_ADMIN_SPECIAL_ENTRY_WR."?cms_message_id=".MESSAGE_PAGE_CLEARANCE_ERROR."&".session_name()."=".session_id());
	exit;
}

$moduleCodename = ($_POST["moduleCodename"]) ? $_POST["moduleCodename"]:$_GET["moduleCodename"];
$object = new CMS_poly_object_definition($_POST["object"]);
$availableLanguagesCodes = CMS_object_i18nm::getAvailableLanguages();

$objectsStructure = CMS_poly_module_structure::getModuleStructure($moduleCodename, true);

if ($moduleCodename) {
	$polymod = CMS_modulesCatalog::getByCodename($moduleCodename);
}

$dialog = new CMS_dialog();
$content = '';
$dialog->setTitle($cms_language->getMessage(MESSAGE_PAGE_TITLE_APPLICATIONS)." :: ".$polymod->getLabel($cms_language)." :: ".$cms_language->getMessage(MESSAGE_PAGE_TITLE, array($object->getLabel($cms_language))),'picto_modules.gif');
$dialog->setBacklink("modules_admin.php?moduleCodename=".$moduleCodename."&object=".$object->getID());
if ($cms_message) {
	$dialog->setActionMessage($cms_message);
}



$resourceStatus = array(
	0 => MESSAGE_PAGE_FIELD_RESOURCE_NONE,
	1 => MESSAGE_PAGE_FIELD_RESOURCE_PRIMARY,
	2 => MESSAGE_PAGE_FIELD_RESOURCE_SECONDARY
);
$adminEditableStatus = array(
	0 => MESSAGE_PAGE_FIELD_YES,
	1 => MESSAGE_PAGE_FIELD_NO,
	2 => MESSAGE_PAGE_FIELD_ONLY_FOR_ADMIN,
);
$objectUseage = CMS_poly_object_catalog::getObjectUsage($object->getID(), true);
if (!sizeof($objectUseage)) {
	$objectUseageLabel = $cms_language->getMessage(MESSAGE_PAGE_FIELD_NO).'<br />';
} else {
	$objectUseageLabel = $cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_USED).' : <ul>';
	foreach ($objectUseage as $anObjectWhichUse) {
		$objectUseageLabel .= '<li>'.$anObjectWhichUse->getLabel().'</li>';
	}
	$objectUseageLabel .='</ul>';
}
$content = '
<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_DESCRIPTION).' :</strong> '.$object->getDescription($cms_language).'<br />
<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_RESOURCE).' :</strong> '.$cms_language->getMessage($resourceStatus[$object->getValue("resourceUsage")]).'<br />
<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_EDITABLE).' :</strong> '.$cms_language->getMessage($adminEditableStatus[$object->getValue("admineditable")]).'<br />
<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_COMPOSED_LABEL).' :</strong> '.$cms_language->getMessage($adminEditableStatus[($object->getValue("composedLabel")) ? 0 : 1]).'<br />
<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_USEAGE).' :</strong> '.$objectUseageLabel.'
<br />
<dialog-title type="admin_h2">'.$cms_language->getMessage(MESSAGE_PAGE_TITLE, array($object->getLabel($cms_language))).' :</dialog-title>
<strong>'.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT_GRAYED_INFOS).'</strong>';

$content .= createHTMLStructure($object->getID(), $objectsStructure);

// ****************************************************************
// ** CONTENT FUNCTIONS                                          **
// ****************************************************************
function createHTMLStructure($objectID, $objectsStructure) {
	global $cms_language;
	static $level;
	$level++;
	
	$html = '';
	if ($objectsStructure['object'.$objectID]) {
		$html .= '<ul>';
		foreach ($objectsStructure['object'.$objectID] as $objectFieldID => $objectField) {
			if (!is_array($objectField) && class_exists($objectField)) {
				$style = _getColorsForLevel($level);
				$html .= '<li style="'.$style['field'].'"><strong>'.$objectsStructure['objectInfos'][$objectFieldID]->getObjectLabel($cms_language).'</strong>&nbsp;&nbsp;&nbsp;<small>('.$objectsStructure['objectInfos'][$objectField]->getObjectLabel($cms_language).')</small></li>';
			} elseif (is_array($objectField)) {
				$arrayKeysObjectField = array_keys($objectField);
				$object = array_shift($arrayKeysObjectField);
				if (strpos($object, 'object') === 0) {
					//here check if object as parameter to force loading of subobjects, if so, remove one level
					//TODO : check this function in condition, maybe we should remove two level instead
					$subObjectsParam = $objectsStructure['objectInfos'][$objectFieldID]->getParameter('loadSubObjects');
					if ($subObjectsParam == true && $level == 2) {
						$level--;
					}
					$style = _getColorsForLevel($level);
					$html .= '
					<li style="'.$style['object'].'"><strong>'.$objectsStructure['objectInfos'][$objectFieldID]->getObjectLabel($cms_language).'</strong>&nbsp;&nbsp;&nbsp;<small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_OBJECT).' \''.$objectsStructure['objectInfos'][$object]->getLabel($cms_language).'\')</small>
						'.createHTMLStructure(substr($object,6), $objectsStructure).'
					</li>';
					if ($subObjectsParam == true && $level == 1) {
						$level++;
					}
				} elseif (strpos($object, 'multiobject') === 0) {
					//here check if object as parameter to force loading of subobjects, if so, remove one level
					//TODO : check this function in condition, maybe we should remove two level instead
					$subObjectsParam = $objectsStructure['objectInfos'][$objectFieldID]->getParameter('loadSubObjects');
					if ($subObjectsParam == true && $level == 2) {
						$level--;
					}
					$style = _getColorsForLevel($level);
					$html .= '
					<li style="'.$style['multiobject'].'"><strong>'.$objectsStructure['objectInfos'][$objectFieldID]->getObjectLabel($cms_language).'</strong>&nbsp;&nbsp;&nbsp;<small>('.$cms_language->getMessage(MESSAGE_PAGE_FIELD_MULTI, array($objectsStructure['objectInfos'][substr($object,5)]->getLabel($cms_language)), MOD_POLYMOD_CODENAME).')</small>
						'.createHTMLStructure(substr($object,11), $objectsStructure).'
					</li>';
					if ($subObjectsParam == true && $level == 1) {
						$level++;
					}
				}
			}
		}
		$html .= '</ul>';
	}
	$level--;
	return $html;
}

function _getColorsForLevel ($level) {
	if ($level <= 2) {
		$style = array(
			'field' 		=> 'color:#000000;font-size:11px;',
			'object' 		=> 'color:#FF7D36;font-size:11px;',
			'multiobject' 	=> 'color:#8FC020;font-size:11px;',
		);
	} else {
		$style = array(
			'field' 		=> 'color:#cccccc;font-size:10px;',
			'object' 		=> 'color:#ffb992;font-size:10px;',
			'multiobject' 	=> 'color:#bfdd7b;font-size:10px;',
		);
	}
	return $style;
}

$detailledObjectsStructure = CMS_poly_module_structure::getModuleDetailledStructure($moduleCodename, $cms_language);

$dialog->setContent($content);
$dialog->show();
?>