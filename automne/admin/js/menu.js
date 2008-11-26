/**
  * Automne.Menu Extension Class for Ext.menu.Menu
  * Provide a delayed mouseout event
  * @class Automne.Menu
  * @extends Ext.menu.Menu
  */
Automne.Menu = Ext.extend(Ext.menu.Menu, {
	mouseOutTimeOut:false,
	//mouseOut launch timer to collapse zone
	onMouseOut: function() {
		// call parent
		Automne.Menu.superclass.onMouseOut.apply(this, arguments);
		if (this.mouseOutTimeOut === false) {
			this.mouseOutTimeOut = new Ext.util.DelayedTask(function(){
				this.hide();
			}, this);
		}
		this.mouseOutTimeOut.delay(1000);
	},
	//mouseIn reset timer
	onMouseOver: function(){
		// call parent
		Automne.Menu.superclass.onMouseOver.apply(this, arguments);
		if (this.mouseOutTimeOut !== false) this.mouseOutTimeOut.cancel();
	}
});

