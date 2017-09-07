/**
  * Automne Javascript file
  *
  * Automne.Menu Extension Class for Ext.menu.Menu
  * Provide a delayed mouseout event to Ext.menu.Menu object
  * @class Automne.Menu
  * @extends Ext.menu.Menu
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: menu.js,v 1.2 2009/03/02 11:26:54 sebastien Exp $
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

