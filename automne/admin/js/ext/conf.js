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