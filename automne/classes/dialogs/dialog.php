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
// | Author: Andre Haynes <andre.haynes@ws-interactive.fr> &              |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: dialog.php,v 1.7 2010/03/08 16:43:31 sebastien Exp $

/**
  * Class CMS_dialog
  *
  * Interface generation
  * This class is deprecated since Automne V4, only here for compatibility with old modules.
  *
  * @package Automne
  * @subpackage deprecated
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_dialog extends CMS_JSDialog
{
	const MESSAGE_JOURNAL = 29;  
	const MESSAGE_TEMPLATES = 30;
	const MESSAGE_META = 31;
	const MESSAGE_QUIT = 32;
	const MESSAGE_PERSONAL_PROFILE = 120;
	const MESSAGE_WEBSITE = 1070;
	const MESSAGE_CALENDAR = 1071;
	const MESSAGE_ARCHIVES = 859;
	const MESSAGE_STATS = 1072;
	const MESSAGE_PROFILES = 73;
	const MESSAGE_HELP = 1073;
	const MESSAGE_SUMMARY = 26;
	const MESSAGE_SEARCH = 212;
	const MESSAGE_MODULES_ADMIN = 264;
	
	/**
	  * Title of page to display
	  *
	  * @var string
	  * @access private
	  */
	protected $_title;
	
	/**
	  * Sub - Title of page to display
	  *
	  * @var string
	  * @access private
	  */
	protected $_subTitle;
	
	/**
	  * Title picto of page to display
	  *
	  * @var string
	  * @access private
	  */
	protected $_picto=false;
		
	/**
	  * Stores context object
	  *
	  * @var CMS_context
	  * @access private
	  */
	protected $_context;
	
	/**
	  * Bookmark
	  *
	  * @var integer = 1
	  * @access private
	  */
	protected $_bookmark = 1;
	
	/**
	  * Contenu
	  *
	  * @var string
	  * @access private
	  */
	protected $_content;
	
	/**
	  * Back Link from page
	  *
	  * @var string
	  * @access private
	  */
	protected $_backLink;
	
	/**
	  * Tree root
	  *
	  * @var integer
	  * @access private
	  */
	protected $_treeRoot = false;

	/**
	  * Sub Menu
	  *
	  * @var array
	  * @access private
	  */
	protected $_subMenu = array();

	/**
	  * Logo : does the logo should appear
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_logo = true;

	/**
	  * Menu : does the menu should appear
	  *
	  * @var boolean
	  * @access private
	  */
	protected $_menu = true;
	
	/**
	  * Action Message
	  *
	  * @var string
	  * @access private
	  */	
	protected $_actionMessage;
	
	/**
	  * Should the content be parsed
	  *
	  * @var boolean
	  * @access private
	  */	
	protected $_dontParse = false;
	
	/**
	  * Text that must appear just before the closing body tag (used by image resizing)
	  *
	  * @var string
	  * @access private
	  */	
	protected $_beforeBody = '';
	
	/**
	  * url of the Main Frame
	  *
	  * @var string
	  * @access private
	  */
	protected $_mainFrame = '';
	
	/**
	  * make the focus on first text field
	  *
	  * @var boolean default true
	  * @access private
	  */
	protected $_makeFocus = true;
	
	/**
	  * page display mode
	  *
	  * @var string default false (in frame page)
	  * @access private
	  */
	protected $_displayMode = false;
	
	/**
	  * Constructor.
	  *
	  * @return void
	  * @access public
	  */
	public function __construct()
	{
		$this->_context = $_SESSION["cms_context"];
		
		if (!is_a($this->_context, "CMS_context")) {
			die("Invalid context.");
		} 
	}
	
	/**
	  * Set dialog Title
	  *
	  * @param string $title
	  * @param string $picto (the html code of a picto)
	  * @return void
	  * @access public
	  */
	public function setTitle($title, $picto=false)
	{
		$this->_title = $title;
		if ($picto) {
			$this->_picto = $picto;
		}
	}
	
	/**
	  * Set dialog Sub Title
	  *
	  * @param string $subtitle
	  * @return void
	  * @access public
	  */
	public function setSubTitle($subtitle)
	{
		$this->_subTitle = $subtitle;
	}
	
	/**
	  * Set text appearing before body tag (usually javascript)
	  *
	  * @param string $text
	  * @return void
	  * @access public
	  */
	public function setTextBeforeBody($text)
	{
		$this->_beforeBody .= $text;
	}
	
	/**
	  * Get dialog Title
	  * 
	  * @return string
	  * @access public
	  */
	public function getTitle()
	{
		$title = ($this->_subTitle) ? $this->_title.' - '.$this->_subTitle:$this->_title;
		return $title;
	}
	
	/**
	  * Set Tree root
	  *
	  * @param integer $treeRoot
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setTreeRoot($treeRoot)
	{
		if (!SensitiveIO::isPositiveInteger($treeRoot)) {
			$this->setError("Root is not a positive integer");
			return false;
		} else {
			$this->_treeRoot = $treeRoot;
			return true;
		}
	}
	
	/**
	  * Get Tree root
	  * 
	  * @return integer the tree root DB ID
	  * @access public
	  */
	public function getTreeRoot()
	{
		return $this->_treeRoot;
	}

	/**
	  * Set menu flag. If false, no menu displayed
	  *
	  * @param boolean $menu
	  * @return void
	  * @access public
	  */
	public function setMenu($menu)
	{
		$this->_menu = ($menu) ? true : false;
	}

	/**
	  * Set logo
	  *
	  * @param boolean $logo
	  * @return void
	  * @access public
	  */
	public function setLogo($logo)
	{
		$this->_logo = $logo;
	}
	
	/**
	  * Has logo
	  * 
	  * @return boolean
	  * @access public
	  */
	public function hasLogo()
	{
		return $this->_logo;
	}
	
	/**
	  * Get context
	  * 
	  * @return CMS_context
	  * @access public
	  */
	public function getContext()
	{
		return $this->_context;
	}
	
	/**
	  * Set bookmark
	  *
	  * @param integer $bookmark
	  * @return void
	  * @access public
	  */
	public function setBookmark($bookmark)
	{
		if (SensitiveIO::isPositiveInteger($bookmark)) {
			$this->_bookmark = $bookmark;
		} else {
			$this->setError("Incorrect bookmark type");
		}
	}
	
	/**
	  * Get bookmark
	  * 
	  * @return integer
	  * @access public
	  */
	public function getBookmark()
	{
		return $this->_bookmark;
	}
	
	/**
	  * Set content
	  *
	  * @param string $content
	  * @param boolean $dontParse If set to true, the content won't be parsed (useful when showing broken XML)
	  * @return void
	  * @access public
	  */
	public function setContent($content, $dontParse = false)
	{
		$this->_dontParse = $dontParse;
		$this->_content = $content;
	}
	
	/**
	  * Get content
	  * 
	  * @return integer
	  * @access public
	  */
	public function getcontent()
	{
		return $this->_content;
	}	

	/**
	  * Set Back Link
	  *
	  * @param string $backLink
	  * @return void
	  * @access public
	  */
	public function setBackLink($backLink)
	{
		$this->_backLink = $backLink;
	}
	
	/**
	  * Get Back Link
	  * 
	  * @return string
	  * @access public
	  */
	public function getBackLink()
	{
		return $this->_backLink;
	}
	
	/**
	  * set the main frame URL
	  * 
	  * @param string $main
	  * @return true
	  * @access public
	  */
	public function setMain($main)
	{
		$this->_mainFrame=$main;
		return true;
	}
	
	/**
	  * Displays Admin frameset
	  *
	  * @return void
	  * @access public
	  */
	public function showFrames()
	{
		if (!$this->_context->getSessionVar('largeur')) {
			$this->_context->setSessionVar('largeur','200');
		}
		if (!$this->_context->getSessionVar('hauteurArbo') && $this->_context->getSessionVar('hauteurArbo')!='0') {
			$this->_context->setSessionVar('hauteurArbo','*');
		}
		
		if (!$this->_context->getSessionVar('treeHref') && $this->_context->getSessionVar('hauteurArbo')!='0') {
			$user = $this->_context->getUser();
			//THE USER SECTIONS, Check if user has module administration, else hide Modules Frame
			$sections_roots=array();
			$sections_roots = $user->getEditablePageClearanceRoots();
			
			if (is_array($sections_roots) && $sections_roots) {
				$this->_context->setSessionVar('sectionsRoots',$sections_roots);
				$root = '9999999';
				$count='0';
				foreach ($sections_roots as $rootID) {
					$pg = CMS_tree::getPageByID($rootID);
					if ($pg && !$pg->hasError()) {
						$root = ($rootID<$root) ? $rootID: $root;
					}
				}
				//build tree link
				$treeHref = PATH_ADMIN_SPECIAL_TREE_WR;
				$treeHref .= '?root='.$root;
				$treeHref .= '&frame=1';
				$treeHref .= '&encodedPageLink='.base64_encode(PATH_ADMIN_SPECIAL_PAGE_SUMMARY_WR.chr(167).chr(167).'page=%s');
				$this->_context->setSessionVar('treeHref',$treeHref);
			} else {
				$treeHref ='';
				$this->_context->setSessionVar('hauteurArbo','0');
			}
		}
		
		if (!$this->_context->getSessionVar('hauteurModules') && $this->_context->getSessionVar('hauteurModules')!='0') {
			$this->_context->setSessionVar('hauteurModules','200');
			
			$user = $this->_context->getUser();
			//THE MODULES ADMINISTRATIONS, Check if user has module administration, else hide Modules Frame
			$modules = CMS_modulesCatalog::getALL();
			$modules_good = array();
			foreach ($modules as $module) {
				if ($module->getCodename() != MOD_STANDARD_CODENAME
					&& $user->hasModuleClearance($module->getCodename(), CLEARANCE_MODULE_EDIT)) {
					$modules_good[] = $module;
				}
			}
			if (!$modules_good) {
				$this->_context->setSessionVar('hauteurModules','0');
			}
		}
		if ($this->_context->getSessionVar('hauteurArbo') == '0' && $this->_context->getSessionVar('hauteurModules') == '0') {
			//current user have not any admin rights so logout !
			header("Location: ".PATH_ADMIN_SPECIAL_LOGIN_WR."?cms_message_id=65&cms_action=logout&".session_name()."=".session_id());
			exit;
		}
		
		$main = ($this->_mainFrame) ? $this->_mainFrame:PATH_ADMIN_SPECIAL_ENTRY_WR;
		
		if (VIEW_SQL && STATS_DEBUG && SYSTEM_DEBUG) {
			$this->_context->setSessionVar('hauteurFrameChecker','50');
		} else {
			$this->_context->setSessionVar('hauteurFrameChecker','0');
		}
		
		$frameset = "
			<SCRIPT type=text/javascript>
			<!--
			    document.writeln('<frameset cols=\"".$this->_context->getSessionVar('largeur').",*\" rows=\"*\" border=\"1\" frameborder=\"1\" framespacing=\"0\">');
			    document.writeln('    <frameset rows=\"".$this->_context->getSessionVar('hauteurArbo').", ".$this->_context->getSessionVar('hauteurModules').",".$this->_context->getSessionVar('hauteurFrameChecker')."\" framespacing=\"0\" frameborder=\"0\" border=\"0\">');
			    document.writeln('        <frame src=\"".$this->_context->getSessionVar('treeHref')."\" name=\"arbo\" border=\"1\" frameborder=\"1\" />');
			    document.writeln('        <frame src=\"modules.php\" name=\"modules\" border=\"1\" frameborder=\"1\" />');
				document.writeln('        <frame src=\"frameChecker.php\" name=\"frameChecker\" frameborder=\"0\" scrolling=\"no\" />');
			    document.writeln('    </frameset>');
				document.writeln('    <frameset rows=\"72, *\" framespacing=\"0\" frameborder=\"0\" border=\"0\">');
			    document.writeln('        <frame src=\"menu.php\" name=\"menu\" frameborder=\"0\" scrolling=\"no\" />');
			    document.writeln('        <frame src=\"".$main."\" name=\"main\" border=\"0\" frameborder=\"0\" />');
			    document.writeln('    </frameset>');
			    document.writeln('    <noframes>');
			    document.writeln('        <body bgcolor=\"#FFFFFF\">');
			    document.writeln('            <p>L\'utilisation d\'Automne nécéssite un navigateur <b>supportant les \"frames\"</b>.</p>');
			    document.writeln('            <p>The use of Automne requires a navigator <b>supporting frames</b>.</p>');
			    document.writeln('        </body>');
			    document.writeln('    </noframes>');
			    document.writeln('</frameset>');
			//-->
			</SCRIPT>";
		return $frameset;
	}

	/**
	  * Display for menu
	  *
	  * @return string
	  * @access private
	  */
	protected function _writeMenu()
	{
		if ($this->_menu) {
			$user = $this->_context->getUser();
			$language = $user->getLanguage();
			
			$menu = '
				<table width="700" height="72" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="562" height="72" valign="top" class="admin">
							<table width="562" height="30" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="472" height="30" class="admin_date">
										'.$language->getMessage(self::MESSAGE_WEBSITE).' <a href="'.CMS_websitesCatalog::getMainURL().'" target="_blank" class="admin_menu_back"><span class="admin_site_label">'.APPLICATION_LABEL.'</span></a> - <b>'. date($language->getDateFormat(), time()) . '</b></td>
									<td width="90" height="30" class="admin"><a href="http://www.automne-cms.org" target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/powered.gif" border="0" /></a></td>
								</tr>
							</table>
							<table width="562" height="40" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="562" height="1" colspan="20"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td>
								</tr>
								<tr>
									<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_SPECIAL_ENTRY_WR. '" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/sommaire.gif" border="0" title="'.$language->getMessage(self::MESSAGE_SUMMARY).'" /></a></td>
									<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITUSERS)) {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/profiles_user.php?userId='.$user->getUserId().'" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/profils.gif" border="0" title="'.$language->getMessage(self::MESSAGE_PERSONAL_PROFILE).'" /></a></td>
										<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>
										<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/profiles_users.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/comptes.gif" border="0" title="'.$language->getMessage(self::MESSAGE_PROFILES).'" /></a></td>
										<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								} else {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/profiles_user.php?userId='.$user->getUserId().'" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/profils.gif" border="0" title="'.$language->getMessage(self::MESSAGE_PERSONAL_PROFILE).'" /></a></td>
										<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								}
								if ($user->hasValidationClearance(MOD_STANDARD_CODENAME)) {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/archives.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/archives.gif" border="0" title="'.$language->getMessage(self::MESSAGE_ARCHIVES).'" /></a></td>
											<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								}
								if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_TEMPLATES) || $user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/templates.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/modeles.gif" border="0" title="'.$language->getMessage(self::MESSAGE_TEMPLATES).'" /></a></td>
											<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								}
								
	/* Calendar Menu Link */	/*if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWCALENDAR)) {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/calendar.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/calendrier.gif" border="0" title="'.$language->getMessage(self::MESSAGE_CALENDAR).'" /></a></td>
											<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								}*/
	/* Stats Menu Link */		/*if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_STATS)) {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/stats.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/stats.gif" border="0" title="'.$language->getMessage(self::MESSAGE_STATS).'" /></a></td>
											<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								}*/
								if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_VIEWLOG)) {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/logs.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/journal.gif" border="0" title="'.$language->getMessage(self::MESSAGE_JOURNAL).'" /></a></td>
											<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								}
								if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/modules_admin.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/base.gif" border="0" title="'.$language->getMessage(self::MESSAGE_MODULES_ADMIN).'" /></a></td>
											<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								}
								if ($user->hasAdminClearance(CLEARANCE_ADMINISTRATION_REGENERATEPAGES) || $user->hasAdminClearance(CLEARANCE_ADMINISTRATION_DUPLICATE_BRANCH) || $user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
									$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/meta_admin.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/meta.gif" border="0" title="'.$language->getMessage(self::MESSAGE_META).'" /></a></td>
											<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								}
	/* Help Menu Link*/			$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" onClick="checkFrameSize();"><a href="' .PATH_ADMIN_WR. '/help.php" target="main" class="admin_menu"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/aide.gif" border="0" title="'.$language->getMessage(self::MESSAGE_HELP).'" /></a></td>
									<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>';
								$menu .= '<td width="32" height="40" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');"><a href="' .PATH_ADMIN_SPECIAL_LOGIN_WR. '?cms_action=logout" class="admin_menu" target="_top"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/quitter.gif" border="0" title="'.$language->getMessage(self::MESSAGE_QUIT).'" /></a></td>
									<td width="1" height="40" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>
									<form action="search.php" target="main" method="post">
									<td width="3000" height="40" align="right">
										<input type="text" name="search" class="admin_search" value="'.$language->getMessage(self::MESSAGE_SEARCH).'" onFocus="clearField(this);" onBlur="checkField(this);" /><input type="image" name="valid" align="absmiddle" src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/search.gif" value="'.$language->getMessage(self::MESSAGE_SEARCH).'" />
									</td>
									</form>
								</tr>
							</table>
						</td>
						<td width="138" height="72"><a href="'.CMS_websitesCatalog::getMainURL().'" target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/logo.png" class="png" width="138" height="72" border="0" /></a></td>
					</tr>
				</table>';
			
			return $menu;
		}
		
	}
	
	/**
	  * dont make the Focus usefull with screen with Tab (Onglet)
	  * wich sometimes hide text fields and cause javascript error on IE
	  *
	  * @return string : the javascript to add
	  * @access private
	  */
	protected function dontMakeFocus()
	{
		$this->_makeFocus = false;
		return true;
	}
	
	/**
	  * add Automne copyright on generated HTML in backend
	  *
	  * @return string : the copyright to add
	  * @access private
	  */
	protected function copyright()
	{
		$copyright = "\n<!-- \n"
		."+----------------------------------------------------------------------+\n"
		."| Automne (TM)  www.automne-cms.org                                    |\n"
		."| Copyright (c) 2000-".date('Y')." WS Interactive www.ws-interactive.fr         |\n"
		."+----------------------------------------------------------------------+\n"
		."-->\n";
		return $copyright;
	}
	
	/**
	  * Writes message
	  *
	  * @return void
	  * @access private
	  */
	protected function _showMessage()
	{
		
		if ($this->_actionMessage) {
			return '
				<table border="0" width="100%">
				<tr>
					<td align="left">
						<pre class="admin_text_alert">'.SensitiveIO::sanitizeHTMLString($this->_actionMessage).'</pre>
					</td>
				</tr>
				</table>
				<br />
			';
		}
	}
	
	/**
	  * Displays Admin page
	  *
	  * @param mixed $mode : the display mode to use in :
	  *  - boolean false : default mode, used by main frame page
	  *  - string 'menu' : used by menu frame page
	  *  - string 'modules' : used by modules frame page
	  *  - string 'arbo' : used by tree arbo frame page
	  *  - string 'frames' : used by general frames page
	  *  - string 'out' : used by out of frames page
	  *  - string 'frameChecker' : used by frameChecker page
	  *  - string 'loading' : used by loading frame page (send content when received without closing page content)
	  * @return void
	  * @access public
	  */
	public function show($mode = false)
	{
		$this->_displayMode = $mode;
		switch ($this->_displayMode) {
			case 'menu' :
			case 'frameChecker':
			case 'modules':
			case 'arbo':
			case 'frames':
				$this->_showHead();
				$this->_showBody();
			break;
			default:
				$this->_showHead();
				$this->_showBody();
				if ($this->_displayMode != "loading") {
					/*only for stats*/
					if (STATS_DEBUG && $_SERVER["SCRIPT_NAME"] != PATH_ADMIN_WR.'/stat.php') {
						echo CMS_stats::view();
					}
				}
			break;
			
		}
		if ($this->_displayMode != "loading") {
			echo "\n</html>";
		}
	}
	
	/**
	  * Writes html header
	  *
	  * @return void
	  * @access private
	  */
	protected function _showHead()
	{
		switch ($this->_displayMode) {
			case 'frames':
				$redir = (isset($_REQUEST["redir"])) ? $_REQUEST["redir"] : null;
				echo '
					<html>
					<head>
						'.$this->copyright().'
						<meta http-equiv="Content-Type" content="text/html; charset='.APPLICATION_DEFAULT_ENCODING.'" />
						<title>' . $this->_title . '</title>
						<link rel="stylesheet" type="text/css" href="' . PATH_ADMIN_CSS_WR.'/../v3/css/main.css" />
						<link rel="icon" type="image/png" href="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/favicon.png" />
						<meta http-equiv="pragma" content="no-cache" />
						<script type="text/javascript" language="javascript">
							if (window.top != window.self) {
						    	window.top.location.replace(\''.PATH_ADMIN_SPECIAL_FRAMES_WR.'?redir='.$redir.'&'.session_name().'='.session_id().'\');
							}
					    </script>
					'.$this->showFrames().'
					</head>';
			break;
			case 'menu' :
				$this->addFrameCheck();
				$this->addSearchCheck();
			case 'modules':
			case 'arbo':
				echo '
					<html>
					<head>
						'.$this->copyright().'
						<link rel="stylesheet" type="text/css" href="' . PATH_ADMIN_CSS_WR.'/../v3/css/main.css" />
						<meta http-equiv="Content-Type" content="text/html; charset='.APPLICATION_DEFAULT_ENCODING.'" />
						<meta http-equiv="pragma" content="no-cache" />
						'.$this->_javascript.'
					</head>';
			break;
			case 'frameChecker':
				echo '
					<html>
					<head>
						'.$this->copyright().'
						<link rel="stylesheet" type="text/css" href="' . PATH_ADMIN_CSS_WR.'/../v3/css/main.css" />
						<meta http-equiv="pragma" content="no-cache" />
						<meta http-equiv="Content-Type" content="text/html; charset='.APPLICATION_DEFAULT_ENCODING.'" />
						<script language="JavaScript" type="text/javascript">
							function initJavascript() {
								if (typeof reloadTree == "function") {
									reloadTree();
								}
								if (typeof reloadModules == "function") {
									reloadModules();
								}
							}
						</script>
						'.$this->_javascript.'
					</head>';
			break;
			default:
				$this->addFrameCheck();
				$this->addJavascriptCheck($this->_makeFocus);
				echo '
					<html>
					<head>
						'.$this->copyright().'
						<meta http-equiv="Content-Type" content="text/html; charset='.APPLICATION_DEFAULT_ENCODING.'" />
						<title>'.APPLICATION_LABEL. " :: " . $this->getTitle() . '</title>
						<link rel="stylesheet" type="text/css" href="' . PATH_ADMIN_CSS_WR.'/../v3/css/main.css" />
						<meta http-equiv="pragma" content="no-cache" />
						'.$this->_javascript.'
					</head>';
			break;
		}
	}
	
	/**
	  * Shows body of html page
	  *
	  * @return void
	  * @access private
	  */
	protected function _showBody()
	{
			switch ($this->_displayMode) {
			case 'menu' :
				echo '
					<body marginheight="0" background="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/fond_menu.gif" marginwidth="0" leftmargin="0" topmargin="0" class="admin">
						'.$this->_writeMenu().'
					</body>
					';
			break;
			case 'frames':
				echo '
					<body>
					'.$this->_parseContent($this->_content).'
					</body>
					';
			break;
			case 'frameChecker':
				echo '
					<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" class="frame" onLoad="initJavascript();">
					'.$this->_parseContent($this->_content).'
					</body>
					';
			break;
			case 'arbo':
				echo '
					<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" class="frame">
						
					'.$this->_getTitleDesign($this->_title,"admin_frame","picto_pages.gif") . '
					
					'.$this->_showMessage().'
					'.$this->_parseContent($this->_content).'
					</body>
				';
			break;
			case 'modules':
				echo '
					<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" class="frame">
						
					'.$this->_getTitleDesign($this->_title,"admin_frame","picto_modules.gif") . '
					
					'.$this->_showMessage().'
					'.$this->_parseContent($this->_content).'
					</body>
				';
			break;
			
			default:
				$user = $this->_context->getUser();
				$language = $user->getLanguage();
				echo '<body marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" class="admin" onLoad="initJavascript();">';
				//content is out of frames, so add Automne content header and do not display menu
				if ($this->_displayMode == 'out') {
					echo '
					<table width="100%" height="72" border="0" cellpadding="0" cellspacing="0" style="background:url('.PATH_ADMIN_IMAGES_WR.'/../v3/img/fond.gif) repeat-x bottom left;">
						<tr>
							<td width="562" height="72" valign="top" class="admin">
								<table width="562" height="30" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="472" height="30" class="admin_date">
											<!--&nbsp;&nbsp;<span class="admin_site_label">'.APPLICATION_LABEL.'</span> - <b>'. date($language->getDateFormat(), time()) . '</b>--></td>
										<td width="90" height="30" class="admin"><a href="http://www.automne-cms.org" target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/powered.gif" border="0" /></a></td>
									</tr>
								</table>
								<table width="562" height="42" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="562" height="42" background="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/fond.gif" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="562" height="1" border="0" /><br />
											'.$this->_getSubMenu().'
										</td>
									</tr>
								</table>
							</td>
							<td width="138" height="72"><a href="'.CMS_websitesCatalog::getMainURL().'" target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/logo.png" class="png" width="138" height="72" border="0" /></a></td>
							<td width="100%" height="72" valign="top" class="admin">
								<table width="100%" height="72" border="0" cellpadding="0" cellspacing="0">
									<tr>
										<td width="100%" height="30"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td>
									</tr>
									<tr>
										<td width="100%" height="42" background="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/fond.gif"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>';
				} else {
					echo $this->_getSubMenu();
				}
				//display content
				echo '
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td width="15"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/pix_trans.gif" border="0" width="15" height="1" /></td>
							<td class="admin">';
								if ($this->_title) {
									echo $this->_getTitleDesign($this->_title,"admin_h1",$this->_picto);
								}
								echo '<br />'.$this->_showMessage();
								$replace = array(
									PATH_ADMIN_WR => '',
									'modules/' => '',
									'/' => '_',
									'.php' => ''
								);
								if (io::strpos($_SERVER["SCRIPT_NAME"], '/polymod/') !== false
									&& isset($_REQUEST['polymod'])) {
									$replace['polymod'] = $_REQUEST['polymod'];
								}
								$filename = sensitiveIO::sanitizeAsciiString(str_replace(array_keys($replace),$replace,$_SERVER["SCRIPT_NAME"]));
								if (file_exists(PATH_ADMIN_FS.'/inc/'.$filename."_".$language->getCode().".inc.php")) {
									include_once(PATH_ADMIN_FS.'/inc/'.$filename."_".$language->getCode().".inc.php");
								}
								echo '
								'.$this->_parseContent($this->_content).'
								<br />
							</td>
						</tr>
					</table>
					' . $this->_beforeBody;
					if ($this->_displayMode != "loading") {
						echo '</body>';
					} else {
						//add loading class
						require_once("loadingDialog.php");
						//start loading mode
						CMS_LoadingDialog::startLoadingMode();
					}
			break;
		}
	}

	/**
	  * Sets action message
	  *
	  * @param string message
	  * @return void
	  * @access public
	  */
	public function setActionMessage($message)
	{
		$this->_actionMessage = $message;
	}

	/**
	  * Get action message
	  *
	  * @param string message
	  * @return void
	  * @access public
	  */
	public function getActionMessage()
	{
		return $this->_actionMessage;
	}
	
	/**
	  * Goes to CMS style sheet to get title desing
	  *
	  * @param string $title
	  * @param string $class
	  * @return void
	  * @access private
	  */
	protected function _getTitleDesign($title, $class,$picto=false)
	{
		switch ($class) {
		case "admin_h1" :
			$img_src=  "puce-h1.gif" ;
			$design = '
			<br /><table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>';
			if ($picto) {
				$picto = (io::strpos($picto,'<img')) ? $picto:'<img src="' .PATH_ADMIN_IMAGES_WR ."/../v3/img/". $picto. '" border="0" />';
				$design .= '<td rowspan="2">'.$picto.'</td><td rowspan="2"><img src="' .PATH_ADMIN_IMAGES_WR .'/pix_trans.gif" width="5" height="1" border="0" /></td>';
			}
				$design .= '<td><span class="' .$class. '">' .$title.'</span>';
				if ($this->_subTitle) {
					$design .= '&nbsp;-&nbsp;<span class="admin_subTitle">'.$this->_subTitle.'</span>';
				}
				$design .= '&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td height="1" width="100%" background="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/tiret.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td>
			</tr>
			</table>
			' ;
			break ;
		case "admin_h2" :
			if ($picto) {
				$picto = (io::strpos(base64_decode($picto),'<img')) ? base64_decode($picto):'<img src="' .PATH_ADMIN_IMAGES_WR ."/../v3/img/". $picto. '" border="0" />';
			}
			$img_td= ($picto) ? '<td bgcolor="#FFFFFF" rowspan="2" valign="top" height="22">'.$picto.'</td><td rowspan="2"><img src="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/pix_trans.gif" width="5" height="1" border="0" /></td>':"" ;
			$title = ($picto) ? $title : '> '.$title;
			$design = '
			<table border="0" width="100%" cellpadding="0" cellspacing="0" height="22">
			<tr>
				'.$img_td.'
				<td bgcolor="#FFFFFF" width="100%" valign="top" height="21"><span class="' .$class. '">' .$title. '</span></td>
			</tr>
			<tr>
				<td height="1" width="100%" background="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/tiretv.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td>
			</tr>
			</table>
			' ;
			break ;
		case "admin_h3" :
			$img_td= ($picto) ? '<td valign="top"><img src="' .PATH_ADMIN_IMAGES_WR ."/../v3/img/". $picto. '" border="0" /></td>':"" ;
			$title = ($picto) ? $title : '> '.$title;
			$design = '
			<table border="0" cellpadding="2" cellspacing="0">
			<tr>
				'.$img_td.'
				<td width="100%"><span class="' .$class. '">' .$title. '</span></td>
			</tr>
			</table>
			' ;
			break ;
		case "admin_frame" :
			$design = '
			<table border="0" cellpadding="0" cellspacing="0" width="'.($this->_context->getSessionVar('largeur')-2).'">
			<tr>
				<td height="1" background="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/tiret.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td>
			</tr>
			<tr>
				<td height="15" bgcolor="#BEB7B5" width="100%" align="center"><span class="' .$class. '"><img src="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/'.$picto.'" border="0" align="absmiddle" /> ' .$title. '</span></td>
			</tr>
			<tr>
				<td height="1" background="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/tiret.gif"><img src="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/pix_trans.gif" width="1" height="1" border="0" /></td>
			</tr>
			</table><br />
			' ;
			break ;
		case "module_title" :
			$design = '
			<table border="0" cellpadding="2" cellspacing="5">
				<tr>
					<td><img src="' .PATH_ADMIN_IMAGES_WR .'/../v3/img/logo_small.gif" width="30" height="26" alt="" border="0" /></td>
					<td class="admin" style="font-weight: bold;">' .$title. '</td>
				</tr>
			</table>';
		break;
		default:
			return false;
		}
		return $design ;
	}

	/**
	  * Parse the content looking for some special XML tags that will be interpretad :
	  * - dialog-title : a title rendered with an image
	  * - dialog-pages : a pages navigation row
	  *
	  * @param string $body xml that will be parsed
	  * @return void
	  * @access public
	  */
	protected function _parseContent($body)
	{
		if ($this->_dontParse) {
			return $this->_content;
		}
		$datas = str_replace("\n", '§§', $body);
		//dialog-title
		while (true) {
			$regs= array();
			preg_match('/<dialog-title [^>]*>.*<\/dialog-title>/U', $datas, $regs);
			if (isset($regs[0]) && $regs[0]) {
				$domdocument = new CMS_DOMDocument();
				try {
					$domdocument->loadXML('<dummy>'.$regs[0].'</dummy>');
				} catch (DOMException $e) {
					$this->setError('Parse error during search for module-param parameters : '.$e->getMessage()." :\n".io::htmlspecialchars($regs[2]));
					return $this->_content;
				}
				$paramsTags = $domdocument->getElementsByTagName('dialog-title');
				foreach ($paramsTags as $paramTag) {
					if (strtolower(APPLICATION_DEFAULT_ENCODING) != 'utf-8') {
						$param_value = $this->_getTitleDesign(utf8_decode($paramTag->textContent), $paramTag->getAttribute("type"));
					} else {
						$param_value = $this->_getTitleDesign($paramTag->textContent, $paramTag->getAttribute("type"));
					}
				}
				$datas = str_replace($regs[0], $param_value, $datas);
			} else {
				break;
			}
		}
		//dialog-pages
		/* Exemple :
		<dialog-pages maxPages="22" boomarkName="rowsBookmark">
			<dialog-pages-param name="currentOnglet" value="1" />
		</dialog-pages>
		*/
		while (true) {
			$regs= array();
			preg_match('/<dialog-pages [^>]*>.*?<\/dialog-pages>/', $datas, $regs);
			if (isset($regs[0])) {
				$domdocument = new CMS_DOMDocument();
				try {
					$domdocument->loadXML('<dummy>'.$regs[0].'</dummy>');
				} catch (DOMException $e) {
					$this->setError('Parse error during search for dialog-pages parameters : '.$e->getMessage()." :\n".io::htmlspecialchars($regs[2]));
					return $this->_content;
				}
				$paramsTags = $domdocument->getElementsByTagName('dialog-pages');
				foreach ($paramsTags as $paramTag) {
					$maxPages = ((int) $paramTag->getAttribute("maxPages")) ? (int) $paramTag->getAttribute("maxPages") : 1;
					$boomarkName = $paramTag->getAttribute("boomarkName") ? $paramTag->getAttribute("boomarkName") : 'bookmark';
				}
				$paramsTags = $domdocument->getElementsByTagName('dialog-pages-param');
				$extra = '';
				foreach ($paramsTags as $paramTag) {
					$extra .= '&amp;'.$paramTag->getAttribute("name").'='.$paramTag->getAttribute("value");
				}
				$links = '<b>';
				// Loop through and create page links
				for($i=0; $i < $maxPages; $i++) {
					$currentBookmark = ($boomarkName != 'bookmark') ? $this->_context->getSessionVar($boomarkName) : $this->_context->getBookmark();
					if (($i+1) == $currentBookmark) {
						$links .= ' <span class="admin_current">'.($i+1).'</span> ';
					} else {
						$links .= '<a class="admin" href='.$_SERVER['SCRIPT_NAME'].'?'.$boomarkName.'='.($i+1);
						if ($extra) {
							$links .= $extra;
						}
						$links .= '>'.($i+1);
						$links .= '</a> ';
					}
				}
				$links .= '</b>';
				$user = $this->_context->getUser();
				$language = $user->getLanguage();
				$tagReplacement = '
					<table border="0" cellpadding="3" cellspacing="0">
					  <tr>
						<td class="admin">
						  '.$language->getMessage(282).' : '.$links.'
						</td>
					  </tr>
					</table>
				';
				$datas = str_replace($regs[0], $tagReplacement, $datas);
			} else {
				break;
			}
		}
		$datas = str_replace("§§", "\n", $datas);
		return $datas;
	}
	
	/**
	 * 
	 * @var CMS_subMenus $submenu
	 * @return string
	 */
	public function setSubMenu($submenu)
	{
		if (is_a($submenu, "CMS_subMenus")) {
			$this->addDHTMLMenu();
			$this->_subMenu = $submenu;
			return true;
		} else {
			$this->setError("Submenu is not a valid CMS_subMenus object");
			return false;
		}
	}
	
	/**
	  * add subMenu item
	  *
	  * @param string $link url for the link
	  		if $link=='break' then add a little break image
	  * @param string $title title of the link (onMouseOver if $picto is defined, else, text title)
	  * @param string $attribute attribute for the link (default : none, ex : onClick="...")
	  * @param string $target target for the link (default : self)
	  * @param string $picto image name for the link
	  * 
	  * @return void
	  * @access public
	  */
	public function addSubMenuItem($link,$title='',$attribute=false,$target="_self",$picto=false)
	{
		$this->_subMenu[] = array('link'=>$link,'title'=>$title,'attribute'=>$attribute,'target'=>$target,'picto'=>$picto);
		return true;
	}
	
	/**
	  * Return subMenu HTML code
	  *
	  * @return string
	  * @access private
	  */
	protected function _getSubMenu()
	{
		if ($this->_subMenu || $this->getBackLink()) {
			$subMenu = '';
			if ($this->_displayMode != 'out') {
				$subMenu='
				<table width="100%" height="35" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="100%" height="35" background="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/fond_subMenu.gif" nowrap="nowrap">';
			}
					if ($this->getBackLink()) {
						$user = $this->_context->getUser();
						$language = $user->getLanguage();
						$subMenu.='
						<table height="35" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="32" height="35" onMouseOver="changeColor(this,\'A69C9A\');" onMouseOut="changeColor(this,\'\');" valign="center">&nbsp;<a href="' . $this->_backLink . '" target="_self" class="admin_menu_back">&lt;&lt;&nbsp;'.$language->getMessage(MESSAGE_BACK).'</a>&nbsp;</td>
								<td width="1" height="35" valign="center"><img src="'.PATH_ADMIN_IMAGES_WR.'/../v3/img/tireth.gif" border="0" /></td>
							</tr>
						</table>';
					}
					if ($this->_subMenu) {
						$subMenu.= $this->_subMenu->getContent();
					}
			if ($this->_displayMode != 'out') {
				$subMenu.='		
						</td>
					</tr>
				</table>';
			}
			if ($this->_subMenu) {
				$subMenu.= $this->_subMenu->getDHTMLMenu();
			}
			return $subMenu ;
		} else {
			return false;
		}
	}
	
}
?>