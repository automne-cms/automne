/**
  * Automne Javascript file
  *
  * Automne.tabPanel Extension Class for Ext.tabPanel
  * Provide all frame and windows panel management
  * @class Automne.tabPanel
  * @extends Ext.tabPanel
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: tabpanel.js,v 1.8 2009/11/27 15:37:48 sebastien Exp $
  */
Automne.tabPanel = Ext.extend(Ext.TabPanel, { 
	pageId:		false,
	isFavorite:	false,
	//component initialisation (after constructor)
	initComponent: function() {
		// call parent initComponent
		Automne.tabPanel.superclass.initComponent.call(this);
		this.on({'beforetabchange': this.beforeChangePanel, 'tabchange': this.afterChangePanel, scope: this});
	},
	/**
     * Sets the specified tab as the active tab. This method fires the {@link #beforetabchange} event which
     * can return false to cancel the tab change.
     * @param {String/Panel} tab The id or tab Panel to activate
     */
    setActiveTab : function(item, force){
		item = this.getComponent(item);
		if(!item || (item.disabled && !force) || this.fireEvent('beforetabchange', this, item, this.activeTab, force) === false){
			return;
		}
        if(!this.rendered){
            this.activeTab = item;
            return;
        }
        if(this.activeTab != item){
            if(this.activeTab){
                var oldEl = this.getTabEl(this.activeTab);
                if(oldEl){
                    Ext.fly(oldEl).removeClass('x-tab-strip-active');
					if(this.activeTab.reloadable) Ext.fly(oldEl).removeClass('x-tab-strip-reloadable');
                }
                this.activeTab.fireEvent('deactivate', this.activeTab);
            }
            var el = this.getTabEl(item);
            Ext.fly(el).addClass('x-tab-strip-active');
            if(item.reloadable) Ext.fly(el).addClass('x-tab-strip-reloadable');
			this.activeTab = item;
            this.stack.add(item);

            this.layout.setActiveItem(item);
            if(this.layoutOnTabChange && item.doLayout){
                item.doLayout();
            }
            if(this.scrolling){
                this.scrollToTab(item, this.animScroll);
            }

            item.fireEvent('activate', item);
            this.fireEvent('tabchange', this, item, force);
        }
    },
	//function called before each panel change.
	beforeChangePanel: function(tabPanel, newTab, oldTab, force) {
		return newTab.beforeActivate(tabPanel, newTab, oldTab, force);
	},
	//function called after each panel change.
	afterChangePanel: function(tabPanel, newTab, force) {
		//force remove locked tips
		var tip;
		while(tip = Ext.get('publicTip')) {
			if (tip) {
				tip.remove();
			}
		}
		//force hidding search panel
		Automne.view.removeSearch();
		return newTab.afterActivate(tabPanel, newTab, force);
	},
	setPageId: function(pageId) {
		this.pageId = pageId;
	},
	getPageInfos: function(params, fcn, fcnparams, scope) {
		params = Ext.applyIf(params, {
			pageUrl:	'',
			pageId:		'',
			from:		this.pageId,
			fromTab:	this.getActiveTab().id
		});
		if ((!params.pageId || params.pageId == 'false') && !params.pageUrl) {
			pr('Drop page info request, no valid infos to request ...');
			return false;
		}
		if (params.fromTab == false) {
			params.fromTab = 'public';
		}
		//disable all tabs except current one and search
		Automne.tabPanels.disableTabs(['search', params.fromTab]);
		
		Automne.tabPanels.items.each(function(panel) {
			if (panel.id != 'search' && panel.id != params.fromTab) {
				panel.disable();
			}
		});
		pr('Load '+params.fromTab+' frame infos');
		//uncomment this line to see source call
		//pr(this.getPageInfos.caller.toString());
		if (Automne.context.path != undefined) {
			Automne.server.call(Automne.context.path + '/automne/admin/page-infos.php?' + Ext.urlEncode(params), fcn, fcnparams, scope);
		}
	},
	disableTabs:function(exceptions) {
		exceptions = exceptions || [];
		var disabled = [];
		//disable all tabs except search
		Automne.tabPanels.items.each(function(panel) {
			if (exceptions.indexOf(panel.id) == -1 && !panel.disabled) {
				panel.disable();
				disabled[disabled.length] = panel.id;
			}
		});
		return disabled;
	},
	enableTabs:function(enable) {
		enable = enable || [];
		var enabled = [];
		//disable all tabs except search
		Automne.tabPanels.items.each(function(panel) {
			if (enable.indexOf(panel.id) != -1 && panel.disabled) {
				panel.enable();
				enabled[enabled.length] = panel.id;
			}
		});
		return enabled;
	},
	setDraft: function(isDraft) {
		var editTab = Automne.tabPanels.getItem('edit');
		if (editTab) {
			var editTabEl = Ext.get(Automne.tabPanels.getTabEl(editTab));
			if (editTabEl) {
				if (isDraft) {
					editTabEl.addClass('x-tab-strip-hatch');
				} else {
					editTabEl.removeClass('x-tab-strip-hatch');
				}
			}
		}
	},
	setFavorite: function(isFavorite) {
		var favoriteTab = Automne.tabPanels.getItem('favorite')
		Automne.tabPanels.isFavorite = false;
		if (favoriteTab) {
			var favoriteTabEl = Ext.get(Automne.tabPanels.getTabEl(favoriteTab));
			if (favoriteTabEl) {
				if (isFavorite) {
					Automne.tabPanels.isFavorite = true;
					favoriteTabEl.addClass('x-tab-strip-hatch');
				} else {
					favoriteTabEl.removeClass('x-tab-strip-hatch');
				}
			}
		}
	},
	// private
    onRender : function(ct, position){
        Ext.TabPanel.superclass.onRender.call(this, ct, position);

        if(this.plain){
            var pos = this.tabPosition == 'top' ? 'header' : 'footer';
            this[pos].addClass('x-tab-panel-'+pos+'-plain');
        }

        var st = this[this.stripTarget];

        this.stripWrap = st.createChild({cls:'x-tab-strip-wrap', cn:{
            tag:'ul', cls:'x-tab-strip x-tab-strip-'+this.tabPosition}});

        var beforeEl = (this.tabPosition=='bottom' ? this.stripWrap : null);
        this.stripSpacer = st.createChild({cls:'x-tab-strip-spacer'}, beforeEl);
        this.strip = new Ext.Element(this.stripWrap.dom.firstChild);
        
        this.edge = this.strip.createChild({tag:'li', cls:'x-tab-edge'});
        this.strip.createChild({cls:'x-clear'});

        this.body.addClass('x-tab-panel-body-'+this.tabPosition);

        if(!this.itemTpl){
            var tt = new Ext.Template(
                 '<li class="{cls}" id="{id}"><a class="x-tab-strip-close" onclick="return false;"></a><a class="x-tab-strip-reload" onclick="return false;"></a>',
                 '<a class="x-tab-right" href="#" onclick="return false;"><em class="x-tab-left">',
                 '<span class="x-tab-strip-inner"><span class="x-tab-strip-text {iconCls}">{text}</span></span>',
                 '</em></a></li>'
            );
            tt.disableFormats = true;
            tt.compile();
            Ext.TabPanel.prototype.itemTpl = tt;
        }

        this.items.each(this.initTab, this);
    },
	// private
    findTargets : function(e){
        var item = null;
        var itemEl = e.getTarget('li', this.strip);
        if(itemEl){
            item = this.getComponent(itemEl.id.split(this.idDelimiter)[1]);
            if(item.disabled){
                return {
                    close : null,
                    reload: null,
					item : null,
                    el : null
                };
            }
        }
        return {
            close : e.getTarget('.x-tab-strip-close', this.strip),
            reload : e.getTarget('.x-tab-strip-reload', this.strip),
            item : item,
            el : itemEl
        };
    },
	// private
    onStripMouseDown: function(e){
        if(e.button != 0){
            return;
        }
        e.preventDefault();
        var t = this.findTargets(e);
        if(t.close){
            this.remove(t.item);
            return;
        }
        if(t.reload){
            this.reload(t.item);
            return;
        }
        if(t.item && t.item != this.activeTab){
            this.setActiveTab(t.item);
        }
    },
	reload: function(item) {
		if (item.id == Automne.tabPanels.getActiveTab().id) {
			Automne.message.show(Automne.locales.refresh, '', item);
			item.reload();
		}
	}
});