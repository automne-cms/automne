/**
  * Automne Javascript file
  *
  * Automne.blockText Extension Class for Automne.block
  * Add specific controls for text block
  * @class Automne.blockText
  * @extends Automne.block
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: block-text.js,v 1.9 2010/01/18 08:46:36 sebastien Exp $
  */
Automne.blockText = Ext.extend(Automne.block, {
	blockClass:	'CMS_block_text',
	stylesheet:	false,
	FCKTimer:	false,
	FCKEditor:	false,
	edit: function() {
		//create contener with all block edition elements
		var bd = Ext.get(this.document.body);
		var box = this.getBox();
		//set min size
		if (box.width < 170) {
			box.width = 170;
		}
		if (box.height < 100) {
			box.height = 100;
		}
		//check x-y position to avoid editor to exit frame
		var docbox = bd.getBox();
		if(box.x + box.width > docbox.width) {
			box.x = docbox.width - box.width - 5;
		}
		var cont = bd.createChild({cls: 'atm-edit-content atm-edit-text-content'});
		var tb = bd.createChild({id:'fcktoolbar'});
		cont.setVisibilityMode(Ext.Element.DISPLAY);
		cont.setStyle('position', 'absolute');
		cont.setDisplayed('block');
		cont.setBounds(box.x-1, box.y-1, box.width + 5, box.height + 26);
		var dh = Ext.DomHelper;
		var textCont = dh.append(cont, {tag:'div'}, true);
		textCont.setBounds(box.x, box.y, box.width, box.height);
		var ctrlCont = dh.append(cont, {tag:'div'}, true);
		var validateCtrl = dh.append(ctrlCont, {tag:'span', cls:'atm-block-control atm-block-control-validate'}, true);
		validateCtrl.setX(box.x + box.width - 42);
		validateCtrl.addClassOnOver('atm-block-control-validate-on');
		validateCtrl.dom.title = validateCtrl.dom.alt = Automne.locales.blockValidate;
		var cancelCtrl = dh.append(ctrlCont, {tag:'span', cls:'atm-block-control atm-block-control-cancel'}, true);
		cancelCtrl.setX(box.x + box.width - 22);
		cancelCtrl.addClassOnOver('atm-block-control-cancel-on');
		cancelCtrl.dom.title = cancelCtrl.dom.alt = Automne.locales.cancel;
		cont.show();
		//add resize handler
		var resizer = new Ext.Resizable(cont, {
			width:		box.width + 5,
			height:		box.height + 26,
			minWidth:	175,
			minHeight:	126,
			pinned:		true
		});
		resizer.on("resize", function(el, width, height, e){
			textCont.setWidth(width - 5);
			textCont.setHeight(height - 26);
			ctrlCont.setWidth(width - 5);
			validateCtrl.setX(ctrlCont.getX() + ctrlCont.getWidth() - 42);
			validateCtrl.setY(ctrlCont.getY() + 2);
			cancelCtrl.setX(ctrlCont.getX() + ctrlCont.getWidth() - 22);
			cancelCtrl.setY(ctrlCont.getY() + 2);
		}, this);
		//if we do not have stylesheet for this block, create it
		if(!this.stylesheet) {
			var tagName = this.elements.first().dom.tagName.toLowerCase();
			//if the first block element is a div or a td, use it. Otherwise, use parent tag
			if (tagName == 'div' || tagName == 'td') {
				var sourceEl = this.elements.first();
			} else {
				var sourceEl = this.elements.first().parent();
			}
			try {
				var styleEl = dh.append(sourceEl, {tag:'div'}, true);
			} catch(e) {
				var styleEl = dh.append(sourceEl.parent(), {tag:'div'}, true);
			}
			styleEl.setVisibilityMode(Ext.Element.DISPLAY);
			styleEl.hide();
			var tagList = ['b', 'strong', 'i', 'em', {tag:'a', href:'/', html:'text'}, 'p', {tag:'ul', children:[{tag:'li'}]}, {tag:'ol', children:[{tag:'li'}]}, 'span', 'div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'img', 'small', 'abbr', 'acronym', 'blockquote', 'cite', 'code'];
			var elements = new Ext.CompositeElement([sourceEl]);
			for(var i = 0, tagLen = tagList.length; i < tagLen; i++) {
				if (typeof tagList[i] == 'string') {
					elements.add(dh.append(styleEl, {tag:tagList[i]}, true));
				} else {
					var el = dh.append(styleEl, tagList[i], true);
					elements.add(el);
					var els = el.select('*', true);
					els.each(function(el) {
						elements.add(el);
					});
				}
			}
			var stylesheet = '';
			elements.each(function(el, els, index) {
				var styles = el.getStyles(
					'font-size', 'color', 'font-family', 'font-weight', 'font-style',
					'padding-top', 'padding-left', 'padding-right', 'padding-bottom', 
					'margin-top', 'margin-left', 'margin-right', 'margin-bottom', 
					'background-color', 'background-image', 'background-position', 'background-repeat',
					'border-bottom-style', 'border-bottom-width', 'border-bottom-color', 
					'border-top-style', 'border-top-width', 'border-top-color', 
					'border-left-style', 'border-left-width', 'border-left-color', 
					'border-right-style', 'border-right-width', 'border-right-color', 
					'float', 'display',
					'text-align', 'text-decoration', 'vertical-align',
					'list-style', 'list-style-image', 'list-style-position', 'list-style-type'
				);
				if (!index) {
					stylesheet += 'body';
				} else {
					var tagLineage = '', parent = el;
					while (parent && parent.id != styleEl.id) {
						tagLineage = parent.dom.tagName.toLowerCase() +' '+ tagLineage;
						parent = parent.parent();
					}
					stylesheet += tagLineage;
				}
				stylesheet += '{\n';
				for (var styleName in styles) {
					if (styles[styleName]) {
						if (el.dom.tagName.toLowerCase() == 'a') {
							stylesheet += styleName+':'+styles[styleName]+' !important;\n'
						} else {
							stylesheet += styleName+':'+styles[styleName]+';\n'
						}
					}
				}
				stylesheet += '}\n';
			});
			//pr(stylesheet);
			//append some style for fckeditor
			stylesheet += '\n.ForceBaseFont {\n'+
			'	background-color:#FFFFFF;\n'+
			'}\n';
			this.stylesheet = stylesheet;
			styleEl.remove();
		}
		textCont.update(this.value.replace(/\{0\}/g, encodeURIComponent(this.stylesheet)));
		//set a timer on this function to wait until editor is fully loaded
		this.FCKTimer = new Ext.util.DelayedTask(function() {
			if (window.FCKeditorAPI && window.FCKeditorAPI.GetInstance) {
				this.FCKEditor = window.FCKeditorAPI.GetInstance('fck-' + this.row.rowTagID + '-' + this.id);
				if (!this.FCKEditor) {
					this.FCKTimer.delay(5);
					return;
				} else {
					//get all iframes and set them to position fixed
					var catchFrames = new Ext.util.DelayedTask(function() {
						var iframes = bd.select('iframe', true);
						var count = 0;
						iframes.each(function(iframe){
							try{
								if (iframe.id.indexOf('fck-' + this.row.rowTagID + '-' + this.id) == -1 && iframe.getStyle('position') == 'absolute') {
									if (count) { //skip first frame which is the mouse contextual menu
										iframe.setStyle('position', 'fixed');
									}
									count++;
								}
							} catch(e){}
						}, this);
					}, this);
					catchFrames.delay(1000);
				}
			} else {
				this.FCKTimer.delay(10);
				return;
			}
		}, this);
		this.FCKTimer.delay(10);
		//put click events on controls
		cancelCtrl.on('mousedown', this.stopEdition.createDelegate(this, [cancelCtrl, validateCtrl, ctrlCont, textCont, cont, tb]), this);
		validateCtrl.on('mousedown', this.validateEdition.createDelegate(this, [cancelCtrl, validateCtrl, ctrlCont, textCont, cont, tb]), this);
	},
	validateEdition: function(cancelCtrl, validateCtrl, ctrlCont, textCont, cont, tb) {
		//get new value from textarea
		if (this.FCKEditor) {
			this.value = this.FCKEditor.GetXHTML(true);
			//send all datas to server to update block content and get new row HTML code
			Automne.server.call('page-content-controler.php', this.stopEditionAfterValidation, {
				action:			'update-block-text',
				cs:				this.row.clientspace.getId(),
				page:			this.row.clientspace.page,
				template:		this.row.template,
				rowType:		this.row.rowType,
				rowTag:			this.row.rowTagID,
				block:			this.getId(),
				blockClass:		this.blockClass,
				value:			this.value,
				stopParams:		[cancelCtrl, validateCtrl, ctrlCont, textCont, cont, tb]
			}, this);
		}
		
	},
	stopEditionAfterValidation: function(response, option) {
		//if user is disconnected, then with this check, we do not close the editor. 
		//So it can login and submit his text again without loose everything
		if (response.responseXML && response.responseXML.getElementsByTagName('content').length) {
			//stop block edition
			this.endModify();
			var elements = new Ext.CompositeElement(option.params.stopParams);
			elements.removeAllListeners();
			elements.remove();
			delete elements;
			//replace row content
			this.row.replaceContent(response, option);
		}
	},
	stopEdition: function(cancelCtrl, validateCtrl, ctrlCont, textCont, cont, tb) {
		this.endModify();
		var elements = new Ext.CompositeElement([cancelCtrl, validateCtrl, ctrlCont, textCont, cont, tb]);
		elements.removeAllListeners();
		elements.remove();
		delete elements;
	}
});