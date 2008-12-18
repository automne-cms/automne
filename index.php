<?php
if (strtolower(parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST)) == 'automne4' || strtolower($_SERVER['HTTP_HOST']) == 'automne4') {
	// http://automne4
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/html/2.php')) {
	$cms_page_included = true;
	require($_SERVER['DOCUMENT_ROOT'].'/html/2.php');
} else {
	header('Location: /404.php');
	exit;
}

} elseif (strtolower(parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST)) == 'automne4' || strtolower($_SERVER['HTTP_HOST']) == 'automne4') {
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