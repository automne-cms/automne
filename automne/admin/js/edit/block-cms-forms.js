/**
  * Automne.blockPolymod Extension Class for Automne.block
  * Add specific controls for polymod block
  * @class Automne.blockPolymod
  * @extends Automne.block
  */
Automne.blockCMS_Forms = Ext.extend(Automne.block, {
	blockClass:	'CMS_block_cms_forms',
	win:		false,
	edit: 		function() {
		//create window with block edition elements
		this.win = new parent.Automne.frameWindow({
			id:				'blockCMSFormsWindow',
			width:			800,
			height:			600,
			frameURL:		'/automne/admin/modules/cms_forms/content_block.php?' + Ext.urlEncode({
				winId:			'blockCMSFormsWindow',
				cs:				this.row.clientspace.getId(),
				page:			this.row.clientspace.page,
				template:		this.row.template,
				rowType:		this.row.rowType,
				rowTag:			this.row.rowTagID,
				block:			this.getId(),
				blockClass:		this.blockClass
			}),
			allowFrameNav:	true
		});
		this.win.show();
		this.win.on('close', this.updateRow, this);
	},
	admin: function() {
		//create module admin window
		this.win = new parent.Automne.frameWindow({
			id:				'moduleCMSFormsWindow',
			width:			800,
			height:			600,
			frameURL:		'/automne/admin/modules/cms_forms/index.php',
			allowFrameNav:	true
		});
		this.win.show();
		this.win.on('close', this.updateRow, this);
	},
	updateRow: function() {
		//send all datas to server to get new row HTML code
		Automne.server.call('page-content-controler.php', this.row.replaceContent, {
			action:			'update-row',
			cs:				this.row.clientspace.getId(),
			page:			this.row.clientspace.page,
			template:		this.row.template,
			rowType:		this.row.rowType,
			rowTag:			this.row.rowTagID,
			block:			this.getId(),
			blockClass:		this.blockClass
		}, this.row);
		//stop block edition
		this.stopEdition();
	}
});