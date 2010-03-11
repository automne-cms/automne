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
//
// $Id: polymod.php,v 1.5 2010/03/08 16:44:19 sebastien Exp $

/**
  * Javascript plugin for FCKeditor
  * Create Automne medias items insertions
  *
  * @package CMS
  * @subpackage admin
  * @author Frederico Caldeira Knabben (fredck@fckeditor.net)
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../cms_rc_admin.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>DlgPolymodTitle</title>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
		<meta name="robots" content="noindex, nofollow" />
		<script src="../../editor/dialog/common/fck_dialog_common.js" type="text/javascript"></script>
		<script src="fckpolymod.js" type="text/javascript"></script>
		<script type="text/javascript">
			var displayPolymod = function(id, content) {
				Ext.QuickTips.init();
				var pagesTree = new Automne.panel({
					id:				'FCKPolymod',
					region:			'center',
					applyTo:		document.getElementById('atmFCKPolymod'),
					layout: 		'atm-border',
					height:			465,
					width:			718,
					border: 		false,
					xtype:			'atmPanel',
					autoLoad:		{
						url:		'<?php echo PATH_REALROOT_WR; ?>/automne/admin/modules/polymod/fckplugin.php',
						params:		{
							winId:			'FCKPolymod',
							id:				id,
							content:		content
						},
						nocache:	true,
						scope:		this
					}
				});
			}
		</script>
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
				Ext.Ajax = parent.parent.Ext.Ajax;
				Ext.BLANK_IMAGE_URL = '<?php echo PATH_ADMIN_IMAGES_WR; ?>/s.gif';
			}
		</script>
	</head>
	<body scroll="no" style="OVERFLOW: hidden">
		<div id="divInfo" style="DISPLAY: none">
			<div id="atmFCKPolymod"></div>
			<input type="hidden" id="codeToPaste" value="" />
		</div>
	</body>
</html>
