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
//
// $Id: backgroundscript.php,v 1.3 2010/03/08 16:43:29 sebastien Exp $

/**
  * background script abstract class
  *
  * PHP-CLI script which runs in the background
  *
  * @package Automne
  * @subpackage backgroundScripts
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  */

class backgroundScript extends CMS_grandFather
{
	/**
	  * The process manager
	  * @var processManager
	  * @access private
	  */
	var $_processManager;

	/**
	  * Is it debug-time ?
	  * @var boolean
	  * @access private
	  */
	var $_debug;

	
	/**
	  * Constructor.
	  * Initializes the process manager and lauches the action if all went well, then delete the PIDFile
	  * NOTE : SCRIPT_CODENAME is a constant that must be defined, and unique accross all usage of the background scripts
	  * (i.e. One background script for one application should have the same, but two applications having the same script shouldn't collate)
	  *
	  * @param boolean $debug Set to true if you want a debug of what the script does
	  * @return void
	  * @access public
	  */
	function backgroundScript($debug = false, $scriptID='Master')
	{
		$this->_debug = $debug;
		
		$this->_processManager = new processManager(SCRIPT_CODENAME.'_'.$scriptID);
		
		// Cleans previous PIDs
		if (isset($_SERVER['argv']['3']) && $_SERVER['argv']['3'] == '-F') {
			if (!APPLICATION_IS_WINDOWS) {
				$tmpDir = dir($this->_processManager->getTempPath());
				while (false !== ($file = $tmpDir->read())) {
					if (io::strpos($file, SCRIPT_CODENAME) !== false) {
						@unlink($this->_processManager->getTempPath().'/'.$file);
					}
				}
			} else {
				@system("del ".$this->_processManager->getTempPath().'/'.SCRIPT_CODENAME . "*.* /Q /F");
			}
		}
		//write script process PID File
		if ($this->_processManager->writePIDFile()) {
			if ($this->_debug) {
				$this->raiseError("PID file successfully written (".$this->_processManager->getPIDFileName().").");
			}
			//start script process
			$this->activate($this->_debug);
			//delete script process PID File
			if ($this->_processManager->deletePIDFile()) {
				if ($this->_debug) {
					$this->raiseError("PID file successfully deleted (".$this->_processManager->getPIDFileName().").");
				}
			} else {
				$this->raiseError("Can not delete PID file (".$this->_processManager->getPIDFileName().").");
			}
			exit;
		} else {
			if ($this->_debug) {
				$this->raiseError("PID file already exists or impossible to write (".$this->_processManager->getPIDFileName().").");
			}
			exit;
		}
	}
	
	/**
	  * activates the script function.
	  *
	  * @return void
	  * @access public
	  */
	function activate()
	{
		if ($this->_debug) {
			CMS_grandFather::raiseError("Script Activation launched");
		}
	}
}
?>