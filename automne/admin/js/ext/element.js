//this function overides all element positionning methods to provide consistent element positionning retrieval when element is not in the current document.
Ext.lib.Dom.getXY = function(el) {
	var libFlyweight = false;
	var fly = function(el) {
		if (!libFlyweight) {
			libFlyweight = new Ext.Element.Flyweight();
		}
		libFlyweight.dom = el;
		return libFlyweight;
	}
	el = Ext.getDom(el);
	var doc = el.ownerDocument || document;
	var p, pe, b, scroll, bd = (doc.body || doc.documentElement);
	if(el == bd){
		return [0, 0];
	}
	if (el.getBoundingClientRect) {
		b = el.getBoundingClientRect();
		scroll = fly(document).getScroll();
		if (!isNaN(scroll.left)) {
			return [b.left + scroll.left, b.top + scroll.top];
		} else {
			scroll = fly(el.ownerDocument).getScroll();
			return [b.left + scroll.left, b.top + scroll.top];
		}
	}
	var x = 0, y = 0;
	p = el;
	var hasAbsolute = fly(el).getStyle("position") == "absolute";
	while (p) {
		x += p.offsetLeft;
		y += p.offsetTop;
		if (!hasAbsolute && fly(p).getStyle("position") == "absolute") {
			hasAbsolute = true;
		}
		if (Ext.isGecko) {
			pe = fly(p);
			var bt = parseInt(pe.getStyle("borderTopWidth"), 10) || 0;
			var bl = parseInt(pe.getStyle("borderLeftWidth"), 10) || 0;
			x += bl;
			y += bt;
			if (p != el && pe.getStyle('overflow') != 'visible') {
				x += bl;
				y += bt;
			}
		}
		p = p.offsetParent;
	}
	if (Ext.isSafari && hasAbsolute) {
		x -= bd.offsetLeft;
		y -= bd.offsetTop;
	}
	if (Ext.isGecko && !hasAbsolute) {
		var dbd = fly(bd);
		x += parseInt(dbd.getStyle("borderLeftWidth"), 10) || 0;
		y += parseInt(dbd.getStyle("borderTopWidth"), 10) || 0;
	}
	p = el.parentNode;
	while (p && p != bd) {
		if (!Ext.isOpera || (p.tagName != 'TR' && fly(p).getStyle("display") != "inline")) {
			x -= p.scrollLeft;
			y -= p.scrollTop;
		}
		p = p.parentNode;
	}
	return [x, y];
}

//append a specific class on tip with a valid title
Ext.override(Ext.ToolTip, {
	showAt: function(xy){
		this.lastActive = new Date();
		this.clearTimers();
		Ext.ToolTip.superclass.showAt.call(this, xy);
		if (this.title) {
			this.el.addClass('x-tip-with-title');
		} else {
			this.el.removeClass('x-tip-with-title');
		}
		if(this.dismissDelay && this.autoHide !== false){
			this.dismissTimer = this.hide.defer(this.dismissDelay, this);
		}
	}
});