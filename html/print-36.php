<?php CMS_view::redirect('http://127.0.0.1/web/demo/9-contact.php', true, 302);
 ?><?php //Generated on Mon, 18 Jan 2010 16:11:30 +0100 by Automne (TM) 4.0.0
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	CMS_view::redirect('http://127.0.0.1/web/demo/print-36-formulaire.php', true, 301);
}
 ?><?php if (!is_object($cms_user) || !$cms_user->hasPageClearance(36, CLEARANCE_PAGE_VIEW)) {
	CMS_view::redirect(PATH_FRONTEND_SPECIAL_LOGIN_WR.'?referer='.base64_encode($_SERVER['REQUEST_URI']));
}
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";   ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<?php echo '<meta http-equiv="Content-Type" content="text/html; charset='.strtoupper(APPLICATION_DEFAULT_ENCODING).'" />';    ?>
	<title>Automne 4 : Formulaire</title>
	<link rel="stylesheet" type="text/css" href="/css/print.css" />
</head>
<body>
<h1>Formulaire</h1>
<h3>
<?php if ($cms_user->hasPageClearance(31, CLEARANCE_PAGE_VIEW)) {
echo '
		&raquo;&nbsp;Exemples de modules
		';
}
?><?php if ($cms_user->hasPageClearance(36, CLEARANCE_PAGE_VIEW)) {
echo '
		&raquo;&nbsp;Formulaire
		';
}
?>
</h3>



	
	

	
	


<br />
<hr />
<div align="center">
	<small>
		
		<?php if ($cms_user->hasPageClearance(36, CLEARANCE_PAGE_VIEW)) {
echo '
				Page  "Formulaire" (http://127.0.0.1/web/demo/36-formulaire.php)
				';
}
?><br />
		Tir&eacute; du site http://<?php echo $_SERVER["HTTP_HOST"];    ?>
	</small>
</div>
<script language="JavaScript">window.print();</script>
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}   ?>
</body>
</html>