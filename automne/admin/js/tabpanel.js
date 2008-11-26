/**
  * Automne.tabPanel Extension Class for Ext.tabPanel
  * Provide all frame and windows panel management
  * @class Automne.tabPanel
  * @extends Ext.tabPanel
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
        if(!item || this.fireEvent('beforetabchange', this, item, this.activeTab, force) === false){
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
                }
                this.activeTab.fireEvent('deactivate', this.activeTab);
            }
            var el = this.getTabEl(item);
            Ext.fly(el).addClass('x-tab-strip-active');
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
		Automne.server.call('/automne/admin/page-infos.php?' + Ext.urlEncode(params), fcn, fcnparams, scope);
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
		var editTab = Ext.get(Automne.tabPanels.getTabEl(Automne.tabPanels.getItem('edit')));
		if (isDraft) {
			editTab.addClass('x-tab-strip-hatch');
		} else {
			editTab.removeClass('x-tab-strip-hatch');
		}
	},
	setFavorite: function(isFavorite) {
		var favoriteTab = Ext.get(Automne.tabPanels.getTabEl(Automne.tabPanels.getItem('favorite')));
		if (isFavorite) {
			Automne.tabPanels.isFavorite = true;
			favoriteTab.addClass('x-tab-strip-hatch');
		} else {
			Automne.tabPanels.isFavorite = false;
			favoriteTab.removeClass('x-tab-strip-hatch');
		}
	}
});