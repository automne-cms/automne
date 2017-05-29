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
// | Author: S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>      |
// +----------------------------------------------------------------------+
//
// $Id: stat.php,v 1.9 2010/03/08 16:41:21 sebastien Exp $

/**
  * Automne Debug Statistics viewver
  *
  * @package Automne
  * @subpackage admin
  * @author S�bastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
error_reporting(E_ALL & ~E_NOTICE);

$SQL_TIME_MARK = ($_REQUEST["SQL_TIME_MARK"]) ? $_REQUEST["SQL_TIME_MARK"] : '0.001';
$statName = ($_REQUEST['stat']) ? $_REQUEST['stat'] : '';

$dialog = new CMS_dialog();
if (!$statName) {
	$dialog->setTitle('Automne :: Debug :: Statistics','pic_meta.gif');
	$dialog->setContent('Cannot find stats datas ...');
	$dialog->show();
	exit;
}

//get stats from cache object
$cache = new CMS_cache($statName, 'atm-stats', 600, false);
//load cache content
if (!$cache->exist() || !($datas = $cache->load())) {
	$dialog->setTitle('Automne :: Debug :: Statistics','pic_meta.gif');
	$dialog->setContent('Cannot find stats datas ...');
	$dialog->show();
	exit;
}

$sql_table = $datas['stat_sql_table'];
$files_loaded = $datas['stat_files_table'];
$memoryUsages = $datas['stat_memory_table'];

$dialog->setTitle('Automne :: Debug :: Statistics for file : '.$datas['stat_content_name'],'pic_meta.gif');

$time = sprintf('%.5f', $datas['stat_time_end'] - $datas['stat_time_start']);
$rapport = sprintf('%.2f', ((100 * $datas['stat_total_time'])/$time));

function sanitizeString($input) {
	$sanitized = trim($input);
	$sanitized = str_replace("
", "",str_replace("\n", "",preg_replace("#\t+#", "_",$sanitized)));
	$sanitized = strtr($sanitized, " ��������������", "_aaaeeeeiioouuu");
	$sanitized = preg_replace("#[^[a-zA-Z0-9_.,=-]]*#", "", $sanitized);
	$sanitized = str_replace("___", "_",$sanitized);
	$sanitized = str_replace("__", "_",$sanitized);
	$sanitized = str_replace(",_", ",",$sanitized);
	return $sanitized;
}

$content = '
<a name="top"></a>
<strong>
<a href="#sql-resume" class="admin">[SQL Resume]</a> | 
<a href="#files" class="admin">[PHP Files]</a> | 
<a href="#memory" class="admin">[Memory Usage]</a> | 
<a href="#sql" class="admin">[SQL Detail]</a>
</strong>
<br />
<a name="resume"></a>
<h3>Stat Resume:</h3>
<br />
Loaded in ' . $time . ' seconds<br />
Loaded PHP files : '. $datas['stat_files_loaded'] .'<br />
SQL requests : ' . sprintf('%.5f', $datas['stat_total_time']) . ' seconds (' . $datas['stat_sql_nb_requests'] . ' requests)<br />
% SQL/PHP time : '. $rapport .' %<br />
Memory Peak : '. $datas['stat_memory_peak'] .'Mo
<br /><br />
<a name="sql-resume"></a>
<h3>SQL Resume:</h3>
<a href="#top" class="admin" style="float:right;padding:10px;">[TOP]</a>
<br />
<form action="'.$_SERVER["SCRIPT_NAME"].'?stat='.$statName.'" method="post">
<strong>HighLight times upper than :</strong><br />
<input class="admin_input_text" type="text" size="10" name="SQL_TIME_MARK" value="'.$SQL_TIME_MARK.'" />&nbsp;<input class="admin_input_submit" type="submit" name="Change" value="Change" />
</form>';

$select = $update = $insert = $delete = $unknown = 0;
$sqltype_select=array();
$sqltype_delete=array();
$sqltype_insert=array();
$sqltype_update=array();

foreach ($sql_table as $sql_request) {
	if (preg_match("#^select#i", trim($sql_request["sql"]))) {
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
	} elseif (preg_match("#^insert#i", trim($sql_request["sql"]))) {
		$insert++;
		$split = explode('into',$sql_request["sql"]);
		if (io::strpos($sql_request["sql"], 'set') !== false) {
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
	} elseif (preg_match("#^update#i", trim($sql_request["sql"]))) {
		$update++;
		$split = explode('update',$sql_request["sql"]);
		$split = explode('set',$split[1]);
		$from=sanitizeString($split[0]);
		if ($from=='') {
			$from='(unknown : '.$sql_request["sql"].')';
		}
		$sqltype_update[$from]++;
		$sqltype_update_time[$from]=$sqltype_update_time[$from]+$sql_request["time"];
	} elseif (preg_match("#^delete#i", trim($sql_request["sql"]))) {
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
<a name="files"></a>
<h3>PHP Files Detail:</h3>
<a href="#top" class="admin" style="float:right;padding:10px;">[TOP]</a>
<ol>';
foreach ($files_loaded as $fileData) {
	$content .= '<li>';
	if (isset($fileData['file'])) {
		$content .= str_replace(PATH_REALROOT_FS, '', $fileData['file']);
	}
	if (isset($fileData['class'])) {
		$content .= ' ('.$fileData['class'].')';
	}
	if (isset($fileData['from'])) {
		$content .= ' - From '.$fileData['from'];
	}
	$content .= '</li>';
}
$content .= '</ol>
<a name="memory"></a>
<h3>Memory Usage Evolution (file : current / max):</h3>
<a href="#top" class="admin" style="float:right;padding:10px;">[TOP]</a>
Memory is measured after the inclusion of a file<br />
<ol>';
foreach ($memoryUsages as $memoryUsage) {
	$content .= '<li>';
	$content .= round(($memoryUsage['memory']/1048576),3).'Mo / '.round(($memoryUsage['peak']/1048576),3).'Mo';
	if (isset($memoryUsage['file'])) {
		$content .= ' - '.str_replace(PATH_REALROOT_FS, '', $memoryUsage['file']);
	}
	if (isset($memoryUsage['class'])) {
		$content .= ' ('.$memoryUsage['class'].')';
	}
	$content .= '</li>';
}
$content .= '</ol>
<a name="sql"></a>
<h3>SQL Detail:</h3>
<a href="#top" class="admin" style="float:right;padding:10px;">[TOP]</a>
<ol>';
foreach ($sql_table as $sql_request) {
	$content .= '<li>';
	if ($sql_request["time"] >= $SQL_TIME_MARK) {
		$content .=  '<strong style="color:red;">'.io::htmlspecialchars($sql_request["sql"]).'</strong><br />Loaded in ' . $sql_request["time"] . ' sec - at '.$sql_request["current"].' sec from start<br />From '.$sql_request["from"].'<br />Memory : '.round(($sql_request['memory']/1048576),3).'Mo / '.round(($sql_request['peak']/1048576),3).'Mo<br /><br />';
	} else {
		$content .=  '<strong>'.io::htmlspecialchars($sql_request["sql"]).'</strong><br />Loaded in ' . $sql_request["time"] . ' sec - at '.$sql_request["current"].' sec from start<br />From '.$sql_request["from"].'<br />Memory : '.round(($sql_request['memory']/1048576),3).'Mo / '.round(($sql_request['peak']/1048576),3).'Mo<br /><br />';
	}
	$content .= '</li>';
}
$content .=  '
</ol>
<a href="#top" class="admin" style="float:right;padding:10px;">[TOP]</a>';
$dialog->setContent($content);
$dialog->show();
?>