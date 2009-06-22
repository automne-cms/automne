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
// $Id: patch.php,v 1.4 2009/06/22 14:08:41 sebastien Exp $

/**
  * Class CMS_patch
  *
  * This script aimed to manage patch files
  *
  * @package CMS
  * @subpackage files
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
  
class CMS_patch extends CMS_grandFather
{
	/**
	 * Patch $this->_report
	 * @var array
	 * @access public
	 */
	protected $_return = array();
	
	/**
	 * Constructor
	 * 
	 * @return void
	 */
	function __construct() 
	{
		//nothing
	}
	
	/**
	 * Check patch parameters
	 *
	 * @param array of parameters to check (usually : file patch), view documentation for format
	 * @return true on success, false on failure
	 * @access public
	 */
	function checkPatch($array) {
		if (is_array($array)) {
			$return = true;
			foreach ($array as $aPatchCheck) {
				$checkParams = array_map("trim",explode("\t",$aPatchCheck));
				switch ($checkParams[0]) {
					case "V:":
						$versions = array_map("trim",explode("|",$checkParams[1]));
						if (!isset($checkParams[2])) {
							$return = (in_array(AUTOMNE_VERSION,$versions)) ? $return:false;
						} elseif ($checkParams[1]=="none") {
							$return = true;
						} else {
							$versionFile = new CMS_file($checkParams[2],CMS_file::WEBROOT);
							if ($versionFile->exists()) {
								$return = (in_array(trim($patchFile->readContent("string")),$versions)) ? $return:false;
							} else {
								$this->raiseError("Version file does not exist : ".$checkParams[2]);
								return false;
							}
						}
					break;
					default:
						return false;
					break;
				}
			}
			return $return;
		} else {
			$this->raiseError("Param must be an array");
			return false;
		}
	}
	
	/**
	 * Check install parameters
	 *
	 * @param $array, install command to check, view documentation for format
	 * @param $errorsInfo array, infos on errors found in checked install commands. Returned by reference.
	 * @return string errors found in install array
	 * @access public
	 */
	function checkInstall(&$array,&$errorsInfo)
	{
		if (is_array($array)) {
			$errorsInfo = array();
			$error = '';
			foreach ($array as $line => $aInstallCheck) {
				$line++; //to have the correct line number
				
				//remove blank lines
				if (!$aInstallCheck) {
					unset($array[$line-1]);
					continue;
				}
				
				$installParams = array_map("trim",explode("\t",$aInstallCheck));
				//read UPDATE.DENY file
				$updateDenyFile = new CMS_file(UPDATE_DENY,CMS_file::WEBROOT);
				if ($updateDenyFile->exists()) {
					$updateDeny = $updateDenyFile->readContent("array");
				} else {
					$this->raiseError("File ".UPDATE_DENY." does not exist");
					return false;
				}
				//if we don't have parameter and line not a comment
				if (!isset($installParams[1]) && substr($installParams[0],0,1) != '#' && $installParams[0] != 'rc') {
					$error .= "Error at line : ".$line." missing file parameter<br />";
					$errorsInfo[] = array('no' => 1, 'line' => $line, 'command' => $aInstallCheck);
					unset($array[$line-1]);
				} else {
					//first check needed file existence
					if ($installParams[0] != 'ex') {
						$originalFile = (isset($installParams[1])) ? PATH_REALROOT_FS.$installParams[1] : PATH_REALROOT_FS;
						$patchFile = (isset($installParams[1])) ? PATH_TMP_FS.$installParams[1] : PATH_TMP_FS;
					}
					$filesExists = true;
					switch ($installParams[0]) {
						//check only patch file existence
						case "x":
						case ">":
						case "+":
							if (!file_exists($patchFile)) {
								$error .= "Error at line : ".$line.", temporary file ".$patchFile." does not exist<br />";
								$filesExists=false;
								$errorsInfo[] = array('no' => 2, 'line' => $line, 'command' => $aInstallCheck);
								unset($array[$line-1]);
							}
						break;
						//check only original file existence
						case "<":
						case "ch":
						case "co":
						case "cg":
							if (strpos($originalFile,'*')===false) {
								if (!file_exists($originalFile)) {
									$error .= "Error at line : ".$line.", file ".$originalFile." does not exist<br />";
									$errorsInfo[] = array('no' => 3, 'line' => $line, 'command' => $aInstallCheck);
									$filesExists=false;
									//in this 2 case don't unset this command if it has an error because the file needed may be created by this script
									if ($installParams[0]!='co' && $installParams[0]!='cg') {
										unset($array[$line-1]);
									}
								}
							}
						break;
					}
					if ($filesExists) {
						//then if files are ok, check installation request
						switch ($installParams[0]) {
							case ">": //add or update a file or folder
								if (in_array($installParams[1],$updateDeny) && !is_file($patchFile.'.updated')) {
									$error .= "Error at line : ".$line.", file ".$installParams[1]." is in the UPDATE.DENY list<br />";
									$errorsInfo[] = array('no' => 5, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								} else {
									if (file_exists($originalFile)) {
										//check if file is writable
										if (!CMS_FILE::makeWritable($originalFile)) {
											$error .= "Error at line : ".$line.", file ".$originalFile." is not writable<br />";
											$errorsInfo[] = array('no' => 6, 'line' => $line, 'command' => $aInstallCheck);
											unset($array[$line-1]);
										}
									} else {
										//check if parent directory is writable
										$parent = CMS_file::getParent($originalFile);
										if (!CMS_FILE::makeWritable($parent)) {
											$error .= "Error at line : ".$line.", file ".dirname($originalFile)." is not writable<br />";
											$errorsInfo[] = array('no' => 7, 'line' => $line, 'command' => $aInstallCheck);
											unset($array[$line-1]);
										}
									}
								}
								
								//check right presence and format
								if (isset($installParams[2]) && $installParams[2]) {
									if (!$this->_checkRightFormat($installParams[2])) {
										$error .= "Error at line : ".$line.", right command malformed<br />";
										$errorsInfo[] = array('no' => 8, 'line' => $line, 'command' => $aInstallCheck);
										unset($array[$line-1]);
									}
								}
							break;
							case "<": //delete a file or folder (recursively)
								if (in_array($installParams[1],$updateDeny)) {
									$error .= "Error at line : ".$line.", file ".$installParams[1]." is in the UPDATE.DENY list<br />";
									$errorsInfo[] = array('no' => 9, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								} else {
									if (file_exists($originalFile)) {
										//check if file or directory is deletable
										if (is_file($originalFile)) {
											if (!CMS_FILE::makeWritable($originalFile)) {
												$error .= "Error at line : ".$line.", file ".$originalFile." is not deletable<br />";
												$errorsInfo[] = array('no' => 10, 'line' => $line, 'command' => $aInstallCheck);
												unset($array[$line-1]);
											}
										} elseif(is_dir($originalFile)) {
											if (!CMS_FILE::deltreeSimulation($originalFile,true)) {
												$error .= "Error at line : ".$line.", directory ".$originalFile." is not deletable<br />";
												$errorsInfo[] = array('no' => 11, 'line' => $line, 'command' => $aInstallCheck);
												unset($array[$line-1]);
											}
										} else {
											$error .= "Error at line : ".$line.", what is ".$originalFile." ???<br />";
											$errorsInfo[] = array('no' => 12, 'line' => $line, 'command' => $aInstallCheck);
											unset($array[$line-1]);
										}
									} else {
										$error .= "Error at line : ".$line.", file to delete ".$originalFile." does not exist<br />";
										$errorsInfo[] = array('no' => 13, 'line' => $line, 'command' => $aInstallCheck);
										unset($array[$line-1]);
									}
								}
							break;
							case "+": //concatenate module xml file
								//check extension of source file
								if (substr($patchFile,-4,4)!='.xml') {
									$error .= "Error at line : ".$line.", XML file to append ".$patchFile." does not seem to be an XML file<br />";
									$errorsInfo[] = array('no' => 14, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								}
								
								//Check XML validity of source file
								$sourceXML = new CMS_file($patchFile);
								$domdocument = new CMS_DOMDocument();
								try {
									$domdocument->loadXML($sourceXML->readContent("string"));
								} catch (DOMException $e) {
									$error .= "Error at line : ".$line.", XML parse error on file ".$patchFile." : ". $e->getMessage()."<br />";
									$errorsInfo[] = array('no' => 15, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								}
								//check module to apply XML modifications
								if ($installParams[2]) {
									$module = CMS_modulesCatalog::getByCodename($installParams[2]);
									if ($module===false) {
										$error .= "Error at line : ".$line.", module ".$installParams[2]." does not exist<br />";
										$errorsInfo[] = array('no' => 16, 'line' => $line, 'command' => $aInstallCheck);
										unset($array[$line-1]);
										$filesExists=false;
									} elseif(!$module->hasParameters()) {
										$error .= "Error at line : ".$line.", module ".$installParams[2]." does not have parameters<br />";
										$errorsInfo[] = array('no' => 17, 'line' => $line, 'command' => $aInstallCheck);
										unset($array[$line-1]);
										$filesExists=false;
									}
								} else {
									$error .= "Error at line : ".$line.", need module codename<br />";
									$errorsInfo[] = array('no' => 18, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
									$filesExists=false;
								}
							break;
							case "x": //execute SQL or PHP file
								//only check extension for the moment
								if (substr($patchFile,-4,4)!='.sql' && substr($patchFile,-4,4)!='.php') {
									$error .= "Error at line : ".$line.", file to execute ".$patchFile." does not seem to be an SQL or PHP file<br />";
									$errorsInfo[] = array('no' => 19, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								}
								if (substr($patchFile,-4,4)=='.sql') {
									//make a simulation on the sql script
									if (!$this->executeSqlScript($patchFile,true)) {
										$error .= "Error at line : ".$line.", on ".$patchFile.", no SQL request found...";
										$errorsInfo[] = array('no' => 20, 'line' => $line, 'command' => $aInstallCheck);
										unset($array[$line-1]);
									}
								}
							break;
							case "ch": //execute chmod
								//only check right presence and format
								if (!$installParams[2]) {
									$error .= "Error at line : ".$line.", command does not have right<br />";
									$errorsInfo[] = array('no' => 21, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								} else {
									if (!$this->_checkRightFormat($installParams[2])) {
										$error .= "Error at line : ".$line.", right command malformed<br />";
										$errorsInfo[] = array('no' => 22, 'line' => $line, 'command' => $aInstallCheck);
										unset($array[$line-1]);
									}
								}
							break;
							case "co": //execute change owner
							case "cg": //execute change group
								//only check right presence
								if (!$installParams[2]) {
									$error .= "Error at line : ".$line.", command does not have right<br />";
									$errorsInfo[] = array('no' => 23, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								}
							break;
							case "rc":
								//do nothing
							break;
							case "htaccess":
								if (!$installParams[2]) {
									$error .= "Error at line : ".$line.", missing htaccess type<br />";
									$errorsInfo[] = array('no' => 26, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								} elseif (!is_file(PATH_HTACCESS_FS.'/htaccess_'.$installParams[2])) {
									$error .= "Error at line : ".$line.", unknown htaccess type : ".$installParams[2]."<br />";
									$errorsInfo[] = array('no' => 26, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								}
							break;
							default:
								if (substr($installParams[0],0,1)!='#') {
									$error .= "Error at line : ".$line.", 	unknown parameter : ".$installParams[0]."<br />";
									$errorsInfo[] = array('no' => 25, 'line' => $line, 'command' => $aInstallCheck);
									unset($array[$line-1]);
								}
							break;
						}
					}
				}
			}
			return $error;
		} else {
			$this->raiseError("Param must be an array");
			return false;
		}
	}
	
	protected function _verbose($text) {
		$this->_return[] = array('type' => 'verbose', 'error' => 0, 'text' => $text);
	}
	
	protected function _report($text, $isErrror = false) {
		$this->_return[] = array('type' => 'report', 'error' => ($isErrror) ? 1 : 0, 'text' => $text);
	}
	
	/**
	 * Do patch installation
	 *
	 * @param array of install command to do, view documentation for format
	 *  This array MUST be checked before by checkInstall method to ensure it format is as correct as possible
	 * @param array of excluded commands
	 * @return void
	 * @access public
	 */
	function doInstall(&$array,$excludeCommand=array(), $stopOnErrors = true)
	{
		if (is_array($array)) {
			foreach ($array as $line => $aInstallCheck) {
				$line++; //to have the correct line number
				$installParams = array_map("trim",explode("\t",$aInstallCheck));
				if ($installParams[0]!='ex') {
					$originalFile = (isset($installParams[1])) ? PATH_REALROOT_FS.$installParams[1] : PATH_REALROOT_FS;
					$patchFile = (isset($installParams[1])) ? PATH_TMP_FS.$installParams[1] : PATH_TMP_FS;
				}
				if (!in_array($installParams[0],$excludeCommand)) {
					//launch installation request
					switch ($installParams[0]) {
						case ">": //add or update a file or folder
							//copy file or folder
							if (CMS_FILE::copyTo($patchFile,$originalFile)) {
								$this->_verbose(' -> File '.$patchFile.' successfully copied to '.$originalFile);
							} else {
								$this->_report('Error during copy of '.$patchFile.' to '.$originalFile,true);
								if ($stopOnErrors) return;
							}
							if (!isset($installParams[2]))
								break;
						case "ch": //execute chmod
							$filesNOK = $this->applyChmod($installParams[2],$originalFile);
							if (!$filesNOK) {
								switch ($installParams[2]) {
									case 'r':
										$this->_verbose(' -> File(s) '.$originalFile.' are readable.');
									break;
									case 'w':
										$this->_verbose(' -> File(s) '.$originalFile.' are writable.');
									break;
									case 'x':
										$this->_verbose(' -> File(s) '.$originalFile.' are executable.');
									break;
									default:
										$this->_verbose(' -> File(s) '.$originalFile.' successfully chmoded with value '.$installParams[2]);
									break;
								}
							} else {
								$this->_report('Error during chmod operation of '.$originalFile.'. Can\'t apply chmod value \''.$installParams[2].'\' on files :<br />'.$filesNOK.'<br />',true);
								if ($stopOnErrors) return;
							}
						break;
						case "<": //delete a file or folder (recursively)
							if (CMS_FILE::deleteFile($originalFile)) {
								$this->_verbose(' -> File '.$originalFile.' successfully deleted');
							} else {
								$this->_report('Error during deletion of '.$originalFile,true);
								if ($stopOnErrors) return;
							}
						break;
						case "+": //concatenate module xml file
							//load destination module parameters
							$module = CMS_modulesCatalog::getByCodename($installParams[2]);
							$moduleParameters = $module->getParameters(false,true);
							
							//load the XML data of the source the files
							$sourceXML = new CMS_file($patchFile);
							$domdocument = new CMS_DOMDocument();
							try {
								$domdocument->loadXML($sourceXML->readContent("string"));
							} catch (DOMException $e) {}
							$paramsTags = $domdocument->getElementsByTagName('param');
							$sourceParameters = array();
							foreach ($paramsTags as $aTag) {
								$name = ($aTag->hasAttribute('name')) ? $aTag->getAttribute('name') : '';
								$type = ($aTag->hasAttribute('type')) ? $aTag->getAttribute('type') : '';
								$sourceParameters[$name] = array(CMS_DOMDocument::DOMElementToString($aTag, true),$type);
							}
							//merge the two tables of parameters
							$resultParameters = array_merge($sourceParameters,$moduleParameters);
							//set new parameters to the module
							if ($module->setAndWriteParameters($resultParameters)) {
								$this->_verbose(' -> File '.$patchFile.' successfully merged with module '.$installParams[2].' parameters');
							} else {
								$this->_report('Error during merging of '.$patchFile.' with module '.$installParams[2].' parameters',true);
								if ($stopOnErrors) return;
							}
						break;
						case "x": //execute SQL or PHP file
							//exec sql script with help of some phpMyAdmin classes
							if (substr($patchFile,-4,4)=='.sql') {
								if ($this->executeSqlScript($patchFile)) {
									$this->_verbose(' -> File '.$patchFile.' successfully executed');
								} else {
									$this->_report('Error during execution of '.$patchFile,true);
									if ($stopOnErrors) return;
								}
							} elseif (substr($patchFile,-4,4)=='.php') {
								//exec php script
								$executionReturn = $this->executePhpScript($patchFile);
								if ($executionReturn===false) {
									$this->_report('Error during execution of '.$patchFile,true);
									if ($stopOnErrors) return;
								} else {
									$executionReturn = ($executionReturn) ? ' -> Return :<br /><div style="border:1px;background-color:#000080;color:#C0C0C0;padding:5px;">'.$executionReturn.'</div><br />':'';
									$this->_report(' -> File '.$patchFile.' executed<br />'.$executionReturn);
								}
							}
						break;
						case "co": //execute change owner
							$filesNOK = $this->changeOwner($installParams[2],$originalFile);
							if (!$filesNOK) {
								$this->_verbose(' -> Owner of file(s) '.$originalFile.' successfully changed to '.$installParams[2]);
							} else {
								$this->_report('Error during operation on '.$originalFile.'. Can\'t change owner to \''.$installParams[2].'\' on files :<br />'.$filesNOK.'<br />',true);
								if ($stopOnErrors) return;
							}
						break;
						case "cg": //execute change group
							$filesNOK = $this->changeGroup($installParams[2],$originalFile);
							if (!$filesNOK) {
								$this->_verbose(' -> Group of file(s) '.$originalFile.' successfully changed to '.$installParams[2]);
							} else {
								$this->_report('Error during operation on '.$originalFile.'. Can\'t change group to \''.$installParams[2].'\' on files :<br />'.$filesNOK.'<br />',true);
								if ($stopOnErrors) return;
							}
						break;
						/* removed : too dangerous
						case "ex": //execute command in exec
							//exec command script
							$executionReturn = $this->executeCommand($installParams[1],$errorReturn);
							$executionReturn = ($executionReturn) ? ' -> Command return is :<br /><div style="border:1px;background-color:#000080;color:#C0C0C0;padding:5px;"><pre>'.sensitiveIO::decodeWindowsChars($executionReturn).'</pre></div><br />':'';
							if ($errorReturn!=0) {
								$this->_report('Error during execution of command \''.$installParams[1].'\'<br />Error return code is :<br />'.$errorReturn.'<br />'.$executionReturn,true);
								if ($stopOnErrors) return;
							} else {
								$this->_report(' -> Command \''.$installParams[1].'\' executed<br />'.$executionReturn);
							}
						break;
						*/
						case "rc":
							$this->automneGeneralScript();
						break;
						case "htaccess":
							$installParams[1] = (substr($installParams[1], -1) == '/') ? substr($installParams[1], 0, -1) : $installParams[1];
							foreach(glob(PATH_REALROOT_FS.$installParams[1]) as $path) {
								if (is_dir($path) && CMS_file::makeWritable($path)) {
									if (CMS_file::copyTo(PATH_HTACCESS_FS.'/htaccess_'.$installParams[2], $path.'/.htaccess')) {
										CMS_file::chmodFile(FILES_CHMOD, $path.'/.htaccess');
										$this->_report('File '.$path.'/.htaccess ('.$installParams[2].') successfully writen');
									} else {
										$this->_report('Error during operation on '.$path.'/.htaccess. Can\'t write file.<br />', true);
										if ($stopOnErrors) return;
									}
								} else {
									$this->_report('Error during operation. '.$path.' must be a writable directory.<br />',true);
									if ($stopOnErrors) return;
								}
							}
						break;
						default:
							if (substr($installParams[0],0,1)!='#') {
								$this->raiseError("Unknown parameter : ".$installParams[0]);
								return false;
							}
						break;
					}
				} else {
					$this->_report('Error during operation of "'.$aInstallCheck.'". Command execution is not allowed.<br />',true);
					if ($stopOnErrors) return;
				}
			}
		} else {
			$this->raiseError("Param must be an array");
			return false;
		}
		//at end of any patch process, update Automne subversion to force reload of JS and CSS cache from client
		if (@file_put_contents(PATH_MAIN_FS."/SUBVERSION" , time()) !== false) {
			CMS_file::chmodFile(FILES_CHMOD, PATH_MAIN_FS."/SUBVERSION");
		}
	}
	
	/**
	 * Execute a SQL script
	 *
	 * @param $script, string : the CMS_file::FILE_SYSTEM SQL script filename
	 *  This script can be SQL export provided by phpMyadmin or mysqldump, etc.
	 * @param simulation : boolean, if true, only do a read of the script and if it contain sql data, return true.
	 * @return boolean, true on success, false on failure
	 * @access public
	 */
	function executeSqlScript($script,$simulation=false) 
	{
		//include PMA import functions
		require_once(PATH_PACKAGES_FS.'/files/sqlDump.php');
		//read mysql version and set needed constant/vars for phpMyAdmin
		$q = new CMS_query('SELECT VERSION() AS version');
		$version = $q->getValue('version');
		$match = explode('.', $version);
		//read mysql file, clean it and split queries
		$query = PMA_readFile($script);
		PMA_splitSqlFile($queries,$query,(int)sprintf('%d%02d%02d', $match[0], $match[1], intval($match[2])));
		
		if (!$simulation) {
			//execute all queries
			$ok = true;
			foreach ($queries as $aQuery) {
				$q = new cms_query($aQuery);
				$ok = ($q->hasError()) ? false:$ok;
			}
		} else {
			$ok = (is_array($queries) && $queries) ? true:false;
		}
		return $ok;
	}
	
	/**
	 * Execute a PHP script
	 *
	 * @param $script, string : the CMS_file::FILE_SYSTEM PHP script filename
	 * @return string, the return of the script, false on failure
	 * @access public
	 */
	function executePhpScript($script)
	{
		//change current dir
		$pwd = getcwd();
		@chdir(PATH_REALROOT_FS);
		
		//execute script
		@ob_start();
		$includeOK = include_once $script;
		
		$data = @ob_get_contents();
		@ob_end_clean();
		
		//restore original dir
		@chdir($pwd);
		
		//return
		if ($includeOK!=1) {
			return false;
		} else {
			return $data;
		}
	}
	
	/**
	 * Execute a command
	 *
	 * @param $script, string : the Command to execute
	 * @param $error, integer : the error Command return, passed by reference
	 * @return string, the return of the command, false on failure
	 * @access public
	 */
	function executeCommand($command, &$error)
	{
		//change current dir
		$pwd = getcwd();
		@chdir(PATH_REALROOT_FS);
		
		if (function_exists("exec")) {
			//execute command
			@exec($command, $return , $error );
			$return = implode("\n",$return);
		} elseif (function_exists("passthru")) {
			//execute command
			@ob_start();
			@passthru ($command, $error);
			$return = @ob_get_contents();
			@ob_end_clean();
		} else {
			$error=1;
			return "passthru() and exec() commands not available, please correct your PHP configuration or contact your technical administrator";
		}
		//restore original dir
		@chdir($pwd);
		
		return $return;
	}
	
	/**
	 * Check validity format of a given right
	 *
	 * @param string the right to check
	 *  format :
	 *  r	read (and execute if it's a folder)
	 *  w	read and write (and execute if it's a folder)
	 *  x	read+write+execute
	 *  XXX	unix chmod octal value (ex : 664, 775, etc.)
	 * @return boolean true on success, false on failure
	 * @access private
	 */
	protected function _checkRightFormat($right) {
		if (is_numeric($right)) {
			if (strlen($right)!=3) {
				return false;
			} else {
				$rights = preg_split('//', $right, -1, PREG_SPLIT_NO_EMPTY);
				foreach ($rights as $aRight) {
					if ($aRight>7) {
						return false;
					}
				}
			}
		} else {
			if ($right!='r' && $right!='w' && $right!='x') {
				return false;
			}
		}
		return true;
	}
	
	/**
	 * Apply chmod on file(s)
	 *
	 * @param $right, string : rights to apply to file(s)
	 *  format : 
	 *  r	read (and execute if it's a folder)
	 *  w	read and write (and execute if it's a folder)
	 *  x	read+write+execute
	 *  XXX	unix chmod octal value (ex : 664, 775, etc.)
	 * @param $files, string : the files to apply new rights (relative to CMS_file::FILE_SYSTEM)
	 * @return string, the files who can't apply the chmod, else nothing if all is done.
	 * @access public
	 */
	function applyChmod($right,$files)
	{
		$filesList = CMS_file::getFileList($files);
		if (is_array($filesList) && $filesList) {
			$nok = '';
			foreach ($filesList as $aFile) {
				switch ($right) {
					case 'r':
						$nok .= (CMS_file::makeReadable($aFile['name'])) ? '':$aFile['name'].'<br />';
					break;
					case 'w':
						$nok .= (CMS_file::makeWritable($aFile['name'])) ? '':$aFile['name'].'<br />';
					break;
					case 'x':
						$nok .= (CMS_file::makeExecutable($aFile['name'])) ? '':$aFile['name'].'<br />';
					break;
					default:
						$nok .= (CMS_file::chmodFile($right,$aFile['name'])) ? '':$aFile['name'].'<br />';
					break;
				}
			}
			return $nok;
		} else {
			return '';
		}
	}
	
	/**
	 * Change owner on file(s)
	 *
	 * @param $owner, string : new owner to apply to file(s)
	 * @param $files, string : the files to apply new rights (relative to CMS_file::FILE_SYSTEM)
	 * @return string, the files who can't apply the chmod, else nothing if all is done.
	 * @access public
	 */
	function changeOwner($owner,$files)
	{
		$filesList = CMS_file::getFileList($files);
		if (is_array($filesList) && $filesList) {
			$nok = '';
			foreach ($filesList as $aFile) {
				$nok .= (chown($aFile['name'],$owner)) ? '':$aFile['name'].'<br />';
			}
			return $nok;
		} else {
			return '';
		}
	}
	
	/**
	 * Change group on file(s)
	 *
	 * @param $group, string : new group to apply to file(s)
	 * @param $files, string : the files to apply new rights (relative to CMS_file::FILE_SYSTEM)
	 * @return string, the files who can't apply the chmod, else nothing if all is done.
	 * @access public
	 */
	function changeGroup($group,$files)
	{
		$filesList = CMS_file::getFileList($files);
		if (is_array($filesList) && $filesList) {
			$nok = '';
			foreach ($filesList as $aFile) {
				$nok .= (chgrp($aFile['name'],$owner)) ? '':$aFile['name'].'<br />';
			}
			return $nok;
		} else {
			return '';
		}
	}
	
	/**
	 * Launch script PATH_AUTOMNE_CHMOD_SCRIPT_FS
	 *
	 * @return boolean true on success, false on failure.
	 * @access public
	 */
	function automneGeneralScript()
	{
		$chmodScript = new CMS_file(PATH_AUTOMNE_CHMOD_SCRIPT_FS);
		if ($chmodScript->exists()) {
			$commandLine = $chmodScript->readContent("array");
		} else {
			$this->_report('Error : File '.PATH_AUTOMNE_CHMOD_SCRIPT_FS.' does not exists ...',true);
			return false;
		}
		//read command lines and do maximum check on it before starting the installation process
		$this->_verbose('Read script...');
		$installError = $this->checkInstall($commandLine,$errorsInfos, false);
		
		//start command process
		$this->_verbose('Execute script...');
		$this->doInstall($commandLine);
		if ($installError) {
			$this->_report('Error with command :');
			$this->_report($installError);
			return false;
		} else {
			return true;
		}
	}
	
	function getReturn() {
		return $this->_return;
	}
	
	/**
	 * Is this errors can be easilly corrected by patch system ?
	 *
	 * @param $errorsInfos, array, the errors returned by checkInstall method
	 * @return boolean true on success, false on failure.
	 * @access public
	 */
	function canCorrectErrors($errorsInfos)
	{
		$canCorrect = true;
		if (is_array($errorsInfos) && $errorsInfos) {
			foreach ($errorsInfos as $anError) {
				switch ($anError['no']) {
					case 5 : //try to update a protected file (UPDATE.DENY)
						$canCorrect = ($canCorrect) ? true:false;
					break;
					default:
						$canCorrect = false;
					break;
				}
			}
		} else {
			return false;
		}
		return $canCorrect;
	}
}
?>