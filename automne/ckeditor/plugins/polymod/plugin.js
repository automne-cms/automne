
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
	requires : [ 'dialog', 'fakeobjects', 'iframedialog' ],
	lang : [ 'en', 'fr' ],
	init : function( editor )
	{
		var lang = editor.lang.polymod;

		editor.addCommand( 'createPlugin', new CKEDITOR.dialogCommand( 'createPlugin' ) );
		editor.addCommand( 'editPlugin', new CKEDITOR.dialogCommand( 'editPlugin' ) );

		editor.ui.addButton( 'polymod',
		{
			label : lang.toolbar,
			command :'createPlugin',
			icon : this.path + 'polymod.gif'
		});
		CKEDITOR.dialog.add( 'createPlugin', this.path + 'dialogs/polymod.js' );
		CKEDITOR.dialog.add( 'editPlugin', this.path + 'dialogs/polymod.js' );

		if ( editor.addMenuItems )
		{
			editor.addMenuGroup( 'polymod', 20 );
			editor.addMenuItems(
				{
					editPlugin :
					{
						label : lang.edit,
						command : 'editPlugin',
						group : 'polymod',
						order : 1,
						icon : this.path + 'polymod.gif'
					}
				} );

			if ( editor.contextMenu )
			{
				editor.contextMenu.addListener( function( element, selection )
					{
						if ( !element || !element.hasClass('polymod') )
							return null;
						
						return { editPlugin : CKEDITOR.TRISTATE_OFF };
					} );
			}
		}

		editor.on( 'doubleclick', function( evt )
			{
				if ( CKEDITOR.plugins.polymod.getSelectedPlugin( editor ) )
					evt.data.dialog = 'editPlugin';
			});

		editor.addCss(
			'.polymod' +
			'{' +
				'border-bottom:		1px dotted #008000;' +
				'padding:			1px 10px 1px 1px;' +
				'background:			url(../automne/ckeditor/plugins/polymod/polymod-mini.gif) no-repeat right top;' +
				( CKEDITOR.env.gecko ? 'cursor: default;' : '' ) +
			'}'
		);

		editor.on( 'contentDom', function()
			{
				editor.document.getBody().on( 'resizestart', function( evt )
					{
						if ( editor.getSelection().getSelectedElement().attributes[ 'class' ] 
								&& editor.getSelection().getSelectedElement().attributes[ 'class' ].indexOf ( 'polymod' ) != -1 )
							evt.data.preventDefault();
					});
			});

		
	}/*,
	afterInit : function( editor )
	{
		var dataProcessor = editor.dataProcessor,
			dataFilter = dataProcessor && dataProcessor.dataFilter,
			htmlFilter = dataProcessor && dataProcessor.htmlFilter;

		if ( dataFilter )
		{
			dataFilter.addRules(
			{
				elements :
				{
					'span' : function( element )
					{
						if ( element.attributes && element.attributes[ 'class' ] && element.attributes[ 'class' ].indexOf ( 'polymod' ) != -1 )
							element.attributes.contenteditable = "false";
							
					}
				}
			});
		}

		if ( htmlFilter )
		{
			htmlFilter.addRules(
			{
				elements :
				{
					'span' : function( element )
					{
						if ( element.attributes && element.attributes[ 'class' ] && element.attributes[ 'class' ].indexOf ( 'polymod' ) != -1 )
							delete element.attributes.contenteditable;
					}
				}
			});
		}
	}*/
});

CKEDITOR.plugins.polymod =
{
	createPlugin : function( editor, oldElement, text )
	{
		element = new CKEDITOR.dom.element( 'span', editor.document );
		element.setHtml( text );
		element = element.getChild(0);
		element.setAttributes({contentEditable : 'false'});
		
		if (!oldElement) {
			editor.insertElement( element );
		} else {
			element.replace(oldElement);
		}
		
		return null;
	},

	getSelectedPlugin : function( editor )
	{
		var range = editor.getSelection().getRanges()[ 0 ];
		range.shrink( CKEDITOR.SHRINK_TEXT );
		var node = range.startContainer;
		while( node && !( node.type == CKEDITOR.NODE_ELEMENT && node.hasClass('polymod') ))
			node = node.getParent();
		return node;
	}
};
