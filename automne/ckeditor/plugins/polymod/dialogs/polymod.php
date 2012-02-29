<?php
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2010 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Frederico Caldeira Knabben (fredck@fckeditor.net)            |
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+

/**
  * Javascript plugin for CKeditor
  * Create Automne medias items insertions
  *
  * @package Automne
  * @subpackage CKeditor
  * @author Frederico Caldeira Knabben (fredck@fckeditor.net)
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../../cms_rc_admin.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Polymod Plugins</title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo APPLICATION_DEFAULT_ENCODING; ?>" />
		<meta name="robots" content="noindex, nofollow" />
		<?php
			echo CMS_view::getCSS(array('ext','main'));
			echo CMS_view::getJavascript(array('ext','main', 'initConfig'));
		?>
		<script type="text/javascript">
			if (parent.parent) {
				//Declare Automne namespace
				Ext.namespace('Automne');
				pr = parent.parent.pr;
				Automne.locales = parent.parent.Automne.locales;
				Automne.message = parent.parent.Automne.message;
				Ext.MessageBox = parent.parent.Ext.MessageBox;
				Automne.server = parent.parent.Automne.server;
				Automne.context = parent.parent.Automne.context;
				Ext.Ajax = parent.parent.Ext.Ajax;
			}
			Ext.BLANK_IMAGE_URL = '<?php echo PATH_ADMIN_IMAGES_WR; ?>/s.gif';
		</script>
	</head>
	<body scroll="no" style="OVERFLOW: hidden">
		<div id="atmCKPolymod"></div>
		<input type="hidden" id="codeToPaste" value="" />
		<script type="text/javascript">
			var displayPolymod = function(id, content) {
				Ext.QuickTips.init();
				var polymodPlugins = new Automne.panel({
					id:				'CKPolymod',
					region:			'center',
					applyTo:		document.getElementById('atmCKPolymod'),
					layout: 		'atm-border',
					height:			465,
					width:			718,
					border: 		false,
					xtype:			'atmPanel',
					autoLoad:		{
						url:		'<?php echo PATH_ADMIN_WR; ?>/modules/polymod/ckplugin.php',
						params:		{
							winId:			'CKPolymod',
							id:				id,
							content:		content
						},
						nocache:	true,
						scope:		this
					}
				});
			}
			displayPolymod('', '');
		</script>
	</body>
</html>
