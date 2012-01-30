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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>	  |
// +----------------------------------------------------------------------+

/**
  * File used to frame oembed HTML objects
  * Ideally this frame should use another domain from website to avoid XSS
  *
  * @package Automne
  * @subpackage oembed
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

define('APPLICATION_EXEC_TYPE', 'frame');
require_once(dirname(__FILE__).'/../../cms_rc_frontend.php');

//Check parameter
if (!io::get('params')) {
	die('Missing parameter.');
}
$params = io::get('params');
$params = @base64_decode($params);
if (!$params) {
	die('Incorrect parameter.');
}
$params = @unserialize($params);
if (!is_array($params) || !isset($params['url']) || !isset($params['maxwidth']) || !isset($params['maxheight'])) {
	die('Incorrect parameter.');
}
//load oembed object
$oembed = new CMS_oembed($params['url'], $params['maxwidth'], $params['maxheight']);

$title = $html = '';

if (!$oembed->hasProvider()) {
	$title = $html = 'Media not handled ...';
} else {
	$title = $oembed->getTitle();
	$html = $oembed->getHTML(array(), true);
}

if (defined('APPLICATION_XHTML_DTD')) echo APPLICATION_XHTML_DTD."\n";
echo '<html>
<head>
	<title>'.$title.'</title>
	<style>
		body {
			margin:		0px;
			padding:	0px;
		}
	</style>
</head>
<body>
'.$html.'
</body>
</html>';
?>
