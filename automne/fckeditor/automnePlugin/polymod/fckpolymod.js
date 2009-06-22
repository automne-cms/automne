/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)                                                         |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2004 WS Interactive                               |
// | Copyright (c) 2000-2004 Antoine Pouch                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | or (at your discretion) to version 3.0 of the PHP license.           |
// | The first is bundled with this package in the file LICENSE-GPL, and  |
// | is available at through the world-wide-web at                        |
// | http://www.gnu.org/copyleft/gpl.html.                                |
// | The later is bundled with this package in the file LICENSE-PHP, and  |
// | is available at through the world-wide-web at                        |
// | http://www.php.net/license/3_0.txt.                                  |
// +----------------------------------------------------------------------+
// | Author: Frederico Caldeira Knabben (fredck@fckeditor.net)            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |    
// +----------------------------------------------------------------------+
//
// $Id: fckpolymod.js,v 1.2 2009/06/22 14:14:44 sebastien Exp $

/**
  * Javascript plugin for FCKeditor
  * Create Automne medias items insertions
  *
  * @package CMS
  * @subpackage admin
  * @author Frederico Caldeira Knabben (fredck@fckeditor.net)
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

var oEditor = window.parent.InnerDialogLoaded() ;
var FCK		= oEditor.FCK ;
var FCKLang	= oEditor.FCKLang ;

// oSpan: The selected span in the editor if any.
var oSpan;
// oID: The span id in the editor if any
var oID = '';
// oContent: The selected text content in the editor if any
var oContent = '';

//Initialization Code
window.onload = function()
{
	// Translate the dialog box texts.
	oEditor.FCKLanguageManager.TranslatePage(document) ;
	// Load the selected span informations (if any).
	LoadSelection() ;
	//load polymod window
	displayPolymod(oID, oContent);
	// Show the initial dialog content.
	GetE('divInfo').style.display = '' ;
	if (oID) {
		// Activate the "OK" button.
		window.parent.SetOkButton( true ) ;
	}
}
//load current selected span if any and all span infos
function LoadSelection()
{
	oSpan = FCK.Selection.MoveToAncestorNode( 'SPAN' ) ;
	if ( oSpan && oSpan.className == 'polymod'){
		FCK.Selection.SelectNode( oSpan ) ;
		oID = oSpan.id;
		//oContent = oSpan.textContent;
		if (typeof oSpan.innerText != 'undefined') { //IE
			oContent = oSpan.innerText;
		} else if (typeof oSpan.textContent != 'undefined') { //GECKO
			oContent = oSpan.textContent;
		}
	} else {
		if (FCK.EditorWindow.getSelection) { //GECKO
			oContent = FCK.EditorWindow.getSelection();
		} else { //IE
			var oRange = FCK.EditorDocument.selection.createRange() ;
			oContent = oRange.text;
		}
	}
	return;
}
//The OK button was hit.
function Ok()
{
	if (GetE('codeToPaste').value == '') {
		alert(FCKLang['DlgPolymodNoPage']);
	} else {
		var codeToPaste = htmlDecode(GetE('codeToPaste').value);
		//remove old selection code
		FCK.Selection.Delete();
		//then paste the new one
		FCK.InsertHtml(codeToPaste);
		//then close windows
		window.parent.Cancel() ;
	}
}
function htmlDecode(value){
	return !value ? value : String(value).replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, '"');
}
