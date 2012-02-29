
/**
  * Automne Links plugin for CKEditor
  *
  * @package CMS
  * @subpackage CKEditor
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author CKSource - Frederico Knabben.
  */

CKEDITOR.plugins.add( 'automneLinks',
{
	
	lang : [ 'en', 'fr' ],
	init : function( editor )
	{
		// Add the link and unlink buttons.
		editor.addCommand( 'automneLinks', new CKEDITOR.dialogCommand( 'automneLinks' ) );
		editor.ui.addButton( 'automneLinks',
			{
				label : editor.lang.automneLinks.toolbar,
				command : 'automneLinks',
				icon : this.path + 'automneLinks.gif'
			} );
		CKEDITOR.dialog.add( 'automneLinks', this.path + 'dialogs/automneLinks.js' );
		//on doubleclick, edit link
		editor.on( 'doubleclick', function( evt )
			{
				var element = CKEDITOR.plugins.automneLinks.getSelectedLink( editor ) || evt.data.element;
				if ( !element.isReadOnly() )
				{
					if ( element.is( 'a' ) && element.getAttribute('href') && (element.getAttribute('href').indexOf('}}') != -1 || element.getAttribute('href').indexOf('%7D%7D') != -1))
					{
						evt.data.dialog = 'automneLinks';
						editor.getSelection().selectElement( element );
					}
				}
			});

		// If the "menu" plugin is loaded, register the menu items.
		if ( editor.addMenuItems )
		{
			editor.addMenuItems(
				{
					automneLinks : {
						label : editor.lang.automneLinks.menu,
						command : 'automneLinks',
						group : 'automneLinks',
						icon : this.path + 'automneLinks.gif',
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
						menu = { automneLinks : CKEDITOR.TRISTATE_ON };
					}
					return menu;
				});
		}
	},
	requires : [ 'fakeobjects', 'iframedialog' ]
} );

CKEDITOR.plugins.automneLinks =
{
	/**
	 *  Get the surrounding link element of current selection.
	 * @param editor
	 * @example CKEDITOR.plugins.link.getSelectedLink( editor );
	 * @since 3.2.1
	 * The following selection will all return the link element.
	 *	 <pre>
	 *  <a href="#">li^nk</a>
	 *  <a href="#">[link]</a>
	 *  text[<a href="#">link]</a>
	 *  <a href="#">li[nk</a>]
	 *  [<b><a href="#">li]nk</a></b>]
	 *  [<a href="#"><b>li]nk</b></a>
	 * </pre>
	 */
	getSelectedLink : function( editor )
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