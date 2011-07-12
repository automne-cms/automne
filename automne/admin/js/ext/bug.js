//Pb on email validation : do not accept -
Ext.apply(Ext.form.VTypes, {
    //  vtype validation function
    email: function(val, field) {
        return /^([\w\-]+)(\.[\w\-]+)*@([\w\-]+\.){1,5}([A-Za-z]){2,4}$/.test(val);
    }
});
//Pb on side panels which not correctly close after onening a window (error into hasFxBlock)
Ext.override(Ext.Panel, {
 collapse : function(animate){
     if (!this.el.dom) {
	 	this.el = Ext.get(this.el.id);
	 }
	 if(this.collapsed || this.el.hasFxBlock() || this.fireEvent('beforecollapse', this, animate) === false){
         return;
     }
     var doAnim = animate === true || (animate !== false && this.animCollapse);
     this.beforeEffect(doAnim);
     this.onCollapse(doAnim, animate);
     return this;
 }
});
//Pb on DD with Multiselect2.js
Ext.dd.DragDropMgr.getLocation = function(oDD) {
    if (! this.isTypeOfDD(oDD)) {
        return null;
    }

    var el = oDD.getEl(), pos, x1, x2, y1, y2, t, r, b, l;

    try {
        pos= Ext.lib.Dom.getXY(el);
    } catch (e) { }

    if (!pos) {
        return null;
    }

    x1 = pos[0];
    x2 = x1 + el.offsetWidth;
    y1 = pos[1];
    y2 = y1 + el.offsetHeight;

    t = y1 - oDD.padding[0];
    r = x2 + oDD.padding[1];
    b = y2 + oDD.padding[2];
    l = x1 - oDD.padding[3];

    return new Ext.lib.Region( t, r, b, l );
};