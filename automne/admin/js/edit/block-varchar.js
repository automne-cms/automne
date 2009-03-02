/**
  * Automne Javascript file
  *
  * Automne.blockVarchar Extension Class for Automne.block
  * Add specific controls for varchar block
  * @class Automne.blockVarchar
  * @extends Automne.block
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: block-varchar.js,v 1.2 2009/03/02 11:27:02 sebastien Exp $
  */
Automne.blockVarchar = Ext.extend(Automne.block, {
	blockClass:	'CMS_block_varchar',
	edit: function() {
		//create contener with all block edition elements
		var bd = Ext.get(this.document.body);
		var box = this.getBox();
		var cont = bd.createChild({cls: 'atm-edit-content'});
		cont.setVisibilityMode(Ext.Element.DISPLAY);
		cont.setStyle('position', 'absolute');
		cont.setDisplayed('block');
		cont.setBounds(box.x, box.y, box.width, box.height + 16);
		var dh = Ext.DomHelper;
		var textCont = dh.append(cont, {tag:'div'}, true);
		var ctrlCont = dh.append(cont, {tag:'div'}, true);
		var validateCtrl = dh.append(ctrlCont, {tag:'span', cls:'atm-block-control atm-block-control-validate'}, true);
		validateCtrl.setX(box.x + box.width - 40);
		validateCtrl.addClassOnOver('atm-block-control-validate-on');
		validateCtrl.dom.title = validateCtrl.dom.alt = Automne.locales.blockValidate;
		var cancelCtrl = dh.append(ctrlCont, {tag:'span', cls:'atm-block-control atm-block-control-cancel'}, true);
		cancelCtrl.setX(box.x + box.width - 20);
		cancelCtrl.addClassOnOver('atm-block-control-cancel-on');
		cancelCtrl.dom.title = cancelCtrl.dom.alt = Automne.locales.cancel;
		cont.show();
		//create textarea
		var textarea = new Ext.form.TextArea({
			renderTo:			textCont,
			name:				'blocktext',
			width:				box.width,
			growMin:			box.height,
			maxLength:			255,
			grow:				true,
			preventScrollbars:	true,
			enableKeyEvents:	true
		});
		//this textarea should not allow ENTER key and must not allow more than 255 enoded caracters
		textarea.on("keypress", function(el, e){
			var k = e.getKey();
			if(k == e.ENTER) {
				e.stopEvent();
			}
			if(!Ext.isIE && (e.isNavKeyPress() || k == e.BACKSPACE || (k == e.DELETE && e.button == -1))){
				return;
			}
			var c = e.getCharCode(), cc = String.fromCharCode(c);
			if(Ext.isIE && (e.isSpecialKey() || !cc)){
				return;
			}
			if(Ext.util.Format.htmlEncode(this.getRawValue()).length >= this.maxLength) {
				e.stopEvent();
			}
		}, textarea);
		var blockEl = this.elements.first();
		var textareaEl = textarea.getEl();
		textarea.setRawValue(Ext.util.Format.htmlDecode(this.value));
		textarea.show();
		//set style of textarea text according to original text element in page
		var blockStyle = blockEl.getStyles('font-size', 'color', 'font-family', 'font-weight', 'font-style', 'background-color', 'background-repeat', 'background-position', 'background-image', 'padding-right', 'padding-top', 'padding-left', 'padding-bottom');
		//overwrite transparent bg color to avoid visibility of block behind textarea
		if (blockStyle['background-color'] == 'transparent') {
			blockStyle['background-color'] = '#FFFFFF';
		}
		
		pr(blockStyle);
		textareaEl.setStyle(blockStyle);
		Ext.get(textarea.textSizeEl).setStyle(blockStyle);
		textarea.autoSize();
		//put click events on controls
		cancelCtrl.on('mousedown', this.stopEdition.createDelegate(this, [textareaEl, textarea, cancelCtrl, validateCtrl, ctrlCont, textCont, cont]), this);
		validateCtrl.on('mousedown', this.validateEdition.createDelegate(this, [textareaEl, textarea, cancelCtrl, validateCtrl, ctrlCont, textCont, cont]), this);
	},
	validateEdition: function(textareaEl, textarea, cancelCtrl, validateCtrl, ctrlCont, textCont, cont) {
		//get new value from textarea
		this.value = textarea.getValue();
		//send all datas to server to update block content and get new row HTML code
		Automne.server.call('page-content-controler.php', this.row.replaceContent, {
			action:			'update-block-varchar',
			cs:				this.row.clientspace.getId(),
			page:			this.row.clientspace.page,
			template:		this.row.template,
			rowType:		this.row.rowType,
			rowTag:			this.row.rowTagID,
			block:			this.getId(),
			blockClass:		this.blockClass,
			value:			this.value
		}, this.row);
		//stop block edition
		this.stopEdition(textareaEl, textarea, cancelCtrl, validateCtrl, ctrlCont, textCont, cont);
	},
	stopEdition: function(textareaEl, textarea, cancelCtrl, validateCtrl, ctrlCont, textCont, cont) {
		var elements = new Ext.CompositeElement([textareaEl, cancelCtrl, validateCtrl, ctrlCont, textCont, cont]);
		textarea.destroy();
		elements.removeAllListeners();
		elements.remove();
		delete elements;
		this.endModify();
	}
});