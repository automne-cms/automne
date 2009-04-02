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
// $Id: grandfather.php,v 1.6 2009/04/02 13:57:59 sebastien Exp $

/**
  * Class CMS_grandFather
  * This class is the ancestor of all CMS classes
  * @package CMS
  * @subpackage common
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr>
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_grandFather
{
	/**
	  * System label
	  * Default : "Automne (TM)"
	  */
	const SYSTEM_LABEL = "Automne (TM)";
	/**
	  * Log file
	  * Default : "cms_error_log"
	  */
	const ERROR_LOG = "/cms_error_log";

	/**
	  * True if this object has raised an error.
	  * @var boolean
	  * @access private
	  */
	private $_errRaised = false;

	/**
	  * If set to true, all errors will be reported to the screen.
	  * Can be set here during the developpement phase, or into a descendant being developped.
	  * @var boolean
	  * @access private
	  */
	private $_debug;

	/**
	  * If set to true, all errors will be added to the error log.
	  * Can be set here after the developpement phase, or into a descendant.
	  * @var boolean
	  * @access private
	  */
	private $_log = true;

	/**
	  * Raises an error. Shows it to the screen
	  *
	  * @param string $errorMessage the error message.
	  * @return void
	  * @access public (deprecated, use raiseError instead)
	  */
	public function _raiseError($errorMessage)
	{
		static $errorNumber;
		$systemDebug = (!defined('SYSTEM_DEBUG')) ? true : SYSTEM_DEBUG;
		if (isset($this) && $this->_debug === NULL) {
			$this->_debug = $systemDebug;
		}
		//second condition are for static calls (made by static methods)
		if (!defined('APPLICATION_EXEC_TYPE') || (APPLICATION_EXEC_TYPE == 'http' && ((!isset($this) && $systemDebug) || (isset($this) && $this->_debug)))) {
			$backTrace = $backTraceLink = '';
			if (isset($_SESSION) && isset($_SESSION["cms_context"]) && is_a($_SESSION["cms_context"],'CMS_context')) {
				$backtraces = !isset($_SESSION['automneBacktraces']) ? array() : $_SESSION['automneBacktraces'];
				//limit to last 3 backtraces
				if (sizeof($backtraces) >= 3) {
					$backtraces = array_slice($backtraces, sizeof($backtraces) - 2);
				}
				$bt = array_reverse(debug_backtrace());
				$backtrace = array(
					'summary'		=> sensitiveIO::printBackTrace($bt),
					'backtrace'		=> print_r($bt,true),
				);
				$backtraceName = 'bt-'.md5(rand());
				$backtraces[$backtraceName] = $backtrace;
				$_SESSION['automneBacktraces'] = $backtraces;
				$backTraceLink = '/automne/admin/backtrace.php?bt='.$backtraceName;
			}
			//append error to current view
			$view = CMS_view::getInstance();
			$view->addError(array('error' => $errorMessage, 'backtrace' => $backTraceLink));
		}
		
		//second condition are for static calls (made by static methods)
		if (!isset($this) || $this->_log) {
			$fd = @fopen(PATH_MAIN_FS.'/'.self::ERROR_LOG, "a");
			if (is_resource($fd)) {
				@fwrite($fd, date("Y-m-d H:i:s", mktime()).'|'.APPLICATION_EXEC_TYPE.'|'.$errorMessage."\n", 4096);
				@fclose($fd);
				@chmod (PATH_MAIN_FS.'/'.self::ERROR_LOG, octdec(FILES_CHMOD));
			}
		}
		//must be at the end because it interferes with the static calls conditions above
		if (isset($this)) {
			$this->_errRaised = true;
		}
	}

	/**
	  * Raises an error.
	  *
	  * @param string $errorMessage the error message.
	  * @return void
	  * @access public
	  */
	public function raiseError($errorMessage) {
		$errorMessage = sensitiveIO::getCallInfos().' : '.$errorMessage;
		self::_raiseError($errorMessage);
	}

	/**
	  * Returns true if this instance has already raised an error.
	  *
	  * @return boolean true if an error was raised by this instance, false otherwise.
	  * @access public
	  */
	public function hasError()
	{
		return $this->_errRaised;
	}

	/**
	  * Set the debug attribute
	  *
	  * @param boolean $activated True if debug should be activated, false otherwise
	  * @return void
	  * @access public
	  */
	public function setDebug($activated)
	{
		$this->_debug = ($activated) ? true : false;
	}

	/**
	  * Set the log attribute
	  *
	  * @param boolean $activated True if log should be activated, false otherwise
	  * @return void
	  * @access public
	  */
	public function setLog($activated)
	{
		$this->_log = ($activated) ? true : false;
	}

	/**
	  * PHP error handler
	  *
	  * @return true
	  * @access public
	  */
	static function PHPErrorHandler($errno, $errstr , $errfile , $errline , $errcontext ) {
		//if errno is not in the error_reporting scope, skip it
		//read it like this : "if errno bit is not in error_reporting"
		if ($errno & ~error_reporting()) {
			return true;
		}
		//define errors type table
	    $errortype = array (E_ERROR				=> 'Error',
							E_WARNING			=> 'Warning',
							E_PARSE				=> 'Parse error',
							E_NOTICE			=> 'Notice',
							E_CORE_ERROR		=> 'Core Error',
							E_CORE_WARNING		=> 'Core Warning',
							E_COMPILE_ERROR		=> 'Compile Error',
							E_COMPILE_WARNING	=> 'Compile Warning',
							E_STRICT			=> 'Runtime Notice',
							E_RECOVERABLE_ERROR	=> 'Catchable Fatal Error'
						);
		CMS_grandFather::raiseError('PHP '.$errortype[$errno].' : '.$errstr.' line '.$errline.' of file '.$errfile);
		return true;
	}

	/**
	  * Unknown method handler
	  *
	  * @return false
	  * @access public
	  */
	function __call($name, $parameters)
	{
		$bt = debug_backtrace();
		if (isset($bt[1]) && isset($bt[1]['class'])) {
			$this->raiseError('Unknown method \''.$name.'\' for object '.$bt[1]['class'].' in this version of Automne');
		} else{
			$this->raiseError('Unknown method \''.$name.'\' in this version of Automne');
		}
		return false;
	}

	/**
	  * Automne autoload handler
	  *
	  * @return true
	  * @access public
	  */
	static function autoload($classname) {
		static $classes, $modules;
		if (!isset($classes)) {
			$classes = array(
				//common
				'cms_stack' 						=> PATH_PACKAGES_FS.'/common/stack.php',
				'cms_contactdata' 					=> PATH_PACKAGES_FS.'/common/contactdata.php',
				'cms_contactdatas_catalog' 			=> PATH_PACKAGES_FS.'/common/contactdatascatalog.php',
				'cms_href' 							=> PATH_PACKAGES_FS.'/common/href.php',
				'cms_log_catalog' 					=> PATH_PACKAGES_FS.'/common/logcatalog.php',
				'cms_log' 							=> PATH_PACKAGES_FS.'/common/log.php',
				'cms_languagescatalog' 				=> PATH_PACKAGES_FS.'/common/languagescatalog.php',
				'cms_actions' 						=> PATH_PACKAGES_FS.'/common/actions.php',
				'cms_action' 						=> PATH_PACKAGES_FS.'/common/action.php',
				'cms_search' 						=> PATH_PACKAGES_FS.'/common/search.php',
				'cms_ldap_contactdata' 				=> PATH_PACKAGES_FS.'/common/contactdataldap.php',
				'cms_contactdatas_catalog' 			=> PATH_PACKAGES_FS.'/common/contactdatascatalog.php',
				'cms_email' 						=> PATH_PACKAGES_FS.'/common/email.php',
				'cms_emailscatalog' 				=> PATH_PACKAGES_FS.'/common/emailscatalog.php',
				'cms_ldap_auth' 					=> PATH_PACKAGES_FS.'/common/ldapauth.php',
				'cms_ldap_connexion' 				=> PATH_PACKAGES_FS.'/common/ldapconnexion.php',
				'cms_ldap_query' 					=> PATH_PACKAGES_FS.'/common/ldapquery.php',
				'cms_ldap_set' 						=> PATH_PACKAGES_FS.'/common/ldapset.php',
				'cms_query' 						=> PATH_PACKAGES_FS.'/common/query.php',
				'cms_date' 							=> PATH_PACKAGES_FS.'/common/date.php',
				'cms_language' 						=> PATH_PACKAGES_FS.'/common/language.php',
				'sensitiveio' 						=> PATH_PACKAGES_FS.'/common/sensitiveio.php',

				//dialogs
				'cms_context' 						=> PATH_PACKAGES_FS.'/dialogs/context.php',
				'cms_wysiwyg_toolbar' 				=> PATH_PACKAGES_FS.'/dialogs/toolbar.php',
				'cms_dialog' 						=> PATH_PACKAGES_FS.'/dialogs/dialog.php', //Deprecated
				'cms_jsdialog' 						=> PATH_PACKAGES_FS.'/dialogs/jsdialog.php', //Deprecated
				'cms_view' 							=> PATH_PACKAGES_FS.'/dialogs/view.php',
				'cms_submenus' 						=> PATH_PACKAGES_FS.'/dialogs/submenus.php',
				'cms_submenu' 						=> PATH_PACKAGES_FS.'/dialogs/submenu.php',
				'cms_dialog_listboxes' 				=> PATH_PACKAGES_FS.'/dialogs/dialoglistboxes.php',
				'cms_dialog_href' 					=> PATH_PACKAGES_FS.'/dialogs/dialoghref.php',
				'cms_fileupload_dialog' 			=> PATH_PACKAGES_FS.'/dialogs/fileupload.php',
				'cms_loadingdialog' 				=> PATH_PACKAGES_FS.'/dialogs/loadingDialog.php',
				'cms_texteditor' 					=> PATH_PACKAGES_FS.'/dialogs/texteditor.php',

				//files
				'cms_patch'							=> PATH_PACKAGES_FS.'/files/patch.php',
				'cms_file'							=> PATH_PACKAGES_FS.'/files/filesManagement.php',
				'cms_archive'						=> PATH_PACKAGES_FS.'/files/archive.php',
				'cms_bzip_file'						=> PATH_PACKAGES_FS.'/files/archive-bzip.php',
				'cms_gzip_file'						=> PATH_PACKAGES_FS.'/files/archive-gzip.php',
				'cms_tar_file'						=> PATH_PACKAGES_FS.'/files/archive-tar.php',
				'cms_zip_file'						=> PATH_PACKAGES_FS.'/files/archive-zip.php',
				'cms_fileupload'					=> PATH_PACKAGES_FS.'/files/fileupload.php',

				//modules
				'cms_module'						=> PATH_MODULES_FS.'/module.php',
				'cms_modulescodes'					=> PATH_MODULES_FS.'/modulesCodes.php',
				'cms_modulevalidation'				=> PATH_MODULES_FS.'/moduleValidation.php',
				'cms_superresource'					=> PATH_MODULES_FS.'/super_resource.php',
				'cms_modulecategory'				=> PATH_MODULES_FS.'/modulecategory.php',
				'cms_modulescatalog'				=> PATH_MODULES_FS.'/modulescatalog.php',
				'cms_modulecategories_catalog'		=> PATH_MODULES_FS.'/modulecategoriescatalog.php',
				'cms_modulestags'					=> PATH_MODULES_FS.'/modulesTags.php',
				'cms_moduleclientspace'				=> PATH_MODULES_FS.'/moduleclientspace.php',
				'cms_superresource'					=> PATH_MODULES_FS.'/super_resource.php',
				'cms_polymod'						=> PATH_MODULES_FS.'/polymod.php',
				'cms_modulepolymodvalidation' 		=> PATH_MODULES_FS.'/modulePolymodValidation.php',
				
				//standard
				'cms_rowscatalog' 					=> PATH_MODULES_FS.'/standard/rowscatalog.php',
				'cms_row' 							=> PATH_MODULES_FS.'/standard/row.php',
				'cms_block' 						=> PATH_MODULES_FS.'/standard/block.php',
				'cms_block_file' 					=> PATH_MODULES_FS.'/standard/blockfile.php',
				'cms_block_flash' 					=> PATH_MODULES_FS.'/standard/blockflash.php',
				'cms_block_image' 					=> PATH_MODULES_FS.'/standard/blockimage.php',
				'cms_blockscatalog' 				=> PATH_MODULES_FS.'/standard/blockscatalog.php',
				'cms_block_text' 					=> PATH_MODULES_FS.'/standard/blocktext.php',
				'cms_block_varchar' 				=> PATH_MODULES_FS.'/standard/blockvarchar.php',
				'cms_moduleclientspace_standard' 	=> PATH_MODULES_FS.'/standard/clientspace.php',
				'cms_moduleclientspace_standard_catalog' => PATH_MODULES_FS.'/standard/clientspacescatalog.php',

				//pageContent
				'cms_linxescatalog' 				=> PATH_PACKAGES_FS.'/pageContent/linxescatalog.php',
				'cms_xml2array' 					=> PATH_PACKAGES_FS.'/pageContent/xml2Array.php',
				'cms_linx' 							=> PATH_PACKAGES_FS.'/pageContent/linx.php',
				'cms_linxcondition' 				=> PATH_PACKAGES_FS.'/pageContent/linxcondition.php',
				'cms_linxdisplay' 					=> PATH_PACKAGES_FS.'/pageContent/linxdisplay.php',
				'cms_linxnodespec' 					=> PATH_PACKAGES_FS.'/pageContent/linxnodespec.php',
				'cms_xmltag' 						=> PATH_PACKAGES_FS.'/pageContent/xmltag.php',
				'cms_xmlparser' 					=> PATH_PACKAGES_FS.'/pageContent/xmlparser.php', //shadow class, for compatibility
				'cms_domdocument'					=> PATH_PACKAGES_FS.'/pageContent/xmldomdocument.php',

				//scripts
				'processmanager' 					=> PATH_PACKAGES_FS.'/scripts/backgroundScript/processmanager.php',
				'backgroundscript' 					=> PATH_PACKAGES_FS.'/scripts/backgroundScript/backgroundscript.php',
				'cms_scriptsmanager' 				=> PATH_PACKAGES_FS.'/scripts/scriptsmanager.php',

				//tree
				'cms_tree'							=> PATH_PACKAGES_FS.'/tree/tree.php',
				'cms_page'							=> PATH_PACKAGES_FS.'/tree/page.php',
				'cms_pagetemplatescatalog'			=> PATH_PACKAGES_FS.'/tree/pagetemplatescatalog.php',
				'cms_pagetemplate'					=> PATH_PACKAGES_FS.'/tree/pagetemplate.php',
				'cms_websitescatalog'				=> PATH_PACKAGES_FS.'/tree/websitescatalog.php',
				'cms_website'						=> PATH_PACKAGES_FS.'/tree/website.php',

				//user
				'cms_profile_user' 					=> PATH_PACKAGES_FS.'/user/profileuser.php',
				'cms_profile' 						=> PATH_PACKAGES_FS.'/user/profile.php',
				'cms_modulecategoriesclearances'	=> PATH_PACKAGES_FS.'/user/profilemodulecategoriesclearances.php',
				'cms_profile_userscatalog'			=> PATH_PACKAGES_FS.'/user/profileuserscatalog.php',
				'cms_profile_usersgroupscatalog'	=> PATH_PACKAGES_FS.'/user/profileusersgroupscatalog.php',
				'cms_profile_usersgroup'			=> PATH_PACKAGES_FS.'/user/profileusersgroup.php',

				//workflow
				'cms_resource' 						=> PATH_PACKAGES_FS.'/workflow/resource.php',
				'cms_resourcestatus' 				=> PATH_PACKAGES_FS.'/workflow/resourcestatus.php',
				'cms_resourcevalidationinfo' 		=> PATH_PACKAGES_FS.'/workflow/resourcevalidationinfo.php',
				'cms_resourcevalidation' 			=> PATH_PACKAGES_FS.'/workflow/resourcevalidation.php',
				'cms_resourcevalidationscatalog' 	=> PATH_PACKAGES_FS.'/workflow/resourcevalidationscatalog.php',

				//fckeditor
				'fckeditor' 						=> PATH_MAIN_FS.'/fckeditor/fckeditor.php',

				//JSMin
				'jsmin' 							=> PATH_MAIN_FS.'/jsmin/jsmin.php',

				//CSSMin
				'cssmin' 							=> PATH_MAIN_FS.'/cssmin/cssmin.php',
			);
		}
		$file = '';
		if (isset($classes[strtolower($classname)])) {
			$file = $classes[strtolower($classname)];
		} elseif (strpos($classname, 'CMS_module_') === 0) { //modules lazy loading
			if (file_exists(PATH_MODULES_FS.'/'.substr($classname,11).'.php')) {
				$file = PATH_MODULES_FS.'/'.substr($classname,11).'.php';
			} else {
				//here, we need to stop
				return false;
			}
		}
		if (!$file) {
			//try modules Autoload
			if (!isset($modules)) {
				$modules = CMS_modulesCatalog::getAll("id");
			}
			$polymodDone = false;
			foreach($modules as $codename => $module) {
				if (((!$polymodDone && $module->isPolymod()) || !$module->isPolymod()) && method_exists($module, 'load')) {
					if (!$polymodDone && $module->isPolymod()) {
						$polymodDone = false;
					}
					$file = $module->load($classname);
				} elseif ($polymodDone && $module->isPolymod()) {
					unset($module[$codename]);
				}
				if ($file) {
					break;
				}
			}
		}
		
		if ($file) {
			require_once($file);
			/*only for stats*/
			if (STATS_DEBUG) $GLOBALS["files_loaded"]++;
			if (STATS_DEBUG && VIEW_SQL) $GLOBALS["files_table"][] = $file;
		} else {
			//register Zend Framework Autoload
			require_once(PATH_MAIN_FS.'/Zend/Loader.php');
			/*only for stats*/
			if (STATS_DEBUG) $GLOBALS["files_loaded"]++;
			if (STATS_DEBUG && VIEW_SQL) $GLOBALS["files_table"][] = PATH_MAIN_FS.'/Zend/Loader.php';
			chdir(PATH_MAIN_FS);
			if (!Zend_Loader::autoload($classname)) {
				CMS_grandFather::raiseError('class '.$classname.' not found');
			}
		}
	}
}

/**
  * Set basic exception catch
  */
class CMS_Exception extends Exception  {
	public function __construct($message, $code = 0) {
		CMS_grandFather::raiseError($message);
	}
}

/**
  * Set PHP error handler
  */
set_error_handler (array('CMS_grandFather','PHPErrorHandler'));

/**
  * Set Automne autoload handler
  */
spl_autoload_register (array('CMS_grandFather','autoload'));

/**
  * Set shutdown function
  */
register_shutdown_function(array('CMS_view','quit'));
?>