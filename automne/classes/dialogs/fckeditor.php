<?php 
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2004 Frederico Caldeira Knabben
 * 
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 * 
 * For further information visit:
 * 		http://www.fckeditor.net/
 * 
 * File Name: fckeditor.php
 * 	This is the integration file for PHP.
 * 	
 * 	It defines the FCKeditor class that can be used to create editor
 * 	instances in PHP pages on server side.
 * 
 * Version:  2.0 RC2
 * Modified: 2004-11-29 17:56:52
 * 
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 *      Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
 */
// $Id: fckeditor.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

class FCKeditor
{
	var $InstanceName ;
	var $BasePath ;
	var $Width ;
	var $Height ;
	var $ToolbarSet ;
	var $Value ;
	var $Config ;

	function FCKeditor( $instanceName )
	{
		$this->InstanceName	= $instanceName ;
		$this->BasePath		= PATH_ADMIN_WR.'/fckeditor/' ;
		$this->Width		= '100%' ;
		$this->Height		= '400' ;
		$this->ToolbarSet	= 'Default' ;
		$this->Value		= '' ;

		$this->Config		= array() ;
	}

	function Create()
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
	
	function CreateHtml()
	{
		$HtmlValue = htmlspecialchars( $this->Value ) ;

		$Html = '<div>' ;
		
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
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}\" name=\"{$this->InstanceName}\" value=\"{$HtmlValue}\" />" ;

			// Render the configurations hidden field.
			$Html .= "<input type=\"hidden\" id=\"{$this->InstanceName}___Config\" value=\"" . $this->GetConfigFieldString() . "\" />" ;

			// Render the editor IFRAME.
			$Html .= "<iframe id=\"{$this->InstanceName}___Frame\" src=\"{$Link}\" width=\"{$this->Width}\" height=\"{$this->Height}\" frameborder=\"no\" scrolling=\"no\"></iframe>" ;
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

			$Html .= "<textarea name=\"{$this->InstanceName}\" rows=\"4\" cols=\"40\" style=\"width: {$WidthCSS}; height: {$HeightCSS}\" wrap=\"virtual\">{$HtmlValue}</textarea>" ;
		}

		$Html .= '</div>' ;
		
		return $Html ;
	}

	function IsCompatible()
	{
		global $HTTP_USER_AGENT ;

		if ( isset( $HTTP_USER_AGENT ) )
			$sAgent = $HTTP_USER_AGENT ;
		else
			$sAgent = $_SERVER['HTTP_USER_AGENT'] ;

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
		else
			return false ;
	}

	function GetConfigFieldString()
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
	
	function EncodeConfig( $valueToEncode )
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
		$modulesTreatment = new CMS_modulesTags(MODULE_TREATMENT_WYSIWYG_INNER_TAGS, RESOURCE_DATA_LOCATION_EDITION, new CMS_date());
		$wantedTags = $modulesTreatment->getWantedTags();
		//create regular expression on wanted tags
		$exp = '';
		foreach ($wantedTags as $aWantedTag) {
			$exp .= ($exp) ? '|<'.$aWantedTag["tagName"] : '<'.$aWantedTag["tagName"];
		}
		//is parsing needed (value contain some of these wanted tags)
		if (is_array($wantedTags) && $wantedTags && preg_match('#('.$exp.')+#' ,$value) !== false) {
			$parser = new CMS_XMLParser(XMLPARSER_DATA_TYPE_CDATA, '<html>'.$value.'</html>');
			$addWantedTagsOK = true;
			foreach ($wantedTags as $aWantedTag) {
				$addWantedTagsOK = ($parser->addWantedTag($aWantedTag["tagName"], $aWantedTag["selfClosed"])) ? $addWantedTagsOK:false;
			}
			if ($addWantedTagsOK === true
				&& $parser->parse()) {
				$tags = $parser->getTags();
			} else {
				CMS_grandFather::_raiseError("FCKeditor : parsePluginsTags : malformed content returned by edited row");
				return $value;
			}
			if (is_array($tags) && $tags) {
				$offset = 0;
				$content = '';
				foreach ($tags as $tag) {
					//add the cdata from the end of last tag to the beginning of the current tag
					$content .= substr($value, $offset, ($tag->getStartByte()-6) - $offset);
					$content .= $modulesTreatment->treatWantedTag($tag, array('module' => $module));
					$offset = $tag->getEndByte()-6;
				}
				$value = $content . substr($value, $offset);
			}
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
		/*
		 * we need to do some replacements to be completely conform with Automne
		 * you can add here all dirty tags to be removed from editor's output
		 */
		$replace = array(
			"%7B%7B" 					=> "{{",		//in case of internal links copy/paste, editor encode {{
			"%7D%7D" 					=> "}}",		//in case of internal links copy/paste, editor encode }}
			"/>" 						=> " />",		//xhtml missing space on auto-closed tags
			"<o:p>" 					=> "",			//dirty tags from MS Word pasting
			"</o:p>" 					=> "",
			"<!--[if !supportLists]-->" => "",
			"<!--[endif]-->" 			=> "",
			'<font' 					=> '<span', 	//remove ugly font tags
       		'color="' 					=> 'style="color: ',
       		'size="1"' 					=> 'style="font-size: xx-small;"',
       		'size="2"' 					=> 'style="font-size: x-small;"',
       		'size="3"' 					=> 'style="font-size: small;"',
       		'size="4"' 					=> 'style="font-size: medium;"',
       		'size="5"' 					=> 'style="font-size: large;"',
       		'size="6"' 					=> 'style="font-size: x-large;"',
       		'size="7"' 					=> 'style="font-size: xx-large;"',
       		'</font>' 					=> '</span>',
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
			$parser = new CMS_XMLParser(XMLPARSER_DATA_TYPE_CDATA, '<html>'.$text.'</html>');
			$addWantedTagsOK = true;
			foreach ($wantedTags as $aWantedTag) {
				$addWantedTagsOK = ($parser->addWantedTag($aWantedTag["tagName"], $aWantedTag["selfClosed"], $aWantedTag["parameters"])) ? $addWantedTagsOK:false;
			}
			if ($addWantedTagsOK === true
				&& $parser->parse()) {
				$tags = $parser->getTags();
			} else {
				CMS_grandFather::_raiseError("FCKeditor : createAutomneLinks : malformed content returned by editor");
			}
			if (is_array($tags) && $tags) {
				$offset = 0;
				$content = '';
				foreach ($tags as $tag) {
					//add the cdata from the end of last tag to the beginning of the current tag
					$content .= substr($text, $offset, ($tag->getStartByte()-6) - $offset);
					$content .= $modulesTreatment->treatWantedTag($tag, array('module' => $module));
					$offset = $tag->getEndByte()-6;
				}
				$text = $content . substr($text, $offset);
			}
		}
		//if post only contain a space or empty paragraph then the block is empty.
		$text = ($text=='&nbsp;' || $text=='<p></p>' || $text=='<div></div>') ? '' : $text;
		return $text;
	}
}
?>