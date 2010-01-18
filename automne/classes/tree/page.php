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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &    |
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// +----------------------------------------------------------------------+
//
// $Id: page.php,v 1.12 2010/01/18 15:30:54 sebastien Exp $

/**
  * Class CMS_page
  *
  * represent a page.
  *
  * @package CMS
  * @subpackage tree
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr> &
  * @author Cédric Soret <cedric.soret@ws-interactive.fr>
  */

class CMS_page extends CMS_resource
{
	const MESSAGE_PAGE_PAGE = 1328;
	
	/**
	  * page DB id
	  * @var integer
	  * @access private
	  */
	protected $_pageID;

	/**
	  * page base data DB id
	  * @var integer
	  * @access private
	  */
	protected $_baseDataID;

	/**
	  * Reminded editors stack
	  * @var CMS_stack
	  * @access private
	  */
	protected $_remindedEditors;

	/**
	  * last reminder : date of the last reminder message sent
	  * @var CMS_date
	  * @access private
	  */
	protected $_lastReminder;

	/**
	  * Template DB ID of the page
	  * @var integer
	  * @access private
	  */
	protected $_templateID;

	/**
	  * Template of the page. Instanciated at first call of function using it.
	  * @var CMS_pageTemplate
	  * @access private
	  */
	protected $_template;

	/**
	  * Website of the page. Instanciated at first call of function using it.
	  * @var CMS_website
	  * @access private
	  */
	protected $_website;
	
	/**
	  * Last date the page file was created
	  * @var CMS_date
	  * @access private
	  */
	protected $_lastFileCreation;

	/**
	  * Edited base data. Contains the base data edited by users. Not valid when page location is ARCHIVED or DELETED
	  * @var array(string=>mixed)
	  * @access private
	  */
	protected $_editedBaseData = false;

	/**
	  * Public base data.
	  * @var array(string=>mixed)
	  * @access private
	  */
	protected $_publicBaseData = false;
	
	/**
	  * The page URL
	  * @var string
	  * @access private
	  */
	protected $_pageURL = '';
	
	/**
	  * Constructor.
	  * initializes the page if the id is given.
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access public
	  */
	function __construct($id = 0)
	{
		$this->_remindedEditors = new CMS_stack();
		$this->_lastReminder = new CMS_date();
		$this->_lastFileCreation = new CMS_date();
		
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->raiseError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					pages,
					resources,
					resourceStatuses
				where
					id_pag='$id' and
					resource_pag = id_res and
					status_res = id_rs
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_pageID = $id;
				$this->_remindedEditors->setTextDefinition($data["remindedEditorsStack_pag"]);
				$this->_lastReminder->setFromDBValue($data["lastReminder_pag"]);
				$this->_templateID = $data["template_pag"];
				$this->_lastFileCreation->setFromDBValue($data["lastFileCreation_pag"]);
				$this->_pageURL = $data["url_pag"];
				//initialize super-class
				parent::__construct($data);
			} else {
				//display this error only if we are in HTTP mode (not cli) because it is only relevant in this mode
				if (!defined('APPLICATION_EXEC_TYPE') || APPLICATION_EXEC_TYPE == 'http') {
					$this->raiseError("Unknown ID :".$id);
				}
			}
		} else {
			//initialize super-class
			parent::__construct();
		}
	}
	
	/**
	  * Gets the DB ID of the instance.
	  *
	  * @return integer the DB id
	  * @access public
	  */
	function getID()
	{
		return $this->_pageID;
	}
	
	/**
	  * is this page the tree root ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isRoot() {
		return ($this->_pageID == APPLICATION_ROOT_PAGE_ID) ? true : false;
	}
	
	/**
	  * is this page content in draft ?
	  *
	  * @return boolean
	  * @access public
	  */
	function isDraft() {
		$this->_checkTemplate();
		if (!is_object($this->_template)) {
			return false;
		}
		return ($this->_template->isDraft()) ? true : false;
	}
	
	
	/**
	  * Gets the page status
	  *
	  * @return CMS_resourceStatus The resource status
	  * @access public
	  */
	function getStatus()
	{
		$this->_status->setDraft($this->isDraft());
		return $this->_status;
	}
	
	/**
	  * Gets the template of the page
	  *
	  * @return CMS_pageTemplate The page template
	  * @access public
	  */
	function getTemplate()
	{
		$this->_checkTemplate();
		return $this->_template;
	}
	
	/**
	  * Sets the page template
	  *
	  * @param integer $templateID The DB ID of the new template to set
	  * @param CMS_profile_user $user the user who did the edition (if not set, the edition is not considered)
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setTemplate($templateID)
	{
		if (!SensitiveIO::isPositiveInteger($templateID)) {
			$this->raiseError("TemplateID is not a positive integer");
			return false;
		}
		//comment this because this is not submitted to validation...
		/*if ($user) {
			$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		}*/
		$this->_templateID = $templateID;
		return true;
	}
	
	/**
	  * Get the date of last file creation
	  *
	  * @return CMS_date The last file creation date
	  * @access public
	  */
	function getLastFileCreationDate()
	{
		return $this->_lastFileCreation;
	}
	
	/**
	  * Get the modules contained in the page (via the module clientspaces)
	  *
	  * @return array(CMS_module) The modules
	  * @access public
	  */
	function getModules()
	{
		$this->_checkTemplate();
		if ($this->_template) {
			return $this->_template->getModules();
		}
	}
	
	/**
	  * Does the page use module
	  *
	  * @param string $codename The module codename
	  * @return boolean
	  * @access public
	  */
	function hasModule($codename)
	{
		$this->_checkTemplate();
		if ($this->_template) {
			return $this->_template->hasModule($codename);
		}
		return false;
	}
	
	/**
	  * Gets the page reminded editors for an edition
	  *
	  * @param integer $edition The edition the user should have made to be returned
	  * @return array(CMS_profile_user) The editors
	  * @access public
	  */
	function getRemindedEditors($edition)
	{
		$elements = $this->_remindedEditors->getElementsWithOneValue($edition, 2);
		$editors = array();
		foreach ($elements as $element) {
			$user = CMS_profile_usersCatalog::getByID($element[0]);
			if ($user) {
				$editors[] = $user;
			}
		}
		return $editors;
	}
	
	/**
	  * Gets the page reminded editors stack
	  *
	  * @return CMS_stack The reminded editors stack
	  * @access public
	  */
	function getRemindedEditorsStack()
	{
		return $this->_remindedEditors;
	}
	
	/**
	  * Sets the page reminded editors from a stack
	  *
	  * @param CMS_stack $editorsStack The Reminded editors stack to set
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setRemindedEditorsStack($editorsStack)
	{
		if (!is_a($editorsStack, "CMS_stack")) {
			$this->raiseError("EditorsStack is not a stack");
			return false;
		}
		$this->_remindedEditors = $editorsStack;
	}
	
	/**
	  * Get the page HTML URL.
	  *
	  * @param boolean $printPage Do we want the print page URL ?
	  * @param boolean $returnFilenameOnly : return only the page filename (default false)
	  * @param constant $relativeTo : get URL relative to webroot (PATH_RELATIVETO_WEBROOT) or file system (PATH_RELATIVETO_FILESYSTEM)
	  * @return string The html url; complete with PATH and website information. False if page not published.
	  * @access public
	  */
	function getHTMLURL($printPage = false, $returnFilenameOnly = false, $relativeTo = PATH_RELATIVETO_WEBROOT) {
		if ($this->getLocation() == RESOURCE_LOCATION_USERSPACE && $this->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED) {
			$htmlRoot = ($relativeTo == PATH_RELATIVETO_WEBROOT) ? PATH_PAGES_HTML_WR : PATH_PAGES_HTML_FS;
			$filename = $this->_getHTMLFilename();
			if ($printPage) {
				if ($returnFilenameOnly) {
					return "print-".$filename;
				} else {
					return $htmlRoot."/print-".$filename;
				}
			} else {
				if ($returnFilenameOnly) {
					return $filename;
				} else {
					return $htmlRoot."/".$filename;
				}
			}
		} else {
			return false;
		}
	}
	
	/**
	  * Get the page online URL.
	  *
	  * @param boolean $printPage Do we want the print page URL ?
	  * @param boolean $returnFilenameOnly : return only the page filename (default false)
	  * @param constant $relativeTo : get URL relative to webroot (PATH_RELATIVETO_WEBROOT) or file system (PATH_RELATIVETO_FILESYSTEM)
	  * @param boolean $force : get URL even if page is not published (default : false)
	  * @return string The url; complete with PATH and website information. Empty string if page not published.
	  * @access public
	  */
	function getURL($printPage = false, $returnFilenameOnly = false, $relativeTo = PATH_RELATIVETO_WEBROOT, $force = false) {
		if ($force || ($this->getLocation() == RESOURCE_LOCATION_USERSPACE && $this->getPublication() == RESOURCE_PUBLICATION_PUBLIC)) {
			$ws = CMS_tree::getPageWebsite($this);
			$wsURL = '';
			if (is_object($ws)) {
				if ($relativeTo == PATH_RELATIVETO_WEBROOT) {
					$wsURL = $ws->getURL();
				}
				$wsPagesPath = $ws->getPagesPath($relativeTo);
			} else {
				return '';
			}
			$filename = $this->_getFilename();
			if ($printPage) {
				if ($returnFilenameOnly) {
					return "print-".$filename;
				} else {
					return $wsURL.$wsPagesPath."/print-".$filename;
				}
			} else {
				if ($returnFilenameOnly) {
					return $filename;
				} else {
					return $wsURL.$wsPagesPath."/".$filename;
				}
			}
		} else {
			return '';
		}
	}
	
	/**
	  * Get the page path from its website
	  *
	  * @param integer $relativeTo Relative to filesystem or webroot. See constants
	  * @return string The file path relative to web root or filesystem. See constants.
	  * @access private
	  */
	protected function _getFilePath($relativeTo)
	{
		$ws = CMS_tree::getPageWebsite($this);
		return $ws->getPagesPath($relativeTo);
	}
	
	/**
	  * Get the html page path from its website
	  *
	  * @param integer $relativeTo Relative to filesystem or webroot. See constants
	  * @return string The html file path relative to web root or filesystem. See constants.
	  * @access private
	  */
	protected function _getHTMLFilePath($relativeTo)
	{
		if (SensitiveIO::isInSet($relativeTo, array(PATH_RELATIVETO_WEBROOT, PATH_RELATIVETO_FILESYSTEM))) {
			return ($relativeTo == PATH_RELATIVETO_WEBROOT) ? PATH_PAGES_HTML_WR : PATH_PAGES_HTML_FS;
		} else {
			$this->raiseError("Can't give pages path relative to anything other than WR or FS");
			return false;
		}
	}
	
	/**
	  * Get the page filename.
	  *
	  * @return string The filename without path indication, false if never validated or outside of userspace.
	  * @access private
	  */
	protected function _getFilename($regenerate = false) {
		if (trim($this->_pageURL) && !$regenerate) {
			return $this->_pageURL;
		} else {
			//check if page has been validated, if so, generate data from title
			if ($this->getPublication() != RESOURCE_PUBLICATION_NEVERVALIDATED && $this->getLocation() == RESOURCE_LOCATION_USERSPACE) {
				//create new filename
				$title = $this->getTitle(true);
				if (!$title) {
					//no public title founded, to avoid error, try to use the edited one.
					$title = $this->getTitle(false);
					if (!$title) {
						$this->raiseError("Can't get page title for page ".$this->getID()." to create page filename ...");
						return false;
					}
				}
				$filename = $this->getID().'-'.sensitiveIO::sanitizeURLString($title).'.php';
				//and save it
				$this->_pageURL = $filename;
				$this->writeToPersistence();
				return $filename;
			}
			return false;
		}
	}
	
	/**
	  * Get the html page filename from the title.
	  *
	  * @return string The html filename without path indication, false if never validated or outside of userspace.
	  * @access private
	  */
	protected function _getHTMLFilename() {
		return $this->getID().'.php';
	}
	
	/**
	  * Get the linx file path.
	  *
	  * @return string The path of the linx file, even if it doesn't exists.
	  * @access public
	  */
	function getLinxFilePath()
	{
		return PATH_PAGES_LINXFILES_FS."/".$this->_getHTMLFilename().".linx";
	}
	
	/**
	  * Get the print status for this page
	  *
	  * @return boolean true if there is something to print, false otherwise
	  * @access public
	  */
	function getPrintStatus() {
		if (!USE_PRINT_PAGES) {
			return false;
		}
		$this->_checkTemplate();
		if (!is_object($this->_template) || !$this->_template->getPrintingClientSpaces()) {
			return false;
		}
		return true;
	}
	
	/**
	  * Get the page content for the specified visualization mode and language.
	  *
	  * @return string The content of the page.
	  * @access public
	  */
	function getContent(&$language, $visualizationMode = false) {
		if (!is_a($language, "CMS_language") || !SensitiveIO::isInSet($visualizationMode, CMS_page::getAllVisualizationModes())) {
			$this->raiseError("Language must be a valid language and visualization mode in the set of possibles");
			return false;
		}
		$this->_checkTemplate();
		if ($this->_template) {
			//get parsed content definition from template (including CS block contents)
			$definition = $this->_template->getContent($language, $this, $visualizationMode);
			
			//instanciate modules treatments for page content tags
			$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGECONTENT_TAGS, $visualizationMode, $this);
			$modulesTreatment->setTreatmentParameters(array("language" => $language));
			$modulesTreatment->setDefinition($definition);
			$content = $modulesTreatment->treatContent(true);
			
			//instanciate modules treatments for page header tags
			$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_PAGEHEADER_TAGS, $visualizationMode, $this);
			$modulesTreatment->setTreatmentParameters(array("language" => $language));
			$modulesTreatment->setDefinition($content);
			$content = $modulesTreatment->treatContent(true);
			
			/*if ($visualizationMode == PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE) {
				//eval() the PHP code
				$content = sensitiveIO::evalPHPCode($content);
				return $content;
			}*/
			//include modules header codes on top of output file
			$modulesCodes = new CMS_modulesCodes();
			$headerInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_PAGECONTENT_HEADER_CODE, $visualizationMode, $this);
			if (is_array($headerInclude) && $headerInclude) {
				$content = implode("\n",$headerInclude).$content;
			}
			
			//include modules footers codes on bottom of output file
			$footerInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_PAGECONTENT_FOOTER_CODE, $visualizationMode, $this);
			if (is_array($footerInclude) && $footerInclude) {
				$content .= implode("\n",$footerInclude);
			}
			//replace {{pageID}} tag in all page content.
			$content = str_replace('{{pageID}}', $this->getID(), $content);
			if ($visualizationMode != PAGE_VISUALMODE_HTML_PUBLIC 
				&& $visualizationMode != PAGE_VISUALMODE_PRINT ) {
				//eval() the PHP code
				$content = sensitiveIO::evalPHPCode($content);
			}
			return $content;
		} else {
			return false;
		}
	}
	
	/**
	  * Regenerate the page file, either from scratch or from the linx file.
	  * If linx file doesn't exists, the file is regenerated from scratch (obviously).
	  *
	  * @param boolean $fromScratch If false, regenerate from the linx file, otherwise regenerate linx file first.
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function regenerate($fromScratch = false)
	{
		//regenerate don't work on pages that are not public
		if ($this->getPublication() != RESOURCE_PUBLICATION_PUBLIC) {
			return true;
		}
		//need pageTemplate for regeneration
		$this->_checkTemplate();
		//get linx file path
		$linxFile = new CMS_file($this->getLinxFilePath());
		//should we regenerate the linx file ?
		if ($fromScratch || !$linxFile->exists()) {
			if (!$this->_template) {
				$this->raiseError('Can\'t find page template for page '.$this->getID());
				return false;
			}
			if (!$this->writeLinxFile()) {
				return false;
			}
			//reload linx file
			$linxFile = new CMS_file($this->getLinxFilePath());
		}
		//unregister all linxes
		CMS_linxesCatalog::deleteLinxes($this);
		//instanciate modules treatments for page linx tags
		$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_LINXES_TAGS,PAGE_VISUALMODE_HTML_PUBLIC,$this);
		$modulesTreatment->setDefinition($linxFile->getContent());
		
		if ($content = $modulesTreatment->treatContent(true)) {
			$pageHTMLPath = $this->_getHTMLFilePath(PATH_RELATIVETO_FILESYSTEM)."/".$this->_getHTMLFilename();
			$pageFile = new CMS_file($pageHTMLPath);
			$pageFile->setContent($content);
			$pageFile->writeToPersistence();
			$this->_lastFileCreation->setNow();
			$this->writeToPersistence();
			//if the page is a website root, create the index page redirecting to this one
			if ($fromScratch && CMS_websitesCatalog::isWebsiteRoot($this->getID())) {
				CMS_websitesCatalog::writeRootRedirection();
			}
		} else {
			$this->raiseError('Malformed linx file');
			return false;
		}
		
		//write significant url page
		$pagePath = $this->_getFilePath(PATH_RELATIVETO_FILESYSTEM)."/".$this->_getFilename();
		$redirectionFile = new CMS_file($pagePath);
		$redirectionFile->setContent($this->redirectionCode($pageHTMLPath));
		$redirectionFile->writeToPersistence(true, true);
		
		//write print page if any
		if (USE_PRINT_PAGES && $this->_template->getPrintingClientSpaces()) {
			//reload linx file
			$printLinxFile = new CMS_file($this->getLinxFilePath().'.print');
			if ($printLinxFile->exists()) {
				$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_LINXES_TAGS,PAGE_VISUALMODE_PRINT,$this);
				$modulesTreatment->setDefinition($printLinxFile->getContent());
				if ($content = $modulesTreatment->treatContent(true)) {
					$printHTMLPath = $this->_getHTMLFilePath(PATH_RELATIVETO_FILESYSTEM)."/print-".$this->_getHTMLFilename();
					$printFile = new CMS_file($printHTMLPath);
					$printFile->setContent($content);
					$printFile->writeToPersistence();
				} else {
					$this->raiseError('Malformed print linx file');
					return false;
				}
				//write significant url print page
				$printPath = $this->_getFilePath(PATH_RELATIVETO_FILESYSTEM)."/print-".$this->_getFilename();
				$redirectionFile = new CMS_file($printPath);
				$redirectionFile->setContent($this->redirectionCode($printHTMLPath));
				$redirectionFile->writeToPersistence();
			} else {
				$this->raiseError('Malformed print linx file');
				return false;
			}
		}
		return true;
	}
	
	/**
	  * Write to disk the linx file, i.e. the content for the specified page.
	  * Doesn't translates the atm-linx tags.
	  * Also writes the "print" linx file
	  *
	  * @return boolean true on success, false on failure to write the content to this file.
	  * @access private
	  */
	function writeLinxFile()
	{
		$defaultLanguage = CMS_languagesCatalog::getDefaultLanguage();
		//get public page content (without linxes process)
		$pageContent = $this->getContent($defaultLanguage, PAGE_VISUALMODE_HTML_PUBLIC);
		//then write the page linx file
		$linxFile = new CMS_file($this->getLinxFilePath());
		$linxFile->setContent($pageContent);
		if (!$linxFile->writeToPersistence()) {
			$this->raiseError("Can't write linx file : ".$fpath);
			return false;
		}
		//writes the "print" linx file if any
		if (USE_PRINT_PAGES && $this->_template->getPrintingClientSpaces()) {
			//get print page content (without linxes process)
			$printPageContent = $this->getContent($defaultLanguage, PAGE_VISUALMODE_PRINT);
			//then write the print page linx file
			$linxFile = new CMS_file($this->getLinxFilePath().".print");
			$linxFile->setContent($printPageContent);
			if (!$linxFile->writeToPersistence()) {
				$this->raiseError("Can't write print linx file : ".$fpath);
				return false;
			}
		}
		return true;
	}
	
	/**
	  * Gets the page redirection code to html page.
	  *
	  * @param string $filePath the html filepath
	  * @return string The redirection code
	  * @access public
	  */
	function redirectionCode($filePath) {
		//replace absolute filePath to DOCUMENT_ROOT one
		$filePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $filePath);		
		$content = 
		'<?php'."\n".
		'if (file_exists($_SERVER[\'DOCUMENT_ROOT\'].\''.$filePath.'\')) {'."\n".
		'	$cms_page_included = true;'."\n".
		'	require($_SERVER[\'DOCUMENT_ROOT\'].\''.$filePath.'\');'."\n".
		'} else {'."\n".
		'	header(\'HTTP/1.x 301 Moved Permanently\', true, 301);'."\n".
		'	header(\'Location: '.PATH_SPECIAL_PAGE_NOT_FOUND_WR.'\');'."\n".
		'	exit;'."\n".
		'}'."\n".
		'?>';
		return $content;
	}
	
	/**
	  * Get HTML meta tags for a given page
	  *
	  * @param boolean $public Do we want the edited or public value ? (default : false => edited).
	  * @return string : HTML meta tags infos infos
	  * @access public
	  */
	function getMetaTags($public = false) {
		$website = $this->getWebsite();
		$favicon = '';
		$metaDatas = '';
		if (!is_object($website)) {
			return '';
		}
		if ($website->getMeta('favicon')) {
			$infos = pathinfo($website->getMeta('favicon'));
			if ($infos['extension']) {
				switch ($infos['extension']) {
					case 'ico':
						$type = 'image/x-icon';
					break;
					case 'jpg':
						$type = 'image/jpeg';
					break;
					case 'gif':
						$type = 'image/gif';
					break;
					case 'png':
						$type = 'image/png';
					break;
					default:
						$type = 'application/octet-stream';
					break;
				}
			} else {
				$type = 'application/octet-stream';
			}
			$metaDatas .= '<link rel="icon" type="'.$type.'" href="'.$website->getURL().$website->getMeta('favicon').'" />'."\n";
		} elseif (file_exists(PATH_REALROOT_FS.'/favicon.ico')) {
			$metaDatas .= '<link rel="icon" type="image/x-icon" href="'.$website->getURL().'/favicon.ico" />'."\n";
		} elseif (file_exists(PATH_REALROOT_FS.'/img/favicon.png')) {
			$metaDatas .= '<link rel="icon" type="image/png" href="'.$website->getURL().'/img/favicon.png" />'."\n";
		}
		if ($this->getDescription($public)) {
			$metaDatas .= '	<meta name="description" content="'.SensitiveIO::sanitizeHTMLString($this->getDescription($public)).'" />'."\n";
		}
		if ($this->getKeywords($public)) {
			$metaDatas .= '	<meta name="keywords" content="'.SensitiveIO::sanitizeHTMLString($this->getKeywords($public)).'" />'."\n";
		}
		if ($this->getCategory($public)) {
			$metaDatas .= '	<meta name="category" content="'.SensitiveIO::sanitizeHTMLString($this->getCategory($public)).'" />'."\n";
		}
		if ($this->getRobots($public)) {
			$metaDatas .= '	<meta name="robots" content="'.SensitiveIO::sanitizeHTMLString($this->getRobots($public)).'" />'."\n";
		}
		if ($this->getLanguage($public)) {
			$metaDatas .= '	<meta name="language" content="'.SensitiveIO::sanitizeHTMLString($this->getLanguage($public)).'" />'."\n";
		}
		if (!NO_PAGES_EXTENDED_META_TAGS) {
			if ($this->getAuthor($public)) {
				$metaDatas .= '	<meta name="author" content="'.SensitiveIO::sanitizeHTMLString($this->getAuthor($public)).'" />'."\n";
			}
			if ($this->getReplyto($public)) {
				$metaDatas .= '	<meta name="reply-to" content="'.SensitiveIO::sanitizeHTMLString($this->getReplyto($public)).'" />'."\n";
			}
			if ($this->getCopyright($public)) {
				$metaDatas .= '	<meta name="copyright" content="'.SensitiveIO::sanitizeHTMLString($this->getCopyright($public)).'" />'."\n";
			}
		}
		$metaDatas .= 
			'	<meta name="generator" content="'.CMS_grandFather::SYSTEM_LABEL.'" />'."\n".
			'	<meta name="identifier-url" content="'.$website->getURL().'" />'."\n";
		if ($this->getReminderPeriodicity($public) && $this->getReminderPeriodicity($public) > 0) {
			$metaDatas .= '	<meta name="revisit-after" content="'.$this->getReminderPeriodicity($public).' days" />'."\n";
		}
		if ($this->getPragma($public)) {
			$metaDatas .= '	<meta http-equiv="pragma" content="no-cache" />'."\n";
		}
		if ($this->getRefresh($public)) {
			$metaDatas .= '	<meta http-equiv="refresh" content="'.SensitiveIO::sanitizeHTMLString($this->getRefresh($public)).'" />'."\n";
		}
		if ($this->getMetas($public)) {
			$metaDatas .= $this->getMetas($public)."\n";
		}
		return $metaDatas;
	}
	
	/**
	  * Gets the title base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return string The title
	  * @access public
	  */
	function getTitle($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["title"];
	}
	
	/**
	  * get object type label
	  *
	  * @param mixed $language the language code (string) or the CMS_language (object) to use for label
	  * @return string : the object name
	  * @access public
	  */
	function getTypeLabel($language) {
		return $language->getMessage(self::MESSAGE_PAGE_PAGE);
	}
	
	/**
	  * Gets the url in base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return string The base data url
	  * @access public
	  */
	function getBaseDataURL($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["url"];
	}
	
	/**
	  * Sets the title base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setTitle($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$data) {
			$this->raiseError("Try to set an empty title for page");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		$this->_editedBaseData["title"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the link-title base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return string The link-title
	  * @access public
	  */
	function getLinkTitle($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		return $this->{$var}["linkTitle"];
	}
	
	/**
	  * Sets the link-title base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setLinkTitle($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["linkTitle"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the refresh url base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return string The link-title
	  * @access public
	  */
	function getRefreshURL($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["refreshUrl"];
	}
	
	/**
	  * Sets the refresh url base data.
	  *
	  * @param boolean $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setRefreshUrl($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["refreshUrl"] = ($data) ? 1 : 0;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets a meta value from website.
	  *
	  * @param string $meta : the meta name to get
	  * @return string The website meta value
	  * @access public
	  */
	function getMetaFromWebsite($meta) {
		if ($this->_checkWebsite()) {
			return $this->_website->getMeta($meta);
		} else {
			return false;
		}
	}
	
	
	/**
	  * Get page website.
	  *
	  * @return CMS_website The website the page belong to
	  * @access public
	  */
	function getWebsite() {
		if ($this->_checkWebsite()) {
			return $this->_website;
		} else {
			return false;
		}
	}
	
	/**
	  * Gets the keywords base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The keywords
	  * @access public
	  */
	function getKeywords($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return (!$this->{$var}["keywords"] && $queryWebsite) ? $this->getMetaFromWebsite('keywords') : $this->{$var}["keywords"];
	}
	
	/**
	  * Sets the keywords base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setKeywords($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["keywords"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the description base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The description
	  * @access public
	  */
	function getDescription($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		return (!$this->{$var}["description"] && $queryWebsite) ? $this->getMetaFromWebsite('description') : $this->{$var}["description"];
	}
	
	/**
	  * Sets the description base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setDescription($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["description"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the category base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The category
	  * @access public
	  */
	function getCategory($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		return (!$this->{$var}["category"] && $queryWebsite) ? $this->getMetaFromWebsite('category') : $this->{$var}["category"];
	}
	
	/**
	  * Sets the category base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setCategory($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["category"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the author base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The author
	  * @access public
	  */
	function getAuthor($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		return (!$this->{$var}["author"] && $queryWebsite) ? $this->getMetaFromWebsite('author') : $this->{$var}["author"];
	}
	
	/**
	  * Sets the author base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setAuthor($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["author"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the replyto base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The replyto
	  * @access public
	  */
	function getReplyto($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return (!$this->{$var}["replyto"] && $queryWebsite) ? $this->getMetaFromWebsite('replyto') : $this->{$var}["replyto"];
	}
	
	/**
	  * Sets the replyto base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setReplyto($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["replyto"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the metas base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The replyto
	  * @access public
	  */
	function getMetas($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return (!$this->{$var}["metas"] && $queryWebsite) ? $this->getMetaFromWebsite('metas') : $this->{$var}["metas"];
	}
	
	/**
	  * Sets the metas base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setMetas($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["metas"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the copyright base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The copyright
	  * @access public
	  */
	function getCopyright($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return (!$this->{$var}["copyright"] && $queryWebsite) ? $this->getMetaFromWebsite('copyright') : $this->{$var}["copyright"];
	}
	
	/**
	  * Sets the copyright base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setCopyright($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["copyright"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the language base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The language
	  * @access public
	  */
	function getLanguage($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		if ($this->{$var}["language"]) {
			return $this->{$var}["language"];
		} elseif ($queryWebsite && $this->getMetaFromWebsite('language')) {		    
			return $this->getMetaFromWebsite('language');
		} else {
			//assume application default language is the good one ...
			return APPLICATION_DEFAULT_LANGUAGE;
		}
	}
	
	/**
	  * Sets the language base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setLanguage($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		$this->_editedBaseData["language"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the robots base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @param boolean $queryWebsite : Do we get the meta value from website if does not exists for the page itself ?
	  * @return string The robots
	  * @access public
	  */
	function getRobots($public = false, $queryWebsite = true)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		return (!$this->{$var}["robots"] && $queryWebsite) ? $this->getMetaFromWebsite('robots') : $this->{$var}["robots"];
	}
	
	/**
	  * Sets the robots base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setRobots($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["robots"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the Pragma base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return string The Pragma
	  * @access public
	  */
	function getPragma($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["pragma"];
	}
	
	/**
	  * Sets the Pragma base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setPragma($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["pragma"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the refresh base data
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return string The refresh
	  * @access public
	  */
	function getRefresh($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["refresh"];
	}
	
	/**
	  * Sets the refresh base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setRefresh($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["refresh"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the reminder periodicity base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return integer The reminder periodicity
	  * @access public
	  */
	function getReminderPeriodicity($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["reminderPeriodicity"];
	}
	
	/**
	  * Sets the reminder periodicity base data.
	  *
	  * @param integer $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setReminderPeriodicity($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		if (SensitiveIO::isPositiveInteger($data) || $data === 0) {
			$this->_editedBaseData["reminderPeriodicity"] = $data;
			$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
			return true;
		} else {
			$this->raiseError("Value is not a positive integer or zero");
			return false;
		}
	}
	
	/**
	  * Gets the reminder On base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return CMS_date The reminder On date
	  * @access public
	  */
	function getReminderOn($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["reminderOn"];
	}
	
	/**
	  * Sets the reminder On base data.
	  *
	  * @param CMS_date $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setReminderOn($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		if (is_a($data, "CMS_date")) {
			$this->_editedBaseData["reminderOn"] = $data;
			$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
			return true;
		} else {
			$this->raiseError("Value is not a CMS_date");
			return false;
		}
	}
	
	/**
	  * Gets the reminder On message base data.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return string The message
	  * @access public
	  */
	function getReminderOnMessage($public = false)
	{
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["reminderOnMessage"];
	}
	
	/**
	  * Sets the reminder On Message base data.
	  *
	  * @param string $data The new base data to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setReminderOnMessage($data, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		$this->_editedBaseData["reminderOnMessage"] = $data;
		$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
		return true;
	}
	
	/**
	  * Gets the redirect link.
	  *
	  * @param boolean $public Do we want the edited or public value ?
	  * @return CMS_href The redirect link
	  * @access public
	  */
	function getRedirectLink($public = false) {
		if (!$this->_checkBaseData($public)) {
			return false;
		}
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		return $this->{$var}["redirect"];
	}
	
	/**
	  * Sets the reminder On Message base data.
	  *
	  * @param CMS_href $link The new link to set
	  * @param CMS_profile_user &$user the user who did the edition
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function setRedirectLink($link, &$user)
	{
		if (!is_a($user, "CMS_profile_user")) {
			$this->raiseError("Didn't received a valid user");
			return false;
		}
		if (!$this->_checkBaseData(false)) {
			return false;
		}
		
		if (is_a($link, "CMS_href")) {
			$this->_editedBaseData["redirect"] = $link;
			$this->addEdition(RESOURCE_EDITION_BASEDATA, $user);
			return true;
		} else {
			$this->raiseError("Value is not a CMS_href");
			return false;
		}
	}
	
	/**
	  * Sets the last reminder to today
	  *
	  * @return void
	  * @access public
	  */
	function touchLastReminder()
	{
		$this->_lastReminder->setNow();
	}
	
	/**
	  * Validate the location proposition of the resource (proposedFor attribute).
	  * This overloaded method deletes the html file if location proposed is outside userspace
	  *
	  * @return void
	  * @access public
	  */
	function validateProposedLocation()
	{
		$outside = $this->isProposedForOutsideUserspace();
		parent::validateProposedLocation();
		if ($outside && $this->isProposedForOutsideUserspace()) {
			@unlink($this->_getFilePath(PATH_RELATIVETO_FILESYSTEM));
		}
	}
	
	/**
	  * Validates an edition. Adds the publishing of siblings orders to the parent function, and the setting of reminded editors
	  *
	  * @param integer $edition the edition to validate
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	function validateEdition($edition)
	{
		//change the remindedEditors stack
		if ($edition & RESOURCE_EDITION_CONTENT || $edition & RESOURCE_EDITION_BASEDATA) {
			$final_stack = $this->_remindedEditors;
			$editors_content = $this->getEditors(RESOURCE_EDITION_CONTENT);
			$editors_basedata = $this->getEditors(RESOURCE_EDITION_BASEDATA);
			$reminded_editors = array_merge($editors_content, $editors_basedata);
			//use this tricky method here because array_unique compare elements as a string and php complain about converting CMS_profile_user in string
			$unique_reminded_editors = array();
			foreach ($reminded_editors as $editor) {
				$unique_reminded_editors[$editor->getUserID()] = $editor;
			}
			foreach ($unique_reminded_editors as $editor) {
				$final_stack->add($editor->getUserID());
			}
			
			$this->setRemindedEditorsStack($final_stack);
			$this->writeToPersistence();
		}
		//change the page url if needed
		if ($edition & RESOURCE_EDITION_BASEDATA && $this->getRefreshUrl(true)) {
			$this->_createNewURL();
		}
		parent::validateEdition($edition);
		
		if ($edition & RESOURCE_EDITION_SIBLINGSORDER || $edition & RESOURCE_EDITION_MOVE) {//TODOV4 : check this for RESOURCE_EDITION_MOVE
			CMS_tree::publishSiblingsOrder($this);
		}
	}
	
	/**
	  * Create new page URL filename
	  *  /!\ This method should be used only by validateEdition method, because it is a part of the page validation process !
	  *      It is used only for page filename change and destroy old filename files
	  * @return boolean true on success, false on failure
	  * @access private
	  */
	protected function _createNewURL() {
		//1- load edited baseDatas
		$this->_checkBaseData(false);
		//2- remove refreshUrl flag in base data (edited AND public)
		$this->_editedBaseData["refreshUrl"] = 0;
		$this->_publicBaseData["refreshUrl"] = 0;
		
		//3- generate new filename and save it (it will also save edited baseDatas)
		$this->_getFilename(true);
		
		//4- update basedatas tables (public)
		$sql = "update
					pagesBaseData_public
				set
					refreshUrl_pbd='0'
				where
					page_pbd='".$this->getID()."'";
		$q = new CMS_query($sql);
		
		//5- destroy all previous url files for this page
		$printfiles = glob($this->_getFilePath(PATH_RELATIVETO_FILESYSTEM).'/print-'.$this->getID().'-*.php', GLOB_NOSORT);
		$files = array_merge(glob($this->_getFilePath(PATH_RELATIVETO_FILESYSTEM).'/'.$this->getID().'-*.php', GLOB_NOSORT),$printfiles);
		if (is_array($files) && $files) {
			foreach ($files as $file) {
				@unlink($file);
			}
		}
		//then return new filename
		return true;
	}
	
	/**
	  * Is page useable (not in  DELETED or ARCHIVED locations)
	  *
	  * @return boolean true if useable, false otherwise
	  * @access public
	  */
	function isUseable()
	{
		return ($this->_status->getLocation() == RESOURCE_LOCATION_ARCHIVED ||
				$this->_status->getLocation() == RESOURCE_LOCATION_DELETED)
				? false : true;
	}
	
	/**
	  * Check that the base data is loaded (edited base data can't be loaded from DELETED or ARCHIVED locations)
	  *
	  * @param boolean $public Is it the public or edited base data we want ?
	  * @return boolean true on success, false on failure (because users can't edit the data)
	  * @access private
	  */
	protected function _checkBaseData($public = false)
	{
		$var = ($public) ? "_publicBaseData" : "_editedBaseData";
		
		if (!$this->{$var}) {
			//can't have edited base data when page is in DELETED or ARCHIVED locations
			if (!$public && 
				($this->_status->getLocation() == RESOURCE_LOCATION_ARCHIVED ||
				$this->_status->getLocation() == RESOURCE_LOCATION_DELETED)) {
				
				//$this->raiseError('Page '.$this->getID().' : Can\'t get edited base data from DELETED or ARCHIVED locations');
				return false;
			}
			
			$this->{$var} = array();
			$this->{$var}["title"] = '';
			$this->{$var}["linkTitle"] = '';
			$this->{$var}["keywords"] = '';
			$this->{$var}["description"] = '';
			$this->{$var}["reminderPeriodicity"] = '';
			$this->{$var}["reminderOnMessage"] = '';
			$this->{$var}["category"] = '';
			$this->{$var}["author"] = '';
			$this->{$var}["replyto"] = '';
			$this->{$var}["copyright"] = '';
			$this->{$var}["language"] = '';
			$this->{$var}["robots"] = '';
			$this->{$var}["pragma"] = '';
			$this->{$var}["refresh"] = '';
			$this->{$var}["refreshUrl"] = '';
			$this->{$var}["metas"] = '';
			$this->{$var}["reminderOn"] = new CMS_date();
			$this->{$var}["redirect"] = new CMS_href();
			switch ($this->_status->getLocation()) {
			case RESOURCE_LOCATION_ARCHIVED:
				$table = "pagesBaseData_archived";
				break;
			case RESOURCE_LOCATION_DELETED:
				$table = "pagesBaseData_deleted";
				break;
			case RESOURCE_LOCATION_USERSPACE:
			default:
				$table = ($public) ? "pagesBaseData_public" : "pagesBaseData_edited";
				break;
			}
			
			$sql = "
				select
					*
				from
					".$table."
				where
					page_pbd='".$this->_pageID."'
			";
			
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_baseDataID = $data["id_pbd"];
				$this->{$var}["title"] = $data["title_pbd"];
				$this->{$var}["linkTitle"] = $data["linkTitle_pbd"];
				$this->{$var}["keywords"] = $data["keywords_pbd"];
				$this->{$var}["description"] = $data["description_pbd"];
				$this->{$var}["reminderPeriodicity"] = $data["reminderPeriodicity_pbd"];
				$this->{$var}["reminderOn"]->setFromDBValue($data["reminderOn_pbd"]);
				$this->{$var}["reminderOnMessage"] = $data["reminderOnMessage_pbd"];
				$this->{$var}["category"] = $data["category_pbd"];
				$this->{$var}["author"] = $data["author_pbd"];
				$this->{$var}["replyto"] = $data["replyto_pbd"];
				$this->{$var}["copyright"] = $data["copyright_pbd"];
				$this->{$var}["language"] = $data["language_pbd"];
				$this->{$var}["robots"] = $data["robots_pbd"];
				$this->{$var}["pragma"] = $data["pragma_pbd"];
				$this->{$var}["refresh"] = $data["refresh_pbd"];
				$this->{$var}["refreshUrl"] = $data["refreshUrl_pbd"];
				$this->{$var}["metas"] = $data["metas_pbd"];
				$this->{$var}["redirect"] = new CMS_href($data["redirect_pbd"]);
			}
		}
		
		return true;
	}
	
	/**
	  * Check that the template is instanciated.
	  *
	  * @return void
	  * @access private
	  */
	protected function _checkTemplate()
	{
		if (!$this->_template && $this->_templateID) {
			$this->_template =& CMS_pageTemplatesCatalog::getByID($this->_templateID);
		}
	}
	
	/**
	  * Check that the website is instanciated.
	  *
	  * @return void
	  * @access private
	  */
	protected function _checkWebsite()
	{
		if (!is_object($this->_website)) {
			$this->_website =& CMS_tree::getPageWebsite($this->_pageID);
		}
		if (!is_object($this->_website)) {
			$this->raiseError('No website founded for page : '.$this->_pageID);
			return false;
		}
		return true;
	}
	
	/**
	  * Delete the page file, html file, print files and the page linx file
	  *
	  * @return boolean true if deletion went without errors, false otherwise
	  * @access public
	  */
	function deleteFiles()
	{
		//delete HTML page
		@unlink($this->_getHTMLFilePath(PATH_RELATIVETO_FILESYSTEM)."/".$this->_getHTMLFilename());
		//delete HTML print page
		@unlink($this->_getHTMLFilePath(PATH_RELATIVETO_FILESYSTEM)."/print-".$this->_getHTMLFilename());
		//delete page
		@unlink($this->_getFilePath(PATH_RELATIVETO_FILESYSTEM)."/".$this->_getFilename());
		//delete print page
		@unlink($this->_getFilePath(PATH_RELATIVETO_FILESYSTEM)."/print-".$this->_getFilename());
		//delete linx file
		@unlink($this->getLinxFilePath());
		return true;
	}
	
	/**
	  * Writes the page into persistence (MySQL for now), along with base data.
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	function writeToPersistence()
	{
		parent::writeToPersistence();
		
		//save page data
		$sql_fields = "
			resource_pag='".parent::getID()."',
			remindedEditorsStack_pag='".SensitiveIO::sanitizeSQLString($this->_remindedEditors->getTextDefinition())."',
			lastReminder_pag='".$this->_lastReminder->getDBValue()."',
			template_pag='".$this->_templateID."',
			lastFileCreation_pag='".$this->_lastFileCreation->getDBValue()."',
			url_pag='".SensitiveIO::sanitizeSQLString($this->_pageURL)."'
		";

		if ($this->_pageID) {
			$sql = "
				update
					pages
				set
					".$sql_fields."
				where
					id_pag='".$this->_pageID."'
			";
		} else {
			$sql = "
				insert into
					pages
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_pageID) {
			$this->_pageID = $q->getLastInsertedID();
		}
		
		//save base data if modified
		if ($this->_editedBaseData) {
			$sql_fields = "
				page_pbd='".$this->_pageID."',
				title_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["title"])."',
				linkTitle_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["linkTitle"])."',
				keywords_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["keywords"])."',
				description_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["description"])."',
				reminderPeriodicity_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["reminderPeriodicity"])."',
				reminderOn_pbd='".$this->_editedBaseData["reminderOn"]->getDBValue()."',
				reminderOnMessage_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["reminderOnMessage"])."',
				category_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["category"])."',
				author_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["author"])."',
				replyto_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["replyto"])."',
				copyright_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["copyright"])."',
				language_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["language"])."',
				robots_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["robots"])."',
				pragma_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["pragma"])."',
				refresh_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["refresh"])."',
				redirect_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["redirect"]->getTextDefinition())."',
				refreshUrl_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["refreshUrl"])."',
				metas_pbd='".SensitiveIO::sanitizeSQLString($this->_editedBaseData["metas"])."'
			";
			if ($this->_baseDataID) {
				$sql = "
					update
						pagesBaseData_edited
					set
						".$sql_fields."
					where
						id_pbd='".$this->_baseDataID."'
				";
			} else {
				$sql = "
					insert into
						pagesBaseData_edited
					set
						".$sql_fields;
			}
			$q = new CMS_query($sql);
			if (!$q->hasError() && !$this->_baseDataID) {
				$this->_baseDataID = $q->getLastInsertedID();
			}
		}
		return true;
	}
	
	/**
	  * Duplicate current page into another one
	  * All contents and external datas are duplicated too
	  * 
	  * @param CMS_user user, the user processing to creation
	  * @param integer templateID, a new template to duplicate the page with
	  * @param boolean $dontDuplicateContent If true, the content of the page is not duplicated
	  * @return CMS_page newly created, or null on error
	  */
	function duplicate(&$user, $templateID=0, $dontDuplicateContent = false)
	{
		$pg = null;
		if ($user->hasPageClearance($this->getID(), CLEARANCE_PAGE_VIEW)
			&& $user->hasModuleClearance(MOD_STANDARD_CODENAME, CLEARANCE_MODULE_EDIT)) {
			$pg = new CMS_page();
			$pg->lock($user);
			$pg->addEdition(RESOURCE_EDITION_CONTENT, $user);
			//Which template to use?
			if (!$templateID) {
				$newTpl = CMS_pageTemplatesCatalog::getCloneFromID($this->_templateID, false, true, false, $this->_templateID);
			} else {
				$newTpl = CMS_pageTemplatesCatalog::getCloneFromID($templateID, false, true, false, $this->_templateID);
			}
			if (!is_a($newTpl, 'CMS_pageTemplate') || $newTpl->hasError()) {
				$this->raiseError("Error during template clone creation.");
			} else {
				$pg->setTemplate($newTpl->getID()) ;
			}
			//Duplicate page base datas
			$pg->setTitle($this->getTitle(), $user);
			$pg->setLinkTitle($this->getLinkTitle(), $user);
			$pg->setDescription($this->getDescription(), $user);
			$pg->setKeywords($this->getKeywords(), $user);
			$pg->setPublicationDates($this->getPublicationDateStart(false), $this->getPublicationDateEnd(false));
			$pg->setReminderOn($this->getReminderOn(), $user);
			$pg->setReminderOnMessage($this->getReminderOnMessage(), $user);
			$pg->setCategory($this->getCategory(), $user);
			$pg->setAuthor($this->getAuthor(), $user);
			$pg->setReplyto($this->getReplyto(), $user);
			$pg->setCopyright($this->getCopyright(), $user);
			$pg->setLanguage($this->getLanguage(), $user);
			$pg->setRobots($this->getRobots(), $user);
			$pg->setPragma($this->getPragma(), $user);
			$pg->setRefresh($this->getRefresh(), $user);
			$pg->setRedirectLink($this->getRedirectLink(), $user);
			$pg->setMetas($this->getMetas(), $user);
			if (SensitiveIO::isPositiveInteger($this->getReminderPeriodicity())) {
				$pg->setReminderPeriodicity($this->getReminderPeriodicity(), $user);
			}
			$pg->writeToPersistence();
			$pg->unlock();
			
			//Duplicate contents, get all blocks and duplicate them
			if (!$dontDuplicateContent) {
				$this->duplicateContent($user, $pg);
			}
		} else {
			$this->raiseError("User doesn't have rights to do this creation");
		}
		return $pg;
	}
	
	/**
	  * Duplicate current page contents into another one
	  * All contents and external datas are duplicated too
	  * 
	  * @param CMS_user user, the user processing to creation
	  * @return boolean true on success, false on failure
	  */
	function duplicateContent(&$user, &$page)
	{
		$_proceed = true ;
		if (!is_a($page, "CMS_page") || !is_a($user,"CMS_profile_user")) {
			$_proceed = false ;
		} else {
			//Duplicate contents, get all blocks and duplicate them
			$_allBlocks = CMS_blocksCatalog::getAllBlocksForPage($this, false);
			$page->lock($user);
			$page->addEdition(RESOURCE_EDITION_CONTENT, $user);
			foreach ($_allBlocks as $b) {
				if (!$done = $b->duplicate($page)) {
					$_proceed = false ;
				}
			}
			$page->writeToPersistence();
			$page->unlock();
		}
		return $_proceed ;
	}
	
	/**
	  * Get the array of visualization modes, without textual information as it's useless
	  * Static function.
	  *
	  * @return void
	  * @access private
	  */
	function getAllVisualizationModes()
	{
		return array(	PAGE_VISUALMODE_FORM, 
						PAGE_VISUALMODE_HTML_PUBLIC,
						PAGE_VISUALMODE_HTML_EDITED,
						PAGE_VISUALMODE_HTML_EDITION,
						PAGE_VISUALMODE_CLIENTSPACES_FORM,
						PAGE_VISUALMODE_PRINT,
						PAGE_VISUALMODE_HTML_PUBLIC_INDEXABLE);
	}
}
?>