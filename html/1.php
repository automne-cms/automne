<?php header('HTTP/1.x 302 Found',true,302);
header("Location: http://automne4/web/fr/2-accueil.php");
exit;
 ?><?php //Generated on Wed, 04 Mar 2009 11:06:48 +0100 by Automne (TM) 4.0.0b1
if (!isset($cms_page_included) && !$_POST && !$_GET) {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: http://automne4/web/1-demo-automne.php');
	exit;
}
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_frontend.php");
 ?><?php if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";  ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">
<head>
	<link rel="icon" type="image/x-icon" href="http://automne4/favicon.ico" />
	<meta name="language" content="fr" />
	<meta name="generator" content="Automne (TM)" />
	<meta name="identifier-url" content="http://automne4" />
	<script type="text/javascript" src="/js/CMS_functions.js"></script>

</head>
<body>
<!-- empty template, only used for pages with redirection -->
&nbsp;
<?php if (SYSTEM_DEBUG && STATS_DEBUG) {view_stat();}  ?>
</body>
</html>