#!/usr/bin/env php
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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr>              |
// +----------------------------------------------------------------------+

/**
  * Daily routine script
  *
  * Checks all unpublished pages to delete them, etc.
  *
  * @package Automne
  * @subpackage scripts
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> &
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

//must calculate the document root first (for compatibility with old scripts)
$_SERVER["DOCUMENT_ROOT"] = realpath(substr(dirname(__FILE__), 0, strlen(dirname(__FILE__)) - strpos(strrev(dirname(__FILE__)), "enmotua") - strlen("automne") - 1));
//define application type
define('APPLICATION_EXEC_TYPE', 'cli');
//include required file
require_once(dirname(__FILE__).'/../../../cms_rc_admin.php');

$modules = CMS_modulesCatalog::getAll();
foreach ($modules as $aModule) {
	if ($aModule->getCodename() == MOD_STANDARD_CODENAME) {
		//module standard auto check if daily routine is already done today
		$aModule->processDailyRoutine();
	} else {
		//see if the action was done today
		$sql = "
			select
				1
			from
				actionsTimestamps
			where
				to_days(date_at) = to_days(now())
				and type_at='DAILY_ROUTINE'
				and module_at='".io::sanitizeSQLString($aModule->getCodename())."'
		";
		$q = new CMS_query($sql);
		if (!$q->getNumRows()) {
			//process module daily routine
			$aModule->processDailyRoutine();
			//update the timestamp
			$sql = "
				delete from
					actionsTimestamps
				where
					type_at='DAILY_ROUTINE'
					and module_at='".io::sanitizeSQLString($aModule->getCodename())."'
			";
			$q = new CMS_query($sql);
			$sql = "
				insert into
					actionsTimestamps
				set
					type_at='DAILY_ROUTINE',
					date_at=now(),
					module_at='".io::sanitizeSQLString($aModule->getCodename())."'
			";
			$q = new CMS_query($sql);
		}
	}
}
?>
