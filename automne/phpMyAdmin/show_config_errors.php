<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Simple wrapper just to enable error reporting and include config
 *
 * @version $Id: show_config_errors.php,v 1.1 2009/03/02 11:47:35 sebastien Exp $
 */

/**
 *
 */
echo "Starting to parse config file...\n";

error_reporting(E_ALL);
require './config.inc.php';

?>
