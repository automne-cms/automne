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

//does this file is directly included by another automne script ?
$included = defined('APPLICATION_CONFIG_LOADED') ? true : false;
if (!$included) {
	if (file_exists(dirname(__FILE__).'/../upload-vault/allow_front_update')) {
		//in case of update patch which destroy admin user session, we need to allow 
		//this file with frontend rights
		@unlink(dirname(__FILE__).'/../upload-vault/allow_front_update');
		require_once(dirname(__FILE__).'/../../cms_rc_frontend.php');
	} else {
		require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
	}
	//load interface instance
	$view = CMS_view::getInstance();
	//set default display mode for this page
	$view->setDisplayMode(CMS_view::SHOW_HTML);
}

$content = '';

$content .= "<pre>Start update of Automne database ... <br />";

//START UPDATE FROM 4.0.2 TO 4.1.0
if (!function_exists('atm_regen')) {
	function atm_regen(){}
}
if (!defined('APPLICATION_CONFIG_LOADED')) {
	define('APPLICATION_CONFIG_LOADED', true);
}

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
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v402-to-v410.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v402-to-v410.sql',false);
		$content .= 'Database successfuly updated (uuid)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v402-to-v410.sql must be executed manualy<br/>';
	}
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
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v402-to-v410-2.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v402-to-v410-2.sql',false);
		$content .= 'Database successfuly updated (pages codename)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v402-to-v410-2.sql must be executed manualy<br/>';
	}
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
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v402-to-v410-3.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v402-to-v410-3.sql',false);
		$content .= 'Database successfuly updated (website codename)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v402-to-v410-3.sql must be executed manualy<br/>';
	}
}

$content .= "Automne database updated.<br /><br />";

$content .= "Start update of Automne directories ... <br />";
//Update folders if needed
$actionsTodo = $actionsDone = '';
// Create dir /automne/linx/
if (is_dir(PATH_REALROOT_FS.'/automne_linx_files')) {
	//remove old dir
	if (!CMS_file::deltree(PATH_REALROOT_FS.'/automne_linx_files', true)) {
		$actionsTodo .= '- Delete directory '.PATH_REALROOT_WR.'/automne_linx_files <br/>';
	} else {
		$actionsDone .= '- Deleted directory '.PATH_REALROOT_WR.'/automne_linx_files <br/>';
	}
	//create new one
	if (!CMS_file::makeDir(PATH_MAIN_FS."/linx")) {
		$actionsTodo .= '- Create directory '.PATH_MAIN_WR.'/linx <br/>';
	} else {
		$actionsDone .= '- Created directory '.PATH_MAIN_WR.'/linx <br/>';
	}
}
// Move /automne_bin (only files which not already exists)
if (is_dir(PATH_REALROOT_FS.'/automne_bin')) {
	//create new directory
	if (!is_dir(PATH_MAIN_FS."/bin")) {
		if (!CMS_file::makeDir(PATH_MAIN_FS."/bin")) {
			$actionsTodo .= '- Create directory '.PATH_MAIN_WR.'/bin <br/>';
		} else {
			$actionsDone .= '- Created directory '.PATH_MAIN_WR.'/bin <br/>';
		}
	}
	//copy all files from old directory to new one if they do not already exists
	$errorCopy = false;
	try{
		foreach ( new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PATH_REALROOT_FS.'/automne_bin'), RecursiveIteratorIterator::SELF_FIRST) as $file) {
			if ($file->isFile() && $file->getFilename() != ".htaccess") {
				$to = str_replace(PATH_REALROOT_FS.'/automne_bin', '', $file->getPathname());
				if (!file_exists(PATH_MAIN_FS.'/bin'.$to)) {
					if (!CMS_file::copyTo($file->getPathname(), PATH_MAIN_FS.'/bin'.$to)) {
						$errorCopy = true;
						$actionsTodo .= '- Copy file from '.$file->getPathname().' to '.PATH_MAIN_FS.'/bin'.$to.' <br/>';
					} else {
						//$actionsDone .= '- File copied from '.$file->getPathname().' to '.PATH_MAIN_FS.'/bin'.$to.' <br/>';
					}
				}
			}
		}
	} catch(Exception $e) {}
	//remove old dir
	if (!$errorCopy) {
		if (!CMS_file::deltree(PATH_REALROOT_FS.'/automne_bin', true)) {
			$actionsTodo .= '- Delete directory '.PATH_REALROOT_WR.'/automne_bin <br/>';
		} else {
			$actionsDone .= '- Deleted directory '.PATH_REALROOT_WR.'/automne_bin <br/>';
		}
	} else {
		$actionsTodo .= '- Delete directory '.PATH_REALROOT_WR.'/automne_bin <br/>';
	}
}
// Move /sql (only files which not already exists)
if (is_dir(PATH_REALROOT_FS.'/sql')) {
	//create new directory
	if (!is_dir(PATH_MAIN_FS."/sql")) {
		if (!CMS_file::makeDir(PATH_MAIN_FS."/sql")) {
			$actionsTodo .= '- Create directory '.PATH_MAIN_WR.'/sql <br/>';
		} else {
			$actionsDone .= '- Created directory '.PATH_MAIN_WR.'/sql <br/>';
		}
	}
	//copy all files from old directory to new one if they do not already exists
	$errorCopy = false;
	try{
		foreach ( new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PATH_REALROOT_FS.'/sql'), RecursiveIteratorIterator::SELF_FIRST) as $file) {
			if ($file->isFile() && $file->getFilename() != ".htaccess") {
				$to = str_replace(PATH_REALROOT_FS.'/sql', '', $file->getPathname());
				if (!file_exists(PATH_MAIN_FS.'/sql'.$to)) {
					if (!CMS_file::copyTo($file->getPathname(), PATH_MAIN_FS.'/sql'.$to)) {
						$errorCopy = true;
						$actionsTodo .= '- Copy file from '.$file->getPathname().' to '.PATH_MAIN_FS.'/sql'.$to.' <br/>';
					} else {
						//$actionsDone .= '- File copied from '.$file->getPathname().' to '.PATH_MAIN_FS.'/sql'.$to.' <br/>';
					}
				}
			}
		}
	} catch(Exception $e) {}
	//remove old dir
	if (!$errorCopy) {
		if (!CMS_file::deltree(PATH_REALROOT_FS.'/sql', true)) {
			$actionsTodo .= '- Delete directory '.PATH_REALROOT_WR.'/sql <br/>';
		} else {
			$actionsDone .= '- Deleted directory '.PATH_REALROOT_WR.'/sql <br/>';
		}
	} else {
		$actionsTodo .= '- Delete directory '.PATH_REALROOT_WR.'/sql <br/>';
	}
}

//check if config.php is writable
$configWritable = is_writable(PATH_REALROOT_FS.'/config.php');

# Create config for /html
if (is_dir(PATH_REALROOT_FS.'/html') && PATH_PAGES_HTML_FS == PATH_MAIN_FS.'/html') {
	if ($configWritable) {
		$configFile = new CMS_file(PATH_REALROOT_FS.'/config.php');
		if ($configFile->exists()) {
			$configContent = $configFile->getContent();
			if (strpos($configContent, 'PATH_PAGES_HTML_WR') === false) {
				$configContent = str_replace('?>', '//HTML pages dir (DO NOT CHANGE)'."\n".'define("PATH_PAGES_HTML_WR", "'.PATH_REALROOT_WR.'/html");'."\n".'?>' , $configContent);
				$configFile->setContent($configContent);
				$configFile->writeToPersistence();
				$actionsDone .= '- Add HTML directory constant PATH_PAGES_HTML_WR in config.php file <br/>';
			}
		}
	} else {
		$actionsTodo .= '- Add the following config in config.php file <br/>';
		$actionsTodo .= 'define("PATH_PAGES_HTML_WR", "'.PATH_REALROOT_WR.'/html");<br/>';
	}
}
# Create config for /automne_modules_files
if (is_dir(PATH_REALROOT_FS.'/automne_modules_files') && PATH_MODULES_FILES_FS == PATH_REALROOT_FS.'/files') {
	if ($configWritable) {
		$configFile = new CMS_file(PATH_REALROOT_FS.'/config.php');
		if ($configFile->exists()) {
			$configContent = $configFile->getContent();
			if (strpos($configContent, 'PATH_MODULES_FILES_WR') === false) {
				$configContent = str_replace('?>', '//Modules files dir (DO NOT CHANGE)'."\n".'define("PATH_MODULES_FILES_WR", "'.PATH_REALROOT_WR.'/automne_modules_files");'."\n".'?>' , $configContent);
				$configFile->setContent($configContent);
				$configFile->writeToPersistence();
				$actionsDone .= '- Add modules files directory constant PATH_MODULES_FILES_WR in config.php file <br/>';
			}
		}
	} else {
		$actionsTodo .= '- Add the following config in config.php file <br/>';
		$actionsTodo .= 'define("PATH_MODULES_FILES_WR", "'.PATH_REALROOT_WR.'/automne_modules_files");<br/>';
	}
}
if ($actionsTodo) {
	$content .= '<fieldset style="padding:3px;margin:3px;"><legend>/!\ Warning : Remaining actions to be done manually to complete update :</legend>'.$actionsTodo.'</fieldset><br />';
}
if ($actionsDone) {
	$content .= '<fieldset style="padding:3px;margin:3px;"><legend>Update actions done :</legend>'.$actionsDone.'</fieldset><br />';
}
$content .= 'Directories successfuly updated.<br/><br/>';
//END UPDATE FROM 4.0.2 TO 4.1.0

//START UPDATE FROM 4.1.1 TO 4.1.2
# Change structure of website table to add 403 and 404 data
$sql = "show columns from websites";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "403_web") {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v411-to-v412.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v411-to-v412.sql',false);
		$content .= 'Database successfuly updated (website 403 and 404)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v411-to-v412.sql must be executed manualy<br/>';
	}
}
#change field password_pru to use a longer field size for sha1 storage
$sql = "show columns from profilesUsers";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "password_pru" && $r["Type"] == 'varchar(45)') {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v411-to-v412-2.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v411-to-v412-2.sql',false);
		$content .= 'Database successfuly updated (sha1 password storage)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v411-to-v412-2.sql must be executed manualy<br/>';
	}
}
#change field language_mcl of modulesCategories_i18nm to use a longer field size for 5 characters language code storage
$sql = "show columns from modulesCategories_i18nm";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "language_mcl" && $r["Type"] == 'char(5)') {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v411-to-v412-3.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v411-to-v412-3.sql',false);
		$content .= 'Database successfuly updated (handle language codes of 5 characters)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v411-to-v412-3.sql must be executed manualy<br/>';
	}
}

#remove field http_user_agent_ses of sessions table
$sql = "show columns from sessions";
$q = new CMS_query($sql);
$installed = true;
while($r = $q->getArray()) {
	if ($r["Field"] == "http_user_agent_ses") {
		$installed = false;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v411-to-v412-4.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v411-to-v412-4.sql',false);
		$content .= 'Database successfuly updated (remove user agent check in session management)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v411-to-v412-4.sql must be executed manualy<br/>';
	}
}
//END UPDATE FROM 4.1.1 TO 4.1.2

//START UPDATE FROM 4.1.2 TO 4.1.3
# Change structure of actionsTimestamps table to add module data
$sql = "show columns from actionsTimestamps";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "module_at") {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v412-to-v413.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v412-to-v413.sql',false);
		$content .= 'Database successfuly updated (actionsTimestamps)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v412-to-v413.sql must be executed manualy<br/>';
	}
}
//END UPDATE FROM 4.1.2 TO 4.1.3

//START UPDATE FROM 4.1.3 TO 4.2.0
# Change structure of profilesUsers and profilesUsersGroups table to drop ldap fields
$sql = "show columns from profilesUsers";
$q = new CMS_query($sql);
$installed = true;
while($r = $q->getArray()) {
	if ($r["Field"] == "dn_pru") {
		$installed = false;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420.sql',false);
		$content .= 'Database successfuly updated (drop ldap fields)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v413-to-v420.sql must be executed manualy<br/>';
	}
}
#change page codename to use a longer field size
$sql = "show columns from pagesBaseData_edited";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "codename_pbd" && $r["Type"] == 'varchar(100)') {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-2.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-2.sql',false);
		$content .= 'Database successfuly updated (page codename update)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v413-to-v420-2.sql must be executed manualy<br/>';
	}
}
#add polymod tmp table
$sql = "SHOW TABLE STATUS";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r['Name'] == "mod_object_search_tmp" && $r['Engine'] == 'MEMORY') {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-3.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-3.sql',false);
		$content .= 'Database successfuly updated (polymod tmp table update)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v413-to-v420-3.sql must be executed manualy<br/>';
	}
}
#add multilanguage polymod status
$sql = "show columns from mod_object_definition";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "multilanguage_mod") {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-4.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-4.sql',false);
		$content .= 'Database successfuly updated (polymod multilanguage update)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v413-to-v420-4.sql must be executed manualy<br/>';
	}
}
#refactor modulesCategories_clearances
$sql = "show columns from modulesCategories_clearances";
$q = new CMS_query($sql);
$installed = true;
while($r = $q->getArray()) {
	if ($r["Field"] == "id_mcc") {
		$installed = false;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-5.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-5.sql',false);
		$content .= 'Database successfuly updated (refactor modules categories clearances)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v413-to-v420-5.sql must be executed manualy<br/>';
	}
}
#add type to raws datas tables to manage link block
$sql = "show columns from blocksRawDatas_edited";
$q = new CMS_query($sql);
$installed = false;
while($r = $q->getArray()) {
	if ($r["Field"] == "type") {
		$installed = true;
	}
}
if (!$installed) {
	if (CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-6.sql',true)) {
		CMS_patch::executeSqlScript(PATH_MAIN_FS.'/sql/updates/v413-to-v420-6.sql',false);
		$content .= 'Database successfuly updated (add link block)<br/>';
	} else {
		$content .= 'Error during database update ! Script '.PATH_MAIN_FS.'/sql/updates/v413-to-v420-6.sql must be executed manualy<br/>';
	}
}
//END UPDATE FROM 4.1.3 TO 4.2.0

//Update Automne messages
$files = glob(PATH_MAIN_FS."/sql/messages/*/*.sql", GLOB_NOSORT);
if (is_array($files)) {
	$content .= "Start update of Automne messages ...<br />";
	foreach($files as $file) {
		if (file_exists($file) && CMS_patch::executeSqlScript($file, true)) {
			CMS_patch::executeSqlScript($file);
		} else {
			$content .= 'Error during database update ! Script '.$file.' must be executed manualy<br/>';
		}
	}
	$content .= "Automne messages updated.<br /><br />";
}

//clear caches
$content .= "Clean Automne cache.<br /><br />";
CMS_cache::clearTypeCache('polymod');
CMS_cache::clearTypeCache('atm-polymod-structure');
CMS_cache::clearTypeCache('text/javascript');
CMS_cache::clearTypeCache('text/css');
CMS_cache::clearTypeCache('atm-backtrace');

//compile polymod definitions
CMS_polymod::compileDefinitions();
$content .= "Objects definitions recompilations is done.<br />";

//regenerate pages
$content .= "<br />Launch pages regeneration.";
CMS_tree::regenerateAllPages(true);
$content .= '</pre>';

if (!$included) {
	$view->setContent($content);
	$view->show();
} else {
	echo $content;
}
?>