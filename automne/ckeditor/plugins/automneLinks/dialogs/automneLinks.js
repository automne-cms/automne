
/**
  * Automne Links plugin for CKEditor
  *
  * @package CMS
  * @subpackage CKEditor
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author CKSource - Frederico Knabben.
  */

CKEDITOR.dialog.add( 'automneLinks', function( editor )
{
	var plugin = CKEDITOR.plugins.automneLinks;
	// Handles the event when the "Target" selection box is changed.
	var targetChanged = function()
	{
		var dialog = this.getDialog(),
			popupFeatures = dialog.getContentElement( 'target', 'popupFeatures' ),
			targetName = dialog.getContentElement( 'target', 'linkTargetName' ),
			value = this.getValue();

		if ( !popupFeatures || !targetName )
			return;

		popupFeatures = popupFeatures.getElement();
		popupFeatures.hide();
		targetName.setValue( '' );

		switch ( value )
 		{
			case 'frame' :
				targetName.setLabel( editor.lang.automneLinks.targetFrameName );
				targetName.getElement().show();
				break;
			case 'popup' :
				popupFeatures.show();
				targetName.setLabel( editor.lang.automneLinks.targetPopupName );
				targetName.getElement().show();
				break;
			default :
				targetName.setValue( value );
				targetName.getElement().hide();
				break;
 		}
	};

	// Loads the parameters in a selected link to the link dialog fields.
	var selectableTargets = /^(_(?:self|top|parent|blank))$/;

	var popupRegex =
		/\s*window.open\(\s*this\.href\s*,\s*(?:'([^']*)'|null)\s*,\s*'([^']*)'\s*\)\s*;\s*return\s*false;*\s*/;
	var popupFeaturesRegex = /(?:^|,)([^=]+)=(\d+|yes|no)/gi;

	var parseLink = function( editor, element )
	{
		var href = ( element  && ( element.data( 'cke-saved-href' ) || element.getAttribute( 'href' ) ) ) || '',
		 	retval = {};
		
		retval.type = 'url';
		if (href && href.substr(0,2) == '{{') {
			retval.pageId = href.substr(0,(href.length -2)).substr(2);
		} else {
			retval.pageId = 1;
		}
		
		if (element && element.getAttribute( 'noselection' )) {
			if (element.getAttribute( 'noselection' ) == 'true') {
				retval.noselection = true;
			} else {
				retval.noselection = false;
			}
		} else {
			retval.noselection = true;
		}

		// Load target and popup settings.
		if ( element )
		{
			var target = element.getAttribute( 'target' );
			retval.target = {};
			retval.adv = {};

			// IE BUG: target attribute is an empty string instead of null in IE if it's not set.
			if ( !target )
			{
				var onclick = element.data( 'cke-pa-onclick' ) || element.getAttribute( 'onclick' ),
					onclickMatch = onclick && onclick.match( popupRegex );
				if ( onclickMatch )
				{
					retval.target.type = 'popup';
					retval.target.name = onclickMatch[1];

					var featureMatch;
					while ( ( featureMatch = popupFeaturesRegex.exec( onclickMatch[2] ) ) )
					{
						// Some values should remain numbers (#7300)
						if ( ( featureMatch[2] == 'yes' || featureMatch[2] == '1' ) && !( featureMatch[1] in { height:1, width:1, top:1, left:1 } ) )
							retval.target[ featureMatch[1] ] = true;
						else if ( isFinite( featureMatch[2] ) )
							retval.target[ featureMatch[1] ] = featureMatch[2];
					}
				}
			}
			else
			{
				var targetMatch = target.match( selectableTargets );
				if ( targetMatch )
					retval.target.type = retval.target.name = target;
				else
				{
					retval.target.type = 'frame';
					retval.target.name = target;
				}
			}

			var me = this;
			var advAttr = function( inputName, attrName )
			{
				var value = element.getAttribute( attrName );
				if ( value !== null )
					retval.adv[ inputName ] = value || '';
			};
			advAttr( 'advId', 'id' );
			advAttr( 'advLangDir', 'dir' );
			advAttr( 'advAccessKey', 'accessKey' );

			retval.adv.advName =
				element.data( 'cke-saved-name' )
				|| element.getAttribute( 'name' )
				|| '';
			advAttr( 'advLangCode', 'lang' );
			advAttr( 'advTabIndex', 'tabindex' );
			advAttr( 'advTitle', 'title' );
			advAttr( 'advContentType', 'type' );
			CKEDITOR.plugins.automneLinks.synAnchorSelector ?
				retval.adv.advCSSClasses = getLinkClass( element )
				: advAttr( 'advCSSClasses', 'class' );
			advAttr( 'advCharset', 'charset' );
			advAttr( 'advStyles', 'style' );
			advAttr( 'advRel', 'rel' );
		}

		
		// Record down the selected element in the dialog.
		this._.selectedElement = element;
		return retval;
	};

	var setupParams = function( page, data )
	{
		if ( data[page] )
			this.setValue( data[page][this.id] || '' );
	};

	var setupPopupParams = function( data )
	{
		return setupParams.call( this, 'target', data );
	};

	var setupAdvParams = function( data )
	{
		return setupParams.call( this, 'adv', data );
	};

	var commitParams = function( page, data )
	{
		if ( !data[page] )
			data[page] = {};

		data[page][this.id] = this.getValue() || '';
	};

	var commitPopupParams = function( data )
	{
		return commitParams.call( this, 'target', data );
	};

	var commitAdvParams = function( data )
	{
		return commitParams.call( this, 'adv', data );
	};

	function unescapeSingleQuote( str )
	{
		return str.replace( /\\'/g, '\'' );
	}

	function escapeSingleQuote( str )
	{
		return str.replace( /'/g, '\\$&' );
	}

	function getLinkClass( ele )
	{
		var className = ele.getAttribute( 'class' );
		return className ? className.replace( /\s*(?:cke_anchor_empty|cke_anchor)(?:\s*$)?/g, '' ) : '';
	}

	var commonLang = editor.lang.common,
		linkLang = editor.lang.automneLinks;

	return {
		title : linkLang.title,
		resizable: CKEDITOR.DIALOG_RESIZE_NONE,
		minWidth : 550,
		minHeight : 400,
		contents : [
			{
				id : 'info',
				label : linkLang.info,
				title : linkLang.info,
				elements :
				[
					
					{
						type : 'vbox',
						id : 'urlOptions',
						children :
						[
							{
								type : 'hbox',
								widths : [ '30%', '70%' ],
								children :
								[
									{
										type : 'text',
										id : 'pageId',
										label : linkLang.pageIdText,
										required: true,
										setup : function( data )
										{
											if ( data.pageId )
												this.setValue( data.pageId );
										},
										commit : function( data )
										{
											data.pageId = this.getValue();
										}
									},
									{
										type : 'checkbox',
										id : 'keeplink',
										label : linkLang.keeplink,
										setup : function (data) {
											if ( data.noselection )
												this.setValue(true);
										},
										commit : function (data) {
											data.noselection = this.getValue() ? true : false;
										}
									},
									
								]
							}
						]
					},
					{
						type : 'iframe',
						src : editor.plugins.automneLinks.path + 'dialogs/automneLinks.php',
						width : 550, 
						height : 400
					}
				]
			},
			{
				id : 'target',
				label : linkLang.target,
				title : linkLang.target,
				elements :
				[
					{
						type : 'hbox',
						widths : [ '50%', '50%' ],
						children :
						[
							{
								type : 'select',
								id : 'linkTargetType',
								label : commonLang.target,
								'default' : 'notSet',
								style : 'width : 100%;',
								'items' :
								[
									[ commonLang.notSet, 'notSet' ],
									[ linkLang.targetFrame, 'frame' ],
									[ linkLang.targetPopup, 'popup' ],
									[ commonLang.targetNew, '_blank' ],
									[ commonLang.targetTop, '_top' ],
									[ commonLang.targetSelf, '_self' ],
									[ commonLang.targetParent, '_parent' ]
								],
								onChange : targetChanged,
								setup : function( data )
								{
									if ( data.target )
										this.setValue( data.target.type || 'notSet' );
									targetChanged.call( this );
								},
								commit : function( data )
								{
									if ( !data.target )
										data.target = {};

									data.target.type = this.getValue();
								}
							},
							{
								type : 'text',
								id : 'linkTargetName',
								label : linkLang.targetFrameName,
								'default' : '',
								setup : function( data )
								{
									if ( data.target )
										this.setValue( data.target.name );
								},
								commit : function( data )
								{
									if ( !data.target )
										data.target = {};

									data.target.name = this.getValue().replace(/\W/gi, '');
								}
							}
						]
					},
					{
						type : 'vbox',
						width : '100%',
						align : 'center',
						padding : 2,
						id : 'popupFeatures',
						children :
						[
							{
								type : 'fieldset',
								label : linkLang.popupFeatures,
								children :
								[
									{
										type : 'hbox',
										children :
										[
											{
												type : 'checkbox',
												id : 'resizable',
												label : linkLang.popupResizable,
												setup : setupPopupParams,
												commit : commitPopupParams
											},
											{
												type : 'checkbox',
												id : 'status',
												label : linkLang.popupStatusBar,
												setup : setupPopupParams,
												commit : commitPopupParams

											}
										]
									},
									{
										type : 'hbox',
										children :
										[
											{
												type : 'checkbox',
												id : 'location',
												label : linkLang.popupLocationBar,
												setup : setupPopupParams,
												commit : commitPopupParams

											},
											{
												type : 'checkbox',
												id : 'toolbar',
												label : linkLang.popupToolbar,
												setup : setupPopupParams,
												commit : commitPopupParams

											}
										]
									},
									{
										type : 'hbox',
										children :
										[
											{
												type : 'checkbox',
												id : 'menubar',
												label : linkLang.popupMenuBar,
												setup : setupPopupParams,
												commit : commitPopupParams

											},
											{
												type : 'checkbox',
												id : 'fullscreen',
												label : linkLang.popupFullScreen,
												setup : setupPopupParams,
												commit : commitPopupParams

											}
										]
									},
									{
										type : 'hbox',
										children :
										[
											{
												type : 'checkbox',
												id : 'scrollbars',
												label : linkLang.popupScrollBars,
												setup : setupPopupParams,
												commit : commitPopupParams

											},
											{
												type : 'checkbox',
												id : 'dependent',
												label : linkLang.popupDependent,
												setup : setupPopupParams,
												commit : commitPopupParams

											}
										]
									},
									{
										type : 'hbox',
										children :
										[
											{
												type :  'text',
												widths : [ '50%', '50%' ],
												labelLayout : 'horizontal',
												label : commonLang.width,
												id : 'width',
												setup : setupPopupParams,
												commit : commitPopupParams

											},
											{
												type :  'text',
												labelLayout : 'horizontal',
												widths : [ '50%', '50%' ],
												label : linkLang.popupLeft,
												id : 'left',
												setup : setupPopupParams,
												commit : commitPopupParams

											}
										]
									},
									{
										type : 'hbox',
										children :
										[
											{
												type :  'text',
												labelLayout : 'horizontal',
												widths : [ '50%', '50%' ],
												label : commonLang.height,
												id : 'height',
												setup : setupPopupParams,
												commit : commitPopupParams

											},
											{
												type :  'text',
												labelLayout : 'horizontal',
												label : linkLang.popupTop,
												widths : [ '50%', '50%' ],
												id : 'top',
												setup : setupPopupParams,
												commit : commitPopupParams

											}
										]
									}
								]
							}
						]
					}
				]
			},
			{
				id : 'upload',
				label : linkLang.upload,
				title : linkLang.upload,
				hidden : true,
				filebrowser : 'uploadButton',
				elements :
				[
					{
						type : 'file',
						id : 'upload',
						label : commonLang.upload,
						style: 'height:40px',
						size : 29
					},
					{
						type : 'fileButton',
						id : 'uploadButton',
						label : commonLang.uploadSubmit,
						filebrowser : 'info:url',
						'for' : [ 'upload', 'upload' ]
					}
				]
			},
			{
				id : 'advanced',
				label : linkLang.advanced,
				title : linkLang.advanced,
				elements :
				[
					{
						type : 'vbox',
						padding : 1,
						children :
						[
							{
								type : 'hbox',
								widths : [ '45%', '35%', '20%' ],
								children :
								[
									{
										type : 'text',
										id : 'advId',
										label : linkLang.id,
										setup : setupAdvParams,
										commit : commitAdvParams
									},
									{
										type : 'select',
										id : 'advLangDir',
										label : linkLang.langDir,
										'default' : '',
										style : 'width:110px',
										items :
										[
											[ commonLang.notSet, '' ],
											[ linkLang.langDirLTR, 'ltr' ],
											[ linkLang.langDirRTL, 'rtl' ]
										],
										setup : setupAdvParams,
										commit : commitAdvParams
									},
									{
										type : 'text',
										id : 'advAccessKey',
										width : '80px',
										label : linkLang.acccessKey,
										maxLength : 1,
										setup : setupAdvParams,
										commit : commitAdvParams

									}
								]
							},
							{
								type : 'hbox',
								widths : [ '45%', '35%', '20%' ],
								children :
								[
									{
										type : 'text',
										label : linkLang.name,
										id : 'advName',
										setup : setupAdvParams,
										commit : commitAdvParams

									},
									{
										type : 'text',
										label : linkLang.langCode,
										id : 'advLangCode',
										width : '110px',
										'default' : '',
										setup : setupAdvParams,
										commit : commitAdvParams

									},
									{
										type : 'text',
										label : linkLang.tabIndex,
										id : 'advTabIndex',
										width : '80px',
										maxLength : 5,
										setup : setupAdvParams,
										commit : commitAdvParams

									}
								]
							}
						]
					},
					{
						type : 'vbox',
						padding : 1,
						children :
						[
							{
								type : 'hbox',
								widths : [ '45%', '55%' ],
								children :
								[
									{
										type : 'text',
										label : linkLang.advisoryTitle,
										'default' : '',
										id : 'advTitle',
										setup : setupAdvParams,
										commit : commitAdvParams

									},
									{
										type : 'text',
										label : linkLang.advisoryContentType,
										'default' : '',
										id : 'advContentType',
										setup : setupAdvParams,
										commit : commitAdvParams

									}
								]
							},
							{
								type : 'hbox',
								widths : [ '45%', '55%' ],
								children :
								[
									{
										type : 'text',
										label : linkLang.cssClasses,
										'default' : '',
										id : 'advCSSClasses',
										setup : setupAdvParams,
										commit : commitAdvParams

									},
									{
										type : 'text',
										label : linkLang.charset,
										'default' : '',
										id : 'advCharset',
										setup : setupAdvParams,
										commit : commitAdvParams

									}
								]
							},
							{
								type : 'hbox',
								widths : [ '45%', '55%' ],
								children :
								[
									{
										type : 'text',
										label : linkLang.rel,
										'default' : '',
										id : 'advRel',
										setup : setupAdvParams,
										commit : commitAdvParams
									},
									{
										type : 'text',
										label : linkLang.styles,
										'default' : '',
										id : 'advStyles',
										validate : CKEDITOR.dialog.validate.inlineStyle( editor.lang.common.invalidInlineStyle ),
										setup : setupAdvParams,
										commit : commitAdvParams
									}
								]
							}
						]
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
			if ( ( element = plugin.getSelectedLink( editor ) ) && element.hasAttribute( 'href' ) )
				selection.selectElement( element );
			else
				element = null;

			this.setupContent( parseLink.apply( this, [ editor, element ] ) );
		},
		onOk : function()
		{
			var attributes = {},
				removeAttributes = [],
				data = {},
				me = this,
				editor = this.getParentEditor();

			this.commitContent( data );
			
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
			}
		},
		onLoad : function()
		{
			if ( !editor.config.linkShowAdvancedTab )
				this.hidePage( 'advanced' );		//Hide Advanded tab.

			if ( !editor.config.linkShowTargetTab )
				this.hidePage( 'target' );		//Hide Target tab.

		}
	};
});