<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | Automne (TM)														  |
// +----------------------------------------------------------------------+
// | Copyright (c) 2000-2009 WS Interactive								  |
// +----------------------------------------------------------------------+
// | Automne is subject to version 2.0 or above of the GPL license.		  |
// | The license text is bundled with this package in the file			  |
// | LICENSE-GPL, and is available through the world-wide-web at		  |
// | http://www.gnu.org/copyleft/gpl.html.								  |
// +----------------------------------------------------------------------+
// | Author: Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: backTrace.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * PHP page : Backtrace debug page
  *
  * @package CMS
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
//require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

$dialog = new CMS_dialog();
$dialog->setTitle('Automne :: Debug :: BackTrace','pic_meta.gif');

function backtrace($backtrace)
{
	if (!is_array($backtrace)) {
		return false;
	}
	foreach ($backtrace as $bt) {
	    $args = null;
	    if (is_array($bt['args']))
	  		foreach ($bt['args'] as $a) {
		         if (isset($args)) {
		             $args .= ', ';
		         }
		         switch (gettype($a)) {
		         case 'integer':
		         case 'double':
		             $args .= $a;
		             break;
		         case 'string':
		             $a = htmlspecialchars(substr($a, 0, 64)).((strlen($a) > 64) ? '...' : '');
		             $args .= "\"$a\"";
		             break;
		         case 'array':
		             $args .= 'Array('.count($a).')';
		             break;
		         case 'object':
					 $args .= 'Object('.get_class($a).')';
		             break;
		         case 'resource':
		             $args .= 'Resource('.strstr($a, '#').')';
		             break;
		         case 'boolean':
		             $args .= $a ? 'True' : 'False';
		             break;
		         case 'NULL':
		             $args .= 'Null';
		             break;
		         default:
		             $args .= 'Unknown';
		         }
		     }
	    $output .= "<br />\n";
	    $output .= "<b>file:</b> {$bt['line']} - {$bt['file']}<br />\n";
	    $output .= "<b>call:</b> {$bt['class']}{$bt['type']}{$bt['function']}($args)<br />\n";
	}
	return $output;
}

$errorNumber = (int) $_GET['errorNumber'];

if (sensitiveIO::isPositiveInteger($errorNumber) && $_GET['className'] && isset($_SESSION["backTrace"]) && is_array($_SESSION["backTrace"][$_GET['className']][$errorNumber])) {
	$backTrace = array_reverse($_SESSION["backTrace"][$_GET['className']][$errorNumber]);
	$backTraceVars = $_SESSION["backTraceVars"][$_GET['className']][$errorNumber];
	
	$content = '
	<dialog-title type="admin_h2">Backtrace:</dialog-title>
	'.backtrace($backTrace).'<br />
	<dialog-title type="admin_h2">Backtrace Detail:</dialog-title>
	<pre>'.htmlspecialchars(print_r($backTrace,true)).'</pre>
	<dialog-title type="admin_h2">Defined Vars:</dialog-title>
	<pre>'.htmlspecialchars(print_r($backTraceVars,true)).'</pre>
	';
} else {
	$content = 'Cannot backtrace, datas missing ...';
}
$dialog->setContent($content);
$dialog->show();
?>