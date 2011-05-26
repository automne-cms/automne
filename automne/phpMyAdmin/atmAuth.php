<?php
require_once(dirname(__FILE__).'/../../cms_rc_admin.php');
//Check user rights
if (!isset($cms_user) || !$cms_user->hasAdminClearance(CLEARANCE_ADMINISTRATION_EDITVALIDATEALL)) {
	die('Access denied ... ');
}

/* Store there credentials */
$_SESSION['PMA_single_signon_user'] = APPLICATION_DB_USER;
$_SESSION['PMA_single_signon_password'] = APPLICATION_DB_PASSWORD;
$_SESSION['PMA_single_signon_host'] = APPLICATION_DB_HOST;
$_SESSION['PMA_single_signon_only_db'] = APPLICATION_DB_NAME;

/* Close that session */
Zend_Session::writeClose();
/* Redirect to phpMyAdmin (should use absolute URL here!) */
header('Location: '.PATH_REALROOT_WR.'/automne/phpMyAdmin/index.php?time='.time());
?>