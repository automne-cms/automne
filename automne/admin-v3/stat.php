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
// $Id: stat.php,v 1.1.1.1 2008/11/26 17:12:06 sebastien Exp $

/**
  * Automne Debug Statistics viewver
  *
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once($_SERVER["DOCUMENT_ROOT"]."/cms_rc_admin.php");
require_once(PATH_ADMIN_SPECIAL_SESSION_CHECK_FS);

$sql_table = $cms_context->getSessionVar('stat_sql_table');
$files_loaded = $cms_context->getSessionVar('stat_files_table');
$SQL_TIME_MARK = ($_POST["SQL_TIME_MARK"]) ? $_POST["SQL_TIME_MARK"]:$_GET["SQL_TIME_MARK"];

function sanitizeString($input)
{
	$sanitized = trim($input);
	$sanitized = str_replace("
", "",str_replace("\n", "",ereg_replace("\t+", "_",$sanitized)));
	$sanitized = strtr($sanitized, " àâäéèëêïîöôùüû", "_aaaeeeeiioouuu");
	$sanitized = ereg_replace("[^[a-zA-Z0-9_.,=-]]*", "", $sanitized);
	$sanitized = str_replace("___", "_",$sanitized);
	$sanitized = str_replace("__", "_",$sanitized);
	$sanitized = str_replace(",_", ",",$sanitized);
	return $sanitized;
}

$dialog = new CMS_dialog();
$dialog->setTitle('Automne :: Debug :: Statistics for file : '.$cms_context->getSessionVar('stat_content_name'),'pic_meta.gif');

$time = sprintf('%.5f', $cms_context->getSessionVar('stat_time_end') - $cms_context->getSessionVar('stat_time_start'));
$rapport = sprintf('%.2f', ((100*$cms_context->getSessionVar('stat_total_time'))/$time));

$content = '
<dialog-title type="admin_h2">Stat Resume:</dialog-title>
<br />
Loaded in ' . $time . ' seconds<br />
SQL requests : ' . sprintf('%.5f',$cms_context->getSessionVar('stat_total_time')) . ' seconds (' . $cms_context->getSessionVar('stat_sql_nb_requests') . ' requests)<br />
PHP files : '. $cms_context->getSessionVar('stat_files_loaded') .'<br />
% SQL/PHP time : '. $rapport .' %
<br /><br />
<dialog-title type="admin_h2">SQL Resume:</dialog-title>
<br />
<form action="'.$_SERVER["SCRIPT_NAME"].'" method="post">
<strong>HighLight times upper than :</strong><br />
<input class="admin_input_text" type="text" size="10" name="SQL_TIME_MARK" value="'.$SQL_TIME_MARK.'" />&nbsp;<input class="admin_input_submit" type="submit" name="Change" value="Change" />
</form>';

$select = $update = $insert = $delete = $unknown = 0;
$sqltype_select=array();
$sqltype_delete=array();
$sqltype_insert=array();
$sqltype_update=array();

foreach ($sql_table as $sql_request) {
	if (eregi("^select", trim($sql_request["sql"]))) {
		$select++;
		$split = explode('from',$sql_request["sql"]);
		$split = explode('where',$split[1]);
		$split = explode('order',$split[0]);
		$from=sanitizeString($split[0]);
		if ($from=='') {
			$from='(unknown : '.$sql_request["sql"].')';
		}
		$sqltype_select[$from]++;
		$sqltype_select_time[$from]=$sqltype_select_time[$from]+$sql_request["time"];
	} elseif (eregi("^insert", trim($sql_request["sql"]))) {
		$insert++;
		$split = explode('into',$sql_request["sql"]);
		if (strpos($sql_request["sql"], 'set') !== false) {
			$split = explode('set',$split[1]);
		} else {
			$split = explode('(',$split[1]);
		}
		$from=sanitizeString($split[0]);
		if ($from=='') {
			$from='(unknown : '.$sql_request["sql"].')';
		}
		$sqltype_insert[$from]++;
		$sqltype_insert_time[$from]=$sqltype_insert_time[$from]+$sql_request["time"];
	} elseif (eregi("^update", trim($sql_request["sql"]))) {
		$update++;
		$split = explode('update',$sql_request["sql"]);
		$split = explode('set',$split[1]);
		$from=sanitizeString($split[0]);
		if ($from=='') {
			$from='(unknown : '.$sql_request["sql"].')';
		}
		$sqltype_update[$from]++;
		$sqltype_update_time[$from]=$sqltype_update_time[$from]+$sql_request["time"];
	} elseif (eregi("^delete", trim($sql_request["sql"]))) {
		$delete++;
		$split = explode('from',$sql_request["sql"]);
		$split = explode('where',$split[1]);
		$from=sanitizeString($split[0]);
		if ($from=='') {
			$from='(unknown : '.$sql_request["sql"].')';
		}
		$sqltype_delete[$from]++;
		$sqltype_delete_time[$from]=$sqltype_delete_time[$from]+$sql_request["time"];
	} else {
		$unknown++;
		$from=trim($sql_request["sql"]);
		$sqltype_unknown[$from]++;
		$sqltype_unknown_time[$from]=$sqltype_unknown_time[$from]+$sql_request["time"];
	}
}
$content .= '
<table border="1" cellpadding="2" cellspacing="0">
		<tr>
			<td><font size="1"><b>Nb</b></font></td>
			<td><font size="1"><b>Tables</b></font></td>
			<td><font size="1"><b>Total time (sec)</b></font></td>
			<td><font size="1"><b>Average time (sec)</b></font></td>
		</tr>
		<tr>
			<td colspan="4"><font size="1" color="red"><b>-> select</b> : '.$select.'</font></td>
		</tr>';
while (list($k,$v) = each($sqltype_select)) {
       $content .= '<tr>
			<td><font size="1">'.$v.'&nbsp;</font></td>
			<td><font size="1">in '.$k.'</font></td>
			<td><font size="1">&nbsp;'.sprintf('%.5f',$sqltype_select_time[$k]).'</font></td>';
	if ($sqltype_select_time[$k]/$v >= $SQL_TIME_MARK) {
		$content .= '<td><font size="1" color="red"><b>&nbsp;'.sprintf('%.5f',($sqltype_select_time[$k]/$v)).'</b></font></td>';
	} else {
		$content .= '<td><font size="1">&nbsp;'.sprintf('%.5f',($sqltype_select_time[$k]/$v)).'</font></td>';
	}
	 $content .= '</tr>';
   }
if ($update) {
	$content .= '<tr>
			<td colspan="4"><font size="1" color="red"><b>-> update</b> : '.$update.'</font></td>
		</tr>';
	while (list($k,$v) = each($sqltype_update)) {
	       $content .= '<tr>
				<td><font size="1">'.$v.'&nbsp;</font></td>
				<td><font size="1">in '.$k.'</font></td>
				<td><font size="1">&nbsp;'.sprintf('%.5f',$sqltype_update_time[$k]).'</font></td>';
	if ($sqltype_update_time[$k]/$v >= $SQL_TIME_MARK) {
		$content .= '<td><font size="1" color="red"><b>&nbsp;'.sprintf('%.5f',($sqltype_update_time[$k]/$v)).'</b></font></td>';
	} else {
		$content .= '<td><font size="1">&nbsp;'.sprintf('%.5f',($sqltype_update_time[$k]/$v)).'</font></td>';
	}
	 $content .= '</tr>';
	   }
}
if ($insert) {
	$content .= '<tr>
			<td colspan="4"><font size="1" color="red"><b>-> insert</b> : '.$insert.'</font></td>
		</tr>';
	while (list($k,$v) = each($sqltype_insert)) {
	       $content .= '<tr>
				<td><font size="1">'.$v.'&nbsp;</font></td>
				<td><font size="1">in '.$k.'</font></td>
				<td><font size="1">&nbsp;'.sprintf('%.5f',$sqltype_insert_time[$k]).'</font></td>';
	if ($sqltype_insert_time[$k]/$v >= $SQL_TIME_MARK) {
		$content .= '<td><font size="1" color="red"><b>&nbsp;'.sprintf('%.5f',($sqltype_insert_time[$k]/$v)).'</b></font></td>';
	} else {
		$content .= '<td><font size="1">&nbsp;'.sprintf('%.5f',($sqltype_insert_time[$k]/$v)).'</font></td>';
	}
	 $content .= '</tr>';
	   }
}
if ($delete) {
	$content .= '<tr>
			<td colspan="4"><font size="1" color="red"><b>-> delete</b> : '.$delete.'</font></td>
		</tr>';
	while (list($k,$v) = each($sqltype_delete)) {
	       $content .= '<tr>
				<td><font size="1">'.$v.'&nbsp;</font></td>
				<td><font size="1">in '.$k.'</font></td>
				<td><font size="1">&nbsp;'.sprintf('%.5f',$sqltype_delete_time[$k]).'</font></td>';
	if ($sqltype_delete_time[$k]/$v >= $SQL_TIME_MARK) {
		$content .= '<td><font size="1" color="red"><b>&nbsp;'.sprintf('%.5f',($sqltype_delete_time[$k]/$v)).'</b></font></td>';
	} else {
		$content .= '<td><font size="1">&nbsp;'.sprintf('%.5f',($sqltype_delete_time[$k]/$v)).'</font></td>';
	}
	 $content .= '</tr>';
	   }
}
if ($unknown) {
	$content .= '<tr>
			<td colspan="4"><font size="1" color="red"><b>-> unknown</b> : '.$unknown.'</font></td>
		</tr>';
	while (list($k,$v) = each($sqltype_unknown)) {
       $content .= '<tr>
			<td><font size="1">'.$v.'&nbsp;</font></td>
			<td><font size="1">'.$k.'</font></td>
			<td><font size="1">&nbsp;'.sprintf('%.5f',$sqltype_unknown_time[$k]).'</font></td>';
	if ($sqltype_unknown_time[$k]/$v >= $SQL_TIME_MARK) {
		$content .= '<td><font size="1" color="red"><b>&nbsp;'.sprintf('%.5f',($sqltype_unknown_time[$k]/$v)).'</b></font></td>';
	} else {
		$content .= '<td><font size="1">&nbsp;'.sprintf('%.5f',($sqltype_unknown_time[$k]/$v)).'</font></td>';
	}
	 $content .= '</tr>';
	}
}
$content .= '</table><br />
<dialog-title type="admin_h2">PHP Files Detail:</dialog-title>
<br />';
foreach ($files_loaded as $file) {
	$content .= str_replace(PATH_REALROOT_FS, '', $file).'<br />';
}
$content .= '<br />
<dialog-title type="admin_h2">SQL Detail:</dialog-title>
<br />
';
$count='0';
foreach ($sql_table as $sql_request) {
	$count++;
	if ($sql_request["time"] >= $SQL_TIME_MARK) {
		$content .=  $count.' : <font color="red">Loaded in <b>' . $sql_request["time"] . '</b> ('.htmlspecialchars($sql_request["sql"]).')</font><br /><br />';
	} else {
		$content .=  $count.' : Loaded in ' . $sql_request["time"] . ' ('.htmlspecialchars($sql_request["sql"]).')<br /><br />';
	}
}

$dialog->setContent($content);
$dialog->show();
?>