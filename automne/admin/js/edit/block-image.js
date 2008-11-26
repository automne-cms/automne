/**
  * Automne.blockImage Extension Class for Automne.block
  * Add specific controls for image block
  * @class Automne.blockImage
  * @extends Automne.block
  */
Automne.blockImage = Ext.extend(Automne.block, {
	blockClass:	'CMS_block_image',
	win:		false,
	edit: function() {
		//create window with block edition elements
		this.win = new parent.Automne.Window({
			id:				'blockImageWindow',
			width:			700,
			height:			435,
			autoLoad:		{
				url:		'/automne/admin/page-content-block-image.php',
				params:		{
					winId:			'blockImageWindow',
					cs:				this.row.clientspace.getId(),
					page:			this.row.clientspace.page,
					template:		this.row.template,
					rowType:		this.row.rowType,
					rowTag:			this.row.rowTagID,
					block:			this.getId(),
					blockClass:		this.blockClass,
					minWidth:		this.value.minwidth,
					maxWidth:		this.value.maxwidth
				},
				nocache:	true,
				scope:		this
			}
		});
		this.win.show();
		this.win.on('close', this.stopEdition, this);
	},
	validateEdition: function(values) {
		//send all datas to server to update block content and get new row HTML code
		Automne.server.call('page-content-controler.php', this.row.replaceContent, Ext.apply(values, {
			action:			'update-block-image',
			cs:				this.row.clientspace.getId(),
			page:			this.row.clientspace.page,
			template:		this.row.template,
			rowType:		this.row.rowType,
			rowTag:			this.row.rowTagID,
			block:			this.getId(),
			blockClass:		this.blockClass
		}), this.row);
		//stop block edition
		this.win.close();
	}
});