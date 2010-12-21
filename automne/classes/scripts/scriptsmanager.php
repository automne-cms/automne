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
// $Id: scriptsmanager.php,v 1.5 2010/03/08 16:43:32 sebastien Exp $

/**
  * Class CMS_scriptsManager
  *
  * Manages Automne scriptsp
  *
  * @package Automne
  * @subpackage scripts
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_scriptsManager
{
	/**
	  * Add / replace a script to process to the queue.
	  *
	  * @param string $module : the module codename in charge of the script process
	  * @param array $parameters : The script parameters
	  * @param integer $id : The script id to replace (default : false, add a new script)
	  * @return void
	  * @access public
	  * @static
	  */
	static function addScript($module, $parameters, $id=false) {
		if ($module && is_array($parameters) && $parameters) {
			$sqlFields = "
				module_reg='".sensitiveIO::sanitizeSQLString($module)."',
				parameters_reg='".sensitiveIO::sanitizeSQLString(serialize($parameters))."'";
			if (sensitiveIO::isPositiveInteger($id)) {
				$sql = "
					update
						regenerator
					set
						".$sqlFields."
					where
						id_reg='".$id."'";
			} else {
				$sql = "
					insert into
						regenerator
					set
						".$sqlFields;
			}
			$q = new CMS_query($sql);
			//$q->executePreparedQuery($sql, $sqlParameters);
			return true;
		}
		return false;
	}
	
	/**
	  * Get all scripts infos in queue.
	  *
	  * @param string $module : the module codename to get scripts (default : false, all scripts)
	  * @return array(scriptID => array parameters)
	  * @access public
	  * @static
	  */
	static function getScripts($module=false) {
		$sql = "
			select
				*
			from
				regenerator";
		if ($module) {
			$sql .= " where
				module_reg='".sensitiveIO::sanitizeSQLString($module)."'";
		}
		$q = new CMS_query($sql);
		$scripts = array();
		while ($data = $q->getArray()) {
			$scripts[$data['id_reg']] = unserialize($data['parameters_reg']);
		}
		return $scripts;
	}
	
	/**
	  * Start the scripts process queue.
	  * Remove the lock file then relaunch the script if force is true
	  *
	  * @param boolean $force Set to true if you wish to remove the lock file before launch
	  * @return void
	  * @access public
	  * @static
	  */
	static function startScript($force = false)
	{
		if (USE_BACKGROUND_REGENERATOR) {
			$forceRestart = '';
			if ($force) {
				$forceRestart = ' -F';
			} elseif (processManager::hasRunningScript()) {
				return false;
			}
			//test if we're on windows or linux, for the output redirection
			if (APPLICATION_IS_WINDOWS) {
				if (realpath(PATH_PHP_CLI_WINDOWS) === false) {
					CMS_grandFather::raiseError("Unknown CLI location : ".PATH_PHP_CLI_WINDOWS.", please check your configuration.");
					return false;
				}
				// Create the BAT file
				$command ="@echo off"."\r\n"."start /LOW ".realpath(PATH_PHP_CLI_WINDOWS)." " .realpath(PATH_PACKAGES_FS . '\scripts\script.php').' -m '.REGENERATION_THREADS.$forceRestart;
				$replace = array(
					'program files' => 'progra~1',
					'documents and settings' => 'docume~1',
				);
				$command = str_ireplace(array_keys($replace), $replace, $command);
				if (!@touch (PATH_WINDOWS_BIN_FS."/script.bat")) {
					CMS_grandFather::_raiseError("CMS_scriptsManager : startScript : Create file error : ".PATH_WINDOWS_BIN_FS."/script.bat");
					return false;
				}
				$fh = @fopen( PATH_WINDOWS_BIN_FS."/script.bat", "wb" );
				if (is_resource($fh)) {
					if (!@fwrite($fh, $command,io::strlen($command))) {
						CMS_grandFather::raiseError("Save file error : script.bat");
					}
					@fclose($fh);
				}
				$sys = realpath(PATH_WINDOWS_BIN_FS) . "\bgrun.exe ".realpath(PATH_WINDOWS_BIN_FS) . '\script.bat';
				$sys = str_ireplace(array_keys($replace), $replace, $sys);
				$log = @system($sys);
			} else {
				$error = '';
				if (!defined('PATH_PHP_CLI_UNIX') || !PATH_PHP_CLI_UNIX) {
					$return = CMS_patch::executeCommand('which php 2>&1',$error);
					if ($error) {
						CMS_grandFather::raiseError('Error when finding php CLI with command "which php", please check your configuration : '.$error);
						return false;
					}
					if (io::substr($return,0,1) != '/') {
						CMS_grandFather::raiseError('Can\'t find php CLI with command "which php", please check your configuration.');
						return false;
					}
					$return = CMS_patch::executeCommand("cd ".PATH_REALROOT_FS."; php ".PATH_PACKAGES_FS."/scripts/script.php -m ".REGENERATION_THREADS.$forceRestart." > /dev/null 2>&1 &",$error);
					if ($error) {
						CMS_grandFather::raiseError('Error during execution of script command (cd '.PATH_REALROOT_FS.'; php '.PATH_PACKAGES_FS.'/scripts/script.php -m '.REGENERATION_THREADS.$forceRestart.'), please check your configuration : '.$error);
						return false;
					}
				} else {
					$return = CMS_patch::executeCommand(PATH_PHP_CLI_UNIX.' -v 2>&1',$error);
					if ($error) {
						CMS_grandFather::raiseError('Error when testing php CLI with command "'.PATH_PHP_CLI_UNIX.' -v", please check your configuration : '.$error);
						return false;
					}
					if (io::strpos(io::strtolower($return), '(cli)') === false) {
						CMS_grandFather::raiseError(PATH_PHP_CLI_UNIX.' is not the CLI version');
						return false;
					}
					$return = CMS_patch::executeCommand("cd ".PATH_REALROOT_FS."; ".PATH_PHP_CLI_UNIX." ".PATH_PACKAGES_FS."/scripts/script.php -m ".REGENERATION_THREADS.$forceRestart." > /dev/null 2>&1 &",$error);
					if ($error) {
						CMS_grandFather::raiseError('Error during execution of script command (cd '.PATH_REALROOT_FS.'; '.PATH_PHP_CLI_UNIX.' '.PATH_PACKAGES_FS.'/scripts/script.php -m '.REGENERATION_THREADS.$forceRestart.'), please check your configuration : '.$error);
						return false;
					}
				}
				//pr($return,true);
				//pr("cd ".PATH_REALROOT_FS."; php ".PATH_PACKAGES_FS."/scripts/script.php -m ".REGENERATION_THREADS.$forceRestart." > /dev/null 2>&1 &");
				//@system("cd ".PATH_REALROOT_FS."; php ".PATH_PACKAGES_FS."/scripts/script.php -m ".REGENERATION_THREADS.$forceRestart." > /dev/null 2>&1 &");
			}
		} else {
			$_SESSION["cms_context"]->setSessionVar('start_script',true);
		}
	}
	
	/**
	  * Delete all pending scripts
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	static function clearScripts()
	{
		$sql = "
			delete
			from
				regenerator
		";
		$q = new CMS_query($sql);
		return true;
	}
	
	/**
	  * Get the number of scripts left. It's a snapshot, it changes often (hopefully)
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	static function getScriptsNumberLeft()
	{
		$sql = "
			select
				count(id_reg) as nb
			from
				regenerator
		";
		$q = new CMS_query($sql);
		return $q->getValue("nb");
	}
	
	/**
	  * Get the scripts left to regen. It's a snapshot, it changes often (hopefully)
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	static function getScriptsLeft()
	{
		$sql = "
			select
				*
			from
				regenerator
			order by id_reg asc
		";
		$q = new CMS_query($sql);
		$scripts = array();
		$modules = array();
		while ($data = $q->getArray()) {
			//instanciate module if not exists
			if (!isset($modules[$data['module_reg']])) {
				$modules[$data['module_reg']] = CMS_modulesCatalog::getByCodename($data['module_reg']);
			}
			$scripts[$data['id_reg']] = $modules[$data['module_reg']]->scriptInfo(unserialize($data['parameters_reg']));
		}
		return $scripts;
	}
	
	/**
	  * Run queued scripts.
	  * This method is used when background scripts are not used.
	  * It process a number of scripts defined by REGENERATION_THREADS constant
	  *
	  * @return void
	  * @access public
	  * @static
	  */
	static function runQueuedScripts() {
		//the sql which selects scripts to regenerate at a time
		$sql_select = "
			select
				*
			from
				regenerator
			limit
				".sensitiveIO::sanitizeSQLString(REGENERATION_THREADS)."
		";
		$q = new CMS_query($sql_select);
		$modules = array();
		while($data = $q->getArray()) {
			//instanciate script module
			if (!isset($modules[$data['module_reg']])) {
				$modules[$data['module_reg']] = CMS_modulesCatalog::getByCodename($data['module_reg']);
			}
			//then send script task to module (return task title by reference)
			$task = $modules[$data['module_reg']]->scriptTask(unserialize($data['parameters_reg']));
			
			//delete the current script task
			$sql_delete = "
				delete
				from
					regenerator
				where
					id_reg='".$data['id_reg']."'";
			$q_delete = new CMS_query($sql_delete);
		}
	}
}
?>