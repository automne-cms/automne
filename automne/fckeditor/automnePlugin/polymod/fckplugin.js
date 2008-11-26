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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: fckplugin.js,v 1.1.1.1 2008/11/26 17:12:14 sebastien Exp $

/**
  * Javascript Polymod plugin for FCKeditor
  * Allow usage of all Polymod wysiwyg plugins
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

// Register the related commands.
FCKCommands.RegisterCommand( 'polymod'		, new FCKDialogCommand( FCKLang['DlgPolymodTitle']	, FCKLang['DlgPolymodTitle']		, FCKConfig.PluginsPath + 'polymod/polymod.php'	, 750, 550 ) ) ;

// Create the "automneLinks" toolbar button.
var oPolymod		= new FCKToolbarButton( 'polymod', FCKLang['DlgPolymodTitle'] ) ;
oPolymod.IconPath	= FCKConfig.PluginsPath + 'polymod/polymod.gif' ;

FCKToolbarItems.RegisterItem( 'polymod', oPolymod ) ;			// 'polymod' is the name used in the Toolbar config.


// ##### Define "Edit input" context menu entry.

// ## 1. Define the command to be executed when selecting the context menu item.
var oEditPolyCommand = new Object() ;
oEditPolyCommand.Name = 'polyEdit' ;

// This is the standard function used to execute the command (called when clicking in the context menu item).
oEditPolyCommand.Execute = function() {
	FCKDialog.OpenDialog( 'FCKDialog_poly_edit', FCKLang['DlgPolymodTitle'], FCKConfig.PluginsPath + 'polymod/polymod.php'	, 750, 550 ) ;
}

// This is the standard function used to retrieve the command state (it could be disabled for some reason).
oEditPolyCommand.GetState = function() {
	// Let's make it always enabled.
	return FCK_TRISTATE_OFF ;
}

// ## 2. Register our custom command.
FCKCommands.RegisterCommand( 'polyEdit', oEditPolyCommand ) ;

// ## 3. Define the context menu "listener".
var oEditPolyContextMenuListener = new Object() ;

// This is the standard function called right before sowing the context menu.
oEditPolyContextMenuListener.AddItems = function( contextMenu, tag, tagName ) {
	// Let's show our custom option only for form fields.
	if ( tagName == 'SPAN'  || FCKSelection.HasAncestorNode( 'SPAN' )) {
		// Go up to the span to test its properties
		var oSpan = FCKSelection.MoveToAncestorNode( 'SPAN' ) ;
		if (oSpan.className == 'polymod') {
			contextMenu.AddSeparator() ;
			contextMenu.AddItem( 'polyEdit', FCKLang['DlgPolymodEditTitle'], FCKConfig.PluginsPath + 'polymod/polymod.gif' ) ;
		}
	}
}

// ## 4. Register our context menu listener.
FCK.ContextMenu.RegisterListener( oEditPolyContextMenuListener ) ;

// Open the Placeholder dialog on double click.
oEditPolyCommand.OnDoubleClick = function( span ) {
	// Let's show our custom option only for form fields.
	if ( span.tagName == 'SPAN'  || FCKSelection.HasAncestorNode( 'SPAN' )) {
		// Go up to the span to test its properties
		var oSpan = FCKSelection.MoveToAncestorNode( 'SPAN' ) ;
		if (oSpan.className == 'polymod') {
			FCKCommands.GetCommand( 'polyEdit' ).Execute() ;
		}
	}
}
FCK.RegisterDoubleClickHandler( oEditPolyCommand.OnDoubleClick, 'SPAN' ) ;