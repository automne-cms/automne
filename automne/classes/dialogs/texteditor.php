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
  * Class CMS_dialog
  *
  * Interface generation
  *
  * @package Automne
  * @subpackage dialogs
  * @author Antoine Pouch <antoine.pouch@ws-interactive.fr> &
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

class CMS_textEditor extends CMS_grandFather
{
	/**
	  * Name of the form where the editor is displayed
	  *
	  * @var string
	  * @access private
	  */
	protected $_form;

	/**
	  * Name of the form hidden field which will contain the data
	  *
	  * @var string
	  * @access private
	  */
	protected $_formField;

	/**
	  * Initial content
	  *
	  * @var string
	  * @access private
	  */
	protected $_initialContent;

	/**
	  * The user language
	  *
	  * @var CMS_language
	  * @access private
	  */
	protected $_language;

	/**
	  * The width of the textarea
	  *
	  * @var integer
	  * @access private
	  */
	protected $_textareaWidth;

	/**
	  * The rows of the textarea
	  *
	  * @var integer
	  * @access private
	  */
	protected $_textareaRows;
	
	/**
	  * All attributes and config attributes that can be used by an editor
	  * Specially did that for fckeditor integration
	  * Format expected array('ToolbarSet'=>'Basic', 'Width' => 200, 'Height' => 400), each array key
	  * is an attribute of class 
	  * @see FCKeditor::FCKeditor()
	  *
	  * @var array()
	  * @access private
	  */
	protected $_editorAttributes;
	protected $_editorConfigAttributes;
	
	/**
	  * Constructor.
	  *
	  * @param string $form The name of the form
	  * @param string $field The name of the form hidden field which should receive the content
	  * @param string $initialContent The initial content
	  * @param string $userAgent The user agent string
	  * @param string $preferredEditor The name of the user preferred editor (useless since V4)
	  * @param CMS_language $language The user language
	  * @return void
	  * @access public
	  */
	function __construct($form, $field, $initialContent, $userAgent, $preferredEditor, &$language, $textareaWidth = 750, $textareaRows = 15)
	{
		$this->_form = $form;
		$this->_formField = $field;
		$this->_initialContent = $initialContent;
		$this->_language =& $language;
		$this->_textareaWidth = $textareaWidth;
		$this->_textareaRows = $textareaRows;
	}
	
	/**
	 * Stores editor attributes
	 * 
	 * @param $attrs array(), Array of attributes for fckeditor editor or even any editor
	 * ex :  array('ToolbarSet'=>'Basic', 'Width' => 200, 'Height' => 400), each array key
	 * is an attribute of class FCKeditor
	 * @return void
	 */
	function setEditorAttributes($attrs)
	{
		if (is_array($attrs)) {
			$this->_editorAttributes = $attrs;
		}
	}
	
	/**
	 * Stores editor config attributes
	 * 
	 * @param $attrs array(), Array of attributes for fckeditor editor or even any editor
	 * ex :  array('ToolbarSet'=>'Basic', 'Width' => 200, 'Height' => 400), each array key
	 * is an attribute of class FCKeditor
	 * @return void
	 */
	function setEditorConfigAttributes($attrs)
	{
		if (is_array($attrs)) {
			$this->_editorConfigAttributes = $attrs;
		}
	}
	
	/**
	  * Returns the html needed by the editor
	  *
	  * @return string
	  * @access public
	  */
	function getHTML() {
		$value = $this->_initialContent;
		// Editor base path
		$sBasePath = PATH_MAIN_WR.'/fckeditor/';
		$oFCKeditor = new FCKeditor($this->_formField);
		$oFCKeditor->BasePath = $sBasePath ;
		$oFCKeditor->Config['AutoDetectLanguage'] = false ;
		$oFCKeditor->Config['DefaultLanguage'] = $this->_language->getCode();
		$oFCKeditor->Value = $value;
		if (is_array($this->_editorAttributes)) {
			while (list($k, $v) = @each($this->_editorAttributes)) {
				if ($v != '') {
					$oFCKeditor->{$k} = $v ;
				}
			}
		}
		if (is_array($this->_editorConfigAttributes)) {
			while (list($k, $v) = @each($this->_editorConfigAttributes)) {
				if ($v != '') {
					$oFCKeditor->Config[$k] = $v;
				}
			}
		}
		return $oFCKeditor->Create();
	}
	
	/**
	  * Returns the javascript needed by the editor, which will be included in the <head> part
	  *
	  * @return string
	  * @access public
	  */
	function getJavascript()
	{
		//include modules javascript codes in output file
		$modulesCodes = new CMS_modulesCodes();
		$modulesJSCodeInclude = $modulesCodes->getModulesCodes(MODULE_TREATMENT_EDITOR_JSCODE, '', $this, array("language" => $this->_language, "formName" => $this->_form));
		$modulesJSCodeInclude = (sizeof($modulesJSCodeInclude)) ? implode("\n",$modulesJSCodeInclude) : "";
		return $modulesJSCodeInclude;
	}
	
	/**
	 * Get a CMS_textEditor from given parameters
	 * 
	 * @param mixed array(), $attrs each key => value is an attribute
	 * of this class or an attribute to fckeditor
	 * @return CMS_textEditor or null if error
	 */
	static function getEditorFromParams($attrs)
	{
		if (!is_array($attrs)) {
			CMS_grandFather::raiseError("None array of attributes passed to factory");
			return null;
		}
		$text_editor = new CMS_textEditor(
			$attrs['form'],								// Form name
			$attrs['field'],							// Field name
			$attrs['value'],							// Default value
			$_SERVER["HTTP_USER_AGENT"],				// HTTP User agent
			'',											// DEPRECATED
			$attrs['language'],							// language
			$attrs['width'],							// textarea width
			$attrs['rows']								// textarea rows
		);
		$fck_attrs = array(
			'ToolbarSet' => $attrs['toolbarset'],
			'Width' => $attrs['width'],
			'Height' => $attrs['height']
		);
		$text_editor->setEditorAttributes($fck_attrs);
		return $text_editor;
	}
	
	/**
	  * Parse content which go to the WYSIWYG editor to handle all plugins tags
	  *
	  * @param string $text The inputed text of fckeditor
	  * @param string $module The module codename which made the request
	  * @return string the text with plugins tags adapted for fckeditor
	  * @access public
	  */
	public static function parseInnerContent($value, $module = MOD_STANDARD_CODENAME) {
		$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_WYSIWYG_INNER_TAGS, RESOURCE_DATA_LOCATION_EDITION, $this);
		$wantedTags = $modulesTreatment->getWantedTags();
		//create regular expression on wanted tags
		$exp = '';
		foreach ($wantedTags as $aWantedTag) {
			$exp .= ($exp) ? '|<'.$aWantedTag["tagName"] : '<'.$aWantedTag["tagName"];
		}
		//is parsing needed (value contain some of these wanted tags)
		if ($value && is_array($wantedTags) && $wantedTags && preg_match('#('.$exp.')+#' ,$value) !== false) {
			$modulesTreatment->setTreatmentParameters(array('module' => $module));
			$modulesTreatment->setDefinition($value);
			$value = $modulesTreatment->treatContent(true);
		}
		//eval PHP content if any
		if (strpos($value, '<?php') !== false) {
			$value = io::evalPHPCode($value);
		}
		return $value;
	}
	
	/**
	  * Parse content coming out of the WYSIWYG editor to handle all plugins tags
	  *
	  * @param string $text The outputed text of fckeditor
	  * @param string $module The module codename which made the request
	  * @return string the text with all plugin tags
	  * @access public
	  */
	public static function parseOuterContent($text, $module = MOD_STANDARD_CODENAME) {
		//if post only contain a space or empty div or paragraph then the block is empty.
		$cleanedText = trim(str_replace(array('&#160;', '&nbsp;', ' ') , '', $text));
		if ($cleanedText == '<p></p>' || $cleanedText == '<div></div>') {
			$text = '';
		}
		if ($text) {
			/*
			 * we need to do some replacements to be completely conform with Automne
			 * you can add here all dirty tags to be removed from editor's output
			 */
			$replace = array(
				'{' 						=> '&#123;',//encode brackets to avoid vars ( {something:type:var} ) to be interpretted
				'}' 						=> '&#125;',
				'&#123;&#123;' 				=> '{{',	//in case of internal links copy/paste, editor decode {{ and }}
				'&#125;&#125;' 				=> '}}',	
				"%7B%7B" 					=> "{{",	
				"%7D%7D" 					=> "}}",	
				"/>" 						=> " />",	//xhtml missing space on auto-closed tags
				"<o:p>" 					=> "",		//dirty tags from MS Word pasting
				"</o:p>" 					=> "",		
				"<!--[if !supportLists]-->" => "",		
				"<!--[endif]-->" 			=> "",		
				"<?php" 					=> "",		//remove PHP tags for security
				"<?" 						=> "",		
				"?>" 						=> "",		
			);
			
			$text = str_replace(array_keys($replace),$replace,$text);
			$text = sensitiveIO::decodeWindowsChars($text);
			
			$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_WYSIWYG_OUTER_TAGS, RESOURCE_DATA_LOCATION_EDITION, new CMS_date());
			$wantedTags = $modulesTreatment->getWantedTags();
			
			//create regular expression on wanted tags
			$exp = '';
			foreach ($wantedTags as $aWantedTag) {
				$exp .= ($exp) ? '|<'.$aWantedTag["tagName"] : '<'.$aWantedTag["tagName"];
			}
			//is parsing needed (value contain some of these wanted tags)
			if (is_array($wantedTags) && $wantedTags && preg_match('#('.$exp.')+#' ,$text) !== false) {
				$modulesTreatment->setTreatmentParameters(array('module' => $module));
				$modulesTreatment->setDefinition($text);
				$text = $modulesTreatment->treatContent(true);
			}
		}
		return $text;
	}
}
?>
