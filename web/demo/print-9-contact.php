<?php
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/html/print-9.php')) {
	$cms_page_included = true;
	require($_SERVER['DOCUMENT_ROOT'].'/html/print-9.php');
} else {
	header('Location: /404.php');
	exit;
}
?>