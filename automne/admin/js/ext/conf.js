/**
  * Automne Javascript file
  *
  * Provide some configuration for ExtJS
  * @package CMS
  * @subpackage JS
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  * $Id: conf.js,v 1.2 2010/01/18 15:24:42 sebastien Exp $
  */
// reference to local blank image
Ext.BLANK_IMAGE_URL = '/automne/admin/img/s.gif';
//activate native JSON if browser support it
Ext.USE_NATIVE_JSON = true;
//vtype alphanum
Ext.form.VTypes.alphanum = /^[a-zA-Z0-9_.]+$/;
Ext.form.VTypes.alphanumMask = /^[a-zA-Z0-9_.]+$/;