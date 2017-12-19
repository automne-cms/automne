
/**
  * Automne Polymod plugin for CKEditor
  *
  * @package CMS
  * @subpackage CKEditor
  * @author S?astien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * @author CKSource - Frederico Knabben.
  */

(function()
{
	function polymodDialog( editor, isEdit )
	{

		var plugin = CKEDITOR.plugins.polymod;
		
		var commonLang = editor.lang.common,
			polymodLang = editor.lang.polymod.polymod;
	
		return {
			title : polymodLang.title,
			resizable: CKEDITOR.DIALOG_RESIZE_NONE,
			height : 381,
			contents : [
				{
					id : 'info',
					label : polymodLang.info,
					title : polymodLang.info,
					height : 381,
					elements :
					[
						{
							type : 'iframe',
							src : editor.plugins.polymod.path + 'dialogs/polymod.php',
							width : 718, 
							height : 365
						}, 
						{
							type : 'hbox',
							height : 1,
							children :
							[{
								type : 'text',
								id : 'pluginCode',
								style : 'height: 1px;',
								hidden: true,
								validate : CKEDITOR.dialog.validate.notEmpty( polymodLang.selectMissing ),
								commit : function( element )
								{
									// The plugin must be recreated.
									CKEDITOR.plugins.polymod.createPlugin( editor, element, this.getValue() );
								}
							}, {
								type : 'text',
								id : 'pluginSelection',
								style : 'height: 1px;',
								hidden: true,
								setup : function( element )
								{
									if (element){
										this.setValue( element.getText() );
									} else {
										this.setValue(editor.getSelection().getSelectedText());
									}
								}
							}, {
								type : 'text',
								id : 'pluginId',
								style : 'height: 1px;',
								hidden: true,
								setup : function( element )
								{
									if ( isEdit )
										this.setValue(element.getId());
								}
							}]
						}
					]
				}
			],
			onShow : function()
			{
				if ( isEdit ) {
					this._element = CKEDITOR.plugins.polymod.getSelectedPlugin( editor );
				}
				this.setupContent( this._element );
			},
			onOk : function()
			{
				this.commitContent( this._element );
				delete this._element;
			}
		};
	};

	CKEDITOR.dialog.add( 'createPlugin', function( editor )
		{
			return polymodDialog( editor );
		});
	CKEDITOR.dialog.add( 'editPlugin', function( editor )
		{
			return polymodDialog( editor, 1 );
		});
} )();