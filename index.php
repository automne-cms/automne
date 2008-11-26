<?php
if (strtolower($_SERVER['HTTP_HOST']) == 'automne4') {
	// http://automne4
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/html/2.php')) {
	$cms_page_included = true;
	require($_SERVER['DOCUMENT_ROOT'].'/html/2.php');
} else {
	header('Location: /404.php');
	exit;
}

} elseif (strtolower($_SERVER['HTTP_HOST']) == 'automne4') {
	// http://automne4
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/html/2.php')) {
	$cms_page_included = true;
	require($_SERVER['DOCUMENT_ROOT'].'/html/2.php');
} else {
	header('Location: /404.php');
	exit;
}

} else {
	// http://automne4
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/html/2.php')) {
	$cms_page_included = true;
	require($_SERVER['DOCUMENT_ROOT'].'/html/2.php');
} else {
	header('Location: /404.php');
	exit;
}
} ?>