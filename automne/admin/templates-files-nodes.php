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
// $Id: templates-files-nodes.php,v 1.4 2010/03/08 16:41:21 sebastien Exp $

/**
  * PHP page : Load module categories tree window.
  * Used accross an Ajax request. Render categories tree for a given module.
  * 
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */

require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define("MESSAGE_PAGE_STYLESHEET", 1486);
define("MESSAGE_PAGE_WYSIWYG", 1487);
define("MESSAGE_PAGE_JAVASCRIPT", 1488);
define("MESSAGE_PAGE_FOLDER_LAST_UPDATE", 1507);
define("MESSAGE_PAGE_FILE_LAST_UPDATE_SIZE", 1508);
define("MESSAGE_PAGE_WEBSITES_CSS", 1496);
define("MESSAGE_PAGE_WEBSITES_JS", 1497);
define("MESSAGE_PAGE_TXT", 273);

//load interface instance
$view = CMS_view::getInstance();
//set default display mode for this page
$view->setDisplayMode(CMS_view::SHOW_JSON);
//This file is an admin file. Interface must be secure
$view->setSecure();

function checkNode($value) {
	return $value != 'source' && io::strpos($value, '..') === false;
}

$node = sensitiveIO::request('node', 'checkNode', '');
$maxDepth = sensitiveIO::request('maxDepth', 'sensitiveIO::isPositiveInteger', 2);

//CHECKS user has module clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDIT_TEMPLATES)) {
	CMS_grandFather::raiseError('User has no rights on page templates ...');
	$view->show();
}

// from php manual page
function formatBytes($val, $digits = 3, $mode = "SI", $bB = "B"){
   $si = array("", "K", "M", "G", "T", "P", "E", "Z", "Y");
   $iec = array("", "Ki", "Mi", "Gi", "Ti", "Pi", "Ei", "Zi", "Yi");
   switch(io::strtoupper($mode)) {
       case "SI" : $factor = 1000; $symbols = $si; break;
       case "IEC" : $factor = 1024; $symbols = $iec; break;
       default : $factor = 1000; $symbols = $si; break;
   }
   switch($bB) {
       case "b" : $val *= 8; break;
       default : $bB = "B"; break;
   }
   for($i=0;$i<count($symbols)-1 && $val>=$factor;$i++)
       $val /= $factor;
   $p = io::strpos($val, ".");
   if($p !== false && $p > $digits) $val = round($val);
   elseif($p !== false) $val = round($val, $digits-$p);
   return round($val, $digits) . " " . $symbols[$i] . $bB;
}

if (!$node) {
	$lastmod = date($cms_language->getDateFormat().' H:i:s',filemtime(PATH_REALROOT_FS.'/robots.txt'));
	$size = formatBytes(filesize(PATH_REALROOT_FS.'/robots.txt'), 2);
	$qtip = $cms_language->getMessage(MESSAGE_PAGE_FILE_LAST_UPDATE_SIZE, array($cms_language->getMessage(MESSAGE_PAGE_TXT), $lastmod, $size));
	
	$nodes = array(
		array('text' => $cms_language->getJsMessage(MESSAGE_PAGE_WEBSITES_CSS), 'id' => 'css', 'leaf' => false, 'cls'=> 'folder', 'qtip' => '', 'deletable' => false),
		array('text' => $cms_language->getJsMessage(MESSAGE_PAGE_WEBSITES_JS), 'id' => 'js', 'leaf' => false, 'cls'=> 'folder', 'qtip' => '', 'deletable' => false),
		array('text' => 'robots.txt', 'id' => 'robots.txt', 'leaf' => true, 'cls'=> 'atm-txt', 'qtip' => $qtip, 'deletable' => false),
	);
	$view->setContent($nodes);
	$view->show();
}

$allowedFiles = array(
	'css' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_STYLESHEET), 'class' => 'atm-css'),
	'xml' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_WYSIWYG), 'class' => 'atm-xml'),
	'js' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_JAVASCRIPT), 'class' => 'atm-js'),
	'txt' => array('name' => $cms_language->getMessage(MESSAGE_PAGE_TXT), 'class' => 'atm-txt'),
);

$nodes = array();
$d = dir(PATH_REALROOT_FS.'/'.$node);
$currentDepth = count(explode('/', $node));

if ($d) {
	while($f = $d->read()){
	    if($f == '.' || $f == '..' || io::substr($f, 0, 1) == '.') continue;
	    
		$lastmod = date($cms_language->getDateFormat().' H:i:s',filemtime(PATH_REALROOT_FS.'/'.$node.'/'.$f));
	    if(is_dir(PATH_REALROOT_FS.'/'.$node.'/'.$f)){
	        $qtip = $cms_language->getMessage(MESSAGE_PAGE_FOLDER_LAST_UPDATE).' '.$lastmod;
	        $nodes[] = array('text' => $f, 'id' => $node.'/'.$f, 'qtip' => $qtip, 'leaf' => false, 'cls'=> 'folder', 'expanded' => ($currentDepth < $maxDepth), 'deletable' => false);
	    }else{
	        $extension = io::strtolower(pathinfo(PATH_REALROOT_FS.'/'.$node.'/'.$f, PATHINFO_EXTENSION));
			if (isset($allowedFiles[$extension])) {
				$size = formatBytes(filesize(PATH_REALROOT_FS.'/'.$node.'/'.$f), 2);
				$qtip = $cms_language->getMessage(MESSAGE_PAGE_FILE_LAST_UPDATE_SIZE, array($allowedFiles[$extension]['name'], $lastmod, $size));
				$deletable = $extension != 'xml' && is_writable(PATH_REALROOT_FS.'/'.$node.'/'.$f);
				$nodes[] = array('text' => $f, 'id' => $node.'/'.$f, 'leaf' => true, 'qtip' => $qtip, 'cls' => $allowedFiles[$extension]['class'], 'deletable' => $deletable);
			}
	    }
	}
	$d->close();
}
$view->setContent($nodes);
$view->show();
?>