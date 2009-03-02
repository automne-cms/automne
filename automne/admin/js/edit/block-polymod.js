/**
  * Automne Javascript file
  *
  * Automne.blockPolymod Extension Class for Automne.block
  * Add specific controls for polymod block
  * @class Automne.blockPolymod
  * @extends Automne.block
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: block-polymod.js,v 1.3 2009/03/02 11:27:02 sebastien Exp $
  */
Automne.blockPolymod = Ext.extend(Automne.block, {
	blockClass:	'CMS_block_polymod',
	win:		false,
	edit: 		function() {
		//create window with block edition elements
		this.win = new parent.Automne.frameWindow({
			id:				'blockPolymodWindow',
			width:			800,
			height:			600,
			frameURL:		'/automne/admin/modules/polymod/content_block.php?' + Ext.urlEncode({
				winId:			'blockPolymodWindow',
				cs:				this.row.clientspace.getId(),
				page:			this.row.clientspace.page,
				template:		this.row.template,
				rowType:		this.row.rowType,
				rowTag:			this.row.rowTagID,
				block:			this.getId(),
				blockClass:		this.blockClass,
				module:			this.value.module
			}),
			allowFrameNav:	true
		});
		this.win.show();
		this.win.on('close', this.updateRow, this);
	},
	admin: function() {
		//create module admin window
		this.win = new parent.Automne.Window({
			id:				'module'+ this.value.module +'Window',
			width:			800,
			height:			600,
			autoLoad:		{
				url:		'/automne/admin/module.php',
				params:		{
					winId:		'module'+ this.value.module +'Window',
					module:		this.value.module
				},
				nocache:	true,
				scope:		this
			}
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