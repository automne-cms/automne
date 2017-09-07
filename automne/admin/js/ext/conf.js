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
      if(v.substr(0, 1) === ' ') {
        // login may not start by a space
        return false;
      }
      if(v.substr(-1) === ' ') {
        // login may not end by a space
        return false;
      }
      if(v.indexOf('  ') !== -1) {
        // login may not contains multiple spaces in a row.
        return false;
      }
      // due to the lack of unicode support on js regex the other checks will be done on the server side
      return true;
    },
    loginText: 'Login must be alphanumeric and lowercase',
    loginMask: /^[a-zA-Z0-9_.@-]+$/
});

Ext.apply(Ext.util.Format, {
    stripLines:  function(v) {
        return v.replace(/\s+/g, " ").trim();
    }
});