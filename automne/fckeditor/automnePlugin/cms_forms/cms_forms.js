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
// $Id: cms_forms.js,v 1.1.1.1 2008/11/26 17:12:14 sebastien Exp $

/**
  * Javascript plugin for FCKeditor
  * Create Automne internal links
  *
  * @package CMS
  * @subpackage admin
  * @author Frederico Caldeira Knabben (fredck@fckeditor.net)
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

var oEditor = window.parent.InnerDialogLoaded() ;
var FCK		= oEditor.FCK ;
var FCKLang	= oEditor.FCKLang ;
var FCKXhtml = oEditor.FCKXHtml ;

//#### Initialization Code
window.onload = function()
{
	
	// Translate the dialog box texts.
	oEditor.FCKLanguageManager.TranslatePage(document) ;

	// Show the initial dialog content.
	GetE('divInfo').style.display = '' ;
	
	//activate drag & drop
	if (typeof sortList == "function") {
		sortList();
	}
	
	// Activate the "OK" button.
	window.parent.SetOkButton( true ) ;
	
}

function getFormCode() 
{
	//get corresponding tag for selected label
	var forms = FCK.EditorDocument.getElementsByTagName('FORM');
	if (forms.length && forms.length == 1) {
		//select form
		FCK.Selection.SelectNode(forms[0]);
		//and get form code
		var xhtmlCode = FCKXhtml.GetXHTML(forms[0], true);
	} else if (forms.length && forms.length > 1) {
		alert(FCKLang['DlgCMSFormsOneFormAllowed']);
		//close windows
		window.parent.Cancel() ;
	}
	//get current form id
	var formIdDatas = FCK.Name.split("_");
	var formId = '';
	if (formIdDatas[1]) 
		formId = formIdDatas[1];
	if (formId != '')
		GetE('formId').value = formId;

	// Insert editor content in hidden field to analyse
	if (xhtmlCode) {
		GetE('formCode').value = xhtmlCode;
	}
	GetE('analyseForm').submit();
}
function getFieldCode() 
{
	var selectedElement = FCK.Selection.GetSelectedElement();
	if (!selectedElement) {
		var label = FCK.Selection.MoveToAncestorNode( 'LABEL' ) ;
		if (label && label.htmlFor) {
			//get corresponding tag for selected label
			var e = FCK.EditorDocument.getElementById(label.htmlFor);
			FCK.Selection.SelectNode(e);
			selectedElement = FCK.Selection.GetSelectedElement();
		}
	}
	if (!selectedElement || !selectedElement.name) {
		alert(FCKLang['DlgCMSFormsPleaseSelect']);
		//close windows
		window.parent.Cancel() ;
	}
	GetE('fieldName').value = selectedElement.name;
	
	return true;
}
function getFieldPosition() {
	// Get the row where the selection is placed in.
	var oRow = FCK.Selection.MoveToAncestorNode( 'TR' ) ;
	if ( !oRow ) return ;

	// Create a clone of the row.
	var oNewRow = oRow.cloneNode( true ) ;

	// Insert the new row (copy) before of it.
	oRow.parentNode.insertBefore( oNewRow, oRow ) ;

	// add content in new row
	prepareRow( oRow ) ;
}

function prepareRow( tr ) {
	// Get the array of row's cells.
	var aCells = tr.cells ;

	// Replace the contents of each cell with "nothing".
	for ( var i = 0 ; i < aCells.length && i < 2; i++ ) {
		aCells[i].innerHTML = (i == 0) ? '{{label}}' : '{{field}}' ;
	}
}

function addField()
{
	GetE('cms_action').value = 'addField';
	GetE('modifyForm').submit();
}

function removeField(fieldID)
{
	GetE('cms_action').value = 'deleteField';
	GetE('deleteField').value = fieldID;
	GetE('modifyForm').submit();
}

function sendFormCode(formCode)
{
	GetE('codeSent').value = formCode;
	Ok();
}

//#### The OK button was hit.
function Ok()
{
	//check if we are in step 4
	if (GetE('codeSent')) {
		var formCode = GetE('codeSent').value;
		//remove old form code
		FCK.Selection.Delete();
		//then paste the new one
		FCK.InsertHtml(formCode);
		//then close windows
		window.parent.Cancel() ;
	} else {
		//submit modification form
		GetE('modifyForm').submit();
		return false ;
	}
}
//#### Send an error to the user and close
function displayError(msg) {
	alert(msg);
	//then close windows
	window.parent.Cancel() ;
}

//Select Management
function Select( combo )
{
	var iIndex = combo.selectedIndex ;

	oListText.selectedIndex		= iIndex ;
	oListValue.selectedIndex	= iIndex ;

	var oTxtText	= document.getElementById( "txtText" ) ;
	var oTxtValue	= document.getElementById( "txtValue" ) ;

	oTxtText.value	= oListText.value ;
	oTxtValue.value	= oListValue.value ;
}

function Add()
{
	var oTxtText	= document.getElementById( "txtText" ) ;
	var oTxtValue	= document.getElementById( "txtValue" ) ;

	AddComboOption( oListText, oTxtText.value, oTxtText.value ) ;
	AddComboOption( oListValue, oTxtValue.value, oTxtValue.value ) ;

	oListText.selectedIndex = oListText.options.length - 1 ;
	oListValue.selectedIndex = oListValue.options.length - 1 ;

	oTxtText.value	= '' ;
	oTxtValue.value	= '' ;

	oTxtText.focus() ;
}

function Modify()
{
	var iIndex = oListText.selectedIndex ;

	if ( iIndex < 0 ) return ;

	var oTxtText	= document.getElementById( "txtText" ) ;
	var oTxtValue	= document.getElementById( "txtValue" ) ;

	oListText.options[ iIndex ].innerHTML	= oTxtText.value ;
	oListText.options[ iIndex ].value		= oTxtText.value ;

	oListValue.options[ iIndex ].innerHTML	= oTxtValue.value ;
	oListValue.options[ iIndex ].value		= oTxtValue.value ;

	oTxtText.value	= '' ;
	oTxtValue.value	= '' ;

	oTxtText.focus() ;
}

function Move( steps )
{
	ChangeOptionPosition( oListText, steps ) ;
	ChangeOptionPosition( oListValue, steps ) ;
}

function Delete()
{
	RemoveSelectedOptions( oListText ) ;
	RemoveSelectedOptions( oListValue ) ;
}

function SetSelectedValue()
{
	var iIndex = oListValue.selectedIndex ;
	if ( iIndex < 0 ) return ;

	var oTxtValue = document.getElementById( "txtSelValue" ) ;

	oTxtValue.value = oListValue.options[ iIndex ].value ;
}

// Moves the selected option by a number of steps (also negative)
function ChangeOptionPosition( combo, steps )
{
	var iActualIndex = combo.selectedIndex ;

	if ( iActualIndex < 0 )
		return ;

	var iFinalIndex = iActualIndex + steps ;

	if ( iFinalIndex < 0 )
		iFinalIndex = 0 ;

	if ( iFinalIndex > ( combo.options.lenght - 1 ) )
		iFinalIndex = combo.options.lenght - 1 ;

	if ( iActualIndex == iFinalIndex )
		return ;

	var oOption = combo.options[ iActualIndex ] ;
	var sText	= oOption.innerHTML ;
	var sValue	= oOption.value ;

	combo.remove( iActualIndex ) ;

	oOption = AddComboOption( combo, sText, sValue, null, iFinalIndex ) ;

	oOption.selected = true ;
}

// Remove all selected options from a SELECT object
function RemoveSelectedOptions(combo)
{
	// Save the selected index
	var iSelectedIndex = combo.selectedIndex ;

	var oOptions = combo.options ;

	// Remove all selected options
	for ( var i = oOptions.length - 1 ; i >= 0 ; i-- )
	{
		if (oOptions[i].selected) combo.remove(i) ;
	}

	// Reset the selection based on the original selected index
	if ( combo.options.length > 0 )
	{
		if ( iSelectedIndex >= combo.options.length ) iSelectedIndex = combo.options.length - 1 ;
		combo.selectedIndex = iSelectedIndex ;
	}
}

// Add a new option to a SELECT object (combo or list)
function AddComboOption( combo, optionText, optionValue, documentObject, index )
{
	var oOption ;

	if ( documentObject )
		oOption = documentObject.createElement("OPTION") ;
	else
		oOption = document.createElement("OPTION") ;

	if ( index != null )
		combo.options.add( oOption, index ) ;
	else
		combo.options.add( oOption ) ;

	oOption.innerHTML = optionText.length > 0 ? optionText : '&nbsp;' ;
	oOption.value     = optionValue ;

	return oOption ;
}

// Remove all options from a SELECT object
function RemoveOptions(combo)
{
	var oOptions = combo.options ;

	// Remove all selected options
	for ( var i = oOptions.length - 1 ; i >= 0 ; i-- )
	{
		combo.remove(i) ;
	}
}

function viewHideOptionsButton(documentObject, optionsButton)
{
	//view/hide select options button or default option button
	if (documentObject.value == 'select') {
		GetE(optionsButton).style.display = '' ;
		if (GetE(optionsButton + '_value')) {
			GetE(optionsButton + '_value').style.display = 'none' ;
		}
	} else {
		GetE(optionsButton).style.display = 'none' ;
		if (GetE(optionsButton + '_value')) {
			GetE(optionsButton + '_value').style.display = '' ;
		}
	}
}

function manageSelectOptions(fieldID)
{
	// Hide the initial dialog content.
	GetE('divInfo').style.display = 'none' ;
	// Show the select options dialog content.
	GetE('divSelect').style.display = '' ;
	
	//set the current fieldID
	GetE('fieldIDValue').value = fieldID;
	
	//load current options
	var selectValues = GetE( 'selectValues_' + fieldID ).value.split(",");
	var selectLabels = GetE( 'selectLabels_' + fieldID ).value.split(",");
	var defaultValue = GetE( 'defaultValue_' + fieldID ).value;
	
	//set default value
	if (GetE( 'defaultValue_' + fieldID ).value) {
		GetE( "txtSelValue" ).value = GetE( 'defaultValue_' + fieldID ).value;
	} else {
		GetE( "txtSelValue" ).value = '';
	}
	
	//load select options
	oListText	= GetE( 'cmbText' ) ;
	oListValue	= GetE( 'cmbValue' ) ;
	
	//remove options from list
	RemoveOptions(oListText);
	RemoveOptions(oListValue);
	GetE( 'txtText' ).value = '';
	GetE( 'txtValue' ).value = '';
	
	// Load select actual options
	for ( var i = 0 ; i < selectValues.length ; i++ )
	{
		var sText	= selectLabels[i] ;
		var sValue	= selectValues[i] ;
		if (sText) {
			AddComboOption( oListText, sText, sText ) ;
			AddComboOption( oListValue, sValue, sValue ) ;
		}
	}
}

function manageFormFromSelect()
{
	//get the current fieldID
	var fieldID = GetE('fieldIDValue').value;
	
	//load select options
	oListText	= GetE( 'cmbText' ) ;
	oListValue	= GetE( 'cmbValue' ) ;
	
	// Add all available options.
	var finalText = '';
	var finalValue = '';
	var selectedValue = '';
	for ( var i = 0 ; i < oListText.options.length ; i++ )
	{
		if ( oListValue.options[i].value.length == 0 ) oListValue.options[i].value = oListText.options[i].value ;
		
		if (i > 0) {
			finalText	+= ',';
			finalValue	+= ',';
		}
		finalText	+= oListText.options[i].value ;
		finalValue	+= oListValue.options[i].value ;

		/*if ( oListValue.options[i].value == GetE('txtSelValue').value )
		{
			var selectedValue = oListValue.options[i].value;
		}*/
	}
	
	//reset select values with new ones
	GetE( 'selectValues_' + fieldID ).value = finalValue;
	GetE( 'selectLabels_' + fieldID ).value = finalText;
	GetE( 'defaultValue_' + fieldID ).value = GetE('txtSelValue').value;
	
	// Hide the select dialog content.
	GetE('divSelect').style.display = 'none' ;
	// Show the initial options dialog content.
	GetE('divInfo').style.display = '' ;
}
function manageDefaultOptions(fieldID)
{
	// Hide the initial dialog content.
	GetE('divInfo').style.display = 'none' ;
	// Show the default value dialog content.
	GetE('divDefault').style.display = '' ;
	
	//set the current fieldID
	GetE('fieldIDDefaultValue').value = fieldID;
	
	//set default value
	GetE( "defaultValue" ).value = GetE( 'defaultValue_' + fieldID ).value;
}

function manageFormFromDefault()
{
	//get the current fieldID
	var fieldID = GetE('fieldIDDefaultValue').value;
	GetE( 'defaultValue_' + fieldID ).value = GetE( "defaultValue" ).value;
	
	// Hide the select dialog content.
	GetE('divDefault').style.display = 'none' ;
	// Show the initial options dialog content.
	GetE('divInfo').style.display = '' ;
}
