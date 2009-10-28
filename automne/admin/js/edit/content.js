/**
  * Automne Javascript main edit JS file
  *
  * Provide all specific JS codes to manage Automne client viewport
  *
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: content.js,v 1.3 2009/10/28 16:26:28 sebastien Exp $
  */

//copy some parent vars
if (parent) {
	//Declare Automne namespace
	Ext.namespace('Automne');
	pr = parent.pr;
	Automne = parent.Automne;
	Automne.locales = parent.Automne.locales;
	Automne.message = parent.Automne.message;
	Ext.MessageBox = parent.Ext.MessageBox;
}
//////////////////////////
// PAGE CONTENT METHODS //
//////////////////////////
Automne.content = function(id){
	this.editId = id;
	//set validator status
	this.isValidator = atmIsValidator;
	//set validator status
	this.isValidable = atmIsValidable;
	//set preview status
	this.hasPreview = atmHasPreview;
	
	Automne.content.superclass.constructor.call(this);
	this.init();
};
Ext.extend(Automne.content, Ext.util.Observable, {
	cs: 			{}, 
	updateTimer:	false,
	updateCSMask:	false,
	rowMask:		false,
	rowOver:		false,
	isValidator:	false,
	isValidable:	false,
	hasPreview:		false,
	editId:			false,
	init: function() {
		if (parent.Ext.getCmp('editCancelAdd'+ this.editId)) {
			parent.Ext.getCmp('editCancelAdd'+ this.editId).hide();
			parent.Ext.getCmp('addRowCombo'+ this.editId).hide();
			parent.Ext.getCmp('addSelectedRow'+ this.editId).hide();
			parent.Ext.getCmp('editAddRow'+ this.editId).show();
			//these buttons must be shown only if context allow it
			parent.Ext.getCmp('editSaveDraft'+ this.editId).setVisible(this.isValidable);
			parent.Ext.getCmp('editValidateDraft'+ this.editId).setVisible(this.isValidator);
			parent.Ext.getCmp('editPrevizDraft'+ this.editId).setVisible(this.hasPreview);
			parent.Ext.get('selectedRow'+ this.editId).update('');
		}
		//allow row mask to be displayed
		this.startRowsMask();
	},
	edit: function(csDatas, rowsDatas, blocksDatas) {
		//instanciate all rows objects
		var rows = {};
		for (var rowId in rowsDatas) {
			rows[rowId] = new Automne.row(rowsDatas[rowId]);
		}
		//instanciate all blocks objects
		var blocks = {};
		for (var blockId in blocksDatas) {
			blocks[blockId] = eval('new '+blocksDatas[blockId].jsBlockClass+'(blocksDatas[blockId])');
			//add block to row
			if (rows['row-'+blocksDatas[blockId].row]) {
				rows['row-'+blocksDatas[blockId].row].addBlock(blocks[blockId]);
			}
		}
		//instanciate all clientspaces objects
		this.cs = {};
		for (var csId in csDatas) {
			this.cs[csId] = new Automne.cs(csDatas[csId]);
			//associate rows and CS
			var count = 0;
			for(var rowId in rows) {
				if (rows[rowId].getCsId() == csId) {
					this.cs[csId].addRow(rows[rowId]);
				}
			}
			//show CS
			this.cs[csId].show();
		}
		//then for each CS objects, set brothers clientspaces
		for (var csId in this.cs) {
			for (var csId2 in this.cs) {
				if (csId != csId2) {
					this.cs[csId].setBrother(this.cs[csId2]);
				}
			}
		}
		this.updateCSMask = true;
		this.rowMask = true;
		this.updateTimer = new Ext.util.DelayedTask(function() {
			this.updateCSMasks();
			this.updateTimer.delay(3000);
		}, this); 
		this.updateTimer.delay(3000);
		//add unload event on document to remove listeners
		Ext.EventManager.on(window, 'beforeunload', function(e) {
			pr('Clear edition frame objects for '+this.editId);
			//clear update timer interval
			this.updateTimer.cancel();
			//remove all listeners
			for (var csId in this.cs) {
				this.cs[csId].removeListeners();
				delete this.cs[csId];
			}
		}, this);
		Ext.getDoc().on('unload', function() {
			pr('Close '+ this.editId +' => Reload all edition frame objects');
			parent.Ext.ComponentMgr.all.each(function(cmp){
				if (cmp.xtype == "framePanel" && cmp.editable == true && this.editId != cmp.id +'Frame') {
					cmp.reload();
				}
			}, this);
		}, this);
	},
	getRowForEl: function(el) {
		for (var csId in this.cs) {
			for(var i = 0, rowsLen = this.cs[csId].rows.length; i < rowsLen; i++) {
				if (this.cs[csId].rows[i].hasElement(el)) {
					return this.cs[csId].rows[i];
				}
			}
		}
		return false;
	},
	getCS: function(csId) {
		return this.cs[csId];
	},
	updateCSMasks: function() {
		if (this.updateCSMask) {
			for (var csId in this.cs) {
				this.cs[csId].updateMask();
			}
		}
	},
	showZones: function(type) {
		type = type || 'drop';
		//stop showing rows mask
		this.stopRowsMask();
		for (var csId in this.cs) {
			this.cs[csId].showZones(type);
		}
	},
	hideZones: function(exception) {
		for (var csId in this.cs) {
			this.cs[csId].hideZones(exception);
		}
	},
	stopUpdate: function() {
		this.updateCSMask = false;
	},
	startUpdate: function() {
		this.updateCSMask = true;
		this.updateCSMasks();
	},
	startRowsMask: function() {
		this.rowMask = true;
	},
	stopRowsMask: function() {
		this.rowMask = false;
	},
	setRowOver: function(row, status) {
		if (status && this.rowOver !== false && this.rowOver.getId() != row.getId()) {
			if (status) {
				this.rowOver.mouseOut();
			} else {
				return;
			}
		}
		this.rowOver = row;
	},
	endEdition: function(source, el) {
		switch (source) {
			case 'link':
				Automne.message.popup({
					msg: 				Automne.locales.endEdition,
					buttons: 			Ext.MessageBox.YESNOCANCEL,
					animEl: 			el,
					closable: 			false,
					icon: 				Ext.MessageBox.QUESTION,
					scope:				this,
					fn: 				function (button) {
						if (button == 'cancel') {
							return;
						}
						//call server to get page infos using page url
						if (button == 'yes') {
							Automne.tabPanels.getPageInfos({
								pageUrl:		el.dom.href
							}, function(response, params) {
								pr('Submit page content '+ params.params.from +' to validation.');
								//submit content to validation
								Automne.server.call({
									url:				'page-controler.php',
									params: 			{
										currentPage:		params.params.from,
										action:				'submit_for_validation'
									}
								});
							}, {from: Automne.tabPanels.pageId});
						} else {
							Automne.tabPanels.getPageInfos({
								pageUrl:		el.dom.href
							});
						}
						pr('End edition from '+ source +' and unlock page '+ Automne.tabPanels.pageId);
						//unlock page
						Automne.server.call({
							url:				'resource-controler.php',
							params: 			{
								resource:		Automne.tabPanels.pageId,
								module:			'standard',
								action:			'unlock'
							},
							callBackScope:		this
						});
					}
				});
			break;
			case 'tab':
				pr('End edition from '+ source +' and unlock page '+ Automne.tabPanels.pageId);
				//unlock page
				Automne.server.call({
					url:				'resource-controler.php',
					params: 			{
						resource:		Automne.tabPanels.pageId,
						module:			'standard',
						action:			'unlock'
					},
					callBackScope:		this
				});
			break;
		}
		return true;
	}
});
Ext.override(Ext.dd.DragDrop, {
	handleMouseDown: function(e, oDD){
        //Handle DD problem on IE7
		//if (this.primaryButtonOnly && e.button != 0) {
        //	return;
        //}

        if (this.isLocked()) {
        	return;
        }

        this.DDM.refreshCache(this.groups);

        var pt = new Ext.lib.Point(Ext.lib.Event.getPageX(e), Ext.lib.Event.getPageY(e));
        if (!this.hasOuterHandles && !this.DDM.isOverTarget(pt, this) )  {
        } else {
            if (this.clickValidator(e)) {

                // set the initial element position
                this.setStartPosition();


                this.b4MouseDown(e);
                this.onMouseDown(e);

                this.DDM.handleMouseDown(e, this);

                this.DDM.stopEvent(e);
            } else {

				
            }
        }
    },
	clickValidator: function(e) {
        var target = e.getTarget() || e.browserEvent.srcElement; //Handle DD problem on IE7
        return ( this.isValidHandleChild(target) &&
                    (this.id == this.handleElId ||
                        this.DDM.handleWasClicked(target, this.id)) );
    }
});