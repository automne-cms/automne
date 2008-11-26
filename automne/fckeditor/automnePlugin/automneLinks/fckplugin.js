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
  * Create Automne internal links
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

// Register the related commands.
FCKCommands.RegisterCommand( 'automneLinks'		, new FCKDialogCommand( FCKLang['DlgAutomneLinksTitle']	, FCKLang['DlgAutomneLinksTitle']		, FCKConfig.PluginsPath + 'automneLinks/automneLink.php'	, 500, 500 ) ) ;

// Create the "automneLinks" toolbar button.
var oAutomneLinks		= new FCKToolbarButton( 'automneLinks', FCKLang['DlgAutomneLinksTitle'] ) ;
oAutomneLinks.IconPath	= FCKConfig.PluginsPath + 'automneLinks/automneLinks.gif' ;

FCKToolbarItems.RegisterItem( 'automneLinks', oAutomneLinks ) ;			// 'automneLinks' is the name used in the Toolbar config.


// ##### Define "Edit input" context menu entry.

// ## 1. Define the command to be executed when selecting the context menu item.
var oEditAtmLnkCommand = new Object() ;
oEditAtmLnkCommand.Name = 'atmLnkEdit' ;

// This is the standard function used to execute the command (called when clicking in the context menu item).
oEditAtmLnkCommand.Execute = function() {
	FCKDialog.OpenDialog( 'FCKDialog_atmlnk_edit', FCKLang['DlgAutomneLinksTitle'], FCKConfig.PluginsPath + 'automneLinks/automneLink.php'	, 500, 500 ) ;
}

// This is the standard function used to retrieve the command state (it could be disabled for some reason).
oEditAtmLnkCommand.GetState = function()
{
	// Let's make it always enabled.
	return FCK_TRISTATE_OFF ;
}

// ## 2. Register our custom command.
FCKCommands.RegisterCommand( 'atmLnkEdit', oEditAtmLnkCommand ) ;

// ## 3. Define the context menu "listener".
var oEditAtmLnkContextMenuListener = new Object() ;

// This is the standard function called right before sowing the context menu.
oEditAtmLnkContextMenuListener.AddItems = function( contextMenu, tag, tagName ) {
	// Let's show our custom option only for form fields.
	if ( tagName == 'A'  || FCKSelection.HasAncestorNode( 'A' )) {
		
		// Go up to the link to test its properties
		var oLink = FCKSelection.MoveToAncestorNode( 'A' ) ;
		if (oLink.href.indexOf('}}') != -1 || oLink.href.indexOf('%7D%7D') != -1) {
			contextMenu.AddSeparator() ;
			contextMenu.AddItem( 'atmLnkEdit', FCKLang['DlgAutomneEditLinksTitle'], FCKConfig.PluginsPath + 'automneLinks/automneLinks.gif' ) ;
		}
	}
}

// ## 4. Register our context menu listener.
FCK.ContextMenu.RegisterListener( oEditAtmLnkContextMenuListener ) ;

// Open the Placeholder dialog on double click.
oEditAtmLnkCommand.OnDoubleClick = function( tag ) {
	// Let's show our custom option only for form fields.
	if ( tag.tagName == 'A'  || FCKSelection.HasAncestorNode( 'A' )) {
		
		// Go up to the link to test its properties
		var oLink = FCKSelection.MoveToAncestorNode( 'A' ) ;
		if (oLink.href.indexOf('}}') != -1 || oLink.href.indexOf('%7D%7D') != -1) {
			FCKCommands.GetCommand( 'atmLnkEdit' ).Execute() ;
		}
	}
}
FCK.RegisterDoubleClickHandler( oEditAtmLnkCommand.OnDoubleClick, 'A' ) ;