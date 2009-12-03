<?php 
/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2008 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * This is the integration file for PHP 5.
 *
 * It defines the FCKeditor class that can be used to create editor
 * instances in PHP pages on server side.
 */
// $Id: fckeditor.php,v 1.3 2009/12/03 09:44:31 sebastien Exp $

/**
 * Check if browser is compatible with FCKeditor.
 * Return true if is compatible.
 *
 * @return boolean
 */
function FCKeditor_IsCompatibleBrowser()
{
	if ( isset( $_SERVER ) ) {
		$sAgent = $_SERVER['HTTP_USER_AGENT'] ;
	}
	else {
		global $HTTP_SERVER_VARS ;
		if ( isset( $HTTP_SERVER_VARS ) ) {
			$sAgent = $HTTP_SERVER_VARS['HTTP_USER_AGENT'] ;
		}
		else {
			global $HTTP_USER_AGENT ;
			$sAgent = $HTTP_USER_AGENT ;
		}
	}

	if ( strpos($sAgent, 'MSIE') !== false && strpos($sAgent, 'mac') === false && strpos($sAgent, 'Opera') === false )
	{
		$iVersion = (float)substr($sAgent, strpos($sAgent, 'MSIE') + 5, 3) ;
		return ($iVersion >= 5.5) ;
	}
	else if ( strpos($sAgent, 'Gecko/') !== false )
	{
		$iVersion = (int)substr($sAgent, strpos($sAgent, 'Gecko/') + 6, 8) ;
		return ($iVersion >= 20030210) ;
	}
	else if ( strpos($sAgent, 'Opera/') !== false )
	{
		$fVersion = (float)substr($sAgent, strpos($sAgent, 'Opera/') + 6, 4) ;
		return ($fVersion >= 9.5) ;
	}
	else if ( preg_match( "|AppleWebKit/(\d+)|i", $sAgent, $matches ) )
	{
		$iVersion = $matches[1] ;
		return ( $matches[1] >= 522 ) ;
	}
	else
		return false ;
}

class FCKeditor
{
	/**
	 * Name of the FCKeditor instance.
	 *
	 * @access protected
	 * @var string
	 */
	public $InstanceName ;
	/**
	 * Path to FCKeditor relative to the document root.
	 *
	 * @var string
	 */
	public $BasePath ;
	/**
	 * Width of the FCKeditor.
	 * Examples: 100%, 600
	 *
	 * @var mixed
	 */
	public $Width ;
	/**
	 * Height of the FCKeditor.
	 * Examples: 400, 50%
	 *
	 * @var mixed
	 */
	public $Height ;
	/**
	 * Name of the toolbar to load.
	 *
	 * @var string
	 */
	public $ToolbarSet ;
	/**
	 * Initial value.
	 *
	 * @var string
	 */
	public $Value ;
	/**
	 * This is where additional configuration can be passed.
	 * Example:
	 * $oFCKeditor->Config['EnterMode'] = 'br';
	 *
	 * @var array
	 */
	public $Config ;

	/**
	 * Main Constructor.
	 * Refer to the _samples/php directory for examples.
	 *
	 * @param string $instanceName
	 */
	public function __construct( $instanceName )
 	{
		$this->InstanceName	= $instanceName ;
		$this->BasePath		= PATH_ADMIN_WR.'/fckeditor/' ;
		$this->Width		= '100%' ;
		$this->Height		= '400' ;
		$this->ToolbarSet	= 'Default' ;
		$this->Value		= '' ;

		$this->Config		= array() ;
	}

	/**
	 * Display FCKeditor.
	 *
	 */
	public function Create()
	{
		/*
		 *Hack for FCKeditor
		 *All Automne linx must be parsed and changed (FCKEditor does not allow non XHTML DTD tags)
		 *Do not touch to this unless it be properly tested on IE and Gecko browsers
		 * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
		 */
		$this->Value = sensitiveIO::decodeWindowsChars($this->Value);
		
		if ($this->ToolbarSet == 'Default' && $this->Value!='') {
			//parse all plugin tags
			$this->Value = $this->parsePluginsTags($this->Value);
			//we need to do some replacements to be completely conform with FCKeditor attempt
			$replace = array(
				" />" 				//xhtml remove space on auto-closed tags
			);
			$replaceBy = array(
				"/>"
			);
			$this->Value = str_replace($replace,$replaceBy,$this->Value);
		}
		return $this->CreateHtml() ;
	}

	/**
	 * Return the HTML code required to run FCKeditor.
	 *
	 * @return string
	 */
	public function CreateHtml()
	{
		$HtmlValue = htmlspecialchars( $this->Value ) ;

		$Html = '' ;

		if ( $this->IsCompatible() )
		{
			if ( isset( $_GET['fcksource'] ) && $_GET['fcksource'] == "true" )
				$File = 'fckeditor.original.html' ;
			else
				$File = 'fckeditor.html' ;

			$Link = "{$this->BasePath}editor/{$File}?InstanceName={$this->InstanceName}" ;

			if ( $this->ToolbarSet != '' )
				$Link .= "&amp;Toolbar={$this->ToolbarSet}" ;

			// Render the linked hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}\" name=\"{$this->InstanceName}\" value=\"{$HtmlValue}\" style=\"display:none\" />" ;

			// Render the configurations hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}___Config\" value=\"" . $this->GetConfigFieldString() . "\" style=\"display:none\" />" ;

			// Render the editor IFRAME.
			$Html .= "<iframe id=\"{$this->InstanceName}___Frame\" src=\"{$Link}\" width=\"{$this->Width}\" height=\"{$this->Height}\" frameborder=\"0\" scrolling=\"no\"></iframe>" ;
		}
		else
		{
			if ( strpos( $this->Width, '%' ) === false )
				$WidthCSS = $this->Width . 'px' ;
			else
				$WidthCSS = $this->Width ;

			if ( strpos( $this->Height, '%' ) === false )
				$HeightCSS = $this->Height . 'px' ;
			else
				$HeightCSS = $this->Height ;

			$Html .= "<textarea name=\"{$this->InstanceName}\" rows=\"4\" cols=\"40\" style=\"width: {$WidthCSS}; height: {$HeightCSS}\">{$HtmlValue}</textarea>" ;
		}

		return $Html ;
	}

	/**
	 * Returns true if browser is compatible with FCKeditor.
	 *
	 * @return boolean
	 */
	public function IsCompatible()
	{
		return FCKeditor_IsCompatibleBrowser() ;
	}

	/**
	 * Get settings from Config array as a single string.
	 *
	 * @access protected
	 * @return string
	 */
	public function GetConfigFieldString()
	{
		$sParams = '' ;
		$bFirst = true ;

		foreach ( $this->Config as $sKey => $sValue )
		{
			if ( $bFirst == false )
				$sParams .= '&amp;' ;
			else
				$bFirst = false ;

			if ( $sValue === true )
				$sParams .= $this->EncodeConfig( $sKey ) . '=true' ;
			else if ( $sValue === false )
				$sParams .= $this->EncodeConfig( $sKey ) . '=false' ;
			else
				$sParams .= $this->EncodeConfig( $sKey ) . '=' . $this->EncodeConfig( $sValue ) ;
		}

		return $sParams ;
	}

	/**
	 * Encode characters that may break the configuration string
	 * generated by GetConfigFieldString().
	 *
	 * @access protected
	 * @param string $valueToEncode
	 * @return string
	 */
	public function EncodeConfig( $valueToEncode )
	{
		$chars = array(
			'&' => '%26',
			'=' => '%3D',
			'"' => '%22' ) ;

		return strtr( $valueToEncode,  $chars ) ;
	}
	
	/**
	  * Parse All plugins tags
	  *
	  * @param string $text The inputed text of fckeditor
	  * @param string $module The module codename which made the request
	  * @return string the text with plugins tags adapted for fckeditor
	  * @access public
	  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
	  */
	function parsePluginsTags($value, $module = MOD_STANDARD_CODENAME) {
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
		return $value;
	}
	
	/**
	  * Create All plugins tags
	  * (initialy Automne Links only)
	  *
	  * @param string $text The outputed text of fckeditor
	  * @param string $module The module codename which made the request
	  * @return string the text with all plugin tags
	  * @access public
	  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
	  */
	function createAutomneLinks($text, $module = MOD_STANDARD_CODENAME) {
		//if post only contain a space or empty paragraph then the block is empty.
		$text = ($text=='&nbsp;' || $text=='<p></p>' || $text=='<div></div>' || $text=='<p>&#160;</p>') ? '' : $text;
		if ($text) {
			/*
			 * we need to do some replacements to be completely conform with Automne
			 * you can add here all dirty tags to be removed from editor's output
			 */
			$replace = array(
				"%7B%7B" 					=> "{{",	//in case of internal links copy/paste, editor encode {{
				"%7D%7D" 					=> "}}",	//in case of internal links copy/paste, editor encode }}
				"/>" 						=> " />",	//xhtml missing space on auto-closed tags
				"<o:p>" 					=> "",		//dirty tags from MS Word pasting
				"</o:p>" 					=> "",
				"<!--[if !supportLists]-->" => "",
				"<!--[endif]-->" 			=> "",
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