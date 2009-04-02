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
// $Id: module-controler.php,v 1.1 2009/04/02 13:55:54 sebastien Exp $

/**
  * PHP page : Module controler.
  * Used accross an Ajax requestto set module action.
  * 
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

$codename = sensitiveIO::request('module', CMS_modulesCatalog::getAllCodenames());
$action = sensitiveIO::request('action');
$params = sensitiveIO::request('params', 'is_array');

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);

//CHECKS
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no administration rights.');
	$view->show();
}
$module = CMS_modulesCatalog::getByCodename($codename);
if (!is_a($module, "CMS_module")) {
	CMS_grandFather::raiseError('Module '.$codename.' does not exists');
	$view->show();
}

$cms_message = '';

switch ($action) {
	case 'submit-parameters':
		if (!$module->hasParameters()) {
			CMS_grandFather::raiseError('Module '.$codename.' has no parameters');
			$view->show();
			break;
		}
		
		//set return to false by default
		$content = array('success' => false);
		$parameters = $module->getParameters(false, true);
		foreach ($parameters as $label => $value) {
			$parameters[$label][0] = $value;
			if (isset($params[$label])) {
				$parameters[$label][0] = htmlspecialchars($params[$label]);
			} elseif ($parameters[$label][1] == 'boolean') {
				$parameters[$label][0] = 0;
			} else {
				$parameters[$label][0] = '';
			}
		}
		$module->setAndWriteParameters($parameters);
		$content = array('success' => true);
		$cms_message = 'Paramètres enregistrés.';
		$view->setContent($content);
	break;
}

//set user message if any
if ($cms_message) {
	$view->setActionMessage($cms_message);
}
$view->show();
?>