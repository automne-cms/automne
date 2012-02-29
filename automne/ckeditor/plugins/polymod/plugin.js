
/**
  * Automne Polymod plugin for CKEditor
  *
  * @package CMS
  * @subpackage CKEditor
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author CKSource - Frederico Knabben.
  */

CKEDITOR.plugins.add( 'polymod',
{
	
	lang : [ 'en', 'fr' ],
	init : function( editor )
	{
		// Add the link and unlink buttons.
		editor.addCommand( 'polymod', new CKEDITOR.dialogCommand( 'polymod' ) );
		editor.ui.addButton( 'polymod',
			{
				label : editor.lang.polymod.toolbar,
				command : 'polymod',
				icon : this.path + 'polymod.gif'
			} );
		CKEDITOR.dialog.add( 'polymod', this.path + 'dialogs/polymod.js' );
		//on doubleclick, edit link
		editor.on( 'doubleclick', function( evt )
			{
				var element = CKEDITOR.plugins.polymod.getSelectedPlugin( editor ) || evt.data.element;
				if ( !element.isReadOnly() )
				{
					if ( element.is( 'a' ) && element.getAttribute('href') && (element.getAttribute('href').indexOf('}}') != -1 || element.getAttribute('href').indexOf('%7D%7D') != -1))
					{
						evt.data.dialog = 'polymod';
						editor.getSelection().selectElement( element );
					}
				}
			});

		// If the "menu" plugin is loaded, register the menu items.
		if ( editor.addMenuItems )
		{
			editor.addMenuItems(
				{
					polymod : {
						label : editor.lang.polymod.menu,
						command : 'polymod',
						group : 'polymod',
						icon : this.path + 'polymod.gif',
						order : 1
					}
				});
		}

		// If the "contextmenu" plugin is loaded, register the listeners.
		if ( editor.contextMenu )
		{
			editor.contextMenu.addListener( function( element, selection )
				{
					if ( !element || element.isReadOnly() )
						return null;
					var menu = {};

					if ( element.getAttribute( 'href' ) && element.getAttribute( 'href' ).substr(0,2) == '{{') {
						menu = { polymod : CKEDITOR.TRISTATE_ON };
					}
					return menu;
				});
		}
	},
	requires : [ 'fakeobjects', 'iframedialog' ]
} );

CKEDITOR.plugins.polymod =
{
	getSelectedPlugin : function( editor )
	{
		try
		{
			var selection = editor.getSelection();
			if ( selection.getType() == CKEDITOR.SELECTION_ELEMENT )
			{
				var selectedElement = selection.getSelectedElement();
				if ( selectedElement.is( 'a' ) && (selectedElement.getAttribute('href').indexOf('}}') != -1 || selectedElement.getAttribute('href').indexOf('%7D%7D') != -1))
					return selectedElement;
			}

			var range = selection.getRanges( true )[ 0 ];
			range.shrink( CKEDITOR.SHRINK_TEXT );
			var root = range.getCommonAncestor();
			return root.getAscendant( 'a', true );
		}
		catch( e ) { return null; }
	},
};
CKEDITOR.tools.extend( CKEDITOR.config,
{
	linkShowAdvancedTab : true,
	linkShowTargetTab : true
} );