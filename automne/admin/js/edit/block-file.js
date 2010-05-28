/**
  * Automne Javascript file
  *
  * Automne.blockFile Extension Class for Automne.block
  * Add specific controls for file block
  * @class Automne.blockFile
  * @extends Automne.block
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: block-file.js,v 1.2 2009/03/02 11:27:02 sebastien Exp $
  */
Automne.blockFile = Ext.extend(Automne.block, {
	blockClass:	'CMS_block_file',
	win:		false,
	edit: function() {
		//create window with block edition elements
		this.win = new parent.Automne.Window({
			id:				'blockFileWindow',
			width:			700,
			height:			190,
			autoLoad:		{
				url:		Automne.context.path + '/automne/admin/page-content-block-file.php',
				params:		{
					winId:			'blockFileWindow',
					cs:				this.row.clientspace.getId(),
					page:			this.row.clientspace.page,
					template:		this.row.template,
					rowType:		this.row.rowType,
					rowTag:			this.row.rowTagID,
					block:			this.getId(),
					blockClass:		this.blockClass,
					value:			this.value
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
			action:			'update-block-file',
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