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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+
//
// $Id: favorites-sidepanel.php,v 1.1.1.1 2008/11/26 17:12:05 sebastien Exp $

/**
  * PHP page : Load side panel favorites infos.
  * Used accross an Ajax request to refresh the favorites side panel
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_RAW);

$content = '';

$favorites = $cms_user->getFavorites();
if ($favorites) {
	$content .= '<ul>';
	foreach($favorites as $pageId) {
		$page = CMS_tree::getPageById($pageId);
		if (is_object($page) && !$page->hasError()) {
			$content .= '<li><a href="#" atm:action="favorite" atm:page="'.$pageId.'" alt="'.htmlspecialchars($page->getTitle()).'" title="'.htmlspecialchars($page->getTitle()).'">'.$page->getStatus()->getHTML(true, $cms_user, MOD_STANDARD_CODENAME, $page->getID()).'&nbsp;'.sensitiveIO::ellipsis($page->getTitle(), 32).'&nbsp;('.$pageId.')</a></li>';
		}
	}
	$content .= '</ul>';
} else {
	$content .= 'Aucune page dans vos favoris.';
}
/*
//VALIDATIONS PENDING
$validationpanel = '';
if ($cms_user->hasValidationClearance() && APPLICATION_ENFORCES_WORKFLOW) {
	$modulesValidations = CMS_modulesCatalog::getAllValidations($cms_user, true);
	$validationsCount = 0;
	//panel content
	$content .= '<div id="validationsPanel">';
	if ($modulesValidations && sizeof($modulesValidations)) {
		foreach ($modulesValidations as $codename => $moduleValidations) {
			//if module is not standard, echo its name, the number of validations to do and a link to its admin frontend
			if ($codename == MOD_STANDARD_CODENAME) {
				$modLabel = $cms_language->getMessage(MESSAGE_PAGE_STANDARD_MODULE_LABEL);
			} else {
				$mod = CMS_modulesCatalog::getByCodename($codename);
				$modLabel = $mod->getLabel($cms_language);
			}
			$content .= '<h3>'.$modLabel.' :</h3>
			<ul>';
			//sort the validations by type label
			$validationsSorted = array();
			foreach ($moduleValidations as $validation) {
				$validationsSorted[$validation->getValidationTypeLabel()][] = $validation;
			}
			ksort($validationsSorted);
			foreach ($validationsSorted as $label => $validations) {
				$validation = $validations[0];
				$validationsCount += sizeof($validations);
				$editions = $validation->getEditions();
				if ($editions & RESOURCE_EDITION_CONTENT || $editions & RESOURCE_EDITION_BASEDATA) {
					$class = 'atm-validations';
				} elseif ($editions & RESOURCE_EDITION_LOCATION) {
					$class = 'atm-delete';
				} elseif ($editions & RESOURCE_EDITION_SIBLINGSORDER) {
					$class = 'atm-order';
				}
				$content .= '<li><div class="'.$class.'"></div><a atm:action="validations" atm:module="'.$codename.'" atm:editions="'.$editions.'" href="#">'.$label." : ".sizeof($validations).'</a></li>';
			}
			$content .= '</ul>';
		}
	} else {
		$content .= $cms_language->getMessage(MESSAGE_PAGE_NO_VALIDATIONS_PENDING);
	}
	$content .= '</div>';
}

$jscontent = <<<END
	var validationsPanel = Ext.getCmp('validationsPanel');
	validationsPanel.setTitle('{$cms_language->getJSMessage(MESSAGE_PAGE_VALIDATIONS_PENDING)} : {$validationsCount}');
END;
$view->addJavascript($jscontent);
*/
//send content
$view->setContent($content);
$view->show();
?>