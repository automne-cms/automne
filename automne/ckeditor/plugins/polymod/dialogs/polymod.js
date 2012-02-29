
/**
  * Automne Polymod plugin for CKEditor
  *
  * @package CMS
  * @subpackage CKEditor
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author CKSource - Frederico Knabben.
  */

CKEDITOR.dialog.add( 'polymod', function( editor )
{
	var plugin = CKEDITOR.plugins.polymod;
	
	var parsePlugin = function( editor, element )
	{
		var retval = {};
		
		// Record down the selected element in the dialog.
		this._.selectedElement = element;
		return retval;
	};
	
	var commonLang = editor.lang.common,
		polymodLang = editor.lang.polymod;

	return {
		title : polymodLang.title,
		resizable: CKEDITOR.DIALOG_RESIZE_NONE,
		minWidth : 750,
		minHeight : 550,
		contents : [
			{
				id : 'info',
				label : polymodLang.info,
				title : polymodLang.info,
				elements :
				[
					{
						type : 'iframe',
						src : editor.plugins.polymod.path + 'dialogs/polymod.php',
						width : 718, 
						height : 465
					},
					{
						type : 'text',
						id : 'pluginId',
						hidden: true,
						setup : function( data )
						{
							
						},
						commit : function( data )
						{
							
						}
					}
				]
			}
		],
		onShow : function()
		{
			var editor = this.getParentEditor(),
				selection = editor.getSelection(),
				element = null;

			// Fill in all the relevant fields if there's already one link selected.
			if ( ( element = plugin.getSelectedPlugin( editor ) ))
				selection.selectElement( element );
			else
				element = null;

			this.setupContent( parsePlugin.apply( this, [ editor, element ] ) );
		},
		onOk : function()
		{
			var attributes = {},
				removeAttributes = [],
				data = {},
				me = this,
				editor = this.getParentEditor();

			this.commitContent( data );
			/*
			// Compose the URL.
			var url = ( data.pageId && CKEDITOR.tools.trim( data.pageId ) ) ? '{{' + data.pageId + '}}' : '';
			if (!url) {
				return false;
			}
			attributes[ 'data-cke-saved-href' ] = url;
					
			// Popups and target.
			if ( data.target )
			{
				if ( data.target.type == 'popup' )
				{
					var onclickList = [ 'window.open(this.href, \'',
							data.target.name || '', '\', \'' ];
					var featureList = [ 'resizable', 'status', 'location', 'toolbar', 'menubar', 'fullscreen',
							'scrollbars', 'dependent' ];
					var featureLength = featureList.length;
					var addFeature = function( featureName )
					{
						if ( data.target[ featureName ] )
							featureList.push( featureName + '=' + data.target[ featureName ] );
					};

					for ( var i = 0 ; i < featureLength ; i++ )
						featureList[i] = featureList[i] + ( data.target[ featureList[i] ] ? '=yes' : '=no' ) ;
					addFeature( 'width' );
					addFeature( 'left' );
					addFeature( 'height' );
					addFeature( 'top' );

					onclickList.push( featureList.join( ',' ), '\'); return false;' );
					attributes[ 'data-cke-pa-onclick' ] = onclickList.join( '' );

					// Add the "target" attribute. (#5074)
					removeAttributes.push( 'target' );
				}
				else
				{
					if ( data.target.type != 'notSet' && data.target.name )
						attributes.target = data.target.name;
					else
						removeAttributes.push( 'target' );

					removeAttributes.push( 'data-cke-pa-onclick', 'onclick' );
				}
			}

			// Advanced attributes.
			if ( data.adv )
			{
				var advAttr = function( inputName, attrName )
				{
					var value = data.adv[ inputName ];
					if ( value )
						attributes[attrName] = value;
					else
						removeAttributes.push( attrName );
				};

				advAttr( 'advId', 'id' );
				advAttr( 'advLangDir', 'dir' );
				advAttr( 'advAccessKey', 'accessKey' );

				if ( data.adv[ 'advName' ] )
					attributes[ 'name' ] = attributes[ 'data-cke-saved-name' ] = data.adv[ 'advName' ];
				else
					removeAttributes = removeAttributes.concat( [ 'data-cke-saved-name', 'name' ] );

				advAttr( 'advLangCode', 'lang' );
				advAttr( 'advTabIndex', 'tabindex' );
				advAttr( 'advTitle', 'title' );
				advAttr( 'advContentType', 'type' );
				advAttr( 'advCSSClasses', 'class' );
				advAttr( 'advCharset', 'charset' );
				advAttr( 'advStyles', 'style' );
				advAttr( 'advRel', 'rel' );
			}
			
			if (data.noselection) {
				attributes['noselection'] = 'true';
			} else {
				attributes['noselection'] = 'false';
			}

			// Browser need the "href" fro copy/paste link to work. (#6641)
			attributes.href = attributes[ 'data-cke-saved-href' ];

			if ( !this._.selectedElement )
			{
				// Create element if current selection is collapsed.
				var selection = editor.getSelection(),
					ranges = selection.getRanges( true );
				if ( ranges.length == 1 && ranges[0].collapsed )
				{
					var text = new CKEDITOR.dom.text( attributes[ 'data-cke-saved-href' ], editor.document );
					ranges[0].insertNode( text );
					ranges[0].selectNodeContents( text );
					selection.selectRanges( ranges );
				}

				// Apply style.
				var style = new CKEDITOR.style( { element : 'a', attributes : attributes } );
				style.type = CKEDITOR.STYLE_INLINE;		// need to override... dunno why.
				style.apply( editor.document );
			}
			else
			{
				// We're only editing an existing link, so just overwrite the attributes.
				var element = this._.selectedElement,
					href = element.data( 'cke-saved-href' ),
					textView = element.getHtml();

				element.setAttributes( attributes );
				element.removeAttributes( removeAttributes );

				if ( data.adv && data.adv.advName && CKEDITOR.plugins.automneLinks.synAnchorSelector )
					element.addClass( element.getChildCount() ? 'cke_anchor' : 'cke_anchor_empty' );

				// Update text view when user changes protocol (#4612).
				if ( href == textView || data.type == 'email' && textView.indexOf( '@' ) != -1 )
				{
					// Short mailto link text view (#5736).
					element.setHtml( attributes[ 'data-cke-saved-href' ] );
				}

				delete this._.selectedElement;
			}*/
		},
		onLoad : function()
		{
			/*if ( !editor.config.linkShowAdvancedTab )
				this.hidePage( 'advanced' );		//Hide Advanded tab.

			if ( !editor.config.linkShowTargetTab )
				this.hidePage( 'target' );		//Hide Target tab.
			*/
		}
	};
});