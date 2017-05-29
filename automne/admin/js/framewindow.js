/**
  * Automne Javascript file
  *
  * Automne.frameWindow Extension Class for Ext.Panel
  * Provide all events and watch for a contained frame
  * @class Automne.frameWindow
  * @extends Automne.Window
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: framewindow.js,v 1.11 2009/11/20 17:35:36 sebastien Exp $
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
		Ext.applyIf(this, {
			html:  			'<iframe id="' + this.id + 'Frame" width="100%" height="100%"' + (!Ext.isIE ? ' class="x-hide-visibility"' : '') + ' frameborder="no" src="' + Ext.SSL_SECURE_URL + '">&nbsp;</iframe>',
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
		this.loadFrameDocument();
		//set title
		try {		
			if (this.frameDocument && this.frameDocument.title && (!this.title || this.title == '&nbsp;')) {
				this.setTitle(this.frameDocument.title);
			}
		} catch (e){}
		//show frame
		this.frameEl.removeClass('x-hide-visibility');
	},
	//resize frame according to panel size
	resize: function() {
		this.frameEl.setWidth(this.body.getBox().width);
		this.frameEl.setHeight(this.body.getBox().height);
	},
	//reload frame content
	reload: function (force) {
		this.forceReload = force || this.forceReload;
		if (this.loadFrameDocument()) {
			if (this.frameDocument) {
				pr('Reload frame '+ this.id +' => Get : '+this.frameURL);
				try {
					var location = '';
					var parts = this.frameURL.split('#');
					if (parts[1]) {
						location = parts[0] + ((parts[0].indexOf('#') === -1) ? '?' : '&') + '_dc='+ (new Date()).getTime();
						location += '#' + parts[1];
					} else {
						location = this.frameURL + ((this.frameURL.indexOf('?') === -1) ? '?' : '&') + '_dc='+ (new Date()).getTime();
					}
					this.frameDocument.location = location;
				} catch (e) {
					pr(e, 'error');
				}
				this.forceReload = false;
			}
		}
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
		this.frameDocument = this.getDoc();
		return true;
	},
	// private
	getDoc : function(){
		if (!this.frameEl) {
			return false;
		}
		return Ext.isIE ? this.getWin().document : (this.frameEl.dom.contentDocument || this.getWin().document);
	},
	// private
	getDoc : function(){
		if (!this.frameEl) return false;
		return Ext.isIE ? this.getWin().document : (this.frameEl.dom.contentDocument || this.getWin().document);
	},
	// private
	getWin : function(){
		if (!this.frameEl || !this.frameEl.dom) {
			return false;
		}
		var win = false;
		try {
			win = this.frameEl.dom.contentWindow || window.frames[this.frameEl.dom.name];
		} catch (e) {
			pr(e, 'error');
		}
		return win;
	}
});
Ext.reg('frameWindow', Automne.frameWindow);
