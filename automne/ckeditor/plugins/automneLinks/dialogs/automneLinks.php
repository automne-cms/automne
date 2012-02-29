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
  * Create Automne internal links
  *
  * @package Automne
  * @subpackage CKeditor
  * @author Frederico Caldeira Knabben (fredck@fckeditor.net)
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../../../../cms_rc_admin.php');

define("MESSAGE_PAGE_TITLE", 932);
define("MESSAGE_PAGE_TREE_TITLE", 935);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>Link Properties</title>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo APPLICATION_DEFAULT_ENCODING; ?>" />
		<meta name="robots" content="noindex, nofollow" />
		<?php
			echo CMS_view::getCSS(array('ext','main'));
			echo CMS_view::getJavascript(array('ext','main', 'initConfig'));
		?>
		<script type="text/javascript">
			if (parent.parent && parent.parent.Ext) {
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
		<div id="atmCKTree"></div>
		<script type="text/javascript">
			var CKEDITOR   = parent.CKEDITOR;
			var dialog = CKEDITOR.dialog.getCurrent();
			var fieldPageId = dialog._.contents.info.pageId;
			
			var displayTree = function() {
				var currentPage = fieldPageId.getValue();
				if (!currentPage) {
					currentPage = 1;
				}
				//init quicktips
				Ext.QuickTips.init();
				var pagesTree = new Automne.panel({
					id:				'CKPagesTree',
					region:			'center',
					applyTo:		'atmCKTree',
					layout: 		'atm-border',
					height:			400,
					border: 		false,
					xtype:			'atmPanel',
					autoLoad:		{
						url:		'<?php echo PATH_ADMIN_WR; ?>/tree.php',
						params:		{
							winId:			'CKPagesTree',
							editable:		false,
							currentPage:	currentPage,
							window:			false,
							encodedOnClick:	'<?php echo base64_encode('this.node.select();fieldPageId.setValue(\'%s\');'); ?>',
							encodedOnSelect:'<?php echo base64_encode('fieldPageId.setValue(\'%s\');'); ?>',
							heading:		false
						},
						nocache:	true,
						scope:		this
					}
				});
			}
			displayTree();
		
		</script>
	</body>
</html>
