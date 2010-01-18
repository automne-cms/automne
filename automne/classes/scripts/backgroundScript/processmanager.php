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
// | Author: Antoine Pouch <antoine.pouch@ws-interactive.fr> &            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: processmanager.php,v 1.4 2010/01/18 15:30:54 sebastien Exp $

/**
  * background script process manager.
  *
  * Initializes the script, creates the PID file, and deletes it
  *
  * @package CMS
  * @subpackage backgrounScripts
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class processManager
{
	const MASTER_SCRIPT_NAME = 'Script Master';
	
	/**
	  * Contains the script name
	  * @var string
	  * @access private
	  */
	var $_scriptName;

	/**
	  * The tmp path : where to store 'PID' files ?
	  * @var string
	  * @access private
	  */
	var $_tmpPath;

	/**
	  * The launch date : can be used to know what is the time after launch
	  * @var timestamp
	  * @access private
	  */
	var $_startDate;
	
	/**
	  * Constructor.
	  * Check to see if the script in argument has already a process running.
	  *
	  * @param string $scriptName The name of the script to manage
	  * @return void
	  * @access public
	  */
	function processManager($scriptName)
	{
		if (!$scriptName) {
			return;
		}
		
		//captures the launch date
		$this->_startDate = getmicrotime();
		
		//computes the directory to put files in
		$this->_tmpPath = $this->getTempPath();
		
		//script name and PID File name
		$this->_scriptName = $scriptName;
	}
	
	/**
	  * Set the script informations.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setParameters($module, $parameters) {
		if (!$this->_scriptName) {
			return false;
		}
		$sql="
			update
				scriptsStatuses
			set
				module_ss='".sensitiveIO::sanitizeSQLString($module)."',
				parameters_ss='".sensitiveIO::sanitizeSQLString($parameters)."'
			where
				scriptName_ss='".$this->_scriptName."'";
		$q = new CMS_query($sql);
		return true;
	}
	
	/**
	  * Write the PID file. If it already exists, do nothing and return false
	  *
	  * @return boolean true if creation went well, false otherwise
	  * @access public
	  */
	function writePIDFile()
	{
		if (!$this->_scriptName) {
			return false;
		}
		
		$file = $this->getPIDFilePath();
		
		if (APPLICATION_IS_WINDOWS) {
			@clearstatcache();
		}
		
		if (is_file($file)) {
			//file exists, which means the script already runs
			return false;
		} else {
			//file doesn't exists, let's try to create it
			$return = (@touch($file) && @chmod($file, octdec(FILES_CHMOD)));
			if ($return) {
				$f = @fopen($file, 'a');
				@fwrite($f, 'echo PID file: '.$this->_scriptName);
				@fclose($f);
				$sql="
					insert into
						scriptsStatuses
					set
						scriptName_ss='".$this->_scriptName."',
						launchDate_ss=NOW(),
						pidFileName_ss='".$file."'
					";
				$q_script = new CMS_query($sql);
			} else {
				echo "processManager::writePIDFile: Can't write PID file:".$file."\n";
				return false;
			}
			return $return;
		}
	}
	
	/**
	  * Deletes the PID file.
	  *
	  * @return boolean true if deletion went well, false otherwise
	  * @access public
	  */
	function deletePIDFile()
	{
		if (!$this->_scriptName) {
			return true;
		}
		$return = true;
		
		if (@is_file($this->getPIDFilePath())) {
			$return = @unlink($this->getPIDFilePath());
		}
		
		if ($return) {
			$sql="
				delete from
					scriptsStatuses
				where
					scriptName_ss='".$this->_scriptName."'
				";
			$q_script=new CMS_query($sql);
			if (preg_match('#Master#i',$this->_scriptName)) {
				$sql="
					delete from
						scriptsStatuses
					where
						scriptName_ss like '".str_replace('_Master','',$this->_scriptName)."%'
					";
				$q_script=new CMS_query($sql);
			}
		} else {
			echo "processManager::deletePIDFile: Can't delete PID file: ".$unlink."\n";
		}
		
		return $return;
	}
	
	/**
	  * Returns the PID file path.
	  *
	  * @return string
	  * @access public
	  */
	function getPIDFilePath()
	{
		if (!$this->_scriptName) {
			return false;
		}
		return $this->_tmpPath.'/'.$this->_scriptName;
	}
	
	/**
	  * Returns the PID file name.
	  *
	  * @return string
	  * @access public
	  */
	function getPIDFileName()
	{
		if (!$this->_scriptName) {
			return false;
		}
		return $this->_scriptName;
	}
	
	/**
	  * Returns the temp path for PID files.
	  *
	  * @return string
	  * @access public
	  */
	function getTempPath()
	{
		if ($this->_tmpPath) {
			return $this->_tmpPath;
		} else {
			$path = CMS_file::getTmpPath();
			return (io::substr($path, -1,1) == '/') ? io::substr($path, 0, -1) : $path;
		}
	}
	
	/**
	  * Returns the number of seconds since the start of the script
	  *
	  * @return integer
	  * @access public
	  */
	function getExecutionTime()
	{
		return getmicrotime() - $this->_startDate;
	}
	
	/**
	  * select all running scripts from scriptsStatuses Table and check PID files.
	  *
	  * @return array
	  * @access public
	  */
	function getRunningScript()
	{
		//check temporary dir for orchan PID files
		//get temporary path
		$tempPath = CMS_file::getTmpPath();
		
		//computes the directory to put files in
		$tempDir = @dir($tempPath);
		
		//script application label
		$scriptAppLbl = processManager::getAppCode();
		
		//Automatic list of directory content
		//Displayed in alphabetical order (noted on Windows platforms)
		$PIDFiles=array();
		while (false !== ($file = $tempDir->read())) {
			if (stripos($file, $scriptAppLbl) !== false && io::strpos($file, ".ok") === false) {
				$PIDFiles[]= $file;
			}
		}
		//check the table
		$sql = "
			select
				*
			from
				scriptsStatuses
			order by launchDate_ss
			";
		$q = new CMS_query($sql);
		
		$scripts=array();
		$modules = array();
		while ($data = $q->getArray()) {
			$PIDFileStatus=0;
			if (array_search($data["scriptName_ss"],$PIDFiles) !== false) {
				$process = new processManager($data["scriptName_ss"]);
				if (@is_file($process->getPIDFilePath().".ok")) {
					$PIDFileStatus=3;
				} else {
					$PIDFileStatus=1;
				}
				$key = array_search($data["scriptName_ss"],$PIDFiles);
				unset($PIDFiles[$key]);
			}
			$scriptTitle = '';
			//instanciate module if not exists
			if (isset($data['module_ss']) && $data['module_ss'] != self::MASTER_SCRIPT_NAME) {
				if (!isset($modules[$data['module_ss']])) {
					$modules[$data['module_ss']] = CMS_modulesCatalog::getByCodename($data['module_ss']);
				}
				$scriptTitle = $modules[$data['module_ss']]->scriptInfo(unserialize($data['parameters_ss']));
			} elseif ($data['module_ss'] == self::MASTER_SCRIPT_NAME) {
				$scriptTitle = self::MASTER_SCRIPT_NAME;
			} else {
				$scriptTitle = 'Error : script module not set';
			}
			$script = array("Title"		=> $scriptTitle,
							"Date"		=> $data["launchDate_ss"],
							"PIDFile"	=> $PIDFileStatus);
			$scripts[] = $script;
		}
		//add orphan PIDFiles to the report
		foreach ($PIDFiles as $anOrphanPIDFile) {
			$script = array("Title"		=> str_replace('_',' ',str_replace('bgscript_','',$anOrphanPIDFile)),
							"Date"		=> '',
							"PIDFile"	=> '2');
			$scripts[] = $script;
		}
		return $scripts;
	}
	
	/**
	  * check if scripts are currently running
	  *
	  * @return boolean
	  * @access public
	  */
	function hasRunningScript()
	{
	    //check the table
	    $sql = "
	        select
	        	1
	        from
	        	scriptsStatuses
	        where
	        	module_ss = '".self::MASTER_SCRIPT_NAME."'
	        ";
	    $q = new CMS_query($sql);
	    return ($q->getNumRows()) ? true : false;
	}
	
	/**
	  * get sanitized application codename
	  *
	  * @return string the sanitized codename
	  * @access public
	  */
	function getAppCode() {
		$sanitized = strtr(APPLICATION_LABEL, " àâäéèëêïîöôùüû", "_aaaeeeeiioouuu");
		$sanitized = preg_replace("#[^[a-zA-Z0-9_.-]]*#", "", $sanitized);
		return $sanitized;
	}
}
?>