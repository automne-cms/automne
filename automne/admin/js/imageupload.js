/**
  * Automne Javascript file
  *
  * Automne.ImageUploadField Extension Class for Automne.FileUploadField
  * Provide a field wich is dedicated to image upload
  * @class Automne.ImageUploadField
  * @extends Automne.FileUploadField
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: imageupload.js,v 1.4 2009/06/05 15:01:06 sebastien Exp $
  */
Automne.ImageUploadField = Ext.extend(Automne.FileUploadField,  {
	// private
	initComponent: function(){
		Automne.ImageUploadField.superclass.initComponent.call(this);
		//append max filesize limit to fieldLabel
		if (this.minWidth || this.maxWidth || this.minHeight || this.maxHeight) {
			this.fieldLabel += '<br /><small>';
			var al = Automne.locales;
			if (this.minWidth) {
				this.fieldLabel += al.min +' '+ this.minWidth +'px '+ al.width +'<br />';
			}
			if (this.maxWidth) {
				this.fieldLabel += al.max +' '+ this.maxWidth +'px '+ al.width +'<br />';
			}
			if (this.minHeight) {
				this.fieldLabel += al.min +' '+ this.minHeight +'px '+ al.height +'<br />';
			}
			if (this.maxHeight) {
				this.fieldLabel += al.max +' '+ this.maxHeight +'px '+ al.height +'<br />';
			}
			this.fieldLabel += '</small>';
		}
	},
	/**
	 * Validates a value according to the field's validation rules and marks the field as invalid
	 * if the validation fails
	 * @param {Mixed} value The value to validate
	 * @return {Boolean} True if the value is valid, else false
	 */
	validateValue : function(value){
		if(value.length < 1 || value === this.emptyText){ // if it's blank
			 if(this.allowBlank){
				 this.clearInvalid();
				 return true;
			 }else{
				 this.markInvalid(this.blankText);
				 return false;
			 }
		}
		if (value && this.minWidth || this.maxWidth || this.minHeight || this.maxHeight) {
			var al = Automne.locales;
			var w = this.preview.dom.naturalWidth;
			var h = this.preview.dom.naturalHeight;
			if (this.minWidth > w) {
				this.markInvalid(al.maxImageSize);
				return false;
			}
			if (this.maxWidth < w) {
				this.markInvalid(al.maxImageSize);
				return false;
			}
			if (this.minHeight > h) {
				this.markInvalid(al.maxImageSize);
				return false;
			}
			if (this.maxHeight < h) {
				this.markInvalid(al.maxImageSize);
				return false;
			}
		}
		//check image size
		return true;
	},
	// private
	onResize : function(w, h){
		Automne.ImageUploadField.superclass.onResize.call(this, w, h);
		this.wrap.setWidth(w);
		this.infoEl.setWidth(w);
		var w = w - this.button.getEl().getWidth() - this.buttonOffset;
		if (this.preview) {
			this.wrap.setHeight(this.preview.getHeight() + 34);
		} else {
			this.wrap.setHeight(55);
		}
		if (!this.progress) {
			//progress bar
			this.progress = new Ext.ProgressBar({
				text:			Automne.locales.init,
				hidden:			true,
				width:			w,
				style:			'position:absolute;'
			});
			this.progress.render(this.wrap);
		} else {
			this.progress.setWidth(w);
		}
		this.el.setWidth(w);
	},
	onRender : function(ct, position){
		Automne.ImageUploadField.superclass.onRender.call(this, ct, position);
		this.infoEl.addClass('x-form-fileinfos-img');
	},
	//display all current file infos
	loadFileInfos: function() {
		var al = Automne.locales;
		var html = '';
		if (this.fileinfos['filename'] && this.fileinfos['filepath']) {
			html = '<a href="'+ this.fileinfos['filepath']+ '/' +this.fileinfos['filename'] +'" target="_blank">'+ this.ellipsis(this.fileinfos['filename'], 51) +'</a>';
			if (this.fileinfos['filesize']) {
				html += ' ('+ this.fileinfos['filesize'] + al.byte +')';
			}
			this.setValue(this.fileinfos['filename'], this.fileinfos['filepath']);
		} else {
			this.setValue('');
		}
		
		this.infoEl.update(html);
		if (this.preview) {
			this.preview.remove();
		}
			
		if (html) {
			this.preview = this.infoEl.insertHtml('afterBegin','<img src="'+ this.fileinfos['filepath']+ '/' +this.fileinfos['filename'] +'?time='+ (new Date()).getTime() +'" ext:qtip="'+ al.clickOriginal +'" class="atm-help" width="50" />', true);
			this.preview.on({
				'load':{
					fn:function(e, el) {
						this.setNaturalSize(this.preview);
						var img = this.preview;
						if (img.dom.naturalWidth < 50) {
							img.dom.width = img.dom.naturalWidth;
						}
						if ((this.maxWidth && img.dom.naturalWidth > this.maxWidth) || img.dom.naturalWidth < this.minWidth || (this.maxHeight && img.dom.naturalHeight > this.maxHeight) || img.dom.naturalHeight < this.minHeight) {
							this.markInvalid(al.maxImageSize);
						} else {
							this.clearInvalid();
						}
						if ((el.clientHeight + 34) > 55) {
							this.wrap.setHeight(el.clientHeight + 34);
						}
					},
					scope:this
				},
				'mousedown':{
					fn:function(e, el) {
						if (!this.previewProxy) {
							this.createPreview(true);
						}
					},
					scope:this
				}
			});
			if (!this.editEl) {
				this.editEl = this.infoEl.insertHtml('beforeEnd','<span class="atm-block-control atm-block-control-modify" ext:qtip="'+al.updateImage+'">&nbsp;</span>', true);
				this.editEl.on('mousedown', this.editFile, this);
				this.editEl.addClassOnOver('atm-block-control-modify-on');
			} else {
				this.infoEl.appendChild(this.editEl);
			}
			if (!this.deleteEl) {
				this.deleteEl = this.infoEl.insertHtml('beforeEnd','<span class="atm-block-control atm-block-control-del" ext:qtip="'+al.removeImage+'">&nbsp;</span>', true);
				this.deleteEl.on('mousedown', this.deleteFile, this);
				this.deleteEl.addClassOnOver('atm-block-control-del-on');
			} else {
				this.infoEl.appendChild(this.deleteEl);
			}
		}
	},
	createPreview: function(autohide, callback) {
		var body = Ext.getBody();
		this.previewProxy = this.preview.createProxy({tag:'img', src:this.preview.dom.src, width:this.preview.dom.clientWidth, height:this.preview.dom.clientHeight}, body, true);
		this.setNaturalSize(this.previewProxy);
		this.previewProxy.setStyle({'z-index':15000});
		var bbox = body.getBox();
		var w = this.preview.dom.naturalWidth;
		var h = this.preview.dom.naturalHeight;
		if (w > bbox.width) {
			h = (h * bbox.width) / w;
			w = bbox.width;
		}
		if (h > bbox.height) {
			w = (w * bbox.height) / h;
			h = bbox.height;
		}
		var proxyBox = {
			x:		((bbox.width - w) / 2),
			y:		((bbox.height - h) / 2),
			width:	w,
			height:	h
		};
		if (callback) {
			var animate = {
				scope:		this,
				callback:	callback
			}
		} else {
			var animate = true;
		}
		//grow and center proxy
		this.previewProxy.setBox(proxyBox, true, animate);
		if (autohide) {
			this.mask = Ext.getBody().mask();
			this.mask.setStyle({'z-index': parseInt(this.previewProxy.getStyle('z-index')) - 1});
			this.previewProxy.addClass('atm-help');
			Ext.QuickTips.register({target:this.previewProxy, text:Automne.locales.clickToClose});
			this.previewProxy.on('mousedown', this.removePreview, this, {single:true});
		}
	},
	removePreview: function() {
		if (this.previewProxy) {
			if (this.cropHandle) {
				this.stopCrop();
			}
			if (this.mask) {
				this.mask.remove();
				this.mask = null;
			}
			this.previewProxy.setBox(this.preview.getBox(), true, {
				remove:		true,
				scope:		this,
				callback:	function() {
					if (this.previewProxy) {
						this.previewProxy.remove();
						this.previewProxy = null;
					}
				}
			});
		}
	},
	editFile: function() {
		if (!this.previewProxy) {
			this.createPreview(false, this.launchEdit);
		}
	},
	launchEdit: function() {
		if (this.previewProxy) {
			var width = this.preview.dom.naturalWidth;
			var height = this.preview.dom.naturalHeight;
			var startWidth = this.previewProxy.dom.clientWidth;
			var startHeight = this.previewProxy.dom.clientHeight;
			var startValue = parseInt(startWidth * 100 / width);
			var minWidth = this.minWidth;
			var maxWidth = this.maxWidth;
			var minHeight = this.minHeight;
			var maxHeight = this.maxHeight;
			
			var heightField, widthField, sizeSlider;
			var al = Automne.locales;
			
			this.editPanel = new Ext.Window({
				title: 		al.resize,
				closable: 	true,
				width: 		150,
				height: 	250,
				modal:		true,
				resizable:	false,
				plain: 		true,
				layout: 	'border',
				x:			50,
				y:			50,
				tools:		[{id:'help', qtip:{
					title: 			al.help,
					text: 			al.resizeHelp,
					dismissDelay:	0
				}}],
				items: [{
					region: 	'west',
					width: 		50,
					border:		false,
					items:		[{
						xtype:		'slider',
						id:			'sizeSlider',
						vertical: 	true,
						minValue: 	0,
						maxValue: 	100,
						value:		startValue,
						height:		180,
						style:		'margin:auto',
						listeners:	{
							'drag': function(slider) {
								var v = slider.getValue();
								var width = this.preview.dom.naturalWidth;
								var height = this.preview.dom.naturalHeight;
								this.maintainRatio = false;
								heightField.setValue(parseInt((v * height) / 100));
								widthField.setValue(parseInt((v * width) / 100));
								this.maintainRatio = true;
							},
							'changecomplete': function(slider, v) {
								var width = this.preview.dom.naturalWidth;
								var height = this.preview.dom.naturalHeight;
								this.maintainRatio = false;
								heightField.setValue(parseInt((v * height) / 100));
								widthField.setValue(parseInt((v * width) / 100));
								this.maintainRatio = true;
								this.adaptPreviewSize();
							},
							scope:this
						}
					}]
				}, {
					region: 	'center',
					width: 		100,
					border:		false,
					layout:		'form',
					labelAlign:	'top',
					defaults:	{
						xtype:			'numberfield',
						allowDecimals:	false,
						allowNegative:	false,
						allowBlank:		false
					},
					items:[{
						anchor:			'97%',
						fieldLabel:		al.width,
						name:			'widthField',
						id:				'widthField',
						value:			startWidth,
						minValue:		(minWidth) ? minWidth : 20,
						maxValue:		(maxWidth) ? maxWidth : width,
						listeners:{
							'valid':function(field) {
								if (heightField) {
									if (!this.cropHandle && this.maintainRatio !== false) {
										var width = this.preview.dom.naturalWidth;
										var height = this.preview.dom.naturalHeight;
										
										this.maintainRatio = false;
										heightField.setRawValue(parseInt((field.getValue() * height) / width));
										this.maintainRatio = true;
										sizeSlider.setValue(parseInt(field.getValue() * 100 / width));
										this.adaptPreviewSize();
									}
								}
							},
							'focus':function(){
								if (this.cropHandle) {
									this.stopCrop();
								}
							},
							scope:this
						}
					},{
						anchor:			'97%',
						fieldLabel:		al.height,
						name:			'heightField',
						id:				'heightField',
						value:			startHeight,
						minValue:		(minHeight) ? minHeight : 20,
						maxValue:		(maxHeight) ? maxHeight : height,
						listeners:{
							'valid':function(field) {
								if (widthField) {
									if (!this.cropHandle && this.maintainRatio !== false) {
										var width = this.preview.dom.naturalWidth;
										var height = this.preview.dom.naturalHeight;
										
										this.maintainRatio = false;
										widthField.setValue(parseInt((field.getValue() * width) / height));
										this.maintainRatio = true;
										sizeSlider.setValue(parseInt(field.getValue() * 100 / height));
										this.adaptPreviewSize();
									}
								}
							},
							'focus':function(){
								if (this.cropHandle) {
									this.stopCrop();
								}
							},
							scope:this
						}
					},{
						id:				'toggleCrop',
						xtype:			'button',
						text:			al.crop,
						style:			'margin:auto',
						enableToggle:	true,
						scope:			this,
						toggleHandler:	this.crop
					}]
				},{
					region: 	'south',
					height: 	30,
					border:		false,
					items:		[{
						xtype:		'button',
						text:		al.apply,
						style:		'margin:auto',
						scope:		this,
						handler:	this.applyEdition
					}]
				}]
			});
			this.editPanel.on('close', function() {
				this.removePreview();
			}, this);
			this.editPanel.on('show', function(win) {
				this.previewProxy.setStyle({'z-index': parseInt(this.editPanel.mask.getStyle('z-index')) + 1});
				heightField = Ext.getCmp('heightField');
				widthField = Ext.getCmp('widthField');
				sizeSlider = Ext.getCmp('sizeSlider');
			}, this);
			this.editPanel.show(this.editEl);
		}
	},
	adaptPreviewSize: function() {
		var h = Ext.getCmp('heightField').getValue();
		var w = Ext.getCmp('widthField').getValue();
		var bbox = Ext.getBody().getBox();
		var proxyBox = {
			x:		((bbox.width - w) / 2),
			y:		((bbox.height - h) / 2),
			width:	w,
			height:	h
		};
		if (this.cropHandle) {
			this.stopCrop();
		}
		//grow and center proxy
		this.previewProxy.setBox(proxyBox, true, true);
	},
	crop: function(button, state){
		if (!state) {
			this.stopCrop();
			return;
		}
		crop = this.previewProxy.createProxy({tag:'div', id:'imagecrop'}, Ext.getBody(), true);
		crop.setStyle({'z-index': parseInt(this.editPanel.mask.getStyle('z-index')) + 2});
		this.cropHandle = new Ext.Resizable(crop, {
			wrap:			true,
			pinned:			true,
			minWidth:		20,
			minHeight:		20,
			dynamic:		false,
			handles:		'all',
			draggable:		false,
			constrainTo:	this.previewProxy,
			listeners:{
				resize:function(resizer, newWidth, newHeight) {
					Ext.getCmp('widthField').setValue(parseInt(newWidth));
					Ext.getCmp('heightField').setValue(parseInt(newHeight));
				},
				scope:this
			}
		});
	},
	stopCrop: function() {
		if (Ext.getCmp('toggleCrop').pressed) {
			Ext.getCmp('toggleCrop').toggle(false);
		}
		if (this.cropHandle) {
			this.cropHandle.destroy(true);
			this.cropHandle = null;
		}
	},
	applyEdition: function() {
		if (!Ext.getCmp('widthField').isValid() || !Ext.getCmp('heightField').isValid()) {
			Automne.message.popup({
				msg: 				'L\'image dépasse les dimensions autorisées.',
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});
			return;
		}
		if (this.cropHandle) {
			var width = this.previewProxy.dom.clientWidth;
			var height = this.previewProxy.dom.clientHeight;
			var imgR = this.previewProxy.getRegion();
			var cropR = this.cropHandle.el.getRegion();
			var crop = {
				top:	parseInt(cropR.top - imgR.top),
				bottom:	parseInt(imgR.bottom - cropR.bottom),
				left:	parseInt(cropR.left - imgR.left),
				right:	parseInt(imgR.right - cropR.right)
			};
		} else {
			var crop = {top:0,bottom:0,left:0,right:0};
			var width = Ext.getCmp('widthField').getValue();
			var height = Ext.getCmp('heightField').getValue();
		}
		//send all datas to server to apply editions to image
		Automne.server.call('image-controler.php', this.endEdition, {
			image:			this.getValue(),
			width:			width,
			height:			height,
			cropTop:		crop.top,
			cropBottom:		crop.bottom,
			cropLeft:		crop.left,
			cropRight:		crop.right
		}, this);
	},
	endEdition: function(response, options, jsonResponse) {
		if (this.cropHandle) {
			this.stopCrop();
		}
		if (jsonResponse['error']) {
			Automne.message.popup({
				msg: 				jsonResponse['error'],
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});
		} else if (jsonResponse['filepath'] && jsonResponse['filename']) {
			//reload preview
			this.previewProxy.on({
				'load':{
					fn:function(e, el) {
						var img = Ext.get(el);
						this.setNaturalSize(img, Ext.isIE);
						try {
							//these properties are only getters for FF
							this.previewProxy.dom.naturalWidth = img.dom.naturalWidth;
							this.previewProxy.dom.naturalHeight = img.dom.naturalHeight;
						} catch(e){}
						this.maintainRatio = false;
						Ext.getCmp('widthField').setValue(this.previewProxy.dom.naturalWidth);
						Ext.getCmp('heightField').setValue(this.previewProxy.dom.naturalHeight);
						Ext.getCmp('sizeSlider').setValue(100);
						this.maintainRatio = true;
						this.adaptPreviewSize();
					},
					scope:this
				}
			});
			this.previewProxy.dom.src = jsonResponse['filepath']+'/'+ jsonResponse['filename'] +'?time='+(new Date()).getTime();
			this.fileinfos['filesize'] = jsonResponse['filesize'];
			this.fileinfos['filepath'] = jsonResponse['filepath'];
			this.fileinfos['filename'] = jsonResponse['filename'];
			this.loadFileInfos();
		}
	},
	setNaturalSize: function(image, force) {
		if (!force && image.dom.naturalWidth) {
			return true;
		} else {
			var proxy = image.createProxy({tag:'img', src:image.dom.src, cls:'x-hidden'}, Ext.getBody());
			try {
				//these properties are only getters for FF
				image.dom.naturalWidth = proxy.dom.width;
				image.dom.naturalHeight = proxy.dom.height;
			} catch(e){}
			proxy.remove();
			return true;
		}
	}
});
Ext.reg('atmImageUploadField', Automne.ImageUploadField);