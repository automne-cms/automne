/**
  * Automne Javascript file
  *
  * Provide some configuration for ExtJS
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
// reference to local blank image
Ext.BLANK_IMAGE_URL = 'img/s.gif';
//activate native JSON if browser support it
Ext.USE_NATIVE_JSON = true;
//vtype alphanum
Ext.form.VTypes.alphanumMask = /^[a-zA-Z0-9_.]+$/;
Ext.form.VTypes.alphanum = function(v){
	return Ext.form.VTypes.alphanumMask.test(v);
};
//vtype codename
Ext.apply(Ext.form.VTypes, {
    codename:  function(v) {
        return /^[a-z0-9-]*$/.test(v);
    },
    codenameText: 'Codename must be alphanumeric and lowercase',
    codenameMask: /[a-z0-9-]/i
});
//vtype login
Ext.apply(Ext.form.VTypes, {
    login:  function(v) {
        return /^[a-zA-Z0-9_.@-]+$/.test(v);
    },
    loginText: 'Login must be alphanumeric and lowercase',
    loginMask: /^[a-zA-Z0-9_.@-]+$/
});

Ext.apply(Ext.util.Format, {
    stripLines:  function(v) {
        return v.replace(/\s+/g, " ").trim();
    }
});