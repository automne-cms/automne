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
  * $Id: block-polymod.js,v 1.4 2009/06/10 10:11:17 sebastien Exp $
  */
Automne.blockPolymod = Ext.extend(Automne.block, {
	blockClass:	'CMS_block_polymod',
	win:		false,
	edit: 		function() {
		//create window with block edition elements
		this.win = new parent.Automne.Window({
			id:				'blockPolymodWindow',
			width:			750,
			height:			580,
			autoLoad:		{
				url:			'/automne/admin/modules/polymod/content-block.php',
				params:			{
					winId:			'blockPolymodWindow',
					cs:				this.row.clientspace.getId(),
					page:			this.row.clientspace.page,
					template:		this.row.template,
					rowType:		this.row.rowType,
					rowTag:			this.row.rowTagID,
					block:			this.getId(),
					blockClass:		this.blockClass,
					module:			this.value.module
				},
				nocache:		true,
				scope:			this
			}
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