<?php
if (file_exists(dirname(__FILE__).'/../../html/print-24.php')) {
	$cms_page_included = true;
	require(dirname(__FILE__).'/../../html/print-24.php');
} else {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: /trunk/404.php');
	exit;
}
?>