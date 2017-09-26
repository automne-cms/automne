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
// | Author: Cédric Soret <cedric.soret@ws-interactive.fr>                |
// | Author: David Guillot <david.guillot@ws-interactive.fr>              |
// | Author: Jérémie Bryon <jeremie.bryon@ws-interactive.fr>              |
// +----------------------------------------------------------------------+
//
// $Id: dialoghref.php,v 1.6 2010/03/08 16:43:31 sebastien Exp $

/**
  * Class CMS_dialog_href
  *
  * Class to manage XHTML formulars relative to an CMS_href object
  *
  * @package Automne
  * @subpackage dialogs
  * @author Cédric Soret <cedric.soret@ws-interactive.fr> 
  * @author David Guillot <david.guillot@ws-interactive.fr> 
  * @author Jérémie Bryon <jeremie.bryon@ws-interactive.fr>
 */

class CMS_dialog_href extends CMS_grandFather
{
	// I18NM Messages for HTML display
	const MESSAGE_PAGE_NOLINK = 275;
	const MESSAGE_PAGE_INTERNALLINK = 276;
	const MESSAGE_PAGE_EXTERNALLINK = 277;
	const MESSAGE_PAGE_TREEH1 = 1049;
	const MESSAGE_PAGE_FIELD_EDITFILE = 192;
	const MESSAGE_PAGE_EXISTING_FILE = 202;
	const MESSAGE_PAGE_NO_FILE = 10;
	const MESSAGE_PAGE_LINKFILE = 200;
	const MESSAGE_PAGE_POPUP_WIDTH = 290;
	const MESSAGE_PAGE_POPUP_HEIGHT = 291;
	const MESSAGE_PAGE_LINK_LABEL = 934;
	const MESSAGE_PAGE_TARGET_BLANK = 1024;
	const MESSAGE_PAGE_TARGET_TOP = 1023;
	const MESSAGE_PAGE_TARGET_POPUP = 1025;
	const MESSAGE_PAGE_LINK_SHOW = 1006;
	const MESSAGE_PAGE_LINK_DESTINATION = 1420;
	
	/**
	  * The Href object relative to this dialog
	  *
	  * @var CMS_href
	  * @access private
	  */
	protected $_href;
	
	/**
	  * The post prefix used
	  *
	  * @var string
	  * @access private
	  */
	protected $_prefix;
	
	/**
	  * Constructor.
	  *
	  * @param CMS_href $href
	  * @return  void
	  * @access public
	  */
	public function __construct($href, $prefixname = '')
	{
		if (!is_a($href, "CMS_href")) {
			$this->setError("Bad CMS_href given to constructor");
		}
		$this->_href = $href;
		$this->_prefix = $prefixname;
		return;
	}
	
	/**
	  * Get : The href
	  * 
	  * @return CMS_href
	  * @access public
	  */
	public function &getHref()
	{
		return $this->_href;
	}
	
	/**
	  * Set : The CMS_href
	  *
	  * @param CMS_href $href, the HREF to use in this dialog
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function setHref($href)
	{
		if (!is_a($href, "CMS_href")) {
			$this->setError("Bad CMS_href given to constructor");
			return false;
		}
		$this->_href = $href;
		return true;
	}
	
	/**
	 * Get POST vars from a form formatted by such a CMS_dialog_href class
	 * and build a CMS_href
	 *
	 * Uses : _POST['link'] : array $link, the $_POST['link'] built by submiting
	 * the form data : array ( 'internal'=>, 'external'=>, 'file'=>,
	 * 'edit_file'=>, 'popup'=> array ('width'=>,'height'=>), 'type'=> )
	 * @param  string $module, the module concerned by this link
	 * @param integer $resourceID, ID to prepend the filename uploaded with
	 * @param integer $fieldID, optional field ID to surcharge file name representation ("r".$resourceID."_f".$fieldID."_")
	 * @return boolean true on success, false on failure
	 * @access public
	 */
	public function doPost($module = MOD_STANDARD_CODENAME, $resourceID, $fieldID = '')
	{
		$linkLabel = (isset($_POST[$this->_prefix.'link_label'])) ? $_POST[$this->_prefix.'link_label'] : '';
		$linkType = (isset($_POST[$this->_prefix.'link_type'])) ? $_POST[$this->_prefix.'link_type'] : '';
		$internalLink = (isset($_POST[$this->_prefix.'link_internal'])) ? $_POST[$this->_prefix.'link_internal'] : '';
		$externalLink = (isset($_POST[$this->_prefix.'link_external'])) ? $_POST[$this->_prefix.'link_external'] : '';
		$this->_href->setLabel($linkLabel);
		$this->_href->setLinkType($linkType);
		$this->_href->setInternalLink($internalLink);
		$this->_href->setExternalLink($externalLink);
		// Delete/Upload file
		if (isset($_POST[$this->_prefix.'link_edit_linkfile']) && $_POST[$this->_prefix.'link_edit_linkfile'] > 0) {
			switch($module){
				case MOD_STANDARD_CODENAME:
					$locationType = RESOURCE_DATA_LOCATION_EDITION;
					$uniqueName = md5(serialize($this).microtime());
					$fileprefix = ($fieldID) ? 'p'.$resourceID.'_'.$uniqueName."_f".$fieldID : 'p'.$resourceID.'_'.$uniqueName;
				break;
				default:
					$locationType = RESOURCE_DATA_LOCATION_EDITED;
					$fileprefix = ($fieldID) ? 'r'.$resourceID."_f".$fieldID."_" : 'r'.$resourceID."_";
				break;
			}
			//remove the old file if any
			if (is_file($this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM))) {
				if (!unlink($this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM))) {
					$this->setError("Could not delete linked file");
				}
			}
			if ($_FILES[$this->_prefix.'link_file']['name'] != '' && $resourceID > 0) {
				$path = $this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM, false);
				$filename = $fileprefix.SensitiveIO::sanitizeAsciiString($_FILES[$this->_prefix.'link_file']['name']);
				//move uploaded file
				$fileDatas = CMS_file::uploadFile($this->_prefix.'link_file', PATH_TMP_FS);
				if ($fileDatas['error']) {
					return false;
				}
				if (!CMS_file::moveTo(PATH_TMP_FS.'/'.$fileDatas['filename'], $path."/".$filename)) {
					return false;
				}
			} else {
				$filename = '';
			}
			$this->_href->setFileLink($filename);
		}
		// Target and Popup > (width, height)
		if (isset($_POST[$this->_prefix.'link_target'])) {
			switch ($_POST[$this->_prefix.'link_target']) {
			case "popup":
				if ((int) $_POST[$this->_prefix.'link_popup_width'] > 0 || (int) $_POST[$this->_prefix.'link_popup_height'] > 0) {
					$this->_href->setPopup($_POST[$this->_prefix.'link_popup_width'], $_POST[$this->_prefix.'link_popup_height']);
				} else {
					$this->_href->setPopup('','');
				}
				break;
			case "top":
				$this->_href->setTarget('_top');
				$this->_href->setPopup('','');
				break;
			case "blank":
				$this->_href->setTarget('_blank');
				$this->_href->setPopup('','');
				break;
			}
		}
		return true;
	}
	
	/**
	 * Get datas vars from a form formatted by such a Automne.LinkField class
	 * and build a CMS_href
	 *
	 * @param array $datas, the datas sent by the Automne.LinkField return
	 * @param string $module, the module concerned by this link
	 * @param integer $resourceID, ID to prepend the filename uploaded with
	 * @param integer $fieldID, optional field ID to surcharge file name representation ("r".$resourceID."_f".$fieldID."_")
	 * @return boolean true on success, false on failure
	 * @access public
	 */
	public function create($datas = '', $module = MOD_STANDARD_CODENAME, $resourceID, $fieldID = '')
	{
		$datas = explode($this->_href->getSeparator(), $datas);
		
		$linkLabel = (isset($datas[7])) ? $datas[7] : '';
		$linkType = (isset($datas[0])) ? $datas[0] : '';
		$internalLink = (isset($datas[1])) ? $datas[1] : '';
		$externalLink = (isset($datas[2])) ? $datas[2] : '';
		$this->_href->setLabel($linkLabel);
		$this->_href->setLinkType($linkType);
		$this->_href->setInternalLink($internalLink);
		$this->_href->setExternalLink($externalLink);
		// Delete/Upload file
		if (isset($datas[3])) {
			switch($module){
				case MOD_STANDARD_CODENAME:
					$locationType = RESOURCE_DATA_LOCATION_EDITION;
					$uniqueName = md5(serialize($this).microtime());
					$fileprefix = ($fieldID) ? 'p'.$resourceID.'_'.$uniqueName."_f".$fieldID : 'p'.$resourceID.'_'.$uniqueName;
				break;
				default:
					$locationType = RESOURCE_DATA_LOCATION_EDITED;
					$fileprefix = ($fieldID) ? 'r'.$resourceID."_f".$fieldID."_" : 'r'.$resourceID."_";
				break;
			}
			if ($datas[3] && io::strpos($datas[3], PATH_UPLOAD_WR.'/') !== false) {
				//move and rename uploaded file 
				$datas[3] = str_replace(PATH_UPLOAD_WR.'/', PATH_UPLOAD_FS.'/', $datas[3]);
				$basename = pathinfo($datas[3], PATHINFO_BASENAME);
				$path = $this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM, false);
				$newFilename = $path.'/'.$fileprefix.$basename;
				CMS_file::moveTo($datas[3], $newFilename);
				CMS_file::chmodFile(FILES_CHMOD, $newFilename);
				$datas[3] = pathinfo($newFilename, PATHINFO_BASENAME);
				//remove the old file if any
				if (is_file($this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM))) {
					if (!unlink($this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM))) {
						$this->setError("Could not delete old linked file");
					}
				}
			} elseif ($datas[3]) {
				//keep old file
				$datas[3] = pathinfo($datas[3], PATHINFO_BASENAME);
			} else {
				$datas[3] = '';
				//remove the old file if any
				if (is_file($this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM))) {
					if (!unlink($this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM))) {
						$this->setError("Could not delete old linked file");
					}
				}
			}
			$this->_href->setFileLink($datas[3]);
		} elseif (is_file($this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM))) {
			//remove the old file
			if (!unlink($this->_href->getFileLink(true, $module, $locationType, PATH_RELATIVETO_FILESYSTEM))) {
				$this->setError("Could not delete old linked file");
			}
		}
		// Target and Popup > (width, height)
		list($width, $height) = explode(',',$datas[6]);
		if (sensitiveIO::isPositiveInteger($width) && sensitiveIO::isPositiveInteger($height)) {
			$this->_href->setPopup($width, $height);
		} else {
			switch ($datas[4]) {
				case "_top":
					$this->_href->setTarget('_top');
					$this->_href->setPopup('','');
				break;
				case "_blank":
					$this->_href->setTarget('_blank');
					$this->_href->setPopup('','');
				break;
			}
		}
		return true;
	}
	
	/**
	  * Get : a XHTML render of the "A" tag
	  *
	  * @param string $module, the module concerned by this link
	  * @param string $dataLocation Where does the data lies ? @see CMS_resource constants
	  * @return string, the XHTML Tag
	  * @access public
	  */
	public function getHTML($module = MOD_STANDARD_CODENAME, $dataLocation = RESOURCE_DATA_LOCATION_EDITED)
	{
		if (!is_a($this->_href, 'CMS_href')) {
			$this->setError("\$this->_href isn't a CMS_href");
			return '';
		}
		return $this->_href->getHTML(false, $module, $dataLocation);
	}
	
	/**
	 * Returns XHTML formatted form fields for this Href
	 * 
	 * @param CMS_language $cms_language, the language to build the form with
	 * @param string $module, the module codename (default : MOD_STANDARD_CODENAME)
	 * @param constant $dataLocation, the current data location (RESOURCE_DATA_LOCATION_EDITED (default), RESOURCE_DATA_LOCATION_PUBLIC, etc.)
	 * @param array $options, array of possible link options (default false : all options actived)
	 *	Example :
	 * Array (
	 *     'label' 		=> true|false,				// Link has label ?
	 *     'internal' 	=> true|false,				// Link can target an Automne page ?
	 *     'external' 	=> true|false,				// Link can target an external resource ?
	 *     'file' 		=> true|false,				// Link can target a file ?
	 *     'destination'=> true|false,				// Can select a destination for the link ?
	 *     'no_admin' 	=> true|false,				// Deprecated : Remove all admin class reference (default = false)
	 *     'admin' 		=> true|false,				// Use admin JS and classes instead of direct actions (default = true)
	 *     'currentPage'=> int|false,				// Current page to open tree panel (default : CMS_tree::getRoot())
	 * )
	 * @return string HTML formated expected
	 * @access public
	 */
	public function getHTMLFields($cms_language, $module = MOD_STANDARD_CODENAME, $dataLocation = RESOURCE_DATA_LOCATION_EDITED, $options = false)
	{
		global $cms_user;
		if (!is_a($this->_href, 'CMS_href')) {
			$this->setError("\$this->_href isn't a CMS_href");
			return '';
		}
		$tdClass = $tdClassLight = $tdClassDark = $inputClass = '';
		if (!isset($options['no_admin']) || $options['no_admin'] === false) {
			$tdClass = ' class="admin"';
			$tdClassLight = ' class="admin_lightgreybg"';
			$tdClassDark = ' class="admin_darkgreybg"';
			$inputClass = ' class="admin_input_text"';
		}
		$s = '';
		if (!isset($options['destination']) || $options['destination'] == true) {
			$s .= '
			<script type="text/javascript">
				if (typeof CMS_openPopUpPage != "function") {
					function CMS_openPopUpPage(href, id, width, height) {
						if (href != "") {
							pagePopupWin = window.open(href, \'CMS_page_\'+id, \'width=\'+width+\',height=\'+height+\',resizable=yes,menubar=no,toolbar=no,scrollbars=yes,status=no,left=0,top=0\');
						}
					}
				}
			</script>';
		}
		$s .= '
		<table>';
			if (!isset($options['label']) || $options['label'] == true) {
				$s .= '
				<!-- link label -->
				<tr>
					<th'.$tdClass.'><span class="admin_text_alert">*</span> '.$cms_language->getMessage(self::MESSAGE_PAGE_LINK_LABEL).'</th>
					<td'.$tdClassLight.' colspan="2"><input style="width:100%;" type="text"'.$inputClass.' name="'.$this->_prefix.'link_label" value="'.io::htmlspecialchars($this->_href->getLabel()).'" /></td>
				</tr>';
			}
			$checked = ($this->_href->getLinkType() == RESOURCE_LINK_TYPE_NONE) ? ' checked="checked"' : '';
			$rowspan = 4;
			if (isset($options['internal']) && $options['internal'] == false) $rowspan--;
			if (isset($options['external']) && $options['external'] == false) $rowspan--;
			if (isset($options['file']) && $options['file'] == false) $rowspan--;
			$s .= '
					<tr>
						<th'.$tdClass.' rowspan="'.$rowspan.'"><span class="admin_text_alert">*</span> '.$cms_language->getMessage(self::MESSAGE_PAGE_LINK_DESTINATION).'</th>
						<td'.$tdClassDark.'><input type="radio" id="'.$this->_prefix.'link_type_0" name="'.$this->_prefix.'link_type" value="'.RESOURCE_LINK_TYPE_NONE.'"'.$checked.' /></td>
						<td'.$tdClassDark.'><label for="'.$this->_prefix.'link_type_0">'.$cms_language->getMessage(self::MESSAGE_PAGE_NOLINK).'</label></td>
					</tr>
			';
			if (!isset($options['internal']) || $options['internal'] == true) {
				$checked = ($this->_href->getLinkType() == RESOURCE_LINK_TYPE_INTERNAL) ? ' checked="checked"' : '';
				// Build tree link
				$grand_root = (isset($options['currentPage']) && sensitiveIO::isPositiveInteger($options['currentPage'])) ? CMS_tree::getPageByID($options['currentPage']) : CMS_tree::getRoot();
				$grand_rootID = $grand_root->getID();
				if($cms_user && is_a($cms_user,'CMS_profile_user')){
					if(!$cms_user->hasPageClearance($grand_rootID,CLEARANCE_PAGE_VIEW)){
						// If user don't have any clearance view for page root : search a "first root" and viewable page sections
						$sections_roots=array();
						$sections_roots = $cms_user->getViewablePageClearanceRoots();
						if($sections_roots){
							CMS_session::setSessionVar('sectionsRoots',$sections_roots);
							$sections_roots = array_reverse($sections_roots);
							foreach($sections_roots as $pageID){
								$lineages[count(CMS_tree::getLineage($grand_rootID,$pageID,false))] = $pageID;
							}
						}
						ksort($lineages);
						$grand_rootID = array_shift($lineages);
					}
				}
				if (!isset($options['admin']) || $options['admin'] == false) {
					//build tree link
					$href = '/automne/admin-v3/tree.php';
					$href .= '?root='.$grand_rootID;
					$href .= '&amp;heading='.$cms_language->getMessage(self::MESSAGE_PAGE_TREEH1);
					$href .= '&amp;encodedOnClick='.base64_encode("window.opener.document.getElementById('".$this->_prefix."link_internal').value = '%s';self.close();");
					$href .= '&encodedPageLink='.base64_encode('false');
					$treeLink = '<a href="'.$href.'"'.$tdClass.' target="_blank"><img src="'.PATH_ADMIN_IMAGES_WR. '/tree.gif" border="0" align="absmiddle" /></a>';
				} else {
					$treeLink = '<a href="#" onclick="Automne.view.tree(\''.$this->_prefix.'link_internal\', \''.sensitiveIO::sanitizeJSString($cms_language->getMessage(self::MESSAGE_PAGE_TREEH1)).'\', \''.$grand_rootID.'\')"><img src="'.PATH_ADMIN_IMAGES_WR. '/tree.gif" border="0" align="absmiddle" /></a>';
				}
				$s .= '<tr>
						<td'.$tdClassLight.'><input type="radio" id="'.$this->_prefix.'link_type_1" name="'.$this->_prefix.'link_type" value="'.RESOURCE_LINK_TYPE_INTERNAL.'"'.$checked.' /></td>
						<td'.$tdClassLight.'>
							<label for="'.$this->_prefix.'link_type_1">'.$cms_language->getMessage(self::MESSAGE_PAGE_INTERNALLINK).'</label>
							<input type="text"'.$inputClass.' id="'.$this->_prefix.'link_internal" name="'.$this->_prefix.'link_internal" value="'.$this->_href->getInternalLink().'" size="6" />
							'.$treeLink.'
						</td>
					</tr>';
			}
			if (!isset($options['external']) || $options['external'] == true) {
				$checked = ($this->_href->getLinkType() == RESOURCE_LINK_TYPE_EXTERNAL) ? ' checked="checked"' : '';
				$s .= '
					<tr>
						<td'.$tdClassDark.'><input type="radio" id="'.$this->_prefix.'link_type_2" name="'.$this->_prefix.'link_type" value="'.RESOURCE_LINK_TYPE_EXTERNAL.'"'.$checked.' /></td>
						<td'.$tdClassDark.'>
							<label for="'.$this->_prefix.'link_type_2">'.$cms_language->getMessage(self::MESSAGE_PAGE_EXTERNALLINK).'</label>
							<input type="text"'.$inputClass.' id="'.$this->_prefix.'link_external" name="'.$this->_prefix.'link_external" value="'.io::htmlspecialchars($this->_href->getExternalLink()).'" size="30" />
						</td>
					</tr>
				';
			}
			if (!isset($options['file']) || $options['file'] == true) {
				$checked = ($this->_href->getLinkType() == RESOURCE_LINK_TYPE_FILE) ? ' checked="checked"' : '';
				$s .= '
					<tr>
						<td'.$tdClassLight.'><input type="radio" id="'.$this->_prefix.'link_type_3" name="'.$this->_prefix.'link_type" value="'.RESOURCE_LINK_TYPE_FILE.'"'.$checked.' /></td>
						<td'.$tdClassLight.'>
							<label for="'.$this->_prefix.'link_type_3">'.$cms_language->getMessage(self::MESSAGE_PAGE_LINKFILE).'</label>
							<input type="file"'.$inputClass.' name="'.$this->_prefix.'link_file" /><br />
							<label for="'.$this->_prefix.'link_edit_linkfile"><input type="checkbox" id="'.$this->_prefix.'link_edit_linkfile" name="'.$this->_prefix.'link_edit_linkfile" value="1" /> '.$cms_language->getMessage(self::MESSAGE_PAGE_FIELD_EDITFILE).'</label>';
							if ($this->_href->getFileLink(false,$module,$dataLocation)) {
								$s .= '<br />'.$cms_language->getMessage(self::MESSAGE_PAGE_EXISTING_FILE).' : <a href="'.$this->_href->getFileLink(true,$module,$dataLocation).'" target="_blank">'.$this->_href->getFileLink(false,$module,$dataLocation).'</a>';
							} else {
								$s .= '<br />'.$cms_language->getMessage(self::MESSAGE_PAGE_EXISTING_FILE).' : '.$cms_language->getMessage(self::MESSAGE_PAGE_NO_FILE);
							}
				$s .= '	</td>
					</tr>';
			}
			if (!isset($options['destination']) || $options['destination'] == true) {
				$popup = $this->_href->getPopup();
				$checked_pop = (isset($popup['width']) && $popup['width'] > 0) ? ' checked="checked"' : '';
				$checked_top = (isset($popup['width']) && $popup['width'] <= 0 && $this->_href->getTarget() == '_top') ? ' checked="checked"' : '';
				$checked_bl = (isset($popup['width']) && $popup['width'] <= 0 && $this->_href->getTarget() == '_blank') ? ' checked="checked"' : '';
				if (!$checked_pop && !$checked_top && !$checked_bl) {
					$checked_top = ' checked="checked"';
				}
				$width = (isset($popup['width'])) ? $popup['width'] : 0;
				$height = (isset($popup['height'])) ? $popup['height'] : 0;
				$s .= '
					<!-- Link target -->
					<tr>
						<th'.$tdClass.' rowspan="3">'.$cms_language->getMessage(self::MESSAGE_PAGE_LINK_SHOW).'</th>
						<td'.$tdClassDark.'><input type="radio" id="'.$this->_prefix.'link_target_top" name="'.$this->_prefix.'link_target" value="top"'.$checked_top.' /></td>
						<td'.$tdClassDark.'>
							<label for="'.$this->_prefix.'link_target_top"><img src="'.PATH_ADMIN_IMAGES_WR. '/pic_link_top.gif" alt="" border="0" align="absmiddle" />
							'.$cms_language->getMessage(self::MESSAGE_PAGE_TARGET_TOP).'</label>
						</td>
					</tr>
					<tr>
						<td'.$tdClassLight.'><input type="radio" id="'.$this->_prefix.'link_target_blank" name="'.$this->_prefix.'link_target" value="blank"'.$checked_bl.' /></td>
						<td'.$tdClassLight.'>
							<label for="'.$this->_prefix.'link_target_blank"><img src="'.PATH_ADMIN_IMAGES_WR. '/pic_link_blank.gif" alt="" border="0" align="absmiddle" />
							'.$cms_language->getMessage(self::MESSAGE_PAGE_TARGET_BLANK).'</label>
						</td>
					</tr>
					<tr>
						<td'.$tdClassDark.'><input type="radio" id="'.$this->_prefix.'link_target_popup" name="'.$this->_prefix.'link_target" value="popup"'.$checked_pop.' /></td>
						<td'.$tdClassDark.'>
							<label for="'.$this->_prefix.'link_target_popup"><img src="'.PATH_ADMIN_IMAGES_WR. '/pic_link_top.gif" alt="" border="0" align="absmiddle" />
							'.$cms_language->getMessage(self::MESSAGE_PAGE_TARGET_POPUP).' : </label>
							'.$cms_language->getMessage(self::MESSAGE_PAGE_POPUP_WIDTH).' <input type="text"'.$inputClass.' name="'.$this->_prefix.'link_popup_width" value="'.$width.'" size="3" />
							'.$cms_language->getMessage(self::MESSAGE_PAGE_POPUP_HEIGHT).' <input type="text"'.$inputClass.' name="'.$this->_prefix.'link_popup_height" value="'.$height.'" size="3" />
						</td>
					</tr>';
			}
			$s .= '</table>';
		return $s;
	}
}
?>