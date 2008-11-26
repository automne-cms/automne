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
// | Author: Frederico Caldeira Knabben (fredck@fckeditor.net)            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: fck_link.js,v 1.1.1.1 2008/11/26 17:12:14 sebastien Exp $

/**
  * Javascript plugin for FCKeditor
  * Create Automne internal links
  *
  * @package CMS
  * @subpackage admin
  * @author Frederico Caldeira Knabben (fredck@fckeditor.net)
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

var oEditor		= window.parent.InnerDialogLoaded() ;
var FCK			= oEditor.FCK ;
var FCKLang		= oEditor.FCKLang ;
var FCKConfig	= oEditor.FCKConfig ;
var FCKRegexLib	= oEditor.FCKRegexLib ;
var FCKTools	= oEditor.FCKTools ;

//#### Dialog Tabs

// Set the dialog tabs.
window.parent.AddTab( 'Info', FCKLang['DlgAutomneLinksChoose'] ) ;

if ( !FCKConfig.LinkDlgHideTarget )
	window.parent.AddTab( 'Target', FCKLang.DlgLnkTargetTab ) ;

if ( !FCKConfig.LinkDlgHideAdvanced )
	window.parent.AddTab( 'Advanced', FCKLang.DlgAdvancedTag ) ;

// Function called when a dialog tag is selected.
function OnDialogTabChange( tabCode )
{
	ShowE('divInfo'		, ( tabCode == 'Info' ) ) ;
	ShowE('divTarget'	, ( tabCode == 'Target' ) ) ;
	ShowE('divAttribs'	, ( tabCode == 'Advanced' ) ) ;

	window.parent.SetAutoSize( true ) ;
}

//#### Regular Expressions library.
var oRegex = new Object() ;

oRegex.UriProtocol = /^(((http|https|ftp|news):\/\/)|mailto:)/gi ;

oRegex.UrlOnChangeProtocol = /^(http|https|ftp|news):\/\/(?=.)/gi ;

oRegex.UrlOnChangeTestOther = /^((javascript:)|[#\/\.])/gi ;

oRegex.ReserveTarget = /^_(blank|self|top|parent)$/i ;

oRegex.PopupUri = /^javascript:void\(\s*window.open\(\s*'([^']+)'\s*,\s*(?:'([^']*)'|null)\s*,\s*'([^']*)'\s*\)\s*\)\s*$/ ;

// Accessible popups
oRegex.OnClickPopup = /^\s*on[cC]lick="\s*window.open\(\s*this\.href\s*,\s*(?:'([^']*)'|null)\s*,\s*'([^']*)'\s*\)\s*;\s*return\s*false;*\s*"$/ ;

oRegex.PopupFeatures = /(?:^|,)([^=]+)=(\d+|yes|no)/gi ;

//#### Initialization Code

// oLink: The actual selected link in the editor.
var oLink = FCK.Selection.MoveToAncestorNode( 'A' ) ;
if ( oLink )
	FCK.Selection.SelectNode( oLink ) ;

window.onload = function()
{
	// Translate the dialog box texts.
	oEditor.FCKLanguageManager.TranslatePage(document) ;

	// Fill the Anchor Names and Ids combos.
	//LoadAnchorNamesAndIds() ;

	// Load the selected link information (if any).
	LoadSelection() ;

	// Update the dialog box.
	SetLinkType( 'url' ) ;
	
	// Show the initial dialog content.
	GetE('divInfo').style.display = '' ;

	// Activate the "OK" button.
	window.parent.SetOkButton( true ) ;
}

var bHasAnchors ;

function LoadAnchorNamesAndIds()
{
	// Since version 2.0, the anchors are replaced in the DOM by IMGs so the user see the icon
	// to edit them. So, we must look for that images now.
	var aAnchors = new Array() ;
	var i ;
	var oImages = oEditor.FCK.EditorDocument.getElementsByTagName( 'IMG' ) ;
	for( i = 0 ; i < oImages.length ; i++ )
	{
		if ( oImages[i].getAttribute('_fckanchor') )
			aAnchors[ aAnchors.length ] = oEditor.FCK.GetRealElement( oImages[i] ) ;
	}

	// Add also real anchors
	var oLinks = oEditor.FCK.EditorDocument.getElementsByTagName( 'A' ) ;
	for( i = 0 ; i < oLinks.length ; i++ )
	{
		if ( oLinks[i].name && ( oLinks[i].name.length > 0 ) )
			aAnchors[ aAnchors.length ] = oLinks[i] ;
	}

	var aIds = oEditor.FCKTools.GetAllChildrenIds( oEditor.FCK.EditorDocument.body ) ;

	bHasAnchors = ( aAnchors.length > 0 || aIds.length > 0 ) ;

	for ( i = 0 ; i < aAnchors.length ; i++ )
	{
		var sName = aAnchors[i].name ;
		if ( sName && sName.length > 0 )
			oEditor.FCKTools.AddSelectOption( GetE('cmbAnchorName'), sName, sName ) ;
	}

	for ( i = 0 ; i < aIds.length ; i++ )
	{
		oEditor.FCKTools.AddSelectOption( GetE('cmbAnchorId'), aIds[i], aIds[i] ) ;
	}

	//ShowE( 'divSelAnchor'	, bHasAnchors ) ;
	//ShowE( 'divNoAnchor'	, !bHasAnchors ) ;
}

function LoadSelection()
{
	if(!oLink){
		// noSelection tag
		GetE('noselection').checked = "checked";
		displayTree();
		return ;
	}
	// get noSelection tag
	if(oLink.getAttribute('noselection') == 'true'){
		GetE('noselection').checked = "checked";
	}
	
	// Get the actual Link href.
	var sHRef = oLink.getAttribute( '_fcksavedurl' ) ;
	if ( sHRef == null )
		sHRef = oLink.getAttribute( 'href' , 2 ) || '' ;

	// Look for a popup javascript link.
	var oPopupMatch = oRegex.PopupUri.exec( sHRef ) ;
	if( oPopupMatch )
	{
		GetE('cmbTarget').value = 'popup' ;
		sHRef = oPopupMatch[1] ;
		FillPopupFields( oPopupMatch[2], oPopupMatch[3] ) ;
		SetTarget( 'popup' ) ;
	}

	// Accessible popups, the popup data is in the onclick attribute
	if ( !oPopupMatch ) 
	{
		var onclick = oLink.getAttribute( 'onclick_fckprotectedatt' ) ;
		if ( onclick )
		{
			// Decode the protected string
			onclick = decodeURIComponent( onclick ) ;
			
			oPopupMatch = oRegex.OnClickPopup.exec( onclick ) ;
			if( oPopupMatch )
			{
				GetE( 'cmbTarget' ).value = 'popup' ;
				FillPopupFields( oPopupMatch[1], oPopupMatch[2] ) ;
				SetTarget( 'popup' ) ;
			}
		}
	}
	
	sType = 'url' ;
	if (sHRef && sHRef.substr(0,2) == '{{') {
		// get last ID selected
		GetE('txtUrl').value = sHRef.substr(0,(sHRef.length -2)).substr(2);
		displayTree(GetE('txtUrl').value);
	}
	
	if ( !oPopupMatch )
	{
		// Get the target.
		var sTarget = oLink.target ;

		if ( sTarget && sTarget.length > 0 )
		{
			if ( oRegex.ReserveTarget.test( sTarget ) )
			{
				sTarget = sTarget.toLowerCase() ;
				GetE('cmbTarget').value = sTarget ;
			}
			else
				GetE('cmbTarget').value = 'frame' ;
			GetE('txtTargetFrame').value = sTarget ;
		}
	}
	
	// Get Advances Attributes
	GetE('txtAttId').value			= oLink.id ;
	GetE('txtAttName').value		= oLink.name ;
	GetE('cmbAttLangDir').value		= oLink.dir ;
	GetE('txtAttLangCode').value	= oLink.lang ;
	GetE('txtAttAccessKey').value	= oLink.accessKey ;
	GetE('txtAttTabIndex').value	= oLink.tabIndex <= 0 ? '' : oLink.tabIndex ;
	GetE('txtAttTitle').value		= oLink.title ;
	GetE('txtAttContentType').value	= oLink.type ;
	GetE('txtAttCharSet').value		= oLink.charset ;

	var sClass ;
	if ( oEditor.FCKBrowserInfo.IsIE )
	{
		sClass	= oLink.getAttribute('className',2) || '' ;
		// Clean up temporary classes for internal use:
		sClass = sClass.replace( FCKRegexLib.FCK_Class, '' ) ;

		GetE('txtAttStyle').value	= oLink.style.cssText ;
	}
	else
	{
		sClass	= oLink.getAttribute('class',2) || '' ;
		GetE('txtAttStyle').value	= oLink.getAttribute('style',2) || '' ;
	}
	GetE('txtAttClasses').value	= sClass ;

	// Update the Link type combo.
	GetE('cmbLinkType').value = sType ;
}

//#### Link type selection.
function SetLinkType( linkType )
{
	//do nothing
}

//#### Target type selection.
function SetTarget( targetType )
{
	GetE('tdTargetFrame').style.display	= ( targetType == 'popup' ? 'none' : '' ) ;
	GetE('tdPopupName').style.display	=
	GetE('tablePopupFeatures').style.display = ( targetType == 'popup' ? '' : 'none' ) ;

	switch ( targetType )
	{
		case "_blank" :
		case "_self" :
		case "_parent" :
		case "_top" :
			GetE('txtTargetFrame').value = targetType ;
			break ;
		case "" :
			GetE('txtTargetFrame').value = '' ;
			break ;
	}

	if ( targetType == 'popup' )
		window.parent.SetAutoSize( true ) ;
}

//#### Called while the user types the URL.
function OnUrlChange()
{
	var sUrl = '{{'+GetE('txtUrl').value+'}}' ;
}

//#### Called while the user types the target name.
function OnTargetNameChange()
{
	var sFrame = GetE('txtTargetFrame').value ;

	if ( sFrame.length == 0 )
		GetE('cmbTarget').value = '' ;
	else if ( oRegex.ReserveTarget.test( sFrame ) )
		GetE('cmbTarget').value = sFrame.toLowerCase() ;
	else
		GetE('cmbTarget').value = 'frame' ;
}

// Accessible popups
function BuildOnClickPopup()
{
	var sWindowName = "'" + GetE('txtPopupName').value.replace(/\W/gi, "") + "'" ;

	var sFeatures = '' ;
	var aChkFeatures = document.getElementsByName( 'chkFeature' ) ;
	for ( var i = 0 ; i < aChkFeatures.length ; i++ )
	{
		if ( i > 0 ) sFeatures += ',' ;
		sFeatures += aChkFeatures[i].value + '=' + ( aChkFeatures[i].checked ? 'yes' : 'no' ) ;
	}

	if ( GetE('txtPopupWidth').value.length > 0 )	sFeatures += ',width=' + GetE('txtPopupWidth').value ;
	if ( GetE('txtPopupHeight').value.length > 0 )	sFeatures += ',height=' + GetE('txtPopupHeight').value ;
	if ( GetE('txtPopupLeft').value.length > 0 )	sFeatures += ',left=' + GetE('txtPopupLeft').value ;
	if ( GetE('txtPopupTop').value.length > 0 )		sFeatures += ',top=' + GetE('txtPopupTop').value ;

	if ( sFeatures != '' )
		sFeatures = sFeatures + ",status" ;

	return ( "window.open(this.href," + sWindowName + ",'" + sFeatures + "'); return false" ) ;
}

//#### Fills all Popup related fields.
function FillPopupFields( windowName, features )
{
	if ( windowName )
		GetE('txtPopupName').value = windowName ;

	var oFeatures = new Object() ;
	var oFeaturesMatch ;
	while( ( oFeaturesMatch = oRegex.PopupFeatures.exec( features ) ) != null )
	{
		var sValue = oFeaturesMatch[2] ;
		if ( sValue == ( 'yes' || '1' ) )
			oFeatures[ oFeaturesMatch[1] ] = true ;
		else if ( ! isNaN( sValue ) && sValue != 0 )
			oFeatures[ oFeaturesMatch[1] ] = sValue ;
	}

	// Update all features check boxes.
	var aChkFeatures = document.getElementsByName('chkFeature') ;
	for ( var i = 0 ; i < aChkFeatures.length ; i++ )
	{
		if ( oFeatures[ aChkFeatures[i].value ] )
			aChkFeatures[i].checked = true ;
	}

	// Update position and size text boxes.
	if ( oFeatures['width'] )	GetE('txtPopupWidth').value		= oFeatures['width'] ;
	if ( oFeatures['height'] )	GetE('txtPopupHeight').value	= oFeatures['height'] ;
	if ( oFeatures['left'] )	GetE('txtPopupLeft').value		= oFeatures['left'] ;
	if ( oFeatures['top'] )		GetE('txtPopupTop').value		= oFeatures['top'] ;
}

//#### The OK button was hit.
function Ok()
{
	var sUri, sInnerHtml ;
	oEditor.FCKUndo.SaveUndoStep() ;
	
	sUri = '{{'+GetE('txtUrl').value+'}}' ;
	
	if ( sUri.length == 0 )
	{
		alert( FCKLang.DlnLnkMsgNoUrl ) ;
		return false ;
	}
	// If no link is selected, create a new one (it may result in more than one link creation - #220).
	var aLinks = oLink ? [ oLink ] : oEditor.FCK.CreateLink( sUri, true ) ;
	
	// If no selection, no links are created, so use the uri as the link text (by dom, 2006-05-26)
	var aHasSelection = ( aLinks.length > 0 ) ;
	if ( !aHasSelection )
	{
		sInnerHtml = GetE('nodeText').value;
		var oLinkPathRegEx = new RegExp("//?([^?\"']+)([?].*)?$") ;
		var asLinkPath = oLinkPathRegEx.exec( sUri ) ;
		if (asLinkPath != null)
			sInnerHtml = asLinkPath[1];  // use matched path
		// Create a new (empty) anchor.
		aLinks = [ oEditor.FCK.InsertElement( 'a' ) ] ;
	}
	for ( var i = 0 ; i < aLinks.length ; i++ )
	{
		oLink = aLinks[i] ;
		if ( aHasSelection )
			sInnerHtml = oLink.innerHTML ;		// Save the innerHTML (IE changes it if it is like an URL).

		oLink.href = sUri ;
		SetAttribute( oLink, '_fcksavedurl', sUri ) ;

		var onclick;
		// Accessible popups
		if( GetE('cmbTarget').value == 'popup' )
		{
			onclick = BuildOnClickPopup() ;
			// Encode the attribute
			onclick = encodeURIComponent( " onclick=\"" + onclick + "\"" )  ;
			SetAttribute( oLink, 'onclick_fckprotectedatt', onclick ) ;
		}
		else
		{
			// Check if the previous onclick was for a popup:
			// In that case remove the onclick handler.
			onclick = oLink.getAttribute( 'onclick_fckprotectedatt' ) ;
			if ( onclick )
			{
				// Decode the protected string
				onclick = decodeURIComponent( onclick ) ;
			
				if( oRegex.OnClickPopup.test( onclick ) )
					SetAttribute( oLink, 'onclick_fckprotectedatt', '' ) ;
			}
		}
		oLink.innerHTML = sInnerHtml ;		// Set (or restore) the innerHTML

		// Target
		if( GetE('cmbTarget').value != 'popup' )
			SetAttribute( oLink, 'target', GetE('txtTargetFrame').value ) ;
		else
			SetAttribute( oLink, 'target', null ) ;

		// Let's set the "id" only for the first link to avoid duplication.
		if ( i == 0 )
			SetAttribute( oLink, 'id', GetE('txtAttId').value ) ;

		// Advances Attributes
		SetAttribute( oLink, 'name'		, GetE('txtAttName').value ) ;
		SetAttribute( oLink, 'dir'		, GetE('cmbAttLangDir').value ) ;
		SetAttribute( oLink, 'lang'		, GetE('txtAttLangCode').value ) ;
		SetAttribute( oLink, 'accesskey', GetE('txtAttAccessKey').value ) ;
		SetAttribute( oLink, 'tabindex'	, ( GetE('txtAttTabIndex').value > 0 ? GetE('txtAttTabIndex').value : null ) ) ;
		SetAttribute( oLink, 'title'	, GetE('txtAttTitle').value ) ;
		SetAttribute( oLink, 'type'		, GetE('txtAttContentType').value ) ;
		SetAttribute( oLink, 'charset'	, GetE('txtAttCharSet').value ) ;
		// NoSelection tag 	 
		noSelectionTag = (GetE('noselection').checked) ? 'true' : null; 	 
		SetAttribute( oLink, 'noselection', noSelectionTag ) ;
		if ( oEditor.FCKBrowserInfo.IsIE )
		{
			var sClass = GetE('txtAttClasses').value ;
			// If it's also an anchor add an internal class
			if ( GetE('txtAttName').value.length != 0 )
				sClass += ' FCK__AnchorC' ;
			SetAttribute( oLink, 'className', sClass ) ;

			oLink.style.cssText = GetE('txtAttStyle').value ;
		}
		else
		{
			SetAttribute( oLink, 'class', GetE('txtAttClasses').value ) ;
			SetAttribute( oLink, 'style', GetE('txtAttStyle').value ) ;
		}
	}
	// Select the (first) link.
	oEditor.FCKSelection.SelectNode( aLinks[0] );
	return true ;
}

function SetUrl( url )
{
	document.getElementById('txtUrl').value = url ;
	OnUrlChange() ;
	window.parent.SetSelectedTab( 'Info' ) ;
}