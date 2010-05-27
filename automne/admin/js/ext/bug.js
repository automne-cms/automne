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