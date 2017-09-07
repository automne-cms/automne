Ext.override(Ext.Button, {
	onClick : function(e){
        if(e){
            e.preventDefault();
        }
        if(e.button != 0){
            return;
        }
        if(!this.disabled){
            if(this.enableToggle && (this.allowDepress !== false || !this.pressed)){
                this.toggle();
            }
            if(this.menu && !this.menu.isVisible() && !this.ignoreNextClick){
                this.showMenu();
            }
            this.fireEvent("click", this, e);
            if(this.handler){
                if (this.el && this.el.removeClass) {
					this.el.removeClass("x-btn-over");
                }
				if (this.handler.call) {
					this.handler.call(this.scope || this, this, e);
				} else {
					eval(this.handler).call(this.scope || this, this, e);
				}
            }
        }
    }
});