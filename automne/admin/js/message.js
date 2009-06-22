/**
  * Automne Javascript file
  *
  * Automne.message
  * Provide user message methods
  * @class Automne.message
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: message.js,v 1.1 2009/06/22 14:10:34 sebastien Exp $
  */
Automne.message = {
	msgCt:		false,
	show: function (title, message, el){
		if(!Automne.message.msgCt){
			Automne.message.msgCt = Ext.DomHelper.insertFirst(document.body, {id:'atm-msg-div'}, true);
		}
		if (message && !title) {
			title = message;
			message = null;
		}
		if (message && title) {
			message = '<br />' + message;
		}
		var boxtpl = ['<div class="msg">',
			'<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>',
			'<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><strong>', title, '</strong>', message, '</div></div></div>',
			'<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>',
			'</div>'].join('');
		var win;
		if	(el && el.getEl) {
			win = el;
			el = win.getEl();
		}
		Automne.message.msgCt.alignTo(el || document, 't-t');
		var m = Ext.DomHelper.insertFirst(Automne.message.msgCt, {html:boxtpl}, true);
		m.slideIn('t').pause(3).ghost("t", {remove:true});
		if (win && win.on) {
			win.on('close',function(){m.remove();});
		}
	},
	popup: function(config) {
		return Ext.MessageBox.show(config);
	}
};