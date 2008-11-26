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
// $Id: getValidationByID.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : validations
  * Handle validation by its ID and module codename
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

//augment the execution time, because things here can be quite lengthy
@set_time_limit(0);

//checks
if (!$_GET["module"] || !$_GET["resource"]) {
	die ("Missing parameter...");
	exit;
}

$module = CMS_modulesCatalog::getByCodename($_GET["module"]);

$resource = $module->getResourceByID($_GET["resource"]);

//Clean old validations
CMS_resourceValidation::cleanOldValidations();

if (method_exists($module, "getValidationByID")) {
	$validation = $module->getValidationByID($resource->getID(),$cms_user);
	if (is_a($validation,"CMS_resourceValidation") && !$validation->hasError()) {
		$validationID = $validation->getID();
	}
} else {
	$validations = $module->getValidations($cms_user);
	foreach ($validations as $aValidation) {
		if ($aValidation->getResourceID() == $resource->getID()) {
			$validationID = $aValidation->getID();
		}
	}
}

if ($validationID) {
	header ("Location: validation.php?validation_id=".$validationID."&".session_name()."=".session_id());
	exit;
} else {
	CMS_grandFather::raiseError("Unknown resource ID ".$_GET["resource"]." for module ".$_GET["module"].".");
}
?>