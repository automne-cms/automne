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
  */
Automne.blockText = Ext.extend(Automne.block, {
	blockClass:	'CMS_block_text',
	stylesheet:	false,
	CKEditor:	false,
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
		var tb = bd.createChild({id:'cktoolbar'});
		cont.setVisibilityMode(Ext.Element.DISPLAY);
		cont.setStyle('position', 'absolute');
		cont.setDisplayed('block');
		cont.setX(box.x);
		cont.setY(box.y);
		var dh = Ext.DomHelper;
		var ctrlCont = dh.append(cont, {tag:'div', cls:'atm-block-text-control'}, true);
		var validateCtrl = dh.append(ctrlCont, {tag:'span', cls:'atm-block-control atm-block-control-validate'}, true);
		validateCtrl.addClassOnOver('atm-block-control-validate-on');
		validateCtrl.dom.title = validateCtrl.dom.alt = Automne.locales.blockValidate;
		var cancelCtrl = dh.append(ctrlCont, {tag:'span', cls:'atm-block-control atm-block-control-cancel'}, true);
		cancelCtrl.addClassOnOver('atm-block-control-cancel-on');
		cancelCtrl.dom.title = cancelCtrl.dom.alt = Automne.locales.cancel;
		cont.show();
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
			var tagList = ['b', 'strong', 'i', 'em', {tag:'a', href:'/', html:'text'}, 'p', {tag:'ul', children:[{tag:'li'}]}, {tag:'ol', children:[{tag:'li'}]}, {tag:'div', children:[{tag:'p'}]}, 'span', 'div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'hr', 'img', 'small', 'abbr', 'acronym', 'blockquote', 'cite', 'code'];
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
			//append some style for ckeditor
			stylesheet += '\n.ForceBaseFont {\n'+
			'	background-color:#FFFFFF;\n'+
			'}\n';
			if (this.options.bgcolor) {
				stylesheet += '\n body {\n'+
				'	background-color:'+this.options.bgcolor+';\n'+
				'}\n';
			}
			this.stylesheet = stylesheet;
			styleEl.remove();
		} else {
			var stylesheet = this.stylesheet;
		}
		//set editor options
		var ckconf = {};
		ckconf.height = box.height;
		ckconf.width = box.width;
		ckconf.language = this.options.language;
		ckconf.scayt_sLang = this.options.language;
		ckconf.sharedSpaces = {top: 'cktoolbar'};
		if (this.options.styles) {
			ckconf.extraPlugins = 'stylesheetparser';
			ckconf.stylesSet = [];
			ckconf.contentsCss = Automne.context.path + this.options.styles;
		}
		if (this.options.atmToolbar) {
			ckconf.customConfig = Automne.context.path +'/automne/ckeditor/config.php?toolbar=' + this.options.atmToolbar;
		} else {
			ckconf.customConfig = Automne.context.path +'/automne/ckeditor/config.php?toolbar=Default';
		}
		//append stylesheet to editor (use events because addCss only works before editor exists)
		var loadStyles = function (e) {
			e.editor.addCss(stylesheet);
		}
		CKEDITOR.on( 'instanceCreated', loadStyles);
		CKEDITOR.on( 'instanceDestroyed', function (e) {
			CKEDITOR.removeListener('instanceCreated', loadStyles);
		});
		//create editor
		this.CKEditor = CKEDITOR.appendTo( cont.dom, ckconf, this._base64_decode(this.value) );
		
		//put click events on controls
		cancelCtrl.on('mousedown', this.stopEdition.createDelegate(this, [cancelCtrl, validateCtrl, ctrlCont, cont, tb]), this);
		validateCtrl.on('mousedown', this.validateEdition.createDelegate(this, [cancelCtrl, validateCtrl, ctrlCont, cont, tb]), this);
	},
	validateEdition: function(cancelCtrl, validateCtrl, ctrlCont, cont, tb) {
		//get new value from textarea
		if (this.CKEditor) {
			this.value = this.CKEditor.getData();
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
				stopParams:		[cancelCtrl, validateCtrl, ctrlCont, cont, tb]
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
			//remove editor
			if (this.CKEditor) {
				this.CKEditor.destroy();
				this.CKEditor = null;
			}
			//replace row content
			this.row.replaceContent(response, option);
		}
	},
	stopEdition: function(cancelCtrl, validateCtrl, ctrlCont, cont, tb) {
		this.endModify();
		var elements = new Ext.CompositeElement([cancelCtrl, validateCtrl, ctrlCont, cont, tb]);
		elements.removeAllListeners();
		elements.remove();
		delete elements;
		//remove editor
		if (this.CKEditor) {
			this.CKEditor.destroy();
			this.CKEditor = null;
		}
	},
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",
 	// private method for base64 decoding
	_base64_decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;
		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
		while (i < input.length) {
			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
			output = output + String.fromCharCode(chr1);
			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}
		}
		output = this._utf8_decode(output);
		return output;
	},
	// private method for UTF-8 decoding
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;
		while ( i < utftext.length ) {
			c = utftext.charCodeAt(i);
			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			} else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			} else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}
		}
		return string;
	}
});