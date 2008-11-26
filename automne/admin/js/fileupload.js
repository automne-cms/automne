/*
 * Ext JS Library 2.2
 * Copyright(c) 2006-2008, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */


Automne.FileUploadField = Ext.extend(Ext.form.TextField,  {
	/**
	 * @cfg {Number} buttonOffset The number of pixels of space reserved between the button and the text field
	 * (defaults to 3).
	 */
	buttonOffset: 3,
	/**
	 * @cfg {Object} buttonCfg A standard {@link Ext.Button} config object.
	 */

	// private
	readOnly: true,
	
	/**
	 * @hide 
	 * @method autoSize
	 */
	autoSize: Ext.emptyFn,
	
	// private : swfupload object
	swfu: false,
	
	//all fileinfos
	fileinfos:{},
	
	// private
	initComponent: function(){
		Automne.FileUploadField.superclass.initComponent.call(this);
		this.addEvents(
			'beforecancel', //before cancel upload (return false to cancel action)
			'cancel', //after cancel upload
			'beforedelete', //before delete file (return false to cancel action)
			'delete', //after delete file
			'beforestartupload', //before upload start (return false to cancel action)
			'startupload', //after upload start
			'uploadsuccess', //after upload success
			'uploadfailure' //after upload failure
        );
		//default fileinfos
		this.fileinfos = Ext.applyIf(this.fileinfos || {}, {
			'filename':		'',
			'filepath':		'',
			'filesize':		'',
			'fileicon':		'',
			'extension':	'',
			'module':		'standard',
			'visualisation':'edition'
		});
		//default upload conf
		this.uploadCfg = Ext.applyIf(this.uploadCfg || {}, {
			// Default Settings
			upload_url: 					"/automne/admin/upload-controler.php",
			flash_url : 					"/automne/swfupload/swfupload_f9.swf",
			file_upload_limit : 			0,
			file_queue_limit : 				1,
			file_queue_error_handler : 		this.fileError,
			file_dialog_complete_handler :	this.fileDialogComplete,
			upload_start_handler:			this.uploadStart,
			upload_progress_handler :		this.uploadProgress,
			upload_error_handler :			this.fileError,
			upload_success_handler :		this.uploadSuccess,
			upload_complete_handler :		this.uploadComplete,
			debug_handler :					window.pr,
			custom_settings : {
				block: 							this
			},
			post_params: {
				userAgent:						window.navigator.userAgent
			},
			file_size_limit : 				"2048",
			file_types : 					"*.*",
			file_queue_limit : 				1,
			file_types_description : 		"All files ...",
			// Debug Settings
			debug: 							(Automne.context.debug & 1)
		});
		this.swfu = new SWFUpload(this.uploadCfg);
		//append max filesize limit to fieldLabel
		if (this.uploadCfg && this.uploadCfg.file_size_limit && this.fieldLabel) {
			var separator = (typeof this.labelSeparator != 'undefined') ? this.labelSeparator : new Ext.layout.FormLayout().labelSeparator;
			this.fieldLabel += separator +'<br /><small>('+ Automne.locales.max +' '+ (this.uploadCfg.file_size_limit / 1024) +' M'+ Automne.locales.byte +')</small>';
			this.labelSeparator = '';
		}
	},
	onDestroy: function() {
		//remove swfu object
		if (this.swfu) {
			this.swfu.destroy();
		}
	},
	// private
	onRender : function(ct, position){
		Automne.FileUploadField.superclass.onRender.call(this, ct, position);
		
		this.wrap = this.el.wrap({cls:'x-form-field-wrap x-form-file-wrap'});
		this.el.addClass('x-form-file-text');
		this.el.dom.removeAttribute('name');
		if(this.name){
			this.hiddenField = this.el.insertSibling({tag:'input', type:'hidden', name: this.name, id: this.name}, 'before', true);
		}
		//browse button
		var btnCfg = Ext.applyIf(this.buttonCfg || {}, {
			text: 			Automne.locales.browse
		});
		this.button = new Ext.Button(Ext.apply(btnCfg, {
			renderTo: 		this.wrap,
			cls: 			'x-form-file-btn' + (btnCfg.iconCls ? ' x-btn-icon' : '')
		}));
		//cancel button
		var cancelCfg = Ext.applyIf(this.cancelCfg || {}, {
			text: 			Automne.locales.cancel
		});
		this.cancel = new Ext.Button(Ext.apply(cancelCfg, {
			renderTo: 		this.wrap,
			hidden:			true,
			cls: 			'x-form-file-btn' + (cancelCfg.iconCls ? ' x-btn-icon' : '')
		}));
		this.cancel.on('click', this.cancelUpload, this);
		if (this.uploadCfg.file_queue_limit != 1) {
			this.button.on('click', this.swfu.selectFiles, this.swfu);
		} else {
			this.button.on('click', this.swfu.selectFile, this.swfu);
		}
		this.infoEl = this.wrap.createChild({cls:'x-form-fileinfos'});
		this.loadFileInfos();
	},
	cancelUpload: function() {
		if (this.fireEvent('beforecancel', this) !== false) {
			this.swfu.cancelUpload(this.fileId);
			this.fireEvent('cancel', this);
		}
	},
	deleteFile: function() {
		if (this.fireEvent('beforedelete', this, this.fileinfos) !== false) {
			var deletedInfos = this.fileinfos;
			this.fileinfos = {
				'filename':		'',
				'filepath':		'',
				'filesize':		'',
				'fileicon':		'',
				'extension':	'',
				'module':		this.fileinfos.module,
				'visualisation':this.fileinfos.visualisation
			};
			this.loadFileInfos();
			this.fireEvent('delete', this, deletedInfos);
		}
	},
	// private
	getFileInputId: function(){
		return this.id+'-file';
	},
	// private
	ellipsis: function(label, size){
		if (!label) {
			return '';
		}
		if (label.length <= size) {
			return label;
		}
		return label.substr(0, Math.ceil((size-3)/2)) + '...' + label.substr(- Math.ceil((size-3)/2));
	},
	// private
	onResize : function(w, h){
		Automne.FileUploadField.superclass.onResize.call(this, w, h);
		this.wrap.setWidth(w);
		this.infoEl.setWidth(w);
		var w = w - this.button.getEl().getWidth() - this.buttonOffset;
		
		this.wrap.setHeight(50);
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
	// private
    initValue : function(){
        // reference to original value for reset
        this.originalValue = this.getValue();
    },
	/**
	 * Returns the normalized data value
	 */
	getValue : function(){
		return this.hiddenField.value;
	},
	getRawValue : function() {
		return this.getValue();
	},
	setValue: function(v, path) {
		this.getEl().dom.value = this.ellipsis(v, 51);
		if (v && path) {
			v = path +'/'+ v;
		} else if(this.fileinfos['filepath']) {
			v = this.fileinfos['filepath'] +'/'+ v;
		} else if(v && this.fileinfos.module) {
			//send all datas to server to get file infos if any
			Automne.server.call('file-infos.php', function(response, options, jsonResponse) {
				this.fileinfos = jsonResponse;
				this.loadFileInfos();
			}, {
				file:			v,
				module:			this.fileinfos.module,
				visualisation:	this.fileinfos.visualisation
			}, this);
			
			v = '';
		} else {
			v = '';
		}
		if(this.emptyText && this.el && v !== undefined && v !== null && v !== ''){
            this.el.removeClass(this.emptyClass);
        }
		this.value = v;
        this.applyEmptyText();
        this.hiddenField.value = v;
	},
	// private
	preFocus : Ext.emptyFn,
	
	// private
	getResizeEl : function(){
		return this.wrap;
	},

	// private
	getPositionEl : function(){
		return this.wrap;
	},

	// private
	alignErrorIcon : function(){
		this.errorIcon.alignTo(this.wrap, 'tl-tr', [2, 0]);
	},
	//display all current file infos
	loadFileInfos: function() {
		var html = '';
		if (this.fileinfos['filename'] && this.fileinfos['filepath']) {
			html = '<a href="'+ this.fileinfos['filepath']+ '/' +this.fileinfos['filename'] +'" target="_blank">'+ this.ellipsis(this.fileinfos['filename'], 51) +'</a>';
			if (this.fileinfos['filesize']) {
				html += ' ('+ this.fileinfos['filesize'] + Automne.locales.byte +')';
			}
			if (this.fileinfos['fileicon']) {
				html = '<img src="'+ this.fileinfos['fileicon'] +'" alt="' + this.fileinfos['extension'] + '" title="' + this.fileinfos['extension'] + '" /> ' + html;
			}
			this.setValue(this.fileinfos['filename'], this.fileinfos['filepath']);
		} else {
			this.setValue('');
		}
		this.infoEl.update(html);
		if (html) {
			if (!this.deleteEl) {
				this.deleteEl = this.infoEl.insertHtml('beforeEnd','<span class="atm-block-control atm-block-control-del">&nbsp;</span>', true);
				this.deleteEl.on('mousedown', this.deleteFile, this);
				this.deleteEl.addClassOnOver('atm-block-control-del-on');
			} else {
				this.infoEl.appendChild(this.deleteEl);
			}
		}
	},
	fileError: function(file, errorCode, message) {
		try {
			var block = (this.swfu) ? this : this.settings.custom_settings.block;
			var al = Automne.locales;
			block.progress.reset(true);
			block.cancel.hide();
			block.button.show();
			block.el.show();
			
			var errorName = "";
			switch (errorCode) {
				case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
					errorName = al.queueLimit;
				break;
				case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
					errorName = al.zeroByte;
				break;
				case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
					errorName = String.format(al.tooBig, (Math.round((file.size / 1048576)*100) / 100), (block.uploadCfg.file_size_limit / 1024));
				break;
				case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
					errorName = al.invalidType;
				break;
				case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
					errorName = al.sendingCancelled;
				break;
				case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
					errorName = al.sendingStopped;
				break;
				case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
					errorName = al.sizeLimit;
				break;
				case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
					errorName = al.uploadError;
				break;
				case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
					errorName = al.treatmentError;
				break;
				case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
					errorName = al.securityError;
				break;
				default:
					errorName = al.unknownError + message;
				break;
			}
			Automne.message.popup({
				msg: 				errorName,
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});
			//validate field value (remove the invalid label)
			block.validate();
			block.fireEvent('uploadfailure', block, file, errorCode, message);
		} catch (ex) {
			pr(ex);
		}
	},
	//SWFUpload control methods
	fileDialogComplete: function(numFilesSelected, numFilesQueued) {
		try {
			if (numFilesQueued > 0) {
				this.startUpload();
			}
		} catch (ex) {
			this.debug(ex);
		}
	},
	uploadStart: function(file) {
		var block = this.settings.custom_settings.block;
		if (block.fireEvent('beforestartupload', block, file) === false) {
			return false;
		}
		block.markInvalid(Automne.locales.pleaseWait);
		var progress = block.progress;
		var el = block.getEl();
		el.hide();
		block.button.hide();
		block.cancel.show();
		//set file id
		block.fileId = file.id;
		//reset block value
		block.setValue('');
		progress.show();
		progress.updateProgress(0, file.name +' ...');
		block.fireEvent('startupload', block, file);
	},
	uploadProgress: function(file, bytesLoaded) {
		try {
			var percent = bytesLoaded / file.size;
			var progress = this.settings.custom_settings.block.progress;
			if (!progress.hidden) {
				progress.updateProgress(percent, file.name +' : '+ Math.ceil(percent*100) +'%');	
			}
		} catch (ex) {
			this.debug(ex);
		}
	},
	uploadSuccess: function(file, serverData) {
		var block = this.settings.custom_settings.block;
		var progress = block.progress;
		var el = block.getEl();
		progress.reset(true);
		block.cancel.hide();
		block.button.show();
		el.show();
		//load serverdata as a new XMLDocument
		if (document.implementation && document.implementation.createDocument) {
			var parser = new DOMParser();
			xmlDatas = parser.parseFromString(serverData, "text/xml");
		} else if (window.ActiveXObject) {
			xmlDatas = new ActiveXObject("Microsoft.XMLDOM");
			xmlDatas.async="false"
			xmlDatas.loadXML(serverData)
		} else {
			Automne.message.popup({
				msg: 				Automne.locales.browserError,
				buttons: 			Ext.MessageBox.OK,
				closable: 			false,
				icon: 				Ext.MessageBox.ERROR
			});
			return;
		}
		var response = {responseXML: xmlDatas};
		//eval response for errors management
		var jsonResponse = Automne.server.evalResponse(response, {scope:this});
		if (typeof jsonResponse.error == "undefined") {
			block.fileError(file, SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED, '');
		} else if (jsonResponse.error !== 0) {
			block.fileError(file, jsonResponse.error, '');
		} else {
			block.fileinfos = jsonResponse;
			block.loadFileInfos();
		}
		//validate field value (remove the invalid label)
		block.validate();
		block.fireEvent('uploadsuccess', block, file, serverData);
	},
	uploadComplete: function(file) {
		//nothing for now
	}
});
Ext.reg('atmFileUploadField', Automne.FileUploadField);