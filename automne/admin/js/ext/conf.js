/**
  * Automne Javascript file
  *
  * Provide some configuration for ExtJS
  * @package CMS
  * @subpackage JS
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: conf.js,v 1.3 2010/03/08 15:20:22 sebastien Exp $
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