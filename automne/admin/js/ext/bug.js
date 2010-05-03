//Pb on email validation : do not accept -
Ext.apply(Ext.form.VTypes, {
    //  vtype validation function
    email: function(val, field) {
        return /^([\w\-]+)(\.[\w\-]+)*@([\w\-]+\.){1,5}([A-Za-z]){2,4}$/.test(val);
    }
});