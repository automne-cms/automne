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
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: backtrace.php,v 1.3 2010/03/08 16:41:17 sebastien Exp $

/**
  * PHP page : Backtrace debug page
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

$dialog = new CMS_dialog();
$dialog->setTitle('Automne :: Debug :: BackTrace','pic_meta.gif');

$backTraceName = $_GET['bt'];
if (!$backTraceName) {
	$content = 'Cannot backtrace, datas missing ...';
} else {
	//get backtrace from cache object
	$cache = new CMS_cache($backTraceName, 'atm-backtrace', 600, false);
	//load cache content
	if (!$cache->exist() || !($datas = $cache->load())) {
		$content = 'Cannot backtrace, datas missing ...';
	} else {
		$content = '
		<h3>Backtrace:</h3>
		'.$datas['summary'].'<br />
		<h3>Backtrace Detail:</h3>
		<pre>'.io::htmlspecialchars($datas['backtrace']).'</pre>
		';
	}
}
$dialog->setContent($content);
$dialog->show();
?>