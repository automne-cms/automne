/**
  * Automne Javascript file
  *
  * Automne.FileUploadField Extension Class for Ext.form.TextField
  * Provide an file upload field
  * @class Automne.FileUploadField
  * @extends Ext.form.TextField
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: fileupload.js,v 1.7 2009/06/25 13:57:23 sebastien Exp $
  */
Automne.FileUploadField = Ext.extend(Ext.form.TextField,  {
	/**
	 * @cfg {String} buttonText The button text to display on the upload button (defaults to
	 * 'Browse...').  Note that if you supply a value for {@link #buttonCfg}, the buttonCfg.text
	 * value will be used instead if available.
	 */
	buttonText: 'Browse...',
	/**
	 * @cfg {Boolean} buttonOnly True to display the file upload field as a button with no visible
	 * text field (defaults to false).  If true, all inherited TextField members will still be available.
	 */
	buttonOnly: false,
	/**
	 * @cfg {Number} buttonOffset The number of pixels of space reserved between the button and the text field
	 * (defaults to 3).  Note that this only applies if {@link #buttonOnly} = false.
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
	
	QUEUE_ERROR: {
		QUEUE_LIMIT_EXCEEDED	  		: -100,
		FILE_EXCEEDS_SIZE_LIMIT  		: -110,
		ZERO_BYTE_FILE			  		: -120,
		INVALID_FILETYPE		  		: -130
	},
	UPLOAD_ERROR: {
		HTTP_ERROR				  		: -200,
		MISSING_UPLOAD_URL		  		: -210,
		IO_ERROR				  		: -220,
		SECURITY_ERROR			  		: -230,
		UPLOAD_LIMIT_EXCEEDED	  		: -240,
		UPLOAD_FAILED			  		: -250,
		SPECIFIED_FILE_ID_NOT_FOUND		: -260,
		FILE_VALIDATION_FAILED	  		: -270,
		FILE_CANCELLED			  		: -280,
		UPLOAD_STOPPED					: -290
	},
	
	// private
	initComponent: function(){
		Automne.FileUploadField.superclass.initComponent.call(this);
		this.addEvents(
			/**
			 * @event fileselected
			 * Fires when the underlying file input field's value has changed from the user
			 * selecting a new file from the system file selection dialog.
			 * @param {Ext.form.FileUploadField} this
			 * @param {String} value The file value returned by the underlying file input field
			 */
			'fileselected',
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
		//append max filesize limit to fieldLabel
		if (this.uploadCfg && this.uploadCfg.file_size_limit && this.fieldLabel) {
			var separator = (typeof this.labelSeparator != 'undefined') ? this.labelSeparator : new Ext.layout.FormLayout().labelSeparator;
			this.fieldLabel += separator +'<br /><small>'+ Automne.locales.max +' '+ (this.uploadCfg.file_size_limit / 1024) +' M'+ Automne.locales.byte +'</small>';
			this.labelSeparator = '';
		}
		//add disallowed files type if not exists
		this.uploadCfg = Ext.applyIf(this.uploadCfg || {}, {disallowed_file_types: '*.exe;*.php;*.pif;*.vbs;*.bat;*.com;*.scr;*.reg'});
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
		this.fileInput = this.wrap.createChild({
			id:			this.getFileInputId(),
			name:		'Filedata',
			cls:		'x-form-file',
			tag:		'input', 
			type:		'file',
			size:		1
		});
		
		var btnCfg = Ext.applyIf(this.buttonCfg || {}, {
			text: 		Automne.locales.browse
		});
		this.button = new Ext.Button(Ext.apply(btnCfg, {
			renderTo: this.wrap,
			cls: 'x-form-file-btn' + (btnCfg.iconCls ? ' x-btn-icon' : '')
		}));
		this.infoEl = this.wrap.createChild({cls:'x-form-fileinfos'});
		
		this.fileInput.on('change', function(){
			var v = this.fileInput.dom.value;
			//this.setValue(v);
			this.fireEvent('fileselected', this, v);
		}, this);
		
		this.on('fileselected', this.uploadStart, this);
		
		this.loadFileInfos();
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
			this.clearInvalid();
			this.loadFileInfos();
			this.fireEvent('delete', this, deletedInfos);
		}
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
	getFileInputId: function(){
		return this.id+'-file';
	},
	// private
	onResize : function(w, h){
		Automne.FileUploadField.superclass.onResize.call(this, w, h);
		this.wrap.setWidth(w);
		this.infoEl.setWidth(w);
		var w = w - this.button.getEl().getWidth() - this.buttonOffset;
		
		this.wrap.setHeight(55);
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
		if (typeof v == 'object') {
			this.fileinfos = v;
			this.loadFileInfos();
		} else {
			this.getEl().dom.value = this.ellipsis(v, 51);
			if (v && path) {
				v = path +'/'+ v;
				this.fileinfos.filepath = path;
			} else if(v) {
				if(this.fileinfos.module && this.fileinfos.visualisation) {
					//send all datas to server to get file infos if any
					Automne.server.call('file-infos.php', function(response, options, jsonResponse) {
						this.fileinfos = Ext.applyIf(jsonResponse, this.fileinfos);
						this.loadFileInfos();
					}, {
						file:			v,
						module:			this.fileinfos.module,
						visualisation:	this.fileinfos.visualisation
					}, this);
					v = this.getEl().dom.value = '';
				} else if (this.fileinfos.filepath) {
					v = this.fileinfos.filepath +'/'+ v;
				}
			} else {
				v = this.getEl().dom.value = '';
			}
			if(this.emptyText && this.el && v !== undefined && v !== null && v !== ''){
				this.el.removeClass(this.emptyClass);
			} else if(this.emptyText && this.el) {
				this.applyEmptyText();
			}
			this.value = v;
			this.hiddenField.value = v;
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
		return true;
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
				this.deleteEl = this.infoEl.insertHtml('beforeEnd','<span class="atm-block-control atm-block-control-del" ext:qtip="'+Automne.locales.removeFile+'">&nbsp;</span>', true);
				this.deleteEl.on('mousedown', this.deleteFile, this);
				this.deleteEl.addClassOnOver('atm-block-control-del-on');
			} else {
				this.infoEl.appendChild(this.deleteEl);
			}
		}
	},
	uploadStart: function(field, file) {
		//check for file type if any
		if (this.uploadCfg.file_types && this.uploadCfg.file_types != '*.*') {
			var allowedTypes = this.uploadCfg.file_types.split(/;/);
			var ok = false;
			var fileExtension = file.split(/\./)[file.split(/\./).length - 1].toLowerCase();
			for(var i = 0; i < allowedTypes.length; i++) {
				if (allowedTypes[i] && fileExtension.indexOf(allowedTypes[i].substring(2).toLowerCase()) !== -1) {
					ok = true;
				}
			}
			if (!ok) {
				this.fileError(file, this.QUEUE_ERROR.INVALID_FILETYPE, '');
				return false;
			}
		}
		//check for file type if any
		if (this.uploadCfg.disallowed_file_types) {
			var disallowedTypes = this.uploadCfg.disallowed_file_types.split(/;/);
			var ok = true;
			var fileExtension = file.split(/\./)[file.split(/\./).length - 1].toLowerCase();
			for(var i = 0; i < disallowedTypes.length; i++) {
				if (disallowedTypes[i] && fileExtension.indexOf(disallowedTypes[i].substring(2).toLowerCase()) !== -1) {
					ok = false;
				}
			}
			if (!ok) {
				this.fileError(file, this.QUEUE_ERROR.INVALID_FILETYPE, '');
				return false;
			}
		}
		//var block = this.settings.custom_settings.block;
		if (this.fireEvent('beforestartupload', this, file) === false) {
			return false;
		}
		this.markInvalid(Automne.locales.pleaseWait);
		var progress = this.progress;
		var el = this.getEl();
		el.hide();
		this.button.hide();
		//this.cancel.show();
		//set file id
		this.fileId = file.id;
		//reset block value
		this.setValue('');
		progress.show();
		progress.wait({
			interval:	200,
			increment:	15,
			text:		'\''+ file + '\'' + ' : Envoi en cours ...'
		});
		this.fireEvent('startupload', this, file);
		
		//create form to submit file
		this.form = document.createElement('form');
		this.form.method = 'POST';
		document.body.appendChild(this.form);
		//append file input to form
		this.form.appendChild(this.fileInput.dom);
		this.requestId = Automne.server.call({
			fcnCallback:	this.uploadSuccess,
			scope:			this,
			form:			this.form,
			url:			Automne.context.path + "/automne/admin/upload-controler.php",
			method:			'POST',
			isUpload:		true,
			file:			file
		});
	},
	uploadSuccess: function(response, options, jsonResponse) {
		//reset field
		this.resetField();
		if (typeof jsonResponse.error == "undefined") {
			this.fileError(options.file, this.UPLOAD_ERROR.UPLOAD_FAILED, '');
		} else if (jsonResponse.error !== 0) {
			this.fileError(options.file, jsonResponse.error, '');
		} else {
			this.fileinfos = Ext.applyIf(jsonResponse, this.fileinfos);
			this.loadFileInfos();
		}
		//validate field value (remove the invalid label)
		this.validate();
		this.fireEvent('uploadsuccess', this, options.file, jsonResponse);
	},
	resetField: function() {
		var progress = this.progress;
		var el = this.getEl();
		progress.reset(true);
		//this.cancel.hide();
		this.button.show();
		el.show();
		//reset request Id
		this.requestId = false;
		//remove file input and form
		if (this.form) {
			this.fileInput.remove();
			Ext.get(this.form).remove();
			this.form = false;
			this.fileInput = this.wrap.createChild({
				id:			this.getFileInputId(),
				name:		'Filedata',
				cls:		'x-form-file',
				tag:		'input', 
				type:		'file',
				size:		1
			});
			this.fileInput.on('change', function(){
				var v = this.fileInput.dom.value;
				//this.setValue(v);
				this.fireEvent('fileselected', this, v);
			}, this);
		}
	},
	fileError: function(file, errorCode, message) {
		try {
			//var block = (this.swfu) ? this : this.settings.custom_settings.block;
			var al = Automne.locales;
			this.progress.reset(true);
			//this.cancel.hide();
			this.button.show();
			this.el.show();
			
			var errorName = "";
			switch (errorCode) {
				case this.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
					errorName = al.queueLimit;
				break;
				case this.QUEUE_ERROR.ZERO_BYTE_FILE:
					errorName = al.zeroByte;
				break;
				case this.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
					errorName = String.format(al.tooBig, (Math.round((file.size / 1048576)*100) / 100), (this.uploadCfg.file_size_limit / 1024));
				break;
				case this.QUEUE_ERROR.INVALID_FILETYPE:
					errorName = al.invalidType;
				break;
				case this.UPLOAD_ERROR.FILE_CANCELLED:
					errorName = al.sendingCancelled;
				break;
				case this.UPLOAD_ERROR.UPLOAD_STOPPED:
					errorName = al.sendingStopped;
				break;
				case this.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
					errorName = al.sizeLimit;
				break;
				case this.UPLOAD_ERROR.UPLOAD_FAILED:
					errorName = al.uploadError;
				break;
				case this.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
					errorName = al.treatmentError;
				break;
				case this.UPLOAD_ERROR.SECURITY_ERROR:
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
			this.validate();
			this.fireEvent('uploadfailure', this, file, errorCode, message);
		} catch (ex) {
			pr(ex, 'error');
		}
	}
});
Ext.reg('atmFileUploadField', Automne.FileUploadField);