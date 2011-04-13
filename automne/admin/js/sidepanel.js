/**
  * Automne Javascript file
  *
  * Automne.sidePanel Extension Class for Ext.Panel
  * Provide all mouseover events and watch for contained panels
  * @class Automne.sidePanel
  * @extends Ext.Panel
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: sidepanel.js,v 1.3 2010/01/22 16:29:01 sebastien Exp $
  */
Automne.sidePanel = Ext.extend(Automne.panel, { 
	hasMouseOver:		false,
	hasMouseOut:		false,
	mouseOutTimeOut:	false,
	collapsible:		true,
	collapseDefaults: {
		duration:		1
	},
	//on first render add mouse in/out events
	onRender: function(ct, position) {
		// call parent onRender
		Automne.sidePanel.superclass.onRender.call(this, ct, position);
		//set mouve in/out events
		if (this.hasMouseOut === false) {
			Ext.get(this.id).on('mouseout', this.onMouseOut, this);
			Ext.get(this.id).on('mouseover', this.onMouseIn, this);
			//then collapse panel when rendered
			Ext.get(this.id).getUpdater().on('update', this.onMouseOut, this);
			this.hasMouseOut = true;
		}
	},
	//on first collapse, add events on collapsed zone
	onCollapse: function(doAnim, animArg) {
		// call parent onCollapse
		Automne.sidePanel.superclass.onCollapse.call(this, doAnim, animArg);
		//set mouse over on collaspsed zone if not exists
		if (this.hasMouseOver === false) {
			Ext.get(this.id + '-xcollapsed').on('mouseover', this.expand, this);
			this.hasMouseOver = true;
		}
	},
	//mouseOut launch timer to collapse zone
	onMouseOut: function() {
		if (this.collapsible) {
			this.collapseTimer();
		}
	},
	//start timer to collapse zone
	collapseTimer: function() {
		if (this.mouseOutTimeOut === false) {
			this.mouseOutTimeOut = new Ext.util.DelayedTask(function(){
				if (this.collapsible) {
					this.collapse();
				}
			}, this);
		}
		this.mouseOutTimeOut.delay(2000);
	},
	//mouseIn reset timer
	onMouseIn: function(){
		if (this.mouseOutTimeOut !== false) this.mouseOutTimeOut.cancel();
	},
	expand: function() {
		//try to refresh validation panel
		var validationPanel = Ext.getCmp('validationsSidePanel');
		if (validationPanel) validationPanel.refresh();
		// call parent
		return Automne.sidePanel.superclass.expand.apply(this, arguments); 
	}
});