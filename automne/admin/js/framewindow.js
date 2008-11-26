/**
  * Automne.frameWindow Extension Class for Ext.Panel
  * Provide all events and watch for a contained frame
  * @class Automne.frameWindow
  * @extends Automne.Window
  */
Automne.frameWindow = Ext.extend(Automne.Window, { 
	//frame url to use at next frame reload
	frameURL:			'',
	//does the frame currently has events attached to it
	frameEvents:		false,
	//iframe element
	frameEl:			false,
	//iframe inner document
	frameDocument: 		false,
	//is navigation allowed into frame ?
	allowFrameNav: 		false,
	//force next frmae reload (even if url is the same)
	forceReload:		false,
	//constructor
	constructor: function(config) { 
		// preprocessing
		if (config.frameURL) {
			this.setFrameURL(config.frameURL);
		}
		this.allowFrameNav = (config.allowFrameNav) ? config.allowFrameNav : true;
		//call constructor
		Automne.frameWindow.superclass.constructor.apply(this, arguments); 
	},
	//component initialisation (after constructor)
	initComponent: function() {
		Ext.apply(this, {
			html:  			'<iframe id="' + this.id + 'Frame" width="100%" height="100%" frameborder="no" src="#">&nbsp;</iframe>',
			hideBorders:	true,
			autoScroll:		true
		});
		this.on('show', this.onShow, this);
		// call parent initComponent
		Automne.frameWindow.superclass.initComponent.call(this);
	},
	//on destroy, destroy tooltip and iframe
	onDestroy: function () {
		//destroy frame
		if (this.frameEl !== false && this.frameEl.destroy) this.frameEl.destroy();
		//call parent
		Automne.frameWindow.superclass.onDestroy.apply(this, arguments);
	},
	//after panel is activated (tab panel clicked)
	onShow: function () {
		//if frame element is not known (first activation of panel), then set event on it and load it
		if (!this.frameEl) {
			this.frameEl = Ext.get(this.id + 'Frame');
			if (this.frameEl) {
				//set frame events
				this.setFrameEvents();
				this.reload();
			}
		}
	},
	//set load and resize events on frame if not already exists
	setFrameEvents: function() {
		if (this.frameEvents === false && this.frameEl) {
			this.frameEl.on('load', this.loadFrameInfos, this);
			//this.on('resize', this.resize, this);
			this.frameEvents = true;
		}
	},
	//function called after each load of a new page frame
	loadFrameInfos: function() {
		//get frame and document from event
		this.frameDocument = (Ext.isIE) ? this.frameEl.dom.contentWindow.document : this.frameEl.dom.contentDocument;
		if (!this.allowFrameNav) {
			pr('catch '+this.id+' frame links');
			this.catchFrameLinks();
		}
		this.setTitle(this.frameDocument.title);
	},
	//resize frame according to panel size
	resize: function() {
		this.frameEl.setWidth(this.body.getBox().width);
		this.frameEl.setHeight(this.body.getBox().height);
	},
	//catch all click into frame links and form submission to redirect action
	catchFrameLinks: function () {
		/*var links = Ext.DomQuery.select('a', this.frameDocument);
		for (var i=0; i < links.length; i++) {
			var link = Ext.get(links[i]);
			if (link.dom.target != "_blank") {
				link.on('click', function(e) {
					e.stopEvent();
					pr('load '+this.id+' frame infos');
					//call server to get page infos using page url
					Automne.server.call('page-infos.php?pageurl=' + this.dom.href);
				}, link);
			}
		}
		var forms = Ext.DomQuery.select('form', this.frameDocument);
		for (var i=0; i < forms.length; i++) {
			var form = Ext.get(forms[i]);
			if (form.dom.target != "_blank") {
				form.on('submit', function(e) {
					e.stopEvent();
					//send a message to user
					Ext.MessageBox.show({ //TODOV4 : rationaliser la création d'alerte et récup les label par ajax
						title: 'Action impossible', 
						msg: 'Vous ne pouvez pas soumettre un formulaire depuis une page non publique.',
						buttons: Ext.MessageBox.OK,
						icon: Ext.MessageBox.WARNING,
						animEl: this
					});
				}, form);
			}
		}*/
	},
	//reload frame content
	reload: function (force) {
		this.forceReload = force || this.forceReload;
		if (this.loadFrameDocument()) {
			pr('Reload '+this.id)
			if (this.frameDocument) {
				this.frameDocument.location = this.frameURL + (this.frameURL.indexOf('?') !== -1 ? '&' : '?') +'time='+ (new Date()).getTime();
				this.forceReload = false;
			}
		}
		
		/*this.forceReload = force || this.forceReload;
		if (!this.frameDocument) {
			//get frame document
			this.frameDocument = (Ext.isIE) ? this.frameEl.dom.contentWindow.document : this.frameEl.dom.contentDocument;
		}
		if (this.frameDocument) {
			//remove domain from urls*/
			//var documentURL = (this.frameDocument.location.href.indexOf("http://") === 0) ? this.frameDocument.location.href.replace(/http:\/\/[^\/]*/, '') : this.frameDocument.location.href;
			//var frameURL = (this.frameURL.indexOf("http://") === 0) ? this.frameURL.replace(/http:\/\/[^\/]*/, '') : this.frameURL;
			//and if url are different or if force is needed, then change frame location
			/*if (this.forceReload || documentURL != frameURL) {
				pr('Reload '+this.id)
				this.frameDocument.location = this.frameURL;
				this.forceReload = false;
			}
		}*/
	},
	//set a flag to force next reload of the frame (even if url is the same)
	setForceReload: function(force) {
		this.forceReload = force;
	},
	//frame url setters and getters
	setFrameURL: function(url) { 
		this.frameURL = url;
	},
	getFrameURL: function() {
		return this.frameURL;
	},
	loadFrameDocument: function () {
		if (!this.frameEl) {
			return false;
		}
		this.frameDocument = (Ext.isIE) ? this.frameEl.dom.contentWindow.document : this.frameEl.dom.contentDocument;
		return true;
	}
});
Ext.reg('frameWindow', Automne.frameWindow);