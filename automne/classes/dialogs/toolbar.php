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
  * Class CMS_wysiwyg_toolbar
  *
  * represent a wwysiwyg (ckeditor) toolbar with a set of elements
  *
  * @package Automne
  * @subpackage dialogs
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_wysiwyg_toolbar extends CMS_grandFather
{
	/**
	  * DB id
	  * @var integer
	  * @access private
	  */
	protected $_id;

	/**
	  * Array of all common toolbar elements
	  * @var array : (string)element code => (int)element name id
	  * @access private
	  */
	protected $_elements = array(
			'Source' 		=> 1356,
			'Separator1' 	=> 1398,
			'Maximize' 		=> 1758, // FitWindow
			'ShowBlocks'	=> 525,
			'Separator2' 	=> 1398,
			'Preview' 		=> 1358,
			'Templates' 	=> 1359,
			'Separator3' 	=> 1398,
			'Cut' 			=> 1360,
			'Copy' 			=> 1361,
			'Paste' 		=> 1362,
			'PasteText' 	=> 1363,
			'PasteFromWord' => 1364, // PasteWord
			'Separator4' 	=> 1398,
			'Print'	 		=> 1365,
			'Separator5' 	=> 1398,
			'Undo' 			=> 1366,
			'Redo' 			=> 1367,
			'Separator6' 	=> 1398,
			'Find' 			=> 1368,
			'Replace' 		=> 1369,
			'Separator7' 	=> 1398,
			'SelectAll' 	=> 1370,
			'RemoveFormat' 	=> 1371,
			'Scayt' 		=> 1752, // New tool
			'Separator8' 	=> 1398,
			'Bold' 			=> 1372,
			'Italic' 		=> 1373,
			'Underline' 	=> 1374,
			'Strike' 		=> 1375, // StrikeThrough
			'Separator9' 	=> 1398,
			'Subscript' 	=> 1376,
			'Superscript' 	=> 1377,
			'Separator10' 	=> 1398,
			'NumberedList' 	=> 1378, // OrderedList
			'BulletedList'	=> 1379, // UnorderedList
			'Blockquote' 	=> 1753, // New tool
			'CreateDiv' 	=> 1754, // New tool
			'Separator11' 	=> 1398,
			'Outdent' 		=> 1380,
			'Indent' 		=> 1381,
			'Separator12' 	=> 1398,
			'JustifyLeft' 	=> 1382,
			'JustifyCenter' => 1383,
			'JustifyRight' 	=> 1384,
			'JustifyBlock' 	=> 1385, // JustifyFull
			'BidiLtr' 		=> 1755, // New tool
			'BidiRtl' 		=> 1756, // New tool
			'Separator13' 	=> 1398,
			'Link' 			=> 1386,
			'Unlink' 		=> 1387,
			'Anchor' 		=> 1388,
			'Separator14' 	=> 1398,
			'Table' 		=> 1390,
			'HorizontalRule'=> 1391, // Rule
			'SpecialChar' 	=> 1392,
			'Iframe' 		=> 1757, // New tool
			'Separator15' 	=> 1398,
			'Styles' 		=> 1393, // Style
			'Format' 		=> 1394, // FontFormat
			'FontSize' 		=> 1395,
			'Separator16' 	=> 1398,
			'TextColor' 	=> 1396,
			'BGColor' 		=> 1397,
			'Separator17' 	=> 1398,
		);

	/**
	  * Current toolbar elements (common ones plus modules specific if any)
	  * @var array
	  * @access private
	  */
	protected $_toolbarElements = array();

	/**
	  * Current user which use toolbar
	  * @var CMS_profile_user
	  * @access private
	  */
	protected $_user;

	/**
	  * Current toolbar code
	  * @var string
	  * @access private
	  */
	protected $_code;

	/**
	  * Current toolbar label
	  * @var string
	  * @access private
	  */
	protected $_label;

	/**
	  * Constructor.
	  * initializes the toolbar if the id is given.
	  *
	  * @param integer $id DB id
	  * @return void
	  * @access public
	  */
	public function __construct($id = 0, &$user)
	{
		if (!is_a($user, 'CMS_profile_user') || $user->hasError()) {
			$this->setError("User is not a valid CMS_profile_user");
			return;
		}
		$this->_user = $user;
		if ($id) {
			if (!SensitiveIO::isPositiveInteger($id)) {
				$this->setError("Id is not a positive integer");
				return;
			}
			$sql = "
				select
					*
				from
					toolbars
				where
					id_tool='$id'
			";
			$q = new CMS_query($sql);
			if ($q->getNumRows()) {
				$data = $q->getArray();
				$this->_id = $id;
				$this->_code = $data["code_tool"];
				$this->_label = $data["label_tool"];
				$this->_toolbarElements = explode('|',$data["elements_tool"]);
			} else {
				$this->setError("Unknown ID :".$id);
			}
		} else {
			$this->_toolbarElements = array_keys($this->_elements);
		}
	}
	
	/**
	  * Gets the DB ID of the instance.
	  *
	  * @return integer the DB id
	  * @access public
	  */
	public function getID() {
		return $this->_id;
	}
	
	/**
	  * Get user used for this toolbar
	  *
	  * @return CMS_profile_user the user
	  * @access public
	  */
	public function getUser() {
		return $this->_user;
	}
	
	/**
	  * Get toolbar elements specifics to modules for the curent user
	  *
	  * @return array : modules elements
	  * @access public
	  */
	protected function _getModulesElements() {
		static $modulesElements;
		if (!isset($modulesElements[$this->_user->getUserId()])) {
			//include modules codes in output file
			$modulesCodes = new CMS_modulesCodes();
			$modulesElements[$this->_user->getUserId()] = $modulesCodes->getModulesCodes(MODULE_TREATMENT_EDITOR_PLUGINS, '', new CMS_stack(), array("editor" => "fckeditor", "user" => $this->_user));
		}
		return $modulesElements[$this->_user->getUserId()];
	}
	
	/**
	  * Does the toolbar use special modules plugins ?
	  *
	  * @return boolean
	  * @access public
	  */
	public function hasModulePlugins() {
		$modulesElements = $this->_getModulesElements();
		if (!$this->_getModulesElements()) {
			return false;
		}
		foreach ($modulesElements as $code => $label) {
			if (in_array($code, $this->_toolbarElements)) {
				return true;
			}
		}
		return false;
	}
	
	/**
	  * Get default toolbar elements
	  *
	  * @return array : modules elements
	  * @access public
	  */
	protected function _getDefaultElements() {
		return $this->_elements;
	}
	
	/**
	  * Gets the toolbar code
	  *
	  * @return string the toolbar code
	  * @access public
	  */
	public function getCode() {
		return $this->_code;
	}
	
	/**
	  * Sets the toolbar code
	  *
	  * @param string $code the toolbar code to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	public function setCode($code) {
		$this->_code = io::substr(sensitiveIO::sanitizeAsciiString($code),0,20);
		return true;
	}
	
	/**
	  * Gets the toolbar elements
	  *
	  * @return array the toolbar elements
	  * @access public
	  */
	public function getElements() {
		//ckeditor => fckeditor
		$conversion = array(
			'PasteFromWord' => 'PasteWord',
			'Strike' 		=> 'StrikeThrough',
			'NumberedList' 	=> 'OrderedList',
			'BulletedList'	=> 'UnorderedList',
			'JustifyBlock' 	=> 'JustifyFull',
			'HorizontalRule'=> 'Rule',
			'Styles' 		=> 'Style',
			'Format' 		=> 'FontFormat',
			'Maximize' 		=> 'FitWindow',
		);
		foreach ($this->_toolbarElements as $key => $toolbarElement) {
			//for backward compat
			if (in_array($toolbarElement, $conversion)) {
				$this->_toolbarElements[$key] = str_replace($conversion, array_keys($conversion), $toolbarElement);
			}
		}
		return $this->_toolbarElements;
	}
	
	/**
	  * Sets the toolbar elements
	  *
	  * @param elements $elements the toolbar elements to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	public function setElements($elements) {
		$this->_toolbarElements = (array) $elements;
		return true;
	}
	
	/**
	  * Sets the toolbar label
	  *
	  * @param string $label the toolbar label to set
	  * @return boolean true on success, false on failure.
	  * @access public
	  */
	public function setLabel($label) {
		$this->_label = $label;
		return true;
	}
	
	/**
	  * Gets the toolbar label
	  *
	  * @return string the toolbar code
	  * @access public
	  */
	public function getLabel() {
		return $this->_label;
	}
	
	/**
	  * Gets the (F)CKEditor toolbar definition
	  *
	  * @param boolean $fckEditor Does the format must be compatible with fckeditor (default : false)
	  * @return string the toolbar code
	  * @access public
	  */
	public function getDefinition($fckEditor = false) {
		$modulesElements = $this->_getModulesElements();
		$defaultElements = $this->_getDefaultElements();
		$availableElements = array_merge($defaultElements, $modulesElements);
		if ($fckEditor) {
			$definition = "\n".'FCKConfig.ToolbarSets["'.$this->getCode().'"] = [[';
		} else {
			$definition = "\n".'toolbarSets["'.$this->getCode().'"] = [[';
		}
		//ckeditor => fckeditor
		$conversion = array(
			'PasteFromWord' => 'PasteWord',
			'Strike' 		=> 'StrikeThrough',
			'NumberedList' 	=> 'OrderedList',
			'BulletedList'	=> 'UnorderedList',
			'JustifyBlock' 	=> 'JustifyFull',
			'HorizontalRule'=> 'Rule',
			'Styles' 		=> 'Style',
			'Format' 		=> 'FontFormat',
			'Maximize' 		=> 'FitWindow',
		);
		if ($fckEditor) {
			$newElements = array(
				'Scayt',
				'Blockquote',
				'CreateDiv',
				'BidiLtr',
				'BidiRtl',
				'Iframe',
				'Maximize',
				'ShowBlocks',
			);
		}
		$count = 0;
		foreach ($this->_toolbarElements as $toolbarElement) {
			//for backward compat
			if (in_array($toolbarElement, $conversion)) {
				$toolbarElement = str_replace($conversion, array_keys($conversion), $toolbarElement);
			}
			if ($fckEditor && in_array($toolbarElement, $newElements)) {
				$toolbarElement = 'unavailable';
			}
			if (isset($availableElements[$toolbarElement])) {
				if (io::substr($toolbarElement, 0, 9) != 'Separator') {
					$definition .= ($count) ? ',':'';
					if ($fckEditor) {
						$toolbarElement = str_replace(array_keys($conversion), $conversion, $toolbarElement);
					}
					$definition .= '\''.$toolbarElement.'\'';
					$count++;
				} else {
					$definition .= '],[';
					$count = 0;
				}
			}
		}
		$definition .= ']];'."\n";
		return $definition;
	}
	
	/**
	  * Totally destroys the current toolbar
	  *
	  * @return void
	  * @access public
	  */
	public function destroy() {
		if ($this->_id) {
			$sql = "
				delete
				from
					toolbars
				where
					id_tool = '".$this->_id."'
			";
			$q = new CMS_query($sql);
		}
		parent::destroy();
	}
	
	/**
	  * Writes the toolbar into persistence (MySQL for now).
	  *
	  * @return boolean true on success, false on failure
	  * @access public
	  */
	public function writeToPersistence() {
		$sql_fields = "
			code_tool='".SensitiveIO::sanitizeSQLString($this->_code)."',
			label_tool='".SensitiveIO::sanitizeSQLString($this->_label)."',
			elements_tool='".SensitiveIO::sanitizeSQLString(implode('|', $this->_toolbarElements))."'
		";
		if ($this->_id) {
			$sql = "
				update
					toolbars
				set
					".$sql_fields."
				where
					id_tool='".$this->_id."'
			";
		} else {
			$sql = "
				insert into
					toolbars
				set
					".$sql_fields;
		}
		$q = new CMS_query($sql);
		if ($q->hasError()) {
			return false;
		} elseif (!$this->_id) {
			$this->_id = $q->getLastInsertedID();
		}
		return true;
	}
	
	/**
	  * Gets the toolbar elements
	  *
	  * @param CMS_profile_user $user the toolbar elements to set
	  * @return array the toolbar elements
	  * @access public
	  * @static
	  */
	public static function getAllElements($user = '') {
		/*if (isset($this)) {
			$modulesElements = $this->_getModulesElements();
			$defaultElements = $this->_getDefaultElements();
			$language = $this->_user->getLanguage();
		} else*/
		if (is_a($user, 'CMS_profile_user')) {
			$tmp = new CMS_wysiwyg_toolbar(0, $user);
			$modulesElements = $tmp->_getModulesElements();
			$defaultElements = $tmp->_getDefaultElements();
			$language = $user->getLanguage();
		} else {
			CMS_grandFather::raiseError('User parameter must be a valid CMS_profile_user when function is used statically');
			return false;
		}
		foreach ($defaultElements as $code => $languageCode) {
			$defaultElements[$code] = $language->getMessage($languageCode);
		}
		return array_merge($defaultElements, $modulesElements);
	}
	
	/**
	  * Gets all toolbars
	  *
	  * @param CMS_profile_user $user the toolbar elements to set
	  * @return array the toolbars
	  * @access public
	  * @static
	  */
	public static function getAll(&$user)
	{
		$sql = "
			select
				id_tool
			from
				toolbars
			order by
				label_tool
		";
		$q = new CMS_query($sql);
		$toolbars = array();
		while ($id = $q->getValue("id_tool")) {
			$toolbar = new CMS_wysiwyg_toolbar($id, $user);
			if (!$toolbar->hasError()) {
				$toolbars[$toolbar->getCode()] = $toolbar;
			}
		}
		return $toolbars;
	}
	
	/**
	  * Get toolbar by code
	  *
	  * @param string $code the toolbar code to get
	  * @param CMS_profile_user $user the toolbar elements to set
	  * @return array the toolbars
	  * @access public
	  * @static
	  */
	public static function getByCode($code, &$user) {
		$sql = "
			select
				id_tool
			from
				toolbars
			where
				code_tool = '".sensitiveIO::sanitizeSQLString($code)."'
		";
		$q = new CMS_query($sql);
		return ($q->getNumRows()) ? new CMS_wysiwyg_toolbar($q->getValue("id_tool"), $user) : false;
	}
}
?>