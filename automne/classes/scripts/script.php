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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * background script : regenerator
  *
  * Regenerates pages stored in the 'regenerator' table
  *
  * @package Automne
  * @subpackage scripts
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

//must calculate the document root first (for compatibility with old scripts)
$_SERVER["DOCUMENT_ROOT"] = realpath(substr(dirname(__FILE__), 0, strlen(dirname(__FILE__)) - strpos(strrev(dirname(__FILE__)), "enmotua") - strlen("automne") - 1));

//include required file
require_once(dirname(__FILE__).'/../../../cms_rc_admin.php');

/**
  * Script codename
  */
//clean the application label
$appCode = processManager::getAppCode();
define("SCRIPT_CODENAME", "bgscript_" . $appCode . "_regenerator");

//time out in second for scripts
if (!defined('SUB_SCRIPT_TIME_OUT')) {
	define("SUB_SCRIPT_TIME_OUT", 300); //5 minutes
}
if (!defined('MASTER_SCRIPT_TIME_OUT')) {
	define("MASTER_SCRIPT_TIME_OUT", 43200); //12 hours
}
//duration in seconds between each cycles of checking of sub-scripts
if (!defined('SLEEP_TIME')) {
	define("SLEEP_TIME", 1);
}

//for script debug - verbose in cms_error_log
if (!defined('SCRIPT_DEBUG')) {
	define("SCRIPT_DEBUG", false);
}

class automne_script extends backgroundScript
{
	/**
	  * activates the script function.
	  *
	  * @return void
	  * @access public
	  */
	function activate()
	{
		parent::activate();
		
		if ($_SERVER['argv']['1']=='-s' && SensitiveIO::isPositiveInteger($_SERVER['argv']['2'])) {
			// SUB-SCRIPT : Processes one script task
			@ini_set('max_execution_time', SUB_SCRIPT_TIME_OUT); //set max execution time for sub script
			@set_time_limit(SUB_SCRIPT_TIME_OUT); //set the PHP timeout for sub script
			
			$sql = "
				select
					*
				from
					regenerator
				where
					id_reg = '".$_SERVER['argv']['2']."'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				//send script informations to process manager
				$this->_processManager->setParameters($data['module_reg'], $data['parameters_reg']);
				//instanciate script module
				$module = CMS_modulesCatalog::getByCodename($data['module_reg']);
				//then send script task to module (return task title by reference)
				$task = $module->scriptTask(unserialize($data['parameters_reg']));
				
				//delete the current script task
				$sql_delete = "
					delete
					from
						regenerator
					where
						id_reg='".$data['id_reg']."'";
				$q = new CMS_query($sql_delete);
				
				if ($this->_debug) {
					$this->raiseError($this->_processManager->getPIDFilePath()." : task ".$_SERVER['argv']['2']." seems ".((!$task) ? 'NOT ':'')."done !");
					$this->raiseError($this->_processManager->getPIDFilePath()." : PID file exists ? ".(@file_exists($this->_processManager->getPIDFilePath())));
				}
				$fpath = $this->_processManager->getPIDFilePath().'.ok';
				if (@touch($fpath) && @chmod($fpath, octdec(FILES_CHMOD))) {
					$f = @fopen($fpath, 'a');
					if (!@fwrite($f, 'Script OK')) {
						$this->raiseError($this->_processManager->getPIDFilePath()." : Can't write into file: ".$fpath);
					}
					@fclose($f);
				} else {
					$this->raiseError($this->_processManager->getPIDFilePath()." : Can't create file: ".$fpath);
				}
			}
		} else {
			// MASTER SCRIPT : Processes all sub-scripts
			@ini_set('max_execution_time', MASTER_SCRIPT_TIME_OUT); //set max execution time for master script
			@set_time_limit(MASTER_SCRIPT_TIME_OUT); //set the PHP timeout  for master script
			
			//max simultaneous scripts
			$maxScripts = $_SERVER['argv']['2'];
			$scriptsArray = array();
			
			//send script informations to process manager
			$this->_processManager->setParameters(processManager::MASTER_SCRIPT_NAME, '');
			
			//the sql script which selects one script task at a time
			$sql_select = "
				select
					*
				from
					regenerator
				limit
					".$maxScripts."
			";
			//and now, launch all sub-scripts until table is empty.
			while (true) {
				//get scripts
				$q = new CMS_query($sql_select);
				if ($q->getNumRows()) {
					while (count($scriptsArray) < $maxScripts && $data = $q->getArray()) {
						// Launch sub-process
						if (!APPLICATION_IS_WINDOWS) {
							// On unix system
							$sub_system = PATH_PACKAGES_FS."/scripts/script.php -s ".$data["id_reg"]." > /dev/null 2>&1 &";
							if (!defined('PATH_PHP_CLI_UNIX') || !PATH_PHP_CLI_UNIX) {
								CMS_patch::executeCommand("cd ".PATH_REALROOT_FS."; php ".$sub_system, $error);
								if ($error) {
									CMS_grandFather::raiseError('Error during execution of sub script command (cd '.PATH_REALROOT_FS.'; php '.$sub_system.'), please check your configuration : '.$error);
									return false;
								}
							} else {
								CMS_patch::executeCommand("cd ".PATH_REALROOT_FS."; ".PATH_PHP_CLI_UNIX." ".$sub_system, $error);
								if ($error) {
									CMS_grandFather::raiseError('Error during execution of sub script command (cd '.PATH_REALROOT_FS.'; '.PATH_PHP_CLI_UNIX.' '.$sub_system.'), please check your configuration : '.$error);
									return false;
								}
							}
							$PIDfile = $this->_processManager->getTempPath()."/" . SCRIPT_CODENAME . "_" . $data["id_reg"];
							if ($this->_debug) {
								$this->raiseError(processManager::MASTER_SCRIPT_NAME." : Executes system(".$sub_system.")");
							}
							//sleep a little 
							@sleep(SLEEP_TIME);
						} else {
							// On windows system
							//Create the BAT file
							$command = '@echo off'."\r\n".'@start /B /BELOWNORMAL '.realpath(PATH_PHP_CLI_WINDOWS). ' ' . realpath(PATH_PACKAGES_FS . '\scripts\script.php').' -s '.$data["id_reg"];
							if (!@touch(PATH_WINDOWS_BIN_FS."/sub_script.bat")) {
								$this->raiseError(processManager::MASTER_SCRIPT_NAME." : Create file error : sub_script.bat");
							}
							
							$replace = array(
								'program files (x86)' 		=> 'progra~2',
								'program files' 			=> 'progra~1',
								'documents and settings'	=> 'docume~1',
							);
							$command = str_ireplace(array_keys($replace), $replace, $command);
							
							$fh = fopen( PATH_WINDOWS_BIN_FS."/sub_script.bat", "wb" );
							if (is_resource($fh)) {
								if (!fwrite($fh, $command,io::strlen($command))) {
									CMS_grandFather::raiseError(processManager::MASTER_SCRIPT_NAME." : Save file error : sub_script.bat");
								}
								fclose($fh);
							}
							
							$WshShell = new COM("WScript.Shell");
							$oExec = $WshShell->Run(str_ireplace(array_keys($replace), $replace, realpath(PATH_WINDOWS_BIN_FS . '\sub_script.bat')), 0, false);
							
							$PIDfile = $this->_processManager->getTempPath().'/'.SCRIPT_CODENAME . "_" . $data["id_reg"];
							//sleep a little 
							@sleep(SLEEP_TIME);
						}
						if ($this->_debug) {
							$this->raiseError(processManager::MASTER_SCRIPT_NAME." : script : ".$data["id_reg"]." - sub_system : ".$sub_system);
						}
						$scriptsArray[] = array(
									"PID" 			=> $PIDfile,
									"startTime" 	=> CMS_stats::getmicrotime(),
									"scriptID" 		=> $data["id_reg"],
									"scriptDatas"	=> $data);
					}
				} else {
					// no more scripts to process
					// > delete all temporary files
					// > end script
					if (APPLICATION_IS_WINDOWS) {
						$files = glob(realpath($this->_processManager->getTempPath()).'/'.SCRIPT_CODENAME.'*.ok', GLOB_NOSORT);
						if (is_array($files)) {
							foreach($files as $file) {
								if (!CMS_file::deleteFile($file)) {
									$this->raiseError("Can't delete file ".$file);
									return false;
								}
							}
						}
					} else {
						$tmpDir = dir($this->_processManager->getTempPath());
						while (false !== ($file = $tmpDir->read())) {
							if (io::strpos($file, SCRIPT_CODENAME) !== false) {
								@unlink($this->_processManager->getTempPath().'/'.$file);
							}
						}
					}
					break;
				}
				while (true) {
					@sleep(SLEEP_TIME); //wait a little to check sub_scripts
					$break = false;
					$timeStop = CMS_stats::getmicrotime();
					if ($this->_debug) {
						$this->raiseError(processManager::MASTER_SCRIPT_NAME." Scripts in progress : ".sizeof($scriptsArray));
					}
					foreach ($scriptsArray as $nb => $aScript) {
						if ($this->_debug) {
							$this->raiseError(processManager::MASTER_SCRIPT_NAME." PID : ".$aScript["PID"]." - time : ".($timeStop-$aScript["startTime"]));
						}
						$ok = '';
						$ok = is_file($aScript["PID"].'.ok');
						if ($ok) {
							//$break = true;
							if ($this->_debug) {
								$this->raiseError(processManager::MASTER_SCRIPT_NAME." Script : ".$aScript["PID"]." OK !");
							}
							unset($scriptsArray[$nb]);
						} elseif(($timeStop - $aScript["startTime"]) >= SUB_SCRIPT_TIME_OUT) {
							if ($this->_debug) {
								$this->raiseError(processManager::MASTER_SCRIPT_NAME." : Script : ".$aScript["PID"]." NOT OK !");
							}
							$this->raiseError(processManager::MASTER_SCRIPT_NAME.' : Error on task : '.$aScript["scriptID"].' ... skip it. Task parameters : '.print_r($aScript['scriptDatas'], true));
							//$break = true;
							unset($scriptsArray[$nb]);
							
							//delete the script in error from task list
							$q_del = "
								delete
								from
									regenerator
								where
									id_reg='".$aScript["scriptID"]."'";
							$q_del = new CMS_query($q_del);
						}
					}
					if (!$scriptsArray) {
						break;
					}
				}
			}
		}
	}
}
if (isset($_SERVER['argv']['1']) && $_SERVER['argv']['1']=='-s' && isset($_SERVER['argv']['2']) && SensitiveIO::isPositiveInteger($_SERVER['argv']['2'])) {
	$script = new automne_script(SCRIPT_DEBUG,$_SERVER['argv']['2']);
} elseif (isset($_SERVER['argv']['1']) && $_SERVER['argv']['1']=='-m' && isset($_SERVER['argv']['2']) && SensitiveIO::isPositiveInteger($_SERVER['argv']['2']) && $_SERVER['argv']['2'] <= 10) {
	$script = new automne_script(SCRIPT_DEBUG);
} else {
	echo 
	'Automne script - Missing parameters...'."\n\n".
	'Usage:'."\n".
	'-s <script task DB ID>              For one script task only'."\n".
	'-m <number of sub scripts (1 - 10)> For master script'."\n".
	'[-F]                                Force script launch'."\n\n".
	'Note:'."\n".
	'-m use the MySQL regenerator table to process all scripts in queue (launch Master Script)'."\n".
	'-F delete old PID Files, need to be the last parameter!'."\n\n".
	'Examples:'."\n".
	'script.php -s 10'."\n".
	'script.php -m 2'."\n".
	'script.php -m 5 -F';
}
?>
