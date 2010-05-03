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
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");

$dialog = new CMS_dialog();
$dialog->setTitle('Automne :: Debug :: BackTrace','pic_meta.gif');

$backTraceName = $_GET['bt'];

if ($backTraceName && isset($_SESSION["automneBacktraces"]) && isset($_SESSION["automneBacktraces"][$backTraceName])) {
	$content = '
	<h3>Backtrace:</h3>
	'.$_SESSION["automneBacktraces"][$backTraceName]['summary'].'<br />
	<h3>Backtrace Detail:</h3>
	<pre>'.io::htmlspecialchars($_SESSION["automneBacktraces"][$backTraceName]['backtrace']).'</pre>
	';
} else {
	$content = 'Cannot backtrace, datas missing ...';
}
$dialog->setContent($content);
$dialog->show();
?>