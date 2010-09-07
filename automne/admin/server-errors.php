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
//
// $Id: polymod-help.php,v 1.3 2010/03/08 16:42:07 sebastien Exp $

/**
  * PHP page : Load polymod help for object.
  * Used accross an Ajax request.
  *
  * @package Automne
  * @subpackage admin
  * @author Sébastien Pauchet <sebastien.pauchet@ws-interactive.fr>
  */
define("ENABLE_HTML_COMPRESSION", false);
require_once(dirname(__FILE__).'/../../cms_rc_admin.php');

define('MESSAGE_PAGE_NO_LOGS', 1608);
define("MESSAGE_PAGE_NO_SERVER_RIGHTS",748);

//CHECKS user has admin clearance
if (!$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	CMS_grandFather::raiseError('User has no administration rights');
	echo $cms_language->getMessage(MESSAGE_PAGE_NO_SERVER_RIGHTS);
	exit;
}

$date = sensitiveIO::request('date');

$errorFile = '';
$gzip = false;

$now = new CMS_date();
$now->setNow(true);

$requestedDate = new CMS_date();
$requestedDate->setFormat($cms_language->getDateFormat());
$requestedDate->setLocalizedDate($date);

if (!$requestedDate->hasError()) {
	if (CMS_date::compare($requestedDate, $now, '==')) {
		$errorFile = PATH_MAIN_FS.'/'.CMS_grandFather::ERROR_LOG;
	} else {
		$gzip = true;
		$requestedDate->moveDate('+1 day');
		$errorFile = PATH_LOGS_FS.'/'.CMS_grandFather::ERROR_LOG.'-'.$requestedDate->getLocalizedDate('Y-m-d').'.gz';
	}
}
if ($errorFile && file_exists($errorFile)) {
	if (connection_status() == 0) {
		//close session then clean buffer
		session_write_close();
	    ob_end_clean();
		//to prevent long file from getting cut off from max_execution_time
	    @set_time_limit(0);
		if ($gzip) {
			header("Content-Encoding: gzip");
		}
		//send http headers
		header("Cache-Control: ");// leave blank to avoid IE errors
		header("Pragma: ");// leave blank to avoid IE errors
		//send file (fread seems to be faster here than fpassthru nor readfile)
		if($file = fopen($errorFile, 'rb')){
			while( (!feof($file)) && (connection_status()==0) ){
				print(fread($file, 1024*8));
				flush();
			}
			fclose($file);
	    }
	}
} else {
	echo $cms_language->getMessage(MESSAGE_PAGE_NO_LOGS);
}
?>