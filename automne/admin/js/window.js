/**
  * Automne.Window Extension Class for Ext.Window
  * Manager for windows update through ajax request. Allow fine error management
  * @class Automne.Window
  * @extends Ext.Window
  */
Automne.Window = Ext.extend(Ext.Window, {
	currentPage:	false,
	father:			false,
	resources:		{},
	//constructor
	constructor: function(config) { 
		config = Ext.applyIf(config, {
			currentPage:	false,
			width: 			750,
			height:			500,
			minWidth:		500,
			resizable:		true,
			modal: 			true,
			shim:			false,
			maximizable:	true,
			constrainHeader:true,
			layout:			'atm-border',
			iconCls:		'atm-pic-logo',
			title: 			'&nbsp;',
			footer:			true,
			layout:			'atm-border',
			tools:[{
				id:				'help',
				hidden:			true,
				handler: 		Ext.emptyFn
			}]
		});
		//set winId for autoLoad if missing
		if (config.id && config.autoLoad && config.autoLoad.params && !config.autoLoad.params.winId) {
			config.autoLoad.params.winId = config.id;
		}
		// preprocessing
		this.currentPage = (config.currentPage) ? config.currentPage : false;
		arguments[0] = config;
		//call parent
		Automne.Window.superclass.constructor.apply(this, arguments); 
	},
	// private
	initComponent : function(){
		this.resources = {};
		Automne.Window.superclass.initComponent.call(this);
	},
	initEvents : function(){
		Automne.Window.superclass.initEvents.call(this);
		if (this.modal) {
			this.on("beforeclose", this.checkModalGroup, this);
		}
	},
	checkModalGroup: function () {
		if (this.modal && this.manager.hasDaughters(this)) {
			Automne.message.popup({
				msg: 				Automne.locales.cannotCloseModalGroup,
				buttons: 			Ext.MessageBox.OK,
				animEl: 			this.tools.close,
				closable: 			false,
				icon: 				Ext.MessageBox.INFO
			});
			return false;
		}
		return true;
	},
	addButtons: function (buttons) {
		// tables are required to maintain order and for correct IE layout
		var tb = this.footer.createChild({cls:'x-panel-btns-ct', cn: {
			cls:"x-panel-btns x-panel-btns-"+this.buttonAlign,
			html:'<table cellspacing="0"><tbody><tr></tr></tbody></table><div class="x-clear"></div>'
		}}, null, true);
		var tr = tb.getElementsByTagName('tr')[0];
		for(var i = 0, len = buttons.length; i < len; i++) {
			var b = buttons[i];
			var td = document.createElement('td');
			td.className = 'x-panel-btn-td';
			b.render(tr.appendChild(td));
		}
	},
	show: function() {
		//call parent
		Automne.Window.superclass.show.apply(this, arguments); 
		//set window specific updater
		this.getUpdater().renderer = new Automne.windowRenderer();
	},
	setZIndex : function(index, leaveMaskAlone){
		//here if window is a modal one, we can leave the mask in place (used by Automne.ModalWindowGroup) 
		if(this.modal) {
			if (!leaveMaskAlone){
				this.mask.setStyle("z-index", index);
			} else if(index < this.mask.getStyle("z-index")) {
				index = parseInt(this.mask.getStyle("z-index"));
			}
		}
		this.el.setZIndex(++index);
		index += 5;

		if(this.resizer){
			this.resizer.proxy.setStyle("z-index", ++index);
		}
		this.lastZIndex = index;
	},
	// private - used for dragging : correct a z-index pb with modal group during dragging 
    ghost : function(cls){
        //get initial z-index of window element
		var zindex = parseInt(this.el.getStyle('z-index'));
		//call parent to get ghost
		var g = Automne.Window.superclass.ghost.apply(this, arguments); 
		//set initial z-index to ghost
		g.setStyle('z-index', zindex);
		return g;
    },
	updateResource: function (action, module, resourceId) {
		if (action == 'delete' && this.resources[module] && this.resources[module][resourceId] && this.update) {
			this.update();
		}
	},
	addResource: function (module, resourceId) {
		if (!this.resources[module]) {
			this.resources[module] = {};
		}
		this.resources[module][resourceId] = true;
	},
	resetResources: function() {
		this.resources = {};
	}
});
/**
  * Automne.windowRenderer Extension Class for Ext.Updater.BasicRenderer
  * Manager for windows update through ajax request. Allow fine error management
  * @class Automne.windowRenderer
  * @extends Ext.Updater.BasicRenderer
  */
Automne.windowRenderer = Ext.extend(Ext.Updater.BasicRenderer, {
	//this is the method called after request
	render: function(el, response, updateManager, callback) {
		if (response.status != '200') {
			if (el.dom) {
				el.dom.innerHTML = Automne.locales.loadingError+ ' (code : '+ response.status +')';
			} else {
				Automne.message.popup({
					msg: 				Automne.locales.loadingError+ ' (code : '+ response.status +')',
					buttons: 			Ext.MessageBox.OK,
					closable: 			false,
					icon: 				Ext.MessageBox.ERROR
				});
			}
		}
		//redirect to automne evalResponse for errors management
		Automne.server.evalResponse(response, {
			scope:			response.argument.options.scope || this,
			el:				el,
			fcnCallback:	this.doRender,
			evalJS:			false
		});
	},
	//render response into window body
	doRender: function(response, options, content) {
		if (options.el.dom && content) {
			options.el.dom.innerHTML = content;
		} else {
			options.el.dom.innerHTML = '';
		}
		if (response.responseXML.getElementsByTagName('jscontent').length) {
			/*try {*/
				eval(response.responseXML.getElementsByTagName('jscontent').item(0).firstChild.nodeValue);
			/*} catch(e) {
				pr(e);
			}*/
		}
		if (options.el.dom && !content && !response.responseXML.getElementsByTagName('jscontent').length) {
			options.el.dom.innerHTML = Automne.locales.loadingError;
		}
	}
});
/**
  * Automne.ModalWindowGroup Extension Class for Ext.WindowGroup
  * Allow grouping of windows around a modal window (windows of the group does not pass throught the modal layer)
  * @class Automne.ModalWindowGroup
  * @extends Ext.WindowGroup
  */
Automne.ModalWindowGroup = function(){
    var list = {};
    var accessList = [];
    var front = null;
	var daughtersList = {};
    // private
    var sortWindows = function(d1, d2){
        return (!d1._lastAccess || d1._lastAccess < d2._lastAccess) ? -1 : 1;
	};

	// private
	var orderWindows = function(){
		var a = accessList, len = a.length;
		if(len > 0){
			a.sort(sortWindows);
			var seed = a[0].manager.zseed;
			for(var i = 0; i < len; i++){
				var win = a[i];
				//move seed to z-index of group father mask if any
				if (win.father && win.father.modal) {
					seed = parseInt(win.father.mask.getStyle('z-index'));
				}
				if(win && !win.hidden){
					win.setZIndex(seed + (i*10), win.manager.hasDaughters(win));
				}
			}
		}
		activateLast();
	};

	// private
	var setActiveWin = function(win){
		if(win != front){
			if(front){
				front.setActive(false);
			}
			front = win;
			if(win){
				win.setActive(true);
			}
		}
	};

	// private
	var activateLast = function(){
		for(var i = accessList.length-1; i >=0; --i) {
			if(!accessList[i].hidden){
				setActiveWin(accessList[i]);
				return;
			}
		}
		// none to activate
		setActiveWin(null);
	};

	return {
		/**
		 * The starting z-index for windows (defaults to 9000)
		 * @type Number The z-index value
		 */
		zseed : 9000,
		modalMgr:true,
		// private
		register : function(win){
			list[win.id] = win;
			accessList.push(win);
			//if window has a father, add it to father's daugther list
			if (win.father) {
				if (!daughtersList[win.father.id]) {
					daughtersList[win.father.id] = [];
				}
				daughtersList[win.father.id].push(win.id);
			}
			win.on('hide', activateLast);
		},

		// private
		unregister : function(win){
			delete list[win.id];
			win.un('hide', activateLast);
			accessList.remove(win);
			if (daughtersList[win.id]) {
				delete daughtersList[win.id];
			}
			if (win.father && daughtersList[win.father.id]) {
				daughtersList[win.father.id].remove(win.id);
			}
		},

		/**
		 * Gets a registered window by id.
		 * @param {String/Object} id The id of the window or a {@link Ext.Window} instance
		 * @return {Ext.Window}
		 */
		get : function(id){
			return typeof id == "object" ? id : list[id];
		},

		/**
		 * Brings the specified window to the front of any other active windows.
		 * @param {String/Object} win The id of the window or a {@link Ext.Window} instance
		 * @return {Boolean} True if the dialog was brought to the front, else false
		 * if it was already in front
		 */
		bringToFront : function(win){
			win = this.get(win);
			if(win != front){
				win._lastAccess = new Date().getTime();
				orderWindows();
				return true;
			}
			return false;
		},

		/**
		 * Sends the specified window to the back of other active windows.
		 * @param {String/Object} win The id of the window or a {@link Ext.Window} instance
		 * @return {Ext.Window} The window
		 */
		sendToBack : function(win){
			win = this.get(win);
			win._lastAccess = -(new Date().getTime());
			orderWindows();
			return win;
		},

		/**
		 * Hides all windows in the group.
		 */
		hideAll : function(){
			for(var id in list){
				if(list[id] && typeof list[id] != "function" && list[id].isVisible()){
					list[id].hide();
				}
			}
		},

		/**
		 * Gets the currently-active window in the group.
		 * @return {Ext.Window} The active window
		 */
		getActive : function(){
			return front;
		},
		
		/**
		 * Does the current window has daughters registered
		 * @return {Boolean}
		 */
		hasDaughters : function(win){
			return (win.modal && daughtersList[win.id] && daughtersList[win.id].length) ? true : false;
		},

		/**
		 * Returns zero or more windows in the group using the custom search function passed to this method.
		 * The function should accept a single {@link Ext.Window} reference as its only argument and should
		 * return true if the window matches the search criteria, otherwise it should return false.
		 * @param {Function} fn The search function
		 * @param {Object} scope (optional) The scope in which to execute the function (defaults to the window
		 * that gets passed to the function if not specified)
		 * @return {Array} An array of zero or more matching windows
		 */
		getBy : function(fn, scope){
			var r = [];
			for(var i = accessList.length-1; i >=0; --i) {
				var win = accessList[i];
				if(fn.call(scope||win, win) !== false){
					r.push(win);
				}
			}
			return r;
		},

		/**
		 * Executes the specified function once for every window in the group, passing each
		 * window as the only parameter. Returning false from the function will stop the iteration.
		 * @param {Function} fn The function to execute for each item
		 * @param {Object} scope (optional) The scope in which to execute the function
		 */
		each : function(fn, scope){
			for(var id in list){
				if(list[id] && typeof list[id] != "function"){
					if(fn.call(scope || list[id], list[id]) === false){
						return;
					}
				}
			}
		}
	};
};
//replace default Ext.WindowMgr
Ext.WindowMgr = new Automne.ModalWindowGroup();