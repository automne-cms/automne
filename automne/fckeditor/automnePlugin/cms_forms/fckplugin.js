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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: fckplugin.js,v 1.1.1.1 2008/11/26 17:12:14 sebastien Exp $

/**
  * Javascript plugin for FCKeditor
  * Create cms_forms module wizard
  *
  * @package Modules
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

// Register the related commands.
FCKCommands.RegisterCommand( 'cms_forms'		, new FCKDialogCommand( FCKLang['DlgCMSFormsTitle']	, FCKLang['DlgCMSFormsTitle']		, FCKConfig.PluginsPath + 'cms_forms/cms_forms.php'	, 500, 500 ) ) ;

// Create the "automneLinks" toolbar button.
var oCMSForms		= new FCKToolbarButton( 'cms_forms', FCKLang['DlgCMSFormsTitle'] ) ;
oCMSForms.IconPath	= FCKConfig.PluginsPath + 'cms_forms/cms_forms.gif' ;

FCKToolbarItems.RegisterItem( 'cms_forms', oCMSForms ) ;			// 'cms_forms' is the name used in the Toolbar config.


// ##### Define "Edit input" context menu entry.

// ## 1. Define the command to be executed when selecting the context menu item.
var oEditInputCommand = new Object() ;
oEditInputCommand.Name = 'EditInput' ;

// This is the standard function used to execute the command (called when clicking in the context menu item).
oEditInputCommand.Execute = function()
{
	FCKDialog.OpenDialog( 'FCKDialog_cms_forms_edit', FCKLang['DlgCMSFormsEditTitle'], FCKConfig.PluginsPath + 'cms_forms/cms_forms_edit.php', 440, 480 ) ;
}

// This is the standard function used to retrieve the command state (it could be disabled for some reason).
oEditInputCommand.GetState = function()
{
	// Let's make it always enabled.
	return FCK_TRISTATE_OFF ;
}

// ## 2. Register our custom command.
FCKCommands.RegisterCommand( 'EditInput', oEditInputCommand ) ;


// ## 1. Define the command to be executed when selecting the context menu item.
var oAddInputCommand = new Object() ;
oAddInputCommand.Name = 'AddInput' ;

// This is the standard function used to execute the command (called when clicking in the context menu item).
oAddInputCommand.Execute = function()
{
	FCKDialog.OpenDialog( 'FCKDialog_cms_forms_add', FCKLang['DlgCMSFormsAddTitle'], FCKConfig.PluginsPath + 'cms_forms/cms_forms_add.php', 440, 480 ) ;
}

// This is the standard function used to retrieve the command state (it could be disabled for some reason).
oAddInputCommand.GetState = function()
{
	// Let's make it always enabled.
	return FCK_TRISTATE_OFF ;
}

// ## 2. Register our custom command.
FCKCommands.RegisterCommand( 'AddInput', oAddInputCommand ) ;


// ## 3. Define the context menu "listener".
var oEditInputContextMenuListener = new Object() ;

// This is the standard function called right before sowing the context menu.
oEditInputContextMenuListener.AddItems = function( contextMenu, tag, tagName )
{
	// Let's show our custom option only for form fields.
	if ( tagName == 'INPUT' || tagName == 'TEXTAREA' || tagName == 'SELECT' || tagName == 'LABEL' || FCKSelection.HasAncestorNode( 'LABEL' ))
	{
		if (FCKSelection.HasAncestorNode( 'LABEL' )) {
			FCKSelection.MoveToAncestorNode( 'LABEL' ) ;
		}
		contextMenu.AddSeparator() ;
		contextMenu.AddItem( 'EditInput', FCKLang['DlgCMSFormsEditInput'], FCKConfig.PluginsPath + 'cms_forms/cms_forms.gif' ) ;
	} else if (tagName != 'TABLE' && FCKSelection.HasAncestorNode( 'TABLE' ) && FCKSelection.HasAncestorNode( 'FORM' )) {
		contextMenu.AddSeparator() ;
		contextMenu.AddItem( 'AddInput', FCKLang['DlgCMSFormsAddTitle'], FCKConfig.PluginsPath + 'cms_forms/cms_forms.gif' ) ;
	}
}

// ## 4. Register our context menu listener.
FCK.ContextMenu.RegisterListener( oEditInputContextMenuListener ) ;