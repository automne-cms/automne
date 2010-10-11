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

/**
  * PHP page : Update Automne database
  * Used accross an include at end of scripts
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

if (!function_exists('atm_regen')) {
	function atm_regen(){}
}
if (!defined('APPLICATION_CONFIG_LOADED')) {
	define('APPLICATION_CONFIG_LOADED', true);
}

//START UPDATE FROM 4.0.2 TO 4.1.0
echo "Update database if needed : <br />";

# Change structure of some tables to add uuid data
$sql = "show columns from mod_object_definition";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "uuid_mod") {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_REALROOT_FS.'/sql/updates/v402-to-v410.sql',true)) {
		CMS_patch::executeSqlScript(PATH_REALROOT_FS.'/sql/updates/v402-to-v410.sql',false);
		echo 'Database successfuly updated (uuid)<br/>';
	} else {
		echo 'Error during database update ! Script '.PATH_REALROOT_FS.'/sql/updates/v402-to-v410.sql must be executed manualy<br/>';
	}
} else {
	echo 'Database already up to date (uuid) ... skipping<br/>';
}
# Change structure of base datas tables to add codename data
$sql = "show columns from pagesBaseData_public";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "codename_pbd") {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_REALROOT_FS.'/sql/updates/v402-to-v410-2.sql',true)) {
		CMS_patch::executeSqlScript(PATH_REALROOT_FS.'/sql/updates/v402-to-v410-2.sql',false);
		echo 'Database successfuly updated (pages codename)<br/>';
	} else {
		echo 'Error during database update ! Script '.PATH_REALROOT_FS.'/sql/updates/v402-to-v410-2.sql must be executed manualy<br/>';
	}
} else {
	echo 'Database already up to date (pages codename) ... skipping<br/>';
}
# Change structure of website table to add codename data
$sql = "show columns from websites";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "codename_web") {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_REALROOT_FS.'/sql/updates/v402-to-v410-3.sql',true)) {
		CMS_patch::executeSqlScript(PATH_REALROOT_FS.'/sql/updates/v402-to-v410-3.sql',false);
		echo 'Database successfuly updated (website codename)<br/>';
	} else {
		echo 'Error during database update ! Script '.PATH_REALROOT_FS.'/sql/updates/v402-to-v410-3.sql must be executed manualy<br/>';
	}
} else {
	echo 'Database already up to date (website codename) ... skipping<br/>';
}
//END UPDATE FROM 4.0.2 TO 4.1.0

//clear caches
CMS_cache::clearTypeCache('polymod');
CMS_cache::clearTypeCache('text/javascript');
CMS_cache::clearTypeCache('text/css');
//launch definitions updates
if ($return = @file_get_contents(CMS_websitesCatalog::getMainURL().PATH_ADMIN_MODULES_WR.'/polymod/update-definitions.php')) {
	echo $return;
} else {
	echo '<a href="'.CMS_websitesCatalog::getMainURL().PATH_ADMIN_MODULES_WR.'/polymod/update-definitions.php" class="admin" target="_blank">/!\ Please click this link to finalise Automne update /!\</a><br />';
}
//regenerate pages
echo "<br />Pages regeneration is launched<br />";
CMS_tree::regenerateAllPages(true);
?>