<?php
//rewrite some server conf if HTTP_X_FORWARDED exists
if (isset($_SERVER["HTTP_X_FORWARDED_HOST"])) {
	$_SERVER["HTTP_HOST"] = $_SERVER["HTTP_X_FORWARDED_HOST"];
}
if (isset($_SERVER["HTTP_X_FORWARDED_SERVER"])) {
	$_SERVER["HTTP_SERVER"] = $_SERVER["HTTP_X_FORWARDED_SERVER"];
}
if (strtolower(parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST)) == 'automne4.trunk' || strtolower($_SERVER['HTTP_HOST']) == 'automne4.trunk') {
	// http://automne4.trunk
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/html/2.php')) {
	$cms_page_included = true;
	require($_SERVER['DOCUMENT_ROOT'].'/html/2.php');
} else {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: /404.php');
	exit;
}

} elseif (strtolower(parse_url($_SERVER['HTTP_HOST'], PHP_URL_HOST)) == 'automne4.trunk' || strtolower($_SERVER['HTTP_HOST']) == 'automne4.trunk') {
	// http://automne4.trunk
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/html/2.php')) {
	$cms_page_included = true;
	require($_SERVER['DOCUMENT_ROOT'].'/html/2.php');
} else {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: /404.php');
	exit;
}

} else {
	// http://automne4.trunk
if (file_exists($_SERVER['DOCUMENT_ROOT'].'/html/2.php')) {
	$cms_page_included = true;
	require($_SERVER['DOCUMENT_ROOT'].'/html/2.php');
} else {
	header('HTTP/1.x 301 Moved Permanently', true, 301);
	header('Location: /404.php');
	exit;
}
} ?>